<?php
    require('../conexion.php');

    $id = $_GET['id'];

    $sql = "SELECT * 
            FROM departamento
            WHERE id_departamento = $id";

    $resultado = mysqli_query($conexion, $sql);

    $departamento = mysqli_fetch_assoc($resultado);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ver Departamento</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-header">
            <h3>Información del Departamento</h3>
        </div>

        <div class="card-body">

            <p>
                <strong>ID:</strong>
                <?php echo $departamento['id_departamento']; ?>
            </p>

            <p>
                <strong>Nombre:</strong>
                <?php echo $departamento['nombre_departamento']; ?>
            </p>

        </div>

    </div>

</div>

</body>
</html>