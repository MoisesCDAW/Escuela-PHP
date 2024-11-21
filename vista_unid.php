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
            width: 850px;
            text-align: center;
        }
    </style>

</head>
<body>

    <p>CREAR UNIDAD - <?php echo "Código Asig.: " . ASIG?></p>
    <form action="logica_unid.php" method="post">
        <input type="text" placeholder="Número de Unidad" name="numero">
        <input type="text" placeholder="Nombre de la unidad" name="nombre" style='width:250px;'>
        <br>
        <br>
        <button name="gestion" value="crear-unid">Crear</button>
        <br>
        <br>
        <?php 
            if (isset($_SESSION["mensaje"])) {
                $mensajes = $_SESSION["mensaje"];

                if (!is_array($mensajes)) {
                    $mensajes = [$mensajes];
                }
                
                foreach ($mensajes as $value) {
                    echo $value;
                }
                
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
    <form action="vista_asig.php" method="post">
        <button name="opcion" value="volver">Volver</button>
    </form>
</body>
</html>