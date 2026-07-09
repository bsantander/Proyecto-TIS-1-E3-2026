<?php
    require ("../conexion.php");
    session_start();
    require_once '../models/Mod_Equipos.php';
    require_once '../models/Mod_Funcionarios.php';
    require_once '../models/Mod_Correctivas.php';
    require_once '../models/Mod_Preventivas.php';
    $total_equipos = contarEquipos($conexion);
    $total_funcionarios = contarFuncionarios($conexion);
    $total_preventivas = contarPreventivas($conexion);
    $total_correctivas = contarCorrectivas($conexion);
    $equipos_operativos = $total_equipos - $total_correctivas;
    $equipos_mantencion = $total_correctivas + $total_preventivas;
    $equipos_baja = contarBajas($conexion);

    // Query para costos por mes

    $meses_a_mostrar = isset($_GET['meses']) ? (int)$_GET['meses'] : 6;

    if ($meses_a_mostrar <= 0) { 
        $meses_a_mostrar = 6; 
        }

    $sql = "SELECT DATE_FORMAT(fecha_evento, '%Y-%m') AS anio_mes, DATE_FORMAT(fecha_evento, '%b') as nombre_mes, SUM(costo_asociado) AS costo_total
            FROM evento
            WHERE fecha_evento >= DATE_SUB(NOW(), INTERVAL $meses_a_mostrar MONTH)
            GROUP BY anio_mes
            ORDER BY anio_mes ASC";

    $resultado = mysqli_query($conexion, $sql);

    $labels = [];
    $value = [];

    if ($resultado) {
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $labels[] = $fila['nombre_mes'];
            $value[] = (int)$fila['costo_total'];
        }
    }

    $costos_mensuales = [
        'labels' => $labels,
        'data' => $value
    ];

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NodoActivo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/style.css">
    <script src="../assets/script.js" defer></script>
    <script src="../assets/dashboard.js" defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

</head>
<body>

