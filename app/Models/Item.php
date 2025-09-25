<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;

class Item extends BaseModel
{
    protected $table = 'items';

    public function inbounds()
    {
        return $this->hasMany(Inbound::class, 'item_id');
    }

    public function outbounds()
    {
        return $this->hasMany(Outbound::class, 'item_id');
    }

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class, 'item_id');
    }
}