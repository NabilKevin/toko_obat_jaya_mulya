<?php

namespace App\Http\Requests\Admin\Obat;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
  public function rules()
  {
    return [
      'kode_barcode' => 'string|size:13',
      'nama' => 'max:255',
      'stok' => 'integer',
      'tipe_id' => 'exists:tipeobat,id',
      'harga_modal' => 'integer',
      'harga_jual' => 'integer',
    ];
  }
}
