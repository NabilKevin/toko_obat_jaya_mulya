<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    protected $guarded = ['id'];
    protected $table = 'transactionitem';
    public function obat()
    {
        return $this->belongsTo(Obat::class, 'obat_id', 'id');
    }
}
