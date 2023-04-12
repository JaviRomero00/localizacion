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

            <h1>Dar de Alta a un trabajador</h1>
            <form action="index.php" method="POST">
                <label for="dni">DNI:</label>
                <input type="text" name="dni" required>
                <br>
                <label for="nombre">NOMBRE:</label>
                <input type="text" name="nombre" required>
                <br>
                <label for="apellidos">APELLIDOS:</label>
                <input type="text" name="apellidos" required>
                <br>
                <label for="direccion">DIRECCIÓN:</label>
                <input type="text" name="direccion" required>
                <br>
                <label for="poblacion">POBLACIÓN:</label>
                <input type="text" name="poblacion" required>
                <br>
                <label for="provincia">PROVINCIA:</label>
                <input type="text" name="provincia" required>
                <br>
                <label for="cp">CODIGO POSTAL:</label>
                <input type="text" name="cp" required>
                <br>
                <label for="puesto">PUESTO:</label>
                <input type="text" name="puesto" required>
                <br>
                <label for="plaza">PLAZA:</label>
                <input type="text" name="plaza" required>
                <br>
                <label for="controlador">CONTROLADOR:</label>
                <input type="radio" name="controlador" value=true required> Sí
                <input type="radio" name="controlador" value=false required> No
                <br>
                <input type="submit" value="Guardar">
            </form>
        <?php } ?>
        <?php
            require 'conexion.php';
            $dni = $_POST['dni'];
            $nombre   = $_POST['nombre'];
            $apellidos = $_POST['apellidos'];
            $direccion = $_POST['direccion'];
            $poblacion = $_POST['poblacion'];
            $provincia = $_POST['provincia'];
            $cp = $_POST['cp'];
            $puesto = $_POST['puesto'];
            $plaza = $_POST['plaza'];
            $controlador = $_POST['controlador'];

            if (preg_match('/^[0-9]{8}[TRWAGMYFPDXBNJZSQVHLCKE]+$/', $_POST['dni']) &&
            preg_match('/^[a-zA-Z\s]+$/', $_POST['nombre']) &&
            preg_match('/^[a-zA-Z\s]+$/', $_POST['apellidos']) &&
            preg_match('/^[a-zA-Z\s]+$/', $_POST['direccion']) &&
            preg_match('/^[a-zA-Z\s]+$/', $_POST['poblacion']) &&
            preg_match('/^[a-zA-Z\s]+$/', $_POST['provincia']) &&
            preg_match('/^[0-9]{5}+$/', $_POST['cp']) &&
            preg_match('/^[a-zA-Z\s]+$/', $_POST['puesto']) &&
            preg_match('/^[a-zA-Z\s]+$/', $_POST['plaza'])) {
                $query = "INSERT INTO trabajadores (dni, nombre, apellidos,
                         direccion, poblacion, provincia, cp, puesto, plaza, controlador)
                            VALUES ('$dni', '$nombre', '$apellidos', '$direccion',
                            '$poblacion', '$provincia', '$cp', '$puesto', '$plaza',
                            '$controlador') RETURNING id;";

                $consulta = "SELECT * FROM contactos
                            WHERE dni = '$dni';";

                $res = pg_query($con, $consulta);

                if (pg_num_rows($res) == 0) {
                    pg_query($con, $query);
                    echo "<div class='aceptar'>Contacto guardado correctamente</div>";
                } else {
                    echo "<div class='error'>Error al guardar el contacto, el teléfono ya esta registrado</div>";
                }
            } else {
                echo 'fallo';
            }
            pg_close($con);
        ?>
    </div>
</body>
</html>
