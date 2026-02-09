<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class CheckoutController extends Controller
{
    /**
     * Display the checkout form
     */
    public function index()
    {
        $cart = Cart::getOrCreate();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Votre panier est vide.');
        }

        return view('checkout.index', compact('cart'));
    }

    /**
     * Process the checkout form
     */
    public function process(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'address_complement' => 'nullable|string|max:255',
            'postal_code' => 'required|string|max:10',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:2',
            'payment_method' => 'required|in:credit_card,paypal,cash_on_delivery',
            'order_notes' => 'nullable|string|max:1000',
            'terms_accepted' => 'required|accepted',
        ]);

        $cart = Cart::getOrCreate();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Votre panier est vide.');
        }

        try {
            // Create the order
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => $this->generateOrderNumber(),
                'status' => 'pending',
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'address_complement' => $validated['address_complement'] ?? null,
                'postal_code' => $validated['postal_code'],
                'city' => $validated['city'],
                'country' => $validated['country'],
                'payment_method' => $validated['payment_method'],
                'subtotal' => $cart->getTotal(),
                'tax' => $cart->getTotal() * 0.20,
                'total' => $cart->getTotal() * 1.20,
                'order_notes' => $validated['order_notes'] ?? null,
            ]);

            foreach ($cart->items as $cartItem) {
                if ($cartItem->product->quantity < $cartItem->quantity) {
                    return redirect()->back()->with('error', "Stock insuffisant pour {$cartItem->product->title}");
                }
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->price_at_addition,
                    'subtotal' => $cartItem->getSubtotal(),
                ]);

                $cartItem->product->decrement('quantity', $cartItem->quantity);
            }

            // handle PayPal vs Other methods
            if ($validated['payment_method'] === 'paypal') {
                return $this->payWithPaypal($order);
            }

            // finalize for non-PayPal (e.g. Cash on delivery)
            $cart->items()->delete();

            return redirect()->route('orders.show', $order)
                ->with('success', 'Votre commande a été passée avec succès !');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la création de votre commande.');
        }
    }

    private function payWithPaypal(Order $order)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('paypal.success', ['order' => $order->id]),
                "cancel_url" => route('paypal.cancel', ['order' => $order->id]),
            ],
            "purchase_units" => [
                0 => [
                    "reference_id" => $order->order_number,
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => number_format($order->total, 2, '.', '')
                    ]
                ]
            ]
        ]);

        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }
        }

        return redirect()->route('checkout.index')->with('error', 'Erreur de connexion avec PayPal.');
    }

    public function paypalSuccess(Request $request, Order $order)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $response = $provider->capturePaymentOrder($request['token']);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            // update payment_status instead of status to avoid truncation error
            $order->update([
                'payment_status' => 'paid',
                'status' => 'processing' // move from pending to processing
            ]);

            $cart = Cart::getOrCreate();
            $cart->items()->delete();

            return redirect()->route('orders.show', $order)
                ->with('success', 'Paiement PayPal réussi !');
        }

        return redirect()->route('checkout.index')->with('error', 'Le paiement n\'a pas pu être validé.');
    }

    public function paypalCancel(Order $order)
    {
        return redirect()->route('checkout.index')
            ->with('error', 'Vous avez annulé le paiement PayPal. Votre commande est en attente.');
    }

    private function generateOrderNumber()
    {
        return 'ORD-' . strtoupper(uniqid());
    }
}
