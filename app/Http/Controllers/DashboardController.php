<?php

namespace App\Http\Controllers;

use App\Models\StockItem;
use App\Models\MasterProduct;
use App\Models\SalesLog;
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

        $stocks = StockItem::all();

        // 1. Total Aset Stok
        $totalAset = $stocks->sum('nominal');

        // 2. Total Belum Lunas
        $totalHutang = $stocks->where('status_pembayaran', '!=', 'Lunas')->sum('nominal');

        // 3. Barang Ready
        $barangReady = $stocks->where('qty', '>', 0)->count();
        $stokKosong = $stocks->where('qty', '<=', 0)->count();

        // 4. Rata-rata Margin
        $avgMargin = $stocks->avg('margin') ?? 0;

        // Insights & Data Tambahan
        $skuAktif = MasterProduct::count();
        $lowStockCount = StockItem::lowStock(20)->count();

        // Data Produk Terlaris
        $topProducts = SalesLog::with(['stockItem.masterProduct'])
            ->select('stock_item_id', DB::raw('SUM(qty_terjual) as total_qty'), DB::raw('SUM(subtotal) as total_revenue'))
            ->groupBy('stock_item_id')
            ->orderBy('total_revenue', 'desc')
            ->take(5)
            ->get();

        // Data Chart Bulanan
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

        // Isi array 1-12
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
