<?php
session_start();

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


    }catch(PDOException $e){
        var_dump("Create ERROR: " . $e->getMessage());
        die();
    }
}


/**
 * Muesta las asignaturas disponibles en un menú desplegable 
 */
function getAsignaturas(){
    global $conn;

    try {
        $sql = $conn->prepare("SELECT asignatura FROM asignatura");
        $sql->execute();

        $datos = $sql->fetchAll();

        $_SESSION["asignaturas"] = $datos;

    } catch (PDOException $th) {
        var_dump("Read ERROR: " . $th->getMessage());
        die();
    }
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


    } catch (PDOException $th) {
        var_dump("Create ERROR: " . $th->getMessage());
        die();
    }
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

        crearCurso($dni, $asignatura);

    } catch (PDOException $th) {
        var_dump("Create ERROR: " . $th->getMessage());
        die();
    }

}


/**
 * CREA UNIDADES
 */
function crearUnidad($unidad, $asignatura){
    global $conn;

    try {
        $sql = $conn->prepare("INSERT INTO unidad VALUES (:unidad, :asignatura)");
        $sql->bindParam(":unidad", $unidad);
        $sql->bindParam(":asignatura", $asignatura);
        $sql->execute();


    } catch (PDOException $th) {
        var_dump("Create ERROR: " . $th->getMessage());
        die();
    }
}


/**
 * CREA ACTIVIDADES
 */
function crearActividad($actividad, $unidad){
    global $conn;

    try {
        $sql = $conn->prepare("INSERT INTO actividad VALUES (:actividad, :unidad)");
        $sql->bindParam(":actividad", $actividad);
        $sql->bindParam(":unidad", $unidad);
        $sql->execute();


    } catch (PDOException $th) {
        var_dump("Create ERROR: " . $th->getMessage());
        die();
    }
}


/**
 * CREA CALIFICACIÓN
 */
function crearCalificacion(){

}



/**
 * Gestiona los datos que se reciben desde post y determina que acción tomar
 */
function inicio(){
    global $conn;
    getAsignaturas(); 

    if (isset($_POST["enviar"])) {
        $opcion = $_POST["enviar"];

        switch ($opcion) {

            // Gestiona creación de asignaturas
            case 'input-asig':
                if (isset($_POST["asignatura"]) && $_POST["asignatura"]!="") {
                    crearAsignatura($_POST["asignatura"]);
                }
                break;

            // Gestiona creación de alumnos
            case 'input-alumn':
                $dni = "";
                $nombre = "";
                $apell = "";
                $asig = "";

                if (isset($_POST["dni-alumn"]) && $_POST["dni-alumn"]!="") {
                    $dni = $_POST["dni-alumn"];

                    if (isset($_POST["nombre-alumn"]) && $_POST["nombre-alumn"]!="") {
                        $nombre = $_POST["nombre-alumn"];

                        if (isset($_POST["apell-alumn"]) && $_POST["apell-alumn"]!="") {
                            $apell = $_POST["apell-alumn"];

                            if (isset($_POST["asig-alumn"]) && $_POST["asig-alumn"]!="") { // REVISAR
                                $asig = $_POST["asig-alumn"];
                                
                                crearAlumno($dni, $nombre, $apell, $asig);
                            } 
                        }
                    }
                }
                break;

            // Gestiona creación de unidades
            case 'input-uni':
                if (isset($_POST["unidad"]) && $_POST["unidad"]!="") {
                    $unidad = $_POST["unidad"];

                    if (isset($_POST["asig-uni"]) && $_POST["asig-uni"]!="") {
                        $asig = $_POST["asig-uni"];

                        crearActividad($unidad, $asig);
                    }
                }
                break;

            // Gestiona creación de actividades
            case 'input-act':
                if (isset($_POST["actividad"]) && $_POST["actividad"]!="") {
                    $act = $_POST["actividad"];

                    if (isset($_POST["unidad-act"]) && $_POST["unidad-act"]!="") {
                        $uni = $_POST["unidad-act"];

                        crearActividad($act, $uni);
                    }
                }
                break;

            // Gestiona creación de calificaciones
            case 'input-cal':

                break;
        }

        $conn = null;
    }
}

inicio();