-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2025 at 09:04 PM
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
-- Database: `pim_vi_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`) VALUES
(1, 'Pedro Henrique Nunes Melo', 'mms.p3dro@gmail.com', '$2y$10$CNxf6yDW0pHrx9RyTghxdu69k3guFaMj74S2zZU7.SrX83vaVjfK2', 'user'),
(2, 'Admin', 'admin@admin', '$2y$10$MrNE9Yd6iTHUJ7Fi0k0VXunGm8aIudpVytHrLrr8BRg4TFzgU3Lve', 'admin'),
(3, 'marcelo melo', 'mms.melo@hotmail.com', '$2y$10$LAygD8p01SEPLycBD8s5mO8jYE6JM/Dd6lXD8k0j2JuDJ3S.jmcUm', 'user'),
(5, 'marcelo melo', 'mms@melo', '$2y$10$J511LAKkt376UlHrDEAGE.iW0X0QstgCcMJR23VFgGvYqYcWqTBi.', 'user'),
(6, 'João Gabriel', 'jojo@gmail.com', '$2y$10$y.vbHVqHyexIxjcI06J3AeT/qdT99ik/8mEVYY.hG8X7cN3jpkIGe', 'user'),
(7, 'Carlos Oliveira', 'carlosoliveira123@gmail.com', '$2y$10$l/tmR1g6jIPQrG293JO10OK8uDP2ZABkN6aSAvsdySj.oGQWEDXsu', 'user'),
(8, 'Leonardo', 'lele@gmail.com', '$2y$10$GVtuGDrym5fo/wYsX/F76e9Fd.Tuh/dIH.BPPo6RQaxte3ghCrYoW', 'user'),
(9, 'Pedro Henrique', 'mms.p3droii@gmail.com', '$2y$10$lgmA/gAwcuzY71XHfpgcjOn2TdKrrtsqADQfRDimeO6NZ114Plavm', 'user'),
(10, 'Lucas Andrade Souza', 'lucasandrade@hotmail.com', '$2y$10$W.bOhVD5uMw/lUy3AqRcNO2im7jTRcks2cBHgzq62p5U5s2.kz6gO', 'user'),
(11, 'Gabriel Nunes', 'gabrielnunes@hotmail.com', '$2y$10$aUmbSgznCdYoU1hN7vmanOrXItpOSEQdrrTJE/M81o0KICOkrskgK', 'user'),
(12, 'João Gabriel Nunes', 'joao@gmail.com', '$2y$10$zKhlzCz4oJGXGZHaJy734eSlW7STt7Oa7HPgP/TBgqGUfkCn88dZW', 'user'),
(13, 'Stephany Lisboa Duarte', 'stephany-4409@hotmail.com', '$2y$10$TN1Gvlkzja1rCSW3nOueP.LtCqeqoYW4e0BHKzlHB44/daxqa6ZDi', 'user'),
(14, 'Ana Julia Nunes Melo', 'Nunesmeloanajulia@gmail.com', '$2y$10$zWftb9W2SSpY6FfnqGhjC.ehOx.wN1xmDThtfL1F/Mxicq9fXY2ES', 'user'),
(15, 'Fabiana Nunes de Rezende', 'fabysckott@hotmail.com', '$2y$10$1CxGOnfWdSpvo.JREcMdhOMg9F6AR7scuePs7wtQeJUbsQ648LmBW', 'user'),
(18, 'Marcelo Melo de Souza', 'mms.melo@outlook.com', '$2y$10$JD9twNllRxUKVu.ZkjpTC.X1Ayb//FkCDmQjIUlnlGCRqjlroVOlC', 'user'),
(21, 'Marcelo Melo de Souza II', 'mms.melo2@outlook.com', '$2y$10$DBa.ybMqFeoAqmwV.ZXu2Oz9YzND4VdmVCuMaAgg7DNtBd25zTCSG', 'user'),
(22, 'João Gabriel Nunes de Rezende', 'JoaoGabriel@gmail.com', '$2y$10$NhPzyPuxZ1J1.dV8xaPAqOfSuVZ5/9zYZl2BPPBdKr03fMhiK8W6G', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
