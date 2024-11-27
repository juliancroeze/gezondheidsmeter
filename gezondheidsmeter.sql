-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 25, 2024 at 11:17 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gezondheidsmeter`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `weight` decimal(5,2) DEFAULT NULL,
  `length` int(11) DEFAULT NULL,
  `bmi` decimal(4,2) DEFAULT NULL,
  `health_score` int(11) DEFAULT NULL,
  `onboarding_complete` tinyint(1) DEFAULT 0,
  `age` int(11) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `is_admin`, `created_at`, `weight`, `length`, `bmi`, `health_score`, `onboarding_complete`, `age`, `gender`) VALUES
(2, 'julian', 'julian@gmail.com', '$2y$10$kU2WkZ1IGlBrDmljKc7GDuGEaD8DCu0WSTlbEOhb2r3bfzY/iQ85K', 0, '2024-11-21 12:39:14', 80.00, 180, 24.69, 70, 1, 19, 'man'),
(3, 'admin', 'admin@gmail.com', '$2y$10$3EIhl3Kw5rV0XiDIlDCLv.uiRJn6L6y9RpIt/bjudELPaP8f0y8sW', 1, '2024-11-21 13:48:38', NULL, NULL, NULL, NULL, 0, NULL, NULL),
(4, 'test', 'test@gmail.com', '$2y$10$ykOzevqtEbmKmzAlaJF/OuiSD7v7VR8PohgQ6hAOx1h0uucxaVeO6', 0, '2024-11-25 09:47:08', NULL, NULL, NULL, NULL, 0, 30, 'man');

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
