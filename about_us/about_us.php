<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Index/style.css">
    <link rel="shortcut icon" href="../img/Logo fondo blanco.svg" type="image/x-icon">
    <title>Topanga Gaming</title>
</head>
<style>
    .container_about_us {
        display: flex;
        flex-direction: column;
        width: 100%;
        height: calc(100vh - 70px);
        justify-content: center;
        align-items: center;
    }

    .container_about_us * {
        color: white;
        border: solid 1px white;
    }

    .container_sobre_nosotros {
        width: 90%;
        display: flex;
        flex-direction: row;
        height: 30vh;
        align-content: center;
        justify-content: center;
        gap: 10px;
    }

    .texto_sobre_nosotros {
        width: 50%;
    }

    .fotos_sobre_nosotros {
        width: 50%;
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        grid-template-rows: repeat(2, 1fr);
        gap: 10px;
    }

    .titulo_sobre_nosotros {
        font-size: 40px;
    }

    .desc_sobre_nosotros {
        font-size: 20px;
    }

    .info_sobre_nosotros {
        display: flex;
        flex-direction: column;
        align-content: center;
        align-items: center;
        justify-content: center;
    }

    .img_nosotros {
        display: flex;
        width: 100px;
        height: 100px;
        border-radius: 50px;
        justify-content: center;
        align-items: center;
        overflow: hidden;
    }

    .img_nosotros img {
        height: 100px;
    }
</style>

<body>
    <div class="overlay"></div>
    <?php
    include "../header y footer/header.html";
    include "../header y footer/VentanaModal.html";
    include "../database/connect.php";
    ?>

    <div class="container_about_us">
        <div class="container_sobre_nosotros">
            <div class="texto_sobre_nosotros">
                <div class="titulo_sobre_nosotros">ABOUT US</div>
                <div class="desc_sobre_nosotros">Lorem ipsum dolor sit amet consectetur adipisicing elit. Iure inventore molestiae enim incidunt accusamus pariatur quis doloremque placeat dolores mollitia illum voluptatem harum quia, vitae ipsum sequi expedita cum sapiente.</div>
            </div>
            <div class="fotos_sobre_nosotros">
                <div class="info_sobre_nosotros">
                    <div class="img_nosotros"><img src="../img/Fondo Index.png" alt=""></div>
                    <span>Lucca</span>
                    <span>CEO</span>
                </div>
                <div class="info_sobre_nosotros">
                    <div class="img_nosotros"><img src="../img/Fondo Index.png" alt=""></div>
                    <span></span>
                    <span></span>
                </div>
                <div class="info_sobre_nosotros">
                    <div class="img_nosotros"><img src="../img/Fondo Index.png" alt=""></div>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
        <div class="container_contacto"></div>
    </div>

    <script src="../Index/script.js"></script>

</body>

</html>