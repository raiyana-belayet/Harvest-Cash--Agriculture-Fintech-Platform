-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2025 at 07:56 AM
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
-- Database: `fintech_agri`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'nazmul', '222014037', '2025-04-28 19:09:32');

-- --------------------------------------------------------

--
-- Table structure for table `investments`
--

CREATE TABLE `investments` (
  `id` int(11) NOT NULL,
  `investor_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `investment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','approved','rejected') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `investments`
--

INSERT INTO `investments` (`id`, `investor_id`, `project_id`, `amount`, `investment_date`, `status`) VALUES
(1, 2, 1, 500.00, '2025-03-29 09:46:16', 'approved'),
(2, 2, 2, 300.00, '2025-03-29 09:46:16', 'pending'),
(3, 12, 1, 5000.00, '2025-04-28 23:19:24', 'pending'),
(4, 12, 2, 8000.00, '2025-04-28 23:48:19', 'pending'),
(5, 12, 7, 10000.00, '2025-04-29 00:22:03', 'pending'),
(6, 12, 6, 1500.00, '2025-04-29 00:24:51', 'pending'),
(7, 12, 10, 10000.00, '2025-04-29 05:10:25', 'pending'),
(8, 14, 6, 10000.00, '2025-04-29 05:11:35', 'pending'),
(9, 16, 11, 25000.00, '2025-04-29 05:33:57', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`id`, `email`, `token`, `created_at`) VALUES
(1, 'alice@example.com', '2eebf679d102737c877e389ddb099f0abb05514e2a481b2edccb7a50f3845819', '2025-03-29 09:46:39');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `farmer_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `target_amount` decimal(15,2) DEFAULT NULL,
  `raised_amount` decimal(15,2) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` enum('pending','approved','closed','finished') NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `roi` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `farmer_id`, `title`, `description`, `category`, `target_amount`, `raised_amount`, `start_date`, `end_date`, `status`, `created_at`, `roi`) VALUES
