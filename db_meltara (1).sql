-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2025 at 11:31 PM
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
-- Database: `db_meltara`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`) VALUES
(1, 'Cake', NULL),
(2, 'Cookies', NULL),
(4, 'Drinks', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `order_number` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `subtotal` decimal(10,2) NOT NULL,
  `shipping_cost` decimal(10,2) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` varchar(50) NOT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_status` enum('Menunggu Verifikasi','Pembayaran Berhasil','Pembayaran Ditolak') NOT NULL DEFAULT 'Menunggu Verifikasi',
  `payment_proof` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_number`, `user_id`, `order_date`, `subtotal`, `shipping_cost`, `total_amount`, `status`, `payment_method`, `payment_status`, `payment_proof`) VALUES
(1, 'BK001', 2, '2025-11-28 19:02:59', 45000.00, 15000.00, 60000.00, 'Confirmed', 'COD', 'Menunggu Verifikasi', NULL),
(2, 'BK002', 3, '2025-11-28 19:02:59', 200000.00, 15000.00, 215000.00, 'Completed', 'Transfer', 'Menunggu Verifikasi', NULL),
(3, 'NA680464705', 6, '2025-12-07 11:43:59', 82000.00, 0.00, 82000.00, '', 'QRIS', 'Menunggu Verifikasi', NULL),
(4, 'NA775341165', 6, '2025-12-07 12:08:59', 56000.00, 0.00, 56000.00, '', 'QRIS', 'Menunggu Verifikasi', NULL),
(5, 'NA246967391', 6, '2025-12-07 12:18:55', 28000.00, 0.00, 28000.00, '', 'QRIS', 'Menunggu Verifikasi', NULL),
(6, 'ORD1765114642', 6, '2025-12-07 13:37:22', 32000.00, 10000.00, 42000.00, '', 'QRIS', 'Menunggu Verifikasi', NULL),
(7, 'ORD1765114777', 6, '2025-12-07 13:39:37', 28000.00, 10000.00, 38000.00, '', 'QRIS', 'Menunggu Verifikasi', NULL),
(8, 'ORD1765116448', 6, '2025-12-07 14:07:28', 54000.00, 10000.00, 64000.00, '', 'QRIS', 'Menunggu Verifikasi', NULL),
(9, 'ORD1765120542', 6, '2025-12-07 15:15:42', 32000.00, 10000.00, 42000.00, '', 'QRIS', 'Menunggu Verifikasi', NULL),
(10, 'ORD1765120975', 6, '2025-12-07 15:22:55', 32000.00, 10000.00, 42000.00, '', 'QRIS', 'Menunggu Verifikasi', NULL),
(11, 'ORD1765121912', 6, '2025-12-07 15:38:32', 32000.00, 10000.00, 42000.00, '', 'QRIS', 'Menunggu Verifikasi', NULL),
(12, 'ORD1765122237', 6, '2025-12-07 15:43:57', 32000.00, 10000.00, 42000.00, '', 'QRIS', 'Menunggu Verifikasi', NULL),
(13, 'ORD1765122261', 6, '2025-12-07 15:44:21', 32000.00, 10000.00, 42000.00, '', 'QRIS', 'Menunggu Verifikasi', NULL),
(14, 'ORD1765123492', 6, '2025-12-07 16:04:52', 28000.00, 10000.00, 38000.00, '', 'QRIS', 'Menunggu Verifikasi', NULL),
(15, 'ORD1765123986', 6, '2025-12-07 16:13:06', 28000.00, 10000.00, 38000.00, 'Confirmed', 'COD', 'Menunggu Verifikasi', NULL),
(16, 'ORD1765125512', 6, '2025-12-07 16:38:32', 32000.00, 10000.00, 42000.00, 'Pending', 'Gopay', 'Menunggu Verifikasi', NULL),
(17, 'ORD1765126100', 6, '2025-12-07 16:48:20', 30000.00, 10000.00, 40000.00, 'Pending', 'Dana', 'Menunggu Verifikasi', NULL),
(18, 'ORD1765128095', 6, '2025-12-07 17:21:35', 40000.00, 10000.00, 50000.00, 'Pending', 'Gopay', 'Menunggu Verifikasi', NULL),
(19, 'ORD1765130928', 6, '2025-12-07 18:08:48', 40000.00, 10000.00, 50000.00, 'Pending', 'Dana', 'Menunggu Verifikasi', NULL),
(20, 'ORD1765147736', 6, '2025-12-07 22:48:56', 36000.00, 10000.00, 46000.00, 'Pending', 'Gopay', 'Menunggu Verifikasi', NULL),
(21, 'ORD1765149519', 6, '2025-12-07 23:18:39', 40000.00, 10000.00, 50000.00, 'Pending', 'Gopay', 'Menunggu Verifikasi', NULL),
(22, 'ORD1765149658', 6, '2025-12-07 23:20:58', 40000.00, 10000.00, 50000.00, 'Pending', 'Gopay', 'Menunggu Verifikasi', NULL),
(23, 'ORD1765163714', 6, '2025-12-08 03:15:14', 32000.00, 10000.00, 42000.00, 'Pending', 'Gopay', 'Menunggu Verifikasi', NULL),
(24, 'ORD1765164011', 6, '2025-12-08 03:20:11', 18000.00, 10000.00, 28000.00, 'Pending', 'Dana', 'Menunggu Verifikasi', NULL),
(25, 'ORD1765168357', 6, '2025-12-08 04:32:37', 119000.00, 10000.00, 129000.00, 'Confirmed', 'COD', 'Menunggu Verifikasi', NULL),
(26, 'ORD1765180574', 7, '2025-12-08 07:56:14', 64000.00, 10000.00, 74000.00, 'Confirmed', 'COD', 'Menunggu Verifikasi', NULL),
(27, 'ORD1765734156', 7, '2025-12-14 17:42:36', 32000.00, 10000.00, 42000.00, 'Confirmed', 'QRIS', 'Menunggu Verifikasi', NULL),
(28, 'ORD1765734272', 7, '2025-12-14 17:44:32', 64000.00, 10000.00, 74000.00, 'Confirmed', 'QRIS', 'Menunggu Verifikasi', NULL),
(29, 'ORD1765734829', 7, '2025-12-14 17:53:49', 32000.00, 10000.00, 42000.00, 'Confirmed', 'COD', 'Menunggu Verifikasi', NULL),
(30, 'ORD1765735039', 1, '2025-12-14 17:57:19', 32000.00, 10000.00, 42000.00, 'Confirmed', 'COD', 'Menunggu Verifikasi', NULL),
(31, 'ORD1765735219', 1, '2025-12-14 18:00:19', 32000.00, 10000.00, 42000.00, 'Confirmed', 'COD', 'Menunggu Verifikasi', NULL),
(32, 'ORD1765735235', 1, '2025-12-14 18:00:35', 32000.00, 10000.00, 42000.00, 'Confirmed', 'COD', 'Menunggu Verifikasi', NULL),
(33, 'ORD1765735601', 7, '2025-12-14 18:06:41', 88000.00, 10000.00, 98000.00, 'Confirmed', 'QRIS', 'Menunggu Verifikasi', NULL),
(34, 'ORD1765735970', 1, '2025-12-14 18:12:50', 32000.00, 10000.00, 42000.00, 'Confirmed', 'COD', 'Menunggu Verifikasi', NULL),
(35, 'ORD1765737475', 1, '2025-12-14 18:37:55', 32000.00, 10000.00, 42000.00, 'Confirmed', 'COD', 'Menunggu Verifikasi', NULL),
(36, 'ORD1765737899', 1, '2025-12-14 18:44:59', 64000.00, 10000.00, 74000.00, '', 'QRIS', 'Menunggu Verifikasi', NULL),
(37, 'ORD1765738131', 1, '2025-12-14 18:48:51', 32000.00, 10000.00, 42000.00, '', 'QRIS', 'Menunggu Verifikasi', NULL),
(38, 'ORD1765738296', 1, '2025-12-14 18:51:36', 80000.00, 10000.00, 90000.00, '', 'QRIS', 'Menunggu Verifikasi', NULL),
(39, 'ORD1765738929', 1, '2025-12-14 19:02:09', 30000.00, 10000.00, 40000.00, 'Pending', 'QRIS', 'Menunggu Verifikasi', NULL),
(40, 'ORD1765739213', 1, '2025-12-14 19:06:53', 28000.00, 10000.00, 38000.00, 'Pending', 'QRIS', 'Menunggu Verifikasi', NULL),
(41, 'ORD1765739345', 1, '2025-12-14 19:09:05', 30000.00, 10000.00, 40000.00, '', 'QRIS', 'Menunggu Verifikasi', NULL),
(42, 'ORD1765739457', 1, '2025-12-14 19:10:57', 30000.00, 10000.00, 40000.00, '', 'QRIS', 'Menunggu Verifikasi', NULL),
(43, 'ORD1765739829', 1, '2025-12-14 19:17:09', 28000.00, 10000.00, 38000.00, '', 'QRIS', 'Menunggu Verifikasi', NULL),
(44, 'ORD1765739956', 1, '2025-12-14 19:19:16', 35000.00, 10000.00, 45000.00, '', 'QRIS', 'Menunggu Verifikasi', NULL),
(45, 'ORD1765740003', 1, '2025-12-14 19:20:03', 30000.00, 10000.00, 40000.00, '', 'QRIS', 'Menunggu Verifikasi', NULL),
(46, 'ORD1765740176', 1, '2025-12-14 19:22:56', 20000.00, 10000.00, 30000.00, '', 'QRIS', 'Menunggu Verifikasi', NULL),
(47, 'ORD1765741333', 1, '2025-12-14 19:42:13', 116000.00, 10000.00, 126000.00, '', 'QRIS', 'Menunggu Verifikasi', NULL),
(48, 'ORD1765741386', 1, '2025-12-14 19:43:06', 30000.00, 10000.00, 40000.00, '', 'QRIS', 'Menunggu Verifikasi', NULL),
(49, 'ORD1765741469', 1, '2025-12-14 19:44:29', 28000.00, 10000.00, 38000.00, '', 'QRIS', 'Menunggu Verifikasi', NULL),
(50, 'ORD1765741631', 1, '2025-12-14 19:47:11', 30000.00, 10000.00, 40000.00, '', 'QRIS', 'Menunggu Verifikasi', NULL),
(51, 'ORD1765741686', 1, '2025-12-14 19:48:06', 30000.00, 10000.00, 40000.00, '', 'QRIS', 'Menunggu Verifikasi', NULL),
(52, 'ORD1765741780', 1, '2025-12-14 19:49:40', 60000.00, 10000.00, 70000.00, '', 'QRIS', 'Menunggu Verifikasi', NULL),
(53, 'ORD1765742089', 1, '2025-12-14 19:54:49', 28000.00, 10000.00, 38000.00, '', 'QRIS', 'Menunggu Verifikasi', NULL),
(54, 'ORD1765742141', 1, '2025-12-14 19:55:41', 18000.00, 10000.00, 28000.00, '', 'QRIS', 'Menunggu Verifikasi', NULL),
(55, 'ORD1765742274', 1, '2025-12-14 19:57:54', 32000.00, 10000.00, 42000.00, '', 'QRIS', 'Menunggu Verifikasi', NULL),
(56, 'ORD1765762294', 7, '2025-12-15 01:31:34', 56000.00, 10000.00, 66000.00, '', 'QRIS', 'Menunggu Verifikasi', NULL),
(57, 'ORD1765762602', 7, '2025-12-15 01:36:42', 32000.00, 10000.00, 42000.00, '', 'QRIS', 'Menunggu Verifikasi', NULL),
(58, 'ORD1765762752', 7, '2025-12-15 01:39:12', 45000.00, 10000.00, 55000.00, '', 'QRIS', 'Menunggu Verifikasi', NULL),
(59, 'ORD1765763019', 7, '2025-12-15 01:43:39', 18000.00, 10000.00, 28000.00, 'Pembayaran Berhasil', 'QRIS', 'Menunggu Verifikasi', NULL),
(60, 'ORD1765763048', 7, '2025-12-15 01:44:08', 30000.00, 10000.00, 40000.00, 'Pembayaran Berhasil', 'QRIS', 'Menunggu Verifikasi', NULL),
(61, 'ORD1765763107', 7, '2025-12-15 01:45:07', 20000.00, 10000.00, 30000.00, 'Pembayaran Berhasil', 'QRIS', 'Menunggu Verifikasi', NULL),
(62, 'ORD1765763221', 7, '2025-12-15 01:47:01', 28000.00, 10000.00, 38000.00, 'Pembayaran Berhasil', 'COD', 'Menunggu Verifikasi', NULL),
(63, 'ORD1765763328', 7, '2025-12-15 01:48:48', 30000.00, 10000.00, 40000.00, 'Pembayaran Berhasil', 'QRIS', 'Menunggu Verifikasi', NULL),
(64, 'ORD1765764395', 7, '2025-12-15 02:06:35', 28000.00, 10000.00, 38000.00, 'Pembayaran Berhasil', 'QRIS', 'Menunggu Verifikasi', NULL),
(65, 'ORD1765764448', 7, '2025-12-15 02:07:28', 30000.00, 10000.00, 40000.00, 'Pembayaran Berhasil', 'QRIS', 'Menunggu Verifikasi', NULL),
(66, 'ORD1765765978', 7, '2025-12-15 02:32:58', 30000.00, 10000.00, 40000.00, 'Dikemas', 'QRIS', '', NULL),
(67, 'ORD1765767837', 7, '2025-12-15 03:03:57', 28000.00, 10000.00, 38000.00, 'Menunggu Konfirmasi', 'QRIS', '', NULL),
(68, 'ORD1765768664', 7, '2025-12-15 03:17:44', 28000.00, 10000.00, 38000.00, 'Menunggu Konfirmasi', 'QRIS', '', NULL),
(69, 'ORD1765768968', 1, '2025-12-15 03:22:48', 32000.00, 10000.00, 42000.00, 'Menunggu Konfirmasi', 'QRIS', '', NULL),
(70, 'ORD1765769404', 1, '2025-12-15 03:30:04', 30000.00, 10000.00, 40000.00, 'Menunggu Konfirmasi', 'QRIS', '', NULL),
(71, 'ORD1765769753', 1, '2025-12-15 03:35:53', 32000.00, 10000.00, 42000.00, 'Menunggu Konfirmasi', 'QRIS', '', NULL),
(72, 'ORD1765770245', 1, '2025-12-15 03:44:05', 18000.00, 10000.00, 28000.00, 'Menunggu Konfirmasi', 'QRIS', '', NULL),
(73, 'ORD1765772297', 1, '2025-12-15 04:18:17', 28000.00, 10000.00, 38000.00, 'Dikemas', 'QRIS', '', NULL),
(74, 'ORD1765773574', 1, '2025-12-15 04:39:34', 28000.00, 10000.00, 38000.00, 'Dikemas', 'QRIS', '', NULL),
(75, 'ORD1765774297', 1, '2025-12-15 04:51:37', 40000.00, 10000.00, 50000.00, 'Dikemas', 'QRIS', '', '1765774297_ff39f12cc4ff69f92d9a.png'),
(76, 'ORD1765774348', 1, '2025-12-15 04:52:28', 28000.00, 10000.00, 38000.00, 'Dikemas', 'QRIS', '', '1765774348_9526ac9bb1c36a39668f.png'),
(77, 'ORD1765775113', 1, '2025-12-15 05:05:13', 32000.00, 10000.00, 42000.00, 'Dikemas', 'QRIS', '', '1765775113_579b945ba79a6e6d68fc.png'),
(78, 'ORD1765775802', 1, '2025-12-15 05:16:42', 32000.00, 10000.00, 42000.00, 'Dikemas', 'QRIS', '', '1765775802_10c050bd640feabfefbe.png'),
(79, 'ORD1765776188', 1, '2025-12-15 05:23:08', 32000.00, 10000.00, 42000.00, 'Dikemas', 'QRIS', '', '1765776188_e115112739271193ff65.png'),
(80, 'ORD1765778545', 7, '2025-12-15 06:02:25', 32000.00, 10000.00, 42000.00, 'Confirmed', 'QRIS', '', NULL),
(81, 'ORD1765779136', 1, '2025-12-15 06:12:16', 28000.00, 10000.00, 38000.00, 'Pending', 'QRIS', '', NULL),
(82, 'ORD1765779532', 1, '2025-12-15 06:18:52', 28000.00, 10000.00, 38000.00, 'Pending', 'QRIS', '', '1765779532_f099e5137afa5365e20b.png'),
(83, 'ORD1765780210', 1, '2025-12-15 06:30:10', 28000.00, 10000.00, 38000.00, 'Cancelled', 'QRIS', '', '1765780210_f7bd2d62f05d6b5672d7.png'),
(84, 'ORD1765785338', 1, '2025-12-15 07:55:38', 28000.00, 10000.00, 38000.00, 'Confirmed', 'QRIS', '', '1765785338_c83306689d40c4e064c3.png'),
(85, 'ORD1765788248', 1, '2025-12-15 08:44:08', 40000.00, 10000.00, 50000.00, 'Confirmed', 'QRIS', 'Menunggu Verifikasi', NULL),
(86, 'ORD1765789428', 1, '2025-12-15 09:03:48', 28000.00, 10000.00, 38000.00, 'Confirmed', 'QRIS', 'Menunggu Verifikasi', NULL),
(87, 'ORD1765791538', 1, '2025-12-15 09:38:58', 28000.00, 10000.00, 38000.00, 'Confirmed', 'QRIS', '', '1765791538_acdaee1833b9d40e6582.png'),
(88, 'ORD1765792672', 7, '2025-12-15 09:57:52', 64000.00, 10000.00, 74000.00, 'Pending', 'QRIS', '', '1765792672_fd7032191e6228d823a0.png'),
(89, 'ORD1765792767', 7, '2025-12-15 09:59:27', 40000.00, 10000.00, 50000.00, 'Confirmed', 'QRIS', '', '1765792767_bb74c5cc17a7a50a055f.png'),
(90, 'ORD1765793975', 7, '2025-12-15 10:19:35', 28000.00, 10000.00, 38000.00, 'Selesai', 'QRIS', '', '1765793975_27fdf7c2adc8a0143d52.png'),
(91, 'ORD1765794249', 7, '2025-12-15 10:24:09', 32000.00, 10000.00, 42000.00, 'Dikemas', 'QRIS', '', '1765794249_9db5d6c2a95c61619ebd.png'),
(92, 'ORD1765794577', 7, '2025-12-15 10:29:37', 32000.00, 10000.00, 42000.00, 'Dikemas', 'QRIS', '', '1765794577_87f8cc5db1b18e9d1859.png'),
(93, 'ORD1765794983', 7, '2025-12-15 10:36:23', 32000.00, 10000.00, 42000.00, 'Dikemas', 'QRIS', '', '1765794983_d490149ebaba8eae2de6.png'),
(94, 'ORD1765795168', 7, '2025-12-15 10:39:28', 28000.00, 10000.00, 38000.00, 'Selesai', 'QRIS', '', '1765795168_2ff76069e1f6d3b5e170.png'),
(95, 'ORD1765795558', 7, '2025-12-15 10:45:58', 40000.00, 10000.00, 50000.00, 'Dikemas', 'QRIS', '', '1765795558_7292e0bb1e87726d9880.png'),
(96, 'ORD1765796256', 7, '2025-12-15 10:57:36', 32000.00, 10000.00, 42000.00, 'Dikemas', 'QRIS', '', '1765796256_94f29be2f000d4a1c3a5.png'),
(97, 'ORD1765796537', 7, '2025-12-15 11:02:17', 28000.00, 10000.00, 38000.00, 'Dikemas', 'QRIS', '', '1765796537_2a1bb64fee67c4fcff38.png'),
(98, 'ORD1765796691', 7, '2025-12-15 11:04:51', 28000.00, 10000.00, 38000.00, 'Dikemas', 'QRIS', '', '1765796691_e24da5fd1f85ae505f6e.png'),
(99, 'ORD1765796739', 7, '2025-12-15 11:05:39', 54000.00, 10000.00, 64000.00, 'Cancelled', 'QRIS', '', '1765796739_7dd015151d612e32d6ae.png'),
(100, 'ORD1765797438', 7, '2025-12-15 11:17:18', 20000.00, 10000.00, 30000.00, 'Dikemas', 'COD', '', NULL),
(101, 'ORD1765797455', 7, '2025-12-15 11:17:35', 28000.00, 10000.00, 38000.00, 'Dikemas', 'QRIS', '', '1765797455_e9be4cc751ab4dd0ff59.png'),
(102, 'ORD1765903160', 8, '2025-12-16 16:39:20', 64000.00, 0.00, 64000.00, 'Pending', 'QRIS', '', '1765903160_42cb77843bfc636ce94e.png'),
(103, 'ORD1765903251', 11, '2025-12-16 16:40:51', 64000.00, 0.00, 64000.00, 'Dikirim', 'QRIS', '', '1765903251_33a7d9d15d84ea02af8b.png');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `unit_price`, `subtotal`) VALUES
(1, 1, 2, 2, 15000.00, 30000.00),
(3, 2, 3, 1, 200000.00, 200000.00),
(4, 3, 1, 2, 32000.00, 64000.00),
(5, 3, 10, 1, 18000.00, 18000.00),
(6, 4, 2, 2, 28000.00, 56000.00),
(7, 5, 2, 1, 28000.00, 28000.00),
(8, 6, 1, 1, 32000.00, 32000.00),
(9, 7, 2, 1, 28000.00, 28000.00),
(10, 8, 10, 2, 18000.00, 36000.00),
(11, 8, 16, 1, 18000.00, 18000.00),
(12, 9, 1, 1, 32000.00, 32000.00),
(13, 10, 1, 1, 32000.00, 32000.00),
(14, 11, 1, 1, 32000.00, 32000.00),
(15, 12, 1, 1, 32000.00, 32000.00),
(16, 13, 1, 1, 32000.00, 32000.00),
(17, 14, 2, 1, 28000.00, 28000.00),
(18, 15, 2, 1, 28000.00, 28000.00),
(19, 16, 1, 1, 32000.00, 32000.00),
(20, 17, 17, 1, 30000.00, 30000.00),
(21, 18, 3, 1, 40000.00, 40000.00),
(22, 19, 3, 1, 40000.00, 40000.00),
(23, 20, 10, 2, 18000.00, 36000.00),
(24, 22, 3, 1, 40000.00, 40000.00),
(25, 23, 1, 1, 32000.00, 32000.00),
(26, 24, 10, 1, 18000.00, 18000.00),
(27, 25, 4, 1, 55000.00, 55000.00),
(28, 25, 1, 2, 32000.00, 64000.00),
(29, 26, 1, 2, 32000.00, 64000.00),
(30, 27, 1, 1, 32000.00, 32000.00),
(31, 28, 1, 2, 32000.00, 64000.00),
(32, 29, 1, 1, 32000.00, 32000.00),
(33, 30, 1, 1, 32000.00, 32000.00),
(34, 31, 1, 1, 32000.00, 32000.00),
(35, 32, 1, 1, 32000.00, 32000.00),
(36, 33, 1, 1, 32000.00, 32000.00),
(37, 33, 2, 2, 28000.00, 56000.00),
(38, 34, 1, 1, 32000.00, 32000.00),
(39, 35, 1, 1, 32000.00, 32000.00),
(40, 36, 1, 2, 32000.00, 64000.00),
(41, 37, 1, 1, 32000.00, 32000.00),
(42, 38, 3, 2, 40000.00, 80000.00),
(43, 39, 11, 1, 30000.00, 30000.00),
(44, 40, 2, 1, 28000.00, 28000.00),
(45, 41, 17, 1, 30000.00, 30000.00),
(46, 42, 6, 1, 30000.00, 30000.00),
(47, 43, 2, 1, 28000.00, 28000.00),
(48, 44, 18, 1, 35000.00, 35000.00),
(49, 45, 6, 1, 30000.00, 30000.00),
(50, 46, 12, 1, 20000.00, 20000.00),
(51, 47, 1, 1, 32000.00, 32000.00),
(52, 47, 2, 3, 28000.00, 84000.00),
(53, 48, 6, 1, 30000.00, 30000.00),
(54, 49, 2, 1, 28000.00, 28000.00),
(55, 50, 17, 1, 30000.00, 30000.00),
(56, 51, 11, 1, 30000.00, 30000.00),
(57, 52, 17, 2, 30000.00, 60000.00),
(58, 53, 2, 1, 28000.00, 28000.00),
(59, 54, 10, 1, 18000.00, 18000.00),
(60, 55, 1, 1, 32000.00, 32000.00),
(61, 56, 8, 2, 28000.00, 56000.00),
(62, 57, 1, 1, 32000.00, 32000.00),
(63, 58, 9, 1, 45000.00, 45000.00),
(64, 59, 10, 1, 18000.00, 18000.00),
(65, 60, 11, 1, 30000.00, 30000.00),
(66, 61, 12, 1, 20000.00, 20000.00),
(67, 62, 2, 1, 28000.00, 28000.00),
(68, 63, 11, 1, 30000.00, 30000.00),
(69, 64, 2, 1, 28000.00, 28000.00),
(70, 65, 11, 1, 30000.00, 30000.00),
(71, 66, 11, 1, 30000.00, 30000.00),
(72, 67, 2, 1, 28000.00, 28000.00),
(73, 68, 2, 1, 28000.00, 28000.00),
(74, 69, 1, 1, 32000.00, 32000.00),
(75, 70, 17, 1, 30000.00, 30000.00),
(76, 71, 1, 1, 32000.00, 32000.00),
(77, 72, 10, 1, 18000.00, 18000.00),
(78, 73, 2, 1, 28000.00, 28000.00),
(79, 74, 2, 1, 28000.00, 28000.00),
(80, 75, 3, 1, 40000.00, 40000.00),
(81, 76, 2, 1, 28000.00, 28000.00),
(82, 77, 1, 1, 32000.00, 32000.00),
(83, 78, 1, 1, 32000.00, 32000.00),
(84, 79, 1, 1, 32000.00, 32000.00),
(85, 80, 1, 1, 32000.00, 32000.00),
(86, 81, 2, 1, 28000.00, 28000.00),
(87, 82, 2, 1, 28000.00, 28000.00),
(88, 83, 2, 1, 28000.00, 28000.00),
(89, 84, 2, 1, 28000.00, 28000.00),
(90, 85, 3, 1, 40000.00, 40000.00),
(91, 86, 2, 1, 28000.00, 28000.00),
(92, 87, 2, 1, 28000.00, 28000.00),
(93, 88, 1, 2, 32000.00, 64000.00),
(94, 89, 3, 1, 40000.00, 40000.00),
(95, 90, 2, 1, 28000.00, 28000.00),
(96, 91, 1, 1, 32000.00, 32000.00),
(97, 92, 1, 1, 32000.00, 32000.00),
(98, 93, 1, 1, 32000.00, 32000.00),
(99, 94, 2, 1, 28000.00, 28000.00),
(100, 95, 3, 1, 40000.00, 40000.00),
(101, 96, 1, 1, 32000.00, 32000.00),
(102, 97, 2, 1, 28000.00, 28000.00),
(103, 98, 2, 1, 28000.00, 28000.00),
(104, 99, 10, 3, 18000.00, 54000.00),
(105, 100, 15, 1, 20000.00, 20000.00),
(106, 101, 2, 1, 28000.00, 28000.00),
(107, 102, 1, 2, 32000.00, 64000.00),
(108, 103, 1, 2, 32000.00, 64000.00);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) DEFAULT 0,
  `gambar` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `stock`, `gambar`, `is_active`) VALUES
