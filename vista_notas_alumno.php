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
        <!-- <tr>
            <td>DSW</td>
            <td>10</td>
        </tr>
        <tr>
            <td>DEW</td>
            <td>10</td>
        </tr> -->
    </table>
    <br>
    <hr>
    <p>
        Nota Final del curso: 
    </p>
    <br>
    <!-- <hr>
    <p>Por asignatura</p>
    <select>
        <option>DSW</option>
        <option>DEW</option>
    </select>
    <br>
    <br>
    <table class="panel2">
        <tr>
            <th>Nº Unidad</th>
            <th>Unidad</th>
            <th>Nota</th>
        </tr>
        <tr>
            <td>1</td>
            <td>Introducción</td>
            <td>10</td>
        </tr>
        <tr>
            <td>2</td>
            <td>CRUD</td>
            <td>10</td>
        </tr>
    </table> -->


    <br>
    <br>
    <form action="alumn_vista.php" method="post">
        <button name="opcion" value="volver">Volver</button>
    </form>
</body>
</html>