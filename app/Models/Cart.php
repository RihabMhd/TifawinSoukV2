<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        
        // Only merge for customers (role_id = 3)
        if ($user->role_id != 3) {
            return;
        }

        // use the provided old session ID, or fall back to current session ID
        $sessionId = $oldSessionId ?? session()->getId();

        // get the current session cart along with its items and products
        $sessionCart = self::where('session_id', $sessionId)
            ->with('items.product')
            ->first();
        
        if (!$sessionCart || $sessionCart->items->isEmpty()) {
            return;
        }

        // get or create the user's database cart
        $userCart = self::firstOrCreate([
            'user_id' => $user->id
        ]);

        // loop through each item in the session cart
        foreach ($sessionCart->items as $sessionItem) {
            // check if the product already exists in the user's cart
            $existingItem = $userCart->items()
                ->where('product_id', $sessionItem->product_id)
                ->first();

            if ($existingItem) {
                // if it exists, increase the quantity
                $existingItem->update([
                    'quantity' => $existingItem->quantity + $sessionItem->quantity
                ]);
            } else {
                // if not, create a new cart item
                CartItem::create([
                    'cart_id' => $userCart->id,
                    'product_id' => $sessionItem->product_id,
                    'quantity' => $sessionItem->quantity,
                    'price_at_addition' => $sessionItem->price_at_addition,
                ]);
            }
        }

        // Clean up the session cart after merging
        $sessionCart->items()->delete();
        $sessionCart->delete();
    }
}