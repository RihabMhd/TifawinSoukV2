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
                <?php echo e($product->title); ?>

            </h2>
            <?php if(auth()->guard()->check()): ?>
                <?php if(auth()->user()->isAdmin()): ?>
                    <div class="flex gap-2">
                        <a href="<?php echo e(route('admin.products.edit', $product->id)); ?>"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white">
                            Edit
                        </a>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                        <div class="aspect-square bg-gray-100 dark:bg-gray-700 rounded-lg overflow-hidden">
                            <?php if($product->image): ?>
                                <img src="<?php echo e(asset('storage/' . $product->image)); ?>" alt="<?php echo e($product->title); ?>"
                                    class="w-full h-full object-cover">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-32 h-32 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                            <?php endif; ?>
                        </div>


                        <div class="flex flex-col">
                            <div class="flex-1">
                                <div class="mb-4">
                                    <span
                                        class="inline-block px-3 py-1 text-sm font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-full">
                                        <?php echo e($product->category->title); ?>

                                    </span>
                                </div>

                                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                                    <?php echo e($product->title); ?>

                                </h1>

                                <div class="text-4xl font-bold text-gray-900 dark:text-gray-100 mb-6">
                                    $<?php echo e(number_format($product->price, 2)); ?>

                                </div>

                                <?php if($product->description): ?>
                                    <div class="prose dark:prose-invert max-w-none mb-6">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">
                                            Description</h3>
                                        <p class="text-gray-700 dark:text-gray-300"><?php echo e($product->description); ?></p>
                                    </div>
                                <?php endif; ?>

                                <div class="border-t border-gray-200 dark:border-gray-700 pt-6 mt-6">
                                    <dl class="grid grid-cols-1 gap-4">
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Created by
                                            </dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                                <?php echo e($product->user->name); ?></dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Listed on
                                            </dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                                <?php echo e($product->created_at->format('F j, Y')); ?></dd>
                                        </div>
                                    </dl>
                                </div>
                            </div>


                            <div class="flex gap-4 mt-8">
                                <a href="<?php echo e(route('products.index')); ?>"
                                    class="flex-1 text-center px-6 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    Back to Products
                                </a>

                                <?php if(auth()->guard()->check()): ?>
                                    <?php if(auth()->user()->isAdmin()): ?>
                                        <form action="<?php echo e(route('admin.products.destroy', $product->id)); ?>" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this product?');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit"
                                                class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold text-sm rounded-md">
                                                Delete Product
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <form action="<?php echo e(route('cart.add', $product->id)); ?>" method="POST" class="mt-6">
                                    <?php echo csrf_field(); ?>
                                    <div class="flex items-center gap-4">
                                        <input type="number" name="quantity" value="1" min="1"
                                            class="w-20 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded px-3 py-2">

                                        <button type="submit"
                                            class="flex-1 px-6 py-3 bg-blue-600 text-white rounded hover:bg-blue-700 font-semibold">
                                            Ajouter au panier
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <?php if($relatedProducts->count() > 0): ?>
                <div class="mt-12">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">Related Products</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        <?php $__currentLoopData = $relatedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relatedProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(route('products.show', $relatedProduct->id)); ?>" class="group">
                                <div
                                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow duration-200">
                                    <div class="aspect-square bg-gray-100 dark:bg-gray-700">
                                        <?php if($relatedProduct->image): ?>
                                            <img src="<?php echo e(asset('storage/' . $relatedProduct->image)); ?>"
                                                alt="<?php echo e($relatedProduct->title); ?>"
                                                class="w-full h-full object-cover group-hover:opacity-90 transition-opacity">
                                        <?php else: ?>
                                            <div class="w-full h-full flex items-center justify-center">
                                                <svg class="w-16 h-16 text-gray-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="p-4">
                                        <h3
                                            class="font-semibold text-gray-900 dark:text-gray-100 group-hover:text-gray-600 dark:group-hover:text-gray-300">
                                            <?php echo e($relatedProduct->title); ?>

                                        </h3>
                                        <p class="text-lg font-bold text-gray-900 dark:text-gray-100 mt-2">
                                            $<?php echo e(number_format($relatedProduct->price, 2)); ?>

                                        </p>
                                    </div>
                                </div>
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
<?php endif; ?>
<?php /**PATH C:\laragon\www\TifawinSouk-E-com\resources\views/products/show.blade.php ENDPATH**/ ?>