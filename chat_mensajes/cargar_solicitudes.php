<?php
include_once "../database/connect.php";

try {
    $conn = getConexion();
    session_start();

    $usuario_id = $_SESSION['id'];

    // Consulta SQL para obtener los datos de los usuarios que han enviado solicitud
    $consulta = "
        SELECT u.*
        FROM amigos a
        JOIN usuarios u ON a.usuario_id = u.id
        WHERE a.amigo_id = ? AND a.aceptada = 'NO'
    ";

    // Ejecutar la consulta preparada
    if ($stmt = $conn->prepare($consulta)) {
        // Vincular parámetros
        $stmt->bind_param("i", $usuario_id);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el resultado de la consulta
        $resultado = $stmt->get_result();

        // Verificar si la consulta arrojó resultados
        if ($resultado->num_rows > 0) {
            // Array para almacenar los datos de usuario
            $datos_usuario = [];

            // Recorrer los resultados y obtener los datos de usuario
            while ($fila = $resultado->fetch_assoc()) {
                $datos_usuario[] = $fila;
            }

            // Devolver los amigos en formato JSON
            echo json_encode($datos_usuario);
        } else {
            // No se encontraron amigos
            echo json_encode(["mensaje" => "No se encontraron amigos."]);
        }

        // Cerrar la declaración
        $stmt->close();
    } else {
        // Si la preparación de la consulta falla, manejar el error según sea necesario
        echo json_encode(["error" => "Error en la preparación de la consulta."]);
    }

    // Cerrar la conexión a la base de datos
    $conn->close();
} catch (Exception $e) {
    echo json_encode(["error" => "Excepción capturada: " . $e->getMessage()]);
}
?>
