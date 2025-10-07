<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $guarded = ['id'];
    protected $table = 'transaction';
    public $timestamps = false;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    protected $appends = ['name', 'qty', 'kasir'];

    public function items()
    {
        return $this->hasMany(TransactionItem::class, 'transaction_id', 'id');
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
