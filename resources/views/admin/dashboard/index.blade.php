@extends('admin.layouts.app')

@section('title', 'Dashboard - Toko Obat Jaya Mulya')
@section('page-title', 'Dashboard')

@section('content')
<div class="p-3 sm:p-4 lg:p-6 space-y-4 sm:space-y-6">
    <div class="space-y-1 sm:space-y-2">
        <h1 class="text-2xl sm:text-3xl font-bold text-foreground">Dashboard</h1>
        <p class="text-sm sm:text-base text-muted-foreground">Selamat datang di sistem admin Toko Obat Jaya Mulya</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-6">
        <div class="group relative bg-gradient-to-br from-blue-500/10 via-blue-600/5 to-transparent border border-blue-500/20 rounded-xl p-4 sm:p-6 hover:shadow-lg hover:shadow-blue-500/10 transition-all duration-300 hover:-translate-y-1 active:scale-95">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-transparent rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs sm:text-sm text-muted-foreground font-medium">Total Obat</p>
                    <p class="text-2xl sm:text-3xl font-bold text-foreground mt-1 truncate">{{ $totalObat }}</p>
                    <p class="text-xs text-blue-500 mt-1 flex items-center">
                        @if($totalKenaikanObat > 0)
                            <i data-lucide="trending-up" class="h-3 w-3 mr-1 flex-shrink-0"></i>
                            <span class="truncate">+{{ $totalKenaikanObat }}% dari bulan lalu</span>
                        @elseif ($totalKenaikanObat < 0)
                            <i data-lucide="trending-down" class="h-3 w-3 mr-1 flex-shrink-0"></i>
                            <span class="truncate">{{ $totalKenaikanObat }}% dari bulan lalu</span>
                        @else
                            <span class="truncate">Tidak ada perubahan dari bulan lalu</span>
                        @endif
                    </p>
                </div>
                <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/25 flex-shrink-0 ml-3">
                    <i data-lucide="package" class="h-6 w-6 sm:h-7 sm:w-7 text-white"></i>
                </div>
            </div>
        </div>

        <div class="group relative bg-gradient-to-br from-green-500/10 via-green-600/5 to-transparent border border-green-500/20 rounded-xl p-4 sm:p-6 hover:shadow-lg hover:shadow-green-500/10 transition-all duration-300 hover:-translate-y-1 active:scale-95">
            <div class="absolute inset-0 bg-gradient-to-br from-green-500/5 to-transparent rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs sm:text-sm text-muted-foreground font-medium">Penjualan Hari Ini</p>
                    <p class="text-xl sm:text-3xl font-bold text-foreground mt-1 truncate">Rp {{ $penjualanHariIni }}</p>
                    <p class="text-xs text-{{ $totalKenaikanPenjualan >= 0 ? 'green' : 'red' }}-500 mt-1 flex items-center">
                        @if($totalKenaikanPenjualan > 0)
                            <i data-lucide="trending-up" class="h-3 w-3 mr-1 flex-shrink-0"></i>
                            <span class="truncate">+{{ $totalKenaikanPenjualan }}% dari kemarin</span>
                        @elseif ($totalKenaikanPenjualan < 0)
                            <i data-lucide="trending-down" class="h-3 w-3 mr-1 flex-shrink-0"></i>
                            <span class="truncate">{{ $totalKenaikanPenjualan }}% dari kemarin</span>
                        @else
                            <span class="truncate">Tidak ada perubahan dari kemarin</span>
                        @endif
                    </p>
                </div>
                <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg shadow-green-500/25 flex-shrink-0 ml-3">
                    <i data-lucide="trending-up" class="h-6 w-6 sm:h-7 sm:w-7 text-white"></i>
                </div>
            </div>
        </div>

        <div class="group relative bg-gradient-to-br from-yellow-500/10 via-yellow-600/5 to-transparent border border-yellow-500/20 rounded-xl p-4 sm:p-6 hover:shadow-lg hover:shadow-yellow-500/10 transition-all duration-300 hover:-translate-y-1 active:scale-95">
            <div class="absolute inset-0 bg-gradient-to-br from-yellow-500/5 to-transparent rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs sm:text-sm text-muted-foreground font-medium">Stok Menipis</p>
                    <p class="text-2xl sm:text-3xl font-bold text-foreground mt-1 truncate">{{ $totalStokMenipis }}</p>
                    <p class="text-xs text-yellow-500 mt-1 flex items-center">
                        @if ($totalStokMenipis > 0)
                            <i data-lucide="alert-triangle" class="h-3 w-3 mr-1 flex-shrink-0"></i>
                            <span class="truncate">Perlu perhatian</span>
                        @else
                            <span class="truncate">Semua stok dalam kondisi aman</span>
                        @endif
                    </p>
                </div>
                <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl flex items-center justify-center shadow-lg shadow-yellow-500/25 flex-shrink-0 ml-3">
                    <i data-lucide="alert-triangle" class="h-6 w-6 sm:h-7 sm:w-7 text-white"></i>
                </div>
            </div>
        </div>

        <div class="group relative bg-gradient-to-br from-purple-500/10 via-purple-600/5 to-transparent border border-purple-500/20 rounded-xl p-4 sm:p-6 hover:shadow-lg hover:shadow-purple-500/10 transition-all duration-300 hover:-translate-y-1 active:scale-95">
            <div class="absolute inset-0 bg-gradient-to-br from-purple-500/5 to-transparent rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs sm:text-sm text-muted-foreground font-medium">Total User</p>
                    <p class="text-2xl sm:text-3xl font-bold text-foreground mt-1 truncate">{{ $totalUser }}</p>
                    <p class="text-xs text-purple-500 mt-1 flex items-center">
                        <i data-lucide="users" class="h-3 w-3 mr-1 flex-shrink-0"></i>
                        <span class="truncate">+{{ $totalKenaikanUser }} user baru</span>
                    </p>
                </div>
                <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg shadow-purple-500/25 flex-shrink-0 ml-3">
                    <i data-lucide="users" class="h-6 w-6 sm:h-7 sm:w-7 text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
        <div class="bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-800/50 dark:to-slate-900/50 rounded-xl p-4 sm:p-6 border border-slate-200/50 dark:border-slate-700/50 shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between mb-4 sm:mb-6">
                <h3 class="text-base sm:text-lg font-semibold text-foreground">Penjualan Mingguan</h3>
                <div class="flex items-center space-x-2">
                    <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                    <span class="text-xs sm:text-sm text-muted-foreground hidden sm:inline">Trend naik</span>
                </div>
            </div>
            <div class="h-48 sm:h-64 flex items-center justify-center text-muted-foreground bg-gradient-to-br from-blue-50/50 to-indigo-50/50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-lg border border-blue-200/30 dark:border-blue-700/30">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <div class="bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-800/50 dark:to-slate-900/50 rounded-xl p-4 sm:p-6 border border-slate-200/50 dark:border-slate-700/50 shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between mb-4 sm:mb-6">
                <h3 class="text-base sm:text-lg font-semibold text-foreground">Overview Inventory</h3>
                <span class="text-xs sm:text-sm text-muted-foreground bg-slate-200/50 dark:bg-slate-700/50 px-2 py-1 rounded-full">{{ $totalStokObat }} total</span>
            </div>
            <div class="space-y-3 sm:space-y-4">
                @php
                    $colors = ['green', 'blue', 'purple', 'yellow'];
                @endphp
                @foreach ($overviewObats as $i => $d)
                    <div class="p-3 bg-white/50 dark:bg-slate-800/50 rounded-lg border border-slate-200/30 dark:border-slate-700/30">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-foreground">{{ $d['nama'] }}</span>
                            <span class="text-sm font-bold text-foreground">{{ $d['stok'] }} unit</span>
                        </div>
                        <div class="w-full bg-slate-200 dark:bg-slate-700 rounded-full h-2">
                            <div class="bg-gradient-to-r from-{{ $colors[$i] }}-500 to-{{ $colors[$i] }}-600 h-2 rounded-full" style="width: {{ $d['stok']/$totalStokObat *100 }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-800/50 dark:to-slate-900/50 rounded-xl p-4 sm:p-6 border border-slate-200/50 dark:border-slate-700/50 shadow-sm hover:shadow-md transition-shadow duration-300">
        <div class="flex items-center justify-between mb-4 sm:mb-6">
            <h3 class="text-base sm:text-lg font-semibold text-foreground">Transaksi Terbaru</h3>
        </div>
        <div class="overflow-x-auto -mx-4 sm:mx-0">
            <div class="inline-block min-w-full align-middle">
            @if (count($transaksis) === 0)
                <h1 class="my-4 font-medium text-2xl text-foreground text-center">Tidak ada data transaksi!</h1>
            @else
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b border-slate-200 dark:border-slate-700">
                            <th class="text-left py-3 px-2 text-xs sm:text-sm font-semibold text-muted-foreground bg-slate-100/50 dark:bg-slate-800/50 rounded-l-lg">ID</th>
                            <th class="text-left py-3 px-2 text-xs sm:text-sm font-semibold text-muted-foreground bg-slate-100/50 dark:bg-slate-800/50">Obat</th>
                            <th class="text-left py-3 px-2 text-xs sm:text-sm font-semibold text-muted-foreground bg-slate-100/50 dark:bg-slate-800/50 hidden sm:table-cell">Jumlah</th>
                            <th class="text-left py-3 px-2 text-xs sm:text-sm font-semibold text-muted-foreground bg-slate-100/50 dark:bg-slate-800/50">Total</th>
                            <th class="text-left py-3 px-2 text-xs sm:text-sm font-semibold text-muted-foreground bg-slate-100/50 dark:bg-slate-800/50 rounded-r-lg hidden md:table-cell">Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaksis as $transaksi)
                            <tr class="border-b border-slate-200/50 dark:border-slate-700/50 hover:bg-white/50 dark:hover:bg-slate-800/30 transition-colors duration-200 active:bg-slate-100/50 dark:active:bg-slate-700/50">
                                <td class="py-3 sm:py-4 px-2">
                                    <span class="text-xs sm:text-sm font-mono font-medium text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/30 px-2 py-1 rounded">#{{ $transaksi->id }}</span>
                                </td>
                                <td class="py-3 sm:py-4 px-2">
                                    <div class="flex items-center">
                                        <div class="min-w-0">
                                            <span class="text-xs sm:text-sm font-medium text-foreground block truncate">{{ $transaksi->obat->nama }}</span>
                                            <span class="text-xs text-muted-foreground sm:hidden">{{ $transaksi->qty }} unit</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 sm:py-4 px-2 hidden sm:table-cell">
                                    <span class="text-sm text-foreground bg-slate-100 dark:bg-slate-700 px-2 py-1 rounded-full">{{ $transaksi->qty }} unit</span>
                                </td>
                                <td class="py-3 sm:py-4 px-2">
                                    <span class="text-xs sm:text-sm font-semibold text-green-600 dark:text-green-400">Rp {{ $transaksi->subtotal }}</span>
                                </td>
                                <td class="py-3 sm:py-4 px-2 hidden md:table-cell">
                                    <span class="text-sm text-muted-foreground">{{ timeAgo($transaksi->transaction->created_at) }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(ctx, {
        type: 'line', // bisa 'bar', 'line', 'pie', dll.
        data: {
            labels: @json($chartLabels), // tanggal
            datasets: [{
                label: 'Total Penjualan',
                data: @json($chartTotals), // total penjualan per tanggal
                borderColor: '#FACC15',   // kuning keemasan
                backgroundColor: 'rgba(250, 204, 21, 0.3)', // transparan
                borderWidth: 2,
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let value = context.raw;
                            return 'Rp ' + value.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });
</script>
@endsection

