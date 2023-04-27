<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="formulario">
    <h1>Comprobar que usted esta dado de alta:</h1>
        <form action="consulta.php" method="POST">
            <label for="dni">Introduzca su DNI para comprobar si está en el sistema:</label>
            <input type="text" name="dni" id="dni">
            <br>

            <input type="submit" value="Buscar">
        </form>
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
                if (isset($_POST['dni'])) {
                    $dni = $_POST['dni'];

                    $query = "SELECT * FROM trabajadores
                              WHERE dni = '$dni';";
                    $resultado = pg_query($con, $query);

                    if (pg_num_rows($resultado) == 0) {
                        echo "no se encontró a ningun trabajador con ese DNI.";
                    } else {
                        echo "<br><table>";
                        echo "<tr><th>DNI</th><th>Nombre</th><th>Apellidos</th>
                        <th>Dirección</th><th>Población</th><th>Provincia</th>
                        <th>Código Postal</th><th>Puesto</th><th>Plaza</th>
                        <th>Controlador</th></tr>";
                        while ($fila = pg_fetch_assoc($resultado)) {
                            echo "<tr><td>". $fila['dni'] . "</td><td>" . $fila['nombre']
                            . "</td><td>" . $fila['apellidos'] . "</td><td>" . $fila['direccion']
                            . "</td><td>" . $fila['poblacion'] . "</td><td>" . $fila['provincia']
                            . "</td><td>" . $fila['cp'] . "</td><td>" . $fila['puesto']
                            . "</td><td>" . $fila['plaza'] . "</td><td>" . $fila['controlador'] . "</td></tr>";
                        }
                        echo "</table>";
                    }
                }
            }
            pg_close($con);
        }
        ?>
</body>
</html>
