<?php

namespace App\Http\Controllers\Admin\Obat;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Obat\StoreRequest;
use App\Models\Obat;

class Post extends Controller
{
    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        $data['kode_barcode'] = $this->generateUniqueEAN13();
        
        Obat::create($data);
        
        return redirect()->route('obat.index')->with('success', 'Obat berhasil ditambahkan!');
    }       
    private function generateUniqueEAN13()
    {
        do {
            $barcode = $this->generateEAN13();
        } while (Obat::where('kode_barcode', $barcode)->exists());

        return $barcode;
    }

    private function generateEAN13($prefix = '912', $companyCode = '34810', $productId = null)
    {
        // Jika tidak ada productId, generate random 4 digit
        if ($productId === null) {
            $productId = str_pad((string)mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);
        }

        // Gabungkan 12 digit awal
        $partial = $prefix . $companyCode . $productId;

        // Hitung check digit (modulus 10)
        $checkDigit = $this->calculateEAN13CheckDigit($partial);

        return $partial . $checkDigit;
    }

    private function calculateEAN13CheckDigit($number)
    {
        $digits = str_split($number);
        $sum = 0;

        foreach ($digits as $i => $d) {
            $sum += ($i % 2 === 0 ? $d : $d * 3);
        }

        $mod = $sum % 10;
        return $mod === 0 ? 0 : 10 - $mod;
    }

}
