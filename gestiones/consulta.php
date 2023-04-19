<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dar de alta</title>
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
            header("Location: ../login.php");
            exit;
        } else {

        }
        ?>
