<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="formulario">
        <?php session_start();
        if (!isset($_SESSION['tiempo'])) {
            $_SESSION['tiempo'] = time();
        }
        else if (time() - $_SESSION['tiempo'] > 180) {
            session_destroy();
            header("Location: ../login.php");
            die();
        }
        $_SESSION['tiempo'] = time();
        if (!isset($_SESSION['user'])) {
            header('Location: ../login.php');
            exit;
        } else {
        ?>

            <h1>Dar de Baja a un trabajador</h1>
            <form action="alta.php" method="POST">
                <label for="dni">Introduzca el DNI del trabajador al que debes dar de baja:</label>
                <input type="text" name="dni" required>
                <br>
                <input type="submit" value="Guardar">
            </form>
        <?php
            require 'conexion.php';
            $dni = $_POST['dni'];
            $consulta = "SELECT * FROM trabajadores
                            WHERE dni = '$dni';";

            $query = "DELETE FROM trabajadores
                      WHERE dni = '$dni';";

            $res = pg_query($con, $consulta);

            if (pg_num_rows($res) == 1) {
                pg_query($con, $query);
                echo "<div class='aceptar'>El trabajador ha sido dado de baja con exito.</div>";
            } else {
                echo "<div class='error'>El DNI introducido no pertenece a ningún trabajador registrado.</div>";
            }
            }
            pg_close($con);
        ?>
    </div>
</body>
</html>
