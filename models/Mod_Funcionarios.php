<?php
class Mod_Funcionarios {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    private function insertarEventoEquipo($id_equipo, $tipo_evento, $descripcion, $id_funcionario) {
        if (empty($id_equipo)) {
            return true;
        }

        $resultado_evento = $this->conexion->query("SELECT COALESCE(MAX(id_evento), 0) + 1 AS nuevo_id FROM evento");
        if (!$resultado_evento) {
            return false;
        }

        $fila_evento = $resultado_evento->fetch_assoc();
        $nuevo_id_evento = (int) $fila_evento['nuevo_id'];

        $sql = "INSERT INTO evento (
            id_evento,
            id_equipo,
            estado_equipo,
            fecha_evento,
            tipo_evento,
            descripcion,
            costo_asociado,
            id_funcionario,
            id_mantencion
        ) VALUES (?, ?, 'activo', NOW(), ?, ?, 0, ?, NULL)";

        return (bool) $this->conexion->execute_query(
            $sql,
            [$nuevo_id_evento, $id_equipo, $tipo_evento, $descripcion, $id_funcionario]
        );
    }

    public function autenticar($rut, $contrasena) {
        $sql = "SELECT id_funcionario, nombre_completo, rol FROM funcionario WHERE rut = ? AND contrasena = ?";        
        $resultado = $this->conexion->execute_query($sql, [$rut, $contrasena]);
        return $resultado ? $resultado->fetch_assoc() : null; 
    }

    public function agregarFuncionario($rut, $nombre_completo, $id_equipo, $id_departamento, $rol){

        $sql = "SELECT * FROM funcionario 
                WHERE rut = ?"; 
        
        $resultado = $this->conexion->execute_query(
            $sql,
            [$rut]
        );
        
        if($resultado->num_rows > 0){
            return "Ya existe un funcionario con ese RUT";
        }

        $sql = "INSERT INTO funcionario(rut, nombre_completo, id_equipo, id_departamento, rol
                VALUES(?, ?, ?, ?, ?)";
        $this->conexion->execute_query(
            $sql,
            [$rut, $nombre_completo, $id_equipo, $id_departamento, $rol]
        );

        return "Funcionario registrado correctamente"; 
    }

    public function editarFuncionario(
    $id_funcionario,
    $rut,
    $nombre_completo,
    $id_equipo,
    $id_departamento,
    $rol
    ){

    // Verificar que no exista otro funcionario con el mismo RUT
        $sql = "SELECT id_funcionario
                FROM funcionario
                WHERE rut = ?
                AND id_funcionario <> ?";

        $res = $this->conexion->execute_query(
            $sql,
            [$rut, $id_funcionario]
        );

        if($res->num_rows > 0){
            return "Ya existe otro funcionario con ese RUT";
        }

        // Actualizar datos
        $sql = "UPDATE funcionario
                SET rut = ?,
                    nombre_completo = ?,
                    id_equipo = ?,
                    id_departamento = ?,
                    rol = ?
                WHERE id_funcionario = ?";

        $this->conexion->execute_query(
            $sql,
            [
                $rut,
                $nombre_completo,
                $id_equipo,
                $id_departamento,
                $rol,
                $id_funcionario
            ]
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


function contarFuncionarios($conexion){
    $sql = "SELECT COUNT(*) as total FROM funcionario";
    $resultado = mysqli_query($conexion, $sql);
    $fila = mysqli_fetch_assoc($resultado);
    return $fila['total'];
}

?>





