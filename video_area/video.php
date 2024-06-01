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
    session_start(); // Iniciar sesión si no se ha iniciado aún
    
    include "../header y footer/header.html";
    include "../header y footer/VentanaModal.html";
    include "../database/connect.php";

    $conn = getConexion();

    // Verificar si se proporciona un ID de video válido en la URL
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        // Obtener el ID del video de la URL
        $video_id = $_GET['id'];

        // Preparar la consulta para seleccionar el video de la base de datos
        $sql = "SELECT videos.nombreVideo, videos.video, usuarios.nombre_usuario, usuarios.id AS idAutor
            FROM videos
            JOIN usuarios ON videos.idAutor = usuarios.id
            WHERE videos.id = ?";

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

            // Verificar si el usuario está suscrito al autor del video
            if (isset($_SESSION['id'])) {
                $idUsuario = $_SESSION['id'];
                $idAutor = $video['idAutor'];
                $sql_subscripcion = "SELECT * FROM suscripciones WHERE idUsuario = ? AND idStreamer = ?";
                $stmt_subscripcion = $conn->prepare($sql_subscripcion);
                $stmt_subscripcion->bind_param("ii", $idUsuario, $idAutor);
                $stmt_subscripcion->execute();
                $result_subscripcion = $stmt_subscripcion->get_result();

                $sql_meGusta = "SELECT * FROM megusta WHERE idUsuario = ? AND idVideo = ?";
                $stmt_megusta = $conn->prepare($sql_meGusta);
                $stmt_megusta->bind_param("ii", $idUsuario, $video_id);
                $stmt_megusta->execute();
                $result_megusta = $stmt_megusta->get_result();

                // Si existe una fila de suscripción, el usuario está suscrito al autor
                $suscripcion_activa = ($result_subscripcion->num_rows == 1);
                $megusta_activa = ($result_megusta->num_rows == 1);
            } else {
                $suscripcion_activa = false;
                $megusta_activa = false;
            }
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

    if (isset($_GET['id'])) {
        $idVideo = intval($_GET['id']); // Obtener y sanitizar el ID del video
    } else {
        echo "No se ha proporcionado un ID de video.";
        exit;
    }

    // Obtener comentarios del video específico
    $sqlComentarios = "SELECT * FROM comentarios WHERE idVideo = ?";
    $stmt = $conn->prepare($sqlComentarios);
    $stmt->bind_param("i", $idVideo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    $comentarios = [];
    if ($resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
            $comentarios[] = $fila;
        }
    }

    // Cerrar la conexión a la base de datos
    $stmt->close();
    $conn->close();
    ?>
    <div class="divVideoComentarios">
        <div class="divVideoAbierto">
            <h1><?php echo $video['nombreVideo']; ?></h1>
            <video controls>
                <source src="<?php echo $video['video']; ?>" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <div class="divAbajoVideo">
                <p>@<?php echo $video['nombre_usuario']; ?>
                    <?php if ($suscripcion_activa): ?>
                        <button class="subscribeButton" id="cancelarSuscripcion">
                            <img src="../img/Icons/suscribirseCancelar.png" alt="Campana Suscripción"
                                class="imgCampanaSuscripcion">
                            Cancelar suscripción
                        </button>
                    <?php else: ?>
                        <button class="subscribeButton" id="aceptarSuscripcion">
                            <img src="../img/Icons/suscribirse.png" alt="Campana Suscripción" class="imgCampanaSuscripcion">
                            Suscribirse
                        </button>
                    <?php endif; ?>
                </p>
                <div class="tooltip">
                    <?php if ($megusta_activa): ?>
                        <img src="../img/Icons/corazonRelleno.png" alt="Corazon de me gusta" class="imgCorazon"
                            id="nolikeButton">
                        <span class="tooltiptext">No me gusta</span>
                    <?php else: ?>
                        <img src="../img/Icons/corazon.png" alt="Corazon de me gusta" class="imgCorazon" id="likeButton">
                        <span class="tooltiptext">Me gusta</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="divComentarios">
            <h2>Comentarios del vídeo</h2>
            <div class="divEnviarComentario">
                <?php if (!empty($comentarios)): ?>
                    <?php foreach ($comentarios as $comentario): ?>
                        <div class="comentario">
                            <p><?php echo htmlspecialchars($comentario['idUsuario']); ?>:
                                <?php echo htmlspecialchars($comentario['comment']); ?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p id="noComentarios">¡Sé el primero en comentar!</p>
                <?php endif; ?>
            </div>
            <form id="comentarioForm">
                <input type="hidden" id="idUsuario" value="1"><!-- ID del usuario que está comentando -->
                <textarea id="comment" required></textarea>
                <button type="submit">Enviar comentario</button>
            </form>
        </div>
    </div>

    <script src="../Index/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            // Suscripción
            $("#aceptarSuscripcion").click(function () {
                suscribirse(<?php echo $video['idAutor']; ?>);
            });

            $("#cancelarSuscripcion").click(function () {
                cancelarSuscripcion(<?php echo $video['idAutor']; ?>);
            });

            // Me gusta
            $("#nolikeButton").click(function () {
                quitarMeGusta(<?php echo $video_id; ?>);
            });

            $("#likeButton").click(function () {
                darMeGusta(<?php echo $video_id; ?>);
            });
        });

        function suscribirse(idAutor) {
            $.ajax({
                type: "POST",
                url: "suscribirse.php",
                data: { idAutor: idAutor },
                success: function (response) {
                    $("#aceptarSuscripcion")
                        .html('<img src="../img/Icons/suscribirseCancelar.png" alt="Campana Suscripción" class="imgCampanaSuscripcion"> Cancelar suscripción')
                        .attr("id", "cancelarSuscripcion")
                        .unbind("click")
                        .click(function () {
                            cancelarSuscripcion(idAutor);
                        });
                }
            });
        }

        function cancelarSuscripcion(idAutor) {
            $.ajax({
                type: "POST",
                url: "cancelar_suscripcion.php",
                data: { idAutor: idAutor },
                success: function (response) {
                    $("#cancelarSuscripcion")
                        .html('<img src="../img/Icons/suscribirse.png" alt="Campana Suscripción" class="imgCampanaSuscripcion"> Suscribirse')
                        .attr("id", "aceptarSuscripcion")
                        .unbind("click")
                        .click(function () {
                            suscribirse(idAutor);
                        });
                }
            });
        }

        function darMeGusta(video_id) {
            $.ajax({
                type: "POST",
                url: "dar_megusta.php",
                data: { video_id: video_id },
                success: function (response) {
                    $("#likeButton")
                        .attr("src", "../img/Icons/corazonRelleno.png")
                        .attr("id", "nolikeButton")
                        .unbind("click")
                        .click(function () {
                            quitarMeGusta(video_id);
                        });
                    $(".tooltiptext")
                        .html("No me gusta")
                },
                error: function (response) {
                    console.log("Error al dar Me Gusta: " + response);
                }
            });
        }

        function quitarMeGusta(video_id) {
            $.ajax({
                type: "POST",
                url: "quitar_megusta.php",
                data: { video_id: video_id },
                success: function (response) {
                    $("#nolikeButton")
                        .attr("src", "../img/Icons/corazon.png")
                        .attr("id", "likeButton")
                        .unbind("click")
                        .click(function () {
                            darMeGusta(video_id);
                        });
                    $(".tooltiptext")
                        .html("Me gusta")
                },
                error: function (response) {
                    console.log("Error al quitar Me Gusta: " + response);
                }
            });
        }

        $(document).ready(function () {
            $('#comentarioForm').submit(function (event) {
                event.preventDefault(); // Evita que el formulario se envíe de la manera tradicional

                var idVideo = <?php echo $idVideo; ?>;
                var idUsuario = $('#idUsuario').val();
                var comment = $('#comment').val();

                $.ajax({
                    url: 'enviar_comentario.php',
                    method: 'POST',
                    data: {
                        idVideo: idVideo,
                        idUsuario: idUsuario,
                        comment: comment
                    },
                    success: function (response) {
                        // Verificar si existe el mensaje "No hay comentarios"
                        var noComentariosMsg = $('#noComentarios');
                        if (noComentariosMsg.length) {
                            noComentariosMsg.remove(); // Eliminar el mensaje
                        }
                        // Agregar el nuevo comentario a la lista de comentarios
                        $('.divEnviarComentario').append('<div class="comentario"><p>' + idUsuario + ': ' + comment + '</p></div>');
                        // Limpiar el formulario
                        $('#comentarioForm')[0].reset();
                    }
                });
            });
        });

    </script>



</body>

</html>