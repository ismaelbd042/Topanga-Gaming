<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
        <div class="indexServicios">
            <span class="tituloServicios">Nuestros servicios</span>
            <span class="descServicios">Descubre las potentes características que hacen que nuestras soluciones se destaquen frente a la competencia.</span>
            <div class="tiposServicios">
                <div class="servicios">
                    <div class="miniTituloServicios"><i class="fa-regular fa-comment-dots"></i> Chat en línea</div>
                    <div class="miniDescServicios">Chatea en linea con tus compañeros y mantén una comunicación con el fin de adivinar el fantasma misterioso.</div>
                </div>
                <div class="servicios">
                    <div class="miniTituloServicios"><i class="fa-solid fa-video"></i> Contenido audiovisual</div>
                    <div class="miniDescServicios">Visualiza o comparte contenido on-line y sorprendete con trucos nuevos e increibles.</div>
                </div>
                <div class="servicios">
                    <div class="miniTituloServicios"><i class="fa-solid fa-ghost"></i> Averigüa el fantasma</div>
                    <div class="miniDescServicios">Descarta pruebas, recibe pistas ocultas y descubre el fantasma correcto.</div>
                </div>
            </div>
        </div>
        <div class="Index2" id="Index2">
            <div class="tituloMapa">Investiga los Mapas</div>
            <div class="corchoMapas">
                <div class="tarjeta_mapa_corcho" id="Ridgeview" data-mapa="10_Ridgeview_Court">
                    <div class="imgsMapas"><img src="../img/Fotos mapas/10_Ridgeview_Court.png" alt=""></div>
                    <span class="nombre_mapa_corcho">10 Ridgeview Court</span>
                </div>
                <div class="tarjeta_mapa_corcho" id="Willow" data-mapa="13_Willow_Street">
                    <div class="imgsMapas"><img src="../img/Fotos mapas/13_Willow_Street.png" alt=""></div>
                    <span class="nombre_mapa_corcho">13 Willow Street</span>
                </div>
                <div class="tarjeta_mapa_corcho" id="Edgefield" data-mapa="42_Edgefield_Road">
                    <div class="imgsMapas"><img src="../img/Fotos mapas/42_Edgefield_Road.png" alt=""></div>
                    <span class="nombre_mapa_corcho">42 Edgefield Road</span>
                </div>
                <div class="tarjeta_mapa_corcho" id="Tanglewood" data-mapa="6_Tanglewood_Drive">
                    <div class="imgsMapas"><img src="../img/Fotos mapas/6_Tanglewood_Drive.png" alt=""></div>
                    <span class="nombre_mapa_corcho">6 Tanglewood drive</span>
                </div>
                <div class="tarjeta_mapa_corcho" id="Bleasdale" data-mapa="Bleasdale_Farmhouse">
                    <div class="imgsMapas"><img src="../img/Fotos mapas/Bleasdale_Farmhouse.png" alt=""></div>
                    <span class="nombre_mapa_corcho">Bleasdale Farmhouse</span>
                </div>
                <div class="tarjeta_mapa_corcho" id="BrownStone" data-mapa="Brownstone_High_School">
                    <div class="imgsMapas"><img src="../img/Fotos mapas/Brownstone_High_School.png" alt=""></div>
                    <span class="nombre_mapa_corcho">Brownstone High School</span>
                </div>
                <div class="tarjeta_mapa_corcho" id="Woodwind" data-mapa="Camp_Woodwind">
                    <div class="imgsMapas"><img src="../img/Fotos mapas/Camp_Woodwind.png" alt=""></div>
                    <span class="nombre_mapa_corcho">Camp Woodwind</span>
                </div>
                <div class="tarjeta_mapa_corcho" id="Farmhouse" data-mapa="Grafton_Farmhouse">
                    <div class="imgsMapas"><img src="../img/Fotos mapas/Grafton_Farmhouse.png" alt=""></div>
                    <span class="nombre_mapa_corcho">Grafton Farmhouse</span>
                </div>
                <div class="tarjeta_mapa_corcho" id="Lodge" data-mapa="Maple_Lodge_Campsite">
                    <div class="imgsMapas"><img src="../img/Fotos mapas/Maple_Lodge_Campsite.png" alt=""></div>
                    <span class="nombre_mapa_corcho">Maple Lodge Campsite</span>
                </div>
                <div class="tarjeta_mapa_corcho" id="Prison" data-mapa="Prison">
                    <div class="imgsMapas"><img src="../img/Fotos mapas/Prison.png" alt=""></div>
                    <span class="nombre_mapa_corcho">Prision</span>
                </div>
                <div class="tarjeta_mapa_corcho" id="Meadows" data-mapa="Sunny_Meadows_Mental_Institution">
                    <div class="imgsMapas"><img src="../img/Fotos mapas/Sunny_Meadows_Mental_Institution.png" alt=""></div>
                    <span class="nombre_mapa_corcho">Sunny Meadows</span>
                </div>
                <div class="tarjeta_mapa_corcho" id="MeadowsRestricted" data-mapa="Sunny_Meadows_Mental_Institution_(Restricted)">
                    <div class="imgsMapas"><img src="../img/Fotos mapas/Sunny_Meadows_Mental_Institution_(Restricted).png" alt=""></div>
                    <span class="nombre_mapa_corcho">Sunny Meadows Restricted</span>
                </div>
                <div class="tarjeta_mapa_corcho" id="Azar" data-mapa="random">
                    <div class="imgsMapas"><img src="../img/Fotos mapas/Azar.png" alt=""></div>
                    <span class="nombre_mapa_corcho">Al azar</span>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const tarjetasMapa = document.querySelectorAll(".tarjeta_mapa_corcho");

            tarjetasMapa.forEach(tarjeta => {
                tarjeta.addEventListener("click", function() {
                    const nombreMapa = this.getAttribute("data-mapa");

                    if (nombreMapa === "random") {
                        const randomMapName = getRandomMapName();

                        window.location.href = `../mapas/mapas.php?mapa=${randomMapName}`;
                    } else {
                        window.location.href = `../mapas/mapas.php?mapa=${nombreMapa}`;
                    }
                });
            });
        });

        // Function to generate a random map name
        function getRandomMapName() {
            const availableMaps = ["10_Ridgeview_Court",
                "13_Willow_Street",
                "42_Edgefield_Road",
                "Sunny_Meadows_Mental_Institution_(Restricted)",
                "Sunny_Meadows_Mental_Institution", "Prison",
                "Maple_Lodge_Campsite",
                "Grafton_Farmhouse",
                "Camp_Woodwind",
                "Brownstone_High_School",
                "Bleasdale_Farmhouse",
                "6_Tanglewood_Drive"
            ];
            const randomIndex = Math.floor(Math.random() * availableMaps.length);
            return availableMaps[randomIndex];
        }
    </script>
    <script src="script.js"></script>
</body>

</html>