(1, 1, 'Blackberry Mousse Cake', 'Nikmati kelembutan setiap lapisan Blackberry Mousse Cake, perpaduan sempurna antara sponge cake vanilla yang lembut dan mousse blackberry yang halus dengan aroma buah beri yang segar. Setiap gigitan menghadirkan sensasi manis, creamy, dan menyegarkan yang memanjakan lidah. Dibalut dengan glaze mengilap dan dihiasi potongan blackberry segar, kue ini tak hanya menggoda rasa tapi juga memanjakan mata — pilihan sempurna untuk hadiah, perayaan, atau sekadar menikmati waktu manis Anda. 💜', 32000.00, 50, '1765027959_b100d1329a0e6845b78f.jpg', 1),
(2, 1, 'Lemon Cheese Mousse Cake', 'Nikmati kelembutan lapisan mousse keju yang ringan berpadu dengan aroma segar lemon yang menggugah selera. Setiap gigitannya menghadirkan kombinasi rasa manis, asam, dan creamy yang menyeimbangkan lidah. Teksturnya yang lembut seolah meleleh di mulut, menghadirkan sensasi segar yang elegan. Dibalut dengan tampilan cantik berwarna lembut, kue ini cocok untuk hidangan spesial atau hadiah manis bagi orang tersayang.', 28000.00, 30, '1765028092_d95da44b29fe4ac6cff6.jpg', 1),
(3, 1, 'Choco Dream Bites', 'Rasakan kelezatan penuh dari potongan brownies cokelat lembut yang kaya rasa dan aroma. Choco Dream Bites dibuat dari cokelat premium dengan tekstur fudgy di dalam dan sedikit renyah di luar. Setiap potongan memberikan sensasi manis yang intens dan memanjakan lidah — cocok untuk semua pencinta cokelat sejati.  Sajikan sebagai dessert manis, teman minum kopi, atau camilan penutup hari yang sempurna.', 40000.00, 10, '1765028104_b46a065441e55bc88db5.jpg', 1),
(4, 2, 'Cloud Nine Cookies', 'Cloud Nine Cookies menghadirkan kelembutan butter cookies berpadu dengan lapisan icing tipis yang manis. Bentuknya yang lucu dan warna lembutnya memberi kesan elegan dan dreamy — seindah rasanya.Teksturnya renyah di luar dan sedikit chewy di tengah, sempurna untuk camilan ringan yang tak terlupakan.', 55000.00, 8, '1765028118_ca640df9a5b00e5a4a22.jpg', 1),
(6, 1, 'Velvet Crinkels', 'Nikmati kelembutan Velvet Crinkles yang meleleh di setiap gigitan — perpaduan sempurna antara tekstur chewy dan cita rasa cokelat pekat yang khas. Dibalut dengan taburan gula halus yang manis, kue ini memberikan sensasi manis yang elegan di lidah.', 30000.00, 25, '1765028134_cfe40e926606d7c992ac.jpg', 1),
(8, 2, 'Crispy Tales', 'Crispy Tales menghadirkan sensasi renyah dan manis dalam setiap kepingan. Dipanggang hingga keemasan dengan potongan cokelat chip yang lumer, menjadikannya camilan sempurna untuk menemani secangkir teh hangat.', 28000.00, 122, '1765028148_e1bb98be8e8f61155981.jpg', 1),
(9, 2, 'Gingerbread Cookies', 'Klasik dan hangat! Gingerbread Cookies ini memiliki aroma rempah yang khas dengan sentuhan manis madu. Dibentuk dengan karakter lucu yang menggemaskan, cocok untuk acara spesial atau musim perayaan.', 45000.00, 14, '1765028161_989a6334c670feca4d16.jpg', 1),
(10, 1, 'Fudge Brownies', 'Kelezatan cokelat murni dalam Fudge Brownies yang lembut dan fudgy. Lapisan atasnya sedikit renyah dengan bagian tengah yang meleleh di mulut. Kaya rasa, manis pas, dan bikin nagih!', 18000.00, 134, '1765028181_dbc7bbda87394053f9f3.jpg', 1),
(11, 1, 'Roll Cake Keju', 'Lembutnya sponge cake berpadu dengan krim lembut dan parutan keju gurih di atasnya. Roll Cake Keju memberikan keseimbangan rasa manis dan asin yang harmonis dalam setiap gigitan.', 30000.00, 56, '1765028200_30369c3d4929db475fe0.jpg', 1),
(12, 1, 'Tart Buah Segar', 'Tart dengan kulit pastry renyah berisi krim lembut dan aneka buah segar pilihan. Setiap potongannya menghadirkan sensasi creamy, manis, dan segar yang memanjakan lidah.', 20000.00, 18, '1765028210_bb0885e8dd9ef77bfe5a.jpg', 1),
(13, 4, 'Citrus Splash', 'Kesegaran lemon dan mentimun berpadu dalam minuman ringan yang menyegarkan. Citrus Splash memberi efek segar seketika, cocok untuk mengembalikan energi di hari yang panas.', 18000.00, 24, '1765028228_c33136e4eb13a6898911.jpg', 1),
(14, 4, 'Caribbean Breeze', 'Perpaduan tropis nan eksotis dari kelapa, nanas, dan sedikit soda yang berkilau. Caribbean Breeze membawa nuansa pantai dan liburan di setiap tegukan.', 20000.00, 12, '1765028252_5088acc4edcf2dd58b66.jpg', 1),
(15, 4, 'Strawberry Lemonade', 'Manisnya stroberi segar berpadu dengan segarnya lemon memberikan keseimbangan rasa asam-manis yang pas. Strawberry Lemonade menghadirkan kesegaran alami yang menenangkan.', 20000.00, 32, '1765028262_5c9a688e0ff471a72cc5.jpg', 1),
(16, 4, 'Ice Cream', 'Kelezatan es krim premium yang creamy dengan potongan biskuit di dalamnya. Dingin, lembut, dan manis sempurna untuk momen manismu kapan saja.', 18000.00, 213, '1765028275_21899bdba4da9ec113d4.jpg', 1),
(17, 1, 'Tart Ceri Segar', 'Cheesecake klasik dengan topping ceri merah segar yang manis-asam. Teksturnya lembut dengan aroma vanila dan rasa keju yang creamy, memberikan pengalaman manis yang elegan', 30000.00, 23, '1765028294_64e05f88a08e8fc045bd.jpg', 1),
(18, 1, 'Buttercream Bliss', 'Kue sponge lembut berlapis krim buttercream yang manis dan lembut, dihiasi potongan buah stroberi segar. Tiap lapisan memberikan sensasi lembut dan manis yang menyatu sempurna. ', 35000.00, 43, '1765028306_a3da9ca7b36f3cd3ece0.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` float DEFAULT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `comment` text DEFAULT NULL,
  `is_approved` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `product_id`, `user_id`, `rating`, `comment`, `is_approved`, `created_at`) VALUES
