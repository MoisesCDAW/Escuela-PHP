<?php
session_start();

/**
 * Crea la conexión con las base de datos
 */
function conectar(){
    $user = "root";
    $password = "";

    try {
        $conn = new PDO('mysql:host=localhost;dbname=escuela', $user, $password);
        $conn->setAttribute(PDo::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        var_dump("Connection failed: " . $e->getMessage());
        die();
    }

    return $conn;
}

$conn = conectar();


/**
 * CREA REGISTROS
 */
function crear($tabla, $columnas, $valores){
    global $conn;
    $colsAux = [];

    foreach ($columnas as $value) {
        array_push($colsAux, ":".$value);
    }

    $strCols = implode(",",$colsAux);
    $columnas = implode(",",$columnas);

    $sql = "INSERT INTO $tabla ($columnas) VALUES ($strCols)";

    try {
        $sql = $conn->prepare($sql);

        for ($i=0; $i < count($valores); $i++) { 
            $sql->bindParam($colsAux[$i], $valores[$i]);
        }
        
        $sql->execute();


    }catch(PDOException $e){
        var_dump("Create ERROR: " . $e->getMessage());
        die();
    }
}


/**
 * DEVUELVE REGISTROS. Permite filtrar por ID 
 */
function leer($columnas, $tabla, $filtro=null, $valor=null){
    global $conn; 

    $columnas = implode(",",$columnas); 

    try {
        if($filtro==null){
            $sql = "SELECT $columnas FROM $tabla";
            $sql = $conn->prepare($sql);
            $sql->execute();
            $datos = $sql->fetchAll(PDO::FETCH_ASSOC);
        }else {
            $sql = "SELECT $columnas FROM $tabla WHERE $filtro = :valor";
            $sql = $conn->prepare($sql);
            $sql->bindParam(":valor", $valor);
            $sql->execute();
            $datos = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        return $datos;

    } catch (PDOException $th) {
        var_dump("Read ERROR en leer(): " . $th->getMessage());
        die();
    }
}


/**
 * ACTUALIZA UN REGISTRO
 */
function actualizar($tabla, $columnas, $valores, $filtro, $valor){
    global $conn;
    $colsAux = [];

    for ($i=0; $i < count($columnas); $i++) { 
        array_push($colsAux, $columnas[$i] . "=" . ":" . $columnas[$i]);
    }

    $strColum = implode(",", $colsAux);

    $strFiltro = "";
    for ($i=0; $i < count($filtro); $i++) { 
        $strFiltro .= $filtro[$i] . "= :" . $filtro[$i];
        if ($i!=count($filtro)-1) {
            $strFiltro .= " and ";
        }
    }

    try {
        $sql = "UPDATE $tabla SET $strColum WHERE $strFiltro";
        $sql = $conn->prepare($sql);

        for ($i=0; $i < count($valores); $i++) {
            $sql->bindParam(":".$columnas[$i], $valores[$i]);
        }

        for ($i=0; $i < count($filtro); $i++) { 
            $sql->bindParam(":".$filtro[$i], $valor[$i]);
        }

        $sql->execute();

    } catch (PDOException $th) {
        var_dump("Update ERROR: " . $th->getMessage());
        die();
    }
}


/**
 *  ELIMIMA UN REGISTRO
 */
function borrar($tabla, $columnas, $valores){
    global $conn; 

    $str = "";
    for ($i=0; $i < count($columnas); $i++) { 
        $str .= $columnas[$i] . "= :" . $columnas[$i];
        if ($i!=count($columnas)-1) {
            $str .= " and ";
        }
    }

    try {
        $sql = "DELETE FROM $tabla WHERE $str";
        $sql = $conn->prepare($sql);

        for ($i=0; $i < count($columnas); $i++) { 
            $sql->bindParam(":".$columnas[$i], $valores[$i]);
        }

        $sql->execute();

    } catch (PDOException $th) {
        var_dump("Delete ERROR: " . $th->getMessage());
        die();
    }
} 


/**
 * Devuele un array con las asignaturas de un alumno buscando por ID_alumn
 */
function buscarAsig($ID){
    global $conn; 

    try {
        $sql = "SELECT ID, abreviatura FROM asignaturas WHERE ID IN(
        SELECT ID_asig FROM cursantes WHERE ID_alumn = :ID)";
        $sql = $conn->prepare($sql);
        $sql->bindParam(":ID", $ID);
        $sql->execute();

        $datos = $sql->fetchAll(PDO::FETCH_ASSOC);

        return $datos;

    } catch (PDOException $th) {
        var_dump("Read ERROR en buscarAsig(): " . $th->getMessage());
        die();
    }
}


/**
 * Busca la nota de un alumno en una cierta actividad
 */
function buscarNota($ID_act, $ID_alumn){
    global $conn; 

    try {
        $sql = "SELECT nota FROM notas WHERE ID_act = :ID_act and ID_alumn = :ID_alumn";
        $sql = $conn->prepare($sql);
        $sql->bindParam(":ID_act", $ID_act);
        $sql->bindParam(":ID_alumn", $ID_alumn);
        $sql->execute();

        $datos = $sql->fetchAll(PDO::FETCH_ASSOC);

        return $datos;

    } catch (PDOException $th) {
        var_dump("Read ERROR en buscarNota(): " . $th->getMessage());
        die();
    }
}


/**
 * Devuelve un array con dos arrays, el primero con la nota final de una cierta asignatura
 * y otro con las notas finales de cada unidad de una cierta asignatura
 */
function buscarNota_finales($ID_alumn, $ID_asig){
    global $conn;
    $notas_unidad = 0;
    $notas_unidades = [];
    $nota_asig = 0;

    try {

        // Todas las unidades de una asignatura
        $unidades = "SELECT ID, numero FROM unidades where ID_asig = :ID_asig";
        $unidades = $conn->prepare($unidades);
        $unidades->bindParam(":ID_asig", $ID_asig);
        $unidades->execute();
        $unidades = $unidades->fetchAll(PDO::FETCH_ASSOC);

        // Todas las actividades de una unidad
        for ($i=0; $i < count($unidades); $i++) { 
            $uni = $unidades[$i]["ID"];

            // Todas las notas de un alumno en una unidad
            $notas = "SELECT nota FROM notas WHERE ID_alumn = :ID_alumn AND ID_act IN ( SELECT id FROM actividades WHERE ID_unid = $uni)";

            $notas = $conn->prepare($notas);
            $notas->bindParam(":ID_alumn", $ID_alumn);
            $notas->execute();
            $notas = $notas->fetchAll(PDO::FETCH_ASSOC);

            if ($notas!=[]) {
                $aux = 0;
                for ($j=0; $j < count($notas); $j++) { 
                    $aux += $notas[$j]["nota"];
                }
    
                $notas_unidad += round($aux/count($notas));
                $notas_unidades = $notas_unidades + [$unidades[$i]["numero"] => round($aux/count($notas))];
            }
        
        }

        if ($notas_unidad!=0) {
            $nota_asig = round($notas_unidad/count($unidades));

            return [$nota_asig, $notas_unidades];
        }else {
            return 0;
        }


    } catch (PDOException $th) {
        var_dump("Read ERROR en buscarNota_finales(): " . $th->getMessage());
        die();
    }
}


/**
 * Utilizada para borrar las notas de una asignatura de un cierto alumno cuando este se desmatricula
 */
function borrarNotas($ID_alumn, $ID_asig){
    global $conn; 

    try {
        $sql = "DELETE FROM notas WHERE ID_alumn = :ID_alumn AND ID_act IN (
        SELECT actividades.ID FROM actividades JOIN unidades ON actividades.ID_unid = unidades.ID
        JOIN asignaturas ON unidades.ID_asig = asignaturas.ID  WHERE asignaturas.ID = :ID_asig)";

        $sql = $conn->prepare($sql);
        $sql->bindParam(":ID_alumn", $ID_alumn);
        $sql->bindParam(":ID_asig", $ID_asig);
        $sql->execute();

    } catch (PDOException $th) {
        var_dump("Delete ERROR en borrarNotas(): " . $th->getMessage());
        die();
    }
}
