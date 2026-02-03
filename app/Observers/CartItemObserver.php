<?php

namespace App\Observers;

use App\Models\CartItem;
use Exception;

class CartItemObserver
{
    /**
     * Avant création
     */
    public function creating(CartItem $cartItem): void
    {
        $product = $cartItem->product;

        if ($product->stock < $cartItem->quantity) {
            throw new Exception('Stock insuffisant pour ce produit.');
        }

        $cartItem->price_at_addition = $product->price;
    }

    /**
     * Avant mise à jour
     */
    public function updating(CartItem $cartItem): void
    {
        if ($cartItem->isDirty('quantity')) {
            $product = $cartItem->product;

            if ($product->stock < $cartItem->quantity) {
                throw new Exception('Stock insuffisant pour la nouvelle quantité.');
            }
        }
    }
}
