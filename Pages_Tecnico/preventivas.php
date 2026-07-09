<?php
    session_start();
    require('../conexion.php');
    require('../models/Mod_Tec_Mantenciones.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        Entregar_preventiva($conexion, $_POST['id_mantencion']);
        header('Location: preventivas.php');
        exit;
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mantenciones Preventivas - NodoActivo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/style.css?v=7">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
<div class="Container d-flex flex-row vh-100 overflow-hidden">

    <div class="Barra_Lateral d-flex flex-column justify-content-between p-3" style="background-color: #BBBFBF;">
        <div class="Superior d-flex flex-column justify-content-start align-items-start gap-2">
            <div class="Inicio p-2 d-flex flex-row justify-content-start gap-0">
                <p class="fs-4 fw-bold" style="color: #05ad98;">Nodo</p>
                <p class="fs-4 fw-bold text-black">Activo</p>
            </div>

            <hr class="m-0 w-100" style="color: #000000;">

            <div class="Inicio">
                <a href="index_tecnico.php" class="d-flex flex-row justify-content-start gap-2 align-items-center text-decoration-none text-black p-2 rounded-1">
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
                <a href="preventivas.php" class="Barra_Izquierda_Index_active d-flex flex-row justify-content-start gap-2 align-items-center text-decoration-none text-black p-2 rounded-1">
                    <span class="material-symbols-outlined fs-5">event_repeat</span>
                    <p class="m-0 fs-6">Preventivas</p>
                </a>
            </div>
        </div>

        <div class="Inferior">
            <div class="Cerrar_Sesion">
                <a href="../sesion.php?logout=1" class="d-flex flex-row justify-content-start gap-2 align-items-center text-decoration-none text-danger p-2">
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
                        <h2 class="fs-4 fw-bold m-0" style="color: #333333;">Mantenciones Preventivas</h2>
                        <p class="titulo-seccion-texto m-0">Registro visual de revisiones programadas</p>
                    </div>
                </div>
            </div>

            <div class="my-3 d-flex flex-column flex-lg-row justify-content-between gap-3">
                <div class="input-group flex-nowrap" style="max-width: 450px">
                    <span class="input-group-text material-symbols-outlined">search</span>
                    <input type="text" class="Buscador form-control" placeholder="Buscar por ID, equipo, descripcion">
                </div>
            </div>

            <div class="card shadow-sm border-0 rounded-3" style="border-top: 3px solid #05ad98; overflow: hidden;">
                <div class="card-body p-0">
                    <div class="table-responsive">
                            <?php
                            $consulta = "SELECT id_mantencion, id_equipo, fecha_prox_mantencion, frecuencia_mantencion, descripcion, fecha_entrega, estado FROM preventiva WHERE estado = 'en mantención'";
                            $resultado = mysqli_query($conexion, $consulta);
                            ?>
                        <table class="table table-hover m-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="p-3 text-secondary" style="font-size: 0.9rem; font-weight: 600;">ID Mantencion</th>
                                    <th class="p-3 text-secondary" style="font-size: 0.9rem; font-weight: 600;">ID Equipo</th>
                                    <th class="p-3 text-secondary" style="font-size: 0.9rem; font-weight: 600;">Fecha proxima</th>
                                    <th class="p-3 text-secondary" style="font-size: 0.9rem; font-weight: 600;">Frecuencia</th>
                                    <th class="p-3 text-secondary" style="font-size: 0.9rem; font-weight: 600;">Descripcion</th>
                                    <th class="p-3 text-secondary" style="font-size: 0.9rem; font-weight: 600;">Fecha de entrega</th>
                                    <th class="p-3 text-secondary" style="font-size: 0.9rem; font-weight: 600;">Estado</th>
                                    <th class="p-3 text-secondary text-center" style="font-size: 0.9rem; font-weight: 600;">Entregas</th>
                                </tr>
                            </thead>
                            <tbody id="tablaPreventivas">
                            <?php
                            while($row = mysqli_fetch_assoc($resultado)){
                            ?>
                            <tr>
                              <th scope="row" class="p-3 text-muted"><?php echo $row["id_mantencion"]; ?></th>
                              <td class="p-3 fw-semibold" style="color: #05ad98;"><?php echo $row["id_equipo"]; ?></td>
                              <td class="p-3 fw-medium text-dark"><?php echo $row["fecha_prox_mantencion"]; ?></td>
                              <td class="p-3 fw-medium text-dark"><?php echo $row["frecuencia_mantencion"]; ?></td>
                              <td class="p-3 text-secondary"><?php echo $row["descripcion"]; ?></td>
                              <td class="p-3 fw-medium text-dark"><?php echo $row["fecha_entrega"]; ?></td>
                              <td class="p-3 text-secondary"><?php echo $row["estado"]; ?></td>
                              <td class="p-3 text-center">
                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalEntregarPreventiva" data-id="<?php echo $row["id_mantencion"]; ?>">
                                    Entregar
                                </button>
                              </td>
                            </tr>
                            <?php
                            }
                            ?>  
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEntregarPreventiva" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h5 class="modal-title fs-6 fw-bold">Entregar equipo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <p class="m-0">Estas seguro que quieres entregar el equipo?</p>
                    <input type="hidden" name="id_mantencion" id="idPreventivaEntregar">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn button btn-sm">Entregar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
const modalEntregarPreventiva = document.getElementById('modalEntregarPreventiva');
modalEntregarPreventiva.addEventListener('show.bs.modal', (evento) => {
    document.getElementById('idPreventivaEntregar').value = evento.relatedTarget.dataset.id;
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
