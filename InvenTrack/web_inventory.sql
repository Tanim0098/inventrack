-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 23, 2025 at 04:35 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web_inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id` int NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `kategori_id` int DEFAULT NULL,
  `stok` int DEFAULT '0',
  `satuan` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_deleted` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id`, `nama_barang`, `kategori_id`, `stok`, `satuan`, `created_at`, `updated_at`, `is_deleted`) VALUES
(1, 'Beras Premium', 1, 105, 'Kg', '2025-11-16 07:33:52', '2025-11-23 11:44:44', 1),
(2, 'Minyak Goreng', 1, 15, 'Liter', '2025-11-16 07:33:52', '2025-11-23 11:44:46', 1),
(3, 'Gula Pasir', 1, 4, 'Kg', '2025-11-16 07:33:52', '2025-11-23 11:44:49', 1),
(4, 'Televisi LED 32 Inch', 2, 3, 'Unit', '2025-11-16 07:33:52', '2025-12-23 03:15:24', 0),
(5, 'Beras Merah', 1, 5, 'Kg', '2025-11-17 01:31:00', '2025-11-23 11:40:23', 1),
(7, 'HP Samsung M33', 2, 3, 'Unit', '2025-11-20 02:13:49', '2025-12-23 03:16:40', 0),
(9, 'Mur', 1, 20, 'Pcs', '2025-11-23 12:06:02', '2025-11-23 12:06:02', 0),
(10, 'Sapu', 3, 10, 'Unit', '2025-11-23 12:06:30', '2025-11-23 12:06:30', 0),
(12, 'APD', 5, 10, 'Unit', '2025-11-23 12:07:39', '2025-11-23 12:59:14', 0),
(13, 'Masker Duckbill', 5, 3, 'Box', '2025-11-23 12:07:58', '2025-12-15 01:28:29', 0),
(14, 'Kanebo', 3, 2, 'Unit', '2025-12-15 01:25:58', '2025-12-15 01:27:26', 0),
(15, 'HP Vivo Y12', 2, 5, 'Unit', '2025-12-23 03:15:39', '2025-12-23 03:15:39', 0);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int NOT NULL,
  `nama_kategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `nama_kategori`) VALUES
(1, 'Suku Cadang'),
(2, 'Gadget'),
(3, 'Alat Kebersihan'),
(4, 'Alat Berat'),
(5, 'Alat Keselamatan');

-- --------------------------------------------------------

--
-- Table structure for table `laporan_peminjaman`
--

CREATE TABLE `laporan_peminjaman` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `barang_id` int NOT NULL,
  `jumlah` int NOT NULL,
  `tanggal_pengajuan` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `keterangan` text,
  `status` enum('pending','diterima','ditolak') NOT NULL DEFAULT 'pending',
  `keterangan_tolak` text,
  `tanggal_diterima` datetime DEFAULT NULL,
  `tanggal_ditolak` datetime DEFAULT NULL,
  `admin_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `laporan_peminjaman`
--

INSERT INTO `laporan_peminjaman` (`id`, `user_id`, `barang_id`, `jumlah`, `tanggal_pengajuan`, `keterangan`, `status`, `keterangan_tolak`, `tanggal_diterima`, `tanggal_ditolak`, `admin_id`) VALUES
(7, 5, 14, 3, '2025-12-15 08:27:14', 'sdasdas', 'diterima', NULL, '2025-12-15 08:27:26', NULL, 5),
(8, 10, 13, 2, '2025-12-15 08:28:09', 'asdasdas', 'diterima', NULL, '2025-12-15 08:28:29', NULL, 5),
(9, 5, 7, 2, '2025-12-23 10:15:10', 'Saya mau minjam HP untuk kepentingan recording', 'ditolak', 'Recording pakai camera saja', '2025-12-23 10:16:05', NULL, 5),
(10, 5, 7, 3, '2025-12-23 10:16:34', 'Saya mau meminjam hp untuk keperluan dokumentasi', 'diterima', NULL, '2025-12-23 10:16:40', NULL, 5),
(11, 13, 14, 2, '2025-12-23 10:18:07', 'Saya mau meminjam kanebo untuk keperluan bersih bersih', 'pending', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`) VALUES
(4, 'akusuka', '$2y$10$QoZHIIOAYSb2duLM70yQTOWP5FpXFEQGR.fwuh6QqzEmVToeWTiFS', 'user', '2025-11-19 14:13:37'),
(5, 'admin', '$2y$10$KU5ez.fNJdf6wJ9EuE6kmue/VEKpEbDhzN6LBMlef2Xd1Zyj.N71K', 'admin', '2025-11-19 14:13:37'),
(6, 'user', '$2y$10$vk.GGu2zLMxeu2AjKHuL8e6bTuD8MiaWMV0cXi2heOfgyO0TXbYmW', 'user', '2025-11-19 14:13:37'),
(7, 'asdhasdhga', '$2y$10$Yo3tDnQk70RQKF6MJVXnNugLpVR8AMsMdJcVe1s/oYguImYxW2NPq', 'user', '2025-11-19 14:13:37'),
(8, 'qqq', '$2y$10$OflGrsJbvKaMSDUvs7s0fOAyEITD126s5DBxqG5TZDE51opVYrCJq', 'user', '2025-11-19 14:13:37'),
(10, 'a', '$2y$10$Mz9ShCn.winxMUN6e5jf0ut1ebAgELOtYnc4rGLVpNu5n0tYIeKFO', 'user', '2025-11-22 18:53:26'),
(13, 'hahahaha', '$2y$10$I05Hie0yBGYfOB7SU1o8g.C9BLNmjwuXOXKC3J.Kay/6CefjU5xf.', 'user', '2025-12-23 10:17:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kategori_id` (`kategori_id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `laporan_peminjaman`
--
ALTER TABLE `laporan_peminjaman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `barang_id` (`barang_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `username_2` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `laporan_peminjaman`
--
ALTER TABLE `laporan_peminjaman`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`);

--
-- Constraints for table `laporan_peminjaman`
--
ALTER TABLE `laporan_peminjaman`
  ADD CONSTRAINT `laporan_peminjaman_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `laporan_peminjaman_ibfk_2` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
