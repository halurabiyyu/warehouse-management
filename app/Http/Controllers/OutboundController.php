<?php

namespace App\Http\Controllers;

use App\DataTables\InboundDataTable;
use App\DataTables\ItemDataTable;
use App\DataTables\OutboundDataTable;
use Dflydev\DotAccessData\Data;
use App\Models\Outbound as BaseModel;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Services\DataTable;

class OutboundController extends Controller
{
    public function index(OutboundDataTable $dataTable){
        $items = Item::all();

        return $dataTable->render('admin.outbound.index', compact('items'));
    }
    public function show($id){
        // $item = BaseModel::findOrFail($id);
        // return view('admin.outbound.show', compact('item'));
    }
    public function store(Request $request){
        DB::beginTransaction();
        try {
            $validated = $request->validate([
                'item_id' => 'required|uuid|exists:items,id',
                'quantity' => 'required|integer|min:0',
                'shipping_date' => 'required|date',
            ], [
                'item_id.required' => 'Nama barang wajib dipilih.',
                'item_id.uuid' => 'Format ID barang tidak valid.',
                'item_id.exists' => 'Barang yang dipilih tidak ditemukan.',

                'quantity.required' => 'Jumlah barang wajib diisi.',
                'quantity.integer' => 'Jumlah harus berupa angka.',
                'quantity.min' => 'Jumlah minimal 0.',

                'shipping_date.required' => 'Tanggal pengiriman wajib diisi.',
                'shipping_date.date' => 'Tanggal pengiriman tidak valid.',
            ]);
    
            $outbound = BaseModel::create([
                'item_id' => $validated['item_id'],
                'quantity' => $validated['quantity'],
                'shipping_date' => $validated['shipping_date'],
                'destination' => 'SELF',
            ]);

            DB::commit();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Barang keluar berhasil ditambahkan',
                    'data' => $outbound
                ]);
            }
    
            return redirect()->route('outbound.index')->with('success', 'Outbound created successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $e->errors()
                ], 422);
            }

            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menambahkan barang keluar. Silakan coba lagi.'
                ], 500);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan barang keluar. Silakan coba lagi.');
        }
    }
    public function update(Request $request, $id){
        DB::beginTransaction();
        try {
            $validated = $request->validate([
                'item_id' => 'required|uuid|exists:items,id',
                'quantity' => 'required|integer|min:0',
                'shipping_date' => 'required|date',
            ], [
                'item_id.required' => 'Nama barang wajib dipilih.',
                'item_id.uuid' => 'Format ID barang tidak valid.',
                'item_id.exists' => 'Barang yang dipilih tidak ditemukan.',

                'quantity.required' => 'Jumlah barang wajib diisi.',
                'quantity.integer' => 'Jumlah harus berupa angka.',
                'quantity.min' => 'Jumlah minimal 0.',

                'shipping_date.required' => 'Tanggal pengiriman wajib diisi.',
                'shipping_date.date' => 'Tanggal pengiriman tidak valid.',
            ]);
    
            $outbound = BaseModel::findOrFail($id);
            $item = Item::findOrFail($outbound->item_id);
    
            $oldQty = $outbound->quantity;
            $newQty = $validated['quantity'];
    
            if($oldQty != $newQty){
                $diff = $newQty - $oldQty;
                $item->stock -= $diff;
                $item->save();
    
                $outbound->update([
                    'item_id' => $validated['item_id'],
                    'quantity' => $newQty,
                    'shipping_date' => $validated['shipping_date'],
                ]);
            }
    
            $outbound->update($validated);

            DB::commit();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Barang keluar berhasil diperbarui',
                    'data' => $outbound
                ]);
            }
    
            return redirect()->route('outbound.index')->with('success', 'Outbound updated successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $e->errors()
                ], 422);
            }

            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menambahkan barang keluar. Silakan coba lagi.'
                ], 500);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan barang keluar. Silakan coba lagi.');
        }
    }
    public function destroy($id){
        try {
            $item = BaseModel::findOrFail($id);
            $item->delete();

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Barang Keluar berhasil dihapus',
                ]);
            }
    
            return redirect()->route('outbound.index')->with('success', 'Outbound deleted successfully');
        } catch (\Throwable $th) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus barang: ' . $th->getMessage(),
                ], 500);
            }
            return redirect()->route('outbound.index')->with('error', 'Error: ' . $th->getMessage());

        }
    }
}
