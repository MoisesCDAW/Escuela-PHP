<?php 
include "CRUD.php";
include "validaciones.php";


/**
 * Pinta las notas finales de todas las asignaturas de las que está matriculado el alumno
 */
function general(){
    $asignatuas = [];

    if ($_SESSION["ID_alumn"]!="") {

        define("ID_ALUMN", $_SESSION["ID_alumn"]);

        $ID_asignaturas = leer(["ID_asig"], "cursantes", "ID_alumn", ID_ALUMN);
        $datos = [];
    
        for ($i=0; $i < count($ID_asignaturas); $i++) { 
            $aux = leer(["abreviatura", "ID"], "asignaturas", "ID", $ID_asignaturas[$i]["ID_asig"]);
            $aux2 = buscarNota_finales(ID_ALUMN, $aux[0]["ID"]);

            if ($aux2 != 0) { 
                $datos = $datos + [$aux[0]["abreviatura"] => $aux2[0]];
                array_push($asignatuas, $aux[0]["abreviatura"]);
            }else{
                $datos = $datos + [$aux[0]["abreviatura"] => "Sin notas"];
                array_push($asignatuas, $aux[0]["abreviatura"]);
            }
        }
    
        foreach ($datos as $key => $value) {
            echo "
                <tr>
                    <td>$key</td>
                    <td>$value</td>
                </tr>
            ";
        }

        define("ASIGS", $asignatuas);
    }
}


/**
 * Pinta las notas de la asignatura que se pasó por el form: "Por asignatura"
 */
function pintaAsigs(){ 
    $selected = "";

    if (isset($_SESSION["asig"])) {
        $selected = $_SESSION["asig"];
        unset($_SESSION["asig"]);
    }

    foreach (ASIGS as $value) {
        if ($value==$selected) {
            echo "<option selected>$value</option>";
        }else{
            echo "<option>$value</option>";
        }
        
    }
}


/**
 * Gestiona la acción de mostrar las notas de una cierta asignatura que viene del form: "Por asignatura"
 */
function mostrar(){
    if (isset($_POST["mostrar"])) {
        if (isset($_POST["asig"])) {
            $asig = $_POST["asig"];
            
            $ID_asig = leer(["ID"], "asignaturas", "abreviatura", $asig);
            $ID_alumno = $_SESSION["ID_alumn"];

            $notas_unid_asigs = buscarNota_finales($ID_alumno, $ID_asig[0]["ID"]);

            if ($notas_unid_asigs==0) {
                $notas_unid_asigs = [""=>"Sin notas"];
            }else {
                $notas_unid_asigs = $notas_unid_asigs[1];
            }

            $_SESSION["notas"] = $notas_unid_asigs;
            $_SESSION["asig"] = $asig;
        }

        header("location: vista_notas_alumno.php");
        die();
    }
}

mostrar();