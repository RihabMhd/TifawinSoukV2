<x-app-layout>
    {{-- ===== HEADER ===== --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- ================= KPI CARDS ================= --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                {{-- CA du jour --}}
                <div class="bg-green-500 text-white rounded-lg p-6 shadow">
                    <p class="text-sm">CA du jour</p>
                    <p class="text-2xl font-bold">{{ $revenueToday }} MAD</p>
                </div>

                {{-- Commandes du jour --}}
                <div class="bg-blue-500 text-white rounded-lg p-6 shadow">
                    <p class="text-sm">Commandes du jour</p>
                    <p class="text-2xl font-bold">{{ $ordersToday }}</p>
                </div>

                {{-- En attente --}}
                <div class="bg-yellow-400 text-gray-900 rounded-lg p-6 shadow">
                    <p class="text-sm">En attente</p>
                    <p class="text-2xl font-bold">{{ $pendingOrders }}</p>
                </div>

                {{-- Total mois --}}
                <div class="bg-gray-600 text-white rounded-lg p-6 shadow">
                    <p class="text-sm">Total mois</p>
                    <p class="text-2xl font-bold">{{ $ordersThisMonth }}</p>
                </div>

            </div>

            {{-- ================= GRAPHIQUES ================= --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- Line chart --}}
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                    <h3 class="font-semibold mb-4 text-gray-800 dark:text-gray-200">
                        Ventes – 7 derniers jours
                    </h3>
                    <canvas id="salesChart"></canvas>
                </div>

                {{-- Doughnut chart --}}
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                    <h3 class="font-semibold mb-4 text-gray-800 dark:text-gray-200">
                        Statut des commandes
                    </h3>
                    <canvas id="statusChart"></canvas>
                </div>

            </div>

            {{-- Bar chart --}}
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                <h3 class="font-semibold mb-4 text-gray-800 dark:text-gray-200">
                    Top 5 produits vendus
                </h3>
                <canvas id="productsChart"></canvas>
            </div>

            {{-- ================= TABLE ================= --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                <div class="p-6 flex justify-between items-center">
                    <h3 class="font-semibold text-gray-800 dark:text-gray-200">
                        Dernières commandes
                    </h3>
                    <a href="{{ route('admin.orders.index') }}"
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
                            @foreach($recentOrders as $order)
                            <tr class="border-t dark:border-gray-700">
                                <td class="px-6 py-3">{{ $order->id }}</td>
                                <td class="px-6 py-3">{{ $order->total_amount }} MAD</td>
                                <td class="px-6 py-3">{{ $order->status }}</td>
                                <td class="px-6 py-3">{{ $order->created_at->format('d/m/Y') }}</td>
                                <td class="px-6 py-3">
                                    <a href="{{ route('admin.orders.show', $order) }}"
                                       class="text-indigo-600 hover:underline">
                                        Détail
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    {{-- ================= CHART.JS ================= --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Line chart
        new Chart(document.getElementById('salesChart'), {
            type: 'line',
            data: {
                labels: @json($chartLabels),
                datasets: [{
                    label: 'CA',
                    data: @json($chartData),
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.3
                }]
            }
        });

        // Doughnut chart
        new Chart(document.getElementById('statusChart'), {
            type: 'doughnut',
            data: {
                labels: @json($statusLabels),
                datasets: [{
                    data: @json($statusData),
                    backgroundColor: ['#facc15', '#22c55e', '#ef4444']
                }]
            }
        });

        // Bar chart
        new Chart(document.getElementById('productsChart'), {
            type: 'bar',
            data: {
                labels: @json($topProducts->pluck('product_name')),
                datasets: [{
                    label: 'Quantité vendue',
                    data: @json($topProducts->pluck('total_sold')),
                    backgroundColor: '#6366f1'
                }]
            }
        });
    </script>
</x-app-layout>
