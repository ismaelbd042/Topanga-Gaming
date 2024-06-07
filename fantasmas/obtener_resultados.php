<?php
// Incluir el archivo de conexión a la base de datos
include "../database/connect.php";

// Obtener la conexión a la base de datos
$conexion = getConexion();

// Obtener las pruebas seleccionadas del cuerpo de la solicitud JSON
$data = json_decode(file_get_contents("php://input"), true);
$pruebas_seleccionadas = isset($data['pruebas']) ? $data['pruebas'] : [];

// Construir la cláusula HAVING según las pruebas seleccionadas usando sentencias preparadas
$filtro = "";
$params = [];
$types = "";

if (!empty($pruebas_seleccionadas)) {
    $filtro = "HAVING ";
    $pruebas_count = count($pruebas_seleccionadas);
    for ($i = 0; $i < $pruebas_count; $i++) {
        $filtro .= "SUM(IF(pf.prueba_id = ?, 1, 0)) > 0";
        if ($i < $pruebas_count - 1) {
            $filtro .= " AND ";
        }
        $params[] = $pruebas_seleccionadas[$i];
        $types .= "i";
    }
}

// Consulta para obtener los datos de los fantasmas y sus pruebas asociadas con el filtro adecuado
$sql = "SELECT f.nombre AS nombre_fantasma, f.descripcion AS descripcion_fantasma, 
        GROUP_CONCAT(p.nombre) AS pruebas
        FROM fantasmas f 
        INNER JOIN pruebas_fantasmas pf ON f.id = pf.fantasma_id
        INNER JOIN pruebas p ON pf.prueba_id = p.id
        GROUP BY f.id
        $filtro";

$stmt = $conexion->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Generar las tarjetas HTML para cada fantasma
    while ($row = $result->fetch_assoc()) {
        echo '<div class="tarjeta_fantasma_general" id="' . quitarTildes($row["nombre_fantasma"]) . '">';
        echo '<div class="cuadrado_morado"><img src="../img/Fotos fantasmas/' . strtolower($row["nombre_fantasma"]) . '.svg"></div>';
        echo '<div class="info_fantasma">';
        echo '<span class="nombre_fantasma">' . quitarTildes($row["nombre_fantasma"]) . '</span>';
        echo '<div class="desc_fantasma">' . nl2br($row["descripcion_fantasma"]) . '</div>';
        echo '<div class="pruebas_fantasmas">';

        // Obtener y mostrar las pruebas asociadas al fantasma
        $pruebas = explode(",", $row["pruebas"]);
        foreach ($pruebas as $key => $prueba) {
            echo '<div class="pruebas prueba' . ($key + 1) . '"><img src="../img/Fotos pruebas/' . $prueba . '.svg" alt="">' . $prueba . '</div>';
        }

        echo '</div></div></div>';
    }
} else {
    echo "0 resultados";
}

function quitarTildes($cadena)
{
    // Arrays con las letras acentuadas y sus equivalentes sin acento
    $letras_acentuadas = array('á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú');
    $letras_sin_acento = array('a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U');

    // Reemplazar las letras acentuadas con las sin acento
    $cadena = str_replace($letras_acentuadas, $letras_sin_acento, $cadena);

    return $cadena;
}

// Cerrar la conexión a la base de datos
$stmt->close();
mysqli_close($conexion);
