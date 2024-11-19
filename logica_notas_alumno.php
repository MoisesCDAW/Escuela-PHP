<?php 
include "CRUD.php";



function general(){
    $asignatuas = [];

    if ($_SESSION["ID_alumn"]!="") {

        define("ID_ALUMN", $_SESSION["ID_alumn"]);

        $ID_asignaturas = leer(["ID_asig"], "cursantes", "ID_alumn", ID_ALUMN);
        $datos = [];
        $final = 0;
    
        for ($i=0; $i < count($ID_asignaturas); $i++) { 
            $aux = leer(["abreviatura", "ID"], "asignaturas", "ID", $ID_asignaturas[$i]["ID_asig"]);
            $aux2 = buscarNota_finales(ID_ALUMN, $aux[0]["ID"]);

            if ($aux2 != 0) { 
                $datos = $datos + [$aux[0]["abreviatura"] => $aux2[0]];
                array_push($asignatuas, $aux[0]["abreviatura"]);
            }else{
                $datos = $datos + [$aux[0]["abreviatura"] => "Sin notas"];
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


function pintaAsigs(){
    foreach (ASIGS as $value) {
        echo "<option>$value</option>";
    }
}


function mostrar(){
    if (isset($_POST["mostrar"])) {
        if (isset($_POST["asig"])) {
            $asig = $_POST["asig"];
            $ID_asig = leer(["ID"], "asignaturas", "abreviatura", $asig);
            $ID_alumno = $_SESSION["ID_alumn"];

            $notas_unid_asigs = buscarNota_finales($ID_alumno, $ID_asig[0]["ID"]);
            $notas_unid_asigs = $notas_unid_asigs[1];

            $_SESSION["notas"] = $notas_unid_asigs;
        }

        header("location: vista_notas_alumno.php");
        die();
    }
}

mostrar();