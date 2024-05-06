<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
        }

        .cuadrado_morado {
            width: 50%;
            height: 100%;
            clip-path: polygon(60% 0, 100% 50%, 60% 100%, 0 100%, 0 0);
            background: radial-gradient(185.32% 99.8% at 11.32% 52.18%, #003 0%, #5F1495 100%);
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
    </style>
</head>
<body>
<?php
include "../database/connect.php";

// Obtener la conexión a la base de datos
$conexion = getConexion();

// Consulta para obtener los datos de los fantasmas y sus pruebas asociadas
$sql = "SELECT f.nombre AS nombre_fantasma, f.descripcion AS descripcion_fantasma, 
GROUP_CONCAT(p.nombre) AS pruebas
FROM fantasmas f 
INNER JOIN pruebas_fantasmas pf ON f.id = pf.fantasma_id
INNER JOIN pruebas p ON pf.prueba_id = p.id
GROUP BY f.id";
$result = mysqli_query($conexion, $sql);

echo '<div class="granTarjeta">';
if (mysqli_num_rows($result) > 0) {
// Generar las tarjetas HTML para cada fantasma
while($row = mysqli_fetch_assoc($result)) {
echo '<div class="tarjeta_fantasma_general">';
echo '<div class="cuadrado_morado"><img src="../img/Fotos fantasmas/'.strtolower($row["nombre_fantasma"]).'.svg"></img></div>';
echo '<div class="info_fantasma">';
echo '<span class="nombre_fantasma">' . $row["nombre_fantasma"] . '</span>';
echo '<div class="desc_fantasma">' . nl2br($row["descripcion_fantasma"]) . '</div>';
echo '<div class="pruebas_fantasmas">';

// Obtener y mostrar las pruebas asociadas al fantasma
$pruebas = explode(",", $row["pruebas"]);
foreach ($pruebas as $key => $prueba) {
echo '<div class="pruebas prueba' . ($key + 1) . '"><img src="../img/Fotos pruebas/'.$prueba.'.svg" alt="">' . $prueba . '</div>';
}

echo '</div></div></div>';
}
} else {
echo "0 resultados";
}
echo '</div>';
// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>
</body>
</html>