<?php 

/**
 * Carga automáticamente todos los controladores que existen
 * en la carpeta /controllers/.
 * @param String $nombre_clase     Nombre del archivo de los controladores
 */
function autoload($nombre_clase) {
    $archivo = 'controllers/' . $nombre_clase . '.php';
    if(file_exists($archivo))
        require $archivo;
}

spl_autoload_register('autoload');
?>