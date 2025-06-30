-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2025 at 09:03 PM
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
-- Table structure for table `perifericos`
--

CREATE TABLE `perifericos` (
  `id` int(11) NOT NULL,
  `nome` varchar(127) NOT NULL,
  `descricao` text NOT NULL,
  `categoria` enum('Mouse','Teclado','Fone','Headset','Mousepad','Controle') NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `imagem_path` varchar(255) NOT NULL,
  `galeria_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `perifericos`
--

INSERT INTO `perifericos` (`id`, `nome`, `descricao`, `categoria`, `preco`, `quantidade`, `imagem_path`, `galeria_path`) VALUES
(6, 'Wooting60HE+', 'O Wooting 60HE+ possui um layout de 60% e conta com switches Lekker L60. Este teclado oferece aos jogadores um controle sem precedentes sobre seus personagens no jogo, tornando-o um dos teclados preferidos dos jogadores profissionais. Além de sua vantagem competitiva, o 60HE+ foi projetado para ser modificado, permitindo que os entusiastas de teclado o adaptem ao seu gosto.\r\n', 'Teclado', 2159.91, 12, 'uploads/perifericos/wooting1.png', 'uploads/perifericos/wooting2.png'),
(7, 'Viper v3 PRO Faker', 'Experimente um desempenho incomparável no calor da batalha com o mouse sem fio Razer Viper V3 Pro – o predador de ponta entre os mouses sem fio para esportes eletrônicos. Projetado para dominar, o Viper V3 Pro combina leveza com tecnologia de ponta para proporcionar a melhor experiência de jogo competitiva. O Razer HyperPolling Wireless Dongle, já incluso, permite uma taxa de polling de até 8k com seu Viper V3 Pro.', 'Mouse', 2159.91, 7, 'uploads/perifericos/Viper-v3-Faker-1.png', 'uploads/perifericos/Viper-v3-Faker-2.png'),
(8, 'Huntsman v3 Pro Mini', 'Experimente uma resposta inigualável com o Razer Huntsman V3 Pro Mini – White Edition, um teclado 60% equipado com nossos novos switches ópticos analógicos. O acionamento ajustável e o modo de ativação rápida para comandos repetidos ultrarrápidos oferecem a velocidade de que você precisa para vencer. Priorize a última entrada entre duas teclas selecionadas sem ter que liberar a anterior. Desfrute de entradas mais ágeis para mudanças de direção quase instantâneas.\r\n\r\n', 'Teclado', 1709.91, 10, 'uploads/perifericos/Huntsman-V3-1.png', 'uploads/perifericos/Huntsman-V3-1.png'),
(9, 'Pulsar TenZ', 'Pulsar TenZ Signature Edition – Precisão e Velocidade no Mais Alto Nível\r\n\r\nA Pulsar TenZ Signature Edition é o mouse gamer definitivo para quem busca dominar a precisão e a velocidade. Projetado pessoalmente por TenZ, lenda dos eSports e MVP do VCT 2021 Masters Reykjavik, este mouse é uma homenagem ao seu estilo de jogo impecável.', 'Mouse', 1619.91, 11, 'uploads/perifericos/Pulsar-TenZ2.png', 'uploads/perifericos/Pulsar-TenZ1.png'),
(10, 'Finalmouse ULX Prophecy Small', 'Finalmouse ULX Prophecy – O mouse gamer sem fio mais leve e responsivo do mundo\r\n\r\nComemorando 10 anos de inovação revolucionária, o ULX Prophecy da Finalmouse redefine os padrões de desempenho nos eSports. Com peso entre apenas 33 e 38 gramas, este mouse foi projetado para transformar sua experiência de jogo.', 'Mouse', 1979.91, 8, 'uploads/perifericos/prophecy1.png', 'uploads/perifericos/prophecy2.png'),
(11, 'ATK × Aspas RS6 Ultra', 'Same as Aspas\' Tournament Edition Innovative Original Mecha-Syle Design ATK Blazing Wind Magnetic Switch Solution ATK Proprietary Multi-Layer PCB Champion Presets & Music Rhythm Effects Comes with Aspas Custom Transparent Keycaps', 'Teclado', 1581.77, 7, 'uploads/perifericos/ATK Aspas1.webp', 'uploads/perifericos/ATK-Aspas2.png\r\n'),
(12, 'Razer Blackshark v2 PRO', 'RAZER BlackShark V2 Pro — Feito para os Profissionais\r\n\r\nSe os eSports são a sua vocação, atenda ao chamado com o headset sem fio definitivo para jogos competitivos, desenvolvido em colaboração com os maiores atletas do cenário. Criado para performance absoluta, o premiado Razer BlackShark V2 Pro oferece áudio cristalino, isolamento de ruído avançado e conforto prolongado para longas sessões de jogo.', 'Headset', 1889.91, 11, 'uploads/perifericos/Razer-Blackshark-v2-PRO1.png', 'uploads/perifericos/Razer-Blackshark-v2-PRO2.png'),
(14, 'Truthear Crinacle Zero Red', 'Adopt dual polyurethane suspension composite liquid-crystal dome diaphragm N52 Rubidium magnet double-cavity internal magnetic circuit dynamic driver', 'Fone', 503.91, 8, 'uploads/perifericos/Truthear-Crinacle-Zero-Red-1.png\r\n', 'uploads/perifericos/Truthear-Crinacle-Zero-Red-2.png'),
(15, 'Steelseries Arctis Nova 7 Wireless Faze Clan', 'Almighty Audio apresenta o Nova Acoustic System, um design personalizado que oferece a melhor experiência de áudio da categoria para jogos, com drivers de alta fidelidade. Desfrute de uma personalização completa da sua experiência sonora ideal através de um equalizador paramétrico de nível profissional, uma inovação na indústria dos jogos. Principais recursos do produto: Jogos.', 'Headset', 1349.91, 8, 'uploads/perifericos/Steelseries-Arctis-Nova-7.png', 'uploads/perifericos/Steelseries-Arctis-Nova-72.png'),
(16, 'Zowie H-SR-SE', 'Superfície de tecido resistente à umidade e de maior durabilidade, com impressão colorida de alta qualidade.\r\nComfortGlide™: deslizamento suave com controle preciso.\r\nNova base de borracha de alta densidade: equilíbrio perfeito entre estabilidade e conforto.\r\nBordas sem costura: design clean e minimalista.\r\nBase antiderrapante: aderência firme para maior segurança.\r\nDimensões: 500 x 500 mm.', 'Mousepad', 476.91, 11, 'uploads/perifericos/Zowie-H-SR-SE-1.png', 'uploads/perifericos/Zowie-H-SR-SE-2.png'),
(21, 'Scyrox V6 8K', 'O Scyrox V6 é um mouse gamer sem fio ultraleve que leva sua jogabilidade a outro nível. Com uma impressionante taxa de polling de até 8000 Hz, você obtém respostas ultrarrápidas e precisas, garantindo vantagem em partidas intensas.', 'Mouse', 845.91, 11, 'uploads/perifericos/Scyrox-V6(1).png', 'uploads/perifericos/Scyrox-V6(2).png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `perifericos`
--
ALTER TABLE `perifericos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `perifericos`
--
ALTER TABLE `perifericos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
