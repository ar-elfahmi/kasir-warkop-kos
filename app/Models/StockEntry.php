<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockEntry extends Model
{
    use HasFactory;

    protected $fillable = ['menu_item_id', 'quantity', 'note'];

    public function menuItem()
    {
        return $this->belongsTo(MenuItem::class);
    }
}
