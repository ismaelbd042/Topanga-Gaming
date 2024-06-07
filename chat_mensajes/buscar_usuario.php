<?php
include_once "../database/connect.php";
$conn = getConexion();
session_start();

$busqueda = $_GET['busqueda'];
$busqueda = "%{$conn->real_escape_string($busqueda)}%";
$usuario_id = $_SESSION['id'];

$sql = "SELECT id, nombre_usuario, correo 
        FROM usuarios 
        WHERE nombre_usuario LIKE ? 
        AND id NOT IN (
            SELECT amigo_id 
            FROM amigos 
            WHERE usuario_id = ? 
            UNION 
            SELECT usuario_id 
            FROM amigos 
            WHERE amigo_id = ?
        )
        AND id != ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("siii", $busqueda, $usuario_id, $usuario_id, $usuario_id);
$stmt->execute();
$resultado = $stmt->get_result();

$usuarios = array();
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $usuarios[] = $fila;
    }
}

header('Content-Type: application/json');
echo json_encode($usuarios);

$stmt->close();
$conn->close();
