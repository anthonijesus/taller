-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-04-2023 a las 04:36:56
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ajmfix`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `banco`
--

CREATE TABLE `banco` (
  `cod_banco` int(2) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `nro_cuenta` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `ID_Cliente` int(11) NOT NULL,
  `CI` varchar(20) DEFAULT NULL,
  `nom_ape` varchar(50) DEFAULT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `username` varchar(11) DEFAULT NULL,
  `date_add` datetime NOT NULL DEFAULT current_timestamp(),
  `estatus` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`ID_Cliente`, `CI`, `nom_ape`, `direccion`, `telefono`, `username`, `date_add`, `estatus`) VALUES
(43, '', 'Cliente Generico Salinas', 'Salinas, Canelones', 'No Aplica', 'admin', '2023-04-01 22:35:39', 1),
(44, '', 'Romina Mardones', 'Pando, Canelones', '098609880', 'admin', '2023-04-01 22:38:58', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `cod_compra` int(11) NOT NULL,
  `nro_fact` int(5) NOT NULL,
  `fecha` datetime DEFAULT current_timestamp(),
  `descripcion` varchar(200) DEFAULT NULL,
  `proveedor` int(11) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `estatus` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`cod_compra`, `nro_fact`, `fecha`, `descripcion`, `proveedor`, `precio`, `username`, `estatus`) VALUES
(9, 379391, '2023-04-01 23:35:38', 'Display: Samsung A505 - iPhone 6s', 1, '4880.00', 'admin', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipos`
--

