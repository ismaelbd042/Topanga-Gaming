<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.1.2/css/all.css" integrity="sha384-fZCoUih8XsaUZnNDOiLqnby1tMJ0sE7oBbNk2Xxf5x8Z4SvNQ9j83vFMa/erbVrV" crossorigin="anonymous" />
    <link rel="stylesheet" href="../Index/style.css">
    <link rel="shortcut icon" href="../img/Logo fondo blanco.svg" type="image/x-icon">
    <title>Topanga Gaming</title>
</head>
<style>
    @font-face {
        font-family: OctoberCrow;
        src: url(../fonts/October\ Crow.ttf);
    }

    .container_general_equipamiento {
        display: flex;
        flex-direction: column;
        width: 100vw;
        height: auto;
        align-items: center;
        text-align: center;
        overflow: hidden;
        margin-bottom: 50px;
    }

    .container_carrousel {
        width: 80vw;
        overflow: hidden;
        position: relative;
        overflow: hidden;
    }

    .container_carrousel_equipamiento {
        display: flex;
        flex-direction: row;
        width: 300%;
        overflow: hidden;
        transition: transform 0.5s ease;
        margin-top: 1em;
        overflow: hidden;
    }

    .container_equipamiento {
        display: flex;
        flex-direction: row;
        width: 100%;
        height: 70vh;
        align-items: center;
        background-color: #ffffff;
        border-radius: 10px;
        overflow: hidden;
        border: 1px solid black;
        overflow: hidden;
    }

    .container_equipamiento .div_img_equipamiento {
        width: 50%;
        height: 100%;
        justify-content: center;
        background: radial-gradient(50% 50% at 50% 50%, rgb(0, 0, 51) 0%, rgb(95, 20, 149) 100%);
        display: flex;
        align-items: center;
        border-radius: 10px;
        overflow: hidden;
    }

    .container_equipamiento .img_equipamiento {
        position: relative;
        width: 400px;
        height: auto;
        object-fit: contain;
        border-radius: 10px;
        overflow: hidden;
        max-height: 450px;
    }

    .container_equipamiento .div_info_equipamiento {
        width: 50%;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        gap: 20px;
        align-items: center;
        overflow: hidden;
    }

    .container_equipamiento .div_nivel_equipamiento {
        justify-content: center;
        gap: 120px;
        padding: 30px 0 0 0;
        width: 100%;
        flex: 0 0 auto;
        display: flex;
        align-items: center;
        align-self: stretch;
    }

    .container_equipamiento .nivel_equipamiento {
        width: 20px;
        height: auto;
    }

    .container_equipamiento .info_equipamiento {
        width: auto;
        height: auto;
        padding: 0 20px 0 20px;
        margin: 0;
        font-weight: 400;
        color: #000000;
        font-size: 20px;
    }

    .arrow {
        position: relative;
        top: 2.6em;
        transform: translateY(-50%);
        width: 50px;
        height: 50px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1;
    }

    .arrow-left {
        color: white;
        left: calc(-51.2% + 1.5em);
    }

    .arrow-right {
        right: calc(-51.2% + 1.5em);
        color: white;
    }

    .arrow_div {
        position: absolute;
        bottom: 0px;
        width: 50px;
        background-color: rgba(1, 1, 1, 0.8);
    }

    .div-arrow-right {
        right: 0;
        border-radius: 10px 0 0 0;
    }

    .div-arrow-left {
        left: 0;
        border-radius: 0 10px 0 0;
    }


    #nombre_equipamiento {
        font-family: OctoberCrow;
        font-size: 50px;
    }

    /* Media query for smaller screens */
    @media (max-width: 768px) {
        .container_equipamiento {
            flex-direction: column;
            height: auto;
            padding-bottom: 50px;
        }

        .container_equipamiento .div_img_equipamiento,
        .container_equipamiento .div_info_equipamiento {
            width: 100%;
            height: auto;
        }

        .container_equipamiento .img_equipamiento {
            width: 70%;
            height: auto;
        }
    }
</style>

