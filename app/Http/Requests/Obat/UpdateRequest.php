<?php

namespace App\Http\Requests\Obat;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
  public function rules()
  {
    return [
      'kode_barcode' => 'string|size:12',
      'nama' => 'max:255',
      'stok' => 'integer',
      'tipe' => 'in:bebas,bebas terbatas,keras,narkotika,psikotropika',
      'harga_modal' => 'integer',
      'harga_jual' => 'integer',
    ];
  }
}