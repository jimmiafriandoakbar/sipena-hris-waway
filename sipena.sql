-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 13 Bulan Mei 2026 pada 03.12
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sipena`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `bagian`
--

CREATE TABLE `bagian` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_bagian` varchar(255) NOT NULL,
  `nama_bagian` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `bagian`
--

INSERT INTO `bagian` (`id`, `kode_bagian`, `nama_bagian`, `created_at`, `updated_at`) VALUES
(1, 'IT', 'Information Technology (IT)', '2026-05-07 00:11:53', '2026-05-07 00:11:53'),
(2, 'OPS', 'Operasional (OPS)', '2026-05-07 00:11:53', '2026-05-07 00:11:53'),
(3, 'MRK', 'Marketing (MRK)', '2026-05-07 00:11:53', '2026-05-07 00:11:53'),
(4, 'USDM', 'Umum dan SDM (USDM)', '2026-05-07 00:11:53', '2026-05-07 00:11:53'),
(5, 'ACRE', 'Accounting dan Renbang (ACRE)', '2026-05-07 00:11:53', '2026-05-07 00:11:53'),
(6, 'SKAI', 'Satuan Kerja Audit Internal (SKAI)', '2026-05-07 00:11:53', '2026-05-07 00:11:53'),
(7, 'SKPMR', 'Satuan Kerja Pemantau Manajemen Risiko (SKPMR)', '2026-05-07 00:11:53', '2026-05-07 00:11:53'),
(8, 'PMB', 'Pembinaan (PMB)', '2026-05-07 00:11:53', '2026-05-07 00:11:53'),
(9, 'DIROP', 'Direktur Operasional (DIROP)', '2026-05-07 00:11:53', '2026-05-07 00:11:53'),
(10, 'DIRUT', 'Direktur Utama (DIRUT)', '2026-05-07 00:11:53', '2026-05-07 00:11:53');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jabatan`
--

CREATE TABLE `jabatan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_jabatan` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `jabatan`
--

INSERT INTO `jabatan` (`id`, `nama_jabatan`, `created_at`, `updated_at`) VALUES
(1, 'Direktur Operasional', '2026-05-07 19:50:16', '2026-05-07 19:50:16'),
(2, 'Direktur Utama', '2026-05-07 19:50:16', '2026-05-07 19:50:16'),
(3, 'Kepala Bagian', '2026-05-07 19:50:16', '2026-05-07 19:50:16'),
(4, 'Supervisor', '2026-05-07 19:50:16', '2026-05-07 19:50:16'),
(5, 'Staff', '2026-05-07 19:50:16', '2026-05-07 23:46:58'),
(6, 'Kontrak', '2026-05-07 19:50:16', '2026-05-07 19:50:16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_04_22_171322_create_sessions_table', 1),
(5, '2026_05_06_085241_add_detail_columns_to_pegawai_table', 2),
(6, '2026_05_07_070453_create_jabatans_table', 3),
(7, '2026_05_08_024125_create_jabatans_table', 4),
(8, '2026_05_10_140350_create_surat_table', 5),
(9, '2026_05_10_140937_create_surat_tujuans_table', 6),
(10, '2026_05_10_141443_create_surat_ttds_table', 7),
(11, '2026_05_10_141640_create_surat_masuks_table', 8),
(12, '2026_05_10_144255_add_relation_to_pegawai_table', 9);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pegawai`
--

CREATE TABLE `pegawai` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nip` varchar(255) NOT NULL,
  `bagian_id` bigint(20) UNSIGNED DEFAULT NULL,
  `jabatan_id` bigint(20) UNSIGNED DEFAULT NULL,
  `no_hp` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `gaji_pokok` int(11) NOT NULL DEFAULT 0,
  `tunjangan` int(11) NOT NULL DEFAULT 0,
  `bonus` int(11) NOT NULL DEFAULT 0,
  `potongan` int(11) NOT NULL DEFAULT 0,
  `ttd` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `pendidikan` varchar(255) DEFAULT NULL,
  `jurusan` varchar(255) DEFAULT NULL,
  `mulai_bekerja` date DEFAULT NULL,
  `nomor_rekening` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pegawai`
