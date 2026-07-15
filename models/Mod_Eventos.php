<?php

function Registrar_evento_mantencion(
    $conexion,
    $id_equipo,
    $tipo_evento,
    $descripcion,
    $costo_asociado,
    $id_funcionario,
    $id_mantencion,
    $estado_equipo = 'en reparacion'
){
    $tipo_evento = mysqli_real_escape_string($conexion, $tipo_evento);
    $descripcion = mysqli_real_escape_string($conexion, $descripcion);
    $estado_equipo = mysqli_real_escape_string($conexion, $estado_equipo);

    $consulta = "INSERT INTO evento (
                    id_equipo,
                    estado_equipo,
                    fecha_evento,
                    tipo_evento,
                    descripcion,
                    costo_asociado,
                    id_funcionario,
                    id_mantencion
                 ) VALUES (
                    $id_equipo,
                    '$estado_equipo',
                    NOW(),
                    '$tipo_evento',
                    '$descripcion',
                    $costo_asociado,
                    $id_funcionario,
                    $id_mantencion
                 )";

    return mysqli_query($conexion, $consulta);
}

?>