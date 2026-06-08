<?php
session_start();
require_once 'conexion.php';
require_once 'models/Mod_Funcionarios.php';

if (isset($_GET['logout'])) {
    session_destroy();
    $_SESSION = array();
}

if (isset($_SESSION['id_funcionario'])) {
    header('Location: index.php');
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rut = trim($_POST['rut'] ?? '');
    $contrasena = trim($_POST['contrasena'] ?? '');

    if (empty($rut) || empty($contrasena)) {
        $error = 'Por favor completa todos los campos.';
    } else {
        try {
            $mod_funcionarios = new Mod_Funcionarios($conexion);
            $usuario = $mod_funcionarios->autenticar($rut, $contrasena);

            if ($usuario) {
                $_SESSION['id_funcionario'] = $usuario['id_funcionario'];
                $_SESSION['nombre_completo'] = $usuario['nombre_completo'];
                $_SESSION['rol'] = $usuario['rol'];
                header('Location: index.php');
                exit();
            } else {
                $error = 'RUT o contraseña incorrectos.';
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio_Sesion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="assets/style.css">
    <script src="assets/script.js" defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body class="d-flex align-items-center justify-content-center py-5">
    <div class="container">
        <div class="row gx-4 gy-4 justify-content-center mt-5">
            <div class="col-12 col-lg-5">
                <div class="h-100 p-5">
                    <div class="d-flex flex-row align-items-center gap-0 mb-3">
                        <p class="fs-2 m-0 fw-bold" style="color: #05ad98;">Nodo</p>
                        <p class="fs-2 m-0 text-black fw-bold">Active</p>
                    </div>
                    <h1 class="h3 mt-4">Conéctate con tu cuenta</h1>
                    <p class="text-secondary">Accede a tu panel de control para revisar equipos, funcionarios y mantenciones de forma rápida.</p>
                </div>
            </div>
            <div class="col-12 col-lg-5">
                <div class="card inicio_secion bg-white h-100 p-4">
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo htmlspecialchars($error); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <form method="POST" action="">
                        <div class="mb-4">
                            <label for="rut" class="form-label fw-semibold">RUT</label>
                            <input type="text" id="rut" name="rut" class="form-control campos_inicio_secion" placeholder="12345678" required>
                        </div>
                        <div class="mb-4">
                            <label for="contrasena" class="form-label fw-semibold">Contraseña</label>
                            <input type="password" id="contrasena" name="contrasena" class="form-control campos_inicio_secion" placeholder="Contraseña123" required>
                        </div>
                        <button type="submit" class="btn button btn-lg w-100 mb-3">Iniciar sesión</button>
                    </form>
                    <div class="d-flex justify-content-between small">
                        <a href="#" class="link-success fw-semibold">¿Olvidaste la contraseña?</a>
                        <a href="index.php" class="link-success fw-semibold">Volver</a>
                    </div>
                    <p class="text-muted text-center mt-4">Ingresa tu RUT y contraseña para continuar.</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

