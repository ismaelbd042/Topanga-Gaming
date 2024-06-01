<?php
session_start(); // Asegúrate de que session_start() sea lo primero en el script

include_once "../database/connect.php"; // Usar include_once o require_once para evitar múltiples inclusiones

// Verificar si se ha enviado una solicitud POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el valor del elemento de la barra lateral seleccionado por el usuario
    $selectedItem = $_POST['selectedItem'];

    // Realizar una acción basada en el elemento seleccionado
    if ($selectedItem == 'meGustaSidebar') {
        // Realizar la consulta SQL correspondiente para el elemento "Me Gusta"
        $idAutor = $_SESSION['id'];
        $sql = "SELECT videos.id, videos.nombreVideo, videos.video, usuarios.nombre_usuario
        FROM videos
        JOIN usuarios ON videos.idAutor = usuarios.id 
        JOIN meGusta ON videos.id = meGusta.idVideo
        WHERE meGusta.idUsuario = $idAutor
        ORDER BY videos.id DESC";
    } elseif ($selectedItem == 'canalSidebar') {
        // Realizar la consulta SQL correspondiente para el elemento "Mis Vídeos"
        $idAutor = $_SESSION['id']; // Asume que el ID del usuario está almacenado en la sesión
        $sql = "SELECT videos.id, videos.nombreVideo, videos.video, usuarios.nombre_usuario 
            FROM videos 
            JOIN usuarios ON videos.idAutor = usuarios.id 
            WHERE videos.idAutor = $idAutor
            ORDER BY videos.id DESC";
        $isCanalSidebar = true;
    } elseif ($selectedItem == 'suscripcionesSidebar') {
        // Realizar la consulta SQL correspondiente para el elemento "Suscripciones"
        $idAutor = $_SESSION['id'];
        $sql = "SELECT videos.id, videos.nombreVideo, videos.video, usuarios.nombre_usuario
        FROM videos
        JOIN usuarios ON videos.idAutor = usuarios.id 
        JOIN suscripciones ON videos.idAutor = suscripciones.idStreamer
        WHERE suscripciones.idUsuario = $idAutor
        ORDER BY videos.id DESC";
    } else {
        // Realizar la consulta SQL correspondiente para el elemento "Inicio" (o cualquier otra acción predeterminada)
        $sql = "SELECT videos.id, videos.nombreVideo, videos.video, usuarios.nombre_usuario 
            FROM videos 
            JOIN usuarios ON videos.idAutor = usuarios.id
            ORDER BY videos.id DESC";

    }

    // Ejecutar la consulta SQL y mostrar el resultado
    $conn = getConexion();
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="video-item" data-nombre-video="' . $row['nombreVideo'] . '" data-nombre-autor="' . $row['nombre_usuario'] . '">';
            echo '<a href="video.php?id=' . $row['id'] . '">';
            echo '<video>';
            echo '<source src="' . $row['video'] . '" type="video/mp4">';
            echo 'Your browser does not support the video tag.';
            echo '</video>';
            echo '<div class="play-icon"></div>';
            echo '</a>';
            echo '<h2>' . $row['nombreVideo'] . '</h2>';
            echo '<p>@ ' . $row['nombre_usuario'] . '</p>';
            echo '</div>';
        }

    } else {
        echo '<div class="divNoHayVideos">';
        echo '<img src="../img/Icons/noVideos.png" alt="No hay videos icono" class="imgNoVideos">';
        echo '<p id="noVideosMessage">Lo sentimos, no hay videos en esta sección.</p>';
        echo '</div>';
    }

    exit; // Finalizar la ejecución del script después de mostrar el resultado
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="video_area.css">
    <link rel="stylesheet" href="../Index/style.css">
    <link rel="shortcut icon" href="../img/Logo fondo blanco.svg" type="image/x-icon">
    <title>Topanga Gaming</title>
</head>

