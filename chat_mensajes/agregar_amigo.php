<?php
include_once "../database/connect.php";
$conn = getConexion();
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['id'])) {
    echo json_encode(['exito' => false, 'error' => 'Sesión no iniciada']);
    exit;
}

$usuario_id = $_SESSION['id'];
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['idAmigo'])) {
    echo json_encode(['exito' => false, 'error' => 'Datos incompletos']);
    exit;
}

$idAmigo = $data['idAmigo'];

// Consulta para verificar si ya existe una fila con los mismos valores
$sql_check = "SELECT * FROM amigos WHERE usuario_id = ? AND amigo_id = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("ii", $usuario_id, $idAmigo);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    // Si ya existe una fila, enviar mensaje de solicitud enviada
    echo json_encode(['exito' => false, 'error' => 'La solicitud ya ha sido enviada']);
    exit;
}

// Si no existe la fila, proceder con la inserción
$sql_insert = "INSERT INTO amigos (usuario_id, amigo_id, aceptada) VALUES (?, ?, 'NO')";
$stmt_insert = $conn->prepare($sql_insert);

if ($stmt_insert) {
    $stmt_insert->bind_param("ii", $usuario_id, $idAmigo);
    if ($stmt_insert->execute()) {
        echo json_encode(['exito' => true]);
    } else {
        echo json_encode(['exito' => false, 'error' => $stmt_insert->error]);
    }
    $stmt_insert->close();
} else {
    echo json_encode(['exito' => false, 'error' => $conn->error]);
}

$stmt_check->close();
$conn->close();
?>
