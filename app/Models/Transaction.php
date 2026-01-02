<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $guarded = ['id'];
    protected $table = 'transaction';
    public $timestamps = false;

    protected $fillable = [
        'kode',
        'status',
        'total_transaksi',
        'total_dibayar',
        'total_kembalian',
        'void_reason',
        'user_id',
        'void_by'
    ];

    

    


    protected $appends = ['name', 'qty', 'kasir'];

    public function items()
    {
        return $this->hasMany(TransactionItem::class, 'transaction_id', 'id');
    }

    public function returns()
{
    return $this->hasMany(TransactionReturn::class);
}
/* ===============================
     | VOID BY USER
     =============================== */
    public function voidBy()
    {
        return $this->belongsTo(User::class, 'void_by');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getNameAttribute()
    {
        return $this->items->pluck('obat.nama')->implode(', ');
    }

    public function getQtyAttribute()
    {
        return $this->items->sum('qty');
    }

    public function getKasirAttribute()
    {
        return $this->user ? $this->user->nama : '-';
    }
}
