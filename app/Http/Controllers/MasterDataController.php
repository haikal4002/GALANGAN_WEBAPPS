<?php

namespace App\Http\Controllers;

use App\Models\MasterProduct;
use App\Models\MasterUnit;
use App\Models\ProductUnit;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MasterDataController extends Controller
{
    public function index()
    {
        // Data for Master Data Page - Cached for 10 minutes
        $masterProducts = Cache::remember('master_products_list', 600, function () {
            return MasterProduct::select('id', 'nama')
                ->orderBy('nama', 'asc')
                ->get();
        });

        $suppliers = Cache::remember('suppliers_list', 600, function () {
            return Supplier::select('id', 'nama', 'kontak', 'alamat')
                ->orderBy('nama', 'asc')
                ->get();
        });

        $allUnits = Cache::remember('master_units_list', 600, function () {
            return MasterUnit::withCount('productUnits')
                ->orderBy('nama', 'asc')
                ->get();
        });

        return view('master.index', compact('masterProducts', 'suppliers', 'allUnits'));
    }

    // --- MASTER BARANG ---

    public function storeMasterProduct(Request $request)
    {
        $request->validate(['nama' => 'required|string|unique:master_products,nama|max:255']);
        MasterProduct::create(['nama' => strtoupper($request->nama)]);
        Cache::forget('master_products_list');
        return redirect()->back()->with('success', 'Master Barang berhasil ditambahkan!');
    }

    public function updateMasterProduct(Request $request, $id)
    {
        $request->validate(['nama' => 'required|string|unique:master_products,nama,' . $id . '|max:255']);
        $product = MasterProduct::findOrFail($id);
        $product->update(['nama' => strtoupper($request->nama)]);
        Cache::forget('master_products_list');
        return redirect()->back()->with('success', 'Master Barang berhasil diperbarui!');
    }

    public function destroyMasterProduct($id)
    {
        $product = MasterProduct::findOrFail($id);
        $hasUnits = ProductUnit::where('master_product_id', $id)->exists();
        if ($hasUnits) {
            return redirect()->back()->with('error', 'Master Barang tidak bisa dihapus karena sudah memiliki data varian/satuan di stok!');
        }
        Cache::forget('master_products_list');
        $product->delete();
        return redirect()->back()->with('success', 'Master Barang berhasil dihapus!');
    }

    // --- MASTER SATUAN ---

    public function storeMasterUnit(Request $request)
    {
        $request->validate(['nama' => 'required|string|unique:master_units,nama|max:255']);
        MasterUnit::create(['nama' => strtoupper($request->nama)]);
        Cache::forget('master_units_list');
        return redirect()->back()->with('success', 'Master Satuan berhasil ditambahkan!');
    }

    public function updateMasterUnit(Request $request, $id)
    {
        $request->validate(['nama' => 'required|string|unique:master_units,nama,' . $id . '|max:255']);
        $unit = MasterUnit::findOrFail($id);
        Cache::forget('master_units_list');
        $unit->update(['nama' => strtoupper($request->nama)]);
        return redirect()->back()->with('success', 'Master Satuan berhasil diperbarui!');
    }

    public function destroyMasterUnit($id)
    {
        $unit = MasterUnit::findOrFail($id);
        $isUsed = ProductUnit::where('master_unit_id', $id)->exists();
        if ($isUsed) {
            return redirect()->back()->with('error', 'Satuan tidak bisa dihapus karena sudah digunakan dalam data stok!');
        }
        Cache::forget('master_units_list');
        $unit->delete();
        return redirect()->back()->with('success', 'Master Satuan berhasil dihapus!');
    }

    // --- SUPPLIER ---

    public function storeSupplier(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|unique:suppliers,nama|max:255',
            'kontak' => 'nullable|string|max:50',
            'alamat' => 'nullable|string|max:255',
        ]);
        Supplier::create([
            'nama' => strtoupper($request->nama),
            'kontak' => $request->kontak ?? '-',
            'alamat' => $request->alamat ?? '-'
        ]);
        Cache::forget('suppliers_list');
        return redirect()->back()->with('success', 'Supplier berhasil ditambahkan!');
    }

    public function updateSupplier(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|unique:suppliers,nama,' . $id . '|max:255',
            'kontak' => 'nullable|string|max:50',
            'alamat' => 'nullable|string|max:255',
        ]);
        $supplier = Supplier::findOrFail($id);
        $supplier->update([
            'nama' => strtoupper($request->nama),
            'kontak' => $request->kontak ?? '-',
            'alamat' => $request->alamat ?? '-'
        ]);
        Cache::forget('suppliers_list');
        return redirect()->back()->with('success', 'Supplier berhasil diperbarui!');
    }

    public function destroySupplier($id)
    {
        $supplier = Supplier::findOrFail($id);
        $hasPurchase = Purchase::where('supplier_id', $id)->exists();
        if ($hasPurchase) {
            return redirect()->back()->with('error', 'Supplier tidak bisa dihapus karena sudah memiliki riwayat transaksi pembelian!');
        }
        Cache::forget('suppliers_list');
        $supplier->delete();
        return redirect()->back()->with('success', 'Supplier berhasil dihapus!');
    }
}
