<?php 
include "CRUD.php";


function general(){
    if ($_SESSION["ID_alumn"]!="") {
        $ID_ALUMN = $_SESSION["ID_alumn"];
        $ID_asignaturas = leer(["ID_asig"], "cursantes", "ID_alumn", $ID_ALUMN);
        $datos = [];
        $final = 0;
    
        for ($i=0; $i < count($ID_asignaturas); $i++) { 
            $aux = leer(["abreviatura", "ID"], "asignaturas", "ID", $ID_asignaturas[$i]["ID_asig"]);
            $datos = $datos + [$aux[0]["abreviatura"] => buscarNota_finales($ID_ALUMN, $aux[0]["ID"])];
        }
    
        foreach ($datos as $key => $value) {
            echo "
                <tr>
                    <td>$key</td>
                    <td>$value</td>
                </tr>
            ";

            $final += $value;
        }

        return round($final/count($datos));
    }
}