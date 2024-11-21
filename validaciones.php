<?php 

/**
 * Usada para sanear los datos ingresados por el usuario
 */
function validarDato($dato){
    $dato = trim($dato);
    $dato = stripcslashes($dato);
    $dato = htmlspecialchars($dato);
    return $dato;
}

/**
 * Capitaliza el string que se le pasa como parámetro
 */
function toCapitalize($string){
    $letras = ['Á'=>'á', 'É'=>'é', 'Í'=>'í', 'Ó'=>'ó', 'Ú'=>'ú'];
    $string = mb_strtolower(strtr($string, $letras));
    $primera = mb_substr($string, 0, 1);
    $primera = mb_strtoupper($primera);

    return $primera.mb_substr($string, 1);
}


/**
 * Para validad un DNI de un alumno
 */
function validarDNI($dni) {

    // Verificar el formato: 8 dígitos seguidos de una letra
    if (!preg_match('/^\d{8}[A-Z]$/', $dni)) {
        return false;
    }

    // Separar el número y la letra
    $numero = substr($dni, 0, 8);
    $letra = substr($dni, -1);

    // Letras válidas según el cálculo del módulo 23
    $letrasValidas = "TRWAGMYFPDXBNJZSQVHLCKE";

    // Calcular la letra correspondiente
    $letraCalculada = $letrasValidas[$numero % 23];

    // Comprobar si la letra es correcta
    if($letra === $letraCalculada){
        return $dni;
    }else {
        return false;
    }
}


/**
 * Valida nombre y apellidos del alumno. Permite espacios entre nombres
 */
function validarNomApell($dato){
    if (!preg_match("/^[a-zA-ZñáéíóúÑÁÉÍÓÚ]{2,14}( [a-zA-Z][a-zA-ZñáéíóúÑÁÉÍÓÚ]{2,14})?$/", $dato)) {
        return false;
    }else {
        $aux = explode(" ", $dato);
        for ($i=0; $i < count($aux); $i++) { 
            $aux[$i] = toCapitalize($aux[$i]);
        }
        $dato = implode(" ", $aux);
        return $dato;
    }
}


/**
 * Valida la abreviatura de una asignatura
 */
function validarAbrevAsig($dato){
    if (!preg_match("/^[a-zA-Z]{3}$/", $dato)) {
        return false;
    }else {
        return $dato;
    }
}


/**
 * Valida la abreviatura de una asignatura
 */
function validarNomvAsig($dato){
    if (!preg_match("/^([a-zA-Z][a-zA-ZñáéíóúÑÁÉÍÓÚ]{3, 50}([\s])?)+$/", $dato)) {
        return false;
    }else {
        $aux = explode(" ", $dato);
        for ($i=0; $i < count($aux); $i++) { 
            $aux[$i] = toCapitalize($aux[$i]);
        }
        $dato = implode(" ", $aux);
        return $dato;
    }
}
