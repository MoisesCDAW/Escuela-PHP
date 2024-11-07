<?php


function inicio(){
    if (isset($_POST["opcion"])) {
        $opcion = $_POST["opcion"];

        switch ($opcion) {
            case 'asig':
                header("location: asignaturas.php");
                die();
                break;
            
            case 'alumn':
                header("location: alumnos.php");
                die();
                break;

            case 'volver':
                header("location: index.php");
                die();
                break;
        }
    }
}

inicio();