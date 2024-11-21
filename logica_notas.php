<?php 
include "CRUD.php";
include "validaciones.php";


/**
 * Crea el panel de gestión en la página de vista_notas.php
 */
function panelNotas(){
    $datos = leer(["ID_alumn"], "cursantes", "ID_asig", ID_ASIG);
    
    if ($datos!=[]) {
        for ($i=0; $i < count($datos); $i++) { 

            // Imprime datos de cada alumno matriculado en la asignatura
            $alumno = leer(["dni", "nombre", "apellidos"], "alumnos", "ID", $datos[$i]["ID_alumn"]);
            $ID_alumn = $datos[$i]["ID_alumn"];
            $dni = $alumno[0]["dni"];
            $nombre = $alumno[0]["nombre"];
            $apellidos = $alumno[0]["apellidos"];

            $actualizar = $id_alumn_edit = "";
            $boton_der = "<button name='gestion' value='borrar-nota,$ID_alumn' onclick='return confirm(\"Confirmar borrado\")'>Borrar Nota</button>";

            if (isset($_SESSION["edicion"])) {
                $actualizar = $_SESSION["edicion"];
                $id_alumn_edit = $_SESSION["ID_alumn"];
            }

            if ($actualizar=="") {
                $boton_izq = "<button name='gestion' value='guardar-nota,$ID_alumn'>Guardar Nota</button>";
            }

            //---- Permite activar o desactivar el input
            $desactivado = $value = "";
            $name = "nota-".$ID_alumn;
    
            $nota = buscarNota(ID_ACT,$ID_alumn);

            if ($nota!=[]) {
                $value = "value=".$nota[0]["nota"];
                $desactivado = "disabled";

                if ($actualizar!="" && $ID_alumn==$id_alumn_edit) {
                    $desactivado = "";
                    $boton_izq = $actualizar;
                    $boton_der = "<button name='gestion' value='cancelar-nota,$ID_alumn'>Cancelar</button>";

                    unset($_SESSION["edicion"]);
                    unset($_SESSION["ID_alumn"]);
                }else{
                    $boton_izq = "<button name='gestion' value='editar-nota,$ID_alumn'>Editar Nota</button>";
                }
            }

            $input = "<input type='number' name=$name style='width:50px;' $desactivado $value>";
            //----

            echo "
            <tr>
                <td>$dni</td>
                <td>$nombre</td>
                <td>$apellidos</td>
                <td>
                    $input
                </td>
                <td>
                    $boton_izq
                    $boton_der
                </td>
            </tr>
            ";
        }
    }
}


/**
 * Valida los datos de entrada y crea notas
 */
function guardarNota($ID_alumn){

    if ($_POST["nota-".$ID_alumn]!=""){
        $nota = $_POST["nota-".$ID_alumn];

        if ($nota<=0 || $nota>10) {
            $_SESSION["mensaje"] = "<p>Las notas tienen que estar entre 1 y 10</p>";
        }else {
            crear("notas",["nota", "ID_act","ID_alumn"],[$nota, ID_ACT, $ID_alumn]);
            $_SESSION["mensaje"] = "<p style='color: green;'> ¡Nota guardada!</p>";
        }
        
    }else{
        $_SESSION["mensaje"] = "<p>No pueden haber campos vacíos</p>";
    }

    header("location: vista_notas.php");
    die();   
}

/**
 * Complemento de la función editar
 * Se activa después de enviar el formulario desde la página de ediciones.php
 * Se cambia el DOM para poder mostrar el nuevo "value" del input en caso de ser actualizado
 * 
 */
function actualizarNota($ID_alumn){

    if ($_POST["nota-".$ID_alumn]!=""){
        $nota = $_POST["nota-".$ID_alumn];
        $nota = intval($nota);

        if ($nota<=0 || $nota>10) {
            $_SESSION["mensaje"] = "<p>Las notas tienen que estar entre 1 y 10</p>";
        }else {
            actualizar("notas", ["nota"], [$nota], ["ID_act","ID_alumn"], [ID_ACT, $ID_alumn]);
            $_SESSION["mensaje"] = "<p style='color: green;'> ¡Nota actualizada!</p>";
        }
        
    }else{
        $_SESSION["mensaje"] = "<p>No pueden haber campos vacíos</p>";
    }

    header("location: vista_notas.php");
    die();
}


/**
 * Borra una Nota
 */
function borrarNota($ID_alumn){
    borrar("notas", ["ID_act", "ID_alumn"], [ID_ACT, $ID_alumn]);
    $_SESSION["mensaje"] = "<p style='color: red;'>Nota eliminada</p>";

    header("location: vista_notas.php");
    die();
}


/**
 * GESTIONA ACCIONES
 */
function gestorNotas(){


    if (isset($_SESSION["id_asig"])) {
        $id_asig = $_SESSION["id_asig"];

        if (isset($_SESSION["id_unid"])) {
            $id_unid = $_SESSION["id_unid"];

            if (isset($_SESSION["id_act"])) {
                $id_act = $_SESSION["id_act"];
    
                $cod_asig = leer(["abreviatura"], "asignaturas", "ID", $id_asig);
                $numero_unid = leer(["numero"], "unidades", "ID", $id_unid);
                $numero_act = leer(["numero"], "actividades", "ID", $id_act);
    
                define("ID_ASIG", $id_asig);
                define("ASIG", $cod_asig[0]["abreviatura"]);
    
                define("ID_UNIDAD", $id_unid);
                define("UNIDAD", $numero_unid[0]["numero"]);

                define("ID_ACT", $id_act);
                define("ACTIVIDAD", $numero_act[0]["numero"]);
            }
        }
    }


    if (isset($_POST["gestion"])) {
        $gestion = $_POST["gestion"];

        $gestion = explode(",", $gestion);

        $ID_alumn = $gestion[1];

        switch ($gestion[0]) {
            case 'guardar-nota':
                guardarNota($ID_alumn);
                break;

            case 'borrar-nota':
                borrarNota($ID_alumn);
                break;
            
            case 'editar-nota':
                $_SESSION["edicion"] = "<button name='gestion' value='actualizar-nota,$ID_alumn'>Actualizar</button>";
                $_SESSION["ID_alumn"] = $ID_alumn;
                header("location: vista_notas.php");
                die();
                break;

            case 'actualizar-nota':
                actualizarNota($ID_alumn);
                break;

            case 'cancelar-nota':
                header("location: vista_notas.php");
                die();
                break;
        }
    }
}

gestorNotas();