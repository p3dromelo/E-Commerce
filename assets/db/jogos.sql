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
-- Table structure for table `jogos`
--

CREATE TABLE `jogos` (
  `id` int(11) NOT NULL,
  `nome` varchar(127) NOT NULL,
  `descricao` varchar(600) NOT NULL,
  `categoria` enum('Ação','Aventura','Battle-Royale','Corrida','Cinematográfico','Esporte','FPS','Indie','Luta','MOBA','RPG','Simulação','Terror') NOT NULL,
  `plataforma` enum('PlayStation','Xbox','Steam') NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `quantidade` int(11) NOT NULL DEFAULT 1,
  `banner_path` varchar(255) NOT NULL,
  `icone_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jogos`
--

INSERT INTO `jogos` (`id`, `nome`, `descricao`, `categoria`, `plataforma`, `preco`, `quantidade`, `banner_path`, `icone_path`) VALUES
(1, 'The Last of Us Part II', 'Experimente o vencedor de mais de 300 prêmios de Jogo do Ano, agora no PC. Descubra a história de Ellie e Abby com melhorias gráficas, modos de jogo como a experiência de sobrevivência roguelike Sem Volta e muito mais.', 'Aventura', 'PlayStation', 349.90, 21, 'uploads/banners/TLOU2.jpg', 'uploads/icones/TLOU2.png'),
(3, 'Detroit: Become Human', 'Detroit: Become Human coloca o destino da humanidade e dos androides em suas mãos. Todas as suas escolhas afetam o resultado do jogo, com uma das narrativas mais intrinsecamente ramificadas já criadas.', 'Cinematográfico', 'PlayStation', 69.50, 3, 'uploads/banners/Detroid Become Human.jpg', 'uploads/icones/Detroid Become Human.png'),
(4, 'Grand Theft Auto: VI', 'Vice City, EUA.\r\nJason e Lucia sempre souberam que a situação estava contra eles. Mas quando uma situação fácil dá errado, eles se veem no lado mais sombrio do lugar mais ensolarado dos Estados Unidos, no meio de uma conspiração criminosa que se espalha pelo estado de Leonida — forçados a depender um do outro mais do que nunca se quiserem sobreviver.', 'Ação', 'Steam', 599.99, 6, 'uploads/banners/GTAVI.png', 'uploads/icones/GTAVI.png'),
(6, 'The Last of Us Part I', 'Descubra o jogo premiado que inspirou a série de TV aclamada pela crítica. Desbrave a América pós-apocalíptica com Joel e Ellie e conheça aliados e inimigos inesquecíveis em The Last of Us™.', 'Aventura', 'PlayStation', 249.90, 7, 'uploads/banners/TLOU1.jpg', 'uploads/icones/TLOU1.png'),
(9, 'Stray', 'Perdido, sozinho e separado da sua família, um gato de rua precisa desvendar um mistério ancestral para fugir de uma cibercidade esquecida e encontrar o caminho para casa.', 'Indie', 'PlayStation', 59.90, 7, 'uploads/banners/Stray.png', 'uploads/icones/Stray.jpg'),
(10, 'Metal Gear Solid V: Phantom Pain', 'Inaugurando uma nova era para a franquia METAL GEAR com tecnologia de ponta alimentada pelo Fox Engine, METAL GEAR SOLID V: The Phantom Pain irá proporcionar aos jogadores uma experiência de jogo de primeira linha com liberdade tática para realizar missões em mundo aberto.', 'Aventura', 'Steam', 13.59, 8, 'uploads/banners/MetalGear.png', 'uploads/icones/MetalGear.jpg'),
(11, 'Horizon Zero Dawn', 'Curta o aclamado Horizon Zero Dawn™ com recursos aprimorados e novos visuais incríveis. Em um futuro distante, dominado por máquinas colossais que vagam pela Terra, a natureza retomou as ruínas da nossa civilização esquecida, e pequenos grupos de sobreviventes se dividem em diferentes tribos.', 'Aventura', 'PlayStation', 49.99, 9, 'uploads/banners/Horzion Zero Dawn.png', 'uploads/icones/Horizon Zero Dawn.png'),
(12, 'The Sims 4', 'Curta o poder de criar e controlar pessoas num mundo virtual onde não há regras. Seja poderoso e livre, divirta-se e jogue com a vida!', 'Simulação', 'Steam', 120.00, 115, 'uploads/banners/The sims 4.jpg', 'uploads/icones/the sims.jpg'),
(14, 'Spider Man Miles Morales', 'Após os eventos de Marvel\'s Spider-Man Remasterizado, o adolescente Miles Morales está se adaptando a um novo lar enquanto segue os passos do seu mentor, Peter Parker. Mas quando uma violenta disputa de forças ameaça destruir seu novo lar, Miles precisa reconhecer e assumir o título de Homem-Aranha.', 'Aventura', 'Steam', 199.90, 6, 'uploads/banners/SpiderMan Miles Morales.png', 'uploads/icones/SpideMan Miles Morales.png'),
(23, 'DOOM: The Dark Ages', 'DOOM: The Dark Ages é a prequela dos aclamados títulos DOOM (2016) e DOOM Eternal que conta a história épica e cinematográfica da origem da fúria de DOOM Slayer. Os jogadores entrarão na pele calejada de DOOM Slayer em uma guerra medieval sinistra, sombria e inédita contra as forças do inferno.', 'FPS', 'Xbox', 249.99, 647, 'uploads/banners/Doom The Dark Ages.jpg', 'uploads/icones/Doom The Dark Ages.png'),
(24, 'DOOM 3', 'Uma invasão demoníaca tomou conta do complexo de pesquisa da Union Aerospace Corporation em Marte. Como um dos sobreviventes, você deve lutar no Inferno e enfrentar uma horda de demônios neste aclamado FPS de horror e ação, uma releitura do DOOM original.', 'FPS', 'PlayStation', 100.00, 6, 'uploads/banners/Doom 3.jpg', 'uploads/icones/Doom 3.png'),
(25, 'A Little to the Left', 'A Little to the Left é um jogo de quebra-cabeças aconchegante, em que você separa, empilha e organiza itens domésticos de forma prazerosa enquanto fica de olho em um gato travesso com um gostinho pela bagunça. Descobrir um quebra-cabeça intuitivo e divertido com mais de 100 bagunças maravilhosos.', 'Indie', 'Steam', 42.99, 3, 'uploads/banners/A Little to the Left.png', 'uploads/icones/A Little to the Left.png'),
(32, 'Star Wars Jedi: Fallen Order', 'Prepare-se para cruzar a galáxia em STAR WARS Jedi: Fallen Order, uma aventura em terceira pessoa cheia de ação da Respawn Entertainment. Um padawan perdido precisa completar seu treinamento, desenvolver novas habilidades com a Força e dominar a arte do sabre de luz.', 'Aventura', 'Xbox', 139.00, 4, 'uploads/banners/Jedi Fallen Order.jpg', 'uploads/icones/Jedi Fallen Order.jpg'),
(34, 'Forza Horizon 5', 'Explore as paisagens vibrantes de mundo aberto do México com diversão e velocidade sem limites com os melhores carros do mundo.', 'Corrida', 'Xbox', 249.00, 99, 'uploads/banners/Forza Horizon.png', 'uploads/icones/Forza Horizon.png'),
(35, 'God of War', 'Com a vingança contra os deuses do Olimpo em um passado distante, Kratos agora vive como um mortal no reino dos deuses e monstros nórdicos. É nesse mundo duro e implacável que ele deve lutar para sobreviver... e ensinar seu filho a fazer o mesmo.', 'Ação', 'PlayStation', 199.90, 120, 'uploads/banners/God Of War.jpg', 'uploads/icones/God Of War.jpg'),
(36, 'God of War Ragnarök', 'Kratos e Atreus embarcam numa viagem mítica em busca de respostas antes da chegada do Ragnarök — agora no PC.', 'Ação', 'Steam', 249.90, 10, 'uploads/banners/GOW Ragnarok.jpg', 'uploads/icones/GOW Ragnarok.jpg'),
(37, 'Elden Ring', 'O NOVO RPG DE AÇÃO E FANTASIA. Levante-se, Maculado, e seja guiado pela graça para portar o poder do Anel Prístino e se tornar um Lorde Prístino nas Terras Intermédias.', 'Ação', 'Xbox', 68.90, 100, 'uploads/banners/Elden Ring.jpg', 'uploads/icones/Elden Ring.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jogos`
--
ALTER TABLE `jogos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jogos`
--
ALTER TABLE `jogos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