<div class="Container d-flex flex-row vh-100 overflow-hidden">

    <div class="Barra_Lateral d-flex flex-column justify-content-between p-3" style="background-color: #BBBFBF;">
        <div class="Superior d-flex flex-column justify-content-start align-items-start gap-2">

            <div class="Inicio p-2 d-flex flex-row justify-content-start gap-0 ">
                <p class="fs-4 fw-bold" style="color: #05ad98;">Nodo</p>
                <p class="fs-4 fw-bold text-black">Activo</p>
            </div>

            <hr class="m-0 w-100" style="color: #000000;">

            <div class="Inicio">
                <a href="index_admin.php" class="Barra_Izquierda_Index_active d-flex flex-row justify-content-start gap-2 align-items-center text-decoration-none text-black p-2 rounded-1">
                    <span class="material-symbols-outlined fs-5">house</span>
                    <p class="m-0 fs-6">Inicio</p>
                </a>
            </div>

            <div class="Equipos">
                <a href="equipos.php" class=" d-flex flex-row justify-content-start gap-2 align-items-center text-decoration-none text-black p-2 rounded-1">
                    <span class="material-symbols-outlined fs-5">computer</span>
                    <p class="m-0 fs-6">Equipos</p>
                </a>
            </div>
              <div class="Funcionarios">
                <a href="funcionarios.php" class=" d-flex flex-row justify-content-start gap-2 align-items-center text-decoration-none text-black p-2 rounded-1">
                    <span class="material-symbols-outlined fs-5">person</span>
                    <p class="m-0 fs-6">Funcionarios</p>
                </a>
            </div>
            <div class="Departamentos">
                <a href="departamentos.php" class=" d-flex flex-row justify-content-start gap-2 align-items-center text-decoration-none text-black p-2 rounded-1">
                    <span class="material-symbols-outlined fs-5">apartment</span>
                    <p class="m-0 fs-6">Departamentos</p>
                </a>
            </div>
                <div class="Proovedores">
                    <a href="proveedores.php" class=" d-flex flex-row justify-content-start gap-2 align-items-center text-decoration-none text-black p-2 rounded-1">
                        <span class="material-symbols-outlined">person_4</span>                    
                        <p class="m-0 fs-6">Proveedores</p>
                    </a>
                </div>  
            <div class="Mantenciones">
                <a href="mantenciones.php" class=" d-flex flex-row justify-content-start gap-2 align-items-center text-decoration-none text-black p-2 rounded-1">
                    <span class="material-symbols-outlined fs-5">handyman</span>
                    <p class="m-0 fs-6">Mantenciones</p>
                </a>
            </div>
            <div class="Historial">
                <a href="historial.php" class=" d-flex flex-row justify-content-start gap-2 align-items-center text-decoration-none text-black p-2 rounded-1">
                    <span class="material-symbols-outlined fs-5">history</span>
                    <p class="m-0 fs-6">Historial</p>
                </a>
            </div>
        </div>
        
        <div class="Inferior">
            <div class="Cerrar_Sesion">
                <a href="../sesion.php?logout=1" class=" d-flex flex-row justify-content-start gap-2 align-items-center text-decoration-none text-danger p-2">
                    <span class="material-symbols-outlined">logout</span>
                    <p class="m-0 fs-6">Cerrar Sesion</p>
                </a>
            </div>        
        </div>
    </div>
    
    <div class="flex-grow-1 bg-light">
        <div class="container-fluid p-4">

            <div class="p-4 mb-4 rounded-4 text-white" 
            style="background: linear-gradient(135deg, #05ad98, #047a6c);">
            <h3 class="fw-bold mb-1">Resumen General</h3>
            <h6 class="opacity-75">Panel de control del inventario</h6>
        </div>

        <div class="row g-3 mb-4">
        
            <div class="col-xl-3 col-md-6">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        <h6 class="text-muted">Total Equipos</h6>
                        <h2 class="fw-bold"><?php echo $total_equipos ?></h2>
                    </div>
                </div>
            </div>
        
            <div class="col-xl-3 col-md-6">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        <h6 class="text-muted">Funcionarios</h6>
                        <h2 class="fw-bold"><?php echo $total_funcionarios ?> </h2>
                    </div>
                </div>
            </div>
        
            <div class="col-xl-3 col-md-6">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        <h6 class="text-muted">Mant. Preventivas</h6>
                        <h2 class="fw-bold"><?php echo $total_preventivas ?></h2>
                    </div>
                </div>
            </div>
        
            <div class="col-xl-3 col-md-6">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        <h6 class="text-muted">Mant. Correctivas</h6>
                        <h2 class="fw-bold"><?php echo $total_correctivas ?></h2>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 rounded-4 h-100">
                    <div class="card-header text-white d-flex align-items-center justify-content-between"
                        style="background: linear-gradient(135deg, #05ad98, #047a6c); border-radius: 16px 16px 0 0;">
                        <p class="m-0 fw-semibold">Estadísticas Mensuales</p>
                        <span class="material-symbols-outlined">show_chart</span>
                    </div>
     
                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                        <div class="w-100" style="max-width: 750px; height: 360px;">
                            <canvas id="Izquierda"></canvas>
                        </div>
                        <div class="d-flex justify-content-center align-items-center mt-3" style="margin: 20px;">
                            <label for="selectorMeses">Mostrar últimos: </label>
                            <select id="selectorMeses" class="form-select form-select-sm shadow-sm" 
                            style="width: auto; border-color: #05ad98;" onchange="cambiarIntervalo(this.value)">
                                <option value="3" <?php echo $meses_a_mostrar == 3 ? 'selected' : ''; ?>>3 meses</option>
                                <option value="6" <?php echo $meses_a_mostrar == 6 ? 'selected' : ''; ?>>6 meses</option>
                                <option value="12" <?php echo $meses_a_mostrar == 12 ? 'selected' : ''; ?>>12 meses</option>
                                <option value="24" <?php echo $meses_a_mostrar == 24 ? 'selected' : ''; ?>>24 meses</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 rounded-4 h-100">
                    <div class="card-header text-white d-flex align-items-center justify-content-between"
                    style="background: linear-gradient(135deg, #05ad98, #047a6c); border-radius: 16px 16px 0 0;">
                    <p class="m-0 fw-semibold">Equipos por Estado</p>
                    <span class="material-symbols-outlined">pie_chart</span>
                </div>
                
                <div class="card-body d-flex justify-content-center align-items-center m-0 p-0">
                    <div style="width: 320px; height: 320px;">
                        <canvas id="Derecha"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    

<script>
        function cambiarIntervalo(meses) {
            window.location.search = '?meses=' + meses;
        }
        window.dashboardCostosData = <?php echo json_encode($datosCostos); ?>;
    </script>


<script>
    window.dashboardAdminData = {
        equipos: {
            operativos: <?php echo (int) $equipos_operativos; ?>,
            mantencion: <?php echo (int) $equipos_mantencion; ?>,
            baja: <?php echo (int) $equipos_baja; ?>
        }
    }
</script>
<script>
    window.dashboardCostosData = <?php echo json_encode($costos_mensuales); ?>;
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>