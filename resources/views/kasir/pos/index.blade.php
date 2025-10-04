@extends('kasir.layouts.app')

@section('title', 'POS - Kasir')

@section('content')
  <div id="alert" class="hidden alert success absolute p-4 bg-green-700/50 text-green-500 border rounded-md border-green-600 text-center top-[12%] left-1/2 -translate-x-1/2 z-50">
  </div>
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
    <section class="lg:col-span-2">
      <div class="rounded-lg border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-950 p-3">
        <div class="flex gap-2 flex-col">
          <input id="search" name="search" placeholder="Masukkan nama obat/kode barcode..." class="flex-1 h-10 py-3 rounded-md border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-900 px-3 text-sm focus:ring-2 focus:ring-primary" />
          <div class="flex gap-2 w-100">  
            <button id="start-scan" class="grow h-10 px-4 rounded-md border border-neutral-200 dark:border-neutral-800 hover:bg-neutral-50 dark:hover:bg-neutral-800">Scan</button>
          </div>
        </div>
      </div>


      <div class="mt-4 rounded-lg border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-950 overflow-hidden">
        <div class="px-4 py-2 text-sm font-medium">Katalog</div>
        <div id="tableObats" class="divide-y divide-neutral-100 dark:divide-neutral-800 overflow-auto">
          @foreach ($obats as $obat)
            <div class="flex items-center justify-between px-4 pb-3 py-4 my-4">
              <div>
                <div class="font-medium">{{ $obat['nama'] }}</div>
                <div class="font-medium mb-2">{{ formatRupiah($obat['harga']) }}</div>
                <div class="text-xs text-neutral-500">Stok: {{ $obat['stok'] }}</div>
              </div>
              <button data-id="{{ $obat['id'] }}" class="btn-tambah text-sm px-3 py-1.5 rounded-md border border-neutral-200 dark:border-neutral-800 hover:bg-neutral-50 dark:hover:bg-neutral-800">Tambah</button>
            </div>
          @endforeach
        </div>
      </div>
    </section>

    <aside class="lg:col-span-1">
      <div class="rounded-lg border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-950">
        <div class="px-4 py-3 border-b border-neutral-200 dark:border-neutral-800 font-medium">Keranjang</div>
        <div class="px-4 py-3 overflow-x-auto">
          <table class="w-full text-sm" id="carts">
            <thead class="text-xs text-neutral-600 dark:text-neutral-300">
              <tr class="border-b border-neutral-200 dark:border-neutral-800">
                <th class="text-center py-2 pr-2">Produk</th>
                <th class="text-center py-2 px-2">Qty</th>
                <th class="text-center py-2 px-2">Harga</th>
                <th class="text-center py-2 pl-2">Total</th>
                <th class="py-2 pl-2 text-center">Aksi</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-neutral-100 dark:divide-neutral-800">
            </tbody>
          </table>
          <h1 class="text-center mt-3 font-medium alert-text-table">Tidak ada produk di keranjang!</h1>
        </div>
        <div class="flex flex-col gap-2 px-4">
          <input id="inputTotalBayar" placeholder="Total dibayar..." type="text" class="flex-1 h-10 py-3 rounded-md border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-900 px-3 text-sm focus:ring-2 focus:ring-primary">
        </div>
        <div class="p-4 space-y-1 text-sm">
          <div class="flex justify-between font-semibold">
            <span>Total</span>
            <span>Rp <span id="textTotal">0</span></span>
          </div>
          <div class="flex justify-between !mt-4">
            <span>Total bayar</span>
            <span>Rp <span id="textTotalBayar">0</span></span>
          </div>
          <div class="flex justify-between">
            <span>Total kembalian</span>
            <span>Rp <span id="textTotalKembalian">0</span></span>
          </div>
        </div>
        <div class="p-4 pt-0">
          <button id="btnBayar" class="w-full h-10 rounded-md bg-gradient-to-r from-blue-600 to-blue-700 transition-all active:scale-95 text-white">Bayar</button>
        </div>
      </div>
    </aside>
  </div>
  
  <div id="previewCamera" class="absolute z-50 flex inset-0 hidden bg-black/50">
    <div id="reader" class="m-auto" style="width: 100%; max-width: 400px; display:block;"></div>
  </div>

  <script>
    const obats = @json($obats); 
  </script>
  <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
  <script src="{{ asset('js/kasir/pos/tambah-data.js') }}"></script>
  <script src="{{ asset('js/barcode-scanner.js') }}"></script>
  <script src="{{ asset('js/kasir/pos/scan.js') }}"></script>
  <script src="{{ asset('js/kasir/pos/getData.js') }}"></script>
  <script src="{{ asset('js/kasir/pos/storeData.js') }}"></script>
@endsection