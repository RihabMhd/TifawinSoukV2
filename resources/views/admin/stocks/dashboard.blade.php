<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-black ">

<div class="max-w-6xl mx-auto bg-gray-700 rounded-lg shadow-sm">

    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-gray-700">
        <h2 class="text-lg font-semibold text-white ">
            Total price touts les produits : {{ $product_valeur_inventaire }} $
        </h2>

        <select id="stockFilter"
            class="rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 text-sm focus:ring-indigo-500 focus:border-indigo-500">
            <option value="all">All</option>
            <option value="rupture">Rupture</option>
            <option value="critical">Stock critique</option>
        </select>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200  text-sm">
            <thead class="bg-gray-50 ">
                <tr>
                    <th class="bg-black px-6 py-3 text-left font-medium text-white ">Product</th>
                    <th class="bg-black px-6 py-3 text-left font-medium text-white ">Price</th>
                    <th class="bg-black px-6 py-3 text-left font-medium text-white ">Quantity</th>
                    <th class="bg-black px-6 py-3 text-left font-medium text-white ">Status</th>
                </tr>
            </thead>

            <tbody id="productTable" class="bg-gray-900  divide-y  text-white">

                @foreach($product_rupture as $product)
                <tr data-status="rupture">
                    <td class="px-6 py-4 text-white">
                        {{ $product->title }}
                    </td>
                    <td class="px-6 py-4 text-white">
                        {{ $product->price }}
                    </td>
                    <td class="px-6 py-4 text-white">
                        {{ $product->quantity }}
                    </td>
                    <td class="px-6 py-4 ">
                        <span class="inline-flex px-2 py-0.5 text-xs rounded-md bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300">
                            Rupture
                        </span>
                    </td>
                </tr>
                @endforeach

                @foreach($product_stock_critique as $product)
                <tr data-status="critical">
                    <td class="px-6 py-4 ">
                        {{ $product->title }}
                    </td>
                    <td class="px-6 py-4 ">
                        {{ $product->price }}
                    </td>
                    <td class="px-6 py-4 ">
                        {{ $product->quantity }}
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex px-2 py-0.5 text-xs rounded-md bg-yellow-100 text-yellow-700 dark:bg-yellow-900/40 dark:text-yellow-300">
                            Stock critique
                        </span>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>

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

</body>
</html>
