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
        #asig {
            display: flex;
            align-items: center;
            gap: 10%;
        }
    </style>

</head>
<body>

    <p>CREAR ASIGNATURA</p>
    <form action="logica_asig.php" method="post">
        <input type="text" placeholder="Nombre de la asignatura" name="asignatura">
        <button name="gestion" value="crear-asig">Crear</button>
        <?php 
            if (isset($_SESSION["creada"])) {
                echo $_SESSION["creada"];
                $_SESSION["creada"] = "";
            }
        ?>
    </form>
    <br><hr>

    <p>GESTIONAR ASIGNATURAS</p>
    <?php 
            if (isset($_SESSION["borrada"])) {
                echo $_SESSION["borrada"];
                $_SESSION["borrada"] = "";
            }
        ?>
    <form action="logica_asig.php" method="post">
        <?php 
            getAsignaturas();
        ?>
    </form>
    <hr>

    <br>
    <br>
    <form action="inicio.php" method="post">
        <button name="opcion" value="volver">Volver</button>
    </form>
</body>
</html>