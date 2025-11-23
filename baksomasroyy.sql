-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 23, 2025 at 07:16 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `baksomasroyy`
--

-- --------------------------------------------------------

--
-- Table structure for table `amin`
--

CREATE TABLE `amin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `amin`
--

INSERT INTO `amin` (`id`, `username`, `password`) VALUES
(1, 'kara', '$2y$10$pRhVoZXgLeZ4.NCGlzDeruNEtb1JqsvYRRtnYtu0U42emvvG8ebGO');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `order_code` varchar(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `outlet` varchar(255) NOT NULL,
  `metode` varchar(30) NOT NULL,
  `total_harga` int(11) NOT NULL,
  `tanggal` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_code`, `user_id`, `outlet`, `metode`, `total_harga`, `tanggal`) VALUES
(20, 'ORD-1790', 14, 'Cabang Sawotratap Aloha - Gedangan, Sidoarjo', 'cod', 50000, '2025-11-23 11:41:56'),
(21, 'ORD-1310', 14, 'Cabang Sawotratap Aloha - Gedangan, Sidoarjo', 'cod', 35000, '2025-11-23 11:42:31'),
(22, 'ORD-1982', 15, 'Cabang Merr - Sukolilo, Surabaya', 'qris', 5000, '2025-11-23 11:43:58'),
(23, 'ORD-1626', 15, 'Cabang Merr - Sukolilo, Surabaya', 'qris', 5000, '2025-11-23 11:46:47'),
(24, 'ORD-1663', 15, 'Cabang Dukuh Kupang - Sawahan, Surabaya', 'qris', 5000, '2025-11-23 11:47:13'),
(31, 'ORD-1067', 14, 'Cabang Dukuh Kupang - Sawahan, Surabaya', 'qris', 45000, '2025-11-23 11:56:15'),
(32, 'ORD-965', 14, 'Cabang Merr - Sukolilo, Surabaya', 'qris', 15000, '2025-11-23 12:30:58');

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL,
  `harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_detail`
--

INSERT INTO `order_detail` (`id`, `order_id`, `product_id`, `nama`, `qty`, `harga`) VALUES
(5, 20, 32, 'Bakso Campur', 2, 25000),
(6, 21, 33, 'Gorengan', 1, 15000),
(7, 21, 34, 'Es Teh', 2, 5000),
(8, 21, 35, 'Lontong', 2, 5000),
(9, 22, 34, 'Es Teh', 1, 5000),
(10, 23, 34, 'Es Teh', 1, 5000),
(11, 24, 34, 'Es Teh', 1, 5000),
(14, 28, 32, 'Bakso Campur', 1, 25000),
(15, 30, 32, 'Bakso Campur', 1, 25000),
(16, 31, 32, 'Bakso Campur', 1, 25000),
(17, 31, 33, 'Gorengan', 1, 15000),
(18, 31, 34, 'Es Teh', 1, 5000),
(19, 32, 33, 'Gorengan', 1, 15000);

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `kategori` varchar(255) NOT NULL,
  `harga` int(11) NOT NULL,
  `deskripsi` text NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `nama`, `kategori`, `harga`, `deskripsi`, `image`) VALUES
(32, 'Bakso Campur', 'Makanan', 25000, 'Ready bakso campur 1 kasar 1 tahu bakso 2 bakso kotak 2 bakso halus', 'uploads/gorengan.jpg'),
(33, 'Gorengan', 'Makanan', 15000, 'Seporsi Gorengan isi 5 dengan ukuran yang besar dan rasa yang enak', 'uploads/bakeso.jpg'),
(34, 'Es Teh', 'Minuman', 5000, 'Teh manis segar dengan es batu', 'uploads/essteh.jpeg'),
(35, 'Lontong', 'Makanan', 5000, '1 Lontong panjang besar dan lezat', 'uploads/lontong.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `ulasan`
--

CREATE TABLE `ulasan` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `ulasan` text NOT NULL,
  `status` enum('unread','read') DEFAULT 'unread'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ulasan`
--

INSERT INTO `ulasan` (`id`, `username`, `email`, `ulasan`, `status`) VALUES
(8, 'the rock', 'therockband@gmail.com', 'hancur hatiku, mengenang dikau', 'read'),
(10, 'echo', 'echo@gmail.com', 'aku cinta kau dan dia', 'read'),
(11, 'paramore', 'paramore@gmail.com', 'ain&#039;t it fun?', 'read'),
(12, 'sean_ddd', 'adasd@gmail.com', '!@#$%^*()', 'unread'),
(16, 'azkaasukaara', 'noaa277@gmail.com', 'azka sayang ara', 'unread'),
(17, 'Kara', 'noaa277@gmail.com', '2edd', 'unread');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`) VALUES
(14, 'Kara', 'ezuuna@gmail.com', '$2y$10$ZZhEmWBz4U1BH.2ezOIv8ObKzMaKN0ovIWbMSb6ezhu6BvqflJlw6'),
(15, 'sasa', 'abraham.azka217@smk.belajar.id', '$2y$10$SLOjxuf8DKmix6GirF1y3uOxSOmSJ1JBCl0Lr4bTkccqK6ijOMdE.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `amin`
--
ALTER TABLE `amin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ulasan`
--
ALTER TABLE `ulasan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `amin`
--
ALTER TABLE `amin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `ulasan`
--
ALTER TABLE `ulasan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `order_detail_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_detail_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `produk` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
