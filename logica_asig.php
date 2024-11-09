<?php 
include "CRUD.php";

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


function actualizarAsig($ID){
    if ($_POST["asignatura"]!="") {
        $nombre = $_POST["asignatura"];
        actualizar("asignaturas", ["nombre"], [$nombre], $ID);

        $_SESSION["mensaje"] = "¡Registro actualizado!";
        header("location: ediciones.php");
        die();
    }else{
        $_SESSION["mensaje"] = "No pueden haber campos vacíos";
        header("location: ediciones.php");
        die();
    }
}


function editarAsig($ID){
    $datos = leer(["*"], "asignaturas", $ID);
    $nombre = $datos["nombre"];

    $_SESSION["DOM"] = "
        <p>EDITAR ASIGNATURA</p>
        <form action='logica_asig.php' method='post'>
            <input type='text' placeholder='Nuevo nombre de la asignatura' name='asignatura'>
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


function borrarAsig(){
    var_dump("borrar");
    die();
}


/**
 * GESTIONA ENVÍOS
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

                    $_SESSION["creada"] = "¡Asignatura creada!";

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
                $_SESSION["borrada"] = "Aginatura eliminada<br>";

                header("location: vista_asig.php");
                die();
                break;
        }
    }
}

gestorAsig();