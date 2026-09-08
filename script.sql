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

ALTER TABLE pedidos ADD COLUMN `metodo` VARCHAR(45) NULL AFTER `telefono`;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;


INSERT INTO `usuarios` (`CI`, `nombre`, `direccion`, `celular`, `rol`, `estado`) VALUES
(1, '', '', '', '', ''),
(13529375, 'Fabricio', 'su casa', '676767676', 'vendedor', 'activo'),
(13575435, 'Nagai', 'mi casa', '70376053', 'admin', 'activo'),
(14584266, 'Jhanael', 'mi casa', '67571882', 'vendedor', 'activo'),
(14622765, 'Sebastian', 'su casa', '73349704', 'cliente', 'activo');

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `precio`, `costo`, `stock`) VALUES
(1, 'papas', 'papas fritas, con un toque de oregano', 5, 3, 22),
(3, 'Beyond Burguer', 'Hamburguesa a base de lenteja PRODUCTO ESTREL', 20, 15, 21),
(4, 'ChikiOZ', 'Hamburguesa a base de lenteja para niños', 15, 10, 25);

INSERT INTO `pedidos` (`id`, `nombre`, `fecha`, `estado`, `nombrevendedor`, `direccion`, `telefono`, `metodo`) VALUES
(5, 'Dominga Barrios', '2026-09-08', 'En proceso', 'Jhanael', ' America y Santa Cruz', '7076767', NULL),
(7, 'Juan Pedro', '2026-09-08', 'En proceso', 'Jhanael', ' Av.Ayacucho ', '67676767', NULL),
(8, 'Patsey', '0000-00-00', 'En proceso', 'Jhanael', ' Ayacucho y Aroma', '12121313', NULL),
(9, 'Rebeca Torrez', '0000-00-00', 'Pendiente', 'Jhanael', ' Sacaba km7', '8888888', NULL),
(10, 'Mateo Tauca Tauca', '0000-00-00', 'En proceso', 'Jhanael', ' Plaza Sucre', '67676767', NULL),
(11, 'Sebastian', '2026-09-08', 'Pendiente', NULL, 'su casa', '73349704', 'QR');

INSERT INTO `carrito` (`pedidos_id`, `productos_id`, `cantidad`, `costototal`) VALUES
(5, 1, 3, 15),
(5, 3, 2, 40),
(5, 4, 1, 15),
(7, 1, 1, 5),
(7, 3, 1, 20),
(8, 1, 1, 5),
(8, 3, 4, 80),
(8, 4, 3, 45),
(9, 1, 4, 20),
(9, 3, 6, 120),
(9, 4, 4, 60),
(10, 1, 2, 10),
(10, 3, 1, 20),
(11, 1, 3, 15),
(11, 3, 1, 20),
(11, 4, 2, 30);


INSERT INTO `ventas` (`id`, `estado`, `metodo`, `costototal`, `pedidos_id`) VALUES
(1, 'En proceso', 'QR', 70, 5),
(2, 'En proceso', 'Efectivo', 70, 5),
(3, 'En proceso', 'QR', 25, 7),
(4, 'En proceso', 'Transferencia', 130, 8);