<?php
include_once "../database/connect.php";
$conn = getConexion();
session_start();
$usuario_id = $_SESSION['id'];
$friend_id = $_GET['friend_id'];

// Verificar si la conexión está establecida correctamente
if ($conn) {
    // Consultar mensajes
    $sql = "SELECT * FROM mensajes WHERE (emisor_id = ? AND receptor_id = ?) OR (emisor_id = ? AND receptor_id = ?) ORDER BY fecha";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiii", $usuario_id, $friend_id, $friend_id, $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $messages = array();
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }

    echo json_encode($messages);

    $stmt->close();
    $conn->close();
} else {
    echo "Error: No se pudo establecer la conexión a la base de datos.";
}
?>
