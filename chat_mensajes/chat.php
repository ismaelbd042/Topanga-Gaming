<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <style>
        .container {
            color: white;
        }

        #chat {
            width: 300px;
            height: 400px;
            border: 1px solid #ccc;
            overflow-y: scroll;
        }

        #message {
            width: 80%;
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
            <!-- Sección para buscar usuarios -->
            <h2>Busca un usuario para agregar como amigo</h2>
            <input type="text" id="buscarUsuario" name="busqueda" placeholder="Buscar usuario">
            <button id="botonBuscar">Buscar</button>

            <!-- Sección para mostrar resultados -->
            <div id="resultadosBusqueda"></div>

            <!-- Div para mostrar amigos -->
            <h2>Amigos</h2>
            <div id="amigos">
                <!-- Aquí se mostrarán los amigos -->
            </div>

            <!-- Div para mostrar solicitudes -->
            <h2>Solicitudes de Amistad</h2>
            <div id="solicitudes">
                <!-- Aquí se mostrarán las solicitudss -->
            </div>

            <div id="chat"></div>
            <input type="text" id="message" placeholder="Escribe un mensaje...">
            <button onclick="sendMessage()">Enviar</button>
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
                    amigosDiv.innerHTML = '';

                    if (data.length > 0) {
                        data.forEach(datos_usuario => {
                            var div = document.createElement('div');
                            div.textContent = datos_usuario.nombre_usuario + ' (' + datos_usuario.correo + ')';

                            // Crear el botón de chatear
                            var chatearBtn = document.createElement('button');
                            chatearBtn.textContent = 'Chatear';

                            // Agregar evento click para chatear
                            chatearBtn.addEventListener('click', () => {
                                abrirChat(datos_usuario.id);
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
                        const messageElement = document.createElement('div');
                        messageElement.textContent = message.mensaje;
                        chatDiv.appendChild(messageElement);
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
                            div.textContent = datos_usuario.nombre_usuario + ' (' + datos_usuario.correo + ')';

                            // Crear el botón de aceptar
                            var aceptarBtn = document.createElement('button');
                            aceptarBtn.textContent = 'Aceptar';
                            aceptarBtn.addEventListener('click', () => {
                                // Lógica para aceptar la solicitud
                                aceptarSolicitud(datos_usuario.id);
                            });

                            // Crear el botón de cancelar
                            var cancelarBtn = document.createElement('button');
                            cancelarBtn.textContent = 'Rechazar';
                            cancelarBtn.addEventListener('click', () => {
                                // Lógica para cancelar la solicitud
                                cancelarSolicitud(datos_usuario.id);
                            });

                            // Añadir los botones al div
                            div.appendChild(aceptarBtn);
                            div.appendChild(cancelarBtn);

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

        // Llamar a la función para cargar amigos cuando la página se carga
        window.onload = function () {
            cargarAmigos();
            cargarSolicitudes();
        };

    </script>


    <script src="../Index/script.js"></script>

</body>

</html>