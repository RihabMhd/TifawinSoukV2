<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Products') }}
            </h2>
            @auth
                @if (auth()->user()->isAdmin())
                    <a href="{{ route('admin.products.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                        {{ __('Add Product') }}
                    </a>
                @endif
            @endauth
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div
                    class="mb-4 px-4 py-3 rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800">
                    <p class="text-sm text-green-800 dark:text-green-200">{{ session('success') }}</p>
                </div>
            @endif

            @if (session('error'))
                <div
                    class="mb-4 px-4 py-3 rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800">
                    <p class="text-sm text-red-800 dark:text-red-200">{{ session('error') }}</p>
                </div>
            @endif

          
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('products.index') }}" class="flex gap-2">
                        <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                        <input type="text" 
                            name="search" 
                            id="search" 
                            value="{{ request('search') }}"
                            placeholder="🔍 Rechercher un produit..."
                            class="flex-1 rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
                        
                        <button type="submit"
                            class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">
                            Rechercher
                        </button>
                        
                        @if(request('search') || request('category_id'))
                            <a href="{{ route('products.index') }}"
                                class="px-6 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition">
                                Réinitialiser
                            </a>
                        @endif
                    </form>
                </div>
            </div>

         
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    
                    <div class="flex flex-wrap gap-9 ml-3">
                  
                        <a href="{{ route('products.index', ['search' => request('search')]) }}"
                            class="flex flex-col items-center group">
                            <div class="w-16 h-16 rounded-full flex items-center justify-center transition-all duration-200 {{ !request('category_id') ? 'bg-indigo-600 text-white ring-4 ring-indigo-200 dark:ring-indigo-800' : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                                </svg>
                            </div>
                            <span class="mt-2 text-xs font-medium text-center {{ !request('category_id') ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-600 dark:text-gray-400' }}">
                                Toutes
                            </span>
                            <span class="text-xs text-gray-500 dark:text-gray-500">
                                ({{ $categories->sum('products_count') }})
                            </span>
                        </a>

                        @php
                      
                        $categoryIcons = [
                            'Electronics' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>',
                            'Clothing' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>',
                            'Books' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>',
                            'Food' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>',
                            'Sports' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>',
                            'Home' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>',
                            'Toys' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>',
                            'Beauty' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>',
                        ];
                        
                     
                        $categoryColors = [
                            'bg-blue-600', 'bg-green-600', 'bg-purple-600', 'bg-red-600', 
                            'bg-yellow-600', 'bg-pink-600', 'bg-indigo-600', 'bg-teal-600',
                            'bg-orange-600', 'bg-cyan-600', 'bg-emerald-600', 'bg-violet-600'
                        ];
                        @endphp

                        @foreach($categories as $index => $category)
                            @php
                                $isActive = request('category_id') == $category->id;
                                $color = $categoryColors[$index % count($categoryColors)];
                                
                             
                                $icon = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>';
                                
                                foreach ($categoryIcons as $keyword => $iconPath) {
                                    if (stripos($category->title, $keyword) !== false) {
                                        $icon = $iconPath;
                                        break;
                                    }
                                }
                            @endphp
                            
                            <a href="{{ route('products.index', ['category_id' => $category->id, 'search' => request('search')]) }}"
                                class="flex flex-col items-center group">
                                <div class="w-16 h-16 rounded-full flex items-center justify-center transition-all duration-200 {{ $isActive ? $color . ' text-white ring-4 ring-opacity-30 ring-' . str_replace('bg-', '', $color) : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-600 hover:scale-110' }}">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        {!! $icon !!}
                                    </svg>
                                </div>
                                <span class="mt-2 text-xs font-medium text-center max-w-[80px] truncate {{ $isActive ? 'text-' . str_replace('bg-', '', $color) . ' dark:text-' . str_replace('bg-', '', $color) : 'text-gray-600 dark:text-gray-400' }}" title="{{ $category->title }}">
                                    {{ $category->title }}
                                </span>
                                <span class="text-xs text-gray-500 dark:text-gray-500">
                                    ({{ $category->products_count }})
                                </span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            
            @if(request('search') || request('category_id'))
                <div class="mb-4 flex flex-wrap gap-2 items-center">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Filtres actifs:</span>
                    
                    @if(request('search'))
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-indigo-100 dark:bg-indigo-900 text-indigo-800 dark:text-indigo-200">
                            🔍 "{{ request('search') }}"
                            <a href="{{ route('products.index', ['category_id' => request('category_id')]) }}" 
                                class="ml-2 text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-200 font-bold">
                                ×
                            </a>
                        </span>
                    @endif
                    
                    @if(request('category_id'))
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200">
                            📁 {{ $categories->find(request('category_id'))->title ?? '' }}
                            <a href="{{ route('products.index', ['search' => request('search')]) }}" 
                                class="ml-2 text-purple-600 dark:text-purple-400 hover:text-purple-800 dark:hover:text-purple-200 font-bold">
                                ×
                            </a>
                        </span>
                    @endif
                    
                    <span class="text-sm text-gray-600 dark:text-gray-400">
                        → {{ $products->total() }} produit(s) trouvé(s)
                    </span>
                </div>
            @endif

            @if ($products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach ($products as $product)
                        <div
                            class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow duration-200">

                            <div class="aspect-square bg-gray-100 dark:bg-gray-700">
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}"
                                        class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-20 h-20 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <div class="p-4">
                                <h3 class="font-semibold text-lg text-gray-900 dark:text-gray-100 mb-1">
                                    {{ $product->title }}
                                </h3>

                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                                    {{ $product->category->title }}
                                </p>

                                @if ($product->description)
                                    <p class="text-sm text-gray-700 dark:text-gray-300 mb-3 line-clamp-2">
                                        {{ $product->description }}
                                    </p>
                                @endif

                                <div class="flex items-center justify-between">
                                    <span class="text-xl font-bold text-gray-900 dark:text-gray-100">
                                        ${{ number_format($product->price, 2) }}
                                    </span>

                                    <a href="{{ route('products.show', $product->id) }}"
                                        class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                                        View Details →
                                    </a>

                                </div>
                                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-2">
                                    @csrf

                                    @if ($product->quantity > 0)
                                        
                                        <div class="flex items-center gap-2">
                                            <input type="number" name="quantity" min="1"
                                                max="{{ $product->quantity }}" value="1"
                                                class="w-20 border rounded px-2 py-1" />

                                            <button type="submit"
                                                class="flex-1 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                                Ajouter au panier
                                            </button>
                                        </div>

                                        <p class="text-sm text-gray-500 mt-1">
                                            Stock disponible : {{ $product->quantity }}
                                        </p>
                                    @else
                                       
                                        <button type="button" disabled
                                            class="w-full px-4 py-2 bg-gray-400 text-white rounded cursor-not-allowed">
                                            Rupture de stock
                                        </button>
                                    @endif
                                </form>

                                @auth
                                    @if (auth()->user()->isAdmin())
                                        <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700 flex gap-2">
                                            <a href="{{ route('admin.products.edit', $product->id) }}"
                                                class="flex-1 text-center px-3 py-2 text-xs bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded hover:bg-gray-200 dark:hover:bg-gray-600">
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.products.destroy', $product->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this product?');"
                                                class="flex-1">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="w-full px-3 py-2 text-xs bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 rounded hover:bg-red-200 dark:hover:bg-red-900/50">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                            @if(request('search') || request('category_id'))
                                Aucun produit trouvé
                            @else
                                No products
                            @endif
                        </h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            @if(request('search') || request('category_id'))
                                Essayez de modifier vos critères de recherche ou de filtrage.
                            @else
                                Get started by creating a new product.
                            @endif
                        </p>
                        @auth
                            @if (auth()->user()->isAdmin() && !request('search') && !request('category_id'))
                                <div class="mt-6">
                                    <a href="{{ route('admin.products.create') }}"
                                        class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white">
                                        Add Product
                                    </a>
                                </div>
                            @endif
                        @endauth
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>