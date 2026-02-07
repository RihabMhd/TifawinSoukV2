<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'session_id',
    ];


    public function items()
    {
        return $this->hasMany(CartItem::class)->with('product');
    }

    // get the cart for the current user/session or create a new one if it doesn't exist
    public static function getOrCreate(): self
    {

        if (auth()->check()) {
            return self::where('user_id', auth()->id())->first()
                ?? self::create([
                    'user_id' => auth()->id(),
                ]);
        }

        $sessionId = session()->getId();

        return self::where('session_id', $sessionId)->first()
            ?? self::create([
                'session_id' => $sessionId,
            ]);
    }

    public function getTotal(): float
    {
        return $this->items->sum(function ($item) {
            return $item->quantity * $item->price_at_addition;
        });
    }


    public function getItemsCount(): int
    {
        return $this->items->sum('quantity');
    }

    // merge the session cart into the user database cart after login
    public static function mergeSessionToDatabase($user, $oldSessionId = null)
    {
        Log::info('========================================');
        Log::info('CART MERGE STARTED');
        Log::info('========================================');
        Log::info('User ID: ' . $user->id);
        Log::info('User Email: ' . $user->email);
        Log::info('User Role ID: ' . $user->role_id);
        Log::info('Old Session ID provided: ' . ($oldSessionId ?? 'NULL'));
        Log::info('Current Session ID: ' . session()->getId());
        
        // Only merge for customers (role_id = 3)
        if ($user->role_id != 3) {
            Log::warning('⚠️ MERGE STOPPED: User role is not 3 (customer)');
            Log::info('========================================');
            return;
        }

        // Use the provided old session ID, or fall back to current session ID
        $sessionId = $oldSessionId ?? session()->getId();
        Log::info('Using Session ID for lookup: ' . $sessionId);

        // get the current session cart along with its items and products
        $sessionCart = self::where('session_id', $sessionId)
            ->with('items.product')
            ->first();

        Log::info('Session cart query executed');
        
        if (!$sessionCart) {
            Log::warning('⚠️ MERGE STOPPED: No session cart found with session_id: ' . $sessionId);
            
            // Let's check if ANY session carts exist
            $allSessionCarts = self::whereNotNull('session_id')->get();
            Log::info('Total session carts in database: ' . $allSessionCarts->count());
            foreach ($allSessionCarts as $cart) {
                Log::info('  - Cart ID: ' . $cart->id . ', Session ID: ' . $cart->session_id);
            }
            
            Log::info('========================================');
            return;
        }

        Log::info('✅ Session cart FOUND!');
        Log::info('Session Cart ID: ' . $sessionCart->id);
        Log::info('Session Cart session_id: ' . $sessionCart->session_id);
        Log::info('Session Cart items count: ' . $sessionCart->items->count());

        if ($sessionCart->items->isEmpty()) {
            Log::warning('⚠️ MERGE STOPPED: Session cart exists but has no items');
            Log::info('========================================');
            return;
        }

        Log::info('✅ Session cart has ' . $sessionCart->items->count() . ' items');

        // get or create the user's database cart
        $userCart = self::firstOrCreate([
            'user_id' => $user->id
        ]);

        Log::info('✅ User cart retrieved/created');
        Log::info('User Cart ID: ' . $userCart->id);
        Log::info('User Cart current items: ' . $userCart->items->count());

        // loop through each item in the session cart
        $itemsMerged = 0;
        foreach ($sessionCart->items as $sessionItem) {
            Log::info('---');
            Log::info('Processing cart item:');
            Log::info('  Product ID: ' . $sessionItem->product_id);
            Log::info('  Quantity: ' . $sessionItem->quantity);
            Log::info('  Price: ' . $sessionItem->price_at_addition);
            
            // check if the product already exists in the user's cart
            $existingItem = $userCart->items()
                ->where('product_id', $sessionItem->product_id)
                ->first();

            if ($existingItem) {
                $oldQuantity = $existingItem->quantity;
                $newQuantity = $oldQuantity + $sessionItem->quantity;
                
                // if it exists, increase the quantity
                $existingItem->update([
                    'quantity' => $newQuantity
                ]);
                
                Log::info('  ✅ UPDATED existing item');
                Log::info('  Old quantity: ' . $oldQuantity);
                Log::info('  New quantity: ' . $newQuantity);
            } else {
                // if not, create a new cart item
                $newItem = CartItem::create([
                    'cart_id' => $userCart->id,
                    'product_id' => $sessionItem->product_id,
                    'quantity' => $sessionItem->quantity,
                    'price_at_addition' => $sessionItem->price_at_addition,
                ]);
                
                Log::info('  ✅ CREATED new cart item');
                Log::info('  New cart item ID: ' . $newItem->id);
            }
            
            $itemsMerged++;
        }

        Log::info('---');
        Log::info('Total items merged: ' . $itemsMerged);

        // Clean up the session cart after merging
        $deletedItems = $sessionCart->items()->delete();
        $sessionCart->delete();
        
        Log::info('✅ Session cart cleaned up');
        Log::info('Deleted ' . $deletedItems . ' session cart items');
        Log::info('Deleted session cart ID: ' . $sessionCart->id);
        Log::info('========================================');
        Log::info('CART MERGE COMPLETED SUCCESSFULLY');
        Log::info('========================================');
    }
}