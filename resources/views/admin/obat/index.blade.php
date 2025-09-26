@extends('admin.layouts.app')

@section('title', 'Data Obat - Toko Obat Jaya Mulya')
@section('page-title', 'Data Obat')

@section('content')
<!-- Mobile-optimized padding and spacing -->
<div class="p-3 sm:p-4 lg:p-6 space-y-4 sm:space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="space-y-1 sm:space-y-2">
            <!-- Responsive typography -->
            <h1 class="text-2xl sm:text-3xl font-bold text-foreground">Data Obat</h1>
            <p class="text-sm sm:text-base text-muted-foreground">Kelola inventory obat di toko</p>
        </div>
        <!-- Mobile-friendly button with better touch target -->
        <button onclick="openModal('obatModal')" 
                class="group relative bg-gradient-to-r from-green-600 via-green-700 to-green-800 hover:from-green-700 hover:via-green-800 hover:to-green-900 text-white px-6 sm:px-8 py-3 sm:py-3.5 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 flex items-center justify-center font-semibold text-sm transform hover:scale-105 hover:-translate-y-0.5 active:scale-95 min-h-[48px] w-full sm:w-auto">
            <div class="absolute inset-0 bg-gradient-to-r from-green-400 to-green-600 rounded-xl opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
            <i data-lucide="plus" class="mr-2.5 h-5 w-5 transition-transform duration-300 group-hover:rotate-90"></i>
            <span class="relative z-10">Tambah Obat</span>
        </button>
    </div>

    <div class="bg-muted rounded-lg border border-border">
        <div class="p-4 sm:p-6 border-b border-border">
            <div class="relative">
                <!-- Mobile-optimized search input -->
                <input type="text" 
                       placeholder="Cari obat berdasarkan nama atau kategori..."
                       class="w-full px-3 py-3 sm:py-2 pl-10 bg-background border border-border rounded-md text-foreground placeholder-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary text-base sm:text-sm">
                <i data-lucide="search" class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-muted-foreground"></i>
            </div>
        </div>
        
        <div class="p-3 sm:p-6">
            <!-- Mobile-responsive grid layout -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
                @php
                    $obatList = [
                        ['id' => 1, 'nama' => 'Paracetamol 500mg', 'kategori' => 'Analgesik', 'stok' => 150, 'harga' => 5000, 'expired' => '2025-12-31', 'supplier' => 'PT Kimia Farma'],
                        ['id' => 2, 'nama' => 'Amoxicillin 250mg', 'kategori' => 'Antibiotik', 'stok' => 75, 'harga' => 8500, 'expired' => '2025-08-15', 'supplier' => 'PT Sanbe Farma'],
                        ['id' => 3, 'nama' => 'Vitamin C 1000mg', 'kategori' => 'Vitamin', 'stok' => 200, 'harga' => 12000, 'expired' => '2026-03-20', 'supplier' => 'PT Kalbe Farma'],
                        ['id' => 4, 'nama' => 'Antasida Tablet', 'kategori' => 'Antasida', 'stok' => 30, 'harga' => 3500, 'expired' => '2025-06-10', 'supplier' => 'PT Dexa Medica'],
                    ];
                @endphp

                @foreach($obatList as $obat)
                    @php
                        $stockStatus = $obat['stok'] < 50 ? ['label' => 'Stok Rendah', 'class' => 'bg-red-500/10 text-red-500'] : 
                                      ($obat['stok'] < 100 ? ['label' => 'Stok Sedang', 'class' => 'bg-yellow-500/10 text-yellow-500'] : 
                                      ['label' => 'Stok Aman', 'class' => 'bg-green-500/10 text-green-500']);
                    @endphp
                    
                    <!-- Mobile-optimized card with better touch targets -->
                    <div class="group relative bg-gradient-to-br from-slate-50 via-white to-slate-100 dark:from-slate-800 dark:via-slate-900 dark:to-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 p-4 sm:p-6 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-[1.02] hover:-translate-y-1 active:scale-[0.98]">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 via-purple-500/5 to-pink-500/5 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        
                        <div class="relative z-10">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center space-x-3 flex-1 min-w-0">
                                    <div class="min-w-0 flex-1">
                                        <h3 class="text-base sm:text-lg font-bold text-slate-800 dark:text-slate-100 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-300 truncate">{{ $obat['nama'] }}</h3>
                                        <p class="text-sm text-slate-500 dark:text-slate-400">{{ $obat['kategori'] }}</p>
                                    </div>
                                </div>
                                <!-- Mobile-friendly action buttons with better spacing -->
                                <div class="flex space-x-2 flex-shrink-0">
                                    <button class="group/btn inline-flex items-center justify-center w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white transition-all duration-200 hover:shadow-lg transform hover:scale-110 hover:-translate-y-0.5 active:scale-95">
                                        <i data-lucide="edit" class="h-4 w-4 transition-transform duration-200 group-hover/btn:scale-110"></i>
                                    </button>
                                    <button class="group/btn inline-flex items-center justify-center w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white transition-all duration-200 hover:shadow-lg transform hover:scale-110 hover:-translate-y-0.5 active:scale-95">
                                        <i data-lucide="trash-2" class="h-4 w-4 transition-transform duration-200 group-hover/btn:scale-110"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="space-y-3 sm:space-y-4">
                                <div class="grid gap-3 sm:gap-4">
                                    <div class="bg-slate-100 dark:bg-slate-800 rounded-lg p-3 border border-slate-200 dark:border-slate-700">
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Stok</span>
                                            <div class="flex items-center space-x-2">
                                                <div class="w-2 h-2 rounded-full {{ $obat['stok'] < 50 ? 'bg-red-500' : ($obat['stok'] < 100 ? 'bg-yellow-500' : 'bg-green-500') }}"></div>
                                                <span class="text-sm font-bold text-slate-800 dark:text-slate-200">{{ $obat['stok'] }}</span>
                                            </div>
                                        </div>
                                        <span class="text-xs px-2 py-1 rounded-full {{ $stockStatus['class'] }} mt-1 inline-block">{{ $stockStatus['label'] }}</span>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-3 sm:gap-4">
                                    <div class="bg-slate-100 dark:bg-slate-800 rounded-lg p-3 border border-slate-200 dark:border-slate-700">
                                        <span class="text-sm font-medium text-slate-600 dark:text-slate-400 block">Harga Modal</span>
                                        <span class="text-base sm:text-lg font-bold text-yellow-600 dark:text-yellow-400">Rp {{ number_format($obat['harga']) }}</span>
                                    </div>
                                    
                                    <div class="bg-slate-100 dark:bg-slate-800 rounded-lg p-3 border border-slate-200 dark:border-slate-700">
                                        <span class="text-sm font-medium text-slate-600 dark:text-slate-400 block">Harga Jual</span>
                                        <span class="text-base sm:text-lg font-bold text-green-600 dark:text-green-400">Rp {{ number_format($obat['harga']) }}</span>
                                    </div>
                                </div>
                                
                                <div class="bg-gradient-to-r from-slate-100 to-slate-200 dark:from-slate-800 dark:to-slate-700 rounded-lg p-3 border border-slate-200 dark:border-slate-600">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Expired</span>
                                        <span class="text-sm font-semibold text-slate-800 dark:text-slate-200">{{ $obat['expired'] }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="absolute inset-0 rounded-xl border-2 border-transparent group-hover:border-blue-200 dark:group-hover:border-blue-800 transition-colors duration-300"></div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Mobile-optimized modal -->
<div id="obatModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
    <div class="bg-background rounded-lg p-4 sm:p-6 w-full max-w-md border border-border max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg sm:text-xl font-semibold text-foreground">Tambah Obat</h2>
            <button onclick="closeModal('obatModal')" class="text-muted-foreground hover:text-foreground p-2 -m-2 active:scale-95">
                <i data-lucide="x" class="h-5 w-5"></i>
            </button>
        </div>
        
        <form class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-foreground mb-1">Nama Obat</label>
                <input type="text" class="w-full px-3 py-3 sm:py-2 bg-muted border border-border rounded-md text-foreground text-base sm:text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-foreground mb-1">Kategori</label>
                <select class="w-full px-3 py-3 sm:py-2 bg-muted border border-border rounded-md text-foreground text-base sm:text-sm">
                    <option>Analgesik</option>
                    <option>Antibiotik</option>
                    <option>Vitamin</option>
                    <option>Antasida</option>
                </select>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-foreground mb-1">Stok</label>
                    <input type="number" class="w-full px-3 py-3 sm:py-2 bg-muted border border-border rounded-md text-foreground text-base sm:text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-foreground mb-1">Harga</label>
                    <input type="number" class="w-full px-3 py-3 sm:py-2 bg-muted border border-border rounded-md text-foreground text-base sm:text-sm">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-foreground mb-1">Tanggal Expired</label>
                <input type="date" class="w-full px-3 py-3 sm:py-2 bg-muted border border-border rounded-md text-foreground text-base sm:text-sm">
            </div>
            
            <!-- Mobile-friendly button layout -->
            <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-3 pt-4">
                <button type="submit" class="group flex-1 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white py-3 rounded-lg font-semibold shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105 hover:-translate-y-0.5 active:scale-95 min-h-[48px]">
                    <span class="flex items-center justify-center">
                        <i data-lucide="check" class="h-4 w-4 mr-2 transition-transform duration-200 group-hover:scale-110"></i>
                        Simpan
                    </span>
                </button>
                <button type="button" onclick="closeModal('obatModal')" 
                        class="group flex-1 bg-gradient-to-r from-gray-100 to-gray-200 hover:from-gray-200 hover:to-gray-300 dark:from-gray-700 dark:to-gray-800 dark:hover:from-gray-600 dark:hover:to-gray-700 text-gray-700 dark:text-gray-300 py-3 rounded-lg font-semibold transition-all duration-200 transform hover:scale-105 hover:-translate-y-0.5 active:scale-95 min-h-[48px]">
                    <span class="flex items-center justify-center">
                        <i data-lucide="x" class="h-4 w-4 mr-2 transition-transform duration-200 group-hover:scale-110"></i>
                        Batal
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
