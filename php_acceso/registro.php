<?php
include_once "../database/connect.php";
$conn = getConexion();
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $respuesta = [
        'success' => false,
        'error' => null
    ];

    $correo = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['pswd']);
    $nombre = mysqli_real_escape_string($conn, $_POST['usuario']);

    // Verificar si todos los campos necesarios están presentes y no están vacíos
    if (!empty($correo) && !empty($password) && !empty($nombre)) {
        $stmt_create_user = mysqli_prepare($conn, "INSERT INTO usuarios (nombre_usuario, correo, contrasena) VALUES (?, ?, ?)");
        $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hashear la contraseña antes de almacenarla
        mysqli_stmt_bind_param($stmt_create_user, "sss", $nombre, $correo, $hashed_password);
        $create_user_success = mysqli_stmt_execute($stmt_create_user);

        if ($create_user_success) {
            $respuesta['success'] = true; // Éxito al crear el usuario
            $id_usuario = mysqli_insert_id($conn); // Obtener el ID del usuario recién creado
            $_SESSION['id'] = $id_usuario; // Establece el ID del usuario en la sesión
            $_SESSION['nombre_usuario'] = $nombre; // Establece el nombre del usuario en la sesión
        } else {
            $respuesta['error'] = 'Error al crear el usuario en la base de datos.';
        }
    }


    header('Content-Type: application/json'); // Establece el tipo de contenido de la respuesta como JSON
    echo json_encode($respuesta); // Codifica el array de respuesta en formato JSON y lo imprime

    // Cerrar las consultas preparadas
    if (isset($stmt_check_user)) {
        mysqli_stmt_close($stmt_check_user);
    }
    if (isset($stmt_create_user)) {
        mysqli_stmt_close($stmt_create_user);
    }

    mysqli_close($conn); // Cierra la conexión a la base de datos
    header("location: ..\Index\index.php");
}
