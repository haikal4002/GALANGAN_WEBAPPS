-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 03 Feb 2026 pada 03.17
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
(1, '2025-07-23', 4, 'SALDO AWAL BRI', 182320000.00, 0.00, '2025-07-22 17:00:00', '2025-07-22 17:00:00'),
(2, '2025-07-23', 2, 'KULAK KAYU 3 UKURAN UD.JATI UTAMA', 0.00, 9505000.00, '2025-07-22 17:00:00', '2025-07-22 17:00:00'),
(3, '2025-07-23', 2, 'PELUNASA NOTA.1 KULAK PAKU 3 UK TGL 16 JULI 2025', 0.00, 1899000.00, '2025-07-22 17:00:00', '2025-07-22 17:00:00'),
(4, '2025-07-23', 3, 'BELI KRESEK DAN PLASTIK', 0.00, 115000.00, '2025-07-22 17:00:00', '2025-07-22 17:00:00'),
(5, '2025-07-23', 3, 'BELI BUKU DAN TAS PINK UNTUK NOTA', 0.00, 290000.00, '2025-07-22 17:00:00', '2025-07-22 17:00:00'),
(6, '2025-07-24', 2, 'BAUT DRILLING TOKPED', 0.00, 1134080.00, '2025-07-23 17:00:00', '2025-07-23 17:00:00'),
(7, '2025-07-24', 2, 'SEKOP TOKPED', 0.00, 435000.00, '2025-07-23 17:00:00', '2025-07-23 17:00:00'),
(8, '2025-07-24', 2, 'CANGKUL TOKPED', 0.00, 334750.00, '2025-07-23 17:00:00', '2025-07-23 17:00:00'),
(9, '2025-07-26', 1, 'PEMASUKAN DARI TOKO', 1500000.00, 0.00, '2025-07-25 17:00:00', '2025-07-25 17:00:00'),
(10, '2025-07-27', 3, 'MATERAI', 0.00, 120000.00, '2025-07-26 17:00:00', '2025-07-26 17:00:00'),
(11, '2025-07-28', 1, 'PEMBELIAN MOBIL PICK UP', 145000000.00, 145000000.00, '2025-07-27 17:00:00', '2025-07-27 17:00:00'),
(12, '2025-07-28', 1, 'JASA REPARASI PICK UP', 5000000.00, 5000000.00, '2025-07-27 17:00:00', '2025-07-27 17:00:00'),
(13, '2025-07-28', 3, 'ROKOK CAK SURADI', 320000.00, 320000.00, '2025-07-27 17:00:00', '2025-07-27 17:00:00'),
(14, '2025-07-30', 2, 'PELUNASAN NOTA 2 BELANJA BESI', 0.00, 9525000.00, '2025-07-29 17:00:00', '2025-07-29 17:00:00'),
(15, '2025-07-30', 2, 'PELUNASAN NOTA 2 BELANJA HOLLOW', 0.00, 19575000.00, '2025-07-29 17:00:00', '2025-07-29 17:00:00'),
(16, '2025-07-31', 2, 'BATU KOMBONG 300', 0.00, 24000000.00, '2025-07-30 17:00:00', '2025-07-30 17:00:00'),
(17, '2025-07-31', 3, 'ADMIN TARIK TUNAI', 0.00, 65000.00, '2025-07-30 17:00:00', '2025-07-30 17:00:00'),
(18, '2025-07-31', 3, 'KONSUMSI TUKANG BONGKAR', 0.00, 600000.00, '2025-07-30 17:00:00', '2025-07-30 17:00:00'),
(19, '2025-01-08', 3, 'UPAH DEH MUN MEI JUNI JULI', 0.00, 3300000.00, '2025-01-07 17:00:00', '2025-01-07 17:00:00'),
(20, '2025-02-08', 1, 'PEMASUKAN DARI TOKO', 1500000.00, 0.00, '2025-02-07 17:00:00', '2025-02-07 17:00:00'),
(21, '2025-06-08', 2, 'KULAK TRIPLEK', 0.00, 12850000.00, '2025-06-07 17:00:00', '2025-06-07 17:00:00'),
(22, '2025-10-08', 2, 'SEMEN GRESIK 50 SAK (TOKO LANCAR PANDAN ARUM)', 0.00, 27400000.00, '2025-10-07 17:00:00', '2025-10-07 17:00:00'),
(23, '2025-11-08', 2, '100 SAK KAPUR', 0.00, 17000000.00, '2025-11-07 17:00:00', '2025-11-07 17:00:00'),
(24, '2025-12-08', 1, 'PEMASUKAN DARI TOKO', 2300000.00, 0.00, '2025-12-07 17:00:00', '2025-12-07 17:00:00'),
(25, '2025-12-08', 2, 'BELANJA PASIR', 0.00, 10000000.00, '2025-12-07 17:00:00', '2025-12-07 17:00:00'),
(26, '2025-08-15', 2, 'KULAK STOP KONTAK', 0.00, 1475430.00, '2025-08-14 17:00:00', '2025-08-14 17:00:00'),
(27, '2025-08-15', 2, 'PELUNASAN PAKU TGL 23 JULI 2025', 0.00, 1872000.00, '2025-08-14 17:00:00', '2025-08-14 17:00:00'),
(28, '2025-08-16', 3, 'ADMIN BULANAN ATM', 0.00, 90000.00, '2025-08-15 17:00:00', '2025-08-15 17:00:00'),
(29, '2025-08-18', 1, 'PEMASUKAN TOKO', 2300000.00, 0.00, '2025-08-17 17:00:00', '2025-08-17 17:00:00'),
(30, '2025-08-18', 2, 'KULAK BATERAI ABC 24', 0.00, 622250.00, '2025-08-17 17:00:00', '2025-08-17 17:00:00'),
(31, '2025-08-21', 2, 'KULAK LEM KUNING 10', 0.00, 865000.00, '2025-08-20 17:00:00', '2025-08-20 17:00:00'),
(32, '2025-08-21', 2, 'KULAK PAKU PAYUNG SA', 0.00, 2698000.00, '2025-08-20 17:00:00', '2025-08-20 17:00:00'),
(33, '2025-08-23', 1, 'PEMASUKAN TOKO', 6800000.00, 0.00, '2025-08-22 17:00:00', '2025-08-22 17:00:00'),
(34, '2025-08-23', 3, 'BELI SAPU GALANGAN', 0.00, 180000.00, '2025-08-22 17:00:00', '2025-08-22 17:00:00'),
(35, '2025-08-27', 3, 'CETAK BROSUR', 0.00, 1585000.00, '2025-08-26 17:00:00', '2025-08-26 17:00:00'),
(36, '2025-08-29', 3, 'KERANJANG BUAH', 0.00, 325000.00, '2025-08-28 17:00:00', '2025-08-28 17:00:00'),
(37, '2025-08-30', 1, 'PEMASUKAN TOKO', 5000000.00, 0.00, '2025-08-29 17:00:00', '2025-08-29 17:00:00'),
(38, '2025-08-30', 3, 'UPAH DE MUN + UPAH DE HADI', 0.00, 2700000.00, '2025-08-29 17:00:00', '2025-08-29 17:00:00'),
(39, '2025-01-09', 2, 'KULAK LAMPU INLITE', 0.00, 1952170.00, '2025-01-08 17:00:00', '2025-01-08 17:00:00'),
(40, '2025-01-09', 2, 'KULAK WD 2 KOTAK', 0.00, 1074480.00, '2025-01-08 17:00:00', '2025-01-08 17:00:00'),
(41, '2025-01-09', 2, 'CAT AVIAN 25C 25PCS', 0.00, 1150000.00, '2025-01-08 17:00:00', '2025-01-08 17:00:00'),
(42, '2025-01-09', 2, 'BELANJA CAT DI TOKO LANCAR', 0.00, 14425000.00, '2025-01-08 17:00:00', '2025-01-08 17:00:00'),
(43, '2025-01-09', 2, 'KIKIR', 0.00, 836550.00, '2025-01-08 17:00:00', '2025-01-08 17:00:00'),
(44, '2025-05-09', 2, 'T dus 5/8 dan IB Dus 5/8', 241500.00, 241500.00, '2025-05-08 17:00:00', '2025-05-08 17:00:00'),
(45, '2025-06-09', 1, 'PEMASUKAN TOKO', 4800000.00, 0.00, '2025-06-08 17:00:00', '2025-06-08 17:00:00'),
(46, '2025-08-09', 2, 'SOK DRAT DALAM 1/2\"', 0.00, 198000.00, '2025-08-08 17:00:00', '2025-08-08 17:00:00'),
(47, '2025-08-09', 2, 'SOK 3/4\"', 0.00, 431500.00, '2025-08-08 17:00:00', '2025-08-08 17:00:00'),
(48, '2025-08-09', 2, 'SOK 1/2\"', 0.00, 321000.00, '2025-08-08 17:00:00', '2025-08-08 17:00:00'),
(49, '2025-08-09', 2, 'ISI LEM TEMBAK KECIL', 0.00, 456220.00, '2025-08-08 17:00:00', '2025-08-08 17:00:00'),
(50, '2025-09-13', 1, 'PEMASUKAN TOKO', 2200000.00, 0.00, '2025-09-12 17:00:00', '2025-09-12 17:00:00'),
(51, '2025-09-16', 3, 'ADMIN BULANAN ATM', 0.00, 90000.00, '2025-09-15 17:00:00', '2025-09-15 17:00:00'),
(52, '2025-09-18', 1, 'BATA KUMBUNG 100PCS', 17250000.00, 0.00, '2025-09-17 17:00:00', '2025-09-17 17:00:00'),
(53, '2025-09-18', 3, 'UPAH DE HADI BATU KUMBUNG ABAH KOLIL', 0.00, 1100000.00, '2025-09-17 17:00:00', '2025-09-17 17:00:00'),
(54, '2025-09-18', 1, 'PELUNASAN BELANJA KANTOR ', 5110000.00, 0.00, '2025-09-17 17:00:00', '2025-09-17 17:00:00'),
(55, '2025-09-18', 1, 'PELUNASAN BELANJA KABEL ARJUNA', 900000.00, 0.00, '2025-09-17 17:00:00', '2025-09-17 17:00:00'),
(56, '2025-09-21', 1, 'PEMASUKAN TOKO', 2500000.00, 0.00, '2025-09-20 17:00:00', '2025-09-20 17:00:00'),
(57, '2025-09-26', 2, 'KULAK PAKU SA', 0.00, 2785000.00, '2025-09-25 17:00:00', '2025-09-25 17:00:00'),
(58, '2025-09-26', 3, 'NOTA KECIL', 0.00, 175000.00, '2025-09-25 17:00:00', '2025-09-25 17:00:00'),
(59, '2025-09-26', 1, 'PEMASUKAN TOKO', 3000000.00, 0.00, '2025-09-25 17:00:00', '2025-09-25 17:00:00'),
(60, '2025-03-10', 2, 'KULAK STOP KONTAK BROCO TANAM', 0.00, 1011980.00, '2025-03-09 17:00:00', '2025-03-09 17:00:00'),
(61, '2025-03-10', 2, 'KULAK SAKLAR', 0.00, 1024000.00, '2025-03-09 17:00:00', '2025-03-09 17:00:00'),
(62, '2025-04-10', 3, 'UPAH DE MUN + UPAH DE HADI BULAN SEPTEMBER', 0.00, 2250000.00, '2025-04-09 17:00:00', '2025-04-09 17:00:00'),
(63, '2025-04-10', 1, 'PEMASUKAN TOKO', 13500000.00, 0.00, '2025-04-09 17:00:00', '2025-04-09 17:00:00'),
(64, '2025-04-10', 2, 'KULAK BATU KOMBONG 270 BJ', 0.00, 22200000.00, '2025-04-09 17:00:00', '2025-04-09 17:00:00'),
(65, '2025-04-10', 3, 'BELI NASI GORENG UNTUK KULI DAN SUPIR KIRIM BATU KOMBONG', 0.00, 480000.00, '2025-04-09 17:00:00', '2025-04-09 17:00:00'),
(66, '2025-11-10', 1, 'PEMASUKAN TOKO', 9000000.00, 0.00, '2025-11-09 17:00:00', '2025-11-09 17:00:00'),
(67, '2025-11-10', 2, 'KULAK SEMEN 25 SAK', 0.00, 12475000.00, '2025-11-09 17:00:00', '2025-11-09 17:00:00'),
(68, '2025-10-16', 3, 'ADMIN BULANAN ATM', 0.00, 90000.00, '2025-10-15 17:00:00', '2025-10-15 17:00:00'),
(69, '2025-10-18', 1, 'PEMASUKAN TOKO', 2500000.00, 0.00, '2025-10-17 17:00:00', '2025-10-17 17:00:00'),
(70, '2025-10-20', 1, 'SUPPORT NATUSI', 0.00, 39268250.00, '2025-10-19 17:00:00', '2025-10-19 17:00:00'),
(71, '2025-10-25', 1, 'PEMASUKAN TOKO', 3000000.00, 0.00, '2025-10-24 17:00:00', '2025-10-24 17:00:00'),
(72, '2025-10-31', 1, 'PEMASUKAN TOKO', 12500000.00, 0.00, '2025-10-30 17:00:00', '2025-10-30 17:00:00'),
(73, '2015-10-31', 3, 'GANTI BENSIN PICKUP', 0.00, 550000.00, '2015-10-30 17:00:00', '2015-10-30 17:00:00'),
(74, '2025-03-11', 2, 'WATERMUR', 0.00, 245000.00, '2025-03-10 17:00:00', '2025-03-10 17:00:00'),
(75, '2025-03-11', 2, 'SOLDER', 0.00, 406500.00, '2025-03-10 17:00:00', '2025-03-10 17:00:00'),
(76, '2025-03-11', 2, 'KRAN 3/4', 0.00, 513800.00, '2025-03-10 17:00:00', '2025-03-10 17:00:00'),
(77, '2025-03-11', 2, 'SEMEN GRESIK 25 SAK MORODADI', 0.00, 13715000.00, '2025-03-10 17:00:00', '2025-03-10 17:00:00'),
(78, '2025-06-11', 2, 'KULAK PAKU 2 DIM 10KG', 0.00, 1395000.00, '2025-06-10 17:00:00', '2025-06-10 17:00:00'),
(79, '2025-07-11', 3, 'OPS GALANGAN (BENSIN DLL)', 0.00, 2025000.00, '2025-07-10 17:00:00', '2025-07-10 17:00:00'),
(80, '2025-08-11', 1, 'PEMASUKAN TOKO', 7300000.00, 0.00, '2025-08-10 17:00:00', '2025-08-10 17:00:00'),
(81, '2025-08-11', 3, 'UPAH DEH MUN BULAN OKT 2025 + DE HADI', 0.00, 2850000.00, '2025-08-10 17:00:00', '2025-08-10 17:00:00'),
(82, '2025-10-11', 3, 'KAMPAS KOPLING PIKEP', 0.00, 1008000.00, '2025-10-10 17:00:00', '2025-10-10 17:00:00'),
(83, '2025-09-11', 3, 'TIKAR', 0.00, 524990.00, '2025-09-10 17:00:00', '2025-09-10 17:00:00'),
(84, '2025-09-11', 3, 'KIPAS', 0.00, 650000.00, '2025-09-10 17:00:00', '2025-09-10 17:00:00'),
(85, '2025-11-15', 1, 'PEMASUKAN TOKO', 6500000.00, 0.00, '2025-11-14 17:00:00', '2025-11-14 17:00:00'),
(86, '2025-11-15', 3, 'UPAH SEBAR BROSUR', 0.00, 600000.00, '2025-11-14 17:00:00', '2025-11-14 17:00:00'),
(87, '2025-11-16', 3, 'ADMIN BULANAN ATM', 0.00, 90000.00, '2025-11-15 17:00:00', '2025-11-15 17:00:00'),
(88, '2025-11-22', 1, 'PEMASUKAN TOKO', 5160000.00, 0.00, '2025-11-21 17:00:00', '2025-11-21 17:00:00'),
(89, '2025-11-29', 1, 'PEMASUKAN TOKO', 5500000.00, 0.00, '2025-11-28 17:00:00', '2025-11-28 17:00:00'),
(90, '2025-11-29', 2, 'KULAK KNEE 1/2DIM', 0.00, 241680.00, '2025-11-28 17:00:00', '2025-11-28 17:00:00'),
(91, '2025-11-29', 2, 'KULAK TIMBA', 0.00, 490000.00, '2025-11-28 17:00:00', '2025-11-28 17:00:00'),
(92, '2025-11-29', 2, 'KULAK LEM KUNING 10', 0.00, 1002000.00, '2025-11-28 17:00:00', '2025-11-28 17:00:00'),
(93, '2025-11-29', 2, 'KULAK KRAN DAN KUAS 3\"', 0.00, 944400.00, '2025-11-28 17:00:00', '2025-11-28 17:00:00'),
(94, '2025-11-29', 2, 'KLEM REGULATOR', 0.00, 186220.00, '2025-11-28 17:00:00', '2025-11-28 17:00:00'),
(95, '2025-11-29', 2, 'CATOK REGULATOR', 0.00, 223480.00, '2025-11-28 17:00:00', '2025-11-28 17:00:00'),
(96, '2025-06-12', 1, 'PEMASUKAN TOKO', 2500000.00, 0.00, '2025-06-11 17:00:00', '2025-06-11 17:00:00'),
(97, '2025-06-12', 3, 'UPAH DEMUN 23 HARI KERJA NOVEMBER', 0.00, 2300000.00, '2025-06-11 17:00:00', '2025-06-11 17:00:00'),
(98, '2025-06-12', 2, 'KULAK PAKU 1 1/4', 0.00, 725000.00, '2025-06-11 17:00:00', '2025-06-11 17:00:00'),
(99, '2025-09-12', 3, 'KALENDAER GALANGAN 50PCS', 0.00, 3538000.00, '2025-09-11 17:00:00', '2025-09-11 17:00:00'),
(100, '2025-12-15', 1, 'PEMASUKAN TOKO', 4400000.00, 0.00, '2025-12-14 17:00:00', '2025-12-14 17:00:00'),
(101, '2025-12-16', 3, 'ADMIN BULANAN ATM', 0.00, 90000.00, '2025-12-15 17:00:00', '2025-12-15 17:00:00'),
(102, '2025-12-26', 1, 'PEMASUKAN TOKO', 2700000.00, 0.00, '2025-12-25 17:00:00', '2025-12-25 17:00:00'),
(103, '2026-02-01', 2, 'KULAK KNEE DD 1/2', 0.00, 204000.00, '2026-01-31 17:00:00', '2026-01-31 17:00:00'),
(104, '2026-02-01', 2, 'KULAK KNEE 3/4', 318000.00, 318000.00, '2026-01-31 17:00:00', '2026-01-31 17:00:00'),
(105, '2026-02-01', 2, 'KULAK AMPLAS 3 UKURAN (60,150,240)', 0.00, 1360000.00, '2026-01-31 17:00:00', '2026-01-31 17:00:00'),
(106, '2026-03-01', 2, 'WATERMUR DD 3/4', 0.00, 293650.00, '2026-02-28 17:00:00', '2026-02-28 17:00:00'),
(107, '2026-03-01', 2, 'BENDRAT 5KG', 0.00, 945000.00, '2026-02-28 17:00:00', '2026-02-28 17:00:00'),
(108, '2026-03-01', 2, 'KAWAT GALVANIS', 0.00, 279500.00, '2026-02-28 17:00:00', '2026-02-28 17:00:00'),
(109, '2026-03-01', 1, 'PEMASUKAN TOKO', 10000000.00, 0.00, '2026-02-28 17:00:00', '2026-02-28 17:00:00'),
(110, '2026-03-01', 3, 'UPAH DE MUN BULAN DESEMBER', 0.00, 2500000.00, '2026-02-28 17:00:00', '2026-02-28 17:00:00'),
(111, '2026-03-01', 2, 'LEM RAJAWALI 12', 0.00, 2292000.00, '2026-02-28 17:00:00', '2026-02-28 17:00:00'),
(112, '2026-05-01', 2, 'S GRESIK 15', 0.00, 8325000.00, '2026-04-30 17:00:00', '2026-04-30 17:00:00'),
(113, '2026-05-01', 2, 'S MERDEKA 5', 0.00, 2075000.00, '2026-04-30 17:00:00', '2026-04-30 17:00:00'),
(114, '2026-05-01', 2, 'PAKU 3\" 10KG', 0.00, 1300000.00, '2026-04-30 17:00:00', '2026-04-30 17:00:00'),
(115, '2026-05-01', 2, 'PAKU 2 1/2\" 10KG', 0.00, 1300000.00, '2026-04-30 17:00:00', '2026-04-30 17:00:00'),
(116, '2026-08-01', 3, 'UPAH WATU KUMBUNG 50', 0.00, 350000.00, '2026-07-31 17:00:00', '2026-07-31 17:00:00'),
(117, '2026-01-16', 3, 'ADMIN BULANAN ATM', 0.00, 90000.00, '2026-01-15 17:00:00', '2026-01-15 17:00:00'),
(118, '2026-01-17', 1, 'PEMASUKAN TOKO', 3820000.00, 0.00, '2026-01-16 17:00:00', '2026-01-16 17:00:00'),
(119, '2026-01-17', 3, 'BELI PLASTIK UNTUK WADAH KAPUR', 0.00, 300000.00, '2026-01-16 17:00:00', '2026-01-16 17:00:00'),
(120, '2026-01-21', 2, 'KULAK LAMPU', 0.00, 2859870.00, '2026-01-20 17:00:00', '2026-01-20 17:00:00'),
(121, '2026-01-21', 2, 'KULAK DOP', 0.00, 659800.00, '2026-01-20 17:00:00', '2026-01-20 17:00:00'),
(122, '2026-01-21', 2, 'DOP HEMAT', 0.00, 309990.00, '2026-01-20 17:00:00', '2026-01-20 17:00:00'),
(123, '2026-01-21', 2, 'SAKLAR TEMPEL', 0.00, 955280.00, '2026-01-20 17:00:00', '2026-01-20 17:00:00'),
(124, '2026-01-21', 2, 'PITING GANTUNG', 0.00, 314000.00, '2026-01-20 17:00:00', '2026-01-20 17:00:00'),
(125, '2026-01-21', 2, 'OVERLUP', 0.00, 284000.00, '2026-01-20 17:00:00', '2026-01-20 17:00:00'),
(126, '2026-01-24', 1, 'PEMASUKAN TOKO', 12000000.00, 0.00, '2026-01-23 17:00:00', '2026-01-23 17:00:00'),
(127, '2026-01-25', 3, 'UPAH PASANG PAVING DP', 0.00, 2000000.00, '2026-01-24 17:00:00', '2026-01-24 17:00:00'),
(128, '2026-01-26', 2, 'GERGAJI BESI PIPA', 0.00, 428000.00, '2026-01-25 17:00:00', '2026-01-25 17:00:00'),
(129, '2026-01-26', 2, 'KNEE 1 DIM', 0.00, 417400.00, '2026-01-25 17:00:00', '2026-01-25 17:00:00'),
(130, '2026-01-29', 5, 'CAT RUKO', 0.00, 50000.00, '2026-01-28 20:53:44', '2026-01-28 20:53:44'),
(131, '2026-01-29', 3, 'LISTRIK TOKEN 50K', 0.00, 100000.00, '2026-01-28 21:10:22', '2026-01-28 21:10:22');

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
(1, 'Fitting Gantung', NULL, NULL, NULL),
(2, 'Colokan T ', NULL, NULL, NULL),
(3, 'Steker Bulat', NULL, NULL, NULL),
(4, 'Steker Gepeng', NULL, NULL, NULL),
(5, 'Saklar Gantung Putih jumbo', NULL, NULL, NULL),
(6, 'Saklar Gantung Hitam', NULL, NULL, NULL),
(7, 'Isolasi Hitam National', NULL, NULL, NULL),
(8, 'Lem PVC Isarplas 40gram', NULL, NULL, NULL),
(9, 'Isolasi Kran air onda ', NULL, NULL, NULL),
(10, 'Tutup Pipa 3/4\"', NULL, NULL, NULL),
(11, 'Fitting lampu gantung outdoor (10 m 5 fitting)', NULL, NULL, NULL),
(12, 'Obeng karet 4\" plus', NULL, NULL, NULL),
(13, 'Obeng karet 4\" minus', NULL, NULL, NULL),
(14, 'Obeng karet 6\" plus', NULL, NULL, NULL),
(15, 'Obeng karet 6\" Minus', NULL, NULL, NULL),
(16, 'Kabel Awg 24 Double 2x18 merah hitam', NULL, NULL, NULL),
(17, 'Kabel bintik serabut tembaga motor mobil 20mx0.5mm/0,85mm merah 0,5mm', NULL, NULL, NULL),
(18, 'Kabel bintik serabut tembaga motor mobil 20mx0.5mm/0,85mm hitam 0,5mm', NULL, NULL, NULL),
(19, 'Mata Gerinda keramik 4 inch kering', NULL, NULL, NULL),
(20, 'Kabel tunggal serabut 0.8mmx25m biru 25m', NULL, NULL, NULL),
(21, 'Kabel tunggal serabut 0.8mmx25m Hitam 25m', NULL, NULL, NULL),
(22, 'Lampu Hias LED strip USB 10m+adaptor ', NULL, NULL, NULL),
(23, 'Lampu LED strip outdoor rainbow 10m +adaptor', NULL, NULL, NULL),
(24, 'Lampu LED strip outdoor merah putih 10m +adaptor', NULL, NULL, NULL),
(25, 'Lampu tumbler 10m (rainbow)', NULL, NULL, NULL),
(26, 'WD Gerinda potong besi', NULL, NULL, NULL),
(27, 'Meteran karet 7,5m (merk HPP)', NULL, NULL, NULL),
(28, 'Meteran karet 5m (merk VPR)', NULL, NULL, NULL),
(29, 'Kuas cat 2 1/2\" (merk MDN)', NULL, NULL, NULL),
(30, 'Kuas cat 2\" (merk MDN)', NULL, NULL, NULL),
(31, 'Kuas cat 3\" (merk MDN)', NULL, NULL, NULL),
(32, 'Kuas cat 1 1/2\" (merk MDN)', NULL, NULL, NULL),
(33, 'Kuas cat 1\" (merk MDN)', NULL, NULL, NULL),
(34, 'Kran PVC Tembok 3/4\"', NULL, NULL, NULL),
(35, 'Kran PVC Tembok 1/2\"', NULL, NULL, NULL),
(36, 'Lampu bohlam inlite 5w Putih', NULL, NULL, NULL),
(37, 'Lampu bohlam inlite 7w Putih', NULL, NULL, NULL),
(38, 'Lampu bohlam inlite 15w Putih', NULL, NULL, NULL),
(39, 'Lampu bohlam inlite 12w Putih', NULL, NULL, NULL),
(40, 'Lampu tintin platinum LED 9w', NULL, NULL, NULL),
(41, 'Lampu tintin platinum LED 5w', NULL, NULL, NULL),
(42, 'Lampu tintin platinum LED 21w', NULL, NULL, NULL),
(43, 'Lampu tintin platinum LED 15w', NULL, NULL, NULL),
(44, 'Lampu tintin platinum LED 12w', NULL, NULL, NULL),
(45, 'Lampu tintin platinum LED 7w', NULL, NULL, NULL),
(46, 'Gergaji kayu (POPEYE) 18 inch ', NULL, NULL, NULL),
(47, 'Kapi plamir plastik PVC 9\" (23cm)', NULL, NULL, NULL),
(48, 'Kapi plamir plastik PVC 5\" (12cm)', NULL, NULL, NULL),
(49, 'Kapi plamir plastik PVC 7\" (18cm)', NULL, NULL, NULL),
(50, 'Tang Kombinasi karet 8\"', NULL, NULL, NULL),
(51, 'Tang Kombinasi 8\"', NULL, NULL, NULL),
(52, 'Stop Kontak Hitam 3L 5M ', NULL, NULL, NULL),
(53, 'Stop Kontak Hitam 4L 5M ', NULL, NULL, NULL),
(54, 'Stop Kontak Hitam 5L 5M ', NULL, NULL, NULL),
(55, 'Stop Kontak Hitam 2L 5M ', NULL, NULL, NULL),
(56, 'Palu Konde besi cor gagang kayu ukuran 1LB', NULL, NULL, NULL),
(57, 'Lem kuning 100gr', NULL, NULL, NULL),
(58, 'Lem aica aibon kuning 125gr', NULL, NULL, NULL),
(59, 'Kuas 4\" incco', NULL, NULL, NULL),
(60, 'Meteran Autostop Wilmer 5m*19mm', NULL, NULL, NULL),
(61, 'Precision S/Driver Obeng 6S DIY', NULL, NULL, NULL),
(62, 'Blades / Isi Cutter Besar DIY', NULL, NULL, NULL),
(63, 'Blades / Isi Cutter Kecil DIY', NULL, NULL, NULL),
(64, 'Screwdriver  / Obeng 4\" isi 2 DIY', NULL, NULL, NULL),
(65, 'Test Pen DIY', NULL, NULL, NULL),
(66, 'Door Bolt / Selot Pintu DIY 4\"', NULL, NULL, NULL),
(67, 'Door Bolt / Selot Pintu DIY 3\"', NULL, NULL, NULL),
(68, 'Kuas 2\" incco', NULL, NULL, NULL),
(69, 'Kuas 1\" incco ', NULL, NULL, NULL),
(70, 'Kapi Plastik Kuning DIY', NULL, NULL, NULL),
(71, 'Kabel Ties 3.6x300mm (85 gram) isi 100 pcs', NULL, NULL, NULL),
(72, 'Kabel Ties 3.6x150mm (60 gram) isi 100 pcs', NULL, NULL, NULL),
(73, 'Kabel Ties 2.5x200mm (50 gram) isi 100 pcs', NULL, NULL, NULL),
(74, 'Kabel Ties 2.5x100mm (50 gram) isi 100 pcs', NULL, NULL, NULL),
(75, 'Kabel Ties 2.5x150mm (50 gram) isi 100 pcs', NULL, NULL, NULL),
(76, 'Kabel Ties 3.6x250mm (80 gram) isi 100 pcs', NULL, NULL, NULL),
(77, 'Kabel Ties 4.8x200mm (85 gram) isi 100 pcs', NULL, NULL, NULL),
(78, 'Kabel Ties 3.6x150mm (70 gram) isi 100 pcs', NULL, NULL, NULL),
(79, 'Kabel Ties 3.6x250mm (70 gram) isi 100 pcs', NULL, NULL, NULL),
(80, 'Kabel Transparan 2x30 90M full serabut per roll 2line', NULL, NULL, NULL),
(81, 'Kabel Transparan 2x80 90M full serabut per roll 2line', NULL, NULL, NULL),
(82, 'Kabel Transparan 2x50 90M full serabut per roll 2line', NULL, NULL, NULL),
(83, 'Solder listrik gagang kayu 60watt', NULL, NULL, NULL),
(84, 'Timah gulung solder tenol elektrik', NULL, NULL, NULL),
(85, 'Solasi lakban coklat', NULL, NULL, NULL),
(86, 'Spidol Kecil snowman Hitam', NULL, NULL, NULL),
(87, 'Spidol Kecil snowman Merah', NULL, NULL, NULL),
(88, 'isolasi Lakban Packing bening', NULL, NULL, NULL),
(89, 'Tali tampar/ Tali tukang', NULL, NULL, NULL),
(90, 'Keranjang serbaguna', NULL, NULL, NULL),
(91, 'Paku (Nail 2000) 1 1/2\"', NULL, NULL, NULL),
(92, 'Paku (Nail 2000) 2 1/2\"', NULL, NULL, NULL),
(93, 'Paku (Nail 2000) 3\"', NULL, NULL, NULL),
(94, 'Paku (Nail 2000) 1\"', NULL, NULL, NULL),
(95, 'Paku (Nail 20000 1 3/4\"', NULL, NULL, NULL),
(96, 'Paku (Nail 2000) 2\"', NULL, NULL, NULL),
(97, 'Besi Beton 6mm SNI (U)', NULL, NULL, NULL),
(98, 'Besi Beton 8mm SNI (U)', NULL, NULL, NULL),
(99, 'Besi Beton 10mm SNI (U)', NULL, NULL, NULL),
(100, 'Hollow G Tube 20x40x0.4', NULL, NULL, NULL),
(101, 'Hollow G Tube 40x40x0.4', NULL, NULL, NULL),
(102, 'Reng Galvalum Kenana 0.45 (M)', NULL, NULL, NULL),
(103, 'C Truss Kencana 75x0.85 (0.75) MM', NULL, NULL, NULL),
(104, 'KAYU BALOK 4X6X4', NULL, NULL, NULL),
(105, 'KAYU BALOK 3X5X4', NULL, NULL, NULL),
(106, 'KAYU BALOK 2X3X4', NULL, NULL, NULL),
(107, 'CANGKUL ', NULL, NULL, NULL),
(108, 'SEKOP PASIR', NULL, NULL, NULL),
(109, 'Baut Drilling Galvalum Baja Ringan 100\r\nPcs Per Plastik - WL 12x50 100Pcs', NULL, NULL, NULL),
(110, 'Baut Drilling Galvalum Baja Ringan 100\r\nPcs Per Plastik - WL 12x60 100Pcs', NULL, NULL, NULL),
(111, 'Baut Drilling Galvalum Baja Ringan 100\r\nPcs Per Plastik - WL 12x30 100Pcs', NULL, NULL, NULL),
(112, 'Baut Drilling Galvalum Baja Ringan 100\r\nPcs Per Plastik - WL 12x40 100Pcs', NULL, NULL, NULL),
(113, 'Baut Drilling Galvalum Baja Ringan 100\r\nPcs Per Plastik - WL 12x20 100Pcs', NULL, NULL, NULL),
(114, 'Batu Kumbung', NULL, NULL, NULL),
(115, 'Triplek 8m sengon', NULL, NULL, NULL),
(116, 'Triplek 6m sengon', NULL, NULL, NULL),
(117, 'Triplek 3m sengon', NULL, NULL, NULL),
(118, 'Semen Gresik', NULL, NULL, NULL),
(119, 'Kapur', NULL, NULL, NULL),
(120, 'Pasir', NULL, NULL, NULL),
(121, 'Stop kontak 1 lubang', NULL, NULL, NULL),
(122, 'Stop kontak 2 lubang', NULL, NULL, NULL),
(123, 'Stop kontak 3 lubang', NULL, NULL, NULL),
(124, 'Stop kontak 4 lubang', NULL, NULL, NULL),
(125, 'Stop kontak 5 lubang', NULL, NULL, NULL),
(126, 'Baterai ABC', NULL, NULL, NULL),
(127, 'NAIL  PAKU PAYUNG 2\"', NULL, NULL, NULL),
(128, 'NAIL PAKU PAYUNG ULIR 3\"', NULL, NULL, NULL),
(129, 'NAIL PAKU PAYUNG ULIR 4\"', NULL, NULL, NULL),
(130, 'PAKU PINES ', NULL, NULL, NULL),
(131, 'KIKIR 3 INC', NULL, NULL, NULL),
(132, 'KIKIR 3.5 INC', NULL, NULL, NULL),
(133, 'KIKIR 4 INC', NULL, NULL, NULL),
(134, 'AVIAN 192 VERMILLION 25CC', NULL, NULL, NULL),
(135, 'AVIAN SB 25CC', NULL, NULL, NULL),
(136, 'AVIAN 465 MEDIUM YELLOW 25CC', NULL, NULL, NULL),
(137, 'AVIAN 733 OCEAN BLUE 25CC', NULL, NULL, NULL),
(138, 'AVIAN SW 25CC', NULL, NULL, NULL),
(139, 'AVIAN KAYU BESI SB', NULL, NULL, NULL),
(140, 'AVIAN KAYU BESI 192', NULL, NULL, NULL),
(141, 'AVIAN KAYU BESI 480', NULL, NULL, NULL),
(142, 'AVIAN KAYU BESI SW', NULL, NULL, NULL),
(143, 'BEE BRAND KAYU BESI 126 GREEN', NULL, NULL, NULL),
(144, 'BEE BRAND KAYU BESI 1019 DEL FOGLIO', NULL, NULL, NULL),
(145, 'BEE BRAND KAYU BESI 115 SILVER', NULL, NULL, NULL),
(146, 'PARAGON TEMBOK SW 5KG', NULL, NULL, NULL),
(147, 'PARAGON TEMBOK SW 1KG', NULL, NULL, NULL),
(148, 'NODROP TEMBOK ABU-ABU 602 1KG', NULL, NULL, NULL),
(149, 'AVITEX TEMBOK 710 BLUE', NULL, NULL, NULL),
(150, 'AVITEX TEMBOK 770 GREEN', NULL, NULL, NULL),
(151, 'AVITEX TEMBOK 750 YELLOW', NULL, NULL, NULL),
(152, 'AVITEX TEMBOK 831 CREAM', NULL, NULL, NULL),
(153, 'AVITEX TEMBOK SB', NULL, NULL, NULL),
(154, 'knee 1/2 dim', NULL, NULL, NULL),
(155, 'knee 3/4 dim', NULL, NULL, NULL),
(156, 'knee drat dalam 3/4 dim', NULL, NULL, NULL),
(157, 'paku 1 1/2', NULL, NULL, NULL),
(158, 'paku 3/4', NULL, NULL, NULL),
(159, 't  1/2 dim', NULL, NULL, NULL),
(160, 'knee 1 dim', NULL, NULL, NULL),
(161, 't 1/2 dim', NULL, NULL, NULL),
(162, 't 1/4 dim', NULL, NULL, NULL),
(163, 't 2 dim', NULL, NULL, NULL),
(164, 't 3/4 dim', NULL, NULL, NULL),
(165, 'knee 1 1/2', NULL, NULL, NULL),
(166, 't drat dalam 1/2 dim', NULL, NULL, NULL),
(167, 't drat dalam 3/4', NULL, NULL, NULL),
(168, 'sok darat luar 1/2', NULL, NULL, NULL),
(169, 'knee 1 1/4', NULL, NULL, NULL),
(170, 'sok drat dalam 1/2', NULL, NULL, NULL),
(171, 'sok 1/2', NULL, NULL, NULL),
(172, 'sok 3/4', NULL, NULL, NULL),
(173, 'sok 1 1/2', NULL, NULL, NULL),
(174, 'sok 2', NULL, NULL, NULL),
(175, 'sok 1 1/4', NULL, NULL, NULL),
(176, 'sok 3', NULL, NULL, NULL),
(177, 'sok drat dalam 1', NULL, NULL, NULL),
(178, 'sok drat dalam 3/4', NULL, NULL, NULL),
(179, 'sok drat luar 3/4', NULL, NULL, NULL),
(180, 'overlup 1 x 3/4', NULL, NULL, NULL),
(181, 'sok drat dalam 3/4 x 1/2', NULL, NULL, NULL),
(182, 'overlup 2 x 1', NULL, NULL, NULL),
(183, 'overlup 2 x 1 1/2', NULL, NULL, NULL),
(184, 'overlup 1 x 1 1/2', NULL, NULL, NULL),
(185, 'overlup 2 x 2 1/2', NULL, NULL, NULL),
(186, 't  3/4 x 1', NULL, NULL, NULL),
(187, 'knee 2 1/2', NULL, NULL, NULL),
(188, 'sok 4', NULL, NULL, NULL),
(189, 'sok 2 1/2', NULL, NULL, NULL),
(190, 'sok drat luar 2', NULL, NULL, NULL),
(191, 't 4', NULL, NULL, NULL),
(192, 't 3', NULL, NULL, NULL),
(193, 'knee 4', NULL, NULL, NULL),
(194, 'overlup 4 x 2 1/2', NULL, NULL, NULL),
(195, 'overlup 4 x 3', NULL, NULL, NULL),
(196, 'knee 3', NULL, NULL, NULL),
(197, 'tutup pipa 3', NULL, NULL, NULL),
(198, 'tutup pipa 4', NULL, NULL, NULL),
(199, 'tutup pipa 2 1/2', NULL, NULL, NULL),
(200, 'tutup pipa 2', NULL, NULL, NULL),
(201, 'pipa 1/2', NULL, NULL, NULL),
(202, 'pipa 3/4', NULL, NULL, NULL),
(203, 'pipa 5/8', NULL, NULL, NULL),
(204, 'pipa 1 aw', NULL, NULL, NULL),
(205, 'pipa bluefin 1 1/2', NULL, NULL, NULL),
(206, 'pipa quinlon 1 1/2', NULL, NULL, NULL),
(207, 'pipa bluefin 2 dim c', NULL, NULL, NULL),
(208, 'pipa bluefin 2 dim d', NULL, NULL, NULL),
(209, 'pipa interniti 2 dim', NULL, NULL, NULL),
(210, 'pipa bluefin 2 1/2 dim c', NULL, NULL, NULL),
(211, 'pipa quinlon 3 dim c', NULL, NULL, NULL),
(212, 'pipa quinlon 3 dim d', NULL, NULL, NULL),
(213, 'asbes 180 x 1 m', NULL, NULL, NULL),
(214, 'asbes 240 x 1 m', NULL, NULL, NULL),
(215, 'fiber glass', NULL, NULL, NULL),
(216, 'kasiboard 2 m', NULL, NULL, NULL),
(217, 'besi  p 10', NULL, NULL, NULL),
(218, 'besi  8', NULL, NULL, NULL),
(219, 'talang seng gulung', NULL, NULL, NULL),
(220, 'galvalum', NULL, NULL, NULL),
(221, 'watermur 1/2', NULL, NULL, NULL),
(222, 'loster besar kotak', NULL, NULL, NULL),
(223, 'loster besar saringan', NULL, NULL, NULL),
(224, 'lem rajawali', NULL, NULL, NULL),
(225, 'pain roller nippon pain', NULL, NULL, NULL),
(226, 'pain roller index ', NULL, NULL, NULL),
(227, 'timba', NULL, NULL, NULL),
(228, 'paku 5', NULL, NULL, NULL),
(229, 'paku 3 1/2', NULL, NULL, NULL),
(230, 'geraji', NULL, NULL, NULL),
(231, 'cutter', NULL, NULL, NULL),
(232, 'cutter joyko', NULL, NULL, NULL),
(233, 'tang', NULL, NULL, NULL),
(234, 'sarung tangan karet', NULL, NULL, NULL),
(235, 'batrai panasonic 1,5 volt AAA', NULL, NULL, NULL),
(236, 'penggaris siku', NULL, NULL, NULL),
(237, 'turbo cut 1,2 mm', NULL, NULL, NULL),
(238, 'diamond cutting well', NULL, NULL, NULL),
(239, 'paku 1 1/4', NULL, NULL, NULL),
(240, 'siku  kecil', NULL, NULL, NULL),
(241, 'paku 6', NULL, NULL, NULL),
(242, 'paku 4', NULL, NULL, NULL),
(243, 'kasutan /  trowel', NULL, NULL, NULL),
(244, 'kapi 3 dim', NULL, NULL, NULL),
(245, 'kapi 5 dim', NULL, NULL, NULL),
(246, 'cetok sukun hitam', NULL, NULL, NULL),
(247, 'cetok sukun sedang', NULL, NULL, NULL),
(248, 'cetak sukun kecil', NULL, NULL, NULL),
(249, 'paku payung', NULL, NULL, NULL),
(250, 'pinnes', NULL, NULL, NULL),
(251, 'jaring kawat 1/2', NULL, NULL, NULL),
(252, 'jaring kawat 1/4', NULL, NULL, NULL),
(253, 'lampu kepala', NULL, NULL, NULL),
(254, 'lampu led muxindo 25 watt', NULL, NULL, NULL),
(255, 'lampu hemat  5 watt', NULL, NULL, NULL),
(256, 'skrup atap  sedang', NULL, NULL, NULL),
(257, 'waseo led panel 3+3w', NULL, NULL, NULL),
(258, 'distribution box', NULL, NULL, NULL),
(259, 'skrup kecil', NULL, NULL, NULL),
(260, 'skrup besar', NULL, NULL, NULL),
(261, 'floor stainer plastik', NULL, NULL, NULL),
(262, 'skrup atap  kecil', NULL, NULL, NULL),
(263, 'lampu led', NULL, NULL, NULL),
(264, 'waterpres magnet (alat ukur)', NULL, NULL, NULL),
(265, 'round kabel klip 6 mm', NULL, NULL, NULL),
(266, 'round kabel klip 7 mm', NULL, NULL, NULL),
(267, 'round kabel klip 9 mm', NULL, NULL, NULL),
(268, 'round kabel klip 10 mm', NULL, NULL, NULL),
(269, 'floor stainer stainless', NULL, NULL, NULL),
(270, 'amplass bunder', NULL, NULL, NULL),
(271, 'paku beton 1 1/2', NULL, NULL, NULL),
(272, 'tusen klep air', NULL, NULL, NULL),
(273, 'saringan plastik biasa', NULL, NULL, NULL),
(274, 'kuas  2', NULL, NULL, NULL),
(275, 'afur hpp', NULL, NULL, NULL),
(276, 'AFUR KLASIK', NULL, NULL, '2026-01-27 21:25:41'),
(277, 'kuas cat garis', NULL, NULL, NULL),
(278, 'pilox', NULL, NULL, NULL),
(279, 'sikring', NULL, NULL, NULL),
(280, 'Tutup  skring', NULL, NULL, NULL),
(281, 'kabel serabut 0.75 mm', NULL, NULL, NULL),
(282, 'Skalar Tunggal', NULL, NULL, NULL),
(283, 'Saklar Ganda', NULL, NULL, NULL),
(284, 'Kabel audio 2 x 1 1/2', NULL, NULL, NULL),
(285, 'Skalar Triple', NULL, NULL, NULL),
(286, 'Senter', NULL, NULL, NULL),
(287, 'Fittingan', NULL, NULL, NULL),
(288, 'Fittingan bagus', NULL, NULL, NULL),
(289, 'Kassa gibsum', NULL, NULL, NULL),
(290, 'Lampu Tidur', NULL, NULL, NULL),
(291, 'Soket Lampu', NULL, NULL, NULL),
(292, 'Sarung tangan kain', NULL, NULL, NULL),
(293, 'Grendel Double', NULL, NULL, NULL),
(294, 'Kunci Oval pintu', NULL, NULL, NULL),
(295, 'Benang ris  sedang', NULL, NULL, NULL),
(296, 'Jepitan Udang grendel', NULL, NULL, NULL),
(297, 'Cengkal jendela panjang lurus', NULL, NULL, NULL),
(298, 'Gagang Pintu', NULL, NULL, NULL),
(299, 'Sekrup  3cm', NULL, NULL, NULL),
(300, 'Sekrup  2.5', NULL, NULL, NULL),
(301, 'Roda etalase', NULL, NULL, NULL),
(302, 'Gagang pintu besi  besar', NULL, NULL, NULL),
(303, 'Gagang pintu besi  Kecil', NULL, NULL, NULL),
(304, 'Sekrup  6 x 1', NULL, NULL, NULL),
(305, 'Klem kabel  8 mm', NULL, NULL, NULL),
(306, 'Klem kabel  9 mm', NULL, NULL, NULL),
(307, 'Fishcer 8 mm', NULL, NULL, NULL),
(308, 'Fishcer 5 mm', NULL, NULL, NULL),
(309, 'Kran besi 3/4', NULL, NULL, NULL),
(310, 'Gunting tanggung', NULL, NULL, NULL),
(311, 'Stop kran PVC onda 3/4', NULL, NULL, NULL),
(312, 'Stop kran PVC move 1/2', NULL, NULL, NULL),
(313, 'Ungkal', NULL, NULL, NULL),
(314, 'Stop kran PVC jia rong 1', NULL, NULL, NULL),
(315, 'Stop kran move 1', NULL, NULL, NULL),
(316, 'Pegangan laci/ lemari  3', NULL, NULL, NULL),
(317, 'Pegangan laci/ lemari  4', NULL, NULL, NULL),
(318, 'cutter besar', NULL, NULL, NULL),
(319, 'Paku beton 1', NULL, NULL, NULL),
(320, 'Footklem PVC 1 royal 3/4', NULL, NULL, NULL),
(321, 'Footklem PVC 1 royal 1', NULL, NULL, NULL),
(322, 'Tinner 1/2liter', NULL, NULL, NULL),
(323, 'Cat emco', NULL, NULL, NULL),
(324, 'Cat kayu avian 25cc', NULL, NULL, NULL),
(325, 'Engsel Pintu', NULL, NULL, NULL),
(326, 'Lem tikus', NULL, NULL, NULL),
(327, 'Catut 6\"', NULL, NULL, NULL),
(328, 'Catut 9\"', NULL, NULL, NULL),
(329, 'Kunci  lemari/laci', NULL, NULL, NULL),
(330, 'Microphone', NULL, NULL, NULL),
(331, 'Isolasi kecil', NULL, NULL, NULL),
(332, 'Lakban coklat', NULL, NULL, NULL),
(333, 'Fiberglass tape', NULL, NULL, NULL),
(334, 'Gembok 40m', NULL, NULL, NULL),
(335, 'Gembok 35 m', NULL, NULL, NULL),
(336, 'Gembok 25mm', NULL, NULL, NULL),
(337, 'Microphone mini clip', NULL, NULL, NULL),
(338, 'Double tip foam hitam', NULL, NULL, NULL),
(339, 'amplass', NULL, NULL, NULL),
(340, 'Tie clip microphone', NULL, NULL, NULL),
(341, 'Selot besar / grendel 3\"', NULL, NULL, NULL),
(342, 'Tee dos', NULL, NULL, NULL),
(343, 'Double tip foam putih', NULL, NULL, NULL),
(344, 'pegangan pintu putih ', NULL, NULL, NULL),
(345, 'INBOW DUS', NULL, NULL, NULL),
(346, 'TEE DOS', NULL, NULL, NULL),
(347, 'LEM TEMBAK', NULL, NULL, NULL),
(348, 'STOP KONTAK BROCO TANAM', NULL, NULL, NULL),
(349, 'STOP KONTAK TANAM PANASONIC', NULL, NULL, NULL),
(350, 'STOP KONTAK INBOW TANAM', NULL, NULL, NULL),
(351, 'SAKLAR3 CABANG (TEE)', NULL, NULL, NULL),
(352, 'SAKLAR HOKSUN 3 LUBANG', NULL, NULL, NULL),
(353, 'SAKLAR TRM 4 LUBANG', NULL, NULL, NULL),
(354, 'SEMEN MERAH PUTIH', NULL, NULL, NULL),
(355, 'SEMEN SINGA MERAH', NULL, NULL, NULL),
(356, 'WATERMUR 3/4', NULL, NULL, NULL),
(357, 'SOLDER GAGANG KAYU 40W', NULL, NULL, NULL),
(358, 'KUAS GRT 3\"', NULL, NULL, NULL),
(359, 'PENGAMAN REGULATOR', NULL, NULL, NULL),
(360, 'KLEM REGULATOR', NULL, NULL, NULL),
(361, 'TIMBA STANDART', NULL, NULL, NULL),
(362, 'KNEE DRAT DALAM 1/2 DIM', NULL, NULL, NULL),
(363, 'AMPLAS UK 60 ', NULL, NULL, NULL),
(364, 'AMPLAS UK 150', NULL, NULL, NULL),
(365, 'AMPLAS UK 240', NULL, NULL, NULL),
(366, 'WATERMUR DD 3/4', NULL, NULL, NULL),
(367, 'BENDRAT 5KG', NULL, NULL, NULL),
(368, 'S MERDEKA 5', NULL, NULL, NULL);

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
(14, '2026_01_27_020354_create_pos_transaction_items_table', 2),
(15, '2026_01_27_070831_create_stock_items_table', 3),
(16, '2026_01_28_075033_add_gambar_to_product_units_table', 3),
(17, '2026_01_29_120000_add_kategori_to_master_units_table', 4),
(18, '2026_01_29_121500_add_kategori_to_transaction_codes_table', 5),
(19, '2026_01_29_121600_drop_kategori_from_master_units_table', 5),
(20, '2026_01_30_000000_add_insidentil_to_transaction_codes_table', 6);

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
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `harga_jual` decimal(15,2) NOT NULL DEFAULT '0.00',
  `harga_atas` decimal(15,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `product_units`
--

INSERT INTO `product_units` (`id`, `master_product_id`, `master_unit_id`, `nilai_konversi`, `is_base_unit`, `stok`, `harga_beli_terakhir`, `margin`, `gambar`, `harga_jual`, `harga_atas`, `created_at`, `updated_at`) VALUES
(1, 1, 5, 1, 1, 120, 14000.00, 20.00, 'images/products/1769591673_update_1.jpg', 16800.00, 40000.00, '2025-12-31 17:00:00', '2026-01-28 02:14:33'),
(2, 2, 5, 1, 1, 120, 30000.00, 20.00, NULL, 39000.00, 40000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(3, 3, 5, 1, 1, 120, 30000.00, 20.00, NULL, 60000.00, 60000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(4, 4, 5, 1, 1, 120, 11000.00, 20.00, NULL, 14300.00, 30000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(5, 5, 1, 1, 1, 120, 22500.00, 20.00, NULL, 40000.00, 40000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(6, 6, 1, 1, 1, 120, 18500.00, 20.00, NULL, 40000.00, 35000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(7, 7, 5, 1, 1, 200, 51500.00, 20.00, NULL, 79825.00, 80000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(8, 8, 11, 1, 1, 240, 69000.00, 20.00, NULL, 95000.00, 95000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(9, 9, 5, 1, 1, 600, 11500.00, 20.00, NULL, 14950.00, 30000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(10, 10, 5, 1, 1, 500, 8500.00, 20.00, NULL, 12750.00, 30000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(11, 11, 5, 1, 1, 10, 380000.00, 20.00, NULL, 494000.00, 480000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(12, 12, 5, 1, 1, 50, 55000.00, 20.00, NULL, 71500.00, 110000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(13, 13, 5, 1, 1, 50, 55000.00, 20.00, NULL, 71500.00, 110000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(14, 14, 5, 1, 1, 50, 70000.00, 20.00, NULL, 91000.00, 140000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(15, 15, 5, 1, 1, 50, 70000.00, 20.00, NULL, 91000.00, 140000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(16, 16, 5, 1, 1, 20, 1065000.00, 20.00, NULL, 1810500.00, 35000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(17, 17, 5, 1, 1, 20, 337000.00, 20.00, NULL, 572900.00, 30000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(18, 18, 5, 1, 1, 20, 337000.00, 20.00, NULL, 572900.00, 30000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(19, 19, 5, 1, 1, 50, 120000.00, 20.00, NULL, 180000.00, 180000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(20, 20, 5, 1, 1, 10, 175000.00, 20.00, NULL, 297500.00, 20000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(21, 21, 5, 1, 1, 10, 175000.00, 20.00, NULL, 297500.00, 20000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(22, 22, 5, 1, 1, 20, 500000.00, 20.00, NULL, 650000.00, 650000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(23, 23, 5, 1, 1, 50, 270000.00, 20.00, NULL, 351000.00, 450000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(24, 24, 5, 1, 1, 50, 300000.00, 20.00, NULL, 405000.00, 400000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(25, 25, 5, 1, 1, 50, 110000.00, 20.00, NULL, 143000.00, 150000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(26, 26, 5, 1, 1, 600, 29000.00, 20.00, NULL, 50000.00, 50000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(27, 27, 5, 1, 1, 30, 128000.00, 20.00, NULL, 166400.00, 170000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(28, 28, 5, 1, 1, 30, 70000.00, 20.00, NULL, 91000.00, 110000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(29, 29, 2, 1, 1, 50, 53000.00, 20.00, NULL, 68900.00, 70000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(30, 30, 2, 1, 1, 50, 44000.00, 20.00, NULL, 57200.00, 60000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(31, 31, 2, 1, 1, 50, 63000.00, 20.00, NULL, 81900.00, 85000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(32, 32, 2, 1, 1, 50, 34000.00, 20.00, NULL, 44200.00, 50000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(33, 33, 2, 1, 1, 50, 23000.00, 20.00, NULL, 29900.00, 40000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(34, 34, 5, 1, 1, 240, 42000.00, 20.00, NULL, 60000.00, 60000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(35, 35, 5, 1, 1, 240, 42000.00, 20.00, NULL, 60000.00, 60000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(36, 36, 5, 1, 1, 70, 130000.00, 20.00, NULL, 182000.00, 180000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(37, 37, 5, 1, 1, 20, 162000.00, 20.00, NULL, 226800.00, 220000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(38, 38, 5, 1, 1, 40, 280000.00, 20.00, NULL, 392000.00, 370000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(39, 39, 5, 1, 1, 60, 250000.00, 20.00, NULL, 300000.00, 300000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(40, 40, 5, 1, 1, 50, 70000.00, 20.00, NULL, 98000.00, 100000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(41, 41, 5, 1, 1, 50, 50000.00, 20.00, NULL, 70000.00, 70000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(42, 42, 5, 1, 1, 30, 155000.00, 20.00, NULL, 217000.00, 200000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(43, 43, 5, 1, 1, 50, 88000.00, 20.00, NULL, 130000.00, 130000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(44, 44, 5, 1, 1, 50, 78000.00, 20.00, NULL, 109200.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(45, 45, 5, 1, 1, 50, 58000.00, 20.00, NULL, 81200.00, 85000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(46, 46, 5, 1, 1, 40, 150000.00, 20.00, NULL, 195000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(47, 47, 5, 1, 1, 100, 22000.00, 20.00, NULL, 33000.00, 75000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(48, 48, 5, 1, 1, 50, 11000.00, 20.00, NULL, 16500.00, 35000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(49, 49, 5, 1, 1, 100, 15000.00, 20.00, NULL, 22500.00, 50000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(50, 50, 5, 1, 1, 50, 120000.00, 20.00, NULL, 156000.00, 170000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(51, 51, 5, 1, 1, 50, 125000.00, 20.00, NULL, 162500.00, 170000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(52, 52, 5, 1, 1, 20, 184000.00, 20.00, NULL, 276000.00, 250000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(53, 53, 5, 1, 1, 30, 196000.00, 20.00, NULL, 294000.00, 280000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(54, 54, 5, 1, 1, 60, 210000.00, 20.00, NULL, 315000.00, 320000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(55, 55, 5, 1, 1, 20, 170000.00, 20.00, NULL, 255000.00, 210000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(56, 56, 5, 1, 1, 30, 170000.00, 20.00, NULL, 221000.00, 210000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(57, 57, 5, 1, 1, 250, 100000.00, 20.00, NULL, 150000.00, 130000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(58, 58, 5, 1, 1, 20, 182000.00, 20.00, NULL, 273000.00, 210000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(59, 59, 5, 1, 1, 30, 150000.00, 20.00, NULL, 195000.00, 190000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(60, 60, 5, 1, 1, 20, 250000.00, 20.00, NULL, 300000.00, 310000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(61, 61, 5, 1, 1, 20, 95000.00, 20.00, NULL, 133000.00, 140000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(62, 62, 5, 1, 1, 200, 11500.00, 20.00, NULL, 14950.00, 15000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(63, 63, 5, 1, 1, 200, 7000.00, 20.00, NULL, 10500.00, 10000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(64, 64, 5, 1, 1, 20, 120000.00, 20.00, NULL, 156000.00, 200000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(65, 65, 5, 1, 1, 20, 120000.00, 20.00, NULL, 156000.00, 156000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(66, 66, 5, 1, 1, 30, 75000.00, 20.00, NULL, 97500.00, 100000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(67, 67, 5, 1, 1, 20, 105000.00, 20.00, NULL, 136500.00, 140000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(68, 68, 5, 1, 1, 30, 70000.00, 20.00, NULL, 91000.00, 90000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(69, 69, 5, 1, 1, 50, 35000.00, 20.00, NULL, 45500.00, 50000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(70, 70, 5, 1, 1, 40, 55000.00, 20.00, NULL, 71500.00, 75000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(71, 71, 5, 1, 1, 10, 110000.00, 20.00, NULL, 165000.00, 160000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(72, 72, 5, 1, 1, 10, 65000.00, 20.00, NULL, 97500.00, 60000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(73, 73, 5, 1, 1, 10, 53000.00, 20.00, NULL, 79500.00, 110000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(74, 74, 5, 1, 1, 30, 28500.00, 20.00, NULL, 42750.00, 60000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(75, 71, 5, 1, 1, 10, 110000.00, 20.00, NULL, 165000.00, 160000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(76, 75, 5, 1, 1, 10, 41000.00, 20.00, NULL, 61500.00, 60000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(77, 76, 5, 1, 1, 10, 103000.00, 20.00, NULL, 154500.00, 140000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(78, 77, 5, 1, 1, 10, 110000.00, 20.00, NULL, 165000.00, 110000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(79, 74, 5, 1, 1, 10, 28500.00, 20.00, NULL, 42750.00, 45000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(80, 78, 5, 1, 1, 10, 65000.00, 20.00, NULL, 97500.00, 60000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(81, 77, 5, 1, 1, 10, 110000.00, 20.00, NULL, 165000.00, 110000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(82, 79, 5, 1, 1, 10, 103000.00, 20.00, NULL, 154500.00, 140000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(83, 80, 5, 1, 1, 10, 800000.00, 20.00, NULL, 1360000.00, 30000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(84, 81, 5, 1, 1, 10, 1650000.00, 20.00, NULL, 2805000.00, 50000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(85, 82, 5, 1, 1, 10, 1400000.00, 20.00, NULL, 2380000.00, 40000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(86, 83, 5, 1, 1, 50, 130000.00, 20.00, NULL, 169000.00, 170000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(87, 84, 5, 1, 1, 30, 105000.00, 20.00, NULL, 136500.00, 170000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(88, 85, 5, 1, 1, 60, 36000.00, 20.00, NULL, 54000.00, 60000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(89, 86, 5, 1, 1, 120, 17000.00, 20.00, NULL, 25500.00, 50000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(90, 87, 5, 1, 1, 120, 17000.00, 20.00, NULL, 25500.00, 50000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(91, 88, 5, 1, 1, 60, 45000.00, 20.00, NULL, 58500.00, 85000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(92, 89, 5, 1, 1, 200, 17500.00, 20.00, NULL, 22750.00, 50000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(93, 90, 5, 1, 1, 240, 47000.00, 20.00, NULL, 0.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(94, 91, 3, 1, 1, 40, 144000.00, 20.00, NULL, 187200.00, 250000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(95, 92, 3, 1, 1, 200, 135000.00, 20.00, NULL, 175500.00, 240000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(96, 93, 3, 1, 1, 200, 135000.00, 20.00, NULL, 175500.00, 240000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(97, 94, 3, 1, 1, 40, 152000.00, 20.00, NULL, 197600.00, 250000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(98, 95, 3, 1, 1, 40, 141000.00, 20.00, NULL, 183300.00, 250000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(99, 96, 3, 1, 1, 150, 135000.00, 20.00, NULL, 175500.00, 240000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(100, 97, 5, 1, 1, 100, 220000.00, 20.00, NULL, 260000.00, 270000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(101, 98, 5, 1, 1, 100, 370000.00, 20.00, NULL, 430000.00, 440000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(102, 99, 5, 1, 1, 50, 580000.00, 20.00, NULL, 730000.00, 740000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(103, 100, 5, 1, 1, 200, 215000.00, 20.00, NULL, 258000.00, 300000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(104, 101, 5, 1, 1, 100, 285000.00, 20.00, NULL, 342000.00, 285000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(105, 102, 5, 1, 1, 100, 390000.00, 20.00, NULL, 429000.00, 515000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(106, 103, 5, 1, 1, 100, 850000.00, 20.00, NULL, 935000.00, 1105000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(107, 104, 5, 1, 1, 120, 390000.00, 20.00, NULL, 429000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(108, 105, 5, 1, 1, 100, 240000.00, 20.00, NULL, 264000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(109, 106, 5, 1, 1, 250, 96000.00, 20.00, NULL, 105600.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(110, 107, 5, 1, 1, 10, 335800.00, 20.00, NULL, 570860.00, 650000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(111, 108, 4, 1, 1, 20, 200000.00, 20.00, NULL, 340000.00, 450000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(112, 109, 5, 1, 1, 1000, 2500.00, 20.00, NULL, 5000.00, 7000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(113, 110, 5, 1, 1, 1000, 3000.00, 20.00, NULL, 6000.00, 8000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(114, 111, 5, 1, 1, 1000, 1700.00, 20.00, NULL, 3400.00, 5000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(115, 112, 5, 1, 1, 1000, 2200.00, 20.00, NULL, 4400.00, 6000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(116, 113, 5, 1, 1, 1000, 1500.00, 20.00, NULL, 3000.00, 4000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(117, 114, 5, 1, 1, 5700, 80000.00, 20.00, NULL, 120000.00, 120000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(118, 115, 5, 1, 1, 50, 670000.00, 20.00, NULL, 703500.00, 690000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(119, 116, 5, 1, 1, 100, 565000.00, 20.00, NULL, 593250.00, 575000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(120, 117, 5, 1, 1, 100, 385000.00, 20.00, NULL, 404250.00, 395000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(121, 118, 1, 1, 1, 1050, 550000.00, 20.00, NULL, 564850.00, 565000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(122, 119, 5, 1, 1, 1000, 170000.00, 20.00, NULL, 187000.00, 185000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(123, 120, 4, 1, 1, 10, 10000000.00, 20.00, NULL, 11000000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(124, 121, 5, 1, 1, 50, 41250.00, 20.00, NULL, 4166250.00, 80000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(125, 122, 5, 1, 1, 50, 52500.00, 20.00, NULL, 89250.00, 100000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(126, 123, 5, 1, 1, 50, 67500.00, 20.00, NULL, 140000.00, 140000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(127, 124, 5, 1, 1, 50, 81000.00, 20.00, NULL, 160000.00, 160000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(128, 125, 5, 1, 1, 50, 97500.00, 20.00, NULL, 165750.00, 500000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(129, 126, 5, 1, 1, 240, 26000.00, 20.00, NULL, 39000.00, 35000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(130, 127, 3, 1, 1, 50, 175000.00, 20.00, NULL, 262500.00, 185000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(131, 128, 3, 1, 1, 50, 185000.00, 20.00, NULL, 277500.00, 180000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(132, 129, 3, 1, 1, 50, 165000.00, 20.00, NULL, 247500.00, 180000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(133, 130, 3, 1, 1, 90, 12000.00, 20.00, NULL, 20400.00, 30000.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(134, 131, 5, 1, 1, 50, 80000.00, 20.00, NULL, 172000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(135, 132, 5, 1, 1, 20, 75000.00, 20.00, NULL, 191250.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(136, 133, 5, 1, 1, 20, 90000.00, 20.00, NULL, 207000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(137, 134, 5, 1, 1, 50, 45000.00, 20.00, NULL, 55800.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(138, 135, 5, 1, 1, 50, 45000.00, 20.00, NULL, 55800.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(139, 136, 5, 1, 1, 50, 45000.00, 20.00, NULL, 55800.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(140, 137, 5, 1, 1, 50, 45000.00, 20.00, NULL, 55800.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(141, 138, 5, 1, 1, 50, 45000.00, 20.00, NULL, 55800.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(142, 139, 5, 1, 1, 10, 730000.00, 20.00, NULL, 766500.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(143, 140, 5, 1, 1, 10, 730000.00, 20.00, NULL, 766500.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(144, 141, 5, 1, 1, 10, 730000.00, 20.00, NULL, 766500.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(145, 142, 5, 1, 1, 10, 730000.00, 20.00, NULL, 766500.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(146, 143, 5, 1, 1, 10, 680000.00, 20.00, NULL, 727600.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(147, 144, 5, 1, 1, 10, 680000.00, 20.00, NULL, 727600.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(148, 145, 5, 1, 1, 10, 680000.00, 20.00, NULL, 727600.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(149, 146, 3, 1, 1, 20, 1225000.00, 20.00, NULL, 1347500.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(150, 147, 3, 1, 1, 40, 325000.00, 20.00, NULL, 357500.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(151, 148, 3, 1, 1, 40, 535000.00, 20.00, NULL, 588500.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(152, 149, 5, 1, 1, 20, 355000.00, 20.00, NULL, 390500.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(153, 150, 5, 1, 1, 20, 355000.00, 20.00, NULL, 390500.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(154, 151, 5, 1, 1, 20, 355000.00, 20.00, NULL, 390500.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(155, 152, 5, 1, 1, 20, 355000.00, 20.00, NULL, 390500.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(156, 153, 5, 1, 1, 20, 355000.00, 20.00, NULL, 390500.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(157, 154, 5, 1, 1, 460, 25000.00, 20.00, NULL, 25000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(158, 155, 5, 1, 1, 380, 35000.00, 20.00, NULL, 35000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(159, 156, 5, 1, 1, 80, 45000.00, 20.00, NULL, 45000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(160, 157, 3, 1, 1, 10, 250000.00, 20.00, NULL, 250000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(161, 158, 3, 1, 1, 10, 250000.00, 20.00, NULL, 250000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(162, 159, 5, 1, 1, 90, 25000.00, 20.00, NULL, 25000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(163, 160, 5, 1, 1, 180, 40000.00, 20.00, NULL, 40000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(164, 161, 5, 1, 1, 150, 25000.00, 20.00, NULL, 25000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(165, 162, 5, 1, 1, 50, 25000.00, 20.00, NULL, 25000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(166, 163, 5, 1, 1, 240, 50000.00, 20.00, NULL, 50000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(167, 164, 5, 1, 1, 110, 35000.00, 20.00, NULL, 35000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(168, 165, 5, 1, 1, 100, 45000.00, 20.00, NULL, 45000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(169, 166, 5, 1, 1, 100, 30000.00, 20.00, NULL, 30000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(170, 167, 5, 1, 1, 70, 40000.00, 20.00, NULL, 40000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(171, 168, 5, 1, 1, 120, 25000.00, 20.00, NULL, 25000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(172, 169, 5, 1, 1, 130, 35000.00, 20.00, NULL, 35000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(173, 170, 5, 1, 1, 3200, 9300.00, 20.00, NULL, 25000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(174, 171, 5, 1, 1, 3500, 6220.00, 20.00, NULL, 20000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(175, 172, 5, 1, 1, 3500, 8350.00, 20.00, NULL, 30000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(176, 173, 5, 1, 1, 110, 35000.00, 20.00, NULL, 35000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(177, 174, 5, 1, 1, 80, 20000.00, 20.00, NULL, 20000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(178, 175, 5, 1, 1, 170, 35000.00, 20.00, NULL, 35000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(179, 176, 5, 1, 1, 80, 75000.00, 20.00, NULL, 75000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(180, 177, 5, 1, 1, 90, 35000.00, 20.00, NULL, 35000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(181, 178, 5, 1, 1, 50, 40000.00, 20.00, NULL, 40000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(182, 179, 5, 1, 1, 70, 30000.00, 20.00, NULL, 30000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(183, 180, 5, 1, 1, 260, 25000.00, 20.00, NULL, 25000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(184, 181, 5, 1, 1, 60, 30000.00, 20.00, NULL, 30000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(185, 182, 5, 1, 1, 130, 75000.00, 20.00, NULL, 75000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(186, 183, 5, 1, 1, 50, 55000.00, 20.00, NULL, 55000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(187, 184, 5, 1, 1, 50, 65000.00, 20.00, NULL, 65000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(188, 185, 5, 1, 1, 30, 80000.00, 20.00, NULL, 80000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(189, 186, 5, 1, 1, 10, 35000.00, 20.00, NULL, 35000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(190, 187, 5, 1, 1, 80, 75000.00, 20.00, NULL, 75000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(191, 188, 5, 1, 1, 220, 90000.00, 20.00, NULL, 90000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(192, 189, 5, 1, 1, 20, 55000.00, 20.00, NULL, 55000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(193, 190, 5, 1, 1, 50, 75000.00, 20.00, NULL, 75000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(194, 191, 5, 1, 1, 100, 165000.00, 20.00, NULL, 165000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(195, 192, 5, 1, 1, 70, 100000.00, 20.00, NULL, 100000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(196, 193, 5, 1, 1, 130, 140000.00, 20.00, NULL, 140000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(197, 194, 5, 1, 1, 10, 120000.00, 20.00, NULL, 120000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(198, 195, 5, 1, 1, 20, 125000.00, 20.00, NULL, 125000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(199, 196, 5, 1, 1, 60, 100000.00, 20.00, NULL, 100000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(200, 197, 5, 1, 1, 40, 85000.00, 20.00, NULL, 85000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(201, 198, 5, 1, 1, 10, 95000.00, 20.00, NULL, 95000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(202, 199, 5, 1, 1, 20, 65000.00, 20.00, NULL, 65000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(203, 200, 5, 1, 1, 20, 60000.00, 20.00, NULL, 60000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(204, 201, 5, 1, 1, 30, 25000.00, 20.00, NULL, 25000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(205, 202, 5, 1, 1, 60, 275000.00, 20.00, NULL, 275000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(206, 203, 5, 1, 1, 40, 0.00, 20.00, NULL, 0.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(207, 204, 5, 1, 1, 30, 380000.00, 20.00, NULL, 380000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(208, 205, 5, 1, 1, 10, 350000.00, 20.00, NULL, 350000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(209, 206, 5, 1, 1, 10, 320000.00, 20.00, NULL, 320000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(210, 207, 5, 1, 1, 60, 410000.00, 20.00, NULL, 410000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(211, 208, 5, 1, 1, 10, 460000.00, 20.00, NULL, 460000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(212, 209, 5, 1, 1, 70, 420000.00, 20.00, NULL, 420000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(213, 210, 5, 1, 1, 20, 575000.00, 20.00, NULL, 575000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(214, 211, 5, 1, 1, 30, 530000.00, 20.00, NULL, 530000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(215, 212, 5, 1, 1, 10, 780000.00, 20.00, NULL, 780000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(216, 213, 5, 1, 1, 20, 590000.00, 20.00, NULL, 590000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(217, 214, 5, 1, 1, 20, 720000.00, 20.00, NULL, 720000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(218, 215, 5, 1, 1, 10, 1500000.00, 20.00, NULL, 1500000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(219, 216, 5, 1, 1, 20, 0.00, 20.00, NULL, 0.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(220, 217, 5, 1, 1, 40, 710000.00, 20.00, NULL, 710000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(221, 218, 5, 1, 1, 10, 430000.00, 20.00, NULL, 430000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(222, 219, 5, 1, 1, 10, 190000.00, 20.00, NULL, 190000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(223, 220, 5, 1, 1, 10, 230000.00, 20.00, NULL, 230000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(224, 221, 5, 1, 1, 60, 50000.00, 20.00, NULL, 50000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(225, 222, 5, 1, 1, 130, 155000.00, 20.00, NULL, 155000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(226, 223, 5, 1, 1, 150, 175000.00, 20.00, NULL, 175000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(227, 224, 5, 1, 1, 190, 195000.00, 20.00, NULL, 215000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(228, 225, 5, 1, 1, 10, 300000.00, 20.00, NULL, 300000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(229, 226, 5, 1, 1, 10, 250000.00, 20.00, NULL, 250000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(230, 227, 5, 1, 1, 80, 100000.00, 20.00, NULL, 100000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(231, 228, 3, 1, 1, 4, 260000.00, 20.00, NULL, 260000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(232, 229, 3, 1, 1, 55, 240000.00, 20.00, NULL, 240000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(233, 230, 5, 1, 1, 80, 300000.00, 20.00, NULL, 300000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(234, 231, 5, 1, 1, 100, 30000.00, 20.00, NULL, 30000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(235, 232, 5, 1, 1, 30, 50000.00, 20.00, NULL, 50000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(236, 233, 5, 1, 1, 20, 295000.00, 20.00, NULL, 295000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(237, 234, 5, 1, 1, 10, 16000.00, 20.00, NULL, 16000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(238, 235, 5, 1, 1, 40, 45000.00, 20.00, NULL, 30000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(239, 236, 5, 1, 1, 10, 415000.00, 20.00, NULL, 415000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(240, 237, 5, 1, 1, 10, 350000.00, 20.00, NULL, 350000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(241, 238, 5, 1, 1, 10, 350000.00, 20.00, NULL, 350000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(242, 239, 3, 1, 1, 5, 250000.00, 20.00, NULL, 250000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(243, 240, 5, 1, 1, 70, 75000.00, 20.00, NULL, 75000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(244, 241, 3, 1, 1, 5, 260000.00, 20.00, NULL, 260000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(245, 242, 3, 1, 1, 55, 26000.00, 20.00, NULL, 26000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(246, 243, 5, 1, 1, 40, 135000.00, 20.00, NULL, 135000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(247, 244, 5, 1, 1, 20, 55000.00, 20.00, NULL, 55000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(248, 245, 5, 1, 1, 30, 75000.00, 20.00, NULL, 75000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(249, 246, 5, 1, 1, 10, 250000.00, 20.00, NULL, 250000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(250, 247, 5, 1, 1, 20, 170000.00, 20.00, NULL, 170000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(251, 248, 5, 1, 1, 10, 140000.00, 20.00, NULL, 140000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(252, 249, 3, 1, 1, 570, 250000.00, 20.00, NULL, 250000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(253, 250, 5, 1, 1, 10, 60000.00, 20.00, NULL, 60000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(254, 251, 3, 1, 1, 10, 140000.00, 20.00, NULL, 140000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(255, 252, 3, 1, 1, 10, 150000.00, 20.00, NULL, 150000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(256, 253, 5, 1, 1, 40, 315000.00, 20.00, NULL, 315000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(257, 254, 5, 1, 1, 10, 250000.00, 20.00, NULL, 250000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(258, 255, 5, 1, 1, 40, 60000.00, 20.00, NULL, 70000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(259, 256, 5, 1, 1, 200, 0.00, 20.00, NULL, 0.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(260, 257, 5, 1, 1, 20, 230000.00, 20.00, NULL, 230000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(261, 258, 7, 1, 1, 20, 150000.00, 20.00, NULL, 150000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(262, 259, 5, 1, 1, 100, 0.00, 20.00, NULL, 0.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(263, 260, 5, 1, 1, 410, 0.00, 20.00, NULL, 0.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(264, 261, 5, 1, 1, 10, 240000.00, 20.00, NULL, 240000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(265, 262, 5, 1, 1, 10, 0.00, 20.00, NULL, 0.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(266, 263, 5, 1, 1, 100, 110000.00, 20.00, NULL, 110000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(267, 264, 5, 1, 1, 10, 330000.00, 20.00, NULL, 330000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(268, 265, 5, 1, 1, 150, 20000.00, 20.00, NULL, 20000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(269, 266, 5, 1, 1, 60, 20000.00, 20.00, NULL, 20000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(270, 267, 5, 1, 1, 120, 25000.00, 20.00, NULL, 25000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(271, 268, 5, 1, 1, 160, 25000.00, 20.00, NULL, 25000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(272, 269, 5, 1, 1, 10, 240000.00, 20.00, NULL, 240000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(273, 270, 5, 1, 1, 80, 25000.00, 20.00, NULL, 25000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(274, 271, 3, 1, 1, 20, 140000.00, 20.00, NULL, 140000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(275, 272, 5, 1, 1, 40, 0.00, 20.00, NULL, 0.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(276, 273, 5, 1, 1, 30, 120000.00, 20.00, NULL, 120000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(277, 274, 5, 1, 1, 20, 80000.00, 20.00, NULL, 80000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(278, 275, 5, 1, 1, 10, 270000.00, 20.00, NULL, 270000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(279, 276, 5, 1, 1, 10, 320000.00, 20.00, NULL, 320000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(280, 277, 2, 1, 1, 40, 90000.00, 20.00, NULL, 90000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(281, 278, 5, 1, 1, 40, 290000.00, 20.00, NULL, 290000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(282, 279, 5, 1, 1, 50, 35000.00, 20.00, NULL, 35000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(283, 280, 5, 1, 1, 140, 35000.00, 20.00, NULL, 35000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(284, 281, 5, 1, 1, 5, 20000.00, 20.00, NULL, 20000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(285, 4, 5, 1, 1, 60, 40000.00, 20.00, NULL, 40000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(286, 282, 5, 1, 1, 30, 65000.00, 20.00, NULL, 65000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(287, 283, 1, 1, 1, 30, 80000.00, 20.00, NULL, 80000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(288, 284, 5, 1, 1, 1000, 30000.00, 20.00, NULL, 30000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(289, 285, 5, 1, 1, 20, 350000.00, 20.00, NULL, 350000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(290, 286, 5, 1, 1, 10, 250000.00, 20.00, NULL, 250000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(291, 287, 5, 1, 1, 70, 50000.00, 20.00, NULL, 50000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(292, 288, 5, 1, 1, 20, 90000.00, 20.00, NULL, 90000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(293, 289, 5, 1, 1, 30, 70000.00, 20.00, NULL, 70000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(294, 290, 5, 1, 1, 20, 80000.00, 20.00, NULL, 80000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(295, 3, 5, 1, 1, 10, 60000.00, 20.00, NULL, 60000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(296, 291, 5, 1, 1, 10, 110000.00, 20.00, NULL, 110000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(297, 292, 5, 1, 1, 160, 60000.00, 20.00, NULL, 60000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(298, 293, 5, 1, 1, 20, 0.00, 20.00, NULL, 0.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(299, 294, 5, 1, 1, 20, 0.00, 20.00, NULL, 0.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(300, 295, 5, 1, 1, 40, 50000.00, 20.00, NULL, 50000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(301, 296, 5, 1, 1, 10, 0.00, 20.00, NULL, 0.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(302, 297, 5, 1, 1, 40, 110000.00, 20.00, NULL, 110000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(303, 298, 5, 1, 1, 10, 180000.00, 20.00, NULL, 180000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(304, 299, 5, 1, 1, 200, 0.00, 20.00, NULL, 0.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(305, 300, 5, 1, 1, 100, 0.00, 20.00, NULL, 0.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(306, 301, 5, 1, 1, 40, 350000.00, 20.00, NULL, 350000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(307, 302, 5, 1, 1, 70, 45000.00, 20.00, NULL, 45000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(308, 303, 5, 1, 1, 20, 20000.00, 20.00, NULL, 20000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(309, 304, 5, 1, 1, 10, 0.00, 20.00, NULL, 0.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(310, 305, 5, 1, 1, 40, 140000.00, 20.00, NULL, 140000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(311, 306, 5, 1, 1, 20, 140000.00, 20.00, NULL, 140000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(312, 307, 5, 1, 1, 40, 150000.00, 20.00, NULL, 150000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(313, 308, 5, 1, 1, 30, 100000.00, 20.00, NULL, 100000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(314, 309, 5, 1, 1, 20, 275000.00, 20.00, NULL, 275000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(315, 310, 5, 1, 1, 20, 100000.00, 20.00, NULL, 100000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(316, 311, 5, 1, 1, 10, 310000.00, 20.00, NULL, 310000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(317, 312, 5, 1, 1, 30, 210000.00, 20.00, NULL, 210000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(318, 313, 5, 1, 1, 10, 225000.00, 20.00, NULL, 225000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(319, 314, 5, 1, 1, 10, 285000.00, 20.00, NULL, 285000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(320, 315, 5, 1, 1, 20, 210000.00, 20.00, NULL, 210000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(321, 316, 5, 1, 1, 210, 15000.00, 20.00, NULL, 15000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(322, 317, 5, 1, 1, 50, 20000.00, 20.00, NULL, 20000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(323, 318, 5, 1, 1, 30, 50000.00, 20.00, NULL, 50000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(324, 319, 3, 1, 1, 20, 140000.00, 20.00, NULL, 140000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(325, 320, 5, 1, 1, 20, 165000.00, 20.00, NULL, 165000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(326, 321, 5, 1, 1, 10, 170000.00, 20.00, NULL, 170000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(327, 322, 5, 1, 1, 30, 200000.00, 20.00, NULL, 200000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(328, 323, 2, 1, 1, 30, 220000.00, 20.00, NULL, 220000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(329, 324, 2, 1, 1, 10, 55000.00, 20.00, NULL, 55000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(330, 325, 5, 1, 1, 10, 230000.00, 20.00, NULL, 230000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(331, 326, 5, 1, 1, 20, 210000.00, 20.00, NULL, 210000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(332, 327, 2, 1, 1, 60, 150000.00, 20.00, NULL, 150000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(333, 328, 2, 1, 1, 10, 170000.00, 20.00, NULL, 170000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(334, 329, 5, 1, 1, 100, 200000.00, 20.00, NULL, 200000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(335, 330, 5, 1, 1, 30, 750000.00, 20.00, NULL, 750000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(336, 331, 5, 1, 1, 20, 30000.00, 20.00, NULL, 30000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(337, 332, 5, 1, 1, 10, 150000.00, 20.00, NULL, 150000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(338, 333, 5, 1, 1, 50, 100000.00, 20.00, NULL, 100000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(339, 334, 5, 1, 1, 40, 180000.00, 20.00, NULL, 180000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(340, 335, 5, 1, 1, 20, 150000.00, 20.00, NULL, 150000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(341, 336, 5, 1, 1, 30, 130000.00, 20.00, NULL, 130000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(342, 337, 5, 1, 1, 20, 1350000.00, 20.00, NULL, 1350000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(343, 338, 5, 1, 1, 30, 60000.00, 20.00, NULL, 60000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(344, 339, 5, 1, 1, 10, 70000.00, 20.00, NULL, 70000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(345, 340, 5, 1, 1, 20, 1250000.00, 20.00, NULL, 1250000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(346, 341, 5, 1, 1, 30, 110000.00, 20.00, NULL, 110000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(347, 342, 5, 1, 1, 80, 30000.00, 20.00, NULL, 30000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(348, 343, 5, 1, 1, 10, 25000.00, 20.00, NULL, 25000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(349, 344, 5, 1, 1, 20, 160000.00, 20.00, NULL, 160000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(350, 345, 5, 1, 1, 200, 5000.00, 20.00, NULL, 10000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(351, 346, 5, 1, 1, 200, 5000.00, 20.00, NULL, 15000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(352, 347, 5, 1, 1, 740, 7000.00, 20.00, NULL, 15000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(353, 348, 5, 1, 1, 30, 135000.00, 20.00, NULL, 160000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(354, 349, 5, 1, 1, 30, 150000.00, 20.00, NULL, 180000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(355, 350, 5, 1, 1, 50, 64000.00, 20.00, NULL, 110000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(356, 351, 1, 1, 1, 20, 175000.00, 20.00, NULL, 180000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(357, 352, 1, 1, 1, 20, 157500.00, 20.00, NULL, 220000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(358, 353, 1, 1, 1, 20, 197500.00, 20.00, NULL, 260000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(359, 354, 1, 1, 1, 50, 410000.00, 20.00, NULL, 420000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(360, 355, 1, 1, 1, 50, 430000.00, 20.00, NULL, 440000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(361, 356, 5, 1, 1, 50, 47000.00, 20.00, NULL, 70000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(362, 357, 5, 1, 1, 50, 90000.00, 20.00, NULL, 120000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(363, 358, 5, 1, 1, 120, 40000.00, 20.00, NULL, 75000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(364, 359, 5, 1, 1, 30, 75000.00, 20.00, NULL, 120000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(365, 360, 5, 1, 1, 200, 12000.00, 20.00, NULL, 25000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(366, 361, 5, 1, 1, 100, 50000.00, 20.00, NULL, 80000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(367, 362, 5, 1, 1, 150, 14000.00, 20.00, NULL, 35000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(368, 363, 5, 1, 1, 100, 45000.00, 20.00, NULL, 70000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(369, 364, 5, 1, 1, 100, 45000.00, 20.00, NULL, 70000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(370, 365, 5, 1, 1, 100, 45000.00, 20.00, NULL, 70000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(371, 366, 5, 1, 1, 50, 60000.00, 20.00, NULL, 80000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(372, 367, 3, 1, 1, 50, 190000.00, 20.00, NULL, 250000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00'),
(373, 368, 5, 1, 1, 50, 415000.00, 20.00, NULL, 43000.00, 0.00, '2025-12-31 17:00:00', '2025-12-31 17:00:00');

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
('7j66nDriXe4Fk8PUDf5shBtVjoszLR2sEW4Z30Be', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibUVFSEtDR0VObzU4ckk1YmtuNjdkWWViVm56RmVWeXhiMFFrTUJYUyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sYXBvcmFuIjtzOjU6InJvdXRlIjtzOjEyOiJyZXBvcnQuaW5kZXgiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1769594248),
('hOwGopvmrXcZpKFbhIEf4kkc1NksR32H1V1WRbPW', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoieUJjT05RdUZCbVY4TXRvRmYxRTB5a3B5ZjFBTFR3YUlabVRzMGcyQiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9jYXNoLWZsb3ciO3M6NToicm91dGUiO3M6MTQ6ImNhc2hmbG93LmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1769765635),
('JjqrI9PCZbaIToR8ksNlNIxvVwVNknkUY6bn7bJS', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTlNXaThWSUo2SnJvRjBLY1YydDJQSHl0V2pmM3o1UFNNd0hMMTJ4TiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9leHBlbnNlcyI7czo1OiJyb3V0ZSI7czoxNDoiZXhwZW5zZXMuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1770088641),
('UayUvUXbxFR60wB2PEle8oMBMYgyJmfW3xLzMTQQ', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZzE0QkdsdU4yREpDandOU0VJNkpSeFFISk53OWU4Q2VZRWNGaUl3WCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9jYXNoLWZsb3c/cT0iO3M6NToicm91dGUiO3M6MTQ6ImNhc2hmbG93LmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1769659991);

-- --------------------------------------------------------

--
-- Struktur dari tabel `stock_items`
--

CREATE TABLE `stock_items` (
  `id` bigint UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `nomor_resi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `master_product_id` bigint UNSIGNED NOT NULL,
  `qty` int NOT NULL,
  `qty_kulak` int NOT NULL,
  `stok_awal` int NOT NULL,
  `harga_beli` decimal(15,2) NOT NULL,
  `nominal` decimal(15,2) NOT NULL,
  `margin` int NOT NULL DEFAULT '0',
  `harga_jual` decimal(15,2) NOT NULL,
  `harga_atas` decimal(15,2) DEFAULT NULL,
  `supplier_id` bigint UNSIGNED NOT NULL,
  `status_pembayaran` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Lunas',
  `status_barang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Diterima',
  `jatuh_tempo` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, 'Toko A8 (SHOPEE)', '-', '-', NULL, NULL),
(2, 'ksam_uuwyn (SHOPEE)', '-', '-', NULL, NULL),
(3, 'Arvella (SHOPEE)', '-', '-', NULL, NULL),
(4, 'Cakra Tools (TOKOPEDIA)', '-', '-', NULL, NULL),
(5, 'PionTools Sby (TOKOPEDIA)', '-', '-', NULL, NULL),
(6, 'Msizg shop (TOKOPEDIA)', '-', '-', NULL, NULL),
(7, 'TripleWayElektrik (TOKOPEDIA)', '-', '-', NULL, NULL),
(8, 'manse.strore (TOKOPEDIA)', '-', '-', NULL, NULL),
(9, 'GLOBAL LED MOTORINDO (TOKOPEDIA)', '-', '-', NULL, NULL),
(10, 'Bintang Terang Listrik (TOKOPEDIA)', '-', '-', NULL, NULL),
(11, 'Artha Tirta Bangunan (SHOPEE)', '-', '-', NULL, NULL),
(12, 'LARIS.CO*', '-', '-', NULL, NULL),
(13, 'GLOBAL PERKASA INDAH (TOKOPEDIA)', '-', '-', NULL, NULL),
(14, 'Sie Ibin Store (TOKOPEDIA)', '-', '-', NULL, NULL),
(15, 'BocahDH (TOKOPEDIA)', '-', '-', NULL, NULL),
(16, 'S-Logam Teknik (TOKOPEDIA)', '-', '-', NULL, NULL),
(17, 'Nika Tools (TOKOPEDIA)', '-', '-', NULL, NULL),
(18, 'Verona Tools (TOKOPEDIA)', '-', '-', NULL, NULL),
(19, 'Twins88listrik (TOKOPEDIA)', '-', '-', NULL, NULL),
(20, 'GOnBAY Store (TOKOPEDIA)', '-', '-', NULL, NULL),
(21, 'Sahabat DMP_NEW (TOKOPEDIA)', '-', '-', NULL, NULL),
(22, 'CV ANUGRAH ABADI NUSANTARA (TOKOPEDIA)', '-', '-', NULL, NULL),
(23, 'DIY', '-', '-', NULL, NULL),
(24, 'Hanzcell (TOKOPEDIA)', '-', '-', NULL, NULL),
(25, 'SafetyAbadiStore (TOKOPEDIA)', '-', '-', NULL, NULL),
(26, 'Zidan Electric (TOKOPEDIA)', '-', '-', NULL, NULL),
(27, 'Emperor Raja Biled (TOKOPEDIA)', '-', '-', NULL, NULL),
(28, 'SNW JAYA (TOKOPEDIA)', '-', '-', NULL, NULL),
(29, 'Leony Indonesia (TOKOPEDIA)', '-', '-', NULL, NULL),
(30, 'HEMAT PEKING_NEW (TOKOPEDIA)', '-', '-', NULL, NULL),
(31, 'Yuanapurnomo (SHOPEE)', '-', '-', NULL, NULL),
(32, 'Yani_Store123 (SHOPEE)', '-', '-', NULL, NULL),
(33, 'Sumber Abadi (Graha SA)', '-', '-', NULL, NULL),
(34, 'Gofarm Store31', '-', '-', NULL, NULL),
(35, 'Mas Oke21', '-', '-', NULL, NULL),
(36, 'Maxima Jaya', '-', '-', NULL, NULL),
(37, 'Rejeki Triplek', '-', '-', NULL, NULL),
(38, 'TOKO LANCAR PANDAN', '-', '-', NULL, NULL),
(39, 'Awali Store', '-', '-', NULL, NULL),
(40, 'SA', '-', '-', NULL, NULL),
(41, 'SURYA JAYA ABADIE', '-', '-', NULL, NULL),
(42, 'MENARA BANGUNAN SENTOSA', '-', '-', NULL, NULL),
(43, 'MORODADI', '-', '-', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaction_codes`
--

CREATE TABLE `transaction_codes` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'primary',
  `kategori` enum('pemasukan','pengeluaran') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pemasukan',
  `insidentil` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `transaction_codes`
--

INSERT INTO `transaction_codes` (`id`, `code`, `label`, `color`, `kategori`, `insidentil`, `created_at`, `updated_at`) VALUES
(1, 'IN-SALES', 'Pemasukan Penjualan', 'success', 'pemasukan', 0, '2026-01-25 20:42:19', '2026-01-25 20:42:19'),
(2, 'OUT-PURCHASE', 'Pengeluaran Kulakan', 'danger', 'pengeluaran', 0, '2026-01-25 20:42:19', '2026-01-25 20:42:19'),
(3, 'OUT-OPR', 'Biaya Operasional', 'warning', 'pengeluaran', 0, '2026-01-25 20:42:19', '2026-01-25 20:42:19'),
(4, 'IN-MODAL', 'Modal Awal', 'primary', 'pemasukan', 0, '2026-01-26 20:42:35', '2026-01-26 20:42:35'),
(5, 'OUT-LAINYA', 'Pengeluaran Lainya', 'danger', 'pengeluaran', 1, '2026-01-26 20:42:35', '2026-01-26 20:42:35'),
(6, 'OUT-HUMANITY', 'SUMBANGAN KEMANUSIAAN', 'success', 'pengeluaran', 1, '2026-01-30 02:28:18', '2026-01-30 02:28:18');

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
-- Indeks untuk tabel `stock_items`
--
ALTER TABLE `stock_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_items_master_product_id_foreign` (`master_product_id`),
  ADD KEY `stock_items_supplier_id_foreign` (`supplier_id`);

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=392;

--
-- AUTO_INCREMENT untuk tabel `master_units`
--
ALTER TABLE `master_units`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `pos_transactions`
--
ALTER TABLE `pos_transactions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT untuk tabel `pos_transaction_items`
--
ALTER TABLE `pos_transaction_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1021;

--
-- AUTO_INCREMENT untuk tabel `product_units`
--
ALTER TABLE `product_units`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=400;

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
-- AUTO_INCREMENT untuk tabel `stock_items`
--
ALTER TABLE `stock_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT untuk tabel `transaction_codes`
--
ALTER TABLE `transaction_codes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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

--
-- Ketidakleluasaan untuk tabel `stock_items`
--
ALTER TABLE `stock_items`
  ADD CONSTRAINT `stock_items_master_product_id_foreign` FOREIGN KEY (`master_product_id`) REFERENCES `master_products` (`id`),
  ADD CONSTRAINT `stock_items_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
