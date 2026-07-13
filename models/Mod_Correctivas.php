<?php

require_once __DIR__ . '/Mod_Eventos.php';

    
function contarCorrectivas($conexion) {
    $sql = "SELECT COUNT(*) as total FROM correctiva";
    $result = mysqli_query($conexion, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}

function Entregar_correctiva($conexion, $id_mantencion){
    $consulta_mantencion = "SELECT id_equipo, id_funcionario FROM correctiva WHERE id_mantencion = $id_mantencion";
    $resultado_mantencion = mysqli_query($conexion, $consulta_mantencion);
    $mantencion = mysqli_fetch_assoc($resultado_mantencion);

    $consulta = "UPDATE correctiva SET estado = 'operativo' WHERE id_mantencion = $id_mantencion";
    mysqli_query($conexion, $consulta);

    Registrar_evento_mantencion(
        $conexion,
        $mantencion['id_equipo'],
        'Mantencion correctiva',
        'Entrega de equipo por mantencion correctiva',
        0,
        $mantencion['id_funcionario'],
        $id_mantencion,
        'activo'
    );
}

function Guardar_correctiva($conexion, $datos){
    $costo = $datos['costo'];
    $id_funcionario = $datos['id_funcionario'];
    $id_equipo = $datos['id_equipo'];
    $tipo_de_fallo = mysqli_real_escape_string($conexion, $datos['tipo_de_fallo']);
    $descripcion = mysqli_real_escape_string($conexion, $datos['descripcion_correctiva']);
    $fecha_entrega = $datos['fecha_entrega_correctiva'];

    mysqli_begin_transaction($conexion);

    $consulta = "INSERT INTO correctiva (costo,estado,tipo_de_fallo,descripcion,
                  id_funcionario,id_equipo,fecha_entrega)
                 VALUES ($costo,'en mantención','$tipo_de_fallo','$descripcion',
                 $id_funcionario,$id_equipo,'$fecha_entrega')";

    mysqli_query($conexion, $consulta);
    $id_mantencion = mysqli_insert_id($conexion);

    Registrar_evento_mantencion($conexion,$id_equipo,'Mantencion correctiva',$descripcion,$costo,$id_funcionario,$id_mantencion);

    mysqli_commit($conexion);
    return 'correctivas.php';
}

?>

