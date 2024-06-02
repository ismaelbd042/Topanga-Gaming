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
        // Realizar la inserción en la tabla de Contacto
        $insertar_contacto = "INSERT INTO Contacto (nombre, correo, mensaje) 
                             VALUES ('$nombreApellidos', '$correo', '$descripcion')";

        if (mysqli_query($conexion, $insertar_contacto)) {
            // La inserción fue exitosa
            echo "Mensaje Enviado.";
        } else {
            // Error al insertar
            echo "Error al enviar el mensaje: " . mysqli_error($conexion);
        }
    } else {
        echo "Por favor, complete todos los campos del formulario.";
    }

    // Cerrar la conexión
    mysqli_close($conexion);
}

