<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../conexion.php';
require_once __DIR__ . '/../models/Mod_Funcionarios.php';

function autenticarUsuario($rut, $contrasena) {
    $mod_funcionarios = new Mod_Funcionarios($conexion);
    return $mod_funcionarios->autenticar($rut, $contrasena);
}

function guardarSesionUsuario($usuario) {
    $_SESSION['id_funcionario'] = $usuario['id_funcionario'];
    $_SESSION['nombre_completo'] = $usuario['nombre_completo'];
    $_SESSION['rol'] = $usuario['rol'];
}

function cerrarSesion() {
    session_destroy();
    $_SESSION = array();
}

function estaLogueado() {
    return !empty($_SESSION['id_funcionario']);
}

function obtenerRol() {
    return strtolower(trim(isset($_SESSION['rol']) ? $_SESSION['rol'] : ''));
}

function requireLogin() {
    if (!estaLogueado()) {
        header('Location: /Proyecto-TIS-1-E3-2026/secion.php');
        exit();
    }
}

function requireRol($roles) {
    requireLogin();
    $rol = obtenerRol();
    if (is_string($roles)) {
        $roles = array($roles);
    }
    $roles = array_map('strtolower', $roles);
    if (!in_array($rol, $roles, true)) {
        header('Location: /Proyecto-TIS-1-E3-2026/secion.php');
        exit();
    }
}

function redirigirPorRol() {
    $rol = obtenerRol();
    if ($rol === 'administrador') {
        header('Location: /Proyecto-TIS-1-E3-2026/Pages_Admin/index_admin.php');
    } elseif ($rol === 'tecnico') {
        header('Location: /Proyecto-TIS-1-E3-2026/Pages_Tecnico/index_tecnico.php');
    } else {
        header('Location: /Proyecto-TIS-1-E3-2026/secion.php');
    }
    exit();
}
