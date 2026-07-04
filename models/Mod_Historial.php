<?php
function obtenerHistorialEquipos($conexion, $limite = 15, $offset = 0) {
    $limite = (int) $limite;
    $offset = (int) $offset;

    $sql = "
        SELECT
            ve.id_equipo,
            ve.tipo,
            ve.marca,
            ve.modelo,
            f.nombre_completo AS funcionario,
            r.id_mantencion,
            r.id_evento,
            COALESCE(co.costo, pr.costo, e.costo_asociado, 0) AS costo,
            COALESCE(co.estado, pr.estado, e.estado_equipo, 'Sin estado') AS estado,
            e.fecha_evento,
            e.tipo_evento
        FROM (
            SELECT id_equipo, tipo, marca, modelo
            FROM vista_equipos
            ORDER BY id_equipo, tipo
            LIMIT $limite OFFSET $offset
        ) ve
        LEFT JOIN (
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
            SELECT id_equipo, id_funcionario FROM otro_dispositivo
        ) equipo_funcionario ON ve.id_equipo = equipo_funcionario.id_equipo
        LEFT JOIN funcionario f ON equipo_funcionario.id_funcionario = f.id_funcionario
        LEFT JOIN realiza r ON f.id_funcionario = r.id_funcionario
        LEFT JOIN correctiva co ON r.id_mantencion = co.id_mantencion
        LEFT JOIN preventiva pr ON r.id_mantencion = pr.id_mantencion
        LEFT JOIN evento e ON r.id_evento = e.id_evento
        ORDER BY ve.id_equipo ASC, e.fecha_evento DESC, r.id_mantencion DESC
    ";

    $resultado = mysqli_query($conexion, $sql);

    if (!$resultado) {
        return [
            'error' => mysqli_error($conexion),
            'filas' => []
        ];
    }

    $filas = [];
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $filas[] = $fila;
    }

    return [
        'error' => null,
        'filas' => $filas
    ];
}

function contarEquiposHistorial($conexion) {
    $sql = "SELECT COUNT(*) AS total FROM vista_equipos";
    $resultado = mysqli_query($conexion, $sql);

    if (!$resultado) {
        return 0;
    }

    $fila = mysqli_fetch_assoc($resultado);
    return (int) $fila['total'];
}
?>
