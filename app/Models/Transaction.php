<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $guarded = ['id'];
    protected $table = 'transaction';
    public $timestamps = false;

    public function items() 
    {
        return $this->hasMany(TransactionItem::class, 'transaction_id', 'id');
    }

    protected $appends = ['name', 'qty'];

    public function getNameAttribute()
    {
        return $this->items->pluck('obat.nama')->implode(', ');
    }

    public function getQtyAttribute()
    {
        return $this->items->sum('qty');
    }
}