(1, 11, 'Tomato', 'Description', 'Agriculture', 1500.00, 0.00, '2025-04-22', '2025-09-22', 'pending', '2025-04-22 12:02:48', 13.00),
(2, 11, 'asdf', 'asdfsdfasdf', 'Agriculture', 2000.00, 10.00, '2025-04-29', '2025-05-29', '', '2025-04-29 03:18:11', 10.00),
(3, 1, 'Organic Rice Farming', 'A project to grow organic rice.', 'Agriculture', 5000.00, 1000.00, '2025-04-01', '2025-09-30', 'approved', '2025-03-29 15:46:07', 0.00),
(4, 1, 'Dairy Farming Expansion', 'Expanding dairy farm production.', 'Livestock', 8000.00, 2000.00, '2025-05-15', '2025-12-31', 'approved', '2025-03-29 15:46:07', 0.00),
(5, 3, 'sd', 'sdfa', 'Agriculture', 10000.00, 0.00, '2025-04-15', '2025-05-15', 'approved', '2025-04-15 07:57:03', 0.00),
(6, 7, 'PRN', 'Desc', 'Agriculture', 10000.00, 0.00, '2025-04-15', '2025-06-29', 'closed', '2025-04-29 01:57:02', 15.00),
(7, 4, 'Project Test', 'Project Description', 'Agriculture', 100000.00, 0.00, '2025-04-15', '2025-09-15', 'approved', '2025-04-15 08:00:25', 0.00),
(8, 5, 'asdf', 'sadf asdf', 'Agriculture', 456456.00, 0.00, '2025-04-15', '2025-09-15', 'approved', '2025-04-15 10:51:17', 0.00),
(9, 7, 'PRN', 'Desc', 'Agriculture', 10000.00, 0.00, '2025-04-15', '2025-06-29', 'finished', '2025-04-29 01:57:02', 15.00),
(10, 13, 'Noman Tomato', 'Project Description', 'Agriculture', 10000.00, 0.00, '2025-04-29', '2025-07-29', '', '2025-04-29 10:48:15', 15.00),
(11, 15, 'Ahsun Chicken Farm', 'Healthy Chicken', 'Agriculture', 25000.00, 0.00, '2025-04-29', '2025-10-29', '', '2025-04-29 11:28:00', 15.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('farmer','investor') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `balance` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `role`, `created_at`, `balance`) VALUES
(1, 'John Doe', 'john@example.com', 'ef92b778bafe771e89245b89ecbc08a44a4e166c06659911881f383d4473e94f', 'farmer', '2025-03-29 09:45:45', 13000.00),
(2, 'Alice Smith', 'alice@example.com', 'ef92b778bafe771e89245b89ecbc08a44a4e166c06659911881f383d4473e94f', 'investor', '2025-03-29 09:45:45', 6600.00),
(3, 'Michael Admin', 'admin@example.com', '713bfda78870bf9d1b261f565286f85e97ee614efe5f0faf7c34e7ca4f65baca', '', '2025-03-29 09:45:56', 0.00),
(5, 'Ahsun Ahmed Sun', 'ahsun.ahmed.cse@gmail.com', '123456', 'farmer', '2025-04-03 03:13:14', 0.00),
(7, 'Ajker Bangladesh', 'ahsun.ahmed@gmail.com', '$2y$10$Wx/RTphmM6apK5aNk2fyIOj.RYIvZGE7btKYXp8UUIZIDE0Y4J2pC', 'investor', '2025-04-03 04:28:57', 10000.00),
(8, 'Aual Khan', 'aual@gmail.com', '$2y$10$lxTxDsOeh5NSo2QFCitbU.T.Zi5qCkZiEbYee.D6eBTNaAubnBwoe', 'farmer', '2025-04-03 04:39:52', 0.00),
(9, 'Aual Khan', 'aual123@gmail.com', '$2y$10$wjWSL5u7avb19yg8.y4Bf.ee9hVcjaSXKoKROSaTwoI03nDsizLzG', 'farmer', '2025-04-03 04:41:03', 0.00),
(10, 'Ahsun Ahmed Sun', 'ahsun.ahmed.cse@ulab.edu.bd', '$2y$10$Jrp59lBrNxeO6wTeWT4WlOtVGnhuhB5fiMM8.D5XvS2/M3Kdrus.G', 'investor', '2025-04-03 06:37:17', 0.00),
(11, 'Naz', 'mdnazmulhaque0033@gmail.com', '$2y$10$mPBcZwlAOyLERhq0/LdFYO9GEfoJ1kTRUjbgI61kMMGVoVGj8qIka', 'farmer', '2025-04-14 21:13:08', 5023.00),
(12, 'Investor', 'investor@gmail.com', '$2y$10$3WW42SGm7vCi3Di1BSejzepdyjrYIwADzEOiBUydQxGQhJG6lTRLW', 'investor', '2025-04-28 18:35:34', 51500.00),
(13, 'Noman1', 'noman1@gmail.com', '$2y$10$5RDT.UJhK3nOfSHaflZEyed2tPlz47xxkrv10bbRMHdz68lusd1ri', 'farmer', '2025-04-29 00:47:02', 13500.00),
(14, 'Nazmul1', 'nazmul1@gmail.com', '$2y$10$W43AXMqiLU5zpKWY.B.STeALzBFu0q5KqVnpHHfFB1D1LrvSRxyjq', 'investor', '2025-04-29 00:52:38', 40000.00),
(15, 'ahmedsun', 'ahmed@gmail.com', '$2y$10$x7KCjTOLwQxAryy5ncKiMO0hFrXDRO2Z93.p1nVskP/fD7sBMhbo2', 'farmer', '2025-04-29 01:25:57', 1250.00),
(16, 'Shakhawat', 'shakhawat@gmail.com', '$2y$10$SrL0LWxOlm/f3QqfheW3dulFerUV1IJIXbZF34q83RghUt3V8jNFi', 'investor', '2025-04-29 01:29:21', 750.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `investments`
--
ALTER TABLE `investments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `investor_id` (`investor_id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `investments`
--
ALTER TABLE `investments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `investments`
--
ALTER TABLE `investments`
  ADD CONSTRAINT `investments_ibfk_1` FOREIGN KEY (`investor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `investments_ibfk_2` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
