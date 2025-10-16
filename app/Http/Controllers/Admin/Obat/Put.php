<?php

namespace App\Http\Controllers\Admin\Obat;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Obat\UpdateRequest;
use App\Models\Obat;
use Illuminate\Validation\ValidationException;

class Put extends Controller
{
    public function update(UpdateRequest $request, $id)
    {
        $data = $request->validated();
        $obat = Obat::find($id);

        if (!$obat) {
            return redirect()->back()->with("error", "Obat tidak ditemukan!");
        }

        // Jika kode_barcode diubah, pastikan tidak duplikat
        if (isset($data['kode_barcode']) && $data['kode_barcode'] !== $obat->kode_barcode) {
            $exists = Obat::where('kode_barcode', $data['kode_barcode'])->where('id', '!=', $id)->exists();
            if ($exists) {
                throw ValidationException::withMessages([
                    'kode_barcode' => 'Kode barcode sudah digunakan oleh obat lain.',
                ]);
            }
        }

        // Hapus field kosong agar tidak menimpa dengan null
        $filtered = array_filter($data, function ($value) {
            return !is_null($value) && $value !== '';
        });

        $obat->update($filtered);

        return redirect()->route('admin.obat')->with('success', 'Obat berhasil diedit!');
    }
}