--

INSERT INTO `pegawai` (`id`, `user_id`, `nama`, `nip`, `bagian_id`, `jabatan_id`, `no_hp`, `email`, `gaji_pokok`, `tunjangan`, `bonus`, `potongan`, `ttd`, `created_at`, `updated_at`, `pendidikan`, `jurusan`, `mulai_bekerja`, `nomor_rekening`) VALUES
(1, 2, 'Jimmi Afriando Akbar', '12345678', 1, 5, '085156437551', 'Jimmi@gmail.com', 5000000, 1000000, 200000, 300000, 'ttd/OV8mFc4TgpQUXM3Vw54ilRIopRrjuVgWzMv4RSvi.png', '2026-05-06 01:39:50', '2026-05-11 10:32:18', 'S1', 'Ilmu Komputer', '2022-04-05', '0011025277'),
(8, 9, 'Angga Rendy Septian', '1234567', 4, 5, '0852575331', 'anggarendy@gmail.com', 5000000, 2000000, 100000, 2500000, 'ttd/hlWDzmjiIsj9yFCbsyCQb1GcT8MCuRnp8ya96ceL.png', '2026-05-06 03:03:14', '2026-05-10 08:36:32', 'S1', 'Teknik Informatika', '2016-12-12', NULL),
(9, 10, 'Bagus Bramansyah', '12341234', 7, 5, '08525753312', 'Bagus@gmail.com', 5000000, 1000000, 100000, 1000000, 'ttd/rNB6AdU9ncfCZ9YbiTBtS2wNdfmMGJbngNrHc0zb.png', '2026-05-06 03:18:20', '2026-05-10 11:21:13', 'S1', 'Perbankan', '2022-12-12', '0011039997'),
(11, 12, 'Agus Prinanto', '010200', 5, 3, '085434546651', 'agus@gmail.com', 10000000, 5000000, 2000000, 2500000, 'ttd/hkkjpjotSoXf3eZIbE6aY27xdinFLHJKtGON6JRi.png', '2026-05-10 10:51:35', '2026-05-10 11:20:12', 'S1', 'Akutansi', '2008-12-12', '00110252288'),
(13, 14, 'Dwi Yuli', '909090', 5, 4, '085151557', 'Dwiyuli@gmail.com', 8000000, 2000000, 1000000, 1000000, NULL, '2026-05-11 10:44:46', '2026-05-11 10:44:46', 'S1', 'Akutansi', '2015-12-12', '089941412'),
(14, 15, 'Wahyu Nugraha', '010202', 1, 6, '08313232', 'wahyu@gmail.com', 1500000, 100000, 100000, 300000, NULL, '2026-05-11 10:50:49', '2026-05-11 10:50:49', 'S1', 'Teknik Informatika', '2026-12-12', '0011039999'),
(15, 16, 'Arif Ab', '808080', 3, 4, '010102020', 'Arif@gmail.com', 8000000, 2000000, 1000000, 1000000, NULL, '2026-05-11 10:56:47', '2026-05-11 10:56:47', 'S1', 'Hukum', '2022-12-12', '001101242');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('JGXVPzH9CmTan7Z8jJzK3rLbjlLaIEGZrSAyZZkE', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/118.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWHM5RTVkQ3ExWDFITnZjVTJmeTQyelJEclRpWmkzeU1JelFqV0JmSSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fX0=', 1778553805),
('NWOHPan20EhW7Yhn8ag7rsyIB1v64qv8Rx4XA6sq', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/118.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVUJVY3l5Z3FhN0NPWTNrOTJNemJNbkVPbzhwR25taWpkcTBNY1A5VSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1778634683),
('QXhjdb2tLJe6t3fTDFvqiYPis3v8g96qIPAGRL0v', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.119.0 Chrome/142.0.7444.265 Electron/39.8.8 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoia0NKSjBNVVFJOEVWYkd3aUFpZkJ5R3NZNWF2cGwzWlFuMkt4TGRjViI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1778634679);

-- --------------------------------------------------------

--
-- Struktur dari tabel `surat`
--

CREATE TABLE `surat` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `jenis_surat` varchar(255) NOT NULL,
  `nomor_surat` varchar(255) DEFAULT NULL,
  `tanggal_surat` date DEFAULT NULL,
  `perihal` varchar(255) NOT NULL,
  `isi_surat` longtext DEFAULT NULL,
  `file_pdf` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `surat`
--

INSERT INTO `surat` (`id`, `user_id`, `jenis_surat`, `nomor_surat`, `tanggal_surat`, `perihal`, `isi_surat`, `file_pdf`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 'nota_dinas', '001/IT/V/2026', '2026-05-10', 'Tindak Lanjut Unggah Laporan Transparansi Tata Kelola', 'Dengan hormat,\r\nMenindaklanjuti Nota Dinas Nomor 070/SKP/IV /2A26 perihal permohonan bantuan unggah\r\nLaporan Transparansi Tata Kelola Periode Tahun 2A25 ke website BPR Waway, dengan ini kami\r\nsampaikan bahwa:\r\nLaporan Transparansi Tata Kelola [GCG) Tahun 2025 dimaksud telah berhasil diunggah dan\r\ndiperbarui pada website resmi pT BPR Waway Lampung (PerserodaJ, dan dapat diakses melalui\r\ntautan berikut:\r\n. https:ilbankwawaylampung.comfiaporan-gcg\r\nDengan demikian, permohonan unggah laporan telah kami tindaklanjuti sesuai dengan permintaan.\r\nDemikian karni sampaikan. Atas perhatian dan kerja samanya kami ucapkan terima kasih.', 'surat/kn68F0NtWOEjOFzKyEYMakG3gY2bfACPH3mU2yj2.pdf', 'pending', '2026-05-10 07:55:19', '2026-05-10 07:55:19'),
(2, 2, 'nota_dinas', '001/IT/V/2026', '2026-05-10', 'Tindak Lanjut Unggah Laporan Transparansi Tata Kelola', 'Dengan hormat,\r\nMenindaklanjuti Nota Dinas Nomor 070/SKP/IV /2A26 perihal permohonan bantuan unggah\r\nLaporan Transparansi Tata Kelola Periode Tahun 2A25 ke website BPR Waway, dengan ini kami\r\nsampaikan bahwa:\r\nLaporan Transparansi Tata Kelola [GCG) Tahun 2025 dimaksud telah berhasil diunggah dan\r\ndiperbarui pada website resmi pT BPR Waway Lampung (PerserodaJ, dan dapat diakses melalui\r\ntautan berikut:\r\n. https:ilbankwawaylampung.comfiaporan-gcg\r\nDengan demikian, permohonan unggah laporan telah kami tindaklanjuti sesuai dengan permintaan.\r\nDemikian karni sampaikan. Atas perhatian dan kerja samanya kami ucapkan terima kasih.', 'surat/c1ohUlF0jqhCJuDb9b0NwL7C7bPtV8kH8l5xmJLx.pdf', 'ditolak', '2026-05-10 07:56:59', '2026-05-10 08:21:11'),
(3, 2, 'nota_dinas', '002/IT/V/2026', '2026-05-10', 'Restruktur', 'ini coba restruk', 'surat/1bnrX67BBVhSBBAisJwIHbDhexHitD9E35Wv2tYa.pdf', 'disetujui', '2026-05-10 08:00:28', '2026-05-10 08:19:50'),
(4, 2, 'nota_dinas', '003/IT/V/2026', '2026-05-08', 'Coa Limitasi', 'Sehubungan dengan kebutuhan penyesuaian dan pengendalian transaksi operasional pada sistem, bersama ini disampaikan permohonan untuk dilakukan pengaturan/pembatasan (limitasi) pada COA tertentu guna meningkatkan ketertiban administrasi, keamanan transaksi, serta meminimalisir potensi kesalahan penggunaan akun dalam proses operasional.\r\n\r\nAdapun limitasi COA tersebut agar dapat disesuaikan berdasarkan kebutuhan operasional dan kewenangan user terkait pada masing-masing unit kerja. Dengan adanya penyesuaian tersebut diharapkan proses monitoring, pencatatan, dan pengendalian transaksi dapat berjalan lebih efektif dan sesuai ketentuan yang berlaku.\r\n\r\nDemikian nota dinas ini disampaikan untuk dapat ditindaklanjuti sebagaimana mestinya. Atas perhatian dan kerja samanya diucapkan terima kasih.', 'surat/AoyLOLZ9PN3SfCRJyyu3jUJqFt9ei74qhXVylWcC.pdf', 'disetujui', '2026-05-10 10:54:33', '2026-05-10 10:56:36'),
(5, 2, 'nota_dinas', '005/IT/V/2026', '2026-05-11', 'Permohonan buka blokir', 'memohon untuk buka blokir', 'surat/gp4hqjnKzAPHz3wzShfqbn6QYyFWaGw7BNXwik6c.pdf', 'disetujui', '2026-05-10 18:09:49', '2026-05-10 18:11:26'),
(6, 2, 'nota_dinas', '007/IT/V/2026', '2026-05-11', 'Permohonan Laporan', 'Tolong Laporan', 'surat/0AEJz9hottvgI15f55UZHrJy9qs2rq6xEaG9K99n.pdf', 'ditolak', '2026-05-10 18:26:01', '2026-05-11 10:37:27'),
(7, 2, 'nota_dinas', '010/IT/V/2026', '2026-05-11', 'Pembelian Kursi', 'Pembelian Kursi tolong dibeliin', 'surat/H3bwRUoA1HNghu0tBtBNreJj0rW4UJ3kX9OkonG5.pdf', 'disetujui', '2026-05-10 18:27:23', '2026-05-11 10:37:23'),
(8, 2, 'Berita Acara', '009/IT/V/2026', '2026-05-11', 'Permohonan Buka Blokir', 'Buka Blokir', 'surat/UdY6zAIjs2kBmMMgrbtSPS1BU95fvIQBLmZZgifG.pdf', 'disetujui', '2026-05-10 18:32:35', '2026-05-10 18:35:38'),
(9, 2, 'nota_dinas', '111/IT/V/2026', '2026-05-11', 'AUDIT INTERNAL', 'Import PDF', 'surat/LCErKbL529u45XlPw9mhidKVrnahYTSBIkyWv3lC.pdf', 'disetujui', '2026-05-11 02:44:30', '2026-05-11 10:33:28'),
(10, 2, 'Risalah Rapat', '200/IT/V/2026', '2026-05-11', 'Permohonan Restruk', 'Restruk', 'surat/inefZGYgyoj98mZEp0KYM7MXhioMfaOqsbqSuJpv.pdf', 'disetujui', '2026-05-11 10:11:12', '2026-05-11 10:11:54'),
(11, 2, 'Berita Acara', '201/IT/V/2026', '2026-05-11', 'COBA ALERT', 'COBA ALERT', 'surat/ypp7F23Y3rZ6d2uJopnjbkVXUGEhwhUMLXjYe2fF.pdf', 'disetujui', '2026-05-11 10:27:43', '2026-05-11 19:17:45');

-- --------------------------------------------------------

--
-- Struktur dari tabel `surat_masuk`
--

CREATE TABLE `surat_masuk` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `surat_id` bigint(20) UNSIGNED NOT NULL,
  `bagian_id` bigint(20) UNSIGNED NOT NULL,
  `dibaca` tinyint(1) NOT NULL DEFAULT 0,
  `tanggal_dibaca` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `surat_masuk`
--

INSERT INTO `surat_masuk` (`id`, `surat_id`, `bagian_id`, `dibaca`, `tanggal_dibaca`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 1, NULL, '2026-05-10 08:19:50', '2026-05-10 09:14:13'),
(2, 4, 5, 0, NULL, '2026-05-10 10:56:36', '2026-05-10 10:56:36'),
(3, 4, 7, 1, NULL, '2026-05-10 10:56:36', '2026-05-11 02:57:33'),
(4, 4, 4, 0, NULL, '2026-05-10 10:56:36', '2026-05-10 10:56:36'),
(5, 5, 3, 0, NULL, '2026-05-10 18:11:26', '2026-05-10 18:11:26'),
(6, 8, 5, 0, NULL, '2026-05-10 18:35:38', '2026-05-10 18:35:38'),
(7, 10, 7, 0, NULL, '2026-05-11 10:11:54', '2026-05-11 10:11:54'),
(8, 9, 9, 0, NULL, '2026-05-11 10:33:28', '2026-05-11 10:33:28'),
(9, 9, 3, 0, NULL, '2026-05-11 10:33:28', '2026-05-11 10:33:28'),
(10, 7, 4, 0, NULL, '2026-05-11 10:37:23', '2026-05-11 10:37:23'),
(11, 11, 2, 0, NULL, '2026-05-11 19:17:45', '2026-05-11 19:17:45');

-- --------------------------------------------------------

--
-- Struktur dari tabel `surat_ttd`
--

CREATE TABLE `surat_ttd` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `surat_id` bigint(20) UNSIGNED NOT NULL,
  `pegawai_id` bigint(20) UNSIGNED NOT NULL,
  `urutan` int(11) NOT NULL DEFAULT 1,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `tanggal_ttd` timestamp NULL DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `surat_ttd`
--

INSERT INTO `surat_ttd` (`id`, `surat_id`, `pegawai_id`, `urutan`, `status`, `tanggal_ttd`, `catatan`, `created_at`, `updated_at`) VALUES
(1, 2, 8, 1, 'ditolak', '2026-05-10 08:21:11', NULL, '2026-05-10 07:56:59', '2026-05-10 08:21:11'),
(3, 4, 11, 1, 'disetujui', '2026-05-10 10:56:36', NULL, '2026-05-10 10:54:33', '2026-05-10 10:56:36'),
(4, 4, 9, 2, 'disetujui', '2026-05-10 10:55:58', NULL, '2026-05-10 10:54:33', '2026-05-10 10:55:58'),
(5, 5, 9, 1, 'disetujui', '2026-05-10 18:10:43', NULL, '2026-05-10 18:09:49', '2026-05-10 18:10:43'),
(6, 5, 8, 2, 'disetujui', '2026-05-10 18:11:26', NULL, '2026-05-10 18:09:49', '2026-05-10 18:11:26'),
(7, 6, 9, 1, 'disetujui', '2026-05-10 18:35:41', NULL, '2026-05-10 18:26:01', '2026-05-10 18:35:41'),
(8, 6, 8, 2, 'ditolak', '2026-05-11 10:37:27', NULL, '2026-05-10 18:26:01', '2026-05-11 10:37:27'),
(9, 7, 8, 1, 'disetujui', '2026-05-11 10:37:23', NULL, '2026-05-10 18:27:23', '2026-05-11 10:37:23'),
(10, 8, 9, 1, 'disetujui', '2026-05-10 18:35:38', NULL, '2026-05-10 18:32:35', '2026-05-10 18:35:38'),
(11, 9, 8, 1, 'disetujui', '2026-05-11 10:33:28', NULL, '2026-05-11 02:44:30', '2026-05-11 10:33:28'),
(12, 9, 9, 2, 'disetujui', '2026-05-11 02:58:36', NULL, '2026-05-11 02:44:30', '2026-05-11 02:58:36'),
(13, 10, 8, 1, 'disetujui', '2026-05-11 10:11:54', NULL, '2026-05-11 10:11:12', '2026-05-11 10:11:54'),
(14, 11, 11, 1, 'disetujui', '2026-05-11 19:17:45', NULL, '2026-05-11 10:27:43', '2026-05-11 19:17:45');

-- --------------------------------------------------------

--
-- Struktur dari tabel `surat_tujuan`
--

CREATE TABLE `surat_tujuan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `surat_id` bigint(20) UNSIGNED NOT NULL,
  `bagian_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `surat_tujuan`
--

INSERT INTO `surat_tujuan` (`id`, `surat_id`, `bagian_id`, `created_at`, `updated_at`) VALUES
(1, 1, 3, '2026-05-10 07:55:19', '2026-05-10 07:55:19'),
(2, 2, 3, '2026-05-10 07:56:59', '2026-05-10 07:56:59'),
(3, 3, 1, '2026-05-10 08:00:28', '2026-05-10 08:00:28'),
(4, 4, 5, '2026-05-10 10:54:33', '2026-05-10 10:54:33'),
(5, 4, 7, '2026-05-10 10:54:33', '2026-05-10 10:54:33'),
(6, 4, 4, '2026-05-10 10:54:33', '2026-05-10 10:54:33'),
(7, 5, 3, '2026-05-10 18:09:49', '2026-05-10 18:09:49'),
(8, 6, 5, '2026-05-10 18:26:01', '2026-05-10 18:26:01'),
(9, 7, 4, '2026-05-10 18:27:23', '2026-05-10 18:27:23'),
(10, 8, 5, '2026-05-10 18:32:35', '2026-05-10 18:32:35'),
(11, 9, 9, '2026-05-11 02:44:30', '2026-05-11 02:44:30'),
(12, 9, 3, '2026-05-11 02:44:30', '2026-05-11 02:44:30'),
(13, 10, 7, '2026-05-11 10:11:12', '2026-05-11 10:11:12'),
(14, 11, 2, '2026-05-11 10:27:43', '2026-05-11 10:27:43');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'pegawai',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin SIPENA', 'admin@sipena.com', NULL, '$2y$12$hX6dJQbul6MDvZ5zGhkSpObnzXJ/VpHqq4vXNxkpGC8UoYgG6MKFa', 'admin', NULL, '2026-05-06 01:38:11', '2026-05-06 01:38:11'),
(2, 'Jimmi Afriando Akbar', 'Jimmi@gmail.com', NULL, '$2y$12$PR5/g49iEPAPdDLM6960w.h7D.TvlUy/eC/7/JibUYdwNNWdXz5Ym', 'pegawai', NULL, '2026-05-06 01:39:50', '2026-05-11 10:32:35'),
(9, 'Angga Rendy Septian', 'anggarendy@gmail.com', NULL, '$2y$12$u2iqxmBJnrT5o23NPdHEB.XTn71qPs1qTqZEtvvnG/HpM1RWrcDia', 'pegawai', NULL, '2026-05-06 03:03:14', '2026-05-06 03:03:14'),
(10, 'Bagus Bramansyah', 'Bagus@gmail.com', NULL, '$2y$12$W072RuXI4Gg1TMgsMnBwK.AWP1ZEI9B42FDUOln0I8XFzyslUS/Fu', 'pegawai', NULL, '2026-05-06 03:18:20', '2026-05-06 03:18:20'),
(12, 'Agus Prinanto', 'agus@gmail.com', NULL, '$2y$12$6nRV.9eRotCJCHiKlEMLg.czrsOroidA7u26wSJQtnbht0aArSRCC', 'pegawai', NULL, '2026-05-10 10:51:35', '2026-05-10 10:51:35'),
(14, 'Dwi Yuli', 'Dwiyuli@gmail.com', NULL, '$2y$12$hTgYdj/1nQeNswU8GlXS7u8p8iqJEiBK8dw4OzPTjVKl67oy5E.oC', 'pegawai', NULL, '2026-05-11 10:44:46', '2026-05-11 10:44:46'),
(15, 'Wahyu Nugraha', 'wahyu@gmail.com', NULL, '$2y$12$7zYrQdrwxcXlzQEjY8/zLu.LcHvu/IGyvxmWP0rNAMCpk2P1Ifqji', 'pegawai', NULL, '2026-05-11 10:50:49', '2026-05-11 10:50:49'),
(16, 'Arif Ab', 'Arif@gmail.com', NULL, '$2y$12$QV0RJvXLNhxj2EpfyOPoZeQZ9Gqnmbv9VQSUx8EIbMCD9nQuhehJy', 'pegawai', NULL, '2026-05-11 10:56:47', '2026-05-11 10:56:47');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `bagian`
--
ALTER TABLE `bagian`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `jabatan_kode_jabatan_unique` (`kode_bagian`),
  ADD UNIQUE KEY `jabatan_nama_jabatan_unique` (`nama_bagian`);

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
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `jabatan_nama_jabatan_unique` (`nama_jabatan`);

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
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pegawai_nip_unique` (`nip`),
  ADD KEY `pegawai_user_id_foreign` (`user_id`),
  ADD KEY `pegawai_bagian_id_foreign` (`bagian_id`),
  ADD KEY `pegawai_jabatan_id_foreign` (`jabatan_id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `surat`
--
ALTER TABLE `surat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `surat_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `surat_masuk`
--
ALTER TABLE `surat_masuk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `surat_masuk_surat_id_foreign` (`surat_id`),
  ADD KEY `surat_masuk_bagian_id_foreign` (`bagian_id`);

--
-- Indeks untuk tabel `surat_ttd`
--
ALTER TABLE `surat_ttd`
  ADD PRIMARY KEY (`id`),
  ADD KEY `surat_ttd_surat_id_foreign` (`surat_id`),
  ADD KEY `surat_ttd_pegawai_id_foreign` (`pegawai_id`);

--
-- Indeks untuk tabel `surat_tujuan`
--
ALTER TABLE `surat_tujuan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `surat_tujuan_surat_id_foreign` (`surat_id`),
  ADD KEY `surat_tujuan_bagian_id_foreign` (`bagian_id`);

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
-- AUTO_INCREMENT untuk tabel `bagian`
--
ALTER TABLE `bagian`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `surat`
--
ALTER TABLE `surat`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `surat_masuk`
--
ALTER TABLE `surat_masuk`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `surat_ttd`
--
ALTER TABLE `surat_ttd`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `surat_tujuan`
--
ALTER TABLE `surat_tujuan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  ADD CONSTRAINT `pegawai_bagian_id_foreign` FOREIGN KEY (`bagian_id`) REFERENCES `bagian` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pegawai_jabatan_id_foreign` FOREIGN KEY (`jabatan_id`) REFERENCES `jabatan` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pegawai_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `surat`
--
ALTER TABLE `surat`
  ADD CONSTRAINT `surat_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `surat_masuk`
--
ALTER TABLE `surat_masuk`
  ADD CONSTRAINT `surat_masuk_bagian_id_foreign` FOREIGN KEY (`bagian_id`) REFERENCES `bagian` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `surat_masuk_surat_id_foreign` FOREIGN KEY (`surat_id`) REFERENCES `surat` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `surat_ttd`
--
ALTER TABLE `surat_ttd`
  ADD CONSTRAINT `surat_ttd_pegawai_id_foreign` FOREIGN KEY (`pegawai_id`) REFERENCES `pegawai` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `surat_ttd_surat_id_foreign` FOREIGN KEY (`surat_id`) REFERENCES `surat` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `surat_tujuan`
--
ALTER TABLE `surat_tujuan`
  ADD CONSTRAINT `surat_tujuan_bagian_id_foreign` FOREIGN KEY (`bagian_id`) REFERENCES `bagian` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `surat_tujuan_surat_id_foreign` FOREIGN KEY (`surat_id`) REFERENCES `surat` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
