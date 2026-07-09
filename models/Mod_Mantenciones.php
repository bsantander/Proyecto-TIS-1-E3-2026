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
    
    $consulta = '
        SELECT COUNT(*) AS total
        FROM correctiva
        WHERE fecha_entrega > NOW()
    ';

    
    $resultado = mysqli_query($conexion, $consulta);
    
    if ($resultado) {
        $fila = mysqli_fetch_assoc($resultado);
        mysqli_free_result($resultado);

        return (int) $fila['total'];
    } else {
        mysqli_free_result($resultado);

        return 0; 
    }
}

function costoUltimoMes($conexion){
    $consulta = '
    SELECT SUM(costo) AS total
    FROM correctiva
    WHERE YEAR(fecha_entrega) = YEAR(NOW())
        AND MONTH(fecha_entrega) = MONTH(NOW())
    ';
    $resultado = mysqli_query($conexion, $consulta);
    $datos = mysqli_fetch_assoc($resultado);
    mysqli_free_result($resultado);
    return $datos['total'];
}


?>