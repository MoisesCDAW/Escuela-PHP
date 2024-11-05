
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>

</head>
<body>
    
    <br>
    
    <!-- ASIGNATURA -->
    <form action="logica.php" method="post">
        <input type="text" placeholder="Nombre de la asignatura" name="asignatura">
        <button name="enviar" id="input-asig">Enviar</button>
    </form>

    <br><br>

    <!-- ALUMNO -->
    <form action="logica.php" method="post">
        <input type="text" placeholder="DNI del alumno" name="dni-alumn">
        <input type="text" placeholder="Nombre del alumno" name="nombre-alumn">
        <input type="text" placeholder="Apellidos del alumno" name="apell-alumn">
        <select>
            <?php 
                include "logica.php";

                // for ($i=0; $i < 5; $i++) { 
                //     echo "<option>$asig</option>";
                // } 
            ?>
        </select>
        <button name="enviar" id="input-alumn">Enviar</button>
    </form>

    <br><br>

    <!-- UNIDAD -->
    <form action="logica.php" method="post">
        <input type="text" placeholder="Número de la unidad" name="unidad">
        <button name="enviar" id="input-asig">Enviar</button>
    </form>

    <br><br>

    <!-- ACTIVIDAD -->
    <form action="logica.php" method="post">
        <input type="text" placeholder="Título de la actividad" name="actividad">
        <button name="enviar" id="input-asig">Enviar</button>
    </form>


</body>
</html>