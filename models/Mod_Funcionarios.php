<?php
class Mod_Funcionarios {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function autenticar($rut, $contrasena) {
        $sql = "SELECT id_funcionario, nombre_completo, rol FROM funcionario WHERE rut = ? AND contrasena = ?";        
        $resultado = $this->conexion->execute_query($sql, [$rut, $contrasena]);
        return $resultado ? $resultado->fetch_assoc() : null; 
    }
}
?>





