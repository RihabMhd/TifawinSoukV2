<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Gestion des Commandes
            </h2>

            <a href="{{ route('admin.orders.export') }}"
               class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded text-sm font-medium">
                Export CSV
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!--  Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-white dark:bg-gray-800 p-6 rounded shadow">
                    <p class="text-sm text-gray-500">Total commandes</p>
                    <p class="text-2xl font-bold">{{ $stats['total_orders'] }}</p>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded shadow">
                    <p class="text-sm text-gray-500">Montant total</p>
                    <p class="text-2xl font-bold">{{ number_format($stats['total_amount'], 2) }} MAD</p>
                </div>
            </div>

            <!-- //Formulaire filtres -->
            <form method="GET" action="{{ route('admin.orders.index') }}" class="bg-white dark:bg-gray-800 p-6 rounded shadow mb-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                    <input type="text" name="client" value="{{ request('client') }}" placeholder="Client (nom ou email)" class="rounded border-gray-300 dark:bg-gray-700">
                    <select name="status" class="rounded border-gray-300 dark:bg-gray-700">
                        <option value="">Tous</option>
                        @foreach(['pending','processing','shipped','delivered','cancelled'] as $s)
                            <option value="{{ $s }}" {{ request('status')==$s?'selected':'' }}>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" class="rounded border-gray-300 dark:bg-gray-700">
                    <input type="date" name="date_to" value="{{ request('date_to') }}" class="rounded border-gray-300 dark:bg-gray-700">
                    <input type="number" name="amount_min" placeholder="Min" value="{{ request('amount_min') }}" class="rounded border-gray-300 dark:bg-gray-700">
                    <input type="number" name="amount_max" placeholder="Max" value="{{ request('amount_max') }}" class="rounded border-gray-300 dark:bg-gray-700">
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Filtrer</button>
                    <a href="{{ route('admin.orders.index') }}" class="bg-gray-200 px-4 py-2 rounded">Réinitialiser</a>
                </div>

                <!-- Badges filtres  -->
                <div class="flex flex-wrap gap-2 mt-2">
                    @if(request('client'))
                        <span class="bg-indigo-100 text-indigo-800 px-2 py-1 rounded text-xs">Client: {{ request('client') }}</span>
                    @endif
                    @if(request('status'))
                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">Statut: {{ request('status') }}</span>
                    @endif
                    @if(request('date_from') || request('date_to'))
                        <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded text-xs">Date: Filtrée</span>
                    @endif
                </div>
            </form>

            <!-- Tableau -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">#</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Client</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Statut</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($orders as $order)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">#{{ $order->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $order->user->name ?? 'Invité' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold">{{ number_format($order->total, 2) }} MAD</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <select name="status" onchange="if(confirm('Changer le statut ?')){this.form.submit();} else {this.value='{{ $order->status }}';}"
                                                class="px-2 py-1 rounded text-xs cursor-pointer
                                                {{ $order->status==='pending'?'bg-yellow-100 text-yellow-800':'' }}
                                                {{ $order->status==='processing'?'bg-indigo-100 text-indigo-800':'' }}
                                                {{ $order->status==='shipped'?'bg-purple-100 text-purple-800':'' }}
                                                {{ $order->status==='delivered'?'bg-green-100 text-green-800':'' }}
                                                {{ $order->status==='cancelled'?'bg-red-100 text-red-800':'' }}">
                                                @foreach(['pending','processing','shipped','delivered','cancelled'] as $s)
                                                    <option value="{{ $s }}" {{ $order->status==$s?'selected':'' }}>{{ ucfirst($s) }}</option>
                                                @endforeach
                                            </select>
                                        </form>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $order->created_at->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-3">
                                            <a href="{{ route('admin.orders.show', $order->id) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400">Voir</a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">Aucune commande trouvée</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                 <!-- Pagination -->
                <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700">
                    {{ $orders->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
