<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>

</head>
<body>
    
    <br>

    <form action="index.php" method="post">
        <button name="opcion" value="asig">Asignaturas</button>
        <button name="opcion" value="alumn">Alumnos</button>
        <button name="opcion" value="unidad">Unidades</button>
    </form>

    <?php
    function inicio(){
            if (isset($_POST["opcion"])) {
                $opcion = $_POST["opcion"];

                switch ($opcion) {
                    case 'asig':
                        header("location: vista_asig.php");
                        die();
                        break;
                    
                    case 'alumn':
                        header("location: alumn_vista.php");
                        die();
                        break;

                    case 'unidad':
                        header("location: vista_unid.php");
                        die();
                        break;

                    case 'volver':
                        header("location: index.php");
                        die();
                        break;
                }
            }
        }

        inicio();
    ?>
</body>
</html>