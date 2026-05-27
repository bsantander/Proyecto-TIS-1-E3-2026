<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mantenciones - NodoActivo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
<div class="Container d-flex flex-row vh-100 overflow-hidden">

    <div class="Barra_Lateral d-flex flex-column  justify-content-between p-3" style="background-color: #BBBFBF;">
        <div class="Superior d-flex flex-column justify-content-start align-items-start gap-2">

            <div class="Inicio p-2 d-flex flex-row justify-content-start gap-0 ">
                <p class="fs-4 fw-bold" style="color: #05ad98;">Nodo</p>
                <p class="fs-4 fw-bold text-black">Activo</p>
            </div>

            <hr class="m-0 w-100" style="color: #000000;">

            <div class="Inicio">
                <a href="index.php" class=" d-flex flex-row justify-content-start gap-2 align-items-center text-decoration-none text-black p-2 rounded-1">
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
            <div class="Mantenciones">
                <a href="mantenciones.php" class="Barra_Izquierda_Index_active d-flex flex-row justify-content-start gap-2 align-items-center text-decoration-none text-black p-2 rounded-1">
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
            <div class="Configuracion" >
                <a href="configuracion.php" class=" d-flex flex-row justify-content-start gap-2 align-items-center text-decoration-none text-black p-2">
                    <span class="material-symbols-outlined">build</span>                   
                    <p class="m-0 fs-6">Configuracion</p>
                </a>
            </div>

            <div class="Cerrar_Sesion">
                <a href="secion.php" class=" d-flex flex-row justify-content-start gap-2 align-items-center text-decoration-none text-danger p-2">
                    <span class="material-symbols-outlined">logout</span>
                    <p class="m-0 fs-6">Cerrar Sesion</p>
                </a>
            </div>        
        </div>
    </div>

    <div class="flex-grow-1 p-4" style="background-color: #F4F6F8; overflow-y: auto;">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fs-3 fw-bold m-0" style="color: #333333;">Módulo de Mantenciones</h2>
                <p class="text-secondary mb-0">Control de intervenciones y reparaciones.</p>
            </div>
            
            <button class="btn button d-flex align-items-center gap-2 px-3 py-2 fw-semibold" style="border-radius: 10px;">
                <span class="material-symbols-outlined fs-5">add_circle</span>
                Programar Mantención
            </button>
        </div>

        <div class="row mb-4 g-3">
            <div class="col-12 col-md-4">
                <div class="card shadow-sm border-0 rounded-3" style="border-left: 4px solid #05ad98;">
                    <div class="card-body p-3">
                        <p class="text-muted fw-semibold mb-1" style="font-size: 0.9rem;">Costo Acumulado</p>
                        <h3 class="fw-bold m-0 fs-4">$0</h3>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card shadow-sm border-0 rounded-3" style="border-left: 4px solid #ffc107;">
                    <div class="card-body p-3">
                        <p class="text-muted fw-semibold mb-1" style="font-size: 0.9rem;">En Proceso</p>
                        <h3 class="fw-bold m-0 fs-4">0</h3>
                    </div>
                </div>
            </div>
        </div>

        <ul class="nav nav-tabs mb-4 border-bottom" id="mantencionesTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active fw-semibold" id="preventiva-tab" data-bs-toggle="tab" data-bs-target="#preventiva" type="button" role="tab" style="color: #05ad98; border-bottom: 2px solid #05ad98; background-color: transparent;">Mantención Preventiva</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-semibold text-secondary" id="correctiva-tab" data-bs-toggle="tab" data-bs-target="#correctiva" type="button" role="tab" style="border: none; background-color: transparent;">Mantención Correctiva</button>
            </li>
        </ul>

        <div class="tab-content" id="mantencionesTabsContent">
            <div class="tab-pane fade show active" id="preventiva" role="tabpanel">
                <h5 class="fw-bold mb-3" style="color: #05ad98;">Revisiones Programadas</h5>
                
                <div class="card shadow-sm border-0 rounded-3" style="overflow: hidden;">
                    <div class="card-body p-0">
                        <table class="table table-hover m-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="p-3 text-secondary border-bottom" style="font-size: 0.85rem; font-weight: 600;">Activo</th>
                                    <th class="p-3 text-secondary border-bottom" style="font-size: 0.85rem; font-weight: 600;">Frecuencia</th>
                                    <th class="p-3 text-secondary border-bottom" style="font-size: 0.85rem; font-weight: 600;">Próxima Fecha</th>
                                    <th class="p-3 text-secondary border-bottom" style="font-size: 0.85rem; font-weight: 600;">Responsable</th>
                                    <th class="p-3 text-secondary border-bottom" style="font-size: 0.85rem; font-weight: 600;">Estado</th>
                                    <th class="p-3 text-secondary border-bottom" style="font-size: 0.85rem; font-weight: 600;">Costo Estimado</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="tab-pane fade" id="correctiva" role="tabpanel">
                <div class="p-5 text-center text-muted">
                    <p class="m-0">Tabla mantenciones correctivas</p>
                </div>
            </div>
        </div>
    </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>