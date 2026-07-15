<?php

require_once '../models/Mod_Preventivas.php';
require_once '../models/Mod_Correctivas.php';

function consultarCostoCorrectiva($conexion){
    $consulta = "
        SELECT
            SUM(costo) AS total,
            AVG(costo) AS promedio,
            COUNT(*) AS cantidad
        FROM correctiva
    ";

    $resultado = mysqli_query($conexion, $consulta);
    $datos = mysqli_fetch_assoc($resultado);
    mysqli_free_result($resultado);
    return $datos;
}


function consultaTotalMantenciones($conexion){
    
    $consulta = "
        SELECT COUNT(*) AS total FROM (
            SELECT id_mantencion FROM preventiva WHERE estado = 'en mantención'
            UNION ALL
            SELECT id_mantencion FROM correctiva WHERE estado = 'en mantención'
        ) AS en_mantencion
    ";

    
    $resultado = mysqli_query($conexion, $consulta);
    
    if ($resultado) {
        $fila = mysqli_fetch_assoc($resultado);
        mysqli_free_result($resultado);

        return (int) $fila['total'];
    }
    return 0; 
    
}

function costoUltimoMes($conexion){
    $consulta = "
        SELECT SUM(costo) AS total FROM (
            SELECT costo, fecha_entrega FROM preventiva
            UNION ALL
            SELECT costo, fecha_entrega FROM correctiva
        ) AS mantenciones
        WHERE YEAR(fecha_entrega) = YEAR(NOW())
            AND MONTH(fecha_entrega) = MONTH(NOW())
    ";

    $resultado = mysqli_query($conexion, $consulta);
    $datos = mysqli_fetch_assoc($resultado);
    mysqli_free_result($resultado);

    return $datos['total'] ?? 0;
}

?>