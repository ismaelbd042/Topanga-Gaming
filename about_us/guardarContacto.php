<?php
include "../database/connect.php"; // Incluir el archivo que contiene la función getConexion().

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $conexion = getConexion(); // Obtener una conexión a la base de datos.

    // Recuperar los datos del formulario
    $nombreApellidos = $_POST["nombre"] ?? '';
    $correo = $_POST["correo"] ?? '';
    $descripcion = $_POST["mensaje"] ?? '';

    // Validar que los campos no estén vacíos
    if (!empty($nombreApellidos) && !empty($correo) && !empty($descripcion)) {
        // Preparar la inserción en la tabla de Contacto
        $insertar_contacto = $conexion->prepare("INSERT INTO Contacto (nombre, correo, mensaje) VALUES (?, ?, ?)");
        $insertar_contacto->bind_param("sss", $nombreApellidos, $correo, $descripcion);

        if ($insertar_contacto->execute()) {
            // La inserción fue exitosa
            echo "Mensaje Enviado.";
        } else {
            // Error al insertar
            echo "Error al enviar el mensaje: " . $conexion->error;
        }

        // Cerrar la sentencia
        $insertar_contacto->close();
    } else {
        echo "Por favor, complete todos los campos del formulario.";
    }

    // Cerrar la conexión
    $conexion->close();
}
