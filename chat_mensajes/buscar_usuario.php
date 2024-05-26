<?php
include_once "../database/connect.php";
$conn = getConexion();
session_start();

$busqueda = $_GET['busqueda'];
$busqueda = $conn->real_escape_string($busqueda);

$sql = "SELECT id, nombre_usuario, correo 
        FROM usuarios 
        WHERE nombre_usuario LIKE '%$busqueda%' 
          AND id NOT IN (
              SELECT amigo_id 
              FROM amigos 
              WHERE usuario_id = {$_SESSION['id']}
              UNION
              SELECT usuario_id 
              FROM amigos 
              WHERE amigo_id = {$_SESSION['id']}
          )
          AND id != {$_SESSION['id']}";

$resultado = $conn->query($sql);

$usuarios = array();
if ($resultado->num_rows > 0) {
    while($fila = $resultado->fetch_assoc()) {
        $usuarios[] = $fila;
    }
}

header('Content-Type: application/json');
echo json_encode($usuarios);

$conn->close();
?>
