<?php
session_start();
include "../database/connect.php";

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id'])) {
    // Manejar el caso en que el usuario no esté autenticado
    exit("Usuario no autenticado");
}

// Verificar si se proporciona el ID del autor del video
if (isset($_POST['video_id']) && is_numeric($_POST['video_id'])) {
    $video_id = $_POST['video_id'];
    $idUsuario = $_SESSION['id'];

    $conn = getConexion();

    // Eliminar la suscripción de la base de datos
    $sql = "DELETE FROM megusta WHERE idUsuario = ? AND idVideo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $idUsuario, $video_id);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    // Devolver una respuesta adecuada
    exit("Me gusta cancelado");
} else {
    // Manejar el caso en que no se proporcione un ID válido
    exit("ID de autor no válido");
}
?>
