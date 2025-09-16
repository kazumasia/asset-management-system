-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 20, 2024 at 04:00 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pengaduan`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth_activation_attempts`
--

CREATE TABLE `auth_activation_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_groups`
--

CREATE TABLE `auth_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `auth_groups`
--

INSERT INTO `auth_groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'site administrator'),
(2, 'user', 'regular user');

-- --------------------------------------------------------

--
-- Table structure for table `auth_groups_permissions`
--

CREATE TABLE `auth_groups_permissions` (
  `group_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `permission_id` int(11) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `auth_groups_permissions`
--

INSERT INTO `auth_groups_permissions` (`group_id`, `permission_id`) VALUES
(1, 2),
(1, 2),
(2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `auth_groups_users`
--

CREATE TABLE `auth_groups_users` (
  `group_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `auth_groups_users`
--

INSERT INTO `auth_groups_users` (`group_id`, `user_id`) VALUES
(1, 6),
(2, 7),
(2, 9);

-- --------------------------------------------------------

--
-- Table structure for table `auth_logins`
--

CREATE TABLE `auth_logins` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `date` datetime NOT NULL,
  `success` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `auth_logins`
--

INSERT INTO `auth_logins` (`id`, `ip_address`, `email`, `user_id`, `date`, `success`) VALUES
(1, '::1', 'wakanda441@gmail.com', 3, '2023-12-23 09:12:33', 1),
(2, '::1', 'wakanda441@gmail.com', 4, '2023-12-23 09:15:41', 1),
(3, '::1', 'wakanda441@gmail.com', 4, '2023-12-23 09:23:16', 1),
(4, '::1', 'wakanda441@gmail.com', 4, '2023-12-23 09:32:23', 1),
(5, '::1', 'wakanda441@gmail.com', 4, '2023-12-23 09:35:31', 1),
(6, '::1', 'gataumales009@gmail.com', 5, '2023-12-23 09:42:00', 1),
(7, '::1', 'wakanda441@gmail.com', 4, '2023-12-23 09:53:21', 1),
(8, '::1', 'gataumales009@gmail.com', 5, '2023-12-23 09:53:33', 1),
(9, '::1', 'wakanda441@gmail.com', 4, '2023-12-23 10:02:45', 1),
(10, '::1', 'gataumales009@gmail.com', 5, '2023-12-23 10:32:42', 1),
(11, '::1', 'wakanda441@gmail.com', 4, '2023-12-23 10:47:27', 1),
(12, '::1', 'gataumales009@gmail.com', 5, '2023-12-23 13:23:21', 1),
(13, '::1', 'wakanda441@gmail.com', 4, '2023-12-23 13:23:29', 1),
(14, '::1', 'gataumales009@gmail.com', 5, '2023-12-23 13:33:52', 1),
(15, '::1', 'gataumales009@gmail.com', 5, '2023-12-24 08:18:31', 1),
(16, '::1', 'wakanda441@gmail.com', 4, '2023-12-24 08:27:24', 1),
(17, '::1', 'shurakuma', NULL, '2023-12-24 08:28:09', 0),
(18, '::1', 'wakanda441@gmail.com', 4, '2023-12-24 08:28:15', 1),
(19, '::1', 'wakanda441@gmail.com', 4, '2024-01-02 05:32:02', 1),
(20, '::1', 'gataumales009@gmail.com', 5, '2024-01-02 06:36:55', 1),
(21, '::1', 'wakanda441@gmail.com', 4, '2024-01-02 07:20:48', 1),
(22, '::1', 'gataumales009@gmail.com', 5, '2024-01-02 07:42:23', 1),
(23, '::1', 'wakanda441@gmail.com', 4, '2024-01-02 07:49:42', 1),
(24, '::1', 'gataumales009@gmail.com', 5, '2024-01-02 08:08:46', 1),
(25, '::1', 'wakanda441@gmail.com', 4, '2024-01-02 08:13:21', 1),
(26, '::1', 'gataumales009@gmail.com', 5, '2024-01-02 08:14:31', 1),
(27, '::1', 'wakanda441@gmail.com', 4, '2024-01-02 08:16:38', 1),
(28, '::1', 'wakanda441@gmail.com', 4, '2024-01-05 03:09:13', 1),
(29, '::1', 'gataumales009@gmail.com', 5, '2024-01-05 03:11:18', 1),
(30, '::1', 'wakanda441@gmail.com', 4, '2024-01-06 11:37:28', 1),
(31, '::1', 'gataumales009@gmail.com', 5, '2024-01-06 12:19:46', 1),
(32, '::1', 'wakanda441@gmail.com', 4, '2024-01-06 12:37:59', 1),
(33, '::1', 'gataumales009@gmail.com', 5, '2024-01-06 12:45:55', 1),
(34, '::1', 'wakanda441@gmail.com', 4, '2024-01-06 12:49:07', 1),
(35, '::1', 'wakanda441@gmail.com', 4, '2024-01-06 15:56:14', 1),
(36, '::1', 'wakanda441@gmail.com', 4, '2024-01-06 19:50:00', 1),
(37, '::1', 'wakanda441@gmail.com', 4, '2024-01-07 12:43:03', 1),
(38, '::1', 'wakanda441@gmail.com', 4, '2024-01-07 22:38:25', 1),
(39, '::1', 'wakanda441@gmail.com', 4, '2024-01-08 11:45:34', 1),
(40, '::1', 'wakanda441@gmail.com', 4, '2024-01-08 14:27:05', 1),
(41, '::1', 'wakanda441@gmail.com', 4, '2024-01-08 20:09:26', 1),
(42, '::1', 'admin', NULL, '2024-01-08 21:03:50', 0),
(43, '::1', 'adminbps@gmail.com', 6, '2024-01-08 21:03:56', 1),
(44, '::1', 'userBPS@gmail.com', 7, '2024-01-08 21:05:31', 1),
(45, '::1', 'adminbps@gmail.com', 6, '2024-01-08 21:06:40', 1),
(46, '::1', 'adminbps@gmail.com', 6, '2024-01-09 20:09:31', 1),
(47, '::1', 'adminbps@gmail.com', 6, '2024-01-11 11:57:24', 1),
(48, '::1', 'adminbps@gmail.com', 6, '2024-01-11 11:58:02', 1),
(49, '::1', 'adminbps@gmail.com', 6, '2024-02-02 07:16:00', 1),
(50, '::1', 'userBPS@gmail.com', 7, '2024-02-02 07:17:26', 1),
(51, '::1', 'adminbps@gmail.com', 6, '2024-02-02 07:17:47', 1),
(52, '::1', 'userBPS@gmail.com', 7, '2024-02-02 08:17:08', 1),
(53, '::1', 'adminbps@gmail.com', 6, '2024-02-02 08:26:52', 1),
(54, '::1', 'userBPS@gmail.com', 7, '2024-02-02 08:54:31', 1),
(55, '::1', 'adminbps@gmail.com', 6, '2024-02-02 10:16:14', 1),
(56, '::1', 'userBPS@gmail.com', 7, '2024-02-02 14:40:18', 1),
(57, '::1', 'adminbps@gmail.com', 6, '2024-02-10 13:20:49', 1),
(58, '::1', 'adminbps@gmail.com', 6, '2024-02-11 07:42:22', 1),
(59, '::1', 'adminbps@gmail.com', 6, '2024-02-12 07:13:42', 1),
(60, '::1', 'adminbps@gmail.com', 6, '2024-02-13 14:46:50', 1),
(61, '::1', 'userBPS@gmail.com', 7, '2024-02-13 20:21:09', 1),
(62, '::1', 'adminbps@gmail.com', 6, '2024-02-13 20:24:20', 1),
(63, '::1', 'Syahla', NULL, '2024-02-13 20:25:57', 0),
(64, '::1', 'syahla@aziz.com', 8, '2024-02-13 20:26:05', 1),
(65, '::1', 'adminbps@gmail.com', 6, '2024-02-13 20:26:29', 1),
(66, '::1', 'adminbps@gmail.com', 6, '2024-02-14 14:22:49', 1),
(67, '::1', 'admin', NULL, '2024-02-14 21:12:19', 0),
(68, '::1', 'admin', NULL, '2024-02-14 21:12:25', 0),
(69, '::1', 'adminbps@gmail.com', 6, '2024-02-14 21:12:31', 1),
(70, '::1', 'adminbps@gmail.com', 6, '2024-02-16 16:35:33', 1),
(71, '::1', 'adminbps@gmail.com', 6, '2024-02-16 21:26:30', 1),
(72, '::1', 'adminbps@gmail.com', 6, '2024-02-18 16:08:13', 1),
(73, '::1', 'adminbps@gmail.com', 6, '2024-02-19 23:18:13', 1),
(74, '::1', 'adminbps@gmail.com', 6, '2024-02-19 23:18:20', 1),
(75, '::1', 'adminbps@gmail.com', 6, '2024-02-19 23:18:33', 1),
(76, '::1', 'adminbps@gmail.com', 6, '2024-02-19 23:18:51', 1),
(77, '::1', 'admin', NULL, '2024-02-19 23:19:00', 0),
(78, '::1', 'adminbps@gmail.com', 6, '2024-02-19 23:19:11', 1),
(79, '::1', 'adminbps@gmail.com', 6, '2024-02-19 23:19:46', 1),
(80, '::1', 'adminbps@gmail.com', 6, '2024-02-19 23:21:10', 1),
(81, '::1', 'adawd', NULL, '2024-02-19 23:21:13', 0),
(82, '::1', 'adminbps@gmail.com', 6, '2024-02-19 23:21:37', 1),
(83, '::1', 'adminbps@gmail.com', 6, '2024-02-19 23:22:54', 1),
(84, '::1', 'adminbps@gmail.com', 6, '2024-02-19 23:23:12', 1),
(85, '::1', 'adminbps@gmail.com', 6, '2024-02-19 23:23:29', 1),
(86, '::1', 'adminbps@gmail.com', 6, '2024-02-20 19:31:42', 1),
(87, '::1', 'adminbps@gmail.com', 6, '2024-02-20 19:44:40', 1);

-- --------------------------------------------------------

--
-- Table structure for table `auth_permissions`
--

CREATE TABLE `auth_permissions` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `auth_permissions`
--

INSERT INTO `auth_permissions` (`id`, `name`, `description`) VALUES
(1, 'manage-users', 'manage all users'),
(2, 'manage-profile', 'Manage user\'s profile');

-- --------------------------------------------------------

--
-- Table structure for table `auth_reset_attempts`
--

CREATE TABLE `auth_reset_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_tokens`
--

CREATE TABLE `auth_tokens` (
  `id` int(11) UNSIGNED NOT NULL,
  `selector` varchar(255) NOT NULL,
  `hashedValidator` varchar(255) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `expires` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_users_permissions`
--

CREATE TABLE `auth_users_permissions` (
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `permission_id` int(11) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `complaint`
--

CREATE TABLE `complaint` (
  `id` int(5) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nomor_aset` varchar(50) NOT NULL,
  `jenis_aset` varchar(50) NOT NULL,
  `deskripsi` text NOT NULL,
  `lokasi` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Dalam Proses',
  `tanggal_selesai` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `complaint`
--

INSERT INTO `complaint` (`id`, `nama`, `nomor_aset`, `jenis_aset`, `deskripsi`, `lokasi`, `created_at`, `status`, `tanggal_selesai`) VALUES
(16, 'AKAKAKA', 'AD-1234', 'printer', 'adadad', 'Ruang Rapat', '2024-01-18 17:32:08', 'Selesai', '2024-02-12 17:43:55'),
(27, 'akuma', 'as-123', 'monitor', 'asqwda', 'Ruang Rapat', '2024-02-13 15:43:24', 'Selesai', '2024-02-13 20:27:29'),
(29, 'AKAKAKA', 'AD-1234', 'printer', 'qwdeqwdqed', 'al', '2024-03-01 20:15:20', 'Dalam Proses', NULL),
(30, 'akuma', 'AD-1234', 'printer', 'wedqwedqde', 'al', '2024-04-04 20:15:32', 'Selesai', '2024-02-13 20:28:04'),
(31, 'akumaqdwqd', 'AD-1234', 'laptop', 'wdqwdad', 'Ruang Rapat', '2024-05-03 20:15:43', 'Dalam Proses', NULL),
(32, 'akumaqdwqd', 'AD-1234', 'laptop', 'wdqwdad', 'Ruang Rapat', '2024-06-05 20:15:43', 'Dalam Proses', NULL),
(33, 'akumaqdwqd', 'AD-1234', 'laptop', 'wdqwdad', 'Ruang Rapat', '2024-07-18 20:15:43', 'Dalam Proses', NULL),
(34, 'akumaqdwqd', 'AD-1234', 'laptop', 'wdqwdad', 'Ruang Rapat', '2024-08-08 20:15:43', 'Dalam Proses', NULL),
(35, 'akumaqdwqd', 'AD-1234', 'laptop', 'wdqwdad', 'Ruang Rapat', '2024-09-11 20:15:43', 'Dalam Proses', NULL),
(36, 'akumaqdwqd', 'AD-1234', 'laptop', 'wdqwdad', 'Ruang Rapat', '2024-10-15 20:15:43', 'Dalam Proses', NULL),
(37, 'akumaqdwqd', 'AD-1234', 'laptop', 'wdqwdad', 'Ruang Rapat', '2024-11-06 20:15:43', 'Dalam Proses', NULL),
(38, 'akumaqdwqd', 'AD-1234', 'laptop', 'wdqwdad', 'Ruang Rapat', '2024-12-04 20:15:43', 'Dalam Proses', NULL),
(39, 'akumaqdwqd', 'AD-1234', 'laptop', 'wdqwdad', 'Ruang Rapat', '2025-12-18 20:15:43', 'Dalam Proses', NULL),
(41, 'akumaqdwqd', 'AD-1234', 'laptop', 'wdqwdad', 'Ruang Rapat', '2024-02-08 20:15:43', 'Dalam Proses', NULL),
(42, 'akumaqdwqd', 'AD-1234', 'monitor', 'wdqwdad', 'Ruang Rapat', '2024-02-08 20:15:43', 'Dalam Proses', NULL),
(43, 'akuma', 'as-123', 'Televisi', 'adwAs', 'Ruang Rapat', '2024-02-18 18:04:06', 'Dalam Proses', NULL),
(44, 'akuma', 'AD-1234', 'Rumah', 'afnaweifhawdh', 'Ruang Rapat', '2024-02-19 23:37:15', 'Dalam Proses', NULL),
(45, 'akuma', 'AD-1234', 'printer', 'asdqwda', 'Ruang Rapat', '2024-02-20 00:43:14', 'Dalam Proses', NULL),
(46, 'akuma', 'AD-1234', 'printer', 'asdawd', 'Ruang Rapat', '2024-02-20 00:43:34', 'Dalam Proses', NULL),
(47, 'akuma', 'AD-1234', 'printer', 'asdawd', 'Ruang Rapat', '2024-02-20 00:43:34', 'Dalam Proses', NULL),
(48, 'akuma', 'AD-1234', 'printer', 'asdawd', 'Ruang Rapat', '2024-02-20 00:43:34', 'Dalam Proses', NULL),
(49, 'akuma', 'AD-1234', 'printer', 'asdawd', 'Ruang Rapat', '2024-02-20 00:43:34', 'Dalam Proses', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2017-11-20-223112', 'Myth\\Auth\\Database\\Migrations\\CreateAuthTables', 'default', 'Myth\\Auth', 1703319086, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `user_image` varchar(255) NOT NULL DEFAULT 'default.svg',
  `password_hash` varchar(255) NOT NULL,
  `reset_hash` varchar(255) DEFAULT NULL,
  `reset_at` datetime DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL,
  `activate_hash` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `status_message` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `force_pass_reset` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `fullname`, `user_image`, `password_hash`, `reset_hash`, `reset_at`, `reset_expires`, `activate_hash`, `status`, `status_message`, `active`, `force_pass_reset`, `created_at`, `updated_at`, `deleted_at`) VALUES
(6, 'adminbps@gmail.com', 'admin', NULL, 'default.svg', '$2y$10$gZP7KeaN/.B0wawWOsk51uqFO9g8rOxVLPPcQMkNYDfWllrtW4IZi', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2024-01-08 21:03:45', '2024-01-08 21:03:45', NULL),
(7, 'userBPS@gmail.com', 'user', NULL, 'default.svg', '$2y$10$D8iRShk7Jin1EvqrfdeWYO8ECeww4ASHSIzXSzRfum8dbBT7eRhHO', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2024-01-08 21:05:25', '2024-01-08 21:05:25', NULL),
(9, 'wakanda441@gmail.com', 'jokowi', NULL, 'default.svg', '$2y$10$1dGi3IPG2ztSEBUx7p6me.JmsSXwyezcTKGN95QNk8HJ8ANiuRoVW', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2024-02-19 23:21:27', '2024-02-19 23:21:27', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auth_activation_attempts`
--
ALTER TABLE `auth_activation_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_groups`
--
ALTER TABLE `auth_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_groups_permissions`
--
ALTER TABLE `auth_groups_permissions`
  ADD KEY `auth_groups_permissions_permission_id_foreign` (`permission_id`),
  ADD KEY `group_id_permission_id` (`group_id`,`permission_id`);

--
-- Indexes for table `auth_groups_users`
--
ALTER TABLE `auth_groups_users`
  ADD KEY `auth_groups_users_user_id_foreign` (`user_id`),
  ADD KEY `group_id_user_id` (`group_id`,`user_id`);

--
-- Indexes for table `auth_logins`
--
ALTER TABLE `auth_logins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `auth_permissions`
--
ALTER TABLE `auth_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_reset_attempts`
--
ALTER TABLE `auth_reset_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_tokens`
--
ALTER TABLE `auth_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `auth_tokens_user_id_foreign` (`user_id`),
  ADD KEY `selector` (`selector`);

--
-- Indexes for table `auth_users_permissions`
--
ALTER TABLE `auth_users_permissions`
  ADD KEY `auth_users_permissions_permission_id_foreign` (`permission_id`),
  ADD KEY `user_id_permission_id` (`user_id`,`permission_id`);

--
-- Indexes for table `complaint`
--
ALTER TABLE `complaint`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `auth_activation_attempts`
--
ALTER TABLE `auth_activation_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `auth_groups`
--
ALTER TABLE `auth_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `auth_logins`
--
ALTER TABLE `auth_logins`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `auth_permissions`
--
ALTER TABLE `auth_permissions`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `auth_reset_attempts`
--
ALTER TABLE `auth_reset_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `auth_tokens`
--
ALTER TABLE `auth_tokens`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `complaint`
--
ALTER TABLE `complaint`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `auth_groups_permissions`
--
ALTER TABLE `auth_groups_permissions`
  ADD CONSTRAINT `auth_groups_permissions_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `auth_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `auth_groups_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `auth_permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `auth_groups_users`
--
ALTER TABLE `auth_groups_users`
  ADD CONSTRAINT `auth_groups_users_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `auth_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `auth_groups_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `auth_tokens`
--
ALTER TABLE `auth_tokens`
  ADD CONSTRAINT `auth_tokens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `auth_users_permissions`
--
ALTER TABLE `auth_users_permissions`
  ADD CONSTRAINT `auth_users_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `auth_permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `auth_users_permissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
