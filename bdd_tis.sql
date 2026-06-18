-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-06-2026 a las 04:09:58
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
-- Base de datos: `bdd_tis_2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `computador`
--

CREATE TABLE `computador` (
  `id_equipo` int(11) NOT NULL,
  `marca` varchar(255) DEFAULT NULL,
  `codigo_qr` varchar(255) DEFAULT NULL,
  `fecha_garantia` date DEFAULT NULL,
  `valor_equipo` double DEFAULT NULL,
  `fecha_compra` date DEFAULT NULL,
  `numero_serie` int(11) DEFAULT NULL,
  `procesador` enum('Intel','Ryzen') DEFAULT NULL,
  `memoria_ram` enum('DDR4','DDR5') DEFAULT NULL,
  `almacenamiento` enum('SSD SATA','SSD M.2','HDD') DEFAULT NULL,
  `id_funcionario` int(11) DEFAULT NULL,
  `modelo_procesador` varchar(255) DEFAULT NULL,
  `cantidad_ram` int(11) DEFAULT NULL,
  `cantidad_almacenamiento` double DEFAULT NULL,
  `id_proveedor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `computador`
--

INSERT INTO `computador` (`id_equipo`, `marca`, `codigo_qr`, `fecha_garantia`, `valor_equipo`, `fecha_compra`, `numero_serie`, `procesador`, `memoria_ram`, `almacenamiento`, `id_funcionario`, `modelo_procesador`, `cantidad_ram`, `cantidad_almacenamiento`, `id_proveedor`) VALUES
(1, 'Dell', 'QR-COMP-01', '2028-05-21', 850000, '2026-05-21', 12345678, 'Ryzen', 'DDR4', 'SSD M.2', 2, 'Core i5-12400', 16, 512, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `correctiva`
--

CREATE TABLE `correctiva` (
  `id_mantencion` int(11) NOT NULL,
  `costo` double DEFAULT NULL,
  `estado` enum('operativo','en mantención','fuera de servicio') DEFAULT NULL,
  `tipo_de_fallo` text DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `id_funcionario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento`
--

CREATE TABLE `departamento` (
  `id_departamento` int(11) NOT NULL,
  `nombre_departamento` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `departamento`
--

INSERT INTO `departamento` (`id_departamento`, `nombre_departamento`) VALUES
(1, 'Jefatura'),
(2, 'Tecnica'),
(3, 'Funcionarios');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipo_general`
--

CREATE TABLE `equipo_general` (
  `id_equipo` int(11) NOT NULL,
  `tipo_equipo` enum('Computador','Proyector','Impresora','Notebook','Servidor','Otro Dispositivo') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `equipo_general`
--

INSERT INTO `equipo_general` (`id_equipo`, `tipo_equipo`) VALUES
(1, 'Computador'),
(2, 'Proyector'),
(3, 'Notebook'),
(4, 'Proyector'),
(5, 'Proyector'),
(6, 'Otro Dispositivo'),
(7, 'Otro Dispositivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evento`
--

CREATE TABLE `evento` (
  `id_evento` int(11) NOT NULL,
  `estado_equipo` enum('activo','en reparacion','dado de baja') DEFAULT NULL,
  `fecha_evento` datetime DEFAULT NULL,
  `tipo_evento` varchar(255) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `costo_asociado` double DEFAULT NULL,
  `id_funcionario` int(11) DEFAULT NULL,
  `id_mantencion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `funcionario`
--

CREATE TABLE `funcionario` (
  `id_funcionario` int(11) NOT NULL,
  `rut` int(11) DEFAULT NULL,
  `nombre_completo` varchar(255) DEFAULT NULL,
  `id_equipo` int(11) DEFAULT NULL,
  `id_departamento` int(11) NOT NULL,
  `rol` enum('Administrador','Funcionario','Tecnico') DEFAULT NULL,
  `contrasena` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `funcionario`
--

INSERT INTO `funcionario` (`id_funcionario`, `rut`, `nombre_completo`, `id_equipo`, `id_departamento`, `rol`, `contrasena`) VALUES
(1, 12345678, 'Prueba Jefatura', NULL, 1, 'Administrador', 'contraseña123'),
(2, 87654321, 'Prueba Tecnica', NULL, 2, 'Tecnico', 'contraseña123'),
(3, 987654321, 'Prueba Funcionarios', 0, 3, 'Funcionario', 'contraseña123'),
(5, 44444, 'dasdasd', NULL, 3, 'Funcionario', 'dasdasdas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `impresora`
--

CREATE TABLE `impresora` (
  `id_equipo` int(11) NOT NULL,
  `marca` varchar(255) DEFAULT NULL,
  `codigo_qr` varchar(255) DEFAULT NULL,
  `fecha_garantia` date DEFAULT NULL,
  `valor_equipo` double DEFAULT NULL,
  `fecha_compra` date DEFAULT NULL,
  `numero_serie` int(11) DEFAULT NULL,
  `volumen_impresion` double DEFAULT NULL,
  `modelo` varchar(255) DEFAULT NULL,
  `tipo` enum('Inyección','Laser') DEFAULT NULL,
  `id_funcionario` int(11) DEFAULT NULL,
  `id_proveedor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notebook`
--

CREATE TABLE `notebook` (
  `id_equipo` int(11) NOT NULL,
  `marca` varchar(255) DEFAULT NULL,
  `codigo_qr` varchar(255) DEFAULT NULL,
  `fecha_garantia` date DEFAULT NULL,
  `valor_equipo` double DEFAULT NULL,
  `fecha_compra` date DEFAULT NULL,
  `numero_serie` int(11) DEFAULT NULL,
  `procesador` enum('Intel','Ryzen') DEFAULT NULL,
  `memoria_ram` enum('DDR4','DDR5') DEFAULT NULL,
  `modelo` varchar(255) DEFAULT NULL,
  `almacenamiento` enum('SSD SATA','SSD M.2','HDD') DEFAULT NULL,
  `id_funcionario` int(11) DEFAULT NULL,
  `cantidad_ram` int(11) DEFAULT NULL,
  `cantidad_almacenamiento` double DEFAULT NULL,
  `modelo_procesador` varchar(255) DEFAULT NULL,
  `id_proveedor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `notebook`
--

INSERT INTO `notebook` (`id_equipo`, `marca`, `codigo_qr`, `fecha_garantia`, `valor_equipo`, `fecha_compra`, `numero_serie`, `procesador`, `memoria_ram`, `modelo`, `almacenamiento`, `id_funcionario`, `cantidad_ram`, `cantidad_almacenamiento`, `modelo_procesador`, `id_proveedor`) VALUES
(3, 'asus', '', '2004-10-11', 1000000, '2002-10-11', 2423432, 'Ryzen', 'DDR4', 'zephyrus g14', 'SSD M.2', 3, 16, 512, '7 serie 400', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `otro_dispositivo`
--

CREATE TABLE `otro_dispositivo` (
  `id_equipo` int(11) NOT NULL,
  `marca` varchar(255) DEFAULT NULL,
  `codigo_qr` varchar(255) DEFAULT NULL,
  `fecha_garantia` date DEFAULT NULL,
  `valor_equipo` double DEFAULT NULL,
  `fecha_compra` date DEFAULT NULL,
  `numero_serie` int(11) DEFAULT NULL,
  `modelo` varchar(255) DEFAULT NULL,
  `id_funcionario` int(11) DEFAULT NULL,
  `id_proveedor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `otro_dispositivo`
--

INSERT INTO `otro_dispositivo` (`id_equipo`, `marca`, `codigo_qr`, `fecha_garantia`, `valor_equipo`, `fecha_compra`, `numero_serie`, `modelo`, `id_funcionario`, `id_proveedor`) VALUES
(6, 'AAA', '', '2026-06-06', 123, '2026-07-02', 11, 'NOSE', 3, 2),
(7, 'adasds', NULL, '2026-07-04', 111, '2026-06-04', 1312, 'DADA', 3, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preventiva`
--

CREATE TABLE `preventiva` (
  `id_mantencion` int(11) NOT NULL,
  `costo` double DEFAULT NULL,
  `estado` enum('operativo','en mantención','fuera de servicio') DEFAULT NULL,
  `fecha_prox_mantencion` date DEFAULT NULL,
  `frecuencia_mantencion` datetime DEFAULT NULL,
  `id_funcionario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `id_proveedor` int(11) NOT NULL,
  `rut_proveedor` int(11) DEFAULT NULL,
  `nombre_completo` varchar(255) DEFAULT NULL,
  `id_equipo` int(11) DEFAULT NULL,
  `Contacto` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`id_proveedor`, `rut_proveedor`, `nombre_completo`, `id_equipo`, `Contacto`) VALUES
(1, 2147483647, 'Prueba Proveedor 10 ', NULL, 'aaaaa@gmail.com'),
(2, 87654321, 'Prueba Proveedor 2', NULL, 'bbbbb@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyector`
--

CREATE TABLE `proyector` (
  `id_equipo` int(11) NOT NULL,
  `marca` varchar(255) DEFAULT NULL,
  `codigo_qr` varchar(255) DEFAULT NULL,
  `fecha_garantia` date DEFAULT NULL,
  `valor_equipo` double DEFAULT NULL,
  `fecha_compra` date DEFAULT NULL,
  `numero_serie` int(11) DEFAULT NULL,
  `calidad_imagen` double DEFAULT NULL,
  `modelo` varchar(255) DEFAULT NULL,
  `id_funcionario` int(11) DEFAULT NULL,
  `id_proveedor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proyector`
--

INSERT INTO `proyector` (`id_equipo`, `marca`, `codigo_qr`, `fecha_garantia`, `valor_equipo`, `fecha_compra`, `numero_serie`, `calidad_imagen`, `modelo`, `id_funcionario`, `id_proveedor`) VALUES
(2, 'Epson', 'QR-PROY-01', '2027-05-21', 450000, '2026-05-21', 87654321, 1080, 'PowerLite W49', NULL, NULL),
(4, 'dadda', NULL, '2026-06-16', 150000, '0000-00-00', 312312, 1080, '', 3, NULL),
(5, 'AAAA', NULL, '2026-07-04', 321312, '2026-06-25', 12312, 12312, '', 2, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `realiza`
--

CREATE TABLE `realiza` (
  `id_funcionario` int(11) NOT NULL,
  `id_mantencion` int(11) NOT NULL,
  `id_evento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servidor`
--

CREATE TABLE `servidor` (
  `id_equipo` int(11) NOT NULL,
  `marca` varchar(255) DEFAULT NULL,
  `codigo_qr` varchar(255) DEFAULT NULL,
  `fecha_garantia` date DEFAULT NULL,
  `valor_equipo` double DEFAULT NULL,
  `fecha_compra` date DEFAULT NULL,
  `numero_serie` int(11) DEFAULT NULL,
  `funcion` varchar(255) DEFAULT NULL,
  `id_funcionario` int(11) DEFAULT NULL,
  `id_proveedor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_equipos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_equipos` (
`id_equipo` int(11)
,`tipo` varchar(16)
,`marca` varchar(255)
,`modelo` varchar(255)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_equipos`
--
DROP TABLE IF EXISTS `vista_equipos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_equipos`  AS SELECT `computador`.`id_equipo` AS `id_equipo`, 'Computador' AS `tipo`, `computador`.`marca` AS `marca`, `computador`.`modelo_procesador` AS `modelo` FROM `computador`union all select `proyector`.`id_equipo` AS `id_equipo`,'Proyector' AS `tipo`,`proyector`.`marca` AS `marca`,`proyector`.`modelo` AS `modelo` from `proyector` union all select `impresora`.`id_equipo` AS `id_equipo`,'Impresora' AS `tipo`,`impresora`.`marca` AS `marca`,`impresora`.`modelo` AS `modelo` from `impresora` union all select `notebook`.`id_equipo` AS `id_equipo`,'Notebook' AS `tipo`,`notebook`.`marca` AS `marca`,`notebook`.`modelo` AS `modelo` from `notebook` union all select `servidor`.`id_equipo` AS `id_equipo`,'Servidor' AS `tipo`,`servidor`.`marca` AS `marca`,`servidor`.`funcion` AS `modelo` from `servidor` union all select `otro_dispositivo`.`id_equipo` AS `id_equipo`,'Otro Dispositivo' AS `tipo`,`otro_dispositivo`.`marca` AS `marca`,`otro_dispositivo`.`modelo` AS `modelo` from `otro_dispositivo`  ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `computador`
--
ALTER TABLE `computador`
  ADD PRIMARY KEY (`id_equipo`),
  ADD KEY `fk_comp_func` (`id_funcionario`);

--
-- Indices de la tabla `correctiva`
--
ALTER TABLE `correctiva`
  ADD PRIMARY KEY (`id_mantencion`),
  ADD KEY `fk_corr_func` (`id_funcionario`);

--
-- Indices de la tabla `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`id_departamento`);

--
-- Indices de la tabla `equipo_general`
--
ALTER TABLE `equipo_general`
  ADD PRIMARY KEY (`id_equipo`);

--
-- Indices de la tabla `evento`
--
ALTER TABLE `evento`
  ADD PRIMARY KEY (`id_evento`),
  ADD KEY `fk_evento_func` (`id_funcionario`);

--
-- Indices de la tabla `funcionario`
--
ALTER TABLE `funcionario`
  ADD PRIMARY KEY (`id_funcionario`),
  ADD KEY `fk_func_depto` (`id_departamento`);

--
-- Indices de la tabla `impresora`
--
ALTER TABLE `impresora`
  ADD PRIMARY KEY (`id_equipo`),
  ADD KEY `fk_impr_func` (`id_funcionario`);

--
-- Indices de la tabla `notebook`
--
ALTER TABLE `notebook`
  ADD PRIMARY KEY (`id_equipo`),
  ADD KEY `fk_note_func` (`id_funcionario`);

--
-- Indices de la tabla `otro_dispositivo`
--
ALTER TABLE `otro_dispositivo`
  ADD PRIMARY KEY (`id_equipo`),
  ADD KEY `fk_otro_func` (`id_funcionario`);

--
-- Indices de la tabla `preventiva`
--
ALTER TABLE `preventiva`
  ADD PRIMARY KEY (`id_mantencion`),
  ADD KEY `fk_prev_func` (`id_funcionario`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`id_proveedor`);

--
-- Indices de la tabla `proyector`
--
ALTER TABLE `proyector`
  ADD PRIMARY KEY (`id_equipo`),
  ADD KEY `fk_proy_func` (`id_funcionario`);

--
-- Indices de la tabla `realiza`
--
ALTER TABLE `realiza`
  ADD PRIMARY KEY (`id_funcionario`,`id_mantencion`,`id_evento`),
  ADD KEY `fk_real_evento` (`id_evento`);

--
-- Indices de la tabla `servidor`
--
ALTER TABLE `servidor`
  ADD PRIMARY KEY (`id_equipo`),
  ADD KEY `fk_serv_func` (`id_funcionario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `departamento`
--
ALTER TABLE `departamento`
  MODIFY `id_departamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `equipo_general`
--
ALTER TABLE `equipo_general`
  MODIFY `id_equipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `funcionario`
--
ALTER TABLE `funcionario`
  MODIFY `id_funcionario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `computador`
--
ALTER TABLE `computador`
  ADD CONSTRAINT `fk_comp_equipo_gen` FOREIGN KEY (`id_equipo`) REFERENCES `equipo_general` (`id_equipo`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_comp_func` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionario` (`id_funcionario`);

--
-- Filtros para la tabla `correctiva`
--
ALTER TABLE `correctiva`
  ADD CONSTRAINT `fk_corr_func` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionario` (`id_funcionario`);

--
-- Filtros para la tabla `evento`
--
ALTER TABLE `evento`
  ADD CONSTRAINT `fk_evento_func` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionario` (`id_funcionario`);

--
-- Filtros para la tabla `funcionario`
--
ALTER TABLE `funcionario`
  ADD CONSTRAINT `fk_func_depto` FOREIGN KEY (`id_departamento`) REFERENCES `departamento` (`id_departamento`);

--
-- Filtros para la tabla `impresora`
--
ALTER TABLE `impresora`
  ADD CONSTRAINT `fk_impr_equipo_gen` FOREIGN KEY (`id_equipo`) REFERENCES `equipo_general` (`id_equipo`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_impr_func` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionario` (`id_funcionario`);

--
-- Filtros para la tabla `notebook`
--
ALTER TABLE `notebook`
  ADD CONSTRAINT `fk_note_equipo_gen` FOREIGN KEY (`id_equipo`) REFERENCES `equipo_general` (`id_equipo`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_note_func` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionario` (`id_funcionario`);

--
-- Filtros para la tabla `otro_dispositivo`
--
ALTER TABLE `otro_dispositivo`
  ADD CONSTRAINT `fk_otro_equipo_gen` FOREIGN KEY (`id_equipo`) REFERENCES `equipo_general` (`id_equipo`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_otro_func` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionario` (`id_funcionario`);

--
-- Filtros para la tabla `preventiva`
--
ALTER TABLE `preventiva`
  ADD CONSTRAINT `fk_prev_func` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionario` (`id_funcionario`);

--
-- Filtros para la tabla `proyector`
--
ALTER TABLE `proyector`
  ADD CONSTRAINT `fk_proy_equipo_gen` FOREIGN KEY (`id_equipo`) REFERENCES `equipo_general` (`id_equipo`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_proy_func` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionario` (`id_funcionario`);

--
-- Filtros para la tabla `realiza`
--
ALTER TABLE `realiza`
  ADD CONSTRAINT `fk_real_evento` FOREIGN KEY (`id_evento`) REFERENCES `evento` (`id_evento`),
  ADD CONSTRAINT `fk_real_func` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionario` (`id_funcionario`);

--
-- Filtros para la tabla `servidor`
--
ALTER TABLE `servidor`
  ADD CONSTRAINT `fk_serv_equipo_gen` FOREIGN KEY (`id_equipo`) REFERENCES `equipo_general` (`id_equipo`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_serv_func` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionario` (`id_funcionario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