<body>
    <div class="divHeaderYFooter">
        <div class="overlay"></div>
        <?php
        include "../header y footer/header.html";
        include "../header y footer/VentanaModal.html";
        ?>
    </div>
    <div class="divPrincipalVideos">
        <nav class="sidebarVideos">
            <ul>
                <li class="inicioSidebar" id="inicioSidebar"><a><img src="../img/Icons/inicio.png" alt="">Inicio</a>
                </li>
                <li class="meGustaSidebar" id="meGustaSidebar"><a><img src="../img/Icons/megusta.png" alt="">Me
                        Gusta</a></li>
                <li class="canalSidebar" id="canalSidebar"><a><img src="../img/Icons/misvideos.png" alt="">Mis
                        Vídeos</a></li>
                <li class="suscripcionesSidebar" id="suscripcionesSidebar"><a><img src="../img/Icons/suscripciones.png"
                            alt="">Suscripciones</a></li>
            </ul>
        </nav>

        <!-- Aquí va el contenido principal de la página -->
        <div class="main-contentVideos">
            <div class="search-containerVideo">
                <div class="search-wrapper">
                    <img src="../img/Icons/lupa.png" alt="" class="search-icon">
                    <input type="text" id="searchInputVideo" placeholder="Buscar por nombre de video o autor">
                </div>
            </div>
            <div class="divWrapVideos" id="videoContainer">
                <?php
                $sql = "SELECT videos.id, videos.nombreVideo, videos.video, usuarios.nombre_usuario
                FROM videos
                JOIN usuarios ON videos.idAutor = usuarios.id 
                ORDER BY videos.id DESC";

                // Ejecutar la consulta SQL y mostrar el resultado
                $conn = getConexion();
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="video-item" data-nombre-video="' . $row['nombreVideo'] . '"
                    data-nombre-autor="' . $row['nombre_usuario'] . '">';
                        echo '<a href="video.php?id=' . $row['id'] . '">';
                        echo '<video>';
                        echo '
                            <source src="' . $row['video'] . '" type="video/mp4">';
                        echo 'Your browser does not support the video tag.';
                        echo '
                        </video>';
                        echo '<div class="play-icon"></div>';
                        echo '</a>';
                        echo '<h2>' . $row['nombreVideo'] . '</h2>';
                        echo '<p>@ ' . $row['nombre_usuario'] . '</p>';
                        echo '</div>';
                    }
                } else {
                    echo '<p id="noVideosMessage">No se encontraron videos.</p>';
                }
                ?>
            </div>
            <p id="noVideosMessage" style="display: none;">No se encontraron resultados.</p>
            <div class="upload-video-container">
                <button class="upload-video-button" onclick="location.href='upload_video.php'">Subir Video</button>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Obtener todos los elementos de la barra lateral
                const sidebarItems = document.querySelectorAll('.sidebarVideos li');

                // Agregar la clase 'selected' al primer elemento de la barra lateral
                sidebarItems[0].classList.add('selected');

                // Agregar un evento click a cada elemento
                sidebarItems.forEach(item => {
                    item.addEventListener('click', function () {
                        // Eliminar la clase 'selected' de todos los elementos de la barra lateral
                        sidebarItems.forEach(item => {
                            item.classList.remove('selected');
                        });

                        // Agregar la clase 'selected' al elemento clickeado
                        this.classList.add('selected');

                        // Obtener el id del elemento clickeado
                        const selectedItem = this.getAttribute('id');

                        // Realizar una petición AJAX para cargar el contenido correspondiente basado en el id seleccionado
                        fetch(window.location.href, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: 'selectedItem=' + selectedItem
                        })
                            .then(response => response.text())
                            .then(data => {
                                // Actualizar el contenido de acuerdo a la respuesta del servidor
                                document.getElementById('videoContainer').innerHTML = data;
                            })
                            .catch(error => {
                                console.error('Error:', error);
                            });
                    });
                });
            });



            document.getElementById('searchInputVideo').addEventListener('input', function () {
                const searchTerm = this.value.toLowerCase();
                const videos = document.querySelectorAll('.video-item');
                let visibleCount = 0;

                videos.forEach(video => {
                    const nombreVideo = video.getAttribute('data-nombre-video').toLowerCase();
                    const nombreAutor = video.getAttribute('data-nombre-autor').toLowerCase();
                    if (nombreVideo.includes(searchTerm) || nombreAutor.includes(searchTerm)) {
                        video.style.display = 'block';
                        visibleCount++;
                    } else {
                        video.style.display = 'none';
                    }
                });

                const noVideosMessage = document.getElementById('noVideosMessage');
                if (visibleCount === 0) {
                    noVideosMessage.style.display = 'block';
                } else {
                    noVideosMessage.style.display = 'none';
                }
            });
        </script>

        <script src="../Index/script.js"></script>
</body>

</html>