<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['total', 'payment_method', 'paid_amount', 'change_amount'];

    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }
}
