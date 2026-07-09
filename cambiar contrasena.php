<?php

session_start();

require_once "conexion.php";

if(!isset($_SESSION["usuario"])){

    header("Location:secion.php");

    exit();

}

$id=$_SESSION["usuario"]["id_funcionario"];

if($_SERVER["REQUEST_METHOD"]=="POST"){

    $nueva=$_POST["nueva"];

    $sql="UPDATE funcionario

          SET

          contrasena=?,

          cambiar_contrasena=0

          WHERE id_funcionario=?";

    $conexion->execute_query(

        $sql,

        [$nueva,$id]

    );

    header("Location:secion.php");

    exit();

}

?>

<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<title>Cambiar contraseña</title>
<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="manifest" href="/site.webmanifest">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="container-fluid mt-5">

<h2>Cambiar contraseña</h2>

<form method="POST">

<label>Nueva contraseña</label>

<input
type="password"
name="nueva"
class="form-control"
required>

<br>

<button class="btn btn-primary">

Guardar

</button>

</form>

</body>

</html>