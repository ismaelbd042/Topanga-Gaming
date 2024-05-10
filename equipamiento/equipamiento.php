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
        padding-top: 2em;
    }

    .container_carrousel {
        width: 1000px;
        overflow: hidden;
        position: relative;
    }

    .container_carrousel_equipamiento {
        display: flex;
        flex-direction: row;
        width: 300%;
        overflow: hidden;
        transition: transform 0.5s ease;
        margin-top: 1em;
    }

    .container_equipamiento {
        display: flex;
        flex-direction: row;
        width: 1000px;
        height: 70vh;
        align-items: center;
        background-color: #ffffff;
        border-radius: 10px;
        overflow: hidden;
        border: 1px solid black;
    }

    .container_equipamiento .div_img_equipamiento {
        width: 50%;
        height: 100%;
        justify-content: center;
        background: radial-gradient(50% 50% at 50% 50%, rgb(0, 0, 51) 0%, rgb(95, 20, 149) 100%);
        display: flex;
        align-items: center;
    }

    .container_equipamiento .img_equipamiento {
        position: relative;
        width: 400px;
        height: auto;
        /* transform: rotate(-20deg); */
        object-fit: cover;
    }

    .container_equipamiento .div_info_equipamiento {
        width: 50%;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        gap: 30px;
        align-items: center;
    }

    .container_equipamiento .div_nivel_equipamiento {
        justify-content: center;
        gap: 120px;
        padding: 50px 0 0 0;
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
        font-size: 26px;
    }

    .arrow {
        position: relative;
        bottom: 1em;
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
        left: calc(-51.2% + 1em);
    }

    .arrow-right {
        right: calc(-51.2% + 1em);
        color: black;
    }

    #nombre_equipamiento {
        font-family: OctoberCrow;
        font-size: 50px;
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
    ?>
    <div class="container_general_equipamiento">
        <div class="container_carrousel">
            <span id="nombre_equipamiento">Medidor EMF</span>
            <div class="container_carrousel_equipamiento">
                <div class="container_equipamiento equipamiento1_carrosuel">
                    <div class="div_img_equipamiento"><img class="img_equipamiento" src="../img/Fotos equipamiento/emf1 1.svg" /></div>
                    <div class="div_info_equipamiento">
                        <div class="div_nivel_equipamiento"><img class="nivel_equipamiento" src="../img/Fotos equipamiento/NivelEquipamiento.svg" /></div>
                        <p class="info_equipamiento">
                            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nemo obcaecati itaque quos rem officia
                            labore
                            autem laborum consectetur quasi aliquam magni vero fugiat, sed maxime voluptates cum, modi a
                            accusamus.
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Quod hic obcaecati illo quis eum
                            deleniti
                            atque
                            quam! Commodi officia sapiente delectus, eveniet, debitis voluptatem labore ut ipsam in
                            reiciendis
                            aspernatur.
                        </p>
                    </div>
                </div>
                <div class="container_equipamiento equipamiento2_carrosuel">
                    <div class="div_img_equipamiento"><img class="img_equipamiento" src="../img/Fotos equipamiento/emf2 1.svg" /></div>
                    <div class="div_info_equipamiento">
                        <div class="div_nivel_equipamiento"><img class="nivel_equipamiento" src="../img/Fotos equipamiento/NivelEquipamiento.svg" /><img class="nivel_equipamiento" src="../img/Fotos equipamiento/NivelEquipamiento.svg" /></div>
                        <p class="info_equipamiento">
                            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nemo obcaecati itaque quos rem officia
                            labore
                            autem laborum consectetur quasi aliquam magni vero fugiat, sed maxime voluptates cum, modi a
                            accusamus.
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Quod hic obcaecati illo quis eum
                            deleniti
                            atque
                            quam! Commodi officia sapiente delectus, eveniet, debitis voluptatem labore ut ipsam in
                            reiciendis
                            aspernatur.
                        </p>
                    </div>
                </div>
                <div class="container_equipamiento equipamiento3_carrosuel">
                    <div class="div_img_equipamiento"><img class="img_equipamiento" src="../img/Fotos equipamiento/emf3 1.svg" />
                    </div>
                    <div class="div_info_equipamiento">
                        <div class="div_nivel_equipamiento"><img class="nivel_equipamiento" src="../img/Fotos equipamiento/NivelEquipamiento.svg" /><img class="nivel_equipamiento" src="../img/Fotos equipamiento/NivelEquipamiento.svg" /><img class="nivel_equipamiento" src="../img/Fotos equipamiento/NivelEquipamiento.svg" /></div>
                        <p class="info_equipamiento">
                            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nemo obcaecati itaque quos rem officia
                            labore
                            autem laborum consectetur quasi aliquam magni vero fugiat, sed maxime voluptates cum, modi a
                            accusamus.
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Quod hic obcaecati illo quis eum
                            deleniti
                            atque
                            quam! Commodi officia sapiente delectus, eveniet, debitis voluptatem labore ut ipsam in
                            reiciendis
                            aspernatur.
                        </p>
                    </div>
                </div>
            </div>
            <i class="fa-solid fa-angle-right arrow arrow-right" onclick="moveRight()"></i>
            <i class="fa-solid fa-angle-left arrow arrow-left" onclick="moveLeft()"></i>
        </div>
    </div>

    <script>
        const container = document.querySelector('.container_carrousel_equipamiento');
        const slides = document.querySelectorAll('.container_equipamiento');
        let index = 0;

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
            container.style.transform = `translateX(${newPosition}px)`;
        }
    </script>
</body>

</html>