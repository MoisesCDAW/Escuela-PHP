<?php 
include "CRUD.php";

/**
 * Crea los checkbox de cada asignatura
 */
function pintaCheckbox($asigs=null){
    $asigsEdicion = [];

    if ($asigs!=null) { // Guarda los check marcados
        $IDs_existentes = [];
        foreach ($asigs as $value) {
            array_push($IDs_existentes, $value["ID"]);
        }
    }

    $datos = leer(["*"], "asignaturas");
    if ($datos==[]) {
        echo "<br>Sin registros";
    }else{
        for ($i=0; $i<count($datos);$i++) {
            $ID_asig = $datos[$i]["ID"];
            $abrev = $datos[$i]["abreviatura"];

            if ($asigs!=null) {
                if(in_array($ID_asig, $IDs_existentes)){
                    array_push($asigsEdicion, "<input type='checkbox' name='asig-alumn[]' value=$ID_asig checked> ".$abrev);
                }else{
                    array_push($asigsEdicion, "<input type='checkbox' name='asig-alumn[]' value=$ID_asig> ".$abrev);
                }
            }else{
                echo "<input type='checkbox' name='asig-alumn[]' value=$ID_asig> ".$abrev;
                if ($asigs==null) { // Si ese alumno no sale en "cursantes", permite pintar los checkbox
                    array_push($asigsEdicion, "<input type='checkbox' name='asig-alumn[]' value=$ID_asig> ".$abrev);
                }      
            }  
        } 
    }

    return $asigsEdicion;
}


/**
 * Crea el panel de gestión de alumnos
 */
function panelAlumn(){

    $datos = leer(["*"], "alumnos");
    if ($datos!=[]) {
        for ($i=0; $i<count($datos);$i++) {
            $ID = $datos[$i]["ID"];
            $dni = $datos[$i]["dni"];
            $nombre = $datos[$i]["nombre"];
            $apellidos = $datos[$i]["apellidos"];
            $asigs = buscarAsig($ID);
            $aux = "";

            foreach ($asigs as $value) {
                $aux = $aux . " " . $value["abreviatura"];
            }
            
            echo "
            <tr>
                <td>$dni</td>
                <td>$nombre</td>
                <td>$apellidos</td>
                <td>$aux</td>
                <td>
                    <button name='gestion' value='editar-alumn, $ID'>Editar</button>
                    <button name='gestion' value='borrar-alumn, $ID' onclick='return confirm(\"Confirmar borrado\")'>Borrar</button>
                </td>
            </tr>
            
            ";
        } 
    }
}


/**
 * Valida los datos de entrada y crea alumnos
 */
function crearAlumn(){
    $valido = 0;

    if ($_POST["dni-alumn"]!=""){
        $dni = $_POST["dni-alumn"];
        if ($_POST["nombre-alumn"]!=""){
            $nombre = $_POST["nombre-alumn"];
            if ($_POST["apell-alumn"]!=""){
                $apell = $_POST["apell-alumn"];
                if ($_POST["asig-alumn"]!=[]){
                    $asig = $_POST["asig-alumn"];
                    
                    crear("alumnos", ["dni","nombre","apellidos"], [$dni, $nombre, $apell]);
                    $id = buscarAlumno(["ID"],$dni);

                    foreach ($asig as $value) {
                        crear("cursantes", ["ID_alumn", "ID_asig"], [$id["ID"], $value]);
                    }

                    $valido = 1;
                }
            }
        } 
    }

    if (!$valido) {
        $_SESSION["mensaje"] = "<p>No pueden haber campos vacíos</p>";
    }else {
        $_SESSION["mensaje"] = "<p style='color: green;'> ¡Alumn@ cread@!</p>";
    }
    
    header("location: alumn_vista.php");
    die();
}


/**
 * Actualiza las asignaturas de un alumno
 * Se activa cuando se envía el formulario de los checkboxs
 */
function actualizaCheck($ID){
    $valido = 0;

    if ($_POST["asig-alumn"]!=[]) {
        $newChecks = $_POST["asig-alumn"];
        $datosCursante = datosCursante($ID);

        foreach ($datosCursante as $value) {
            $aux = array_search($value["ID_asig"], $newChecks);
            if ($aux!=false) {
                unset($newChecks[$aux]);
                continue;
            }
            borrar("cursantes", [$ID, $value["ID_asig"]], ["ID_alumn", "ID_asig"]);
        }

        foreach ($newChecks as $value) {
            crear("cursantes", ["ID_alumn", "ID_asig"], [$ID, $value]);
        }

        
        $valido = 1;
        
    }

    if (!$valido) {
        $_SESSION["mensaje"] = "No pueden haber campos vacíos";
    }else{
        $_SESSION["mensaje"] = "<p style='color: green;'> ¡Registro actualizado!</p>";
    }

    editarAlumn($ID);
    header("location: ediciones.php");
    die();
}


