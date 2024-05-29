<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Index/style.css">
    <link rel="stylesheet" href="video.css">
    <link rel="shortcut icon" href="../img/Logo fondo blanco.svg" type="image/x-icon">
    <title>Topanga Gaming</title>
</head>

<body>
    <div class="overlay"></div>
    <?php
    include "../header y footer/header.html";
    include "../header y footer/VentanaModal.html";
    include "../database/connect.php";

    $conn = getConexion();

    // Verificar si se proporciona un ID de video válido en la URL
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        // Obtener el ID del video de la URL
        $video_id = $_GET['id'];

        // Preparar la consulta para seleccionar el video de la base de datos
        $sql = "SELECT nombreVideo, video FROM videos WHERE id = ?";

        // Preparar la declaración
        $stmt = $conn->prepare($sql);

        // Vincular parámetros
        $stmt->bind_param("i", $video_id);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el resultado de la consulta
        $result = $stmt->get_result();

        // Verificar si se encontró el video
        if ($result->num_rows == 1) {
            // Obtener los datos del video
            $video = $result->fetch_assoc();
        } else {
            // Si no se encuentra el video, redirigir a otra página o mostrar un mensaje de error
            header('Location: index.php'); // Redirigir a la página principal
            exit();
        }
    } else {
        // Si no se proporciona un ID válido, redirigir a otra página o mostrar un mensaje de error
        header('Location: index.php'); // Redirigir a la página principal
        exit();
    }

    // Cerrar la conexión a la base de datos
    $stmt->close();
    $conn->close();
    ?>
    <div class="divVideoComentarios">
        <h1><?php echo $video['nombreVideo']; ?></h1>
        <div class="divVideoAbierto">
            <video controls>
                <source src="<?php echo $video['video']; ?>" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
        <!-- Aquí puedes incluir la sección de comentarios u otros detalles del video -->
    </div>
    <script src="../Index/script.js"></script>
</body>

</html>