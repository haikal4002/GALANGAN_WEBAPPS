<?php

namespace App\Http\Controllers;

use App\Models\MasterProduct;
use App\Models\ProductUnit;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\Supplier;
use App\Models\Cashflow;
use App\Models\TransactionCode;
use App\Models\MasterUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class StockItemController extends Controller
{
    public function index(Request $request)
    {
        // 1. Get Inventory Data with Eager Loading & Search (Optimized)
        $search = $request->get('search');

        $query = ProductUnit::with(['masterProduct:id,nama', 'masterUnit:id,nama'])
            ->select(
                'id',
                'master_product_id',
                'master_unit_id',
                'nilai_konversi',
                'is_base_unit',
                'stok',
                'harga_beli_terakhir',
                'margin',
                'harga_jual',
                'harga_atas',
                'gambar',
                'updated_at'
            );

        if ($search) {
            $query->whereHas('masterProduct', function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%');
            });
        }

        $units = $query->orderBy('updated_at', 'desc')
            ->paginate(50)
            ->withQueryString();

        // 2. Calculate Metrics (Optimized with DB aggregates)
        $totalAset = ProductUnit::selectRaw('SUM(stok * harga_beli_terakhir) as total')
            ->value('total') ?? 0;

        $totalHutang = Purchase::where('status_pembayaran', 'Belum Lunas')
            ->sum('total_nominal');

        $barangReady = ProductUnit::where('stok', '>', 0)->count();

        $avgMargin = ProductUnit::where('stok', '>', 0)
            ->avg('margin') ?? 0;

        // 3. Data for Dropdowns (Only essential columns) - Cached for 10 minutes
        $masterProducts = Cache::remember('master_products_list', 600, function () {
            return MasterProduct::select('id', 'nama')
                ->orderBy('nama', 'asc')
                ->get();
        });

        $suppliers = Cache::remember('suppliers_list', 600, function () {
            return Supplier::select('id', 'nama', 'kontak', 'alamat')
                ->orderBy('nama', 'asc')
                ->get();
        });

        $allUnits = Cache::remember('master_units_list', 600, function () {
            return MasterUnit::withCount('productUnits')
                ->orderBy('nama', 'asc')
                ->get();
        });

        return view('stock.index', compact(
            'units',
            'allUnits',
            'totalAset',
            'totalHutang',
            'barangReady',
            'avgMargin',
            'masterProducts',
            'suppliers'
        ));
    }

    // Update Price & Margin for Stock Item
    public function updateItem(Request $request, $id)
    {
        $request->validate([
            'harga_jual' => 'required|numeric|min:0',
            'harga_atas' => 'nullable|numeric|min:0',
            'stok' => 'nullable|integer|min:0',
            'master_unit_id' => 'nullable|exists:master_units,id',
            'harga_beli_terakhir' => 'nullable|numeric|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $unit = ProductUnit::findOrFail($id);

        // Recalculate margin (based on current HPP)
        $margin = 0;
        if ($unit->harga_beli_terakhir > 0) {
            $margin = (($request->harga_jual - $unit->harga_beli_terakhir) / $unit->harga_beli_terakhir) * 100;
        }

        // update harga + margin first
        $updateData = [
            'harga_jual' => $request->harga_jual,
            'harga_atas' => $request->harga_atas ?? $unit->harga_atas,
            'margin' => round($margin, 2),
        ];

        // optional stok update if provided
        if ($request->filled('stok')) {
            $updateData['stok'] = (int) $request->stok;
        }

        // optional master_unit change: ensure no duplicate for same product
        if ($request->filled('master_unit_id') && $request->master_unit_id != $unit->master_unit_id) {
            $newMasterUnitId = $request->master_unit_id;
            $exists = ProductUnit::where('master_product_id', $unit->master_product_id)
                ->where('master_unit_id', $newMasterUnitId)
                ->where('id', '!=', $unit->id)
                ->exists();

            if ($exists) {
                return redirect()->back()->with('error', 'Satuan tersebut sudah ada untuk produk ini.');
            }

            $updateData['master_unit_id'] = $newMasterUnitId;
        }

        // If harga_beli_terakhir changed, sync proportional HPP to other units
        if ($request->filled('harga_beli_terakhir')) {
            $newHpp = (float) $request->harga_beli_terakhir;

            DB::transaction(function () use ($unit, $newHpp) {
                // Sync other product units proportionally using nilai_konversi
                $baseHpp = $newHpp / max(1, $unit->nilai_konversi);
                $others = ProductUnit::where('master_product_id', $unit->master_product_id)
                    ->where('id', '!=', $unit->id)
                    ->get();

                foreach ($others as $ou) {
                    $newOuHpp = $baseHpp * $ou->nilai_konversi;
                    $ou->update([
                        'harga_beli_terakhir' => $newOuHpp,
                        'harga_jual' => $newOuHpp + ($newOuHpp * ($ou->margin ?? 0) / 100)
                    ]);
                }
            });

            // update this unit's HPP as well
            $updateData['harga_beli_terakhir'] = $newHpp;
        }

        // finally update this unit with collected data
        $unit->update($updateData);

        // handle optional gambar upload
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_update_' . $unit->id . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/products'), $filename);
            $unit->update(['gambar' => 'images/products/' . $filename]);
        }

        return redirect()->back()->with('success', 'Harga Jual & Margin berhasil diperbarui secara otomatis!');
    }

    // --- STORE METHOD (UPDATED FOR MASTER UNITS) ---
    public function store(Request $request)
    {
        // Validasi Input
        $request->validate([
            'tanggal' => 'required|date',
            'nomor_resi' => 'required|string',
            'supplier_id' => 'required|exists:suppliers,id',
            'master_product_id' => 'required|exists:master_products,id',
            'master_unit_id' => 'required|exists:master_units,id',
            'qty' => 'required|integer|min:1',
            'harga_beli' => 'required|numeric|min:0',
            'margin' => 'required|numeric|min:0',
            'harga_atas' => 'nullable|numeric|min:0',
            'status_pembayaran' => 'required|in:Lunas,Belum Lunas',
            'jatuh_tempo' => 'nullable|date',
            'nilai_konversi' => 'nullable|integer|min:1',
            'ecer_master_unit_id' => 'required_if:bisa_diecer,on|nullable|exists:master_units,id',
            'ecer_margin' => 'nullable|numeric|min:0',
            'ecer_harga_atas' => 'nullable|numeric|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ecer_gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        DB::transaction(function () use ($request) {
            $hargaJual = $request->harga_beli + ($request->harga_beli * $request->margin / 100);
            $konversi = $request->filled('nilai_konversi') ? $request->nilai_konversi : 1;

            // Handle Image Upload for Unit Utama
            $pathGambarUtama = null;
            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');
                $filename = time() . '_' . str_replace(' ', '_', strtolower($request->nomor_resi)) . '_utama.' . $file->getClientOriginalExtension();
                $file->move(public_path('images/products'), $filename);
                $pathGambarUtama = 'images/products/' . $filename;
            }

            // 1. HANDLE UNIT UTAMA
            $unitUtama = ProductUnit::where('master_product_id', $request->master_product_id)
                ->where('master_unit_id', $request->master_unit_id)
                ->first();

            if ($unitUtama) {
                $updateData = [
                    'stok' => $unitUtama->stok + $request->qty,
                    'harga_beli_terakhir' => $request->harga_beli,
                    'margin' => $request->margin,
                    'harga_jual' => $hargaJual,
                    'harga_atas' => $request->harga_atas ?? $unitUtama->harga_atas,
                    'nilai_konversi' => $konversi,
                    'is_base_unit' => $request->has('bisa_diecer') ? false : $unitUtama->is_base_unit
                ];
                if ($pathGambarUtama)
                    $updateData['gambar'] = $pathGambarUtama;

                $unitUtama->update($updateData);
            } else {
                // Tentukan is_base_unit jika belum ada
                $hasUnits = ProductUnit::where('master_product_id', $request->master_product_id)->exists();
                $isBase = $request->has('bisa_diecer') ? false : !$hasUnits;

                $unitUtama = ProductUnit::create([
                    'master_product_id' => $request->master_product_id,
                    'master_unit_id' => $request->master_unit_id,
                    'nilai_konversi' => $konversi,
                    'is_base_unit' => $isBase,
                    'stok' => $request->qty,
                    'harga_beli_terakhir' => $request->harga_beli,
                    'margin' => $request->margin,
                    'harga_jual' => $hargaJual,
                    'harga_atas' => $request->harga_atas,
                    'gambar' => $pathGambarUtama
                ]);
            }

            // 2. HANDLE UNIT ECERAN (Jika dicentang)
            if ($request->has('bisa_diecer')) {
                // Handle Image Upload for Unit Ecer
                $pathGambarEcer = null;
                if ($request->hasFile('ecer_gambar')) {
                    $file = $request->file('ecer_gambar');
                    $filename = time() . '_' . str_replace(' ', '_', strtolower($request->nomor_resi)) . '_ecer.' . $file->getClientOriginalExtension();
                    $file->move(public_path('images/products'), $filename);
                    $pathGambarEcer = 'images/products/' . $filename;
                }

                $unitEcer = ProductUnit::where('master_product_id', $request->master_product_id)
                    ->where('master_unit_id', $request->ecer_master_unit_id)
                    ->first();

                $hargaBeliEcer = $request->harga_beli / $konversi;
                $ecerMargin = $request->ecer_margin ?? $request->margin;
                $hargaJualEcer = $hargaBeliEcer + ($hargaBeliEcer * $ecerMargin / 100);

                if ($unitEcer) {
                    $updateDataEcer = [
                        'harga_beli_terakhir' => $hargaBeliEcer,
                        'margin' => $ecerMargin,
                        'harga_jual' => $hargaJualEcer,
                        'harga_atas' => $request->ecer_harga_atas ?? $unitEcer->harga_atas,
                        'nilai_konversi' => 1,
                        'is_base_unit' => true
                    ];
                    if ($pathGambarEcer)
                        $updateDataEcer['gambar'] = $pathGambarEcer;

                    $unitEcer->update($updateDataEcer);
                } else {
                    ProductUnit::create([
                        'master_product_id' => $request->master_product_id,
                        'master_unit_id' => $request->ecer_master_unit_id,
                        'nilai_konversi' => 1,
                        'is_base_unit' => true,
                        'stok' => 0,
                        'harga_beli_terakhir' => $hargaBeliEcer,
                        'margin' => $ecerMargin,
                        'harga_jual' => $hargaJualEcer,
                        'harga_atas' => $request->ecer_harga_atas,
                        'gambar' => $pathGambarEcer
                    ]);
                }
            }

            // 3. SYNC HARGA KE UNIT LAIN (PROPOSIONAL) - Optimized
            $baseHpp = $request->harga_beli / $unitUtama->nilai_konversi;
            $otherUnits = ProductUnit::where('master_product_id', $request->master_product_id)
                ->where('id', '!=', $unitUtama->id)
                ->get();

            foreach ($otherUnits as $ou) {
                $newOuHpp = $baseHpp * $ou->nilai_konversi;
                $newOuJual = $newOuHpp + ($newOuHpp * $ou->margin / 100);

                $ou->update([
                    'harga_beli_terakhir' => $newOuHpp,
                    'harga_jual' => $newOuJual
                ]);
            }

            // 4. Save Purchase Transaction
            $totalNominal = $request->qty * $request->harga_beli;

            $purchase = Purchase::create([
                'supplier_id' => $request->supplier_id,
                'nomor_resi' => $request->nomor_resi,
                'tanggal' => $request->tanggal,
                'total_nominal' => $totalNominal,
                'status_pembayaran' => $request->status_pembayaran,
                'jatuh_tempo' => $request->jatuh_tempo,
            ]);

            PurchaseDetail::create([
                'purchase_id' => $purchase->id,
                'product_unit_id' => $unitUtama->id,
                'qty' => $request->qty,
                'harga_beli_satuan' => $request->harga_beli,
                'subtotal' => $totalNominal
            ]);

            if ($request->status_pembayaran == 'Lunas') {
                $codeKeluar = TransactionCode::where('code', 'OUT-PURCHASE')->first();
                $unitName = $unitUtama->masterUnit->nama;

                Cashflow::create([
                    'tanggal' => $request->tanggal,
                    'transaction_code_id' => $codeKeluar ? $codeKeluar->id : 1,
                    'keterangan' => "Kulakan " . $unitUtama->masterProduct->nama . " (" . $request->qty . " " . $unitName . ")",
                    'debit' => 0,
                    'kredit' => $totalNominal
                ]);
            }
        });

        return redirect()->back()->with('success', 'Stok berhasil ditambahkan!');
    }

    // --- BREAK UNIT METHOD (UPDATED FOR DYNAMIC TARGET) ---
    public function breakUnit(Request $request)
    {
        $request->validate([
            'product_unit_id' => 'required|exists:product_units,id', // Source Unit (e.g., Sak)
            'target_master_unit_id' => 'required|exists:master_units,id', // Target Master Unit (e.g., Kg)
            'qty_to_break' => 'required|integer|min:1',           // Amount to open
        ]);

        DB::transaction(function () use ($request) {
            // 1. Get Source Data
            $sourceUnit = ProductUnit::findOrFail($request->product_unit_id);

            // Validation: Check stock
            if ($sourceUnit->stok < $request->qty_to_break) {
                throw new \Exception("Stok tidak cukup!");
            }

            // 2. Find or Create Target ProductUnit
            $targetUnit = ProductUnit::where('master_product_id', $sourceUnit->master_product_id)
                ->where('master_unit_id', $request->target_master_unit_id)
                ->first();

            if (!$targetUnit) {
                // Target ProductUnit belum ada, BUAT BARU
                // Hitung harga beli per unit kecil (asumsi konversi = 1 untuk unit baru/base)
                $hargaBeliPerUnit = $sourceUnit->harga_beli_terakhir / $sourceUnit->nilai_konversi;
                $hargaJual = $hargaBeliPerUnit + ($hargaBeliPerUnit * $sourceUnit->margin / 100);

                $targetUnit = ProductUnit::create([
                    'master_product_id' => $sourceUnit->master_product_id,
                    'master_unit_id' => $request->target_master_unit_id,
                    'nilai_konversi' => 1, // Unit baru default konversi 1 (base unit)
                    'is_base_unit' => true, // Jadi base unit
                    'stok' => 0,
                    'harga_beli_terakhir' => $hargaBeliPerUnit,
                    'margin' => $sourceUnit->margin,
                    'harga_jual' => $hargaJual,
                ]);
            }

            // 3. Calculate Conversion Quantity
            // Formula: (Qty Open * Source Conversion) / Target Conversion
            // Example: 1 Sak (50) -> Kg (1). Result = (1 * 50) / 1 = 50.
            $qtyResult = ($request->qty_to_break * $sourceUnit->nilai_konversi) / $targetUnit->nilai_konversi;

            // 4. Update Stocks
            $sourceUnit->decrement('stok', $request->qty_to_break);
            $targetUnit->increment('stok', $qtyResult);

            // 5. Update Target HPP (Cost Price)
            // Recalculate cost based on the source unit's cost
            $newHpp = $sourceUnit->harga_beli_terakhir / ($sourceUnit->nilai_konversi / $targetUnit->nilai_konversi);
            $newHargaJual = $newHpp + ($newHpp * $targetUnit->margin / 100);
            $targetUnit->update([
                'harga_beli_terakhir' => $newHpp,
                'harga_jual' => $newHargaJual
            ]);
        });

        return redirect()->back()->with('success', 'Konversi berhasil!');
    }


    // Delete a product unit (variant) from inventory
    public function destroyUnit($id)
    {
        return $this->destroy($id);
    }

    public function destroy($id)
    {
        $unit = ProductUnit::findOrFail($id);

        // Prevent deletion if used in purchase details
        $isUsed = PurchaseDetail::where('product_unit_id', $id)->exists();
        if ($isUsed) {
            return redirect()->back()->with('error', 'Satuan tidak bisa dihapus karena sudah tercatat dalam transaksi pembelian.');
        }

        if ($unit->stok > 0) {
            return redirect()->back()->with('error', 'Hapus gagal: stok harus 0 terlebih dahulu.');
        }

        $unit->delete();
        return redirect()->back()->with('success', 'Data satuan/stok berhasil dihapus!');
    }
}

