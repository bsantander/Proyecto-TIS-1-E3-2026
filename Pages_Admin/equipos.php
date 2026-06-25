<?php
require_once("../conexion.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipos - NodoActivo</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/style.css">
    <script src="../assets/script.js" defer></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100..900&display=swap" rel="stylesheet">
</head>

<body>

<div class="Container d-flex flex-row vh-100 overflow-hidden">

    <!-- SIDEBAR -->
    <div class="Barra_Lateral d-flex flex-column justify-content-between p-3" style="background-color: #BBBFBF;">
        <div class="Superior d-flex flex-column gap-2">

            <div class="Inicio p-2 d-flex flex-row">
                <p class="fs-4 fw-bold" style="color:#05ad98;">Nodo</p>
                <p class="fs-4 fw-bold text-black">Activo</p>
            </div>

            <hr class="m-0 w-100">

            <a href="index_admin.php" class="d-flex gap-2 align-items-center text-decoration-none text-black p-2">
                <span class="material-symbols-outlined">house</span> Inicio
            </a>

            <a href="equipos.php" class="d-flex gap-2 align-items-center text-decoration-none text-black p-2 Barra_Izquierda_Index_active">
                <span class="material-symbols-outlined">computer</span> Equipos
            </a>

            <a href="funcionarios.php" class="d-flex gap-2 align-items-center text-decoration-none text-black p-2">
                <span class="material-symbols-outlined">person</span> Funcionarios
            </a>

            <a href="departamentos.php" class="d-flex gap-2 align-items-center text-decoration-none text-black p-2">
                <span class="material-symbols-outlined">apartment</span> Departamentos
            </a>

            <a href="proveedores.php" class="d-flex gap-2 align-items-center text-decoration-none text-black p-2">
                <span class="material-symbols-outlined">person_4</span> Proveedores
            </a>

            <a href="mantenciones.php" class="d-flex gap-2 align-items-center text-decoration-none text-black p-2">
                <span class="material-symbols-outlined">handyman</span> Mantenciones
            </a>

            <a href="historial.php" class="d-flex gap-2 align-items-center text-decoration-none text-black p-2">
                <span class="material-symbols-outlined">history</span> Historial
            </a>
        </div>

        <div class="Inferior">

            <a href="configuracion.php" class="d-flex gap-2 align-items-center text-decoration-none text-black p-2">
                <span class="material-symbols-outlined">build</span> Configuración
            </a>

            <a href="../secion.php?logout=1" class="d-flex gap-2 align-items-center text-decoration-none text-danger p-2">
                <span class="material-symbols-outlined">logout</span> Cerrar Sesión
            </a>

        </div>
    </div>

    <!-- CONTENIDO -->
    <div class="flex-grow-1 p-4" style="background:#F4F6F8; overflow-y:auto;">

        <h2 class="fs-4 fw-bold mb-3">Inventario de Equipos</h2>

        <!-- BOTÓN AGREGAR -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="input-group" style="max-width:450px;">
                <span class="input-group-text material-symbols-outlined">search</span>
                <input type="text" id="inputBusquedaEquipo" onkeyup="filtrarEquipos()" class="form-control" placeholder="Buscar equipo">
            </div>

            <a href="equipos_agregar.php" class="btn btn-success d-flex align-items-center gap-2">
                <span class="material-symbols-outlined">add</span> Agregar equipo
            </a>
        </div>

        <!-- TABLA -->
        <div class="card shadow-sm border-0" style="border-top:3px solid #05ad98;">

            <div class="card-body p-0">

                <?php
                $consulta = "SELECT id_equipo, tipo, marca, modelo FROM vista_equipos";
                $resultado = mysqli_query($conexion, $consulta);

                if (!$resultado) {
                    die("Error consulta: " . mysqli_error($conexion));
                }
                ?>

                <table class="table table-hover m-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Tipo</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Fallas</th>
                            <th>Criticidad</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php while ($row = mysqli_fetch_assoc($resultado)) {

                        $id = $row['id_equipo'];
                        $tipo = $row['tipo'];
                        $marca = $row['marca'];
                        $modelo = $row['modelo'];

                        $sql_fallas = "
                            SELECT COUNT(co.id_mantencion) AS fallas
                            FROM realiza r
                            LEFT JOIN correctiva co ON r.id_mantencion = co.id_mantencion
                            WHERE r.id_equipo = $id
                        ";

                        $res = mysqli_query($conexion, $sql_fallas);
                        $fallas = 0;

                        if ($res && $f = mysqli_fetch_assoc($res)) {
                            $fallas = $f['fallas'];
                        }

                        $critico = ($fallas >= 3)
                            ? "<span class='badge bg-danger'>Crítico</span>"
                            : "<span class='badge bg-success'>Normal</span>";
                    ?>

                        <tr>
                            <td><?php echo $id; ?></td>
                            <td style="color:#05ad98; font-weight:600;"><?php echo $tipo; ?></td>
                            <td><?php echo $marca; ?></td>
                            <td><?php echo $modelo; ?></td>

                            <td class="text-center"><?php echo $fallas; ?></td>
                            <td class="text-center"><?php echo $critico; ?></td>

                            <td class="text-center">
                                <a href="equipos_detalle.php?id=<?php echo $id; ?>&tipo=<?php echo $tipo; ?>" class="btn btn-sm border">
                                    <span class="material-symbols-outlined">visibility</span>
                                </a>

                                <a href="equipos_QR.php?id=<?php echo $id; ?>&tipo=<?php echo $tipo; ?>" class="btn btn-sm border">
                                    <span class="material-symbols-outlined">qr_code</span>
                                </a>
                            </td>
                        </tr>

                    <?php } ?>

                    </tbody>
                </table>

            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>