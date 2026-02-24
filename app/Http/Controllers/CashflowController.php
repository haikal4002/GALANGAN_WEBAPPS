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

        // selected month/year for profit filter (default: current)
        $selectedYear = (int) $request->query('year', $currentMonth->year);
        $selectedMonth = (int) $request->query('month', $currentMonth->month);

        $profitBulanIni = Cashflow::whereYear('tanggal', $selectedYear)
            ->whereMonth('tanggal', $selectedMonth)
            ->whereHas('transactionCode', function ($q) {
                $q->where('code', '!=', 'IN-MODAL'); // Kecualikan Modal Awal
            })
            ->sum(DB::raw('debit - kredit'));

        // 3. Ambil Data Mutasi (Tabel Utama)
        $order = strtolower($request->query('order', 'desc')) === 'asc' ? 'asc' : 'desc';

        $cashflowsQuery = Cashflow::with('transactionCode')
            ->whereHas('transactionCode', function ($q) {
                $q->where('insidentil', '!=', 1);
            });

        if (!empty($searchQuery)) {
            $cashflowsQuery->where('keterangan', 'like', '%' . $searchQuery . '%');
        }

        // ambil data (paginate) sesuai order yang diminta
        $cashflows = $cashflowsQuery
            ->orderBy('tanggal', $order)
            ->orderBy('id', $order)
            ->paginate(50)
            ->withQueryString();

        // LOGIKA SALDO BERJALAN (Running Balance) untuk Tabel
        if ($cashflows->isNotEmpty()) {
            // Urutkan koleksi secara kronologis (oldest -> newest) agar saldo dihitung berurutan
            $items = $cashflows->getCollection();
            $chron = $items->sort(function ($a, $b) {
                if ($a->tanggal === $b->tanggal) {
                    return $a->id <=> $b->id;
                }
                return $a->tanggal <=> $b->tanggal;
            })->values();

            // Ambil baris pertama secara kronologis di halaman ini
            $firstChron = $chron->first();

            // Hitung saldo awal riil sebelum transaksi pertama di halaman ini.
            // Gunakan query bersih tanpa filter list agar saldo mencerminkan kondisi kas sebenarnya.
            $running = Cashflow::where(function ($q) use ($firstChron) {
                $q->where('tanggal', '<', $firstChron->tanggal)
                    ->orWhere(function ($q2) use ($firstChron) {
                        $q2->where('tanggal', $firstChron->tanggal)
                            ->where('id', '<', $firstChron->id);
                    });
            })->sum(DB::raw('debit - kredit'));

            // Hitung saldo berjalan akumulatif untuk item di halaman ini
            foreach ($chron as $cf) {
                $running += ($cf->debit - $cf->kredit);
                $cf->saldo_berjalan = $running;
            }
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
            ->where('insidentil', '!=', '1')
            ->get();

        return view('cashflow.index', compact(
            'saldoSaatIni',
            'profitBulanIni',
            'cashflows',
            'codes',
            'monthlyStats',
            'selectedMonth',
            'selectedYear'
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

    // Edit form
    public function edit($id)
    {
        $cf = Cashflow::with('transactionCode')->findOrFail($id);
        $codes = TransactionCode::orderBy('code', 'asc')->get();
        return view('cashflow.edit', compact('cf', 'codes'));
    }

    // Update action
    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'transaction_code_id' => 'required|exists:transaction_codes,id',
            'keterangan' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
        ]);

        $cf = Cashflow::findOrFail($id);

        $code = TransactionCode::find($request->transaction_code_id);
        $isDebit = str_starts_with(strtoupper($code->code), 'IN-');

        $cf->update([
            'tanggal' => $request->tanggal,
            'transaction_code_id' => $request->transaction_code_id,
            'keterangan' => strtoupper($request->keterangan),
            'debit' => $isDebit ? $request->amount : 0,
            'kredit' => !$isDebit ? $request->amount : 0,
        ]);

        return redirect()->route('cashflow.index')->with('success', 'Data mutasi berhasil diperbarui!');
    }

    // Delete a cashflow entry
    public function destroy($id)
    {
        $cf = Cashflow::findOrFail($id);
        $cf->delete();
        return redirect()->route('cashflow.index')->with('success', 'Mutasi kas berhasil dihapus.');
    }
}