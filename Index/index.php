<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="../img/Logo fondo blanco.svg" type="image/x-icon">
    <title>Topanga Gaming</title>
</head>

<body>
    <div class="overlay"></div>
    <?php
    include "../header y footer/header.html";
    include "../header y footer/VentanaModal.html";
    include "../database/connect.php";
    ?>

    <div class="containerIndex">
        <div class="Index1">
            <span id="Titulo_phasmo">phasmophobia</span>
            <span id="desc_index">Eleva tu juego a otro nivel</span>
        </div>
        <div class="Index2">
            <div class="tituloMapa">Investiga los Mapas</div>
            <div class="corchoMapas">
                <div class="tarjeta_mapa_corcho" id="Ridgeview">
                    <div class="imgsMapas"><img src="../img/Fotos mapas/10_Ridgeview_Court.svg" alt=""></div>
                    <span class="nombre_mapa_corcho">10 Ridgeview Court</span>
                </div>
                <div class="tarjeta_mapa_corcho" id="Willow">
                    <div class="imgsMapas"><img src="../img/Fotos mapas/13_Willow_Street.svg" alt=""></div>
                    <span class="nombre_mapa_corcho">13 Willow Street</span>
                </div>
                <div class="tarjeta_mapa_corcho" id="Edgefield">
                    <div class="imgsMapas"><img src="../img/Fotos mapas/42_Edgefield_Road.svg" alt=""></div>
                    <span class="nombre_mapa_corcho">42 Edgefield Road</span>
                </div>
                <div class="tarjeta_mapa_corcho" id="Tanglewood">
                    <div class="imgsMapas"><img src="../img/Fotos mapas/6_Tanglewood_Drive.svg" alt=""></div>
                    <span class="nombre_mapa_corcho">6 Tanglewood drive</span>
                </div>
                <div class="tarjeta_mapa_corcho" id="Bleasdale">
                    <div class="imgsMapas"><img src="../img/Fotos mapas/Bleasdale_Farmhouse.svg" alt=""></div>
                    <span class="nombre_mapa_corcho">Bleasdale Farmhouse</span>
                </div>
                <div class="tarjeta_mapa_corcho" id="BrownStone">
                    <div class="imgsMapas"><img src="../img/Fotos mapas/Brownstone_High_School.svg" alt=""></div>
                    <span class="nombre_mapa_corcho">Brownstone High School</span>
                </div>
                <div class="tarjeta_mapa_corcho" id="Woodwind">
                    <div class="imgsMapas"><img src="../img/Fotos mapas/Camp_Woodwind.svg" alt=""></div>
                    <span class="nombre_mapa_corcho">Camp Woodwind</span>
                </div>
                <div class="tarjeta_mapa_corcho" id="Farmhouse">
                    <div class="imgsMapas"><img src="../img/Fotos mapas/Grafton_Farmhouse.svg" alt=""></div>
                    <span class="nombre_mapa_corcho">Grafton Farmhouse</span>
                </div>
                <div class="tarjeta_mapa_corcho" id="Lodge">
                    <div class="imgsMapas"><img src="../img/Fotos mapas/Maple_Lodge_Campsite.svg" alt=""></div>
                    <span class="nombre_mapa_corcho">Maple Lodge Campsite</span>
                </div>
                <div class="tarjeta_mapa_corcho" id="Prison">
                    <div class="imgsMapas"><img src="../img/Fotos mapas/Prison.svg" alt=""></div>
                    <span class="nombre_mapa_corcho">Prision</span>
                </div>
                <div class="tarjeta_mapa_corcho" id="Meadows">
                    <div class="imgsMapas"><img src="../img/Fotos mapas/Sunny_Meadows_Mental_Institution.svg" alt=""></div>
                    <span class="nombre_mapa_corcho">Sunny Meadows</span>
                </div>
                <div class="tarjeta_mapa_corcho" id="MeadowsRestricted">
                    <div class="imgsMapas"><img src="../img/Fotos mapas/Sunny_Meadows_Mental_Institution_(Restricted).svg" alt=""></div>
                    <span class="nombre_mapa_corcho">Sunny Meadows Restricted</span>
                </div>
                <div class="tarjeta_mapa_corcho" id="Azar">
                    <div class="imgsMapas"><img src="../img/Fotos mapas/Azar.png" alt=""></div>
                    <span class="nombre_mapa_corcho">Al azar</span>
                </div>
            </div>
        </div>

    </div>






    <!-- <span onclick="playSound('https://zero-network.net/phasmophobia/static/assets/banshee_scream.mp3')">Icono de sonido</span> -->
    <!-- codigo que hace que suene un sonido -->
    <?php
    // include "../header y footer/footer.html"
    ?>
    <script src="script.js"></script>
</body>

</html>