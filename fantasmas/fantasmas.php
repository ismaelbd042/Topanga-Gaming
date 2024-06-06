<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Index/style.css">
    <link rel="shortcut icon" href="../img/Logo fondo blanco.svg" type="image/x-icon">
    <title>Topanga Gaming</title>
    <style>
        @font-face {
            font-family: OctoberCrow;
            src: url(../fonts/October\ Crow.ttf);
        }

        .granTarjeta {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: center;
        }

        .tarjeta_fantasma_general {
            width: 500px;
            height: auto;
            background: #000;
            border-radius: 30px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            align-items: center;
            margin: 2%;
            overflow: hidden;
        }

        .cuadrado_morado {
            width: 100%;
            height: 400px;
            clip-path: polygon(0% 0%, 100% 0%, 100% 85%, 95% 88%, 88% 92%, 80% 95%, 72% 97%, 64% 99%, 55% 100%, 45% 100%, 36% 99%, 28% 97%, 20% 95%, 12% 92%, 5% 88%, 0% 85%);
            background: radial-gradient(185.32% 99.8% at 11.32% 52.18%, #003 0%, #5F1495 100%);
            border-top-left-radius: 30px;
            border-bottom-left-radius: 30px;
            display: flex;
            justify-content: center;
        }

        .cuadrado_morado img {
            height: 100%;
        }

        .info_fantasma {
            height: 45%;
            width: 80%;
            display: flex;
            flex-direction: column;
            justify-content: start;
            align-items: center;
            text-align: center;
            color: white;
            gap: 10px;
        }

        .info_fantasma .nombre_fantasma {
            font-family: OctoberCrow;
            font-size: 40px;
        }

        .info_fantasma .desc_fantasma {
            font-size: 15px;
            text-align: left;
        }

        .pruebas_fantasmas {
            display: flex;
            flex-direction: row;
            justify-content: space-around;
        }

        .pruebas {
            display: flex;
            max-width: 33%;
            width: fit-content;
            flex-direction: column;
            gap: 5px;
        }

        .pruebas img {
            height: 40%;
        }

        #filtroForm {
            margin: 50px;
            background-color: black;
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            border-radius: 10px;
        }

        #filtroForm h1 {
            font-family: OctoberCrow;
            margin-top: 30px;
        }

        .divPruebasFiltro {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            /* Centrar horizontalmente */
            font-size: 20px;
            padding: 0;
            /* Eliminar el padding para evitar espacios innecesarios */
        }

        .divPruebasFiltro label {
            margin: 30px;
            /* Reducir el margen */
            display: flex;
            text-align: center;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }
    </style>
</head>

<body>
    <div class="overlay"></div>
    <?php
    include "../header y footer/header.html";
    include "../header y footer/VentanaModal.html";
    include "../database/connect.php";

    // Obtener la conexión a la base de datos
    $conexion = getConexion();

    // Consulta para obtener los datos de la base de datos
    $query = "SELECT f.id AS fantasma_id, f.nombre AS nombre_fantasma, f.descripcion AS descripcion_fantasma, 
            p.id AS prueba_id, p.nombre AS nombre_prueba
            FROM fantasmas f
            INNER JOIN pruebas_fantasmas pf ON f.id = pf.fantasma_id
            INNER JOIN pruebas p ON pf.prueba_id = p.id
            ORDER BY f.id, p.id";
    $resultado = mysqli_query($conexion, $query);

    // Array para almacenar los datos de los fantasmas y sus pruebas
    $fantasmas = array();
    echo '<div class="granTarjeta">';
    // Recorrer los resultados y agrupar los datos por fantasma
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $fantasma_id = $fila['fantasma_id'];
        $nombre_fantasma = $fila['nombre_fantasma'];
        $descripcion_fantasma = $fila['descripcion_fantasma'];
        $prueba_id = $fila['prueba_id'];
        $nombre_prueba = $fila['nombre_prueba'];

        // Si el fantasma no existe en el array, agregarlo
        if (!isset($fantasmas[$fantasma_id])) {
            $fantasmas[$fantasma_id] = array(
                'nombre' => $nombre_fantasma,
                'descripcion' => $descripcion_fantasma,
                'pruebas' => array()
            );
        }

        // Agregar la prueba al fantasma
        $fantasmas[$fantasma_id]['pruebas'][] = $nombre_prueba;
    }

    // Generar el HTML para cada fantasma
    foreach ($fantasmas as $fantasma) {
        echo '<div class="tarjeta_fantasma_general" id="' . quitarTildes($fantasma['nombre']) . '">';
        echo '    <div class="cuadrado_morado"><img src="../img/Fotos fantasmas/' . strtolower($fantasma['nombre']) . '.svg"></div>';
        echo '    <div class="info_fantasma">';
        echo '        <span class="nombre_fantasma">' . quitarTildes(htmlspecialchars($fantasma['nombre'])) . '</span>';
        echo '        <div class="desc_fantasma">' . htmlspecialchars($fantasma['descripcion']) . '</div>';
        echo '        <div class="pruebas_fantasmas">';

        // Generar el HTML para cada prueba del fantasma
        foreach ($fantasma['pruebas'] as $prueba) {
            if ($fantasma['nombre'] == 'Mímico' && $prueba == 'Orbes Espectrales') {
                continue; // Omitir la prueba si el fantasma es "Mimico" y la prueba es "Orbes Espectrales"
            }
            echo '<div class="pruebas">';
            echo '                <img src="../img/Fotos pruebas/' . $prueba . '.svg" alt="">';
            echo '                ' . htmlspecialchars($prueba);
            echo '            </div>';
        }

        echo '        </div>';
        echo '    </div>';
        echo '</div>';
    }
    echo '</div>';

    function quitarTildes($cadena)
    {
        // Arrays con las letras acentuadas y sus equivalentes sin acento
        $letras_acentuadas = array('á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú');
        $letras_sin_acento = array('a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U');

        // Reemplazar las letras acentuadas con las sin acento
        $cadena = str_replace($letras_acentuadas, $letras_sin_acento, $cadena);

        return $cadena;
    }

    // Liberar resultado y cerrar conexión
    mysqli_free_result($resultado);
    mysqli_close($conexion);
    ?>

    <script src="../Index/script.js"></script>

</body>

</html>