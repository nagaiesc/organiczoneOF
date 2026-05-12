-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema organiczoneBD
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema organiczoneBD
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `organiczoneBD` DEFAULT CHARACTER SET utf8 ;
USE `organiczoneBD`;

-- -----------------------------------------------------
-- Table `organiczoneBD`.`clientes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `organiczoneBD`.`clientes` (
  `id` INT NOT NULL,
  `nombre` VARCHAR(45) NULL,
  `apellido` VARCHAR(45) NULL,
  `nombreusuario` VARCHAR(45) NULL,
  `correo` VARCHAR(45) NULL,
  `contraseña` VARCHAR(45) NULL,
  `fechanacimiento` DATE NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `organiczoneBD`.`usuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `organiczoneBD`.`usuarios` (
  `CI` INT NOT NULL,
  `nombre` VARCHAR(45) NULL,
  `direccion` VARCHAR(45) NULL,
  `celular` VARCHAR(45) NULL,
  `rol` VARCHAR(45) NULL,
  `estado` VARCHAR(45) NULL,
  PRIMARY KEY (`CI`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `organiczoneBD`.`productos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `organiczoneBD`.`productos` (
  `id` INT NOT NULL,
  `nombre` VARCHAR(45) NULL,
  `descripcion` VARCHAR(45) NULL,
  `precio` INT NULL,
  `costo` INT NULL,
  `stock` INT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
