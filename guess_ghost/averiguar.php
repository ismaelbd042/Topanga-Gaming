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

// Construir la consulta SQL con un switch basado en la combinación de datos
switch ($combination) {
    case '100': // Solo pruebas
        $sql = "SELECT f.id AS id_fantasma
                FROM fantasmas f
                JOIN pruebas_fantasmas pf ON f.id = pf.fantasma_id
                JOIN pruebas p ON pf.prueba_id = p.id
                WHERE p.nombre IN (";
        $pruebaNombres = array_map(function ($prueba) {
            return "'" . $prueba . "'";
        }, $pruebas);
        $sql .= implode(",", $pruebaNombres) . ")
                GROUP BY f.id
                HAVING COUNT(DISTINCT p.nombre) = " . count($pruebas);
        break;
    case '010': // Solo cordura
        $sql = "SELECT f.id AS id_fantasma
                FROM fantasmas f
                WHERE f.cordura " . implode(' OR ', $cordura);
        break;
    case '001': // Solo velocidad
        $sql =
            "SELECT f.id AS id_fantasma
                FROM fantasmas f
                WHERE f.velocidad_desc LIKE '%" . implode("%' AND f.cordura LIKE '%", $velocidad) . "%'";
        break;
    case '110': // Pruebas y cordura
        $sql = "SELECT f.id AS id_fantasma
            FROM fantasmas f
            JOIN pruebas_fantasmas pf ON f.id = pf.fantasma_id
            JOIN pruebas p ON pf.prueba_id = p.id
            WHERE p.nombre IN (";
        $pruebaNombres = array_map(function ($prueba) {
            return "'" . $prueba . "'";
        }, $pruebas);
        $sql .= implode(",", $pruebaNombres) . ")
            AND (f.cordura " . implode(' OR f.cordura ', $cordura) . ")
            GROUP BY f.id
            HAVING COUNT(DISTINCT p.nombre) = " . count($pruebas);
        break;
    case '101': // Pruebas y velocidad
        $sql = "SELECT f.id AS id_fantasma
            FROM fantasmas f
            JOIN pruebas_fantasmas pf ON f.id = pf.fantasma_id
            JOIN pruebas p ON pf.prueba_id = p.id
            WHERE p.nombre IN (";
        $pruebaNombres = array_map(function ($prueba) {
            return "'" . $prueba . "'";
        }, $pruebas);
        $sql .= implode(",", $pruebaNombres) . ")
            AND (f.velocidad_desc LIKE '%" . implode("%' AND f.velocidad_desc LIKE '%", $velocidad) . "%')";
        break;

    case '011': // Cordura y velocidad
        $sql = "SELECT f.id AS id_fantasma
            FROM fantasmas f
            WHERE (f.cordura " . implode(' OR f.cordura ', $cordura) . ")
            AND (f.velocidad_desc LIKE '%" . implode("%' AND f.velocidad_desc LIKE '%", $velocidad) . "%')";
        break;

    case '111': // Pruebas, cordura y velocidad
        $sql = "SELECT f.id AS id_fantasma
            FROM fantasmas f
            JOIN pruebas_fantasmas pf ON f.id = pf.fantasma_id
            JOIN pruebas p ON pf.prueba_id = p.id
            WHERE p.nombre IN (";
        $pruebaNombres = array_map(function ($prueba) {
            return "'" . $prueba . "'";
        }, $pruebas);
        $sql .= implode(",", $pruebaNombres) . ")
            AND (f.cordura " . implode(' OR f.cordura ', $cordura) . ")
            AND (f.velocidad_desc LIKE '%" . implode("%' AND f.velocidad_desc LIKE '%", $velocidad) . "%')
            GROUP BY f.id
            HAVING COUNT(DISTINCT p.nombre) = " . count($pruebas);
        break;
    default:
        echo json_encode(array("error" => "No se han proporcionado nombres de prueba, cordura o velocidad."));
        exit;
}

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
    exit;
}

// Cerrar la conexión a la base de datos
$conexion->close();

// Devolver los IDs de los fantasmas como un array JSON
echo json_encode($ids_fantasmas);
