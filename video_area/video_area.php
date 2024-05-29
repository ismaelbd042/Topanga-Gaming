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
        include "../database/connect.php";
        ?>
    </div>
    <div class="divPrincipalVideos">
        <nav class="sidebarVideos">
            <ul>
                <li><a href="#inicio"><img src="../img/Icons/inicio.png" alt="">Inicio</a></li>
                <li><a href="#me-gusta"><img src="../img/Icons/megusta.png" alt="">Me Gusta</a></li>
                <li><a href="#mi-canal"><img src="../img/Icons/misvideos.png" alt="">Mis Vídeos</a></li>
                <li><a href="#suscripciones"><img src="../img/Icons/suscripciones.png" alt="">Suscripciones</a></li>
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
            <div class="divWrapVideos">
                <?php
                $conn = getConexion();

                $sql = "SELECT videos.id, videos.nombreVideo, videos.video, usuarios.nombre_usuario 
            FROM videos 
            JOIN usuarios ON videos.idAutor = usuarios.id";
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
                    echo '<p id="noVideosMessage">No se encontraron videos.</p>';
                }
                ?>
            </div>
            <p id="noVideosMessage" style="display: none;">No se encontraron resultados.</p>
        </div>

        <script>
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