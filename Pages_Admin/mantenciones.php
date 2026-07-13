<?php
    require_once "../includes/auth.php";
    requireLogin();
    requireRol("administrador");
    require_once("../conexion.php");
    require_once("../models/Mod_Mantenciones.php");

    // accion de botones
    if(isset($_POST['guardar_preventiva'])){
        $datos = [
            'costo'                    => $_POST['costo'],
            'id_funcionario'           => $_POST['id_funcionario'],
            'id_equipo'                => $_POST['id_equipo'],
            'fecha_prox_mantencion'    => $_POST['fecha_prox_mantencion'],
            'frecuencia_mantencion'    => $_POST['frecuencia_mantencion'],
            'descripcion_preventiva'   => trim($_POST['descripcion_preventiva']),
            'fecha_entrega_preventiva' => $_POST['fecha_entrega_preventiva'],
        ];

        Guardar_preventiva($conexion, $datos);

        $_SESSION['mensaje'] = "Mantención preventiva programada correctamente";
        $_SESSION['tipo'] = "success";
        header("Location: mantenciones.php");
        exit;
    }

    if(isset($_POST['guardar_correctiva'])){
        $datos = [
            'costo'                    => $_POST['costo'],
            'id_funcionario'           => $_POST['id_funcionario'],
            'id_equipo'                => $_POST['id_equipo'],
            'tipo_de_fallo'            => trim($_POST['tipo_de_fallo']),
            'descripcion_correctiva'   => trim($_POST['descripcion_correctiva']),
            'fecha_entrega_correctiva' => $_POST['fecha_entrega_correctiva'],
        ];

        Guardar_correctiva($conexion, $datos);

        $_SESSION['mensaje'] = "Mantención correctiva registrada correctamente";
        $_SESSION['tipo'] = "success";
        header("Location: mantenciones.php");
        exit;
    }

    $funcionarios_lista = mysqli_query($conexion, "SELECT id_funcionario, nombre_completo FROM funcionario ORDER BY nombre_completo ASC");
    $equipos_lista = mysqli_query($conexion, "SELECT id_equipo, tipo_equipo FROM equipo_general ORDER BY id_equipo ASC");

    $datos = consultarCostoCorrectiva($conexion);

    $mantenciones_actuales = consultaTotalMantenciones($conexion);

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mantenciones - NodoActivo</title>
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="manifest" href="/site.webmanifest">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/style.css?v=8">
    <script src="../assets/script.js" defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>

    <?php if(isset($_SESSION['mensaje'])){ ?>
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
            <div id="toastMensaje"
                class="toast align-items-center text-white bg-<?php echo $_SESSION['tipo'] ?? 'success'; ?> border-0"
                role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        <?php
                            echo $_SESSION['mensaje'];
                            unset($_SESSION['mensaje']);
                            unset($_SESSION['tipo']);
                        ?>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        </div>
    <?php } ?>

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

            <div class="Cerrar_Sesion">
                <a href="/Proyecto-TIS-1-E3-2026/sesion.php?logout=1"
                class="d-flex flex-row justify-content-start gap-2 align-items-center text-decoration-none text-danger p-2">
                    <span class="material-symbols-outlined">logout</span>
                    <p class="m-0 fs-6">Cerrar Sesion</p>
                </a>
            </div>        
        </div>
    </div>

    <div class="flex-grow-1 p-4" style="background-color: #F4F6F8; overflow-y: auto;">
        <div class="titulo-seccion d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center gap-3">
                <div class="titulo-seccion-linea"></div>
                <div>
                    <h2 class="fs-4 fw-bold m-0" style="color: #333333;">Módulo de Mantenciones</h2>
                    <p class="titulo-seccion-texto m-0">Control de intervenciones y reparaciones.</p>
                </div>
            </div>
        
            <button type="button" class="btn button d-flex align-items-center gap-2 px-3 py-2 fw-semibold" style="border-radius: 10px;"
                data-bs-toggle="modal" data-bs-target="#modalProgramarMantencion">
            <span class="material-symbols-outlined fs-5">add_circle</span>
            <p class="m-0 text-decoration-none text-white">Programar Mantención</p>
            </button>
        </div>
        <div class="row g-2 m-0">
            <div class="card p-3 mb-4 col-sm-8">
                <h5>Reporte de Costos de Mantención</h5>

                <p>
                    Total Mantenciones: <strong><?php echo $datos['cantidad']; ?></strong>
                </p>

                <p>
                    Costo Total: <strong>$<?php echo number_format($datos['total'], 0, ',', '.'); ?></strong>
                </p>

                <p>
                    Costo Promedio: <strong>$<?php echo number_format($datos['promedio'], 0, ',', '.'); ?></strong>
                </p>
            </div>

            <div class="row-col-1 align-items-center col-sm-4">
                <div class="col-12 col-md-auto mb-2">
                    <div class="card shadow-sm rounded-3" style="border-left: 10px solid #05ad98;">
                        <div class="card-body p-3">
                            <p class="text-muted fw-semibold mb-1" style="font-size: 0.9rem;">Costo Ultimo Mes</p>
                            <h3 class="fw-bold m-0 fs-4">$<?php echo number_format((int)costoUltimoMes($conexion), 0, ',', '.');?></h3>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-auto">
                    <div class="card shadow-sm rounded-3" style="border-left: 10px solid #ffc107;">
                        <div class="card-body p-3">
                            <p class="text-muted fw-semibold mb-1" style="font-size: 0.9rem;">Equipos En Mantención</p>
                            <h3 class="fw-bold m-0 fs-4"><?php echo $mantenciones_actuales ?> </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <ul class="nav nav-tabs mb-4 border-bottom" id="mantencionesTabs" role="tablist" style="--bs-nav-tabs-link-active-color: #05ad98; --bs-nav-link-color: #6c757d; --bs-nav-tabs-link-active-border-color: #05ad98;">
            <li class="nav-item" role="presentation">
                <button class="nav-link active fw-semibold" id="preventiva-tab" data-bs-toggle="tab" data-bs-target="#preventiva" type="button" role="tab">Mantención Preventiva</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-semibold text-secondary" id="correctiva-tab" data-bs-toggle="tab" data-bs-target="#correctiva" type="button" role="tab">Mantención Correctiva</button>
            </li>
        </ul>

        <div class="tab-content" id="mantencionesTabsContent">
            <div class="tab-pane fade show active" id="preventiva" role="tabpanel">
                <h5 class="fw-bold mb-3" style="color: #05ad98;">Revisiones Programadas</h5>
                
                <div class="card shadow-sm border-0 rounded-3" style="overflow: hidden;">
                    <div class="card-body p-0">
                        <?php
                        $consulta = "SELECT p.id_mantencion, p.costo, p.fecha_prox_mantencion, p.frecuencia_mantencion, f.nombre_completo as responsable 
                                    FROM preventiva p
                                    INNER JOIN funcionario f
                                    ON p.id_funcionario = f.id_funcionario";
                        $resultado = mysqli_query($conexion, $consulta);

                        if (!$resultado) {
                            die('Error de la consulta: ' . mysqli_error($conexion));
                        }
                        ?>

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
                            <tbody id = "tablaMantencionesProgramadas">
                                <?php
                                while($row = mysqli_fetch_assoc($resultado)){
                                    $id_mantencion = $row["id_mantencion"];
                                    $frecuencia = $row["frecuencia_mantencion"];
                                    $proxima_fecha = $row["fecha_prox_mantencion"];
                                    $responsable = $row["responsable"];
                                    $costo = $row["costo"];
                                ?>
                                <tr>
                                    <td><?php echo $id_mantencion; ?></td>
                                    <td><?php echo $frecuencia; ?> meses</td>
                                    <td><?php echo $proxima_fecha; ?></td>
                                    <td><?php echo $responsable; ?></td>
                                    <td><span class="badge bg-success">Programada</span></td>
                                    <td>$<?php echo number_format($costo,0,",","."); ?></td>
                                </tr>
                                
                                <?php
                                    }
                                ?>

                            </tbody>


                        </table>
                    </div>
                </div>
            </div>
            
            <div class="tab-pane fade" id="correctiva" role="tabpanel">
                <h5 class="fw-bold mb-3" style="color: #05ad98;">Revisiones Programadas</h5>
                
                <div class="card shadow-sm border-0 rounded-3" style="overflow: hidden;">
                    <div class="card-body p-0">
                        <?php
                        $consulta = "SELECT c.id_mantencion, c.tipo_de_fallo, c.estado, c.costo, c.descripcion, f.nombre_completo AS responsable 
                                     FROM correctiva c
                                     INNER JOIN funcionario f
                                     ON c.id_funcionario = f.id_funcionario";
                        $resultado = mysqli_query($conexion, $consulta);

                        if (!$resultado) {
                            die('Error de la consulta: ' . mysqli_error($conexion));
                        }
                        ?>

                        <table class="table table-hover m-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="p-3 text-secondary border-bottom" style="font-size: 0.85rem; font-weight: 600;">ID Mantención</th>
                                    <th class="p-3 text-secondary border-bottom" style="font-size: 0.85rem; font-weight: 600;">Tipo de Fallo</th>
                                    <th class="p-3 text-secondary border-bottom" style="font-size: 0.85rem; font-weight: 600;">Estado</th>
                                    <th class="p-3 text-secondary border-bottom" style="font-size: 0.85rem; font-weight: 600;">Costo Estimado</th>
                                    <th class="p-3 text-secondary border-bottom" style="font-size: 0.85rem; font-weight: 600;">Descripcion</th>
                                    <th class="p-3 text-secondary border-bottom" style="font-size: 0.85rem; font-weight: 600;">Responsable</th>
                                </tr>
                            </thead>
                            <tbody id = "tablaMantencionesProgramadas">
                                <?php
                                while($row = mysqli_fetch_assoc($resultado)){
                                    $id_mantencion = $row["id_mantencion"];
                                    $tipo_fallo = $row["tipo_de_fallo"];
                                    $estado = $row["estado"];
                                    $costo = $row["costo"];
                                    $descripcion = $row["descripcion"];
                                    $responsable = $row["responsable"];
                                ?>
                                <tr>
                                    <th scope="row" class="p-3 text-muted"><?php echo $id_mantencion;?>
                                    </th>
                                    <th scope="row" class="p-3 text-muted"><?php echo $tipo_fallo;?>
                                    </th>
                                    <th scope="row" class="p-3 text-muted"><?php echo $estado;?>
                                    </th>
                                    <th scope="row" class="p-3 text-muted"><?php echo $costo;?>
                                    </th>
                                    <th scope="row" class="p-3 text-muted"><?php echo $descripcion;?>
                                    </th>
                                    <th scope="row" class="p-3 text-muted"><?php echo $responsable;?>
                                    </th>
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

<div class="modal fade" id="modalProgramarMantencion" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Programar Mantención</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <ul class="nav nav-tabs px-3 pt-2" id="tipoMantencionTabs" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="modal-preventiva-tab" data-bs-toggle="tab" data-bs-target="#modal-preventiva" type="button" role="tab">Preventiva</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="modal-correctiva-tab" data-bs-toggle="tab" data-bs-target="#modal-correctiva" type="button" role="tab">Correctiva</button>
        </li>
      </ul>

      <div class="tab-content">

        <div class="tab-pane fade show active p-3" id="modal-preventiva" role="tabpanel">
          <form method="POST">
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Equipo</label>
                <select name="id_equipo" class="form-select" required>
                  <option value="">Seleccionar...</option>
                  <?php mysqli_data_seek($equipos_lista, 0); while($eq = mysqli_fetch_assoc($equipos_lista)): ?>
                    <option value="<?php echo $eq['id_equipo']; ?>">
                      #<?php echo $eq['id_equipo']; ?> - <?php echo htmlspecialchars($eq['tipo_equipo']); ?>
                    </option>
                  <?php endwhile; ?>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label">Responsable</label>
                <select name="id_funcionario" class="form-select" required>
                  <option value="">Seleccionar...</option>
                  <?php mysqli_data_seek($funcionarios_lista, 0); while($f = mysqli_fetch_assoc($funcionarios_lista)): ?>
                    <option value="<?php echo $f['id_funcionario']; ?>">
                      <?php echo htmlspecialchars($f['nombre_completo']); ?>
                    </option>
                  <?php endwhile; ?>
                </select>
              </div>
              <div class="col-md-4">
                <label class="form-label">Costo</label>
                <input type="number" name="costo" class="form-control" min="0" step="1" required>
              </div>
              <div class="col-md-4">
                <label class="form-label">Próxima mantención</label>
                <input type="date" name="fecha_prox_mantencion" class="form-control" required>
              </div>
              <div class="col-md-4">
                <label class="form-label">Frecuencia</label>
                <input type="datetime-local" name="frecuencia_mantencion" class="form-control" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Fecha de entrega estimada</label>
                <input type="date" name="fecha_entrega_preventiva" class="form-control" required>
              </div>
              <div class="col-md-12">
                <label class="form-label">Descripción</label>
                <textarea name="descripcion_preventiva" class="form-control" rows="2" required></textarea>
              </div>
            </div>
            <div class="modal-footer px-0 pb-0 mt-3">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              <button type="submit" name="guardar_preventiva" class="btn btn-success">Guardar Preventiva</button>
            </div>
          </form>
        </div>

        <div class="tab-pane fade p-3" id="modal-correctiva" role="tabpanel">
          <form method="POST">
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Equipo</label>
                <select name="id_equipo" class="form-select" required>
                  <option value="">Seleccionar...</option>
                  <?php mysqli_data_seek($equipos_lista, 0); while($eq = mysqli_fetch_assoc($equipos_lista)): ?>
                    <option value="<?php echo $eq['id_equipo']; ?>">
                      #<?php echo $eq['id_equipo']; ?> - <?php echo htmlspecialchars($eq['tipo_equipo']); ?>
                    </option>
                  <?php endwhile; ?>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label">Responsable</label>
                <select name="id_funcionario" class="form-select" required>
                  <option value="">Seleccionar...</option>
                  <?php mysqli_data_seek($funcionarios_lista, 0); while($f = mysqli_fetch_assoc($funcionarios_lista)): ?>
                    <option value="<?php echo $f['id_funcionario']; ?>">
                      <?php echo htmlspecialchars($f['nombre_completo']); ?>
                    </option>
                  <?php endwhile; ?>
                </select>
              </div>
              <div class="col-md-4">
                <label class="form-label">Costo</label>
                <input type="number" name="costo" class="form-control" min="0" step="1" required>
              </div>
              <div class="col-md-4">
                <label class="form-label">Fecha de entrega estimada</label>
                <input type="date" name="fecha_entrega_correctiva" class="form-control" required>
              </div>
              <div class="col-md-4">
                <label class="form-label">Tipo de fallo</label>
                <input type="text" name="tipo_de_fallo" class="form-control" required>
              </div>
              <div class="col-md-12">
                <label class="form-label">Descripción</label>
                <textarea name="descripcion_correctiva" class="form-control" rows="2" required></textarea>
              </div>
            </div>
            <div class="modal-footer px-0 pb-0 mt-3">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              <button type="submit" name="guardar_correctiva" class="btn btn-success">Guardar Correctiva</button>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const toastEl = document.getElementById("toastMensaje");
    if (toastEl) {
        const toast = new bootstrap.Toast(toastEl, { delay: 3000 });
        toast.show();
    }
});
</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>