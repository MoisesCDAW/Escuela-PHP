<?php 
    include "logica_unid.php";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unidades</title>

    <style>
        .panel {
            width: 650px;
            text-align: center;
        }
    </style>

</head>
<body>

    <p>CREAR UNIDAD</p>
    <form action="logica_unid.php" method="post">
        <input type="number" placeholder="Número de Unidad" name="numero">
        <input type="text" placeholder="Nombre de la unidad" name="nombre" style='width:250px;'>
        <br>
        <p>Selecciona la asignatura a la que pertenecerá:</p>
        <?php 
            $datos = pintaRadio();
        ?>
        <br>
        <br>
        <button name="gestion" value="crear-unid">Crear</button>
        <br>
        <br>
        <?php 
            if (isset($_SESSION["mensaje"])) {
                echo $_SESSION["mensaje"];
                unset($_SESSION["mensaje"]);
            }
        ?>
    </form>
    <br><hr>

    <p>GESTIONAR UNIDAD</p>
    <hr>
    <?php 
            if (isset($_SESSION["borrada"])) {
                echo $_SESSION["borrada"];
                unset($_SESSION["borrada"]);
            }
        ?>
    <form action="logica_unid.php" method="post">
        <table class="panel">
            <tr>
                <th>Número</th>
                <th>Nombre</th>
                <th>Asignatura</th>
                <th></th>
            </tr>
            <?php panelUnid(); ?>
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