@extends('kasir.layouts.app')

@section('page-title', 'Struk')

@section('content')
<div class="flex justify-center py-8">
    <div id="strukArea"
        class="bg-white dark:bg-gray-900 p-6 rounded-xl shadow-md w-[280px] text-sm print:w-full print:shadow-none print:p-0">

        {{-- === STYLE PRINT KHUSUS STRUK === --}}
        <style>
            @font-face {
                font-family: 'DotMatrix';
                src: local('Courier New'), local('Consolas'), monospace;
            }

            @media print {
                @page {
                    size: 58mm auto;
                    margin: 0;
                }

                body {
                    width: 52mm;
                    margin: 0;
                    padding: 0;
                    background: #fff;
                    font-family: 'DotMatrix', monospace;
                    font-size: 10.2px; /* sedikit diperbesar agar lebih terbaca */
                    line-height: 1.3;
                    color: #000;
                    font-weight: 900;
                    letter-spacing: 0px;
                    -webkit-print-color-adjust: exact;
                    print-color-adjust: exact;
                    image-rendering: pixelated;
                    -webkit-font-smoothing: none;
                    -moz-osx-font-smoothing: grayscale;
                    font-smooth: never;
                    text-rendering: geometricPrecision;
                    transform-origin: top left;
                }

                /* Hanya area struk yang dicetak */
                body * {
                    visibility: hidden;
                }

                #strukArea,
                #strukArea * {
                    visibility: visible;
                }

                #strukArea {
                    position: absolute;
                    left: 0;
                    top: 0;
                    width: 52mm;
                    padding: 2mm;
                    background: #fff;
                    transform: scale(0.96);
                    transform-origin: top left;
                    box-shadow: none;
                    border: none;
                }

                .no-print {
                    display: none !important;
                }

                table {
                    width: 100%;
                    border-collapse: collapse;
                    font-size: 10px;
                }

                td {
                    padding: 1px 0;
                    vertical-align: top;
                }

                /* Efek tajam dan tebal seperti printer kasir */
                * {
                    color: #000 !important;
                    font-weight: 900 !important;
                    text-shadow:
                        0 0 0.6px #000,
                        0 0 0.6px #000,
                        0 0 0.6px #000;
                }

                /* Garis putus-putus */
                .border-dashed {
                    border-top: 1px dashed #000 !important;
                }

                /* Hilangkan warna dark mode */
                .dark\:bg-gray-900 {
                    background: #fff !important;
                }

                /* Rata tengah tajam */
                .text-center {
                    text-align: center;
                    letter-spacing: 0.15px;
                }

                /* Biar hasil tidak blur pada printer thermal */
                img {
                    image-rendering: pixelated;
                }
            }
        </style>

        {{-- === AREA STRUK === --}}
        <div class="struk font-mono text-gray-800 dark:text-gray-100">
            <div class="text-center font-bold text-base">
                <div>Toko Obat Jaya Mulya</div>
                <div class="text-[11px] font-mono font-normal mt-1 leading-tight">
                    Jl. Swadaya No.04 8, RT.8/RW.12, Jatinegara, Kec. Cakung,<br>
                    Kota Jakarta Timur, DKI Jakarta 13930
                </div>
            </div>

            <div class="border-t border-dashed border-gray-400 my-2"></div>

            {{-- Info Transaksi --}}
            <table class="w-full text-[10px] mb-1">
                <tr>
                    <td>No. Transaksi</td>
                    <td class="text-right">{{ $transaction->kode }}</td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td class="text-right">{{ date('d/m/Y H:i:s', strtotime($transaction->created_at)) }}</td>
                </tr>
                <tr>
                    <td>Kasir</td>
                    <td class="text-right">{{ $transaction->kasir ?? 'Kasir' }}</td>
                </tr>
            </table>

            <div class="border-t border-dashed border-gray-400 my-2"></div>

            {{-- Detail Barang --}}
            <table class="w-full text-[10px]">
                @foreach ($transaction->items as $item)
                <tr>
                    <td style="width: 60%;">{{ $item->obat->nama }}</td>
                    <td style="width: 10%; text-align: center;">x{{ $item->qty }}</td>
                    <td style="width: 30%; text-align: right;">{{ formatRupiah($item->subtotal) }}</td>
                </tr>
                @endforeach
            </table>

            <div class="border-t border-dashed border-gray-400 my-2"></div>

            {{-- Total --}}
            <table class="w-full text-[10px]">
                <tr>
                    <td>Total</td>
                    <td class="text-right">{{ formatRupiah($transaction->total_transaksi) }}</td>
                </tr>
                <tr>
                    <td>Tunai</td>
                    <td class="text-right">{{ formatRupiah($transaction->total_dibayar) }}</td>
                </tr>
                <tr>
                    <td>Kembali</td>
                    <td class="text-right">{{ formatRupiah($transaction->total_kembalian) }}</td>
                </tr>
            </table>

            <div class="border-t border-dashed border-gray-400 my-2"></div>

            {{-- Pesan --}}
            <div class="text-center text-[10px]">
                <p>Terima Kasih!</p>
                <p>Semoga Lekas Sembuh</p>
            </div>

            <div class="border-t border-dashed border-gray-400 my-2"></div>

            <div class="text-center text-[9px] mt-2 italic">
                <p>Struk ini merupakan bukti pembayaran yang sah</p>
            </div>

            <div class="border-t border-dashed border-gray-400 my-2"></div>

            {{-- Powered by EasyFlow --}}
            <div class="text-center text-[10px] mt-1 font-bold">
                <p>Powered by EasyFlow</p>
            </div>
        </div>

        {{-- === TOMBOL AKSI (TIDAK DICETAK) === --}}
        <div class="no-print text-center mt-6 flex justify-center gap-3">
            <button onclick="window.print()"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                Print Struk
            </button>
            <a href="{{ route('kasir.transaksi') }}"
                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                Selesai
            </a>
        </div>
    </div>
</div>
@endsection
