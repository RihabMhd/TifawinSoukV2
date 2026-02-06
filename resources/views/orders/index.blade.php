<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Mes Commandes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 px-4 py-3 rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-sm text-green-800 dark:text-green-200">
                            {{ session('success') }}
                        </p>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 px-4 py-3 rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-600 dark:text-red-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-sm text-red-800 dark:text-red-200">
                            {{ session('error') }}
                        </p>
                    </div>
                </div>
            @endif

          
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            Filtres de recherche
                        </h3>
                        <button type="button" 
                                onclick="document.getElementById('filtersForm').classList.toggle('hidden')"
                                class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                            <svg class="w-5 h-5 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                            </svg>
                            <span id="filterToggleText">Afficher les filtres</span>
                        </button>
                    </div>

                     
                    <form method="GET" action="{{ route('orders.index') }}" id="filtersForm" class="hidden">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            
                             
                            <div>
                                <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Rechercher
                                </label>
                                <input type="text" 
                                       name="search" 
                                       id="search"
                                       value="{{ request('search') }}"
                                       placeholder="Numéro de commande..."
                                       class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                      
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Statut
                                </label>
                                <select name="status" 
                                        id="status"
                                        class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Tous les statuts</option>
                                    @foreach($statuses as $value => $label)
                                        <option value="{{ $value }}" {{ request('status') === $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                       
                            <div>
                                <label for="sort_by" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Trier par
                                </label>
                                <select name="sort_by" 
                                        id="sort_by"
                                        class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="created_at" {{ request('sort_by') === 'created_at' ? 'selected' : '' }}>Date</option>
                                    <option value="total" {{ request('sort_by') === 'total' ? 'selected' : '' }}>Montant</option>
                                    <option value="order_number" {{ request('sort_by') === 'order_number' ? 'selected' : '' }}>Numéro</option>
                                </select>
                            </div>

                            <div>
                                <label for="sort_order" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Ordre
                                </label>
                                <select name="sort_order" 
                                        id="sort_order"
                                        class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="desc" {{ request('sort_order') === 'desc' ? 'selected' : '' }}>Décroissant</option>
                                    <option value="asc" {{ request('sort_order') === 'asc' ? 'selected' : '' }}>Croissant</option>
                                </select>
                            </div>

                            <div>
                                <label for="date_from" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Date de début
                                </label>
                                <input type="date" 
                                       name="date_from" 
                                       id="date_from"
                                       value="{{ request('date_from') }}"
                                       class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <div>
                                <label for="date_to" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Date de fin
                                </label>
                                <input type="date" 
                                       name="date_to" 
                                       id="date_to"
                                       value="{{ request('date_to') }}"
                                       class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <div>
                                <label for="price_min" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Montant minimum
                                </label>
                                <input type="number" 
                                       name="price_min" 
                                       id="price_min"
                                       value="{{ request('price_min') }}"
                                       step="0.01"
                                       placeholder="0.00"
                                       class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            {{-- Price max --}}
                            <div>
                                <label for="price_max" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Montant maximum
                                </label>
                                <input type="number" 
                                       name="price_max" 
                                       id="price_max"
                                       value="{{ request('price_max') }}"
                                       step="0.01"
                                       placeholder="0.00"
                                       class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                        </div>

                        
                        <div class="flex gap-3 mt-4">
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                                </svg>
                                Filtrer
                            </button>

                            <a href="{{ route('orders.index') }}"
                               class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Réinitialiser
                            </a>
                        </div>
                    </form>

                  
                    @if(!empty($activeFilters))
                        <div class="mt-4 pt-4 border-t dark:border-gray-700">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Filtres actifs:
                                </span>
                                @foreach($activeFilters as $filter)
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm bg-blue-100 dark:bg-blue-900/20 text-blue-800 dark:text-blue-200">
                                        <span class="font-medium">{{ $filter['label'] }}:</span>
                                        <span>{{ $filter['value'] }}</span>
                                        <a href="{{ request()->fullUrlWithQuery([$filter['param'] => null]) }}"
                                           class="ml-1 hover:text-blue-900 dark:hover:text-blue-100">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </a>
                                    </span>
                                @endforeach
                                
                                <a href="{{ route('orders.index') }}"
                                   class="text-sm text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 ml-2">
                                    Tout effacer
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            @if($orders->isEmpty())
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>

                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                            Aucune commande trouvée
                        </h3>

                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            @if(!empty($activeFilters))
                                Aucune commande ne correspond à vos critères de recherche.
                            @else
                                Vous n'avez pas encore passé de commande.
                            @endif
                        </p>

                        <div class="mt-6">
                            @if(!empty($activeFilters))
                                <a href="{{ route('orders.index') }}"
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                    Réinitialiser les filtres
                                </a>
                            @else
                                <a href="{{ route('products.index') }}"
                                   class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 text-white dark:text-gray-800 rounded-md text-xs font-semibold uppercase hover:bg-gray-700 dark:hover:bg-white">
                                    Découvrir les produits
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @else

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Numéro de commande
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Date
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Statut
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Total
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Articles
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($orders as $order)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $order->order_number }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $order->created_at->format('d/m/Y') }}
                                    </div>
                                    <div class="text-xs text-gray-400 dark:text-gray-500">
                                        {{ $order->created_at->format('H:i') }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                               bg-{{ $order->statusColor }}-100 dark:bg-{{ $order->statusColor }}-900/20 
                                               text-{{ $order->statusColor }}-800 dark:text-{{ $order->statusColor }}-200">
                                        {{ $order->statusLabel }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                        ${{ number_format($order->total, 2) }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $order->items->count() }} article{{ $order->items->count() > 1 ? 's' : '' }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('orders.show', $order) }}"
                                           class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                            Détails
                                        </a>

                                        @if($order->canBeCancelled())
                                        <button type="button"
                                                onclick="openCancelModal({{ $order->id }}, '{{ $order->order_number }}')"
                                                class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                            Annuler
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($orders->hasPages())
                <div class="px-6 py-4 border-t dark:border-gray-700">
                    {{ $orders->links() }}
                </div>
                @endif
            </div>

            @endif

            @if($orders->isNotEmpty())
            <div class="mt-6 grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500 dark:text-gray-400">Total des commandes</div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 mt-1">
                        {{ auth()->user()->orders->count() }}
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500 dark:text-gray-400">En attente</div>
                    <div class="text-2xl font-bold text-yellow-600 dark:text-yellow-400 mt-1">
                        {{ auth()->user()->orders->where('status', 'pending')->count() }}
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500 dark:text-gray-400">Livrées</div>
                    <div class="text-2xl font-bold text-green-600 dark:text-green-400 mt-1">
                        {{ auth()->user()->orders->where('status', 'delivered')->count() }}
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500 dark:text-gray-400">Montant total</div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 mt-1">
                        ${{ number_format(auth()->user()->orders->sum('total'), 2) }}
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>

   
    <div id="cancelOrderModal" 
         class="hidden fixed inset-0 bg-black bg-opacity-50 overflow-y-auto h-full w-full z-50 transition-opacity duration-300">
        <div class="relative top-20 mx-auto p-0 border-0 w-full max-w-md">
            <div class="relative bg-white dark:bg-gray-800 rounded-xl shadow-2xl transform transition-all duration-300 scale-95 opacity-0" 
                 id="cancelModalContent">
                
                <div class="relative bg-gradient-to-r from-red-600 to-red-500 rounded-t-xl px-6 py-6">
                    <div class="flex items-center justify-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-white bg-opacity-20 rounded-full backdrop-blur-sm">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xl font-semibold text-white text-center mt-4">
                        Confirmer l'annulation
                    </h3>
                </div>

                <div class="px-6 py-6">
                    <div class="text-center space-y-3">
                        <p class="text-gray-600 dark:text-gray-300 text-sm">
                            Vous êtes sur le point d'annuler la commande
                        </p>
                        <div class="bg-gray-100 dark:bg-gray-700 rounded-lg px-4 py-3">
                            <p class="text-lg font-bold text-gray-900 dark:text-gray-100" id="orderNumberDisplay">
                                #
                            </p>
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Cette action est <span class="font-semibold text-red-600 dark:text-red-400">irréversible</span> 
                            et ne pourra pas être annulée.
                        </p>
                    </div>

                    <div class="mt-5 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-red-600 dark:text-red-400 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div class="text-sm text-red-800 dark:text-red-300">
                                <p class="font-medium">Attention</p>
                                <p class="mt-1 text-red-700 dark:text-red-400">La commande sera définitivement annulée et les produits seront remis en stock.</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-3 mt-6">
                        <button type="button"
                                onclick="closeCancelModal()"
                                class="flex-1 inline-flex justify-center items-center px-4 py-2.5 bg-white dark:bg-gray-700 
                                       border-2 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 
                                       rounded-lg font-medium hover:bg-gray-50 dark:hover:bg-gray-600 
                                       transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gray-500">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Annuler
                        </button>
                        
                        <form id="cancelOrderForm" method="POST" action="" class="flex-1">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                    class="w-full inline-flex justify-center items-center px-4 py-2.5 bg-red-600 text-white 
                                           rounded-lg font-medium hover:bg-red-700 
                                           shadow-md hover:shadow-lg transition-all duration-200 
                                           focus:outline-none focus:ring-2 focus:ring-red-500">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Confirmer
                            </button>
                        </form>
                    </div>
                </div>

                <button type="button"
                        onclick="closeCancelModal()"
                        class="absolute top-4 right-4 text-white hover:text-gray-200 transition-colors p-1 rounded-lg hover:bg-white hover:bg-opacity-10">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <script>
        let currentOrderId = null;

        
        document.querySelector('button[onclick*="filtersForm"]')?.addEventListener('click', function() {
            const text = document.getElementById('filterToggleText');
            const form = document.getElementById('filtersForm');
            text.textContent = form.classList.contains('hidden') ? 'Masquer les filtres' : 'Afficher les filtres';
        });

     
        @if(!empty($activeFilters))
            document.getElementById('filtersForm').classList.remove('hidden');
            document.getElementById('filterToggleText').textContent = 'Masquer les filtres';
        @endif

        function openCancelModal(orderId, orderNumber) {
            currentOrderId = orderId;
            const modal = document.getElementById('cancelOrderModal');
            const content = document.getElementById('cancelModalContent');
            const orderDisplay = document.getElementById('orderNumberDisplay');
            const form = document.getElementById('cancelOrderForm');

            orderDisplay.textContent = '#' + orderNumber;
            form.action = `/orders/${orderId}/cancel`;

            modal.classList.remove('hidden');
            
            setTimeout(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeCancelModal() {
            const modal = document.getElementById('cancelOrderModal');
            const content = document.getElementById('cancelModalContent');

            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');

            setTimeout(() => {
                modal.classList.add('hidden');
                currentOrderId = null;
            }, 300);
        }

        document.getElementById('cancelOrderModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeCancelModal();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && currentOrderId !== null) {
                closeCancelModal();
            }
        });

        document.getElementById('cancelOrderForm')?.addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <svg class="w-5 h-5 mr-2 animate-spin inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Traitement...
            `;
        });
    </script>

</x-app-layout>