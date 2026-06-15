<?php
require('../conexion.php');

$id = (int)$_GET['id'];

$sql = "SELECT * FROM departamento WHERE id_departamento = $id";
$resultado = mysqli_query($conexion, $sql);

$departamento = mysqli_fetch_assoc($resultado);

$contenidoQR =
"ID: ".$departamento['id_departamento'].
"\nDepartamento: ".$departamento['nombre_departamento'];

$qr = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data="
      . urlencode($contenidoQR);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>QR Departamento</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style.css">
</head>

<body style="background-color:#F4F6F8;">

<div class="container py-5">

    <div class="card shadow-sm border-0 mx-auto"
         style="max-width:600px; border-top:4px solid #05ad98;">

        <div class="card-body text-center">

            <h2 class="fw-bold mb-4">
                Código QR del Departamento
            </h2>

            <h4 class="mb-1">
                <?php echo $departamento['nombre_departamento']; ?>
            </h4>

            <p class="text-muted">
                ID: <?php echo $departamento['id_departamento']; ?>
            </p>

            <div class="bg-white p-3 rounded border d-inline-block">
                <img
                    src="<?php echo $qr; ?>"
                    alt="Código QR"
                    style="width:300px;height:300px;">
            </div>

            <div class="mt-4">
                <a href="departamentos.php" class="btn button">
                    Volver a Departamentos
                </a>
            </div>

        </div>

    </div>

</div>

</body>
</html>