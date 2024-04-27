<?php
include_once "../database/connect.php"; // Incluye el archivo de conexión a la base de datos
$conn = getConexion(); // Obtiene la conexión a la base de datos

// Obtener el nombre de usuario enviado desde el frontend
$data = json_decode(file_get_contents('php://input'), true);
$username = $data['username'];

// Preparar la consulta SQL con una instrucción preparada para evitar la inyección de SQL
$sql = "SELECT COUNT(*) AS count FROM usuarios WHERE nombre_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

// Obtener el resultado de la consulta
$stmt->bind_result($count);
$stmt->fetch();

// Devolver el resultado como JSON
$exists = $count > 0 ? true : false;
echo json_encode(array('exists' => $exists));

// Cerrar la conexión y liberar los recursos
$stmt->close();
$conn->close();
