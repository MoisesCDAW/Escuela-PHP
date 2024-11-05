<?php


/**
 * Crea la conexión con las base de datos
 */
function conectar(){
    $user = "moises";
    $password = "123456";

    try {
        $conn = new PDO('mysql:host=localhost;dbname=escuela', $user, $password);
        $conn->setAttribute(PDo::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        var_dump("Connection failed: " . $e->getMessage());
        die();
    }

    return $conn;
}

$conn = conectar();

/**
 * CREA ASIGNATURAS
 */
function crearAsignatura($nombre){
    
}


/**
 * CREA ALUMNOS
 */
function crearAlumno($dni, $nombre, $apellidos, $asignaturas){
    crearCurso($dni, $asignaturas);
}


/**
 * TABLA RELACIONAL ENTRE ALUMNO Y ASIGNATURA
 */
function crearCurso($dni, $asignaturas){

}


/**
 * CREA UNIDADES
 */
function crearUnidad($unidad, $asignaturas){

}


/**
 * CREA ACTIVIDADES
 */
function crearActividad($actividad, $unidad){

}


/**
 * Gestiona los datos que se reciben desde post y determina que acción tomar
 */
function inicio(){
    
}