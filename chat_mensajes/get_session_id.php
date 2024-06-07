<?php
include_once "../database/connect.php";
$conn = getConexion();
session_start();
$usuario_id = $_SESSION['id'];

// Devolver el ID de sesión como respuesta en formato JSON
echo json_encode(array('usuario_id' => $usuario_id));
?>
