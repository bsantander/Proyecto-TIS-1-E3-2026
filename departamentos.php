<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Departamentos - NodoActivo</title>
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

    <div class="Barra_Lateral d-flex flex-column justify-content-between p-3" style="background-color: #BBBFBF;">
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
                <a href="departamentos.php" class="Barra_Izquierda_Index_active d-flex flex-row justify-content-start gap-2 align-items-center text-decoration-none text-black p-2 rounded-1">
                    <span class="material-symbols-outlined fs-5">apartment</span>
                    <p class="m-0 fs-6">Departamentos</p>
                </a>
            </div>
            <div class="Mantenciones">
                <a href="mantenciones.php" class=" d-flex flex-row justify-content-start gap-2 align-items-center text-decoration-none text-black p-2 rounded-1">
                    <span class="material-symbols-outlined fs-5">handyman</span>
                    <p class="m-0 fs-6">Mantenciones</p>
                </a>
            </div>
            <div class="Historial">
                <a href="#" class=" d-flex flex-row justify-content-start gap-2 align-items-center text-decoration-none text-black p-2 rounded-1">
                    <span class="material-symbols-outlined fs-5">history</span>
                    <p class="m-0 fs-6">Historial</p>
                </a>
            </div>
        </div>
        
        <div class="Inferior">
            <div class="Configuracion" >
                <a href="#" class=" d-flex flex-row justify-content-start gap-2 align-items-center text-decoration-none text-black p-2">
                    <span class="material-symbols-outlined">build</span>                   
                    <p class="m-0 fs-6">Configuracion</p>
                </a>
            </div>

            <div class="Cerrar_Sesion">
                <a href="logout.php" class=" d-flex flex-row justify-content-start gap-2 align-items-center text-decoration-none text-danger p-2">
                    <span class="material-symbols-outlined">logout</span>
                    <p class="m-0 fs-6">Cerrar Sesion</p>
                </a>
            </div>        
        </div>
    </div>

    <div class="flex-grow-1 p-4" style="background-color: #F4F6F8; overflow-y: auto;">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fs-4 fw-bold m-0" style="color: #333333;">Departamentos</h2>
            </div>
            
            <button class="btn button d-flex align-items-center gap-2 px-3 py-2 fw-semibold" style="border-radius: 10px;">
                <span class="material-symbols-outlined fs-5">domain_add</span>
                <p class="m-0">Agregar departamento</p>
            </button>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4 gap-3">
            <div class="input-group" style="max-width: 450px;">
                <span class="input-group-text bg-white border-end-0 rounded-start-3" style="border-color: #dbe4e2;">
                    <span class="material-symbols-outlined text-secondary fs-5">search</span>
                </span>
                <input type="text" class="Buscador form-control border-start-0 rounded-end-3 py-2" placeholder="Buscar departamento o encargado...">
            </div>

            <button class=" Filtros btn btn-outline-secondary d-flex align-items-center gap-2 px-3 py-2 fw-medium">
                <span class="material-symbols-outlined fs-5">filter_list</span>
                Filtros
            </button>
        </div>
        
        <div class="card shadow-sm border-0 rounded-3" style="border-top: 3px solid #05ad98; overflow: hidden;">
            <div class="card-body p-0">
                <table class="table table-hover m-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="p-3 text-secondary" style="font-size: 0.9rem; font-weight: 600; width: 10%;">ID</th>
                            <th class="p-3 text-secondary" style="font-size: 0.9rem; font-weight: 600; width: 40%;">Nombre del Departamento</th>
                            <th class="p-3 text-secondary" style="font-size: 0.9rem; font-weight: 600; width: 30%;">ID Encargado (Jefe)</th>
                            <th class="p-3 text-secondary text-center" style="font-size: 0.9rem; font-weight: 600; width: 20%;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="p-3 text-muted fw-semibold">2</td>
                            <td class="p-3 text-dark fw-medium">Recursos Humanos</td>
                            <td class="p-3">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="material-symbols-outlined text-secondary fs-5">person</span>
                                    <span class="text-muted">Funcionario #1</span>
                                </div>
                            </td>
                            <td class="p-3 text-center">
                                <button class="btn btn-sm btn-light border text-secondary me-1" title="Editar">
                                    <span class="material-symbols-outlined" style="font-size: 1.1rem;">edit</span>
                                </button>
                                <button class="btn btn-sm btn-light border text-danger" title="Eliminar">
                                    <span class="material-symbols-outlined" style="font-size: 1.1rem;">delete</span>
                                </button>
                            </td>
                        </tr>
                        </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>