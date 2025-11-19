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
    nome_marca VARCHAR(3) NOT NULL,
    imagem_marca VARCHAR(50) NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- criaçao tabela tbtenis
CREATE TABLE tbtenis(
    id_tenis INT(11) NOT NULL,
    id_marca_tenis INT(11) NOT NULL,
    nome_tenis VARCHAR(100) NOT NULL,
    resumo_tenis VARCHAR(1000) NULL,
    valor_tenis DECIMAL(9,2) NULL,
    imagem_tenis VARCHAR(50) NULL,
    promoção_tenis enum('Sim','Não') NOT NULL,
    sneakers_tenis enum('Sim','Não') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ------ CHAVES ------
ALTER TABLE tbtenis
    ADD PRIMARY KEY (id_tenis),    
    ADD KEY id_marca_tenis_fk(id_marca_tenis);

ALTER TABLE tbmarcas
      ADD PRIMARY KEY (id_marca);

-- ----- AUTO INCREMENTS -----
ALTER TABLE tbtenis
    MODIFY id_tenis INT(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

ALTER TABLE tbmarcas
    MODIFY id_marca INT(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;   

ALTER TABLE tbusuarios
    MODIFY id_usuario INT(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;   

-- limitadores e referencias da chave estrangeira
ALTER TABLE tbtenis
   ADD CONSTRAINT id_marca_tenis_fk FOREIGN KEY (id_marca_tenis)
   REFERENCES tbmarcas(id_marca)
   ON DELETE NO ACTION
   ON UPDATE NO ACTION;  

-- Adicionar Chave Primária e Chave Única
ALTER TABLE tbusuarios
ADD PRIMARY KEY (id_usuario),
ADD UNIQUE KEY login_usuario_uniq(login_usuario);


-- inserts 
INSERT INTO tbmarcas (id_marca, nome_marca, imagem_marca) VALUES
(1, 'Adidas', 'adidas-logo.svg'),
(2, 'Nike', 'nike-logo.svg'),
(3, 'Crocs', 'crocs-logo.svg'),
(4, 'Jordan', 'jordan-marca.svg'),
(5, 'Newbalance', 'Newbalence-logo.svg'),
(6, 'Puma', 'pumaaa.png');


INSERT INTO tbusuarios
(id_usuario, login_usuario, senha_usuario, nivel_usuario)
VALUES
(1, 'paulo', '1234', 'admin'),
(2, 'rocha', '1234', 'user'),
(3, 'gabriel', '1234', 'admin');

-- Extraindo dados da tabela `tbprodutos`
INSERT INTO tbtenis (id_tenis, id_marca_tenis, nome_tenis, resumo_tenis, valor_tenis, imagem_tenis, promoção_tenis, sneakers_tenis) VALUES
(1, 6, 'PUMA INHALE X A$AP ROCKY', ' tenis puma', 1.000,99, 'puma-promoçao.webp', 'Sim', 'Não'),
(2, 4, 'AIR JORDAN 1 OG', ' tenis nike azul', 1.299,00, 'jordan-1-promoçao.webp', 'Sim', 'Sim'),
(3, 6, 'PUMA LAFRANCÉ', ' tenis puma', 2.099,99, 'puma-lafrancé-promoçao.webp', 'Sim', 'Sim'),
(4, 6, 'PUMA MOSTRO', 'tenis puma', 1.199,99, 'puma-2-promoçao.webp', 'Sim', 'Não'),
(5, 4, 'AIR JORDAN 5', ' tenis nike ', 1.399,99, 'air-jordan-promoçao.webp', 'Sim', 'Não'),
(6, 4, 'Tênis Air Jordan 1 Low Feminino', ' tenis jordan ',  1.099,99, 'puma-promoçao.webp', 'Sim', 'Não'),
(7, 4, 'Tênis Nike A One Run Low Feminino', ' tenis nike ', 899,99, 'nike-rosa-eclusivo.webp', 'Sim', 'Não'),
(8, 2, 'Tênis Nike Shox Tl Low Masculino', 'nike mola ', 1.399,99, 'nikeshox-exclusivo.webp', 'Não', 'Sim');



