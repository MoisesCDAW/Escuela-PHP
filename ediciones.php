<?php 
include "CRUD.php";?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ediciones</title>
</head>
<body>
    <?php
        if (isset($_SESSION["DOM"])) {
            echo $_SESSION["DOM"];
        }

        if (isset($_SESSION["mensaje"])) {
            echo $_SESSION["mensaje"];
            $_SESSION["mensaje"] = "";
        }

        if (isset($_SESSION["volver"])) {
            echo $_SESSION["volver"];
        }
    ?>
</body>
</html>