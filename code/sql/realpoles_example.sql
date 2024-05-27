-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 27, 2024 at 08:47 PM
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
-- Database: `realpoles`
--

-- --------------------------------------------------------

--
-- Table structure for table `polls`
--

CREATE TABLE `polls` (
  `poll_id` int(10) NOT NULL,
  `question` varchar(255) NOT NULL,
  `north_ans` text NOT NULL,
  `south_ans` text NOT NULL,
  `created_by` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `polls`
--

INSERT INTO `polls` (`poll_id`, `question`, `north_ans`, `south_ans`, `created_by`) VALUES
(1, 'What is the better standard?', 'SSE', 'Webhooks', 1),
(2, 'Katero pivo je boljse?', 'Lasko', 'Union', 1),
(3, 'Trieste is?', 'Slovenian', 'Italian', 1),
(4, 'Tea with or without milk?', 'with', 'without', 1),
(5, 'What is the superior dish?', 'Štruklji', 'Beans-on-toast', 2),
(6, 'Correct way to make Cedevita?', 'water-first', 'cedevita-first', 2),
(7, 'Who\'s your favourite?', 'Pogacar', 'Roglic', 2),
(8, 'What is the better city?', 'Ljubljana', 'Prague', 6);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(10) NOT NULL,
  `username` varchar(16) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`) VALUES
(1, 'bwjordan', '$2y$10$yrZ5weumm7g4T2WOnfdr.Oygtp0jmFxtbWBoiJ1KQMTGmVRMPmfb.'),
(2, 'user1', '$2y$10$uLIQJstWlL0Z.68GFGfN/.Isyv3t/mwek2yz7EPjWLvAjEBzKGwvi'),
(3, 'user2', '$2y$10$TzkEncx/r0iTZK8mq0Dv7uEMqLlHN53bZ1t/O0laKkseQoKoHFaw6'),
(4, 'user3', '$2y$10$GFin/vx7lMdG9ImTycxg1eDScPsaIe8NC2UFlmFEu/l7hZ4wWCyDW'),
(5, 'user4', '$2y$10$hlAyaA5a8SNlb0Bf.fJjv.tdYwCnI4j4tinZGhfsXNJDmCTXect/y'),
(6, 'user5', '$2y$10$e7qwvay9oDq4AjN5otfFE.BhE.MQuSoPGCX7Q0.wDQ0XKel9MrD8W');

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE `votes` (
  `vote_id` int(10) NOT NULL,
  `poll_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `vote` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `votes`
--

INSERT INTO `votes` (`vote_id`, `poll_id`, `user_id`, `vote`) VALUES
(1, 4, 2, 1),
(2, 1, 3, 1),
(3, 2, 3, 1),
(4, 3, 3, 1),
(5, 5, 3, 0),
(6, 4, 3, 1),
(7, 7, 3, 1),
(8, 6, 3, 1),
(9, 1, 4, 1),
(10, 2, 4, 0),
(11, 3, 4, 0),
(12, 4, 4, 1),
(13, 5, 4, 0),
(14, 6, 4, 0),
(15, 7, 4, 0),
(16, 1, 5, 0),
(17, 2, 5, 0),
(18, 4, 5, 1),
(19, 3, 5, 1),
(20, 6, 5, 1),
(21, 5, 5, 0),
(22, 7, 5, 1),
(23, 8, 1, 1),
(24, 1, 6, 1),
(25, 2, 6, 1),
(26, 3, 6, 1),
(27, 4, 6, 0),
(28, 5, 6, 0),
(29, 6, 6, 1),
(30, 7, 6, 1),
(31, 6, 1, 0),
(32, 5, 1, 0),
(33, 7, 1, 1),
(34, 1, 2, 0),
(35, 2, 2, 1),
(36, 3, 2, 1),
(37, 8, 2, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `polls`
--
ALTER TABLE `polls`
  ADD PRIMARY KEY (`poll_id`),
  ADD KEY `polls_ibfk_1` (`created_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`vote_id`),
  ADD KEY `votes_ibfk_1` (`poll_id`),
  ADD KEY `votes_ibfk_2` (`user_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `polls`
--
ALTER TABLE `polls`
  ADD CONSTRAINT `polls_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `votes`
--
ALTER TABLE `votes`
  ADD CONSTRAINT `votes_ibfk_1` FOREIGN KEY (`poll_id`) REFERENCES `polls` (`poll_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `votes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
