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

function _insertarEventoEquipo($conexion, $id_equipo, $tipo_evento, $descripcion, $id_funcionario = null, $estado_equipo = 'activo', $costo_asociado = 0, $id_mantencion = null) {
    $id_equipo = (int) $id_equipo;
    $tipo_evento = mysqli_real_escape_string($conexion, $tipo_evento);
    $descripcion = mysqli_real_escape_string($conexion, $descripcion);
    $estado_equipo = mysqli_real_escape_string($conexion, $estado_equipo);
    $costo_asociado = (float) $costo_asociado;
    $id_funcionario_sql = $id_funcionario === null ? 'NULL' : (int) $id_funcionario;
    $id_mantencion_sql = $id_mantencion === null ? 'NULL' : (int) $id_mantencion;

    $sql_evento = "INSERT INTO evento (
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
        $id_funcionario_sql,
        $id_mantencion_sql
    )";

    return mysqli_query($conexion, $sql_evento);
}

function obtenerEstadoActualEquipo($conexion, $id_equipo) {
    $id_equipo = (int) $id_equipo;
    $sql = "SELECT estado_equipo FROM evento WHERE id_equipo = $id_equipo ORDER BY fecha_evento DESC, id_evento DESC LIMIT 1";
    $resultado = mysqli_query($conexion, $sql);

    if (!$resultado || mysqli_num_rows($resultado) === 0) {
        return 'activo';
    }

    $fila = mysqli_fetch_assoc($resultado);
    return $fila['estado_equipo'] ?: 'activo';
}

function darDeBajaEquipo($conexion, $id, $tipo) {
    $tabla = _obtenerTabla($tipo);
    if (!$tabla) {
        return false;
    }

    $id = (int) $id;
    $resultado = mysqli_query($conexion, "SELECT id_funcionario FROM $tabla WHERE id_equipo = $id");
    $fila = mysqli_fetch_assoc($resultado);
    $id_funcionario = empty($fila['id_funcionario']) ? null : (int) $fila['id_funcionario'];

    return _insertarEventoEquipo(
        $conexion,
        $id,
        'Dado de baja',
        "Equipo $id dado de baja",
        $id_funcionario,
        'dado de baja'
    );
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
    if (!$tabla) {
        return false;
    }

    $id = (int) $id;
    $cambia_funcionario = array_key_exists('id_funcionario', $datos);
    $funcionario_anterior = null;
    $funcionario_nuevo = null;

    if ($cambia_funcionario) {
        $sql_funcionario_actual = "SELECT id_funcionario FROM $tabla WHERE id_equipo = $id";
        $resultado_funcionario_actual = mysqli_query($conexion, $sql_funcionario_actual);

        if (!$resultado_funcionario_actual) {
            return false;
        }

        $fila_funcionario_actual = mysqli_fetch_assoc($resultado_funcionario_actual);
        $funcionario_anterior = empty($fila_funcionario_actual['id_funcionario']) ? null : (int) $fila_funcionario_actual['id_funcionario'];
        $funcionario_nuevo = $datos['id_funcionario'] === '' ? null : (int) $datos['id_funcionario'];
    }
    
    $set_parts = [];
    foreach ($datos as $columna => $valor) {
        if (in_array($columna, ['id_funcionario', 'id_proveedor'], true) && $valor === '') {
            $set_parts[] = "$columna = NULL";
            continue;
        }

        $set_parts[] = "$columna = '" . mysqli_real_escape_string($conexion, $valor) . "'";
    }
    
    $sql = "UPDATE $tabla SET " . implode(', ', $set_parts) . " WHERE id_equipo = $id";
    mysqli_begin_transaction($conexion);

    if (!mysqli_query($conexion, $sql)) {
        mysqli_rollback($conexion);
        return false;
    }

    if ($cambia_funcionario && $funcionario_nuevo !== null && $funcionario_anterior !== $funcionario_nuevo) {
        $tipo_evento = $funcionario_anterior === null ? 'Asignacion a funcionario' : 'Reasignacion a funcionario';
        $descripcion_evento = $funcionario_anterior === null
            ? "Equipo asignado al funcionario $funcionario_nuevo"
            : "Equipo reasignado del funcionario $funcionario_anterior al funcionario $funcionario_nuevo";

        if (!_insertarEventoEquipo($conexion, $id, $tipo_evento, $descripcion_evento, $funcionario_nuevo)) {
            mysqli_rollback($conexion);
            return false;
        }
    }

    mysqli_commit($conexion);
    return true;
}

function insertarEquipo($conexion, $tipo, $datos) {
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

    if (!isset($tablas[$tipo])) {
        return false;
    }

    mysqli_begin_transaction($conexion);

    $tipo_limpio = mysqli_real_escape_string($conexion, $tipo);
    $sql_padre = "INSERT INTO equipo_general (tipo_equipo) VALUES ('$tipo_limpio')";
    if (!mysqli_query($conexion, $sql_padre)) {
        mysqli_rollback($conexion);
        return false; 
    }
    
    $nuevo_id = mysqli_insert_id($conexion);
    $datos['id_equipo'] = $nuevo_id;

    $tabla = $tablas[$tipo];
    $permitidas = $columnas_permitidas[$tabla];
    
    $datos_limpios = array_intersect_key($datos, array_flip($permitidas));
    
    $columnas = implode(', ', array_keys($datos_limpios));
    $valores = array_map(function($val) use ($conexion) {
        return "'" . mysqli_real_escape_string($conexion, $val) . "'";
    }, array_values($datos_limpios));
    
    $sql = "INSERT INTO $tabla ($columnas) VALUES (" . implode(', ', $valores) . ")";
    if (!mysqli_query($conexion, $sql)) {
        mysqli_rollback($conexion);
        return false;
    }

    $id_funcionario = isset($datos['id_funcionario']) && $datos['id_funcionario'] !== ''
        ? (int) $datos['id_funcionario']
        : null;

    if (!_insertarEventoEquipo($conexion, $nuevo_id, 'Ingreso Equipo', "Ingreso de equipo $tipo al inventario", $id_funcionario)) {
        mysqli_rollback($conexion);
        return false;
    }

    mysqli_commit($conexion);
    return true;
}

function contarEquipos($conexion){
    $sql = "SELECT COUNT(*) as total FROM equipo_general";
    $resultado = mysqli_query($conexion, $sql);
    $fila = mysqli_fetch_assoc($resultado);
    return $fila['total'];
}

?>
