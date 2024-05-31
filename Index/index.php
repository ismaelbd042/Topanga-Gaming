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
                <div class="imgsMapas" id="Ridgeview"><img src="../img/Fotos mapas/10_Ridgeview_Court.svg" alt=""></div>
                <div class="imgsMapas" id="Willow"><img src="../img/Fotos mapas/13_Willow_Street.svg" alt=""></div>
                <div class="imgsMapas" id="Edgefield"><img src="../img/Fotos mapas/42_Edgefield_Road.svg" alt=""></div>
                <div class="imgsMapas" id="Tanglewood"><img src="../img/Fotos mapas/6_Tanglewood_Drive.svg" alt=""></div>
                <div class="imgsMapas" id="Bleasdale"><img src="../img/Fotos mapas/Bleasdale_Farmhouse.svg" alt=""></div>
                <div class="imgsMapas" id="BrownStone"><img src="../img/Fotos mapas/Brownstone_High_School.svg" alt=""></div>
                <div class="imgsMapas" id="Woodwind"><img src="../img/Fotos mapas/Camp_Woodwind.svg" alt=""></div>
                <div class="imgsMapas" id="Farmhouse"><img src="../img/Fotos mapas/Grafton_Farmhouse.svg" alt=""></div>
                <div class="imgsMapas" id="Lodge"><img src="../img/Fotos mapas/Maple_Lodge_Campsite.svg" alt=""></div>
                <div class="imgsMapas" id="Prison"><img src="../img/Fotos mapas/Prison.svg" alt=""></div>
                <div class="imgsMapas" id="Meadows"><img src="../img/Fotos mapas/Sunny_Meadows_Mental_Institution.svg" alt=""></div>
                <div class="imgsMapas" id="MeadowsRestricted"><img src="../img/Fotos mapas/Sunny_Meadows_Mental_Institution_(Restricted).svg" alt=""></div>
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