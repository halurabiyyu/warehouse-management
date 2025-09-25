<?php

namespace App\Http\Controllers;

use App\DataTables\ItemDataTable;
use Dflydev\DotAccessData\Data;
use App\Models\Item as BaseModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Services\DataTable;

class ItemController extends Controller
{
    public function index(ItemDataTable $dataTable){

        return $dataTable->render('admin.items.index');
    }
    public function show($id){
        // $item = BaseModel::findOrFail($id);
        // return view('admin.items.show', compact('item'));
    }
    public function store(Request $request){
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:items,code',
            'name' => 'required|string|max:255',
            'size' => 'required|string',
        ]);

        BaseModel::create([
            'code' => $validated['code'],
            'name' => $validated['name'],
            'size' => $validated['size'],
            'stock' => 0, // Initialize stock to 0
        ]);

        return redirect()->route('items.index')->with('success', 'Item created successfully');
    }
    public function update(Request $request, $id){
        $item = BaseModel::findOrFail($id);

        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:items,code,' . $item->id,
            'name' => 'required|string|max:255',
            'size' => 'required|string',
        ]);

        $item->update($validated);

        return redirect()->route('items.index')->with('success', 'Item updated successfully');
    }
    public function destroy($id){
        $item = BaseModel::findOrFail($id);
        $item->delete();

        return redirect()->route('items.index')->with('success', 'Item deleted successfully');
    }
}
