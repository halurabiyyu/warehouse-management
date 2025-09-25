<?php

namespace App\Http\Controllers;

use App\DataTables\InboundDataTable;
use App\DataTables\ItemDataTable;
use Dflydev\DotAccessData\Data;
use App\Models\Inbound as BaseModel;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Services\DataTable;

class InboundController extends Controller
{
    public function index(InboundDataTable $dataTable){

        $items = Item::all();

        return $dataTable->render('admin.inbound.index', compact('items'));
    }
    public function show($id){
        // $item = BaseModel::findOrFail($id);
        // return view('admin.inbound.show', compact('item'));
    }
    public function store(Request $request){
        DB::beginTransaction();
        try {
            $validated = $request->validate([
                'item_id' => 'required|uuid|exists:items,id',
                'quantity' => 'required|integer|min:0',
                'received_date' => 'required|date',
            ]);
    
            $validated['supplier'] = 'SELF';

            $inbound = BaseModel::create($validated);

            DB::commit();
            return redirect()->route('inbound.index')->with('success', 'Inbound created successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Error creating inbound: ' . $th->getMessage());
            return redirect()->route('inbound.index')->with('error', 'Error: ' . $th->getMessage());
        }
    }
    public function update(Request $request, $id){
        DB::beginTransaction();
        try {
            $validated = $request->validate([
                'item_id' => 'required|uuid|exists:items,id',
                'quantity' => 'required|integer|min:0',
                'received_date' => 'required|date',
            ]);
    
            $inbound = BaseModel::findOrFail($id);
            $item = Item::findOrFail($inbound->item_id);
    
            $oldQty = $inbound->quantity;
            $newQty = $validated['quantity'];
    
            if($oldQty != $newQty){
                $diff = $newQty - $oldQty;
                $item->stock += $diff;
                $item->save();
    
                $inbound->update([
                    'item_id' => $validated['item_id'],
                    'quantity' => $newQty,
                    'received_date' => $validated['received_date'],          
                ]);
            }
    
            $inbound->update($validated);

            DB::commit();
            return redirect()->route('inbound.index')->with('success', 'Inbound updated successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('inbound.index')->with('error', 'Error: ' . $th->getMessage());
        }
    }
    public function destroy($id){
        DB::beginTransaction();
        try {
            $inbound = BaseModel::findOrFail($id);
            $inbound->delete();

            DB::commit();
            return redirect()->route('inbound.index')->with('success', 'Inbound deleted successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('inbound.index')->with('error', 'Error: ' . $th->getMessage());
        }
    }
}
