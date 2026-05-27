-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-05-2026 a las 22:46:47
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
-- Base de datos: `bdd_tis`
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
  `cantidad_almacenamiento` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `nombre_departamento` varchar(255) DEFAULT NULL,
  `id_funcionario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `id_departamento` int(11) DEFAULT NULL,
  `rol` enum('Administrador','Funcionario') DEFAULT NULL,
  `contrasena` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `id_funcionario` int(11) DEFAULT NULL
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
  `modelo_procesador` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `id_funcionario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `id_equipo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `id_funcionario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `id_funcionario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  ADD PRIMARY KEY (`id_departamento`),
  ADD KEY `fk_depto_func` (`id_funcionario`);

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
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `computador`
--
ALTER TABLE `computador`
  ADD CONSTRAINT `fk_comp_func` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionario` (`id_funcionario`);

--
-- Filtros para la tabla `correctiva`
--
ALTER TABLE `correctiva`
  ADD CONSTRAINT `fk_corr_func` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionario` (`id_funcionario`);

--
-- Filtros para la tabla `departamento`
--
ALTER TABLE `departamento`
  ADD CONSTRAINT `fk_depto_func` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionario` (`id_funcionario`);

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
  ADD CONSTRAINT `fk_impr_func` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionario` (`id_funcionario`);

--
-- Filtros para la tabla `notebook`
--
ALTER TABLE `notebook`
  ADD CONSTRAINT `fk_note_func` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionario` (`id_funcionario`);

--
-- Filtros para la tabla `otro_dispositivo`
--
ALTER TABLE `otro_dispositivo`
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
  ADD CONSTRAINT `fk_serv_func` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionario` (`id_funcionario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
