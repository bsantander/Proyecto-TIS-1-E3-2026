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
    
    $sql = "SELECT $tabla.*, 
                   funcionario.nombre_completo AS nombre_funcionario,
                   funcionario.id_funcionario,
                   departamento.nombre_departamento AS nombre_departamento,
                   proveedor.nombre_completo AS nombre_proveedor, 
                   proveedor.contacto AS contacto_proveedor
            FROM $tabla
            LEFT JOIN funcionario ON $tabla.id_funcionario = funcionario.id_funcionario
            LEFT JOIN departamento ON funcionario.id_departamento = departamento.id_departamento
            LEFT JOIN proveedor ON $tabla.id_proveedor = proveedor.id_proveedor
            WHERE $tabla.id_equipo = $id";
            
    $resultado = mysqli_query($conexion, $sql);
    $row = mysqli_fetch_assoc($resultado);
    
    $funcionario = [
        'id_funcionario'      => $row['id_funcionario'],
        'nombre'              => $row['nombre_funcionario'],
        'nombre_departamento' => $row['nombre_departamento']
    ];
    
    $proveedor = [
        'id_proveedor'    => $row['id_proveedor'],
        'nombre_completo' => $row['nombre_proveedor'],
        'contacto'        => $row['contacto_proveedor']
    ];
    
    unset($row['nombre_funcionario'], $row['nombre_proveedor'], $row['contacto_proveedor'], $row['nombre_departamento']);
    
    return [
        'equipo'      => $row,
        'funcionario' => $funcionario,
        'proveedor'   => $proveedor
    ];
}
function obtenerTodosFuncionarios($conexion) {
    $sql = "SELECT funcionario.id_funcionario, funcionario.nombre_completo, departamento.nombre_departamento FROM funcionario 
            LEFT JOIN departamento on funcionario.id_departamento = departamento.id_departamento";
    $resultado = mysqli_query($conexion, $sql);
    $funcionarios = [];
    while ($row = mysqli_fetch_assoc($resultado)) {
        $funcionarios[] = $row;
    }
    return $funcionarios;
}

function obtenerTodosProveedores($conexion) {
    $sql = "SELECT id_proveedor, nombre_completo, contacto FROM proveedor"; 
    $resultado = mysqli_query($conexion, $sql);
    $proveedores = [];
    while ($row = mysqli_fetch_assoc($resultado)) {
        $proveedores[] = $row;
    }
    return $proveedores;
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
        'computador' => ['id_equipo', 'marca','fecha_garantia', 'valor_equipo', 'fecha_compra', 'numero_serie', 'procesador', 'memoria_ram', 'almacenamiento', 'id_funcionario', 'id_proveedor', 'modelo_procesador', 'cantidad_ram', 'cantidad_almacenamiento'],
        'proyector'  => ['id_equipo', 'marca','fecha_garantia', 'valor_equipo', 'fecha_compra', 'numero_serie', 'calidad_imagen', 'modelo', 'id_funcionario', 'id_proveedor'],
        'impresora'  => ['id_equipo', 'marca','fecha_garantia', 'valor_equipo', 'fecha_compra', 'numero_serie', 'volumen_impresion', 'modelo', 'tipo', 'id_funcionario', 'id_proveedor'],
        'notebook'   => ['id_equipo', 'marca','fecha_garantia', 'valor_equipo', 'fecha_compra', 'numero_serie', 'procesador', 'memoria_ram', 'modelo', 'almacenamiento', 'id_funcionario', 'id_proveedor', 'cantidad_ram', 'cantidad_almacenamiento', 'modelo_procesador'],
        'servidor'   => ['id_equipo', 'marca','fecha_garantia', 'valor_equipo', 'fecha_compra', 'numero_serie', 'funcion', 'id_funcionario', 'id_proveedor'],
        'otro_dispositivo' => ['id_equipo', 'marca', 'fecha_garantia', 'valor_equipo', 'fecha_compra', 'numero_serie', 'modelo', 'id_funcionario', 'id_proveedor']
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