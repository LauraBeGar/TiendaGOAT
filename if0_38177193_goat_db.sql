-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: sql302.infinityfree.com
-- Tiempo de generación: 09-02-2025 a las 13:42:57
-- Versión del servidor: 10.6.19-MariaDB
-- Versión de PHP: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `if0_38177193_goat_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `codigo` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `codCategoriaPadre` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`codigo`, `nombre`, `activo`, `codCategoriaPadre`) VALUES
(1, 'Escalada', 1, 0),
(2, 'Via ferrata', 1, 0),
(3, 'Barranquismo', 1, 0),
(4, 'RocÃ³dromo', 1, 0),
(11, 'Arneses', 1, 1),
(12, 'Cuerdas', 1, 1),
(13, 'Pies de gato', 1, 1),
(21, 'Disipadores', 1, 2),
(22, 'Bagas de descanso', 1, 2),
(31, 'Neoprenos', 1, 3),
(32, 'Cascos', 1, 3),
(41, 'Presas', 1, 4),
(42, 'Magnesio', 1, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `linea_pedido`
--

CREATE TABLE `linea_pedido` (
  `num_pedido` int(11) NOT NULL,
  `cod_producto` varchar(8) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` float NOT NULL,
  `nombre_producto` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `linea_pedido`
--

INSERT INTO `linea_pedido` (`num_pedido`, `cod_producto`, `cantidad`, `precio`, `nombre_producto`) VALUES
(3, 'arn1', 1, 50, 'Arnes CORAX'),
(4, 'arn3', 1, 85, 'Arnes 003'),
(4, 'dis1', 1, 75, 'Disipador'),
(4, 'bag1', 1, 40, 'Cabo de descanso BEAL');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `idPedido` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `total` float NOT NULL,
  `estado` varchar(50) NOT NULL DEFAULT 'Proceso',
  `cod_usuario` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`idPedido`, `fecha`, `total`, `estado`, `cod_usuario`) VALUES
(3, '2025-02-09', 50, 'Cancelado', '48554971Q'),
(4, '2025-02-09', 200, 'Preparando', '48554971Q');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `codigo` varchar(8) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `imagen` varchar(200) NOT NULL,
  `categoria` int(11) NOT NULL,
  `precio` float NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`codigo`, `nombre`, `descripcion`, `imagen`, `categoria`, `precio`, `activo`) VALUES
('arn1', 'Arnes CORAX', 'Arnes de escalada para principiantes', 'arnes CORAX R.png', 11, 50, 1),
('arn2', 'Arnes EXPLORA', 'Arnes para escalada clasica', 'explora-harness R.jpg', 11, 105, 1),
('arn3', 'Arnes 003', 'arnes de escalada  deportiva', '003 R.jpg', 11, 85, 0),
('bag1', 'Cabo de descanso BEAL', 'Cabo de anclaje para descanso en via ferrata', 'Baga de descaso BEAL.jpg', 22, 40, 1),
('bag2', 'Cabo de anclaje KIT BELAY', 'Kit basico para via ferrata', 'viaferratabelaykit15medelrid.jpg', 22, 30, 0),
('dis1', 'Disipador', 'Disipador para via ferrata', 'disipador (1).jpg', 21, 75, 1),
('dis2', 'Disipador EDELRID', 'Disipador para via ferrata', 'disipador EDELRID.jpg', 21, 35, 1),
('pie1', 'Pies de gato TENAYA ARAI', 'Pies de gato para escalada deportiva', 'Tenaya arai R.jpg', 13, 80, 1),
('pie2', 'Tenaya tanta green', 'Pie de gato para escalada deportiva', 'Tenaya tanta green R.jpg', 13, 63, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `dni` varchar(9) NOT NULL,
  `clave` varchar(60) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellidos` varchar(80) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `localidad` varchar(30) NOT NULL,
  `provincia` varchar(30) NOT NULL,
  `telefono` varchar(9) NOT NULL,
  `email` varchar(30) NOT NULL,
  `rol` tinyint(1) NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`dni`, `clave`, `nombre`, `apellidos`, `direccion`, `localidad`, `provincia`, `telefono`, `email`, `rol`, `activo`) VALUES
('12345678Z', '$2y$10$OJVAGIEYnB/.0b9zLK3bjeSfIDD8kSH6QtSIfZZb0AEHp03oGcZce', 'juan', 'Lopez', '', '', '', '', 'juan@juan.es', 0, 0),
('48554971Q', '$2y$10$ZzcSlmNGvL09xVWwkKD/pOGZV6PslbirEZg9bhEKBpi5bB3ng6zjG', 'Lucia', 'Bernal', 'Calle calderon de la barca,5', 'Benferri', 'Alicante', '631212223', 'lucia@lucia.com', 0, 1),
('48697363S', '$2y$10$xUWbCFnI7p/i0KgavcieE./eCDWOEhqXlKXC2It6GbyCQVYIjTCKO', 'Laura', 'Bernal', 'calle ciruela', 'murcia', 'murcia', '666666666', 'laura@laura.com', 1, 1),
('74383233Z', '$2y$10$4lwVFTuaHkbSo1QNRoE6iOqmaGJe9CgwPBKwOeBAabfeNFFAHc/Aa', 'Javier', 'rubio', 'calle cinco', 'Jaen', 'Jaen', '666666666', 'javi@javi.com', 2, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `linea_pedido`
--
ALTER TABLE `linea_pedido`
  ADD KEY `FK_cod_producto` (`cod_producto`),
  ADD KEY `FK_num_pedido` (`num_pedido`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`idPedido`),
  ADD KEY `FK_cod_usuario` (`cod_usuario`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `FK_categoria` (`categoria`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`dni`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `linea_pedido`
--
ALTER TABLE `linea_pedido`
  ADD CONSTRAINT `linea_pedido_ibfk_1` FOREIGN KEY (`cod_producto`) REFERENCES `productos` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `linea_pedido_ibfk_2` FOREIGN KEY (`num_pedido`) REFERENCES `pedidos` (`idPedido`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`cod_usuario`) REFERENCES `usuarios` (`dni`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`categoria`) REFERENCES `categorias` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
