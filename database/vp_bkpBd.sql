-- backup do banco

-- drop do user se existir

DROP USER IF EXISTS 'adminVP'@'localhost';
 
-- Criar o usuário adminVP se ele não existir

CREATE USER IF NOT EXISTS 'adminVP'@'localhost'

    IDENTIFIED BY 'senacvp_ti19';

GRANT ALL PRIVILEGES ON *.* TO 'adminVP'@'localhost'

    WITH GRANT OPTION;

FLUSH PRIVILEGES;
 
-- drop do banco vpstreet_ti19 se ele exista

DROP DATABASE IF EXISTS vpstreet_ti19;
 
-- Criar o banco se caso ele não exista

CREATE DATABASE IF NOT EXISTS vpstreet_ti19

    DEFAULT CHARACTER SET utf8

    COLLATE utf8_general_ci;
 
-- usa o banco vpstreet_ti19

USE vpstreet_ti19;
 
-- criaçao tabela usuario

CREATE TABLE tbusuarios(

    id_usuario INT(11) NOT NULL,

    login_usuario VARCHAR(30) NOT NULL,

    email_usuario VARCHAR(50) NOT NULL,

    senha_usuario VARCHAR(8) NOT NULL,

    nivel_usuario ENUM('admin','user') NOT NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 
-- criaçao tabela tbmarcas

CREATE TABLE tbmarcas(

    id_marca INT(11) NOT NULL,

    nome_marca VARCHAR(15) NOT NULL,

    imagem_marca VARCHAR(50) NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 
-- criaçao tabela tbgeneros

CREATE TABLE tbgeneros(

    id_genero INT(11) NOT NULL,

    nome_genero VARCHAR(15) NOT NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 
-- criaçao tabela tbtipos

CREATE TABLE tbtipos(

    id_tipo INT(11) NOT NULL,

    nome_tipo VARCHAR(15) NOT NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 
-- criaçao tabela tbprodutos

CREATE TABLE tbprodutos(

    id_produto INT(11) NOT NULL,

    id_marca_produto INT(11) NULL,

    id_genero_produto INT(11) NOT NULL,

    id_tipo_produto INT(11) NOT NULL,

    nome_produto VARCHAR(100) NOT NULL,

    resumo_produto VARCHAR(1000) NULL,

    valor_produto DECIMAL(9,2) NULL,

    imagem_produto VARCHAR(50) NULL,

    promoção_produto ENUM('Pro','Não') NOT NULL,

    sneakers_produto ENUM('Sne','Not') NOT NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 
-- =========================================================

-- TAMANHOS (NOVO)

-- =========================================================
 
-- criaçao tabela tbtamanhos

CREATE TABLE tbtamanhos(

    id_tamanho INT(11) NOT NULL,

    numero_tamanho VARCHAR(10) NOT NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 
-- criaçao tabela tbproduto_tamanho (produto x tamanho + estoque)

CREATE TABLE tbproduto_tamanho(

    id_produto INT(11) NOT NULL,

    id_tamanho INT(11) NOT NULL,

    estoque INT(11) NOT NULL DEFAULT 0

) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 
-- ------ CHAVES ------

ALTER TABLE tbprodutos

    ADD PRIMARY KEY (id_produto),

    ADD KEY idx_marca_produto (id_marca_produto),

    ADD KEY idx_genero_produto (id_genero_produto),

    ADD KEY idx_tipo_produto (id_tipo_produto);
 
ALTER TABLE tbmarcas

    ADD PRIMARY KEY (id_marca);
 
ALTER TABLE tbtipos

    ADD PRIMARY KEY (id_tipo);
 
ALTER TABLE tbgeneros

    ADD PRIMARY KEY (id_genero);
 
ALTER TABLE tbusuarios

    ADD PRIMARY KEY (id_usuario),

    ADD UNIQUE KEY login_usuario_uniq (login_usuario);
 
-- chaves tamanhos

ALTER TABLE tbtamanhos

    ADD PRIMARY KEY (id_tamanho),

    ADD UNIQUE KEY numero_tamanho_uniq (numero_tamanho);
 
ALTER TABLE tbproduto_tamanho

    ADD PRIMARY KEY (id_produto, id_tamanho),

    ADD KEY id_tamanho_fk (id_tamanho);
 
-- ----- AUTO INCREMENTS -----

ALTER TABLE tbprodutos

    MODIFY id_produto INT(11) NOT NULL AUTO_INCREMENT;
 
ALTER TABLE tbmarcas

    MODIFY id_marca INT(11) NOT NULL AUTO_INCREMENT;
 
ALTER TABLE tbusuarios

    MODIFY id_usuario INT(11) NOT NULL AUTO_INCREMENT;
 
ALTER TABLE tbgeneros

    MODIFY id_genero INT(11) NOT NULL AUTO_INCREMENT;
 
ALTER TABLE tbtipos

    MODIFY id_tipo INT(11) NOT NULL AUTO_INCREMENT;
 
ALTER TABLE tbtamanhos

    MODIFY id_tamanho INT(11) NOT NULL AUTO_INCREMENT;
 
-- limitadores e referencias da chave estrangeira

ALTER TABLE tbprodutos

   ADD CONSTRAINT fk_prod_marca

   FOREIGN KEY (id_marca_produto)

   REFERENCES tbmarcas(id_marca)

   ON DELETE SET NULL

   ON UPDATE CASCADE;
 
ALTER TABLE tbprodutos

   ADD CONSTRAINT fk_prod_genero

   FOREIGN KEY (id_genero_produto)

   REFERENCES tbgeneros(id_genero)

   ON DELETE RESTRICT

   ON UPDATE CASCADE;
 
ALTER TABLE tbprodutos

   ADD CONSTRAINT fk_prod_tipo

   FOREIGN KEY (id_tipo_produto)

   REFERENCES tbtipos(id_tipo)

   ON DELETE RESTRICT

   ON UPDATE CASCADE;
 
-- foreign keys tamanhos

ALTER TABLE tbproduto_tamanho

   ADD CONSTRAINT fk_pt_produto

   FOREIGN KEY (id_produto)

   REFERENCES tbprodutos(id_produto)

   ON DELETE CASCADE

   ON UPDATE CASCADE;
 
ALTER TABLE tbproduto_tamanho

   ADD CONSTRAINT fk_pt_tamanho

   FOREIGN KEY (id_tamanho)

   REFERENCES tbtamanhos(id_tamanho)

   ON DELETE NO ACTION

   ON UPDATE NO ACTION;
 
-- inserts
 
INSERT INTO tbusuarios

(id_usuario, login_usuario, email_usuario, senha_usuario, nivel_usuario)

VALUES

(1, 'paulo', 'paulo@email.com', '1234', 'admin'),
(2, 'rocha', 'rocha@email.com', '1234', 'user'),

(3, 'gabriel', 'gabriel@email.com', '1234', 'admin');
 
INSERT INTO tbmarcas (id_marca, nome_marca, imagem_marca) VALUES

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
 
INSERT INTO tbgeneros (id_genero, nome_genero) VALUES

(1, 'Masculino'),

(2, 'Feminino'),

(3, 'infatil');
 
INSERT INTO tbtipos (id_tipo, nome_tipo) VALUES
(1, 'Tenis'),
(2, 'Chinelo'),
(3, 'Camisa'),
(4, 'Bonés');
 
INSERT INTO tbprodutos
(id_produto, id_marca_produto, id_genero_produto, id_tipo_produto, nome_produto, resumo_produto, valor_produto, imagem_produto, promoção_produto, sneakers_produto)
VALUES
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
(19, 9, 2, 1, 'Mizuno Felix', 'É um tênis de alta performance que combina tecnologia avançada com um design moderno e imponente. Com cabedal em mesh respirável, proporciona excelente ventilação e conforto durante o uso.', 790.00, '313234-1600-1600.webp', '', ''),
(20, 9, 2, 1, 'Pro 8 ', 'O Mizuno Wave Prophecy Pro 8 combina tecnologia e design futurista para máximo conforto e desempenho. Com a exclusiva placa Wave, oferece excelente amortecimento, estabilidade e resposta a cada passada.', 1300.00, 'mizuno_pro8_final.jpg', 'Não', 'Not'),
(21, 3, 2, 2, 'NFL Kansas City Chiefs', 'O design único e ousado da sandália traz as cores e o logo do time de futebol americano Kansas City Chiefs, trazendo todo o espírito esportivo para o seu visual.\r\n ', 500.00, 'crocs.webp', '', ''),
(22, 3, 1, 2, 'Simpsons', 'A Crocs dos Simpsons combina o conforto clássico da Crocs com o humor e a irreverência da família mais famosa da TV. Com design divertido e inspirado na série, ela é perfeita para fãs que querem destacar o visual com personalidade e muito conforto no dia a dia.', 600.00, 'crocs_simpson_invertido.jpg', 'Não', 'Not'),
(23, 1, 1, 1, 'Adi 2000', 'O Adidas ADI 2000 traz de volta a estética marcante dos anos 2000, unindo inspiração no skate, design robusto e conforto para o uso diário. Um tênis com identidade forte, ideal para quem curte estilo urbano e atitude autêntica.', 850.00, 'ChatGPT Image 24 de fev. de 2026, 19_26_54.png', '', ''),
(24, 1, 2, 1, ' Grand Court 2.0', 'Tênis Adidas rosa com design clássico e versátil, perfeito para o dia a dia. Possui cabedal em material sintético resistente, que garantem o visual autêntico da marca.', 350.00, '587679-1200-auto.webp', '', ''),
(26, 10, 1, 1, 'Artic', 'O ASICS une tradição em performance com um visual moderno e urbano. Inspirado nos modelos clássicos de corrida, ele oferece conforto, amortecimento eficiente e um design robusto.', 600.00, 'ChatGPT Image 24 de fev. de 2026, 19_36_12.png', 'Não', 'Not'),
(27, 10, 2, 1, 'Black Edition', 'Apresenta um visual robusto e moderno, com forte inspiração nos clássicos da corrida. Com design imponente, acabamento premium e excelente amortecimento, é a escolha ideal para quem busca conforto', 700.00, 'ChatGPT Image 24 de fev. de 2026, 19_38_25.png', 'Não', 'Not'),
(28, 10, 1, 1, 'Court FF', 'Foi desenvolvido para alto desempenho nas quadras, oferecendo estabilidade, amortecimento e resposta rápida em cada movimento. Com design moderno e estrutura reforçada, ele garante conforto', 1100.00, 'ChatGPT Image 24 de fev. de 2026, 19_40_45.png', 'Não', 'Not'),
(29, 3, 1, 2, 'Crocs Minecraft', 'A Crocs do Minecraft une conforto icônico com o universo criativo do jogo mais famoso do mundo. Com design temático e cheio de detalhes inspirados no Minecraft, ela é perfeita para fãs que querem estilo', 500.00, 'ChatGPT Image 24 de fev. de 2026, 19_44_37.png', '', ''),
(30, 2, 2, 1, 'Court Vision', 'Tênis Nike branco com design clássico e clean, ideal para compor looks versáteis no dia a dia. Confeccionado em material sintético de alta qualidade com acabamento texturizado, ele traz o icônico Swoosh nas laterais que garante autenticidade ao modelo.', 450.00, '61oZve9XmvL._AC_SY695_.jpg', 'Não', 'Not'),
(31, 2, 2, 1, ' Free Metcon 6', 'Nike Free Metcon 6 é o equilíbrio perfeito entre flexibilidade e estabilidade para treinos intensos. Com cabedal leve e respirável, ele garante conforto durante todo o uso, enquanto a tecnologia Free na entressola proporciona movimentos naturais e maior liberdade nos pés.', 1300.00, '61k1omhPUnL._AC_SY575_.jpg', 'Não', 'Not'),
(32, 2, 1, 1, 'Air VaporMax Plus', 'Nike Air VaporMax Plus traz um visual marcante com tecnologia de ponta, combinando estilo urbano com máximo conforto. Com cabedal em material leve e ajustável, ele se adapta perfeitamente aos pés, enquanto a icônica estrutura lateral oferece suporte e design moderno.', 1500.00, '717OUXQ4C-L._AC_SY575_.jpg', 'Não', 'Not'),
(33, 1, 2, 1, 'Megaride', 'O Adidas megaride combina estilo e funcionalidade em um design moderno e versátil. Com cabedal em mesh e sobreposições sintéticas, oferece respirabilidade e resistência para o uso diário.', 470.00, '587371-1200-auto.webp', '', ''),
(34, 10, 1, 1, 'Netburner Ballistic FF 4', 'ASICS Netburner Ballistic FF é um tênis desenvolvido para alta performance em quadras, unindo leveza, estabilidade e conforto. Seu cabedal em mesh respirável garante ventilação ideal, enquanto a estrutura reforçada oferece suporte lateral para movimentos rápidos e intensos.', 830.00, '51EWV7WCdrL._AC_SY575_.jpg', 'Não', 'Not'),
(35, 3, 1, 2, 'Harley Quinn Cls Clg', 'a Sandália Crocs Harley Quinn Cls Clg Unissex é ideal para o dia a dia, seja para usar em casa, no trabalho ou até mesmo em um passeio descontraído. Seu design colorido e estampado inspirado na personagem Harley Quinn', 600.00, 'crocs 1.webp', '', ''),
(36, 9, 2, 1, 'Sunrise', 'Mizuno Sunrise é um tênis leve e confortável, ideal para corridas e uso no dia a dia. Com cabedal em knit respirável, proporciona excelente ventilação e ajuste aos pés.', 700.00, '51DkZjOEBXL._AC_SY575_.jpg', 'Não', 'Not'),
(37, 5, 1, 1, '990 V6', 'Tênis New Balance com design moderno e sofisticado, ideal para quem busca estilo e conforto no dia a dia. Confeccionado com materiais de alta qualidade, combina camurça e mesh, garantindo durabilidade e respirabilidade.', 1570.00, 'paulo.jpg', 'Não', 'Not'),
(38, 6, 1, 1, 'RS Surge', 'Prepare-se para arrasar com o Tênis Puma RS Surge Unissex Azul! Feito com materiais de alta qualidade, este tênis combina Textile base com detalhes em Leather, proporcionando durabilidade e estilo.', 980.00, '596973-1200-auto.webp', '', ''),
(39, 8, 2, 1, 'Tesla Skate', 'Tênis com visual urbano e estilo skate, ideal para o dia a dia. Confeccionado em material tipo camurça na cor preta, traz acabamento com costuras contrastantes que destacam o design.', 500.00, 'tenis_invertido.jpg', 'Não', 'Not'),
(40, 1, 2, 1, 'Campus', 'O Adidas Campus é um clássico atemporal que une estilo urbano e conforto no dia a dia. Confeccionado em camurça de alta qualidade na cor marrom, oferece um visual sofisticado e versátil.', 670.00, '601277-1200-auto.webp', 'Não', 'Not'),
(41, 7, 2, 1, 'Upland', 'O Tênis Vans Upland Feminino na cor Cinza é a combinação perfeita de estilo e conforto. Feito de material couro sintéticoh de alta qualidade, este tênis garante durabilidade e resistência, sem deixar de lado o design moderno e estiloso. ', 500.00, '577197-1200-auto.webp', 'Não', 'Not'),
(42, 1, 1, 4, 'Boné Adidas', 'Estiloso e autêntico, o boné Adidas Originals na cor preta traz o clássico logo Trefoil em destaque na parte frontal, garantindo um visual marcante.', 100.00, '81k9L2r-zyL._AC_SX569_.jpg', 'Não', 'Not'),
(43, 1, 1, 4, 'Bucket Adidas', 'Moderno e cheio de atitude, o bucket Adidas Originals é a escolha ideal para um visual urbano e estiloso. Na cor preta, traz o logo Trefoil em destaque na parte frontal, garantindo autenticidade à peça.', 200.00, '513UF9-KjbL._AC_SX466_.jpg', '', ''),
(44, 1, 1, 4, 'Boné 3 Listras', 'Clássico e cheio de estilo, o boné Adidas preto é perfeito para o dia a dia. Possui o icônico logo Adidas na parte frontal e as tradicionais três listras na aba, trazendo um visual esportivo marcante.', 150.00, '71hFSReqB7L._AC_SX569_.jpg', 'Não', 'Not'),
(45, 2, 2, 4, 'Bucket Nike', 'Estiloso e funcional, o chapéu bucket Nike é ideal para quem busca proteção e conforto no dia a dia. Com aba larga ao redor, oferece maior cobertura contra o sol, sendo perfeito para atividades ao ar livre.', 300.00, 'p.jpg', 'Não', 'Not'),
(46, 2, 1, 4, 'Nike Dry-Fit', 'Discreto e versátil, o boné Nike preto é ideal para compor qualquer look com estilo esportivo. Produzido com tecnologia Dri-FIT, proporciona conforto ao absorver o suor e manter a cabeça seca durante o uso.', 400.00, '41FHSBJCyoL._AC_SX569_.jpg', 'Não', 'Not'),
(47, 2, 1, 4, 'Nike Sport', 'Leve, moderno e funcional, o boné Nike na cor azul é perfeito para o dia a dia e atividades esportivas. Confeccionado com tecnologia Dri-FIT, ajuda a absorver o suor mantendo a cabeça seca e confortável.', 350.00, 'bone.jpg', 'Pro', 'Sne'),
(48, 6, 1, 3, 'Puma Classic', 'Clássica e versátil, a camiseta Puma preta traz um visual minimalista com o logo icônico da marca em destaque no peito.', 200.00, 'preto.webp', '', ''),
(49, 6, 1, 3, 'Puma Preta', 'Clássica e versátil, a camiseta Puma preta traz um visual minimalista com o logo icônico da marca em destaque no peito.', 100.00, 'OIP (1).webp', 'Não', 'Not'),
(50, 6, 1, 3, 'Puma Retro', 'Camiseta preta Puma com estampa traseira de estilo retrô-futurista, combinando cores vibrantes e elementos gráficos como planetas, estrelas e formas geométricas.', 150.00, '7d192a64-358b-4496-9ac5-8427c5f06809 (1).png', 'Não', 'Not'),
(51, 4, 1, 3, 'Jordan Reissue', 'Confeccionada em fibra sintética de alta qualidade, essa peça traz o design icônico da marca Jordan em um corte oversized, perfeito para um visual moderno e despojado', 200.00, 'NIke (1).webp', 'Não', 'Not'),
(52, 2, 1, 3, 'M90 Oc Wings Victory', 'A Camiseta Nike M90 Oc Wings Victory Masculina é o equilíbrio perfeito entre estilo e funcionalidade. Confeccionada em fibra sintética de alta qualidade, proporciona conforto e durabilidade ao longo do dia.', 200.00, 'nike collection.webp', '', ''),
(53, 1, 1, 3, 'Trefoil', 'O design moderno da Camiseta adidas Skateboarding Triple Trefoil traz uma versão atualizada do legado das Três Listras, com sua estrutura de gola careca de algodão e modelagem básica', 100.00, 'adidas.webp', 'Não', 'Not'),
(54, 7, 1, 3, 'Vans Dollface SS', 'O roxo é uma cor vibrante e versátil, que combina facilmente com diferentes estilos e complementa diversas combinações de roupas, trazendo um toque de personalidade ao visual.', 180.00, 'vans.webp', 'Não', 'Not'),
(55, 5, 1, 3, 'New Balance Essentials', 'A Camiseta New Balance Essentials Masculina é a escolha perfeita para quem busca conforto e estilo no dia a dia. Confeccionada em material de alta qualidade', 200.00, 'new.webp', 'Não', 'Not');
-- inserts tamanhos (NOVO) - CORRIGIDO

INSERT INTO tbtamanhos (numero_tamanho) VALUES

('34'),('35'),('36'),('37'),('38'),('39'),('40'),('M'),('G'),('GG');
 
-- liga todos os produtos aos tamanhos 34..40 com estoque 10 (NOVO) - CORRIGIDO

INSERT INTO tbproduto_tamanho (id_produto, id_tamanho, estoque)

SELECT p.id_produto, t.id_tamanho, 10

FROM tbprodutos p

JOIN tbtamanhos t

WHERE t.numero_tamanho IN ('34','35','36','37','38','39','40');
 
-- =========================================================

-- VIEW (ATUALIZADA COM TAMANHOS)

-- =========================================================
 
DROP VIEW IF EXISTS vw_tbprodutos;
 
CREATE VIEW vw_tbprodutos AS

SELECT

    p.id_produto,

    p.id_marca_produto,

    p.id_genero_produto,

    p.id_tipo_produto,

    t.nome_tipo,

    m.nome_marca,

    i.nome_genero,

    m.imagem_marca,

    p.nome_produto,

    p.resumo_produto,

    p.valor_produto,

    p.imagem_produto,

    p.promoção_produto,

    p.sneakers_produto,

    ta.id_tamanho,

    ta.numero_tamanho,

    pt.estoque

FROM tbprodutos p

JOIN tbgeneros i ON p.id_genero_produto = i.id_genero

JOIN tbmarcas  m ON p.id_marca_produto  = m.id_marca

JOIN tbtipos   t ON p.id_tipo_produto   = t.id_tipo

LEFT JOIN tbproduto_tamanho pt ON pt.id_produto = p.id_produto

LEFT JOIN tbtamanhos ta ON ta.id_tamanho = pt.id_tamanho;
 