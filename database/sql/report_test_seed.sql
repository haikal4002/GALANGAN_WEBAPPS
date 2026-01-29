-- Seed data untuk LAPORAN BULANAN BARANG TERJUAL (TEST DATA)
-- Owner: TEST_REPORT
-- Gunakan skrip PHP di scripts/report_test_seed.php untuk mengeksekusi

SET autocommit=1;

# 1) Tambah 20 master products + product_units (TEST_REPORT_PRODUCT 1..20)
INSERT INTO `master_products` (`nama`, `deskripsi`, `created_at`, `updated_at`) VALUES
('TEST_REPORT_PRODUCT 1', 'Product test untuk laporan bulanan', '2026-01-02 00:00:00', '2026-01-02 00:00:00'),
('TEST_REPORT_PRODUCT 2', 'Product test untuk laporan bulanan', '2026-01-03 00:00:00', '2026-01-03 00:00:00'),
('TEST_REPORT_PRODUCT 3', 'Product test untuk laporan bulanan', '2026-01-04 00:00:00', '2026-01-04 00:00:00'),
('TEST_REPORT_PRODUCT 4', 'Product test untuk laporan bulanan', '2026-01-05 00:00:00', '2026-01-05 00:00:00'),
('TEST_REPORT_PRODUCT 5', 'Product test untuk laporan bulanan', '2026-01-06 00:00:00', '2026-01-06 00:00:00'),
('TEST_REPORT_PRODUCT 6', 'Product test untuk laporan bulanan', '2026-01-07 00:00:00', '2026-01-07 00:00:00'),
('TEST_REPORT_PRODUCT 7', 'Product test untuk laporan bulanan', '2026-01-08 00:00:00', '2026-01-08 00:00:00'),
('TEST_REPORT_PRODUCT 8', 'Product test untuk laporan bulanan', '2026-01-09 00:00:00', '2026-01-09 00:00:00'),
('TEST_REPORT_PRODUCT 9', 'Product test untuk laporan bulanan', '2026-01-10 00:00:00', '2026-01-10 00:00:00'),
('TEST_REPORT_PRODUCT 10', 'Product test untuk laporan bulanan', '2026-01-11 00:00:00', '2026-01-11 00:00:00'),
('TEST_REPORT_PRODUCT 11', 'Product test untuk laporan bulanan', '2026-01-12 00:00:00', '2026-01-12 00:00:00'),
('TEST_REPORT_PRODUCT 12', 'Product test untuk laporan bulanan', '2026-01-13 00:00:00', '2026-01-13 00:00:00'),
('TEST_REPORT_PRODUCT 13', 'Product test untuk laporan bulanan', '2026-01-14 00:00:00', '2026-01-14 00:00:00'),
('TEST_REPORT_PRODUCT 14', 'Product test untuk laporan bulanan', '2026-01-15 00:00:00', '2026-01-15 00:00:00'),
('TEST_REPORT_PRODUCT 15', 'Product test untuk laporan bulanan', '2026-01-16 00:00:00', '2026-01-16 00:00:00'),
('TEST_REPORT_PRODUCT 16', 'Product test untuk laporan bulanan', '2026-01-17 00:00:00', '2026-01-17 00:00:00'),
('TEST_REPORT_PRODUCT 17', 'Product test untuk laporan bulanan', '2026-01-18 00:00:00', '2026-01-18 00:00:00'),
('TEST_REPORT_PRODUCT 18', 'Product test untuk laporan bulanan', '2026-01-19 00:00:00', '2026-01-19 00:00:00'),
('TEST_REPORT_PRODUCT 19', 'Product test untuk laporan bulanan', '2026-01-20 00:00:00', '2026-01-20 00:00:00'),
('TEST_REPORT_PRODUCT 20', 'Product test untuk laporan bulanan', '2026-01-21 00:00:00', '2026-01-21 00:00:00');

