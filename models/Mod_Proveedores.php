<?php
class Mod_Proveedores {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function agregarProveedor() {
        $Rut_recibido      = trim($_POST['rut_proveedor']);
        $Nombre_recibido   = trim($_POST['nombre_completo']);
        $Contacto_recibido = trim($_POST['contacto']);

        if (!$this->rutValido($Rut_recibido)) {
            return "El RUT del proveedor debe tener entre 8 y 9 digitos.";
        }

        $consulta = "INSERT INTO proveedor (rut_proveedor, nombre_completo, contacto) 
                     VALUES ('$Rut_recibido', '$Nombre_recibido', '$Contacto_recibido')";
        
        mysqli_query($this->conexion, $consulta);
        header("Location: proveedores.php");
    }

    public function editarProveedor() {
        $id                = $_POST['id_proveedor'];
        $Rut_recibido      = trim($_POST['rut_proveedor']);
        $Nombre_recibido   = trim($_POST['nombre_completo']);
        $Contacto_recibido = trim($_POST['contacto']);

        if (!$this->rutValido($Rut_recibido)) {
            return "El RUT del proveedor debe tener entre 8 y 9 digitos.";
        }

        $consulta = "UPDATE proveedor SET rut_proveedor='$Rut_recibido', nombre_completo='$Nombre_recibido', contacto='$Contacto_recibido' 
                     WHERE id_proveedor='$id'";
        
        mysqli_query($this->conexion, $consulta);
        header("Location: proveedores.php");
        exit;
    }

    public function eliminarProveedor($id_proveedor) {
        $consulta = "DELETE FROM proveedor WHERE id_proveedor = '$id_proveedor'";
        mysqli_query($this->conexion, $consulta);   
        header("Location: proveedores.php");
        exit;
    }

    private function rutValido($rut) {
        return preg_match('/^[0-9]{8,9}$/', $rut);
    }
}
?>
