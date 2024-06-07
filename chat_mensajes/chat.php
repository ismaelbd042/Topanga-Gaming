<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../Index/style.css">
    <link rel="shortcut icon" href="../img/Logo fondo blanco.svg" type="image/x-icon">
    <title>Chat</title>
    <style>
        .body {
            height: 100%;
        }

        .container {
            display: flex;
            width: 100%;
            height: 100%;
            margin-bottom: 150px;
        }

        .sidebar {
            width: 30%;
            background-color: #555555;
            display: flex;
            flex-direction: column;
            padding: 10px;
            gap: 10px;
        }

        .divBusqueda {
            height: auto;
        }

        .divAmigos {
            height: auto;
        }

        .divSolicitudes {
            height: auto;
        }

        #amigos {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        #amigos div {
            background-color: grey;
            color: white;
            height: 30px;
            display: flex;
            align-items: center;
            padding-left: 10px;
            border-radius: 10px;
            border: solid 1px;
        }

        .divBuscarUsuario {
            width: 100%;
            /* border: solid 1px; */
            display: flex;
            flex-wrap: nowrap;
            align-items: center;
            gap: 3px;
        }

        #buscarUsuario {
            width: 70%;
            padding: 10px;
            margin: 10px 0;
            height: 25px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        #buscarUsuario:focus {
            border-color: #66afe9;
            outline: none;
            box-shadow: 0 0 8px rgba(102, 175, 233, 0.6);
        }

        #buscarUsuario::placeholder {
            color: #aaa;
            font-style: italic;
        }

        #botonBuscar {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 5px 10px;
            font-size: 16px;
            height: 25px;
            font-weight: bold;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        #botonBuscar i {
            margin-right: 8px;
            /* Espacio entre el icono y el texto */
        }

        #botonBuscar:hover {
            background-color: darkgrey;
        }


        .chatMensajes {
            width: 70%;
            height: 100%;
        }

        #chat {
            width: 100%;
            height: 400px;
            border: 1px solid #ccc;
            overflow-y: scroll;
            background-image: url("../img/Chat/imagenFondoChat.avif");
            background-position: center;
            background-repeat: no-repeat;
            background-size: 100% 100%;
        }

        .enviarMensaje {
            width: 100%;
            display: flex;
            gap: 0;
        }

        #message {
            width: 85%;
            height: 40px;
        }

        .enviarMensaje button {
            width: 15%;
            height: 40px;
            background: var(--Gradiente-Marca,
                    radial-gradient(80.89% 43.8% at 50% 50%, #003 0%, #5f1495 100%));
            color: white;
        }

        #nombreAmigo {
            font-size: 30px;
            background-color: black;
            color: white;
            border: solid 3px purple;
            text-align: center;
        }

        .texto-con-ellipsis {
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }



        /* Estilo para contenedor de mensajes del amigo */
        .friend-message-container {
            width: auto;
            min-width: auto;
            max-width: 80%;
            /* Máximo 80% del ancho disponible */
            float: left;
            /* Alinea a la izquierda */
            clear: both;
            margin-left: 5px;
        }

        /* Estilo para contenedor de mensajes de otros usuarios */
        .other-message-container {
            width: auto;
            min-width: auto;
            max-width: 80%;
            /* Máximo 80% del ancho disponible */
            float: right;
            /* Alinea a la izquierda */
            clear: both;
        }

        /* Estilo para mensajes del amigo */
        .friend-message {
            background-color: #003;
            /* Morado oscuro */
            color: #FFFFFF;
            /* Texto blanco */
            padding: 10px;
            border-radius: 10px;
            margin: 5px 0;
            word-wrap: break-word;
            /* Agregada para evitar que el mensaje se salga de la pantalla */
        }

        /* Estilo para mensajes de otros usuarios */
        .other-message {
            background-color: #5f1495;
            color: white;
            padding: 10px;
            border-radius: 10px;
            margin: 5px 0;
            word-wrap: break-word;
        }

        /* Estilo para la fecha del mensaje */
        .message-date {
            font-size: 10px;
            color: #888888;
            bottom: 0;
            right: 0;
            text-align: right;
        }

        #mensajeAgregado {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid transparent;
            border-radius: 4px;
        }

        #mensajeAgregado.exito {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        #mensajeAgregado.error {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }

        #nombreAmigo {
            display: flex;
            align-items: center;
            /* Alinea verticalmente los elementos */
        }

        #volverAtrasBtn {
            margin-right: 10px;
            /* Margen a la derecha para separar el botón del texto */
            background-color: white;
            /* Fondo transparente */
            border: none;
            /* Sin borde */
            cursor: pointer;
            /* Cambia el cursor al pasar sobre el botón */
        }

        #volverAtrasBtn {
            background: black;
        }

        #flecha_atras {
            margin-top: 5px;
            width: 30px;
            /* background: black; */
        }

        @media (max-width: 940px) {

            .container {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                height: 100vh;
            }

            .chatMensajes {
                width: 100%;
                display: none;
                height: 100vh;
            }

        }
    </style>
