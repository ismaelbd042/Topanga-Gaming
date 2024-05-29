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

    .container_general_mapas {
        /* display: flex;
        flex-direction: column; */
        width: 100vw;
        height: auto;
        align-items: center;
        /* text-align: center; */
        /* padding-top: 2em; */
        /* overflow: hidden; */
        /* border: 1px solid purple; */
    }

    .div_foto_nombreMapa {
        width: 100%;
        height: 600px;
        border-top: 1px solid;

        background: url('../img/Fotos mapas/TangleWood.svg');
        background-size: cover; /* Ajusta el tamaño de la imagen para cubrir todo el fondo */
        background-repeat: no-repeat; /* Evita que la imagen se repita */

        display: flex;
        flex-direction: column;
        justify-content: center;
        /* align-self: flex-end; */

    }

    .div_informacion_mapa {
        width: 100%;
        height: auto;
        /* background: white; */
        /* border: 1px solid; */
        /* margin-top: 5%; */
        padding: 5% 5%;

        display: flex;
        flex-direction: column;
        /* justify-content: space-evenly; */
        /* gap: 5%; */
        align-items: center;
    }

    .div_ubicacion_cuadroLuz {
        width: 100%;
        height: 450px;
        /* border: 1px solid; */
        /* background: white; */
        /* margin-top: 5%; */
        background: radial-gradient(185.32% 99.8% at 11.32% 52.18%, #003 0%, #5F1495 100%);

        display: flex;
        flex-direction: column;
        justify-content: space-evenly;
        align-items: center;
    }

    .div_ubicacion_objetos {
        width: 100%;
        height: 2200px;
        /* border: 1px solid; */

        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: center;
    }

    .div_nombre_mapa {
        font-family: OctoberCrow;
        font-size: 50px;
        color: White;
        text-align: center;
        /* border: 1px solid; */
        width: 100%;
        /* align-self: center; */
        padding-bottom: 20%;
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

    .div_titulo_ubicacionCuadro {
        width: 90%;
        height: 10%;
        text-align: center;
        border: 1px solid;
        font-family: OctoberCrow;
        font-size: 36px;
    }

    .div_titulo_ubicacionObjetos {
        width: 90%;
        /* height: 10%; */
        text-align: center;
        border: 1px solid;
        font-family: OctoberCrow;
        font-size: 36px;
    }

    .div_general_ubicacionesObjetos {
        width: 90%;
        height: 2200px;
        border: 1px solid;

        display: flex;
        flex-direction: column;
        justify-content: space-evenly;
        align-items: center;
    }

    .div_textos_foto_cuadro {
        width: 90%;
        height: 70%;
        border: 1px solid;
        gap: 4%;

        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
        align-self: center;
    }

    .imagen_cuadroLuz {
        border: 1px solid;
        /* width: 30%; */
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
        height: 250px;
        border: 1px solid;

        display: flex;
        flex-direction: row;
        justify-content: space-evenly;
        align-items: center;
    }

    .div_texto_objetoUbicacion {
        width: 40%;
        height: 90%;
        border: 1px solid;
    }

</style>

<body>
    <div class="overlay"></div>
    <?php
    include "../header y footer/header.html";
    include "../header y footer/VentanaModal.html";
    include "../database/connect.php";
    ?>

    <div class="container_general_mapas">
        <div class="div_foto_nombreMapa">
            <div class="div_nombre_mapa">TANGLEWOOD DRIVE</div>
        </div>
        <div class="div_informacion_mapa">
            <div class="cuadro_informacion">Información Acerca del Mapa</div>
            <div class="cuadro_informacion2">Este mapa tenebroso detalla el inquietante Bosque de las Sombras, un lugar envuelto en misterio y peligros desconocidos. A lo largo del mapa, se despliega una extensión sombría dominada por la naturaleza salvaje y el abandono de antiguas civilizaciones.</div>
        </div>
        <div class="div_ubicacion_cuadroLuz">
            <div class="div_titulo_ubicacionCuadro">Ubicacion del Cuadro de Luz</div>
            <div class="div_textos_foto_cuadro">
                <!-- Esto hacerlo igual solo que abajo -->
                <img src="../img/Fotos Cuadros Luz/TangleWood.svg" alt="" class="imagen_cuadroLuz">
                <div class="informacion_cuadroLuz">En el juego Phasmophobia, los cuadros de luz (o paneles eléctricos) son cruciales para restaurar la energía en la ubicación después de que el fantasma haya provocado un apagón. Estos cuadros de luz están situados en distintos lugares dependiendo del mapa en el que te encuentres. Aquí te doy una guía general sobre dónde puedes encontrarlos en algunos de los mapas más comunes del juego</div>
            </div>
        </div>
        <div class="div_ubicacion_objetos">
            <div class="div_general_ubicacionesObjetos">
                <div class="div_titulo_ubicacionObjetos">Ubicacion de los Objetos Malditos</div>
                <div class="div_objeto_maldito">
                    <!-- Cambiar el primer div de todos por la imagen directamente -->
                    <div class="div_texto_objetoUbicacion"></div> 
                    <div class="div_texto_objetoUbicacion"></div>
                </div>
                <div class="div_objeto_maldito">
                    <div class="div_texto_objetoUbicacion"></div> 
                    <div class="div_texto_objetoUbicacion"></div>
                </div>
                <div class="div_objeto_maldito">
                    <div class="div_texto_objetoUbicacion"></div> 
                    <div class="div_texto_objetoUbicacion"></div>
                </div>
                <div class="div_objeto_maldito">
                    <div class="div_texto_objetoUbicacion"></div> 
                    <div class="div_texto_objetoUbicacion"></div>
                </div>
                <div class="div_objeto_maldito">
                    <div class="div_texto_objetoUbicacion"></div> 
                    <div class="div_texto_objetoUbicacion"></div>
                </div>
                <div class="div_objeto_maldito">
                    <div class="div_texto_objetoUbicacion"></div> 
                    <div class="div_texto_objetoUbicacion"></div>
                </div>
                <div class="div_objeto_maldito">
                    <div class="div_texto_objetoUbicacion"></div> 
                    <div class="div_texto_objetoUbicacion"></div>
                </div>
            </div>
        </div>
    </div>




    <script src="../Index/script.js"></script>

</body>

</html>