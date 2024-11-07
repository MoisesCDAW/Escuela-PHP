<?php 
    session_start(); 
    // include "CRUD.php";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignaturas</title>
</head>
<body>

    <p>CREAR ASIGNATURA</p>
    <form action="CRUD.php" method="post">
        <input type="text" placeholder="Nombre de la asignatura" name="asignatura">
        <button name="enviar" value="input-asig">Enviar</button>
    </form>
    <hr>

    <form action="inicio.php" method="post">
        <button name="opcion" value="volver">Volver</button>
    </form>
</body>
</html>