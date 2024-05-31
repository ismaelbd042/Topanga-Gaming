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

        .div_textos_foto_cuadro {
            width: 90%;
            height: 70%;
            gap: 4%;
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            align-self: center;
        }

        .imagen_cuadroLuz {
            height: 90%;
        }

        .informacion_cuadroLuz {
            border: 1px solid;
            width: 35%;
            height: 50%;
            font-size: 20px;
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
            width: 45%;
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
    $nombreMapa = isset($_GET['mapa']) ? $_GET['mapa'] : '13_Willow_Street';
    $nombreMapaLimpio = str_replace('_', ' ', $nombreMapa);

    // Consultar los datos del mapa específico
    $query = "SELECT * FROM mapas WHERE nombre = '$nombreMapaLimpio'";
    $result = mysqli_query($conexion, $query);

    // Verificar si se obtuvieron resultados
    if ($result && mysqli_num_rows($result) > 0) {
        $mapa = mysqli_fetch_assoc($result);
        $imagen_fondo = '../img/Fotos mapas/' . $nombreMapa . '.svg';
    ?>
        <div class="container_general_mapas">
            <div class="div_foto_nombreMapa" style="background: url('<?php echo $imagen_fondo; ?>'); background-size: cover;">
                <div class="div_nombre_mapa"><?php echo $mapa['nombre']; ?></div>
            </div>
            <div class="div_informacion_mapa">
                <div class="cuadro_informacion">Información Acerca del Mapa</div>
                <div class="cuadro_informacion2">
                    Este mapa tenebroso detalla el inquietante Bosque de las Sombras, un lugar envuelto en misterio y peligros desconocidos.
                    A lo largo del mapa, se despliega una extensión sombría dominada por la naturaleza salvaje y el abandono de antiguas civilizaciones.
                    <br><br>
                    Tamaño: <?php echo $mapa['tamaño']; ?><br>
                    Plantas: <?php echo $mapa['plantas']; ?><br>
                    Habitaciones: <?php echo $mapa['habitaciones']; ?><br>
                    Salidas: <?php echo $mapa['salidas']; ?><br>
                    Grifos: <?php echo $mapa['grifos']; ?><br>
                    Cámaras: <?php echo $mapa['camaras']; ?><br>
                    Escondites: <?php echo $mapa['escondites']; ?><br>
                    Nivel de Desbloqueo: <?php echo $mapa['nivel_desbloqueo']; ?>
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
</body>

</html>