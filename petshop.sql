/*Criando o Banco de dados */
CREATE DATABASE `petshop` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

/*Criando a tabela cliente */
CREATE TABLE cliente NOT EXISTS `table_name` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(60),
  `email` VARCHAR(255),
  `senha` VARCHAR(255),
  `papel` VARCHAR(10),
  PRIMARY KEY `pk_id`(`id`)
) ENGINE = InnoDB;

/*Criando a tabela produto */
CREATE TABLE produto NOT EXISTS `table_name` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(60),
  `valor` FLOAT(255),
  `tipo` VARCHAR(255),
  `imagem` VARCHAR(255),
  
  PRIMARY KEY `pk_id`(`id`)
) ENGINE = InnoDB;

/*Recomendo usar o md5 para criptografar a senha*/
INSERT INTO `cliente`(`nome` `email` `senha` `papel`) VALUES
('brenda','brenda@gmail.com','1234','ADM'),
;