<body>
    <div class="overlay"></div>
    <?php
    include "../header y footer/header.html";
    include "../header y footer/VentanaModal.html";
    include "../database/connect.php";

    // Obtener la conexión a la base de datos
    $conexion = getConexion();

    // Consulta para obtener los datos de la base de datos
    $query = "SELECT nombre, tier, descripcion FROM equipamiento";
    $resultado = mysqli_query($conexion, $query);

    // Array para almacenar los nombres únicos de equipamiento
    $equipamiento_nombres = array();

    // Recorrer los resultados y generar la estructura HTML
    while ($fila = mysqli_fetch_assoc($resultado)) {
        // Obtener los datos de la fila
        $nombre = $fila['nombre'];
        $tier = $fila['tier'];
        $descripcion = $fila['descripcion'];

        // Verificar si ya se ha creado un contenedor para este equipamiento
        if (!in_array($nombre, $equipamiento_nombres)) {
            // Si no existe, crear un nuevo contenedor
            echo '<div class="container_general_equipamiento">';
            echo '<div class="container_carrousel" id=' . str_replace(' ', '', $nombre) . '>';
            echo '<span id="nombre_equipamiento">' . quitarTildes($nombre) . '</span>';
            echo '<div class="container_carrousel_equipamiento">';
            $equipamiento_nombres[] = $nombre; // Agregar el nombre al array
        }

        // Crear un nuevo contenedor de equipamiento para este tier
        echo '<div class="container_equipamiento equipamiento' . $tier . '_carrosuel">';
        echo '<div class="div_img_equipamiento"><img class="img_equipamiento" src="../img/Fotos equipamiento/' . strtolower(str_replace(' ', '', $nombre)) . $tier . '.svg" /></div>';
        echo '<div class="div_info_equipamiento">';
        echo '<div class="div_nivel_equipamiento">';
        // Agregar imágenes de nivel según el tier
        for ($i = 0; $i < $tier; $i++) {
            echo '<img class="nivel_equipamiento" src="../img/Fotos equipamiento/NivelEquipamiento.svg" />';
        }
        echo '</div>';
        echo '<p class="info_equipamiento">' . $descripcion . '</p>';
        echo '</div>';
        echo '</div>';

        // Cerrar contenedor de equipamiento si ya se han generado todos los tiers
        if ($tier == 3) {
            echo '</div>'; // Cerrar container_carrousel_equipamiento
            echo '<div class="arrow_div div-arrow-right"><i class="fa-solid fa-angle-right arrow arrow-right" onclick="moveRight()"></i></div>';
            echo '<div class="arrow_div div-arrow-left"><i class="fa-solid fa-angle-left arrow arrow-left" onclick="moveLeft()"></i></div>';
            echo '</div>'; // Cerrar container_carrousel
            echo '</div>'; // Cerrar container_general_equipamiento
        }
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
    // Liberar resultado y cerrar conexión
    mysqli_free_result($resultado);
    mysqli_close($conexion);
    ?>

    <script src="../Index/script.js"></script>
    <script>
        // Seleccionar todos los contenedores generales de equipamiento
        const containers = document.querySelectorAll('.container_carrousel');

        containers.forEach(container => {
            // Para cada contenedor, seleccionar elementos específicos dentro de él
            const carrousel = container.querySelector('.container_carrousel_equipamiento');
            const slides = container.querySelectorAll('.container_equipamiento');
            let index = 0;

            // Agregar eventos de clic a las flechas de navegación dentro de este contenedor
            container.querySelector('.arrow-left').addEventListener('click', moveLeft);
            container.querySelector('.arrow-right').addEventListener('click', moveRight);

            function moveLeft() {
                index = (index === 0) ? slides.length - 1 : index - 1;
                updateSlidePosition();
            }

            function moveRight() {
                index = (index === slides.length - 1) ? 0 : index + 1;
                updateSlidePosition();
            }

            function updateSlidePosition() {
                const newPosition = -index * slides[0].offsetWidth;
                carrousel.style.transform = `translateX(${newPosition}px)`;
            }
        });
    </script>
    <?php include "../header y footer/footer.html"; ?>
    <style>
    </style>
</body>

</html>