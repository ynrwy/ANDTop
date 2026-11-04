-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 04, 2026 at 07:28 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `andtop-topup`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ewallets`
--

CREATE TABLE `ewallets` (
  `id_ewallet` bigint UNSIGNED NOT NULL,
  `nama_ewallet` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'images/ewallets/default.png',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ewallets`
--

INSERT INTO `ewallets` (`id_ewallet`, `nama_ewallet`, `deskripsi`, `photo`, `created_at`, `updated_at`) VALUES
(1, 'DANA', 'Top up saldo DANA dengan proses cepat dan aman.', 'images/ewallets/dana.png', '2026-06-13 09:03:01', '2026-06-14 07:19:19'),
(2, 'OVO', 'Top up saldo OVO untuk kebutuhan transaksi sehari-hari.', 'images/ewallets/ovo.png', '2026-06-13 09:03:01', '2026-06-13 09:03:01'),
(3, 'GoPay', 'Top up saldo GoPay langsung masuk ke akun Anda.', 'images/ewallets/gopay.png', '2026-06-13 09:03:01', '2026-06-13 09:03:01'),
(4, 'Shopee pay', 'Top up saldo shopee pay dengan cepat dan aman', 'images/ewallets/OLs3FqXJ3Ol5SWR6tgox03BLsPBGYZxuHPxBd0K8.png', '2026-06-14 09:21:29', '2026-06-14 09:22:33'),
(6, 'test', 'bla', 'images/ewallets/default.png', '2026-10-19 06:22:50', '2026-10-19 06:22:50');

-- --------------------------------------------------------

--
-- Table structure for table `ewallet_packages`
--

CREATE TABLE `ewallet_packages` (
  `id_package` bigint UNSIGNED NOT NULL,
  `id_ewallet` bigint UNSIGNED NOT NULL,
  `nama_paket` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nominal` int NOT NULL,
  `harga_coin` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ewallet_packages`
--

INSERT INTO `ewallet_packages` (`id_package`, `id_ewallet`, `nama_paket`, `nominal`, `harga_coin`, `created_at`, `updated_at`) VALUES
(1, 1, 'Saldo Rp 25.000', 25000, 27.00, '2026-06-13 09:03:01', '2026-06-14 07:20:32'),
(2, 1, 'Saldo Rp 50.000', 50000, 53.00, '2026-06-13 09:03:01', '2026-06-13 09:03:01'),
(3, 1, 'Saldo Rp 100.000', 100000, 104.00, '2026-06-13 09:03:01', '2026-06-13 09:03:01'),
(4, 2, 'Saldo Rp 25.000', 25000, 27.00, '2026-06-13 09:03:01', '2026-06-13 09:03:01'),
(5, 2, 'Saldo Rp 50.000', 50000, 53.00, '2026-06-13 09:03:01', '2026-06-13 09:03:01'),
(6, 2, 'Saldo Rp 100.000', 100000, 104.00, '2026-06-13 09:03:01', '2026-06-13 09:03:01'),
(7, 3, 'Saldo Rp 25.000', 25000, 27.00, '2026-06-13 09:03:01', '2026-06-13 09:03:01'),
(8, 3, 'Saldo Rp 50.000', 50000, 53.00, '2026-06-13 09:03:01', '2026-06-13 09:03:01'),
(9, 3, 'Saldo Rp 100.000', 100000, 104.00, '2026-06-13 09:03:01', '2026-06-13 09:03:01'),
(10, 4, 'Saldo Rp 25.000', 25000, 27.00, '2026-06-14 09:23:50', '2026-06-14 09:23:50');

-- --------------------------------------------------------

--
-- Table structure for table `ewallet_transactions`
--

CREATE TABLE `ewallet_transactions` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `id_ewallet` bigint UNSIGNED NOT NULL,
  `id_package` bigint UNSIGNED NOT NULL,
  `target_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga_coin` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
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
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `id_game` bigint UNSIGNED NOT NULL,
  `nama_game` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'images/games/default.png',
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'images/games/icons/default.png',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`id_game`, `nama_game`, `deskripsi`, `photo`, `icon`, `created_at`, `updated_at`) VALUES
(1, 'Mobile Legends', 'Top up diamond Mobile Legends dengan harga terjangkau dan proses cepat.', 'images/games/mobile-legends.jpeg', 'images/games/icons/diamond-ml.jpg', '2026-06-13 09:03:01', '2026-06-13 12:28:54'),
(2, 'Free Fire', 'Top up diamond Free Fire untuk membeli skin, karakter, dan item lainnya.', 'images/games/free-fire.jpeg', 'images/games/icons/diamond-ff.jpg', '2026-06-13 09:03:01', '2026-06-13 09:03:01'),
(3, 'PUBG Mobile', 'Top up UC PUBG Mobile dengan berbagai pilihan nominal.', 'images/games/pubg-mobile.jpg', 'images/games/icons/diamond-pubg.jpg', '2026-06-13 09:03:01', '2026-06-13 09:03:01'),
(5, 'Roblox', 'Roblox', 'images/games/4cLERgLfjxX2SYPkV7h4dhKkrBdzRby4qARGkehc.jpg', 'images/games/icons/Q0ViXr3z9b6WwpC0mYtofAZNi0SlxQ0SEJ3rAABH.jpg', '2026-06-13 13:02:42', '2026-10-19 06:22:12'),
(7, 'Valorant', 'Top up valo dengan cepat', 'images/games/sDxWh4KUoGS9IEK6BLB1VfXn5sngK8NVfVTVUmfh.jpg', 'images/games/icons/xmgmcofRuNOCs40lLZFHA8JASW4zCp1sCQqKZ2rg.png', '2026-06-14 09:18:32', '2026-06-14 09:18:32');

