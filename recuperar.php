<?php
require_once "conexion.php";

$mensaje="";
$error="";

if($_SERVER["REQUEST_METHOD"]=="POST"){

    $rut=trim($_POST["rut"]);

    $sql="SELECT * FROM funcionario WHERE rut=?";

    $resultado=$conexion->execute_query($sql,[$rut]);

    if($resultado->num_rows>0){

        // obtener solo números
        $soloNumeros=preg_replace('/[^0-9]/','',$rut);

        // últimos cuatro
        $provisoria=substr($soloNumeros,-4);

        $sql="UPDATE funcionario
              SET contrasena=?,
                  cambiar_contrasena=1
              WHERE rut=?";

        $conexion->execute_query($sql,[$provisoria,$rut]);

        $mensaje="Su contraseña provisoria es: ".$provisoria;

    }else{

        $error="El RUT no existe.";

    }

}

?>

<!DOCTYPE html>

<html lang="es">

<head>

<meta charset="UTF-8">

<title>Recuperar contraseña</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="container mt-5">

<h2>Recuperar contraseña</h2>

<form method="POST">

<label>RUT</label>

<input
type="text"
name="rut"
class="form-control"
required>

<br>

<button
class="btn btn-success">

Generar contraseña

</button>

</form>

<br>

<?php

if($mensaje!=""){
    echo "<div class='alert alert-success'>$mensaje</div>";
    echo '<a href="index.php" class="btn btn-primary">Volver al inicio de sesión</a>';
}

if($error!=""){
    echo "<div class='alert alert-danger'>$error</div>";
    echo '<a href="index.php" class="btn btn-secondary">Volver al inicio de sesión</a>';
}

?>

</body>

</html>