<?php
require_once '../conexion.php';
require_once '../models/Mod_Equipos.php';
require_once '../models/Mod_Historial.php';

$id = $_GET['id'];
$tipo = $_GET['tipo'];

$data = obtenerDatosCompletos($conexion, $id, $tipo);
$equipo = $data['equipo'];
$funcionario = $data['funcionario'];
$proveedor = $data['proveedor'];
$estado_actual = obtenerEstadoActualEquipo($conexion, $id);
$eventos = obtenerEventosEquipo($conexion, $id);

function fechaEvento($fecha) {
    return date('d-m-Y H:i', strtotime($fecha));
}

function estadoEvento($evento) {
    return in_array($evento['tipo_evento'], ['Mantencion preventiva', 'Mantencion correctiva'], true)
        && $evento['estado_equipo'] === 'en reparacion'
        ? 'en mantencion'
        : $evento['estado_equipo'];
}
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ficha Tecnica - NodoActivo</title>
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
                <h1 class="fs-4 fw-bold m-0" style="color: #333333;">Detalle del Equipo</h1>
                <p class="titulo-seccion-texto m-0">Equipo <?php echo $id; ?> - <?php echo $tipo; ?></p>
            </div>
        </div>

        <a href="equipos.php" class="btn button d-flex align-items-center gap-2 px-3 py-2 fw-semibold">
            <span class="material-symbols-outlined fs-5">arrow_back</span>
            Volver
        </a>
    </div>

    <div class="detalle-card mb-4">
        <div class="detalle-card-header">
            <h2 class="fs-5 fw-bold m-0 text-dark">Informacion del Equipo</h2>
        </div>

        <div class="detalle-card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="detalle-campo">
                        <span class="detalle-label">Tipo de Equipo</span>
                        <div class="detalle-valor detalle-valor-principal"><?php echo $tipo; ?></div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="detalle-campo">
                        <span class="detalle-label">Estado del Equipo</span>
                        <div class="detalle-valor"><?php echo $estado_actual; ?></div>
                    </div>
                </div>

                <?php foreach ($equipo as $col => $val): ?>
                    <?php if (in_array($col, ['id_funcionario', 'id_proveedor'], true)) { continue; } ?>
                    <div class="col-md-6">
                        <div class="detalle-campo">
                            <span class="detalle-label"><?php echo str_replace('_', ' ', $col); ?></span>
                            <div class="detalle-valor"><?php echo $val; ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="detalle-card h-100">
                <div class="detalle-card-header">
                    <h2 class="fs-5 fw-bold m-0 text-dark">Funcionario a Cargo</h2>
                </div>

                <div class="detalle-card-body">
                    <div class="detalle-campo mb-3">
                        <span class="detalle-label">Responsable</span>
                        <div class="detalle-valor"><?php echo $funcionario['nombre']; ?></div>
                    </div>

                    <div class="detalle-campo">
                        <span class="detalle-label">Departamento</span>
                        <div class="detalle-valor text-muted">
                            <?php echo $funcionario['nombre_departamento']; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="detalle-card h-100">
                <div class="detalle-card-header">
                    <h2 class="fs-5 fw-bold m-0 text-dark">Datos del Proveedor</h2>
                </div>

                <div class="detalle-card-body">
                    <div class="detalle-campo">
                        <span class="detalle-label">Proveedor</span>
                        <div class="detalle-valor"><?php echo $proveedor['nombre_completo']; ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="detalle-card mb-4">
        <div class="detalle-card-header">
            <h2 class="fs-5 fw-bold m-0 text-dark">Historial del Equipo</h2>
        </div>

        <div class="detalle-card-body p-0">
            <div class="table-responsive">
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

    <div class="detalle-card mb-4">
        <div class="detalle-card-header">
            <h2 class="fs-5 fw-bold m-0 text-dark">Codigo QR</h2>
        </div>

        <div class="detalle-card-body text-center">
            <div class="bg-white border rounded-3 d-inline-block p-3">
                <div id="qrcode"></div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
    new QRCode(document.getElementById("qrcode"), {
        text: window.location.href,
        width: 300,
        height: 300,
        colorDark: "#000000",
        colorLight: "#ffffff"
    });
</script>
</body>
</html>
