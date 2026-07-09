<?php

function cargarEnv(string $path): bool 
{
    if (!file_exists($path)) {
        return false;
    }

    // Leer el archivo línea por línea, omitiendo líneas vacías
    $lineas = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    foreach ($lineas as $linea) {
        // Ignorar comentarios (líneas que empiezan con #)
        if (strpos(trim($linea), '#') === 0) {
            continue;
        }

        // Dividir la línea en clave y valor por el primer signo '='
        if (strpos($linea, '=') !== false) {
            list($clave, $valor) = explode('=', $linea, 2);
            
            // Limpiar espacios en blanco, comillas simples o dobles alrededor de la clave y el valor
            $clave = trim($clave);
            $valor = trim($valor, " \t\n\r\0\x0B\"'");

            // Definir la variable en el entorno del sistema y superglobales
            putenv("{$clave}={$valor}");
            $_ENV[$clave] = $valor;
            $_SERVER[$clave] = $valor;
        }
    }

    return true;
}

?>