CREATE TABLE `equipos` (
  `id_equipo` int(11) NOT NULL,
  `equipo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `equipos`
--

INSERT INTO `equipos` (`id_equipo`, `equipo`) VALUES
(1, 'Celular'),
(2, 'Pcs');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estatus`
--

CREATE TABLE `estatus` (
  `id_estatus` int(11) NOT NULL,
  `estatus` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estatus`
--

INSERT INTO `estatus` (`id_estatus`, `estatus`) VALUES
(1, 'Pendiente de Revisión'),
(2, 'Reparado'),
(3, 'En espera de Repuesto'),
(4, 'Facturado'),
(5, 'Pendiente de Facturar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE `facturas` (
  `nro_factura` bigint(10) UNSIGNED NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `id_rep` int(11) DEFAULT NULL,
  `cliente` varchar(50) DEFAULT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `precio_total` decimal(10,2) DEFAULT NULL,
  `estatus` int(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Disparadores `facturas`
--
DELIMITER $$
CREATE TRIGGER `actualizar_saldo` AFTER INSERT ON `facturas` FOR EACH ROW BEGIN
	INSERT INTO saldo(saldo)
	VALUES (NEW.precio_total);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fallas`
--

CREATE TABLE `fallas` (
  `id_falla` int(11) NOT NULL,
  `des_falla` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `fallas`
--

INSERT INTO `fallas` (`id_falla`, `des_falla`) VALUES
(1, 'Reemplazar Display'),
(2, 'Cambio PIN de Carga'),
(3, 'FRP Google'),
(4, 'Flasheo de Sistema'),
(5, 'Reparación en placa madre');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gastos`
--

CREATE TABLE `gastos` (
  `cod_gasto` int(11) NOT NULL,
  `nro_fact_gasto` int(6) NOT NULL,
  `fecha` datetime DEFAULT current_timestamp(),
  `descripcion` varchar(150) NOT NULL,
  `monto` decimal(10,2) DEFAULT NULL,
  `proveedor` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `estatus` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `gastos`
--

INSERT INTO `gastos` (`cod_gasto`, `nro_fact_gasto`, `fecha`, `descripcion`, `monto`, `proveedor`, `id_usuario`, `estatus`) VALUES
(8, 0, '2023-04-01 22:42:48', 'Víveres', '332.00', 4, 1, 1),
(9, 0, '2023-04-01 22:44:01', 'Víveres', '884.00', 9, 1, 1),
(10, 2167465, '2023-04-01 22:45:32', 'Víveres', '485.00', 10, 1, 1),
(11, 0, '2023-04-01 22:50:40', 'Víveres', '180.00', 11, 1, 1),
(12, 0, '2023-04-01 23:02:53', 'Víveres', '255.00', 12, 1, 1);

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
(1, 'Samsung'),
(2, 'Apple'),
(3, 'Huawei'),
(4, 'Xiaomi'),
(5, 'Sony'),
(6, 'LG'),
(7, 'HP'),
(8, 'Lenovo'),
(9, 'Acer');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `cod_proveedor` int(11) NOT NULL,
  `proveedor` varchar(100) DEFAULT NULL,
  `per_contacto` varchar(100) DEFAULT NULL,
  `telefono` int(15) DEFAULT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `date_add` datetime NOT NULL DEFAULT current_timestamp(),
  `estatus` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`cod_proveedor`, `proveedor`, `per_contacto`, `telefono`, `direccion`, `id_usuario`, `date_add`, `estatus`) VALUES
(1, 'Mancrú', 'Rafael Silva', 97323090, 'Paysandú 1175', 1, '2023-03-16 11:00:01', 1),
(2, 'Carmel', 'Carmel', 94711555, ' Av. Uruguay 1338 esq. Ejido', 1, '2023-03-20 15:43:16', 1),
(3, 'ANCAP Pinamar', 'No Aplica', 0, 'Pinamar Canelones', 1, '2023-03-31 10:18:24', 1),
(4, 'Supermercado Salinas', 'No aplica', 0, 'Av. Julieta', 1, '2023-03-31 18:27:48', 1),
(5, 'Supermercado Imperio', 'No Aplica', 0, 'Pinamar Canelones', 1, '2023-03-31 18:28:17', 1),
(6, 'Feria Salinas', 'No Aplica', 0, 'Pinamar Canelones', 1, '2023-03-31 18:28:49', 1),
(7, 'Blessing', 'Anthony', 91223834, 'Av Libertador 1722', 1, '2023-03-31 18:30:02', 1),
(8, 'GTM Importaciones', 'Nicole', 99418096, 'Ejido 1497 Esq. Uruguay', 1, '2023-03-31 18:32:09', 1),
(9, 'Supermercado de Carnes', 'No Aplica', 0, 'Salinas, Canelones', 1, '2023-04-01 22:43:37', 1),
(10, 'Supermercado Éxito', 'No Aplica', 0, 'Av. Julieta, Salinas, Canelones', 1, '2023-04-01 22:44:52', 1),
(11, 'Sin Proveedor', 'No Aplica', 0, 'Salinas, Canelones', 1, '2023-04-01 22:50:18', 1),
(12, 'Almacen Vecino - Salinas Sur', 'Erika', 0, 'Calle Bibí, Salinas Sur', 1, '2023-04-01 23:00:55', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reparaciones`
--

CREATE TABLE `reparaciones` (
  `id_rep` int(11) NOT NULL,
  `cliente` int(11) NOT NULL,
  `marca` varchar(50) NOT NULL,
  `modelo` varchar(50) DEFAULT NULL,
  `equipo` varchar(50) NOT NULL,
  `des_falla` varchar(150) NOT NULL,
  `fecha` datetime DEFAULT current_timestamp(),
  `observacion` text DEFAULT NULL,
  `estatus` varchar(100) NOT NULL,
  `rep_act` int(11) NOT NULL DEFAULT 1,
  `username` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reparaciones`
--

INSERT INTO `reparaciones` (`id_rep`, `cliente`, `marca`, `modelo`, `equipo`, `des_falla`, `fecha`, `observacion`, `estatus`, `rep_act`, `username`) VALUES
(44, 43, 'Samsung', 'A505', 'Celular', 'Reemplazar Display', '2023-04-01 22:39:38', 'Seña 4.000$ - Presupuesto de 5800$', 'En espera de Repuesto', 1, 'admin'),
(45, 44, 'Apple', 'Iphone 6s', 'Celular', 'Reemplazar Display', '2023-04-01 22:40:35', 'Seña 2.000$ - Presupuesto de 2700$', 'En espera de Repuesto', 1, 'admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `idrol` int(11) NOT NULL,
  `rol` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`idrol`, `rol`) VALUES
(1, 'administrador'),
(2, 'supervisor'),
(3, 'usuario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `saldo`
--

CREATE TABLE `saldo` (
  `cod_saldo` int(2) NOT NULL,
  `saldo` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `saldo`
--

INSERT INTO `saldo` (`cod_saldo`, `saldo`) VALUES
(1, '150.00'),
(2, '600.00'),
(3, '700.00'),
(4, '900.00'),
(5, '100.00'),
(6, '500.00'),
(7, '100.00'),
(8, '600.00'),
(9, '1200.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idusuario` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `rol` int(11) DEFAULT NULL,
  `estatus` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idusuario`, `nombre`, `username`, `password`, `rol`, `estatus`) VALUES
(1, 'Anthoni Merchan', 'admin', '21232f297a57a5a743894a0e4a801fc3', 1, 1),
(2, 'Norelky Vanezca', 'nore', '21232f297a57a5a743894a0e4a801fc3', 2, 1),
(3, 'Noriangel Merchan', 'nori', '21232f297a57a5a743894a0e4a801fc3', 3, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `banco`
--
ALTER TABLE `banco`
  ADD PRIMARY KEY (`cod_banco`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`ID_Cliente`),
  ADD KEY `idusuario` (`username`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`cod_compra`),
  ADD KEY `proveedor` (`proveedor`);

--
-- Indices de la tabla `equipos`
--
ALTER TABLE `equipos`
  ADD PRIMARY KEY (`id_equipo`);

--
-- Indices de la tabla `estatus`
--
ALTER TABLE `estatus`
  ADD PRIMARY KEY (`id_estatus`);

--
-- Indices de la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD PRIMARY KEY (`nro_factura`);

--
-- Indices de la tabla `fallas`
--
ALTER TABLE `fallas`
  ADD PRIMARY KEY (`id_falla`);

--
-- Indices de la tabla `gastos`
--
ALTER TABLE `gastos`
  ADD PRIMARY KEY (`cod_gasto`);

--
-- Indices de la tabla `marca`
--
ALTER TABLE `marca`
  ADD PRIMARY KEY (`id_marca`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`cod_proveedor`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `reparaciones`
--
ALTER TABLE `reparaciones`
  ADD PRIMARY KEY (`id_rep`),
  ADD KEY `cliente` (`cliente`),
  ADD KEY `idusuario` (`username`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`idrol`);

--
-- Indices de la tabla `saldo`
--
ALTER TABLE `saldo`
  ADD PRIMARY KEY (`cod_saldo`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idusuario`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `rol` (`rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `banco`
--
ALTER TABLE `banco`
  MODIFY `cod_banco` int(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `ID_Cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `cod_compra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `equipos`
--
ALTER TABLE `equipos`
  MODIFY `id_equipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `estatus`
--
ALTER TABLE `estatus`
  MODIFY `id_estatus` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `facturas`
--
ALTER TABLE `facturas`
  MODIFY `nro_factura` bigint(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT de la tabla `fallas`
--
ALTER TABLE `fallas`
  MODIFY `id_falla` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `gastos`
--
ALTER TABLE `gastos`
  MODIFY `cod_gasto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `marca`
--
ALTER TABLE `marca`
  MODIFY `id_marca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `cod_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `reparaciones`
--
ALTER TABLE `reparaciones`
  MODIFY `id_rep` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `idrol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `saldo`
--
ALTER TABLE `saldo`
  MODIFY `cod_saldo` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `compras_ibfk_1` FOREIGN KEY (`proveedor`) REFERENCES `proveedor` (`cod_proveedor`);

--
-- Filtros para la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD CONSTRAINT `proveedor_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`idusuario`);

--
-- Filtros para la tabla `reparaciones`
--
ALTER TABLE `reparaciones`
  ADD CONSTRAINT `reparaciones_ibfk_1` FOREIGN KEY (`cliente`) REFERENCES `cliente` (`ID_Cliente`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`rol`) REFERENCES `rol` (`idrol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
