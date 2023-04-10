<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>

    </script>
    <title>Document</title>
</head>
<body>
    <?php

        if (!isset($_SESSION['user'])) {
            header('Location: ../login.php');
            exit;
        } else {
    ?>

        <h1> Modificar usuario </h1>

        <?php
        }
        ?>
</body>
</html>
