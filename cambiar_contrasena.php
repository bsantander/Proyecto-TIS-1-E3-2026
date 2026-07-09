<?php

session_start();

require_once "conexion.php";

if(!isset($_SESSION["id_funcionario"])){

    header("Location: /sesion.php");

    exit();

}

$id=$_SESSION["id_funcionario"];

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

    header("Location: /sesion.php");

    exit();

}

?>

<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<title>Cambiar contraseña</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="container mt-5">

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