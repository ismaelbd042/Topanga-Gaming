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
        // Verificar si el nombre de usuario ya existe
        $stmt_check_username = mysqli_prepare($conn, "SELECT id FROM usuarios WHERE nombre_usuario = ?");
        mysqli_stmt_bind_param($stmt_check_username, "s", $nombre);
        mysqli_stmt_execute($stmt_check_username);
        mysqli_stmt_store_result($stmt_check_username);
        if (mysqli_stmt_num_rows($stmt_check_username) > 0) {
            $respuesta['error'] = 'El nombre de usuario ya está en uso.';
        } else {
            // Verificar si el correo electrónico ya existe
            $stmt_check_email = mysqli_prepare($conn, "SELECT id FROM usuarios WHERE correo = ?");
            mysqli_stmt_bind_param($stmt_check_email, "s", $correo);
            mysqli_stmt_execute($stmt_check_email);
            mysqli_stmt_store_result($stmt_check_email);
            if (mysqli_stmt_num_rows($stmt_check_email) > 0) {
                $respuesta['error'] = 'El correo electrónico ya está en uso.';
            } else {
                // Insertar el nuevo usuario en la base de datos
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
        }
    }

    header('Content-Type: application/json'); // Establece el tipo de contenido de la respuesta como JSON
    echo json_encode($respuesta); // Codifica el array de respuesta en formato JSON y lo imprime

    // Cerrar las consultas preparadas
    if (isset($stmt_check_username)) {
        mysqli_stmt_close($stmt_check_username);
    }
    if (isset($stmt_check_email)) {
        mysqli_stmt_close($stmt_check_email);
    }
    if (isset($stmt_create_user)) {
        mysqli_stmt_close($stmt_create_user);
    }

    mysqli_close($conn); // Cierra la conexión a la base de datos
    header("location: ..\Index\index.php");
}