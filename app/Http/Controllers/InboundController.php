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
    public function index(InboundDataTable $dataTable)
    {

        $items = Item::all();

        return $dataTable->render('admin.inbound.index', compact('items'));
    }
    public function show($id)
    {
        // $item = BaseModel::findOrFail($id);
        // return view('admin.inbound.show', compact('item'));
    }
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validated = $request->validate([
                'item_id' => 'required|uuid|exists:items,id',
                'quantity' => 'required|integer|min:0',
                'received_date' => 'required|date',
            ], [
                'item_id.required' => 'Nama barang wajib dipilih.',
                'item_id.uuid' => 'Format ID barang tidak valid.',
                'item_id.exists' => 'Barang yang dipilih tidak ditemukan.',

                'quantity.required' => 'Jumlah barang wajib diisi.',
                'quantity.integer' => 'Jumlah harus berupa angka.',
                'quantity.min' => 'Jumlah minimal 0.',

                'received_date.required' => 'Tanggal masuk wajib diisi.',
                'received_date.date' => 'Tanggal masuk tidak valid.',
            ]);

            $validated['supplier'] = 'SELF';

            $inbound = BaseModel::create($validated);

            DB::commit();
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Barang Masuk berhasil ditambahkan',
                    'data' => $inbound
                ]);
            }

            return redirect()->route('inbound.index')->with('success', 'Inbound created successfully');
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
                    'message' => 'Gagal menambahkan barang masuk. Silakan coba lagi.'
                ], 500);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan barang masuk. Silakan coba lagi.');
        }
    }
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $validated = $request->validate([
                'item_id' => 'required|uuid|exists:items,id',
                'quantity' => 'required|integer|min:0',
                'received_date' => 'required|date',
            ], [
                'item_id.required' => 'Nama barang wajib dipilih.',
                'item_id.uuid' => 'Format ID barang tidak valid.',
                'item_id.exists' => 'Barang yang dipilih tidak ditemukan.',

                'quantity.required' => 'Jumlah barang wajib diisi.',
                'quantity.integer' => 'Jumlah harus berupa angka.',
                'quantity.min' => 'Jumlah minimal 0.',

                'received_date.required' => 'Tanggal masuk wajib diisi.',
                'received_date.date' => 'Tanggal masuk tidak valid.',
            ]);

            $inbound = BaseModel::findOrFail($id);
            $item = Item::findOrFail($inbound->item_id);

            $oldQty = $inbound->quantity;
            $newQty = $validated['quantity'];

            if ($oldQty != $newQty) {
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

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Barang Masuk berhasil diperbarui',
                    'data' => $inbound
                ]);
            }

            return redirect()->route('inbound.index')->with('success', 'Inbound updated successfully');
        }catch (\Illuminate\Validation\ValidationException $e) {
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
                    'message' => 'Gagal menambahkan barang masuk. Silakan coba lagi.'
                ], 500);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan barang masuk. Silakan coba lagi.');
        }
    }
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $inbound = BaseModel::findOrFail($id);
            $inbound->delete();

            DB::commit();

             if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Barang Masuk berhasil dihapus',
                ]);
            }
            return redirect()->route('inbound.index')->with('success', 'Inbound deleted successfully');
        } catch (\Throwable $th) {
            DB::rollBack();

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus barang: ' . $th->getMessage(),
                ], 500);
            }
            return redirect()->route('inbound.index')->with('error', 'Error: ' . $th->getMessage());
        }
    }
}
