<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestiones</title>
</head>
<body>
    <?php
        session_start();
        if (!isset($_SESSION['tiempo'])) {
            $_SESSION['tiempo'] = time();
        }
        else if (time() - $_SESSION['tiempo'] > 180) {
            session_destroy();
            header("Location: login.php");
            die();
        }
        $_SESSION['tiempo'] = time();
        if (!isset($_SESSION['user'])) {
            header('Location: login.php');
            exit;
        }
        require 'conexion.php';
        $actual = $_SESSION['user'];
        $query = "SELECT rol FROM usuarios WHERE usuario = '$actual';";
        $resultado = pg_query($con, $query);
        $rol = pg_fetch_assoc($resultado);
        if ($rol['rol'] == 'admin') {
            echo '<h1>hola administrador que gestion desea hacer: </h1>';
            echo '<button type="button" onclick="location.href=\'gestiones/alta.php\'">Dar de alta a un nuevo trabajador</button> <br> <br>';
            echo '<button type="button" onclick="location.href=\'gestiones/baja.php\'">Dar de baja a un trabajador</button> <br> <br>';
            echo '<button type="button" onclick="location.href=\'gestiones/consulta.php\'">Consultar datos de un trabajador</button> <br> <br>';
            echo '<button type="button" onclick="location.href=\'gestiones/modificacion.php\'">Modificar datos de un trabajador</button>';
        }
        else {
            echo 'hola no administrador';
        }
        pg_close($con);
    ?>
</body>
</html>
