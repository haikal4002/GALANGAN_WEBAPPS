<?php

namespace App\Http\Controllers;

use App\Models\StockItem;
use App\Models\MasterProduct;
use App\Models\Supplier;
use Illuminate\Http\Request;

class StockItemController extends Controller
{
    public function index()
    {
        // Ambil data stok dengan relasi produk dan supplier
        // Urutkan dari yang terbaru
        $stocks = StockItem::with(['masterProduct', 'supplier'])
            ->latest('tanggal')
            ->get();

        // Hitung Data untuk Kartu Metrik (Sama seperti dashboard)
        $totalAset = $stocks->sum('nominal'); // Total uang belanja stok
        // Asumsi hitung yang belum lunas
        $totalHutang = $stocks->where('status_pembayaran', '!=', 'Lunas')->sum('nominal');
        $barangReady = $stocks->where('qty', '>', 0)->count();
        $avgMargin = $stocks->avg('margin');

        $masterProducts = MasterProduct::orderBy('nama', 'asc')->get();

        $suppliers = Supplier::orderBy('nama', 'asc')->get();

        return view('stock.index', compact('stocks', 'totalAset', 'totalHutang', 'barangReady', 'avgMargin', 'masterProducts', 'suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'nomor_resi' => 'required|string|max:255',
            'master_product_id' => 'required|exists:master_products,id',
            'stok_awal' => 'required|integer|min:0',
            'qty' => 'required|integer|min:0', // Qty Saat Ini
            'harga_beli' => 'required|numeric|min:0',
            'margin' => 'required|numeric|min:0',
            'harga_atas' => 'nullable|numeric|min:0',
            'supplier_id' => 'required|exists:suppliers,id',
            'status_pembayaran' => 'required|in:Lunas,Belum Lunas',
            'status_barang' => 'required|string',
            'jatuh_tempo' => 'nullable|date',
            'qty_kulak' => 'nullable|integer|min:0',
        ]);

        // Rumus: Harga Beli + (Harga Beli * Margin / 100)
        $hargaJual = $request->harga_beli + ($request->harga_beli * $request->margin / 100);

        // Hitung Nominal (Total Aset barang ini)
        $nominal = $request->qty * $request->harga_beli;

        // Simpan ke Database
        StockItem::create([
            'tanggal' => $request->tanggal,
            'nomor_resi' => $request->nomor_resi,
            'master_product_id' => $request->master_product_id,
            'stok_awal' => $request->stok_awal,
            'qty' => $request->qty,
            'harga_beli' => $request->harga_beli,
            'nominal' => $nominal,
            'margin' => $request->margin,
            'harga_jual' => $hargaJual,
            'harga_atas' => $request->harga_atas ?? 0,
            'supplier_id' => $request->supplier_id,
            'status_pembayaran' => $request->status_pembayaran,
            'status_barang' => $request->status_barang,
            'jatuh_tempo' => $request->jatuh_tempo,
            'qty_kulak' => $request->qty_kulak ?? 0,
        ]);

        return redirect()->back()->with('success', 'Data stok berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'nomor_resi' => 'required|string|max:255',
            'master_product_id' => 'required|exists:master_products,id',
            'stok_awal' => 'required|integer|min:0',
            'qty' => 'required|integer|min:0',
            'harga_beli' => 'required|numeric|min:0',
            'margin' => 'required|numeric|min:0',
            'harga_atas' => 'nullable|numeric|min:0',
            'supplier_id' => 'required|exists:suppliers,id',
            'status_pembayaran' => 'required|in:Lunas,Belum Lunas',
            'status_barang' => 'required|string',
            'jatuh_tempo' => 'nullable|date',
            'qty_kulak' => 'nullable|integer|min:0',
        ]);

        $stock = StockItem::findOrFail($id);

        $hargaJual = $request->harga_beli + ($request->harga_beli * $request->margin / 100);
        $nominal = $request->qty * $request->harga_beli;

        $stock->update([
            'tanggal' => $request->tanggal,
            'nomor_resi' => $request->nomor_resi,
            'master_product_id' => $request->master_product_id,
            'stok_awal' => $request->stok_awal,
            'qty' => $request->qty,
            'harga_beli' => $request->harga_beli,
            'nominal' => $nominal,
            'margin' => $request->margin,
            'harga_jual' => $hargaJual,
            'harga_atas' => $request->harga_atas ?? 0,
            'supplier_id' => $request->supplier_id,
            'status_pembayaran' => $request->status_pembayaran,
            'status_barang' => $request->status_barang,
            'jatuh_tempo' => $request->jatuh_tempo,
            'qty_kulak' => $request->qty_kulak ?? 0,
        ]);

        return redirect()->back()->with('success', 'Data stok berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $stock = StockItem::findOrFail($id);

        // Cek jika sudah ada penjualan terkait (SalesLog)
        if ($stock->salesLogs()->count() > 0) {
            return redirect()->back()->with('error', 'Gagal menghapus! Barang ini sudah memiliki riwayat penjualan.');
        }

        $stock->delete();
        return redirect()->back()->with('success', 'Data stok berhasil dihapus!');
    }

    public function storeMasterProduct(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|unique:master_products,nama|max:255'
        ]);
        MasterProduct::create([
            'nama' => strtoupper($request->nama)
        ]);
        return redirect()->back()->with('success', 'Master Barang berhasil ditambahkan!');
    }

    public function destroyMasterProduct($id)
    {
        $product = MasterProduct::findOrFail($id);

        // Cek apakah barang sudah digunakan di stok
        if ($product->stockItems()->count() > 0) {
            return redirect()->back()->with('error', 'Gagal menghapus! Barang ini sudah memiliki riwayat stok.');
        }

        $product->delete();
        return redirect()->back()->with('success', 'Master Barang berhasil dihapus!');
    }

    public function storeSupplier(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|unique:suppliers,nama|max:255'
        ]);

        // Kita simpan Nama saja sesuai desain Quick Add
        // Pastikan kolom kontak & alamat di database 'nullable' atau beri nilai default '-'
        Supplier::create([
            'nama' => strtoupper($request->nama),
            'kontak' => '-', // Default karena form hanya input nama
            'alamat' => '-'  // Default karena form hanya input nama
        ]);

        return redirect()->back()->with('success', 'Supplier berhasil ditambahkan!');
    }

    public function destroySupplier($id)
    {
        $supplier = Supplier::findOrFail($id);

        // Cek apakah supplier sudah digunakan di stok
        if ($supplier->stockItems()->count() > 0) {
            return redirect()->back()->with('error', 'Gagal menghapus! Supplier ini sudah terkait dengan data stok.');
        }

        $supplier->delete();
        return redirect()->back()->with('success', 'Supplier berhasil dihapus!');
    }

}