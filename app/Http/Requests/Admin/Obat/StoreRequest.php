<?php

namespace App\Http\Requests\Admin\Obat;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
  public function rules()
  {
    return [
      'kode_barcode' => 'required|size:12',
      'nama' => 'required|max:255',
      'stok' => 'required|integer',
      'tipe_id' => 'required|exists:tipeobat,id',
      'harga_modal' => 'required|integer',
      'harga_jual' => 'required|integer',
      'expired_at' => 'required',
    ];
  }
}