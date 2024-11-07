<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>

</head>
<body>
    
    <br>

    <form action="inicio.php" method="post">
        <button name="opcion" value="asig">Asignaturas</button>
        <button name="opcion" value="alumn">Alumnos</button>
    </form>

    <!-- UNIDAD -->
    <!-- <form action="logica.php" method="post">
        <input type="text" placeholder="Número de la unidad" name="unidad">
        <select name="asig-uni">
            <?php 
                // if (isset($_SESSION["asignaturas"])) {
                //     $array = $_SESSION["asignaturas"];

                //     foreach ($array as $x){
                //         echo "<option value='".$x[0]."'>".$x[0]."</option>";
                //     }
                // }
            ?>
        </select>
        <button name="enviar" value="input-uni">Enviar</button>
    </form>

    <br><br> -->

    <!-- ACTIVIDAD -->
    <!-- <form action="logica.php" method="post">
        <input type="text" placeholder="Título de la actividad" name="actividad">
        <input type="text" placeholder="Número de la unidad" name="unidad-act">
        <button name="enviar" value="input-act">Enviar</button>
    </form> -->

    <br><br>

    <!-- CALIFICACIONES -->
    <!-- <form action="logica.php" method="post">
        <input type="text" placeholder="DNI del alumno" name="dni-cal">
        <input type="text" placeholder="Título de la actividad" name="act-cal">
        <input type="text" placeholder="Calificación" name="nota">
        <button name="enviar" value="input-cal">Enviar</button>
    </form> -->

</body>
</html>