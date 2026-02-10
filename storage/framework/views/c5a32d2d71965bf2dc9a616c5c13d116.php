<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\AppLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                <?php echo e(__('Products')); ?>

            </h2>
            <?php if(auth()->guard()->check()): ?>
                <?php if(auth()->user()->isAdmin()): ?>
                    <a href="<?php echo e(route('admin.products.create')); ?>"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                        <?php echo e(__('Add Product')); ?>

                    </a>
                <?php endif; ?>
            <?php endif; ?>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <?php if(session('success')): ?>
                <div
                    class="mb-4 px-4 py-3 rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800">
                    <p class="text-sm text-green-800 dark:text-green-200"><?php echo e(session('success')); ?></p>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div
                    class="mb-4 px-4 py-3 rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800">
                    <p class="text-sm text-red-800 dark:text-red-200"><?php echo e(session('error')); ?></p>
                </div>
            <?php endif; ?>

    

            
            <?php if($products->count()): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow duration-300">
                            <div class="p-6">
                                <?php if($product->image): ?>
                                    <div class="mb-4 overflow-hidden rounded-lg bg-gray-100 dark:bg-gray-700">
                                        <img src="<?php echo e(asset('storage/' . $product->image)); ?>" alt="<?php echo e($product->title); ?>"
                                            class="w-full h-48 object-cover hover:scale-105 transition-transform duration-300">
                                    </div>
                                <?php endif; ?>

                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">
                                    <?php echo e($product->title); ?>

                                </h3>

                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                                    <?php echo e($product->category->title); ?>

                                </p>

                                <?php if($product->description): ?>
                                    <p class="text-sm text-gray-700 dark:text-gray-300 mb-3 line-clamp-2">
                                        <?php echo e($product->description); ?>

                                    </p>
                                <?php endif; ?>

                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-xl font-bold text-gray-900 dark:text-gray-100">
                                        $<?php echo e(number_format($product->price, 2)); ?>

                                    </span>

                                    <a href="<?php echo e(route('products.show', $product->id)); ?>"
                                        class="text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 font-medium">
                                        View Details →
                                    </a>
                                </div>

                                
                                <?php if(!auth()->check() || !auth()->user()->isAdmin()): ?>
                                    <form action="<?php echo e(route('cart.add', $product->id)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>

                                        <?php if($product->quantity > 0): ?>
                                            <div class="flex items-center gap-2 mb-2">
                                                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Qté:</label>
                                                <input type="number" name="quantity" min="1"
                                                    max="<?php echo e($product->quantity); ?>" value="1"
                                                    class="w-20 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 text-sm" />

                                                <button type="submit"
                                                    class="flex-1 inline-flex items-center justify-center px-4 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                                    </svg>
                                                    Ajouter au panier
                                                </button>
                                            </div>

                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                <span class="font-medium text-green-600 dark:text-green-400">✓</span> 
                                                <?php echo e($product->quantity); ?> en stock
                                            </p>
                                        <?php else: ?>
                                            <button type="button" disabled
                                                class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-gray-300 dark:bg-gray-600 text-gray-500 dark:text-gray-400 font-medium rounded-lg cursor-not-allowed">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                                Rupture de stock
                                            </button>
                                        <?php endif; ?>
                                    </form>
                                <?php endif; ?>

                                
                                <?php if(auth()->guard()->check()): ?>
                                    <?php if(auth()->user()->isAdmin()): ?>
                                        <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700 flex gap-2">
                                            <a href="<?php echo e(route('admin.products.edit', $product->id)); ?>"
                                                class="flex-1 text-center px-3 py-2 text-xs bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-400 font-medium rounded hover:bg-indigo-200 dark:hover:bg-indigo-900/50 transition">
                                                Edit
                                            </a>
                                            <form action="<?php echo e(route('admin.products.destroy', $product->id)); ?>"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this product?');"
                                                class="flex-1">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit"
                                                    class="w-full px-3 py-2 text-xs bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 font-medium rounded hover:bg-red-200 dark:hover:bg-red-900/50 transition">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

               
            <?php else: ?>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                            <?php if(request('search') || request('category_id')): ?>
                                Aucun produit trouvé
                            <?php else: ?>
                                No products
                            <?php endif; ?>
                        </h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            <?php if(request('search') || request('category_id')): ?>
                                Essayez de modifier vos critères de recherche ou de filtrage.
                            <?php else: ?>
                                Get started by creating a new product.
                            <?php endif; ?>
                        </p>
                        <?php if(auth()->guard()->check()): ?>
                            <?php if(auth()->user()->isAdmin() && !request('search') && !request('category_id')): ?>
                                <div class="mt-6">
                                    <a href="<?php echo e(route('admin.products.create')); ?>"
                                        class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white">
                                        Add Product
                                    </a>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\TifawinSoukV2\resources\views/products/index.blade.php ENDPATH**/ ?>