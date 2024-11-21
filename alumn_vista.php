<?php 
    include "alumn_logica.php";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumnos</title>

    <style>
        .panel {
            width: 950px;
            text-align: center;
        }
    </style>
</head>
<body>

    <p>CREAR ALUMNO</p>
    <form action="alumn_logica.php" method="post">
        <input type="text" placeholder="DNI del alumno" name="dni-alumn">
        <input type="text" placeholder="Nombre del alumno" name="nombre-alumn" capitalize>
        <input type="text" placeholder="Apellidos del alumno" name="apell-alumn" capitalize>
        <br>
        <p>Selecciona las asignaturas a las que pertenecerá:</p>
        <?php 
            $datos = pintaCheckbox();
        ?>
        <br>
        <br>
        <button name="gestion" value="crear-alumn">Enviar</button>
        <br>
        <br>
        <?php 
            if (isset($_SESSION["mensaje"])) {
                $mensajes = $_SESSION["mensaje"];
                foreach ($mensajes as $value) {
                    echo $value;
                }
                
                unset($_SESSION["mensaje"]);
            }
        ?>
    </form>
    <hr>

    <p>GESTIONAR ALUMNOS</p>
    <?php 
        if (isset($_SESSION["borrada"])) {
            echo $_SESSION["borrada"];
            unset($_SESSION["borrada"]);
        }
    ?>
    <hr>
    
    <form action="alumn_logica.php" method="post">
        <table class="panel">
            <tr>
                <th>DNI</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Asignaturas</th>
                <th></th>
            </tr>
            <?php panelAlumn(); ?>
        </table>
    </form>
    <hr>

    <br>
    <br>
    <form action="index.php" method="post">
        <button name="opcion" value="volver">Volver</button>
    </form>
</body>
</html>