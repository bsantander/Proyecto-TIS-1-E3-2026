<?php
function _obtenerTabla($tipo) {
    $mapa = [
        'Computador' => 'computador', 
        'Proyector' => 'proyector', 
        'Impresora' => 'impresora', 
        'Notebook' => 'notebook', 
        'Servidor' => 'servidor', 
        'Otro Dispositivo' => 'otro_dispositivo'
    ];
    return $mapa[$tipo] ?? null;
}
function obtenerDatosCompletos($conexion, $id, $tipo) {
    $tabla = _obtenerTabla($tipo);
    
    $sql = "SELECT e.*, f.nombre_completo, f.rut, f.rol 
            FROM $tabla e 
            LEFT JOIN funcionario f ON e.id_funcionario = f.id_funcionario 
            WHERE e.id_equipo = $id";
            
    $resultado = mysqli_query($conexion, $sql);
    $row = mysqli_fetch_assoc($resultado);
    
    $funcionario = [
        'Nombre Completo' => $row['nombre_completo']
    ];
    
    $id_funcionario = $row['id_funcionario'];
    
    unset($row['nombre_completo'], $row['rut'], $row['rol']);
    
    return [
        'equipo' => $row,
        'funcionario' => $funcionario,
        'id_funcionario' => $id_funcionario
    ];
}

function obtenerTodosFuncionarios($conexion) {
    $sql = "SELECT id_funcionario, nombre_completo FROM funcionario";
    $resultado = mysqli_query($conexion, $sql);
    $funcionarios = [];
    while ($row = mysqli_fetch_assoc($resultado)) {
        $funcionarios[] = $row;
    }
    return $funcionarios;
}

function actualizarEquipo($conexion, $id, $tipo, $datos) {
    $tabla = _obtenerTabla($tipo);
    
    $set_parts = [];
    foreach ($datos as $columna => $valor) {
        $set_parts[] = "$columna = '" . mysqli_real_escape_string($conexion, $valor) . "'";
    }
    
    $sql = "UPDATE $tabla SET " . implode(', ', $set_parts) . " WHERE id_equipo = $id";
    return mysqli_query($conexion, $sql);
}

function insertarEquipo($conexion, $tipo, $datos) {
    $sql_padre = "INSERT INTO equipo_general (tipo_equipo) VALUES ('$tipo')";
    if (!mysqli_query($conexion, $sql_padre)) {
        return false; 
    }
    
    $nuevo_id = mysqli_insert_id($conexion);
        $datos['id_equipo'] = $nuevo_id;

    $tablas = [
        'Computador' => 'computador', 'Proyector' => 'proyector', 
        'Impresora' => 'impresora', 'Notebook' => 'notebook', 
        'Servidor' => 'servidor', 'Otro Dispositivo' => 'otro_dispositivo'
    ];
    
    $columnas_permitidas = [
        'computador' => ['id_equipo', 'marca','fecha_garantia', 'valor_equipo', 'fecha_compra', 'numero_serie', 'procesador', 'memoria_ram', 'almacenamiento', 'id_funcionario', 'modelo_procesador', 'cantidad_ram', 'cantidad_almacenamiento'],
        'proyector'  => ['id_equipo', 'marca','fecha_garantia', 'valor_equipo', 'fecha_compra', 'numero_serie', 'calidad_imagen', 'modelo', 'id_funcionario'],
        'impresora'  => ['id_equipo', 'marca','fecha_garantia', 'valor_equipo', 'fecha_compra', 'numero_serie', 'volumen_impresion', 'modelo', 'tipo', 'id_funcionario'],
        'notebook'   => ['id_equipo', 'marca','fecha_garantia', 'valor_equipo', 'fecha_compra', 'numero_serie', 'procesador', 'memoria_ram', 'modelo', 'almacenamiento', 'id_funcionario', 'cantidad_ram', 'cantidad_almacenamiento', 'modelo_procesador'],
        'servidor'   => ['id_equipo', 'marca','fecha_garantia', 'valor_equipo', 'fecha_compra', 'numero_serie', 'funcion', 'id_funcionario'],
        'otro_dispositivo' => ['id_equipo', 'marca', 'fecha_garantia', 'valor_equipo', 'fecha_compra', 'numero_serie', 'modelo', 'id_funcionario']
    ];

    $tabla = $tablas[$tipo];
    $permitidas = $columnas_permitidas[$tabla];
    
    $datos_limpios = array_intersect_key($datos, array_flip($permitidas));
    
    $columnas = implode(', ', array_keys($datos_limpios));
    $valores = array_map(function($val) use ($conexion) {
        return "'" . mysqli_real_escape_string($conexion, $val) . "'";
    }, array_values($datos_limpios));
    
    $sql = "INSERT INTO $tabla ($columnas) VALUES (" . implode(', ', $valores) . ")";
    return mysqli_query($conexion, $sql);
}

?>