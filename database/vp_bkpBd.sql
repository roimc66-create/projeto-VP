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

-- usa o bancoi vpstreet_ti19
USE vpstreet_ti19;

-- criaçao tabela usuario
CREATE TABLE tbusuarios(
    id_usuario INT(11) NOT NULL,
    login_usuario VARCHAR(30) NOT NULL,
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
    id_marca_produto INT(11) NOT NULL,
    id_genero_produto INT(11) NOT NULL,
    id_tipo_produto INT(11) NOT NULL,
    nome_produto VARCHAR(100) NOT NULL,
    resumo_produto VARCHAR(1000) NULL,
    valor_produto DECIMAL(9,2) NULL,
    imagem_produto VARCHAR(50) NULL,
    promoção_produto enum('Sim','Não') NOT NULL,
    sneakers_produto enum('Sim','Não') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ------ CHAVES ------
ALTER TABLE tbprodutos
    ADD PRIMARY KEY (id_produto),    
    ADD KEY id_marca_produto_fk(id_marca_produto);

ALTER TABLE tbmarcas
      ADD PRIMARY KEY (id_marca);

ALTER TABLE tbtipos
      ADD PRIMARY KEY (id_tipo);      

ALTER TABLE tbgeneros
      ADD PRIMARY KEY (id_genero);

    ALTER TABLE tbusuarios
ADD PRIMARY KEY (id_usuario),
ADD UNIQUE KEY login_usuario_uniq(login_usuario);

-- ----- AUTO INCREMENTS -----
ALTER TABLE tbprodutos
    MODIFY id_produto INT(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

ALTER TABLE tbmarcas
    MODIFY id_marca INT(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;   

ALTER TABLE tbusuarios
    MODIFY id_usuario INT(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;   

ALTER TABLE tbgeneros
    MODIFY id_genero INT(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;    

ALTER TABLE tbtipos
 MODIFY id_tipo INT(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;     

-- limitadores e referencias da chave estrangeira
ALTER TABLE tbprodutos
   ADD CONSTRAINT id_marca_produto_fk FOREIGN KEY (id_marca_produto)
   REFERENCES tbmarcas(id_marca)
   ON DELETE NO ACTION
   ON UPDATE NO ACTION;  

   ALTER TABLE tbprodutos
   ADD CONSTRAINT id_genero_produto_fk FOREIGN KEY (id_genero_produto)
   REFERENCES tbgeneros(id_genero)
   ON DELETE NO ACTION
   ON UPDATE NO ACTION;  

   ALTER TABLE tbprodutos
   ADD CONSTRAINT id_tipo_produto_fk FOREIGN KEY (id_tipo_produto)
   REFERENCES tbtipos(id_tipo)
   ON DELETE NO ACTION
   ON UPDATE NO ACTION;  


-- inserts

INSERT INTO tbusuarios
(id_usuario, login_usuario, senha_usuario, nivel_usuario)
VALUES
(1, 'paulo', '1234', 'admin'),
(2, 'rocha', '1234', 'user'),
(3, 'gabriel', '1234', 'admin');


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

-- Extraindo dados da tabela tbgeneros
INSERT INTO tbgeneros (id_genero, nome_genero) VALUES
(1, 'Masculino'),
(2, 'Feminino'),
(3, 'infatil');

-- Extraindo dados da tabela tbtipos
INSERT INTO tbtipos (id_tipo, nome_tipo) VALUES
(1, 'Tenis'),
(2, 'Chinelo'),
(3, 'Camisa');



INSERT INTO tbprodutos 
(id_produto, id_marca_produto, id_genero_produto, id_tipo_produto, nome_produto, resumo_produto, valor_produto, imagem_produto, promoção_produto, sneakers_produto) 
VALUES
(1, 6, 1, 1, 'PUMA INHALE X A$AP ROCKY', 'Modelo de visual agressivo, com design inspirado nos anos 2000. Mistura materiais robustos com cores chamativas e detalhes esportivos que dão um ar futurista.', 1000.99, 'puma-promocao.webp', 'Sim', 'Não'),
(2, 4, 1, 1, 'AIR JORDAN 1 OG', 'Clássico absoluto do basquete. Construção tradicional em couro, visual retrô e acabamento premium, perfeito para quem gosta de estilo autêntico e versátil.', 1299.00, 'jordan-1-promocao.webp', 'Sim', 'Sim'),
(3, 6, 1, 1, 'PUMA LAFRANCÉ', 'Tênis de edição especial com design moderno e elegante. Combina materiais leves, tons sofisticados e o padrão característico da collab, trazendo estilo e conforto.', 2099.99, 'puma-lafrance-promocao.webp', 'Sim', 'Sim'),
(4, 6, 1, 1, 'PUMA MOSTRO', 'Icônico e ousado, conhecido pelo solado dentado e pela silhueta futurista. Mistura moda, esporte e um visual diferenciado que se destaca em qualquer look.', 1199.99, 'puma-2-promocao.webp', 'Sim', 'Não'),
(5, 4, 1, 1, 'AIR JORDAN 5', 'Modelo marcante com língua refletiva e solado translúcido. Inspirado em jatos de caça, traz um visual esportivo e cheio de personalidade.', 1399.99, 'air-jordan-promocao.webp', 'Sim', 'Não'),
(6, 4, 2, 1, 'Tênis Air Jordan 1 Low Feminino', 'Clássico e elegante, combina couro macio e silhueta baixa para um visual versátil. Perfeito para quem gosta de estilo clean com toque esportivo.', 1099.99, 'puma-promocao.webp', 'Sim', 'Não'),
(7, 4, 2, 1, 'Tênis Nike A One Run Low Feminino', 'Modelo moderno com linhas fluidas e destaque no rosa vibrante. Leve, confortável e estiloso, ideal para quem quer um visual futurista e cheio de personalidade.', 899.99, 'nike-rosa-exclusivo.webp', 'Sim', 'Não'),
(8, 2, 1, 1, 'Tênis Nike Shox Tl Low Masculino', 'Design icônico com sistema Shox de amortecimento total. Durável, moderno e com visual agressivo, ideal para quem busca conforto e estilo marcante no dia a dia.', 1399.99, 'nikeshox-exclusivo.webp', 'Não', 'Sim');

-- view 

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
    sneakers_produto
FROM tbprodutos p 
JOIN tbgeneros i 
JOIN tbmarcas m 
JOIN tbtipos t
WHERE p.id_genero_produto = i.id_genero
  AND p.id_marca_produto = m.id_marca  
  AND p.id_tipo_produto = t.id_tipo;
