<?php
    session_start();
    require('../conexion.php');
    require('../models/Mod_Tec_Mantenciones.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $pagina_destino = Guardar_mantencion($conexion, $_POST);
        header('Location: ' . $pagina_destino);
        exit;
    }

    $equipos_disponibles = Consultar_equipos($conexion);
    $funcionarios_disponibles = Consultar_funcionarios($conexion);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Mantencion - NodoActivo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/style.css?v=7">
    <script src="../assets/script.js" defer></script>
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
                    <p class="m-0 fs-6">Dashboard</p>
                </a>
            </div>

            <div class="Mantenciones">
                <a href="mantenciones_agregar.php" class="Barra_Izquierda_Index_active d-flex flex-row justify-content-start gap-2 align-items-center text-decoration-none text-black p-2 rounded-1">
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
                <a href="preventivas.php" class="d-flex flex-row justify-content-start gap-2 align-items-center text-decoration-none text-black p-2 rounded-1">
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

    <div class="flex-grow-1 bg-light overflow-auto p-4">
        <div class="titulo-seccion d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center gap-3">
                <div class="titulo-seccion-linea"></div>
                <div>
                    <h2 class="fs-4 fw-bold m-0" style="color: #333333;">Agregar Mantencion</h2>
                    <p class="titulo-seccion-texto m-0">Registro visual de mantenciones preventivas y correctivas</p>
                </div>
            </div>
        </div>

        <form id="formMantencion" class="card shadow-sm border-0 rounded-3" novalidate method="POST">
            <div class="card-header bg-white border-bottom d-flex flex-column flex-lg-row justify-content-between gap-2 p-3">
                <div>
                    <h3 class="fs-5 fw-bold m-0">Datos de la mantencion</h3>
                    <p class="text-secondary m-0">Campos organizados segun el tipo de mantencion</p>
                </div>
            </div>

            <div class="card-body p-4">
                <div id="alertaCampos" class="alert alert-danger d-none align-items-center gap-2" role="alert">
                    <i class="bi bi-exclamation-circle"></i>
                    <p class="m-0">Todos los campos son obligatorios</p>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-12 col-lg-6">
                        <input type="radio" class="btn-check" name="tipo_mantencion" id="tipoPreventiva" value="preventiva" checked required>
                        <label class="btn btn-outline-primary text-start w-100 h-100 p-3" for="tipoPreventiva">
                            <span class="d-flex align-items-center gap-2 fw-bold">
                                <span class="material-symbols-outlined fs-5">event_available</span>
                                Mantencion preventiva
                            </span>
                            <span class="d-block mt-2 small">Revision programada con fecha proxima y frecuencia.</span>
                        </label>
                    </div>

                    <div class="col-12 col-lg-6">
                        <input type="radio" class="btn-check" name="tipo_mantencion" id="tipoCorrectiva" value="correctiva" required>
                        <label class="btn btn-outline-danger text-start w-100 h-100 p-3" for="tipoCorrectiva">
                            <span class="d-flex align-items-center gap-2 fw-bold">
                                <span class="material-symbols-outlined fs-5">construction</span>
                                Mantencion correctiva
                            </span>
                            <span class="d-block mt-2 small">Registro de falla y descripcion de reparacion.</span>
                        </label>
                    </div>
                </div>

                <div class="border rounded-3 p-3 mb-4 bg-white">
                    <h4 class="fs-6 fw-bold mb-3">Datos generales</h4>

                    <div class="row g-3">
                        <div class="col-12 col-md-6 col-xl-4">
                            <label for="costoMantencion" class="form-label fw-semibold text-secondary">Costo</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="costoMantencion" name="costo" placeholder="25000" required>
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-xl-4">
                            <label for="funcionarioMantencion" class="form-label fw-semibold text-secondary">ID funcionario</label>
                            <select class="form-select" id="funcionarioMantencion" name="id_funcionario" required>
                                <option value="" selected disabled id="funcionarioPlaceholder">Seleccione un equipo primero</option>
                                <?php while ($funcionario = mysqli_fetch_assoc($funcionarios_disponibles)): ?>
                                    <option value="<?php echo $funcionario['id_funcionario']; ?>">
                                        <?php echo $funcionario['id_funcionario']; ?> - <?php echo $funcionario['nombre_completo']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="col-12 col-md-6 col-xl-4">
                            <label for="equipoMantencion" class="form-label fw-semibold text-secondary">ID equipo</label>
                            <select class="form-select" id="equipoMantencion" name="id_equipo" required>
                                <option value="" selected disabled>Seleccione un equipo</option>
                                <?php while ($equipo = mysqli_fetch_assoc($equipos_disponibles)): ?>
                                    <option value="<?php echo $equipo['id_equipo']; ?>" data-funcionario="<?php echo $equipo['id_funcionario']; ?>">
                                        <?php echo $equipo['id_equipo']; ?> - <?php echo $equipo['tipo']; ?> <?php echo $equipo['marca']; ?> <?php echo $equipo['modelo']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div id="camposPreventiva" class="border rounded-3 p-3 mb-4 bg-white">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <span class="material-symbols-outlined text-primary fs-5">event_available</span>
                        <h4 class="fs-6 fw-bold m-0">Datos preventiva</h4>
                    </div>

                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label for="fechaProxima" class="form-label fw-semibold text-secondary">Fecha proxima mantencion</label>
                            <input type="date" class="form-control" id="fechaProxima" name="fecha_prox_mantencion" required>
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="frecuenciaMantencion" class="form-label fw-semibold text-secondary">Frecuencia mantencion</label>
                            <input type="datetime-local" class="form-control" id="frecuenciaMantencion" name="frecuencia_mantencion" required>
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="descripcionPreventiva" class="form-label fw-semibold text-secondary">Descripcion</label>
                            <textarea class="form-control" id="descripcionPreventiva" name="descripcion_preventiva" rows="3" placeholder="Describe la mantencion preventiva" required></textarea>
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="fechaEntregaPreventiva" class="form-label fw-semibold text-secondary">Fecha de entrega</label>
                            <input type="date" class="form-control" id="fechaEntregaPreventiva" name="fecha_entrega_preventiva" required>
                        </div>
                    </div>
                </div>

                <div id="camposCorrectiva" class="border rounded-3 p-3 mb-4 bg-white d-none">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <span class="material-symbols-outlined text-danger fs-5">construction</span>
                        <h4 class="fs-6 fw-bold m-0">Datos correctiva</h4>
                    </div>

                    <div class="row g-3">
                        <div class="col-12">
                            <label for="tipoFallo" class="form-label fw-semibold text-secondary">Tipo de fallo</label>
                            <input type="text" class="form-control" id="tipoFallo" name="tipo_de_fallo" placeholder="Pantalla sin imagen" required>
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="descripcionCorrectiva" class="form-label fw-semibold text-secondary">Descripcion</label>
                            <textarea class="form-control" id="descripcionCorrectiva" name="descripcion_correctiva" rows="3" placeholder="Describe la mantencion correctiva" required></textarea>
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="fechaEntregaCorrectiva" class="form-label fw-semibold text-secondary">Fecha de entrega</label>
                            <input type="date" class="form-control" id="fechaEntregaCorrectiva" name="fecha_entrega_correctiva" required>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm" style="border-left: 4px solid #05ad98 !important;">
                    <div class="card-body d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 p-3">
                        <div>
                            <p class="fw-bold m-0">Guardar mantencion</p>
                            <p class="text-secondary m-0">Se registrara segun el tipo seleccionado.</p>
                        </div>

                        <div class="d-flex flex-column flex-sm-row gap-2">
                            <a href="index_tecnico.php" class="btn btn-outline-secondary px-4">Cancelar</a>
                            <button type="submit" class="btn button px-4">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
