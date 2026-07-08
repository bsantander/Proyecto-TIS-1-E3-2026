-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-07-2026 a las 04:32:32
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
(8, 'HP', '', '0000-00-00', 0, '0000-00-00', 0, '', '', '', 5, 'Core i7', 16, 512, 1),
(14, 'Dell', '', '0000-00-00', 0, '0000-00-00', 0, '', '', '', NULL, 'Core i5', 8, 256, NULL),
(20, 'Lenovo', '', '0000-00-00', 0, '0000-00-00', 0, '', '', '', 2, 'Ryzen 5', 16, 1000, NULL),
(26, 'HP', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Core i3', 8, 256, NULL),
(32, 'Dell', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Core i7', 32, 1000, NULL);

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
  `id_funcionario` int(11) DEFAULT NULL,
  `id_equipo` int(11) DEFAULT NULL,
  `fecha_entrega` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `correctiva`
--

INSERT INTO `correctiva` (`id_mantencion`, `costo`, `estado`, `tipo_de_fallo`, `descripcion`, `id_funcionario`, `id_equipo`, `fecha_entrega`) VALUES
(1, 15000, 'operativo', 'Falla eléctrica', 'Reemplazo de cables principales', 1, 10, '2026-07-10'),
(2, 45000, 'operativo', 'Desgaste mecánico', 'Lubricación y ajuste de piezas móviles', 2, 5, '2026-07-15'),
(3, 5000, 'operativo', 'No prende', 'La pantalla se fue a negro y no prende', 1, 9, '2026-07-18'),
(4, 200000, 'operativo', 'No prende', 'DASDSAD', 1, 10, '2026-07-25'),
(5, 150000, 'operativo', 'NO IMPRIME', 'Dejo de imprimir y no hace nada', 3, 11, '2026-07-26');

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
(8, 'Computador'),
(9, 'Notebook'),
(10, 'Proyector'),
(11, 'Impresora'),
(12, 'Servidor'),
(13, 'Otro Dispositivo'),
(14, 'Computador'),
(15, 'Notebook'),
(16, 'Proyector'),
(17, 'Impresora'),
(18, 'Servidor'),
(19, 'Otro Dispositivo'),
(20, 'Computador'),
(21, 'Notebook'),
(22, 'Proyector'),
(23, 'Impresora'),
(24, 'Servidor'),
(25, 'Otro Dispositivo'),
(26, 'Computador'),
(27, 'Notebook'),
(28, 'Proyector'),
(29, 'Impresora'),
(30, 'Servidor'),
(31, 'Otro Dispositivo'),
(32, 'Computador'),
(33, 'Notebook'),
(34, 'Proyector'),
(35, 'Impresora'),
(36, 'Servidor'),
(37, 'Otro Dispositivo'),
(38, 'Impresora');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evento`
--

CREATE TABLE `evento` (
  `id_evento` int(11) NOT NULL,
  `id_equipo` int(11) DEFAULT NULL,
  `estado_equipo` enum('activo','en reparacion','dado de baja') DEFAULT NULL,
  `fecha_evento` datetime DEFAULT NULL,
  `tipo_evento` enum('Ingreso Equipo','Asignacion a funcionario','Reasignacion a funcionario','Mantencion preventiva','Mantencion correctiva','Dado de baja') NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `costo_asociado` double DEFAULT NULL,
  `id_funcionario` int(11) DEFAULT NULL,
  `id_mantencion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `evento`
--

INSERT INTO `evento` (`id_evento`, `id_equipo`, `estado_equipo`, `fecha_evento`, `tipo_evento`, `descripcion`, `costo_asociado`, `id_funcionario`, `id_mantencion`) VALUES
(1, 38, 'activo', '2026-07-04 00:20:26', 'Ingreso Equipo', 'Ingreso de equipo Impresora al inventario', 0, 1, NULL),
(2, 38, 'activo', '2026-07-04 00:26:12', 'Reasignacion a funcionario', 'Equipo reasignado del funcionario 1 al funcionario 2', 0, 2, NULL),
(3, 38, 'activo', '2026-07-04 00:33:41', 'Reasignacion a funcionario', 'Equipo reasignado del funcionario 2 al funcionario 5', 0, 5, NULL),
(4, 20, 'activo', '2026-07-04 00:34:21', 'Asignacion a funcionario', 'Equipo asignado al funcionario 2', 0, 2, NULL),
(5, 23, 'activo', '2026-07-07 19:58:19', 'Mantencion preventiva', 'fallo la ram', 150000, 2, 13),
(6, 38, '', '2026-07-07 20:25:33', 'Mantencion preventiva', 'Fallo la ram', 1500000, 5, 14),
(8, 8, 'en reparacion', '2026-07-07 20:29:58', 'Mantencion preventiva', 'fallo la cpu', 150000, 5, 15),
(9, 8, 'activo', '2026-07-07 20:30:00', 'Mantencion preventiva', 'Entrega de equipo por mantencion preventiva', 0, 5, 15),
(10, 9, 'en reparacion', '2026-07-07 20:33:08', 'Mantencion correctiva', 'La pantalla se fue a negro y no prende', 5000, 1, 3),
(11, 9, 'activo', '2026-07-07 20:33:26', 'Mantencion correctiva', 'Entrega de equipo por mantencion correctiva', 0, 1, 3),
(12, 8, 'dado de baja', '2026-07-07 20:45:05', 'Dado de baja', 'Equipo 8 dado de baja', 0, 5, NULL),
(13, 9, 'en reparacion', '2026-07-07 20:59:14', 'Mantencion preventiva', 'Falla de ram', 150000, 1, 16),
(14, 10, 'en reparacion', '2026-07-07 22:16:20', 'Mantencion correctiva', 'DASDSAD', 200000, 1, 4),
(15, 10, 'activo', '2026-07-07 22:16:56', 'Mantencion correctiva', 'Entrega de equipo por mantencion correctiva', 0, 1, 4),
(16, 10, 'activo', '2026-07-07 22:17:26', 'Asignacion a funcionario', 'Equipo asignado al funcionario 1', 0, 1, NULL),
(17, 10, 'dado de baja', '2026-07-07 22:17:49', 'Dado de baja', 'Equipo 10 dado de baja', 0, 1, NULL),
(18, 11, 'en reparacion', '2026-07-07 22:19:24', 'Mantencion correctiva', 'Dejo de imprimir y no hace nada', 150000, 3, 5),
(19, 11, 'activo', '2026-07-07 22:20:13', 'Mantencion correctiva', 'Entrega de equipo por mantencion correctiva', 0, 3, 5),
(20, 11, 'activo', '2026-07-07 22:20:59', 'Asignacion a funcionario', 'Equipo asignado al funcionario 3', 0, 3, NULL),
(21, 11, 'dado de baja', '2026-07-07 22:21:15', 'Dado de baja', 'Equipo 11 dado de baja', 0, 3, NULL);

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
(1, 12345678, 'Prueba Jefatura', 9, 1, 'Administrador', 'contraseña123'),
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

--
-- Volcado de datos para la tabla `impresora`
--

INSERT INTO `impresora` (`id_equipo`, `marca`, `codigo_qr`, `fecha_garantia`, `valor_equipo`, `fecha_compra`, `numero_serie`, `volumen_impresion`, `modelo`, `tipo`, `id_funcionario`, `id_proveedor`) VALUES
(11, 'Brother', '', '0000-00-00', 0, '0000-00-00', 0, 0, 'HL-1200', 'Laser', 3, NULL),
(17, 'HP', NULL, NULL, NULL, NULL, NULL, NULL, 'Deskjet 2700', 'Inyección', NULL, NULL),
(23, 'Canon', NULL, NULL, NULL, NULL, NULL, NULL, 'Pixma', 'Inyección', NULL, NULL),
(29, 'Brother', NULL, NULL, NULL, NULL, NULL, NULL, 'DCP-1610', 'Laser', NULL, NULL),
(35, 'HP', NULL, NULL, NULL, NULL, NULL, NULL, 'LaserJet', 'Laser', NULL, NULL),
(38, 'aaaa', '', '2026-07-26', 10, '2026-07-04', 1321, 1010, 'aaaa', 'Inyección', 5, 2);

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
(9, 'Asus', '', '0000-00-00', 0, '0000-00-00', 0, '', '', 'VivoBook', '', 1, 16, 512, '', 1),
(15, 'Acer', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Swift', NULL, NULL, 8, 256, NULL, NULL),
(21, 'HP', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pavilion', NULL, NULL, 16, 512, NULL, NULL),
(27, 'Lenovo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ThinkPad', NULL, NULL, 16, 512, NULL, NULL),
(33, 'Dell', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Inspiron', NULL, NULL, 8, 256, NULL, NULL);

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
(13, 'Logitech', NULL, NULL, NULL, NULL, NULL, 'Webcam', NULL, NULL),
(19, 'Cisco', NULL, NULL, NULL, NULL, NULL, 'Switch', NULL, NULL),
(25, 'APC', NULL, NULL, NULL, NULL, NULL, 'UPS', NULL, NULL),
(31, 'D-Link', '', '0000-00-00', 0, '0000-00-00', 0, 'Router', 2, 2),
(37, 'Eaton', NULL, NULL, NULL, NULL, NULL, 'UPS', NULL, NULL);

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
  `id_funcionario` int(11) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `id_equipo` int(11) DEFAULT NULL,
  `fecha_entrega` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `preventiva`
--

INSERT INTO `preventiva` (`id_mantencion`, `costo`, `estado`, `fecha_prox_mantencion`, `frecuencia_mantencion`, `id_funcionario`, `descripcion`, `id_equipo`, `fecha_entrega`) VALUES
(4, 25000, 'operativo', '2026-08-01', '2026-07-06 10:00:00', 1, '101', 5, '2026-07-06'),
(12, 32000.5, 'operativo', '2026-09-15', '2026-07-06 14:30:00', 2, '102', 8, '2026-07-07'),
(13, 150000, 'operativo', '2026-07-16', '2026-07-15 19:58:00', 2, 'fallo la ram', 23, '2026-07-25'),
(14, 1500000, 'operativo', '2026-07-10', '2026-07-16 20:25:00', 5, 'Fallo la ram', 38, '2026-07-15'),
(15, 150000, 'operativo', '2026-07-15', '2026-07-15 20:29:00', 5, 'fallo la cpu', 8, '2026-07-15'),
(16, 150000, 'en mantención', '2026-07-17', '2026-07-07 20:59:00', 1, 'Falla de ram', 9, '2026-07-29');

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
(2, 87654321, 'Prueba Proveedor 1', NULL, 'bbbbb@gmail.com');

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
(10, 'Epson', '', '0000-00-00', 0, '0000-00-00', 0, 1080, 'X49', 1, 1),
(16, 'BenQ', '', '0000-00-00', 0, '0000-00-00', 0, 720, 'MS550', 1, 2),
(22, 'ViewSonic', NULL, NULL, NULL, NULL, NULL, 1080, 'PA503', NULL, NULL),
(28, 'Epson', NULL, NULL, NULL, NULL, NULL, 1080, 'EB-E01', NULL, NULL),
(34, 'Sony', NULL, NULL, NULL, NULL, NULL, 720, 'VPL-DX221', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `realiza`
--

CREATE TABLE `realiza` (
  `id_funcionario` int(11) NOT NULL,
  `id_mantencion` int(11) NOT NULL,
  `id_evento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `realiza`
--

INSERT INTO `realiza` (`id_funcionario`, `id_mantencion`, `id_evento`) VALUES
(1, 3, 10),
(1, 3, 11),
(1, 4, 14),
(1, 4, 15),
(1, 16, 13),
(2, 13, 5),
(3, 5, 18),
(3, 5, 19),
(5, 14, 6),
(5, 15, 8),
(5, 15, 9);

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

--
-- Volcado de datos para la tabla `servidor`
--

INSERT INTO `servidor` (`id_equipo`, `marca`, `codigo_qr`, `fecha_garantia`, `valor_equipo`, `fecha_compra`, `numero_serie`, `funcion`, `id_funcionario`, `id_proveedor`) VALUES
(12, 'Dell', NULL, NULL, NULL, NULL, NULL, 'Archivos', NULL, NULL),
(18, 'HP', NULL, NULL, NULL, NULL, NULL, 'Web', NULL, NULL),
(24, 'IBM', NULL, NULL, NULL, NULL, NULL, 'Base de Datos', NULL, NULL),
(30, 'Dell', NULL, NULL, NULL, NULL, NULL, 'Correo', NULL, NULL),
(36, 'Supermicro', NULL, NULL, NULL, NULL, NULL, 'Virtualización', NULL, NULL);

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
  ADD KEY `fk_evento_func` (`id_funcionario`),
  ADD KEY `fk_evento_equipo` (`id_equipo`);

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
-- AUTO_INCREMENT de la tabla `correctiva`
--
ALTER TABLE `correctiva`
  MODIFY `id_mantencion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `departamento`
--
ALTER TABLE `departamento`
  MODIFY `id_departamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `equipo_general`
--
ALTER TABLE `equipo_general`
  MODIFY `id_equipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `evento`
--
ALTER TABLE `evento`
  MODIFY `id_evento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `funcionario`
--
ALTER TABLE `funcionario`
  MODIFY `id_funcionario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `preventiva`
--
ALTER TABLE `preventiva`
  MODIFY `id_mantencion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

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
  ADD CONSTRAINT `fk_evento_equipo` FOREIGN KEY (`id_equipo`) REFERENCES `equipo_general` (`id_equipo`) ON DELETE CASCADE,
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

--
-- indicador para obligarlo a cambiar la contraseña
--
ALTER TABLE funcionario
ADD cambiar_contrasena TINYINT(1) NOT NULL DEFAULT 0;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
