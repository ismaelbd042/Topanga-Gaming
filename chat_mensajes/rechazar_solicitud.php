<?php
include_once "../database/connect.php";

try {
    $conn = getConexion();
    session_start();

    // Obtener el ID del usuario desde la sesión
    $usuario_id = $_SESSION['id'];

    // Leer el ID del amigo desde la solicitud POST
    $data = json_decode(file_get_contents("php://input"), true);
    $amigo_id = $data['id'];

    // Verificar que los datos sean válidos
    if (!isset($amigo_id) || !isset($usuario_id)) {
        throw new Exception("Datos incompletos");
    }

    // Consulta SQL para eliminar la solicitud de amistad
    $consulta = "DELETE FROM amigos WHERE usuario_id = ? AND amigo_id = ? AND aceptada = 'NO'";

    // Preparar la consulta
    if ($stmt = $conn->prepare($consulta)) {
        // Vincular parámetros
        $stmt->bind_param("ii", $amigo_id, $usuario_id);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Verificar si se afectaron filas
            if ($stmt->affected_rows > 0) {
                // Responder con éxito
                echo json_encode(["success" => true, "message" => "Solicitud rechazada"]);
            } else {
                // No se encontró la solicitud o ya fue aceptada/cancelada
                echo json_encode(["success" => false, "message" => "No se encontró la solicitud o ya fue procesada"]);
            }
        } else {
            throw new Exception("Error al ejecutar la consulta");
        }

        // Cerrar la declaración
        $stmt->close();
    } else {
        throw new Exception("Error en la preparación de la consulta");
    }

    // Cerrar la conexión a la base de datos
    $conn->close();
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
?>
