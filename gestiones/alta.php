<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../gestiones.css">
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
            require '../conexion.php';
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                if (isset($_POST['dni']) && isset($_POST['nombre']) && isset($_POST['apellidos'])
                && isset($_POST['direccion']) && isset($_POST['poblacion']) && isset($_POST['provincia'])
                && isset($_POST['cp']) && isset($_POST['puesto']) && isset($_POST['plaza'])
                && isset($_POST['controlador'])) {
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

                    $clases_label = [];
                    $clases_input = [];
                    $error = ['dni' => [], 'nombre' => [], 'apellidos' => [], 'direccion' => [],
                    'poblacion' => [], 'provincia' => [], 'cp' => [], 'puesto' => [], 'plaza' => [],
                    'controlador' =>[]];

                    foreach (['dni', 'nombre', 'apellidos', 'direccion', 'poblacion',
                    'provincia', 'cp', 'puesto', 'plaza', 'controlador'] as $e) {
                        $clases_label[$e] = '';
                        $clases_input[$e] = '';
                    }

                    $query = "SELECT * FROM trabajadores
                              WHERE dni = '$dni';";
                    $resultado = pg_query($con, $query);

                    if (isset($dni, $nombre, $apellidos,
                    $direccion, $poblacion, $provincia, $cp, $puesto, $plaza, $controlador)) {
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

                        if ($_POST['controlador'] == 'si') {
                            $controlador = true;
                        } else if ($_POST['controlador2'] == 'no') {
                            $controlador = false;
                        } else {
                            $error['controlador'][] = "Debe marcar alguna de las opciones.";
                        }

                        $vacio = true;

                        foreach ($error as $err) {
                            if (!empty($err)) {
                                $vacio = false;
                                break;
                            }
                        }

                        if ($vacio) {
                            $registrar = "INSERT INTO trabajadores (dni, nombre, apellidos,
                            direccion, poblacion, provincia, cp, puesto, plaza, controlador)
                                        VALUES ('$dni', '$nombre', '$apellidos', '$direccion',
                                        '$poblacion', '$provincia', '$cp', '$puesto', '$plaza',
                                        '$controlador') RETURNING id;";
                            pg_query($con, $registrar);
                            echo pg_last_error($con);
                            echo 'registrado con exito';
                        }
                    }
                }
            }
        }
        ?>
        <h1>Dar de Alta a un trabajador</h1>
            <form action="alta.php" method="POST">
                <label for="dni" class="<?= $clases_label['dni'] ?>">DNI:</label>
                <input type="text" name="dni" id="dni" class="<?= $clases_input['dni'] ?>">
                <?php foreach ($error['dni'] as $err): ?>
                    <p><span>Error!! <?= $err ?></p>
                <?php endforeach ?>

                <label for="nombre" class="<?= $clases_label['nombre'] ?>">NOMBRE:</label>
                <input type="text" name="nombre" id="nombre" class="<?= $clases_input['nombre'] ?>">
                <?php foreach ($error['nombre'] as $err): ?>
                    <p><span>Error!! <?= $err ?></p>
                <?php endforeach ?>

                <label for="apellidos" class="<?= $clases_label['apellidos'] ?>">APELLIDOS:</label>
                <input type="text" name="apellidos" id="apellidos" class="<?= $clases_input['apellidos'] ?>">
                <?php foreach ($error['apellidos'] as $err): ?>
                    <p><span>Error!! <?= $err ?></p>
                <?php endforeach ?>

                <label for="direccion" class="<?= $clases_label['direccion'] ?>">DIRECCIÓN:</label>
                <input type="text" name="direccion" id="direccion" class="<?= $clases_input['direccion'] ?>">
                <?php foreach ($error['direccion'] as $err): ?>
                    <p><span>Error!! <?= $err ?></p>
                <?php endforeach ?>

                <label for="poblacion" class="<?= $clases_label['poblacion'] ?>">POBLACIÓN:</label>
                <input type="text" name="poblacion" id="poblacion" class="<?= $clases_input['poblacion'] ?>">
                <?php foreach ($error['poblacion'] as $err): ?>
                    <p><span>Error!! <?= $err ?></p>
                <?php endforeach ?>

                <label for="provincia" class="<?= $clases_label['provincia'] ?>">PROVINCIA:</label>
                <input type="text" name="provincia" id="provincia" class="<?= $clases_input['provincia'] ?>">
                <?php foreach ($error['provincia'] as $err): ?>
                    <p><span>Error!! <?= $err ?></p>
                <?php endforeach ?>

                <label for="cp" class="<?= $clases_label['cp'] ?>">CODIGO POSTAL:</label>
                <input type="text" name="cp" id="cp" class="<?= $clases_input['cp'] ?>">
                <?php foreach ($error['cp'] as $err): ?>
                    <p><span>Error!! <?= $err ?></p>
                <?php endforeach ?>

                <label for="puesto" class="<?= $clases_label['puesto'] ?>">PUESTO:</label>
                <input type="text" name="puesto" id="puesto" class="<?= $clases_input['puesto'] ?>">
                <?php foreach ($error['puesto'] as $err): ?>
                    <p><span>Error!! <?= $err ?></p>
                <?php endforeach ?>

                <label for="plaza" class="<?= $clases_label['plaza'] ?>">PLAZA:</label>
                <input type="text" name="plaza" id="plaza" class="<?= $clases_input['plaza'] ?>">
                <?php foreach ($error['plaza'] as $err): ?>
                    <p><span>Error!! <?= $err ?></p>
                <?php endforeach ?>

                <label for="controlador" class="<?= $clases_label['controlador'] ?>">CONTROLADOR:</label>
                <input type="radio" name="controlador" value="si" id="controlador-si" class="<?= $clases_input['controlador'] ?>"> Sí
                </label>
                <label for="controlador2" class="<?= $clases_label['controlador'] ?>">
                <input type="radio" name="controlador" value="no" id="controlador-no" class="<?= $clases_input['controlador'] ?>"> No
                </label>
                <?php foreach ($error['controlador'] as $err): ?>
                    <p><span>Error!! <?= $err ?></p>
                <?php endforeach ?>

                <input type="submit" value="Guardar">
            </form>
    </div>
</body>
</html>
