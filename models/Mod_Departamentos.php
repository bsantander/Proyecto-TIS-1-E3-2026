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
    }
}


?>