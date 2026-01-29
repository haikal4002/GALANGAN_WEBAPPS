-- Cleanup untuk data TEST_REPORT
-- Hati-hati: file ini akan menghapus semua baris yang dibuat pada seed di atas

SET autocommit=1;

-- Hapus items transaksi terlebih dahulu (menggunakan notes sebagai penanda)
DELETE pti FROM pos_transaction_items pti
INNER JOIN pos_transactions pt ON pti.pos_transaction_id = pt.id
WHERE pt.notes LIKE 'TEST_REPORT%';

-- Hapus transaksi
DELETE FROM pos_transactions WHERE notes LIKE 'TEST_REPORT%';

-- Hapus product_units yang terkait dengan master_products TEST_REPORT
DELETE FROM product_units
WHERE master_product_id IN (SELECT id FROM master_products WHERE nama LIKE 'TEST_REPORT%');

-- Hapus master_products test
DELETE FROM master_products WHERE nama LIKE 'TEST_REPORT%';

-- Opsional: flush privileges / check
