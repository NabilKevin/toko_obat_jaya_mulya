@extends('admin.layouts.app')

@section('title', 'Laporan - Toko Obat Jaya Mulya')
@section('page-title', 'Laporan')

@section('content')
    @if (session('error'))
        <div
            class="alert error absolute p-4 bg-red-700/50 text-red-500 border rounded-md border-red-600 text-center top-[12%] left-1/2 -translate-x-1/2 z-50 alertAnimate">
            {{ session('error') ?? 'Error!' }}
        </div>
    @endif
    <div class="p-3 sm:p-4 lg:p-6 space-y-4 sm:space-y-6">


        <div class="mt-6">
  <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">
    Laporan Total Modal dan Penjualan per Obat
  </h3>

  <div class="overflow-x-auto rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
      <thead class="bg-gray-100 dark:bg-gray-800">
        <tr>
          <th class="px-4 py-3 text-left font-medium text-gray-700 dark:text-gray-300">No</th>
          <th class="px-4 py-3 text-left font-medium text-gray-700 dark:text-gray-300">Nama Obat</th>
          <th class="px-4 py-3 text-right font-medium text-gray-700 dark:text-gray-300">Total Modal</th>
          <th class="px-4 py-3 text-right font-medium text-gray-700 dark:text-gray-300">Total Penjualan</th>
          <th class="px-4 py-3 text-right font-medium text-gray-700 dark:text-gray-300">Keuntungan</th>
        </tr>
      </thead>

      <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
        @forelse ($totalModalperobat as $index => $obat)
          <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-all">
            <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $index + 1 }}</td>
            <td class="px-4 py-2 font-medium text-gray-900 dark:text-gray-100">{{ $obat->obat->nama ?? '-' }}</td>
            <td class="px-4 py-2 text-right text-gray-700 dark:text-gray-300">
              {{ formatRupiah($obat->total_modal_per_obat) }}
            </td>
            <td class="px-4 py-2 text-right text-gray-700 dark:text-gray-300">
              {{ formatRupiah($obat->total_penjualan_per_obat) }}
            </td>
            <td class="px-4 py-2 text-right font-semibold text-green-600 dark:text-green-400">
              {{ formatRupiah($obat->total_penjualan_per_obat - $obat->total_modal_per_obat) }}
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="px-4 py-3 text-center text-gray-500 dark:text-gray-400">
              Belum ada data transaksi
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>


    </div>

    {{-- <script>
        const totalPenjualanLabels = @json($totalPenjualanLabels).reverse();
        const totalPenjualanTotals = @json($totalPenjualanTotals).reverse();

        const totalModalLabels = @json($totalModalLabels).reverse();
        const totalModalTotals = @json($totalModalTotals).reverse();

        const totalKeuntunganLabels = @json($totalKeuntunganLabels).reverse();
        const totalKeuntunganTotals = @json($totalKeuntunganTotals).reverse();
    </script> --}}

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/admin/dashboard/chart.js') }}"></script>
@endsection
