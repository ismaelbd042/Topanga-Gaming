<?php
include_once "../database/connect.php";
$conn = getConexion();
session_start();

$usuario_id = $_SESSION['id'];

// Consulta SQL para obtener los amigos del usuario actual con la solicitud aceptada
$consulta = "SELECT usuario_id, amigo_id FROM amigos WHERE ((usuario_id = ? AND aceptada = 'SI') OR (amigo_id = ? AND aceptada = 'SI'))";

// Ejecutar la consulta preparada
$stmt = $conn->prepare($consulta);

// Verificar si la preparación de la consulta fue exitosa
if ($stmt) {
    // Vincular parámetros
    $stmt->bind_param("ii", $usuario_id, $usuario_id);

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
            $amigo_id = $fila['amigo_id'];
            $usuario_amigo_id = $fila['usuario_id'];

            // Determinar el ID del amigo correcto
            $id_correcto = ($amigo_id == $usuario_id) ? $usuario_amigo_id : $amigo_id;

            // Consulta preparada para obtener los datos del usuario basado en el ID del amigo correcto
            $consulta2 = "SELECT * FROM usuarios WHERE id = ?";
            $stmt2 = $conn->prepare($consulta2);

            // Verificar si la preparación de la consulta fue exitosa
            if ($stmt2) {
                // Vincular parámetros
                $stmt2->bind_param("i", $id_correcto);

                // Ejecutar la consulta
                $stmt2->execute();

                // Obtener el resultado de la consulta
                $resultado2 = $stmt2->get_result();

                // Verificar si la consulta arrojó resultados
                if ($resultado2->num_rows > 0) {
                    // Obtener los datos del usuario
                    while ($fila_usuario = $resultado2->fetch_assoc()) {
                        $datos_usuario[] = $fila_usuario;
                    }
                }
                // Cerrar la declaración
                $stmt2->close();
            } else {
                // Si la preparación de la consulta falla, manejar el error según sea necesario
                echo "Error en la preparación de la consulta.";
            }
        }

        // Devolver los amigos en formato JSON
        echo json_encode($datos_usuario);
    } else {
        // No se encontraron amigos
        echo "No se encontraron amigos.";
    }
    // Cerrar la declaración
    $stmt->close();
} else {
    // Si la preparación de la consulta falla, manejar el error según sea necesario
    echo "Error en la preparación de la consulta.";
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
