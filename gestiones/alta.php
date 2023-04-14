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
            header('Location: ../login.php');
            exit;
        } else {
            require ('conexion.php');
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                if (isset($_POST['dni']) && isset($_POST['nombre']) && isset($_POST['apellidos'])
                && isset($_POST['direccion']) && isset($_POST['poblacion']) && isset($_POST['provincia'])
                && isset($_POST['cp']) && isset($_POST['puesto']) && isset($_POST['plaza'])) {
                    $dni = $_POST['dni'];
                    $nombre   = $_POST['nombre'];
                    $apellidos = $_POST['apellidos'];
                    $direccion = $_POST['direccion'];
                    $poblacion = $_POST['poblacion'];
                    $provincia = $_POST['provincia'];
                    $cp = $_POST['cp'];
                    $puesto = $_POST['puesto'];
                    $plaza = $_POST['plaza'];

                    $clases_label = [];
                    $clases_input = [];
                    $error = ['dni' => [], 'nombre' => [], 'apellidos' => [], 'direccion' => [],
                    'poblacion' => [], 'provincia' => [], 'cp' => [], 'puesto' => [], 'plaza' => []];

                    foreach (['dni', 'nombre', 'apellidos', 'direccion', 'poblacion',
                    'provincia', 'cp', 'puesto', 'plaza'] as $e) {
                        $clases_label[$e] = '';
                        $clases_input[$e] = '';
                    }

                    $query = "SELECT * FROM trabajadores
                              WHERE dni = '$dni';";
                    $resultado = pg_query($con, $query);

                    if (isset($dni, $nombre, $apellidos,
                    $direccion, $poblacion, $provincia, $cp, $puesto, $plaza)) {
                        if ($_POST['dni'] == '') {
                            $error['dni'][] = 'El dni del trabajador es obligatorio.';
                        }else if(pg_num_rows($resultado) == 1) {
                            $error['dni'][] = "El trabajador ya esta dado de alta.";
                        } else if (preg_match('/^[0-9]{8}[TRWAGMYFPDXBNJZSQVHLCKE]$/i', $_POST['dni']) !== 1) {
                            $error['dni'][] = "El dni no se encuentra en el formato correcto.";
                        }

                        if ($_POST['nombre'] == '') {
                            $error['nombre'][] = 'El nombre del trabajador es obligatorio.';
                        } else if (preg_match('/^[a-zA-Z\s]+$/', $_POST['nombre']) !== 1) {
                            $error['nombre'][] = "El nombre no se encuentra en el formato correcto.";
                        }

                        if ($_POST['apellidos'] == '') {
                            $error['apellidos'][] = 'Los apellidos del trabajador son obligatorio.';
                        } else if (preg_match('/^[a-zA-Z\s]+$/', $_POST['apellidos']) !== 1) {
                            $error['apellidos'][] = "Los apellidos no se encuentra en el formato correcto.";
                        }

                        if ($_POST['direccion'] == '') {
                            $error['direccion'][] = 'La dirección del trabajador es obligatoria.';
                        } else if (preg_match('/^[a-zA-Z0-9\s]+$/', $_POST['direccion']) !== 1) {
                            $error['direccion'][] = "La dirección no se encuentra en el formato correcto.";
                        }

                        if ($_POST['poblacion'] == '') {
                            $error['poblacion'][] = 'La población del trabajador es obligatoria.';
                        } else if (preg_match('/^[a-zA-Z\s]+$/', $_POST['poblacion']) !== 1) {
                            $error['poblacion'][] = "La población no se encuentra en el formato correcto.";
                        }

                        if ($_POST['provincia'] == '') {
                            $error['provincia'][] = 'La provincia del trabajador es obligatoria.';
                        } else if (preg_match('/^[a-zA-Z\s]+$/', $_POST['provincia']) !== 1) {
                            $error['provincia'][] = "La provincia no se encuentra en el formato correcto.";
                        }

                        if ($_POST['cp'] == '') {
                            $error['cp'][] = 'El codigo postal del trabajador es obligatorio.';
                        } else if (preg_match('/^[0-9]{5}+$/', $_POST['cp']) !== 1) {
                            $error['cp'][] = "El codigo postal no se encuentra en el formato correcto.";
                        }

                        if ($_POST['puesto'] == '') {
                            $error['puesto'][] = 'El puesto del trabajador es obligatorio.';
                        } else if (preg_match('/^[a-zA-Z\s]+$/', $_POST['puesto']) !== 1) {
                            $error['puesto'][] = "El puesto no se encuentra en el formato correcto.";
                        }

                        if ($_POST['plaza'] == '') {
                            $error['plaza'][] = 'La plaza del trabajador es obligatoria.';
                        } else if (preg_match('/^[a-zA-Z\s]+$/', $_POST['plaza']) !== 1) {
                            $error['plaza'][] = "La plaza no se encuentra en el formato correcto.";
                        }

                        if ($_POST['controlador'] == 'si'){
                            $controlador = true;
                        } else if ($_POST['controlador'] == 'no'){
                            $controlador = false;
                        }

                        $vacio = true;

                        foreach ($error as $err) {
                            if (!empty($err)) {
                                $vacio = false;
                                break;
                            }
                        }

                        if ($vacio) {
                            $registrar = "INSERT INTO usuarios (usuario, contrasena)
                                        VALUES ('$user', '$password')";
                            pg_query($con, $registrar);
                            header('Location: login.php');
                        }
                    }
                }
            }
        } ?>
        <h1>Dar de Alta a un trabajador</h1>
            <form action="" method="POST">
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
                <input type="radio" name="controlador" value="si" required> Sí
                <input type="radio" name="controlador" value="no" required> No
                <br>
                <input type="submit" value="Guardar">
            </form>
    </div>
</body>
</html>
