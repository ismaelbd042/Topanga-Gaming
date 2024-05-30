<?php
include_once "../database/connect.php";

$conexion = getConexion();
// Obtener los datos enviados desde el cliente
$data = json_decode(file_get_contents('php://input'), true);

// Construir la consulta para buscar los fantasmas
$sql = "SELECT pf.fantasma_id AS id_fantasma
        FROM pruebas_fantasmas pf
        JOIN pruebas p ON p.id = pf.prueba_id
        WHERE p.nombre IN (";

// Construir la lista de nombres de prueba para la consulta SQL
$pruebas = array_map(function ($prueba) {
    return "'" . $prueba . "'";
}, $data);

$sql .= implode(",", $pruebas) . ")
GROUP BY pf.fantasma_id
HAVING COUNT(DISTINCT p.nombre) = " . count($pruebas);

$resultado = $conexion->query($sql);

$ids_fantasmas = array();

if ($resultado) {
    // Procesar el resultado si es necesario
    while ($fila = $resultado->fetch_assoc()) {
        // Guardar los IDs de los fantasmas encontrados en un array
        $ids_fantasmas[] = $fila['id_fantasma'];
    }
} else {
    // Manejar el error si la consulta falla
    echo json_encode(array("error" => $conexion->error));
}

// Cerrar la conexión a la base de datos
$conexion->close();

// Devolver los IDs de los fantasmas como un array JSON
echo json_encode($ids_fantasmas);
