<?php
class Mod_Proveedores {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function agregarProveedor() {
        $Rut_recibido      = $_POST['rut_proveedor'];
        $Nombre_recibido   = $_POST['nombre_completo'];
        $Contacto_recibido = $_POST['contacto'];

        $consulta = "INSERT INTO proveedor (rut_proveedor, nombre_completo, contacto) 
                     VALUES ('$Rut_recibido', '$Nombre_recibido', '$Contacto_recibido')";
        
        mysqli_query($this->conexion, $consulta);
        header("Location: proveedores.php");
        exit;
    }

    public function editarProveedor() {
        $id                = $_POST['id_proveedor'];
        $Rut_recibido      = $_POST['rut_proveedor'];
        $Nombre_recibido   = $_POST['nombre_completo'];
        $Contacto_recibido = $_POST['contacto'];

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
}
?>