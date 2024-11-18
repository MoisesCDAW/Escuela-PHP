<?php 
    include "logica_notas_alumno.php";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notas Alumno</title>

    <style>
        .panel {
            width: 200px;
            text-align: center;
        }

        .panel2 {
            width: 300px;
            text-align: center;
        }
    </style>
</head>
<body>

    <p>Generales</p>
    <table class="panel">
        <tr>
            <th>Asignatura</th>
            <th>Nota</th>
        </tr>
        <?php 
            $final = general();
        ?>
    </table>
    <br>
    <hr>
    <p>
        Nota Final del curso: <?php echo $final?>
    </p>
    <br>

    <br>
    <br>
    <form action="alumn_vista.php" method="post">
        <button name="opcion" value="volver">Volver</button>
    </form>
</body>
</html>