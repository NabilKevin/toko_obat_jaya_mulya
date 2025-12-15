<?php

namespace App\Http\Requests\Admin\Obat;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
  public function rules()
  {
    return [
        'kode_barcode' => 'required|string|max:255',
        'nama' => 'required|string|max:255',
        'stok' => 'required|integer|min:0',
        'tipe_id' => 'required|exists:tipeobat,id',
        'harga_modal' => 'required|integer|min:0',
        'harga_jual' => 'required|integer|min:0',
        'expired_at' => 'required|date', // ← WAJIB
    ];
  }
}
