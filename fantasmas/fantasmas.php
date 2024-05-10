<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Index/style.css">
    <link rel="shortcut icon" href="../img/Logo fondo blanco.svg" type="image/x-icon">
    <title>Topanga Gaming</title>
    <style>
        @font-face {
            font-family: OctoberCrow;
            src: url(../fonts/October\ Crow.ttf);
        }

        .granTarjeta {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .tarjeta_fantasma_general {
            width: 90%;
            height: 500px;
            background: #000;
            border-radius: 30px;
            display: flex;
            flex-direction: row;
            margin: 2%;
            overflow: hidden;
        }

        .cuadrado_morado {
            width: 50%;
            height: 100%;
            clip-path: polygon(60% 0, 100% 50%, 60% 100%, 0 100%, 0 0);
            background: radial-gradient(185.32% 99.8% at 11.32% 52.18%, #003 0%, #5F1495 100%);
            border-top-left-radius: 30px;
            border-bottom-left-radius: 30px;
        }

        .cuadrado_morado img {
            height: 100%;
        }

        .info_fantasma {
            height: 100%;
            width: 40%;
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            padding: 0 20px 0 10px;
            color: white;
        }

        .info_fantasma .nombre_fantasma {
            font-family: OctoberCrow;
            font-size: 56px;
            position: relative;
            left: -70px;
        }

        .info_fantasma .desc_fantasma {
            font-size: 18px;
        }

        .pruebas_fantasmas {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }

        .pruebas {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            gap: 5px;
            /* width: 100%; */
            /* border: solid 1px; */
        }

        .pruebas img {
            height: 40%;
            /* width: 100%; */
        }

        #filtroForm {
            margin: 50px;
            background-color: black;
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            border-radius: 10px;
        }

        #filtroForm h1 {
            font-family: OctoberCrow;
            margin-top: 30px;
        }

        .divPruebasFiltro {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            /* Centrar horizontalmente */
            font-size: 20px;
            padding: 0;
            /* Eliminar el padding para evitar espacios innecesarios */
        }

        .divPruebasFiltro label {
            margin: 30px;
            /* Reducir el margen */
            display: flex;
            text-align: center;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }
    </style>
</head>

<body>
    <div class="overlay"></div>
    <?php
    include "../database/connect.php";
    include "../header y footer/header.html";
    include "../header y footer/VentanaModal.html";

    // Obtener la conexión a la base de datos
    $conexion = getConexion();

    // Consulta para obtener todas las pruebas disponibles
    $sql_pruebas = "SELECT id, nombre FROM pruebas";
    $result_pruebas = mysqli_query($conexion, $sql_pruebas);

    // Convertir las pruebas a un array PHP para usarlo en JavaScript
    $pruebas_array = [];
    while ($row_prueba = mysqli_fetch_assoc($result_pruebas)) {
        $pruebas_array[] = $row_prueba;
    }
    ?>

    <form id="filtroForm">
        <h1>Busca por las pruebas encontradas</h1>
        <div class="divPruebasFiltro">
            <?php
            // Mostrar las opciones en el formulario de búsqueda
            foreach ($pruebas_array as $prueba) {
                echo '<label><input type="checkbox" name="pruebas[]" value="' . $prueba["id"] . '"> ' . $prueba["nombre"] . '</label><br>';
            }
            ?>
        </div>
    </form>

    <div class="granTarjeta" id="resultadoFantasmas">
        <!-- Aquí se mostrarán los resultados de la búsqueda -->
    </div>

    <script>
        // Obtener referencia al formulario
        const form = document.getElementById('filtroForm');

        // Función para enviar la solicitud AJAX y obtener los resultados
        function obtenerResultados() {
            // Obtener las pruebas seleccionadas del formulario
            const formData = new FormData(form);
            const pruebasSeleccionadas = [];
            for (const entry of formData.entries()) {
                pruebasSeleccionadas.push(entry[1]);
            }

            // Convertir las pruebas seleccionadas a JSON
            const data = {
                pruebas: pruebasSeleccionadas
            };

            // Enviar la solicitud AJAX
            fetch('obtener_resultados.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.text())
                .then(result => {
                    // Mostrar los resultados en el contenedor correspondiente
                    document.getElementById('resultadoFantasmas').innerHTML = result;
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        // Escuchar cambios en el formulario y obtener los resultados automáticamente
        form.addEventListener('change', obtenerResultados);

        // Obtener resultados inicialmente al cargar la página
        obtenerResultados();
    </script>

    <?php
    mysqli_close($conexion);
    ?>

    <script src="../Index/script.js"></script>

</body>

</html>