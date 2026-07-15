<?php
   
    require_once "../includes/auth.php";
    requireLogin();
    requireRol("tecnico");

    require("../conexion.php");
    require_once '../models/Mod_Preventivas.php';
    require_once '../models/Mod_Correctivas.php';
    require_once '../models/Mod_Equipos.php';

    $total_preventivas = contarPreventivas($conexion);
    $total_correctivas = contarCorrectivas($conexion);
    $total_equipos = contarEquipos($conexion);
    $total_bajas = contarBajas($conexion);
    $equipos_operativos = $total_equipos - $total_correctivas;
    $equipos_mantencion = $total_correctivas + $total_preventivas;
    $equipos_baja = $total_bajas;

    
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Tecnico - NodoActivo</title>
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="manifest" href="/site.webmanifest">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/style.css?v=7">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>

<div class="container-fluid d-flex flex-row vh-100 overflow-hidden">
    <div class="Barra_Lateral d-flex flex-column justify-content-between p-3" style="background-color: #BBBFBF;">
        <div class="Superior d-flex flex-column justify-content-start align-items-start gap-2">
            <div class="Inicio p-2 d-flex flex-row justify-content-start gap-0">
                <p class="fs-4 fw-bold" style="color: #05ad98;">Nodo</p>
                <p class="fs-4 fw-bold text-black">Activo</p>
            </div>

            <hr class="m-0 w-100" style="color: #000000;">

            <div class="Inicio">
                <a href="index_tecnico.php" class="Barra_Izquierda_Index_active d-flex flex-row justify-content-start gap-2 align-items-center text-decoration-none text-black p-2 rounded-1">
                    <span class="material-symbols-outlined fs-5">dashboard</span>
                    <p class="m-0 fs-6">Inicio</p>
                </a>
            </div>

            <div class="Mantenciones">
                <a href="mantenciones_agregar.php" class="d-flex flex-row justify-content-start gap-2 align-items-center text-decoration-none text-black p-2 rounded-1">
                    <span class="material-symbols-outlined fs-5">add_circle</span>
                    <p class="m-0 fs-6">Agregar</p>
                </a>
            </div>

            <div class="Correctivas">
                <a href="correctivas.php" class="d-flex flex-row justify-content-start gap-2 align-items-center text-decoration-none text-black p-2 rounded-1">
                    <span class="material-symbols-outlined fs-5">build_circle</span>
                    <p class="m-0 fs-6">Correctivas</p>
                </a>
            </div>

            <div class="Preventivas">
                <a href="preventivas.php" class="d-flex flex-row justify-content-start gap-2 align-items-center text-decoration-none text-black p-2 rounded-1">
                    <span class="material-symbols-outlined fs-5">event_repeat</span>
                    <p class="m-0 fs-6">Preventivas</p>
                </a>
            </div>
        </div>

        <div class="Inferior">
            <div class="Cerrar_Sesion">
                <a href="/sesion.php?logout=1" class="d-flex flex-row justify-content-start gap-2 align-items-center text-decoration-none text-danger p-2">
                    <span class="material-symbols-outlined">logout</span>
                    <p class="m-0 fs-6">Cerrar Sesion</p>
                </a>
            </div>
        </div>
    </div>

    <div class="tecnico-dashboard flex-grow-1 p-4" style="background-color: #F4F6F8; overflow-y: auto;">
        <div class="titulo-seccion d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center gap-3">
                <div class="titulo-seccion-linea"></div>
                <div>
                    <h2 class="fs-4 fw-bold m-0" style="color: #333333;">Dashboard Tecnico</h2>
                    <p class="titulo-seccion-texto m-0">Resumen visual de mantenciones preventivas y correctivas</p>
                </div>
            </div>
        </div>

        <div class="dashboard-resumen row g-3 mb-4">
            <div class="col-12 col-md-6 col-xl-3">
                <div class="card shadow-sm border-0 rounded-3 h-100" style="border-left: 4px solid #05ad98;">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-start gap-3">
                            <div>
                                <p class="text-muted fw-semibold mb-1" style="font-size: 0.9rem;">Mantenciones</p>
                                <h3 class="fw-bold m-0 fs-4"><?php echo $total_preventivas + $total_correctivas; ?></h3>
                            </div>
                            <span class="material-symbols-outlined p-2 rounded-2" style="background-color: rgba(5, 173, 152, 0.12); color: #05ad98;">handyman</span>
                        </div>
                        <p class="text-secondary m-0 mt-3" style="font-size: 0.85rem;">Total de mantenciones</p>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-xl-3">
                <div class="card shadow-sm border-0 rounded-3 h-100" style="border-left: 4px solid #0d6efd;">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-start gap-3">
                            <div>
                                <p class="text-muted fw-semibold mb-1" style="font-size: 0.9rem;">Preventivas</p>
                                <h3 class="fw-bold m-0 fs-4"><?php echo $total_preventivas; ?></h3>
                            </div>
                            <span class="material-symbols-outlined p-2 rounded-2" style="background-color: rgba(13, 110, 253, 0.12); color: #0d6efd;">event_available</span>
                        </div>
                        <p class="text-secondary m-0 mt-3" style="font-size: 0.85rem;">Revisiones programadas</p>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-xl-3">
                <div class="card shadow-sm border-0 rounded-3 h-100" style="border-left: 4px solid #dc3545;">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-start gap-3">
                            <div>
                                <p class="text-muted fw-semibold mb-1" style="font-size: 0.9rem;">Correctivas</p>
                                <h3 class="fw-bold m-0 fs-4"><?php echo $total_correctivas; ?></h3>
                            </div>
                            <span class="material-symbols-outlined p-2 rounded-2" style="background-color: rgba(220, 53, 69, 0.12); color: #dc3545;">construction</span>
                        </div>
                        <p class="text-secondary m-0 mt-3" style="font-size: 0.85rem;">Casos por reparacion</p>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-xl-3">
                <div class="card shadow-sm border-0 rounded-3 h-100" style="border-left: 4px solid #ffc107;">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-start gap-3">
                            <div>
                                <p class="text-muted fw-semibold mb-1" style="font-size: 0.9rem;">Total Equipos</p>
                                <h3 class="fw-bold m-0 fs-4"><?php echo $total_equipos; ?></h3>
                            </div>
                            <span class="material-symbols-outlined p-2 rounded-2" style="background-color: rgba(255, 193, 7, 0.18); color: #9a6a00;">pending_actions</span>
                        </div>
                        <p class="text-secondary m-0 mt-3" style="font-size: 0.85rem;">Equipos en total</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-12 col-xl-7">
                <div class="card shadow-sm border-0 rounded-3 h-100" style="border-top: 3px solid #05ad98; overflow: hidden;">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center p-3">
                        <div>
                            <h3 class="fs-6 fw-bold m-0">Estado de equipos</h3>
                            <p class="text-secondary m-0" style="font-size: 0.85rem;">Operativos, en mantencion y dados de baja</p>
                        </div>
                        <span class="material-symbols-outlined p-2 rounded-2" style="background-color: rgba(5, 173, 152, 0.12); color: #05ad98;">bar_chart</span>
                    </div>
                    <div class="card-body d-flex justify-content-center align-items-center p-4">
                        <div class="w-100" style="height: 330px;">
                            <canvas id="bar"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-5">
                <div class="card shadow-sm border-0 rounded-3 h-100" style="border-top: 3px solid #0d6efd; overflow: hidden;">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center p-3">
                        <div>
                            <h3 class="fs-6 fw-bold m-0">Tipo de mantenciones</h3>
                            <p class="text-secondary m-0" style="font-size: 0.85rem;">Preventivas y correctivas</p>
                        </div>
                        <span class="material-symbols-outlined p-2 rounded-2" style="background-color: rgba(13, 110, 253, 0.12); color: #0d6efd;">pie_chart</span>
                    </div>
                    <div class="card-body d-flex justify-content-center align-items-center p-4">
                        <div style="width: 320px; height: 320px;">
                            <canvas id="pie"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.dashboardTecnicoData = {
        mantenciones: {
            preventivas: <?php echo (int) $total_preventivas; ?>,
            correctivas: <?php echo (int) $total_correctivas; ?>
        },
        equipos: {
            operativos: <?php echo (int) $equipos_operativos; ?>,
            mantencion: <?php echo (int) $equipos_mantencion; ?>,
            baja: <?php echo (int) $equipos_baja; ?>
        }
    };
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="../assets/dashboard.js?v=3"></script>
</body>
</html>
