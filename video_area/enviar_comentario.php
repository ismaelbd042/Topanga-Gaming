<?php
// Incluir la conexión a la base de datos
include '../database/connect.php';
$conexion = getConexion();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idVideo = intval($_POST['idVideo']);
    $idUsuario = intval($_POST['idUsuario']);
    $comment = $_POST['comment'];

    // Insertar el comentario en la base de datos
    $sqlInsert = "INSERT INTO comentarios (idVideo, idUsuario, comment) VALUES (?, ?, ?)";
    $stmt = $conexion->prepare($sqlInsert);
    $stmt->bind_param("iis", $idVideo, $idUsuario, $comment);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Comentario enviado correctamente.";
    } else {
        echo "Error al enviar el comentario.";
    }

    $stmt->close();
    $conexion->close();
}
?>
