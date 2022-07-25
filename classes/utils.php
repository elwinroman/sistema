<?php

class Util {
    /**
     * Elimina multiples espacios a un solo espacio, y elimina espacios de los extremos
     * además convierte a minúsculas
     * @param  String $cadena
     * @return String $nueva_cadena
     */
    public function limpiar_cadena($cadena) {
        $cadena = preg_replace('/\s+/', ' ', $cadena);
        $nueva_cadena = trim(mb_strtolower($cadena));
        return $nueva_cadena;
    }

    /**
     * Elimina multiples espacios a un solo espacio, y elimina espacios de los extremos
     * @param  String $cadena
     * @return String
     */
    public function reduce_multiple_space($cadena) {
        return trim(preg_replace('/[ \r\t]+/', ' ', $cadena));
    }

    /**
     * Convierte a mayúsculas el primer caracter de una cadena, adaptada a UTF-8
     * similar a la funcion de PHP [ucwords] que no reconoce los caracteres especiales
     * @param  String $cadena
     * @return String $nueva_cadena
     */
    public function mb_ucwords($cadena) {
        $nueva_cadena = mb_convert_case($cadena, MB_CASE_TITLE, "UTF-8"); 
        return $nueva_cadena;
    }
    
    /**
     * Limpia la cadena y convierte a mayúsculas el primer caracter de una cadena excepto
     * palabras menores a tres caracteres, simula conectores básicos (y, de, etc.)
     * @param String $cadena
     * @param String $nueva_cadena
     */
    public function output_string($cadena) {
        $nueva_cadena = '';
        $cadena = $this->mb_ucwords($this->limpiar_cadena($cadena));
        $words = explode(' ', $cadena);
        foreach ($words as $word)
		    $nueva_cadena .= (mb_strlen($word) < 3) ? mb_strtolower($word).' ' : $word.' '; 
	    return trim($nueva_cadena);
    }
}
?>