<?php

class Util {
    
    /**
     * Función que elimina espacios en blanco entre words dejando one, elimina espacios en blanco
     * de los extremos y convierte a minúsculas
     * @param  string $cadena
     * @return string $nueva_cadena
     */
    public function limpiar_cadena($cadena) {
        $cadena = preg_replace('/\s+/', ' ', $cadena);
        $nueva_cadena = trim(mb_strtolower($cadena));
        return $nueva_cadena;
    }
}
?>