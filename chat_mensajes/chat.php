<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <style>
        .body {
            height: 100%;
        }

        .container {
            /* color: white; */
            display: flex;
            width: 100%;
            height: 100%;
            /* border: solid 1px; */
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
            max-height: 33%;
        }

        .divAmigos {
            max-height: 33%;
        }

        .divSolicitudes {
            max-height: 33%;
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

        #buscarUsuario {
            width: 50%;
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
            /* Morado muy claro */
            color: white;
            /* Texto negro */
            padding: 10px;
            border-radius: 10px;
            margin: 5px 0;
            word-wrap: break-word;
            /* Agregada para evitar que el mensaje se salga de la pantalla */
        }

        /* Estilo para la fecha del mensaje */
        .message-date {
            font-size: 10px;
            /* Tamaño de fuente pequeño */
            color: #888888;
            /* Color de texto gris */
            /* position: absolute; */
            /* Posicionamiento absoluto */
            bottom: 0;
            /* Colocar en la parte inferior */
            right: 0;
            /* Colocar a la derecha */
            text-align: right;
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
                <input type="text" id="buscarUsuario" name="busqueda" placeholder="Buscar usuario">
                <button id="botonBuscar">Buscar</button>

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
            <div id="nombreAmigo">Mi propio chat</div>
            <div id="chat"></div>
            <div class="enviarMensaje">
                <input type="text" id="message" placeholder="Escribe un mensaje...">
                <button onclick="sendMessage()">Enviar</button>
            </div>
        </div>
    </div>


    <script>
        document.getElementById('botonBuscar').addEventListener('click', function () {
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
                                botonAmigo.textContent = 'Añadir amigo';
                                botonAmigo.onclick = function () {
                                    agregarAmigo(idAmigo);
                                };

                                div.appendChild(botonAmigo);
                                resultadosDiv.appendChild(div);
                            });
                        } else {
                            resultadosDiv.textContent = 'No se encontraron usuarios.';
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
                body: JSON.stringify({ idAmigo: idAmigo })
            })
                .then(response => {
                    console.log('Response:', response);  // Registro de la respuesta
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Data:', data);  // Registro de los datos
                    if (data.exito) {
                        document.getElementById('usuario-' + idAmigo).remove();
                        alert('Solicitud de amistad enviada');
                    } else {
                        console.error('Error:', data.error);
                        alert('Hubo un error al añadir al amigo: ' + data.error);
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
                            div.addEventListener('mouseenter', () => {
                                div.style.backgroundColor = 'rgba(255, 248, 239, 0.568)';
                            });

                            div.addEventListener('mouseleave', () => {
                                div.style.backgroundColor = 'grey'; // O el color original que prefieras
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

                            // Agregar evento click para chatear
                            div.addEventListener('click', () => {
                                abrirChat(datos_usuario.id);
                                nameAmigo.innerHTML = '';
                                nameAmigo.textContent = 'Chat con ' + datos_usuario.nombre_usuario;
                            });

                            div.appendChild(chatearBtn);
                            amigosDiv.appendChild(div);
                        });
                    } else {
                        amigosDiv.textContent = 'No tienes amigos aún.';
                    }

                })
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

            // Aquí podrías hacer cualquier otra acción necesaria antes de cargar los mensajes del amigo seleccionado

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
                                body: JSON.stringify({ id: id })
                            })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        alert('Solicitud aceptada');
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
                                body: JSON.stringify({ id: id })
                            })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        alert('Solicitud cancelada');
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

        window.onload = function () {
            // Hacer una solicitud AJAX para obtener el usuario_id
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'get_session_id.php', true);
            xhr.onload = function () {
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

    </script>


    <script src="../Index/script.js"></script>

</body>

</html>