<?php
require_once '../conexion.php'; 
require_once '../models/Mod_Equipos.php';

$id = $_GET['id'];
$tipo = $_GET['tipo'];

$data = obtenerDatosCompletos($conexion, $id, $tipo);
$equipo = $data['equipo'];
$funcionario = $data['funcionario'];
$proveedor = $data['proveedor']; 
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ficha Tecnica - NodoActivo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/style.css">
    <script src="../assets/script.js" defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body class="bg-light p-3 p-md-5">

<div class="container" style="max-width: 700px;">
    
    <div class="card shadow-sm border-0 rounded-3 mb-4" style="border-top: 3px solid #05ad98;">
        <div class="card-header bg-white p-4">
            <h3 class="fs-5 fw-bold m-0 text-dark">Información del Equipo</h3>
        </div>
        <div class="card-body p-4">
            <ul class="list-group list-group-flush">
                <li class='list-group-item d-flex justify-content-between px-0 py-3'>
                    <span class='text-muted fw-semibold'>Tipo de Equipo</span>
                    <span class='text-primary fw-bold'><?php echo $tipo; ?></span>
                </li>
                <?php foreach ($equipo as $col => $val): ?>
                    <li class='list-group-item d-flex justify-content-between px-0 py-3'>
                        <span class='text-muted fw-semibold text-capitalize'><?php echo str_replace('_', ' ', $col); ?></span>
                        <span class='text-dark fw-bold'><?php echo $val; ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-3 mb-4" style="border-top: 3px solid #6c757d;">
        <div class="card-header bg-white p-4">
            <h3 class="fs-5 fw-bold m-0 text-dark">Funcionario Responsable</h3>
        </div>
        <div class="card-body p-4">
            <ul class="list-group list-group-flush">
                <?php foreach ($funcionario as $col => $val): ?>
                    <li class='list-group-item d-flex justify-content-between px-0 py-3'>
                        <span class='text-muted fw-semibold'><?php echo str_replace('_',' ',$col); ?></span>
                        <span class='text-dark fw-bold'><?php echo $val; ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>   
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-3 mb-4" style="border-top: 3px solid #fd7e14;">
        <div class="card-header bg-white p-4">
            <h3 class="fs-5 fw-bold m-0 text-dark">Información del Proveedor</h3>
        </div>
        <div class="card-body p-4">
            <ul class="list-group list-group-flush">
                <?php foreach ($proveedor as $col => $val): ?>
                    <?php if ($col !== 'id_proveedor'):  ?>
                        <li class='list-group-item d-flex justify-content-between px-0 py-3'>
                            <span class='text-muted fw-semibold text-capitalize'><?php echo str_replace('_', ' ', $col); ?></span>
                            <span class='text-dark fw-bold'><?php echo $val; ?></span>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>

<script>
    window.onload = function() {
        new QRCode(document.getElementById("qrcode"), {
            text: window.location.href,
            width: 150,
            height: 150,
            colorDark : "#000000",
            colorLight : "#ffffff"
        });
    };
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>