SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO'
START TRANSACTION;
SET time_zone ='+00:00'

--
-- Base de datos: `NodoActivoDB`
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


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento`
--

CREATE TABLE `departamento` (
  `id_departamento` int(11) NOT NULL,
  `nombre_departamento` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipo_general`
--

CREATE TABLE `equipo_general` (
  `id_equipo` int(11) NOT NULL,
  `tipo_equipo` enum('Computador','Proyector','Impresora','Notebook','Servidor','Otro Dispositivo') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evento`
--

CREATE TABLE `evento` (
  `id_evento` int(11) NOT NULL,
  `id_equipo` int(11) DEFAULT NULL,
  `estado_equipo` enum('activo','en reparacion','dado de baja') DEFAULT NULL,
  `fecha_evento` datetime DEFAULT NULL,
  `tipo_evento` enum('Ingreso Equipo','Asignacion a funcionario','Reasignacion a funcionario','Mantencion preventiva','Mantencion correctiva','Actualizacion de software','Dado de baja') NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `costo_asociado` double DEFAULT NULL,
  `id_funcionario` int(11) DEFAULT NULL,
  `id_mantencion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


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
  `contrasena` varchar(255) DEFAULT NULL,
  `cambiar_contrasena` TINYINT NOT NULL DEFAULT 0
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
  MODIFY `id_mantencion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT de la tabla `departamento`
--
ALTER TABLE `departamento`
  MODIFY `id_departamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT de la tabla `equipo_general`
--
ALTER TABLE `equipo_general`
  MODIFY `id_equipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT de la tabla `evento`
--
ALTER TABLE `evento`
  MODIFY `id_evento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT de la tabla `funcionario`
--
ALTER TABLE `funcionario`
  MODIFY `id_funcionario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT de la tabla `preventiva`
--
ALTER TABLE `preventiva`
  MODIFY `id_mantencion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

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



-- --------------------------------------------------------
-- INSERCIÓN DE PROVEEDORES (10 registros)
-- --------------------------------------------------------
INSERT INTO proveedor (rut_proveedor, nombre_completo, Contacto) VALUES 
(76543210, 'Tech Solutions SpA', 'contacto@techsolutions.cl'),
(77654321, 'Innova TI Limitada', 'ventas@innovati.cl'),
(78765432, 'PC Express', 'soporte@pcexpress.cl'),
(79876543, 'SysCorp Distribución', 'info@syscorp.cl'),
(80987654, 'HardWare Pro S.A.', 'ventas@hwpro.cl'),
(81098765, 'NetWorks Chile', 'contacto@networkschile.cl'),
(82109876, 'CompuMundo', 'ventas@compumundo.cl'),
(83210987, 'Servicios Globales TI', 'gerencia@sgti.cl'),
(84321098, 'OfiTech Equipamientos', 'ventas@ofitech.cl'),
(85432109, 'GigaByte Chile SpA', 'contacto@gigabyte.cl');

-- --------------------------------------------------------
-- INSERCIÓN DE FUNCIONARIOS (40 registros: 1 Admin, 3 Técnicos, 36 Funcionarios)
-- Todas las contraseñas son '123'
-- --------------------------------------------------------
INSERT INTO funcionario (rut, nombre_completo, id_departamento, rol, contrasena, cambiar_contrasena) VALUES 
(11111111, 'Carlos Perez', 1, 'Administrador', '123', 0),
(12222222, 'Maria Gomez', 1, 'Tecnico', '123', 0),
(13333333, 'Juan Rojas', 1, 'Tecnico', '123', 0),
(14444444, 'Pedro Soto', 1, 'Tecnico', '123', 0),
(15555555, 'Ana Torres', 2, 'Funcionario', '123', 0),
(16666666, 'Luis Castro', 2, 'Funcionario', '123', 0),
(17777777, 'Carmen Silva', 2, 'Funcionario', '123', 0),
(18888888, 'Jose Morales', 3, 'Funcionario', '123', 0),
(19999999, 'Claudia Ortiz', 3, 'Funcionario', '123', 0),
(20000000, 'Jorge Reyes', 3, 'Funcionario', '123', 0),
(21111111, 'Monica Nuñez', 4, 'Funcionario', '123', 0),
(22222222, 'Victor Herrera', 4, 'Funcionario', '123', 0),
(23333333, 'Paula Medina', 4, 'Funcionario', '123', 0),
(24444444, 'Raul Vargas', 5, 'Funcionario', '123', 0),
(25555555, 'Sara Guzman', 5, 'Funcionario', '123', 0),
(26666666, 'Diego Flores', 1, 'Funcionario', '123', 0),
(27777777, 'Camila Muñoz', 2, 'Funcionario', '123', 0),
(28888888, 'Rodrigo Vega', 3, 'Funcionario', '123', 0),
(29999999, 'Fernanda Rios', 4, 'Funcionario', '123', 0),
(30000000, 'Daniela Fuentes', 5, 'Funcionario', '123', 0),
(31111111, 'Andres Tapia', 1, 'Funcionario', '123', 0),
(32222222, 'Lorena Carrasco', 2, 'Funcionario', '123', 0),
(33333333, 'Felipe Navarro', 3, 'Funcionario', '123', 0),
(34444444, 'Natalia Araya', 4, 'Funcionario', '123', 0),
(35555555, 'Cristian Cardenas', 5, 'Funcionario', '123', 0),
(36666666, 'Belen Salazar', 1, 'Funcionario', '123', 0),
(37777777, 'Sebastian Pinto', 2, 'Funcionario', '123', 0),
(38888888, 'Javiera Bravo', 3, 'Funcionario', '123', 0),
(39999999, 'Nicolas Figueroa', 4, 'Funcionario', '123', 0),
(40000000, 'Valeria Cortes', 5, 'Funcionario', '123', 0),
(41111111, 'Matias Valdes', 1, 'Funcionario', '123', 0),
(42222222, 'Catalina Pavez', 2, 'Funcionario', '123', 0),
(43333333, 'Francisco Vera', 3, 'Funcionario', '123', 0),
(44444444, 'Marcela Pizarro', 4, 'Funcionario', '123', 0),
(45555555, 'Ignacio Cabrera', 5, 'Funcionario', '123', 0),
(46666666, 'Carolina Moya', 1, 'Funcionario', '123', 0),
(47777777, 'Esteban Peña', 2, 'Funcionario', '123', 0),
(48888888, 'Macarena Leal', 3, 'Funcionario', '123', 0),
(49999999, 'Gabriel Osorio', 4, 'Funcionario', '123', 0),
(50000000, 'Andrea Riquelme', 5, 'Funcionario', '123', 0);

-- --------------------------------------------------------
-- INSERCIÓN DE EQUIPO GENERAL (100 registros)
-- 1-20: Computador | 21-40: Notebook | 41-55: Proyector 
-- 56-70: Impresora | 71-80: Servidor | 81-100: Otro Dispositivo
-- --------------------------------------------------------
INSERT INTO equipo_general (tipo_equipo) VALUES 
('Computador'), ('Computador'), ('Computador'), ('Computador'), ('Computador'),
('Computador'), ('Computador'), ('Computador'), ('Computador'), ('Computador'),
('Computador'), ('Computador'), ('Computador'), ('Computador'), ('Computador'),
('Computador'), ('Computador'), ('Computador'), ('Computador'), ('Computador'),
('Notebook'), ('Notebook'), ('Notebook'), ('Notebook'), ('Notebook'),
('Notebook'), ('Notebook'), ('Notebook'), ('Notebook'), ('Notebook'),
('Notebook'), ('Notebook'), ('Notebook'), ('Notebook'), ('Notebook'),
('Notebook'), ('Notebook'), ('Notebook'), ('Notebook'), ('Notebook'),
('Proyector'), ('Proyector'), ('Proyector'), ('Proyector'), ('Proyector'),
('Proyector'), ('Proyector'), ('Proyector'), ('Proyector'), ('Proyector'),
('Proyector'), ('Proyector'), ('Proyector'), ('Proyector'), ('Proyector'),
('Impresora'), ('Impresora'), ('Impresora'), ('Impresora'), ('Impresora'),
('Impresora'), ('Impresora'), ('Impresora'), ('Impresora'), ('Impresora'),
('Impresora'), ('Impresora'), ('Impresora'), ('Impresora'), ('Impresora'),
('Servidor'), ('Servidor'), ('Servidor'), ('Servidor'), ('Servidor'),
('Servidor'), ('Servidor'), ('Servidor'), ('Servidor'), ('Servidor'),
('Otro Dispositivo'), ('Otro Dispositivo'), ('Otro Dispositivo'), ('Otro Dispositivo'), ('Otro Dispositivo'),
('Otro Dispositivo'), ('Otro Dispositivo'), ('Otro Dispositivo'), ('Otro Dispositivo'), ('Otro Dispositivo'),
('Otro Dispositivo'), ('Otro Dispositivo'), ('Otro Dispositivo'), ('Otro Dispositivo'), ('Otro Dispositivo'),
('Otro Dispositivo'), ('Otro Dispositivo'), ('Otro Dispositivo'), ('Otro Dispositivo'), ('Otro Dispositivo');

-- --------------------------------------------------------
-- ASIGNACIÓN ESPECÍFICA DE COMPUTADORES Y NOTEBOOKS 
-- (Garantiza 1 equipo por cada uno de los 40 funcionarios)
-- --------------------------------------------------------

-- 20 Computadores (Para funcionarios ID 1 al 20)
INSERT INTO computador (id_equipo, marca, codigo_qr, fecha_garantia, valor_equipo, fecha_compra, numero_serie, procesador, memoria_ram, almacenamiento, id_funcionario, modelo_procesador, cantidad_ram, cantidad_almacenamiento, id_proveedor) VALUES
(1, 'Dell', 'QRC01', '2027-01-10', 450000, '2025-01-10', 101, 'Intel', 'DDR4', 'SSD M.2', 1, 'Core i5', 16, 512, 1),
(2, 'HP', 'QRC02', '2027-01-10', 450000, '2025-01-10', 102, 'Ryzen', 'DDR4', 'SSD SATA', 2, 'Ryzen 5', 16, 512, 2),
(3, 'Lenovo', 'QRC03', '2027-02-15', 500000, '2025-02-15', 103, 'Intel', 'DDR5', 'SSD M.2', 3, 'Core i7', 32, 1000, 3),
(4, 'Acer', 'QRC04', '2027-03-20', 420000, '2025-03-20', 104, 'Ryzen', 'DDR4', 'HDD', 4, 'Ryzen 3', 8, 1000, 4),
(5, 'Dell', 'QRC05', '2027-04-12', 480000, '2025-04-12', 105, 'Intel', 'DDR4', 'SSD M.2', 5, 'Core i5', 16, 512, 1),
(6, 'HP', 'QRC06', '2027-05-18', 470000, '2025-05-18', 106, 'Ryzen', 'DDR5', 'SSD M.2', 6, 'Ryzen 7', 16, 1000, 2),
(7, 'Lenovo', 'QRC07', '2027-06-22', 460000, '2025-06-22', 107, 'Intel', 'DDR4', 'SSD SATA', 7, 'Core i3', 8, 256, 3),
(8, 'Dell', 'QRC08', '2027-07-30', 510000, '2025-07-30', 108, 'Ryzen', 'DDR4', 'SSD M.2', 8, 'Ryzen 5', 16, 512, 4),
(9, 'HP', 'QRC09', '2027-08-14', 490000, '2025-08-14', 109, 'Intel', 'DDR5', 'SSD M.2', 9, 'Core i5', 16, 512, 5),
(10, 'Lenovo', 'QRC10', '2027-09-05', 550000, '2025-09-05', 110, 'Intel', 'DDR4', 'HDD', 10, 'Core i7', 32, 2000, 6),
(11, 'Dell', 'QRC11', '2028-01-10', 450000, '2026-01-10', 111, 'Ryzen', 'DDR5', 'SSD M.2', 11, 'Ryzen 5', 16, 512, 1),
(12, 'HP', 'QRC12', '2028-02-15', 480000, '2026-02-15', 112, 'Intel', 'DDR4', 'SSD SATA', 12, 'Core i5', 8, 512, 2),
(13, 'Lenovo', 'QRC13', '2028-03-20', 520000, '2026-03-20', 113, 'Ryzen', 'DDR4', 'SSD M.2', 13, 'Ryzen 7', 16, 1000, 3),
(14, 'Acer', 'QRC14', '2028-04-25', 430000, '2026-04-25', 114, 'Intel', 'DDR4', 'HDD', 14, 'Core i3', 8, 1000, 4),
(15, 'Dell', 'QRC15', '2028-05-30', 470000, '2026-05-30', 115, 'Intel', 'DDR5', 'SSD M.2', 15, 'Core i5', 16, 512, 5),
(16, 'HP', 'QRC16', '2028-06-15', 490000, '2026-06-15', 116, 'Ryzen', 'DDR4', 'SSD SATA', 16, 'Ryzen 5', 16, 512, 6),
(17, 'Lenovo', 'QRC17', '2028-07-20', 510000, '2026-07-20', 117, 'Intel', 'DDR4', 'SSD M.2', 17, 'Core i7', 16, 1000, 7),
(18, 'Dell', 'QRC18', '2028-08-25', 460000, '2026-08-25', 118, 'Ryzen', 'DDR5', 'SSD M.2', 18, 'Ryzen 3', 8, 256, 8),
(19, 'HP', 'QRC19', '2028-09-30', 530000, '2026-09-30', 119, 'Intel', 'DDR4', 'SSD M.2', 19, 'Core i5', 32, 1000, 9),
(20, 'Lenovo', 'QRC20', '2028-10-15', 500000, '2026-10-15', 120, 'Ryzen', 'DDR4', 'HDD', 20, 'Ryzen 5', 16, 2000, 10);

-- 20 Notebooks (Para funcionarios ID 21 al 40)
INSERT INTO notebook (id_equipo, marca, codigo_qr, fecha_garantia, valor_equipo, fecha_compra, numero_serie, procesador, memoria_ram, modelo, almacenamiento, id_funcionario, cantidad_ram, cantidad_almacenamiento, modelo_procesador, id_proveedor) VALUES
(21, 'Apple', 'QRN01', '2027-01-15', 900000, '2025-01-15', 201, 'Intel', 'DDR5', 'MacBook Pro', 'SSD M.2', 21, 16, 512, 'Core i5', 1),
(22, 'Asus', 'QRN02', '2027-02-20', 650000, '2025-02-20', 202, 'Ryzen', 'DDR4', 'ZenBook', 'SSD M.2', 22, 16, 512, 'Ryzen 7', 2),
(23, 'Lenovo', 'QRN03', '2027-03-25', 700000, '2025-03-25', 203, 'Intel', 'DDR4', 'ThinkPad', 'SSD M.2', 23, 32, 1000, 'Core i7', 3),
(24, 'HP', 'QRN04', '2027-04-10', 550000, '2025-04-10', 204, 'Ryzen', 'DDR4', 'ProBook', 'SSD SATA', 24, 8, 256, 'Ryzen 3', 4),
(25, 'Dell', 'QRN05', '2027-05-15', 720000, '2025-05-15', 205, 'Intel', 'DDR5', 'XPS 13', 'SSD M.2', 25, 16, 512, 'Core i5', 5),
(26, 'Acer', 'QRN06', '2027-06-20', 600000, '2025-06-20', 206, 'Ryzen', 'DDR4', 'Swift 3', 'SSD M.2', 26, 16, 512, 'Ryzen 5', 6),
(27, 'Asus', 'QRN07', '2027-07-25', 680000, '2025-07-25', 207, 'Intel', 'DDR4', 'VivoBook', 'HDD', 27, 8, 1000, 'Core i3', 7),
(28, 'Lenovo', 'QRN08', '2027-08-30', 750000, '2025-08-30', 208, 'Ryzen', 'DDR5', 'Legion', 'SSD M.2', 28, 32, 1000, 'Ryzen 7', 8),
(29, 'HP', 'QRN09', '2027-09-15', 620000, '2025-09-15', 209, 'Intel', 'DDR4', 'EliteBook', 'SSD M.2', 29, 16, 512, 'Core i5', 9),
(30, 'Dell', 'QRN10', '2027-10-20', 780000, '2025-10-20', 210, 'Ryzen', 'DDR4', 'Inspiron', 'SSD M.2', 30, 16, 1000, 'Ryzen 5', 10),
(31, 'Apple', 'QRN11', '2028-01-15', 950000, '2026-01-15', 211, 'Intel', 'DDR5', 'MacBook Air', 'SSD M.2', 31, 8, 256, 'Core i5', 1),
(32, 'Asus', 'QRN12', '2028-02-20', 670000, '2026-02-20', 212, 'Ryzen', 'DDR4', 'ZenBook', 'SSD M.2', 32, 16, 512, 'Ryzen 7', 2),
(33, 'Lenovo', 'QRN13', '2028-03-25', 720000, '2026-03-25', 213, 'Intel', 'DDR4', 'ThinkPad', 'SSD M.2', 33, 16, 512, 'Core i7', 3),
(34, 'HP', 'QRN14', '2028-04-10', 570000, '2026-04-10', 214, 'Ryzen', 'DDR4', 'ProBook', 'SSD SATA', 34, 8, 512, 'Ryzen 5', 4),
(35, 'Dell', 'QRN15', '2028-05-15', 740000, '2026-05-15', 215, 'Intel', 'DDR5', 'XPS 15', 'SSD M.2', 35, 32, 1000, 'Core i7', 5),
(36, 'Acer', 'QRN16', '2028-06-20', 610000, '2026-06-20', 216, 'Ryzen', 'DDR4', 'Swift 5', 'SSD M.2', 36, 16, 512, 'Ryzen 7', 6),
(37, 'Asus', 'QRN17', '2028-07-25', 690000, '2026-07-25', 217, 'Intel', 'DDR4', 'VivoBook Pro', 'SSD M.2', 37, 16, 1000, 'Core i5', 7),
(38, 'Lenovo', 'QRN18', '2028-08-30', 770000, '2026-08-30', 218, 'Ryzen', 'DDR5', 'IdeaPad', 'SSD M.2', 38, 16, 512, 'Ryzen 5', 8),
(39, 'HP', 'QRN19', '2028-09-15', 640000, '2026-09-15', 219, 'Intel', 'DDR4', 'Spectre', 'SSD M.2', 39, 16, 512, 'Core i7', 9),
(40, 'Dell', 'QRN20', '2028-10-20', 790000, '2026-10-20', 220, 'Ryzen', 'DDR4', 'Latitude', 'SSD M.2', 40, 32, 1000, 'Ryzen 7', 10);

-- --------------------------------------------------------
-- INSERCIÓN RESTO DE EQUIPOS 
-- --------------------------------------------------------

-- 15 Proyectores (Sin funcionario asignado)
INSERT INTO proyector (id_equipo, marca, codigo_qr, fecha_garantia, valor_equipo, fecha_compra, numero_serie, calidad_imagen, modelo, id_funcionario, id_proveedor) VALUES 
(41, 'Epson', 'QRP01', '2027-01-01', 300000, '2025-01-01', 301, 1080, 'PowerLite', NULL, 1),
(42, 'Sony', 'QRP02', '2027-02-01', 320000, '2025-02-01', 302, 1080, 'VPL-EX', NULL, 2),
(43, 'BenQ', 'QRP03', '2027-03-01', 280000, '2025-03-01', 303, 720, 'MS550', NULL, 3),
(44, 'ViewSonic', 'QRP04', '2027-04-01', 350000, '2025-04-01', 304, 1080, 'PA503W', NULL, 4),
(45, 'Epson', 'QRP05', '2027-05-01', 400000, '2025-05-01', 305, 4000, 'Home Cinema', NULL, 5),
(46, 'Sony', 'QRP06', '2027-06-01', 310000, '2025-06-01', 306, 1080, 'VPL-DX', NULL, 6),
(47, 'BenQ', 'QRP07', '2027-07-01', 290000, '2025-07-01', 307, 720, 'MW560', NULL, 7),
(48, 'ViewSonic', 'QRP08', '2027-08-01', 360000, '2025-08-01', 308, 1080, 'PX701', NULL, 8),
(49, 'Epson', 'QRP09', '2028-01-01', 420000, '2026-01-01', 309, 4000, 'Pro EX', NULL, 9),
(50, 'Sony', 'QRP10', '2028-02-01', 330000, '2026-02-01', 310, 1080, 'VPL-PHZ', NULL, 10),
(51, 'BenQ', 'QRP11', '2028-03-01', 300000, '2026-03-01', 311, 720, 'MH560', NULL, 1),
(52, 'ViewSonic', 'QRP12', '2028-04-01', 370000, '2026-04-01', 312, 1080, 'PG706HD', NULL, 2),
(53, 'Epson', 'QRP13', '2028-05-01', 450000, '2026-05-01', 313, 4000, 'BrightLink', NULL, 3),
(54, 'Sony', 'QRP14', '2028-06-01', 340000, '2026-06-01', 314, 1080, 'VPL-CW', NULL, 4),
(55, 'BenQ', 'QRP15', '2028-07-01', 310000, '2026-07-01', 315, 720, 'TH585', NULL, 5);

-- 15 Impresoras
INSERT INTO impresora (id_equipo, marca, codigo_qr, fecha_garantia, valor_equipo, fecha_compra, numero_serie, volumen_impresion, modelo, tipo, id_funcionario, id_proveedor) VALUES 
(56, 'HP', 'QRI01', '2027-01-15', 150000, '2025-01-15', 401, 1000, 'LaserJet Pro', 'Laser', NULL, 1),
(57, 'Epson', 'QRI02', '2027-02-15', 120000, '2025-02-15', 402, 500, 'EcoTank', 'Inyección', NULL, 2),
(58, 'Canon', 'QRI03', '2027-03-15', 130000, '2025-03-15', 403, 800, 'PIXMA', 'Inyección', NULL, 3),
(59, 'Brother', 'QRI04', '2027-04-15', 160000, '2025-04-15', 404, 1200, 'HL-L2350DW', 'Laser', NULL, 4),
(60, 'HP', 'QRI05', '2027-05-15', 180000, '2025-05-15', 405, 1500, 'LaserJet Enterprise', 'Laser', NULL, 5),
(61, 'Epson', 'QRI06', '2027-06-15', 140000, '2025-06-15', 406, 600, 'WorkForce', 'Inyección', NULL, 6),
(62, 'Canon', 'QRI07', '2027-07-15', 135000, '2025-07-15', 407, 850, 'imageCLASS', 'Laser', NULL, 7),
(63, 'Brother', 'QRI08', '2027-08-15', 170000, '2025-08-15', 408, 1300, 'MFC-L2710DW', 'Laser', NULL, 8),
(64, 'HP', 'QRI09', '2028-01-15', 155000, '2026-01-15', 409, 1100, 'DeskJet', 'Inyección', NULL, 9),
(65, 'Epson', 'QRI10', '2028-02-15', 125000, '2026-02-15', 410, 550, 'EcoTank Pro', 'Inyección', NULL, 10),
(66, 'Canon', 'QRI11', '2028-03-15', 145000, '2026-03-15', 411, 900, 'MAXIFY', 'Inyección', NULL, 1),
(67, 'Brother', 'QRI12', '2028-04-15', 175000, '2026-04-15', 412, 1400, 'DCP-L2550DW', 'Laser', NULL, 2),
(68, 'HP', 'QRI13', '2028-05-15', 190000, '2026-05-15', 413, 1600, 'PageWide', 'Inyección', NULL, 3),
(69, 'Epson', 'QRI14', '2028-06-15', 145000, '2026-06-15', 414, 650, 'PictureMate', 'Inyección', NULL, 4),
(70, 'Canon', 'QRI15', '2028-07-15', 140000, '2026-07-15', 415, 850, 'SELPHY', 'Inyección', NULL, 5);

-- 10 Servidores
INSERT INTO servidor (id_equipo, marca, codigo_qr, fecha_garantia, valor_equipo, fecha_compra, numero_serie, funcion, id_funcionario, id_proveedor) VALUES 
(71, 'Dell', 'QRS01', '2029-01-01', 2500000, '2024-01-01', 501, 'Base de Datos', 1, 1),
(72, 'HP', 'QRS02', '2029-02-01', 2800000, '2024-02-01', 502, 'Aplicaciones', 2, 2),
(73, 'Lenovo', 'QRS03', '2029-03-01', 2200000, '2024-03-01', 503, 'Almacenamiento', 3, 3),
(74, 'Cisco', 'QRS04', '2029-04-01', 3000000, '2024-04-01', 504, 'Redes', 4, 4),
(75, 'Dell', 'QRS05', '2029-05-01', 2600000, '2024-05-01', 505, 'Virtualización', 1, 5),
(76, 'HP', 'QRS06', '2029-06-01', 2900000, '2024-06-01', 506, 'Correo Electrónico', 2, 6),
(77, 'Lenovo', 'QRS07', '2029-07-01', 2300000, '2024-07-01', 507, 'Respaldos', 3, 7),
(78, 'Cisco', 'QRS08', '2029-08-01', 3100000, '2024-08-01', 508, 'Seguridad', 4, 8),
(79, 'Dell', 'QRS09', '2030-01-01', 2700000, '2025-01-01', 509, 'Desarrollo', 1, 9),
(80, 'HP', 'QRS10', '2030-02-01', 3000000, '2025-02-01', 510, 'Testing', 2, 10);

-- 20 Otros Dispositivos
INSERT INTO otro_dispositivo (id_equipo, marca, codigo_qr, fecha_garantia, valor_equipo, fecha_compra, numero_serie, modelo, id_funcionario, id_proveedor) VALUES 
(81, 'Logitech', 'QRO01', '2026-01-01', 50000, '2025-01-01', 601, 'Webcam C920', NULL, 1),
(82, 'Jabra', 'QRO02', '2026-02-01', 80000, '2025-02-01', 602, 'Evolve 20', NULL, 2),
(83, 'APC', 'QRO03', '2027-03-01', 120000, '2025-03-01', 603, 'UPS 600VA', NULL, 3),
(84, 'Ubiquiti', 'QRO04', '2027-04-01', 150000, '2025-04-01', 604, 'UniFi AP', NULL, 4),
(85, 'D-Link', 'QRO05', '2026-05-01', 40000, '2025-05-01', 605, 'Switch 8 Port', NULL, 5),
(86, 'Logitech', 'QRO06', '2026-06-01', 55000, '2025-06-01', 606, 'Teclado MX', NULL, 6),
(87, 'Jabra', 'QRO07', '2026-07-01', 85000, '2025-07-01', 607, 'Speak 510', NULL, 7),
(88, 'APC', 'QRO08', '2027-08-01', 130000, '2025-08-01', 608, 'UPS 1000VA', NULL, 8),
(89, 'Ubiquiti', 'QRO09', '2027-09-01', 160000, '2025-09-01', 609, 'EdgeRouter', NULL, 9),
(90, 'D-Link', 'QRO10', '2026-10-01', 45000, '2025-10-01', 610, 'Router AC1200', NULL, 10),
(91, 'Logitech', 'QRO11', '2027-01-01', 60000, '2026-01-01', 611, 'Mouse MX Master', NULL, 1),
(92, 'Jabra', 'QRO12', '2027-02-01', 90000, '2026-02-01', 612, 'Elite 45h', NULL, 2),
(93, 'APC', 'QRO13', '2028-03-01', 140000, '2026-03-01', 613, 'Smart-UPS', NULL, 3),
(94, 'Ubiquiti', 'QRO14', '2028-04-01', 170000, '2026-04-01', 614, 'UniFi Switch', NULL, 4),
(95, 'D-Link', 'QRO15', '2027-05-01', 50000, '2026-05-01', 615, 'Camara IP', NULL, 5),
(96, 'Logitech', 'QRO16', '2027-06-01', 65000, '2026-06-01', 616, 'Parlantes Z333', NULL, 6),
(97, 'Jabra', 'QRO17', '2027-07-01', 95000, '2026-07-01', 617, 'Evolve 65', NULL, 7),
(98, 'APC', 'QRO18', '2028-08-01', 150000, '2026-08-01', 618, 'Regulador Voltaje', NULL, 8),
(99, 'Ubiquiti', 'QRO19', '2028-09-01', 180000, '2026-09-01', 619, 'Cloud Key', NULL, 9),
(100, 'D-Link', 'QRO20', '2027-10-01', 55000, '2026-10-01', 620, 'Antena WiFi', NULL, 10);


-- --------------------------------------------------------
-- INSERCIÓN DE MANTENCIONES (Mínimo 6 meses hacia atrás desde 2026-07-15)
-- --------------------------------------------------------

-- 5 Preventivas (Fechas entre Febrero 2026 y Junio 2026)
INSERT INTO preventiva (costo, estado, fecha_prox_mantencion, frecuencia_mantencion, id_funcionario, descripcion, id_equipo, fecha_entrega) VALUES 
(45000, 'operativo', '2026-08-15', '2026-02-15 10:00:00', 2, 'Limpieza interna y cambio pasta termica', 1, '2026-02-16'),
(30000, 'operativo', '2026-09-20', '2026-03-20 11:30:00', 3, 'Revisión ventiladores y polvo', 21, '2026-03-21'),
(55000, 'operativo', '2026-10-10', '2026-04-10 09:15:00', 4, 'Actualizacion BIOS y limpieza', 41, '2026-04-11'),
(40000, 'operativo', '2026-11-05', '2026-05-05 14:00:00', 2, 'Reemplazo rodillos e insumos', 56, '2026-05-06'),
(120000, 'operativo', '2026-12-30', '2026-06-30 16:45:00', 3, 'Mantenimiento preventivo RAID y UPS', 71, '2026-07-01');

-- 5 Correctivas (Fechas entre Febrero 2026 y Junio 2026)
INSERT INTO correctiva (costo, estado, tipo_de_fallo, descripcion, id_funcionario, id_equipo, fecha_entrega) VALUES 
(85000, 'operativo', 'Fallo de Hardware', 'Reemplazo de disco duro dañado', 4, 15, '2026-02-28'),
(60000, 'operativo', 'Fallo de Software', 'Reinstalación de Sistema Operativo', 2, 25, '2026-03-15'),
(150000, 'operativo', 'Fallo de Hardware', 'Cambio lámpara quemada', 3, 45, '2026-04-22'),
(45000, 'operativo', 'Atasco físico', 'Extracción de papel atascado y ajuste', 4, 60, '2026-05-18'),
(250000, 'fuera de servicio', 'Fallo Eléctrico', 'Fuente de poder quemada', 2, 75, '2026-06-10');

-- --------------------------------------------------------
-- INSERCIÓN DE EVENTOS (Histórico asociado a las mantenciones)
-- --------------------------------------------------------
INSERT INTO evento (id_equipo, estado_equipo, fecha_evento, tipo_evento, descripcion, costo_asociado, id_funcionario, id_mantencion) VALUES 
(1, 'activo', '2026-02-15 10:00:00', 'Mantencion preventiva', 'Limpieza interna realizada', 45000, 2, 1),
(21, 'activo', '2026-03-20 11:30:00', 'Mantencion preventiva', 'Revisión terminada OK', 30000, 3, 2),
(41, 'activo', '2026-04-10 09:15:00', 'Mantencion preventiva', 'BIOS actualizada', 55000, 4, 3),
(56, 'activo', '2026-05-05 14:00:00', 'Mantencion preventiva', 'Mantenimiento impresoras', 40000, 2, 4),
(71, 'activo', '2026-06-30 16:45:00', 'Mantencion preventiva', 'Revisión de servidor', 120000, 3, 5),
(15, 'activo', '2026-02-25 09:00:00', 'Mantencion correctiva', 'Ingreso por disco duro dañado', 85000, 4, 1),
(25, 'activo', '2026-03-12 10:30:00', 'Mantencion correctiva', 'Ingreso por falla de SO', 60000, 2, 2),
(45, 'activo', '2026-04-20 11:00:00', 'Mantencion correctiva', 'Ingreso cambio lampara', 150000, 3, 3),
(60, 'activo', '2026-05-17 15:20:00', 'Mantencion correctiva', 'Atasco reportado', 45000, 4, 4),
(75, 'en reparacion', '2026-06-08 08:45:00', 'Mantencion correctiva', 'Reporte de apagado súbito', 250000, 2, 5);

-- --------------------------------------------------------
-- INSERCIÓN TABLA INTERMEDIA REALIZA
-- Asociando al Técnico (id_funcionario 2,3,4), la mantención y el evento.
-- Asumiendo los ID autoincrementales generados 1-5 preventiva, 1-5 correctiva
-- --------------------------------------------------------
INSERT INTO realiza (id_funcionario, id_mantencion, id_evento) VALUES 
(2, 1, 1),
(3, 2, 2),
(4, 3, 3),
(2, 4, 4),
(3, 5, 5),
(4, 1, 6),
(2, 2, 7),
(3, 3, 8),
(4, 4, 9),
(2, 5, 10);
