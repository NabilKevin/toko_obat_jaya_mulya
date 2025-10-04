@extends('kasir.layouts.app')

@section('title', 'Transaksi - Kasir')

@section('content')
<div class="rounded-lg border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-950">
  <div class="p-3 flex flex-col md:flex-row gap-2 md:items-center md:justify-between">
    <form method="GET" class="flex gap-2 w-full md:w-auto flex-col sm:flex-row">
      <input name="search" id="search" value="{{ $search }}" placeholder="Cari kode transaksi..." class="py-[0.725rem] flex-1 h-10 rounded-md border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-900 px-3 text-sm focus:ring-2 focus:ring-primary" />
      <div class="flex items-center gap-2">
        <button type="submit" class="grow py-2 px-4 rounded-md border border-neutral-200 dark:border-neutral-800 bg-gradient-to-r from-blue-600 to-blue-700 text-white active:scale-90 transition-all">Cari</button>
        <button onclick="document.querySelector('#search').value = ''; input.closest('form').submit();" class="grow group py-2.5 px-3 relative border border-border text-foreground rounded-lg shadow-sm hover:shadow-md transition-all duration-300 flex items-center justify-center font-semibold text-sm transform hover:-translate-y-0.5 active:scale-95">Reset</button>
      </div>
    </form>
  </div>
  <div class="overflow-x-auto">
    <table class="min-w-full text-sm p-2">
      <thead class="bg-neutral-50 dark:bg-neutral-900">
        <tr>
          <th class="text-center py-3 px-2 text-xs sm:text-sm font-semibold text-muted-foreground bg-slate-100/50 dark:bg-slate-800/50 rounded-l-lg">Kode</th>
          <th class="text-center py-3 px-2 text-xs sm:text-sm font-semibold text-muted-foreground bg-slate-100/50 dark:bg-slate-800/50 hidden sm:table-cell">Obat</th>
          <th class="text-center py-3 px-2 text-xs sm:text-sm font-semibold text-muted-foreground bg-slate-100/50 dark:bg-slate-800/50 hidden md:table-cell">Jumlah</th>
          <th class="text-center py-3 px-2 text-xs sm:text-sm font-semibold text-muted-foreground bg-slate-100/50 dark:bg-slate-800/50">Total</th>
          <th class="text-center py-3 px-2 text-xs sm:text-sm font-semibold text-muted-foreground bg-slate-100/50 dark:bg-slate-800/50 rounded-r-lg hidden md:table-cell">Waktu</th>
          <th class="text-center py-3 px-2 text-xs sm:text-sm font-semibold text-muted-foreground bg-slate-100/50 dark:bg-slate-800/50 rounded-r-lg">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @if (count($transaksis) === 0)
          <h1 class="font-medium text-xl text-foreground text-center">Tidak ada data transaksi!</h1>
        @endif
        @foreach ($transaksis as $transaksi)
          <tr class="border-b">
            <td class="text-center px-4 py-2">{{ $transaksi->kode }}</td>
            <td class="text-center px-4 py-2 hidden md:table-cell">{{ $transaksi->name }}</td>
            <td class="text-center px-4 py-2 hidden sm:table-cell">{{ $transaksi->qty }}</td>
            <td class="text-center px-4 py-2">{{ formatRupiah($transaksi->total_transaksi) }}</td>
            <td class="text-center px-4 py-2 hidden md:table-cell">{{ $transaksi->created_at }}</td>
            <td class="text-center px-4 py-2">
              <button data-id="{{ $transaksi->id }}" class="px-3 py-1.5 rounded-md border border-neutral-200 dark:border-neutral-800 hover:bg-neutral-50 dark:hover:bg-neutral-800 btn-detail">Detail</button>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
            <div class="px-4 md:px-6 py-4 bg-gray-50 dark:bg-gray-900/50 border-t border-gray-200 dark:border-gray-700">
          <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0 gap-2 md:gap-0">
              <div class="text-sm text-gray-700 dark:text-gray-300 text-center md:text-left">
                  Menampilkan <span class="font-medium">{{ $transaksis->firstItem() }}</span> sampai <span class="font-medium">{{ $transaksis->lastItem() }}</span> dari <span class="font-medium">{{ $transaksis->total() }}</span> hasil
              </div>

              <!-- Smart Pagination Component -->
              <div class="flex flex-col md:flex-row items-center space-y-3 md:space-y-0 md:space-x-4">
                  <!-- Pagination Controls -->
                  <div class="flex gap-4 items-center flex-col md:flex-row">
                      <div class="flex items-center space-x-1 sm:space-x-2">
                          <!-- First Page -->
                          <button class="group px-2 sm:px-3 py-2.5 text-sm bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200 flex items-center font-medium min-h-[44px] sm:min-h-[48px] active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed" @disabled($transaksis->onFirstPage()) onclick="window.location.href='{{ $transaksis->url(1) }}'">
                              <i data-lucide="chevrons-left" class="h-4 w-4 transition-transform duration-200 group-hover:-translate-x-0.5"></i>
                              <span class="hidden xl:inline ml-1">First</span>
                          </button>
  
                          <!-- Previous Page -->
                          <button class="group px-2 sm:px-3 py-2.5 text-sm bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200 flex items-center font-medium min-h-[44px] sm:min-h-[48px] active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed" @disabled($transaksis->onFirstPage()) onclick="window.location.href='{{ $transaksis->previousPageUrl() }}'">
                              <i data-lucide="chevron-left" class="h-4 w-4 transition-transform duration-200 group-hover:-translate-x-0.5"></i>
                              <span class="hidden lg:inline ml-1">Prev</span>
                          </button>
  
                          <div class="flex items-center space-x-1">
                              <!-- Current page -->
                              <button class="px-3 py-2.5 text-sm bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg font-medium shadow-md min-h-[48px] ring-2 ring-blue-200 dark:ring-blue-800">{{ $transaksis->currentPage() }}</button>
                          </div>
  
                          <!-- Next Page -->
                          <button class="group px-2 sm:px-3 py-2.5 text-sm bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200 flex items-center font-medium min-h-[44px] sm:min-h-[48px] active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed" @disabled($transaksis->onLastPage()) onclick="window.location.href='{{ $transaksis->nextPageUrl() }}'">
                              <span class="hidden lg:inline mr-1">Next</span>
                              <i data-lucide="chevron-right" class="h-4 w-4 transition-transform duration-200 group-hover:translate-x-0.5"></i>
                          </button>
  
                          <!-- Last Page -->
                          <button class="group px-2 sm:px-3 py-2.5 text-sm bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200 flex items-center font-medium min-h-[44px] sm:min-h-[48px] active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed" @disabled($transaksis->onLastPage()) onclick="window.location.href='{{ $transaksis->url($transaksis->lastPage()) }}'">
                              <span class="hidden xl:inline mr-1">Last</span>
                              <i data-lucide="chevrons-right" class="h-4 w-4 transition-transform duration-200 group-hover:translate-x-0.5"></i>
                          </button>
                      </div>
                      <form action="" method="GET" class="flex gap-3 items-center">
                          <span>Jump to page:</span>
                          @if ($search != '')
                          <input type="hidden" name="search" value="{{ $search }}">
                          @endif
                          <input id="inputPage" type="number" name="page" min="1" max="{{ $transaksis->lastPage() }}" class="max-w-10 py-2 border rounded-md text-center dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-foreground" value="{{ $transaksis->currentPage() }}" >
                          <button type="submit" class="bg-gradient-to-r from-blue-600 to-blue-700 py-[0.675rem] px-3 text-white rounded-md text-sm font-medium active:scale-90 transition-all">Go</button>
                      </form>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
