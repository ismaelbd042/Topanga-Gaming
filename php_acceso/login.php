<?php
include_once "../database/connect.php"; // Incluye el archivo de conexión a la base de datos
$conn = getConexion(); // Obtiene la conexión a la base de datos
session_start(); // Inicia o reanuda una sesión existente

if ($_SERVER["REQUEST_METHOD"] == "POST") { // Verifica si la solicitud es de tipo POST
    $respuesta = [ // Inicializa el array de respuesta
        'success' => false,
        'error' => null
    ];

    $correo = mysqli_real_escape_string($conn, $_POST['email']); // Escapa y obtiene el valor del correo electrónico
    $password = mysqli_real_escape_string($conn, $_POST['pswd']); // Escapa y obtiene el valor de la contraseña

    // Preparar la consulta SQL utilizando una consulta preparada
    $stmt = mysqli_prepare($conn, "SELECT * FROM usuarios WHERE correo = ?");
    mysqli_stmt_bind_param($stmt, "s", $correo); // Vincula el parámetro de la consulta preparada
    mysqli_stmt_execute($stmt); // Ejecuta la consulta preparada

    // Obtener el resultado de la consulta
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) { // Verifica si se encontraron filas en el resultado
        $row = mysqli_fetch_assoc($result); // Obtiene la fila de resultados como un array asociativo
        $stored_password = $row['contrasena']; // Obtiene la contraseña almacenada del resultado
        if (password_verify($password, $stored_password)) { // Compara la contraseña proporcionada con la almacenada sin hash
            $respuesta['success'] = true; // Establece el éxito de la autenticación en verdadero
            $id_usuario = $row['id']; // Obtiene el ID del usuario
            $_SESSION['id'] = $id_usuario; // Establece el ID del usuario en la sesión
        } else {
            $respuesta['error'] = 'Contraseña incorrecta.'; // Establece un mensaje de error si la contraseña es incorrecta
        }
    } else {
        $respuesta['error'] = 'Usuario no encontrado.'; // Establece un mensaje de error si el usuario no se encuentra en la base de datos
    }

    header('Content-Type: application/json'); // Establece el tipo de contenido de la respuesta como JSON
    echo json_encode($respuesta); // Codifica el array de respuesta en formato JSON y lo imprime

    // Cerrar la conexión
    mysqli_stmt_close($stmt); // Cierra la consulta preparada
    mysqli_close($conn); // Cierra la conexión a la base de datos

    // Redireccionar solo si el inicio de sesión fue exitoso
    if ($respuesta['success']) {
        $_SESSION['nombre_usuario'] = $row['nombre_usuario'];
        header("location: ../Index/index.php"); // Redirecciona al usuario a la página de inicio
        exit();
    }
}
