<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionReturn extends Model
{
    protected $table = 'transaction_returns';

    protected $fillable = [
        'transaction_id',
        'transaction_item_id',
        'user_id',
        'qty',
        'amount',
        'reason',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function item()
    {
        return $this->belongsTo(TransactionItem::class, 'transaction_item_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
