<?php

/* Iniciar Sesion (dependiendo del rol tiene que llevar a una pagina o otro (por las mantenciones)) */   

class Mod_Funcionarios {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function autenticar($rut, $contrasena) {
        try {
            $sql = "SELECT id_funcionario, nombre_completo, rol FROM funcionario WHERE rut = ? AND contrasena = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([$rut, $contrasena]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception('Error en la base de datos: ' . $e->getMessage());
        }
    }
}

/* Pagina Funcionarios */



