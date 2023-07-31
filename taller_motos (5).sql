-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-07-2023 a las 05:50:57
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `taller_motos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `barcode`
--

CREATE TABLE `barcode` (
  `id_barcode` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `barcode` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `barcode`
--

INSERT INTO `barcode` (`id_barcode`, `nombre`, `barcode`) VALUES
(7, 'null', '1'),
(21, 'tornillos', '12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `barcodem`
--

CREATE TABLE `barcodem` (
  `id_barcode` int(11) NOT NULL,
  `nombre` text NOT NULL,
  `barcode` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `barcodem`
--

INSERT INTO `barcodem` (`id_barcode`, `nombre`, `barcode`) VALUES
(1, 'Null', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cilindraje`
--

CREATE TABLE `cilindraje` (
  `id_cilindraje` int(11) NOT NULL,
  `cilindraje` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cilindraje`
--

INSERT INTO `cilindraje` (`id_cilindraje`, `cilindraje`) VALUES
(2, '150');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `color`
--

CREATE TABLE `color` (
  `id_color` int(11) NOT NULL,
  `color` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `color`
--

INSERT INTO `color` (`id_color`, `color`) VALUES
(1, 'negro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `combustible`
--

CREATE TABLE `combustible` (
  `id_combustible` int(11) NOT NULL,
  `combustible` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `combustible`
--

INSERT INTO `combustible` (`id_combustible`, `combustible`) VALUES
(1, 'gasolina');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `id_compra` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `documento` int(11) NOT NULL,
  `Total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compra`
--

CREATE TABLE `detalle_compra` (
  `id_comprac` int(11) NOT NULL,
  `cantidad_producto` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_compra` int(11) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_vdocu`
--

CREATE TABLE `detalle_vdocu` (
  `id_detadocu` int(11) NOT NULL,
  `id_documentos` varchar(100) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `id_venta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_venta`
--

CREATE TABLE `detalle_venta` (
  `id_detallev` int(11) NOT NULL,
  `id_producto` varchar(40) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `id_venta` int(11) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_vservi`
--

CREATE TABLE `detalle_vservi` (
  `id_detaservi` int(11) NOT NULL,
  `id_servicio` varchar(40) NOT NULL,
  `cantidad` tinyint(2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `id_venta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos`
--

CREATE TABLE `documentos` (
  `id_documentos` varchar(100) NOT NULL,
  `documentos` varchar(30) NOT NULL,
  `precio` varchar(100) NOT NULL,
  `tipo` varchar(10) NOT NULL DEFAULT 'documento'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `documentos`
--

INSERT INTO `documentos` (`id_documentos`, `documentos`, `precio`, `tipo`) VALUES
('10', 'SOAT', '1000000', 'documento'),
('20', 'TECNO', '200000', 'documento');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

CREATE TABLE `estado` (
  `id_estado` int(11) NOT NULL,
  `estados` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estado`
--

INSERT INTO `estado` (`id_estado`, `estados`) VALUES
(1, 'Activo'),
(2, 'Inactivo'),
(3, 'Disponible'),
(4, 'Próximo a agotar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_venta`
--

CREATE TABLE `factura_venta` (
  `id_venta` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `documento` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `placa` varchar(8) NOT NULL,
  `fecha_vigencia_soat` date DEFAULT NULL,
  `fecha_vigencia_tecnomecanica` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `linea`
--

CREATE TABLE `linea` (
  `id_linea` int(11) NOT NULL,
  `linea` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `linea`
--

INSERT INTO `linea` (`id_linea`, `linea`) VALUES
(1, '125');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marca`
--

CREATE TABLE `marca` (
  `id_marca` int(11) NOT NULL,
  `marca` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `marca`
--

INSERT INTO `marca` (`id_marca`, `marca`) VALUES
(1, 'xtz');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modelo`
--

CREATE TABLE `modelo` (
  `id_modelo` int(11) NOT NULL,
  `modelo` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `modelo`
--

INSERT INTO `modelo` (`id_modelo`, `modelo`) VALUES
(1, '2023');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `moto`
--

CREATE TABLE `moto` (
  `placa` varchar(8) NOT NULL,
  `id_marca` int(11) NOT NULL,
  `descripcion` varchar(90) DEFAULT NULL,
  `documento` int(11) NOT NULL,
  `km` int(11) NOT NULL,
  `ultimo_cambio` date DEFAULT NULL,
  `proximo_cambio_km` int(11) DEFAULT NULL,
  `proximo_cambio_fecha` date DEFAULT NULL,
  `id_linea` int(11) NOT NULL,
  `id_modelo` int(11) NOT NULL,
  `id_cilindraje` int(11) NOT NULL,
  `id_color` int(11) NOT NULL,
  `id_tip_servicio` int(11) NOT NULL,
  `id_clase` int(11) NOT NULL,
  `id_carroceria` int(11) NOT NULL,
  `capacidad` tinyint(2) NOT NULL,
  `id_combustible` int(11) NOT NULL,
  `numero_motor` varchar(20) NOT NULL,
  `vin` varchar(20) NOT NULL,
  `numero_chasis` varchar(20) NOT NULL,
  `barcode` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `moto`
--

INSERT INTO `moto` (`placa`, `id_marca`, `descripcion`, `documento`, `km`, `ultimo_cambio`, `proximo_cambio_km`, `proximo_cambio_fecha`, `id_linea`, `id_modelo`, `id_cilindraje`, `id_color`, `id_tip_servicio`, `id_clase`, `id_carroceria`, `capacidad`, `id_combustible`, `numero_motor`, `vin`, `numero_chasis`, `barcode`) VALUES
('100569', 1, 'jsjsj', 1005691779, 406, '2023-07-30', 3000, '2023-08-29', 1, 1, 2, 1, 1, 1, 1, 2, 1, '7272871828', '818282', '72737372', '100569'),
('slx02f', 1, 'kd', 1005691779, 383, '2023-07-30', 3000, '2023-08-29', 1, 1, 2, 1, 1, 1, 1, 2, 1, '939393939', '2838383838', '83838348', 'slx02f');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_productos` varchar(40) NOT NULL,
  `nom_producto` varchar(40) NOT NULL,
  `precio` decimal(9,2) NOT NULL,
  `descripcion` varchar(70) NOT NULL,
  `cantidad_ini` int(11) NOT NULL,
  `cantidad_ant` int(11) NOT NULL,
  `id_estado` int(11) NOT NULL,
  `barcode` varchar(100) NOT NULL,
  `tipo` varchar(10) NOT NULL DEFAULT 'producto'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_productos`, `nom_producto`, `precio`, `descripcion`, `cantidad_ini`, `cantidad_ant`, `id_estado`, `barcode`, `tipo`) VALUES
('1', 'tornillos', 123234.00, 'jsjsj', 2, 0, 3, '12', 'producto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio`
--

CREATE TABLE `servicio` (
  `id_servicios` varchar(40) NOT NULL,
  `servicio` varchar(20) NOT NULL,
  `precio` varchar(100) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `tipo` varchar(10) NOT NULL DEFAULT 'servicio'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `servicio`
--

INSERT INTO `servicio` (`id_servicios`, `servicio`, `precio`, `descripcion`, `tipo`) VALUES
('25', 'cambio aceite', '50000', 'ksk', 'servicio'),
('60', 'mano de obra', '50000', 'kckd', 'servicio');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_carroceria`
--

CREATE TABLE `tipo_carroceria` (
  `id_carroceria` int(11) NOT NULL,
  `carroceria` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_carroceria`
--

INSERT INTO `tipo_carroceria` (`id_carroceria`, `carroceria`) VALUES
(1, 'normal');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_servicio`
--

CREATE TABLE `tipo_servicio` (
  `id_tip_servicio` int(11) NOT NULL,
  `tip_servicio` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_servicio`
--

INSERT INTO `tipo_servicio` (`id_tip_servicio`, `tip_servicio`) VALUES
(1, 'parti');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_usuarios`
--

CREATE TABLE `tipo_usuarios` (
  `id_tip_usu` int(11) NOT NULL,
  `tip_usu` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_usuarios`
--

INSERT INTO `tipo_usuarios` (`id_tip_usu`, `tip_usu`) VALUES
(1, 'Administrador'),
(2, 'Cliente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_vehiculo`
--

CREATE TABLE `tipo_vehiculo` (
  `id_clase` int(11) NOT NULL,
  `tip_vehiculo` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_vehiculo`
--

INSERT INTO `tipo_vehiculo` (`id_clase`, `tip_vehiculo`) VALUES
(1, 'moto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `documento` int(11) NOT NULL,
  `nombre_completo` varchar(100) NOT NULL,
  `telefono` varchar(10) NOT NULL,
  `email` varchar(40) NOT NULL,
  `fecha_usu` date NOT NULL,
  `usuario` varchar(15) NOT NULL,
  `password` varchar(100) NOT NULL,
  `id_tip_usu` int(11) NOT NULL,
  `id_estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`documento`, `nombre_completo`, `telefono`, `email`, `fecha_usu`, `usuario`, `password`, `id_tip_usu`, `id_estado`) VALUES
(1234567, 'elver ', '3818813929', 'lopezcerquerajuanfrancisco@gmail', '2023-07-28', 'jusjqww223', '$2y$15$5a46XlI6dwRWGc9jBQ1Pru5HjIOJYMOEZ.qesWX5ZWPf88isEM9Bm', 2, 1),
(1005691779, 'Juan francisco lopez', '3136101695', 'lopezcerquerajuanfrancisco@gmail', '2002-02-22', 'juan123', '$2y$15$cKOZkiXOgzMIOjd.u7EXJOG.ZqrfsH6k2VS5HbZ32kAhZkm01rVhG', 2, 1),
(1234567890, 'Sebastian', '3087561234', 'juan@gmail.com', '2005-03-28', 'admin', '$2y$15$ddMGJZCJjRyJFDPP5Yszt.v.2yet7P3scBUVe7gRMaFPQV1y8Btne', 1, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `barcode`
--
ALTER TABLE `barcode`
  ADD PRIMARY KEY (`id_barcode`);

--
-- Indices de la tabla `barcodem`
--
ALTER TABLE `barcodem`
  ADD PRIMARY KEY (`id_barcode`);

--
-- Indices de la tabla `cilindraje`
--
ALTER TABLE `cilindraje`
  ADD PRIMARY KEY (`id_cilindraje`);

--
-- Indices de la tabla `color`
--
ALTER TABLE `color`
  ADD PRIMARY KEY (`id_color`);

--
-- Indices de la tabla `combustible`
--
ALTER TABLE `combustible`
  ADD PRIMARY KEY (`id_combustible`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id_compra`),
  ADD KEY `fk` (`documento`);

--
-- Indices de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD PRIMARY KEY (`id_comprac`),
  ADD KEY `id_compra` (`id_compra`),
  ADD KEY `fk` (`id_producto`,`id_compra`);

--
-- Indices de la tabla `detalle_vdocu`
--
ALTER TABLE `detalle_vdocu`
  ADD PRIMARY KEY (`id_detadocu`),
  ADD KEY `id_documentos` (`id_documentos`),
  ADD KEY `id_venta` (`id_venta`);

--
-- Indices de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD PRIMARY KEY (`id_detallev`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `id_venta` (`id_venta`);

--
-- Indices de la tabla `detalle_vservi`
--
ALTER TABLE `detalle_vservi`
  ADD PRIMARY KEY (`id_detaservi`),
  ADD KEY `id_servicio` (`id_servicio`),
  ADD KEY `id_venta` (`id_venta`);

--
-- Indices de la tabla `documentos`
--
ALTER TABLE `documentos`
  ADD PRIMARY KEY (`id_documentos`);

--
-- Indices de la tabla `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`id_estado`);

--
-- Indices de la tabla `factura_venta`
--
ALTER TABLE `factura_venta`
  ADD PRIMARY KEY (`id_venta`),
  ADD KEY `fk` (`documento`,`placa`),
  ADD KEY `placa` (`placa`);

--
-- Indices de la tabla `linea`
--
ALTER TABLE `linea`
  ADD PRIMARY KEY (`id_linea`);

--
-- Indices de la tabla `marca`
--
ALTER TABLE `marca`
  ADD PRIMARY KEY (`id_marca`);

--
-- Indices de la tabla `modelo`
--
ALTER TABLE `modelo`
  ADD PRIMARY KEY (`id_modelo`);

--
-- Indices de la tabla `moto`
--
ALTER TABLE `moto`
  ADD PRIMARY KEY (`placa`),
  ADD KEY `fk` (`id_marca`,`documento`),
  ADD KEY `id_tip_servicio` (`id_tip_servicio`),
  ADD KEY `id_modelo` (`id_modelo`),
  ADD KEY `id_linea` (`id_linea`),
  ADD KEY `id_combustible` (`id_combustible`),
  ADD KEY `id_color` (`id_color`),
  ADD KEY `id_clase` (`id_clase`),
  ADD KEY `id_cilindraje` (`id_cilindraje`),
  ADD KEY `id_carroceria` (`id_carroceria`),
  ADD KEY `documento` (`documento`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_productos`),
  ADD KEY `fk` (`id_estado`);

--
-- Indices de la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD PRIMARY KEY (`id_servicios`);

--
-- Indices de la tabla `tipo_carroceria`
--
ALTER TABLE `tipo_carroceria`
  ADD PRIMARY KEY (`id_carroceria`);

--
-- Indices de la tabla `tipo_servicio`
--
ALTER TABLE `tipo_servicio`
  ADD PRIMARY KEY (`id_tip_servicio`);

--
-- Indices de la tabla `tipo_usuarios`
--
ALTER TABLE `tipo_usuarios`
  ADD PRIMARY KEY (`id_tip_usu`);

--
-- Indices de la tabla `tipo_vehiculo`
--
ALTER TABLE `tipo_vehiculo`
  ADD PRIMARY KEY (`id_clase`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`documento`),
  ADD KEY `id_estado` (`id_estado`),
  ADD KEY `id_tip_usu` (`id_tip_usu`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `barcode`
--
ALTER TABLE `barcode`
  MODIFY `id_barcode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `barcodem`
--
ALTER TABLE `barcodem`
  MODIFY `id_barcode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id_compra` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  MODIFY `id_comprac` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_vdocu`
--
ALTER TABLE `detalle_vdocu`
  MODIFY `id_detadocu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  MODIFY `id_detallev` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `detalle_vservi`
--
ALTER TABLE `detalle_vservi`
  MODIFY `id_detaservi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `factura_venta`
--
ALTER TABLE `factura_venta`
  MODIFY `id_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT de la tabla `marca`
--
ALTER TABLE `marca`
  MODIFY `id_marca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD CONSTRAINT `detalle_compra_ibfk_2` FOREIGN KEY (`id_compra`) REFERENCES `compras` (`id_compra`);

--
-- Filtros para la tabla `detalle_vdocu`
--
ALTER TABLE `detalle_vdocu`
  ADD CONSTRAINT `detalle_vdocu_ibfk_2` FOREIGN KEY (`id_venta`) REFERENCES `factura_venta` (`id_venta`) ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_vdocu_ibfk_3` FOREIGN KEY (`id_documentos`) REFERENCES `documentos` (`id_documentos`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD CONSTRAINT `detalle_venta_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_productos`),
  ADD CONSTRAINT `detalle_venta_ibfk_2` FOREIGN KEY (`id_venta`) REFERENCES `factura_venta` (`id_venta`);

--
-- Filtros para la tabla `detalle_vservi`
--
ALTER TABLE `detalle_vservi`
  ADD CONSTRAINT `detalle_vservi_ibfk_2` FOREIGN KEY (`id_venta`) REFERENCES `factura_venta` (`id_venta`) ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_vservi_ibfk_3` FOREIGN KEY (`id_servicio`) REFERENCES `servicio` (`id_servicios`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `factura_venta`
--
ALTER TABLE `factura_venta`
  ADD CONSTRAINT `factura_venta_ibfk_2` FOREIGN KEY (`documento`) REFERENCES `usuarios` (`documento`),
  ADD CONSTRAINT `factura_venta_ibfk_3` FOREIGN KEY (`placa`) REFERENCES `moto` (`placa`);

--
-- Filtros para la tabla `moto`
--
ALTER TABLE `moto`
  ADD CONSTRAINT `moto_ibfk_1` FOREIGN KEY (`id_marca`) REFERENCES `marca` (`id_marca`) ON UPDATE CASCADE,
  ADD CONSTRAINT `moto_ibfk_10` FOREIGN KEY (`id_carroceria`) REFERENCES `tipo_carroceria` (`id_carroceria`) ON UPDATE CASCADE,
  ADD CONSTRAINT `moto_ibfk_11` FOREIGN KEY (`documento`) REFERENCES `usuarios` (`documento`) ON UPDATE CASCADE,
  ADD CONSTRAINT `moto_ibfk_3` FOREIGN KEY (`id_tip_servicio`) REFERENCES `tipo_servicio` (`id_tip_servicio`) ON UPDATE CASCADE,
  ADD CONSTRAINT `moto_ibfk_4` FOREIGN KEY (`id_modelo`) REFERENCES `modelo` (`id_modelo`) ON UPDATE CASCADE,
  ADD CONSTRAINT `moto_ibfk_5` FOREIGN KEY (`id_linea`) REFERENCES `linea` (`id_linea`) ON UPDATE CASCADE,
  ADD CONSTRAINT `moto_ibfk_6` FOREIGN KEY (`id_combustible`) REFERENCES `combustible` (`id_combustible`) ON UPDATE CASCADE,
  ADD CONSTRAINT `moto_ibfk_7` FOREIGN KEY (`id_color`) REFERENCES `color` (`id_color`) ON UPDATE CASCADE,
  ADD CONSTRAINT `moto_ibfk_8` FOREIGN KEY (`id_clase`) REFERENCES `tipo_vehiculo` (`id_clase`) ON UPDATE CASCADE,
  ADD CONSTRAINT `moto_ibfk_9` FOREIGN KEY (`id_cilindraje`) REFERENCES `cilindraje` (`id_cilindraje`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`) ON UPDATE CASCADE,
  ADD CONSTRAINT `usuarios_ibfk_2` FOREIGN KEY (`id_tip_usu`) REFERENCES `tipo_usuarios` (`id_tip_usu`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
