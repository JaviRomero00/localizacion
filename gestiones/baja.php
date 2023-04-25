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
            require '../conexion.php';
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                if (isset($_POST['dni'])) {
                    $dni = $_POST['dni'];

                    $clases_label = [];
                    $clases_input = [];
                    $error = ['dni' => []];

                    foreach (['dni'] as $e) {
                        $clases_label[$e] = '';
                        $clases_input[$e] = '';
                    }

                    $query = "SELECT * FROM trabajadores
                              WHERE dni = '$dni';";
                    $resultado = pg_query($con, $query);

                    if (isset($dni)) {
                        if ($_POST['dni'] == '') {
                            $error['dni'][] = 'Introduzca un DNI.';
                        }else if(pg_num_rows($resultado) !== 1) {
                            $error['dni'][] = "El trabajador no esta dado de alta.";
                        } else if (preg_match('/^[0-9]{8}[TRWAGMYFPDXBNJZSQVHLCKE]$/i', $_POST['dni']) !== 1) {
                            $error['dni'][] = "El dni no se encuentra en el formato correcto.";
                        }

                        $vacio = true;

                        foreach ($error as $err) {
                            if (!empty($err)) {
                                $vacio = false;
                                break;
                            }
                        }

                        if ($vacio) {
                            $eliminar = "DELETE FROM trabajadores WHERE dni = '$dni'";
                            pg_query($con, $eliminar);
                            echo pg_last_error($con);
                            echo "El trabajador con DNI '$dni' ha sido dado de baja con exito";
                        }
                    }
                }
            }
        }
        ?>

        <h1>Dar de Baja a un trabajador</h1>
        <form method="POST">
            <label for="dni" class="<?= $clases_label['dni'] ?>">DNI:</label>
            <input type="text" name="dni" id="dni" class="<?= $clases_input['dni'] ?>">
            <?php foreach ($error['dni'] as $err): ?>
                <p><span>Error!! <?= $err ?></p>
            <?php endforeach ?>
            <br>
            <input type="submit" value="Eliminar">
        </form>
    </div>
</body>
</html>
