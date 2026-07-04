    <?php
        session_start();
        require('../conexion.php');
        require('../models/Mod_Departamentos.php');
        $modelo = new Mod_Departamentos($conexion);


       if(isset($_POST['agregar'])){
            $nombre = trim($_POST['nombre_departamento']);

            // Validación
            if(strlen($nombre) < 3){
                $_SESSION['mensaje'] = "El nombre del departamento debe tener al menos 3 caracteres.";
                $_SESSION['tipo'] = "danger";
                header("Location: departamentos.php");
                exit;
            }

            $_SESSION['mensaje'] = $modelo->agregarDepartamento($nombre);
            $_SESSION['tipo'] = "success";
            header("Location: departamentos.php");
            exit;
        }

        if(isset($_GET['eliminar'])){
            $id = (int) $_GET['eliminar'];
            $_SESSION['mensaje'] = $modelo->eliminarDepartamento($id);
            header("Location: departamentos.php");
            exit;
        }
        $editar = null;

        if(isset($_GET['editar'])){
            $id = (int) $_GET['editar'];

            $res = mysqli_query($conexion, "SELECT * FROM departamento WHERE id_departamento=$id");
            $editar = mysqli_fetch_assoc($res);
        }
        if(isset($_POST['guardar'])){

            $id = (int) $_POST['id_departamento'];
            $nombre = trim($_POST['nombre_departamento']);

            // Validación
            if(strlen($nombre) < 3){
                $_SESSION['mensaje'] = "El nombre del departamento debe tener al menos 3 caracteres.";
                $_SESSION['tipo'] = "danger";
                header("Location: departamentos.php");
                exit;
            }

            $_SESSION['mensaje'] = $modelo->editarDepartamento($id, $nombre);
            $_SESSION['tipo'] = "success";
            header("Location: departamentos.php");
            exit;
        }

    ?>


    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Departamentos - NodoActivo</title>
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

        <div class="Barra_Lateral d-flex flex-column justify-content-between p-3">
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
                        <p class="m-0 fs-6">Configuración</p>
                    </a>
                </div>

                <div class="Cerrar_Sesion">
                    <a href="../secion.php?logout=1" class=" d-flex flex-row justify-content-start gap-2 align-items-center text-decoration-none text-danger p-2">
                        <span class="material-symbols-outlined">logout</span>
                        <p class="m-0 fs-6">Cerrar Sesión</p>
                    </a>
                </div>        
            </div>
        </div>

        <div class="flex-grow-1 p-4" style="background-color: #F4F6F8; overflow-y: auto;">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fs-4 fw-bold m-0" style="color: #333333;">Departamentos</h2>
                </div>
                
                <button class="btn button d-flex align-items-center gap-2 px-3 py-2 fw-semibold" style="border-radius: 10px;" data-bs-toggle="modal" data-bs-target="#modalAgregarDepartamento">
                    <span class="material-symbols-outlined fs-5">domain_add</span>
                    <p class="m-0">Agregar departamento</p>
                </button>
            </div>

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

            <div class="d-flex justify-content-between align-items-center mb-4 gap-3">
                <form method="GET" class="w-100" style="max-width: 450px;">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 rounded-start-3" style="border-color: #dbe4e2;">
                            <span class="material-symbols-outlined text-secondary fs-5">search</span>
                        </span>

                        <input
                            type="text"
                            name="buscar"
                            class="Buscador form-control border-start-0 rounded-end-3 py-2"
                            placeholder="Buscar departamento..."
                            value="<?php echo isset($_GET['buscar']) ? htmlspecialchars($_GET['buscar']) : ''; ?>"
                        >

                        <button class="btn btn-outline-primary" type="submit">
                            Buscar
                        </button>
                    </div>
                </form>

                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle d-flex align-items-center gap-2 px-3 py-2 fw-medium"
                        type="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">

                        <span class="material-symbols-outlined fs-5">sort</span>
                        Ordenar
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="departamentos.php">
                                Todos
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item"
                            href="departamentos.php?orden=id_asc&buscar=<?php echo urlencode($_GET['buscar'] ?? ''); ?>">
                                ID Ascendente
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item"
                            href="departamentos.php?orden=id_desc&buscar=<?php echo urlencode($_GET['buscar'] ?? ''); ?>">
                                ID Descendente
                            </a>
                        </li>

                        <li><hr class="dropdown-divider"></li>

                        <li>
                            <a class="dropdown-item"
                            href="departamentos.php?orden=nombre_asc&buscar=<?php echo urlencode($_GET['buscar'] ?? ''); ?>">
                                Nombre A-Z
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item"
                            href="departamentos.php?orden=nombre_desc&buscar=<?php echo urlencode($_GET['buscar'] ?? ''); ?>">
                                Nombre Z-A
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="card shadow-sm border-0 rounded-3" style="border-top: 3px solid #05ad98; overflow: hidden;">
                <div class="card-body p-0">
                    <?php

                            $orden = "ORDER BY id_departamento ASC";

                            if(isset($_GET['orden'])){

                                switch($_GET['orden']){

                                    case "id_desc":
                                        $orden = "ORDER BY id_departamento DESC";
                                        break;

                                    case "nombre_asc":
                                        $orden = "ORDER BY nombre_departamento ASC";
                                        break;

                                    case "nombre_desc":
                                        $orden = "ORDER BY nombre_departamento DESC";
                                        break;

                                    case "id_asc":
                                    default:
                                        $orden = "ORDER BY id_departamento ASC";
                                        break;
                                }
                            }

                            /* ===========================
                            CONSULTA CON BUSCADOR
                            =========================== */

                            $consulta = "
                                SELECT id_departamento, nombre_departamento
                                FROM departamento
                            ";

                            if(isset($_GET['buscar']) && trim($_GET['buscar']) != ""){

                                $buscar = mysqli_real_escape_string(
                                    $conexion,
                                    trim($_GET['buscar'])
                                );

                                $consulta .= "
                                    WHERE nombre_departamento LIKE '%$buscar%'
                                ";
                            }

                            $consulta .= " $orden";

                            $resultado = mysqli_query($conexion, $consulta);

                            if(!$resultado){
                                die("Error en la consulta: " . mysqli_error($conexion));
                            }

                     ?>
                    
                    <table class="table table-hover m-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="p-3 text-secondary" style="font-size: 0.9rem; font-weight: 600; width: 10%;">ID</th>
                                <th class="p-3 text-secondary" style="font-size: 0.9rem; font-weight: 600; width: 40%;">Nombre del Departamento</th>
                                <th class="p-3 text-secondary" style="font-size: 0.9rem; font-weight: 600;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while($row = mysqli_fetch_assoc($resultado)){
                                $id_departamento = $row["id_departamento"];
                                $nombre_departamento = $row["nombre_departamento"];

                            ?>
                            <tr>
                            <th scope="row"><?php echo $id_departamento; ?></th>
                            <td><?php echo $nombre_departamento; ?></td>

                            <td>
                                <button class="btn btn-outline-dark btn-sm"
                                onclick='abrirEditar(
                                    <?php echo $id_departamento; ?>,
                                    <?php echo json_encode($nombre_departamento); ?>
                                )'>
                                        Editar
                                
                                </button>
                                <a href="departamentos.php?eliminar=<?php echo $id_departamento; ?>"
                                    class="btn btn-outline-danger btn-sm"
                                    onclick="return confirm('¿Está seguro de eliminar este departamento?')">
                                        Eliminar
                                </a>
                                <a href="ver_departamento.php?id=<?php echo $id_departamento; ?>"
                                    class="btn btn-ouline-info btn-sm">

                                        <span class="material-symbols-outlined">
                                            visibility
                                        </span>

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



    <div class="modal fade" id="modalAgregarDepartamento" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

        <div class="modal-header">
            <h5 class="modal-title">Agregar Departamento</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>   
        </div>

        <form method="POST">
            <div class="modal-body">
            <label class="form-label">Nombre del departamento</label>
            <input type="text" name="nombre_departamento" class="form-control" required>
            </div>

            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                Cancelar
            </button>

            <button type="submit" name="agregar" class="btn btn-success">
                Guardar
            </button>
            </div>
        </form>

        </div>
    </div>
    </div>

    <div class="modal fade" id="modalEditarDepartamento" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

        <div class="modal-header">
            <h5 class="modal-title">Editar Departamento</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <form method="POST">
            <div class="modal-body">

            <input type="hidden" name="id_departamento" id="edit_id">

            <label class="form-label">Nombre del departamento</label>

            <input type="text"
                    name="nombre_departamento"
                    id="edit_nombre"
                    class="form-control"
                    required>

            </div>

            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                Cancelar
            </button>

            <button type="submit" name="guardar" class="btn btn-success">
                Guardar cambios
            </button>
            </div>

        </form>

        </div>
    </div>
</div>
<script>
function abrirEditar(id, nombre){
    document.getElementById("edit_id").value = id;
    document.getElementById("edit_nombre").value = nombre;

    const modal = new bootstrap.Modal(
        document.getElementById("modalEditarDepartamento")
    );

    modal.show();
}
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const toastEl = document.getElementById("toastMensaje");
    if (toastEl) {
        const toast = new bootstrap.Toast(toastEl, {
            delay: 3000
        });
        toast.show();
    }
});
</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>