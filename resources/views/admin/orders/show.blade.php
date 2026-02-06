<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Commande #{{ $order->id }}
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Créée le {{ $order->created_at->format('d/m/Y à H:i') }}
                </p>
            </div>

            <a href="{{ route('admin.orders.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Retour aux commandes
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Success/Error Messages --}}
            @if (session('success'))
                <div
                    class="mb-6 px-6 py-4 rounded-lg bg-green-50 dark:bg-green-900/20 border-2 border-green-200 dark:border-green-800">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400 mr-3" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-green-800 dark:text-green-200 font-medium">
                            {{ session('success') }}
                        </p>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div
                    class="mb-6 px-6 py-4 rounded-lg bg-red-50 dark:bg-red-900/20 border-2 border-red-200 dark:border-red-800">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-red-600 dark:text-red-400 mr-3" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-red-800 dark:text-red-200 font-medium">
                            {{ session('error') }}
                        </p>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Main Content - Left Column --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- Order Items --}}
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                                Articles commandés
                            </h3>

                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Produit
                                            </th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Prix
                                            </th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Quantité
                                            </th>
                                            <th
                                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Sous-total
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        @forelse($order->items as $item)
                                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        @if ($item->product && $item->product->image)
                                                            <img src="{{ asset('storage/' . $item->product->image) }}"
                                                                alt="{{ $item->product->title }}"
                                                                class="w-16 h-16 rounded object-cover mr-4">
                                                        @else
                                                            <div
                                                                class="w-16 h-16 bg-gray-200 dark:bg-gray-700 rounded flex items-center justify-center mr-4">
                                                                <svg class="w-8 h-8 text-gray-400" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                                    </path>
                                                                </svg>
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <div
                                                                class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                                {{ $item->product->title ?? 'Produit non disponible' }}
                                                            </div>
                                                            @if ($item->product && $item->product->sku)
                                                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                                                    SKU: {{ $item->product->sku }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                    {{ number_format($item->price, 2) }} MAD
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                    {{ $item->quantity }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900 dark:text-gray-100 text-right">
                                                    {{ number_format($item->price * $item->quantity, 2) }} MAD
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4"
                                                    class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                                    Aucun article trouvé
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            {{-- Order Totals --}}
                            <div class="mt-6 pt-6 border-t dark:border-gray-700">
                                <div class="space-y-2 max-w-sm ml-auto">
                                    <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400">
                                        <span>Sous-total</span>
                                        <span>{{ number_format($order->total, 2) }} MAD</span>
                                    </div>

                                    @if (isset($order->shipping_cost) && $order->shipping_cost > 0)
                                        <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400">
                                            <span>Frais de livraison</span>
                                            <span>{{ number_format($order->shipping_cost, 2) }} MAD</span>
                                        </div>
                                    @endif

                                    @if (isset($order->tax) && $order->tax > 0)
                                        <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400">
                                            <span>TVA</span>
                                            <span>{{ number_format($order->tax, 2) }} MAD</span>
                                        </div>
                                    @endif

                                    <div
                                        class="flex justify-between text-lg font-bold text-gray-900 dark:text-gray-100 pt-2 border-t dark:border-gray-700">
                                        <span>Total</span>
                                        <span>{{ number_format($order->total, 2) }} MAD</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Customer Information --}}
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                                Informations client
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="text-sm text-gray-600 dark:text-gray-400">Nom du client</label>
                                    <p class="font-medium text-gray-900 dark:text-gray-100 mt-1">
                                        {{ $order->user->name ?? 'Invité' }}
                                    </p>
                                </div>

                                <div>
                                    <label class="text-sm text-gray-600 dark:text-gray-400">Email</label>
                                    <p class="font-medium text-gray-900 dark:text-gray-100 mt-1">
                                        {{ $order->user->email ?? $order->email ?? 'N/A' }}
                                    </p>
                                </div>

                                <div>
                                    <label class="text-sm text-gray-600 dark:text-gray-400">Téléphone</label>
                                    <p class="font-medium text-gray-900 dark:text-gray-100 mt-1">
                                        {{ $order->phone ?? 'N/A' }}
                                    </p>
                                </div>

                                <div>
                                    <label class="text-sm text-gray-600 dark:text-gray-400">Client depuis</label>
                                    <p class="font-medium text-gray-900 dark:text-gray-100 mt-1">
                                        {{ $order->user ? $order->user->created_at->format('d/m/Y') : 'N/A' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Shipping Information --}}
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                                Adresse de livraison
                            </h3>

                            <div class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                                @if (isset($order->first_name) && isset($order->last_name))
                                    <p class="font-medium text-gray-900 dark:text-gray-100">
                                        {{ $order->first_name }} {{ $order->last_name }}
                                    </p>
                                @endif

                                @if (isset($order->shipping_address))
                                    <p>{{ $order->shipping_address }}</p>
                                @elseif(isset($order->address))
                                    <p>{{ $order->address }}</p>
                                @endif

                                @if (isset($order->address_complement))
                                    <p>{{ $order->address_complement }}</p>
                                @endif

                                <p>
                                    @if (isset($order->postal_code))
                                        {{ $order->postal_code }}
                                    @endif
                                    @if (isset($order->city))
                                        {{ $order->city }}
                                    @endif
                                </p>

                                @if (isset($order->country))
                                    <p>{{ $order->country }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Sidebar - Right Column --}}
                <div class="space-y-6">

                    {{-- Order Status Card --}}
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                                Statut de la commande
                            </h3>

                            <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Statut actuel
                                    </label>
                                    <select name="status"
                                        class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>
                                            En attente
                                        </option>
                                        <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>
                                            Confirmée
                                        </option>
                                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>
                                            En traitement
                                        </option>
                                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>
                                            Expédiée
                                        </option>
                                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>
                                            Livrée
                                        </option>
                                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>
                                            Annulée
                                        </option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    @php
                                        $statusColors = [
                                            'pending' => 'yellow',
                                            'confirmed' => 'blue',
                                            'processing' => 'indigo',
                                            'shipped' => 'purple',
                                            'delivered' => 'green',
                                            'cancelled' => 'red',
                                        ];
                                        $badgeColor = $statusColors[$order->status] ?? 'gray';
                                    @endphp
                                    <span
                                        class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium w-full justify-center
                                               bg-{{ $badgeColor }}-100 dark:bg-{{ $badgeColor }}-900/20 
                                               text-{{ $badgeColor }}-800 dark:text-{{ $badgeColor }}-200">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>

                                <button type="submit"
                                    class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4">
                                        </path>
                                    </svg>
                                    Mettre à jour le statut
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Order Summary --}}
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                                Résumé de commande
                            </h3>

                            <div class="space-y-3 text-sm">
                                <div>
                                    <span class="text-gray-600 dark:text-gray-400">Numéro de commande</span>
                                    <p class="font-medium text-gray-900 dark:text-gray-100 mt-1">
                                        #{{ $order->id }}
                                    </p>
                                </div>

                                <div>
                                    <span class="text-gray-600 dark:text-gray-400">Date de création</span>
                                    <p class="font-medium text-gray-900 dark:text-gray-100 mt-1">
                                        {{ $order->created_at->format('d/m/Y à H:i') }}
                                    </p>
                                </div>

                                <div>
                                    <span class="text-gray-600 dark:text-gray-400">Dernière mise à jour</span>
                                    <p class="font-medium text-gray-900 dark:text-gray-100 mt-1">
                                        {{ $order->updated_at->format('d/m/Y à H:i') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Payment Information --}}
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                                Informations de paiement
                            </h3>

                            <div class="space-y-3 text-sm">
                                <div>
                                    <span class="text-gray-600 dark:text-gray-400">Méthode de paiement</span>
                                    <p class="mt-1">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900/20 text-blue-800 dark:text-blue-200">
                                            {{ $order->payment_method ?? 'Paiement à la livraison' }}
                                        </span>
                                    </p>
                                </div>

                                @if (isset($order->payment_status))
                                    <div>
                                        <span class="text-gray-600 dark:text-gray-400">Statut du paiement</span>
                                        <p class="mt-1">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                       {{ $order->payment_status == 'paid' ? 'bg-green-100 dark:bg-green-900/20 text-green-800 dark:text-green-200' : 'bg-yellow-100 dark:bg-yellow-900/20 text-yellow-800 dark:text-yellow-200' }}">
                                                {{ ucfirst($order->payment_status) }}
                                            </span>
                                        </p>
                                    </div>
                                @endif

                                <div>
                                    <span class="text-gray-600 dark:text-gray-400">Montant total</span>
                                    <p class="font-bold text-lg text-blue-600 dark:text-blue-400 mt-1">
                                        {{ number_format($order->total, 2) }} MAD
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Order Notes --}}
                    @if (isset($order->order_notes) && $order->order_notes)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                                    Notes de commande
                                </h3>
                                <p
                                    class="text-sm text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-gray-700 p-3 rounded">
                                    {{ $order->order_notes }}
                                </p>
                            </div>
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>

</x-app-layout>