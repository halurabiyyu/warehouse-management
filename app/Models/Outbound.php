<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;

class Outbound extends BaseModel
{
    protected $table = 'outbounds';

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}