<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Confirmation de commande') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <!-- Message de succès -->
            @if(session('success'))
                <div class="mb-6 px-6 py-4 rounded-lg bg-green-50 dark:bg-green-900/20 border-2 border-green-200 dark:border-green-800">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-green-800 dark:text-green-200 font-medium">
                            {{ session('success') }}
                        </p>
                    </div>
                </div>
            @endif

            <!-- Détails de la commande -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                
                <!-- En-tête -->
                <div class="p-6 border-b dark:border-gray-700">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                Commande #{{ $order->order_number }}
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                Passée le {{ $order->created_at->format('d/m/Y à H:i') }}
                            </p>
                        </div>
                        
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                   bg-{{ $order->statusColor }}-100 dark:bg-{{ $order->statusColor }}-900/20 
                                   text-{{ $order->statusColor }}-800 dark:text-{{ $order->statusColor }}-200">
                            {{ $order->statusLabel }}
                        </span>
                    </div>
                </div>

                <!-- Informations de livraison et paiement -->
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6 border-b dark:border-gray-700">
                    
                    <!-- Adresse de livraison -->
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-gray-100 mb-3">
                            Adresse de livraison
                        </h4>
                        <div class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                            <p class="font-medium text-gray-900 dark:text-gray-100">
                                {{ $order->first_name }} {{ $order->last_name }}
                            </p>
                            <p>{{ $order->address }}</p>
                            @if($order->address_complement)
                                <p>{{ $order->address_complement }}</p>
                            @endif
                            <p>{{ $order->postal_code }} {{ $order->city }}</p>
                            <p>{{ $order->country }}</p>
                            <p class="pt-2">
                                <span class="font-medium">Tél:</span> {{ $order->phone }}
                            </p>
                            <p>
                                <span class="font-medium">Email:</span> {{ $order->email }}
                            </p>
                        </div>
                    </div>

                    <!-- Informations de paiement -->
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-gray-100 mb-3">
                            Informations de paiement
                        </h4>
                        <div class="text-sm text-gray-600 dark:text-gray-400 space-y-2">
                            <p>
                                <span class="font-medium text-gray-900 dark:text-gray-100">Méthode:</span>
                                {{ $order->paymentMethodLabel }}
                            </p>
                            <p>
                                <span class="font-medium text-gray-900 dark:text-gray-100">Statut:</span>
                                <span class="capitalize">{{ $order->payment_status }}</span>
                            </p>
                        </div>

                        @if($order->order_notes)
                        <div class="mt-4">
                            <h4 class="font-semibold text-gray-900 dark:text-gray-100 mb-2">
                                Notes de commande
                            </h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-gray-700 p-3 rounded">
                                {{ $order->order_notes }}
                            </p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Produits commandés -->
                <div class="p-6 border-b dark:border-gray-700">
                    <h4 class="font-semibold text-gray-900 dark:text-gray-100 mb-4">
                        Produits commandés
                    </h4>

                    <div class="space-y-4">
                        @foreach($order->items as $item)
                        <div class="flex items-center gap-4 pb-4 border-b dark:border-gray-700 last:border-0">
                            @if($item->product->image)
                            <img src="{{ asset('storage/' . $item->product->image) }}"
                                 class="w-20 h-20 rounded object-cover"
                                 alt="{{ $item->product->title ?? $item->product->name }}">
                            @else
                            <div class="w-20 h-20 bg-gray-200 dark:bg-gray-700 rounded flex items-center justify-center">
                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            @endif

                            <div class="flex-1">
                                <h5 class="font-medium text-gray-900 dark:text-gray-100">
                                    {{ $item->product->title ?? $item->product->name }}
                                </h5>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Quantité: {{ $item->quantity }} × ${{ number_format($item->price, 2) }}
                                </p>
                            </div>

                            <div class="font-semibold text-gray-900 dark:text-gray-100">
                                ${{ number_format($item->subtotal, 2) }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Résumé des totaux -->
                <div class="p-6 bg-gray-50 dark:bg-gray-900">
                    <div class="max-w-md ml-auto space-y-2">
                        <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400">
                            <span>Sous-total</span>
                            <span>${{ number_format($order->subtotal, 2) }}</span>
                        </div>

                        @if($order->shipping > 0)
                        <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400">
                            <span>Livraison</span>
                            <span>${{ number_format($order->shipping, 2) }}</span>
                        </div>
                        @else
                        <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400">
                            <span>Livraison</span>
                            <span class="text-green-600">Gratuite</span>
                        </div>
                        @endif

                        <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400">
                            <span>TVA (20%)</span>
                            <span>${{ number_format($order->tax, 2) }}</span>
                        </div>

                        <hr class="my-2 dark:border-gray-700">

                        <div class="flex justify-between text-xl font-bold text-gray-900 dark:text-gray-100">
                            <span>Total</span>
                            <span>${{ number_format($order->total, 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="p-6 bg-white dark:bg-gray-800 flex justify-between">
                    <a href="{{ route('orders.index') }}"
                       class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600">
                        Voir mes commandes
                    </a>

                    <a href="{{ route('products.index') }}"
                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Continuer mes achats
                    </a>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>