const opcionesTipo = document.querySelectorAll('input[name="tipo_mantencion"]');
const formMantencion = document.getElementById('formMantencion');
const alertaCampos = document.getElementById('alertaCampos');
const camposPreventiva = document.getElementById('camposPreventiva');
const camposCorrectiva = document.getElementById('camposCorrectiva');
const equipoMantencion = document.getElementById('equipoMantencion');
const funcionarioMantencion = document.getElementById('funcionarioMantencion');
const funcionarioPlaceholder = document.getElementById('funcionarioPlaceholder');

function sincronizarFuncionarioEquipo() {
    const equipoSeleccionado = equipoMantencion.options[equipoMantencion.selectedIndex];
    const idFuncionario = equipoSeleccionado ? equipoSeleccionado.dataset.funcionario : '';
    if (!equipoSeleccionado || !equipoSeleccionado.value) {
        funcionarioPlaceholder.textContent = 'Seleccione un equipo primero';
        funcionarioMantencion.value = '';
        return;
    }

    const existeFuncionario = Array.from(funcionarioMantencion.options).some((opcion) => {
        return opcion.value === idFuncionario;
    });

    if (idFuncionario && existeFuncionario) {
        funcionarioPlaceholder.textContent = 'Seleccione un equipo primero';
        funcionarioMantencion.value = idFuncionario;
        return;
    }

    funcionarioPlaceholder.textContent = 'Sin funcionario asignado';
    funcionarioMantencion.value = '';
}

function alternarTipoMantencion() {
    const tipoSeleccionado = document.querySelector('input[name="tipo_mantencion"]:checked').value;
    const esPreventiva = tipoSeleccionado === 'preventiva';

    camposPreventiva.classList.toggle('d-none', !esPreventiva);
    camposCorrectiva.classList.toggle('d-none', esPreventiva);

    camposPreventiva.querySelectorAll('input, select, textarea').forEach((campo) => {
        campo.disabled = !esPreventiva;
    });

    camposCorrectiva.querySelectorAll('input, select, textarea').forEach((campo) => {
        campo.disabled = esPreventiva;
    });
}

opcionesTipo.forEach((opcion) => {
    opcion.addEventListener('change', alternarTipoMantencion);
});

equipoMantencion.addEventListener('change', sincronizarFuncionarioEquipo);

formMantencion.addEventListener('submit', (evento) => {
    if (!formMantencion.checkValidity()) {
        evento.preventDefault();
        alertaCampos.classList.remove('d-none');
        alertaCampos.classList.add('d-flex');
        formMantencion.reportValidity();
        return;
    }

    alertaCampos.classList.add('d-none');
    alertaCampos.classList.remove('d-flex');
});

alternarTipoMantencion();
sincronizarFuncionarioEquipo();
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
