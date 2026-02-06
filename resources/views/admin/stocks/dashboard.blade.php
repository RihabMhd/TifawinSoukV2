                    
                    <script src="https://cdn.tailwindcss.com"></script>
                    @foreach($product_rupture as $product)
                            <div class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <p class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                      title :  {{ $product->title }} 
                                    </div>
                                </p>
                                <p class="px-6 py-4">
                                    <div class="text-sm text-gray-700 dark:text-gray-300 max-w-xs truncate">
                                     description :   {{ $product->description ?? 'No description' }}
                                    </div>
                                </p>
                                <p class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                      price :  {{ $product->price }} 
                                    </span>
                                </p>
                                <p class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-700 dark:text-gray-300">
                                      quantity :  {{ $product->quantity }}
                                    </div>
                                </p>
                                <p class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                </p>
                            </div>
                            @endforeach
                    @foreach($product_stock_critique as $product)
                            <div class="hover:bg-red-50 dark:hover:bg-red-700">
                                <p class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                      title :  {{ $product->title }} 
                                    </div>
                                </p>
                                <p class="px-6 py-4">
                                    <div class="text-sm text-gray-700 dark:text-gray-300 max-w-xs truncate">
                                     description :   {{ $product->description ?? 'No description' }}
                                    </div>
                                </p>
                                <p class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                      price :  {{ $product->price }} 
                                    </span>
                                </p>
                                <p class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-700 dark:text-gray-300">
                                      quantity :  {{ $product->quantity }}
                                    </div>
                                </p>
                                <p class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                </p>
                            </div>
                            @endforeach
                            <div class="hover:bg-red-50 dark:hover:bg-red-700">
                                <p class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                      total :  {{ $product_valeur_inventaire }} 
                                    </div>
                                </p>
                              
                            </div>
