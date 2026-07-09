<?php
require_once '../conexion.php';
require_once '../models/Mod_Equipos.php';
session_start();


$id = $_GET['id'] ?? $_POST['id'] ?? 0;
$tipo = $_GET['tipo'] ?? $_POST['tipo'] ?? '';
$modo = $_GET['modo'] ?? 'ver';
$estado_actual = obtenerEstadoActualEquipo($conexion, $id);

if ($estado_actual === 'dado de baja') {
    $modo = 'ver';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['dar_baja'])) {
        darDeBajaEquipo($conexion, $id, $tipo);
        header("Location: equipos_detalle.php?id=$id&tipo=" . urlencode($tipo) . "&modo=ver");
        exit;
    }

    if ($estado_actual !== 'dado de baja') {
        unset($_POST['id'], $_POST['tipo'], $_POST['modo']);
        if (actualizarEquipo($conexion, $id, $tipo, $_POST)) {
            header("Location: equipos_detalle.php?id=$id&tipo=" . urlencode($tipo) . "&modo=ver");
            exit;
        }
    }
}

$data = obtenerDatosCompletos($conexion, $id, $tipo);
$estado_actual = obtenerEstadoActualEquipo($conexion, $id);
$listaFuncionarios = obtenerTodosFuncionarios($conexion);
$listaproovedores = obtenerTodosProveedores($conexion);
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle Equipos - NodoActivo</title>
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="manifest" href="/site.webmanifest">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/style.css?v=5">
    <script src="../assets/script.js" defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body class="detalle-page">

<div class="detalle-contenedor container-fluid my-5">
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="hidden" name="tipo" value="<?php echo $tipo; ?>">

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

                    <?php foreach ($data['equipo'] as $col => $val): ?>
                        <?php if (in_array($col, ['id_funcionario', 'id_proveedor'], true)) { continue; } ?>
                        <div class="col-md-6">
                            <div class="detalle-campo">
                                <span class="detalle-label"><?php echo str_replace('_', ' ', $col); ?></span>

                                <?php if ($modo == 'editar'): ?>
                                    <input type="text" name="<?php echo $col; ?>" value="<?php echo $val; ?>" class="detalle-form-control form-control">
                                <?php else: ?>
                                    <div class="detalle-valor"><?php echo $val; ?></div>
                                <?php endif; ?>
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

                            <?php if ($modo == 'editar'): ?>
                                <select name="id_funcionario" class="detalle-form-control form-select">
                                    <option value="" <?php echo empty($data['funcionario']['id_funcionario']) ? 'selected' : ''; ?>>Sin asignar</option>
                                    <?php foreach ($listaFuncionarios as $f): ?>
                                        <option value="<?php echo $f['id_funcionario']; ?>" <?php echo ($f['id_funcionario'] == ($data['funcionario']['id_funcionario'] ?? '')) ? 'selected' : ''; ?>>
                                            <?php echo $f['nombre_completo']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            <?php else: ?>
                                <div class="detalle-valor"><?php echo $data['funcionario']['nombre'] ?? 'Sin asignar'; ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="detalle-campo">
                            <span class="detalle-label">Departamento</span>
                            <div class="detalle-valor text-muted">
                                <?php echo $data['funcionario']['nombre_departamento'] ?? 'Sin asignar'; ?>
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

                            <?php if ($modo == 'editar'): ?>
                                <select name="id_proveedor" class="detalle-form-control form-select">
                                    <option value="" <?php echo empty($data['proveedor']['id_proveedor']) ? 'selected' : ''; ?>>Sin asignar</option>
                                    <?php foreach ($listaproovedores as $f): ?>
                                        <option value="<?php echo $f['id_proveedor']; ?>" <?php echo ($f['id_proveedor'] == ($data['proveedor']['id_proveedor'] ?? '')) ? 'selected' : ''; ?>>
                                            <?php echo $f['nombre_completo']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            <?php else: ?>
                                <div class="detalle-valor"><?php echo $data['proveedor']['nombre_completo'] ?? 'Sin asignar'; ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="detalle-acciones d-flex justify-content-end gap-2">
            <?php if ($modo == 'ver'): ?>
                <?php if ($estado_actual !== 'dado de baja'): ?>
                    <a href="?id=<?php echo $id; ?>&tipo=<?php echo $tipo; ?>&modo=editar" class="btn button px-5 shadow-sm">Editar</a>
                    <button type="button" class="btn btn-outline-danger px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalDarBajaEquipo">Dar de baja</button>
                <?php else: ?>
                    <button type="button" class="btn btn-outline-secondary px-4 shadow-sm" disabled>Equipo dado de baja</button>
                <?php endif; ?>
            <?php else: ?>
                <a href="?id=<?php echo $id; ?>&tipo=<?php echo $tipo; ?>" class="btn btn-secondary px-4 shadow-sm">Cancelar</a>
                <button type="submit" class="btn button px-5 shadow-sm">Guardar Cambios</button>
            <?php endif; ?>
        </div>

        <div class="modal fade" id="modalDarBajaEquipo" tabindex="-1" aria-labelledby="modalDarBajaEquipoLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header border-0 pb-0">
                        <h2 class="modal-title fs-6 fw-bold" id="modalDarBajaEquipoLabel">Dar de baja</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>

                    <div class="modal-body">
                        <p class="m-0">¿Estas seguro que quieres darlo de baja?</p>
                    </div>

                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" name="dar_baja" value="1" class="btn btn-outline-danger btn-sm">Dar de baja</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
