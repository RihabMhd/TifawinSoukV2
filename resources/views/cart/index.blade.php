<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <i class="fas fa-shopping-cart"></i> {{ __('Mon Panier') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Alerts --}}
            @if (session('success'))
                <div class="mb-4 px-4 py-3 rounded-lg bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-200">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 px-4 py-3 rounded-lg bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-200">
                    <i class="fas fa-times-circle"></i> {{ session('error') }}
                </div>
            @endif

            {{-- Empty cart --}}
            @if ($cart->getTotalItems() === 0)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100 text-center py-12">
                        <i class="fas fa-shopping-cart text-6xl text-gray-400 dark:text-gray-600 mb-4"></i>
                        <h5 class="text-xl font-semibold mb-2">Votre panier est vide</h5>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">Parcourez les produits et ajoutez-les à votre
                            panier.</p>
                        <a href="{{ route('products.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 dark:bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 dark:hover:bg-blue-600 focus:bg-blue-700 dark:focus:bg-blue-600 active:bg-blue-900 dark:active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            <i class="fas fa-store mr-2"></i> Découvrir les produits
                        </a>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    {{-- Cart items --}}
                    <div class="lg:col-span-2">
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                    <i class="fas fa-box mr-2"></i> Produits
                                </h3>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-900">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                                Produit
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                                Prix
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                                Quantité
                                            </th>
                                         
                                            <th scope="col" class="relative px-6 py-3">
                                                <span class="sr-only">Actions</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody
                                        class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        @foreach ($cart->products as $product)
                                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        @if ($product->image)
                                                            <img src="{{ asset('storage/' . $product->image) }}"
                                                                class="h-16 w-16 rounded-lg object-cover mr-4"
                                                                alt="{{ $product->title ?? $product->name }}">
                                                        @else
                                                            <div
                                                                class="h-16 w-16 bg-gray-300 dark:bg-gray-600 rounded-lg flex items-center justify-center mr-4">
                                                                <i
                                                                    class="fas fa-image text-gray-500 dark:text-gray-400"></i>
                                                            </div>
                                                        @endif

                                                        <a href="{{ route('products.show', $product) }}"
                                                            class="text-sm font-medium text-gray-900 dark:text-gray-100 hover:text-blue-600 dark:hover:text-blue-400">
                                                            {{ $product->title ?? $product->name }}
                                                        </a>
                                                    </div>
                                                </td>

                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900 dark:text-gray-100">
                                                    ${{ number_format($product->price, 2) }}
                                                </td>

                                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                                    <form method="POST" action="{{ route('cart.update', $product) }}"
                                                        class="flex items-center justify-center gap-2">
                                                        @csrf
                                                        @method('PATCH')

                                                        <input type="number" name="quantity"
                                                            value="{{ $product->pivot->quantity }}" min="1"
                                                            class="w-20 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-blue-500 dark:focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 text-sm">

                                                        <button type="submit"
                                                            class="inline-flex items-center px-3 py-2  border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 dark:hover:bg-blue-600 focus:bg-blue-700 dark:focus:bg-blue-600 active:bg-blue-900 dark:active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24">
                                                                <path fill="none" stroke="currentColor"
                                                                    stroke-dasharray="48" stroke-linecap="round"
                                                                    stroke-linejoin="round" stroke-width="2"
                                                                    d="M4.25 14c0.89 3.45 4.02 6 7.75 6c4.42 0 8 -3.58 8 -8c0 -4.42 -3.58 -8 -8 -8c-2.39 0 -4.53 1.05 -6 2.71l-2 2.29">
                                                                    <animate fill="freeze"
                                                                        attributeName="stroke-dashoffset" dur="0.6s"
                                                                        values="48;0" />
                                                                </path>
                                                                <g fill="currentColor">
                                                                    <path stroke="currentColor" stroke-linecap="round"
                                                                        stroke-linejoin="round"
                                                                        d="M5.63 7.38l-2.13 -2.13l0 4.25l4.25 0Z"
                                                                        opacity="0" stroke-width="1">
                                                                        <set fill="freeze" attributeName="opacity"
                                                                            begin="0.6s" to="1" />
                                                                        <animate fill="freeze" attributeName="d"
                                                                            begin="0.6s" dur="0.2s"
                                                                            values="M4 9l0 0l0 0l0 0Z;M5.63 7.38l-2.13 -2.13l0 4.25l4.25 0Z" />
                                                                    </path>
                                                                    <circle cx="12" cy="12">
                                                                        <animate fill="freeze" attributeName="r"
                                                                            begin="0.8s" dur="0.2s"
                                                                            to="2" />
                                                                    </circle>
                                                                </g>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </td>

                                               

                                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                                    <form method="POST" action="{{ route('cart.remove', $product) }}"
                                                        onsubmit="return confirm('Supprimer ce produit ?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="inline-flex items-center px-3 py-2 bg-red-600 dark:bg-red-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 dark:hover:bg-red-600 focus:bg-red-700 dark:focus:bg-red-600 active:bg-red-900 dark:active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24">
                                                                <g fill="none" stroke="currentColor"
                                                                    stroke-dasharray="22" stroke-linecap="round"
                                                                    stroke-linejoin="round" stroke-width="2">
                                                                    <path d="M5 5l14 14">
                                                                        <animate fill="freeze"
                                                                            attributeName="stroke-dashoffset"
                                                                            dur="0.5s" values="22;0" />
                                                                    </path>
                                                                    <path stroke-dashoffset="22" d="M19 5l-14 14">
                                                                        <animate fill="freeze"
                                                                            attributeName="stroke-dashoffset"
                                                                            begin="0.5s" dur="0.5s"
                                                                            to="0" />
                                                                    </path>
                                                                </g>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- Summary --}}
                    <div class="lg:col-span-1">
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg sticky top-20">
                            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                    <i class="fas fa-receipt mr-2"></i> Résumé
                                </h3>
                            </div>

                            <div class="p-6">
                               
                                <div class="flex justify-between items-center mb-3">
                                    <span class="text-gray-600 dark:text-gray-400">Livraison</span>
                                    <span class="text-green-600 dark:text-green-400 font-semibold">Gratuite</span>
                                </div>

                                <hr class="my-4 border-gray-200 dark:border-gray-700">

                                <div class="flex justify-between items-center mb-6">
                                    <h4 class="text-xl font-bold text-gray-900 dark:text-gray-100">Total</h4>
                                    <h4 class="text-xl font-bold text-gray-900 dark:text-gray-100">
                                        ${{ number_format($cart->getTotal(), 2) }}</h4>
                                </div>

                                @auth
                                    @if (auth()->user()->role_id == 3)
                                        <a href="{{ route('checkout.index') }}"
                                            class="w-full inline-flex justify-center items-center px-4 py-3 bg-green-600 dark:bg-green-500 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-green-700 dark:hover:bg-green-600 focus:bg-green-700 dark:focus:bg-green-600 active:bg-green-900 dark:active:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                            <i class="fas fa-credit-card mr-2"></i> Passer la commande
                                        </a>
                                    @else
                                        <button
                                            class="w-full inline-flex justify-center items-center px-4 py-3 bg-gray-400 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest cursor-not-allowed"
                                            disabled>
                                            Seuls les clients peuvent commander
                                        </button>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}"
                                        class="w-full inline-flex justify-center items-center px-4 py-3 bg-blue-600 dark:bg-blue-500 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-700 dark:hover:bg-blue-600 focus:bg-blue-700 dark:focus:bg-blue-600 active:bg-blue-900 dark:active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                        <i class="fas fa-sign-in-alt mr-2"></i> Se connecter
                                    </a>
                                @endauth

                                <form method="POST" action="{{ route('cart.clear') }}" class="mt-4"
                                    onsubmit="return confirm('Vider le panier ?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        class="w-full inline-flex justify-center items-center px-4 py-2 bg-transparent border border-red-600 dark:border-red-500 rounded-md font-semibold text-sm text-red-600 dark:text-red-400 uppercase tracking-widest hover:bg-red-50 dark:hover:bg-red-900/20 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                        <i class="fas fa-trash mr-2"></i> Vider le panier
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            @endif
        </div>
    </div>
</x-app-layout>
