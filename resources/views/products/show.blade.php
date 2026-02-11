<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $product->title }}
            </h2>
            @auth
                @if (auth()->user()->isAdmin())
                    <div class="flex gap-2">
                        <a href="{{ route('admin.products.edit', $product->id) }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            Edit
                        </a>
                    </div>
                @endif
            @endauth
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        {{-- Product Image --}}
                        <div class="aspect-square bg-gray-100 dark:bg-gray-700 rounded-lg overflow-hidden">
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}"
                                    class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-32 h-32 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        {{-- Product Details --}}
                        <div class="flex flex-col">
                            <div class="flex-1">
                                <div class="mb-4">
                                    <span
                                        class="inline-block px-3 py-1 text-sm font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-full">
                                        {{ $product->category->title }}
                                    </span>
                                </div>

                                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                                    {{ $product->title }}
                                </h1>

                                <div class="text-4xl font-bold text-gray-900 dark:text-gray-100 mb-6">
                                    ${{ number_format($product->price, 2) }}
                                </div>

                                @if ($product->description)
                                    <div class="prose dark:prose-invert max-w-none mb-6">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">
                                            Description
                                        </h3>
                                        <p class="text-gray-700 dark:text-gray-300">{{ $product->description }}</p>
                                    </div>
                                @endif

                                {{-- Stock Information --}}
                                @if (!auth()->check() || !auth()->user()->isAdmin())
                                    <div class="mb-6">
                                        @if ($product->quantity > 0)
                                            <div class="flex items-center text-green-600 dark:text-green-400">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                <span class="font-medium">{{ $product->quantity }} en stock</span>
                                            </div>
                                        @else
                                            <div class="flex items-center text-red-600 dark:text-red-400">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                                <span class="font-medium">Rupture de stock</span>
                                            </div>
                                        @endif
                                    </div>
                                @endif

                                <div class="border-t border-gray-200 dark:border-gray-700 pt-6 mt-6">
                                    <dl class="grid grid-cols-1 gap-4">
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Created by
                                            </dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                                {{ $product->user->name }}
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Listed on
                                            </dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                                {{ $product->created_at->format('F j, Y') }}
                                            </dd>
                                        </div>
                                        @auth
                                            @if (auth()->user()->isAdmin())
                                                <div>
                                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Stock
                                                        Quantity</dt>
                                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                                        {{ $product->quantity }} units
                                                    </dd>
                                                </div>
                                            @endif
                                        @endauth
                                    </dl>
                                </div>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="mt-8 space-y-4">
                                {{-- Add to Cart (Only for non-admin users) --}}
                                @auth
                                    @if (!auth()->user()->isAdmin())
                                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                            @csrf
                                            @if ($product->quantity > 0)
                                                <div class="flex items-center gap-3">
                                                    <div class="flex flex-col">
                                                        <label
                                                            class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                            Quantité
                                                        </label>
                                                        <input type="number" name="quantity" value="1" min="1"
                                                            max="{{ $product->quantity }}"
                                                            class="w-24 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
                                                    </div>

                                                    <button type="submit"
                                                        class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold text-sm rounded-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mt-6">
                                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                                        </svg>
                                                        Ajouter au panier
                                                    </button>
                                                </div>
                                            @else
                                                <button type="button" disabled
                                                    class="w-full inline-flex items-center justify-center px-6 py-3 bg-gray-300 dark:bg-gray-600 text-gray-500 dark:text-gray-400 font-semibold rounded-lg cursor-not-allowed">
                                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                    Rupture de stock
                                                </button>
                                            @endif
                                        </form>
                                    @endif
                                @endauth

                                {{-- Navigation and Admin Actions --}}
                                <div class="flex gap-3">
                                    <a href="{{ route('products.index') }}"
                                        class="flex-1 text-center px-6 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 transition">
                                        ← Back to Products
                                    </a>

                                    @auth
                                        @if (auth()->user()->isAdmin())
                                            <form action="{{ route('admin.products.destroy', $product->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this product?');"
                                                class="flex-1">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="w-full px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold text-sm rounded-md transition">
                                                    Delete Product
                                                </button>
                                            </form>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Related Products --}}
            @if ($relatedProducts->count() > 0)
                <div class="mt-12">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">Related Products</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach ($relatedProducts as $relatedProduct)
                            <a href="{{ route('products.show', $relatedProduct->id) }}" class="group">
                                <div
                                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow duration-200">
                                    <div class="aspect-square bg-gray-100 dark:bg-gray-700">
                                        @if ($relatedProduct->image)
                                            <img src="{{ asset('storage/' . $relatedProduct->image) }}"
                                                alt="{{ $relatedProduct->title }}"
                                                class="w-full h-full object-cover group-hover:opacity-90 transition-opacity">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <svg class="w-16 h-16 text-gray-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="p-4">
                                        <h3
                                            class="font-semibold text-gray-900 dark:text-gray-100 group-hover:text-gray-600 dark:group-hover:text-gray-300">
                                            {{ $relatedProduct->title }}
                                        </h3>
                                        <p class="text-lg font-bold text-gray-900 dark:text-gray-100 mt-2">
                                            ${{ number_format($relatedProduct->price, 2) }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
