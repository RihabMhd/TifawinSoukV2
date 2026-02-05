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
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <?php echo e(__('Mon Panier')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

          
            <?php if(session('success')): ?>
                <div class="mb-4 px-4 py-3 rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800">
                    <p class="text-sm text-green-800 dark:text-green-200">
                        <?php echo e(session('success')); ?>

                    </p>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="mb-4 px-4 py-3 rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800">
                    <p class="text-sm text-red-800 dark:text-red-200">
                        <?php echo e(session('error')); ?>

                    </p>
                </div>
            <?php endif; ?>

           
            <?php if($cart->items->isEmpty()): ?>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 9m12-9l2 9M9 22h6"/>
                        </svg>

                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                            Votre panier est vide
                        </h3>

                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Parcourez les produits et ajoutez-les à votre panier.
                        </p>

                        <div class="mt-6">
                            <a href="<?php echo e(route('products.index')); ?>"
                               class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 text-white dark:text-gray-800 rounded-md text-xs font-semibold uppercase hover:bg-gray-700 dark:hover:bg-white">
                                Découvrir les produits
                            </a>
                        </div>
                    </div>
                </div>
            <?php else: ?>

            
            <div class="grid grid-cols-1 lg:grid-cols-10 gap-6">

               
                <div class="lg:col-span-7 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-100 dark:bg-gray-700 text-sm uppercase">
                                <tr>
                                    <th class="p-4 text-left">Produit</th>
                                    <th class="p-4 text-center">Prix</th>
                                    <th class="p-4 text-center">Quantité</th>
                                    <th class="p-4 text-center">Sous-total</th>
                                    <th class="p-4"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $cart->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="border-t dark:border-gray-700">
                                    <td class="p-4">
                                        <div class="flex items-center gap-4">
                                            <?php if($item->product->image): ?>
                                            <img src="<?php echo e(asset('storage/' . $item->product->image)); ?>"
                                                 class="w-16 h-16 rounded object-cover"
                                                 alt="<?php echo e($item->product->title ?? $item->product->name); ?>">
                                            <?php else: ?>
                                            <div class="w-16 h-16 bg-gray-200 dark:bg-gray-700 rounded flex items-center justify-center">
                                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                            <?php endif; ?>

                                            <div>
                                                <a href="<?php echo e(route('products.show', $item->product)); ?>"
                                                   class="font-medium text-gray-900 dark:text-gray-100 hover:underline">
                                                    <?php echo e($item->product->title ?? $item->product->name); ?>

                                                </a>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="p-4 text-center text-gray-700 dark:text-gray-300">
                                        $<?php echo e(number_format($item->price_at_addition, 2)); ?>

                                    </td>

                                    <td class="p-4 text-center">
                                        <form method="POST"
                                              action="<?php echo e(route('cart.update', $item)); ?>"
                                              class="flex justify-center gap-2">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PATCH'); ?>

                                            <input type="number"
                                                   name="quantity"
                                                   min="1"
                                                   value="<?php echo e($item->quantity); ?>"
                                                   class="w-20 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded text-center">

                                            <button type="submit" class="px-3 py-1 text-xs bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded hover:bg-gray-200 dark:hover:bg-gray-600">
                                                Modifier
                                            </button>
                                        </form>
                                    </td>

                                    <td class="p-4 text-center font-semibold text-gray-900 dark:text-gray-100">
                                        $<?php echo e(number_format($item->getSubtotal(), 2)); ?>

                                    </td>

                                    <td class="p-4 text-center">
                                        <form method="POST"
                                              action="<?php echo e(route('cart.remove', $item)); ?>"
                                              onsubmit="return confirm('Supprimer ce produit du panier ?');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>

                                            <button type="submit" class="text-red-600 hover:text-red-800 text-xl font-bold">
                                                ×
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>

             
                <div class="lg:col-span-3">
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 sticky top-24">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                            Résumé de la commande
                        </h3>

                        <div class="flex justify-between text-sm mb-2 text-gray-700 dark:text-gray-300">
                            <span>Sous-total</span>
                            <span>$<?php echo e(number_format($cart->getTotal(), 2)); ?></span>
                        </div>

                        <div class="flex justify-between text-sm mb-2 text-gray-700 dark:text-gray-300">
                            <span>Livraison</span>
                            <span class="text-green-600">Gratuite</span>
                        </div>

                        <hr class="my-4 dark:border-gray-700">

                        <div class="flex justify-between text-xl font-bold mb-6 text-gray-900 dark:text-gray-100">
                            <span>Total</span>
                            <span>$<?php echo e(number_format($cart->getTotal(), 2)); ?></span>
                        </div>

                        <?php if(auth()->guard()->check()): ?>
                            <?php if(auth()->user()->role_id == 3): ?>
                                <a href="<?php echo e(route('checkout.index')); ?>"
                                   class="block w-full text-center px-4 py-3 bg-green-600 text-white rounded-md hover:bg-green-700 font-semibold">
                                    Passer la commande
                                </a>
                            <?php else: ?>
                                <div class="block w-full text-center px-4 py-3 bg-gray-300 text-gray-600 rounded-md cursor-not-allowed">
                                    Seuls les clients peuvent commander
                                </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <a href="<?php echo e(route('login')); ?>"
                               class="block w-full text-center px-4 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 font-semibold">
                                Se connecter pour commander
                            </a>
                        <?php endif; ?>

                        <form method="POST"
                              action="<?php echo e(route('cart.clear')); ?>"
                              class="mt-4"
                              onsubmit="return confirm('Voulez-vous vraiment vider le panier ?');">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>

                            <button type="submit" class="w-full text-sm text-red-600 hover:underline">
                                Vider le panier
                            </button>
                        </form>
                    </div>
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
<?php endif; ?><?php /**PATH C:\laragon\www\TifawinSouk-E-com\resources\views/cart/index.blade.php ENDPATH**/ ?>