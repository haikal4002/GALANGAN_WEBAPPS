<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cashflow;
use App\Models\TransactionCode;
use Carbon\Carbon;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $searchQuery = $request->query('q');

        // month/year selection (default: current month/year)
        $selectedYear = (int) $request->query('year', Carbon::now()->year);
        $selectedMonth = (int) $request->query('month', Carbon::now()->month);

        // 1. Ambil Total Pengeluaran untuk kode yang bersifat insidentil dan kategori pengeluaran
        //    berdasarkan bulan/tahun yang dipilih (default: bulan ini)
        $totalExpense = Cashflow::whereHas('transactionCode', function ($q) {
            $q->where('kategori', 'pengeluaran')
                ->where('insidentil', true);
        })
            ->whereYear('tanggal', $selectedYear)
            ->whereMonth('tanggal', $selectedMonth)
            ->sum('kredit');

        // 2. Ambil Riwayat Pengeluaran (Limit 50 terakhir) - semua kode insidentil kategori pengeluaran
        $expensesQuery = Cashflow::with('transactionCode')
            ->where('kredit', '>', 0) // Hanya pengeluaran
            ->whereHas('transactionCode', function ($q) {
                $q->where('kategori', 'pengeluaran')
                    ->where('insidentil', true);
            });

        if (!empty($searchQuery)) {
            $expensesQuery->where('keterangan', 'like', '%' . $searchQuery . '%');
        }

        $expenses = $expensesQuery
            ->orderBy('tanggal', $order = (strtolower($request->query('order', 'desc')) === 'asc' ? 'asc' : 'desc'))
            ->orderBy('id', $order)
            ->limit(50)
            ->get();

        // 3. Ambil Daftar Kode Transaksi untuk Dropdown & Modal (hanya kode insidentil & kategori pengeluaran)
        $codes = TransactionCode::where('kategori', 'pengeluaran')
            ->where('insidentil', true)
            ->orderBy('code', 'asc')
            ->get();

        // 4. Total seluruh pengeluaran (tanpa filter waktu) untuk kode insidentil & kategori pengeluaran
        $totalExpenseAll = Cashflow::whereHas('transactionCode', function ($q) {
            $q->where('kategori', 'pengeluaran')
                ->where('insidentil', true);
        })->sum('kredit');

        return view('expenses.index', compact('totalExpense', 'expenses', 'codes', 'totalExpenseAll', 'selectedMonth', 'selectedYear'));
    }

    // Simpan Pengeluaran ke Cashflow
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'transaction_code_id' => 'required|exists:transaction_codes,id',
            'keterangan' => 'required|string|max:255',
            'amount' => 'required|numeric|min:1',
        ]);

        Cashflow::create([
            'tanggal' => $request->tanggal,
            'transaction_code_id' => $request->transaction_code_id,
            'keterangan' => strtoupper($request->keterangan),
            'debit' => 0,
            'kredit' => $request->amount, // Masuk kolom Kredit (Keluar)
        ]);

        return redirect()->back()->with('success', 'Pengeluaran berhasil dicatat!');
    }

    // --- KELOLA KODE TRANSAKSI ---

    // Tambah Kode Baru
    public function storeCode(Request $request)
    {

        $request->validate([
            'code' => 'required|string|unique:transaction_codes,code',
            'label' => 'required|string|max:50',
            'color' => 'required|string', // danger, success, primary, etc
            'kategori' => 'required|in:pemasukan,pengeluaran',
            'insidentil' => 'sometimes|boolean',
        ]);

        TransactionCode::create([
            'code' => strtoupper($request->code),
            'label' => strtoupper($request->label),
            'color' => $request->color,
            'kategori' => $request->kategori,
            'insidentil' => (int) $request->boolean('insidentil', false),
        ]);

        return redirect()->back()->with('success', 'Kategori transaksi berhasil ditambahkan!');
    }

    // Hapus Kode
    public function destroyCode($id)
    {
        // Cek apakah kode sedang dipakai di cashflow?
        $isUsed = Cashflow::where('transaction_code_id', $id)->exists();

        if ($isUsed) {
            return redirect()->back()->with('error', 'Kode tidak bisa dihapus karena sudah digunakan dalam transaksi!');
        }

        TransactionCode::destroy($id);
        return redirect()->back()->with('success', 'Kode transaksi dihapus!');
    }

    // Edit form for an expense entry (cashflow row)
    public function edit($id)
    {
        $exp = Cashflow::with('transactionCode')->findOrFail($id);
        $codes = TransactionCode::where('kategori', 'pengeluaran')->orderBy('code', 'asc')->get();
        return view('expenses.edit', compact('exp', 'codes'));
    }

    // Update expense
    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'transaction_code_id' => 'required|exists:transaction_codes,id',
            'keterangan' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
        ]);

        $exp = Cashflow::findOrFail($id);

        $exp->update([
            'tanggal' => $request->tanggal,
            'transaction_code_id' => $request->transaction_code_id,
            'keterangan' => strtoupper($request->keterangan),
            'debit' => 0,
            'kredit' => $request->amount,
        ]);

        return redirect()->route('expenses.index')->with('success', 'Pengeluaran berhasil diperbarui!');
    }

    // Delete an expense (cashflow) entry
    public function destroy($id)
    {
        $exp = Cashflow::findOrFail($id);
        $exp->delete();
        return redirect()->route('expenses.index')->with('success', 'Pengeluaran berhasil dihapus!');
    }
}