<div id="trx-modal" class="fixed inset-0 z-50 hidden">
  <div class="absolute inset-0 bg-black/50" data-modal-overlay></div>
  <div role="dialog" aria-modal="true" aria-labelledby="trx-modal-title"
        class="relative mx-auto mt-16 w-[92%] max-w-2xl rounded-lg border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-950 shadow-xl">
    <div class="flex items-center justify-between px-4 py-3 border-b border-neutral-200 dark:border-neutral-800">
      <div>
        <h3 id="trx-modal-title" class="text-base font-semibold">Detail Transaksi</h3>
        <p id="trx-meta" class="text-xs text-muted-foreground">Kode transaksi: <span id="trxKode"></span></p>
        <p id="trx-meta" class="text-xs text-muted-foreground">Waktu: <span id="trxWaktu"></span></p>
      </div>
    </div>

    <div class="p-4">
      <div class="overflow-x-auto rounded-md border border-neutral-200 dark:border-neutral-800">
        <table id="transaksiTableModal" class="min-w-full text-sm">
          <thead class="bg-neutral-50 dark:bg-neutral-900">
            <tr>
              <th class="text-left px-3 py-2">Produk</th>
              <th class="text-center px-3 py-2">Qty</th>
              <th class="text-right px-3 py-2">Harga</th>
              <th class="text-right px-3 py-2">Total</th>
            </tr>
          </thead>
          <tbody id="trx-items">
            <tr>
              <td class="px-3 py-3 text-center text-muted-foreground" colspan="4">Memuat...</td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="mt-4 grid gap-1.5 text-sm">
        <div class="flex items-center justify-between font-semibold mb-2">
          <span>Total</span>
          <span id="trxTotal">Rp 0</span>
        </div>
        <div class="flex items-center justify-between">
          <span class="text-muted-foreground">Total Bayar</span>
          <span id="trxTotalBayar">Rp 0</span>
        </div>
        <div class="flex items-center justify-between">
          <span class="text-muted-foreground">Total Kembalian</span>
          <span id="trxTotalKembalian">Rp 0</span>
        </div>
      </div>
    </div>

    <div class="px-4 pb-4">
      <div class="flex items-center gap-2">
        <button id="trx-close-bottom" class="h-10 px-4 rounded-md bg-gradient-to-r from-blue-600 to-blue-700 text-white active:scale-90 transition-all">Selesai</button>
      </div>
    </div>
  </div>
</div>

<script>
  const transaksis = @json($transaksis)?.['data']
</script>
<script src="{{ asset('js/kasir/transaksi/script.js') }}"></script>
@endsection
