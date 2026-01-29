<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cashflow;
use App\Models\TransactionCode;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CashflowController extends Controller
{
    public function index(Request $request)
    {
        \App::setLocale('id');

        $searchQuery = $request->query('q');

        // 1. Hitung Saldo Saat Ini (Total Debit - Total Kredit)
        $totalDebit = Cashflow::sum('debit');
        $totalKredit = Cashflow::sum('kredit');
        $saldoSaatIni = $totalDebit - $totalKredit;

        // 2. Hitung Profit Bulan Ini (Hanya dari penjualan & pengeluaran, abaikan modal)
        $currentMonth = Carbon::now();
        $profitBulanIni = Cashflow::whereYear('tanggal', $currentMonth->year)
            ->whereMonth('tanggal', $currentMonth->month)
            ->whereHas('transactionCode', function ($q) {
                $q->where('code', '!=', 'IN-MODAL'); // Kecualikan Modal Awal
            })
            ->sum(DB::raw('debit - kredit'));

        // 3. Ambil Data Mutasi (Tabel Utama)
        // Kita ambil 100 transaksi terakhir, kecualikan kode khusus 'OUT-LAINYA'
        $cashflowsQuery = Cashflow::with('transactionCode')
            ->whereHas('transactionCode', function ($q) {
                $q->where('code', '!=', 'OUT-LAINYA');
            });

        if (!empty($searchQuery)) {
            $cashflowsQuery->where('keterangan', 'like', '%' . $searchQuery . '%');
        }

        $cashflows = $cashflowsQuery
            ->orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc')
            ->limit(100)
            ->get();

        // LOGIKA SALDO BERJALAN (Running Balance) untuk Tabel
        // Karena kita menampilkan dari terbaru (desc), kita harus menghitung mundur atau
        // cara paling mudah: set saldo awal = saldo akhir, lalu dikurangi/ditambah iterasi.
        $tempSaldo = $saldoSaatIni;
        foreach ($cashflows as $cf) {
            $cf->saldo_berjalan = $tempSaldo;
            // Kembalikan ke saldo sebelumnya (Reverse logic)
            // Jika transaksi ini Debit (nambah), berarti saldo sebelumnya lebih kecil
            // Jika transaksi ini Kredit (kurang), berarti saldo sebelumnya lebih besar
            $tempSaldo = $tempSaldo - $cf->debit + $cf->kredit;
        }

        // 4. Data untuk Sidebar (Ringkasan Performa 12 Bulan Terakhir)
        // Kita hitung profit murni (tanpa modal) dan omset murni (tanpa modal)
        $monthlyStats = Cashflow::select(
            DB::raw('DATE_FORMAT(tanggal, "%Y-%m") as month_raw'),
            DB::raw('SUM(CASE WHEN transaction_codes.code != "IN-MODAL" THEN debit ELSE 0 END) as omset'),
            DB::raw('SUM(CASE WHEN transaction_codes.code != "IN-MODAL" THEN debit - kredit ELSE -kredit END) as profit')
        )
            ->join('transaction_codes', 'cashflows.transaction_code_id', '=', 'transaction_codes.id')
            ->groupBy('month_raw')
            ->orderBy('month_raw', 'desc')
            ->limit(12)
            ->get()
            ->map(function ($item) {
                $item->month_label = Carbon::parse($item->month_raw . '-01')->translatedFormat('F Y');
                return $item;
            });

        // 5. Daftar Kode Transaksi untuk Dropdown (sembunyikan kode khusus 'OUT-LAINYA')
        $codes = TransactionCode::orderBy('code', 'asc')
            ->where('code', '!=', 'OUT-LAINYA')
            ->get();

        return view('cashflow.index', compact(
            'saldoSaatIni',
            'profitBulanIni',
            'cashflows',
            'codes',
            'monthlyStats'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'transaction_code_id' => 'required|exists:transaction_codes,id',
            'keterangan' => 'required|string|max:255',
            'amount' => 'required|numeric|min:1',
        ]);

        $code = TransactionCode::find($request->transaction_code_id);

        // Logika Otomatis: Jika kode diawali "IN-" maka Masuk (Debit)
        // Jika tidak (biasanya "OUT-"), maka Keluar (Kredit)
        $isDebit = str_starts_with(strtoupper($code->code), 'IN-');

        Cashflow::create([
            'tanggal' => $request->tanggal,
            'transaction_code_id' => $request->transaction_code_id,
            'keterangan' => strtoupper($request->keterangan),
            'debit' => $isDebit ? $request->amount : 0,
            'kredit' => !$isDebit ? $request->amount : 0,
        ]);

        return redirect()->back()->with('success', 'Data mutasi berhasil disimpan!');
    }
}