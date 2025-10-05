<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    protected $guarded = ['id'];
    protected $table = 'obat';
    
    public function tipe() {
        return $this->belongsTo(TipeObat::class, 'tipe_id', 'id');
    }
}
