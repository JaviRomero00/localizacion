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
        echo 'buenas tardes';
        require 'conexion.php';
        $actual = $_SESSION['user'];
        $query = "SELECT rol FROM usuarios WHERE usuario = '$actual';";
        $resultado = pg_query_params($con, $query, array($actual));
        $rol = pg_fetch_result($resultado, 0, 'rol');
        echo $rol;
        if ($rol == 'admin') {
            echo 'hola administrador';
        }
        else {
            echo 'hola no administrador';
        }
        pg_close($con);
    ?>
</body>
</html>
