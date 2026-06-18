<?php
require_once '../conexion.php'; 
require_once '../models/Mod_Equipos.php';

$id = $_GET['id'] ?? $_POST['id'] ?? 0;
$tipo = $_GET['tipo'] ?? $_POST['tipo'] ?? '';
$modo = $_GET['modo'] ?? 'ver';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    unset($_POST['id'], $_POST['tipo'], $_POST['modo']); 
    if (actualizarEquipo($conexion, $id, $tipo, $_POST)) {
        header("Location: equipos_detalle.php?id=$id&tipo=" . urlencode($tipo) . "&modo=ver");
        exit;
    }
}

$data = obtenerDatosCompletos($conexion, $id, $tipo);
$listaFuncionarios = obtenerTodosFuncionarios($conexion);
$listaproovedores = obtenerTodosProveedores($conexion);

?>

<!doctype html>
<html lang="es">
<head>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle Equipos - NodoActivo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/style.css">
    <script src="../assets/script.js" defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

</head>
</head>
<body class="bg-light">

<div class="container my-5" style="max-width: 800px;">
    <a href="equipos.php" class="btn btn-secondary mb-4" style="background-color: #05ad98; border-color: #05ad98;" >Volver</a>

    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="hidden" name="tipo" value="<?php echo $tipo; ?>">

        <div class="card shadow-sm border-0 rounded-3 mb-4" style="border-top: 3px solid #05ad98;">
            <div class="card-header bg-white p-4">
                <h3 class="fs-5 fw-bold m-0 text-dark">Información del Equipo</h3>
            </div>
            <div class="card-body p-4">
                <ul class="list-group list-group-flush">
                    <li class='list-group-item d-flex justify-content-between align-items-center px-0 py-3'>
                        <span class='text-muted fw-semibold'>Tipo de Equipo</span>
                        <span class='text-primary fw-bold'><?php echo $tipo; ?></span>
                    </li>
                    <?php foreach ($data['equipo'] as $col => $val): ?>
                        <li class='list-group-item d-flex justify-content-between align-items-center px-0 py-3'>
                            <span class='text-muted fw-semibold text-capitalize'><?php echo str_replace('_', ' ', $col); ?></span>
                            <?php if ($modo == 'editar'): ?>
                                <input type="text" name="<?php echo $col; ?>" value="<?php echo $val; ?>" class="form-control w-50">
                            <?php else: ?>
                                <span class='text-dark fw-bold'><?php echo $val; ?></span>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <div class="card shadow-sm border-0 rounded-3 mb-4" style="border-top: 3px solid #6c757d;">
            <div class="card-header bg-white p-4">
                <h3 class="fs-5 fw-bold m-0 text-dark">Datos del Funcionario a Cargo</h3>
            </div>
            <div class="card-body p-4">
                <ul class="list-group list-group-flush">
                    <li class='list-group-item d-flex justify-content-between align-items-center px-0 py-3'>
                        <span class='text-muted fw-semibold'>Funcionario Responsable</span>
                        <?php if ($modo == 'editar'): ?>
                            <select name="id_funcionario" class="form-select w-50">
                                <?php foreach ($listaFuncionarios as $f): ?>
                                    <option value="<?php echo $f['id_funcionario']; ?>" <?php echo ($f['nombre_completo'] == $data['funcionario']['Nombre Completo']) ? 'selected' : ''; ?>>
                                        <?php echo $f['nombre_completo']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        <?php else: ?>
                            <span class='text-dark fw-bold'><?php echo $data['funcionario']['Nombre Completo']; ?></span>
                        <?php endif; ?>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card shadow-sm border-0 rounded-3 mb-4" style="border-top: 3px solid #6c757d;">
            <div class="card-header bg-white p-4">
                <h3 class="fs-5 fw-bold m-0 text-dark">Datos del Proveedor</h3>
            </div>
            <div class="card-body p-4">
                <ul class="list-group list-group-flush">
                    <li class='list-group-item d-flex justify-content-between align-items-center px-0 py-3'>
                        <span class='text-muted fw-semibold'>Proveedor del equipo</span>
                        
                        <?php if ($modo == 'editar'): ?>
                            <select name="id_proveedor" class="form-select w-50">
                                <?php foreach ($listaproovedores as $f): ?>
                                    <option value="<?php echo $f['id_proveedor']; ?>" 
                                            <?php echo ($f['id_proveedor'] == $data['proveedor']['id_proveedor']) ? 'selected' : ''; ?>>
                                        <?php echo $f['nombre_completo']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        <?php else: ?>
                            <span class='text-dark fw-bold'>
                                <?php echo $data['proveedor']['nombre_completo'] ?? 'Sin asignar'; ?>
                            </span>
                        <?php endif; ?>
                    </li>
                </ul>
            </div>
        </div>

        <div class="text-end">
            <?php if ($modo == 'ver'): ?>
                <a href="?id=<?php echo $id; ?>&tipo=<?php echo urlencode($tipo); ?>&modo=editar" class="btn" style="background-color: #05ad98; color: white;">Editar</a>
            <?php else: ?>
                <a href="?id=<?php echo $id; ?>&tipo=<?php echo urlencode($tipo); ?>" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn" style="background-color: #05ad98; color: white;">Guardar Cambios</button>
            <?php endif; ?>
        </div>
    </form>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</div>
</body>
</html>