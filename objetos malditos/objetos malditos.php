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
            flex-direction: column;
            align-items: center;
        }

        .tarjeta_objeto_general {
            width: 1200px;
            height: 500px;
            background: #000;
            border-radius: 30px;
            display: flex;
            justify-content: space-around; 
            gap: 9.5%;
            margin: 3%;
            /* align-items: center;   */
        }

        .cuadrado_morado {
            margin-top: 6.3%;
            width: 40%;
            height: 70%; 
            transform: rotate(45deg); 
            background: radial-gradient(185.32% 99.8% at 11.32% 52.18%, #003 0%, #5F1495 100%);
            /* border: 1px solid white; */
        }


        .div_nombre_foto {
            height: 100%;
            width: 28%;
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            gap: 22%;
            padding: 0 20px 0 40px;
            color: white;
            /* border: 1px solid; */
        }

        .imagen_pequeña_objeto_magico {
            border: 1px solid;
            height: 25%;
            width: 100%;
            margin-left: 3%;
        }

        .info_objeto {
            height: 100%;
            width: 40%;
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            gap: 22%;
            padding: 10px 20px 0px 0px;
            color: white;
            border: 1px solid;
        }

        .nombre_objeto {
            /* margin-top: 2%; */
            margin-left: 3%;
            font-family: OctoberCrow;
            height: 30%;
            width: 150%;
            color: white;
            font-size: 56px;
            z-index: 10;
            /* position: relative; */
            /* left: 10%;  */
            /* border: 1px solid; */
        }

        .imagen_objeto_magico {
            /* border: 1px solid white; */
            height: 100%;
            width: 100%;
            transform: rotate(315deg); 
        }

        .info_objeto .desc_objeto {
            font-size: 17px;
            border: 1px solid;
            z-index: 10;
        }

        .info_objeto .desc_objeto2 {
            font-size: 17px;
            border: 1px solid;
            z-index: 10;
        }


    </style>

<body>
    <div class="overlay"></div>
    <?php
    include "../database/connect.php";
    include "../header y footer/header.html";
    include "../header y footer/VentanaModal.html";

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
            echo '<div class="granTarjeta">';
            echo '<div class="tarjeta_objeto_general">';
            echo '<div class="div_nombre_foto">';
            echo '<div class="nombre_objeto">' . quitarTildesyN($row["nombre"]) . '</div>';
            echo '<img src="../img/Fotos Objetos/' . strtolower($row["nombre"]) . '3.svg" class="imagen_pequeña_objeto_magico"></img>';
            echo '</div>';
            echo '<div class="cuadrado_morado">';
            echo '<img src="../img/Fotos Objetos/' . strtolower($row["nombre"]) . '.svg" class="imagen_objeto_magico"></img>';
            echo '</div>';
            echo '<div class="info_objeto">';
            echo '<div class="desc_objeto">' . $row["efecto"] . '</div>';
            // echo '<div class="desc_objeto2">' . $row["preguntas"] . '</div>';
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

    

</body>

</html>
    <script src="../Index/script.js"></script>

</body>

</html>