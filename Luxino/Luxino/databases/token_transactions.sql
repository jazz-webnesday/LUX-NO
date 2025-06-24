-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 21, 2025 at 08:25 AM
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
-- Database: `login`
--

-- --------------------------------------------------------

--
-- Table structure for table `token_transactions`
--

CREATE TABLE `token_transactions` (
  `id` int(11) NOT NULL,
  `sender_id` varchar(255) NOT NULL,
  `receiver_id` varchar(255) NOT NULL,
  `token_type` enum('AU','ZNC','NHE') NOT NULL,
  `token_quantity` int(11) NOT NULL,
  `transaction_type` enum('sent','received') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `token_transactions`
--

INSERT INTO `token_transactions` (`id`, `sender_id`, `receiver_id`, `token_type`, `token_quantity`, `transaction_type`, `created_at`) VALUES
(1, '0', 'DYK726514809', 'NHE', 500, 'sent', '2025-06-21 03:19:11'),
(2, 'DYK726514809', 'DYK726514809', 'ZNC', 200, 'sent', '2025-06-21 04:14:44'),
(3, 'DYK726514809', 'DYK726514809', 'ZNC', 200, 'sent', '2025-06-21 04:15:48'),
(4, 'DYK726514809', 'DYK726514809', 'ZNC', 200, 'sent', '2025-06-21 04:16:11'),
(5, 'DYK726514809', 'DYK726514809', 'ZNC', 200, 'sent', '2025-06-21 04:23:07'),
(6, 'DYK726514809', 'DYK726514809', 'ZNC', 200, 'sent', '2025-06-21 04:28:42'),
(7, 'DYK726514809', 'DYK726514809', 'ZNC', 200, 'sent', '2025-06-21 04:28:47'),
(8, 'DYK726514809', '0', 'ZNC', 200, 'sent', '2025-06-21 04:29:09'),
(9, '0', 'DYK726514809', 'NHE', 500, 'sent', '2025-06-21 04:30:07'),
(10, 'DYK726514809', '0', 'NHE', 500, 'sent', '2025-06-21 04:31:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `token_transactions`
--
ALTER TABLE `token_transactions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `token_transactions`
--
ALTER TABLE `token_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
