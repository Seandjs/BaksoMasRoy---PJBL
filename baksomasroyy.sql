-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 19, 2025 at 10:43 AM
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
(11, 'paramore', 'paramore@gmail.com', 'ain&#039;t it fun?', 'unread'),
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
(14, 'kara', 'noaa277@gmail.com', '$2y$10$SyUU4KWEJC2Jzxo6lx9dgOhi.U5cheAUW7/55PFRXlNIz42gBSB66');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `amin`
--
ALTER TABLE `amin`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
