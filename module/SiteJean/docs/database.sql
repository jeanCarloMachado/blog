SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';


-- -----------------------------------------------------
-- Table `estg_area`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `estg_area` ;

CREATE  TABLE IF NOT EXISTS `estg_area` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(255) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `estg_estado`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `estg_estado` ;

CREATE  TABLE IF NOT EXISTS `estg_estado` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(50) NOT NULL ,
  `sigla` VARCHAR(2) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `estg_cidade`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `estg_cidade` ;

CREATE  TABLE IF NOT EXISTS `estg_cidade` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(100) NOT NULL ,
  `cep` VARCHAR(10) NOT NULL ,
  `estado_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_cidade_estado1_idx` (`estado_id` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `estg_endereco`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `estg_endereco` ;

CREATE  TABLE IF NOT EXISTS `estg_endereco` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `logradouro` VARCHAR(255) NOT NULL ,
  `numero` DECIMAL(5) NULL ,
  `bairro` VARCHAR(100) NOT NULL ,
  `complemento` VARCHAR(255) NULL ,
  `cidade_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_endereco_cidade1_idx` (`cidade_id` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `estg_aluno`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `estg_aluno` ;

CREATE  TABLE IF NOT EXISTS `estg_aluno` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `matricula` VARCHAR(255) NOT NULL ,
  `nome` VARCHAR(255) NOT NULL ,
  `cpf` VARCHAR(15) NOT NULL ,
  `identidade` VARCHAR(20) NOT NULL ,
  `email` VARCHAR(200) NULL ,
  `endereco_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_aluno_endereco1_idx` (`endereco_id` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `estg_professor`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `estg_professor` ;

CREATE  TABLE IF NOT EXISTS `estg_professor` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(255) NOT NULL ,
  `cpf` VARCHAR(255) NULL ,
  `email` VARCHAR(255) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `estg_estagio`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `estg_estagio` ;

CREATE  TABLE IF NOT EXISTS `estg_estagio` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `periodo_ini` DATETIME NOT NULL ,
  `periodo_fim` DATETIME NULL ,
  `carga_horaria` DECIMAL(4) NOT NULL ,
  `avaliacao_relatorio` DECIMAL(2,2) NULL ,
  `avaliacao_apresentacao` DECIMAL(2,2) NULL ,
  `media_final` DECIMAL(2,2) NULL ,
  `seguro_apolice` VARCHAR(255) NULL ,
  `seguro_empresa` VARCHAR(255) NULL ,
  `supervisor` VARCHAR(255) NULL ,
  `supervisao_data` DATETIME NULL ,
  `apresentacao_data` DATETIME NULL ,
  `apresentacao_local` VARCHAR(255) NULL ,
  `area_id` INT UNSIGNED NOT NULL ,
  `aluno_id` INT NOT NULL ,
  `orientador_id` INT NOT NULL ,
  `coorientador_id` INT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_estagio_area_idx` (`area_id` ASC) ,
  INDEX `fk_estagio_aluno1_idx` (`aluno_id` ASC) ,
  INDEX `fk_estagio_professor1_idx` (`orientador_id` ASC) ,
  INDEX `fk_estagio_professor2_idx` (`coorientador_id` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `estg_empresa`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `estg_empresa` ;

CREATE  TABLE IF NOT EXISTS `estg_empresa` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nome_fantasia` VARCHAR(255) NOT NULL ,
  `razao_social` VARCHAR(255) NOT NULL ,
  `cnpj` VARCHAR(255) NOT NULL ,
  `tipo` VARCHAR(255) NOT NULL ,
  `email` VARCHAR(255) NULL ,
  `telefone` VARCHAR(255) NULL ,
  `fax` VARCHAR(255) NULL ,
  `representante_nome` VARCHAR(255) NOT NULL ,
  `representante_cargo` VARCHAR(255) NULL ,
  `convenio_cod` VARCHAR(255) NULL ,
  `convenio_ini` DATE NULL ,
  `convenio_fim` DATE NULL ,
  `area_id` INT NOT NULL ,
  `endereco_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_empresa_area1_idx` (`area_id` ASC) ,
  INDEX `fk_empresa_endereco1_idx` (`endereco_id` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `estg_aluno_telefone`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `estg_aluno_telefone` ;

CREATE  TABLE IF NOT EXISTS `estg_aluno_telefone` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `numero` VARCHAR(255) NOT NULL ,
  `tipo` VARCHAR(255) NULL ,
  `aluno_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_aluno_telefone_aluno1_idx` (`aluno_id` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `estg_empresa_telefone`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `estg_empresa_telefone` ;

CREATE  TABLE IF NOT EXISTS `estg_empresa_telefone` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `numero` VARCHAR(255) NOT NULL ,
  `tipo` VARCHAR(255) NULL ,
  `empresa_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_empresa_telefone_empresa1_idx` (`empresa_id` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `estg_tipo_avaliacao`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `estg_tipo_avaliacao` ;

CREATE  TABLE IF NOT EXISTS `estg_tipo_avaliacao` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(200) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `estg_avaliacao`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `estg_avaliacao` ;

CREATE  TABLE IF NOT EXISTS `estg_avaliacao` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `total` DECIMAL(2,2) NOT NULL DEFAULT 00.00 ,
  `estagio_id` INT NOT NULL ,
  `tipo_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_avaliacao_estagio1_idx` (`estagio_id` ASC) ,
  INDEX `fk_avaliacao_tipo_avaliacao1_idx` (`tipo_id` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `estg_caracteristica`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `estg_caracteristica` ;

CREATE  TABLE IF NOT EXISTS `estg_caracteristica` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(200) NOT NULL ,
  `peso_maximo` DECIMAL(2,2) NOT NULL ,
  `tipo_avaliacao_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_caracteristica_tipo_avaliacao1_idx` (`tipo_avaliacao_id` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `estg_avaliacao_caracteristica`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `estg_avaliacao_caracteristica` ;

CREATE  TABLE IF NOT EXISTS `estg_avaliacao_caracteristica` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `caracteristica_id` INT NOT NULL ,
  `avaliacao_id` INT NOT NULL ,
  `nota` DECIMAL(2,2) NOT NULL ,
  `professor_id` INT NULL ,
  PRIMARY KEY (`id`, `caracteristica_id`, `avaliacao_id`) ,
  INDEX `fk_caracteristica_avaliacao_avaliacao1_idx` (`avaliacao_id` ASC) ,
  INDEX `fk_caracteristica_avaliacao_caracteristica1_idx` (`caracteristica_id` ASC) ,
  INDEX `fk_avaliacao_caracteristica_professor1_idx` (`professor_id` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `estg_papel`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `estg_papel` ;

CREATE  TABLE IF NOT EXISTS `estg_papel` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `estg_usuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `estg_usuario` ;

CREATE  TABLE IF NOT EXISTS `estg_usuario` (
  `id` INT NOT NULL ,
  `email` VARCHAR(200) NULL ,
  `senha` TEXT NULL ,
  `foreign_id` INT NOT NULL ,
  `class_name` VARCHAR(45) NOT NULL ,
  `papel_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_usuario_papel1_idx` (`papel_id` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `estg_recurso`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `estg_recurso` ;

CREATE  TABLE IF NOT EXISTS `estg_recurso` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(255) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
COMMENT = 'o nome representa um controller/action';


-- -----------------------------------------------------
-- Table `estg_acl`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `estg_acl` ;

CREATE  TABLE IF NOT EXISTS `estg_acl` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `papel_id` INT NOT NULL ,
  `recurso_id` INT NOT NULL ,
  `permissao` TINYINT NOT NULL DEFAULT 1 ,
  PRIMARY KEY (`id`, `papel_id`, `recurso_id`) ,
  INDEX `fk_papel_has_recurso_recurso1_idx` (`recurso_id` ASC) ,
  INDEX `fk_papel_has_recurso_papel1_idx` (`papel_id` ASC) )
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
