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
    global $conn;

    try {
        $sql = $conn->prepare("INSERT INTO asignatura VALUES (:nombre)");
        $sql->bindParam(":nombre", $nombre);
        $sql->execute();

        return true;

    }catch(PDOException $e){
        var_dump("Create ERROR: " . $e->getMessage());
        die();
    }

    $conn = null;
}


/**
 * Muesta las asignaturas disponibles en un menú desplegable 
 */
function pintaAsig(){
    global $conn;

    try {
        $sql = $conn->prepare("SELECT asignatura FROM asignatura");
        $sql->execute();

        $datos = $sql->fetchAll();

        foreach($datos as $x){
            echo "<option>".$x[0]."</option>";
        }

    } catch (PDOException $th) {
        var_dump("Read ERROR: " . $th->getMessage());
        die();
    }

    $conn = null;
}


/**
 * CREA ALUMNOS
 */
function crearAlumno($dni, $nombre, $apellidos, $asignatura){
    global $conn;

    try {
        $sql = $conn->prepare("INSERT INTO alumno VALUES (:dni, :nombre, :apellidos)");
        $sql->bindParam(":dni", $dni);
        $sql->bindParam(":nombre", $nombre);
        $sql->bindParam(":apellidos", $apellidos);
        $sql->execute();

        return true;

    } catch (PDOException $th) {
        var_dump("Create ERROR: " . $th->getMessage());
        die();
    }

    crearCurso($dni, $asignatura);
}


/**
 * TABLA RELACIONAL ENTRE ALUMNO Y ASIGNATURA
 */
function crearCurso($dni, $asignatura){
    global $conn;

    try {
        $sql = $conn->prepare("INSERT INTO cursa VALUES (:dni, :asignatura)");
        $sql->bindParam(":dni", $dni);
        $sql->bindParam(":asignatura", $asignatura);
        $sql->execute();

        return true;

    } catch (PDOException $th) {
        var_dump("Create ERROR: " . $th->getMessage());
        die();
    }

    $conn = null;
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
    if (isset($_POST["enviar"])) {
        $opcion = $_POST["enviar"];

        switch ($opcion) {
            case 'input-asig':
                if (isset($_POST["asignatura"])) {
                    crearAsignatura($_POST["asignatura"]);
                }
                break;
            case 'input-alumn':
                $dni = "";
                $nombre = "";
                $apell = "";
                $asig = "";

                if (isset($_POST["dni-alumn"])) {
                    $dni = $_POST["dni-alumn"];

                    if (isset($_POST["nombre-alumn"])) {
                        $nombre = $_POST["nombre-alumn"];

                        if (isset($_POST["apell-alumn"])) {
                            $apell = $_POST["apell-alumn"];

                            if (isset($_POST["asig-alumn"])) { // REVISAR
                                $asig = $_POST["asig-alumn"];
                                
                                crearAlumno($dni, $nombre, $apell, $asig);
                            } 
                        }
                    }
                }

                break;
        }
    }
}

inicio();