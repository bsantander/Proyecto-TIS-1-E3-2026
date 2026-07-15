<?php
require_once __DIR__ . '/includes/carga_env.php';

cargarEnv(__DIR__ . '/.env');

$host = getenv('DB_HOST');
$dbname = getenv('DB_NAME'); 
$username = getenv('DB_USER'); 
$password = getenv('DB_PASS');
$port = getenv('DB_PORT');    

$conexion = mysqli_connect($host, $username, $password, $dbname, $port);

?>