<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
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
                            amigosDiv.appendChild(div);
                        });
                    } else {
                        amigosDiv.textContent = 'No tienes amigos aún.';
                    }
                })
        }

        // Llamar a la función para cargar amigos cuando la página se carga
        window.onload = function () {
            cargarAmigos();
        };

    </script>



    <script src="../Index/script.js"></script>

</body>

</html>