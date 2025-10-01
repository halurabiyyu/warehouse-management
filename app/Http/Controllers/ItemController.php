<?php

namespace App\Http\Controllers;

use App\DataTables\DetailItemDataTable;
use App\DataTables\ItemDataTable;
use Dflydev\DotAccessData\Data;
use App\Models\Item as BaseModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Services\DataTable;

class ItemController extends Controller
{
    public function index(ItemDataTable $dataTable)
    {

        return $dataTable->render('admin.items.index');
    }
    public function show(DetailItemDataTable $dataTable, $id)
    {
        $item = BaseModel::findOrFail($id);

        return $dataTable->with('item_id', $id)->render('admin.items.show', compact('item'));
    }
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $validated = $request->validate([
                'code' => 'required|string|max:50|unique:items,code',
                'name' => 'required|string|max:255',
                'size' => 'required|string',
            ], [
                'code.required' => 'Nama barang wajib dipilih.',
                'code.unique' => 'Kode barang sudah digunakan.',
                'code.max' => 'Kode barang maksimal 50 karakter.',

                'name.required' => 'Nama barang wajib diisi.',
                'name.max' => 'Nama barang maksimal 255 karakter.',

                'size.required' => 'Ukuran barang wajib diisi.',
            ]);

            $item = BaseModel::create([
                'code' => $validated['code'],
                'name' => $validated['name'],
                'size' => $validated['size'],
                'stock' => 0,
            ]);

            DB::commit();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Barang berhasil ditambahkan',
                    'data' => $item
                ]);
            }

            return redirect()->route('items.index')->with('success', 'Item created successfully');
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
                    'message' => 'Gagal menambahkan barang. Silakan coba lagi. ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan barang. Silakan coba lagi.');
        }
    }
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $item = BaseModel::findOrFail($id);

            $validated = $request->validate([
                'code' => 'required|string|max:50|unique:items,code,' . $item->id,
                'name' => 'required|string|max:255',
                'size' => 'required|string',
            ], [
                'code.required' => 'Nama barang wajib dipilih.',
                'code.unique' => 'Kode barang sudah digunakan.',
                'code.max' => 'Kode barang maksimal 50 karakter.',

                'name.required' => 'Nama barang wajib diisi.',
                'name.max' => 'Nama barang maksimal 255 karakter.',

                'size.required' => 'Ukuran barang wajib diisi.',
            ]);

            $item->update($validated);

            DB::commit();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Barang berhasil diperbarui',
                    'data' => $item
                ]);
            }

            return redirect()->route('items.index')->with('success', 'Item updated successfully');
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
                    'message' => 'Gagal menambahkan barang. Silakan coba lagi.'
                ], 500);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan barang. Silakan coba lagi.');
        }
    }
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $item = BaseModel::findOrFail($id);
            $item->delete();

            DB::commit();

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Item berhasil dihapus',
                ]);
            }

            return redirect()->route('items.index')->with('success', 'Item deleted successfully');
        } catch (\Throwable $th) {
            DB::rollBack();

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus item: ' . $th->getMessage(),
                ], 500);
            }
            
            return redirect()->route('items.index')->with('error', 'Error: ' . $th->getMessage());
        }
    }
}
