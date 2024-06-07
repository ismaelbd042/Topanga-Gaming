<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.1.2/css/all.css" integrity="sha384-fZCoUih8XsaUZnNDOiLqnby1tMJ0sE7oBbNk2Xxf5x8Z4SvNQ9j83vFMa/erbVrV" crossorigin="anonymous" />
    <link rel="stylesheet" href="../Index/style.css">
    <link rel="shortcut icon" href="../img/Logo fondo blanco.svg" type="image/x-icon">
    <title>Topanga Gaming</title>
    <style>
        @font-face {
            font-family: OctoberCrow;
            src: url(../fonts/October\ Crow.ttf);
        }

        .container_general_mapas {
            width: 100vw;
            height: auto;
            align-items: center;
        }

        .div_foto_nombreMapa {
            width: 100%;
            height: 600px;
            /* border-top: 1px solid; */
            background-size: cover;
            background-repeat: no-repeat;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .div_informacion_mapa {
            width: 100%;
            height: auto;
            padding: 5% 5%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .div_ubicacion_objetos {
            width: 100%;
            height: 900px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            background: radial-gradient(185.32% 99.8% at 11.32% 52.18%, #003 0%, #5F1495 100%);
        }

        .div_nombre_mapa {
            font-family: OctoberCrow;
            font-size: 50px;
            color: White;
            text-align: center;
            width: 100%;
            padding-top: 15%;
        }

        .cuadro_informacion {
            width: 100%;
            height: 10%;
            text-align: center;
            font-size: 25px;
        }

        .cuadro_informacion2 {
            width: 50%;
            height: 30%;
            text-align: center;
            margin-top: 5%;
            font-size: 20px;
        }

        .div_titulo_ubicacionObjetos {
            width: 70%;
            text-align: center;
            border-bottom: 1px solid;
            font-family: OctoberCrow;
            font-size: 40px;
            padding-bottom: 2%;
        }

        .div_general_ubicacionesObjetos {
            width: 90%;
            height: 900px;
            display: flex;
            flex-direction: column;
            justify-content: space-evenly;
            align-items: center;
        }


        .div_objeto_maldito {
            width: 90%;
            height: 500px;
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
        }

        .imagen_planos_objeto {
            border: 1px solid;
        }

        .imagen_plano_objetos {
            max-height: 580px;
            max-width: 100%;
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

    // Verificar la conexión
    if (mysqli_connect_errno()) {
        echo "Error al conectar con la base de datos: " . mysqli_connect_error();
    }

    // Obtener el nombre del mapa desde la URL
    $nombreMapa = isset($_GET['mapa']) ? $_GET['mapa'] : '6_Tanglewood_Drive';
    $nombreMapaLimpio = str_replace('_', ' ', $nombreMapa);

    // Consultar los datos del mapa específico
    $query = "SELECT * FROM mapas WHERE nombre = '$nombreMapaLimpio'";
    $result = mysqli_query($conexion, $query);

    // Verificar si se obtuvieron resultados
    if ($result && mysqli_num_rows($result) > 0) {
        $mapa = mysqli_fetch_assoc($result);
        $imagen_fondo = '../img/Fotos mapas/' . $nombreMapa . '.png';
    ?>
        <div class="container_general_mapas">
            <div class="div_foto_nombreMapa" style="background: url('<?php echo $imagen_fondo; ?>'); background-size: cover;">
                <div class="div_nombre_mapa"><?php echo $mapa['nombre']; ?></div>
            </div>
            <div class="div_informacion_mapa">
                <div class="cuadro_informacion">Información Acerca del Mapa</div>
                <div class="cuadro_informacion2">
                    Este mapa es <?php echo $mapa['tamaño']; ?>, tiene <?php echo $mapa['plantas']; ?> plantas, tambien tiene <?php echo $mapa['habitaciones']; ?> habitaciones(los numero entre guiones representan las habitaciones por cada planta desde la planta de arriba hasta la planta baja),
                    por otra parte tiene <?php echo $mapa['salidas']; ?> salidas, tambien <?php echo $mapa['grifos']; ?> grifos, <?php echo $mapa['camaras']; ?> camaras, <?php echo $mapa['escondites']; ?>
                    escondites y este mapa se desbloquea en el nivel <?php echo $mapa['nivel_desbloqueo']; ?> de experiencia.
                </div>
            </div>
            <div class="div_ubicacion_objetos">
                <div class="div_general_ubicacionesObjetos">
                    <div class="div_titulo_ubicacionObjetos">Ubicacion de los Objetos en el Mapa</div>
                    <div class="div_objeto_maldito">
                        <img src="<?php echo $mapa['img']; ?>" alt="Plano del Mapa" class="imagen_plano_objetos">
                    </div>
                </div>
            </div>
        </div>
    <?php
    } else {
        echo "<div class='container_general_mapas'><p>Mapa no encontrado.</p></div>";
    }
    mysqli_close($conexion);
    ?>

    <script src="../Index/script.js"></script>
    <?php include "../header y footer/footer.html"; ?>
</body>

</html>