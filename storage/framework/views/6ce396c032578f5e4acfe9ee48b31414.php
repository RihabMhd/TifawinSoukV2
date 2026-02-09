<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Dashboard</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-black min-h-screen p-6">

<div class="max-w-6xl mx-auto bg-gray-700 rounded-lg shadow-sm">

    <!-- HEADER -->
    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-600">
        <h2 class="text-lg font-semibold text-white">
            Total price tous les produits :
            <span class="text-green-400">
                <?php echo e($product_valeur_inventaire); ?> $
            </span>
        </h2>

        <select id="stockFilter"
            class="rounded-md bg-gray-800 border-gray-600 text-gray-200 text-sm focus:ring-indigo-500 focus:border-indigo-500">
            <option value="all">All</option>
            <option value="rupture">Rupture</option>
            <option value="critical">Stock critique</option>
        </select>
    </div>

    <!-- CHART -->
    <div class="p-6 bg-gray-800 h-80 w-full flex justify-center">
        <canvas id="stockChart" height="50"></canvas>
    </div>

    <!-- TABLE -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-700 text-sm">
            <thead class="bg-black">
                <tr>
                    <th class="px-6 py-3 text-left font-medium text-white">Product</th>
                    <th class="px-6 py-3 text-left font-medium text-white">Price</th>
                    <th class="px-6 py-3 text-left font-medium text-white">Quantity</th>
                    <th class="px-6 py-3 text-left font-medium text-white">Status</th>
                </tr>
            </thead>

            <tbody id="productTable" class="bg-gray-900 divide-y divide-gray-800 text-white">

                <!-- RUPTURE -->
                <?php $__currentLoopData = $product_rupture; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr data-status="rupture">
                    <td class="px-6 py-4"><?php echo e($product->title); ?></td>
                    <td class="px-6 py-4"><?php echo e($product->price); ?></td>
                    <td class="px-6 py-4"><?php echo e($product->quantity); ?></td>
                    <td class="px-6 py-4">
                        <span class="inline-flex px-2 py-0.5 text-xs rounded-md
                            bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300">
                            Rupture
                        </span>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <!-- CRITICAL -->
                <?php $__currentLoopData = $product_stock_critique; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr data-status="critical">
                    <td class="px-6 py-4"><?php echo e($product->title); ?></td>
                    <td class="px-6 py-4"><?php echo e($product->price); ?></td>
                    <td class="px-6 py-4"><?php echo e($product->quantity); ?></td>
                    <td class="px-6 py-4">
                        <span class="inline-flex px-2 py-0.5 text-xs rounded-md
                            bg-yellow-100 text-yellow-700 dark:bg-yellow-900/40 dark:text-yellow-300">
                            Stock critique
                        </span>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </tbody>
        </table>
    </div>
</div>

<!-- FILTER TABLE -->
<script>
document.getElementById('stockFilter').addEventListener('change', function () {
    const value = this.value;
    const rows = document.querySelectorAll('#productTable tr');

    rows.forEach(row => {
        if (value === 'all' || row.dataset.status === value) {
            row.classList.remove('hidden');
        } else {
            row.classList.add('hidden');
        }
    });
});
</script>

<!-- CHART SCRIPT -->
<script>
    const ruptureCount = <?php echo e(count($product_rupture)); ?>;
    const criticalCount = <?php echo e(count($product_stock_critique)); ?>;

    const ctx = document.getElementById('stockChart').getContext('2d');

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Rupture', 'Stock critique'],
            datasets: [{
                label: 'Produits',
                data: [ruptureCount, criticalCount],
                backgroundColor: [
                    'rgba(239, 68, 68, 0.8)',
                    'rgba(234, 179, 8, 0.8)'
                ],
                borderColor: [
                    'rgba(239, 68, 68, 1)',
                    'rgba(234, 179, 8, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            plugins: {
                legend: {
                    labels: {
                        color: 'white'
                    }
                }
            }
        }
    });
</script>

</body>
</html>
<?php /**PATH C:\laragon\www\TifawinSoukV2\resources\views/admin/stocks/dashboard.blade.php ENDPATH**/ ?>