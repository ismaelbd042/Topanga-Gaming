<?php
session_start();

// Verificar si existe la sesión y si contiene el nombre de usuario
if (isset($_SESSION['nombre_usuario'])) {
    $respuesta['sesion_activa'] = true;
    $respuesta['nombre_usuario'] = $_SESSION['nombre_usuario'];
} else {
    $respuesta['sesion_activa'] = false;
}

// Devolver respuesta en formato JSON
echo json_encode($respuesta);
