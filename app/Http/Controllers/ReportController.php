<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PosTransactionItem;
use App\Models\ProductUnit;
use App\Models\Cashflow;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Set locale ke Indonesia untuk format bulan
        \App::setLocale('id');

        // 1. Tentukan Bulan Laporan (Default: Bulan Ini)
        $month = $request->get('month', date('m'));
        $year = $request->get('year', date('Y'));

        $currentDate = Carbon::createFromDate($year, $month, 1);
        $monthName = $currentDate->translatedFormat('F Y');

        // ==========================================
        // TABEL 1: LAPORAN BULANAN BARANG TERJUAL
        // ==========================================

        // Ambil semua item yang terjual di bulan ini
        $salesItems = PosTransactionItem::with(['productUnit.masterProduct', 'productUnit.masterUnit'])
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->get();

        // Grouping berdasarkan Product ID untuk menghitung total per barang
        $reportItems = $salesItems->groupBy('product_unit_id')->map(function ($items) {
            $firstItem = $items->first();

            // Cek jika relasi ada untuk menghindari error
            $productName = optional($firstItem->productUnit->masterProduct)->nama ?? 'Produk Dihapus';
            $unitName = optional($firstItem->productUnit->masterUnit)->nama ?? '-';

            $fullName = $productName . ' (' . $unitName . ')';

            $totalQty = $items->sum('qty');
            $totalOmset = $items->sum('subtotal'); // Harga Jual Total

            // Perkiraan Modal (HPP saat ini * Qty Terjual)
            $hppSatuan = optional($firstItem->productUnit)->harga_beli_terakhir ?? 0;
            $totalModal = $hppSatuan * $totalQty;

            $laba = $totalOmset - $totalModal;

            return [
                'name' => $fullName,
                'qty' => $totalQty,
                'modal' => $totalModal,
                'omset' => $totalOmset,
                'laba' => $laba
            ];
        })->values();

        // Hitung Subtotal Tabel 1
        $subtotalBarang = [
            'qty' => $reportItems->sum('qty'),
            'modal' => $reportItems->sum('modal'),
            'omset' => $reportItems->sum('omset'),
            'laba' => $reportItems->sum('laba'),
        ];

        // ==========================================
        // TABEL 2: LAPORAN KEUANGAN BULANAN
        // ==========================================

        // A. Total Pemasukan KHUSUS dari Penjualan (Agar tidak tercampur modal masuk/pinjaman)
        $codeSales = \App\Models\TransactionCode::where('code', 'IN-SALES')->first();
        $totalPemasukan = Cashflow::whereYear('tanggal', $year)
            ->whereMonth('tanggal', $month)
            ->when($codeSales, function ($q) use ($codeSales) {
                return $q->where('transaction_code_id', $codeSales->id);
            })
            ->sum('debit');

        // B. Total Pengeluaran Operasional (Kode OUT-OPR)
        $codeOpr = \App\Models\TransactionCode::where('code', 'OUT-OPR')->first();
        $totalOperasional = 0;

        if ($codeOpr) {
            $totalOperasional = Cashflow::whereYear('tanggal', $year)
                ->whereMonth('tanggal', $month)
                ->where('transaction_code_id', $codeOpr->id)
                ->sum('kredit');
        }

        // C. Total Modal Barang Terjual (HPP)
        $totalHPP = $subtotalBarang['modal'];

        // D. Net Profit (Laba Bersih)
        $netProfit = $totalPemasukan - ($totalOperasional + $totalHPP);

        return view('report.index', compact(
            'monthName',
            'month',
            'year',
            'reportItems',
            'subtotalBarang',
            'totalPemasukan',
            'totalOperasional',
            'totalHPP',
            'netProfit'
        ));
    }

    public function export(Request $request)
    {
        $year = $request->get('year', date('Y'));
        $fileName = "Ringkasan_Keuangan_{$year}.csv";

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = ['Bulan', 'Total Pemasukan (Omset)', 'Total Operasional', 'Total HPP (Modal Barang)', 'Net Profit (Laba Bersih)'];

        $callback = function () use ($year, $columns) {
            $file = fopen('php://output', 'w');
            fputs($file, "\xEF\xBB\xBF"); // BOM for UTF-8

            fputcsv($file, ["LAPORAN RINGKASAN KEUANGAN TAHUN $year"]);
            fputcsv($file, ["Dicetak pada: " . Carbon::now()->format('d/m/Y H:i')]);
            fputcsv($file, []);
            fputcsv($file, $columns);

            $codeSales = \App\Models\TransactionCode::where('code', 'IN-SALES')->first();
            $codeOpr = \App\Models\TransactionCode::where('code', 'OUT-OPR')->first();

            $grandTotal = ['pemasukan' => 0, 'operasional' => 0, 'hpp' => 0, 'net' => 0];

            for ($m = 1; $m <= 12; $m++) {
                $pemasukan = Cashflow::whereYear('tanggal', $year)
                    ->whereMonth('tanggal', $m)
                    ->when($codeSales, function ($q) use ($codeSales) {
                        return $q->where('transaction_code_id', $codeSales->id);
                    })
                    ->sum('debit');

                $operasional = 0;
                if ($codeOpr) {
                    $operasional = Cashflow::whereYear('tanggal', $year)
                        ->whereMonth('tanggal', $m)
                        ->where('transaction_code_id', $codeOpr->id)
                        ->sum('kredit');
                }

                $hpp = PosTransactionItem::whereYear('created_at', $year)
                    ->whereMonth('created_at', $m)
                    ->get()
                    ->sum(function ($item) {
                        return ($item->productUnit->harga_beli_terakhir ?? 0) * $item->qty;
                    });

                $netProfit = $pemasukan - ($operasional + $hpp);
                $monthName = Carbon::createFromDate($year, $m, 1)->translatedFormat('F');

                fputcsv($file, [
                    $monthName,
                    $pemasukan,
                    $operasional,
                    $hpp,
                    $netProfit
                ]);

                $grandTotal['pemasukan'] += $pemasukan;
                $grandTotal['operasional'] += $operasional;
                $grandTotal['hpp'] += $hpp;
                $grandTotal['net'] += $netProfit;
            }

            fputcsv($file, []);
            fputcsv($file, [
                'TOTAL TAHUNAN',
                $grandTotal['pemasukan'],
                $grandTotal['operasional'],
                $grandTotal['hpp'],
                $grandTotal['net']
            ]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}