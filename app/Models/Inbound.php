<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;

class Inbound extends BaseModel
{
    protected $table = 'inbounds';

    protected static function booted(){
        static::created(function ($inbound) {
            $stockMovement = StockMovement::create([
                'item_id' => $inbound->item_id,
                'quantity' => $inbound->quantity,
                'type' => 'masuk',
                'inbound_id' => $inbound->id,
                'movement_date' => $inbound->received_date,
            ]);

            $item = Item::find($inbound->item_id);
            if ($item) {
                $item->stock += $inbound->quantity;
                $item->save();
            }
        });

        static::updated(function ($inbound) {
            $stockMovement = StockMovement::where('inbound_id', $inbound->id)->first();
            if ($stockMovement) {
                $stockMovement->update([
                    'item_id' => $inbound->item_id,
                    'quantity' => $inbound->quantity,
                    'movement_date' => $inbound->received_date,
                ]);
            }
        });

        static::deleting(function ($inbound) {
            $stockMovement = StockMovement::where('inbound_id', $inbound->id)->first();
            if ($stockMovement) {
                $stockMovement->delete();
            }

            $item = Item::find($inbound->item_id);
            if ($item) {
                $item->stock -= $inbound->quantity;
                $item->save();
            }
        });
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}