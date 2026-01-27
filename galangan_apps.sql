-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 27 Jan 2026 pada 03.53
-- Versi server: 8.4.3
-- Versi PHP: 8.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `galangan_apps`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cashflows`
--

CREATE TABLE `cashflows` (
  `id` bigint UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `transaction_code_id` bigint UNSIGNED NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `debit` decimal(15,2) NOT NULL DEFAULT '0.00',
  `kredit` decimal(15,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `cashflows`
--

INSERT INTO `cashflows` (`id`, `tanggal`, `transaction_code_id`, `keterangan`, `debit`, `kredit`, `created_at`, `updated_at`) VALUES
(1, '2026-01-08', 2, 'Kulakan Semen Tiga Roda 40kg (162 Sak)', 0.00, 8763066.00, '2026-01-25 20:42:19', '2026-01-25 20:42:19'),
(2, '2026-01-14', 1, 'Penjualan Semen Tiga Roda 40kg', 324558.00, 0.00, '2026-01-25 20:42:19', '2026-01-25 20:42:19'),
(3, '2026-01-12', 1, 'Penjualan Semen Tiga Roda 40kg', 129823.20, 0.00, '2026-01-25 20:42:19', '2026-01-25 20:42:19'),
(4, '2026-01-09', 1, 'Penjualan Semen Tiga Roda 40kg', 194734.80, 0.00, '2026-01-25 20:42:19', '2026-01-25 20:42:19'),
(5, '2026-01-16', 2, 'Kulakan Cat Tembok Dulux Putih 5kg (66 Galon)', 0.00, 4118268.00, '2026-01-25 20:42:20', '2026-01-25 20:42:20'),
(6, '2026-01-20', 1, 'Penjualan Cat Tembok Dulux Putih 5kg', 149755.20, 0.00, '2026-01-25 20:42:20', '2026-01-25 20:42:20'),
(7, '2026-01-18', 1, 'Penjualan Cat Tembok Dulux Putih 5kg', 224632.80, 0.00, '2026-01-25 20:42:20', '2026-01-25 20:42:20'),
(8, '2026-01-20', 1, 'Penjualan Cat Tembok Dulux Putih 5kg', 74877.60, 0.00, '2026-01-25 20:42:20', '2026-01-25 20:42:20'),
(9, '2026-01-21', 1, 'Penjualan Cat Tembok Dulux Putih 5kg', 74877.60, 0.00, '2026-01-25 20:42:20', '2026-01-25 20:42:20'),
(10, '2026-01-11', 2, 'Kulakan Paku Payung 5cm (184 Kg)', 0.00, 14350896.00, '2026-01-25 20:42:20', '2026-01-25 20:42:20'),
(11, '2026-01-14', 1, 'Penjualan Paku Payung 5cm', 280778.40, 0.00, '2026-01-25 20:42:20', '2026-01-25 20:42:20'),
(12, '2026-01-13', 1, 'Penjualan Paku Payung 5cm', 93592.80, 0.00, '2026-01-25 20:42:20', '2026-01-25 20:42:20'),
(13, '2026-01-13', 1, 'Penjualan Paku Payung 5cm', 374371.20, 0.00, '2026-01-25 20:42:20', '2026-01-25 20:42:20'),
(14, '2026-01-04', 2, 'Kulakan Pasir Lumajang (105 Pick Up)', 0.00, 1786995.00, '2026-01-25 20:42:20', '2026-01-25 20:42:20'),
(15, '2026-01-11', 1, 'Penjualan Pasir Lumajang', 102114.00, 0.00, '2026-01-25 20:42:20', '2026-01-25 20:42:20'),
(16, '2026-01-06', 1, 'Penjualan Pasir Lumajang', 102114.00, 0.00, '2026-01-25 20:42:20', '2026-01-25 20:42:20'),
(17, '2026-01-05', 1, 'Penjualan Pasir Lumajang', 20422.80, 0.00, '2026-01-25 20:42:20', '2026-01-25 20:42:20'),
(18, '2026-01-12', 1, 'Penjualan Pasir Lumajang', 81691.20, 0.00, '2026-01-25 20:42:20', '2026-01-25 20:42:20'),
(19, '2026-01-09', 1, 'Penjualan Pasir Lumajang', 102114.00, 0.00, '2026-01-25 20:42:20', '2026-01-25 20:42:20'),
(20, '2026-01-10', 1, 'Penjualan Pasir Lumajang', 40845.60, 0.00, '2026-01-25 20:42:20', '2026-01-25 20:42:20'),
(21, '2026-01-03', 2, 'Kulakan Bata Merah (95 Pcs)', 0.00, 967290.00, '2026-01-25 20:42:20', '2026-01-25 20:42:20'),
(22, '2026-01-10', 1, 'Penjualan Bata Merah', 36655.20, 0.00, '2026-01-25 20:42:20', '2026-01-25 20:42:20'),
(23, '2026-01-05', 1, 'Penjualan Bata Merah', 61092.00, 0.00, '2026-01-25 20:42:20', '2026-01-25 20:42:20'),
(24, '2026-01-08', 1, 'Penjualan Bata Merah', 61092.00, 0.00, '2026-01-25 20:42:20', '2026-01-25 20:42:20'),
(25, '2026-01-04', 1, 'Penjualan Bata Merah', 61092.00, 0.00, '2026-01-25 20:42:20', '2026-01-25 20:42:20'),
(26, '2026-01-10', 1, 'Penjualan Bata Merah', 36655.20, 0.00, '2026-01-25 20:42:20', '2026-01-25 20:42:20'),
(27, '2026-01-12', 1, 'Penjualan Bata Merah', 61092.00, 0.00, '2026-01-25 20:42:20', '2026-01-25 20:42:20'),
(28, '2026-01-24', 3, 'Bayar Tagihan Listrik Toko', 0.00, 500000.00, '2026-01-25 20:42:20', '2026-01-25 20:42:20'),
(29, '2026-01-26', 2, 'Kulakan LEM-G 15ML (5 Box)', 0.00, 300000.00, '2026-01-25 23:22:36', '2026-01-25 23:22:36'),
(30, '2026-01-26', 2, 'Kulakan Cat Tembok Dulux Putih 5kg (10 Pcs)', 0.00, 500000.00, '2026-01-25 23:51:17', '2026-01-25 23:51:17'),
(31, '2026-01-26', 2, 'Kulakan Paku Payung 5cm (5 Kg)', 0.00, 50000.00, '2026-01-26 00:02:57', '2026-01-26 00:02:57'),
(32, '2026-01-26', 2, 'Kulakan Paku Payung 5cm (10 Kg)', 0.00, 120000.00, '2026-01-26 00:31:46', '2026-01-26 00:31:46'),
(33, '2026-01-26', 2, 'Kulakan Semen Tiga Roda (2 Sak)', 0.00, 140000.00, '2026-01-26 00:35:37', '2026-01-26 00:35:37'),
(34, '2026-01-26', 2, 'Kulakan LEM RAJAWALI 30 ML (10 Box)', 0.00, 500000.00, '2026-01-26 00:46:15', '2026-01-26 00:46:15'),
(35, '2026-01-26', 2, 'Pelunasan: LEM RAJAWALI 30 ML (x10) [Nota: 23/er/f/2026]', 0.00, 650000.00, '2026-01-26 00:52:08', '2026-01-26 00:52:08'),
(36, '2026-01-26', 2, 'Kulakan LEM RAJAWALI 30 ML (10 Box)', 0.00, 600000.00, '2026-01-26 02:13:25', '2026-01-26 02:13:25'),
(37, '2026-01-27', 1, 'Penjualan POS TRX-20260127-3429', 84000.00, 0.00, '2026-01-26 19:25:03', '2026-01-26 19:25:03'),
(38, '2026-01-27', 1, 'Penjualan POS TRX-20260127-3749', 84000.00, 0.00, '2026-01-26 19:25:06', '2026-01-26 19:25:06'),
(39, '2026-01-27', 1, 'Penjualan POS TRX-20260127-1312', 84000.00, 0.00, '2026-01-26 19:25:07', '2026-01-26 19:25:07'),
(40, '2026-01-27', 1, 'Penjualan POS TRX-20260127-8801', 84000.00, 0.00, '2026-01-26 19:25:28', '2026-01-26 19:25:28'),
(41, '2026-01-27', 3, 'LISTRIK TOKEN 50K', 0.00, 51500.00, '2026-01-26 20:38:46', '2026-01-26 20:38:46'),
(42, '2026-01-01', 4, 'MODAL AWAL USAHA', 100000000.00, 0.00, '2026-01-26 20:42:35', '2026-01-26 20:42:35');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_products`
--

