<?php 
include "CRUD.php";


/**
 * Crea el panel de gestión en la página de vista_asig.php
 */
function panelAsig(){
    $datos = leer(["*"], "asignaturas");
    if ($datos!=[]) {
        for ($i=0; $i<count($datos);$i++) {
            $ID = $datos[$i]["ID"];
            $abreviatura = $datos[$i]["abreviatura"];
            $nombre = $datos[$i]["nombre"];
            echo "
            <tr>
                <td>$abreviatura</td>
                <td>$nombre</td>
                <td>
                    <button name='gestion' value='editar-asig, $ID'>Editar</button>
                    <button name='gestion' value='borrar-asig, $ID' onclick='return confirm(\"Confirmar borrado\")'>Borrar</button>
                </td>
            </tr>
            ";
        } 
    }
}


/**
 * Valida los datos de entrada y crea asignaturas
 */
function crearAsig(){
    $valido = 0;

    if ($_POST["abreviatura"]!=""){
        $abreviatura = $_POST["abreviatura"];

        if ($_POST["nombre"]!="") {
            $nombre = $_POST["nombre"];

            crear("asignaturas",["abreviatura","nombre"],[$abreviatura, $nombre]);

            $valido = 1;
        }
    }

    if (!$valido) {
        $_SESSION["mensaje"] = "<p>No pueden haber campos vacíos</p>";
    }else {
        $_SESSION["mensaje"] = "<p style='color: green;'> ¡Asignatura creada!</p>";
    }

    header("location: vista_asig.php");
    die();    
}


/**
 * Complemento de la función editar
 * Se activa después de enviar el formulario desde la página de ediciones.php
 * Se cambia el DOM para poder mostrar el nuevo "value" del input en caso de ser actualizado
 * 
 */
function actualizarAsig($ID){
    $datos = leer(["*"], "asignaturas", $ID);
    $abrev = $datos[0]["abreviatura"];
    $nombre = $datos[0]["nombre"];
    $valido = 0;

    if ($_POST["abreviatura"]!="") {
        $abrev = $_POST["abreviatura"];
        
        if ($_POST["nombre"]!="") {
            $nombre = $_POST["nombre"];
            actualizar("asignaturas", ["abreviatura", "nombre"], [$abrev, $nombre], $ID);
    
            $_SESSION["DOM"] = "
                <p>EDITAR ASIGNATURA</p>
                <form action='logica_asig.php' method='post'>
                    <input type='text' placeholder='Nueva Abreviatura. Ej.: DSW' name='abreviatura' value=$abrev>
                    <input type='text' placeholder='Nuevo nombre' name='nombre' value='$nombre' style='width:250px;'>
                    <button name='gestion' value='actua-asig, $ID' onclick='return confirm(\"Confirmar actualización\")'>Guardar</button>
                </form>
                <br><hr>
            ";
    
            $valido = 1;
        }
    }  

    if (!$valido) {
        $_SESSION["mensaje"] = "No pueden haber campos vacíos";
    }else{
        $_SESSION["mensaje"] = "<p style='color: green;'> ¡Registro actualizado!</p>";
    }

    header("location: ediciones.php");
    die();
}


/**
 * Guarda el DOM a mostrar en una sesión, tanto de los inputs como del botón de volver
 * Redirecciona a la página de ediciones.php
 */
function editarAsig($ID){
    $datos = leer(["*"], "asignaturas", $ID);
    $abrev = $datos[0]["abreviatura"];
    $nombre = $datos[0]["nombre"];

    $_SESSION["DOM"] = "
    <p>EDITAR ASIGNATURA</p>
    <form action='logica_asig.php' method='post'>
        <input type='text' placeholder='Nueva Abreviatura. Ej.: DSW' name='abreviatura' value=$abrev>
        <input type='text' placeholder='Nuevo nombre' name='nombre' value='$nombre' style='width:250px;'>
        <button name='gestion' value='actua-asig, $ID' onclick='return confirm(\"Confirmar actualización\")'>Guardar</button>
    </form>
    <br><hr>
    ";

    $_SESSION["volver"] = "
        <br>
        <br>
        <form action='vista_asig.php' method='post'>
            <button>Volver</button>
        </form>
    ";

    header("location: ediciones.php");
    die();
}


/**
 * Confirma el borrado del alumno y luego lo borra o no
 */
function borrarAsig($ID){
    $datos = cursaPorAsignatura($ID);
    $aux = [];

    foreach ($datos as $value) {

        $aux = datosCursante($value["ID_alumn"]);
        if (count($aux)==1) {
            borrar("alumnos", $value["ID_alumn"]);
        }
        
    }

    borrar("asignaturas", $ID);
    $_SESSION["borrada"] = "<p style='color: red;'>Aginatura eliminada</p>";

    header("location: vista_asig.php");
    die();
}


/**
 * GESTIONA ACCIONES
 */
function gestorAsig(){

    if (isset($_POST["gestion"])) {
        $gestion = $_POST["gestion"];

        $gestion = explode(",", $gestion);

        switch ($gestion[0]) {
            case 'crear-asig':
                crearAsig();
                break;

            case 'editar-asig':
                $ID = $gestion[1];
                editarAsig($ID);
                break;
            
            case 'actua-asig':
                $ID = $gestion[1];
                actualizarAsig($ID);
                break;
            
            case 'borrar-asig':
                $ID = $gestion[1];
                borrarAsig($ID);
                break;
        }
    }
}

gestorAsig();