-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 12, 2024 at 08:22 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `elections`
--

-- --------------------------------------------------------

--
-- Table structure for table `candidate_details`
--

CREATE TABLE `candidate_details` (
  `id` int(11) NOT NULL,
  `election_id` int(11) DEFAULT NULL,
  `candidate_name` varchar(255) DEFAULT NULL,
  `candidate_details` text DEFAULT NULL,
  `candidate_photo` text DEFAULT NULL,
  `inserted_by` varchar(255) DEFAULT NULL,
  `inserted_on` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `candidate_details`
--

INSERT INTO `candidate_details` (`id`, `election_id`, `candidate_name`, `candidate_details`, `candidate_photo`, `inserted_by`, `inserted_on`) VALUES
(2, 2, 'Ali', 'abc', '../assets/images/candidate_photos/43944385300_31936791168web icons-06.png', 'Shoaib', '2022-10-29'),
(3, 2, 'Shoaib', 'xyz', '../assets/images/candidate_photos/54153203372_20775697032web icons-07.png', 'Shoaib', '2022-10-29'),
(15, 12, 'Joseph', 'mku', '../assets/images/candidate_photos/88031844064_848359334051707420140890.jpg', 'Vin', '2024-02-28'),
(16, 12, 'sudi', 'ccc', '../assets/images/candidate_photos/14139222304_599145880841707420140890.jpg', 'Vin', '2024-02-28'),
(17, 13, 'manu', 'ttt', '../assets/images/candidate_photos/1480838335_97551556869convert-jpg-to-word.jpg', 'Vin', '2024-03-26');

-- --------------------------------------------------------

--
-- Table structure for table `database`
--

CREATE TABLE `database` (
  `id_number` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `place_of_birth` varchar(255) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `database`
--

INSERT INTO `database` (`id_number`, `email`, `place_of_birth`, `first_name`, `last_name`, `phone`) VALUES
('39220179', 'olukoyetic467@gmail.com', 'kisii', 'vincent', 'olukoye', '999');

-- --------------------------------------------------------

--
-- Table structure for table `elections`
--

CREATE TABLE `elections` (
  `id` int(11) NOT NULL,
  `election_topic` varchar(255) DEFAULT NULL,
  `no_of_candidates` int(11) DEFAULT NULL,
  `starting_date` date DEFAULT NULL,
  `ending_date` date DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `inserted_by` varchar(255) DEFAULT NULL,
  `inserted_on` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `elections`
--

INSERT INTO `elections` (`id`, `election_topic`, `no_of_candidates`, `starting_date`, `ending_date`, `status`, `inserted_by`, `inserted_on`) VALUES
(2, 'Class Monitor', 2, '2023-12-23', '2023-12-24', 'Expired', 'Vin', '2023-12-23'),
(12, 'Prefect', 2, '2024-02-28', '2024-02-29', 'Expired', 'Vin', '2024-02-28');

-- --------------------------------------------------------

--
-- Table structure for table `otp`
--

CREATE TABLE `otp` (
  `id` int(11) NOT NULL,
  `contact_no` varchar(255) NOT NULL,
  `otp` varchar(6) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `otp`
--

INSERT INTO `otp` (`id`, `contact_no`, `otp`, `created_at`) VALUES
(1, '39220179', '395831', '2024-03-25 21:19:08'),
(2, '39220179', '430989', '2024-03-25 21:24:29'),
(3, '39220179', '708181', '2024-03-25 21:24:34'),
(4, '39220179', '548665', '2024-03-25 21:29:29'),
(5, '39220179', '434721', '2024-03-25 21:30:06'),
(6, '39220179', '435048', '2024-03-25 21:40:35'),
(7, '39220179', '454927', '2024-03-25 21:49:57'),
(8, '39220179', '413807', '2024-03-25 21:51:44'),
(9, '39220179', '115199', '2024-03-25 22:03:51'),
(10, '000', '270165', '2024-03-25 22:04:30'),
(11, '000', '933160', '2024-03-25 22:04:38'),
(12, '000', '317142', '2024-03-25 22:11:58'),
(13, '39220179', '940080', '2024-03-25 22:12:11'),
(14, '39220179', '319038', '2024-03-25 22:13:13'),
(15, '39220179', '776532', '2024-03-25 22:15:32'),
(16, '39220179', '470407', '2024-03-25 22:16:34'),
(17, '39220179', '661332', '2024-03-25 22:17:24'),
(18, '39220179', '838187', '2024-03-25 22:26:58'),
(19, '39220179', '319768', '2024-03-25 22:27:37'),
(20, '39220179', '173477', '2024-03-25 22:28:21'),
(21, '39220179', '640740', '2024-03-26 07:45:22'),
(22, '39220179', '318164', '2024-03-26 07:47:09'),
(23, '39220179', '869465', '2024-03-26 07:58:12'),
(24, '000', '840905', '2024-03-26 08:02:20'),
(25, '000', '191558', '2024-03-26 08:17:49'),
(26, '39220179', '918257', '2024-03-26 08:21:26'),
(27, '000', '240233', '2024-03-26 08:22:14'),
(28, '000', '476502', '2024-03-26 22:56:57'),
(29, '000', '897407', '2024-03-26 22:57:37'),
(30, '000', '473813', '2024-03-26 23:00:15'),
(31, '000', '587445', '2024-04-03 08:15:48'),
(32, '000', '579271', '2024-04-03 08:15:53'),
(33, '39220179', '436424', '2024-04-03 08:20:20'),
(34, '777', '322723', '2024-04-03 08:22:17'),
(35, '777', '841589', '2024-04-03 08:22:56'),
(36, '000', '293444', '2024-04-03 14:41:42');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `contact_no` varchar(45) DEFAULT NULL,
  `password` text DEFAULT NULL,
  `user_role` varchar(45) DEFAULT NULL,
  `user_photo` text DEFAULT NULL,
  `verification_code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `contact_no`, `password`, `user_role`, `user_photo`, `verification_code`) VALUES
(6, 'olukoyevincent433@gmail.com', 'Vin', '000', '8175e3c8753aeb1696959f72ede260ebf3ea14c5', 'Admin', NULL, ''),
(17, '', 'mzing', '777', '8175e3c8753aeb1696959f72ede260ebf3ea14c5', NULL, '../assets/images/user_photos/67838149045_589236771401707420140890.jpg', ''),
(40, '', 'milk', '444', '8175e3c8753aeb1696959f72ede260ebf3ea14c5', NULL, '../assets/images/user_photos/60230361824_12358370326fe6a326-31d0-4407-83f7-618b0f49ac24.jpg', ''),
(47, 'fiverr@gmail.com', 'milke', '555', '8175e3c8753aeb1696959f72ede260ebf3ea14c5', NULL, '../assets/images/user_photos/85559529653_23631991551707420140890.jpg', '');

-- --------------------------------------------------------

--
-- Table structure for table `voter_application`
--

CREATE TABLE `voter_application` (
  `id_number` varchar(20) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `place_of_birth` varchar(255) NOT NULL,
  `contact_no` varchar(20) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `voter_application`
--

INSERT INTO `voter_application` (`id_number`, `first_name`, `last_name`, `email`, `place_of_birth`, `contact_no`, `password`) VALUES
('11111112', 'yosh', 'all', 'yoshgaff@gmail.com', 'Kisumu', '222', '$2y$10$aEUcJwSUDi5/3pG2CeNayeO4jfsa/14xIxs0IeMxoKBKggVL9i9Ou'),
('38220179', 'rose', 'all', 'rose5@gmail.com', 'meru', '111', '$2y$10$cHS2Zylos53urzIMgIG.Ye6dhG/3XmWEn7EaGePb2dJe1I4LF7xVe'),
('39220179', 'vincent', 'olukoye', 'olukoyetic467@gmail.com', 'kisii', '999', '$2y$10$2hhGPVNJ.PLVkHTf9ycFHu3BKVE0OWMa0WS7LR9DAdJDEl.4pISiu');

-- --------------------------------------------------------

--
-- Table structure for table `votings`
--

CREATE TABLE `votings` (
  `id` int(11) NOT NULL,
  `election_id` int(11) DEFAULT NULL,
  `voters_id` int(11) DEFAULT NULL,
  `candidate_id` int(11) NOT NULL,
  `vote_date` date DEFAULT NULL,
  `vote_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `votings`
--

INSERT INTO `votings` (`id`, `election_id`, `voters_id`, `candidate_id`, `vote_date`, `vote_time`) VALUES
(3, 2, 4, 2, '2023-12-23', '09:53:38'),
(4, 2, 5, 3, '2023-12-23', '09:54:05'),
(5, 9, 9, 6, '2024-02-20', '09:13:52'),
(6, 9, 7, 6, '2024-02-20', '04:10:23'),
(7, 9, 10, 6, '2024-02-21', '11:45:39'),
(8, 9, 8, 6, '2024-02-25', '11:15:42'),
(9, 9, 17, 11, '2024-02-27', '06:30:20'),
(10, 11, 17, 14, '2024-02-27', '06:30:42'),
(11, 12, 17, 15, '2024-03-04', '09:56:09'),
(12, 13, 43, 17, '2024-03-26', '06:22:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `candidate_details`
--
ALTER TABLE `candidate_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `database`
--
ALTER TABLE `database`
  ADD PRIMARY KEY (`id_number`);

--
-- Indexes for table `elections`
--
ALTER TABLE `elections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `otp`
--
ALTER TABLE `otp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `voter_application`
--
ALTER TABLE `voter_application`
  ADD PRIMARY KEY (`id_number`);

--
-- Indexes for table `votings`
--
ALTER TABLE `votings`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `candidate_details`
--
ALTER TABLE `candidate_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `elections`
--
ALTER TABLE `elections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `otp`
--
ALTER TABLE `otp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `votings`
--
ALTER TABLE `votings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
