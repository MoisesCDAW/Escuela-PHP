<?php 
include "CRUD.php";

/**
 * Crea los radio de cada asignatura
 */
function pintaRadio($unid=null){
    $unidsEdicion = [];

    $datos = leer(["*"], "unidades");

    if ($datos==[]) {
        echo "<br>Sin registros";
    }else{
        for ($i=0; $i<count($datos);$i++) {
            $ID_uni = $datos[$i]["ID"];
            $numero = $datos[$i]["numero"];

            if ($unid!=null) {
                if($ID_uni == $unid){
                    array_push($unidsEdicion, "<input type='radio' name='unid-act' value=$ID_uni checked> U.".$numero);
                }else{
                    array_push($unidsEdicion, "<input type='radio' name='unid-act' value=$ID_uni> U.".$numero);
                }
            }else{
                echo "<input type='radio' name='unid-act' value=$ID_uni> U.".$numero;      
            }  
        } 
    }

    return $unidsEdicion;
}


/**
 * Crea el panel de gestión en la página de vista_act.php
 */
function panelAct(){
    $datos = leer(["*"], "actividades");

    if ($datos!=[]) {
        for ($i=0; $i<count($datos);$i++) {
            $ID = $datos[$i]["ID"];
            $numero = $datos[$i]["numero"];
            $nombre = $datos[$i]["nombre"];
            $unidad = $datos[$i]["ID_unid"];
            
            $numUnid = leer(["numero"], "unidades", "ID", $unidad);
            $numUnid = $numUnid[0]["numero"];

            $nomUnid = leer(["nombre"], "unidades", "ID", $unidad);
            $nomUnid = $nomUnid[0]["nombre"];

            echo "
            <tr>
                <td>$numero</td>
                <td>$nombre</td>
                <td>$numUnid</td>
                <td>$nomUnid</td>
                <td>
                    <button name='gestion' value='editar-act, $ID'>Editar</button>
                    <button name='gestion' value='borrar-act, $ID' onclick='return confirm(\"Confirmar borrado\")'>Borrar</button>
                </td>
            </tr>
            ";
        } 
    }
}


/**
 * Valida los datos de entrada y crea asignaturas
 */
function crearAct(){
    $valido = 0;

    if ($_POST["numero"]!=""){
        $numero = $_POST["numero"];

        if ($_POST["nombre"]!="") {
            $nombre = $_POST["nombre"];

            if ($_POST["unid-act"]!="") {
                $unid = $_POST["unid-act"];

                crear("actividades",["ID_unid", "numero","nombre"],[$unid, $numero, $nombre]);

                $valido = 1;
            }
        }
    }

    if (!$valido) {
        $_SESSION["mensaje"] = "<p>No pueden haber campos vacíos</p>";
    }else {
        $_SESSION["mensaje"] = "<p style='color: green;'> ¡Actividad creada!</p>";
    }

    header("location: vista_act.php");
    die();    
}

/**
 * Actualiza las unidades de una actividad
 * Se activa cuando se envía el formulario de los radios
 */
function actualizaRadio($ID){
    $valido = 1; // Cambiar a 0 para aplicar validaciones

    $newRadio = $_POST["unid-act"];
    actualizar("actividades", ["ID_unid"], [$newRadio], $ID);

    // $valido = 1;

    if (!$valido) {
        // $_SESSION["mensaje"] = "No pueden haber campos vacíos";
    }else{
        $_SESSION["mensaje"] = "<p style='color: green;'> ¡Registro actualizado!</p>";
    }

    editarAct($ID);
    header("location: ediciones.php");
    die();
}


/**
 * Complemento de la función editarAct().
 * Concatena los checkbox marcados o desmarcados al DOM creado por editarAct();
 */
function radioEdicion($ID){
    $ID_uni = leer(["ID_unid"], "actividades", "ID", $ID);
    $ID_uni = $ID_uni[0]["ID_unid"];
    $datos = pintaRadio($ID_uni);

    $str = "
        <hr><p>EDITAR UNIDADES DE LA ACTIVIDAD</p>
        Marca la unidad correspondiente:<br><br>
        <form action='logica_act.php' method='post'>
    ";

    for ($i=0; $i < count($datos); $i++) { 
        $str = $str . $datos[$i];
    }

    $str = $str . "<br><br><button name='gestion' value='actua-unid-act, $ID' onclick='return confirm(\"Confirmar actualización\")'>Guardar</button>";
    $str = $str . "</form><br><hr>";

    $_SESSION["DOM"] = $_SESSION["DOM"] . $str;
}



/**
 * Complemento de la función editar
 * Se activa después de enviar el formulario desde la página de ediciones.php
 * Se cambia el DOM para poder mostrar el nuevo "value" del input en caso de ser actualizado
 * 
 */
function actualizarAct($ID){
    $datos = leer(["*"], "actividades", "ID", $ID);
    $numero = $datos[0]["numero"];
    $nombre = $datos[0]["nombre"];
    $valido = 0;

    if ($_POST["numero"]!="") {
        $numero = $_POST["numero"];
        
        if ($_POST["nombre"]!="") {
            $nombre = $_POST["nombre"];
            actualizar("actividades", ["numero", "nombre"], [$numero, $nombre], $ID);
    
            $valido = 1;
        }
    }  

    if (!$valido) {
        $_SESSION["mensaje"] = "No pueden haber campos vacíos";
    }else{
        $_SESSION["mensaje"] = "<p style='color: green;'> ¡Registro actualizado!</p>";
    }

    editarAct($ID);
    header("location: ediciones.php");
    die();
}


/**
 * Guarda el DOM a mostrar en una sesión, tanto de los inputs como del botón de volver
 * Redirecciona a la página de ediciones.php
 */
function editarAct($ID){
    $datos = leer(["*"], "actividades", "ID", $ID);
    $numero = $datos[0]["numero"];
    $nombre = $datos[0]["nombre"];

    $_SESSION["DOM"] = "
    <p>EDITAR ACTIVIDAD</p>
    <form action='logica_act.php' method='post'>
        <input type='number' placeholder='Número de Actividad' name='numero' value=$numero>
        <input type='text' placeholder='Nombre de la Actividad' name='nombre' value='$nombre' style='width:250px;'>
        <button name='gestion' value='actua-act, $ID' onclick='return confirm(\"Confirmar actualización\")'>Guardar</button>
    </form>
    <br>
    ";

    radioEdicion($ID);

    $_SESSION["volver"] = "
        <br>
        <br>
        <br>
        <form action='vista_act.php' method='post'>
            <button>Volver</button>
        </form>
    ";

    header("location: ediciones.php");
    die();
}


/**
 * Borra una Actividad
 */
function borrarAct($ID){
    borrar("actividades", [$ID]);
    $_SESSION["borrada"] = "<p style='color: red;'>Actividad eliminada</p>";

    header("location: vista_act.php");
    die();
}


/**
 * GESTIONA ACCIONES
 */
function gestorAct(){

    if (isset($_POST["gestion"])) {
        $gestion = $_POST["gestion"];

        $gestion = explode(",", $gestion);

        $ID = $gestion[1];

        switch ($gestion[0]) {
            case 'crear-act':
                crearAct();
                break;

            case 'editar-act':
                editarAct($ID);
                break;
            
            case 'actua-act':
                actualizarAct($ID);
                break;
            
            case 'borrar-act':
                borrarAct($ID);
                break;

            case 'actua-unid-act':
                actualizaRadio($ID);
                break;
        }
    }
}

gestorAct();