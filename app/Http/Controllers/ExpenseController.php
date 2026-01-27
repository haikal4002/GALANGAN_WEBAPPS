<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cashflow;
use App\Models\TransactionCode;
use Carbon\Carbon;

class ExpenseController extends Controller
{
    public function index()
    {
        // 1. Ambil Total Pengeluaran Bulan Ini (Semua yang kredit > 0)
        $totalExpense = Cashflow::whereYear('tanggal', Carbon::now()->year)
            ->whereMonth('tanggal', Carbon::now()->month)
            ->sum('kredit');

        // 2. Ambil Riwayat Pengeluaran (Limit 50 terakhir)
        $expenses = Cashflow::with('transactionCode')
            ->where('kredit', '>', 0) // Hanya pengeluaran
            ->orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc')
            ->limit(50)
            ->get();

        // 3. Ambil Daftar Kode Transaksi untuk Dropdown & Modal
        $codes = TransactionCode::orderBy('code', 'asc')->get();

        return view('expenses.index', compact('totalExpense', 'expenses', 'codes'));
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
        ]);

        TransactionCode::create([
            'code' => strtoupper($request->code),
            'label' => strtoupper($request->label),
            'color' => $request->color
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
}