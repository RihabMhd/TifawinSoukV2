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
            <?php echo e(__('Confirmation de commande')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <!-- Message de succès -->
            <?php if(session('success')): ?>
                <div class="mb-6 px-6 py-4 rounded-lg bg-green-50 dark:bg-green-900/20 border-2 border-green-200 dark:border-green-800">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-green-800 dark:text-green-200 font-medium">
                            <?php echo e(session('success')); ?>

                        </p>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Détails de la commande -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                
                <!-- En-tête -->
                <div class="p-6 border-b dark:border-gray-700">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                Commande #<?php echo e($order->order_number); ?>

                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                Passée le <?php echo e($order->created_at->format('d/m/Y à H:i')); ?>

                            </p>
                        </div>
                        
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                   bg-<?php echo e($order->statusColor); ?>-100 dark:bg-<?php echo e($order->statusColor); ?>-900/20 
                                   text-<?php echo e($order->statusColor); ?>-800 dark:text-<?php echo e($order->statusColor); ?>-200">
                            <?php echo e($order->statusLabel); ?>

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
                                <?php echo e($order->first_name); ?> <?php echo e($order->last_name); ?>

                            </p>
                            <p><?php echo e($order->address); ?></p>
                            <?php if($order->address_complement): ?>
                                <p><?php echo e($order->address_complement); ?></p>
                            <?php endif; ?>
                            <p><?php echo e($order->postal_code); ?> <?php echo e($order->city); ?></p>
                            <p><?php echo e($order->country); ?></p>
                            <p class="pt-2">
                                <span class="font-medium">Tél:</span> <?php echo e($order->phone); ?>

                            </p>
                            <p>
                                <span class="font-medium">Email:</span> <?php echo e($order->email); ?>

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
                                <?php echo e($order->paymentMethodLabel); ?>

                            </p>
                            <p>
                                <span class="font-medium text-gray-900 dark:text-gray-100">Statut:</span>
                                <span class="capitalize"><?php echo e($order->payment_status); ?></span>
                            </p>
                        </div>

                        <?php if($order->order_notes): ?>
                        <div class="mt-4">
                            <h4 class="font-semibold text-gray-900 dark:text-gray-100 mb-2">
                                Notes de commande
                            </h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-gray-700 p-3 rounded">
                                <?php echo e($order->order_notes); ?>

                            </p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Produits commandés -->
                <div class="p-6 border-b dark:border-gray-700">
                    <h4 class="font-semibold text-gray-900 dark:text-gray-100 mb-4">
                        Produits commandés
                    </h4>

                    <div class="space-y-4">
                        <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-center gap-4 pb-4 border-b dark:border-gray-700 last:border-0">
                            <?php if($item->product->image): ?>
                            <img src="<?php echo e(asset('storage/' . $item->product->image)); ?>"
                                 class="w-20 h-20 rounded object-cover"
                                 alt="<?php echo e($item->product->title ?? $item->product->name); ?>">
                            <?php else: ?>
                            <div class="w-20 h-20 bg-gray-200 dark:bg-gray-700 rounded flex items-center justify-center">
                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <?php endif; ?>

                            <div class="flex-1">
                                <h5 class="font-medium text-gray-900 dark:text-gray-100">
                                    <?php echo e($item->product->title ?? $item->product->name); ?>

                                </h5>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Quantité: <?php echo e($item->quantity); ?> × $<?php echo e(number_format($item->price, 2)); ?>

                                </p>
                            </div>

                            <div class="font-semibold text-gray-900 dark:text-gray-100">
                                $<?php echo e(number_format($item->subtotal, 2)); ?>

                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <!-- Résumé des totaux -->
                <div class="p-6 bg-gray-50 dark:bg-gray-900">
                    <div class="max-w-md ml-auto space-y-2">
                        <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400">
                            <span>Sous-total</span>
                            <span>$<?php echo e(number_format($order->subtotal, 2)); ?></span>
                        </div>

                        <?php if($order->shipping > 0): ?>
                        <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400">
                            <span>Livraison</span>
                            <span>$<?php echo e(number_format($order->shipping, 2)); ?></span>
                        </div>
                        <?php else: ?>
                        <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400">
                            <span>Livraison</span>
                            <span class="text-green-600">Gratuite</span>
                        </div>
                        <?php endif; ?>

                        <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400">
                            <span>TVA (20%)</span>
                            <span>$<?php echo e(number_format($order->tax, 2)); ?></span>
                        </div>

                        <hr class="my-2 dark:border-gray-700">

                        <div class="flex justify-between text-xl font-bold text-gray-900 dark:text-gray-100">
                            <span>Total</span>
                            <span>$<?php echo e(number_format($order->total, 2)); ?></span>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="p-6 bg-white dark:bg-gray-800 flex justify-between">
                    <a href="<?php echo e(route('orders.index')); ?>"
                       class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600">
                        Voir mes commandes
                    </a>

                    <a href="<?php echo e(route('products.index')); ?>"
                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Continuer mes achats
                    </a>
                </div>

            </div>

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
<?php endif; ?><?php /**PATH C:\laragon\www\TifawinSouk-E-com\resources\views/orders/show.blade.php ENDPATH**/ ?>