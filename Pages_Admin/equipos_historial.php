<?php
require_once("../conexion.php");
require_once("../models/Mod_Historial.php");
session_start();

$id_equipo = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$equipo = obtenerEquipoHistorial($conexion, $id_equipo);

if (!$equipo) {
    header('Location: historial.php');
    exit();
}

$eventos = obtenerEventosEquipo($conexion, $id_equipo);
$costoTotalEquipo = 0;

foreach ($eventos as $evento) {
    $costoTotalEquipo += (float) $evento['costo_asociado'];
}

function fechaEvento($fecha) {
    return date('d-m-Y H:i', strtotime($fecha));
}

function estadoEvento($evento) {
    if (empty($evento)) {
        return 'activo';
    }

    return in_array($evento['tipo_evento'], ['Mantencion preventiva', 'Mantencion correctiva'], true)
        && $evento['estado_equipo'] === 'en reparacion'
        ? 'en mantencion'
        : ($evento['estado_equipo'] ?: 'activo');
}
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial Equipo - NodoActivo</title>
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="manifest" href="/site.webmanifest">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/style.css?v=6">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body class="detalle-page">

<div class="detalle-contenedor container-fluid my-5">
    <div class="titulo-seccion d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center gap-3">
            <div class="titulo-seccion-linea"></div>
            <div>
                <h1 class="fs-4 fw-bold m-0" style="color: #333333;">Historial del Equipo</h1>
                <p class="titulo-seccion-texto m-0">
                    Equipo <?php echo (int) $equipo['id_equipo']; ?> - <?php echo $equipo['tipo']; ?>
                </p>
            </div>
        </div>

        <a href="historial.php" class="btn button d-flex align-items-center gap-2 px-3 py-2 fw-semibold">
            <span class="material-symbols-outlined fs-5">arrow_back</span>
            Volver
        </a>
    </div>

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
                <div class="detalle-valor"><?php echo $equipo['tipo']; ?></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="detalle-campo">
                <span class="detalle-label">Costo total</span>
                <div class="detalle-valor">$<?php echo number_format($costoTotalEquipo, 0, ',', '.'); ?></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="detalle-campo">
                <span class="detalle-label">Estado</span>
                <div class="detalle-valor">
                    <?php echo estadoEvento($eventos[0] ?? null); ?>
                </div>
            </div>
        </div>
    </div>

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
                        <th class="p-3 text-secondary text-end" style="font-size: 0.9rem; font-weight: 600;">Costo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($eventos)): ?>
                        <tr>
                            <td colspan="6" class="p-4 text-center text-secondary">
                                Este equipo esta activo y aun no tiene eventos registrados.
                            </td>
                        </tr>
                    <?php endif; ?>

                    <?php foreach ($eventos as $evento): ?>
                        <tr>
                            <td class="p-3 text-secondary"><?php echo fechaEvento($evento['fecha_evento']); ?></td>
                            <td class="p-3 fw-semibold" style="color: #05ad98;"><?php echo $evento['tipo_evento']; ?></td>
                            <td class="p-3 fw-medium text-dark"><?php echo estadoEvento($evento); ?></td>
                            <td class="p-3 text-secondary"><?php echo $evento['descripcion']; ?></td>
                            <td class="p-3 text-secondary"><?php echo $evento['funcionario']; ?></td>
                            <td class="p-3 fw-medium text-dark text-end">$<?php echo number_format((float) $evento['costo_asociado'], 0, ',', '.'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
