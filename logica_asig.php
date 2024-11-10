<?php 
include "CRUD.php";


/**
 * Crea el panel de gestión en la página de vista_asig.php
 */
function getAsignaturas(){
    $datos = leer(["*"], "asignaturas");
    if ($datos==[]) {
        echo "<br>Sin registros";
    }else{
        for ($i=0; $i<count($datos);$i++) {
            $aux = $datos[$i]["nombre"];
            $aux2 = $datos[$i]["ID"];
            echo "
            <div id='asig'>
                <p>$aux</p>
                <div>
                    <button name='gestion' value='editar-asig, $aux2'>Editar</button>
                    <button name='gestion' value='borrar-asig, $aux2'>Borrar</button>
                </div>
            </div>
            ";
        } 
    }
}


/**
 * Complemento de la función editar
 * Se activa después de enviar el formulario desde la página de ediciones.php
 * Se cambia el DOM para poder mostrar el nuevo "value" del input en caso de ser actualizado
 * 
 */
function actualizarAsig($ID){
    $datos = leer(["*"], "asignaturas", $ID);
    $nombre = $datos["nombre"];

    if ($_POST["asignatura"]!="") {
        $nombre = $_POST["asignatura"];
        actualizar("asignaturas", ["nombre"], [$nombre], $ID);

        $_SESSION["DOM"] = "
            <p>EDITAR ASIGNATURA</p>
            <form action='logica_asig.php' method='post'>
                <input type='text' placeholder='Nuevo nombre de la asignatura' name='asignatura' value=$nombre>
                <button name='gestion' value='actua-asig, $ID'>Guardar</button>
            </form>
            <br><hr>
        ";

        $_SESSION["mensaje"] = "<p style='color: green;'> ¡Registro actualizado!</p>";
        header("location: ediciones.php");
        die();
    }else{
        $_SESSION["mensaje"] = "No pueden haber campos vacíos";
        header("location: ediciones.php");
        die();
    }
}


/**
 * Guarda el DOM a mostrar en una sesión, tanto de los inputs como del botón de volver
 * Redirecciona a la página de ediciones.php
 */
function editarAsig($ID){
    $datos = leer(["*"], "asignaturas", $ID);
    $nombre = $datos["nombre"];

    $_SESSION["DOM"] = "
        <p>EDITAR ASIGNATURA</p>
        <form action='logica_asig.php' method='post'>
            <input type='text' placeholder='Nuevo nombre de la asignatura' name='asignatura' value=$nombre>
            <button name='gestion' value='actua-asig, $ID'>Guardar</button>
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
 * GESTIONA ACCIONES
 */
function gestorAsig(){

    if (isset($_POST["gestion"])) {
        $gestion = $_POST["gestion"];

        $gestion = explode(",", $gestion);
        $ID = $gestion[1];

        switch ($gestion[0]) {
            case 'crear-asig':
                if ($_POST["asignatura"]!=""){
                    $datos = $_POST["asignatura"];
                    crear("asignaturas",["nombre"],[$datos]);

                    $_SESSION["creada"] = "<p style='color: green;'> ¡Asignatura creada!</p>";

                    header("location: vista_asig.php");
                    die();
                }    
                break;

            case 'editar-asig':
                editarAsig($ID);
                break;
            
            case 'actua-asig':
                actualizarAsig($ID);
                break;
            
            case 'borrar-asig':
                borrar("asignaturas", $ID);
                $_SESSION["borrada"] = "<p style='color: red;'>Aginatura eliminada</p>";

                header("location: vista_asig.php");
                die();
                break;
        }
    }
}

gestorAsig();