(1, 2, 2, 4.5, 'Rotinya lembut dan coklatnya enak!', 1, '2025-11-28 19:02:59'),
(2, 3, 3, 5, 'Kue ulang tahun terbaik, recommended!', 1, '2025-11-28 19:02:59'),
(3, 4, 2, 4, 'Cheesecake enak tapi terlalu manis menurut saya.', 1, '2025-11-28 19:02:59'),
(8, 1, 1, 5, 'enakkkk pol', 1, '2025-12-14 18:13:03');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `key_name` varchar(100) NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key_name`, `value`, `description`, `user_id`) VALUES
(1, 'shipping_flat_rate', '15000', NULL, NULL),
(2, 'shipping_free_threshold', '200000', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `shipping_info`
--

CREATE TABLE `shipping_info` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `recipient` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `delivery_status` enum('Dikemas','Dalam Perjalanan','Dikirim','Sampai Tujuan') DEFAULT 'Dikemas'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shipping_info`
--

INSERT INTO `shipping_info` (`id`, `order_id`, `recipient`, `address`, `phone`, `delivery_status`) VALUES
(1, 1, 'Siti Nur', 'Jl. Mawar No. 10, Bandung', '082222111333', 'Dikemas'),
(2, 2, 'Rahman Ali', 'Jl. Kenanga No. 21, Jakarta', '083333222444', 'Dikemas'),
(3, 13, 'Ruina Amour', 'Indonesia', '082170708282', 'Dikemas'),
(4, 14, 'Ruina Amour', 'apaja', '082170708282', 'Dikemas'),
(5, 15, 'Runa', 'Gang Sehat', '082356567832', 'Dikemas'),
(6, 16, 'Ruina', 'hmm', '082170700000', 'Dikemas'),
(7, 17, 'hhh', 'h', '098888281', 'Dikemas'),
(8, 18, 'ggg', 'ffff', '087646435777', 'Dikemas'),
(9, 19, 'hhhhhhh', 'hhhhhhhh', '08987654321', 'Dikemas'),
(10, 20, 'ry', 'dgfhhh', '086542345677', 'Dikemas'),
(11, 22, 'scsd', 'sss', '023892388912', 'Dikemas'),
(12, 23, 'sjjsjj', 'kkkwk', '09182811373', 'Dikemas'),
(13, 24, 'Ruina Amour', 'Indonesia', '082170708282', 'Dikemas'),
(14, 25, 'Rara', 'Dr mansyur', '082345678901', 'Dikemas'),
(15, 26, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', 'Dikemas'),
(16, 27, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', 'Dikemas'),
(17, 28, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', 'Dikemas'),
(18, 29, 'Anya Fish it', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', 'Dikemas'),
(19, 30, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', 'Dikemas'),
(20, 31, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', 'Dikemas'),
(21, 32, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', 'Dikemas'),
(22, 33, 'Megawati', 'Jakarta', '087655432678', 'Dikemas'),
(23, 34, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', 'Dikemas'),
(24, 35, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', 'Dikemas'),
(25, 36, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', ''),
(26, 37, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', ''),
(27, 38, 'Anya roger', 'Surabaya', '087654323456', ''),
(28, 39, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', ''),
(29, 40, 'Wanita idamanmu', 'Bandung', '081234565543', ''),
(30, 41, 'Jennie', 'Seoul', '08213356789', 'Dikemas'),
(31, 42, 'lisa', 'thailand', '085436785543', 'Dikemas'),
(32, 43, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', 'Dikemas'),
(33, 44, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', 'Dikemas'),
(34, 45, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', 'Dikemas'),
(35, 46, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', 'Dikemas'),
(36, 47, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', 'Dikemas'),
(37, 48, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', 'Dikemas'),
(38, 49, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', 'Dikemas'),
(39, 50, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', 'Dikemas'),
(40, 51, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', 'Dikemas'),
(41, 52, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', 'Dikemas'),
(42, 53, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', 'Dikemas'),
(43, 54, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', 'Dikemas'),
(44, 55, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', 'Dikemas'),
(45, 56, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', 'Dikemas'),
(46, 57, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', 'Dikemas'),
(47, 58, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', 'Dikemas'),
(48, 59, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', 'Dikemas'),
(49, 60, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', 'Dikemas'),
(50, 61, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', 'Dikemas'),
(51, 62, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', 'Dikemas'),
(52, 63, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', 'Dikemas'),
(53, 64, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', 'Dikemas'),
(54, 65, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', 'Dikemas'),
(55, 66, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', 'Dikemas'),
(56, 67, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', ''),
(57, 68, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', ''),
(58, 69, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', ''),
(59, 70, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', ''),
(60, 71, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', ''),
(61, 72, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', ''),
(62, 73, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', 'Dikemas'),
(63, 74, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', 'Dikemas'),
(64, 75, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', 'Dikemas'),
(65, 76, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', 'Dikemas'),
(66, 77, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', 'Dikemas'),
(67, 78, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', 'Dikemas'),
(68, 79, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', 'Dikemas'),
(69, 80, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', 'Dikemas'),
(70, 81, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', 'Dikemas'),
(71, 82, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', 'Dikemas'),
(72, 83, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', 'Dikemas'),
(73, 84, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', 'Dikemas'),
(74, 85, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', 'Dikemas'),
(75, 86, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', 'Dikemas'),
(76, 87, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', 'Dikemas'),
(77, 88, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', 'Dikemas'),
(78, 89, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', 'Dikirim'),
(79, 90, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', ''),
(80, 91, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', 'Dikemas'),
(81, 92, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', 'Dikemas'),
(82, 93, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', 'Dikemas'),
(83, 94, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', ''),
(84, 95, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', 'Dikemas'),
(85, 96, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', 'Dikemas'),
(86, 97, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', 'Dikemas'),
(87, 98, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', 'Dikemas'),
(88, 99, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', 'Dikemas'),
(89, 100, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', 'Dikemas'),
(90, 101, 'Alya Syahrani', 'l. Almamater No.1, Padang Bulan, Kecamatan Medan Baru, Kota Medan.', '089508262486', 'Dikemas'),
(91, 102, 'sasa', 'jl waru', '082123312049', 'Dikemas'),
(92, 103, 'sasa', 'jl waru', '082123312049', 'Dikirim');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Customer','Admin') DEFAULT 'Customer',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin Toko', 'admin@bakery.com', '12345', 'Admin', '2025-11-28 19:02:59', NULL, NULL),
(2, 'Siti Nur', 'siti@gmail.com', 'password123', 'Customer', '2025-11-28 19:02:59', NULL, NULL),
(3, 'Rahman Ali', 'rahman@gmail.com', 'password123', 'Customer', '2025-11-28 19:02:59', NULL, NULL),
(4, '', 'admin1@gmail.com', '$2y$10$LHrCndn8BXgBTMdmVIrEgOB5XNIu96NxxQRhAy4.P6xp15u6pIGFO', 'Customer', '2025-12-04 02:59:33', '2025-12-04 03:13:02', NULL),
(5, '', 'fadel.dizwara@gmail.com', '$2y$10$tD7cKC6q08Qw2iq8RU6TMO0uQEKUIrPP5G.qfs57Zbd/s6rARhvLS', 'Admin', '2025-12-06 12:36:47', '2025-12-06 12:36:47', NULL),
(6, '', 'renamangunsong@gmail.com', '$2y$10$hGNMZ79ct46bkmdptnOlCec8B7r0FIujTZJF/9EA5LkumwZDEt2.m', 'Customer', '2025-12-07 10:57:23', '2025-12-07 10:57:23', NULL),
(7, '', 'alyasyahrani154@gmail.com', '$2y$10$6noJORfi5B5W.Qb6qVvyGuySeL0Qv9mrPyGle0Kk2OTWmRpjolS5K', 'Customer', '2025-12-08 07:55:35', '2025-12-08 07:55:35', NULL),
(8, '', 'alyasyahrani448@gmail.com', '$2y$10$WycjRUBVIh4hz0rSi08iNO0eNngvGU7TyM9B3d1cq.EbuQA/r/8fK', 'Customer', '2025-12-11 01:35:31', '2025-12-11 01:35:31', NULL),
(9, '', 'alya@gmail.com', '$2y$10$NKx5NbNewBsrroqgvWPF1exl.PooPRrCD5BuLK/hxrPjC8cDJOgdq', 'Customer', '2025-12-11 01:37:50', '2025-12-11 01:37:50', NULL),
(10, '', 'wawa@gmail.com', '$2y$10$Vw5WwVYNwlko9vj.PSM2nO0stkwmtvYLA9HShwfDtC6U8O8KnMdzS', 'Customer', '2025-12-14 18:19:44', '2025-12-14 18:19:44', NULL),
(11, 'sasatruth', 'asya.gbdst@gmail.com', '$2y$10$RK122t9ZJtXBq5cE43D4VeXVzkpseUnzw..9Y3v1n5oHG7vryFqh6', 'Customer', '2025-12-16 16:40:11', '2025-12-16 16:40:11', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_number` (`order_number`),
  ADD KEY `orders_ibfk_1` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_ibfk_1` (`order_id`),
  ADD KEY `order_items_ibfk_2` (`product_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_ibfk_1` (`category_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_ibfk_1` (`product_id`),
  ADD KEY `reviews_ibfk_2` (`user_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `key_name` (`key_name`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `shipping_info`
--
ALTER TABLE `shipping_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_id` (`order_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `shipping_info`
--
ALTER TABLE `shipping_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `shipping_info`
--
ALTER TABLE `shipping_info`
  ADD CONSTRAINT `shipping_info_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
