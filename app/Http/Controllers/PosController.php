<?php

namespace App\Http\Controllers;

use App\Models\ProductUnit;
use App\Models\PosTransaction;
use App\Models\PosTransactionItem;
use App\Models\Cashflow;
use App\Models\TransactionCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PosController extends Controller
{
    public function index()
    {
        // Ambil data produk yang stoknya > 0 dan memiliki harga jual
        // Kita format datanya agar mudah dibaca oleh Javascript (Alpine.js)
        $products = ProductUnit::with(['masterProduct', 'masterUnit'])
            ->where('stok', '>', 0)
            ->where('harga_jual', '>', 0)
            ->orderBy('updated_at', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->masterProduct->nama,
                    'unit' => $item->masterUnit->nama,
                    'price' => $item->harga_jual,
                    'stock' => $item->stok,
                    // Gambar placeholder (bisa diganti nanti jika ada fitur upload gambar)
                    'image' => 'https://ui-avatars.com/api/?name=' . urlencode($item->masterProduct->nama) . '&background=random&size=128'
                ];
            });

        $storeProfile = [
            'name' => 'BANGUNTRACK STORE',
            'address' => 'Jl. Raya Bangunan Utama No. 123',
            'phone' => '(021) 555-0192'
        ];

        return view('pos.index', compact('products', 'storeProfile'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'cart' => 'required|array|min:1',
            'payment_method' => 'required|string',
            'cash_received' => 'required|numeric',
        ]);

        try {
            $transaction = DB::transaction(function () use ($request) {
                $cart = $request->cart;
                $totalAmount = 0;

                // 1. Hitung Total & Validasi Stok Lagi (Untuk keamanan)
                foreach ($cart as $item) {
                    $product = ProductUnit::find($item['id']);
                    if (!$product || $product->stok < $item['qty']) {
                        throw new \Exception("Stok barang " . ($product->masterProduct->nama ?? 'Unknown') . " tidak mencukupi!");
                    }
                    // Gunakan harga dari database untuk keamanan (mencegah manipulasi harga dari frontend)
                    $totalAmount += $product->harga_jual * $item['qty'];
                }

                // 2. Buat Nomor Transaksi Unik (TRX-TahunBulanTanggal-Random)
                $noTrx = 'TRX-' . date('Ymd') . '-' . rand(1000, 9999);

                // 3. Simpan Header Transaksi
                $trx = PosTransaction::create([
                    'no_trx' => $noTrx,
                    'user_id' => Auth::id(),
                    'total_amount' => $totalAmount,
                    'payment_method' => $request->payment_method,
                    'bayar_amount' => $request->cash_received,
                    'kembalian' => $request->cash_received - $totalAmount,
                ]);

                // 4. Simpan Detail Item, KURANGI STOK, & Catat Sales Log
                foreach ($cart as $item) {
                    $product = ProductUnit::find($item['id']);
                    $itemTotal = $product->harga_jual * $item['qty'];

                    // Kurangi Stok
                    $product->decrement('stok', $item['qty']);

                    // Simpan Detail Transaksi
                    PosTransactionItem::create([
                        'pos_transaction_id' => $trx->id,
                        'product_unit_id' => $item['id'],
                        'qty' => $item['qty'],
                        'harga_satuan' => $product->harga_jual,
                        'subtotal' => $itemTotal,
                    ]);
                }

                return $trx;
            });

            // Load data untuk dikirim balik ke frontend (untuk cetak nota)
            $transaction->load(['items.productUnit.masterProduct', 'items.productUnit.masterUnit']);

            return response()->json([
                'status' => 'success',
                'message' => 'Transaksi berhasil disimpan!',
                'data' => $transaction
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function history(Request $request)
    {
        // Dukung filter tanggal (start, end), format YYYY-MM-DD
        $start = $request->query('start');
        $end = $request->query('end');

        $query = PosTransaction::with(['items.productUnit.masterProduct', 'user']);

        if ($start) {
            $query->whereDate('created_at', '>=', $start);
        }
        if ($end) {
            $query->whereDate('created_at', '<=', $end);
        }

        $transactions = $query->orderBy('created_at', 'desc')
            ->limit(200)
            ->get()
            ->map(function ($t) {
                return [
                    'id' => $t->id,
                    'no_trx' => $t->no_trx,
                    'user' => $t->user->name ?? null,
                    'total_amount' => $t->total_amount,
                    'created_at' => $t->created_at,
                    'items' => $t->items->map(function ($it) {
                        return [
                            'name' => $it->productUnit->masterProduct->nama ?? 'Unknown',
                            'qty' => $it->qty,
                            'harga_satuan' => $it->harga_satuan,
                            'subtotal' => $it->subtotal,
                        ];
                    }),
                ];
            });

        return response()->json([
            'status' => 'success',
            'data' => $transactions
        ]);
    }

    // Tampilan halaman history (HTML)
    public function historyPage(Request $request)
    {
        // Support export CSV via ?export=csv&start=...&end=...
        if ($request->query('export') === 'csv') {
            $start = $request->query('start');
            $end = $request->query('end');

            $query = PosTransaction::query();
            if ($start)
                $query->whereDate('created_at', '>=', $start);
            if ($end)
                $query->whereDate('created_at', '<=', $end);

            $rows = $query->orderBy('created_at', 'desc')->get();

            $csv = "no_trx,tanggal,kasir,total_amount\n";
            foreach ($rows as $r) {
                $csv .= sprintf("%s,%s,%s,%s\n", $r->no_trx, $r->created_at->toDateTimeString(), $r->user->name ?? '-', $r->total_amount);
            }

            return response($csv, 200, [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="pos_history_export.csv"'
            ]);
        }

        return view('pos.history');
    }

    // JSON detail endpoint untuk modal
    public function detail($id)
    {
        $t = PosTransaction::with(['items.productUnit.masterProduct', 'user'])->findOrFail($id);
        $data = [
            'id' => $t->id,
            'no_trx' => $t->no_trx,
            'user' => $t->user->name ?? null,
            'total_amount' => $t->total_amount,
            'created_at' => $t->created_at,
            'items' => $t->items->map(function ($it) {
                return [
                    'name' => $it->productUnit->masterProduct->nama ?? 'Unknown',
                    'qty' => $it->qty,
                    'harga_satuan' => $it->harga_satuan,
                    'subtotal' => $it->subtotal,
                ];
            }),
        ];

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }


}