-- --------------------------------------------------------

--
-- Table structure for table `game_packages`
--

CREATE TABLE `game_packages` (
  `id_package` bigint UNSIGNED NOT NULL,
  `id_game` bigint UNSIGNED NOT NULL,
  `nama_paket` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` int NOT NULL,
  `harga_coin` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `game_packages`
--

INSERT INTO `game_packages` (`id_package`, `id_game`, `nama_paket`, `jumlah`, `harga_coin`, `created_at`, `updated_at`) VALUES
(1, 1, '86 Diamond', 86, 20.00, '2026-06-13 09:03:01', '2026-06-13 09:03:01'),
(2, 1, '172 Diamond', 172, 38.00, '2026-06-13 09:03:01', '2026-06-13 09:03:01'),
(3, 1, '344 Diamond', 344, 75.00, '2026-06-13 09:03:01', '2026-06-13 09:03:01'),
(4, 2, '70 Diamond', 70, 15.00, '2026-06-13 09:03:01', '2026-06-13 09:03:01'),
(5, 2, '140 Diamond', 140, 29.00, '2026-06-13 09:03:01', '2026-06-13 09:03:01'),
(6, 2, '355 Diamond', 355, 70.00, '2026-06-13 09:03:01', '2026-06-13 09:03:01'),
(7, 3, '60 UC', 60, 17.00, '2026-06-13 09:03:01', '2026-06-13 09:03:01'),
(8, 3, '325 UC', 325, 85.00, '2026-06-13 09:03:01', '2026-06-13 09:03:01'),
(9, 3, '660 UC', 660, 165.00, '2026-06-13 09:03:01', '2026-06-13 09:03:01'),
(10, 5, '20 Robux', 18, 20.00, '2026-06-13 13:17:54', '2026-06-14 07:57:00'),
(11, 7, '475 VP', 475, 100.00, '2026-06-14 09:27:33', '2026-06-14 09:27:33');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
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
-- Table structure for table `job_batches`
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
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_06_13_071453_add_saldo_to_users_table', 1),
(5, '2026_06_13_075851_create_games_table', 1),
(6, '2026_06_13_084538_create_game_packages_table', 1),
(7, '2026_06_13_134759_create_ewallets_table', 1),
(8, '2026_06_13_135308_create_ewallet_packages_table', 1),
(9, '2026_06_13_135339_create_ewallet_transactions_table', 1),
(10, '2026_06_13_141234_create_transactions_table', 1),
(11, '2026_06_13_155221_add_photo_to_users_table', 1),
(12, '2026_06_24_030156_add_status_to_users_table', 2),
(13, '2026_10_19_113928_add_google_id_to_users_table', 3),
(14, '2026_10_21_065205_create_topup_orders_table', 4),
(15, '2026_10_21_075722_add_payment_detail_to_topup_orders_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', '2026-06-13 09:03:01', '2026-06-13 09:03:01'),
(2, 'User', '2026-06-13 09:03:01', '2026-06-13 09:03:01');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
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
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('561psGoZa4peic2zZOlnqAgLmm39RVs91EC4WqSw', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaXVqUU5sZzdtdDNnYjR0TnFxZktjTVVDVUU2Q2ZITG9kMG5tWXpnQyI7czo3OiJzdWNjZXNzIjtzOjUzOiJTYW1wYWkganVtcGEhIEFuZGEgdGVsYWggYmVyaGFzaWwga2VsdWFyIGRhcmkgQW5kVG9wLiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjE6e2k6MDtzOjc6InN1Y2Nlc3MiO319fQ==', 1792573285),
('9ZCykAu0SmFoeFwdBC4I6hMIcZIwC2luzPio8ndv', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSzBTMElMeHJMT2lYZUhHQVZoek10eHA3U2RGeDJURlBXTjg4UGQ2aSI7czo3OiJzdWNjZXNzIjtzOjUzOiJTYW1wYWkganVtcGEhIEFuZGEgdGVsYWggYmVyaGFzaWwga2VsdWFyIGRhcmkgQW5kVG9wLiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjE6e2k6MDtzOjc6InN1Y2Nlc3MiO319fQ==', 1792582637),
('FHhFrajDQvVfGqexKnjbsrq3PheQ6tBRKltJL3H4', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibEJ1cWdrUGRUc2swcTN1b0tQelFHTWFXbFdmakg1T3V5VXZsbzd0NSI7czo3OiJzdWNjZXNzIjtzOjUzOiJTYW1wYWkganVtcGEhIEFuZGEgdGVsYWggYmVyaGFzaWwga2VsdWFyIGRhcmkgQW5kVG9wLiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjE6e2k6MDtzOjc6InN1Y2Nlc3MiO319fQ==', 1792579567),
('OwdekguhtV2DsCKKAcIoVGYTABaDe3lLL3l7HaLw', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiR1NDRzUzZTBhUjl0N2hMTG5YUEhON0paT3NyVE9GQ05hbHo5OWZETiI7czo3OiJzdWNjZXNzIjtzOjUzOiJTYW1wYWkganVtcGEhIEFuZGEgdGVsYWggYmVyaGFzaWwga2VsdWFyIGRhcmkgQW5kVG9wLiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjE6e2k6MDtzOjc6InN1Y2Nlc3MiO319fQ==', 1792580063),
('S2X7Pk9NrggZoRTlijdBbYInMCasJQF4gLzVOUAO', 18, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQTZocFUyUGNvZzdVcE8wZlhYcGE3V1c3cnBXa3FaeGR3b3VjeTBsNyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC90b3B1cC1nYW1lLzEiO3M6NToicm91dGUiO3M6MTc6InRvcHVwLmdhbWUuZGV0YWlsIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTg7fQ==', 1792585248),
('wyN3Ovr0V2Er2CktXnyGX1p7BJBITiBDK0GLipab', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRXhGVXBwSm5BdzdReTNSV094UmJDUnE5Q0I1V1I2UjRnVGpXdkRxcCI7czo3OiJzdWNjZXNzIjtzOjUzOiJTYW1wYWkganVtcGEhIEFuZGEgdGVsYWggYmVyaGFzaWwga2VsdWFyIGRhcmkgQW5kVG9wLiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjE6e2k6MDtzOjc6InN1Y2Nlc3MiO319fQ==', 1792580430),
('xdj66Ynh1jtsk59dtn7EqdG09ihiRNcks2dst0J0', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibHJnVXZXeW84bkZGcGk5dllHbkxrejFOakVlQm9iRkRiUGkxNG9HVyI7czo3OiJzdWNjZXNzIjtzOjUzOiJTYW1wYWkganVtcGEhIEFuZGEgdGVsYWggYmVyaGFzaWwga2VsdWFyIGRhcmkgQW5kVG9wLiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjE6e2k6MDtzOjc6InN1Y2Nlc3MiO319fQ==', 1792579503),
('YjrQ9wjKcPxtPgTj1HQ6HqBaqKI1Fino8fDhHUaX', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiejUySk1TMGZ2bEY5cTVkT3FvRDFDWnRtanJ1N3hJR2dacUN4ZnY2NSI7czo3OiJzdWNjZXNzIjtzOjUzOiJTYW1wYWkganVtcGEhIEFuZGEgdGVsYWggYmVyaGFzaWwga2VsdWFyIGRhcmkgQW5kVG9wLiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjE6e2k6MDtzOjc6InN1Y2Nlc3MiO319fQ==', 1792582058);

-- --------------------------------------------------------

--
-- Table structure for table `topup_orders`
--

CREATE TABLE `topup_orders` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `coin` int UNSIGNED NOT NULL,
  `amount` bigint UNSIGNED NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `payment_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_detail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `topup_orders`
--

INSERT INTO `topup_orders` (`id`, `order_id`, `user_id`, `coin`, `amount`, `status`, `payment_type`, `payment_detail`, `paid_at`, `created_at`, `updated_at`) VALUES
(17, 'ATP-2-261021104056-GJG5', 2, 1, 1000, 'pending', NULL, NULL, NULL, '2026-10-21 03:40:56', '2026-10-21 03:40:56'),
(18, 'ATP-2-261021104120-EWDL', 2, 1, 1000, 'paid', 'credit_card', 'Kartu 48111111-1114', '2026-10-21 03:42:21', '2026-10-21 03:41:20', '2026-10-21 03:42:21');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `jenis` enum('saldo','game','ewallet') COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_item` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_paket` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `target_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jumlah_coin` decimal(15,2) NOT NULL,
  `tipe` enum('masuk','keluar') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `jenis`, `nama_item`, `nama_paket`, `target_id`, `jumlah_coin`, `tipe`, `created_at`, `updated_at`) VALUES
