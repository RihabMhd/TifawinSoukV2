<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Adjust Stock - ') }} {{ $product->title }}
            </h2>
            <a href="{{ route('admin.stock.dashboard') }}" 
               class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Success Message -->
            @if(session('success'))
            <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-600 dark:text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <p class="text-sm text-green-800 dark:text-green-200">{{ session('success') }}</p>
                </div>
            </div>
            @endif

            <!-- Error Message -->
            @if(session('error'))
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-red-600 dark:text-red-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-sm text-red-800 dark:text-red-200">{{ session('error') }}</p>
                </div>
            </div>
            @endif

            <!-- Product Information Card -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Product Details</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Product Name</dt>
                                <dd class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $product->title }}</dd>
                            </div>
                            
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Description</dt>
                                <dd class="mt-1 text-gray-700 dark:text-gray-300">
                                    {{ $product->description ?? 'No description available' }}
                                </dd>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-4 border border-green-200 dark:border-green-800">
                                <dt class="text-sm font-medium text-green-800 dark:text-green-300">Current Price</dt>
                                <dd class="mt-2 text-3xl font-bold text-green-600 dark:text-green-400">
                                    ${{ number_format($product->price, 2) }}
                                </dd>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4 border border-blue-200 dark:border-blue-800">
                                    <dt class="text-sm font-medium text-blue-800 dark:text-blue-300">Current Stock</dt>
                                    <dd class="mt-2 text-2xl font-bold text-blue-600 dark:text-blue-400">
                                        {{ $product->quantity }}
                                    </dd>
                                </div>
                                <div class="bg-yellow-50 dark:bg-yellow-900/20 rounded-lg p-4 border border-yellow-200 dark:border-yellow-800">
                                    <dt class="text-sm font-medium text-yellow-800 dark:text-yellow-300">Alert Threshold</dt>
                                    <dd class="mt-2 text-2xl font-bold text-yellow-600 dark:text-yellow-400">
                                        {{ $product->stock_alert_threshold }}
                                    </dd>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Adjustment Form -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-6">Stock Adjustment</h3>

                    <form action="{{ route('admin.stock.adjust', $product) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <!-- Quantity Input -->
                            <div>
                                <label for="quantity" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    New Quantity <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input 
                                        type="number" 
                                        name="quantity" 
                                        id="quantity" 
                                        value="{{ old('quantity', $product->quantity) }}"
                                        min="0"
                                        required
                                        class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 
                                               focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 
                                               dark:focus:ring-indigo-600 shadow-sm"
                                        placeholder="Enter new quantity">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                        </svg>
                                    </div>
                                </div>
                                @error('quantity')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                    Current: <span class="font-semibold text-blue-600 dark:text-blue-400">{{ $product->quantity }} units</span>
                                </p>
                            </div>

                            <!-- Stock Alert Threshold Input -->
                            <div>
                                <label for="stock_alert_threshold" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Alert Threshold <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input 
                                        type="number" 
                                        name="stock_alert_threshold" 
                                        id="stock_alert_threshold" 
                                        value="{{ old('stock_alert_threshold', $product->stock_alert_threshold) }}"
                                        min="0"
                                        required
                                        class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 
                                               focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 
                                               dark:focus:ring-indigo-600 shadow-sm"
                                        placeholder="Enter alert threshold">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                        </svg>
                                    </div>
                                </div>
                                @error('stock_alert_threshold')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                    Get notified when stock falls below this level
                                </p>
                            </div>

                        </div>

                        <!-- Info Box -->
                        <div class="mt-6 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h4 class="text-sm font-medium text-blue-800 dark:text-blue-300">Stock Management Tips</h4>
                                    <div class="mt-2 text-sm text-blue-700 dark:text-blue-200">
                                        <ul class="list-disc list-inside space-y-1">
                                            <li>Set alert threshold to 10-20% of average monthly sales</li>
                                            <li>Update quantities after receiving new shipments</li>
                                            <li>Review stock levels weekly to prevent stockouts</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-end gap-3 mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <a href="{{ route('admin.stock.dashboard') }}" 
                               class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Cancel
                            </a>
                            <button 
                                type="submit"
                                class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Update Stock Levels
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

</x-app-layout>
