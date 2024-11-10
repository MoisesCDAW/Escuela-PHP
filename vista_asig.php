<?php 
    include "logica_asig.php";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignaturas</title>

    <style>
        .panel {
            width: 650px;
            text-align: center;
        }
    </style>

</head>
<body>

    <p>CREAR ASIGNATURA</p>
    <form action="logica_asig.php" method="post">
        <input type="text" placeholder="Abreviatura. Ej.: DSW" name="abreviatura">
        <input type="text" placeholder="Nombre de la asignatura" name="nombre" style='width:250px;'>
        <button name="gestion" value="crear-asig">Crear</button>
        <?php 
            if (isset($_SESSION["mensaje"])) {
                echo $_SESSION["mensaje"];
                unset($_SESSION["mensaje"]);
            }
        ?>
    </form>
    <br><hr>

    <p>GESTIONAR ASIGNATURAS</p>
    <hr>
    <?php 
            if (isset($_SESSION["borrada"])) {
                echo $_SESSION["borrada"];
                unset($_SESSION["borrada"]);
            }
        ?>
    <form action="logica_asig.php" method="post">
        <table class="panel">
            <tr>
                <th>Abreviatura</th>
                <th>Nombre</th>
                <th></th>
            </tr>
            <?php panelAsig(); ?>
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