/**
 * Complemento de la función editarAlumn().
 * Concatena los checkbox marcados o desmarcados al DOM creado por editarAlumn();
 */
function checkEdicion($ID){
    $datos = pintaCheckbox(buscarAsig($ID));

    $str = "
        <hr><p>EDITAR ASIGNATURAS DEL ALUMNO</p>
        Marca o Desmarca las asignaturas:<br><br>
        <form action='alumn_logica.php' method='post'>
    ";

    foreach ($datos as $value) {
        $str = $str . $value;
    }

    $str = $str . "<br><br><button name='gestion' value='actua-asig-alumn, $ID' onclick='return confirm(\"Confirmar actualización\")'>Guardar</button>";
    $str = $str . "</form><br><hr>";

    
    $_SESSION["DOM"] = $_SESSION["DOM"] . $str;
}


/**
 * ACTUALIZAR. Se activa cuándo se envía el formulario de datos de la tabla alumno
 */
function actualizarAlumn($ID){
    $datos = leer(["*"], "alumnos", $ID);
    $dni = $datos[0]["dni"];
    $nombre = $datos[0]["nombre"];
    $apell = $datos[0]["apellidos"];
    $valido = 0;

    if ($_POST["dni-alumn"]!="") {
        $dni = $_POST["dni-alumn"];
        
        if ($_POST["nombre-alumn"]!="") {
            $nombre = $_POST["nombre-alumn"];

            if ($_POST["apell-alumn"]!="") {
                $apell = $_POST["apell-alumn"];

                actualizar("alumnos", ["dni", "nombre", "apellidos"], [$dni, $nombre, $apell], $ID);
    
                $valido = 1;
    
            }
        }
    }  

    if (!$valido) {
        $_SESSION["mensaje"] = "No pueden haber campos vacíos";
    }else{
        $_SESSION["mensaje"] = "<p style='color: green;'> ¡Registro actualizado!</p>";
    }

    editarAlumn($ID);
    header("location: ediciones.php");
    die();
}   


/**
 * EDITAR
 */
function editarAlumn($ID){
    $datos = leer(["*"], "alumnos", $ID);
    $dni = $datos[0]["dni"];
    $nombre = $datos[0]["nombre"];
    $apell = $datos[0]["apellidos"];

    $_SESSION["DOM"] = "
    <p>EDITAR ALUMNO</p>
    <form action='alumn_logica.php' method='post'>
        <input type='text' placeholder='Nuevo DNI' name='dni-alumn' value='$dni'>
        <input type='text' placeholder='Nuevo Nombre' name='nombre-alumn' value='$nombre'>
        <input type='text' placeholder='Nuevo Apellidos' name='apell-alumn' value='$apell'>
        <button name='gestion' value='actua-alumn, $ID' onclick='return confirm(\"Confirmar actualización\")'>Guardar</button>
    </form>
    <br>
    ";

    checkEdicion($ID);

    $_SESSION["volver"] = "
        <br>
        <br>
        <br>
        <form action='alumn_vista.php' method='post'>
            <button>Volver</button>
        </form>
    ";

    header("location: ediciones.php");
    die();
}


/**
 * Confirma el borrado del alumno y luego lo borra o no
 */
function borrarAlumn($ID){

    borrar("alumnos", [$ID]);
    $_SESSION["borrada"] = "<p style='color: red;'>Alumn@ eliminad@</p>";

    header("location: alumn_vista.php");
    die();
}


/**
 * GESTIONA ACCIONES
 */
function gestorAlumn(){

    if (isset($_POST["gestion"])) {
        $gestion = $_POST["gestion"];

        $gestion = explode(",", $gestion);
        $ID = $gestion[1];

        switch ($gestion[0]) {
            case 'crear-alumn':
                crearAlumn();
                break;

            case 'editar-alumn':
                editarAlumn($ID);
                break;
            
            case 'actua-alumn':
                actualizarAlumn($ID);
                break;
            
            case 'borrar-alumn':
                borrarAlumn($ID);
                break;

            case 'actua-asig-alumn':
                actualizaCheck($ID);
                break;
        }
    }
}

gestorAlumn();