CREATE TABLE `master_products` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `master_products`
--

INSERT INTO `master_products` (`id`, `nama`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 'Semen Tiga Roda', NULL, '2026-01-25 20:42:19', '2026-01-25 20:42:19'),
(2, 'Cat Tembok Dulux Putih 5kg', NULL, '2026-01-25 20:42:19', '2026-01-25 20:42:19'),
(3, 'Paku Payung 5cm', NULL, '2026-01-25 20:42:19', '2026-01-25 20:42:19'),
(4, 'Pasir Lumajang', NULL, '2026-01-25 20:42:19', '2026-01-25 20:42:19'),
(5, 'Bata Merah', NULL, '2026-01-25 20:42:19', '2026-01-25 20:42:19'),
(6, 'LEM-G 15ML', NULL, '2026-01-25 21:48:19', '2026-01-25 21:48:19'),
(7, 'LEM RAJAWALI 30 ML', NULL, '2026-01-25 23:53:35', '2026-01-25 23:53:35');

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_units`
--

CREATE TABLE `master_units` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `singkatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `master_units`
--

INSERT INTO `master_units` (`id`, `nama`, `singkatan`, `created_at`, `updated_at`) VALUES
(1, 'Sak', 'Sak', '2026-01-25 20:42:19', '2026-01-25 20:42:19'),
(2, 'Galon', 'Gal', '2026-01-25 20:42:19', '2026-01-25 20:42:19'),
(3, 'Kg', 'Kg', '2026-01-25 20:42:19', '2026-01-25 20:42:19'),
(4, 'Pick Up', 'Pic', '2026-01-25 20:42:19', '2026-01-25 20:42:19'),
(5, 'Pcs', 'Pcs', '2026-01-25 20:42:19', '2026-01-25 20:42:19'),
(6, 'Karung', 'Kar', '2026-01-25 20:42:19', '2026-01-25 20:42:19'),
(7, 'Box', 'Box', '2026-01-25 20:42:19', '2026-01-25 20:42:19'),
(8, 'Kubik', 'Kub', '2026-01-25 20:42:19', '2026-01-25 20:42:19'),
(9, 'Ons', 'Ons', '2026-01-25 20:42:19', '2026-01-25 20:42:19'),
(11, 'GRAM', NULL, '2026-01-25 23:20:34', '2026-01-25 23:20:34');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_01_21_000000_transaction_codes_table', 1),
(5, '2026_01_21_032157_master_units_table', 1),
(6, '2026_01_22_075144_master_products', 1),
(7, '2026_01_22_084201_product_units_table', 1),
(8, '2026_01_22_091224_cashflows', 1),
(9, '2026_01_22_091746_sales_logs_table', 1),
(10, '2026_01_23_093226_suppliers_table', 1),
(11, '2026_01_23_093527_purchases_table', 1),
(12, '2026_01_23_093642_purchase_details_table', 1),
(13, '2026_01_27_020349_create_pos_transactions_table', 2),
(14, '2026_01_27_020354_create_pos_transaction_items_table', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pos_transactions`
--

CREATE TABLE `pos_transactions` (
  `id` bigint UNSIGNED NOT NULL,
  `no_trx` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `total_amount` decimal(15,2) NOT NULL,
  `bayar_amount` decimal(15,2) NOT NULL,
  `kembalian` decimal(15,2) NOT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pos_transactions`
--

INSERT INTO `pos_transactions` (`id`, `no_trx`, `user_id`, `total_amount`, `bayar_amount`, `kembalian`, `payment_method`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'TRX-20260127-3429', 1, 84000.00, 100000.00, 16000.00, 'cash', NULL, '2026-01-26 19:25:03', '2026-01-26 19:25:03'),
(2, 'TRX-20260127-3749', 1, 84000.00, 100000.00, 16000.00, 'cash', NULL, '2026-01-26 19:25:06', '2026-01-26 19:25:06'),
(3, 'TRX-20260127-1312', 1, 84000.00, 100000.00, 16000.00, 'cash', NULL, '2026-01-26 19:25:07', '2026-01-26 19:25:07'),
(4, 'TRX-20260127-8801', 1, 84000.00, 100000.00, 16000.00, 'cash', NULL, '2026-01-26 19:25:28', '2026-01-26 19:25:28');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pos_transaction_items`
--

CREATE TABLE `pos_transaction_items` (
  `id` bigint UNSIGNED NOT NULL,
  `pos_transaction_id` bigint UNSIGNED NOT NULL,
  `product_unit_id` bigint UNSIGNED NOT NULL,
  `qty` int NOT NULL,
  `harga_satuan` decimal(15,2) NOT NULL,
  `subtotal` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pos_transaction_items`
--

INSERT INTO `pos_transaction_items` (`id`, `pos_transaction_id`, `product_unit_id`, `qty`, `harga_satuan`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 84000.00, 84000.00, '2026-01-26 19:25:03', '2026-01-26 19:25:03'),
(2, 2, 1, 1, 84000.00, 84000.00, '2026-01-26 19:25:06', '2026-01-26 19:25:06'),
(3, 3, 1, 1, 84000.00, 84000.00, '2026-01-26 19:25:07', '2026-01-26 19:25:07'),
(4, 4, 1, 1, 84000.00, 84000.00, '2026-01-26 19:25:28', '2026-01-26 19:25:28');

-- --------------------------------------------------------

--
-- Struktur dari tabel `product_units`
--

CREATE TABLE `product_units` (
  `id` bigint UNSIGNED NOT NULL,
  `master_product_id` bigint UNSIGNED NOT NULL,
  `master_unit_id` bigint UNSIGNED NOT NULL,
  `nilai_konversi` int NOT NULL DEFAULT '1',
  `is_base_unit` tinyint(1) NOT NULL DEFAULT '0',
  `stok` int NOT NULL DEFAULT '0',
  `harga_beli_terakhir` decimal(15,2) NOT NULL DEFAULT '0.00',
  `margin` decimal(5,2) NOT NULL DEFAULT '0.00',
  `harga_jual` decimal(15,2) NOT NULL DEFAULT '0.00',
  `harga_atas` decimal(15,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `product_units`
--

INSERT INTO `product_units` (`id`, `master_product_id`, `master_unit_id`, `nilai_konversi`, `is_base_unit`, `stok`, `harga_beli_terakhir`, `margin`, `harga_jual`, `harga_atas`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 40, 0, 37, 70000.00, 20.00, 84000.00, 87000.00, '2026-01-25 20:42:19', '2026-01-26 19:25:28'),
(2, 2, 5, 1, 1, 69, 50000.00, 30.00, 65000.00, 70000.00, '2026-01-25 20:42:19', '2026-01-25 23:51:17'),
(3, 3, 3, 10, 0, 33, 12000.00, 30.00, 15600.00, 16000.00, '2026-01-25 20:42:19', '2026-01-26 00:31:46'),
(4, 4, 8, 28, 0, 80, 17019.00, 20.00, 20422.80, 22465.08, '2026-01-25 20:42:19', '2026-01-25 23:48:45'),
(5, 5, 5, 1, 1, 250, 2000.00, 20.00, 2400.00, 3000.00, '2026-01-25 20:42:19', '2026-01-25 20:42:20'),
(6, 1, 3, 1, 1, 80, 1750.00, 30.00, 2275.00, 2500.00, '2026-01-25 21:15:22', '2026-01-26 00:35:37'),
(7, 3, 9, 1, 1, 20, 1200.00, 20.00, 1440.00, 12000.00, '2026-01-25 21:18:56', '2026-01-26 00:31:46'),
(8, 4, 6, 1, 1, 84, 607.82, 20.00, 729.39, 900.00, '2026-01-25 21:19:58', '2026-01-25 23:48:45'),
(11, 7, 7, 10, 0, 8, 60000.00, 20.00, 72000.00, 78000.00, '2026-01-26 02:13:25', '2026-01-26 02:28:45'),
(12, 7, 5, 1, 1, 20, 6000.00, 30.00, 7800.00, 8000.00, '2026-01-26 02:13:25', '2026-01-26 02:28:45');

-- --------------------------------------------------------

--
-- Struktur dari tabel `purchases`
--

CREATE TABLE `purchases` (
  `id` bigint UNSIGNED NOT NULL,
  `supplier_id` bigint UNSIGNED NOT NULL,
  `nomor_resi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal` date NOT NULL,
  `total_nominal` decimal(15,2) NOT NULL,
  `status_pembayaran` enum('Lunas','Belum Lunas') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Belum Lunas',
  `jatuh_tempo` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `purchases`
--

INSERT INTO `purchases` (`id`, `supplier_id`, `nomor_resi`, `tanggal`, `total_nominal`, `status_pembayaran`, `jatuh_tempo`, `created_at`, `updated_at`) VALUES
(1, 2, 'INV-6976E29BD8810', '2026-01-08', 8763066.00, 'Lunas', '2026-02-25', '2026-01-25 20:42:19', '2026-01-25 20:42:19'),
(2, 1, 'INV-6976E29BF1C8D', '2026-01-16', 4118268.00, 'Lunas', '2026-02-25', '2026-01-25 20:42:19', '2026-01-25 20:42:19'),
(3, 2, 'INV-6976E29C0B170', '2026-01-11', 14350896.00, 'Lunas', '2026-02-25', '2026-01-25 20:42:20', '2026-01-25 20:42:20'),
(4, 3, 'INV-6976E29C16230', '2026-01-04', 1786995.00, 'Lunas', '2026-02-25', '2026-01-25 20:42:20', '2026-01-25 20:42:20'),
(5, 4, 'INV-6976E29C289E6', '2026-01-03', 967290.00, 'Lunas', '2026-02-25', '2026-01-25 20:42:20', '2026-01-25 20:42:20'),
(7, 3, '23/er/fk/2026', '2026-01-26', 500000.00, 'Lunas', NULL, '2026-01-25 23:51:17', '2026-01-25 23:51:17'),
(8, 4, '23/er/f/2026', '2026-01-26', 50000.00, 'Lunas', NULL, '2026-01-26 00:02:57', '2026-01-26 00:02:57'),
(9, 4, '23/er/fk/2026', '2026-01-26', 120000.00, 'Lunas', NULL, '2026-01-26 00:31:46', '2026-01-26 00:31:46'),
(10, 4, '23/er/fk/2026', '2026-01-26', 140000.00, 'Lunas', NULL, '2026-01-26 00:35:37', '2026-01-26 00:35:37'),
(13, 3, '23/er/fk/2026', '2026-01-26', 600000.00, 'Lunas', NULL, '2026-01-26 02:13:25', '2026-01-26 02:13:25');

-- --------------------------------------------------------

--
-- Struktur dari tabel `purchase_details`
--

CREATE TABLE `purchase_details` (
  `id` bigint UNSIGNED NOT NULL,
  `purchase_id` bigint UNSIGNED NOT NULL,
  `product_unit_id` bigint UNSIGNED NOT NULL,
  `qty` int NOT NULL,
  `harga_beli_satuan` decimal(15,2) NOT NULL,
  `subtotal` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `purchase_details`
--

INSERT INTO `purchase_details` (`id`, `purchase_id`, `product_unit_id`, `qty`, `harga_beli_satuan`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 162, 54093.00, 8763066.00, '2026-01-25 20:42:19', '2026-01-25 20:42:19'),
(2, 2, 2, 66, 62398.00, 4118268.00, '2026-01-25 20:42:19', '2026-01-25 20:42:19'),
(3, 3, 3, 184, 77994.00, 14350896.00, '2026-01-25 20:42:20', '2026-01-25 20:42:20'),
(4, 4, 4, 105, 17019.00, 1786995.00, '2026-01-25 20:42:20', '2026-01-25 20:42:20'),
(5, 5, 5, 95, 10182.00, 967290.00, '2026-01-25 20:42:20', '2026-01-25 20:42:20'),
(7, 7, 2, 10, 50000.00, 500000.00, '2026-01-25 23:51:17', '2026-01-25 23:51:17'),
(8, 8, 3, 5, 10000.00, 50000.00, '2026-01-26 00:02:57', '2026-01-26 00:02:57'),
(9, 9, 3, 10, 12000.00, 120000.00, '2026-01-26 00:31:46', '2026-01-26 00:31:46'),
(10, 10, 1, 2, 70000.00, 140000.00, '2026-01-26 00:35:37', '2026-01-26 00:35:37'),
(13, 13, 11, 10, 60000.00, 600000.00, '2026-01-26 02:13:25', '2026-01-26 02:13:25');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sales_logs`
--

CREATE TABLE `sales_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `product_unit_id` bigint UNSIGNED NOT NULL,
  `tanggal_jual` date NOT NULL,
  `qty_terjual` int NOT NULL,
  `harga_satuan` decimal(15,2) NOT NULL,
  `subtotal` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sales_logs`
--

INSERT INTO `sales_logs` (`id`, `product_unit_id`, `tanggal_jual`, `qty_terjual`, `harga_satuan`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 1, '2026-01-14', 5, 64911.60, 324558.00, '2026-01-25 20:42:19', '2026-01-25 20:42:19'),
(2, 1, '2026-01-12', 2, 64911.60, 129823.20, '2026-01-25 20:42:19', '2026-01-25 20:42:19'),
(3, 1, '2026-01-09', 3, 64911.60, 194734.80, '2026-01-25 20:42:19', '2026-01-25 20:42:19'),
(4, 2, '2026-01-20', 2, 74877.60, 149755.20, '2026-01-25 20:42:20', '2026-01-25 20:42:20'),
(5, 2, '2026-01-18', 3, 74877.60, 224632.80, '2026-01-25 20:42:20', '2026-01-25 20:42:20'),
(6, 2, '2026-01-20', 1, 74877.60, 74877.60, '2026-01-25 20:42:20', '2026-01-25 20:42:20'),
(7, 2, '2026-01-21', 1, 74877.60, 74877.60, '2026-01-25 20:42:20', '2026-01-25 20:42:20'),
(8, 3, '2026-01-14', 3, 93592.80, 280778.40, '2026-01-25 20:42:20', '2026-01-25 20:42:20'),
(9, 3, '2026-01-13', 1, 93592.80, 93592.80, '2026-01-25 20:42:20', '2026-01-25 20:42:20'),
(10, 3, '2026-01-13', 4, 93592.80, 374371.20, '2026-01-25 20:42:20', '2026-01-25 20:42:20'),
(11, 4, '2026-01-11', 5, 20422.80, 102114.00, '2026-01-25 20:42:20', '2026-01-25 20:42:20'),
(12, 4, '2026-01-06', 5, 20422.80, 102114.00, '2026-01-25 20:42:20', '2026-01-25 20:42:20'),
(13, 4, '2026-01-05', 1, 20422.80, 20422.80, '2026-01-25 20:42:20', '2026-01-25 20:42:20'),
(14, 4, '2026-01-12', 4, 20422.80, 81691.20, '2026-01-25 20:42:20', '2026-01-25 20:42:20'),
(15, 4, '2026-01-09', 5, 20422.80, 102114.00, '2026-01-25 20:42:20', '2026-01-25 20:42:20'),
(16, 4, '2026-01-10', 2, 20422.80, 40845.60, '2026-01-25 20:42:20', '2026-01-25 20:42:20'),
(17, 5, '2026-01-10', 3, 12218.40, 36655.20, '2026-01-25 20:42:20', '2026-01-25 20:42:20'),
(18, 5, '2026-01-05', 5, 12218.40, 61092.00, '2026-01-25 20:42:20', '2026-01-25 20:42:20'),
(19, 5, '2026-01-08', 5, 12218.40, 61092.00, '2026-01-25 20:42:20', '2026-01-25 20:42:20'),
(20, 5, '2026-01-04', 5, 12218.40, 61092.00, '2026-01-25 20:42:20', '2026-01-25 20:42:20'),
(21, 5, '2026-01-10', 3, 12218.40, 36655.20, '2026-01-25 20:42:20', '2026-01-25 20:42:20'),
(22, 5, '2026-01-12', 5, 12218.40, 61092.00, '2026-01-25 20:42:20', '2026-01-25 20:42:20'),
(23, 1, '2026-01-27', 1, 84000.00, 84000.00, '2026-01-26 19:25:03', '2026-01-26 19:25:03'),
(24, 1, '2026-01-27', 1, 84000.00, 84000.00, '2026-01-26 19:25:06', '2026-01-26 19:25:06'),
(25, 1, '2026-01-27', 1, 84000.00, 84000.00, '2026-01-26 19:25:07', '2026-01-26 19:25:07'),
(26, 1, '2026-01-27', 1, 84000.00, 84000.00, '2026-01-26 19:25:28', '2026-01-26 19:25:28');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('MrEy8k1k9I3y3UDSbIpUNJ4mmIxvLm5riNtnpPLq', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiM1dBZjJoem1odkVyeHVUYkZua2RWcVJxa3VoZDdtVDNPWDVFemJNTyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9jYXNoLWZsb3ciO3M6NToicm91dGUiO3M6MTQ6ImNhc2hmbG93LmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1769485696);

-- --------------------------------------------------------

--
-- Struktur dari tabel `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kontak` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `suppliers`
--

INSERT INTO `suppliers` (`id`, `nama`, `kontak`, `alamat`, `created_at`, `updated_at`) VALUES
(1, 'PT Semen Gresik', '08123456785', 'Jl. Raya Bangunan No. 51', '2026-01-25 20:42:19', '2026-01-25 20:42:19'),
(2, 'Toko Cat Warna Warni', '08123456785', 'Jl. Raya Bangunan No. 11', '2026-01-25 20:42:19', '2026-01-25 20:42:19'),
(3, 'TB Sumber Rejeki', '08123456784', 'Jl. Raya Bangunan No. 81', '2026-01-25 20:42:19', '2026-01-25 20:42:19'),
(4, 'Distributor Paku Jaya', '08123456788', 'Jl. Raya Bangunan No. 23', '2026-01-25 20:42:19', '2026-01-25 20:42:19');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaction_codes`
--

CREATE TABLE `transaction_codes` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'primary',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `transaction_codes`
--

INSERT INTO `transaction_codes` (`id`, `code`, `label`, `color`, `created_at`, `updated_at`) VALUES
(1, 'IN-SALES', 'Pemasukan Penjualan', 'success', '2026-01-25 20:42:19', '2026-01-25 20:42:19'),
(2, 'OUT-PURCHASE', 'Pengeluaran Kulakan', 'danger', '2026-01-25 20:42:19', '2026-01-25 20:42:19'),
(3, 'OUT-OPR', 'Biaya Operasional', 'warning', '2026-01-25 20:42:19', '2026-01-25 20:42:19'),
(4, 'IN-MODAL', 'Modal Awal', 'primary', '2026-01-26 20:42:35', '2026-01-26 20:42:35');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin Toko', 'admin@toko.com', 'admin', NULL, '$2y$12$aPbF2IKrfGpRTtyznbCRfOgboD1wTyCBhZpYa6GUmk3YP9eC/9dnS', NULL, '2026-01-25 20:42:19', '2026-01-25 20:42:19'),
(2, 'Karyawan Biasa', 'user@toko.com', 'user', NULL, '$2y$12$8jhkAbBYh03ZYfW.R5PpCenxMYvYfe.QQKbGBC4fJDlFZObVAUWzO', NULL, '2026-01-25 20:42:19', '2026-01-25 20:42:19');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `cashflows`
--
ALTER TABLE `cashflows`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cashflows_transaction_code_id_foreign` (`transaction_code_id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `master_products`
--
ALTER TABLE `master_products`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `master_units`
--
ALTER TABLE `master_units`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `master_units_nama_unique` (`nama`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `pos_transactions`
--
ALTER TABLE `pos_transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pos_transactions_no_trx_unique` (`no_trx`),
  ADD KEY `pos_transactions_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `pos_transaction_items`
--
ALTER TABLE `pos_transaction_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pos_transaction_items_pos_transaction_id_foreign` (`pos_transaction_id`),
  ADD KEY `pos_transaction_items_product_unit_id_foreign` (`product_unit_id`);

--
-- Indeks untuk tabel `product_units`
--
ALTER TABLE `product_units`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_units_master_product_id_foreign` (`master_product_id`),
  ADD KEY `product_units_master_unit_id_foreign` (`master_unit_id`);

--
-- Indeks untuk tabel `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchases_supplier_id_foreign` (`supplier_id`);

--
-- Indeks untuk tabel `purchase_details`
--
ALTER TABLE `purchase_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_details_purchase_id_foreign` (`purchase_id`),
  ADD KEY `purchase_details_product_unit_id_foreign` (`product_unit_id`);

--
-- Indeks untuk tabel `sales_logs`
--
ALTER TABLE `sales_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_logs_product_unit_id_foreign` (`product_unit_id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `transaction_codes`
--
ALTER TABLE `transaction_codes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transaction_codes_code_unique` (`code`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `cashflows`
--
ALTER TABLE `cashflows`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `master_products`
--
ALTER TABLE `master_products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `master_units`
--
ALTER TABLE `master_units`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `pos_transactions`
--
ALTER TABLE `pos_transactions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `pos_transaction_items`
--
ALTER TABLE `pos_transaction_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `product_units`
--
ALTER TABLE `product_units`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `purchase_details`
--
ALTER TABLE `purchase_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `sales_logs`
--
ALTER TABLE `sales_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `transaction_codes`
--
ALTER TABLE `transaction_codes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `cashflows`
--
ALTER TABLE `cashflows`
  ADD CONSTRAINT `cashflows_transaction_code_id_foreign` FOREIGN KEY (`transaction_code_id`) REFERENCES `transaction_codes` (`id`);

--
-- Ketidakleluasaan untuk tabel `pos_transactions`
--
ALTER TABLE `pos_transactions`
  ADD CONSTRAINT `pos_transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `pos_transaction_items`
--
ALTER TABLE `pos_transaction_items`
  ADD CONSTRAINT `pos_transaction_items_pos_transaction_id_foreign` FOREIGN KEY (`pos_transaction_id`) REFERENCES `pos_transactions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pos_transaction_items_product_unit_id_foreign` FOREIGN KEY (`product_unit_id`) REFERENCES `product_units` (`id`);

--
-- Ketidakleluasaan untuk tabel `product_units`
--
ALTER TABLE `product_units`
  ADD CONSTRAINT `product_units_master_product_id_foreign` FOREIGN KEY (`master_product_id`) REFERENCES `master_products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_units_master_unit_id_foreign` FOREIGN KEY (`master_unit_id`) REFERENCES `master_units` (`id`);

--
-- Ketidakleluasaan untuk tabel `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`);

--
-- Ketidakleluasaan untuk tabel `purchase_details`
--
ALTER TABLE `purchase_details`
  ADD CONSTRAINT `purchase_details_product_unit_id_foreign` FOREIGN KEY (`product_unit_id`) REFERENCES `product_units` (`id`),
  ADD CONSTRAINT `purchase_details_purchase_id_foreign` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `sales_logs`
--
ALTER TABLE `sales_logs`
  ADD CONSTRAINT `sales_logs_product_unit_id_foreign` FOREIGN KEY (`product_unit_id`) REFERENCES `product_units` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
