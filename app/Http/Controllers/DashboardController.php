<?php

namespace App\Http\Controllers;

use App\Models\ProductUnit; // Model Baru
use App\Models\MasterProduct;
use App\Models\SalesLog;
use App\Models\Purchase; // Untuk hitung hutang
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $selectedYear = $request->get('year', date('Y'));

        // Ambil semua tahun yang tersedia di data penjualan untuk filter
        $availableYears = SalesLog::selectRaw('YEAR(tanggal_jual) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        // Jika data kosong, tambahkan tahun sekarang
        if (empty($availableYears)) {
            $availableYears = [date('Y')];
        }

        // Ambil semua data stok (Inventory Real)
        $units = ProductUnit::all();

        // 2. Hitung Metrik Dashboard
        // Total Aset Stok (Stok * Harga Beli Terakhir)
        $totalAset = $units->sum(function ($unit) {
            return $unit->stok * $unit->harga_beli_terakhir;
        });

        // Total Belum Lunas (Ambil dari Header Pembelian/Purchase)
        $totalHutang = Purchase::where('status_pembayaran', 'Belum Lunas')->sum('total_nominal');

        // Barang Ready & Kosong
        $barangReady = $units->where('stok', '>', 0)->count();
        $stokKosong = $units->where('stok', '<=', 0)->count();

        // Rata-rata Margin
        $avgMargin = $units->avg('margin') ?? 0;

        // Insights
        $skuAktif = $units->count(); // Jumlah varian aktif
        $lowStockCount = $units->where('stok', '<=', 20)->count(); // Stok menipis

        // 3. Data Produk Terlaris (Top 5 Revenue)
        // Relasi: SalesLog -> ProductUnit -> MasterProduct
        $topProducts = SalesLog::with(['productUnit.masterProduct'])
            ->select('product_unit_id', DB::raw('SUM(qty_terjual) as total_qty'), DB::raw('SUM(subtotal) as total_revenue'))
            ->groupBy('product_unit_id')
            ->orderBy('total_revenue', 'desc')
            ->take(5)
            ->get();

        // 4. Data Chart Bulanan (Omset)
        $monthlySales = SalesLog::select(
            DB::raw('MONTH(tanggal_jual) as month'),
            DB::raw('SUM(subtotal) as total')
        )
            ->whereYear('tanggal_jual', $selectedYear)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('total', 'month')
            ->toArray();

        // Isi array 1-12 dengan 0 jika tidak ada data
        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[] = $monthlySales[$i] ?? 0;
        }

        return view('dashboard', compact(
            'totalAset',
            'totalHutang',
            'barangReady',
            'avgMargin',
            'skuAktif',
            'stokKosong',
            'lowStockCount',
            'topProducts',
            'chartData',
            'selectedYear',
            'availableYears'
        ));
    }
}
