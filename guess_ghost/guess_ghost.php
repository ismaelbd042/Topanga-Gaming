<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Index/style.css">
    <link rel="shortcut icon" href="../img/Logo fondo blanco.svg" type="image/x-icon">
    <title>Topanga Gaming</title>
    <style>
        .menu_lateral {
            position: sticky;
            height: fit-content;
            width: 250px;
            background-color: #494a60;
            border-radius: 0 10px 10px 0;
            border: solid 1px black;
            display: flex;
            flex-direction: column;
            padding: 10px;
            gap: 10px;
            color: white;
        }

        .menu_lateral * {
            color: white;
        }

        .container_guess_ghost {
            height: calc(100vh - 70px);
            width: 100%;
            border: solid 1px white;
            position: absolute;
            top: 70px;
        }

        .herramientas_guess_ghost {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .titulo_pruebas {
            font-size: 28px;
        }

        .pruebas {
            background-color: #353546;
            border-radius: 5px;
            display: flex;
            flex-direction: column;
        }

        .row_pruebas {
            height: 2.2em;
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
    </style>
</head>

<body>
    <div class="overlay"></div>
    <?php
    include "../header y footer/header.html";
    include "../header y footer/VentanaModal.html";
    include "../database/connect.php";
    ?>
    <div class="menu_lateral">
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
                <div class="row_pruebas">
                    <img class="blur_pata_mono" style="display: none;" src="" alt="">
                    <button id="emf5">
                        <div class="checkbox"><span class="icon"></span></div>
                        <div class="label">EMF 5</div>
                    </button>
                    <img class="pata_mono" src="../img/Icons/paw-icon.png" alt="">
                </div>
                <div class="row_pruebas">
                    <img class="blur_pata_mono" style="display: none;" src="" alt="">
                    <button id="ultravioleta">
                        <div class="checkbox"><span class="icon"></span></div>
                        <div class="label">Ultravioleta</div>
                    </button>
                    <img class="pata_mono" src="../img/Icons/paw-icon.png" alt="">
                </div>
                <div class="row_pruebas">
                    <img class="blur_pata_mono" style="display: none;" src="" alt="">
                    <button id="escritura">
                        <div class="checkbox"><span class="icon"></span></div>
                        <div class="label">Escritura</div>
                    </button>
                    <img class="pata_mono" src="../img/Icons/paw-icon.png" alt="">
                </div>
                <div class="row_pruebas">
                    <img class="blur_pata_mono" style="display: none;" src="" alt="">
                    <button id="heladas">
                        <div class="checkbox"><span class="icon"></span></div>
                        <div class="label">Heladas</div>
                    </button>
                    <img class="pata_mono" src="../img/Icons/paw-icon.png" alt="">
                </div>
                <div class="row_pruebas">
                    <img class="blur_pata_mono" style="display: none;" src="" alt="">
                    <button id="dots">
                        <div class="checkbox"><span class="icon"></span></div>
                        <div class="label">DOTs</div>
                    </button>
                    <img class="pata_mono" src="../img/Icons/paw-icon.png" alt="">
                </div>
                <div class="row_pruebas">
                    <img class="blur_pata_mono" style="display: none;" src="" alt="">
                    <button id="orbes">
                        <div class="checkbox"><span class="icon"></span></div>
                        <div class="label">Orbes</div>
                    </button>
                    <img class="pata_mono" src="../img/Icons/paw-icon.png" alt="">
                </div>
                <div class="row_pruebas">
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
                <div class="row_pruebas">
                    <button id="lento">
                        <div class="checkbox"><span class="icon"></span></div>
                        <div class="label">Lento</div>
                    </button>
                </div>
                <div class="row_pruebas">
                    <button id="normal">
                        <div class="checkbox"><span class="icon"></span></div>
                        <div class="label">Normal</div>
                    </button>
                </div>
                <div class="row_pruebas">
                    <button id="rapido">
                        <div class="checkbox"><span class="icon"></span></div>
                        <div class="label">Rápido</div>
                    </button>
                </div>
                <hr>
                <div class="row_pruebas">
                    <button id="con_vision">
                        <div class="checkbox"><span class="icon"></span></div>
                        <div class="label">Más rápido al verte</div>
                    </button>
                </div>
            </div>
            <div class="titulo_pruebas">Cordura de cacería</div>
            <div class="pruebas">
                <div class="row_pruebas">
                    <button id="tarde">
                        <div class="checkbox"><span class="icon"></span></div>
                        <div class="label">Tarde <span class="num_cordura">(&lt;40%)</span>
                        </div>
                    </button>
                </div>
                <div class="row_pruebas">
                    <button id="normal_cordura">
                        <div class="checkbox"><span class="icon"></span></div>
                        <div class="label">Normal <span class="num_cordura">(&gt;40%)</span>
                        </div>
                    </button>
                </div>
                <div class="row_pruebas">
                    <button id="pronto">
                        <div class="checkbox"><span class="icon"></span></div>
                        <div class="label">Pronto <span class="num_cordura">(&gt;50%)</span>
                        </div>
                    </button>
                </div>
                <div class="row_pruebas">
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

    </div>

    <?php
    // Obtener la conexión a la base de datos
    $conexion = getConexion();
    ?>


    <script src="../Index/script.js"></script>

</body>

</html>