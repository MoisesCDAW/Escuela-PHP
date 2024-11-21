<?php 
    include "logica_act.php";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actividades</title>

    <style>
        .panel {
            width: 1150px;
            text-align: center;
        }
    </style>

</head>
<body>

    <p>CREAR ACTIVIDAD - <?php echo "Código Asig.: " . ASIG . " -> Unidad Nº " . UNIDAD?></p>
    <form action="logica_act.php" method="post">
        <input type="number" placeholder="Número de Actividad" name="numero">
        <input type="text" placeholder="Nombre de la Actividad" name="nombre" style='width:250px;'>
        <br>
        <br>
        <button name="gestion" value="crear-act">Crear</button>
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

    <p>GESTIONAR ACTIVIDAD</p>
    <hr>
    <?php 
            if (isset($_SESSION["borrada"])) {
                echo $_SESSION["borrada"];
                unset($_SESSION["borrada"]);
            }
        ?>
    <form action="logica_act.php" method="post">
        <table class="panel">
            <tr>
                <th>Número</th>
                <th>Nombre</th>
                <th>Nº Unid.</th>
                <th>Nom. Unid.</th>
                <th></th>
            </tr>
            <?php panelAct(); ?>
        </table>
    </form>
    <hr>

    <br>
    <br>
    <form action="vista_unid.php" method="post">
        <button name="opcion" value="volver">Volver</button>
    </form>
</body>
</html>