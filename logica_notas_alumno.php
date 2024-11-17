<?php 
include "CRUD.php";


function general(){
    $ID_asignaturas = leer(["ID_asig"], "cursantes", "ID_alumn", ID_ALUMN);
    $cod_asignaturas = [];
    $notas = leer(["nota"], "notas", "ID_alumn", ID_ALUMN);
    $medias = [];

    for ($i=0; $i < count($ID_asignaturas); $i++) { 
        $aux = leer(["abreviatura"], "asignaturas", "ID", $ID_asignaturas[$i]["ID_asig"]);
        array_push($cod_asignaturas, $aux[0]["abreviatura"]);
    }

    for ($i=0; $i < count($notas); $i++) { 
        
    }
}


function porAsignatura(){
    
}


function gestorNotasAlumn(){
    define("ID_ALUMN", $_SESSION["ID_alumn"]);
    general();
}

gestorNotasAlumn();