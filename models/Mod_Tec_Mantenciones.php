<?php
require_once '../models/Mod_Preventivas.php';
require_once '../models/Mod_Correctivas.php';

function Consultar_equipos($conexion){
    $consulta = "SELECT ve.id_equipo,ve.tipo,ve.marca,ve.modelo,equipo_funcionario.id_funcionario
                 FROM vista_equipos ve LEFT JOIN (
                 SELECT id_equipo, id_funcionario FROM computador
                 UNION ALL
                 SELECT id_equipo, id_funcionario FROM notebook
                 UNION ALL
                 SELECT id_equipo, id_funcionario FROM proyector
                 UNION ALL
                 SELECT id_equipo, id_funcionario FROM impresora
                 UNION ALL
                 SELECT id_equipo, id_funcionario FROM servidor
                 UNION ALL
                 SELECT id_equipo, id_funcionario FROM otro_dispositivo)
                equipo_funcionario ON ve.id_equipo = equipo_funcionario.id_equipo
                LEFT JOIN (
                    SELECT e.id_equipo, e.estado_equipo
                    FROM evento e
                    INNER JOIN (
                        SELECT id_equipo, MAX(id_evento) AS ultimo_evento
                        FROM evento
                        GROUP BY id_equipo
                    ) ultimo ON e.id_equipo = ultimo.id_equipo AND e.id_evento = ultimo.ultimo_evento
                ) ultimo_estado ON ve.id_equipo = ultimo_estado.id_equipo
                WHERE COALESCE(ultimo_estado.estado_equipo, 'activo') = 'activo'
                ORDER BY ve.id_equipo, ve.tipo";

    $resultado = mysqli_query($conexion, $consulta);
    return $resultado;
}

function Consultar_funcionarios($conexion){
    $consulta = "SELECT id_funcionario, nombre_completo FROM funcionario ORDER BY id_funcionario";
    $resultado = mysqli_query($conexion, $consulta);
    return $resultado;
}

function Registrar_evento_mantencion($conexion, $id_equipo, $tipo_evento, $descripcion, $costo, $id_funcionario, $id_mantencion, $estado_equipo = 'en reparacion'){
    $consulta_evento = "INSERT INTO evento (id_equipo,estado_equipo,fecha_evento,tipo_evento,
                        descripcion,costo_asociado,id_funcionario,id_mantencion)
                        VALUES ($id_equipo,'$estado_equipo',NOW(),'$tipo_evento','$descripcion',
                        $costo,$id_funcionario,$id_mantencion)";

    mysqli_query($conexion, $consulta_evento);
    $id_evento = mysqli_insert_id($conexion);

    $consulta_realiza = "INSERT INTO realiza (id_funcionario,id_mantencion,id_evento) 
                         VALUES ($id_funcionario,$id_mantencion,$id_evento)";

    mysqli_query($conexion, $consulta_realiza);
}

function Guardar_mantencion($conexion, $datos){
    if ($datos['tipo_mantencion'] === 'preventiva') {
        return Guardar_preventiva($conexion, $datos);
    }
    return Guardar_correctiva($conexion, $datos);
}
?>
