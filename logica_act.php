<?php 
include "CRUD.php";
include "validaciones.php";


/**
 * Ordena las actividades por su número de forma ascendente
 */
function comparaNum($a, $b) {
    if ($a['numero'] < $b['numero']) {
        return -1;
    } elseif ($a['numero'] > $b['numero']) {
        return 1;
    } else {
        return 0;
    }
}


/**
 * Crea los radio de cada asignatura
 */
function pintaRadio($unid=null){
    $unidsEdicion = [];

    $datos = leer(["*"], "unidades", "ID_asig", ID_ASIG);
    usort($datos, 'comparaNum');

    if ($datos==[]) {
        echo "<br>Sin registros";
    }else{
        for ($i=0; $i<count($datos);$i++) {
            $ID_uni = $datos[$i]["ID"];
            $numero = $datos[$i]["numero"];

            if ($unid!=null) {
                if($ID_uni == $unid){
                    array_push($unidsEdicion, "<input type='radio' name='unid-act' value=$ID_uni checked> U.".$numero);
                }else{
                    array_push($unidsEdicion, "<input type='radio' name='unid-act' value=$ID_uni> U.".$numero);
                }
            }else{
                echo "<input type='radio' name='unid-act' value=$ID_uni> U.".$numero;      
            }  
        } 
    }

    return $unidsEdicion;
}


/**
 * Crea el panel de gestión en la página de vista_act.php
 */
function panelAct(){
    $datos = leer(["*"], "actividades", "ID_unid", ID_UNIDAD);
    usort($datos, 'comparaNum');

    if ($datos!=[]) {
        for ($i=0; $i<count($datos);$i++) {
            $ID = $datos[$i]["ID"];
            $numero = $datos[$i]["numero"];
            $nombre = $datos[$i]["nombre"];
            $unidad = $datos[$i]["ID_unid"];
            
            $numUnid = leer(["numero"], "unidades", "ID", $unidad);
            $numUnid = $numUnid[0]["numero"];

            $nomUnid = leer(["nombre"], "unidades", "ID", $unidad);
            $nomUnid = $nomUnid[0]["nombre"];

            echo "
            <tr>
                <td>$numero</td>
                <td>$nombre</td>
                <td>$numUnid</td>
                <td>$nomUnid</td>
                <td>
                    <button name='gestion' value='editar-act, $ID'>Editar</button>
                    <button name='gestion' value='borrar-act, $ID' onclick='return confirm(\"Confirmar borrado\")'>Borrar</button>
                    <span>&nbsp; | &nbsp;</span>
                    <button name='gestion' value='notas-act, $ID'>Calificaciones</button>
                </td>
            </tr>
            ";
        } 
    }
}


/**
 * Valida los datos de entrada y crea asignaturas
 */
function crearAct(){
    $valido = 1;
    $numero = $nombre = "";
    $mensajes = [];

    if ($_SERVER["REQUEST_METHOD"]=="POST") {
        $numero = validarNumero(validarDato($_POST["numero"]));

        if (!$numero) {
            array_push($mensajes, "<p>Número inválido. Números enteros positivos, Max 2 dígitos y no puede estar vacío.</p>");
            $valido = 0;
        }else {
            $existentes = [];
            foreach (leer(["numero"], "actividades", "id_unid", ID_UNIDAD) as $value) {
                array_push($existentes, $value["numero"]);
            }

            if (array_search($numero, $existentes)!==false) {
                array_push($mensajes, "<p>Número inválido. Ya existe una actividad con ese número</p>");
                $valido = 0;
            }
        }

        $nombre = validarNom(validarDato($_POST["nombre"]));

        if (!$nombre) {
            array_push($mensajes, "<p>Nombre inválido. Solo letras, min 3 y max 50 caracteres y no puede estar vacío.</p>");
            $valido = 0;
        }else {
            $existente = leer(["nombre"], "actividades", "nombre", $nombre);
            if ($existente!=[]) {
                array_push($mensajes, "<p>Nombre inválido. Ya existe ese nombre</p>");
                $valido = 0;
            }
        }
    }

    if ($valido) {
        crear("actividades",["ID_unid", "numero","nombre"],[ID_UNIDAD, $numero, $nombre]);
        array_push($mensajes, "<p style='color: green;'> ¡Actividad creada!</p>");
    }

    $_SESSION["mensaje"] = $mensajes;
    header("location: vista_act.php");
    die();    
}

/**
 * Actualiza las unidades de una actividad
 * Se activa cuando se envía el formulario de los radios
 */
function actualizaRadio($ID){
    $valido = 1; // Cambiar a 0 para aplicar validaciones

    $newRadio = $_POST["unid-act"];
    actualizar("actividades", ["ID_unid"], [$newRadio], ["ID"], [$ID]);

    // $valido = 1;

    if (!$valido) {
        // $_SESSION["mensaje"] = "No pueden haber campos vacíos";
    }else{
        $_SESSION["mensaje"] = "<p style='color: green;'> ¡Registro actualizado!</p>";
    }

    editarAct($ID);
    header("location: ediciones.php");
    die();
}


/**
 * Complemento de la función editarAct().
 * Concatena los checkbox marcados o desmarcados al DOM creado por editarAct();
 */
