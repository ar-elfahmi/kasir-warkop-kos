<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    use HasFactory;

    protected $fillable = ['transaction_id', 'variant_id', 'item_name', 'variant_label', 'qty', 'unit_price', 'total_price'];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }

    public function toppings()
    {
        return $this->hasMany(TransactionItemTopping::class);
    }
}
