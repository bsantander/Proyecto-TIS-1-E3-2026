<?php
    require_once "../includes/auth.php";
    requireLogin();
    requireRol("administrador");

    require_once("../conexion.php");
    require_once("../models/Mod_Equipos.php");

    $equipos_por_pagina = 15;
    $pagina_actual = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;

    if ($pagina_actual < 1) {
        $pagina_actual = 1;
    }

    $consulta_total = "SELECT COUNT(*) AS total FROM vista_equipos";
    $resultado_total = mysqli_query($conexion, $consulta_total);


    $total_equipos = (int) mysqli_fetch_assoc($resultado_total)['total'];
    $total_paginas = max(1, (int) ceil($total_equipos / $equipos_por_pagina));

    if ($pagina_actual > $total_paginas) {
        $pagina_actual = $total_paginas;
    }

    $offset = ($pagina_actual - 1) * $equipos_por_pagina;
    $desde_equipo = $total_equipos > 0 ? $offset + 1 : 0;
    $hasta_equipo = min($offset + $equipos_por_pagina, $total_equipos);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipos - NodoActivo</title>
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="manifest" href="/site.webmanifest">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/style.css?v=4">
    <script src="../assets/script.js" defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

</head>
<body>
<div class="container-fluid d-flex flex-row vh-100 overflow-hidden">

    <div class="Barra_Lateral d-flex flex-column  justify-content-between p-3" style="background-color: #BBBFBF;">
        <div class="Superior d-flex flex-column justify-content-start align-items-start gap-2">

            <div class="Inicio p-2 d-flex flex-row justify-content-start gap-0 ">
                <p class="fs-4 fw-bold" style="color: #05ad98;">Nodo</p>
                <p class="fs-4 fw-bold text-black">Activo</p>
            </div>

            <hr class="m-0 w-100" style="color: #000000;">

            <div class="Inicio">
                <a href="index_admin.php" class=" d-flex flex-row justify-content-start gap-2 align-items-center text-decoration-none text-black p-2 rounded-1">
                    <span class="material-symbols-outlined fs-5">house</span>
                    <p class="m-0 fs-6">Inicio</p>
                </a>
            </div>

            <div class="Equipos">
                <a href="equipos.php" class="Barra_Izquierda_Index_active d-flex flex-row justify-content-start gap-2 align-items-center text-decoration-none text-black p-2 rounded-1">
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
                <a href="../sesion.php?logout=1"
                class="d-flex flex-row justify-content-start gap-2 align-items-center text-decoration-none text-danger p-2">
                    <span class="material-symbols-outlined">logout</span>
                    <p class="m-0 fs-6">Cerrar Sesion</p>
                </a>
            </div>
        </div>
    </div>
    
    
    <div class="flex-grow-1 p-4" style="background-color: #F4F6F8; overflow-y: auto;">
        
        <div id="vista-tabla">
            <div class="titulo-seccion d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="titulo-seccion-linea"></div>
                    <div>
                        <h2 class="fs-4 fw-bold m-0" style="color: #333333;">Inventario de Equipos</h2>
                        <p class="titulo-seccion-texto m-0">Registro y gestion de activos tecnologicos</p>
                    </div>
                </div>
                    <button class="btn button d-flex align-items-center gap-2 px-3 py-2 fw-semibold" style="border-radius: 10px;">
                        <span class="material-symbols-outlined fs-5 text-decoration-none text-white">add_to_queue</span>
                        <a href="equipos_agregar.php" class="m-0 text-decoration-none text-white">Agregar equipo</a>
                </button>
            </div>

            <div class=" my-3 d-flex flex-row justify-content-between ">
                <div class="input-group flex-nowrap" style="max-width: 450px">
                    <span class=" input-group-text material-symbols-outlined">search</span>
                    <input type="text" id="inputBusquedaEquipo" onkeyup="filtrarEquipos()" class="Buscador form-control" placeholder="Buscar por ID, Modelo, Tipo, etc" >
                </div>


                <select id="filtroTipo" onchange="filtrarEquipos()" class="Filtro form-select" style="max-width: 200px;">
                    <option value="">Todos los tipos</option>
                    <option value="Computador">Computador</option>
                    <option value="Notebook">Notebook</option>
                    <option value="Impresora">Impresora</option>
                    <option value="Proyector">Proyector</option>
                    <option value="Servidor">Servidor</option>
                    <option value="Otro Dispositivo">Otro</option>
                </select>
            </div>


            <div class="card shadow-sm border-0 rounded-3" style="border-top: 3px solid #05ad98; overflow: hidden;">
                <div class="card-body p-0">
                    <?php
                    $consulta = "SELECT id_equipo, tipo, marca, modelo FROM vista_equipos ORDER BY id_equipo, tipo LIMIT $equipos_por_pagina OFFSET $offset";
                    $resultado = mysqli_query($conexion, $consulta);
                    ?>

                    <table class="table table-hover m-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="p-3 text-secondary" style="font-size: 0.9rem; font-weight: 600;">ID Equipo</th>
                                <th class="p-3 text-secondary" style="font-size: 0.9rem; font-weight: 600;">Tipo</th>
                                <th class="p-3 text-secondary" style="font-size: 0.9rem; font-weight: 600;">Marca</th>
                                <th class="p-3 text-secondary" style="font-size: 0.9rem; font-weight: 600;">Modelo</th>
                                <th class="p-3 text-secondary text-center" style="font-size: 0.9rem; font-weight: 600;">Gestionar Equipo</th>
                                <th class="p-3 text-secondary text-center" style="font-size: 0.9rem; font-weight: 600;">Codigo QR</th>
                            </tr>
                        </thead>
                        <tbody id="tablaEquiposBody" >
                            <?php
                            while($row = mysqli_fetch_assoc($resultado)){
                                $id_equipo = $row["id_equipo"];
                                $tipo      = $row["tipo"];
                                $marca     = $row["marca"];
                                $modelo    = $row["modelo"];
                            ?>
                            <tr>
                              <th scope="row" class="p-3 text-muted"><?php echo $id_equipo; ?></th>
                              <td class="p-3 fw-semibold" style="color: #05ad98;"><?php echo $tipo; ?></td>
                              <td class="p-3 fw-medium text-dark"><?php echo $marca; ?></td>
                              <td class="p-3 text-secondary"><?php echo $modelo; ?></td>

                              <td class="p-3 text-center">
                                <a href="equipos_detalle.php?id=<?php echo $id_equipo; ?>&tipo=<?php echo $tipo; ?>" class="Buttons_equipo btn btn-sm border">
                                    <span class="material-symbols-outlined align-middle">visibility</span>
                                </a>
                              </td>
                              <td class="p-3 text-center">
                                <a href="equipos_Qr.php?id=<?php echo $id_equipo; ?>&tipo=<?php echo $tipo; ?>" class="Buttons_equipo btn btn-sm border">
                                    <span class="material-symbols-outlined align-middle">qr_code</span>
                                </a>
                              </td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mt-3">
                <p class="text-secondary m-0">
                    Mostrando <?php echo $desde_equipo; ?> a <?php echo $hasta_equipo; ?> de <?php echo $total_equipos; ?> equipos
                </p>

                <?php if ($total_paginas > 1): ?>
                    <nav aria-label="Paginacion de equipos">
                        <ul class="pagination equipos-paginacion mb-0">
                            <li class="page-item <?php echo $pagina_actual <= 1 ? 'disabled' : ''; ?>">
                                <a class="page-link" href="?pagina=<?php echo $pagina_actual - 1; ?>">Anterior</a>
                            </li>

                            <?php for ($pagina = 1; $pagina <= $total_paginas; $pagina++): ?>
                                <li class="page-item <?php echo $pagina === $pagina_actual ? 'active' : ''; ?>">
                                    <a class="page-link" href="?pagina=<?php echo $pagina; ?>"><?php echo $pagina; ?></a>
                                </li>
                            <?php endfor; ?>

                            <li class="page-item <?php echo $pagina_actual >= $total_paginas ? 'disabled' : ''; ?>">
                                <a class="page-link" href="?pagina=<?php echo $pagina_actual + 1; ?>">Siguiente</a>
                            </li>
                        </ul>
                    </nav>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
      

</body>
</html>
