-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-09-2026 a las 16:45:14
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `organiczonebd`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `pedidos_id` int(11) NOT NULL,
  `productos_id` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `costototal` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `carrito`
--

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `estado` varchar(45) DEFAULT NULL,
  `nombrevendedor` varchar(45) DEFAULT NULL,
  `direccion` varchar(45) DEFAULT NULL,
  `telefono` varchar(45) DEFAULT NULL,
  `metodo` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `nombre`, `fecha`, `estado`, `nombrevendedor`, `direccion`, `telefono`, `metodo`) VALUES
(5, 'Dominga Barrios', '2026-09-08', 'En proceso', 'Jhanael', ' America y Santa Cruz', '7076767', NULL),
(7, 'Juan Pedro', '2026-09-08', 'En proceso', 'Jhanael', ' Av.Ayacucho ', '67676767', NULL),
(8, 'Patsey', '0000-00-00', 'En proceso', 'Jhanael', ' Ayacucho y Aroma', '12121313', NULL),
(9, 'Rebeca Torrez', '0000-00-00', 'Pendiente', 'Jhanael', ' Sacaba km7', '8888888', NULL),
(10, 'Mateo Tauca Tauca', '0000-00-00', 'En proceso', 'Jhanael', ' Plaza Sucre', '67676767', NULL),
(11, 'Sebastian', '2026-09-08', 'Pendiente', NULL, 'su casa', '73349704', 'QR');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `precio` int(11) DEFAULT NULL,
  `costo` int(11) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `precio`, `costo`, `stock`) VALUES
(1, 'papas', 'papas fritas, con un toque de oregano', 5, 3, 22),
(3, 'Beyond Burguer', 'Hamburguesa a base de lenteja PRODUCTO ESTREL', 20, 15, 21),
(4, 'ChikiOZ', 'Hamburguesa a base de lenteja para niños', 15, 10, 25);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `CI` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `direccion` varchar(45) DEFAULT NULL,
  `celular` varchar(45) DEFAULT NULL,
  `rol` varchar(45) DEFAULT NULL,
  `estado` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`CI`, `nombre`, `direccion`, `celular`, `rol`, `estado`) VALUES
(1, '', '', '', '', ''),
(13529375, 'Fabricio', 'su casa', '676767676', 'vendedor', 'activo'),
(13575435, 'Nagai', 'mi casa', '70376053', 'admin', 'activo'),
(14584266, 'Jhanael', 'mi casa', '67571882', 'vendedor', 'activo'),
(14622765, 'Sebastian', 'su casa', '73349704', 'cliente', 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `estado` varchar(45) DEFAULT NULL,
  `metodo` varchar(45) DEFAULT NULL,
  `costototal` int(11) DEFAULT NULL,
  `pedidos_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `estado`, `metodo`, `costototal`, `pedidos_id`) VALUES
(1, 'En proceso', 'QR', 70, 5),
(2, 'En proceso', 'Efectivo', 70, 5),
(3, 'En proceso', 'QR', 25, 7),
(4, 'En proceso', 'Transferencia', 130, 8);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`pedidos_id`,`productos_id`),
  ADD KEY `fk_pedidos_has_productos_productos1_idx` (`productos_id`),
  ADD KEY `fk_pedidos_has_productos_pedidos_idx` (`pedidos_id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`CI`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`,`pedidos_id`),
  ADD KEY `fk_ventas_pedidos1` (`pedidos_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `CI` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14622766;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `fk_pedidos_has_productos_pedidos` FOREIGN KEY (`pedidos_id`) REFERENCES `pedidos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pedidos_has_productos_productos1` FOREIGN KEY (`productos_id`) REFERENCES `productos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `fk_ventas_pedidos1` FOREIGN KEY (`pedidos_id`) REFERENCES `pedidos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
