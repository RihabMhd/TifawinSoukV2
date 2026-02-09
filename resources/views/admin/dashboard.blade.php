<x-app-layout>
    {{-- ===== HEADER ===== --}}
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Admin Dashboard') }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Bienvenue! Voici un aperçu de votre activité
                </p>
            </div>
            <div class="text-sm text-gray-600 dark:text-gray-400">
                {{ now()->locale('fr')->isoFormat('dddd D MMMM YYYY') }}
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- ================= KPI CARDS ================= --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                {{-- CA du jour --}}
                <div
                    class="group relative bg-gradient-to-br from-green-500 to-emerald-600 text-white rounded-xl p-6 shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-10 rounded-full -mr-16 -mt-16"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-3">
                            <div class="bg-white bg-opacity-20 rounded-lg p-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <span
                                class="text-xs font-semibold bg-white bg-opacity-20 px-2 py-1 rounded-full">Aujourd'hui</span>
                        </div>
                        <p class="text-sm font-medium opacity-90 mb-1">CA du jour</p>
                        <p class="text-3xl font-bold">{{ number_format($revenueToday, 2) }} MAD</p>
                    </div>
                </div>

                {{-- Commandes du jour --}}
                <div
                    class="group relative bg-gradient-to-br from-blue-500 to-indigo-600 text-white rounded-xl p-6 shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-10 rounded-full -mr-16 -mt-16"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-3">
                            <div class="bg-white bg-opacity-20 rounded-lg p-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                            <span
                                class="text-xs font-semibold bg-white bg-opacity-20 px-2 py-1 rounded-full">Aujourd'hui</span>
                        </div>
                        <p class="text-sm font-medium opacity-90 mb-1">Commandes du jour</p>
                        <p class="text-3xl font-bold">{{ $ordersToday }}</p>
                    </div>
                </div>

                {{-- En attente --}}
                <div
                    class="group relative bg-gradient-to-br from-yellow-400 to-orange-500 text-white rounded-xl p-6 shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-10 rounded-full -mr-16 -mt-16"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-3">
                            <div class="bg-white bg-opacity-20 rounded-lg p-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <span class="text-xs font-semibold bg-white bg-opacity-20 px-2 py-1 rounded-full">En
                                cours</span>
                        </div>
                        <p class="text-sm font-medium opacity-90 mb-1">En attente</p>
                        <p class="text-3xl font-bold">{{ $pendingOrders }}</p>
                    </div>
                </div>

                {{-- Total mois --}}
                <div
                    class="group relative bg-gradient-to-br from-purple-500 to-pink-600 text-white rounded-xl p-6 shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-10 rounded-full -mr-16 -mt-16"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-3">
                            <div class="bg-white bg-opacity-20 rounded-lg p-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                            <span class="text-xs font-semibold bg-white bg-opacity-20 px-2 py-1 rounded-full">Ce
                                mois</span>
                        </div>
                        <p class="text-sm font-medium opacity-90 mb-1">Total mois</p>
                        <p class="text-3xl font-bold">{{ $ordersThisMonth }}</p>
                    </div>
                </div>

            </div>

            {{-- ================= GRAPHIQUES ================= --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- Line chart --}}
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-2xl transition-shadow duration-300 overflow-hidden">
                    <div class="bg-gradient-to-r from-cyan-500 to-blue-500 px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-semibold text-white text-lg">
                                    Ventes – 7 derniers jours
                                </h3>
                                <p class="text-cyan-100 text-sm mt-1">Évolution du chiffre d'affaires</p>
                            </div>
                            <div class="bg-white bg-opacity-20 rounded-lg p-2">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <canvas id="salesChart" style="max-height: 300px;"></canvas>
                    </div>
                </div>

                {{-- Doughnut chart --}}
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-2xl transition-shadow duration-300 overflow-hidden">
                    <div class="bg-gradient-to-r from-purple-500 to-pink-500 px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-semibold text-white text-lg">
                                    Statut des commandes
                                </h3>
                                <p class="text-purple-100 text-sm mt-1">Répartition actuelle</p>
                            </div>
                            <div class="bg-white bg-opacity-20 rounded-lg p-2">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <canvas id="statusChart" style="max-height: 300px;"></canvas>
                    </div>
                </div>

            </div>

            {{-- Bar chart --}}
            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-2xl transition-shadow duration-300 overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="font-semibold text-white text-lg">
                                Top 5 produits vendus
                            </h3>
                            <p class="text-indigo-100 text-sm mt-1">Les meilleures ventes du moment</p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-lg p-2">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <canvas id="productsChart" style="max-height: 350px;"></canvas>
                </div>
            </div>

            {{-- ================= TABLE ================= --}}
            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-2xl transition-shadow duration-300 overflow-hidden">
                <div class="bg-gradient-to-r from-gray-700 to-gray-900 px-6 py-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="font-semibold text-white text-lg">
                                Dernières commandes
                            </h3>
                            <p class="text-gray-300 text-sm mt-1">Activité récente</p>
                        </div>
                        <a href="{{ route('admin.orders.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-white bg-opacity-20 hover:bg-opacity-30 text-white text-sm font-medium rounded-lg transition-all duration-200">
                            Voir tout
                            <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-900">
                            <tr>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                    Commande
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                    Total
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                    Status
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                    Date
                                </th>
                                <th
                                    class="px-6 py-4 text-right text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($recentOrders as $order)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="bg-indigo-100 dark:bg-indigo-900 rounded-lg p-2 mr-3">
                                                <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                                </svg>
                                            </div>
                                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                #{{ $order->id }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                            {{ number_format($order->total_amount, 2) }} MAD
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusColors = [
                                                'pending' =>
                                                    'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                                'processing' =>
                                                    'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                                                'completed' =>
                                                    'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                                'cancelled' =>
                                                    'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                            ];
                                            $colorClass =
                                                $statusColors[$order->status] ??
                                                'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200';
                                        @endphp
                                        <span
                                            class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $colorClass }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $order->created_at->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.orders.show', $order) }}"
                                            class="inline-flex items-center text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 transition-colors duration-150">
                                            Voir détails
                                            <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5"
                                        class="px-6 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                                        Aucune commande récente
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    {{-- ================= CHART.JS ================= --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Enhanced Line chart with gradient
        const salesCtx = document.getElementById('salesChart').getContext('2d');
        const salesGradient = salesCtx.createLinearGradient(0, 0, 0, 400);
        salesGradient.addColorStop(0, 'rgba(6, 182, 212, 0.4)');
        salesGradient.addColorStop(1, 'rgba(6, 182, 212, 0.0)');

        new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: @json($chartLabels),
                datasets: [{
                    label: 'CA (MAD)',
                    data: @json($chartData),
                    borderColor: 'rgb(6, 182, 212)',
                    backgroundColor: salesGradient,
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: 'rgb(6, 182, 212)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 13
                        },
                        borderColor: 'rgba(6, 182, 212, 0.5)',
                        borderWidth: 1
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)',
                            drawBorder: false
                        },
                        ticks: {
                            font: {
                                size: 11
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            font: {
                                size: 11
                            }
                        }
                    }
                }
            }
        });

        // Enhanced Doughnut chart
        new Chart(document.getElementById('statusChart'), {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($statusLabels) !!},
                datasets: [{
                    data: {!! json_encode($statusData) !!},
                    backgroundColor: [
                        'rgba(251, 191, 36, 0.8)', // Yellow
                        'rgba(34, 197, 94, 0.8)', // Green
                        'rgba(239, 68, 68, 0.8)', // Red
                    ],
                    borderColor: [
                        'rgba(251, 191, 36, 1)',
                        'rgba(34, 197, 94, 1)',
                        'rgba(239, 68, 68, 1)',
                    ],
                    borderWidth: 2,
                    hoverOffset: 15
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            font: {
                                size: 12
                            },
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 13
                        }
                    }
                },
                cutout: '65%'
            }
        });

        // Enhanced Bar chart with gradient
        const productsCtx = document.getElementById('productsChart').getContext('2d');
        const productsGradient = productsCtx.createLinearGradient(0, 0, 0, 400);
        productsGradient.addColorStop(0, 'rgba(99, 102, 241, 0.8)');
        productsGradient.addColorStop(1, 'rgba(99, 102, 241, 0.2)');

        new Chart(productsCtx, {
            type: 'bar',
            data: {
                labels: @json($topProducts->pluck('product_name')),
                datasets: [{
                    label: 'Quantité vendue',
                    data: @json($topProducts->pluck('total_sold')),
                    backgroundColor: productsGradient,
                    borderColor: 'rgb(99, 102, 241)',
                    borderWidth: 2,
                    borderRadius: 8,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 13
                        },
                        borderColor: 'rgba(99, 102, 241, 0.5)',
                        borderWidth: 1
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)',
                            drawBorder: false
                        },
                        ticks: {
                            font: {
                                size: 11
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            font: {
                                size: 11
                            }
                        }
                    }
                }
            }
        });
    </script>
</x-app-layout>
