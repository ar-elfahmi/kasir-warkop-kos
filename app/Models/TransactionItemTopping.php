<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionItemTopping extends Model
{
    use HasFactory;

    protected $fillable = ['transaction_item_id', 'topping_id', 'topping_name', 'topping_price'];
}
