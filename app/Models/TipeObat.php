<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipeObat extends Model
{
    protected $guarded = ['id'];
    protected $table = "tipeobat";
    public $timestamps = false;

    public function obats() 
    {
        return $this->hasMany(Obat::class, 'tipe_id', 'id');
    }
}
