Panduan singkat: Menambah / menghapus data uji untuk 'LAPORAN BULANAN BARANG TERJUAL' ✅

File yang dibuat:

- database/sql/report_test_seed.sql -> SQL untuk menambah data uji (master_products, product_units, pos_transactions, pos_transaction_items)
- database/sql/report_test_cleanup.sql -> SQL untuk menghapus data uji (menggunakan penanda nama/note 'TEST_REPORT')
- scripts/report_test_seed.php -> Skrip PHP untuk menjalankan seed (membaca .env untuk koneksi DB)
- scripts/report_test_cleanup.php -> Skrip PHP untuk menjalankan cleanup

Cara menjalankan (Windows):

1. Pastikan file .env terisi dengan koneksi database Anda.
2. Jalankan: php scripts\report_test_seed.php
   -> akan menambahkan beberapa produk + transaksi di bulan Januari 2026 (untuk testing tampilan laporan)
3. Setelah selesai testing, jalankan: php scripts\report_test_cleanup.php
   -> akan menghapus semua data yang diberi penanda 'TEST_REPORT'

Catatan:

- Pastikan environment dan backup DB jika ingin menjaga data produksi.
- Jika ingin menyesuaikan bulan/tanggal, edit file SQL `report_test_seed.sql` dan sesuaikan kolom `created_at` pada transaksi.
