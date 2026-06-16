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

    public function agregarFuncionario($rut, $nombre_completo, $id_equipo, $id_departamento, $rol, $contrasena){

        $sql = "SELECT * FROM funcionario 
                WHERE rut = ?"; 
        
        $resultado = $this->conexion->execute_query(
            $sql,
            [$rut]
        );
        
        if($resultado->num_rows > 0){
            return "Ya existe un funcionario con ese RUT";
        }

        $sql = "INSERT INTO funcionario(rut, nombre_completo, id_equipo, id_departamento, rol, contrasena)
                VALUES(?, ?, ?, ?, ?, ?)";
        $this->conexion->execute_query(
            $sql,
            [$rut, $nombre_completo, $id_equipo, $id_departamento, $rol, $contrasena]
        );

        return "Funcionario registrado correctamente"; 
    }

    public function editarFuncionario($id_funcionario, $rut,
    $nombre_completo, $id_equipo, $id_departamento, $rol, $contrasena){
        $sql = "UPDATE funcionario 
                SET rut = ?,
                nombre_completo = ?,
                id_equipo = ?,
                id_departamento = ?,
                rol = ?,
                contrasena = ?,
                WHERE id_funcionario = ?";
        $this->conexion->execute_query(
            $sql,
            [$rut, $nombre_completo, $id_equipo, $id_departamento, $rol, $contrasena, $id_funcionario]
        );
        return "Funcionario actualizado correctamente";
    }

    public function eliminarFuncionario($id_funcionario){

        $sql = "DELETE FROM funcionario
                WHERE id_funcionario = ?";

        $this->conexion->execute_query(
            $sql,
            [$id_funcionario]
        );

    return "Funcionario eliminado correctamente";
    }
}
?>