</head>

<body>
    <div class="overlay"></div>
    <?php
    include "../header y footer/header.html";
    include "../header y footer/VentanaModal.html";
    ?>

    <div class="container">
        <div class="sidebar">

            <div class="divBusqueda">

                <!-- Sección para buscar usuarios -->
                <h2>Busca un amigo para agregar</h2>
                <div id="mensajeAgregado" style="display:none;"></div>
                <div class="divBuscarUsuario">
                    <input type="text" id="buscarUsuario" name="busqueda" placeholder="Buscar usuario">
                    <button id="botonBuscar">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                </div>
                <!-- Sección para mostrar resultados -->
                <div id="resultadosBusqueda"></div>

            </div>
            <div class="divAmigos">
                <!-- Div para mostrar amigos -->
                <h2>Amigos</h2>
                <div id="amigos">
                    <!-- Aquí se mostrarán los amigos -->
                </div>
            </div>

            <div class="divSolicitudes">
                <!-- Div para mostrar solicitudes -->
                <h2>Solicitudes de Amistad</h2>
                <div id="solicitudes">
                    <!-- Aquí se mostrarán las solicitudss -->
                </div>
            </div>
        </div>

        <div class="chatMensajes">
            <div id="nombreAmigo">
                Mi propio chat
            </div>
            <div id="chat"></div>
            <div class="enviarMensaje">
                <input type="text" id="message" placeholder="Escribe un mensaje...">
                <button onclick="sendMessage()">Enviar</button>
            </div>
        </div>
    </div>


    <script>
        document.getElementById('botonBuscar').addEventListener('click', function() {
            var busqueda = document.getElementById('buscarUsuario').value;
            if (busqueda) {
                fetch('buscar_usuario.php?busqueda=' + encodeURIComponent(busqueda))
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        var resultadosDiv = document.getElementById('resultadosBusqueda');
                        resultadosDiv.innerHTML = '';
                        if (data.length > 0) {
                            data.forEach(usuario => {
                                var div = document.createElement('div');
                                div.id = 'usuario-' + usuario.id;
                                div.textContent = usuario.nombre_usuario + ' (' + usuario.correo + ')';
                                var idAmigo = usuario.id;

                                var botonAmigo = document.createElement('button');

                                // Crea un elemento de imagen
                                var imagen = document.createElement('img');
                                imagen.src = '../img/Icons/añadirAmigo.png'; // Ruta a la imagen
                                imagen.alt = 'Añadir amigo'; // Texto alternativo para la imagen
                                imagen.style.width = '24px'; // Ajusta el tamaño de la imagen según sea necesario
                                imagen.style.height = '24px';
                                imagen.style.cursor = 'pointer';

                                // Estilo para el contenedor principal
                                div.style.display = 'flex';
                                div.style.alignItems = 'center';
                                div.style.width = '100%';
                                div.style.boxSizing = 'border-box';

                                // Añade la imagen al botón
                                botonAmigo.appendChild(imagen);
                                botonAmigo.onclick = function() {
                                    agregarAmigo(idAmigo);
                                };

                                // Estilo para el botón
                                botonAmigo.style.border = 'none';
                                botonAmigo.style.background = 'transparent';
                                botonAmigo.style.padding = '0';

                                div.appendChild(botonAmigo);
                                resultadosDiv.appendChild(div);
                                resultadosDiv.style.color = "white"
                            });
                        } else {
                            resultadosDiv.textContent = 'No se encontraron usuarios.';
                            resultadosDiv.style.color = "#ff3f3f";
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Hubo un error en la búsqueda. Intenta de nuevo más tarde.');
                    });
            }
        });

        function agregarAmigo(idAmigo) {
            fetch('agregar_amigo.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        idAmigo: idAmigo
                    })
                })
                .then(response => {
                    console.log('Response:', response); // Registro de la respuesta
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Data:', data); // Registro de los datos
                    if (data.exito) {
                        document.getElementById('usuario-' + idAmigo).remove();
                        mostrarMensaje('Solicitud de amistad enviada', 'exito');
                    } else {
                        console.log('Error:', data.error.replace(/localhost/g, ''));
                        mostrarMensaje('Hubo un error al añadir al amigo: ' + data.error.replace(/localhost/g, ''), 'error');
                    }

                    // Función para mostrar mensajes en la página
                    function mostrarMensaje(mensaje, tipo) {
                        const mensajeElemento = document.getElementById('mensajeAgregado');
                        mensajeElemento.innerText = mensaje;
                        mensajeElemento.className = tipo; // puedes usar clases CSS para estilo
                        mensajeElemento.style.display = 'block';
                    }
                })
        }

        function cargarAmigos() {
            fetch('cargar_amigos.php')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    var amigosDiv = document.getElementById('amigos');
                    var nameAmigo = document.getElementById('nombreAmigo');
                    amigosDiv.innerHTML = '';

                    if (data.length > 0) {
                        data.forEach(datos_usuario => {
                            // Crear el contenedor principal
                            var div = document.createElement('div');

                            // Crear el elemento de texto
                            var texto = document.createElement('span');
                            texto.textContent = datos_usuario.nombre_usuario + ' (' + datos_usuario.correo + ')';
                            texto.classList.add('texto-con-ellipsis');

                            // Agregar el texto al contenedor principal
                            div.appendChild(texto);

                            // Crear el botón de chatear
                            var chatearBtn = document.createElement('button');

                            // Crear el elemento de imagen
                            var img = document.createElement('img');
                            img.src = '../img/Chat/abrirChat.png'; // Reemplaza 'URL_DE_LA_IMAGEN' con la URL de tu imagen
                            img.alt = 'Icono de chatear';
                            img.style.width = '35px'; // Ajusta el tamaño de la imagen según sea necesario
                            img.style.height = '35px';
                            img.style.marginTop = '3px';

                            // Estilo para el contenedor principal
                            div.style.display = 'flex';
                            div.style.justifyContent = 'space-between';
                            div.style.alignItems = 'center';
                            div.style.width = '100%';
                            div.style.padding = '10px';
                            div.style.boxSizing = 'border-box';
                            div.style.cursor = 'pointer';
                            div.style.backgroundColor = '#555555';
                            div.addEventListener('mouseenter', () => {
                                div.style.backgroundColor = 'rgba(255, 248, 239, 0.568)';
                            });

                            div.addEventListener('mouseleave', () => {
                                div.style.backgroundColor = '#555555'; // O el color original que prefieras
                            });

                            // Estilo para el botón
                            chatearBtn.style.border = 'none';
                            chatearBtn.style.background = 'transparent';
                            chatearBtn.style.cursor = 'pointer';
                            chatearBtn.style.padding = '0';

                            // Añadir la imagen al botón
                            chatearBtn.appendChild(img);

                            // Añadir el botón al contenedor principal
                            div.appendChild(chatearBtn);

                            function ocultarSidebar() {
                                const sidebar = document.querySelector('.sidebar');
                                const volverAtrasBtn = document.getElementById('volverAtrasBtn');
                                sidebar.style.display = 'none';
                                volverAtrasBtn.style.display = 'block';
                            }

                            function handleVolverAtrasClick() {
                                const sidebar = document.querySelector('.sidebar');
                                const chatMensajes = document.querySelector('.chatMensajes');
                                const volverAtrasBtn = document.getElementById('volverAtrasBtn');
                                sidebar.style.display = 'block';
                                chatMensajes.style.display = 'none';
                            }

                            // Agregar evento click para chatear y ocultar el sidebar en modo responsive
                            div.addEventListener('click', () => {
                                abrirChat(datos_usuario.id);
                                nameAmigo.innerHTML = '';


                                // Ocultar el sidebar si la pantalla está en modo responsive
                                if (window.innerWidth <= 940) {
                                    nameAmigo.innerHTML = '<button id="volverAtrasBtn"><img src="../img/Icons/flecha_atras.png" alt="Flecha atrás" id="flecha_atras"></button> Chat con ' + datos_usuario.nombre_usuario;
                                    ocultarSidebar();
                                } else {
                                    nameAmigo.innerHTML = '<button id="volverAtrasBtn" style="display: none;"><img src="../img/Icons/flecha_atras.png" alt="Flecha atrás" id="flecha_atras"></button> Chat con ' + datos_usuario.nombre_usuario;
                                }
                                document.getElementById("volverAtrasBtn").addEventListener("click", handleVolverAtrasClick);
                                mostrarChat();
                            });

                            div.appendChild(chatearBtn);
                            amigosDiv.appendChild(div);
                        });
                    } else {
                        amigosDiv.textContent = 'No tienes amigos aún.';
                    }

                })
                .catch(error => {
                    console.error('Error fetching amigos:', error);
                    document.getElementById('amigos').textContent = 'No tienes amigos aún.';
                });
        }

        const chatDiv = document.getElementById('chat');
        let friend_id; // Variable para almacenar el friend_id

        function fetchMessages() {
            if (!friend_id) return; // Evitar la llamada si friend_id no está definido
            fetch(`fetch_messages.php?friend_id=${friend_id}`)
                .then(response => response.json())
                .then(data => {
                    chatDiv.innerHTML = '';
                    data.forEach(message => {
                        const messageContainer = document.createElement('div');
                        const messageElement = document.createElement('div');
                        const dateElement = document.createElement('div');

                        messageElement.textContent = message.mensaje;
                        // Agregar clases CSS según el remitente del mensaje
                        if (message.emisor_id === friend_id) {
                            messageContainer.classList.add('friend-message-container');
                            messageElement.classList.add('friend-message');
                        } else {
                            messageContainer.classList.add('other-message-container');
                            messageElement.classList.add('other-message');
                        }

                        dateElement.textContent = message.fecha;
                        dateElement.classList.add('message-date');

                        messageElement.appendChild(dateElement); // Añadir la fecha al mensaje

                        messageContainer.appendChild(messageElement);

                        chatDiv.appendChild(messageContainer);
                    });
                    chatDiv.scrollTop = chatDiv.scrollHeight;
                })
                .catch(error => {
                    console.error('Error fetching messages:', error);
                });
        }


        function sendMessage() {
            const messageInput = document.getElementById('message');
            const message = messageInput.value;

            if (message.trim() !== '' && friend_id) { // Asegurarse de que friend_id esté definido
                fetch('send_message.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        friend_id: friend_id,
                        message: message,
                    }),
                }).then(() => {
                    messageInput.value = '';
                    fetchMessages();
                });
            }
        }

        function abrirChat(idAmigo) {
            const chatDiv = document.getElementById('chat');
            friend_id = idAmigo; // Asignar el id del amigo

            // Llamar a fetchMessages() para cargar los mensajes del amigo seleccionado
            fetchMessages();
        }

        window.sendMessage = sendMessage;
        // Función para abrir el chat con el amigo seleccionado

        function cargarSolicitudes() {
            fetch('cargar_solicitudes.php')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    var solicitudesDiv = document.getElementById('solicitudes');
                    solicitudesDiv.innerHTML = '';
                    if (data.length > 0) {
                        data.forEach(datos_usuario => {
                            // Crear un contenedor para la solicitud
                            var div = document.createElement('div');
                            div.id = `solicitud-${datos_usuario.id}`;

                            // Crear el elemento de texto
                            var texto = document.createElement('span');
                            texto.textContent = datos_usuario.nombre_usuario + ' (' + datos_usuario.correo + ')';
                            texto.classList.add('texto-con-ellipsis');

                            // Agregar el texto al contenedor principal
                            div.appendChild(texto);

                            div.style.display = 'flex';
                            div.style.alignItems = 'center';
                            div.style.gap = '5px';
                            div.style.border = 'solid 1px rgb(116, 116, 116)';
                            div.style.marginLeft = '-10px';
                            div.style.marginRight = '-10px';
                            div.style.height = '40px';
                            div.style.padding = '3px';
                            div.style.backgroundColor = 'rgb(95, 95, 95)';
                            div.style.display = 'flex';
                            div.style.justifyContent = 'space-between';

                            // Crear el botón de aceptar
                            var aceptarBtn = document.createElement('button');
                            var img = document.createElement('img');
                            img.src = '../img/Icons/iconoOk.png'; // Reemplaza 'URL_DE_LA_IMAGEN' con la URL de tu imagen
                            img.alt = 'Icono de Ok';
                            img.style.width = '25px'; // Ajusta el tamaño de la imagen según sea necesario
                            img.style.height = '25px';
                            img.style.marginTop = '3px';

                            aceptarBtn.style.border = 'none';
                            aceptarBtn.style.background = 'transparent';
                            aceptarBtn.style.cursor = 'pointer';
                            aceptarBtn.style.padding = '0';

                            // Añadir la imagen al botón
                            aceptarBtn.appendChild(img);
                            aceptarBtn.addEventListener('click', () => {
                                // Lógica para aceptar la solicitud
                                aceptarSolicitud(datos_usuario.id);
                            });

                            // Crear el botón de cancelar
                            var cancelarBtn = document.createElement('button');
                            var img2 = document.createElement('img');
                            img2.src = '../img/Icons/iconoMal.png'; // Reemplaza 'URL_DE_LA_IMAGEN' con la URL de tu imagen
                            img2.alt = 'Icono de Ok';
                            img2.style.width = '25px'; // Ajusta el tamaño de la imagen según sea necesario
                            img2.style.height = '25px';
                            img2.style.marginTop = '3px';

                            cancelarBtn.style.border = 'none';
                            cancelarBtn.style.background = 'transparent';
                            cancelarBtn.style.cursor = 'pointer';
                            cancelarBtn.style.padding = '0';

                            // Añadir la imagen al botón
                            cancelarBtn.appendChild(img2);
                            cancelarBtn.addEventListener('click', () => {
                                // Lógica para cancelar la solicitud
                                cancelarSolicitud(datos_usuario.id);
                            });

                            var divBotones = document.createElement('div');
                            divBotones.style.display = 'flex';
                            divBotones.style.wrap = 'no-wrap';
                            divBotones.style.marginRight = '1%';
                            divBotones.style.gap = '7px';


                            // Añadir los botones al div
                            divBotones.appendChild(aceptarBtn);
                            divBotones.appendChild(cancelarBtn);
                            div.appendChild(divBotones);

                            // Añadir el div al contenedor principal de solicitudes
                            solicitudesDiv.appendChild(div);
                        });

                        // Función para manejar la aceptación de la solicitud
                        function aceptarSolicitud(id) {
                            // Aquí puedes hacer una solicitud AJAX para aceptar la solicitud
                            fetch('aceptar_solicitud.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        id: id
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        // alert('Solicitud aceptada');
                                        // Aquí puedes actualizar la interfaz de usuario según sea necesario
                                        // Por ejemplo, remover el elemento del DOM
                                        var solicitudElement = document.querySelector(`#solicitud-${id}`);
                                        if (solicitudElement) {
                                            solicitudElement.remove();
                                        }

                                        location.reload();
                                    } else {
                                        alert('Error al aceptar la solicitud');
                                    }
                                })
                                .catch(error => console.error('Error:', error));
                        }

                        // Función para manejar la cancelación de la solicitud
                        function cancelarSolicitud(id) {
                            // Hacer una solicitud AJAX para cancelar la solicitud
                            fetch('rechazar_solicitud.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        id: id
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        // Aquí puedes actualizar la interfaz de usuario según sea necesario
                                        // Por ejemplo, remover el elemento del DOM
                                        var solicitudElement = document.querySelector(`#solicitud-${id}`);
                                        if (solicitudElement) {
                                            solicitudElement.remove();
                                        }

                                        location.reload();
                                    } else {
                                        alert('Error al cancelar la solicitud');
                                    }
                                })
                                .catch(error => console.error('Error:', error));
                        }

                    } else {
                        solicitudesDiv.textContent = 'No tienes solicitudes de amistad pendientes.';
                    }
                })
        }

        window.onload = function() {
            // Hacer una solicitud AJAX para obtener el usuario_id
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'get_session_id.php', true);
            xhr.onload = function() {
                if (xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText);
                    var usuario_id = response.usuario_id;

                    // Llamar a las funciones con el usuario_id
                    cargarAmigos();
                    cargarSolicitudes();
                    abrirChat(usuario_id);
                }
            };
            xhr.send();
        };

        function mostrarChat() {
            const chatMensajes = document.querySelector('.chatMensajes');
            chatMensajes.style.display = 'block';
        }


        window.addEventListener('resize', () => {
            const chatMensajes = document.querySelector('.chatMensajes');
            const sidebar = document.querySelector('.sidebar');
            const volverAtrasBtn = document.getElementById('volverAtrasBtn');

            // Verificar si el chat está abierto y el tamaño de la pantalla está en modo responsive
            if (chatMensajes.style.display === 'block' && window.innerWidth <= 940) {
                sidebar.style.display = 'none';
                volverAtrasBtn.style.display = 'block';
            }

            // Verificar si el tamaño de la pantalla supera el límite del modo responsive y el chat está abierto
            if (window.innerWidth > 940 && chatMensajes.style.display === 'block') {
                sidebar.style.display = 'block';
                volverAtrasBtn.style.display = 'none';
            }

            if (sidebar.style.display === 'block' && window.innerWidth <= 940) {
                chatMensajes.style.display = 'none';
                volverAtrasBtn.style.display = 'none';
            }


            if (window.innerWidth > 940 && sidebar.style.display === 'block') {
                chatMensajes.style.display = 'block';
                volverAtrasBtn.style.display = 'none';
            }
        });
    </script>


    <script src="../Index/script.js"></script>
    <?php include "../header y footer/footer.html"; ?>
</body>

</html>