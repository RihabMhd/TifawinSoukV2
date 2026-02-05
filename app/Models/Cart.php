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

     public static function mergeSessionToDatabase($user)
    {
        if ($user->role_id != 3) {
            return;
        }

       
        $sessionCart = self::where('session_id', session()->getId())
            ->with('items.product')
            ->first();

 
        if (!$sessionCart || $sessionCart->items->isEmpty()) {
            return;
        }

      
        $userCart = self::firstOrCreate([
            'user_id' => $user->id
        ]);

      
        foreach ($sessionCart->items as $sessionItem) {
            $existingItem = $userCart->items()
                ->where('product_id', $sessionItem->product_id)
                ->first();

            if ($existingItem) {
                $existingItem->update([
                    'quantity' => $existingItem->quantity + $sessionItem->quantity
                ]);
            } else {
                CartItem::create([
                    'cart_id' => $userCart->id,
                    'product_id' => $sessionItem->product_id,
                    'quantity' => $sessionItem->quantity,
                    'price_at_addition' => $sessionItem->price_at_addition,
                ]);
            }
        }

        $sessionCart->items()->delete();
        $sessionCart->delete();
    }
}
