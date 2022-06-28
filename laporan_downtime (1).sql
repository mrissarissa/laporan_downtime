-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 27 Jun 2022 pada 15.41
-- Versi server: 5.7.33
-- Versi PHP: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laporan_downtime`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `downtime_kategori`
--

CREATE TABLE `downtime_kategori` (
  `id` int(100) NOT NULL,
  `downtime_kategori` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `downtime_kategori`
--

INSERT INTO `downtime_kategori` (`id`, `downtime_kategori`, `created_at`, `deleted_at`) VALUES
(1, 'Others', '2022-06-27 14:29:15', NULL),
(2, 'kategori 1', '2022-06-27 02:34:36', '2022-06-27 02:44:04'),
(3, 'No Supply (Material, Trims, Work In Progress)', '2022-06-27 02:44:02', NULL),
(4, 'Machine Breakdown', '2022-06-27 02:44:11', NULL),
(5, 'Style Changeover', '2022-06-27 02:44:17', NULL),
(6, 'Sampling (SMS/Presell sample creation)', '2022-06-27 02:44:24', NULL),
(7, 'Quality problems', '2022-06-27 02:44:29', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan`
--

CREATE TABLE `laporan` (
  `id` int(100) DEFAULT NULL,
  `nik_gl` varchar(50) DEFAULT NULL,
  `line` varchar(50) DEFAULT NULL,
  `nik_spv` varchar(50) DEFAULT NULL,
  `tgl_laporan` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `style` varchar(255) NOT NULL,
  `id_barang` int(100) NOT NULL,
  `problem` text NOT NULL,
  `lossting` double NOT NULL,
  `problem_deskripsi` text NOT NULL,
  `problem_kategori` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `laporan`
--

INSERT INTO `laporan` (`id`, `nik_gl`, `line`, `nik_spv`, `tgl_laporan`, `created_at`, `updated_at`, `deleted_at`, `status`, `style`, `id_barang`, `problem`, `lossting`, `problem_deskripsi`, `problem_kategori`) VALUES
(1, '201200118', '1', '201200116', '2022-06-25', '2022-06-24 14:53:20', '2022-06-24 19:10:29', NULL, '1', 'ABC', 3, 'Problem', 2, 'Problem deskripsi', 'Prpblem Catgepru'),
(1, '201200118', '1', '201200116', '2022-06-27', '2022-06-27 03:38:14', '2022-06-27 03:38:14', NULL, '0', 'ABC', 3, 'problem ', 19, '2', 'Others');

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_barang`
--

CREATE TABLE `master_barang` (
  `id` int(30) NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `create_by` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `master_barang`
--

INSERT INTO `master_barang` (`id`, `nama_barang`, `created_at`, `deleted_at`, `create_by`) VALUES
(1, 'Benang', '2022-06-23 01:08:17', '2022-06-23 01:08:52', '201200117'),
(2, 'Jarumm', '2022-06-23 01:13:22', NULL, '201200117'),
(3, 'Benang', '2022-06-23 16:26:27', NULL, '201200117');

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_downtime_deskripsi`
--

CREATE TABLE `master_downtime_deskripsi` (
  `id` int(100) NOT NULL,
  `downtime_deskripsi` varchar(255) NOT NULL,
  `downtime_kategori_id` int(100) NOT NULL,
  `created_at` timestamp NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `master_downtime_deskripsi`
--

INSERT INTO `master_downtime_deskripsi` (`id`, `downtime_deskripsi`, `downtime_kategori_id`, `created_at`, `deleted_at`) VALUES
(1, 'Material Supply - Accessories', 3, '2022-06-27 02:59:25', NULL),
(2, 'Missing planning production', 1, '2022-06-27 02:59:37', NULL),
(3, 'Change over categories B - Benang (Y),Style (Y), Product (Y), Fabric (N)', 5, '2022-06-27 02:59:44', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_jenis_barang`
--

CREATE TABLE `master_jenis_barang` (
  `id` int(100) NOT NULL,
  `jenis_barang` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL,
  `create_by` varchar(100) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `master_jenis_barang`
--

INSERT INTO `master_jenis_barang` (`id`, `jenis_barang`, `created_at`, `create_by`, `deleted_at`) VALUES
(1, 'jenis masker', '2022-06-23 16:27:50', '201200117', NULL),
(2, 'kelompok benang', '2022-06-23 16:29:07', '201200117', '2022-06-23 16:29:10'),
(3, 'kelompok benang 2', '2022-06-23 16:29:18', '201200117', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` text NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2022-01-26-071952', 'App\\Database\\Migrations\\Users', 'default', 'APP_NAMESPACE', 1643182145, 1),
(2, '2022-01-26-073122', 'App\\Database\\Migrations\\CreateEntrustSetup', 'default', 'APP_NAMESPACE', 1643182396, 2),
(3, '2022-01-26-074015', 'App\\Database\\Migrations\\CreateRole', 'default', 'APP_NAMESPACE', 1643182975, 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengembalian_barang`
--

CREATE TABLE `pengembalian_barang` (
  `id` varchar(100) NOT NULL,
  `nik_gl` int(100) NOT NULL,
  `line` int(100) NOT NULL,
  `nik_spv` int(100) NOT NULL,
  `tgl_pengembalian` date NOT NULL,
  `id_stock` int(100) NOT NULL,
  `qty` int(100) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  `status` int(2) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `kondisi_barang` varchar(100) NOT NULL,
  `keterangan_kondisi` text NOT NULL,
  `status_app_admin` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pengembalian_barang`
--

INSERT INTO `pengembalian_barang` (`id`, `nik_gl`, `line`, `nik_spv`, `tgl_pengembalian`, `id_stock`, `qty`, `created_at`, `updated_at`, `status`, `deleted_at`, `kondisi_barang`, `keterangan_kondisi`, `status_app_admin`) VALUES
('KB-1', 201200118, 1, 201200116, '2022-06-26', 3, 5, '2022-06-24 16:27:09', '0000-00-00 00:00:00', 1, NULL, 'bagus', 'tidak ada kerusakan', 1),
('KB201200118-1', 201200118, 1, 201200116, '2022-06-25', 3, 1, '2022-06-24 16:34:42', '0000-00-00 00:00:00', 2, NULL, 'bagus', '', 0),
('KB201200118-2', 201200118, 1, 201200116, '2022-06-26', 3, 10, '2022-06-24 16:33:26', '0000-00-00 00:00:00', 1, NULL, 'bagus', 'kosong', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `permintaan_barang`
--

CREATE TABLE `permintaan_barang` (
  `id` varchar(100) NOT NULL,
  `nik_gl` varchar(255) NOT NULL,
  `line` int(100) NOT NULL,
  `nik_spv` varchar(255) NOT NULL,
  `tgl_permintaan` date NOT NULL,
  `id_stock` int(100) NOT NULL,
  `qty` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` int(2) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `tgl_pengeluaran_barang` timestamp NULL DEFAULT NULL,
  `user_keluar_barang` int(100) DEFAULT NULL,
  `qty_keluar_barang` int(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `permintaan_barang`
--

INSERT INTO `permintaan_barang` (`id`, `nik_gl`, `line`, `nik_spv`, `tgl_permintaan`, `id_stock`, `qty`, `created_at`, `updated_at`, `status`, `deleted_at`, `tgl_pengeluaran_barang`, `user_keluar_barang`, `qty_keluar_barang`) VALUES
('PB201200111-1', '201200111', 2, '201200116', '2022-06-25', 3, 2, '2022-06-24 16:48:32', NULL, 1, NULL, '2022-06-24 22:22:29', 201200117, 2),
('PB201200118-1', '201200118', 1, '201200116', '2022-06-25', 3, 1, '2022-06-24 16:47:41', NULL, 2, NULL, NULL, NULL, NULL),
('PB201200118-2', '201200118', 1, '201200116', '2022-06-25', 3, 2, '2022-06-24 16:48:10', NULL, 0, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `roles`
--

CREATE TABLE `roles` (
  `id` int(100) NOT NULL,
  `nama_role` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `roles`
--

INSERT INTO `roles` (`id`, `nama_role`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'GL', '2022-01-26 14:44:12', '2022-01-26 14:44:12', NULL),
(2, 'Staff Admin', '2022-01-26 16:46:20', '2022-01-26 16:46:20', NULL),
(3, 'SPV', '2022-01-26 16:46:38', '2022-01-26 16:46:38', NULL),
(4, 'AdminICT', '2022-01-28 21:37:04', '2022-01-28 21:37:04', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `spv`
--

CREATE TABLE `spv` (
  `nik` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data untuk tabel `spv`
--

INSERT INTO `spv` (`nik`, `password`, `name`, `role`, `created_at`, `updated_at`, `deleted_at`) VALUES
('201200116', '$2y$10$8JfM84FBzF.bN5dgFZxgiO6EB2mOOLAg7KkKWNBx4zLgOwh4HYx4a', 'Admin SPV 1', '3', '2022-01-26 09:46:03', NULL, NULL),
('201200111', '$2y$10$8JfM84FBzF.bN5dgFZxgiO6EB2mOOLAg7KkKWNBx4zLgOwh4HYx4a', 'Admin SPV 2', '3', '2022-01-30 05:50:09', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `staff_admin`
--

CREATE TABLE `staff_admin` (
  `nik` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data untuk tabel `staff_admin`
--

INSERT INTO `staff_admin` (`nik`, `password`, `name`, `role`, `created_at`, `updated_at`, `deleted_at`) VALUES
('201200117', '$2y$10$8JfM84FBzF.bN5dgFZxgiO6EB2mOOLAg7KkKWNBx4zLgOwh4HYx4a', 'Staff', '2', '2022-01-26 09:45:10', '2022-01-26 09:45:10', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `stock_barang`
--

CREATE TABLE `stock_barang` (
  `id` int(100) NOT NULL,
  `id_barang` int(100) NOT NULL,
  `id_jenis_barang` int(100) NOT NULL,
  `qty` int(100) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `stock_barang`
--

INSERT INTO `stock_barang` (`id`, `id_barang`, `id_jenis_barang`, `qty`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 3, 3, 10, '2022-06-23 17:34:04', '0000-00-00 00:00:00', '2022-06-27 03:06:11'),
(2, 2, 1, 5, '2022-06-23 18:54:42', '0000-00-00 00:00:00', '2022-06-23 18:55:13'),
(3, 2, 3, 10, '2022-06-25 09:37:45', '2022-06-25 09:37:45', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `nik` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL,
  `line` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`nik`, `password`, `name`, `role`, `line`, `created_at`, `updated_at`) VALUES
('201200118', '$2y$10$C05AcxdN1./f752WSoEF..KnRvh/0pHgwpU6f28Wy24j55K9TpM.S', 'Marissa Nur Aini', '1', '1', '2022-01-26 02:52:09', '2022-01-26 02:52:09'),
('201200111', '$2y$10$8JfM84FBzF.bN5dgFZxgiO6EB2mOOLAg7KkKWNBx4zLgOwh4HYx4a', 'Ardani Yanuar', '1', '2', '2022-01-26 03:51:54', '2022-01-26 03:51:54'),
('admin', '$2y$10$8JfM84FBzF.bN5dgFZxgiO6EB2mOOLAg7KkKWNBx4zLgOwh4HYx4a', 'Admin ICT', '4', '0', '2022-01-30 12:07:01', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `downtime_kategori`
--
ALTER TABLE `downtime_kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `master_barang`
--
ALTER TABLE `master_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `master_downtime_deskripsi`
--
ALTER TABLE `master_downtime_deskripsi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `master_jenis_barang`
--
ALTER TABLE `master_jenis_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pengembalian_barang`
--
ALTER TABLE `pengembalian_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `permintaan_barang`
--
ALTER TABLE `permintaan_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `stock_barang`
--
ALTER TABLE `stock_barang`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
