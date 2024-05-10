<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Index/style.css">
    <link rel="shortcut icon" href="../img/Logo fondo blanco.svg" type="image/x-icon">
    <title>Topanga Gaming</title>
    <style>
        @font-face {
            font-family: OctoberCrow;
            src: url(../fonts/October\ Crow.ttf);
        }
    </style>

<body>
    <div class="overlay"></div>
    <?php
    include "../database/connect.php";
    include "../header y footer/header.html";
    include "../header y footer/VentanaModal.html";

    // Obtener la conexión a la base de datos
    $conexion = getConexion();
    ?>
    <script src="../Index/script.js"></script>

</body>

</html>