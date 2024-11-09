<?php 
    include "CRUD.php";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignaturas</title>
</head>
<body>

    <p>CREAR ALUMNO</p>
    <form action="CRUD.php" method="post">
        <input type="text" placeholder="DNI del alumno" name="dni-alumn">
        <input type="text" placeholder="Nombre del alumno" name="nombre-alumn">
        <input type="text" placeholder="Apellidos del alumno" name="apell-alumn">
        <br>
        <p>Selecciona las asignaturas a la que pertenecerá:</p>
        <?php 
            $datos = getAsignaturas();

            if ($datos==[]) {
                echo "Todavía no hay asignaturas creadas";
            }else{
                for ($i=0; $i < count($datos); $i++) { 
                    echo "<input type='checkbox' name='asig-alumn[]' value='".$datos[$i]."'> ".$datos[$i];
                }
            }
        ?>
        <br>
        <br>
        <button name="enviar" value="input-alumn">Enviar</button>
    </form>
    <hr>


    
    <br>
    <br>
    <form action="inicio.php" method="post">
        <button name="opcion" value="volver">Volver</button>
    </form>
</body>
</html>