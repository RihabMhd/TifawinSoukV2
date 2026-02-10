<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Commande #{{ $order->order_number }}
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Passée le {{ $order->created_at->format('d/m/Y à H:i') }}
                </p>
            </div>

            <span
                class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold
                       bg-{{ $order->statusColor }}-100 dark:bg-{{ $order->statusColor }}-900/20 
                       text-{{ $order->statusColor }}-800 dark:text-{{ $order->statusColor }}-200">
                {{ $order->statusLabel }}
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

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

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-6">
                        Suivi de commande
                    </h3>

                    @php
                        $statuses = [
                            'pending' => ['label' => 'En attente', 'icon' => 'hourglass'],
                            'confirmed' => ['label' => 'Confirmée', 'icon' => 'check-circle'],
                            'shipped' => ['label' => 'Expédiée', 'icon' => 'truck'],
                            'delivered' => ['label' => 'Livrée', 'icon' => 'box'],
                        ];

                        $statusKeys = array_keys($statuses);
                        $currentStatusKey = $order->status;

                        
                        $isCancelled = $currentStatusKey === 'cancelled';

                        if (!$isCancelled) {
                            $currentIndex = array_search($currentStatusKey, $statusKeys);
                            if ($currentIndex === false) {
                                $currentIndex = 0;
                            }
                        }
                    @endphp

                    @if ($isCancelled)
                     
                        <div class="flex items-center justify-center py-8">
                            <div class="text-center">
                                <div
                                    class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-red-100 dark:bg-red-900/20 mb-4">
                                    <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-semibold text-red-600 dark:text-red-400">Commande annulée</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                                    Cette commande a été annulée le {{ $order->updated_at->format('d/m/Y à H:i') }}
                                </p>
                            </div>
                        </div>
                    @else
                       
                        <div class="hidden md:block">
                            <div class="relative">
                                <div class="absolute top-5 left-0 right-0 h-1 bg-gray-200 dark:bg-gray-700"></div>
                                <div class="absolute top-5 left-0 h-1 bg-blue-600 transition-all duration-500"
                                    style="width: {{ ($currentIndex / (count($statuses) - 1)) * 100 }}%"></div>

                                <div class="relative flex justify-between">
                                    @foreach ($statuses as $key => $status)
                                        @php
                                            $index = array_search($key, $statusKeys);
                                            $isCompleted = $index <= $currentIndex;
                                            $isCurrent = $index === $currentIndex;
                                        @endphp

                                        <div class="flex flex-col items-center"
                                            style="width: {{ 100 / count($statuses) }}%">
                                            <div
                                                class="relative flex items-center justify-center w-12 h-12 rounded-full border-4 
                                                      {{ $isCompleted ? 'bg-green-500 border-green-500' : ($isCurrent ? 'bg-blue-600 border-blue-600 animate-pulse' : 'bg-gray-200 dark:bg-gray-700 border-gray-200 dark:border-gray-700') }}">
                                                @if ($status['icon'] === 'hourglass')
                                                    <svg class="w-6 h-6 {{ $isCompleted || $isCurrent ? 'text-white' : 'text-gray-400' }}"
                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                @elseif($status['icon'] === 'check-circle')
                                                    <svg class="w-6 h-6 {{ $isCompleted || $isCurrent ? 'text-white' : 'text-gray-400' }}"
                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                @elseif($status['icon'] === 'truck')
                                                    <svg class="w-6 h-6 {{ $isCompleted || $isCurrent ? 'text-white' : 'text-gray-400' }}"
                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path
                                                            d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z">
                                                        </path>
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1-1V9a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V15a1 1 0 01-1 1h-1m-6 0a1 1 0 001 1h2a1 1 0 001-1m0 0h1a1 1 0 001-1v-1a1 1 0 00-.293-.707l-2-2A1 1 0 0014 9h-2a1 1 0 00-1 1v4a1 1 0 001 1z">
                                                        </path>
                                                    </svg>
                                                @else
                                                    <svg class="w-6 h-6 {{ $isCompleted || $isCurrent ? 'text-white' : 'text-gray-400' }}"
                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4">
                                                        </path>
                                                    </svg>
                                                @endif
                                            </div>

                                            <div class="mt-3 text-center">
                                                <p
                                                    class="text-sm font-medium {{ $isCompleted || $isCurrent ? 'text-gray-900 dark:text-gray-100' : 'text-gray-400 dark:text-gray-500' }}">
                                                    {{ $status['label'] }}
                                                </p>
                                               
                                                @if ($isCompleted && $key === $currentStatusKey)
                                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                        {{ $order->updated_at->format('d/m H:i') }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                      
                        <div class="md:hidden space-y-4">
                            @foreach ($statuses as $key => $status)
                                @php
                                    $index = array_search($key, $statusKeys);
                                    $isCompleted = $index <= $currentIndex;
                                    $isCurrent = $index === $currentIndex;
                                @endphp

                                <div class="flex items-start gap-4">
                                    <div class="relative">
                                        <div
                                            class="flex items-center justify-center w-10 h-10 rounded-full border-4 
                                                  {{ $isCompleted ? 'bg-green-500 border-green-500' : ($isCurrent ? 'bg-blue-600 border-blue-600 animate-pulse' : 'bg-gray-200 dark:bg-gray-700 border-gray-200 dark:border-gray-700') }}">
                                            @if ($status['icon'] === 'hourglass')
                                                <svg class="w-5 h-5 {{ $isCompleted || $isCurrent ? 'text-white' : 'text-gray-400' }}"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            @elseif($status['icon'] === 'check-circle')
                                                <svg class="w-5 h-5 {{ $isCompleted || $isCurrent ? 'text-white' : 'text-gray-400' }}"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            @elseif($status['icon'] === 'truck')
                                                <svg class="w-5 h-5 {{ $isCompleted || $isCurrent ? 'text-white' : 'text-gray-400' }}"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path
                                                        d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z">
                                                    </path>
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1-1V9a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V15a1 1 0 01-1 1h-1m-6 0a1 1 0 001 1h2a1 1 0 001-1m0 0h1a1 1 0 001-1v-1a1 1 0 00-.293-.707l-2-2A1 1 0 0014 9h-2a1 1 0 00-1 1v4a1 1 0 001 1z">
                                                    </path>
                                                </svg>
                                            @else
                                                <svg class="w-5 h-5 {{ $isCompleted || $isCurrent ? 'text-white' : 'text-gray-400' }}"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4">
                                                    </path>
                                                </svg>
                                            @endif
                                        </div>

                                        @if (!$loop->last)
                                            <div
                                                class="absolute top-10 left-1/2 transform -translate-x-1/2 w-0.5 h-12 
                                                      {{ $isCompleted && $index < $currentIndex ? 'bg-green-500' : 'bg-gray-200 dark:bg-gray-700' }}">
                                            </div>
                                        @endif
                                    </div>

                                    <div class="flex-1 pt-1">
                                        <p
                                            class="text-sm font-medium {{ $isCompleted || $isCurrent ? 'text-gray-900 dark:text-gray-100' : 'text-gray-400 dark:text-gray-500' }}">
                                            {{ $status['label'] }}
                                        </p>
                                        @if ($isCompleted && $key === $currentStatusKey)
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                {{ $order->updated_at->format('d/m/Y à H:i') }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
              
                <div class="lg:col-span-2 space-y-6">

                    
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                                Produits commandés
                            </h3>

                            <div class="space-y-4">
                                @foreach ($order->products as $product)
                                    <div
                                        class="flex items-start gap-4 pb-4 border-b dark:border-gray-700 last:border-0">
                                      
                                        @if ($product->product_snapshot && isset($product->product_snapshot['image']))
                                            <img src="{{ asset('storage/' . $product->product_snapshot['image']) }}"
                                                class="w-20 h-20 rounded object-cover flex-shrink-0"
                                                alt="{{ $product->product_snapshot['name'] ?? 'Product' }}">
                                        @elseif($product->product && $product->product->image)
                                            <img src="{{ asset('storage/' . $product->product->image) }}"
                                                class="w-20 h-20 rounded object-cover flex-shrink-0"
                                                alt="{{ $product->product->title ?? $product->product->name }}">
                                        @else
                                            <div
                                                class="w-20 h-20 bg-gray-200 dark:bg-gray-700 rounded flex items-center justify-center flex-shrink-0">
                                                <svg class="w-10 h-10 text-gray-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                            </div>
                                        @endif

                                        <div class="flex-1 min-w-0">
                                            <h5 class="font-medium text-gray-900 dark:text-gray-100">
                                                {{ $product->product_snapshot['name'] ?? ($product->title ?? ($item->product->name ?? 'Produit indisponible')) }}
                                            </h5>

                                            @if (isset($product->product_snapshot['reference']) || ($product && $product->reference))
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                    Réf:
                                                    {{ $product->product_snapshot['reference'] ?? $product->reference }}
                                                </p>
                                            @endif

                                            <div
                                                class="flex items-center gap-4 mt-2 text-sm text-gray-600 dark:text-gray-400">
                                                <span>Quantité: {{ $product->quantity }}</span>
                                                <span>×</span>
                                                <span>${{ number_format($product->price, 2) }}</span>
                                            </div>
                                        </div>

                                        <div
                                            class="font-semibold text-gray-900 dark:text-gray-100 text-right flex-shrink-0">
                                            ${{ number_format($product->subtotal, 2) }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                      
                            <div class="mt-6 pt-6 border-t dark:border-gray-700">
                                <div class="space-y-2">
                                    <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400">
                                        <span>Sous-total</span>
                                        <span>${{ number_format($order->subtotal, 2) }}</span>
                                    </div>

                                    <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400">
                                        <span>Frais de livraison</span>
                                        @if ($order->shipping > 0)
                                            <span>${{ number_format($order->shipping, 2) }}</span>
                                        @else
                                            <span
                                                class="text-green-600 dark:text-green-400 font-medium">Gratuite</span>
                                        @endif
                                    </div>

                                    @if ($order->tax > 0)
                                        <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400">
                                            <span>TVA (20%)</span>
                                            <span>${{ number_format($order->tax, 2) }}</span>
                                        </div>
                                    @endif

                                    <div
                                        class="flex justify-between text-lg font-bold text-gray-900 dark:text-gray-100 pt-2 border-t dark:border-gray-700">
                                        <span>Total</span>
                                        <span>${{ number_format($order->total, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

             
                <div class="space-y-6">

                
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                                Informations de commande
                            </h3>

                            <div class="space-y-3 text-sm">
                                <div>
                                    <span class="text-gray-600 dark:text-gray-400">Numéro de commande</span>
                                    <p class="font-medium text-gray-900 dark:text-gray-100 mt-1">
                                        #{{ $order->order_number }}
                                    </p>
                                </div>

                                <div>
                                    <span class="text-gray-600 dark:text-gray-400">Date de commande</span>
                                    <p class="font-medium text-gray-900 dark:text-gray-100 mt-1">
                                        {{ $order->created_at->format('d/m/Y à H:i') }}
                                    </p>
                                </div>

                                <div>
                                    <span class="text-gray-600 dark:text-gray-400">Statut</span>
                                    <p class="mt-1">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                   bg-{{ $order->statusColor }}-100 dark:bg-{{ $order->statusColor }}-900/20 
                                                   text-{{ $order->statusColor }}-800 dark:text-{{ $order->statusColor }}-200">
                                            {{ $order->statusLabel }}
                                        </span>
                                    </p>
                                </div>

                                <div>
                                    <span class="text-gray-600 dark:text-gray-400">Méthode de paiement</span>
                                    <p class="font-medium text-gray-900 dark:text-gray-100 mt-1">
                                        {{ $order->paymentMethodLabel }}
                                    </p>
                                </div>

                                @if ($order->payment_status)
                                    <div>
                                        <span class="text-gray-600 dark:text-gray-400">Statut du paiement</span>
                                        <p class="font-medium text-gray-900 dark:text-gray-100 mt-1 capitalize">
                                            {{ $order->payment_status }}
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

            
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                                Adresse de livraison
                            </h3>

                            <div class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                                <p class="font-medium text-gray-900 dark:text-gray-100">
                                    {{ $order->first_name }} {{ $order->last_name }}
                                </p>
                                <p>{{ $order->address }}</p>
                                @if ($order->address_complement)
                                    <p>{{ $order->address_complement }}</p>
                                @endif
                                <p>{{ $order->postal_code }} {{ $order->city }}</p>
                                @if ($order->country)
                                    <p>{{ $order->country }}</p>
                                @endif
                                <p class="pt-2">
                                    <span class="font-medium text-gray-900 dark:text-gray-100">Tél:</span>
                                    {{ $order->phone }}
                                </p>
                                <p>
                                    <span class="font-medium text-gray-900 dark:text-gray-100">Email:</span>
                                    {{ $order->email }}
                                </p>
                            </div>
                        </div>
                    </div>

                    
                    @if ($order->order_notes)
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

     
            <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 flex flex-col sm:flex-row justify-between gap-4">
                    <a href="{{ route('orders.index') }}"
                        class="inline-flex justify-center items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Mes commandes
                    </a>

                    <div class="flex gap-3">
                        @if (method_exists($order, 'canBeCancelled') && $order->canBeCancelled())
                            <button type="button" onclick="openCancelModal()"
                                class="inline-flex justify-center items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Annuler la commande
                            </button>
                        @endif

                        <a href="{{ route('products.index') }}"
                            class="inline-flex justify-center items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                            Continuer mes achats
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>

   
    @if (method_exists($order, 'canBeCancelled') && $order->canBeCancelled())
        <div id="cancelModal"
            class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
                <div class="mt-3">
                    <div
                        class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900/20">
                        <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                    </div>

                    <div class="mt-4 text-center">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">
                            Annuler la commande
                        </h3>
                        <div class="mt-2 px-7 py-3">
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Êtes-vous sûr de vouloir annuler cette commande ? Cette action est irréversible.
                            </p>
                        </div>

                        <div class="flex gap-3 justify-center mt-4">
                            <button type="button" onclick="closeCancelModal()"
                                class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 text-sm font-medium rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                                Non, garder
                            </button>

                            <form action="{{ route('orders.cancel', $order) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700 transition">
                                    Oui, annuler
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function openCancelModal() {
                document.getElementById('cancelModal').classList.remove('hidden');
            }

            function closeCancelModal() {
                document.getElementById('cancelModal').classList.add('hidden');
            }

            document.getElementById('cancelModal')?.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeCancelModal();
                }
            });

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeCancelModal();
                }
            });
        </script>
    @endif

</x-app-layout>
