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
    descri_tenis VARCHAR(100) NOT NULL,
    resumo_tenis VARCHAR(1000) NULL,
    valor_tenis DECIMAL(9,2) NULL,
    imagem_tenis VARCHAR(50) NULL,
    promoção_tenis enum('Sim','Não') NOT NULL
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



