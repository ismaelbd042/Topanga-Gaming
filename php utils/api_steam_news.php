<?php
// Preferiblemente llamado desde fetch
function newsSteamApi()
// esta aqui porque no consigo darle formato al contenido para que salga bien, se podria hacer cutre como un texto plano pero queria hacerlo con ul y li
{
    // URL de la API de Steam
    $url = 'https://api.steampowered.com/ISteamNews/GetNewsForApp/v1?appid=739630&count=3'; // count es el numero de "noticias" y format el formato: json (default), xml or vdf.

    // Realizar la solicitud GET y almacenar la respuesta en una variable
    $response = file_get_contents($url);

    // Decodificar la respuesta JSON
    $data = json_decode($response);

    // Verificar si la decodificación fue exitosa y si hay noticias disponibles
    if ($data && isset($data->appnews) && isset($data->appnews->newsitems)) {
        $newsItems = $data->appnews->newsitems;

        // Ejemplo
        // {
        //   "gid": "5762993398269128987",  
        //   "title": "Ascension | v0.9.6.1",   titulo de la actualización
        //   "url": "https://steamstore-a.akamaihd.net/news/externalpost/steam_community_announcements/5762993398269128987",    url a la pagina de steam
        //   "is_external_url": true,
        //   "author": "KineticGames",      autor
        //   "contents": "[b]Changes[/b]\nRemoved Easter 2024 event\n",     contenido que tiene la actualización, aqui sale todo lo interesante
        //   "feedlabel": "Community Announcements",
        //   "date": 1712751433,
        //   "feedname": "steam_community_announcements",
        //   "feed_type": 1,
        //   "appid": 739630,       id del juego en steam
        //   "tags": {      etiquetas de la noticia
        //     "tag": [
        //       "patchnotes"       notas del parche
        //     ]
        //   }
        // }        
    } else {
        // Manejar el caso en que no haya noticias disponibles
        echo "No se encontraron noticias disponibles en este momento.";
    }
}
