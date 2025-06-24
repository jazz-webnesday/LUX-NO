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
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `type` enum('cash in','Withdraw Money','Bought Tokens') NOT NULL,
  `tokens` int(11) NOT NULL,
  `pesos` int(11) NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`id`, `email`, `type`, `tokens`, `pesos`, `created_at`) VALUES
(1, 'm.jazzz.07@gmail.com', 'Bought Tokens', 1000, 2500, '2025-06-20'),
(2, 'm.jazzz.07@gmail.com', 'Bought Tokens', 500, 999, '2025-06-20'),
(3, 'm.jazzz.07@gmail.com', '', 2500, 1250, '2025-06-20'),
(4, 'm.jazzz.07@gmail.com', '', 200, 100, '2025-06-20'),
(5, 'm.jazzz.07@gmail.com', 'Withdraw Money', 200, 100, '2025-06-20'),
(6, 'm.jazzz.07@gmail.com', 'Bought Tokens', 200, 699, '2025-06-20'),
(7, 'm.jazzz.07@gmail.com', 'Bought Tokens', 1000, 2500, '2025-06-20'),
(8, 'm.jazzz.07@gmail.com', 'Bought Tokens', 200, 699, '2025-06-20'),
(9, 'm.jazzz.07@gmail.com', 'Bought Tokens', 200, 699, '2025-06-21'),
(10, 'm.jazzz.07@gmail.com', 'Bought Tokens', 200, 699, '2025-06-21'),
(11, 'm.jazzz.07@gmail.com', 'Bought Tokens', 200, 699, '2025-06-21'),
(12, 'm.jazzz.07@gmail.com', 'Bought Tokens', 200, 699, '2025-06-21'),
(13, 'm.jazzz.07@gmail.com', 'Bought Tokens', 1000, 2500, '2025-06-21'),
(14, 'm.jazzz.07@gmail.com', 'Bought Tokens', 1000, 2500, '2025-06-21'),
(15, 'm.jazzz.07@gmail.com', 'Bought Tokens', 500, 999, '2025-06-21'),
(16, 'm.jazzz.07@gmail.com', 'Bought Tokens', 500, 999, '2025-06-21'),
(17, 'm.jazzz.07@gmail.com', 'Bought Tokens', 500, 999, '2025-06-21'),
(18, 'm.jazzz.07@gmail.com', 'Bought Tokens', 1000, 2500, '2025-06-21'),
(19, 'm.jazzz.07@gmail.com', 'Bought Tokens', 1000, 2500, '2025-06-21'),
(20, 'oo@gmail.com', 'Bought Tokens', 200, 699, '2025-06-21'),
(21, 'm.jazzz.07@gmail.com', 'Bought Tokens', 200, 699, '2025-06-21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