# Insert one product_unit per product with a deterministic harga_jual
INSERT INTO `product_units` (`master_product_id`, `master_unit_id`, `nilai_konversi`, `is_base_unit`, `stok`, `harga_beli_terakhir`, `margin`, `harga_jual`, `created_at`, `updated_at`)
SELECT mp.id, 5, 1, 1, 100 + ROW_NUMBER() OVER (ORDER BY mp.id), 5000 + (ROW_NUMBER() OVER (ORDER BY mp.id) * 1000), 20.00, (5000 + (ROW_NUMBER() OVER (ORDER BY mp.id) * 1000)) * 1.2, '2026-01-05 00:00:00', '2026-01-05 00:00:00'
FROM master_products mp
WHERE mp.nama LIKE 'TEST_REPORT_PRODUCT %';

# 2) Tambah 20 transaksi POS (satu transaksi per produk, agar laporan menampilkan 20 produk terjual)
-- Untuk masing-masing produk, ambil harga_jual dari product_units dan buat transaksi

SET @ctr = 1;
-- Loop simulasi (manual expansion for compatibilitas SQL)

INSERT INTO pos_transactions (no_trx, user_id, total_amount, bayar_amount, kembalian, payment_method, notes, created_at, updated_at)
SELECT CONCAT('TEST-REPORT-202601-', LPAD(ROW_NUMBER() OVER (ORDER BY pu.id),2,'0')),
       1,
       pu.harga_jual * (1 + (ROW_NUMBER() OVER (ORDER BY pu.id) % 3)),
       pu.harga_jual * (1 + (ROW_NUMBER() OVER (ORDER BY pu.id) % 3)),
       0.00,
       'CASH',
       'TEST_REPORT Seed',
       CONCAT('2026-01-', LPAD(2 + (ROW_NUMBER() OVER (ORDER BY pu.id) % 20),2,'0'), ' 10:00:00'),
       CONCAT('2026-01-', LPAD(2 + (ROW_NUMBER() OVER (ORDER BY pu.id) % 20),2,'0'), ' 10:00:00')
FROM product_units pu
JOIN master_products mp on pu.master_product_id = mp.id
WHERE mp.nama LIKE 'TEST_REPORT_PRODUCT %'
ORDER BY pu.id;

-- Insert items using the newly created transactions by joining back on order
-- Note: This assumes auto-increment ids for pos_transactions and sequential inserts.

-- Make a temporary mapping table of recent transactions and product_units
DROP TEMPORARY TABLE IF EXISTS tmp_test_report_map;
CREATE TEMPORARY TABLE tmp_test_report_map AS
SELECT pt.id AS trx_id, pu.id AS pu_id, mp.nama, pu.harga_jual,
       (1 + (ROW_NUMBER() OVER (ORDER BY pu.id) % 3)) AS qty
FROM pos_transactions pt
JOIN (
    SELECT pu.id, pu.harga_jual, mp.nama, ROW_NUMBER() OVER (ORDER BY pu.id) as rn
    FROM product_units pu
    JOIN master_products mp ON pu.master_product_id = mp.id
    WHERE mp.nama LIKE 'TEST_REPORT_PRODUCT %'
    ORDER BY pu.id
) pu JOIN master_products mp ON pu.nama = mp.nama
-- match transactions by order using row numbers
JOIN (
    SELECT id, ROW_NUMBER() OVER (ORDER BY id) as rn FROM pos_transactions WHERE notes = 'TEST_REPORT Seed'
) t ON t.rn = pu.rn
ORDER BY pu.rn;

INSERT INTO pos_transaction_items (pos_transaction_id, product_unit_id, qty, harga_satuan, subtotal, created_at, updated_at)
SELECT trx_id, pu_id, qty, harga_jual, qty * harga_jual, NOW(), NOW() FROM tmp_test_report_map;

-- Selesai.
-- Gunakan cleanup SQL untuk menghapus data ini secara aman.
