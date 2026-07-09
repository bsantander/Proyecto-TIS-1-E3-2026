<?php
require __DIR__ . '/includes/carga_env.php';

cargarEnv(__DIR__ . '/.env');

$host = getenv('DB_HOST');
$dbname = $_ENV['DB_NAME']; 
$username = $_SERVER['DB_USER'] ?? 'root';  
$password = getenv('DB_PASS');      

$conexion = mysqli_connect($host, $username, $password, $dbname);

?>