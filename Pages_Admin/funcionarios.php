<?php
    session_start();
    require('../conexion.php');
    require('../models/Mod_Funcionarios.php');
    $modelo = new Mod_Funcionarios($conexion);

    if(isset($_POST['agregar'])){
        $rut = $_POST['rut'];
        $nombre_completo = $_POST['nombre_completo'];
        $id_equipo = $_POST['id_equipo'];
        $id_departamento = $_POST['id_departamento'];
        $rol = $_POST['rol'];
        $contrasena = $_POST['contrasena'];
        $_SESSION['mensaje'] = $modelo->agregarFuncionario($rut, $nombre_completo, $id_equipo, $id_departamento, $rol, $contrasena);
            header("Location: funcionarios.php");
            exit;
    }

    if(isset($_GET['eliminar'])){
        $id_funcionario = (int) $_GET['eliminar'];
        $_SESSION['mensaje'] = $modelo->eliminarFuncionario($id_funcionario);
        header("Location: funcionarios.php");
        exit;
   }
   $editar = null;

    if(isset($_GET['editar'])){
        $id_funcionario = (int) $_GET['editar'];

        $res = mysqli_query($conexion, "SELECT * FROM funcionario WHERE id_funcionario=$id_funcionario");
        $editar = mysqli_fetch_assoc($res);
    }

    if(isset($_POST['guardar'])){
        $id_funcionario = (int) $_POST['id_funcionario'];
        $rut = (int) $_POST['rut'];
        $nombre_completo = trim($_POST['nombre_completo']);
        $id_equipo = (int) $_POST['id_equipo'];
        $id_departamento = (int) $_POST['id_departamento'];
        $rol = trim($_POST['rol']);
        $contrasena = trim($_POST['contrasena']);

        $_SESSION['mensaje'] = $modelo->editarFuncionario($id_funcionario, $rut, $nombre_completo, $id_equipo,$id_departamento,$rol,$contrasena);
        header("Location: funcionarios.php");
        exit;
    }

    $funcionarios = mysqli_query($conexion, "SELECT id_funcionario, rut, nombre_completo, id_equipo, id_departamento, rol, contrasena FROM funcionario");

    $departamentos = mysqli_query(
    $conexion,
    "SELECT id_departamento, nombre_departamento FROM departamento"
);
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Funcionarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/style.css">
    <script src="../assets/script.js" defer></script>
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
                <a href="funcionarios.php" class="Barra_Izquierda_Index_active d-flex flex-row justify-content-start gap-2 align-items-center text-decoration-none text-black p-2 rounded-1">
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
            <div class="Configuracion" >
                <a href="configuracion.php" class=" d-flex flex-row justify-content-start gap-2 align-items-center text-decoration-none text-black p-2">
                    <span class="material-symbols-outlined">build</span>                   
                    <p class="m-0 fs-6">Configuracion</p>
                </a>
            </div>

            <div class="Cerrar_Sesion">
                <a href="../secion.php?logout=1" class=" d-flex flex-row justify-content-start gap-2 align-items-center text-decoration-none text-danger p-2">
                    <span class="material-symbols-outlined">logout</span>
                    <p class="m-0 fs-6">Cerrar Sesion</p>
                </a>
            </div>        
        </div>
    </div>
    

    <div class="flex-grow-1 p-4" style="background-color: #F4F6F8; overflow-y: auto;">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fs-4 fw-bold m-0" style="color: #333333;">Nómina de Funcionarios</h2>
            
            <button
                class="btn button d-flex align-items-center gap-2 px-3 py-2 fw-semibold"
                style="border-radius: 10px;"
                data-bs-toggle="modal"
                data-bs-target="#modalAgregarFuncionario">

                <span class="material-symbols-outlined fs-5">person_add</span>
                <p class="m-0">Agregar funcionario</p>
            </button>
        </div>

        <?php if (isset($_SESSION['mensaje'])): ?>
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
            <div id="toastMensaje" class="toast align-items-center text-white bg-success border-0" role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        <?php echo $_SESSION['mensaje']; unset($_SESSION['mensaje']); ?>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        </div>
        <?php endif; ?>

                <div class="d-flex justify-content-between align-items-center mb-4 gap-3">
            <div class="input-group" style="max-width: 450px;">
                <span class="input-group-text bg-white border-end-0 rounded-start-3" style="border-color: #dbe4e2;">
                    <span class="material-symbols-outlined text-secondary fs-5">search</span>
                </span>
                <input type="text" class="Buscador form-control border-start-0 rounded-end-3 py-2" placeholder="Buscar por ID, marca o tipo...">
            </div>

            <button class="Filtros btn btn-outline-secondary d-flex align-items-center gap-2 px-3 py-2 fw-medium">
                <span class="material-symbols-outlined fs-5">filter_list</span>
                <p class="m-0">Filtros</p>
            </button>
        </div>
        
        
        <div class="card shadow-sm border-0 rounded-3" style="border-top: 3px solid #05ad98; overflow: hidden;">
            <div class="card-body p-0">
                <?php
                $consulta = "SELECT id_funcionario, rut, nombre_completo, rol, id_equipo, id_departamento
                FROM funcionario";
                $resultado = mysqli_query($conexion, $consulta);
                if (!$resultado) {
                    die('Error en la consulta: ' . mysqli_error($conexion));
                    }
                    ?>

                <table class="table table-hover m-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="p-3 text-secondary" style="font-size: 0.9rem; font-weight: 600;">ID Funcionario</th>
                            <th class="p-3 text-secondary" style="font-size: 0.9rem; font-weight: 600;">RUT</th>
                            <th class="p-3 text-secondary" style="font-size: 0.9rem; font-weight: 600;">Nombre Completo</th>
                            <th class="p-3 text-secondary" style="font-size: 0.9rem; font-weight: 600;">Rol</th>
                            <th class="p-3 text-secondary" style="font-size: 0.9rem; font-weight: 600;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while($row = mysqli_fetch_assoc($resultado)){
                            $id_funcionario  = $row["id_funcionario"];
                            $nombre_completo = $row["nombre_completo"];
                            $id_equipo       = $row["id_equipo"];
                            $id_departamento = $row["id_departamento"];
                            $rol             = $row["rol"];
                            $rut             = $row["rut"];
                        ?>
                        <tr>
                            <th><?php echo $id_funcionario; ?></th>
                            <td><?php echo $rut; ?></td>
                            <td><?php echo $nombre_completo; ?></td>
                            <td><?php echo $rol; ?></td>
                            <td>
                            <button class="btn btn-outline-dark btn-sm"
                            onclick='abrirEditar(
                                <?php echo (int) $id_funcionario; ?>,
                                <?php echo json_encode($rut); ?>,
                                <?php echo json_encode($nombre_completo); ?>,
                                <?php echo (int) $id_equipo; ?>,
                                <?php echo (int) $id_departamento; ?>,
                                <?php echo json_encode($rol); ?>
                            )'>
                            Editar
                            </button>

                            <a href="funcionarios.php?eliminar=<?php echo $id_funcionario; ?>"
                                class="btn btn-outline-danger btn-sm"
                                onclick="return confirm('¿Está seguro de eliminar este funcionario?')">
                                Eliminar
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
    </div>

