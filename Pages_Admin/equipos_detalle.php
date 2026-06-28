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

<div class="container my-5" style="max-width: 1000px;">
    <a href="equipos.php" class="btn btn-secondary mb-4" style="background-color: #05ad98; border-color: #05ad98;">Volver</a>

    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="hidden" name="tipo" value="<?php echo $tipo; ?>">

        <div class="card shadow-sm border-0 rounded-3 mb-4" style="border-top: 3px solid #05ad98;">
            <div class="card-header bg-white p-4 border-0 pb-2">
                <h3 class="fs-5 fw-bold m-0 text-dark">Información del Equipo</h3>
            </div>
            <div class="card-body p-4 pt-2">
                
                <div class="row g-3">
                    
                    <div class="col-md-6">
                        <div class="input-group shadow-sm h-100">
                            <span class="input-group-text bg-light text-muted fw-semibold" style="width: 40%; min-width: 140px;">Tipo de Equipo</span>
                            <div class="form-control bg-white text-primary fw-bold"><?php echo $tipo; ?></div>
                        </div>
                    </div>

                    <?php foreach ($data['equipo'] as $col => $val): ?>
                        <div class="col-md-6">
                            <div class="input-group shadow-sm h-100">
                                <span class="input-group-text bg-light text-muted fw-semibold text-capitalize" style="width: 40%; min-width: 140px;">
                                    <?php echo str_replace('_', ' ', $col); ?>
                                </span>
                                
                                <?php if ($modo == 'editar'): ?>
                                    <input type="text" name="<?php echo $col; ?>" value="<?php echo $val; ?>" class="form-control">
                                <?php else: ?>
                                    <div class="form-control bg-white text-dark fw-bold"><?php echo $val; ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div> </div>
        </div>

        <div class="row g-4 mb-4">
            
            <div class="col-md-6">
                <div class="card shadow-sm border-0 rounded-3 h-100" style="border-top: 3px solid #6c757d;">
                    <div class="card-header bg-white p-4 border-0 pb-2">
                        <h3 class="fs-5 fw-bold m-0 text-dark">Funcionario a Cargo</h3>
                    </div>
                    <div class="card-body p-4 pt-2">
                        <div class="input-group shadow-sm">
                            <span class="input-group-text bg-light text-muted fw-semibold" style="width: 40%; min-width: 130px;">Responsable</span>
                            
                            <?php if ($modo == 'editar'): ?>
                                <select name="id_funcionario" class="form-select">
                                    <?php foreach ($listaFuncionarios as $f): ?>
                                        <option value="<?php echo $f['id_funcionario']; ?>" <?php echo ($f['nombre_completo'] == $data['funcionario']['Nombre Completo']) ? 'selected' : ''; ?>>
                                            <?php echo $f['nombre_completo']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            <?php else: ?>
                                <div class="form-control bg-white text-dark fw-bold"><?php echo $data['funcionario']['Nombre Completo']; ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm border-0 rounded-3 h-100" style="border-top: 3px solid #6c757d;">
                    <div class="card-header bg-white p-4 border-0 pb-2">
                        <h3 class="fs-5 fw-bold m-0 text-dark">Datos del Proveedor</h3>
                    </div>
                    <div class="card-body p-4 pt-2">
                        <div class="input-group shadow-sm">
                            <span class="input-group-text bg-light text-muted fw-semibold" style="width: 40%; min-width: 130px;">Proveedor</span>
                            
                            <?php if ($modo == 'editar'): ?>
                                <select name="id_proveedor" class="form-select">
                                    <?php foreach ($listaproovedores as $f): ?>
                                        <option value="<?php echo $f['id_proveedor']; ?>" <?php echo ($f['id_proveedor'] == $data['proveedor']['id_proveedor']) ? 'selected' : ''; ?>>
                                            <?php echo $f['nombre_completo']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            <?php else: ?>
                                <div class="form-control bg-white text-dark fw-bold">
                                    <?php echo $data['proveedor']['nombre_completo'] ?? 'Sin asignar'; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

        </div> <div class="text-end">
            <?php if ($modo == 'ver'): ?>
                <a href="?id=<?php echo $id; ?>&tipo=<?php echo $tipo; ?>&modo=editar" class="btn px-5 shadow-sm" style="background-color: #05ad98; color: white;">Editar</a> 
                <?php else: ?>
                    <a href="?id=<?php echo $id; ?>&tipo=<?php echo $tipo; ?>" class="btn btn-secondary px-4 me-2 shadow-sm">Cancelar</a>                
                    <button type="submit" class="btn px-5 shadow-sm" style="background-color: #05ad98; color: white;">Guardar Cambios</button>
            <?php endif; ?>
        </div>
    </form>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</div>
</body>
</html>