<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;

class StockMovement extends BaseModel
{
    protected $table = 'stock_movement';

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}