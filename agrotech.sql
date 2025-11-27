SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema agrotech_db
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS agrotech_db DEFAULT CHARACTER SET utf8mb4 ;
USE agrotech_db ;

-- -----------------------------------------------------
-- Table `agrotech_db`.`admin`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS agrotech_db.admin (
  id_adminPK INT(11) NOT NULL AUTO_INCREMENT,
  cargo VARCHAR(50) NOT NULL,
  email VARCHAR(100) NOT NULL,
  permissoes VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (id_adminPK),
  UNIQUE INDEX email (email ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

-- -----------------------------------------------------
-- Table `agrotech_db`.`agricultores`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS agrotech_db.agricultores (
  id_agricultorPK INT(11) NOT NULL AUTO_INCREMENT,
  nome VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  cpf VARCHAR(14) NOT NULL,
  PRIMARY KEY (id_agricultorPK),
  UNIQUE INDEX email (email ASC),
  UNIQUE INDEX cpf (cpf ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

-- -----------------------------------------------------
-- Table `agrotech_db`.`clientes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS agrotech_db.clientes (
  id_clientesPK INT(11) NOT NULL AUTO_INCREMENT,
  nome VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  telefone VARCHAR(20) NULL DEFAULT NULL,
  PRIMARY KEY (id_clientesPK),
  UNIQUE INDEX email (email ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

-- -----------------------------------------------------
-- Table `agrotech_db`.`vendas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS agrotech_db.vendas (
  id_vendasPK INT(11) NOT NULL AUTO_INCREMENT,
  data DATE NOT NULL,
  valor DECIMAL(10,2) NOT NULL,
  formaPagamentos VARCHAR(50) NULL DEFAULT NULL,
  id_clienteFK INT(11) NULL DEFAULT NULL,
  id_agricultorFK INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (id_vendasPK),
  INDEX id_clienteFK (id_clienteFK ASC),
  INDEX id_agricultorFK (id_agricultorFK ASC),
  CONSTRAINT vendas_ibfk_1
    FOREIGN KEY (id_clienteFK)
    REFERENCES clientes (id_clientesPK),
  CONSTRAINT vendas_ibfk_2
    FOREIGN KEY (id_agricultorFK)
    REFERENCES agricultores (id_agricultorPK))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

-- -----------------------------------------------------
-- Table `agrotech_db`.`produtos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS agrotech_db.produtos (
  id_produtoPK INT(11) NOT NULL AUTO_INCREMENT,
  nome VARCHAR(100) NOT NULL,
  quantidade DECIMAL(10,2) NOT NULL,
  descricao  TEXT NULL DEFAULT NULL,
  id_agricultorFK INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (id_produtoPK),
  INDEX id_agricultorFK (id_agricultorFK ASC),
  CONSTRAINT produtos_ibfk_1
    FOREIGN KEY (id_agricultorFK)
    REFERENCES agricultores (id_agricultorPK))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

-- -----------------------------------------------------
-- Table `agrotech_db`.`itens_vendas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS agrotech_db.itens_vendas (
  id_detalheVendasPK INT(11) NOT NULL AUTO_INCREMENT,
  id_vendasFK INT(11) NULL DEFAULT NULL,
  id_produtoFK INT(11) NULL DEFAULT NULL,
  quantidade INT(11) NOT NULL,
  PRIMARY KEY (id_detalheVendasPK),
  INDEX id_vendasFK (id_vendasFK ASC),
  INDEX id_produtoFK (id_produtoFK ASC),
  CONSTRAINT itens_vendas_ibfk_1
    FOREIGN KEY (id_vendasFK)
    REFERENCES vendas (id_vendasPK),
  CONSTRAINT itens_vendas_ibfk_2
    FOREIGN KEY (id_produtoFK)
    REFERENCES produtos (id_produtoPK))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

ALTER TABLE `admin`
MODIFY COLUMN `permissoes` VARCHAR(100);

ALTER TABLE `agricultores`
MODIFY COLUMN `cpf` CHAR(11);

ALTER TABLE `clientes`
MODIFY COLUMN `telefone` VARCHAR(14);

ALTER TABLE `vendas`
MODIFY COLUMN `valor` DECIMAL(8,2);

ALTER TABLE `produtos`
MODIFY COLUMN `quantidade` INT;