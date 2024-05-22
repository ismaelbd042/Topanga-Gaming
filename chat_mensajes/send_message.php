<?php
include_once "../database/connect.php";
$conn = getConexion();
session_start();
$usuario_id = $_SESSION['id'];
$data = json_decode(file_get_contents("php://input"));

$friend_id = $data->friend_id;
$message = $data->message;

// Insertar mensaje
$sql = "INSERT INTO mensajes (emisor_id, receptor_id, mensaje, fecha) VALUES (?, ?, ?, NOW())";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iis", $usuario_id, $friend_id, $message);
$stmt->execute();

$stmt->close();
$conn->close();
?>
