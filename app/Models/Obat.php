<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    protected $guarded = ['id'];
    protected $table = 'obat';
    protected $fillable = [
        'kode_barcode',
        'nama',
        'stok',
        'tipe_id',
        'harga_modal',
        'harga_jual',
        'expired_at', // ← WAJIB ADA
    ];

    protected $casts = [
        'expired_at' => 'date', // ← PENTING
    ];
    
    public function tipe() {
        return $this->belongsTo(TipeObat::class, 'tipe_id', 'id');
    }
}
