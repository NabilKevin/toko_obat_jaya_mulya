<?php

namespace App\Http\Requests\Obat;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
  public function rules()
  {
    return [
      'nama' => 'required|max:255',
      'stok' => 'required|integer',
      'tipe' => 'required|in:bebas,bebas terbatas,keras,narkotika,psikotropika',
      'harga_modal' => 'required|integer',
      'harga_jual' => 'required|integer',
      'expired_at' => 'required',
    ];
  }
}