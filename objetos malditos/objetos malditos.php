<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../img/Logo fondo blanco.svg" type="image/x-icon">
    <link rel="stylesheet" href="../Index/style.css">
    <title>Topanga Gaming</title>
    <style>
        @font-face {
            font-family: OctoberCrow;
            src: url(../fonts/October\ Crow.ttf);
        }

        .granTarjeta {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .tarjeta_objeto_general {
            width: 100%;
            max-width: 1200px;
            height: auto;
            background: #000;
            border-radius: 30px;
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            margin: 3%;
            gap: 20px;
            padding: 20px;
        }

        .cuadrado_morado {
            width: 37%;
            height: 75%;
            margin-top: 5%;
            /* padding-top: 100%; */
            position: relative;
            transform: rotate(45deg);
            background: radial-gradient(185.32% 99.8% at 11.32% 52.18%, #003 0%, #5F1495 100%);
        }

        .imagen_objeto_magico {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            transform: rotate(315deg);
        }

        .div_nombre_foto {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            color: white;
            text-align: center;
        }

        .nombre_objeto {
            font-family: OctoberCrow;
            color: white;
            font-size: 36px;
            margin: 10px 0;
        }

        .imagen_pequeña_objeto_magico {
            border: 1px solid;
            width: 50%;
        }

        .info_objeto {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            color: white;
            gap: 20px;
        }

        .boton-modal label,
        .boton-modal2 label {
            padding: 20px 40px; /* Ajuste de tamaño del botón */
            color: #fff;
            background: radial-gradient(80.89% 43.8% at 50% 50%, #003 0%, #5f1495 100%);
            border: 0;
            font-size: 24px; /* Ajuste de tamaño del texto */
            border-radius: 10px;
            cursor: pointer;
            transition: all 300ms ease;
            text-align: center;
            height: 100px;
        }

        .boton-modal label:hover,
        .boton-modal2 label:hover {
            background-color: #8a56af;
        }

        @media (min-width: 876px) {
            .tarjeta_objeto_general {
                flex-direction: row;
                height: 500px;
                gap: 9.5%;
                padding: 20px;
            }

            .div_nombre_foto {
                width: 28%;
                justify-content: space-around;
                gap: 22%;
                padding: 0 20px 0 40px;
            }

            .nombre_objeto {
                font-size: 56px;
                height: 30%;
                width: 150%;
            }

            .imagen_pequeña_objeto_magico {
                height: 25%;
                width: 100%;
                margin-left: 3%;
            }

            .info_objeto {
                width: 30%;
                justify-content: space-around;
                gap: 10%;
                padding: 10px 20px 0px 0px;
            }
        }
    </style>
</head>

<body>
    <div class="overlay"></div>
    <?php
    include "../database/connect.php";
    include "../header y footer/header.html";
    include "../header y footer/VentanaModal.html";
    include "VentanaModalObjetos.html";
    include "VentanaModalObjetos2.html";

    // Obtener la conexión a la base de datos
    $conexion = getConexion();

    // Verificar la conexión
    if (mysqli_connect_errno()) {
        echo "Error al conectar con la base de datos: " . mysqli_connect_error();
    }

    // Consulta para obtener los datos de la tabla objetos_malditos
    $consultaObjetos = "SELECT * FROM objetos_malditos";
    $result = mysqli_query($conexion, $consultaObjetos);

    // Verificar si se obtuvieron resultados
    if (mysqli_num_rows($result) > 0) {
        // Iterar sobre los resultados y mostrar cada tarjeta de objeto
        while ($row = mysqli_fetch_assoc($result)) {
            $nombreSinTildes = quitarTildesyN($row["nombre"]);
            $nombreLower = strtolower($row["nombre"]);
            echo '<div class="granTarjeta">';
            echo '<div class="tarjeta_objeto_general">';
            echo '<div class="div_nombre_foto">';
            echo '<div class="nombre_objeto">' . $nombreSinTildes . '</div>';
            echo '<img src="../img/Fotos Objetos/' . $nombreLower . '3.svg" class="imagen_pequeña_objeto_magico"></img>';
            echo '</div>';
            echo '<div class="cuadrado_morado">';
            echo '<img src="../img/Fotos Objetos/' . $nombreLower . '.svg" class="imagen_objeto_magico"></img>';
            echo '</div>';
            echo '<div class="info_objeto">';
            echo '<div class="boton-modal"><label class="efecto-btn" data-efecto="' . $row["efecto"] . '" for="btn-modal">Efecto</label></div>';
            if ($row["preguntas"])
                echo '<div class="boton-modal2"><label class="preguntas-btn" data-preguntas="' . $row["preguntas"] . '" for="btn-modal2">Preguntas</label></div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo "No se encontraron resultados.";
    }

    function quitarTildesyN($cadena)
    {
        // Arrays con las letras acentuadas y sus equivalentes sin acento
        $letras_acentuadas = array('á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú', 'Ñ', 'ñ');
        $letras_sin_acento = array('a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U', 'N', 'n');

        // Reemplazar las letras acentuadas con las sin acento
        $cadena = str_replace($letras_acentuadas, $letras_sin_acento, $cadena);

        return $cadena;
    }

    // Cerrar la conexión
    mysqli_close($conexion);
    ?>
    <script src="../Index/script.js"></script>
</body>

</html>