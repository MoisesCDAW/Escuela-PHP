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
            general();
        ?>
    </table>
    <br>
    <hr>

    <p>Por asignatura</p>
    <form action="logica_notas_alumno.php" method="post">
        <select name="asig">
            <?php pintaAsigs()?>
        </select>
        <button name="mostrar" value="notas">Mostrar</button>
    </form>

    <br>
    <br>

    <table class="panel">
        <tr>
            <th>Unidad</th>
            <th>Nota</th>
        </tr>
        <?php 
            if (isset($_SESSION["notas"])) {
                $notas = $_SESSION["notas"];
                foreach ($notas as $key => $value) {
                    echo "
                        <tr>
                            <td>$key</td>
                            <td>$value</td>
                        </tr>
                    ";
                }
                unset($_SESSION["notas"]);
            } 
        ?>
    </table>

    <br>
    <br>
    <form action="alumn_vista.php" method="post">
        <button name="opcion" value="volver">Volver</button>
    </form>
</body>
</html>