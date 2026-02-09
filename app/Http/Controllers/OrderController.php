<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
  
    public function index(Request $request)
    {
        $query = auth()->user()->orders()
            ->with('items.product');

        // search by order number
        if ($request->filled('search')) {
            $query->where('order_number', 'LIKE', '%' . $request->search . '%');
        }

        // filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // filter by price range
        if ($request->filled('price_min')) {
            $query->where('total', '>=', $request->price_min);
        }
        if ($request->filled('price_max')) {
            $query->where('total', '<=', $request->price_max);
        }

        // custom sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');

        // validate sort fields to prevent sql injection
        $allowedSortFields = ['created_at', 'total', 'order_number', 'status'];
        if (in_array($sortBy, $allowedSortFields)) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $orders = $query->paginate(10)->withQueryString();

        // get active filters for display
        $activeFilters = $this->getActiveFilters($request);

        // get available statuses for filter dropdown
        $statuses = [
            'pending' => 'En attente',
            'processing' => 'En traitement',
            'shipped' => 'Expédiée',
            'delivered' => 'Livrée',
            'cancelled' => 'Annulée'
        ];

        return view('orders.index', compact('orders', 'activeFilters', 'statuses'));
    }

   
    public function show(Order $order)
    {
        //  the user can view his own orders
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Vous n\'êtes pas autorisé à voir cette commande.');
        }

     
        $order->load('items.product');

        return view('orders.show', compact('order'));
    }

    
    public function cancel(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Vous n\'êtes pas autorisé à annuler cette commande.');
        }

        // check if order can be cancelled
        if (!$order->canBeCancelled()) {
            return redirect()->back()
                ->with('error', 'Cette commande ne peut plus être annulée. Seules les commandes en attente ou en traitement peuvent être annulées.');
        }

        try {
            // restore product quantities
            foreach ($order->items as $item) {
                if ($item->product) {
                    $item->product->increment('quantity', $item->quantity);
                }
            }

            $order->update([
                'status' => 'cancelled'
            ]);

            return redirect()->route('orders.index')
                ->with('success', 'Votre commande a été annulée avec succès. Les quantités ont été remises en stock.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Une erreur est survenue lors de l\'annulation de la commande. Veuillez réessayer.');
        }
    }

    private function getActiveFilters(Request $request)
    {
        $filters = [];

        if ($request->filled('search')) {
            $filters[] = [
                'label' => 'Recherche',
                'value' => $request->search,
                'param' => 'search'
            ];
        }

        if ($request->filled('status')) {
            $statusLabels = [
                'pending' => 'En attente',
                'processing' => 'En traitement',
                'shipped' => 'Expédiée',
                'delivered' => 'Livrée',
                'cancelled' => 'Annulée'
            ];
            $filters[] = [
                'label' => 'Statut',
                'value' => $statusLabels[$request->status] ?? $request->status,
                'param' => 'status'
            ];
        }

        if ($request->filled('date_from')) {
            $filters[] = [
                'label' => 'Date début',
                'value' => \Carbon\Carbon::parse($request->date_from)->format('d/m/Y'),
                'param' => 'date_from'
            ];
        }

        if ($request->filled('date_to')) {
            $filters[] = [
                'label' => 'Date fin',
                'value' => \Carbon\Carbon::parse($request->date_to)->format('d/m/Y'),
                'param' => 'date_to'
            ];
        }

        if ($request->filled('price_min')) {
            $filters[] = [
                'label' => 'Prix min',
                'value' => '$' . number_format($request->price_min, 2),
                'param' => 'price_min'
            ];
        }

        if ($request->filled('price_max')) {
            $filters[] = [
                'label' => 'Prix max',
                'value' => '$' . number_format($request->price_max, 2),
                'param' => 'price_max'
            ];
        }

        if ($request->filled('sort_by') && $request->sort_by !== 'created_at') {
            $sortLabels = [
                'total' => 'Montant',
                'order_number' => 'Numéro',
                'status' => 'Statut'
            ];
            $sortOrderLabel = $request->get('sort_order', 'desc') === 'desc' ? 'décroissant' : 'croissant';
            $filters[] = [
                'label' => 'Tri',
                'value' => ($sortLabels[$request->sort_by] ?? $request->sort_by) . ' ' . $sortOrderLabel,
                'param' => 'sort_by'
            ];
        }

        return $filters;
    }
}