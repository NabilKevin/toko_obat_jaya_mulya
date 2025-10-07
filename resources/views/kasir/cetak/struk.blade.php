<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Struk</title>
    <style>
        body {
            font-family: "Courier New", monospace;
            background: #f4f4f4;
            padding: 20px;
            text-align: center;
        }
        .struk {
            width: 280px; /* ukuran printer thermal 58mm */
            background: #fff;
            border: 1px solid #ccc;
            margin: 0 auto;
            padding: 10px 15px;
            border-radius: 6px;
            text-align: left;
        }
        .center { text-align: center; }
        .bold { font-weight: bold; }
        .line { border-top: 1px dashed #000; margin: 8px 0; }

        .btn {
            display: inline-block;
            margin: 10px 5px;
            background: #1a73e8;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
        }
        .btn:hover { background: #1557b0; }
        .btn-secondary {
            background: #28a745;
        }
        .btn-secondary:hover {
            background: #218838;
        }

        @media print {
            body { background: #fff; }
            .btn { display: none; }
            .struk {
                border: none;
                box-shadow: none;
                margin: 0;
            }
        }
    </style>
</head>
<body>
    <div class="struk">
        <div class="center bold">
            <div>Toko Obat Jaya Mulya</div>
            <div style="font-size: 12px;">Jl. Contoh No. 123, Sukabumi</div>
        </div>

        <div class="line"></div>

        <div style="font-size: 12px;">
            <p>Tanggal: {{ \Carbon\Carbon::parse($transaction->created_at)->format('d/m/Y H:i:s') }}</p>
            <p>Kasir: {{ $transaction->kasir ?? 'Kasir' }}</p>
            <p>No. Transaksi: {{ $transaction->kode }}</p>   
        </div>

        <div class="line"></div>

        <table width="100%" style="font-size: 12px;">
            @foreach ($transaction->items as $item)
                <tr>
                    <td>{{ $item->obat->nama }}</td>
                    <td>x{{ $item->qty }}</td>
                    <td style="text-align: right;">{{ formatRupiah($item->subtotal) }}</td>
                </tr>
            @endforeach
        </table>

        <div class="line"></div>

        <table width="100%" style="font-size: 12px;">
            <tr>
                <td>Total</td>
                <td style="text-align: right;">{{ formatRupiah($transaction->total) }}</td>
            </tr>
            <tr>
                <td>Tunai</td>
                <td style="text-align: right;">{{ formatRupiah($transaction->tunai) }}</td>
            </tr>
            <tr>
                <td>Kembali</td>
                <td style="text-align: right;">{{ formatRupiah($transaction->kembali) }}</td>
            </tr>
        </table>

        <div class="line"></div>

        <div class="center" style="font-size: 12px;">
            <p>Terima Kasih!</p>
            <p>Semoga Lekas Sembuh 🙏</p>
        </div>
    </div>

    <div>
        <button class="btn" onclick="window.print()">🖨️ Print Struk</button>
        <a href="{{ route('kasir.transaksi.index') }}" class="btn btn-secondary">✅ Selesai</a>
    </div>
</body>
</html>
