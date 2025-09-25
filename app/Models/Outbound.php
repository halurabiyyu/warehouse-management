<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;

class Outbound extends BaseModel
{
    protected $table = 'outbounds';
    protected static function booted(){
        static::created(function ($outbound) {
            $stockMovement = StockMovement::create([
                'item_id' => $outbound->item_id,
                'quantity' => $outbound->quantity,
                'type' => 'keluar',
                'outbound_id' => $outbound->id,
                'movement_date' => $outbound->shipped_date,
            ]);
        });

        static::updated(function ($outbound) {
            $stockMovement = StockMovement::where('outbound_id', $outbound->id)->first();
            if ($stockMovement) {
                $stockMovement->update([
                    'item_id' => $outbound->item_id,
                    'quantity' => $outbound->quantity,
                    'movement_date' => $outbound->shipping_date,
                ]);
            }
        });
    }
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}