</div>

<div class="modal fade" id="modalAgregarFuncionario" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Funcionario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <div class="modal-body d-flex flex-column gap-3">

                    <div>
                        <label class="form-label">RUT</label>
                        <input type="text" name="rut" class="form-control" placeholder="12.345.678-9" required>
                    </div>
                    <div>
                        <label class="form-label">Nombre Completo</label>
                        <input type="text" name="nombre_completo" class="form-control" required>
                    </div>
                    <div>
                        <label class="form-label">Departamento</label>
                        <select name="id_departamento" class="form-select" required>
                            <option value="">Seleccionar...</option>
                            <?php
                            // Rebobinar el resultado de departamentos por si ya se usó
                            mysqli_data_seek($departamentos, 0);
                            while ($dep = mysqli_fetch_assoc($departamentos)):
                            ?>
                            <option value="<?php echo $dep['id_departamento']; ?>">
                                <?php echo $dep['nombre_departamento']; ?>
                            </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Equipo asignado</label>
                            <input type="text" name="id_equipo" class="form-control" required>
                    </div>
                    <div>
                        <label class="form-label">Rol</label>
                        <input type="text" name="rol" class="form-control" required>
                    </div>
                    <div>
                        <label class="form-label">Contraseña</label>
                        <input type="password" name="contrasena" class="form-control" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" name="agregar" class="btn btn-success">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditarFuncionario" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Funcionario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <div class="modal-body d-flex flex-column gap-3">

                    <input type="hidden" name="id_funcionario" id="edit_id">

                    <div>
                        <label class="form-label">RUT</label>
                        <input type="text" name="rut" id="edit_rut" class="form-control" required>
                    </div>
                    <div>
                        <label class="form-label">Nombre Completo</label>
                        <input type="text" name="nombre_completo" id="edit_nombre" class="form-control" required>
                    </div>
                    <div>
                        <label class="form-label">Departamento</label>
                        <select name="id_departamento" id="edit_departamento" class="form-select" required>
                            <option value="">Seleccionar...</option>
                            <?php
                            // Rebobinar el resultado de departamentos por si ya se usó
                            mysqli_data_seek($departamentos, 0);
                            while ($dep = mysqli_fetch_assoc($departamentos)):
                            ?>
                            <option value="<?php echo $dep['id_departamento']; ?>">
                                <?php echo $dep['nombre_departamento']; ?>
                            </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Equipo asignado</label>
                        <input type="text" name="id_equipo" id="edit_equipo" class="form-control" required>
                    </div>
                    <div>
                        <label class="form-label">Rol</label>
                        <input type="text" name="rol" id="edit_rol" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" name="guardar" class="btn btn-primary">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function abrirEditar(id, rut, nombre, id_equipo, id_departamento, rol) {
    document.getElementById('edit_id').value           = id;
    document.getElementById('edit_rut').value          = rut;
    document.getElementById('edit_nombre').value       = nombre;
    document.getElementById('edit_equipo').value       = id_equipo;
    document.getElementById('edit_departamento').value = id_departamento;
    document.getElementById('edit_rol').value          = rol;

    new bootstrap.Modal(document.getElementById('modalEditarFuncionario')).show();
}

document.addEventListener('DOMContentLoaded', function () {
    const toastEl = document.getElementById('toastMensaje');
    if (toastEl) new bootstrap.Toast(toastEl, { delay: 3000 }).show();
});
</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>