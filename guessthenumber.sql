-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 07, 2026 at 12:49 AM
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
-- Database: `guessthenumber`
--

-- --------------------------------------------------------

--
-- Table structure for table `scores`
--

CREATE TABLE `scores` (
  `id` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `guesses` int(11) NOT NULL,
  `maxGuesses` int(11) NOT NULL,
  `gameWon` tinyint(1) NOT NULL,
  `minNumber` int(11) NOT NULL,
  `maxNumber` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `added` datetime NOT NULL,
  `userId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `scores`
--

INSERT INTO `scores` (`id`, `time`, `guesses`, `maxGuesses`, `gameWon`, `minNumber`, `maxNumber`, `score`, `added`, `userId`) VALUES
(40, 2, 2, 5, 1, 1, 10, 1008, '0000-00-00 00:00:00', 5),
(41, 2, 1, 5, 1, 1, 2, 766, '2026-04-03 01:45:34', 5),
(42, 2, 2, 2, 0, 1, 1000, 0, '2026-04-03 01:54:03', 5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'finn', '$2y$10$keLzjdoPzOronKTTuecMd.yeom4Sg5MUgLhwYuNb43RLqbmtvFkX2'),
(3, 'admin', '$2y$10$CU9y0H0AeOGrmmHlSc5o.usnvwMkJZ5hGqv4A96u7000U9QQoy9OC'),
(4, 'yar', '$2y$10$ds8c3d7CRhCPPrnRxNNI4ON8uIAMKQEMq8I4tyf4jhscmRWYfNKAG'),
(5, 'yarr2', '$2y$10$HtPzf9t77d4o.zSfucvAoujx4ZlE890k6Fs9GzUjXJqa7ddg7/BbW');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `scores`
--
ALTER TABLE `scores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `scores`
--
ALTER TABLE `scores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
