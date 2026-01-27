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
            'email' => 'admin@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('admin123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Karyawan Kasir',
            'email' => 'kasir@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('kasir123'),
            'role' => 'user',
        ]);

        // 2. Buat Transaction Codes
        $codes = [
            ['code' => 'IN-MODAL', 'label' => 'Modal Awal', 'color' => 'primary'],
            ['code' => 'IN-SALES', 'label' => 'Pemasukan Penjualan', 'color' => 'success'],
            ['code' => 'OUT-PURCHASE', 'label' => 'Pengeluaran Kulakan', 'color' => 'danger'],
            ['code' => 'OUT-OPR', 'label' => 'Biaya Operasional', 'color' => 'warning'],
            ['code' => 'OUT-GAJI', 'label' => 'Gaji Karyawan', 'color' => 'indigo'],
            ['code' => 'IN-LAIN', 'label' => 'Lain-lain (Masuk)', 'color' => 'cyan'],
            ['code' => 'OUT-LAIN', 'label' => 'Lain-lain (Keluar)', 'color' => 'slate'],
        ];

        foreach ($codes as $c) {
            TransactionCode::create($c);
        }

        // 3. Buat Supplier
        $supplierNames = ['PT Semen Gresik', 'Distributor Cat Avian', 'TB Sumber Makmur', 'Gudang Besi Jaya'];
        $suppliers = [];
        foreach ($supplierNames as $name) {
            $suppliers[] = Supplier::create([
                'nama' => $name,
                'kontak' => '0812' . rand(1000, 9999) . rand(1000, 9999),
                'alamat' => 'Jl. Industri No. ' . rand(1, 100)
            ]);
        }

        // 4. INPUT MODAL AWAL
        Cashflow::create([
            'tanggal' => \Carbon\Carbon::now()->subMonths(1)->startOfMonth(),
            'transaction_code_id' => TransactionCode::where('code', 'IN-MODAL')->first()->id,
            'keterangan' => 'SETORAN MODAL AWAL USAHA',
            'debit' => 100000000,
            'kredit' => 0
        ]);

        // 5. BUAT MASTER UNITS
        $unitNames = ['Sak', 'Galon', 'Kg', 'Pcs', 'Batang', 'Meter'];
        $masterUnits = [];
        foreach ($unitNames as $uName) {
            $masterUnits[$uName] = MasterUnit::create([
                'nama' => $uName,
                'singkatan' => $uName
            ]);
        }

        // 6. MASTER PRODUCTS & PRODUCT UNITS
        $catalog = [
            ['nama' => 'Semen Gresik 40kg', 'unit' => 'Sak', 'harga_beli' => 60000, 'harga_jual' => 68000],
            ['nama' => 'Cat Avitex Putih 5kg', 'unit' => 'Galon', 'harga_beli' => 110000, 'harga_jual' => 125000],
            ['nama' => 'Paku Kayu 3 cm', 'unit' => 'Kg', 'harga_beli' => 15000, 'harga_jual' => 18000],
            ['nama' => 'Pipa PVC 1/2 Wavin', 'unit' => 'Batang', 'harga_beli' => 25000, 'harga_jual' => 30000],
        ];

        foreach ($catalog as $item) {
            $product = MasterProduct::create(['nama' => $item['nama']]);

            ProductUnit::create([
                'master_product_id' => $product->id,
                'master_unit_id' => $masterUnits[$item['unit']]->id,
                'nilai_konversi' => 1,
                'is_base_unit' => true,
                'stok' => rand(20, 100),
                'harga_beli_terakhir' => $item['harga_beli'],
                'margin' => 15,
                'harga_jual' => $item['harga_jual'],
                'harga_atas' => $item['harga_jual'] * 1.1,
            ]);
        }
    }
}