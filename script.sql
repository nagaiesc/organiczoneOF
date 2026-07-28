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
USE `organiczoneBD` ;

-- -----------------------------------------------------
-- Table `organiczoneBD`.`usuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `organiczoneBD`.`usuarios` (
  `CI` INT NOT NULL AUTO_INCREMENT,
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
  `id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NULL,
  `descripcion` VARCHAR(45) NULL,
  `precio` INT NULL,
  `costo` INT NULL,
  `stock` INT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `organiczoneBD`.`pedidos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `organiczoneBD`.`pedidos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NULL,
  `fecha` DATE NULL,
  `estado` VARCHAR(45) NULL,
  `nombrevendedor` VARCHAR(45) NULL,
  `direccion` VARCHAR(45) NULL,
  `telefono` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `organiczoneBD`.`carrito`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `organiczoneBD`.`carrito` (
  `pedidos_id` INT NOT NULL,
  `productos_id` INT NOT NULL,
  `cantidad` INT NULL,
  `costototal` INT NULL,
  PRIMARY KEY (`pedidos_id`, `productos_id`),
  INDEX `fk_pedidos_has_productos_productos1_idx` (`productos_id` ASC) ,
  INDEX `fk_pedidos_has_productos_pedidos_idx` (`pedidos_id` ASC) ,
  CONSTRAINT `fk_pedidos_has_productos_pedidos`
    FOREIGN KEY (`pedidos_id`)
    REFERENCES `organiczoneBD`.`pedidos` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pedidos_has_productos_productos1`
    FOREIGN KEY (`productos_id`)
    REFERENCES `organiczoneBD`.`productos` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `organiczoneBD`.`ventas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `organiczoneBD`.`ventas` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `estado` VARCHAR(45) NULL,
  `metodo` VARCHAR(45) NULL,
  `costototal` INT NULL,
  `pedidos_id` INT NOT NULL,
  PRIMARY KEY (`id`, `pedidos_id`),
  CONSTRAINT `fk_ventas_pedidos1`
    FOREIGN KEY (`pedidos_id`)
    REFERENCES `organiczoneBD`.`pedidos` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
