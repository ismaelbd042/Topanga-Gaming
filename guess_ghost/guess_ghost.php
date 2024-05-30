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
        .menu_lateral {
            position: sticky;
            height: 100vh;
            width: 250px;
            background-color: #494a60;
            border: solid 1px black;
            display: flex;
            flex-direction: column;
            padding: 10px;
            gap: 10px;
            color: white;
            z-index: 1;
            transition: transform 0.3s ease;
        }

        .fixed {
            position: fixed;
            top: 0.5px;
        }

        .menu_lateral * {
            color: white;
        }

        .menu_oculto {
            transform: translateX(-100%);
        }

        .flecha_esconder_menu i {
            transition: transform 0.3s ease;
        }

        .flecha_esconder_menu {
            width: 40px;
            height: 100.3%;
            background-color: #494a60;
            position: absolute;
            top: -1px;
            right: -40px;
            border: solid 1px black;
            border-left: 0;
            border-radius: 0 10px 10px 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container_guess_ghost {
            height: calc(100vh - 70px);
            width: 100%;
            position: absolute;
            top: 70px;
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: center;
            gap: 5%;
            z-index: 0;
            padding: 20px 0 20px 0;
        }

        .herramientas_guess_ghost {
            /* height: 100%; */
            display: flex;
            flex-direction: column;
            gap: 1vh;
        }

        .titulo_pruebas {
            font-size: 28px;
        }

        .pruebas {
            background-color: #353546;
            border-radius: 5px;
            display: flex;
            flex-direction: column;
            margin-bottom: 3%;
        }

        .row_pruebas {
            height: 25px;
            display: flex;
            flex-wrap: nowrap;
            align-content: center;
            align-items: center;
            justify-content: space-between;
            position: relative;
        }

        .pata_mono {
            height: 22px;
            cursor: pointer;
            margin-right: 10px;
            filter: opacity(0.2);
        }

        .checkbox {
            width: 16px;
            height: 16px;
            cursor: pointer;
            margin-right: 10px;
            border-radius: 5px;
            border: solid 2px #ccc;
            display: flex;
            align-content: center;
            justify-content: center;
        }

        hr {
            border: 1px dashed rgba(204, 204, 204, 0.26);
            margin: 5px;
            width: 95%;
        }

        #num_pruebas {
            background-color: #353546;
            border: 0;
            border-radius: 5px;
            height: 1.8em;
            color: white;
        }

        #reset {
            width: 100%;
            align-self: center;
            color: white;
            border-radius: 5px;
            border: solid 2px white;
            height: 50px;
            font-size: 16px;
            background: none;
            cursor: pointer;
        }

        #emf5,
        #ultravioleta,
        #escritura,
        #heladas,
        #dots,
        #orbes,
        #spirit,
        #lento,
        #normal,
        #rapido,
        #con_vision,
        #tarde,
        #normal_cordura,
        #pronto,
        #muy_pronto {
            border: 0;
            background: none;
            position: relative;
            margin: 4px 0px;
            padding: 1px 6px;
            cursor: pointer;
            font-size: 18px;
            font-family: "Yahfie";
            letter-spacing: 1.5;
            display: flex;
            justify-content: start;
        }

        #blur_pata_mono {
            position: absolute;
            left: 0;
            z-index: 1;
            width: 85%;
        }

        .num_cordura {
            color: #bbb;
            font-size: 12px;
        }

        .tarjeta_fantasma_general {
            min-width: 40%;
            max-width: 625px;
            height: 220px;
            background: #313247;
            border-radius: 20px;
            display: flex;
            justify-content: space-evenly;
            flex-direction: row;
            align-items: center;
            overflow: hidden;
            flex-wrap: wrap;
        }

        .div_izq {
            width: 47%;
            height: 90%;
            /* border: 1px solid; */

            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-around;
            text-align: center;
        }

        .div_der {
            width: 47%;
            height: 90%;
            /* border: 1px solid; */

            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }

        .div_nombre_fantasma {
            /* text-align: center; */
            /* border: 1px solid; */
            width: 100%;
            height: 22%;
            align-self: center;

            font-family: OctoberCrow;
            color: white;
            font-size: 40px;
        }

        .div_pruebas_fantasma {
            /* text-align: center; */
            /* border: 1px solid; */
            width: 100%;
            height: 39%;
            /* color: white; */

            display: flex;
            flex-direction: row;
            justify-content: space-evenly;
        }

        .div_prueba {
            /* border: 1px solid; */
            width: 30%;
            height: 100%;

            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            padding-top: 2%;
        }

        .div_info_fantasma {
            /* text-align: center; */
            /* border: 1px solid; */
            width: 100%;
            height: 23%;
            border-radius: 5px;
            background: #262537;

            display: flex;
            flex-direction: row;
            justify-content: space-evenly;
            align-self: center;
        }

        .div_cerebro {
            /* border: 1px solid; */
            width: 35%;
            height: 95%;

            display: flex;
            flex-direction: row;
            align-items: left;
            align-self: center;
        }

        .div_pisadas {
            /* border: 1px solid; */
            width: 55%;
            height: 95%;

            display: flex;
            justify-content: space-evenly;
            flex-direction: row;
            align-items: left;
            align-self: center;
        }

        .div_evidencias_fantasma {
            /* border: 1px solid; */
            width: 85%;
            height: 95%;
            background: #262537;
            overflow: scroll;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            align-items: center;
            border-radius: 5px;
            cursor: default;
        }

        .div_evidencias_fantasma::-webkit-scrollbar {
            display: block;
            width: 4px;
        }

        .div_evidencias_fantasma::-webkit-scrollbar-thumb {
            background-color: #888;
            /* Color del thumb (el "botón" de la barra de desplazamiento) */
            border-radius: 5px;
        }


        .div_iconos {
            /* border: 1px solid; */
            width: 13%;
            height: 95%;

            display: flex;
            flex-direction: column;
            justify-content: space-evenly;
        }

        .div_iconos i {
            width: 1px;
            color: #262537;
            position: relative;
            left: 10px;
        }

        .texto_evidence {
            /* border: 1px solid; */
            width: 95%;
            height: 10%;

            color: #A2A2AD;
            text-align: right;
            font-size: 16px;
            align-self: center;
        }

        .texto_tells {
            /* border: 1px solid; */
            width: 95%;
            height: 10%;

            color: #A2A2AD;
            text-align: left;
            font-size: 16px;
        }

        .texto_info {
            /* border: 1px solid; */
            width: 95%;
            height: 70%;

            color: white;
            text-align: left;
            font-size: 18px;
        }

        .iconoC {
            width: 30%;
        }

        .iconoP {
            width: 20%;
        }

        .iconoA {
            width: 10%;
        }

        .div_numeros {
            font-size: 20px;
            color: #A2A2AD;
            /* border: 1px solid; */
            align-self: center;
        }

        .div_iconos_pruebas {
            width: 35%;
            /* border: 1px solid; */
        }

        .div_texto_pruebas {
            width: 100%;
            height: 20%;
            /* border: 1px solid; */
            text-align: center;
            color: white;
            font-size: 14px;
        }

        .checkbox .checked {
            position: relative;
            top: -7px;
        }

        button.marked .checkbox .icon::before {
            content: '\2713';
            position: relative;
            top: -6px;
        }

        button:not(.marked) .checkbox .icon::before {
            content: '\00D7';
            position: relative;
            top: -4px;
        }
    </style>
