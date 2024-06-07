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
            /* border: 1px solid; */
        }

        .tarjeta_pruebas_general {
            width: 500px;
            height: 600px;
            background: radial-gradient(185.32% 99.8% at 11.32% 52.18%, #003 0%, #5F1495 100%);
            ;
            border-radius: 30px;
            display: flex;
            flex-direction: column;
            gap: 27px;
            align-items: center;
            margin: 2%;
            overflow: hidden;
            border: 2px solid;
        }

        .cuadrado_foto {
            width: 80%;
            height: 25%;
            display: flex;
            justify-content: center;
        }

        .cuadrado_foto img {
            height: 100%;
            border: 1px solid;
        }

        .cuadrado_video {
            width: 80%;
            height: 25%;
            display: flex;
            justify-content: center;
        }

        .cuadrado_video video {
            height: 100%;
            border: 1px solid;
        }

        .nombre_prueba {
            height: 16%;
            width: 80%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
            color: white;
            /* border: 1px solid; */
            /* padding-top: 4%; */

            font-family: OctoberCrow;
            font-size: 40px;
        }


        .extra_prueba {
            height: 15%;
            width: 80%;
            display: flex;
            flex-direction: column;
            justify-content: start;
            color: white;
            /* border: 1px solid; */

            font-size: 18px;
            text-align: center;
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
      
        @media (max-width: 530px) {
            .tarjeta_pruebas_general {
                width: 400px;
            }
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
    $query = "SELECT p.id AS prueba_id, p.nombre AS nombre_prueba, p.extra AS extra_prueba
            FROM pruebas p";
    $stmt = $conexion->prepare($query);
    $stmt->execute();
    $resultado = $stmt->get_result();

    // Array para almacenar los datos de los fantasmas y sus pruebas
    $pruebas = array();
    // Recorrer los resultados y agrupar los datos por fantasma
    while ($fila = mysqli_fetch_assoc($resultado)) {
        echo '<div class="granTarjeta" id="' . quitarTildes($fila['prueba_id']) . '">';
        $prueba_id = $fila['prueba_id'];
        $nombre_prueba = $fila['nombre_prueba'];
        $extra_prueba = $fila['extra_prueba'];

        // Si el fantasma no existe en el array, agregarlo
        if (!isset($pruebas[$prueba_id])) {
            $pruebas[$prueba_id] = array(
                'nombre' => $nombre_prueba,
                'extra' => $extra_prueba,
            );
        }
    }

    // Generar el HTML para cada fantasma
    foreach ($pruebas as $prueba) {
        echo '<div class="tarjeta_pruebas_general" id="' . quitarTildes($prueba['nombre']) . '">';
        echo '    <div class="nombre_prueba">' . quitarTildes(htmlspecialchars($prueba['nombre'])) . '</div>';
        echo '    <div class="cuadrado_foto"><img src="../img/Fotos Pruebas Juego/' . strtolower($prueba['nombre']) . '.svg"></div>';
        echo '    <div class="extra_prueba">' . htmlspecialchars($prueba['extra']) . '</div>';
        echo '    <div class="cuadrado_video"><video src="../img/VideosPruebas/' . strtolower($prueba['nombre']) . '1.mp4" autoplay loop muted></video></div>';
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