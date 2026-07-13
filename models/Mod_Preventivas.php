<?php

require_once __DIR__ . '/Mod_Eventos.php';

function contarPreventivas($conexion) {
    $sql = "SELECT COUNT(*) as total FROM preventiva";
    $result = mysqli_query($conexion, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}

function Entregar_preventiva($conexion, $id_mantencion){
    $consulta_mantencion = "SELECT id_equipo, id_funcionario FROM preventiva WHERE id_mantencion = $id_mantencion";
    $resultado_mantencion = mysqli_query($conexion, $consulta_mantencion);
    $mantencion = mysqli_fetch_assoc($resultado_mantencion);

    $consulta = "UPDATE preventiva SET estado = 'operativo' WHERE id_mantencion = $id_mantencion";
    mysqli_query($conexion, $consulta);

    Registrar_evento_mantencion(
        $conexion,
        $mantencion['id_equipo'],
        'Mantencion preventiva',
        'Entrega de equipo por mantencion preventiva',
        0,
        $mantencion['id_funcionario'],
        $id_mantencion,
        'activo'
    );
}

function Guardar_preventiva($conexion, $datos){
    $costo = $datos['costo'];
    $id_funcionario = $datos['id_funcionario'];
    $id_equipo = $datos['id_equipo'];
    $fecha_prox_mantencion = $datos['fecha_prox_mantencion'];
    $frecuencia_mantencion = str_replace('T', ' ', $datos['frecuencia_mantencion']);
    $descripcion = mysqli_real_escape_string($conexion, $datos['descripcion_preventiva']);
    $fecha_entrega = $datos['fecha_entrega_preventiva'];

    mysqli_begin_transaction($conexion);

    $consulta = "INSERT INTO preventiva (costo,estado,fecha_prox_mantencion,
                frecuencia_mantencion,id_funcionario,descripcion,id_equipo,fecha_entrega)
                 VALUES ($costo,'en mantención','$fecha_prox_mantencion',
                '$frecuencia_mantencion',$id_funcionario,'$descripcion',$id_equipo,'$fecha_entrega')";

    mysqli_query($conexion, $consulta);
    $id_mantencion = mysqli_insert_id($conexion);

    Registrar_evento_mantencion($conexion,$id_equipo,'Mantencion preventiva',$descripcion,$costo,$id_funcionario,$id_mantencion);

    mysqli_commit($conexion);
    return 'preventivas.php';
}
?>
