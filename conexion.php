<?php
$host = "localhost";
$dbname = "bdd_tis"; 
$username = "root";  
$password = "";      

// 1. Creamos la conexión usando MySQLi
$conexion = mysqli_connect($host, $username, $password, $dbname);

// 2. Comprobamos si hubo algún error al conectar
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// 3. Establecemos el formato UTF-8 para que las tildes y las "ñ" se vean correctamente
mysqli_set_charset($conexion, "utf8");
?>