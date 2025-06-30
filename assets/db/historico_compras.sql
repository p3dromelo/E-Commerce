-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2025 at 09:02 PM
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
-- Table structure for table `historico_compras`
--

CREATE TABLE `historico_compras` (
  `id` int(11) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `tipo_produto` enum('jogo','periferico') NOT NULL,
  `produto_id` int(11) NOT NULL,
  `nome_produto` varchar(255) NOT NULL,
  `plataforma_ou_categoria` varchar(100) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `preco_unitario` decimal(10,2) NOT NULL,
  `metodo_pagamento` varchar(50) NOT NULL,
  `data_compra` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `historico_compras`
--

INSERT INTO `historico_compras` (`id`, `user_email`, `tipo_produto`, `produto_id`, `nome_produto`, `plataforma_ou_categoria`, `quantidade`, `preco_unitario`, `metodo_pagamento`, `data_compra`) VALUES
(1, 'mms.p3dro@gmail.com', 'jogo', 36, 'God of War Ragnarök', 'Steam', 1, 249.90, 'pix', '2025-05-27 09:36:35'),
(2, 'mms.p3dro@gmail.com', 'jogo', 25, 'A Little to the Left', 'Steam', 1, 42.99, 'pix', '2025-05-27 09:48:08'),
(3, 'mms.p3dro@gmail.com', 'jogo', 25, 'A Little to the Left', '', 1, 42.99, 'cartao', '2025-05-27 09:53:22'),
(4, 'mms.p3dro@gmail.com', 'jogo', 3, 'Detroit: Become Human', '', 1, 69.50, 'cartao', '2025-05-27 09:53:22'),
(5, 'mms.p3dro@gmail.com', 'jogo', 36, 'God of War Ragnarök', '', 1, 249.90, 'cartao', '2025-05-27 09:53:22'),
(6, 'mms.p3dro@gmail.com', 'periferico', 10, 'Finalmouse ULX Prophecy Small', '', 1, 1979.91, 'cartao', '2025-05-27 09:56:23'),
(7, 'mms.p3dro@gmail.com', 'periferico', 11, 'ATK × Aspas RS6 Ultra', '', 1, 1581.77, 'cartao', '2025-05-27 09:56:23'),
(8, 'mms.p3dro@gmail.com', 'periferico', 15, 'Steelseries Arctis Nova 7 Wireless Faze Clan', '', 1, 1349.91, 'cartao', '2025-05-27 09:56:23'),
(9, 'mms.p3dro@gmail.com', 'periferico', 14, 'Truthear Crinacle Zero Red', '', 1, 503.91, 'cartao', '2025-05-27 09:56:23'),
(10, 'mms.p3dro@gmail.com', 'jogo', 24, 'DOOM 3', '', 1, 100.00, 'pix', '2025-05-27 10:13:26'),
(11, 'mms.p3dro@gmail.com', 'jogo', 14, 'Spider Man Miles Morales', 'Steam', 4, 199.90, 'pix', '2025-05-27 10:30:01'),
(12, 'JoaoGabriel@gmail.com', 'jogo', 10, 'Metal Gear Solid V: Phantom Pain', '', 2, 13.59, 'cartao', '2025-05-27 10:31:42'),
(13, 'mms.p3dro@gmail.com', 'jogo', 3, 'Detroit: Become Human', '', 1, 69.50, 'pix', '2025-05-29 09:39:04'),
(14, 'mms.p3dro@gmail.com', 'periferico', 6, 'Wooting60HE+', 'Teclado', 1, 2159.91, 'cartao', '2025-05-29 15:47:14'),
(15, 'mms.p3dro@gmail.com', 'jogo', 32, 'Star Wars Jedi: Fallen Order', 'Xbox', 1, 139.00, 'cartao', '2025-05-29 15:47:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `historico_compras`
--
ALTER TABLE `historico_compras`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `historico_compras`
--
ALTER TABLE `historico_compras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
