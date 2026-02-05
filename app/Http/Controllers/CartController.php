<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Afficher le panier
     */
    public function index()
    {
        // get the current user cart or create a new one
        $cart = Cart::getOrCreate();

        return view('cart.index', compact('cart'));
    }

    /**
     * Ajouter un produit au panier
     */
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'quantity' => 'nullable|integer|min:1',
        ]);

        // if the quantity did not come with the request we set it to 1
        $quantity = $request->quantity ?? 1;

        // check if our product is not out of stock
        if ($product->quantity < 1) {
            return redirect()->back()->with('error', 'Produit en rupture de stock.');
        }

        $cart = Cart::getOrCreate();

        // check if our product is already in the cart
        $cartItem = $cart->items()
            ->where('product_id', $product->id)
            ->first();

        $currentQuantity = $cartItem?->quantity ?? 0;

        // check if adding the requested quantity exceeds available stock of the product
        if ($currentQuantity + $quantity > $product->quantity) {
            return redirect()->back()->with(
                'error',
                'Stock insuffisant. Disponible : ' . $product->quantity
            );
        }

        if ($cartItem) {
            $cartItem->update([
                'quantity' => $currentQuantity + $quantity,
            ]);
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price_at_addition' => $product->price,
            ]);
        }

        return redirect()->back()->with('success', 'Produit ajouté au panier !');
    }


    /**
     * Mettre à jour la quantité
     */
    public function update(Request $request, CartItem $cartItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Cart::getOrCreate();

        if ($cartItem->cart_id !== $cart->id) {
            return redirect()->back()->with('error', 'Action non autorisée.');
        }

        if ($request->quantity > $cartItem->product->quantity) {
            return redirect()->back()->with(
                'error',
                'Stock insuffisant. Disponible : ' . $cartItem->product->quantity
            );
        }

        $cartItem->update([
            'quantity' => $request->quantity,
        ]);

        return redirect()->back()->with('success', 'Quantité mise à jour !');
    }

    /**
     * Supprimer un item du panier
     */
    public function remove(CartItem $cartItem)
    {
        $cart = Cart::getOrCreate();

        if ($cartItem->cart_id !== $cart->id) {
            return redirect()->back()->with('error', 'Action non autorisée.');
        }

        $cartItem->delete();

        return redirect()->back()->with('success', 'Produit supprimé du panier !');
    }

    /**
     * Vider le panier
     */
    public function clear()
    {
        $cart = Cart::getOrCreate();
        $cart->items()->delete();

        return redirect()->back()->with('success', 'Panier vidé !');
    }
}
