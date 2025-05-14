-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3748
-- Generation Time: May 14, 2025 at 02:05 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `thursina_iibs_tes`
--

-- --------------------------------------------------------

--
-- Table structure for table `app_settings`
--

CREATE TABLE `app_settings` (
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `app_settings`
--

INSERT INTO `app_settings` (`name`, `value`, `description`, `created_at`, `updated_at`) VALUES
('PROVINSI_ID', 'cf5573a0-3169-11ef-9fbe-61199b1df55c', NULL, '2025-05-13 23:49:44', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `core_menus`
--

CREATE TABLE `core_menus` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_show` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `core_menus`
--

INSERT INTO `core_menus` (`id`, `url`, `title`, `icon`, `parent_id`, `order`, `description`, `is_show`, `created_at`, `updated_at`) VALUES
('1b0d37e0-33d8-11ed-bceb-57a813f27781', 'admin/dashboard', 'Dashboard', 'fas fa-tachometer-alt', NULL, 0, NULL, 1, '2025-05-13 23:49:45', NULL),
('2d2a0c90-3158-11ef-b0cf-5bce39cf270a', 'admin/settings/kategori_paket', 'Kategori Paket', NULL, 'acf0b360-ad85-11ed-a465-974f0ff7e079', 3, NULL, 1, '2025-05-13 23:49:45', NULL),
('3a377a90-3158-11ef-bbc6-9bf542ea8a91', 'admin/settings/asrama', 'Asrama', NULL, 'acf0b360-ad85-11ed-a465-974f0ff7e079', 4, NULL, 1, '2025-05-13 23:49:45', NULL),
('60db5290-3e35-11ed-ad15-f5deea1ad299', 'admin/users/user', 'Pengguna', NULL, 'b9f0c9a0-60af-11ed-9109-2d9c58e86481', 1, NULL, 1, '2025-05-13 23:49:45', NULL),
('77aaf1c0-2fea-11f0-90f6-8f748dc2ab97', 'admin/paket', 'Paket', 'fas fa-box', NULL, 3, NULL, 1, '2025-05-13 23:49:45', NULL),
('aa6e5860-36c5-11ef-a781-97906a43167c', 'admin/laporan', 'Laporan', 'fas fa-file-alt', NULL, 2, NULL, 1, '2025-05-13 23:49:45', NULL),
('acf0b360-ad85-11ed-a465-974f0ff7e079', 'admin/settings', 'Pengaturan', 'fas fa-gear', NULL, 4, NULL, 1, '2025-05-13 23:49:45', NULL),
('b9f0c9a0-60af-11ed-9109-2d9c58e86481', 'admin/users', 'Pengaturan User', 'fa fa-user', NULL, 5, NULL, 1, '2025-05-13 23:49:45', NULL),
('e1076ea0-3157-11ef-9f4c-2f91ddc6c4ca', 'admin/settings/santri', 'Santri', NULL, 'acf0b360-ad85-11ed-a465-974f0ff7e079', 2, NULL, 1, '2025-05-13 23:49:45', NULL),
('eb7fd220-5f09-11ed-93cc-af6e8aa97a7b', 'admin/users/role', 'Role', NULL, 'b9f0c9a0-60af-11ed-9109-2d9c58e86481', 0, NULL, 1, '2025-05-13 23:49:45', NULL),
('f51eaec0-36c5-11ef-8838-e5f828db163c', 'admin/laporan/paket', 'Paket', NULL, 'aa6e5860-36c5-11ef-a781-97906a43167c', 0, NULL, 1, '2025-05-13 23:49:45', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `core_menu_abilities`
--

CREATE TABLE `core_menu_abilities` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `menu_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `core_menu_abilities`
--

INSERT INTO `core_menu_abilities` (`id`, `menu_id`, `name`, `description`, `created_at`, `updated_at`) VALUES
('09e3a860-5f0a-11ed-b7d2-696df24549b4', 'eb7fd220-5f09-11ed-93cc-af6e8aa97a7b', 'role:read', 'role:read', '2025-05-13 23:49:45', NULL),
('0da44230-5f0a-11ed-adf6-ad15bedb8f47', 'eb7fd220-5f09-11ed-93cc-af6e8aa97a7b', 'role:create', 'role:create', '2025-05-13 23:49:45', NULL),
('10b72620-5f0a-11ed-8832-af7c26253484', 'eb7fd220-5f09-11ed-93cc-af6e8aa97a7b', 'role:update', 'role:update', '2025-05-13 23:49:45', NULL),
('13bd20a0-5f0a-11ed-b64c-b1748a8c2a28', 'eb7fd220-5f09-11ed-93cc-af6e8aa97a7b', 'role:delete', 'role:delete', '2025-05-13 23:49:45', NULL),
('51311660-36c6-11ef-bd47-7f4971695337', 'f51eaec0-36c5-11ef-8838-e5f828db163c', 'lap_paket:read', 'lap_paket:read', '2025-05-13 23:49:45', NULL),
('632c53f0-3158-11ef-8dca-899e978d9a0a', 'e1076ea0-3157-11ef-9f4c-2f91ddc6c4ca', 'mst_santri:read', 'mst_santri:read', '2025-05-13 23:49:45', NULL),
('8d592ac0-3158-11ef-b76f-71a8428885eb', 'e1076ea0-3157-11ef-9f4c-2f91ddc6c4ca', 'mst_santri:create', 'mst_santri:create', '2025-05-13 23:49:45', NULL),
('93fb1220-3158-11ef-87e5-914f9a32a81d', 'e1076ea0-3157-11ef-9f4c-2f91ddc6c4ca', 'mst_santri:update', 'mst_santri:update', '2025-05-13 23:49:45', NULL),
('9771fbc0-33d8-11ed-ba52-bd4edf9d4c3f', '1b0d37e0-33d8-11ed-bceb-57a813f27781', 'dashboard:read', 'dashboard:read', '2025-05-13 23:49:45', NULL),
('992885b0-3158-11ef-82f3-3709d3854c3d', 'e1076ea0-3157-11ef-9f4c-2f91ddc6c4ca', 'mst_santri:delete', 'mst_santri:delete', '2025-05-13 23:49:45', NULL),
('9c45a610-3e35-11ed-b616-bb2a0c5878de', '60db5290-3e35-11ed-ad15-f5deea1ad299', 'user:read', 'user:read', '2025-05-13 23:49:45', NULL),
('a06404c0-3e35-11ed-8b8c-f36c367192ad', '60db5290-3e35-11ed-ad15-f5deea1ad299', 'user:create', 'user:create', '2025-05-13 23:49:45', NULL),
('a3e6d460-3e35-11ed-a3d2-058c4fc89cd3', '60db5290-3e35-11ed-ad15-f5deea1ad299', 'user:update', 'user:update', '2025-05-13 23:49:45', NULL),
('a9348770-3e35-11ed-b86c-07b168af0e90', '60db5290-3e35-11ed-ad15-f5deea1ad299', 'user:delete', 'user:delete', '2025-05-13 23:49:45', NULL),
('aa869690-3158-11ef-b619-07c73d847949', '77aaf1c0-2fea-11f0-90f6-8f748dc2ab97', 't_paket:read', 't_paket:read', '2025-05-13 23:49:45', NULL),
('b0e8c7b0-3158-11ef-911d-bf8f22936843', '77aaf1c0-2fea-11f0-90f6-8f748dc2ab97', 't_paket:create', 't_paket:create', '2025-05-13 23:49:45', NULL),
('b6d3efe0-3158-11ef-9733-91b0237e8ab9', '77aaf1c0-2fea-11f0-90f6-8f748dc2ab97', 't_paket:update', 't_paket:update', '2025-05-13 23:49:45', NULL),
('bcacbb80-3158-11ef-a628-730cac43d5ee', '77aaf1c0-2fea-11f0-90f6-8f748dc2ab97', 't_paket:delete', 't_paket:delete', '2025-05-13 23:49:45', NULL),
('c43c6250-3158-11ef-82ca-7f207ef271c1', '2d2a0c90-3158-11ef-b0cf-5bce39cf270a', 'mst_kategori_paket:read', 'mst_kategori_paket:read', '2025-05-13 23:49:45', NULL),
('ce850d70-3158-11ef-805c-571ec4b0dba9', '2d2a0c90-3158-11ef-b0cf-5bce39cf270a', 'mst_kategori_paket:update', 'mst_kategori_paket:update', '2025-05-13 23:49:45', NULL),
('d2e177a0-3158-11ef-9fd6-95e4d0183a0a', '2d2a0c90-3158-11ef-b0cf-5bce39cf270a', 'mst_kategori_paket:create', 'mst_kategori_paket:create', '2025-05-13 23:49:45', NULL),
('d7573640-3158-11ef-a8b0-d310acca71a8', '2d2a0c90-3158-11ef-b0cf-5bce39cf270a', 'mst_kategori_paket:delete', 'mst_kategori_paket:delete', '2025-05-13 23:49:45', NULL),
('e59d75c0-3158-11ef-981c-bdab2b06d7ab', '3a377a90-3158-11ef-bbc6-9bf542ea8a91', 'mst_asrama:read', 'mst_asrama:read', '2025-05-13 23:49:45', NULL),
('e9e2e150-3158-11ef-9b24-c5cf8c30b563', '3a377a90-3158-11ef-bbc6-9bf542ea8a91', 'mst_asrama:create', 'mst_asrama:create', '2025-05-13 23:49:45', NULL),
('ef5eb9f0-3158-11ef-8226-11e456c60cee', '3a377a90-3158-11ef-bbc6-9bf542ea8a91', 'mst_asrama:update', 'mst_asrama:update', '2025-05-13 23:49:45', NULL),
('f2ad7350-3158-11ef-bd51-dfed8006565b', '3a377a90-3158-11ef-bbc6-9bf542ea8a91', 'mst_asrama:delete', 'mst_asrama:delete', '2025-05-13 23:49:45', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `core_privileges`
--

CREATE TABLE `core_privileges` (
  `role_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ability_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `core_privileges`
--

INSERT INTO `core_privileges` (`role_id`, `ability_id`, `created_at`, `updated_at`) VALUES
('50155a72-23c4-4de3-b110-822853fb0deb', '09e3a860-5f0a-11ed-b7d2-696df24549b4', '2025-05-13 23:49:45', NULL),
('50155a72-23c4-4de3-b110-822853fb0deb', '0da44230-5f0a-11ed-adf6-ad15bedb8f47', '2025-05-13 23:49:45', NULL),
('50155a72-23c4-4de3-b110-822853fb0deb', '10b72620-5f0a-11ed-8832-af7c26253484', '2025-05-13 23:49:45', NULL),
('50155a72-23c4-4de3-b110-822853fb0deb', '13bd20a0-5f0a-11ed-b64c-b1748a8c2a28', '2025-05-13 23:49:45', NULL),
('50155a72-23c4-4de3-b110-822853fb0deb', '51311660-36c6-11ef-bd47-7f4971695337', '2025-05-13 23:49:45', NULL),
('50155a72-23c4-4de3-b110-822853fb0deb', '632c53f0-3158-11ef-8dca-899e978d9a0a', '2025-05-13 23:49:45', NULL),
('50155a72-23c4-4de3-b110-822853fb0deb', '8d592ac0-3158-11ef-b76f-71a8428885eb', '2025-05-13 23:49:45', NULL),
('50155a72-23c4-4de3-b110-822853fb0deb', '93fb1220-3158-11ef-87e5-914f9a32a81d', '2025-05-13 23:49:45', NULL),
('50155a72-23c4-4de3-b110-822853fb0deb', '9771fbc0-33d8-11ed-ba52-bd4edf9d4c3f', '2025-05-13 23:49:45', NULL),
('50155a72-23c4-4de3-b110-822853fb0deb', '992885b0-3158-11ef-82f3-3709d3854c3d', '2025-05-13 23:49:45', NULL),
('50155a72-23c4-4de3-b110-822853fb0deb', '9c45a610-3e35-11ed-b616-bb2a0c5878de', '2025-05-13 23:49:45', NULL),
('50155a72-23c4-4de3-b110-822853fb0deb', 'a06404c0-3e35-11ed-8b8c-f36c367192ad', '2025-05-13 23:49:45', NULL),
('50155a72-23c4-4de3-b110-822853fb0deb', 'a3e6d460-3e35-11ed-a3d2-058c4fc89cd3', '2025-05-13 23:49:45', NULL),
('50155a72-23c4-4de3-b110-822853fb0deb', 'a9348770-3e35-11ed-b86c-07b168af0e90', '2025-05-13 23:49:45', NULL),
('50155a72-23c4-4de3-b110-822853fb0deb', 'aa869690-3158-11ef-b619-07c73d847949', '2025-05-13 23:49:45', NULL),
('50155a72-23c4-4de3-b110-822853fb0deb', 'b0e8c7b0-3158-11ef-911d-bf8f22936843', '2025-05-13 23:49:45', NULL),
('50155a72-23c4-4de3-b110-822853fb0deb', 'b6d3efe0-3158-11ef-9733-91b0237e8ab9', '2025-05-13 23:49:45', NULL),
('50155a72-23c4-4de3-b110-822853fb0deb', 'bcacbb80-3158-11ef-a628-730cac43d5ee', '2025-05-13 23:49:45', NULL),
('50155a72-23c4-4de3-b110-822853fb0deb', 'c43c6250-3158-11ef-82ca-7f207ef271c1', '2025-05-13 23:49:45', NULL),
('50155a72-23c4-4de3-b110-822853fb0deb', 'ce850d70-3158-11ef-805c-571ec4b0dba9', '2025-05-13 23:49:45', NULL),
('50155a72-23c4-4de3-b110-822853fb0deb', 'd2e177a0-3158-11ef-9fd6-95e4d0183a0a', '2025-05-13 23:49:45', NULL),
('50155a72-23c4-4de3-b110-822853fb0deb', 'd7573640-3158-11ef-a8b0-d310acca71a8', '2025-05-13 23:49:45', NULL),
('50155a72-23c4-4de3-b110-822853fb0deb', 'e59d75c0-3158-11ef-981c-bdab2b06d7ab', '2025-05-13 23:49:45', NULL),
('50155a72-23c4-4de3-b110-822853fb0deb', 'e9e2e150-3158-11ef-9b24-c5cf8c30b563', '2025-05-13 23:49:45', NULL),
('50155a72-23c4-4de3-b110-822853fb0deb', 'ef5eb9f0-3158-11ef-8226-11e456c60cee', '2025-05-13 23:49:45', NULL),
('50155a72-23c4-4de3-b110-822853fb0deb', 'f2ad7350-3158-11ef-bd51-dfed8006565b', '2025-05-13 23:49:45', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `core_roles`
--

CREATE TABLE `core_roles` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `core_roles`
--

INSERT INTO `core_roles` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
('50155a72-23c4-4de3-b110-822853fb0deb', 'Superadmin', NULL, '2025-05-13 23:49:44', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `core_users`
--

CREATE TABLE `core_users` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `core_users`
--

INSERT INTO `core_users` (`id`, `name`, `email`, `password`, `role_id`, `image`, `phone`, `address`, `remember_token`, `created_at`, `updated_at`) VALUES
('0e46f110-3d4f-11ed-9670-a1d5c62051e7', 'ADMINISTRATOR', 'admin@mail.com', '$2y$10$0bU72rGAgRudLh..8XCbAuxEulQWf0Iuq6Lmd6gP7ph/W8/.weeMq', '50155a72-23c4-4de3-b110-822853fb0deb', NULL, NULL, NULL, NULL, '2025-05-13 23:49:44', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_100000_create_password_resets_table', 1),
(2, '2019_08_19_000000_create_failed_jobs_table', 1),
(3, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(4, '2023_02_10_133522_create_app_settings_table', 1),
(5, '2023_02_10_133750_create_core_roles_table', 1),
(6, '2023_02_10_133753_create_core_users_table', 1),
(7, '2023_02_10_134137_create_core_menus_table', 1),
(8, '2023_02_10_134203_create_core_menu_abilities_table', 1),
(9, '2023_02_10_134241_create_core_privileges_table', 1),
(10, '2025_05_13_184701_create_mst_kategori_pakets_table', 1),
(11, '2025_05_13_184717_create_mst_asramas_table', 1),
(12, '2025_05_13_184726_create_mst_santris_table', 1),
(13, '2025_05_13_184728_create_t_pakets_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mst_asramas`
--

CREATE TABLE `mst_asramas` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gedung` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mst_asramas`
--

INSERT INTO `mst_asramas` (`id`, `nama`, `gedung`, `created_at`, `updated_at`) VALUES
('f290d9f0-3054-11f0-b710-6f28489f2c97', 'Asrama 1', NULL, '2025-05-13 23:49:45', NULL),
('f290dec0-3054-11f0-9765-e9930fad7a1e', 'Asrama 2', NULL, '2025-05-13 23:49:45', NULL),
('f290e060-3054-11f0-821c-8924aa5be33c', 'Asrama 3', NULL, '2025-05-13 23:49:45', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mst_kategori_pakets`
--

CREATE TABLE `mst_kategori_pakets` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mst_kategori_pakets`
--

INSERT INTO `mst_kategori_pakets` (`id`, `nama`, `created_at`, `updated_at`) VALUES
('f28664e0-3054-11f0-88ef-15c621691ac6', 'Makanan Basah', '2025-05-13 23:49:45', NULL),
('f2866840-3054-11f0-b85a-f700319d1ce3', 'Makanan Kering (snack)', '2025-05-13 23:49:45', NULL),
('f2866900-3054-11f0-ac55-698d4cf4ae2f', 'Non Makanan', '2025-05-13 23:49:45', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mst_santris`
--

CREATE TABLE `mst_santris` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nis` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `asrama_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_paket` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mst_santris`
--

INSERT INTO `mst_santris` (`id`, `nis`, `nama`, `alamat`, `asrama_id`, `total_paket`, `created_at`, `updated_at`) VALUES
('0100fcde-2e5c-49b5-a8b0-445fdd7281c7', '806117207540', 'Titin Carla Rahimah M.Pd', 'Jr. Bak Mandi No. 801', 'f290d9f0-3054-11f0-b710-6f28489f2c97', 0, '2025-05-13 23:49:45', '2025-05-13 23:49:45'),
('0662bcc6-07d9-45d8-b022-d57a58687b08', '813389755871', 'Irma Laksmiwati', 'Jln. Gremet No. 43', 'f290e060-3054-11f0-821c-8924aa5be33c', 0, '2025-05-13 23:49:45', '2025-05-13 23:49:45'),
('06df8f6b-b156-4ee7-9e47-f4adea77f393', '645768605596', 'Raharja Simbolon', 'Ki. Gegerkalong Hilir No. 432', 'f290d9f0-3054-11f0-b710-6f28489f2c97', 0, '2025-05-13 23:49:45', '2025-05-13 23:49:45'),
('08732b96-7328-4de5-9a15-9c0f130f26c6', '628589074002', 'Darimin Maryadi', 'Ki. Pintu Besar Selatan No. 207', 'f290dec0-3054-11f0-9765-e9930fad7a1e', 0, '2025-05-13 23:49:45', '2025-05-13 23:49:45'),
('0cffb56f-3c26-4dc0-84e2-0857509adf5a', '288689832260', 'Yani Ghaliyati Handayani', 'Jln. Gambang No. 762', 'f290dec0-3054-11f0-9765-e9930fad7a1e', 0, '2025-05-13 23:49:45', '2025-05-13 23:49:45'),
('104c7dca-34f8-4221-aa43-1e9a9bc945bb', '410453060701', 'Hadi Aswani Mandala M.Kom.', 'Gg. Halim No. 934', 'f290e060-3054-11f0-821c-8924aa5be33c', 0, '2025-05-13 23:49:45', '2025-05-13 23:49:45'),
('142198ea-c697-4dd0-b6b5-7e2f76bb2bb1', '732320317717', 'Maida Zulaika S.Pt', 'Jr. Honggowongso No. 80', 'f290d9f0-3054-11f0-b710-6f28489f2c97', 0, '2025-05-13 23:49:45', '2025-05-13 23:49:45'),
('1a0a6402-306a-401f-97fc-d2035839a453', '346352120353', 'Maya Malika Rahayu S.H.', 'Jr. Umalas No. 15', 'f290dec0-3054-11f0-9765-e9930fad7a1e', 0, '2025-05-13 23:49:45', '2025-05-13 23:49:45'),
('1e21fe6e-d669-4db4-878c-9f66e6ea23ce', '876675378628', 'Cahyadi Hutapea', 'Dk. Bakau No. 814', 'f290dec0-3054-11f0-9765-e9930fad7a1e', 0, '2025-05-13 23:49:45', '2025-05-13 23:49:45'),
('26c9395e-2a16-4a47-b3f7-0d8d66c90b83', '405678570626', 'Belinda Puspasari S.T.', 'Ki. Ujung No. 97', 'f290d9f0-3054-11f0-b710-6f28489f2c97', 0, '2025-05-13 23:49:45', '2025-05-13 23:49:45'),
('275d22ee-6a86-4521-a31c-698a3b350d1f', '101389521219', 'Cengkir Empluk Winarno', 'Jln. Qrisdoren No. 967', 'f290dec0-3054-11f0-9765-e9930fad7a1e', 0, '2025-05-13 23:49:45', '2025-05-13 23:49:45'),
('287bc17c-6a92-4835-8786-af944671e32d', '649525687987', 'Cakrabirawa Sihombing S.Kom', 'Jr. Barat No. 160', 'f290d9f0-3054-11f0-b710-6f28489f2c97', 0, '2025-05-13 23:49:45', '2025-05-13 23:49:45'),
('2a5ab80a-74b8-4e76-94e7-91f392762f2b', '961386644699', 'Belinda Mayasari', 'Dk. Bakti No. 650', 'f290dec0-3054-11f0-9765-e9930fad7a1e', 0, '2025-05-13 23:49:45', '2025-05-13 23:49:45'),
('2e73d83c-89ba-4744-8ca4-3e7678f4e7f2', '733507701256', 'Yuliana Farida', 'Kpg. Diponegoro No. 418', 'f290d9f0-3054-11f0-b710-6f28489f2c97', 0, '2025-05-13 23:49:45', '2025-05-13 23:49:45'),
('2eb1fc78-388a-49f6-b56e-77efd7e3884a', '674516755507', 'Kenari Setiawan S.Psi', 'Ds. Yogyakarta No. 489', 'f290d9f0-3054-11f0-b710-6f28489f2c97', 0, '2025-05-13 23:49:45', '2025-05-13 23:49:45'),
('2f6cb296-a18c-4938-9158-214ead3f5340', '974494802741', 'Luhung Narpati', 'Psr. Salatiga No. 494', 'f290dec0-3054-11f0-9765-e9930fad7a1e', 0, '2025-05-13 23:49:45', '2025-05-13 23:49:45'),
('35384022-44e3-4156-b226-275aaaaf1267', '969453461396', 'Mumpuni Slamet Sitompul S.E.', 'Ki. Bakau Griya Utama No. 656', 'f290e060-3054-11f0-821c-8924aa5be33c', 0, '2025-05-13 23:49:45', '2025-05-13 23:49:45'),
('3622a033-ecbd-421d-bdc1-ec762ab4d512', '944762748373', 'Emong Sinaga', 'Kpg. Babadan No. 131', 'f290d9f0-3054-11f0-b710-6f28489f2c97', 0, '2025-05-13 23:49:45', '2025-05-13 23:49:45'),
('36a0b17e-2344-440f-a0cb-305e04af886b', '715427657796', 'Luwar Jailani', 'Gg. Asia Afrika No. 819', 'f290dec0-3054-11f0-9765-e9930fad7a1e', 0, '2025-05-13 23:49:45', '2025-05-13 23:49:45'),
('39980fbd-9188-420e-bec8-6ef0bc85e361', '219790128937', 'Zelaya Puji Usada M.M.', 'Jr. Nangka No. 685', 'f290dec0-3054-11f0-9765-e9930fad7a1e', 0, '2025-05-13 23:49:45', '2025-05-13 23:49:45'),
('3a736e5b-b10d-47d5-a613-abd7a3655323', '572423439582', 'Darimin Prasetyo', 'Gg. Abdul. Muis No. 614', 'f290dec0-3054-11f0-9765-e9930fad7a1e', 0, '2025-05-13 23:49:45', '2025-05-13 23:49:45'),
('3c80f607-bc94-451f-8747-6623906c92d2', '100061185901', 'Amalia Safitri', 'Jr. Raya Ujungberung No. 572', 'f290dec0-3054-11f0-9765-e9930fad7a1e', 0, '2025-05-13 23:49:45', '2025-05-13 23:49:45'),
('4a65ed28-6aee-4040-aece-50f98b03570f', '569904142590', 'Kusuma Gunawan S.T.', 'Psr. Hayam Wuruk No. 272', 'f290e060-3054-11f0-821c-8924aa5be33c', 0, '2025-05-13 23:49:45', '2025-05-13 23:49:45'),
('51792efd-ec72-445d-98a7-1934027b5337', '474679494689', 'Samiah Yance Kusmawati S.H.', 'Jr. Tangkuban Perahu No. 103', 'f290dec0-3054-11f0-9765-e9930fad7a1e', 0, '2025-05-13 23:49:45', '2025-05-13 23:49:45'),
('5e14976a-e2cb-4c0a-89b2-b5a0b6a78c11', '029174154592', 'Yance Novitasari S.Farm', 'Ki. Krakatau No. 354', 'f290dec0-3054-11f0-9765-e9930fad7a1e', 0, '2025-05-13 23:49:45', '2025-05-13 23:49:45'),
('6228b052-d7b7-42ca-851a-81db7322d7c1', '684451146819', 'Saadat Kenari Widodo M.Ak', 'Jln. Yohanes No. 954', 'f290e060-3054-11f0-821c-8924aa5be33c', 0, '2025-05-13 23:49:45', '2025-05-13 23:49:45'),
('69887ad2-96e3-4db1-8074-91844ccaf37c', '319061029807', 'Jamal Mandala', 'Ki. Bata Putih No. 522', 'f290e060-3054-11f0-821c-8924aa5be33c', 0, '2025-05-13 23:49:45', '2025-05-13 23:49:45'),
('6d715522-341c-4b59-92de-697a2bd25175', '341688436656', 'Sabri Narji Widodo S.E.I', 'Jr. Orang No. 612', 'f290e060-3054-11f0-821c-8924aa5be33c', 0, '2025-05-13 23:49:45', '2025-05-13 23:49:45'),
('6e2db923-5ba1-4730-82d9-78410d9e85b3', '388355816749', 'Paramita Gawati Suryatmi S.IP', 'Dk. Kyai Gede No. 618', 'f290d9f0-3054-11f0-b710-6f28489f2c97', 0, '2025-05-13 23:49:45', '2025-05-13 23:49:45'),
('75edaa1b-24f6-4f64-8f89-72bba645874f', '205882004098', 'Fathonah Halimah', 'Ds. Baja Raya No. 304', 'f290d9f0-3054-11f0-b710-6f28489f2c97', 0, '2025-05-13 23:49:45', '2025-05-13 23:49:45'),
('795c6017-d041-4b8c-87cb-b4faa8b67958', '237684705177', 'Imam Baktiono Wibisono', 'Ki. Flora No. 997', 'f290e060-3054-11f0-821c-8924aa5be33c', 0, '2025-05-13 23:49:45', '2025-05-13 23:49:45'),
('81790f29-06d8-4b26-967a-5b675a1d36ad', '826492193155', 'Yessi Hesti Melani S.Farm', 'Dk. Acordion No. 781', 'f290e060-3054-11f0-821c-8924aa5be33c', 0, '2025-05-13 23:49:45', '2025-05-13 23:49:45'),
('88749844-b32f-49fe-9cfd-c718f7fe8fe4', '561893753723', 'Endah Permata', 'Kpg. Kebangkitan Nasional No. 226', 'f290e060-3054-11f0-821c-8924aa5be33c', 0, '2025-05-13 23:49:45', '2025-05-13 23:49:45'),
('88ce7a37-5e04-4a0e-a24b-22f8e3e1d62f', '619748518165', 'Adikara Saefullah', 'Kpg. Bakti No. 401', 'f290e060-3054-11f0-821c-8924aa5be33c', 0, '2025-05-13 23:49:45', '2025-05-13 23:49:45'),
('89350c8b-6866-4cd2-8411-499ae6b0217b', '764582306137', 'Arta Siregar', 'Jr. Ikan No. 739', 'f290d9f0-3054-11f0-b710-6f28489f2c97', 0, '2025-05-13 23:49:45', '2025-05-13 23:49:45'),
('8ad51178-df4d-4ea6-a88f-8dd71ba9a347', '162842550932', 'Leo Dongoran S.IP', 'Dk. Abang No. 880', 'f290d9f0-3054-11f0-b710-6f28489f2c97', 0, '2025-05-13 23:49:45', '2025-05-13 23:49:45'),
('8c8f03da-689a-4be0-8e18-0844395982a0', '234519682187', 'Kurnia Januar', 'Jr. Muwardi No. 429', 'f290dec0-3054-11f0-9765-e9930fad7a1e', 0, '2025-05-13 23:49:45', '2025-05-13 23:49:45'),
('8ebad65d-2d9c-4068-a0d8-4c5e88881393', '576441735607', 'Wage Tarihoran', 'Kpg. Diponegoro No. 245', 'f290e060-3054-11f0-821c-8924aa5be33c', 0, '2025-05-13 23:49:45', '2025-05-13 23:49:45'),
('9666fe1a-2b0b-45f3-be77-d0fc809239c4', '646133321811', 'Safina Gabriella Novitasari', 'Gg. Jakarta No. 478', 'f290dec0-3054-11f0-9765-e9930fad7a1e', 0, '2025-05-13 23:49:45', '2025-05-13 23:49:45'),
('a44b3322-d4be-4291-9ba1-9bdb12ac8a9b', '513814459768', 'Gilda Safitri M.Farm', 'Dk. Karel S. Tubun No. 757', 'f290e060-3054-11f0-821c-8924aa5be33c', 0, '2025-05-13 23:49:45', '2025-05-13 23:49:45'),
('b937a024-a0ce-4bd3-b709-57a19e406a1d', '727998938376', 'Heru Prabowo M.Kom.', 'Ds. Abdul Muis No. 927', 'f290dec0-3054-11f0-9765-e9930fad7a1e', 0, '2025-05-13 23:49:45', '2025-05-13 23:49:45'),
('baaf06bf-521b-4ddd-a3d7-a884a32a6d44', '452842184990', 'Ulya Ira Kuswandari', 'Psr. Nangka No. 567', 'f290d9f0-3054-11f0-b710-6f28489f2c97', 0, '2025-05-13 23:49:45', '2025-05-13 23:49:45'),
('c32b5391-4bb7-413e-b620-6fb36501f7c8', '132188803645', 'Elon Hutagalung', 'Jln. Raya Ujungberung No. 823', 'f290d9f0-3054-11f0-b710-6f28489f2c97', 0, '2025-05-13 23:49:45', '2025-05-13 23:49:45'),
('c5539fa4-9d94-4061-934e-08e1e2cfc4f0', '344739367804', 'Mariadi Ihsan Wasita S.E.', 'Jln. Villa No. 849', 'f290d9f0-3054-11f0-b710-6f28489f2c97', 0, '2025-05-13 23:49:45', '2025-05-13 23:49:45'),
('c5e66d16-2082-42c0-b8db-99d7e89ac16a', '024064443077', 'Sadina Tina Handayani', 'Psr. Suryo Pranoto No. 460', 'f290d9f0-3054-11f0-b710-6f28489f2c97', 0, '2025-05-13 23:49:45', '2025-05-13 23:49:45'),
('df496f17-c4d7-4b36-ba57-4f3bf9557af1', '913608879220', 'Rendy Budiman', 'Ki. Basket No. 582', 'f290dec0-3054-11f0-9765-e9930fad7a1e', 0, '2025-05-13 23:49:45', '2025-05-13 23:49:45'),
('e3cd16cb-4a3e-441b-825f-ee1ae89811ce', '581998567178', 'Jumari Manullang', 'Dk. Suprapto No. 991', 'f290e060-3054-11f0-821c-8924aa5be33c', 0, '2025-05-13 23:49:45', '2025-05-13 23:49:45'),
('e4194525-2f5c-47e6-a6fd-0b14a2a9cf1a', '301115552594', 'Emil Rajasa M.Pd', 'Jr. Samanhudi No. 68', 'f290d9f0-3054-11f0-b710-6f28489f2c97', 0, '2025-05-13 23:49:45', '2025-05-13 23:49:45'),
('e5cbfe67-67bf-4a01-9166-1b702d28dc77', '982251216157', 'Darijan Dwi Prabowo', 'Ds. Rajawali No. 883', 'f290d9f0-3054-11f0-b710-6f28489f2c97', 0, '2025-05-13 23:49:45', '2025-05-13 23:49:45'),
('e6b7e138-eca5-4d74-b325-54f3d40cdee8', '760419116041', 'Heryanto Prasetya', 'Ki. Cokroaminoto No. 499', 'f290d9f0-3054-11f0-b710-6f28489f2c97', 0, '2025-05-13 23:49:45', '2025-05-13 23:49:45');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_pakets`
--

CREATE TABLE `t_pakets` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_diterima` date DEFAULT NULL,
  `kategori_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `asrama_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `penerima_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pengirim` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `isi_yg_disita` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'diambil,belum',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `app_settings`
--
ALTER TABLE `app_settings`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `core_menus`
--
ALTER TABLE `core_menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `core_menu_abilities`
--
ALTER TABLE `core_menu_abilities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `core_menu_abilities_menu_id_foreign` (`menu_id`);

--
-- Indexes for table `core_privileges`
--
ALTER TABLE `core_privileges`
  ADD PRIMARY KEY (`role_id`,`ability_id`),
  ADD KEY `core_privileges_ability_id_foreign` (`ability_id`);

--
-- Indexes for table `core_roles`
--
ALTER TABLE `core_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `core_users`
--
ALTER TABLE `core_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `core_users_role_id_foreign` (`role_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mst_asramas`
--
ALTER TABLE `mst_asramas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mst_kategori_pakets`
--
ALTER TABLE `mst_kategori_pakets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mst_santris`
--
ALTER TABLE `mst_santris`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mst_santris_asrama_id_foreign` (`asrama_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `t_pakets`
--
ALTER TABLE `t_pakets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `t_pakets_kategori_id_foreign` (`kategori_id`),
  ADD KEY `t_pakets_asrama_id_foreign` (`asrama_id`),
  ADD KEY `t_pakets_penerima_id_foreign` (`penerima_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `core_menu_abilities`
--
ALTER TABLE `core_menu_abilities`
  ADD CONSTRAINT `core_menu_abilities_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `core_menus` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `core_privileges`
--
ALTER TABLE `core_privileges`
  ADD CONSTRAINT `core_privileges_ability_id_foreign` FOREIGN KEY (`ability_id`) REFERENCES `core_menu_abilities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `core_privileges_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `core_roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `core_users`
--
ALTER TABLE `core_users`
  ADD CONSTRAINT `core_users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `core_roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mst_santris`
--
ALTER TABLE `mst_santris`
  ADD CONSTRAINT `mst_santris_asrama_id_foreign` FOREIGN KEY (`asrama_id`) REFERENCES `mst_asramas` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `t_pakets`
--
ALTER TABLE `t_pakets`
  ADD CONSTRAINT `t_pakets_asrama_id_foreign` FOREIGN KEY (`asrama_id`) REFERENCES `mst_asramas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `t_pakets_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `mst_kategori_pakets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `t_pakets_penerima_id_foreign` FOREIGN KEY (`penerima_id`) REFERENCES `mst_santris` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
