<?php
require_once("../conexion.php");
require_once("../models/Mod_Historial.php");
session_start();



$equipos_por_pagina = 15;
$pagina_actual = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;

if ($pagina_actual < 1) {
    $pagina_actual = 1;
}

$total_equipos = contarEquiposHistorial($conexion);
$total_paginas = max(1, (int) ceil($total_equipos / $equipos_por_pagina));

if ($pagina_actual > $total_paginas) {
    $pagina_actual = $total_paginas;
}

$offset = ($pagina_actual - 1) * $equipos_por_pagina;
$desde_equipo = $total_equipos > 0 ? $offset + 1 : 0;
$hasta_equipo = min($offset + $equipos_por_pagina, $total_equipos);

$filasHistorial = obtenerHistorialEquipos($conexion, $equipos_por_pagina, $offset);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial - NodoActivo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/style.css?v=8">
    <script src="../assets/script.js" defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>

<div class="Container d-flex flex-row vh-100 overflow-hidden">

    <div class="Barra_Lateral d-flex flex-column justify-content-between p-3" style="background-color: #BBBFBF;">
        <div class="Superior d-flex flex-column justify-content-start align-items-start gap-2">

            <div class="Inicio p-2 d-flex flex-row justify-content-start gap-0">
                <p class="fs-4 fw-bold" style="color: #05ad98;">Nodo</p>
                <p class="fs-4 fw-bold text-black">Activo</p>
            </div>

            <hr class="m-0 w-100" style="color: #000000;">

            <div class="Inicio">
                <a href="index_admin.php" class="d-flex flex-row justify-content-start gap-2 align-items-center text-decoration-none text-black p-2 rounded-1">
                    <span class="material-symbols-outlined fs-5">house</span>
                    <p class="m-0 fs-6">Inicio</p>
                </a>
            </div>

            <div class="Equipos">
                <a href="equipos.php" class="d-flex flex-row justify-content-start gap-2 align-items-center text-decoration-none text-black p-2 rounded-1">
                    <span class="material-symbols-outlined fs-5">computer</span>
                    <p class="m-0 fs-6">Equipos</p>
                </a>
            </div>

            <div class="Funcionarios">
                <a href="funcionarios.php" class="d-flex flex-row justify-content-start gap-2 align-items-center text-decoration-none text-black p-2 rounded-1">
                    <span class="material-symbols-outlined fs-5">person</span>
                    <p class="m-0 fs-6">Funcionarios</p>
                </a>
            </div>

            <div class="Departamentos">
                <a href="departamentos.php" class="d-flex flex-row justify-content-start gap-2 align-items-center text-decoration-none text-black p-2 rounded-1">
                    <span class="material-symbols-outlined fs-5">apartment</span>
                    <p class="m-0 fs-6">Departamentos</p>
                </a>
            </div>

            <div class="Proovedores">
                <a href="proveedores.php" class="d-flex flex-row justify-content-start gap-2 align-items-center text-decoration-none text-black p-2 rounded-1">
                    <span class="material-symbols-outlined">person_4</span>
                    <p class="m-0 fs-6">Proveedores</p>
                </a>
            </div>

            <div class="Mantenciones">
                <a href="mantenciones.php" class="d-flex flex-row justify-content-start gap-2 align-items-center text-decoration-none text-black p-2 rounded-1">
                    <span class="material-symbols-outlined fs-5">handyman</span>
                    <p class="m-0 fs-6">Mantenciones</p>
                </a>
            </div>

            <div class="Historial">
                <a href="historial.php" class="Barra_Izquierda_Index_active d-flex flex-row justify-content-start gap-2 align-items-center text-decoration-none text-black p-2 rounded-1">
                    <span class="material-symbols-outlined fs-5">history</span>
                    <p class="m-0 fs-6">Historial</p>
                </a>
            </div>
        </div>

        <div class="Inferior">

            <div class="Cerrar_Sesion">
                <a href="../sesion.php?logout=1" class="d-flex flex-row justify-content-start gap-2 align-items-center text-decoration-none text-danger p-2">
                    <span class="material-symbols-outlined">logout</span>
                    <p class="m-0 fs-6">Cerrar Sesion</p>
                </a>
            </div>
        </div>
    </div>

    <div class="flex-grow-1 p-4" style="background-color: #F4F6F8; overflow-y: auto;">
        <div class="titulo-seccion d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center gap-3">
                <div class="titulo-seccion-linea"></div>
                <div>
                    <h2 class="fs-4 fw-bold m-0" style="color: #333333;">Historial de Equipos</h2>
                    <p class="titulo-seccion-texto m-0">Selecciona un equipo para revisar sus eventos asociados</p>
                </div>
            </div>
        </div>

        <div class="my-3 d-flex flex-row justify-content-between">
            <div class="input-group flex-nowrap" style="max-width: 450px">
                <span class="input-group-text material-symbols-outlined">search</span>
                <input type="text" class="Buscador form-control" placeholder="Buscar por ID, Modelo, Tipo, etc">
            </div>
        </div>

        <div class="card shadow-sm border-0 rounded-3" style="border-top: 3px solid #05ad98; overflow: hidden;">
            <div class="card-body p-0">
                <table class="table table-hover m-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="p-3 text-secondary" style="font-size: 0.9rem; font-weight: 600;">ID Equipo</th>
                            <th class="p-3 text-secondary" style="font-size: 0.9rem; font-weight: 600;">Tipo</th>
                            <th class="p-3 text-secondary" style="font-size: 0.9rem; font-weight: 600;">Marca</th>
                            <th class="p-3 text-secondary" style="font-size: 0.9rem; font-weight: 600;">Modelo</th>
                            <th class="p-3 text-secondary" style="font-size: 0.9rem; font-weight: 600;">Funcionario</th>
                            <th class="p-3 text-secondary text-center" style="font-size: 0.9rem; font-weight: 600;">Eventos</th>
                            <th class="p-3 text-secondary text-center" style="font-size: 0.9rem; font-weight: 600;">Historial</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($filasHistorial as $fila): ?>
                            <tr>
                                <td class="p-3 text-muted"><?php echo $fila['id_equipo']; ?></td>
                                <td class="p-3 fw-semibold" style="color: #05ad98;"><?php echo $fila['tipo']; ?></td>
                                <td class="p-3 fw-medium text-dark"><?php echo $fila['marca']; ?></td>
                                <td class="p-3 text-secondary"><?php echo $fila['modelo']; ?></td>
                                <td class="p-3 fw-semibold" style="color: #05ad98;"><?php echo $fila['funcionario']; ?></td>
                                <td class="p-3 fw-medium text-dark text-center"><?php echo (int) $fila['total_eventos']; ?></td>
                                <td class="p-3 text-center">
                                    <a href="equipos_historial.php?id=<?php echo $fila['id_equipo']; ?>&tipo=<?php echo $fila['tipo']; ?>" class="Buttons_equipo btn btn-sm border">
                                        <span class="material-symbols-outlined align-middle">visibility</span>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mt-3">
            <p class="text-secondary m-0">
                Mostrando <?php echo $desde_equipo; ?> a <?php echo $hasta_equipo; ?> de <?php echo $total_equipos; ?> equipos
            </p>

            <?php if ($total_paginas > 1): ?>
                <nav aria-label="Paginacion de historial">
                    <ul class="pagination equipos-paginacion mb-0">
                        <li class="page-item <?php echo $pagina_actual <= 1 ? 'disabled' : ''; ?>">
                            <a class="page-link" href="?pagina=<?php echo $pagina_actual - 1; ?>">Anterior</a>
                        </li>

                        <?php for ($pagina = 1; $pagina <= $total_paginas; $pagina++): ?>
                            <li class="page-item <?php echo $pagina === $pagina_actual ? 'active' : ''; ?>">
                                <a class="page-link" href="?pagina=<?php echo $pagina; ?>"><?php echo $pagina; ?></a>
                            </li>
                        <?php endfor; ?>

                        <li class="page-item <?php echo $pagina_actual >= $total_paginas ? 'disabled' : ''; ?>">
                            <a class="page-link" href="?pagina=<?php echo $pagina_actual + 1; ?>">Siguiente</a>
                        </li>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
