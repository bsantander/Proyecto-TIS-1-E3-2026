<?php

class Mod_Departamentos{
    
    private $conexion;

    public function __construct($conexion){
        $this->conexion = $conexion;
    }

    //aqui va lo de gestion de departamentos
    public function agregarDepartamento($nombre_departamento){

        $sql = "SELECT * FROM departamento 
                WHERE nombre_departamento = ?"; 
        
        $resultado = $this->conexion->execute_query(
            $sql,
            [$nombre_departamento]
        );
        
        if($resultado->num_rows > 0){
            return "Departamento ya registrado";
        }

        $sql = "INSERT INTO departamento(nombre_departamento)
                VALUES(?)";
        $this->conexion->execute_query(
            $sql,
            [$nombre_departamento]
        );

        return "Departamento registrado correctamente"; 
    }
    
    // editar departamento
    public function editarDepartamento(
        $id_departamento,
        $nombre_departamento
    ){
        $sql = "UPDATE departamento 
                SET nombre_departamento = ?
                WHERE id_departamento = ?";
        $this->conexion->execute_query(
            $sql,
            [$nombre_departamento, $id_departamento]
        );
        return "Departamento actualizado correctamente";

    }

    //eliminar departamento
    public function eliminarDepartamento($id_departamento){

        $sql = "SELECT *
                FROM funcionario
                WHERE id_departamento = ?";

        $resultado = $this->conexion->execute_query(
            $sql,
            [$id_departamento]
        );

        if($resultado->num_rows > 0){
            return "No se puede eliminar el departamento porque tiene funcionarios asociados";
        }

        $sql = "DELETE FROM departamento
                WHERE id_departamento = ?";

        $this->conexion->execute_query(
            $sql,
            [$id_departamento]
        );

    return "Departamento eliminado correctamente";
    }
}


?>