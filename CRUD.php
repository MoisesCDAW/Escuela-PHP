<?php
session_start();

/**
 * Crea la conexión con las base de datos
 */
function conectar(){
    $user = "moises";
    $password = "123456";

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
function leer($columnas, $tabla, $filtro=null){
    global $conn; 

    $columnas = implode(",",$columnas); 

    try {
        if($filtro==null){
            $sql = "SELECT $columnas FROM $tabla";
            $sql = $conn->prepare($sql);
            $sql->execute();
            $datos = $sql->fetchAll(PDO::FETCH_ASSOC);
        }else {
            $sql = "SELECT $columnas FROM $tabla WHERE ID = :filtro";
            $sql = $conn->prepare($sql);
            $sql->bindParam(":filtro", $filtro);
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
function actualizar($tabla, $columnas, $valores, $ID){
    global $conn;
    $colsAux = [];

    for ($i=0; $i < count($columnas); $i++) { 
        array_push($colsAux, $columnas[$i] . "=" . ":" . $columnas[$i]);
    }

    $strColum = implode(",", $colsAux);

    try {
        $sql = "UPDATE $tabla SET $strColum WHERE ID = :ID";
        $sql = $conn->prepare($sql);

        for ($i=0; $i < count($valores); $i++) {
            $sql->bindParam(":".$columnas[$i], $valores[$i]);
        }

        $sql->bindParam(":ID", $ID);

        $sql->execute();

    } catch (PDOException $th) {
        var_dump("Update ERROR: " . $th->getMessage());
        die();
    }
}


/**
 *  ELIMIMA UN REGISTRO
 */
function borrar($tabla, $ID, $columnas=null){
    global $conn; 

    if ($columnas!=null) {
        $str = "";
        for ($i=0; $i < count($columnas); $i++) { 
            $str .= $columnas[$i] . "= :" . $i;
            if ($i!=count($ID)-1) {
                $str .= " and ";
            }
        }
    }

    try {
        if ($columnas==null) {
            $sql = "DELETE FROM $tabla WHERE ID = :ID";
            $sql = $conn->prepare($sql);
            $sql->bindParam(":ID", $ID[0]);
            
        }else{
            $sql = "DELETE FROM $tabla WHERE $str";
            $sql = $conn->prepare($sql);

            for ($i=0; $i < count($ID); $i++) { 
                $sql->bindParam(":".$i, $ID[$i]);
            }     
        }

        $sql->execute();

    } catch (PDOException $th) {
        var_dump("Delete ERROR: " . $th->getMessage());
        die();
    }
}


/**
 * Busca un alumno por su dni
 */
function buscarAlumno($columnas, $dni){
    global $conn; 

    $columnas = implode(",",$columnas);

    try {
        $sql = "SELECT $columnas FROM alumnos WHERE dni = :dni";
        $sql = $conn->prepare($sql);
        $sql->bindParam(":dni", $dni);
        $sql->execute();

        $datos = $sql->fetch(PDO::FETCH_ASSOC);

        return $datos;

    } catch (PDOException $th) {
        var_dump("Read ERROR en buscarAlumno(): " . $th->getMessage());
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
 * Devuele un array con el ID e ID_asig de la tabla "cursantes" correspondiente a un ID_alumn
 */
function datosCursante($ID){
    global $conn; 

    try {
        $sql = "SELECT ID_asig FROM cursantes WHERE ID_alumn = :ID";
        $sql = $conn->prepare($sql);
        $sql->bindParam(":ID", $ID);
        $sql->execute();

        $datos = $sql->fetchAll(PDO::FETCH_ASSOC);

        return $datos;

    } catch (PDOException $th) {
        var_dump("Read ERROR en datosCursante(): " . $th->getMessage());
        die();
    }
}