(44, 2, 'saldo', 'Topup Saldo', 'via Kartu kredit/debit', 'Kartu 48111111-1114', 1.00, 'masuk', '2026-10-21 03:42:21', '2026-10-21 03:42:21');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `google_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  `saldo` decimal(15,2) NOT NULL DEFAULT '0.00',
  `status` enum('aktif','nonaktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'images/users/default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `google_id`, `email_verified_at`, `password`, `role_id`, `saldo`, `status`, `remember_token`, `created_at`, `updated_at`, `photo`) VALUES
(1, 'Admin', 'admin@gmail.com', NULL, '2026-10-19 05:23:15', '$2y$12$/tEkcLdX3Fl7cDKZLThpCuAn6sBgiw8ZrE6iHy4BTuZjk8tvubx.G', 1, 0.00, 'aktif', NULL, '2026-06-13 09:03:01', '2026-10-19 06:14:27', 'images/users/default.jpg'),
(2, 'Customer 1', 'customer1@gmail.com', NULL, '2026-10-19 05:23:15', '$2y$12$e4MiK1GIk.UbCFnT5aWxKOsKFgvcSyvxiQ4TLN4.TdufwJZAb1h22', 2, 9.00, 'aktif', NULL, '2026-06-13 09:03:01', '2026-10-21 03:42:21', 'images/users/gRVpAjcCBxmArASZu7lHlcnf8iLWgq7mjArTuQDB.png'),
(18, 'Nazwar', 'gamingxyols@gmail.com', '116702132738154396461', '2026-10-21 03:44:51', '$2y$12$IIjHonNtlacxefSnfX8ofuwoZ2Sw9XCztoVzyNBIQ3nvmMaXjwlHW', 2, 0.00, 'aktif', 'VTSLDW6EmFDYQpqb8cxzrS2IlZugTnWuEZgnZaLH1OqiG5norYLT7tqB4Y5I', '2026-10-21 03:43:45', '2026-10-21 03:46:18', 'images/users/default.jpg'),
(19, 'test', 'test@gmail.com', NULL, NULL, '$2y$12$Uou1um8mBhZPfkoIhs6QMu.B4vrupZ43hTtVDbdBCGe1IABN7.kOG', 2, 0.00, 'aktif', NULL, '2026-10-21 03:47:14', '2026-10-21 03:47:14', 'images/users/default.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `ewallets`
--
ALTER TABLE `ewallets`
  ADD PRIMARY KEY (`id_ewallet`);

--
-- Indexes for table `ewallet_packages`
--
ALTER TABLE `ewallet_packages`
  ADD PRIMARY KEY (`id_package`),
  ADD KEY `ewallet_packages_id_ewallet_foreign` (`id_ewallet`);

--
-- Indexes for table `ewallet_transactions`
--
ALTER TABLE `ewallet_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ewallet_transactions_user_id_foreign` (`user_id`),
  ADD KEY `ewallet_transactions_id_ewallet_foreign` (`id_ewallet`),
  ADD KEY `ewallet_transactions_id_package_foreign` (`id_package`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id_game`);

