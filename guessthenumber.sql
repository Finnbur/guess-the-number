-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 12, 2026 at 11:44 PM
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
  `gamemode` varchar(5) NOT NULL,
  `added` datetime NOT NULL,
  `userId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `scores`
--

INSERT INTO `scores` (`id`, `time`, `guesses`, `maxGuesses`, `gameWon`, `minNumber`, `maxNumber`, `score`, `gamemode`, `added`, `userId`) VALUES
(123, 15, 4, 10, 0, 1, 100, 0, 'rush', '2026-04-12 23:22:44', 1),
(124, 15, 6, 10, 1, 1, 100, 1141, 'rush', '2026-04-12 23:29:35', 1),
(125, 15, 0, 10, 1, 1, 100, 1381, 'rush', '2026-04-12 23:30:29', 1),
(126, 6, 0, 10, 1, 1, 100, 0, 'rush', '2026-04-12 23:32:10', 1),
(127, 15, 5, 10, 1, 1, 100, 0, 'rush', '2026-04-12 23:32:31', 1),
(128, 15, 8, 10, 1, 1, 100, 550, 'rush', '2026-04-12 23:33:27', 1),
(129, 6, 0, 1, 1, 1, 10, 0, 'rush', '2026-04-12 23:43:43', 1);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
