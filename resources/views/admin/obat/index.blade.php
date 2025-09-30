@extends('admin.layouts.app')

@section('title', 'Data Obat - Toko Obat Jaya Mulya')
@section('page-title', 'Data Obat')

@section('content')
@if(session('success'))
    <div class="alert absolute p-4 bg-green-700/50 text-green-500 border rounded-md border-green-600 text-center top-[12%] left-1/2 -translate-x-1/2 z-50 alertAnimate">
        {{ session('success') ?? 'Berhasil!' }}
    </div>
@endif
<!-- Mobile-optimized padding and spacing -->
<div class="p-3 sm:p-4 lg:p-6 space-y-4 sm:space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="space-y-1 sm:space-y-2">
            <!-- Responsive typography -->
            <h1 class="text-2xl sm:text-3xl font-bold text-foreground">Data Obat</h1>
            <p class="text-sm sm:text-base text-muted-foreground">Kelola inventory obat di toko</p>
        </div>
        <!-- Mobile-friendly button with better touch target -->
        <button onclick="window.location.href='{{ route('obat.create') }}'" id="createObat"  
                class="group relative bg-green-500 hover:bg-green-500/90 text-white px-6 sm:px-8 py-3 sm:py-3.5 rounded-xl shadow-lg hover:shadow-2xl ring-1 ring-success/20 transition-all duration-300 flex items-center justify-center font-semibold text-sm transform hover:scale-105 hover:-translate-y-0.5 w-full sm:w-auto min-h-[48px] active:scale-95">
            <div class="absolute inset-0 bg-gradient-to-r from-green-400 to-green-600 rounded-xl opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
            <span class="relative z-10">Tambah Obat</span>
        </button>
    </div>

    <div class="bg-muted rounded-lg border border-border">
