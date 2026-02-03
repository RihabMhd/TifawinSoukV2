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
}
