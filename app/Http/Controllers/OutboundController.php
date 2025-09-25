<?php

namespace App\Http\Controllers;

use App\DataTables\InboundDataTable;
use App\DataTables\ItemDataTable;
use App\DataTables\OutboundDataTable;
use Dflydev\DotAccessData\Data;
use App\Models\Item as BaseModel;
use App\Models\Item;
use Illuminate\Http\Request;
use Yajra\DataTables\Services\DataTable;

class OutboundController extends Controller
{
    public function index(OutboundDataTable $dataTable){

        return $dataTable->render('admin.outbound.index');
    }
    public function show($id){
        // $item = BaseModel::findOrFail($id);
        // return view('admin.outbound.show', compact('item'));
    }
    public function store(Request $request){
        $validated = $request->validate([
            'item_id' => 'required|uuid|exists:items,id',
            'quantity' => 'required|integer|min:0',
            'shipping_date' => 'required|date',
        ]);

        BaseModel::create([
            'item_id' => $validated['item_id'],
            'quantity' => $validated['quantity'],
            'shipping_date' => $validated['shipping_date'],
            'supplier' => 'SELF',
        ]);

        return redirect()->route('outbound.index')->with('success', 'Outbound created successfully');
    }
    public function update(Request $request, $id){
        $validated = $request->validate([
            'item_id' => 'required|uuid|exists:items,id',
            'quantity' => 'required|integer|min:0',
            'shipping_date' => 'required|date',
        ]);

        $outbound = BaseModel::findOrFail($id);
        $item = Item::findOrFail($outbound->item_id);

        $oldQty = $outbound->quantity;
        $newQty = $validated['quantity'];

        if($oldQty != $newQty){
            $diff = $newQty - $oldQty;
            $item->stock += $diff;
            $item->save();

            $outbound->update([
                'item_id' => $validated['item_id'],
                'quantity' => $newQty,
                'shipping_date' => $validated['shipping_date'],
            ]);
        }

        $outbound->update($validated);

        return redirect()->route('outbound.index')->with('success', 'Outbound updated successfully');
    }
    public function destroy($id){
        $item = BaseModel::findOrFail($id);
        $item->delete();

        return redirect()->route('outbound.index')->with('success', 'Outbound deleted successfully');
    }
}