<div class="p-4 sm:p-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
            <!-- CHANGE> Added search button next to search input -->
            <form class="flex space-x-3" action="{{ route('obat.index') }}">
                <div class="relative flex-1">
                    <input type="text" 
                            name="search"
                            value="{{ $search }}"
                            id="search"
                            placeholder="Cari user berdasarkan nama atau username..."
                            class="w-full px-4 py-3 pl-12 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg text-foreground placeholder-muted-foreground focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-sm sm:text-base min-h-[48px]">
                    <i data-lucide="search" class="absolute left-4 top-1/2 transform -translate-y-1/2 h-5 w-5 text-muted-foreground"></i>
                </div>
                <button type="submit" class="group relative bg-muted hover:bg-muted/80 border border-border text-foreground px-6 py-3 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 flex items-center justify-center font-semibold text-sm transform hover:scale-105 hover:-translate-y-0.5 min-h-[48px] active:scale-95">
                    <span class="hidden sm:inline relative z-10">Cari</span>
                    <i data-lucide="search" class="inline sm:hidden relative z-10"></i>
                </button>
                <button onclick="document.querySelector('#search').value = ''; input.closest('form').submit();" class="group relative bg-danger hover:bg-danger/80 border border-border text-foreground px-6 py-3 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 flex items-center justify-center font-semibold text-sm transform hover:scale-105 hover:-translate-y-0.5 min-h-[48px] active:scale-95">
                    <span class="hidden sm:inline relative z-10">Clear</span>
                    <i data-lucide="x" class="inline sm:hidden relative z-10"></i>
                </button>
            </form>
        </div>
        
        <div class="p-3 sm:p-6">
            <!-- Mobile-responsive grid layout -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
                @foreach($obats as $obat)
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
                                        <p class="text-sm text-slate-500 dark:text-slate-400">Barcode : {{ $obat['kode_barcode'] }}</p>
                                        <p class="text-sm text-slate-500 dark:text-slate-400">Tipe : {{ $obat['tipe'] }}</p>
                                    </div>
                                </div>
                                <!-- Mobile-friendly action buttons with better spacing -->
                                <div class="flex space-x-2 flex-shrink-0">
                                    <button onclick="window.location.href='{{ route('obat.edit', $obat->id) }}'" class="group inline-flex items-center justify-center w-10 h-10 rounded-lg bg-gradient-to-r from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200 dark:from-blue-900/20 dark:to-blue-900/30 dark:hover:from-blue-900/30 dark:hover:to-blue-900/50 text-blue-600 dark:text-blue-400 transition-all duration-200 hover:shadow-md transform active:scale-95">
                                        <i data-lucide="edit" class="h-5 w-5"></i>
                                    </button>
                                    <form action="{{ route('obat.delete', $obat->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin hapus obat tersebut?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                            class="group inline-flex items-center justify-center w-10 h-10 rounded-lg bg-gradient-to-r from-red-50 to-red-100 hover:from-red-100 hover:to-red-200 dark:from-red-900/20 dark:to-red-900/30 dark:hover:from-red-900/30 dark:hover:to-red-900/50 text-red-600 dark:text-red-400 transition-all duration-200 hover:shadow-md transform active:scale-95">
                                            <i data-lucide="trash-2" 
                                            class="h-4 w-4 transition-transform duration-200 group-hover:scale-110"></i>
                                        </button>
                                    </form>
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
                                        <span class="text-base sm:text-lg font-bold text-yellow-600 dark:text-yellow-400">Rp {{ number_format($obat['harga_modal']) }}</span>
                                    </div>
                                    
                                    <div class="bg-slate-100 dark:bg-slate-800 rounded-lg p-3 border border-slate-200 dark:border-slate-700">
                                        <span class="text-sm font-medium text-slate-600 dark:text-slate-400 block">Harga Jual</span>
                                        <span class="text-base sm:text-lg font-bold text-green-600 dark:text-green-400">Rp {{ number_format($obat['harga_jual']) }}</span>
                                    </div>
                                </div>
                                
                                <div class="bg-gradient-to-r from-slate-100 to-slate-200 dark:from-slate-800 dark:to-slate-700 rounded-lg p-3 border border-slate-200 dark:border-slate-600">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Expired</span>
                                        <span class="text-sm font-semibold text-slate-800 dark:text-slate-200">{{ $obat['expired_at'] }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="absolute inset-0 rounded-xl border-2 border-transparent group-hover:border-blue-200 dark:group-hover:border-blue-800 transition-colors duration-300"></div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="px-4 sm:px-6 py-4 bg-gray-50 dark:bg-gray-900/50 border-t border-gray-200 dark:border-gray-700">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                <div class="text-sm text-gray-700 dark:text-gray-300 text-center sm:text-left">
                    Menampilkan <span class="font-medium">{{ $from }}</span> sampai <span class="font-medium">{{ $to }}</span> dari <span class="font-medium">{{ $total }}</span> hasil
                </div>
    
                <!-- Smart Pagination Component -->
                <div class="flex flex-col sm:flex-row items-center space-y-3 sm:space-y-0 sm:space-x-4">
                    <!-- Mobile Page Info -->
                    <div class="sm:hidden text-sm text-gray-600 dark:text-gray-400 font-medium">
                        Menampilkan {{ $currentPage }} dari {{ $total }}
                    </div>
    
                    <!-- Pagination Controls -->
                    <div class="flex items-center space-x-1 sm:space-x-2">
                        <!-- First Page -->
                        <button class="group px-2 sm:px-3 py-2.5 text-sm bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200 flex items-center font-medium min-h-[44px] sm:min-h-[48px] active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed" @disabled($isFirstPage) onclick="window.location.href='{{ $firstPage }}'">
                            <i data-lucide="chevrons-left" class="h-4 w-4 transition-transform duration-200 group-hover:-translate-x-0.5"></i>
                            <span class="hidden lg:inline ml-1">First</span>
                        </button>
    
                        <!-- Previous Page -->
                        <button class="group px-2 sm:px-3 py-2.5 text-sm bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200 flex items-center font-medium min-h-[44px] sm:min-h-[48px] active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed" @disabled($isFirstPage) onclick="window.location.href='{{ $prevPage }}'">
                            <i data-lucide="chevron-left" class="h-4 w-4 transition-transform duration-200 group-hover:-translate-x-0.5"></i>
                            <span class="hidden sm:inline ml-1">Prev</span>
                        </button>
    
                        <div class="flex items-center space-x-1">
                            <!-- Current page -->
                            <button class="px-3 py-2.5 text-sm bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg font-medium shadow-md min-h-[48px] ring-2 ring-blue-200 dark:ring-blue-800">{{ $currentPage }}</button>
                        </div>
    
                        <!-- Next Page -->
                        <button class="group px-2 sm:px-3 py-2.5 text-sm bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200 flex items-center font-medium min-h-[44px] sm:min-h-[48px] active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed" @disabled($isLastPage) onclick="window.location.href='{{ $nextPage }}'">
                            <span class="hidden sm:inline mr-1">Next</span>
                            <i data-lucide="chevron-right" class="h-4 w-4 transition-transform duration-200 group-hover:translate-x-0.5"></i>
                        </button>
    
                        <!-- Last Page -->
                        <button class="group px-2 sm:px-3 py-2.5 text-sm bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200 flex items-center font-medium min-h-[44px] sm:min-h-[48px] active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed" @disabled($isLastPage) onclick="window.location.href='{{ $lastPage }}'">
                            <span class="hidden lg:inline mr-1">Last</span>
                            <i data-lucide="chevrons-right" class="h-4 w-4 transition-transform duration-200 group-hover:translate-x-0.5"></i>
                        </button>
                    </div>
                </div>
            </div>
    
            <!-- Mobile Quick Navigation -->
            <div class="sm:hidden mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                <div class="flex justify-center space-x-2">
                    <button class="px-4 py-2 text-sm bg-gradient-to-r from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200 dark:from-blue-900/20 dark:to-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg font-medium transition-all duration-200 active:scale-95">
                        Go to First
                    </button>
                    <button class="px-4 py-2 text-sm bg-gradient-to-r from-gray-50 to-gray-100 hover:from-gray-100 hover:to-gray-200 dark:from-gray-800 dark:to-gray-700 text-gray-600 dark:text-gray-400 rounded-lg font-medium transition-all duration-200 active:scale-95">
                        Go to Last
                    </button>
                </div>
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

<script>
    document.getElementById('createObat').addEventListener('click', function() {
        setTimeout(() => {
            this.disabled = true;
            this.style.opacity = '0.5';
            this.style.cursor = 'not-allowed';
        }, 1)
    });
</script>
@endsection