--
-- Indexes for table `game_packages`
--
ALTER TABLE `game_packages`
  ADD PRIMARY KEY (`id_package`),
  ADD KEY `game_packages_id_game_foreign` (`id_game`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `topup_orders`
--
ALTER TABLE `topup_orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `topup_orders_order_id_unique` (`order_id`),
  ADD KEY `topup_orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_google_id_unique` (`google_id`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ewallets`
--
ALTER TABLE `ewallets`
  MODIFY `id_ewallet` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ewallet_packages`
--
ALTER TABLE `ewallet_packages`
  MODIFY `id_package` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `ewallet_transactions`
--
ALTER TABLE `ewallet_transactions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `id_game` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `game_packages`
--
ALTER TABLE `game_packages`
  MODIFY `id_package` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `topup_orders`
--
ALTER TABLE `topup_orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ewallet_packages`
--
ALTER TABLE `ewallet_packages`
  ADD CONSTRAINT `ewallet_packages_id_ewallet_foreign` FOREIGN KEY (`id_ewallet`) REFERENCES `ewallets` (`id_ewallet`) ON DELETE CASCADE;

--
-- Constraints for table `ewallet_transactions`
--
ALTER TABLE `ewallet_transactions`
  ADD CONSTRAINT `ewallet_transactions_id_ewallet_foreign` FOREIGN KEY (`id_ewallet`) REFERENCES `ewallets` (`id_ewallet`) ON DELETE CASCADE,
  ADD CONSTRAINT `ewallet_transactions_id_package_foreign` FOREIGN KEY (`id_package`) REFERENCES `ewallet_packages` (`id_package`) ON DELETE CASCADE,
  ADD CONSTRAINT `ewallet_transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `game_packages`
--
ALTER TABLE `game_packages`
  ADD CONSTRAINT `game_packages_id_game_foreign` FOREIGN KEY (`id_game`) REFERENCES `games` (`id_game`) ON DELETE CASCADE;

--
-- Constraints for table `topup_orders`
--
ALTER TABLE `topup_orders`
  ADD CONSTRAINT `topup_orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
