<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../gestiones.css">
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

            <h1>Modificar datos de un trabajador</h1>
            <form action="alta.php" method="POST">
                <label for="dni">Introduzca el DNI del trabajador:</label>
                <input type="text" name="dni" required>
                <br>
                <input type="submit" value="Guardar">
            </form>
        <?php
            require 'conexion.php';
            $dni = $_POST['dni'];
            $consulta = "SELECT * FROM trabajadores
                            WHERE dni = '$dni';";

            $res = pg_query($con, $consulta);

            if (pg_num_rows($res) == 1) {
                echo "<div class='aceptar'>Introduzca los datos a modificar:</div>";
            ?>
            <h1>Modificar datos de un trabajador</h1>
            <form action="alta.php" method="POST">
                <label for="nombre">NOMBRE:</label>
                <input type="text" name="nombre">
                <br>
                <label for="apellidos">APELLIDOS:</label>
                <input type="text" name="apellidos">
                <br>
                <label for="direccion">DIRECCIÓN:</label>
                <input type="text" name="direccion">
                <br>
                <label for="poblacion">POBLACIÓN:</label>
                <input type="text" name="poblacion">
                <br>
                <label for="provincia">PROVINCIA:</label>
                <input type="text" name="provincia">
                <br>
                <label for="cp">CODIGO POSTAL:</label>
                <input type="text" name="cp">
                <br>
                <label for="puesto">PUESTO:</label>
                <input type="text" name="puesto">
                <br>
                <label for="plaza">PLAZA:</label>
                <input type="text" name="plaza">
                <br>
                <label for="controlador">CONTROLADOR:</label>
                <input type="radio" name="controlador" value=true> Sí
                <input type="radio" name="controlador" value=false> No
                <br>
                <input type="submit" value="Guardar">
            </form>
            <?php
            } else {
                echo "<div class='error'>El DNI introducido no pertenece a ningún trabajador registrado.</div>";
            }
            }
            pg_close($con);
        ?>
    </div>
</body>
</html>
