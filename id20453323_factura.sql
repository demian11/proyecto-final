-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 27-07-2023 a las 18:13:24
-- Versión del servidor: 10.5.20-MariaDB
-- Versión de PHP: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `id20453323_factura`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `idcliente` int(11) NOT NULL,
  `nit` int(11) DEFAULT NULL,
  `nombre` varchar(80) DEFAULT NULL,
  `telefono` int(11) DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `dateadd` datetime NOT NULL DEFAULT current_timestamp(),
  `usuario_id` int(11) NOT NULL,
  `estatus` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`idcliente`, `nit`, `nombre`, `telefono`, `direccion`, `dateadd`, `usuario_id`, `estatus`) VALUES
(1, 123456789, 'damian plascencia', 2147483647, 'demian1155@outlook.com', '2023-03-07 12:52:45', 0, 1),
(2, 1234568, 'omar magaña', 2147483647, 'av de la musica', '2023-03-08 11:25:22', 1, 1),
(3, 87346923, 'derian', 331199443, 'san juan', '2023-03-08 13:37:05', 1, 1),
(4, 0, 'damian', 2147483647, 'demian1155@outlook.com', '2023-03-08 18:05:00', 1, 0),
(5, 90, 'damian', 2147483647, 'demian1155@outlook.com', '2023-03-08 18:05:12', 1, 1),
(6, 0, 'damian', 2147483647, 'demian1155@outlook.com', '2023-03-08 18:06:07', 1, 0),
(7, 2147483647, 'anette', 2147483647, 'anette1@gmail.com', '2023-03-08 18:12:56', 1, 1),
(8, 33, 'juan carlos', 2147483647, 'av patri', '2023-03-08 18:18:20', 1, 0),
(9, 2147483647, 'carlos', 2147483647, 'av de la musica', '2023-03-17 18:29:00', 1, 1),
(10, 2147483647, 'juan carlos', 2147483647, 'av de la musica', '2023-03-17 18:39:21', 1, 1),
(11, 2147483647, '', 0, '', '2023-03-17 18:39:56', 1, 1),
(12, 90, '', 0, '', '2023-03-17 19:04:23', 4, 1),
(13, 90, '', 0, '', '2023-03-17 20:25:42', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE `configuracion` (
  `id` bigint(20) NOT NULL,
  `nit` varchar(20) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `razon_social` varchar(100) NOT NULL,
  `telefono` bigint(20) NOT NULL,
  `email` varchar(200) NOT NULL,
  `direccion` text NOT NULL,
  `iva` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`id`, `nit`, `nombre`, `razon_social`, `telefono`, `email`, `direccion`, `iva`) VALUES
(1, '3322293187', 'dd tech', '', 3314675021, 'ddtech@outlook.com', 'av niños heroes', 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallefactura`
--

CREATE TABLE `detallefactura` (
  `correlativo` bigint(11) NOT NULL,
  `nofactura` bigint(11) DEFAULT NULL,
  `codproducto` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio_venta` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `detallefactura`
--

INSERT INTO `detallefactura` (`correlativo`, `nofactura`, `codproducto`, `cantidad`, `precio_venta`) VALUES
(1, 1, 2, 1, 2300.00),
(2, 1, 2, 1, 2300.00),
(4, 2, 2, 1, 2300.00),
(5, 2, 2, 1, 2300.00),
(7, 3, 2, 1, 2300.00),
(8, 3, 2, 1, 2300.00),
(10, 4, 2, 1, 2300.00),
(11, 5, 2, 1, 2300.00),
(12, 5, 3, 1, 120.00),
(14, 6, 2, 1, 2300.00),
(15, 6, 3, 1, 120.00),
(16, 6, 3, 1, 120.00),
(17, 7, 2, 1, 2300.00),
(18, 7, 3, 1, 120.00),
(19, 7, 3, 1, 120.00),
(20, 8, 4, 1, 120.00),
(21, 9, 2, 1, 2300.00),
(22, 9, 4, 1, 120.00),
(24, 10, 2, 1, 2300.00),
(25, 10, 4, 1, 120.00),
(26, 10, 6, 5, 30.00),
(27, 11, 2, 1, 2300.00),
(28, 11, 4, 1, 120.00),
(29, 11, 6, 5, 30.00),
(30, 12, 2, 1, 2300.00),
(31, 12, 4, 1, 120.00),
(32, 12, 6, 5, 30.00),
(33, 13, 2, 1, 2300.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_temp`
--

CREATE TABLE `detalle_temp` (
  `correlativo` int(11) NOT NULL,
  `token_user` varchar(50) NOT NULL,
  `codproducto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_venta` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `detalle_temp`
--

INSERT INTO `detalle_temp` (`correlativo`, `token_user`, `codproducto`, `cantidad`, `precio_venta`) VALUES
(27, 'a87ff679a2f3e71d9181a67b7542122c', 2, 1, 2300.00),
(28, 'a87ff679a2f3e71d9181a67b7542122c', 3, 1, 120.00),
(29, 'a87ff679a2f3e71d9181a67b7542122c', 3, 1, 120.00),
(31, 'c81e728d9d4c2f636f067f89cc14862c', 2, 1, 2300.00),
(36, 'c4ca4238a0b923820dcc509a6f75849b', 2, 1, 2300.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entradas`
--

CREATE TABLE `entradas` (
  `correlativo` int(11) NOT NULL,
  `codproducto` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `cantidad` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `usuario_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `entradas`
--

INSERT INTO `entradas` (`correlativo`, `codproducto`, `fecha`, `cantidad`, `precio`, `usuario_id`) VALUES
(1, 1, '2023-03-10 15:05:39', 150, 110.00, 1),
(2, 2, '2023-03-10 15:11:25', 100, 2500.00, 1),
(3, 3, '2023-03-11 13:46:46', 5, 120.00, 1),
(4, 4, '2023-03-11 14:09:01', 5, 120.00, 1),
(5, 5, '2023-03-11 14:55:01', 5, 120.00, 1),
(6, 6, '2023-03-12 16:50:43', 40, 30.00, 1),
(7, 7, '2023-03-14 13:05:56', 100, 50.00, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `nofactura` bigint(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `usuario` int(11) DEFAULT NULL,
  `codcliente` int(11) DEFAULT NULL,
  `totalfactura` decimal(10,2) DEFAULT NULL,
  `estatus` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `factura`
--

INSERT INTO `factura` (`nofactura`, `fecha`, `usuario`, `codcliente`, `totalfactura`, `estatus`) VALUES
(1, '2023-03-20 22:15:41', 4, 1, NULL, 1),
(2, '2023-03-20 22:23:03', 4, 1, NULL, 1),
(3, '2023-03-20 22:30:55', 4, 5, NULL, 1),
(4, '2023-03-20 22:39:40', 4, 5, NULL, 1),
(5, '2023-03-20 23:14:45', 4, 5, NULL, 1),
(6, '2023-03-20 23:28:36', 4, 5, NULL, 1),
(7, '2023-03-20 23:28:50', 4, 5, NULL, 1),
(8, '2023-03-21 10:26:56', 2, 1, NULL, 1),
(9, '2023-03-21 22:27:17', 1, 5, NULL, 1),
(10, '2023-03-21 22:58:20', 1, 5, NULL, 1),
(11, '2023-03-22 12:39:44', 1, 1, NULL, 1),
(12, '2023-03-22 14:05:49', 1, 1, NULL, 1),
(13, '2023-03-22 16:30:01', 1, 1, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `codproducto` int(11) NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `proveedor` int(11) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `existencia` int(11) DEFAULT NULL,
  `date_add` datetime NOT NULL DEFAULT current_timestamp(),
  `usuario_id` int(11) NOT NULL,
  `estatus` int(11) NOT NULL DEFAULT 1,
  `foto` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`codproducto`, `descripcion`, `proveedor`, `precio`, `existencia`, `date_add`, `usuario_id`, `estatus`, `foto`) VALUES
(1, 'Mouse USB', 11, 110.00, 150, '2023-03-10 15:05:39', 1, 0, 'img_bd34b64f780f855dafd8bbc3d11c6553.jpg'),
(2, 'Monitor', 7, 2300.00, 85, '2023-03-10 15:11:25', 1, 1, 'img_8f4e7a68f94c60e28cecf5b986683947.jpg'),
(3, 'usb', 2, 130.00, 0, '2023-03-11 13:46:46', 1, 1, 'img_ca145dae5ce6bd973b34d2ddc8f8b2afjpg'),
(4, 'mouse', 11, 120.00, 0, '2023-03-11 14:09:01', 1, 1, 'img_2c4470227239c29d7d94a3c0fe0eacc3.jpg'),
(5, 'usb', 11, 120.00, 5, '2023-03-11 14:55:01', 1, 1, 'img_f87d0391cb1b9fce0b2379cd0c8eb601.jpg'),
(6, 'plumas de colores', 1, 30.00, 25, '2023-03-12 16:50:43', 1, 1, 'img_6e6287758d57d47c1d55b57e2320811e.jpg'),
(7, 'cuaderno de ralla', 1, 50.00, 100, '2023-03-14 13:05:56', 1, 1, 'img_ff2c320f9c35bd9a21de841f01510129.jpg');

--
-- Disparadores `producto`
--
DELIMITER $$
CREATE TRIGGER `entradas_A_I` AFTER INSERT ON `producto` FOR EACH ROW BEGIN
INSERT INTO entradas(codproducto,cantidad,precio,usuario_id)
VALUE (new.codproducto,new.existencia,new.precio,new.usuario_id);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `codproveedor` int(11) NOT NULL,
  `proveedor` varchar(100) DEFAULT NULL,
  `contacto` varchar(100) DEFAULT NULL,
  `telefono` bigint(11) DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `date_add` datetime NOT NULL DEFAULT current_timestamp(),
  `usuario_id` int(11) NOT NULL,
  `estatus` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`codproveedor`, `proveedor`, `contacto`, `telefono`, `direccion`, `date_add`, `usuario_id`, `estatus`) VALUES
(1, 'BIC', 'Claudia Rosales', 789877889, 'Avenida las Americas', '2023-03-09 13:05:18', 0, 1),
(2, 'CASIO', 'Jorge Herrera', 565656565656, 'Calzada Las Flores', '2023-03-09 13:05:18', 0, 1),
(3, 'Omega', 'Julio Estrada', 982877489, 'Avenida Elena Zona 4, Guatemala', '2023-03-09 13:05:18', 0, 1),
(4, 'Dell Compani', 'Roberto Estrada', 2147483646, 'Guatemala, Guatemala', '2023-03-09 13:05:18', 0, 1),
(5, 'Olimpia S.A', 'Elena Franco Morales', 564535676, '5ta. Avenida Zona 4 Ciudad', '2023-03-09 13:05:18', 0, 1),
(6, 'Oster', 'Fernando Guerra', 78987678, 'Calzada La Paz, Guatemala', '2023-03-09 13:05:18', 0, 1),
(7, 'ACELTECSA S.A', 'Ruben PÃ©rez', 789879889, 'Colonia las Victorias', '2023-03-09 13:05:18', 0, 1),
(8, 'Sony', 'Julieta Contreras', 89476787, 'Antigua Guatemala', '2023-03-09 13:05:18', 0, 1),
(9, 'VAIO', 'Felix Arnoldo Rojas', 476378276, 'Avenida las Americas Zona 13', '2023-03-09 13:05:18', 0, 1),
(10, 'SUMAR', 'Oscar Maldonado', 788376787, 'Colonia San Jose, Zona 5 Guatemala', '2023-03-09 13:05:18', 0, 1),
(11, 'HP', 'Angel Cardona', 2147483647, '5ta. calle zona 4 Guatemala', '2023-03-09 13:05:18', 0, 1),
(12, 'BIG', 'alejandro tejeda', 33221188987, 'av de la musica', '2023-03-09 13:50:33', 1, 1),
(13, 'BIG', 'alejandro tejeda', 33221188987, 'av de la musica', '2023-03-09 14:17:31', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `idrol` int(11) NOT NULL,
  `rol` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`idrol`, `rol`) VALUES
(1, 'Administrador'),
(2, 'Supervisor'),
(3, 'Vendedor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idusuario` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `usuario` varchar(15) DEFAULT NULL,
  `clave` varchar(100) DEFAULT NULL,
  `rol` int(11) DEFAULT NULL,
  `estatus` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusuario`, `nombre`, `correo`, `usuario`, `clave`, `rol`, `estatus`) VALUES
(1, 'damian plascencia', 'demian1155@outlook.com', 'admin', '25f9e794323b453885f5181f1b624d0b', 1, 1),
(2, 'Damian Omar ', 'damian1@outlook.com', 'damian', '25f9e794323b453885f5181f1b624d0b', 3, 1),
(3, 'derian', 'derian11@outlook.com', 'derian', '1facc41cbd6797ab981c661e400f5b8e', 1, 1),
(4, 'jaime omar', 'jaime@outlook.com', 'jaime', '81dc9bdb52d04dc20036dbd8313ed055', 2, 1),
(5, 'matias', 'matias99@gmail.com', 'matias', 'c95ee506b1bfeab0f9ad36a22c9a54b2', 3, 0),
(6, 'andrea magaña', 'andreanicoleplascencia@gmail.com', 'vendedor', '81dc9bdb52d04dc20036dbd8313ed055', 3, 0),
(7, 'juan galban', 'juan123@gmail.com', 'juan', '81dc9bdb52d04dc20036dbd8313ed055', 2, 1),
(8, 'omar tejeda', 'omar321@gmail.com', 'omar', 'bf2ccc7c941ec36186839fde9f4e18e4', 3, 1),
(9, 'annete', 'annete@outlook.com', 'annete', 'bf2ccc7c941ec36186839fde9f4e18e4', 2, 1),
(10, 'valeria yunuen', 'valeria4321@outlook.com', 'valeria', '81dc9bdb52d04dc20036dbd8313ed055', 3, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`idcliente`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detallefactura`
--
ALTER TABLE `detallefactura`
  ADD PRIMARY KEY (`correlativo`),
  ADD KEY `codproducto` (`codproducto`),
  ADD KEY `nofactura` (`nofactura`);

--
-- Indices de la tabla `detalle_temp`
--
ALTER TABLE `detalle_temp`
  ADD PRIMARY KEY (`correlativo`),
  ADD KEY `nofactura` (`token_user`),
  ADD KEY `codproducto` (`codproducto`);

--
-- Indices de la tabla `entradas`
--
ALTER TABLE `entradas`
  ADD PRIMARY KEY (`correlativo`),
  ADD KEY `codproducto` (`codproducto`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`nofactura`),
  ADD KEY `usuario` (`usuario`),
  ADD KEY `codcliente` (`codcliente`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`codproducto`),
  ADD KEY `proveedor` (`proveedor`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`codproveedor`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`idrol`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`),
  ADD KEY `rol` (`rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `idcliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `detallefactura`
--
ALTER TABLE `detallefactura`
  MODIFY `correlativo` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `detalle_temp`
--
ALTER TABLE `detalle_temp`
  MODIFY `correlativo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `entradas`
--
ALTER TABLE `entradas`
  MODIFY `correlativo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `nofactura` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `codproducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `codproveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
