<?php
namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::getOrCreate()
            ->load('items.product.primaryImage');

        return view('cart.index', compact('cart'));
    }

  
    public function add(Request $request): JsonResponse
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($data['product_id']);

        if ($product->stock < $data['quantity']) {
            return response()->json([
                'success' => false,
                'message' => 'Stock insuffisant',
            ], 422);
        }

        $cart = Cart::getOrCreate();

        $cartItem = CartItem::firstOrNew([
            'cart_id'    => $cart->id,
            'product_id' => $product->id,
        ]);

        $newQuantity = ($cartItem->exists ? $cartItem->quantity : 0) + $data['quantity'];

        if ($product->stock < $newQuantity) {
            return response()->json([
                'success' => false,
                'message' => 'Stock insuffisant pour cette quantité',
            ], 422);
        }

        $cartItem->quantity = $newQuantity;
        $cartItem->save(); 

        return response()->json([
            'success'     => true,
            'cart_count' => $cart->getItemsCount(),
            'message'     => 'Produit ajouté',
        ]);
    }

    public function update(Request $request, CartItem $cartItem): JsonResponse
    {
        $cart = Cart::getOrCreate();

        if ($cartItem->cart_id !== $cart->id) {
            abort(403);
        }

        $data = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem->update([
            'quantity' => $data['quantity'],
        ]);

        $cart->load('items');

        return response()->json([
            'success'  => true,
            'subtotal' => $cartItem->getSubtotal(),
            'total'    => $cart->getTotal(),
        ]);
    }


    public function remove(CartItem $cartItem): JsonResponse
    {
        $cart = Cart::getOrCreate();

        if ($cartItem->cart_id !== $cart->id) {
            abort(403);
        }

        $cartItem->delete();

        return response()->json([
            'success' => true,
            'total'   => $cart->getTotal(),
        ]);
    }


    public function clear(): JsonResponse
    {
        $cart = Cart::getOrCreate();

        $cart->items()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Panier vidé',
        ]);
    }
}