</head>

<body>
    <div class="overlay"></div>
    <?php
    include "../header y footer/header.html";
    include "../header y footer/VentanaModal.html";
    include "../database/connect.php";
    ?>
    <div class="menu_lateral menu_oculto" id="menuLateral">
        <div class="flecha_esconder_menu" onclick="toggleMenu()">
            <i class="fa-solid fa-angle-right" id="flechaIcono"></i>
        </div>
        <div class="herramientas_guess_ghost">
            <div class="titulo_pruebas">Pruebas</div>
            <select name="num_pruebas" id="num_pruebas">
                <option value="3A">Amateur (3)</option>
                <option value="3I">Intermediate (3)</option>
                <option value="3">Professional (3)</option>
                <option value="2">Nightmare (2)</option>
                <option value="1">Insanity (1)</option>
                <option value="0">Apocalypse III (0)</option>
                <option value="-1">Custom (?)</option>
            </select>
            <div class="pruebas">
                <div class="row_pruebas row_prueba">
                    <img class="blur_pata_mono" style="display: none;" src="" alt="">
                    <button id="emf5">
                        <div class="checkbox"><span class="icon"></span></div>
                        <div class="label">EMF 5</div>
                    </button>
                    <img class="pata_mono" src="../img/Icons/paw-icon.png" alt="">
                </div>
                <div class="row_pruebas row_prueba">
                    <img class="blur_pata_mono" style="display: none;" src="" alt="">
                    <button id="ultravioleta">
                        <div class="checkbox"><span class="icon"></span></div>
                        <div class="label">Ultravioleta</div>
                    </button>
                    <img class="pata_mono" src="../img/Icons/paw-icon.png" alt="">
                </div>
                <div class="row_pruebas row_prueba">
                    <img class="blur_pata_mono" style="display: none;" src="" alt="">
                    <button id="escritura">
                        <div class="checkbox"><span class="icon"></span></div>
                        <div class="label">Escritura</div>
                    </button>
                    <img class="pata_mono" src="../img/Icons/paw-icon.png" alt="">
                </div>
                <div class="row_pruebas row_prueba">
                    <img class="blur_pata_mono" style="display: none;" src="" alt="">
                    <button id="heladas">
                        <div class="checkbox"><span class="icon"></span></div>
                        <div class="label">Heladas</div>
                    </button>
                    <img class="pata_mono" src="../img/Icons/paw-icon.png" alt="">
                </div>
                <div class="row_pruebas row_prueba">
                    <img class="blur_pata_mono" style="display: none;" src="" alt="">
                    <button id="dots">
                        <div class="checkbox"><span class="icon"></span></div>
                        <div class="label">DOTs</div>
                    </button>
                    <img class="pata_mono" src="../img/Icons/paw-icon.png" alt="">
                </div>
                <div class="row_pruebas row_prueba">
                    <img class="blur_pata_mono" style="display: none;" src="" alt="">
                    <button id="orbes">
                        <div class="checkbox"><span class="icon"></span></div>
                        <div class="label">Orbes</div>
                    </button>
                    <img class="pata_mono" src="../img/Icons/paw-icon.png" alt="">
                </div>
                <div class="row_pruebas row_prueba">
                    <img class="blur_pata_mono" style="display: none;" src="" alt="">
                    <button id="spirit">
                        <div class="checkbox"><span class="icon"></span></div>
                        <div class="label">Spirit Box</div>
                    </button>
                    <img class="pata_mono" src="../img/Icons/paw-icon.png" alt="">
                </div>
            </div>
            <div class="titulo_pruebas">Velocidad</div>
            <div class="pruebas">
                <div class="row_pruebas row_velocidad">
                    <button id="lento">
                        <div class="checkbox"><span class="icon"></span></div>
                        <div class="label">Lento</div>
                    </button>
                </div>
                <div class="row_pruebas row_velocidad">
                    <button id="normal">
                        <div class="checkbox"><span class="icon"></span></div>
                        <div class="label">Normal</div>
                    </button>
                </div>
                <div class="row_pruebas row_velocidad">
                    <button id="rapido">
                        <div class="checkbox"><span class="icon"></span></div>
                        <div class="label">Rápido</div>
                    </button>
                </div>
                <hr>
                <div class="row_pruebas row_velocidad">
                    <button id="con_vision">
                        <div class="checkbox"><span class="icon"></span></div>
                        <div class="label">Más rápido al verte</div>
                    </button>
                </div>
            </div>
            <div class="titulo_pruebas">Cordura de cacería</div>
            <div class="pruebas">
                <div class="row_pruebas row_cordura">
                    <button id="tarde">
                        <div class="checkbox"><span class="icon"></span></div>
                        <div class="label">Tarde <span class="num_cordura">(&lt;40%)</span>
                        </div>
                    </button>
                </div>
                <div class="row_pruebas row_cordura">
                    <button id="normal_cordura">
                        <div class="checkbox"><span class="icon"></span></div>
                        <div class="label">Normal <span class="num_cordura">(&gt;40%)</span>
                        </div>
                    </button>
                </div>
                <div class="row_pruebas row_cordura">
                    <button id="pronto">
                        <div class="checkbox"><span class="icon"></span></div>
                        <div class="label">Pronto <span class="num_cordura">(&gt;50%)</span>
                        </div>
                    </button>
                </div>
                <div class="row_pruebas row_cordura">
                    <button id="muy_pronto">
                        <div class="checkbox"><span class="icon"></span></div>
                        <div class="label">Muy pronto <span class="num_cordura">(&gt;75%)</span>
                        </div>
                    </button>
                </div>
            </div>
        </div>
        <button id="reset">Reset</button>
    </div>

    <div class="container_guess_ghost">
        <?php
        // Obtener la conexión a la base de datos
        $conexion = getConexion();

        $sql = "SELECT f.id AS id_fantasma, f.nombre AS fantasma, f.cordura, f.velocidad, f.descripcion, f.extra, p.nombre AS prueba
            FROM fantasmas f
            JOIN pruebas_fantasmas pf ON f.id = pf.fantasma_id
            JOIN pruebas p ON p.id = pf.prueba_id
            ORDER BY f.id";
        $result = $conexion->query($sql);

        $fantasmas = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $nombre_fantasma = $row['fantasma'];
                $fantasmas[$nombre_fantasma]['id'] = $row['id_fantasma'];
                $fantasmas[$nombre_fantasma]['cordura'] = $row['cordura'];
                $fantasmas[$nombre_fantasma]['velocidad'] = $row['velocidad'];
                $fantasmas[$nombre_fantasma]['descripcion'] = $row['descripcion'];
                $fantasmas[$nombre_fantasma]['extra'] = $row['extra'];
                $fantasmas[$nombre_fantasma]['pruebas'][] = $row['prueba'];
            }
        }

        foreach ($fantasmas as $nombre => $datos) : ?>
            <div class="tarjeta_fantasma_general">
                <span style='display: none;'><?php echo $datos['id']; ?></span>
                <div class="div_izq">
                    <div class="div_nombre_fantasma"><?php echo quitarTildes($nombre); ?></div>
                    <div class="div_pruebas_fantasma">
                        <?php foreach ($datos['pruebas'] as $prueba) : ?>
                            <div class="div_prueba">
                                <img src="../img/Fotos pruebas/<?php echo $prueba; ?>.svg" alt="" class="div_iconos_pruebas">
                                <div class="div_texto_pruebas"><?php echo $prueba; ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="div_info_fantasma">
                        <div class="div_cerebro">
                            <img src="../img/Icons/cerebro.svg" alt="" class="iconoC">
                            <div class="div_numeros"><?php echo $datos['cordura']; ?>%</div>
                        </div>
                        <div class="div_pisadas">
                            <img src="../img/Icons/pisadas.svg" alt="" class="iconoP">
                            <div class="div_numeros"><?php echo $datos['velocidad']; ?> m/s</div>
                            <img src="../img/Icons/altavoz.svg" alt="" class="iconoA">
                        </div>
                    </div>
                </div>
                <div class="div_der">
                    <div class="div_evidencias_fantasma">
                        <div class="texto_evidence">0 Evidence Test >></div>
                        <div class="texto_tells">Tells---------------------------------------</div>
                        <div class="texto_info"><?php echo nl2br($datos['extra']); ?></div>
                    </div>
                    <div class="div_iconos">
                        <i class="fa-solid fa-check fa-2xl"></i>
                        <i class="fa-solid fa-xmark fa-2xl"></i>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <?php $conexion->close();
        function quitarTildes($cadena)
        {
            // Arrays con las letras acentuadas y sus equivalentes sin acento
            $letras_acentuadas = array('á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú');
            $letras_sin_acento = array('a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U');

            // Reemplazar las letras acentuadas con las sin acento
            $cadena = str_replace($letras_acentuadas, $letras_sin_acento, $cadena);

            return $cadena;
        } ?>
    </div>

    <script src="../Index/script.js"></script>
    <script>
        window.addEventListener("scroll", function() {
            var menu = document.getElementById("menuLateral");
            if (window.scrollY > 70) {
                menu.classList.add("fixed");
            } else {
                menu.classList.remove("fixed");
            }
        });

        function toggleMenu() {
            var menu = document.getElementById("menuLateral");
            var flechaIcono = document.getElementById("flechaIcono");

            menu.classList.toggle("menu_oculto");

            // Cambia el icono de la flecha
            if (menu.classList.contains("menu_oculto")) {
                flechaIcono.classList.remove("fa-angle-left");
                flechaIcono.classList.add("fa-angle-right");
            } else {
                flechaIcono.classList.remove("fa-angle-right");
                flechaIcono.classList.add("fa-angle-left");
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            var pruebasMarcadas = [];

            var botonesPruebas = document.querySelectorAll('.row_pruebas button');

            botonesPruebas.forEach(function(boton) {
                boton.addEventListener('click', function() {

                    var idPrueba = boton.id;

                    var marcado = pruebasMarcadas.includes(idPrueba);

                    if (marcado) {
                        var index = pruebasMarcadas.indexOf(idPrueba);
                        pruebasMarcadas.splice(index, 1);
                        boton.classList.remove('marked');
                    } else {
                        pruebasMarcadas.push(idPrueba);
                        boton.classList.add('marked');
                    }

                    console.log(pruebasMarcadas);
                    // Enviar la información al servidor
                    fetch('averiguar.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(pruebasMarcadas)
                        })
                        .then(response => response.text()) // Convertir la respuesta a texto
                        .then(data => console.log(data))
                        .catch(error => console.error('Error:', error)); // Manejar errores si los hay
                });
            });
        });


        // const checkbox = button.querySelector('.checkbox .icon');
        // checkbox.innerHTML = '&#10006;';
        // checkbox.classList.add('checked');
        // checkbox.innerHTML = '';
        // checkbox.classList.remove('checked');

        // document.addEventListener('DOMContentLoaded', function() {
        //     const pruebaButtons = document.querySelectorAll('.row_prueba button');
        //     const resetButton = document.getElementById('reset');
        //     const fantasmaCards = document.querySelectorAll('.tarjeta_fantasma_general');
        //     const pruebasSeleccionadas = new Set();

        //     // Map de id de botón a nombre de prueba
        //     const pruebaNombreMap = {
        //         'emf5': 'Medidor EMF 5',
        //         'ultravioleta': 'Ultravioleta',
        //         'escritura': 'Escritura Fantasmal',
        //         'heladas': 'Temperaturas Heladas',
        //         'dots': 'Proyector D.O.T.S.',
        //         'orbes': 'Orbes Espectrales',
        //         'spirit': 'Spirit Box',
        //         'tarde': '40%',
        //         'normal_cordura': '50%',
        //         'pronto': '60%',
        //         'muy_pronto': '75%'
        //     };

        //     pruebaButtons.forEach(button => {
        //         button.addEventListener('click', () => {
        //             const prueba = pruebaNombreMap[button.id];
        //             const isActive = button.classList.toggle('active');

        //             if (isActive) {
        //                 pruebasSeleccionadas.add(prueba);

        //             } else {
        //                 pruebasSeleccionadas.delete(prueba);

        //             }

        //             filtrarFantasmas();
        //         });
        //     });

        //     resetButton.addEventListener('click', () => {
        //         pruebasSeleccionadas.clear();
        //         pruebaButtons.forEach(button => {
        //             button.classList.remove('active');
        //             const checkbox = button.querySelector('.checkbox .icon');
        //             checkbox.classList.remove('checked');
        //         });
        //         mostrarTodosFantasmas();
        //     });

        //     function filtrarFantasmas() {
        //         fantasmaCards.forEach(card => {
        //             const pruebasFantasma = Array.from(card.querySelectorAll('.div_pruebas_fantasma .div_prueba')).map(pruebaDiv => pruebaDiv.querySelector('.div_texto_pruebas').textContent.trim());
        //             const match = Array.from(pruebasSeleccionadas).every(prueba => pruebasFantasma.includes(prueba));
        //             card.style.display = match ? '' : 'none';
        //         });
        //     }

        //     function mostrarTodosFantasmas() {
        //         fantasmaCards.forEach(card => {
        //             card.style.display = '';
        //         });

        //         pruebaButtons.forEach(button => {
        //             const checkbox = button.querySelector('.checkbox .icon');
        //             checkbox.innerHTML = '';
        //             checkbox.classList.remove('checked');
        //         });
        //     }
        // });

        // document.addEventListener('DOMContentLoaded', function() {
        //     const corduraButtons = document.querySelectorAll('.row_cordura button');
        //     const resetButton = document.getElementById('reset');
        //     const fantasmaCards = document.querySelectorAll('.tarjeta_fantasma_general');
        //     let corduraSeleccionada = 'normal_cordura';

        //     // Rangos de cordura
        //     const corduraRanges = {
        //         'tarde': [0, 41],
        //         'normal_cordura': [41, 51],
        //         'pronto': [51, 76],
        //         'muy_pronto': [76, 101]
        //     };

        //     corduraButtons.forEach(button => {
        //         button.addEventListener('click', () => {
        //             // Desmarcar todos los botones
        //             corduraButtons.forEach(btn => {
        //                 btn.classList.remove('active');
        //                 const checkbox = btn.querySelector('.checkbox .icon');
        //                 checkbox.innerHTML = '';
        //                 checkbox.classList.remove('checked');
        //             });

        //             // Marcar el botón seleccionado
        //             button.classList.add('active');
        //             const checkbox = button.querySelector('.checkbox .icon');
        //             checkbox.innerHTML = '&#10006;';
        //             checkbox.classList.add('checked');

        //             corduraSeleccionada = button.id;
        //             filtrarFantasmas();
        //         });
        //     });

        //     resetButton.addEventListener('click', () => {
        //         corduraSeleccionada = 'normal_cordura';
        //         // Desmarcar todos los botones
        //         corduraButtons.forEach(btn => {
        //             btn.classList.remove('active');
        //             const checkbox = btn.querySelector('.checkbox .icon');
        //             checkbox.innerHTML = '';
        //             checkbox.classList.remove('checked');
        //         });
        //         mostrarTodosFantasmas();
        //     });

        //     function filtrarFantasmas() {
        //         fantasmaCards.forEach(card => {
        //             const corduraFantasma = parseInt(card.querySelector('.div_cerebro .div_numeros').textContent.trim());
        //             const [min, max] = corduraRanges[corduraSeleccionada];
        //             const matchCordura = corduraFantasma >= min && corduraFantasma < max;
        //             card.style.display = matchCordura ? '' : 'none';
        //         });
        //     }

        //     function mostrarTodosFantasmas() {
        //         fantasmaCards.forEach(card => {
        //             card.style.display = '';
        //         });
        //     }
        // });

        // document.addEventListener('DOMContentLoaded', function() {
        //     const velocidadButtons = document.querySelectorAll('.row_velocidad button');
        //     const resetButton = document.getElementById('reset');
        //     const fantasmaCards = document.querySelectorAll('.tarjeta_fantasma_general');
        //     let velocidadSeleccionada = 'normal';

        //     // Rangos de velocidad
        //     const velocidadRanges = {
        //         'lento': [0, 1.7],
        //         'normal': [1.7, 1.71],
        //         'rapido': [1.71, 5],
        //         'con_vision': [5, Infinity] // Suponiendo que "Más rápido al verte" no tiene límite superior
        //     };

        //     velocidadButtons.forEach(button => {
        //         button.addEventListener('click', () => {
        //             // Desmarcar todos los botones
        //             velocidadButtons.forEach(btn => {
        //                 btn.classList.remove('active');
        //                 const checkbox = btn.querySelector('.checkbox .icon');
        //                 checkbox.innerHTML = '';
        //                 checkbox.classList.remove('checked');
        //             });

        //             // Marcar el botón seleccionado
        //             button.classList.add('active');
        //             const checkbox = button.querySelector('.checkbox .icon');
        //             checkbox.innerHTML = '&#10006;';
        //             checkbox.classList.add('checked');

        //             velocidadSeleccionada = button.id;
        //             filtrarFantasmas();
        //         });
        //     });

        //     resetButton.addEventListener('click', () => {
        //         velocidadSeleccionada = 'normal';
        //         // Desmarcar todos los botones
        //         velocidadButtons.forEach(btn => {
        //             btn.classList.remove('active');
        //             const checkbox = btn.querySelector('.checkbox .icon');
        //             checkbox.innerHTML = '';
        //             checkbox.classList.remove('checked');
        //         });
        //         mostrarTodosFantasmas();
        //     });

        //     function filtrarFantasmas() {
        //         fantasmaCards.forEach(card => {
        //             const velocidadFantasmaText = card.querySelector('.div_pisadas .div_numeros').textContent.trim();
        //             // Extraer el rango de velocidades
        //             const velocidadRange = velocidadFantasmaText.match(/\d+\.\d+/g);
        //             // Convertir el rango de velocidad a números
        //             const minVelocidadFantasma = parseFloat(velocidadRange[0]);
        //             const maxVelocidadFantasma = parseFloat(velocidadRange[1]);
        //             // Verificar si el rango de velocidad se superpone con el rango de cada botón
        //             const overlappingRanges = Object.entries(velocidadRanges).filter(([_, range]) => {
        //                 const [min, max] = range;
        //                 return minVelocidadFantasma < max && maxVelocidadFantasma > min;
        //             }).map(([buttonId, _]) => buttonId);
        //             // Mostrar el fantasma si su rango se superpone con el rango del botón seleccionado
        //             card.style.display = overlappingRanges.includes(velocidadSeleccionada) ? '' : 'none';
        //         });
        //     }

        //     function mostrarTodosFantasmas() {
        //         fantasmaCards.forEach(card => {
        //             card.style.display = '';
        //         });
        //     }
        // });
    </script>
</body>

</html>