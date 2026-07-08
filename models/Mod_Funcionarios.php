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
        $this->conexion->begin_transaction();

        $resultado_insert = $this->conexion->execute_query(
            $sql,
            [$rut, $nombre_completo, $id_equipo, $id_departamento, $rol, $contrasena]
        );

        if (!$resultado_insert) {
            $this->conexion->rollback();
            return "No se pudo registrar el funcionario";
        }

        $id_funcionario = $this->conexion->insert_id;

        if (!empty($id_equipo)) {
            $descripcion = "Equipo asignado al funcionario $id_funcionario";

            if (!$this->insertarEventoEquipo((int) $id_equipo, 'Asignacion a funcionario', $descripcion, $id_funcionario)) {
                $this->conexion->rollback();
                return "No se pudo registrar el evento de asignacion";
            }
        }

        $this->conexion->commit();
        return "Funcionario registrado correctamente"; 
    }

    public function editarFuncionario($id_funcionario, $rut,
    $nombre_completo, $id_equipo, $id_departamento, $rol, $contrasena){
        $sql_actual = "SELECT id_equipo FROM funcionario WHERE id_funcionario = ?";
        $resultado_actual = $this->conexion->execute_query($sql_actual, [$id_funcionario]);
        $funcionario_actual = $resultado_actual ? $resultado_actual->fetch_assoc() : null;
        $id_equipo_anterior = empty($funcionario_actual['id_equipo']) ? null : (int) $funcionario_actual['id_equipo'];
        $id_equipo_nuevo = empty($id_equipo) ? null : (int) $id_equipo;

        $sql = "UPDATE funcionario 
                SET rut = ?,
                nombre_completo = ?,
                id_equipo = ?,
                id_departamento = ?,
                rol = ?,
                contrasena = ?
                WHERE id_funcionario = ?";

        $this->conexion->begin_transaction();

        $resultado_update = $this->conexion->execute_query(
            $sql,
            [$rut, $nombre_completo, $id_equipo, $id_departamento, $rol, $contrasena, $id_funcionario]
        );

        if (!$resultado_update) {
            $this->conexion->rollback();
            return "No se pudo actualizar el funcionario";
        }

        if ($id_equipo_nuevo !== null && $id_equipo_anterior !== $id_equipo_nuevo) {
            $tipo_evento = $id_equipo_anterior === null ? 'Asignacion a funcionario' : 'Reasignacion a funcionario';
            $descripcion = $id_equipo_anterior === null
                ? "Equipo asignado al funcionario $id_funcionario"
                : "Funcionario $id_funcionario reasignado del equipo $id_equipo_anterior al equipo $id_equipo_nuevo";

            if (!$this->insertarEventoEquipo($id_equipo_nuevo, $tipo_evento, $descripcion, $id_funcionario)) {
                $this->conexion->rollback();
                return "No se pudo registrar el evento de asignacion";
            }
        }

        $this->conexion->commit();
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





