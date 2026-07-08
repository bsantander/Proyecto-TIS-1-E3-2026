<?php
    session_start();
    require('../conexion.php');
    require('../models/Mod_Proveedores.php');
    $modelo = new Mod_Proveedores($conexion);

    if(isset($_POST['agregar'])){

        $rut_proveedor   = trim($_POST['rut_proveedor']);
        $nombre_completo = trim($_POST['nombre_completo']);
        $contacto        = trim($_POST['contacto']);

        $_SESSION['mensaje'] = $modelo->agregarProveedor(
            $rut_proveedor,
            $nombre_completo,
            $contacto
        );

        if($_SESSION['mensaje'] == "Proveedor registrado correctamente"){
            $_SESSION['tipo'] = "success";
        }else{
            $_SESSION['tipo'] = "danger";
        }

        header("Location: proveedores.php");
        exit;
    }

    if(isset($_POST['guardar'])){

        $id_proveedor    = (int) $_POST['id_proveedor'];
        $rut_proveedor   = trim($_POST['rut_proveedor']);
        $nombre_completo = trim($_POST['nombre_completo']);
        $contacto        = trim($_POST['contacto']);

        $_SESSION['mensaje'] = $modelo->editarProveedor(
            $id_proveedor,
            $rut_proveedor,
            $nombre_completo,
            $contacto
        );

        if($_SESSION['mensaje'] == "Proveedor actualizado correctamente"){
            $_SESSION['tipo'] = "success";
        }else{
            $_SESSION['tipo'] = "danger";
        }

        header("Location: proveedores.php");
        exit;
    }

    if(isset($_GET['eliminar'])){

        $id_proveedor = (int) $_GET['eliminar'];

        $_SESSION['mensaje'] = $modelo->eliminarProveedor($id_proveedor);
        $_SESSION['tipo'] = "success";

        header("Location: proveedores.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proveedores - NodoActivo</title>
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
                <a href="equipos.php" class="d-flex flex-row justify-content-start gap-2 align-items-center text-decoration-none text-black p-2 rounded-1">
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
                <a href="proveedores.php" class="Barra_Izquierda_Index_active d-flex flex-row justify-content-start gap-2 align-items-center text-decoration-none text-black p-2 rounded-1">
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
        
        <div id="vista-tabla">
            <div class="titulo-seccion d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="titulo-seccion-linea"></div>
                    <div>
                        <h2 class="fs-4 fw-bold m-0" style="color: #333333;">Nómina de Proveedores</h2>
                        <p class="titulo-seccion-texto m-0">Registro y datos de contacto de proveedores</p>
                    </div>
                </div>

                    <button type="button" class="btn button d-flex align-items-center gap-2 px-3 py-2 fw-semibold" style="border-radius: 10px;"
                    data-bs-toggle="modal" data-bs-target="#modalProveedoragregar">
                        <span class="material-symbols-outlined fs-5 text-decoration-none text-white">add_to_queue</span>
                        <p class="m-0 text-decoration-none text-white">Agregar Proveedor</p>
                </button>
            </div>
            <?php if (isset($_SESSION['mensaje'])): ?>
            <div class="position-fixed bottom-0 end-0 p-3" style="z-index:9999">
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

                        <button type="button"
                                class="btn-close btn-close-white me-2 m-auto"
                                data-bs-dismiss="toast">
                        </button>
                    </div>

                </div>
            </div>
            <?php endif; ?>
            
            <div class="d-flex justify-content-between align-items-center mb-4 gap-3">

                <!-- BUSCADOR -->
                <form method="GET" class="w-100" style="max-width: 450px;">
                    <div class="input-group">

                        <span class="input-group-text bg-white border-end-0 rounded-start-3"
                            style="border-color: #dbe4e2;">
                            <span class="material-symbols-outlined text-secondary fs-5">
                                search
                            </span>
                        </span>

                        <input
                            type="text"
                            name="buscar"
                            class="Buscador form-control border-start-0 rounded-end-3 py-2"
                            placeholder="Buscar proveedor..."
                            value="<?php echo isset($_GET['buscar']) ? htmlspecialchars($_GET['buscar']) : ''; ?>"
                            >

                        <button class="btn btn-outline-primary" type="submit">
                            Buscar
                        </button>

                    </div>

                </form>

                <!-- BOTÓN ORDENAR -->
                <div class="dropdown">

                    <button class="btn btn-secondary dropdown-toggle d-flex align-items-center gap-2 px-3 py-2 fw-medium"
                            type="button"
                            data-bs-toggle="dropdown">

                        <span class="material-symbols-outlined fs-5">sort</span>
                        Ordenar
                    </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item"
                                href="proveedores.php">
                                    Todos
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item"
                                href="proveedores.php?orden=id_asc&buscar=<?php  echo urlencode($_GET['buscar'] ?? ''); ?>">
                                    ID Ascendente
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item"
                                href="proveedores.php?orden=id_desc&buscar=<?php  echo urlencode($_GET['buscar'] ?? ''); ?>">
                                    ID Descendente
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item"
                                href="proveedores.php?orden=nombre_asc&buscar=<?php  echo urlencode($_GET['buscar'] ?? ''); ?>">
                                    Nombre A-Z
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item"
                                href="proveedores.php?orden=nombre_desc&buscar=<?php  echo urlencode($_GET['buscar'] ?? ''); ?>">
                                    Nombre Z-A
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            <div class="card shadow-sm border-0 rounded-3" style="border-top: 3px solid #05ad98; overflow: hidden;">
                <div class="card-body p-0">
                    <?php

                            $orden = "ORDER BY id_proveedor ASC";
                            
                            if(isset($_GET['orden'])){
                                switch($_GET ['orden']) {
                                    case 'id_desc':
                                        $orden = " ORDER BY id_proveedor DESC";
                                        break;

                                    case 'nombre_asc':
                                        $orden = " ORDER BY nombre_completo ASC";
                                        break;

                                    case 'nombre_desc':
                                        $orden = " ORDER BY nombre_completo DESC";
                                        break;
                                    case 'id_asc':
                                    default:
                                        $orden  = " ORDER BY id_proveedor ASC";
                                        break;
                                    }
                                }

                            /* ===========================
                            CONSULTA CON BUSCADOR
                            =========================== */

                            $consulta = "
                                SELECT id_proveedor, rut_proveedor, nombre_completo, contacto
                                FROM proveedor
                            ";

                            if(isset($_GET['buscar']) && trim($_GET['buscar']) != ""){

                                $buscar = mysqli_real_escape_string(
                                    $conexion,
                                    trim($_GET['buscar'])
                                );

                                $consulta .= "
                                    WHERE nombre_completo LIKE '%$buscar%'
                                ";
                            }
                            $consulta .= " $orden";                
                             
                            $resultado = mysqli_query($conexion, $consulta);

                            if (!$resultado) {
                                die("Error en la consulta: " . mysqli_error($conexion));
                            }
                        ?>
                    <table class="table table-hover m-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="p-3 text-secondary" style="font-size: 0.9rem; font-weight: 600;">ID Proveedor</th>
                                <th class="p-3 text-secondary" style="font-size: 0.9rem; font-weight: 600;">Nombre </th>
                                <th class="p-3 text-secondary" style="font-size: 0.9rem; font-weight: 600;">Rut</th>
                                <th class="p-3 text-secondary" style="font-size: 0.9rem; font-weight: 600;">Contacto</th>
                                <th class="p-3 text-secondary text-center" style="font-size: 0.9rem; font-weight: 600;">Gestionar proveedor</th>
                            </tr>
                        </thead>
                        <tbody id="tablaProveedores" >
                            <?php
                            while($row = mysqli_fetch_assoc($resultado)){
                                $id_proveedor    = $row["id_proveedor"];
                                $rut_proveedor   = $row["rut_proveedor"];
                                $nombre_completo = $row["nombre_completo"];
                                $contacto        = $row["contacto"];

                            ?>
                            <tr>
                              <th scope="row" class="p-3 text-muted"><?php echo $id_proveedor; ?></th>
                              <td class="p-3 fw-semibold" style="color: #05ad98;"><?php echo $nombre_completo; ?></td>
                              <td class="p-3 fw-medium text-dark"><?php echo $rut_proveedor; ?></td>
                              <td class="p-3 fw-medium text-dark"><?php echo $contacto; ?></td>
                              
                              <td class="p-3 text-center">

                              <button class="btn btn-outline-dark  btn-sm" 
                            onclick='abrirEditar(<?php echo $row["id_proveedor"]; ?>, 
                            <?php echo json_encode($row["nombre_completo"]); ?>, 
                            <?php echo json_encode($row["rut_proveedor"]); ?>, 
                            <?php echo json_encode($row["contacto"]); ?> )'>
                            Editar
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    

<div class="modal fade" id="modalProveedoragregar" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Agregar Nuevo Proveedor</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form method="POST"> 
        <div class="modal-body">
            <div class="mb-3">
                <label class="form-label">Rut del Proveedor</label>
                <input type="text" name="rut_proveedor" class="form-control" inputmode="numeric" pattern="[0-9]{8,9}" minlength="8" maxlength="9" title="Ingrese su Rut completo, sin ningun signo" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Nombre del Proveedor</label>
                <input type="text" name="nombre_completo" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Contacto</label>
                <input type="email" name="contacto" class="form-control" placeholder="ejemplo@correo.com">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" name="agregar" class="btn btn-primary" style="background-color: #05ad98; border: none;">Guardar Proveedor</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="modalProveedoreditar" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Editar Proveedor</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form method="POST"> 
        <div class="modal-body">
            <input type="hidden" name="id_proveedor" id="edit_id">

            <div class="mb-3">
                <label class="form-label">Rut del Proveedor</label>
                <input type="text" name="rut_proveedor" id="edit_rut" class="form-control" inputmode="numeric" pattern="[0-9]{8,9}" minlength="8" maxlength="9" title="Ingrese su Rut completo, sin ningun signo" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Nombre del Proveedor</label>
                <input type="text" name="nombre_completo" id="edit_nombre" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Contacto</label>
                <input type="email" name="contacto" id="edit_contacto" class="form-control" required>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <a href="#" id="btn_eliminar_modal" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este proveedor?');">Eliminar</a>
            <button type="submit" name="guardar" class="btn btn-primary" style="background-color: #05ad98; border: none;">Guardar cambios</button>
        </div>
      </form>
    </div>
  </div>
</div>

    
<script>
function abrirEditar(id, nombre, rut, contacto) {
    document.getElementById("edit_id").value = id;
    document.getElementById("edit_nombre").value = nombre;
    document.getElementById("edit_rut").value = rut;
    document.getElementById("edit_contacto").value = contacto;
    const btnEliminar = document.getElementById("btn_eliminar_modal");
    if (btnEliminar) {
        btnEliminar.href = "proveedores.php?eliminar=" + id;
    }

    const modalElement = document.getElementById("modalProveedoreditar");
    const modal = new bootstrap.Modal(modalElement);
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

</body>
</html>

