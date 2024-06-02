<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Index/style.css">
    <link rel="shortcut icon" href="../img/Logo fondo blanco.svg" type="image/x-icon">
    <title>Topanga Gaming</title>
    <style>
        .container_about_us {
            display: flex;
            flex-direction: column;
            width: 100%;
            height: auto;
            justify-content: center;
            align-items: center;
            gap: 50px;
            padding-top: 2%;
        }

        /* .container_about_us * {
            color: white;
        } */

        .container_sobre_nosotros {
            width: 90%;
            display: flex;
            flex-direction: row;
            height: 42vh;
            align-content: center;
            justify-content: center;
            gap: 10px;
        }

        .container_contacto {
            width: 90%;
            display: flex;
            flex-direction: row;
            height: 40vh;
            align-content: center;
            justify-content: center;
            gap: 10px;
        }

        .texto_sobre_nosotros {
            width: 50%;
        }

        .texto_contacto {
            width: 50%;
        }

        .fotos_sobre_nosotros {
            width: 50%;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }

        .formulario_contacto {
            width: 50%;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .titulo_sobre_nosotros,
        .titulo_contacto {
            font-size: 33px;
        }

        .desc_sobre_nosotros {
            width: 85%;
            font-size: 16px;
            padding-top: 2%;
        }

        .desc_contacto {
            width: 85%;
            font-size: 16px;
            padding-top: 2%;
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

        .formilario_width {
            width: 49%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .formilario_width2 {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .boton_formulario {
            width: 100%;
            background: #a2a2ad;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            color: white;
        }

        .boton_formulario:hover {
            background: #8e8e9f;
        }

        .email_formulario {
            margin-left: 42%;
            font-size: 13px;
            color: white;
        }
        .tamano_letra_formulario {
            font-size: 13px;
            color: white;
        }

        hr {
            width: 90%;
            border: 1px solid white;
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

    <div class="container_about_us">
        <div class="container_sobre_nosotros">
            <div class="texto_sobre_nosotros">
                <div class="titulo_sobre_nosotros">ABOUT US</div>
                <div class="desc_sobre_nosotros">Topanga Gaming es una empresa dedicada a proporcionar una experiencia completa para los entusiastas de los videojuegos. Ofrecemos información detallada  sobre las tendencias en el mundo de los videojuegos. Además, contamos con una amplia variedad de videos que incluyen reseñas, tutoriales, gameplays y mucho más, para que siempre estés al tanto de lo mejor del gaming.
                <br><br>Nuestros canales de video te permiten disfrutar de contenido exclusivo. Además, hemos creado una plataforma de chat interactiva donde puedes conectarte y charlar con otros jugadores de todo el mundo, compartir tus experiencias, estrategias y consejos sobre tus juegos favoritos.</div>
            </div>
            <div class="fotos_sobre_nosotros">
                <div class="info_sobre_nosotros">
                    <div class="img_nosotros"><img src="../img/Fondo Index.png" alt=""></div>
                    <span>Lucca Manfredotti</span>
                    <span>CEO</span>
                </div>
                <div class="info_sobre_nosotros">
                    <div class="img_nosotros"><img src="../img/Fondo Index.png" alt=""></div>
                    <span>Ismael Bodas</span>
                    <span>CEO</span>
                </div>
                <div class="info_sobre_nosotros">
                    <div class="img_nosotros"><img src="../img/Fondo Index.png" alt=""></div>
                    <span>Álvaro Serrano</span>
                    <span>CEO</span>
                </div>
            </div>
        </div>
        <hr>
        <div class="container_contacto">
            <div class="texto_contacto">
                <div class="titulo_contacto">Contact US</div>
                <div class="desc_contacto">Tienes algunas preguntas/cuestiones o quieres trabajar con nosotros? Rellene el formulario que aparece a continuación y nos pondremos en contacto con usted lo antes posible.</div>
            </div>
            <div class="formulario_contacto">
                <form id="contactForm">
                    <div>
                        <label for="nombre" class="tamano_letra_formulario">Nombre:</label>
                        <label for="correo" class="email_formulario">Correo Electrónico:</label>
                    </div>
                    <div>
                        <input type="text" id="nombre" name="nombre" class="formilario_width" required>
                        <input type="email" id="correo" name="correo" class="formilario_width" required>
                    </div>
                    <div>
                        <label for="mensaje" class="tamano_letra_formulario">Mensaje:</label>
                    </div>
                    <div>
                        <textarea id="mensaje" name="mensaje" rows="5" class="formilario_width2" required></textarea>
                    </div>
                    <div>
                        <button type="submit" class="boton_formulario">Enviar</button>
                    </div>
                </form>
                <div id="responseMessage" style="color: white; margin-top: 10px;"></div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('contactForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Evita que el formulario se envíe de la manera tradicional

            const formData = new FormData(this);

            fetch('guardarContacto.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                document.getElementById('responseMessage').innerText = data;
                this.reset(); // Reinicia el formulario después del envío exitoso
            })
            .catch(error => {
                document.getElementById('responseMessage').innerText = 'Error al enviar el formulario.';
                console.error('Error:', error);
            });
        });
    </script>

    <script src="../Index/script.js"></script>
</body>

</html>
