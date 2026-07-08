<?php
class Mod_Proveedores {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function agregarProveedor($rut_proveedor, $nombre_completo, $contacto) {

        if (!$this->rutValido($rut_proveedor)) {
            return "El RUT del proveedor debe tener entre 8 y 9 dígitos.";
        }

        // Verificar RUT repetido
        $sql = "SELECT id_proveedor
                FROM proveedor
                WHERE rut_proveedor = ?";

        $res = $this->conexion->execute_query(
            $sql,
            [$rut_proveedor]
        );

        if($res->num_rows > 0){
            return "Ya existe un proveedor con ese RUT";
        }

        // Insertar proveedor
        $sql = "INSERT INTO proveedor
                (rut_proveedor, nombre_completo, contacto)
                VALUES (?, ?, ?)";

        $this->conexion->execute_query(
            $sql,
            [$rut_proveedor, $nombre_completo, $contacto]
        );

        return "Proveedor registrado correctamente";
    }

    public function editarProveedor($id_proveedor, $rut_proveedor, $nombre_completo, $contacto) {

        if (!$this->rutValido($rut_proveedor)) {
            return "El RUT del proveedor debe tener entre 8 y 9 dígitos.";
        }

        // Verificar RUT repetido
        $sql = "SELECT id_proveedor
                FROM proveedor
                WHERE rut_proveedor = ?
                AND id_proveedor <> ?";

        $res = $this->conexion->execute_query(
            $sql,
            [$rut_proveedor, $id_proveedor]
        );

        if($res->num_rows > 0){
            return "Ya existe otro proveedor con ese RUT";
        }

        // Actualizar proveedor
        $sql = "UPDATE proveedor
                SET rut_proveedor = ?,
                    nombre_completo = ?,
                    contacto = ?
                WHERE id_proveedor = ?";

        $this->conexion->execute_query(
            $sql,
            [$rut_proveedor, $nombre_completo, $contacto, $id_proveedor]
        );

        return "Proveedor actualizado correctamente";
    }

    public function eliminarProveedor($id_proveedor) {

        $sql = "DELETE FROM proveedor
                WHERE id_proveedor = ?";

        $this->conexion->execute_query(
            $sql,
            [$id_proveedor]
        );

        return "Proveedor eliminado correctamente";
    }

    private function rutValido($rut) {
        return preg_match('/^[0-9]{8,9}$/', $rut);
    }
}
?>