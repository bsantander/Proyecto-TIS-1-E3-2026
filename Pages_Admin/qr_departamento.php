<?php
    require('../conexion.php');

    $id = $_GET['id'];

    $sql = "SELECT * FROM departamento WHERE id_departamento = $id";
    $resultado = mysqli_query($conexion, $sql);

    $departamento = mysqli_fetch_assoc($resultado);

    $contenidoQR =
    "ID: ".$departamento['id_departamento'].
    "\nDepartamento: ".$departamento['nombre_departamento'];

    $qr = "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=".urlencode($contenidoQR);
?>

<!DOCTYPE html>
<html>
<head>
    <title>QR Departamento</title>
</head>
<body>

    <h2>Código QR del Departamento</h2>

    <p>
        <?php echo $departamento['nombre_departamento']; ?>
    </p>

    <img src="<?php echo $qr; ?>">

</body>
</html>