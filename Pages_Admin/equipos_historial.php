<?php
require_once("../conexion.php");
require_once("../models/Mod_Historial.php");
session_start();


$id_equipo = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$tipo_url = $_GET['tipo'] ?? '';

$equipo = $id_equipo > 0 ? obtenerEquipoHistorial($conexion, $id_equipo) : null;
$historialEquipo = $equipo ? obtenerEventosEquipo($conexion, $id_equipo) : ['error' => null, 'filas' => []];
$eventos = $historialEquipo['filas'] ?? [];
$errorHistorial = $historialEquipo['error'] ?? null;

function textoSeguro($valor, $fallback = 'Sin informacion') {
    if ($valor === null || $valor === '') {
        return htmlspecialchars($fallback);
    }

    return htmlspecialchars($valor);
}

function fechaEvento($fecha) {
    if ($fecha === null || $fecha === '') {
        return 'Sin fecha';
    }

    $timestamp = strtotime($fecha);

    if (!$timestamp) {
        return htmlspecialchars($fecha);
    }

    return date('d-m-Y H:i', $timestamp);
}

function estadoEvento($evento) {
    if (
        ($evento['tipo_evento'] === 'Mantencion preventiva' || $evento['tipo_evento'] === 'Mantencion correctiva')
        && $evento['estado_equipo'] === 'en reparacion'
    ) {
        return 'en mantencion';
    }

    return textoSeguro($evento['estado_equipo'], 'Sin estado');
}
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial Equipo - NodoActivo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/style.css?v=6">
    <script src="../assets/script.js" defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body class="detalle-page">

<div class="detalle-contenedor container my-5">
    <div class="titulo-seccion d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center gap-3">
            <div class="titulo-seccion-linea"></div>
            <div>
                <h1 class="fs-4 fw-bold m-0" style="color: #333333;">Historial del Equipo</h1>
                <p class="titulo-seccion-texto m-0">
                    <?php if ($equipo): ?>
                        Equipo <?php echo (int) $equipo['id_equipo']; ?> - <?php echo textoSeguro($equipo['tipo']); ?>
                    <?php else: ?>
                        Equipo no encontrado
                    <?php endif; ?>
                </p>
            </div>
        </div>

        <a href="historial.php" class="btn button d-flex align-items-center gap-2 px-3 py-2 fw-semibold">
            <span class="material-symbols-outlined fs-5">arrow_back</span>
            Volver
        </a>
    </div>

    <?php if (!$equipo): ?>
        <div class="alert alert-warning">
            No se encontro el equipo solicitado.
        </div>
    <?php else: ?>
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="detalle-campo">
                    <span class="detalle-label">ID Equipo</span>
                    <div class="detalle-valor detalle-valor-principal"><?php echo (int) $equipo['id_equipo']; ?></div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="detalle-campo">
                    <span class="detalle-label">Tipo</span>
                    <div class="detalle-valor"><?php echo textoSeguro($equipo['tipo']); ?></div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="detalle-campo">
                    <span class="detalle-label">Marca</span>
                    <div class="detalle-valor"><?php echo textoSeguro($equipo['marca']); ?></div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="detalle-campo">
                    <span class="detalle-label">Estado</span>
                    <div class="detalle-valor">
                        <?php echo count($eventos) > 0 ? estadoEvento($eventos[0]) : 'Por hacer'; ?>
                    </div>
                </div>
            </div>
        </div>

        <?php if ($errorHistorial): ?>
            <div class="alert alert-danger">
                Error al cargar el historial: <?php echo htmlspecialchars($errorHistorial); ?>
            </div>
        <?php endif; ?>

        <div class="card shadow-sm border-0 rounded-3" style="border-top: 3px solid #05ad98; overflow: hidden;">
            <div class="card-body p-0">
                <table class="table table-hover m-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="p-3 text-secondary" style="font-size: 0.9rem; font-weight: 600;">Fecha</th>
                            <th class="p-3 text-secondary" style="font-size: 0.9rem; font-weight: 600;">Evento</th>
                            <th class="p-3 text-secondary" style="font-size: 0.9rem; font-weight: 600;">Estado</th>
                            <th class="p-3 text-secondary" style="font-size: 0.9rem; font-weight: 600;">Descripcion</th>
                            <th class="p-3 text-secondary" style="font-size: 0.9rem; font-weight: 600;">Funcionario</th>
                            <th class="p-3 text-secondary" style="font-size: 0.9rem; font-weight: 600;">Mantencion</th>
                            <th class="p-3 text-secondary text-end" style="font-size: 0.9rem; font-weight: 600;">Costo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!$errorHistorial && count($eventos) > 0): ?>
                            <?php foreach ($eventos as $evento): ?>
                                <tr>
                                    <td class="p-3 text-secondary"><?php echo fechaEvento($evento['fecha_evento']); ?></td>
                                    <td class="p-3 fw-semibold" style="color: #05ad98;"><?php echo textoSeguro($evento['tipo_evento']); ?></td>
                                    <td class="p-3 fw-medium text-dark"><?php echo estadoEvento($evento); ?></td>
                                    <td class="p-3 text-secondary"><?php echo textoSeguro($evento['descripcion'], 'Sin descripcion'); ?></td>
                                    <td class="p-3 text-secondary"><?php echo textoSeguro($evento['funcionario'], 'Sin funcionario'); ?></td>
                                    <td class="p-3 text-secondary"><?php echo textoSeguro($evento['id_mantencion'], 'Sin mantencion'); ?></td>
                                    <td class="p-3 fw-medium text-dark text-end">$<?php echo number_format((float) $evento['costo_asociado'], 0, ',', '.'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php elseif (!$errorHistorial): ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
