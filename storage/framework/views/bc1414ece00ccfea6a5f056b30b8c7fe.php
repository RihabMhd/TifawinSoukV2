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
            <?php echo e(__('Admin Dashboard')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                
                <div class="bg-green-500 text-white rounded-lg p-6 shadow">
                    <p class="text-sm">CA du jour</p>
                    <p class="text-2xl font-bold"><?php echo e($revenueToday); ?> MAD</p>
                </div>

                
                <div class="bg-blue-500 text-white rounded-lg p-6 shadow">
                    <p class="text-sm">Commandes du jour</p>
                    <p class="text-2xl font-bold"><?php echo e($ordersToday); ?></p>
                </div>

                
                <div class="bg-yellow-400 text-gray-900 rounded-lg p-6 shadow">
                    <p class="text-sm">En attente</p>
                    <p class="text-2xl font-bold"><?php echo e($pendingOrders); ?></p>
                </div>

                
                <div class="bg-gray-600 text-white rounded-lg p-6 shadow">
                    <p class="text-sm">Total mois</p>
                    <p class="text-2xl font-bold"><?php echo e($ordersThisMonth); ?></p>
                </div>

            </div>

            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                    <h3 class="font-semibold mb-4 text-gray-800 dark:text-gray-200">
                        Ventes – 7 derniers jours
                    </h3>
                    <canvas id="salesChart"></canvas>
                </div>

                
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                    <h3 class="font-semibold mb-4 text-gray-800 dark:text-gray-200">
                        Statut des commandes
                    </h3>
                    <canvas id="statusChart"></canvas>
                </div>

            </div>

            
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                <h3 class="font-semibold mb-4 text-gray-800 dark:text-gray-200">
                    Top 5 produits vendus
                </h3>
                <canvas id="productsChart"></canvas>
            </div>

            
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                <div class="p-6 flex justify-between items-center">
                    <h3 class="font-semibold text-gray-800 dark:text-gray-200">
                        Dernières commandes
                    </h3>
                    <a href="<?php echo e(route('admin.orders.index')); ?>"
                       class="text-sm text-indigo-600 hover:underline">
                        Voir toutes les commandes →
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left">#</th>
                                <th class="px-6 py-3 text-left">Total</th>
                                <th class="px-6 py-3 text-left">Status</th>
                                <th class="px-6 py-3 text-left">Date</th>
                                <th class="px-6 py-3"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="border-t dark:border-gray-700">
                                <td class="px-6 py-3"><?php echo e($order->id); ?></td>
                                <td class="px-6 py-3"><?php echo e($order->total_amount); ?> MAD</td>
                                <td class="px-6 py-3"><?php echo e($order->status); ?></td>
                                <td class="px-6 py-3"><?php echo e($order->created_at->format('d/m/Y')); ?></td>
                                <td class="px-6 py-3">
                                    <a href="<?php echo e(route('admin.orders.show', $order)); ?>"
                                       class="text-indigo-600 hover:underline">
                                        Détail
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Line chart
        new Chart(document.getElementById('salesChart'), {
            type: 'line',
            data: {
                labels: <?php echo json_encode($chartLabels, 15, 512) ?>,
                datasets: [{
                    label: 'CA',
                    data: <?php echo json_encode($chartData, 15, 512) ?>,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.3
                }]
            }
        });

        // Doughnut chart
        new Chart(document.getElementById('statusChart'), {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode($statusLabels, 15, 512) ?>,
                datasets: [{
                    data: <?php echo json_encode($statusData, 15, 512) ?>,
                    backgroundColor: ['#facc15', '#22c55e', '#ef4444']
                }]
            }
        });

        // Bar chart
        new Chart(document.getElementById('productsChart'), {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($topProducts->pluck('product_name'), 15, 512) ?>,
                datasets: [{
                    label: 'Quantité vendue',
                    data: <?php echo json_encode($topProducts->pluck('total_sold'), 15, 512) ?>,
                    backgroundColor: '#6366f1'
                }]
            }
        });
    </script>
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
<?php /**PATH C:\Users\Youcode\Desktop\TifawinSoukV2\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>