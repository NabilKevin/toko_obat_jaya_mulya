<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    protected $guarded = ['id'];
    protected $table = 'transactionitem';
    public $timestamps = false;
    protected $fillable = [
        'obat_id', 'transaction_id', 'harga_modal',
        'harga_jual', 'qty', 'subtotal'
    ];
    public function obat()
    {
        return $this->belongsTo(Obat::class, 'obat_id', 'id');
    }
    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'id');
    }
}


