<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\TransactionCode;
use App\Models\Cashflow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::with([
            'supplier:id,nama',
            'purchaseDetails' => function ($query) {
                $query->select('id', 'purchase_id', 'product_unit_id', 'qty', 'harga_beli_satuan', 'subtotal');
            },
            'purchaseDetails.productUnit:id,master_product_id,master_unit_id,nilai_konversi',
            'purchaseDetails.productUnit.masterProduct:id,nama',
            'purchaseDetails.productUnit.masterUnit:id,nama'
        ])
            ->select('id', 'supplier_id', 'nomor_resi', 'tanggal', 'total_nominal', 'status_pembayaran', 'jatuh_tempo', 'created_at')
            ->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('purchase.index', compact('purchases'));
    }

    public function markAsPaid($id)
    {
        DB::transaction(function () use ($id) {
            $purchase = Purchase::with([
                'purchaseDetails.productUnit.masterProduct:id,nama'
            ])->findOrFail($id);

            if ($purchase->status_pembayaran == 'Lunas') {
                return;
            }

            // 1. Update Status Purchase
            $purchase->update([
                'status_pembayaran' => 'Lunas'
            ]);

            // 2. Pencatatan Cashflow (Keluar)
            $codeKeluar = TransactionCode::where('code', 'OUT-PURCHASE')->first();

            // Generate keterangan dari detail barang
            $items = $purchase->purchaseDetails->map(function ($d) {
                return ($d->productUnit->masterProduct->nama ?? 'Barang') . " (x" . $d->qty . ")";
            })->implode(', ');

            Cashflow::create([
                'tanggal' => now(),
                'transaction_code_id' => $codeKeluar->id ?? null,
                'keterangan' => "Pelunasan Hutang Supplier: " . ($purchase->supplier->nama ?? '-') . " (Faktur: " . $purchase->nomor_resi . ") - Item: " . $items,
                'kredit' => $purchase->total_nominal
            ]);
        });

        return redirect()->back()->with('success', 'Transaksi berhasil dilunasi!');
    }
}
