<?php 
    include "logica_notas.php";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notas</title>

    <style>
        .panel {
            width: 850px;
            text-align: center;
        }
    </style>

</head>
<body>

    <p>GESTIONAR CALIFICACIONES - <?php echo "Código Asig.: " . ASIG . " -> Unidad Nº " . UNIDAD . " -> Act. Nº " . ACTIVIDAD?></p>

    <?php 
        if (isset($_SESSION["mensaje"])) {
            echo $_SESSION["mensaje"];
            unset($_SESSION["mensaje"]);
        }
    ?>
    <hr>
    <form action="logica_notas.php" method="post">
        <table class="panel">
            <tr>
                <th>DNI</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Calificación</th>
                <th></th>
            </tr>
            <?php panelNotas(); ?>
        </table>
    </form>
    <hr>

    <br>
    <br>
    <form action="vista_act.php" method="post">
        <button name="opcion" value="volver">Volver</button>
    </form>

    <br>
    <br>
    <form action="alumn_vista.php" method="post">
        <button name="opcion" value="alumnos">Alumnos</button>
    </form>

    <br>
    <br>
    <form action="vista_asig.php" method="post">
        <button name="opcion" value="asig">Asignaturas</button>
    </form>
</body>
</html>