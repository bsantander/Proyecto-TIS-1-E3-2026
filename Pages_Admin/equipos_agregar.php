<?php
require_once '../conexion.php'; 
require_once '../models/Mod_Equipos.php';
session_start();

$listaFuncionarios = obtenerTodosFuncionarios($conexion);
$listaProveedores = obtenerTodosProveedores($conexion); 
$fecha_hoy = date('Y-m-d');    
$fecha_maxima = date('Y-m-d', strtotime('+ 5 Years '));

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tipoEquipo = $_POST['tipo'] ?? '';
    $datosEquipo = $_POST;

    if (isset($datosEquipo['tipo_impresora'])) {
        $datosEquipo['tipo'] = $datosEquipo['tipo_impresora'];
        unset($datosEquipo['tipo_impresora']);
    }

    if (insertarEquipo($conexion, $tipoEquipo, $datosEquipo)) {
        header("Location: equipos.php");
        exit;
    }
}
?>

<!doctype html>
<html lang="es">
<head>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Equipo - NodoActivo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/style.css">
    <script src="../assets/script.js" defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
</head>
<body class="bg-light">

<div class="container my-5" style="max-width: 800px;">
    <a href="equipos.php" class="btn btn-secondary mb-4">Volver</a>

    <form method="POST">
        <div class="alert alert-danger d-flex gap-2">
            <i class="bi bi-exclamation-circle"></i>
            <p>Todos los campos son obligatorios</p>
        </div>
        <div class="card shadow-sm border-0 rounded-3 mb-4" style="border-top: 3px solid #05ad98;">
            <div class="card-header bg-white p-4">
                <h3 class="fs-5 fw-bold m-0 text-dark">Información General</h3>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="fw-semibold">Tipo de Equipo</label>
                        <select name="tipo" id="tipoSelect" class="form-select" onchange="mostrarCampos()" required>
                            <option value="">Seleccione...</option>
                            <option value="Computador">Computador</option>
                            <option value="Notebook">Notebook</option>
                            <option value="Proyector">Proyector</option>
                            <option value="Impresora">Impresora</option>
                            <option value="Servidor">Servidor</option>
                            <option value="Otro Dispositivo">Otro Dispositivo</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-semibold">Funcionario Responsable</label>
                        <select name="id_funcionario" class="form-select" required>
                            <?php foreach ($listaFuncionarios as $f): ?>
                                <option value="">Seleccione un funcionario</option>
                                <option value="<?php echo $f['id_funcionario']; ?>"><?php echo $f['nombre_completo']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-semibold">Proveedor del Equipo</label>
                        <select name="id_proveedor" class="form-select" required >
                            <?php foreach ($listaProveedores as $p): ?>
                                <option value="">Seleccione un proovedor</option>
                                <option value="<?php echo $p['id_proveedor']; ?>"><?php echo $p['nombre_completo']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="col-md-4 mb-3"><label>Marca</label><input type="text" name="marca" class="form-control" required></div>
                    <div class="col-md-4 mb-3"><label>N° Serie</label><input type="number" name="numero_serie" class="form-control" required></div>
                    <input type="hidden" name="fecha_compra" class="form-control" value="<?php echo $fecha_hoy; ?>" min="<?php echo $fecha_hoy; ?>">
                    <div class="col-md-6 mb-3"><label>Fecha Garantía</label><input type="date" name="fecha_garantia" class="form-control" required
                    min="<?php echo $fecha_hoy; ?>" max="<?php echo $fecha_maxima; ?>"></div>
                    <div class="col-md-12 mb-3"><label>Valor Equipo</label><input type="number" step="any" name="valor_equipo" class="form-control" required></div>
                </div>
            </div>
        </div>
        <div id="contenedorCampos" class="card border-0 rounded-3 mb-4" style="border-top: 3px solid #6c757d; display:none;">
            <div class="card-header bg-white p-4"><h3 class="fs-5 fw-bold m-0 text-dark">Detalles Específicos</h3></div>
            <div class="card-body p-4">
                <div id="camposComputador" class="tipo-campos" style="display:none;">
                    <div class="row">
                        <div class="col-md-6 mb-3"><label>Procesador</label><select name="procesador" class="form-select" required>
                            <option value="">Seleccione un procesador</option>
                            <option>Intel</option>
                            <option>Ryzen</option>
                        </select>
                    </div>
                        <div class="col-md-6 mb-3"><label>Modelo Procesador</label><input type="text" name="modelo_procesador" class="form-control" required></div>
                        <div class="col-md-6 mb-3"><label>Tipo RAM</label><select name="memoria_ram" class="form-select" required>
                            <option value="">Seleccione tipo de ram</option>
                            <option>DDR4</option>
                            <option>DDR5</option>
                            </select></div>
                        <div class="col-md-6 mb-3"><label>Cantidad RAM (GB)</label><input type="number" name="cantidad_ram" class="form-control" required></div>
                        <div class="col-md-6 mb-3"><label>Almacenamiento</label><select name="almacenamiento" class="form-select" required>
                                <option value="">Seleccione tipo de almacenamiento</option>
                            <option>SSD SATA</option>
                            <option>SSD M.2</option>
                            <option>HDD</option>
                         </select>
                        </div>
                        <div class="col-md-6 mb-3"><label>Cantidad Almacenamiento</label><input type="number" name="cantidad_almacenamiento" class="form-control" required></div>
                    </div>
                </div>
                <div id="camposNotebook" class="tipo-campos" style="display:none;">
                    <div class="row"><div class="col-md-12 mb-3"><label>Modelo Notebook</label><input type="text" name="modelo" class="form-control" required></div></div>
                </div>
                <div id="camposProyector" class="tipo-campos" style="display:none;">
                    <div class="row">
                        <div class="col-md-6 mb-3"><label>Modelo</label><input type="text" name="modelo" class="form-control" required></div>
                        <div class="col-md-6 mb-3"><label>Calidad Imagen</label><input type="number" name="calidad_imagen" class="form-control" required></div>
                    </div>
                </div>
                <div id="camposImpresora" class="tipo-campos" style="display:none;">
                    <div class="row">
                        <div class="col-md-4 mb-3"><label>Modelo</label><input type="text" name="modelo" class="form-control" required></div>
                        <div class="col-md-4 mb-3"><label>Volumen Impresión</label><input type="number" name="volumen_impresion" class="form-control" required></div>
                        <div class="col-md-4 mb-3"><label>Tipo</label>
                        <select name="tipo_impresora" class="form-select" required>
                        <option value="">Seleccione tipo de impresora</option>
                        <option>Inyección</option>
                            <option>Laser</option>
                        </select>
                    </div>
                    </div>
                </div>
                <div id="camposServidor" class="tipo-campos" style="display:none;">
                    <div class="row"><div class="col-md-12 mb-3"><label>Función</label><input type="text" name="funcion" class="form-control" required></div></div>
                </div>
                <div id="camposOtro Dispositivo" class="tipo-campos" style="display:none;">
                    <div class="row"><div class="col-md-12 mb-3"><label>Modelo</label><input type="text" name="modelo" class="form-control" required></div></div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn w-100" style="background-color: #05ad98; color: white;">Guardar Equipo</button>
    </form>
</div>

<script>
function mostrarCampos() {
    const tipo = document.getElementById('tipoSelect').value;
    const contenedor = document.getElementById('contenedorCampos');
    document.querySelectorAll('.tipo-campos').forEach(div => {
        div.style.display = 'none';
        div.querySelectorAll('input, select, textarea').forEach(campo => {
            campo.disabled = true;
        });
    });

    const activarCampos = (contenedorCampos) => {
        contenedorCampos.style.display = 'block';
        contenedorCampos.querySelectorAll('input, select, textarea').forEach(campo => {
            campo.disabled = false;
        });
    };
    
    if(tipo) {
        contenedor.style.display = 'block';
        if(tipo === 'Notebook') {
            activarCampos(document.getElementById('camposComputador'));
            activarCampos(document.getElementById('camposNotebook'));
        } else {
            const divMostrar = document.getElementById('campos' + tipo);
            if(divMostrar) activarCampos(divMostrar);
        }
    } else {
        contenedor.style.display = 'none';
    }
}

document.addEventListener('DOMContentLoaded', mostrarCampos);
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
