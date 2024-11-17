<?php 
include "CRUD.php";

/**
 * Crea el panel de gestión en la página de vista_asig.php
 */
function panelUnid(){
    $datos = leer(["*"], "unidades", "ID_asig", ID_ASIG);

    if ($datos!=[]) {
        for ($i=0; $i<count($datos);$i++) {
            $ID = $datos[$i]["ID"];
            $numero = $datos[$i]["numero"];
            $nombre = $datos[$i]["nombre"];
            $asig = leer(["abreviatura"], "asignaturas", "ID", $datos[$i]["ID_asig"]);
            $asig = $asig[0]["abreviatura"];

            echo "
            <tr>
                <td>$numero</td>
                <td>$nombre</td>
                <td>$asig</td>
                <td>                  
                    <button name='gestion' value='editar-unid, $ID'>Editar</button>
                    <button name='gestion' value='borrar-unid, $ID' onclick='return confirm(\"Confirmar borrado\")'>Borrar</button>
                    <span>&nbsp; | &nbsp;</span>
                    <button name='gestion' value='act-unid, $ID'>Actividades</button>
                </td>
            </tr>
            ";
        } 
    }
}


/**
 * Valida los datos de entrada y crea asignaturas
 */
function crearUnidad(){
    $valido = 0;

    if ($_POST["numero"]!=""){
        $abreviatura = $_POST["numero"];

        if ($_POST["nombre"]!="") {
            $nombre = $_POST["nombre"];

            crear("unidades",["numero","ID_asig","nombre"],[$abreviatura, ID_ASIG, $nombre]);
            $valido = 1;
        }
    }

    if (!$valido) {
        $_SESSION["mensaje"] = "<p>No pueden haber campos vacíos</p>";
    }else {
        $_SESSION["mensaje"] = "<p style='color: green;'> ¡Unidad creada!</p>";
    }

    header("location: vista_unid.php");
    die();    
}


/**
 * Complemento de la función editar
 * Se activa después de enviar el formulario desde la página de ediciones.php
 * Se cambia el DOM para poder mostrar el nuevo "value" del input en caso de ser actualizado
 * 
 */
function actualizarUnid($ID){
    $datos = leer(["*"], "unidades", "ID", $ID);
    $numero = $datos[0]["numero"];
    $nombre = $datos[0]["nombre"];
    $valido = 0;

    if ($_POST["numero"]!="") {
        $numero = $_POST["numero"];
        
        if ($_POST["nombre"]!="") {
            $nombre = $_POST["nombre"];
            actualizar("unidades", ["numero", "nombre"], [$numero, $nombre], ["ID"], [$ID]);
    
            $valido = 1;
        }
    }  

    if (!$valido) {
        $_SESSION["mensaje"] = "No pueden haber campos vacíos";
    }else{
        $_SESSION["mensaje"] = "<p style='color: green;'> ¡Registro actualizado!</p>";
    }

    editarUnid($ID);
    header("location: ediciones.php");
    die();
}


/**
 * Guarda el DOM a mostrar en una sesión, tanto de los inputs como del botón de volver
 * Redirecciona a la página de ediciones.php
 */
function editarUnid($ID){
    $datos = leer(["*"], "unidades", "ID", $ID);
    $numero = $datos[0]["numero"];
    $nombre = $datos[0]["nombre"];

    $_SESSION["DOM"] = "
    <p>EDITAR UNIDAD</p>
    <form action='logica_unid.php' method='post'>
        <input type='number' placeholder='Número de Unidad' name='numero' value=$numero>
        <input type='text' placeholder='Nombre de la unidad' name='nombre' value='$nombre' style='width:250px;'>
        <button name='gestion' value='actua-unid, $ID' onclick='return confirm(\"Confirmar actualización\")'>Guardar</button>
    </form>
    <br>
    ";

    $_SESSION["volver"] = "
        <br>
        <br>
        <br>
        <form action='vista_unid.php' method='post'>
            <button>Volver</button>
        </form>
    ";

    header("location: ediciones.php");
    die();
}


/**
 * Borra una unidad
 */
function borrarUnid($ID){
    borrar("unidades", ["ID"], [$ID]);
    $_SESSION["borrada"] = "<p style='color: red;'>Unidad eliminada</p>";

    header("location: vista_unid.php");
    die();
}


/**
 * GESTIONA ACCIONES
 */
function gestorUnid(){

    if (isset($_SESSION["id_unid"])) {
        $id_asig = $_SESSION["id_asig"];
        $asig = leer(["abreviatura"], "asignaturas", "ID", $id_asig);

        define("ID_ASIG", $id_asig);
        define("ASIG", $asig[0]["abreviatura"]);
    }


    if (isset($_POST["gestion"])) {
        $gestion = $_POST["gestion"];

        $gestion = explode(",", $gestion);

        $ID = $gestion[1];

        switch ($gestion[0]) {
            case 'crear-unid':
                crearUnidad();
                break;

            case 'editar-unid':
                editarUnid($ID);
                break;
            
            case 'actua-unid':
                actualizarUnid($ID);
                break;
            
            case 'borrar-unid':
                borrarUnid($ID);
                break;

            case 'act-unid':
                $_SESSION["id_unid"] = $ID;
                header("location: vista_act.php");
                die();
                break;
        }
    }
}

gestorUnid();