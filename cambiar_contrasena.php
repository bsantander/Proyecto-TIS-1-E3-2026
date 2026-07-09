<?php
require_once __DIR__ . '/includes/auth.php';

if (!estaLogueado()) {
    header('Location: sesion.php');
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nueva = trim($_POST['nueva'] ?? '');

    if ($nueva === '') {
        $error = 'Ingresa una nueva contrasena.';
    } else {
        $id_funcionario = (int) $_SESSION['id_funcionario'];
        $sql = "UPDATE funcionario
                SET contrasena = ?,
                    cambiar_contrasena = 0
                WHERE id_funcionario = ?";
        $conexion->execute_query($sql, [$nueva, $id_funcionario]);
        redirigirPorRol();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar contrasena</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Cambiar contrasena</h2>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <label for="nueva" class="form-label">Nueva contrasena</label>
        <input
            type="password"
            id="nueva"
            name="nueva"
            class="form-control"
            required>

        <button class="btn btn-primary mt-3">
            Guardar
        </button>
    </form>
</body>
</html>
