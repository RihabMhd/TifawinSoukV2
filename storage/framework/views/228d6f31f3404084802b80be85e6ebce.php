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
            <?php echo e(__('Mes Commandes')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Messages de succès/erreur -->
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

            <!-- Pas de commandes -->
            <?php if($orders->isEmpty()): ?>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>

                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                            Aucune commande
                        </h3>

                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Vous n'avez pas encore passé de commande.
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

            <!-- Liste des commandes -->
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
                            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                        <?php echo e($order->order_number); ?>

                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        <?php echo e($order->created_at->format('d/m/Y')); ?>

                                    </div>
                                    <div class="text-xs text-gray-400 dark:text-gray-500">
                                        <?php echo e($order->created_at->format('H:i')); ?>

                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                               bg-<?php echo e($order->statusColor); ?>-100 dark:bg-<?php echo e($order->statusColor); ?>-900/20 
                                               text-<?php echo e($order->statusColor); ?>-800 dark:text-<?php echo e($order->statusColor); ?>-200">
                                        <?php echo e($order->statusLabel); ?>

                                    </span>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                        $<?php echo e(number_format($order->total, 2)); ?>

                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        <?php echo e($order->items->count()); ?> article<?php echo e($order->items->count() > 1 ? 's' : ''); ?>

                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end gap-2">
                                        <a href="<?php echo e(route('orders.show', $order)); ?>"
                                           class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                            Détails
                                        </a>

                                        <?php if($order->status === 'pending'): ?>
                                        <form method="POST"
                                              action="<?php echo e(route('orders.cancel', $order)); ?>"
                                              onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette commande ?');"
                                              class="inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PATCH'); ?>
                                            <button type="submit"
                                                    class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                                Annuler
                                            </button>
                                        </form>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <?php if($orders->hasPages()): ?>
                <div class="px-6 py-4 border-t dark:border-gray-700">
                    <?php echo e($orders->links()); ?>

                </div>
                <?php endif; ?>
            </div>

            <?php endif; ?>

            <!-- Statistiques rapides -->
            <?php if($orders->isNotEmpty()): ?>
            <div class="mt-6 grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500 dark:text-gray-400">Total des commandes</div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 mt-1">
                        <?php echo e(auth()->user()->orders->count()); ?>

                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500 dark:text-gray-400">En attente</div>
                    <div class="text-2xl font-bold text-yellow-600 dark:text-yellow-400 mt-1">
                        <?php echo e(auth()->user()->orders->where('status', 'pending')->count()); ?>

                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500 dark:text-gray-400">Livrées</div>
                    <div class="text-2xl font-bold text-green-600 dark:text-green-400 mt-1">
                        <?php echo e(auth()->user()->orders->where('status', 'delivered')->count()); ?>

                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500 dark:text-gray-400">Montant total</div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 mt-1">
                        $<?php echo e(number_format(auth()->user()->orders->sum('total'), 2)); ?>

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
<?php endif; ?><?php /**PATH C:\laragon\www\TifawinSouk-E-com\resources\views/orders/index.blade.php ENDPATH**/ ?>