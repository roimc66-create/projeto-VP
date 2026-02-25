-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 24/02/2026 às 23:53
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `vpstreet_ti19`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbgeneros`
--

CREATE TABLE `tbgeneros` (
  `id_genero` int(11) NOT NULL,
  `nome_genero` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `tbgeneros`
--

INSERT INTO `tbgeneros` (`id_genero`, `nome_genero`) VALUES
(1, 'Masculino'),
(2, 'Feminino'),
(3, 'infatil');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbmarcas`
--

CREATE TABLE `tbmarcas` (
  `id_marca` int(11) NOT NULL,
  `nome_marca` varchar(15) NOT NULL,
  `imagem_marca` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `tbmarcas`
--

INSERT INTO `tbmarcas` (`id_marca`, `nome_marca`, `imagem_marca`) VALUES
(1, 'Adidas', 'adidas-logo.svg'),
(2, 'Nike', 'nike-logo.svg'),
(3, 'Crocs', 'crocs-logo.svg'),
(4, 'Jordan', 'jordan-marca.svg'),
(5, 'Newbalance', 'Newbalence-logo.svg'),
(6, 'Puma', 'pumaaa.png'),
(7, 'Vans', 'VANS-logo.png'),
(8, 'Tesla', 'TESLA-logo.webp'),
(9, 'Mizuno', 'MIZUNO-logo.jpg'),
(10, 'Asics', 'asics-logo.svg');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbprodutos`
--

CREATE TABLE `tbprodutos` (
  `id_produto` int(11) NOT NULL,
  `id_marca_produto` int(11) DEFAULT NULL,
  `id_genero_produto` int(11) NOT NULL,
  `id_tipo_produto` int(11) NOT NULL,
  `nome_produto` varchar(100) NOT NULL,
  `resumo_produto` varchar(1000) DEFAULT NULL,
  `valor_produto` decimal(9,2) DEFAULT NULL,
  `imagem_produto` varchar(50) DEFAULT NULL,
  `promoção_produto` enum('Pro','Não') NOT NULL,
  `sneakers_produto` enum('Sne','Not') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `tbprodutos`
--

INSERT INTO `tbprodutos` (`id_produto`, `id_marca_produto`, `id_genero_produto`, `id_tipo_produto`, `nome_produto`, `resumo_produto`, `valor_produto`, `imagem_produto`, `promoção_produto`, `sneakers_produto`) VALUES
(1, 6, 1, 1, 'PUMA INHALE X A$AP ROCKY', 'Modelo de visual agressivo, com design inspirado nos anos 2000. Mistura materiais robustos com cores chamativas e detalhes esportivos que dão um ar futurista.', 1000.99, 'puma-promocao.webp', 'Pro', 'Not'),
(2, 4, 1, 1, 'AIR JORDAN 1 OG', 'Clássico absoluto do basquete. Construção tradicional em couro, visual retrô e acabamento premium, perfeito para quem gosta de estilo autêntico e versátil.', 1299.00, 'jordan-1-promocao.webp', 'Pro', 'Sne'),
(3, 6, 1, 1, 'PUMA LAFRANCÉ', 'Tênis de edição especial com design moderno e elegante. Combina materiais leves, tons sofisticados e o padrão característico da collab, trazendo estilo e conforto.', 2099.99, 'puma-lafrance-promocao.webp', 'Pro', 'Sne'),
(4, 6, 1, 1, 'PUMA MOSTRO', 'Icônico e ousado, conhecido pelo solado dentado e pela silhueta futurista. Mistura moda, esporte e um visual diferenciado que se destaca em qualquer look.', 1199.99, 'puma-2-promocao.webp', 'Pro', 'Not'),
(5, 4, 1, 1, 'AIR JORDAN 5', 'Modelo marcante com língua refletiva e solado translúcido. Inspirado em jatos de caça, traz um visual esportivo e cheio de personalidade.', 1399.99, 'air-jordan-promocao.webp', 'Pro', 'Not'),
(6, 4, 2, 1, 'Tênis Air Jordan 1 Low Feminino', 'Clássico e elegante, combina couro macio e silhueta baixa para um visual versátil. Perfeito para quem gosta de estilo clean com toque esportivo.', 1099.99, 'air-jordan-exclusivo.webp', 'Pro', 'Not'),
(7, 4, 2, 1, 'Tênis Nike A One Run Low Feminino', 'Modelo moderno com linhas fluidas e destaque no rosa vibrante. Leve, confortável e estiloso, ideal para quem quer um visual futurista e cheio de personalidade.', 899.99, 'nike-rosa-exclusivo.webp', 'Pro', 'Not'),
(8, 2, 1, 1, 'Tênis Nike Shox Tl Low Masculino', 'Design icônico com sistema Shox de amortecimento total. Durável, moderno e com visual agressivo, ideal para quem busca conforto e estilo marcante no dia a dia.', 1399.99, 'nikeshox-exclusivo.webp', 'Não', 'Sne'),
(9, 8, 1, 1, 'Coil', 'O Tesla Coil traz um visual marcante com identidade street e acabamento premium. Seu design robusto combina cabedal resistente com detalhes modernos, garantindo conforto e durabilidade para o dia a dia.', 450.00, 'tenis tesla.png', 'Não', 'Not'),
(10, 8, 2, 1, 'Hearts Black Art', 'O tenis TESLA HERTS BLACK ART Com design futurista e atitude urbana, o Tesla Hertz Black Art combina visual all-black com detalhes artísticos que elevam o estilo a outro nível.', 600.00, 'vans preto e branco.png', 'Não', 'Not'),
(11, 7, 2, 1, 'Knu Skool', 'O Vans Knu Skool é um tênis que mistura o espírito clássico do skate dos anos 90 com um toque moderno e urbano. Inspirado no icônico Old Skool, ele repagina o visual retrô com detalhes mais robustos e volumosos', 350.00, '2121141545454512651132.png', 'Não', 'Not'),
(12, 8, 1, 1, 'Delux Snake', 'O Tesla Deluxe Snack entrega um visual ousado com pegada street premium. Com design moderno e detalhes exclusivos, ele mistura estilo urbano com conforto de alto nível.', 900.00, 'tesla deluxe (1).png', 'Não', 'Not'),
(13, 7, 1, 1, 'Ultrarange', 'Tênis Vans Ultrarange em preto com detalhes brancos, combinando visual esportivo e urbano. O cabedal em material têxtil respirável oferece leveza e conforto, enquanto a entressola em EVA garante amortecimento macio.', 450.00, 'vans direita.png', 'Não', 'Not'),
(14, 7, 1, 1, 'UltraRange EXO', 'O Vans UltraRange EXO combina visual esportivo com a identidade clássica da Vans. O cabedal em mesh respirável com reforços sintéticos garante leveza, ventilação e durabilidade para o dia a dia', 700.00, 'vans zaul.png', 'Não', 'Not'),
(15, 5, 1, 1, 'Arctic Grey', 'O New Balance Arctic Grey combina design moderno com o clássico conforto da marca. Com cabedal em tons de cinza claro (arctic grey), o modelo traz um visual minimalista e versátil, fácil de combinar com qualquer estilo.', 980.00, 'tenis_invertido_branco.jpg', 'Não', 'Not'),
(16, 5, 1, 1, 'New Balance 530', 'Os tênis New Balance combinam conforto, qualidade e design atemporal. Com foco em amortecimento, ajuste preciso e materiais duráveis, são ideais tanto para atividades esportivas quanto para o dia a dia.', 1100.00, 'tenis2_invertido_branco_suave.jpg', 'Não', 'Not'),
(17, 5, 1, 1, ' V2 Arctic Grey', 'O New Balance V2 Arctic Grey une conforto e estilo em um design moderno e versátil. Com cabedal em tons de cinza (arctic grey), o modelo entrega um visual clean e urbano, ideal para o dia a dia', 750.00, 'tenis3_invertido_branco_suave.jpg', 'Não', 'Not'),
(18, 9, 1, 1, 'Wave ', 'Chama atenção pelo design moderno e estrutura robusta. Sua entressola com tecnologia Wave proporciona excelente absorção de impacto e firmeza a cada passada.', 1250.00, 'tenis4_invertido_branco_suave.jpg', 'Não', 'Not'),
(19, 9, 2, 1, 'Mizuno Wave (linha running)', 'O Mizuno Wave combina performance e estilo em um design moderno totalmente preto. Com cabedal em mesh respirável, oferece leveza e ventilação durante o uso, enquanto o solado com tecnologia Softier Foam garante amortecimento macio e confortável a cada passo.', 790.00, '51YZDrKHs4L._AC_SY575_.jpg', 'Não', 'Not'),
(20, 9, 2, 1, 'Pro 8 ', 'O Mizuno Wave Prophecy Pro 8 combina tecnologia e design futurista para máximo conforto e desempenho. Com a exclusiva placa Wave, oferece excelente amortecimento, estabilidade e resposta a cada passada.', 1300.00, 'mizuno_pro8_final.jpg', 'Não', 'Not'),
(21, 3, 2, 2, 'Classic Rainbow', 'O Crocs Classic Rainbow traz um visual vibrante e cheio de personalidade, combinando conforto extremo com um design colorido em degradê arco-íris.', 350.00, '81n9W7BCldL._AC_SX575_.jpg', '', ''),
(22, 3, 1, 2, 'Simpsons', 'A Crocs dos Simpsons combina o conforto clássico da Crocs com o humor e a irreverência da família mais famosa da TV. Com design divertido e inspirado na série, ela é perfeita para fãs que querem destacar o visual com personalidade e muito conforto no dia a dia.', 600.00, 'crocs_simpson_invertido.jpg', 'Não', 'Not'),
(23, 1, 1, 1, 'Adi 2000', 'O Adidas ADI 2000 traz de volta a estética marcante dos anos 2000, unindo inspiração no skate, design robusto e conforto para o uso diário. Um tênis com identidade forte, ideal para quem curte estilo urbano e atitude autêntica.', 850.00, 'ChatGPT Image 24 de fev. de 2026, 19_26_54.png', '', ''),
(24, 1, 2, 1, ' Grand Court 2.0', 'Tênis Adidas preto com design clássico e versátil, perfeito para o dia a dia. Possui cabedal em material sintético resistente, com as icônicas três listras brancas nas laterais que garantem o visual autêntico da marca.', 350.00, '41FPN9XTj2L._AC_SY695_.jpg', 'Não', 'Not'),
(25, 1, 1, 2, 'Adilette 22', 'O Chinelo Adidas Adilette 22 combina design futurista com conforto extremo. Inspirado em formas orgânicas, ele oferece leveza, amortecimento macio e estilo moderno, sendo perfeito para o dia a dia e momentos de descanso.', 400.00, '6dc78f67-4132-49d7-a10d-38686077e529.png', 'Não', 'Not'),
(26, 10, 1, 1, 'Artic', 'O ASICS une tradição em performance com um visual moderno e urbano. Inspirado nos modelos clássicos de corrida, ele oferece conforto, amortecimento eficiente e um design robusto.', 600.00, 'ChatGPT Image 24 de fev. de 2026, 19_36_12.png', 'Não', 'Not'),
(27, 10, 2, 1, 'Black Edition', 'Apresenta um visual robusto e moderno, com forte inspiração nos clássicos da corrida. Com design imponente, acabamento premium e excelente amortecimento, é a escolha ideal para quem busca conforto', 700.00, 'ChatGPT Image 24 de fev. de 2026, 19_38_25.png', 'Não', 'Not'),
(28, 10, 1, 1, 'Court FF', 'Foi desenvolvido para alto desempenho nas quadras, oferecendo estabilidade, amortecimento e resposta rápida em cada movimento. Com design moderno e estrutura reforçada, ele garante conforto', 1100.00, 'ChatGPT Image 24 de fev. de 2026, 19_40_45.png', 'Não', 'Not'),
(29, 3, 1, 2, 'Minecraft', 'A Crocs do Minecraft une conforto icônico com o universo criativo do jogo mais famoso do mundo. Com design temático e cheio de detalhes inspirados no Minecraft, ela é perfeita para fãs que querem estilo', 500.00, 'ChatGPT Image 24 de fev. de 2026, 19_44_37.png', 'Não', 'Not'),
(30, 2, 2, 1, 'Court Vision', 'Tênis Nike branco com design clássico e clean, ideal para compor looks versáteis no dia a dia. Confeccionado em material sintético de alta qualidade com acabamento texturizado, ele traz o icônico Swoosh nas laterais que garante autenticidade ao modelo.', 450.00, '61oZve9XmvL._AC_SY695_.jpg', 'Não', 'Not'),
(31, 2, 2, 1, ' Free Metcon 6', 'Nike Free Metcon 6 é o equilíbrio perfeito entre flexibilidade e estabilidade para treinos intensos. Com cabedal leve e respirável, ele garante conforto durante todo o uso, enquanto a tecnologia Free na entressola proporciona movimentos naturais e maior liberdade nos pés.', 1300.00, '61k1omhPUnL._AC_SY575_.jpg', 'Não', 'Not'),
(32, 2, 1, 1, 'Air VaporMax Plus', 'Nike Air VaporMax Plus traz um visual marcante com tecnologia de ponta, combinando estilo urbano com máximo conforto. Com cabedal em material leve e ajustável, ele se adapta perfeitamente aos pés, enquanto a icônica estrutura lateral oferece suporte e design moderno.', 1500.00, '717OUXQ4C-L._AC_SY575_.jpg', 'Não', 'Not');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbproduto_tamanho`
--

CREATE TABLE `tbproduto_tamanho` (
  `id_produto` int(11) NOT NULL,
  `id_tamanho` int(11) NOT NULL,
  `estoque` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `tbproduto_tamanho`
--

INSERT INTO `tbproduto_tamanho` (`id_produto`, `id_tamanho`, `estoque`) VALUES
(1, 1, 10),
(1, 2, 10),
(1, 3, 10),
(1, 4, 10),
(1, 5, 10),
(1, 6, 10),
(1, 7, 10),
(2, 1, 10),
(2, 2, 10),
(2, 3, 10),
(2, 4, 10),
(2, 5, 10),
(2, 6, 10),
(2, 7, 10),
(3, 1, 10),
(3, 2, 10),
(3, 3, 10),
(3, 4, 10),
(3, 5, 10),
(3, 6, 10),
(3, 7, 10),
(4, 1, 10),
(4, 2, 10),
(4, 3, 10),
(4, 4, 10),
(4, 5, 10),
(4, 6, 10),
(4, 7, 10),
(5, 1, 10),
(5, 2, 10),
(5, 3, 10),
(5, 4, 10),
(5, 5, 10),
(5, 6, 10),
(5, 7, 10),
(6, 1, 10),
(6, 2, 10),
(6, 3, 10),
(6, 4, 10),
(6, 5, 10),
(6, 6, 10),
(6, 7, 10),
(7, 1, 10),
(7, 2, 10),
(7, 3, 10),
(7, 4, 10),
(7, 5, 10),
(7, 6, 10),
(7, 7, 10),
(8, 1, 10),
(8, 2, 10),
(8, 3, 10),
(8, 4, 10),
(8, 5, 10),
(8, 6, 10),
(8, 7, 10),
(9, 1, 10),
(9, 2, 10),
(9, 3, 10),
(9, 4, 10),
(9, 5, 10),
(9, 6, 10),
(9, 7, 10),
(10, 1, 10),
(10, 2, 10),
(10, 3, 10),
(10, 4, 10),
(10, 5, 10),
(10, 6, 10),
(10, 7, 10),
(11, 1, 10),
(11, 2, 10),
(11, 3, 10),
(11, 4, 10),
(11, 5, 10),
(11, 6, 10),
(11, 7, 10),
(12, 1, 10),
(12, 2, 10),
(12, 3, 10),
(12, 4, 10),
(12, 5, 10),
(12, 6, 10),
(12, 7, 10),
(13, 1, 10),
(13, 2, 10),
(13, 3, 10),
(13, 4, 10),
(13, 5, 10),
(13, 6, 10),
(13, 7, 10),
(14, 1, 10),
(14, 2, 10),
(14, 3, 10),
(14, 4, 10),
(14, 5, 10),
(14, 6, 10),
(14, 7, 10),
(15, 1, 10),
(15, 2, 10),
(15, 3, 10),
(15, 4, 10),
(15, 5, 10),
(15, 6, 10),
(15, 7, 10),
(16, 1, 10),
(16, 2, 10),
(16, 3, 10),
(16, 4, 10),
(16, 5, 9),
(16, 6, 10),
(16, 7, 10),
(17, 1, 10),
(17, 2, 10),
(17, 3, 10),
(17, 4, 10),
(17, 5, 10),
(17, 6, 10),
(17, 7, 10),
(18, 1, 10),
(18, 2, 10),
(18, 3, 10),
(18, 4, 10),
(18, 5, 10),
(18, 6, 10),
(18, 7, 10),
(19, 1, 10),
(19, 2, 10),
(19, 3, 10),
(19, 4, 10),
(19, 5, 10),
(19, 6, 10),
(19, 7, 10),
(20, 1, 9),
(20, 2, 10),
(20, 3, 10),
(20, 4, 10),
(20, 5, 10),
(20, 6, 10),
(20, 7, 10),
(21, 1, 10),
(21, 2, 10),
(21, 3, 10),
(21, 4, 10),
(21, 5, 10),
(21, 6, 10),
(21, 7, 10),
(22, 1, 10),
(22, 2, 10),
(22, 3, 10),
(22, 4, 10),
(22, 5, 10),
(22, 6, 10),
(22, 7, 10),
(23, 1, 10),
(23, 2, 10),
(23, 3, 10),
(23, 4, 10),
(23, 5, 10),
(23, 6, 10),
(23, 7, 10),
(24, 1, 10),
(24, 2, 10),
(24, 3, 10),
(24, 4, 10),
(24, 5, 10),
(24, 6, 10),
(24, 7, 10),
(25, 1, 10),
(25, 2, 10),
(25, 3, 10),
(25, 4, 10),
(25, 5, 10),
(25, 6, 10),
(25, 7, 10),
(26, 1, 10),
(26, 2, 10),
(26, 3, 10),
(26, 4, 10),
(26, 5, 10),
(26, 6, 10),
(26, 7, 10),
(27, 1, 10),
(27, 2, 10),
(27, 3, 10),
(27, 4, 10),
(27, 5, 10),
(27, 6, 10),
(27, 7, 10),
(28, 1, 10),
(28, 2, 10),
(28, 3, 10),
(28, 4, 10),
(28, 5, 10),
(28, 6, 10),
(28, 7, 10),
(29, 1, 10),
(29, 2, 10),
(29, 3, 10),
(29, 4, 10),
(29, 5, 10),
(29, 6, 10),
(29, 7, 10),
(30, 1, 10),
(30, 2, 10),
(30, 3, 10),
(30, 4, 10),
(30, 5, 10),
(30, 6, 10),
(30, 7, 10),
(31, 1, 10),
(31, 2, 10),
(31, 3, 10),
(31, 4, 10),
(31, 5, 10),
(31, 6, 10),
(31, 7, 10),
(32, 1, 10),
(32, 2, 10),
(32, 3, 10),
(32, 4, 10),
(32, 5, 10),
(32, 6, 10),
(32, 7, 10);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbtamanhos`
--

CREATE TABLE `tbtamanhos` (
  `id_tamanho` int(11) NOT NULL,
  `numero_tamanho` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `tbtamanhos`
--

INSERT INTO `tbtamanhos` (`id_tamanho`, `numero_tamanho`) VALUES
(1, '34'),
(2, '35'),
(3, '36'),
(4, '37'),
(5, '38'),
(6, '39'),
(7, '40'),
(9, 'G'),
(10, 'GG'),
(8, 'M');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbtipos`
--

CREATE TABLE `tbtipos` (
  `id_tipo` int(11) NOT NULL,
  `nome_tipo` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `tbtipos`
--

INSERT INTO `tbtipos` (`id_tipo`, `nome_tipo`) VALUES
(1, 'Tenis'),
(2, 'Chinelo'),
(3, 'Camisa');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbusuarios`
--

CREATE TABLE `tbusuarios` (
  `id_usuario` int(11) NOT NULL,
  `login_usuario` varchar(30) NOT NULL,
  `senha_usuario` varchar(8) NOT NULL,
  `nivel_usuario` enum('admin','user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `tbusuarios`
--

INSERT INTO `tbusuarios` (`id_usuario`, `login_usuario`, `senha_usuario`, `nivel_usuario`) VALUES
(1, 'paulo', '1234', 'admin'),
(2, 'rocha', '1234', 'user'),
(3, 'gabriel', '1234', 'admin');

-- --------------------------------------------------------

--
-- Estrutura stand-in para view `vw_tbprodutos`
-- (Veja abaixo para a visão atual)
--
CREATE TABLE `vw_tbprodutos` (
`id_produto` int(11)
,`id_marca_produto` int(11)
,`id_genero_produto` int(11)
,`id_tipo_produto` int(11)
,`nome_tipo` varchar(15)
,`nome_marca` varchar(15)
,`nome_genero` varchar(15)
,`imagem_marca` varchar(50)
,`nome_produto` varchar(100)
,`resumo_produto` varchar(1000)
,`valor_produto` decimal(9,2)
,`imagem_produto` varchar(50)
,`promoção_produto` enum('Pro','Não')
,`sneakers_produto` enum('Sne','Not')
,`id_tamanho` int(11)
,`numero_tamanho` varchar(10)
,`estoque` int(11)
);

-- --------------------------------------------------------

--
-- Estrutura para view `vw_tbprodutos`
--
DROP TABLE IF EXISTS `vw_tbprodutos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_tbprodutos`  AS SELECT `p`.`id_produto` AS `id_produto`, `p`.`id_marca_produto` AS `id_marca_produto`, `p`.`id_genero_produto` AS `id_genero_produto`, `p`.`id_tipo_produto` AS `id_tipo_produto`, `t`.`nome_tipo` AS `nome_tipo`, `m`.`nome_marca` AS `nome_marca`, `i`.`nome_genero` AS `nome_genero`, `m`.`imagem_marca` AS `imagem_marca`, `p`.`nome_produto` AS `nome_produto`, `p`.`resumo_produto` AS `resumo_produto`, `p`.`valor_produto` AS `valor_produto`, `p`.`imagem_produto` AS `imagem_produto`, `p`.`promoção_produto` AS `promoção_produto`, `p`.`sneakers_produto` AS `sneakers_produto`, `ta`.`id_tamanho` AS `id_tamanho`, `ta`.`numero_tamanho` AS `numero_tamanho`, `pt`.`estoque` AS `estoque` FROM (((((`tbprodutos` `p` join `tbgeneros` `i` on(`p`.`id_genero_produto` = `i`.`id_genero`)) join `tbmarcas` `m` on(`p`.`id_marca_produto` = `m`.`id_marca`)) join `tbtipos` `t` on(`p`.`id_tipo_produto` = `t`.`id_tipo`)) left join `tbproduto_tamanho` `pt` on(`pt`.`id_produto` = `p`.`id_produto`)) left join `tbtamanhos` `ta` on(`ta`.`id_tamanho` = `pt`.`id_tamanho`)) ;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `tbgeneros`
--
ALTER TABLE `tbgeneros`
  ADD PRIMARY KEY (`id_genero`);

--
-- Índices de tabela `tbmarcas`
--
ALTER TABLE `tbmarcas`
  ADD PRIMARY KEY (`id_marca`);

--
-- Índices de tabela `tbprodutos`
--
ALTER TABLE `tbprodutos`
  ADD PRIMARY KEY (`id_produto`),
  ADD KEY `idx_marca_produto` (`id_marca_produto`),
  ADD KEY `idx_genero_produto` (`id_genero_produto`),
  ADD KEY `idx_tipo_produto` (`id_tipo_produto`);

--
-- Índices de tabela `tbproduto_tamanho`
--
ALTER TABLE `tbproduto_tamanho`
  ADD PRIMARY KEY (`id_produto`,`id_tamanho`),
  ADD KEY `id_tamanho_fk` (`id_tamanho`);

--
-- Índices de tabela `tbtamanhos`
--
ALTER TABLE `tbtamanhos`
  ADD PRIMARY KEY (`id_tamanho`),
  ADD UNIQUE KEY `numero_tamanho_uniq` (`numero_tamanho`);

--
-- Índices de tabela `tbtipos`
--
ALTER TABLE `tbtipos`
  ADD PRIMARY KEY (`id_tipo`);

--
-- Índices de tabela `tbusuarios`
--
ALTER TABLE `tbusuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `login_usuario_uniq` (`login_usuario`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tbgeneros`
--
ALTER TABLE `tbgeneros`
  MODIFY `id_genero` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `tbmarcas`
--
ALTER TABLE `tbmarcas`
  MODIFY `id_marca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `tbprodutos`
--
ALTER TABLE `tbprodutos`
  MODIFY `id_produto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de tabela `tbtamanhos`
--
ALTER TABLE `tbtamanhos`
  MODIFY `id_tamanho` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `tbtipos`
--
ALTER TABLE `tbtipos`
  MODIFY `id_tipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `tbusuarios`
--
ALTER TABLE `tbusuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `tbprodutos`
--
ALTER TABLE `tbprodutos`
  ADD CONSTRAINT `fk_prod_genero` FOREIGN KEY (`id_genero_produto`) REFERENCES `tbgeneros` (`id_genero`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_prod_marca` FOREIGN KEY (`id_marca_produto`) REFERENCES `tbmarcas` (`id_marca`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_prod_tipo` FOREIGN KEY (`id_tipo_produto`) REFERENCES `tbtipos` (`id_tipo`) ON UPDATE CASCADE;

--
-- Restrições para tabelas `tbproduto_tamanho`
--
ALTER TABLE `tbproduto_tamanho`
  ADD CONSTRAINT `fk_pt_produto` FOREIGN KEY (`id_produto`) REFERENCES `tbprodutos` (`id_produto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pt_tamanho` FOREIGN KEY (`id_tamanho`) REFERENCES `tbtamanhos` (`id_tamanho`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
