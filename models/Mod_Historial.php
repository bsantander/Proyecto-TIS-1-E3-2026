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
            COALESCE(eventos.total_eventos, 0) AS total_eventos
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
        LEFT JOIN (
            SELECT id_equipo, COUNT(*) AS total_eventos
            FROM evento
            GROUP BY id_equipo
        ) eventos ON ve.id_equipo = eventos.id_equipo
        ORDER BY ve.id_equipo ASC, ve.tipo ASC
    ";

    $resultado = mysqli_query($conexion, $sql);
    $filas = [];

    while ($fila = mysqli_fetch_assoc($resultado)) {
        $filas[] = $fila;
    }

    return $filas;
}

function contarEquiposHistorial($conexion) {
    $sql = "SELECT COUNT(*) AS total FROM vista_equipos";
    $resultado = mysqli_query($conexion, $sql);
    $fila = mysqli_fetch_assoc($resultado);

    return (int) $fila['total'];
}

function obtenerEquipoHistorial($conexion, $id_equipo) {
    $id_equipo = (int) $id_equipo;

    $sql = "
        SELECT id_equipo, tipo, marca, modelo
        FROM vista_equipos
        WHERE id_equipo = $id_equipo
        LIMIT 1
    ";

    $resultado = mysqli_query($conexion, $sql);

    return mysqli_fetch_assoc($resultado);
}

function obtenerEventosEquipo($conexion, $id_equipo) {
    $id_equipo = (int) $id_equipo;

    $sql = "
        SELECT
            e.id_evento,
            e.id_equipo,
            e.estado_equipo,
            e.fecha_evento,
            e.tipo_evento,
            e.descripcion,
            e.costo_asociado,
            f.nombre_completo AS funcionario
        FROM evento e
        LEFT JOIN funcionario f ON e.id_funcionario = f.id_funcionario
        WHERE e.id_equipo = $id_equipo
        ORDER BY e.fecha_evento DESC, e.id_evento DESC
    ";

    $resultado = mysqli_query($conexion, $sql);
    $filas = [];

    while ($fila = mysqli_fetch_assoc($resultado)) {
        $filas[] = $fila;
    }

    return $filas;
}
?>
