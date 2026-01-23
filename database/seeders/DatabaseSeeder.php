<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Supplier;
use App\Models\Cashflow;
use App\Models\SalesLog;
use App\Models\TransactionCode;
use App\Models\MasterProduct;
use App\Models\ProductUnit;    // Model Baru
use App\Models\Purchase;       // Model Baru
use App\Models\PurchaseDetail; // Model Baru
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat User
        User::create([
            'name' => 'Admin Toko',
            'email' => 'admin@toko.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Karyawan Biasa',
            'email' => 'user@toko.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // 2. Buat Transaction Codes (PENTING: Ini data master keuangan)
        $codeMasuk = TransactionCode::create([
            'code' => 'IN-SALES',
            'label' => 'Pemasukan Penjualan',
            'color' => 'success'
        ]);

        $codeKeluar = TransactionCode::create([
            'code' => 'OUT-PURCHASE',
            'label' => 'Pengeluaran Kulakan',
            'color' => 'danger'
        ]);

        $codeOpr = TransactionCode::create([
            'code' => 'OUT-OPR',
            'label' => 'Biaya Operasional',
            'color' => 'warning'
        ]);

        // 3. Buat Supplier
        $suppliers = [];
        $supplierNames = ['PT Semen Gresik', 'Toko Cat Warna Warni', 'TB Sumber Rejeki', 'Distributor Paku Jaya'];
        foreach ($supplierNames as $name) {
            $suppliers[] = Supplier::create([
                'nama' => $name,
                'kontak' => '0812345678' . rand(0, 9),
                'alamat' => 'Jl. Raya Bangunan No. ' . rand(1, 100)
            ]);
        }

        // 4. Buat Master Product & Product Unit
        // Kita definisikan array produk beserta satuan dasarnya
        $catalog = [
            ['nama' => 'Semen Tiga Roda 40kg', 'satuan' => 'Sak'],
            ['nama' => 'Cat Tembok Dulux Putih 5kg', 'satuan' => 'Galon'],
            ['nama' => 'Paku Payung 5cm', 'satuan' => 'Kg'],
            ['nama' => 'Pasir Lumajang', 'satuan' => 'Pick Up'],
            ['nama' => 'Bata Merah', 'satuan' => 'Pcs']
        ];

        $units = [];

        foreach ($catalog as $item) {
            // A. Buat Master Product (Induk)
            $master = MasterProduct::create(['nama' => $item['nama']]);

            // B. Buat Satuan Dasar (Unit) - Stok awal 0
            $units[] = ProductUnit::create([
                'master_product_id' => $master->id,
                'satuan' => $item['satuan'],
                'nilai_konversi' => 1,
                'is_base_unit' => true,
                'stok' => 0, // Nanti diisi lewat simulasi pembelian
                'harga_beli_terakhir' => 0,
                'margin' => 0,
                'harga_jual' => 0,
            ]);
        }

        // 5. SIMULASI KULAKAN (PURCHASING)
        // Kita looping setiap unit barang untuk dibelikan stoknya
        foreach ($units as $unit) {

            $supplier = $suppliers[array_rand($suppliers)];
            $qtyBeli = rand(50, 200);
            $hargaBeliSatuan = rand(10000, 100000);
            $totalBelanja = $qtyBeli * $hargaBeliSatuan;
            $tanggalBeli = Carbon::now()->subDays(rand(10, 30));

            // A. Buat Header Pembelian (Purchase)
            $purchase = Purchase::create([
                'supplier_id' => $supplier->id,
                'nomor_resi' => 'INV-' . strtoupper(uniqid()),
                'tanggal' => $tanggalBeli,
                'total_nominal' => $totalBelanja,
                'status_pembayaran' => 'Lunas',
                'jatuh_tempo' => Carbon::now()->addDays(30),
            ]);

            // B. Buat Detail Pembelian (PurchaseDetail)
            PurchaseDetail::create([
                'purchase_id' => $purchase->id,
                'product_unit_id' => $unit->id,
                'qty' => $qtyBeli,
                'harga_beli_satuan' => $hargaBeliSatuan,
                'subtotal' => $totalBelanja
            ]);

            // C. Update Stok & Harga di ProductUnit
            // Hitung harga jual otomatis (Margin 20%)
            $margin = 20;
            $hargaJual = $hargaBeliSatuan + ($hargaBeliSatuan * $margin / 100);

            $unit->update([
                'stok' => $unit->stok + $qtyBeli, // Tambah stok
                'harga_beli_terakhir' => $hargaBeliSatuan,
                'margin' => $margin,
                'harga_jual' => $hargaJual,
                'harga_atas' => $hargaJual * 1.1 // Markup 10% dari harga jual
            ]);

            // D. Catat Cashflow Keluar (Uang Belanja)
            Cashflow::create([
                'tanggal' => $tanggalBeli,
                'transaction_code_id' => $codeKeluar->id,
                'keterangan' => "Kulakan " . $unit->masterProduct->nama . " (" . $qtyBeli . " " . $unit->satuan . ")",
                'debit' => 0,
                'kredit' => $totalBelanja
            ]);

            // 6. SIMULASI PENJUALAN (SALES)
            // Jual barang ini beberapa kali secara acak
            for ($i = 0; $i < rand(3, 8); $i++) {
                $qtyJual = rand(1, 5);

                // Pastikan stok cukup
                if ($unit->stok >= $qtyJual) {
                    $tglJual = Carbon::parse($tanggalBeli)->addDays(rand(1, 10));
                    $subtotalJual = $qtyJual * $unit->harga_jual;

                    // A. Catat Sales Log
                    SalesLog::create([
                        'product_unit_id' => $unit->id,
                        'tanggal_jual' => $tglJual,
                        'qty_terjual' => $qtyJual,
                        'harga_satuan' => $unit->harga_jual,
                        'subtotal' => $subtotalJual
                    ]);

                    // B. Kurangi Stok Unit
                    $unit->decrement('stok', $qtyJual);

                    // C. Catat Cashflow Masuk (Pendapatan)
                    Cashflow::create([
                        'tanggal' => $tglJual,
                        'transaction_code_id' => $codeMasuk->id,
                        'keterangan' => "Penjualan " . $unit->masterProduct->nama,
                        'debit' => $subtotalJual,
                        'kredit' => 0
                    ]);
                }
            }
        }

        // 7. Cashflow Tambahan (Operasional)
        Cashflow::create([
            'tanggal' => Carbon::now()->subDays(2),
            'transaction_code_id' => $codeOpr->id,
            'keterangan' => "Bayar Tagihan Listrik Toko",
            'debit' => 0,
            'kredit' => 500000,
        ]);
    }
}