<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Supplier;
use App\Models\Cashflow;
use App\Models\SalesLog;
use App\Models\TransactionCode;
use App\Models\MasterProduct;
use App\Models\ProductUnit;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\MasterUnit;     // <--- 1. JANGAN LUPA IMPORT INI
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

        // 2. Buat Transaction Codes
        $codeMasuk = TransactionCode::create([
            'code' => 'IN-SALES',
            'label' => 'Pemasukan Penjualan',
            'color' => 'success'
        ]);

        $codeModal = TransactionCode::create([
            'code' => 'IN-MODAL',
            'label' => 'Modal Awal',
            'color' => 'primary'
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

        // 4. INPUT MODAL AWAL (Agar saldo tidak minus)
        Cashflow::create([
            'tanggal' => Carbon::now()->subMonths(2),
            'transaction_code_id' => $codeModal->id,
            'keterangan' => 'MODAL AWAL USAHA',
            'debit' => 100000000, // 100 Juta
            'kredit' => 0
        ]);

        // --- UPDATE BARU MULAI DARI SINI ---

        // 4. BUAT MASTER UNITS TERLEBIH DAHULU
        // Kita simpan dalam array agar mudah diambil ID-nya nanti
        $unitNames = ['Sak', 'Galon', 'Kg', 'Pick Up', 'Pcs', 'Karung', 'Box', 'Kubik', 'Truk'];
        $masterUnits = [];

        foreach ($unitNames as $uName) {
            // Simpan object MasterUnit ke array dengan key nama satuannya
            $masterUnits[$uName] = MasterUnit::create([
                'nama' => $uName,
                'singkatan' => substr($uName, 0, 3)
            ]);
        }

        // 5. Buat Master Product & Product Unit
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

            // B. Buat Satuan Dasar (Unit)
            $units[] = ProductUnit::create([
                'master_product_id' => $master->id,

                // PERUBAHAN PENTING: Gunakan ID dari MasterUnit, bukan string manual
                'master_unit_id' => $masterUnits[$item['satuan']]->id,

                'nilai_konversi' => 1,
                'is_base_unit' => true,
                'stok' => 0,
                'harga_beli_terakhir' => 0,
                'margin' => 0,
                'harga_jual' => 0,
            ]);
        }

        // 6. SIMULASI KULAKAN (PURCHASING)
        foreach ($units as $unit) {

            $supplier = $suppliers[array_rand($suppliers)];
            $qtyBeli = rand(50, 200);
            $hargaBeliSatuan = rand(10000, 100000);
            $totalBelanja = $qtyBeli * $hargaBeliSatuan;
            $tanggalBeli = Carbon::now()->subDays(rand(10, 30));

            // A. Header Pembelian
            $purchase = Purchase::create([
                'supplier_id' => $supplier->id,
                'nomor_resi' => 'INV-' . strtoupper(uniqid()),
                'tanggal' => $tanggalBeli,
                'total_nominal' => $totalBelanja,
                'status_pembayaran' => 'Lunas',
                'jatuh_tempo' => Carbon::now()->addDays(30),
            ]);

            // B. Detail Pembelian
            PurchaseDetail::create([
                'purchase_id' => $purchase->id,
                'product_unit_id' => $unit->id,
                'qty' => $qtyBeli,
                'harga_beli_satuan' => $hargaBeliSatuan,
                'subtotal' => $totalBelanja
            ]);

            // C. Update Stok
            $margin = 20;
            $hargaJual = $hargaBeliSatuan + ($hargaBeliSatuan * $margin / 100);

            $unit->update([
                'stok' => $unit->stok + $qtyBeli,
                'harga_beli_terakhir' => $hargaBeliSatuan,
                'margin' => $margin,
                'harga_jual' => $hargaJual,
                'harga_atas' => $hargaJual * 1.1
            ]);

            // D. Catat Cashflow Keluar
            // PERBAIKAN: Mengambil nama satuan lewat relasi masterUnit
            Cashflow::create([
                'tanggal' => $tanggalBeli,
                'transaction_code_id' => $codeKeluar->id,
                'keterangan' => "Kulakan " . $unit->masterProduct->nama . " (" . $qtyBeli . " " . $unit->masterUnit->nama . ")",
                'debit' => 0,
                'kredit' => $totalBelanja
            ]);

            // 7. SIMULASI PENJUALAN
            for ($i = 0; $i < rand(3, 8); $i++) {
                $qtyJual = rand(1, 5);

                if ($unit->stok >= $qtyJual) {
                    $tglJual = Carbon::parse($tanggalBeli)->addDays(rand(1, 10));
                    $subtotalJual = $qtyJual * $unit->harga_jual;

                    // A. Sales Log
                    SalesLog::create([
                        'product_unit_id' => $unit->id,
                        'tanggal_jual' => $tglJual,
                        'qty_terjual' => $qtyJual,
                        'harga_satuan' => $unit->harga_jual,
                        'subtotal' => $subtotalJual
                    ]);

                    // B. Kurangi Stok
                    $unit->decrement('stok', $qtyJual);

                    // C. Cashflow Masuk
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

        // 8. Cashflow Tambahan
        Cashflow::create([
            'tanggal' => Carbon::now()->subDays(2),
            'transaction_code_id' => $codeOpr->id,
            'keterangan' => "Bayar Tagihan Listrik Toko",
            'debit' => 0,
            'kredit' => 500000,
        ]);
    }
}