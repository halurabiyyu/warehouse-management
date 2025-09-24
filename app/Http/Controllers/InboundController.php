<?php

namespace App\Http\Controllers;

use App\DataTables\InboundDataTable;
use App\DataTables\ItemDataTable;
use Dflydev\DotAccessData\Data;
use App\Models\Item as BaseModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Services\DataTable;

class InboundController extends Controller
{
    public function index(InboundDataTable $dataTable){

        return $dataTable->render('admin.inbound.index');
    }
    public function show($id){
        // $item = BaseModel::findOrFail($id);
        // return view('admin.inbound.show', compact('item'));
    }
    public function store(Request $request){
        $validated = $request->validate([
            'item_id' => 'required|uuid|exists:items,id',
            'quantity' => 'required|integer|min:0',
            'received_date' => 'required|date',
        ]);

        BaseModel::create($validated);

        return redirect()->route('inbound.index')->with('success', 'Inbound created successfully');
    }
    public function update(Request $request, $id){
        $item = BaseModel::findOrFail($id);

        $validated = $request->validate([
            'item_id' => 'required|uuid|exists:items,id',
            'quantity' => 'required|integer|min:0',
            'received_date' => 'required|date',
        ]);

        $item->update($validated);

        return redirect()->route('inbound.index')->with('success', 'Inbound updated successfully');
    }
    public function destroy($id){
        $item = BaseModel::findOrFail($id);
        $item->delete();

        return redirect()->route('inbound.index')->with('success', 'Inbound deleted successfully');
    }
}
