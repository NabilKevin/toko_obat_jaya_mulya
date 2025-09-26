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
                    <p class="text-2xl sm:text-3xl font-bold text-foreground mt-1 truncate">1,234</p>
                    <p class="text-xs text-blue-500 mt-1 flex items-center">
                        <i data-lucide="trending-up" class="h-3 w-3 mr-1 flex-shrink-0"></i>
                        <span class="truncate">+12% dari bulan lalu</span>
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
                    <p class="text-xl sm:text-3xl font-bold text-foreground mt-1 truncate">Rp 2,450,000</p>
                    <p class="text-xs text-green-500 mt-1 flex items-center">
                        <i data-lucide="trending-up" class="h-3 w-3 mr-1 flex-shrink-0"></i>
                        <span class="truncate">+8% dari kemarin</span>
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
                    <p class="text-2xl sm:text-3xl font-bold text-foreground mt-1 truncate">23</p>
                    <p class="text-xs text-yellow-500 mt-1 flex items-center">
                        <i data-lucide="alert-triangle" class="h-3 w-3 mr-1 flex-shrink-0"></i>
                        <span class="truncate">Perlu perhatian</span>
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
                    <p class="text-2xl sm:text-3xl font-bold text-foreground mt-1 truncate">156</p>
                    <p class="text-xs text-purple-500 mt-1 flex items-center">
                        <i data-lucide="users" class="h-3 w-3 mr-1 flex-shrink-0"></i>
                        <span class="truncate">+5 user baru</span>
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
                <div class="text-center">
                    <i data-lucide="bar-chart-3" class="h-10 w-10 sm:h-12 sm:w-12 text-blue-500 mx-auto mb-2"></i>
                    <p class="font-medium text-sm sm:text-base">Chart akan ditampilkan di sini</p>
                    <p class="text-xs sm:text-sm">Grafik penjualan mingguan</p>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-800/50 dark:to-slate-900/50 rounded-xl p-4 sm:p-6 border border-slate-200/50 dark:border-slate-700/50 shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between mb-4 sm:mb-6">
                <h3 class="text-base sm:text-lg font-semibold text-foreground">Overview Inventory</h3>
                <span class="text-xs sm:text-sm text-muted-foreground bg-slate-200/50 dark:bg-slate-700/50 px-2 py-1 rounded-full">1,200 total</span>
            </div>
            <div class="space-y-3 sm:space-y-4">
                <div class="p-3 bg-white/50 dark:bg-slate-800/50 rounded-lg border border-slate-200/30 dark:border-slate-700/30">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-foreground">Analgesik</span>
                        <span class="text-sm font-bold text-foreground">450 unit</span>
                    </div>
                    <div class="w-full bg-slate-200 dark:bg-slate-700 rounded-full h-2">
                        <div class="bg-gradient-to-r from-green-500 to-green-600 h-2 rounded-full" style="width: 75%"></div>
                    </div>
                </div>
                <div class="p-3 bg-white/50 dark:bg-slate-800/50 rounded-lg border border-slate-200/30 dark:border-slate-700/30">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-foreground">Antibiotik</span>
                        <span class="text-sm font-bold text-foreground">320 unit</span>
                    </div>
                    <div class="w-full bg-slate-200 dark:bg-slate-700 rounded-full h-2">
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-2 rounded-full" style="width: 60%"></div>
                    </div>
                </div>
                <div class="p-3 bg-white/50 dark:bg-slate-800/50 rounded-lg border border-slate-200/30 dark:border-slate-700/30">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-foreground">Vitamin</span>
                        <span class="text-sm font-bold text-foreground">280 unit</span>
                    </div>
                    <div class="w-full bg-slate-200 dark:bg-slate-700 rounded-full h-2">
                        <div class="bg-gradient-to-r from-purple-500 to-purple-600 h-2 rounded-full" style="width: 50%"></div>
                    </div>
                </div>
                <div class="p-3 bg-white/50 dark:bg-slate-800/50 rounded-lg border border-slate-200/30 dark:border-slate-700/30">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-foreground">Antasida</span>
                        <span class="text-sm font-bold text-foreground">150 unit</span>
                    </div>
                    <div class="w-full bg-slate-200 dark:bg-slate-700 rounded-full h-2">
                        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 h-2 rounded-full" style="width: 25%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-800/50 dark:to-slate-900/50 rounded-xl p-4 sm:p-6 border border-slate-200/50 dark:border-slate-700/50 shadow-sm hover:shadow-md transition-shadow duration-300">
        <div class="flex items-center justify-between mb-4 sm:mb-6">
            <h3 class="text-base sm:text-lg font-semibold text-foreground">Transaksi Terbaru</h3>
            <button class="text-sm text-blue-500 hover:text-blue-600 font-medium flex items-center transition-colors duration-200 active:scale-95">
                <span class="hidden sm:inline">Lihat semua</span>
                <span class="sm:hidden">Semua</span>
                <i data-lucide="arrow-right" class="h-4 w-4 ml-1"></i>
            </button>
        </div>
        <div class="overflow-x-auto -mx-4 sm:mx-0">
            <div class="inline-block min-w-full align-middle">
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
                        <tr class="border-b border-slate-200/50 dark:border-slate-700/50 hover:bg-white/50 dark:hover:bg-slate-800/30 transition-colors duration-200 active:bg-slate-100/50 dark:active:bg-slate-700/50">
                            <td class="py-3 sm:py-4 px-2">
                                <span class="text-xs sm:text-sm font-mono font-medium text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/30 px-2 py-1 rounded">#001</span>
                            </td>
                            <td class="py-3 sm:py-4 px-2">
                                <div class="flex items-center">
                                    <div class="w-6 h-6 sm:w-8 sm:h-8 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center mr-2 sm:mr-3 flex-shrink-0">
                                        <i data-lucide="pill" class="h-3 w-3 sm:h-4 sm:w-4 text-white"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <span class="text-xs sm:text-sm font-medium text-foreground block truncate">Paracetamol 500mg</span>
                                        <span class="text-xs text-muted-foreground sm:hidden">2 unit</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 sm:py-4 px-2 hidden sm:table-cell">
                                <span class="text-sm text-foreground bg-slate-100 dark:bg-slate-700 px-2 py-1 rounded-full">2 unit</span>
                            </td>
                            <td class="py-3 sm:py-4 px-2">
                                <span class="text-xs sm:text-sm font-semibold text-green-600 dark:text-green-400">Rp 10,000</span>
                            </td>
                            <td class="py-3 sm:py-4 px-2 hidden md:table-cell">
                                <span class="text-sm text-muted-foreground">2 menit lalu</span>
                            </td>
                        </tr>
                        <tr class="border-b border-slate-200/50 dark:border-slate-700/50 hover:bg-white/50 dark:hover:bg-slate-800/30 transition-colors duration-200 active:bg-slate-100/50 dark:active:bg-slate-700/50">
                            <td class="py-3 sm:py-4 px-2">
                                <span class="text-xs sm:text-sm font-mono font-medium text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/30 px-2 py-1 rounded">#002</span>
                            </td>
                            <td class="py-3 sm:py-4 px-2">
                                <div class="flex items-center">
                                    <div class="w-6 h-6 sm:w-8 sm:h-8 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center mr-2 sm:mr-3 flex-shrink-0">
                                        <i data-lucide="pill" class="h-3 w-3 sm:h-4 sm:w-4 text-white"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <span class="text-xs sm:text-sm font-medium text-foreground block truncate">Vitamin C 1000mg</span>
                                        <span class="text-xs text-muted-foreground sm:hidden">1 unit</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 sm:py-4 px-2 hidden sm:table-cell">
                                <span class="text-sm text-foreground bg-slate-100 dark:bg-slate-700 px-2 py-1 rounded-full">1 unit</span>
                            </td>
                            <td class="py-3 sm:py-4 px-2">
                                <span class="text-xs sm:text-sm font-semibold text-green-600 dark:text-green-400">Rp 12,000</span>
                            </td>
                            <td class="py-3 sm:py-4 px-2 hidden md:table-cell">
                                <span class="text-sm text-muted-foreground">5 menit lalu</span>
                            </td>
                        </tr>
                        <tr class="hover:bg-white/50 dark:hover:bg-slate-800/30 transition-colors duration-200 active:bg-slate-100/50 dark:active:bg-slate-700/50">
                            <td class="py-3 sm:py-4 px-2">
                                <span class="text-xs sm:text-sm font-mono font-medium text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/30 px-2 py-1 rounded">#003</span>
                            </td>
                            <td class="py-3 sm:py-4 px-2">
                                <div class="flex items-center">
                                    <div class="w-6 h-6 sm:w-8 sm:h-8 bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg flex items-center justify-center mr-2 sm:mr-3 flex-shrink-0">
                                        <i data-lucide="pill" class="h-3 w-3 sm:h-4 sm:w-4 text-white"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <span class="text-xs sm:text-sm font-medium text-foreground block truncate">Amoxicillin 250mg</span>
                                        <span class="text-xs text-muted-foreground sm:hidden">3 unit</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 sm:py-4 px-2 hidden sm:table-cell">
                                <span class="text-sm text-foreground bg-slate-100 dark:bg-slate-700 px-2 py-1 rounded-full">3 unit</span>
                            </td>
                            <td class="py-3 sm:py-4 px-2">
                                <span class="text-xs sm:text-sm font-semibold text-green-600 dark:text-green-400">Rp 18,000</span>
                            </td>
                            <td class="py-3 sm:py-4 px-2 hidden md:table-cell">
                                <span class="text-sm text-muted-foreground">8 menit lalu</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
