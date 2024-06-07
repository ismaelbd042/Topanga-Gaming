<?php
include_once "../database/connect.php";

$conexion = getConexion();
// Obtener los datos enviados desde el cliente
$data = json_decode(file_get_contents('php://input'), true);

// Arrays separados
$pruebas = isset($data['pruebas']) ? $data['pruebas'] : [];
$cordura = isset($data['cordura']) ? $data['cordura'] : [];
$velocidad = isset($data['velocidad']) ? $data['velocidad'] : [];

// Verificar la combinación de datos presentes
$combination = (!empty($pruebas) ? '1' : '0') . (!empty($cordura) ? '1' : '0') . (!empty($velocidad) ? '1' : '0');

// Inicializar consulta SQL y parámetros
$sql = "";
$params = [];
$types = "";

// Construir la consulta SQL con un switch basado en la combinación de datos
switch ($combination) {
    case '100': // Solo pruebas
        $placeholders = implode(',', array_fill(0, count($pruebas), '?'));
        $sql = "SELECT f.id AS id_fantasma
                FROM fantasmas f
                JOIN pruebas_fantasmas pf ON f.id = pf.fantasma_id
                JOIN pruebas p ON pf.prueba_id = p.id
                WHERE p.nombre IN ($placeholders)
                GROUP BY f.id
                HAVING COUNT(DISTINCT p.nombre) = ?";
        $params = array_merge($pruebas, [count($pruebas)]);
        $types = str_repeat('s', count($pruebas)) . 'i';
        break;
    case '010': // Solo cordura
        $conditions = array_map(function ($cond) {
            return "f.cordura " . $cond;
        }, $cordura);
        $sql = "SELECT f.id AS id_fantasma
                FROM fantasmas f
                WHERE " . implode(' AND ', $conditions);
        break;
    case '001': // Solo velocidad
        $conditions = array_map(function ($cond) {
            return "f.velocidad_desc LIKE ?";
        }, $velocidad);
        $sql = "SELECT f.id AS id_fantasma
                FROM fantasmas f
                WHERE " . implode(' AND ', $conditions);
        $params = array_map(function ($cond) {
            return "%" . $cond . "%";
        }, $velocidad);
        $types = str_repeat('s', count($velocidad));
        break;
    case '110': // Pruebas y cordura
        $placeholders = implode(',', array_fill(0, count($pruebas), '?'));
        $conditions = array_map(function ($cond) {
            return "f.cordura " . $cond;
        }, $cordura);
        $sql = "SELECT f.id AS id_fantasma
                FROM fantasmas f
                JOIN pruebas_fantasmas pf ON f.id = pf.fantasma_id
                JOIN pruebas p ON pf.prueba_id = p.id
                WHERE p.nombre IN ($placeholders)
                AND " . implode(' AND ', $conditions) . "
                GROUP BY f.id
                HAVING COUNT(DISTINCT p.nombre) = ?";
        $params = array_merge($pruebas, [count($pruebas)]);
        $types = str_repeat('s', count($pruebas)) . 'i';
        break;
    case '101': // Pruebas y velocidad
        $placeholders = implode(',', array_fill(0, count($pruebas), '?'));
        $conditions = array_map(function ($cond) {
            return "f.velocidad_desc LIKE ?";
        }, $velocidad);
        $sql = "SELECT f.id AS id_fantasma
                FROM fantasmas f
                JOIN pruebas_fantasmas pf ON f.id = pf.fantasma_id
                JOIN pruebas p ON pf.prueba_id = p.id
                WHERE p.nombre IN ($placeholders)
                AND " . implode(' AND ', $conditions) . "
                GROUP BY f.id
                HAVING COUNT(DISTINCT p.nombre) = ?";
        $params = array_merge($pruebas, array_map(function ($cond) {
            return "%" . $cond . "%";
        }, $velocidad), [count($pruebas)]);
        $types = str_repeat('s', count($pruebas)) . str_repeat('s', count($velocidad)) . 'i';
        break;
    case '011': // Cordura y velocidad
        $corduraConditions = array_map(function ($cond) {
            return "f.cordura " . $cond;
        }, $cordura);
        $velocidadConditions = array_map(function ($cond) {
            return "f.velocidad_desc LIKE ?";
        }, $velocidad);
        $sql = "SELECT f.id AS id_fantasma
                FROM fantasmas f
                WHERE " . implode(' AND ', $corduraConditions) . "
                AND " . implode(' AND ', $velocidadConditions);
        $params = array_map(function ($cond) {
            return "%" . $cond . "%";
        }, $velocidad);
        $types = str_repeat('s', count($velocidad));
        break;
    case '111': // Pruebas, cordura y velocidad
        $placeholders = implode(',', array_fill(0, count($pruebas), '?'));
        $corduraConditions = array_map(function ($cond) {
            return "f.cordura " . $cond;
        }, $cordura);
        $velocidadConditions = array_map(function ($cond) {
            return "f.velocidad_desc LIKE ?";
        }, $velocidad);
        $sql = "SELECT f.id AS id_fantasma
                FROM fantasmas f
                JOIN pruebas_fantasmas pf ON f.id = pf.fantasma_id
                JOIN pruebas p ON pf.prueba_id = p.id
                WHERE p.nombre IN ($placeholders)
                AND " . implode(' AND ', $corduraConditions) . "
                AND " . implode(' AND ', $velocidadConditions) . "
                GROUP BY f.id
                HAVING COUNT(DISTINCT p.nombre) = ?";
        $params = array_merge($pruebas, array_map(function ($cond) {
            return "%" . $cond . "%";
        }, $velocidad), [count($pruebas)]);
        $types = str_repeat('s', count($pruebas)) . str_repeat('s', count($velocidad)) . 'i';
        break;
    default:
        echo json_encode(array("error" => "No se han proporcionado nombres de prueba, cordura o velocidad."));
        exit;
}

$stmt = $conexion->prepare($sql);
if ($types) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$resultado = $stmt->get_result();

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
    exit;
}

// Cerrar la conexión a la base de datos
$conexion->close();

// Devolver los IDs de los fantasmas como un array JSON
echo json_encode($ids_fantasmas);
