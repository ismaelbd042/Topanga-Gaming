<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Index/style.css">
    <link rel="stylesheet" href="video.css">
    <link rel="shortcut icon" href="../img/Logo fondo blanco.svg" type="image/x-icon">
    <title>Topanga Gaming</title>
    <style>
        .upload-video-form-container {
            position: relative;
            z-index: 2;
            background-color: #000033;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }

        .upload-video-form-container form {
            display: flex;
            flex-direction: column;
        }

        .upload-video-form-container label {
            margin-bottom: 10px;
            color: white;
        }

        .upload-video-form-container input[type="text"],
        .upload-video-form-container input[type="file"] {
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #5F1495;
            border-radius: 4px;
            background-color: #fff;
            color: #000;
        }

        .upload-video-form-container input[type="submit"] {
            padding: 10px;
            border: none;
            border-radius: 4px;
            background-color: #5F1495;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .upload-video-form-container input[type="submit"]:hover {
            background-color: #440a69;
        }

        .upload-video-form-container h1 {
            margin-bottom: 20px;
            text-align: center;
            color: #5F1495;
        }

        .container_subir_video {
            height: 100%;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 5%;
        }
    </style>

</head>

<body>
    <div class="overlay"></div>
    <?php
    session_start(); // Iniciar sesión si no se ha iniciado aún

    include "../header y footer/header.html";
    include "../header y footer/VentanaModal.html";
    include "../database/connect.php";

    $conn = getConexion();

    // Verificar si el formulario fue enviado
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["videoFile"])) {
        // Obtener los datos del formulario
        $nombreVideo = $_POST['nombreVideo'];
        $idAutor = $_SESSION['id']; // Asume que el ID del usuario está almacenado en la sesión

        // Manejar la subida del archivo
        $target_dir = "videosMP4/"; // Use the absolute path
        $target_file = $target_dir . basename($_FILES["videoFile"]["name"]);
        $uploadOk = 1;
        $videoFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Verificar si el archivo es un video
        $check = mime_content_type($_FILES["videoFile"]["tmp_name"]);
        if (strpos($check, "video/") !== 0) {
            echo "El archivo no es un video.";
            $uploadOk = 0;
        }

        // Verificar si el archivo ya existe
        if (file_exists($target_file)) {
            echo "El archivo ya existe.";
            $uploadOk = 0;
        }

        // Verificar el tamaño del archivo
        if ($_FILES["videoFile"]["size"] > 50000000) { // 50MB máximo
            echo "El archivo es demasiado grande.";
            $uploadOk = 0;
        }

        // Permitir ciertos formatos de video
        $allowedFormats = ["mp4"];
        if (!in_array($videoFileType, $allowedFormats)) {
            echo "Solo se permiten archivos MP4.";
            $uploadOk = 0;
        }

        // Verificar si $uploadOk es 0 debido a un error
        if ($uploadOk == 0) {
            echo "Tu archivo no fue subido.";
            // Si todo está bien, intentar subir el archivo
        } else {
            if (move_uploaded_file($_FILES["videoFile"]["tmp_name"], $target_file)) {
                // Insertar datos del video en la base de datos
                $sql = "INSERT INTO videos (nombreVideo, video, idAutor) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssi", $nombreVideo, $target_file, $idAutor);

                if ($stmt->execute()) {
                    echo "El video " . htmlspecialchars(basename($_FILES["videoFile"]["name"])) . " ha sido subido.";
                } else {
                    echo "Hubo un error al subir tu video.";
                }
            } else {
                echo "Hubo un error al subir tu archivo.";
            }
        }
    }
    ?>

    <div class="container_subir_video">
        <div class="upload-video-form-container">
            <form action="upload_video.php" method="post" enctype="multipart/form-data">
                <label for="nombreVideo">Nombre del Video:</label>
                <input type="text" name="nombreVideo" id="nombreVideo" required>

                <label for="videoFile">Selecciona el Video:</label>
                <input type="file" name="videoFile" id="videoFile" accept="video/*" required>

                <input type="submit" value="Subir Video" name="submit">
            </form>
        </div>
    </div>
</body>
<script src="../Index/script.js"></script>

</html>