function radioEdicion($ID){
    $ID_uni = leer(["ID_unid"], "actividades", "ID", $ID);
    $ID_uni = $ID_uni[0]["ID_unid"];
    $datos = pintaRadio($ID_uni);

    $str = "
        <hr><p>EDITAR UNIDADES DE LA ACTIVIDAD</p>
        Marca la unidad correspondiente:<br><br>
        <form action='logica_act.php' method='post'>
    ";

    for ($i=0; $i < count($datos); $i++) { 
        $str = $str . $datos[$i];
    }

    $str = $str . "<br><br><button name='gestion' value='actua-unid-act, $ID' onclick='return confirm(\"Confirmar actualización\")'>Guardar</button>";
    $str = $str . "</form><br><hr>";

    $_SESSION["DOM"] = $_SESSION["DOM"] . $str;
}



/**
 * Complemento de la función editar
 * Se activa después de enviar el formulario desde la página de ediciones.php
 * Se cambia el DOM para poder mostrar el nuevo "value" del input en caso de ser actualizado
 * 
 */
function actualizarAct($ID){
    $datos = leer(["*"], "actividades", "ID", $ID);
    $numero = $datos[0]["numero"];
    $nombre = $datos[0]["nombre"];
    $valido = 1;
    $mensajes = [];

    if ($_SERVER["REQUEST_METHOD"]=="POST") {
        $numero = validarNumero(validarDato($_POST["numero"]));

        if (!$numero) {
            array_push($mensajes, "<p>Número inválido. Números enteros positivos, Max 2 dígitos y no puede estar vacío.</p>");
            $valido = 0;
        }else {
            $existentes = [];
            foreach (leer(["numero"], "actividades", "id_unid", ID_UNIDAD) as $value) {
                array_push($existentes, $value["numero"]);
            }

            if (array_search($numero, $existentes)!==false && $numero!=$datos[0]["numero"]) {
                array_push($mensajes, "<p>Número inválido. Ya existe una actividad con ese número</p>");
                $valido = 0;
            }
        }

        $nombre = validarNom(validarDato($_POST["nombre"]));

        if (!$nombre) {
            array_push($mensajes, "<p>Nombre inválido. Solo letras, min 3 y max 50 caracteres y no puede estar vacío.</p>");
            $valido = 0;
        }else {
            $existente = leer(["nombre"], "actividades", "nombre", $nombre);
            if ($existente!=[] && $nombre!=$datos[0]["nombre"]) {
                array_push($mensajes, "<p>Nombre inválido. Ya existe ese nombre</p>");
                $valido = 0;
            }
        }
    }

    if ($valido) {
        actualizar("actividades", ["numero", "nombre"], [$numero, $nombre], ["ID"], [$ID]);
        array_push($mensajes, "<p style='color: green;'> ¡Registro actualizado!</p>");
    }

    $_SESSION["mensaje"] = $mensajes;  
    editarAct($ID);
    header("location: ediciones.php");
    die();
}


/**
 * Guarda el DOM a mostrar en una sesión, tanto de los inputs como del botón de volver
 * Redirecciona a la página de ediciones.php
 */
function editarAct($ID){
    $datos = leer(["*"], "actividades", "ID", $ID);
    $numero = $datos[0]["numero"];
    $nombre = $datos[0]["nombre"];

    $_SESSION["DOM"] = "
    <p>EDITAR ACTIVIDAD</p>
    <form action='logica_act.php' method='post'>
        <input type='number' placeholder='Número de Actividad' name='numero' value=$numero>
        <input type='text' placeholder='Nombre de la Actividad' name='nombre' value='$nombre' style='width:250px;'>
        <button name='gestion' value='actua-act, $ID' onclick='return confirm(\"Confirmar actualización\")'>Guardar</button>
    </form>
    <br>
    ";

    radioEdicion($ID);

    $_SESSION["volver"] = "
        <br>
        <br>
        <br>
        <form action='vista_act.php' method='post'>
            <button>Volver</button>
        </form>
    ";

    header("location: ediciones.php");
    die();
}


/**
 * Borra una Actividad
 */
function borrarAct($ID){
    borrar("actividades", ["ID"], [$ID]);
    $_SESSION["borrada"] = "<p style='color: red;'>Actividad eliminada</p>";

    header("location: vista_act.php");
    die();
}


/**
 * GESTIONA ACCIONES
 */
function gestorAct(){


    if (isset($_SESSION["id_asig"])) {

        if (isset($_SESSION["id_unid"])) {
            $id_unid = $_SESSION["id_unid"];
            $id_asig = $_SESSION["id_asig"];

            $numero_unid = leer(["numero"], "unidades", "ID", $id_unid);
            $cod_asig = leer(["abreviatura"], "asignaturas", "ID", $id_asig);

            define("ID_ASIG", $id_asig);
            define("ASIG", $cod_asig[0]["abreviatura"]);

            define("ID_UNIDAD", $id_unid);
            define("UNIDAD", $numero_unid[0]["numero"]);
        }
    }


    if (isset($_POST["gestion"])) {
        $gestion = $_POST["gestion"];

        $gestion = explode(",", $gestion);

        $ID = $gestion[1];

        switch ($gestion[0]) {
            case 'crear-act':
                crearAct();
                break;

            case 'editar-act':
                editarAct($ID);
                break;
            
            case 'actua-act':
                actualizarAct($ID);
                break;
            
            case 'borrar-act':
                borrarAct($ID);
                break;

            case 'actua-unid-act':
                actualizaRadio($ID);
                break;

            case 'notas-act':
                $_SESSION["id_act"] = $ID;
                header("location: vista_notas.php");
                die();
                break;
        }
    }
}

gestorAct();