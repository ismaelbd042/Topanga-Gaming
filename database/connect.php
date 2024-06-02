<?php
getConexion();
function getConexion()
{
    // Definir los valores de conexión
    $host = 'localhost';    // Dirección del servidor de la base de datos
    $usuario = 'root';      // Nombre de usuario de la base de datos
    $contrasena = '';       // Contraseña de la base de datos (en este caso, está vacía)

    // Intenta establecer una conexión a la base de datos MySQL
    $conexion = mysqli_connect($host, $usuario, $contrasena) or die("Error de conexión"); // Si no se puede conectar, muestra un mensaje de error y termina el script

    // Establece el conjunto de caracteres a utf8
    mysqli_set_charset($conexion, 'utf8');

    // Verificar si la base de datos Proyecto ya existe
    $result = mysqli_query($conexion, "SHOW DATABASES LIKE 'TopangaGaming'");

    if (mysqli_num_rows($result) > 0) {
        mysqli_select_db($conexion, "TopangaGaming");  // Seleccionar la base de datos existente si se encuentra.
    } else {
        // Crear la base de datos Proyecto si no existe
        mysqli_query($conexion, "CREATE DATABASE TopangaGaming");
        mysqli_select_db($conexion, "TopangaGaming");  // Seleccionar la base de datos recién creada.
        crearTablas($conexion);
        insertarDatos($conexion);
    }

    return $conexion;
}

function crearTablas($conexion)
{
    // Crear tabla de pruebas
    $sqlPruebas = "CREATE TABLE IF NOT EXISTS pruebas (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(50),
        extra TEXT
    )";
    mysqli_query($conexion, $sqlPruebas);

    // Crear tabla de fantasmas
    $sqlFantasmas = "CREATE TABLE IF NOT EXISTS fantasmas (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(15),
        cordura INT,
        velocidad VARCHAR(20),
        descripcion TEXT,
        extra TEXT
    )";
    mysqli_query($conexion, $sqlFantasmas);

    // Crear tabla intermedia pruebas_fantasmas
    $sqlPruebasFantasmas = "CREATE TABLE IF NOT EXISTS pruebas_fantasmas (
        id INT AUTO_INCREMENT PRIMARY KEY,
        prueba_id INT,
        fantasma_id INT,
        FOREIGN KEY (prueba_id) REFERENCES pruebas(id),
        FOREIGN KEY (fantasma_id) REFERENCES fantasmas(id)
    )";
    mysqli_query($conexion, $sqlPruebasFantasmas);

    // Crear tabla de objetos malditos
    $sqlObjetos = "CREATE TABLE IF NOT EXISTS objetos_malditos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(50),
        efecto TEXT,
        preguntas TEXT
    )";
    mysqli_query($conexion, $sqlObjetos);

    // Crear tabla de herramientas
    $sqlEquipamiento = "CREATE TABLE IF NOT EXISTS equipamiento (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(50),
        tier INT,
        descripcion TEXT,
        nivel_desbloqueo INT,
        precio_mejora INT,
        coste INT,
        limite_mision INT,
        opcional ENUM('S', 'N'),
        tipo ENUM('electrico', 'consumible', 'ninguno') DEFAULT 'ninguno'
    )";
    mysqli_query($conexion, $sqlEquipamiento);

    // Crear tabla de mapas
    $sqlMapas = "CREATE TABLE IF NOT EXISTS mapas (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(50),
        img BLOB,
        tamaño ENUM('pequeño', 'mediano', 'grande'),
        plantas INT,
        habitaciones VARCHAR(10),
        salidas INT,
        grifos INT,
        camaras INT,
        escondites INT,
        nivel_desbloqueo INT
        )";
    mysqli_query($conexion, $sqlMapas);

    // Crear tabla de usuarios
    $sqlUsuarios = "CREATE TABLE IF NOT EXISTS usuarios (
        id INT AUTO_INCREMENT PRIMARY KEY,   
        nombre_usuario VARCHAR(20),
        correo VARCHAR(255),
        contrasena TEXT
    )";
    mysqli_query($conexion, $sqlUsuarios);

    // Crear tabla de amigos
    $sqlAmigos = "CREATE TABLE IF NOT EXISTS amigos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        usuario_id INT,
        amigo_id INT,
        aceptada TEXT,
        FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
        FOREIGN KEY (amigo_id) REFERENCES usuarios(id)
    )";
    mysqli_query($conexion, $sqlAmigos);

    // Crear tabla de mensajes
    $sqlMensajes = "CREATE TABLE IF NOT EXISTS mensajes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        emisor_id INT,
        receptor_id INT,
        mensaje TEXT,
        fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (emisor_id) REFERENCES usuarios(id),
        FOREIGN KEY (receptor_id) REFERENCES usuarios(id)
    )";
    mysqli_query($conexion, $sqlMensajes);

    $sqlVideos = "CREATE TABLE IF NOT EXISTS videos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombreVideo VARCHAR(255) NOT NULL,
        idAutor INT NOT NULL,
        video LONGBLOB NOT NULL,
        FOREIGN KEY (idAutor) REFERENCES usuarios(id)
    )";
    mysqli_query($conexion, $sqlVideos);

    $sqlMeGusta = "CREATE TABLE IF NOT EXISTS meGusta (
        id INT AUTO_INCREMENT PRIMARY KEY,
        idVideo INT NOT NULL,
        idUsuario INT NOT NULL,
        FOREIGN KEY (idVideo) REFERENCES videos(id),
        FOREIGN KEY (idUsuario) REFERENCES usuarios(id)
    )";
    mysqli_query($conexion, $sqlMeGusta);

    $sqlSuscripciones= "CREATE TABLE IF NOT EXISTS suscripciones (
        id INT AUTO_INCREMENT PRIMARY KEY,
        idStreamer INT NOT NULL,
        idUsuario INT NOT NULL,
        FOREIGN KEY (idStreamer) REFERENCES usuarios(id),
        FOREIGN KEY (idUsuario) REFERENCES usuarios(id)
    )";
    mysqli_query($conexion, $sqlSuscripciones);

    $sqlComentarios = "CREATE TABLE IF NOT EXISTS comentarios (
        id INT AUTO_INCREMENT PRIMARY KEY,
        idVideo INT NOT NULL,
        idUsuario INT NOT NULL,
        comment TEXT NOT NULL,
        FOREIGN KEY (idVideo) REFERENCES videos(id),
        FOREIGN KEY (idUsuario) REFERENCES usuarios(id)
    )";
    mysqli_query($conexion, $sqlComentarios);

    $sqlContacto = "CREATE TABLE IF NOT EXISTS contacto (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(20),
        correo  VARCHAR(255),
        mensaje TEXT NOT NULL
    )";
    mysqli_query($conexion, $sqlContacto);
}

function insertarDatos($conexion)
{
    //Insertar datos en tabla pruebas
    $insertarPruebas = "INSERT INTO pruebas (nombre, extra) VALUES 
        ('Medidor EMF 5', 'Nivel máximo de lecturas de EMF, hay alta actividad paranormal en la zona en la que se encuentra'),
        ('Orbes Espectrales', 'Apariciones visuales de orbes espectrales con la cámara en visión nocturna'),
        ('Temperaturas Heladas', 'Temperaturas bajo cero medidas con el termometro, o aparición de vaho'),
        ('Escritura Fantasmal', 'Escritura en el libro de escritura fantasmal, textos o dibujos'),
        ('Spirit Box', 'Respuestas a preguntas a través del dispositivo de caja de voz (Spirit Box)'),
        ('Proyector D.O.T.S.', 'Silueta del fantasma vista a través del proyector D.O.T.S, dura breves segundos'),
        ('Ultravioleta', 'Impresiones de las manos visibles en superficies como puertas, ventanas o interruptores');
    ";
    mysqli_query($conexion, $insertarPruebas);

    //Insertar datos en tabla fantasmas
    $insertarFantasmas = "INSERT INTO fantasmas (nombre, cordura, velocidad, descripcion, extra) VALUES 
        ('Espíritu', 50, '1.7', 'Los espíritus son fantasmas muy comunes. Son muy poderosos, pero pasivos: solo atacan cuando es necesario. Defienden el lugar donde murieron hasta la saciedad, matando a cualquiera que se quede más tiempo de lo necesario.\nDebilidad:Utilizar incienso cerca de ellos los parará temporalmente.', '<ul><li><b>Información:</b></li><li>- Usando incienso cerca del fantasma evitará que cace en 180s(3m) en vez de 90s de normal(1,5m).</li></ul>'),
        ('Espectro', 50, '1.7', 'Un espectro es un tipo de fantasma de los más peligrosos que puedes hallar. También es el único tipo de fantasma que puede volar y en ocasiones atravesar paredes.\nFortaleza: Casi nunca tocan el suelo, por lo que no dejan pisadas.\nDebilidad: Al entrar en contacto con la sal, les produce una reacción tóxica.', '<ul><li><b>Información:</b></li><li>- El fantasma nunca pisara la sal sin importar su tier.</li><li>- No se ralentizará por la sal de tier 3 durante una cacería.</li><li><b>Comportamiento:</b></li><li>- Se puede hacer tp a un jugador aleatorio dejando como resultado EMF 2 o EMF 5.</li></ul>'),
        ('Ente', 50, '1.7', 'Un ente es un fantasma que puede poseer a los vivos, induciendo el miedo a quienes le rodean. Son comúnmente invocados a través de la güija.\nFortaleza: Mirarlo directamente descenderá tu cordura considerablemente rápido.\nDebilidad: Al sacarle una foto, desaparecerá temporalmente.', '<ul><li><b>Información:</b></li><li>- No se les ve en las fotografías.</li><li>- Al tomarle foto durante un evento o aparición en DOTs hará que el fantasma desaparezca al instante.</li><li>- Su parpadeo es más lento durante las cacerías (Comprobar la pestaña \'Guías\').</li><li><b>Comportamiento:</b></li><li>- Puede seguir a un jugador random dejando como resultado EMF 2.</li></ul>'),
        ('Poltergeist', 50, '1.7', 'Uno de los fantasmas más famosos: el poltergeist. Conocido por manipular objetos a su alrededor para propagar el miedo en sus victimas.\nFortaleza: Puede lanzar múltiples objetos a la vez.\nDebilidad: Su poder no sirve de nada si no tiene objetos que lanzar.', '<ul><li><b>Información:</b></li><li>- Puede lanzar múltiples objetos a la vez reduciendo la cordura del jugador un 2% por cada objeto lanzado.</li><li>- Lanza o interactúa con los objetos cada 0.5s durante la cacería.</li><li><b>Comportamiento:</b></li><li>- Mayor probabilidad de que lance o interactúe con objetos.</li><li>- Puede lanzar los objetos velozmente y más lejos que otros fantasmas.</li></ul>'),
        ('Banshee', 50, '1.7', 'Una banshee es una cazadora nata y atacará a cualquier cosa. Se la conoce por aislar a su presa antes de asestar el golpe fatal.\nFortaleza: Solo se fijará en una persona simultáneamente.\nDebilidad: Temen el crucifijo y serán menos agresivas cerca de uno.', '<ul><li><b>Información:</b></li><li>- Grita a través la parabólica.</li><li><b>Comportamiento:</b></li><li>- Sólo irá tras una persona durante la cacería (a no ser que el objetivo esté fuera).</li><li>- Se mueve hacia su objetivo, dejando un EMF 2.</li><li>- Intentará moverse hacia su objetivo mientras esté en estado DOTs.</li><li>- Prefiere los eventos de cántico.</li><li><b>Cordura de ataque:</b></li><li>- Atacará cuando la cordura de su objetivo esté en 50% o por debajo, lo que significa que puede cazar con un 87% de cordura promedio.</li></ul>'),
        ('Jinn', 50, '1.7 | 2.5', 'Un jinn es un fantasma territorial que atacará cuando se sienta amenazado. También se le conoce por desplazarse significativamente rápido.\nFortalezas: Un jinn acelerará su velocidad si su víctima está lejos de él.\nDebilidades: Apagar el cuadro eléctrico de la ubicación evitará que el jinn pueda usar sus habilidades.', '<ul><li><b>Información:</b></li><li>- Su habilidad reducirá la cordura de los jugadores cercanos en un 25%, dando lugar a un EMF 2 o 5 en la caja de fusibles (cuando está encendido).</li><li><b>Comportamiento:</b></li><li>- No puede apagar la caja de fusibles.</li><li><b>Velocidad:</b></li><li>- 2.5m/s cuando los fusibles están encendidos y el jugador se encuentra a más de 3m, 1.7m/s cuando está a menos de 3m.</li></ul>'),
        ('Pesadilla', 60, '1.7', 'Una pesadilla es la fuente de tus peores sueños, haciéndola así muy poderosa en la oscuridad.\nFortalezas: Una pesadilla podrá atacar muy frecuentemente si está todo a oscuras.\nDebilidades: Encender las luces cerca de una pesadilla reducirá sus posibilidades de atacar.', '<ul><li><b>Información:</b></li><li>- Habilidad de apagar inmediatamente el interruptor que encendió el jugador (Se puede probar solamente 1 vez cada 10s).</li><li>- No puede encender luces (teclados y televisiones sí).</li><li><b>Comportamiento:</b></li><li>- Es más probable que se apaguen y se rompan las luces.</li><li>- Es más probable que deambule por una habitación donde las luces están apagadas.</li><li><b>Cordura de ataque:</b></li><li>- 60% cuando las luces de su habitación están apagadas, 40% cuando están encendidas.</li></ul>'),
        ('Revenant', 50, '1.0 | 3.0', 'Un revenant es un fantasma violento que atacará indiscriminadamente. Su velocidad puede ser engañosa, ya que son lentos mientras están inactivos, sin embargo, tan pronto como cazan, pueden moverse increíblemente rápido.\nFortaleza : Viajará a una velocidad significativamente rápida cuando ataque a su presa.\nDebilidad : Esconderse de él hará que se mueva muy lentamente.', '<ul><li><b>Velocidad:</b></li><li>- 3.0m/s inmediatamente que detecta al jugador (equipamiento, voz, o línea de visión) hasta que el fantasma haya llegado a la última ubicación conocida del jugador, donde se reducirá gradualmente a 1 m/s.</li></ul>'),
        ('Sombra', 35, '1.7', 'Una sombra es conocida por ser muy tímida. Existe evidencia que confirma que una sombra detendrá su actividad paranormal si hay varias personas cerca.\nFortaleza: Son difíciles de encontrar.\nDebilidad: Este fantasma no atacará sí hay varias personas cerca.', '<ul><li><b>Información:</b></li><li>- Sus interacciones no darán como resultado EMF 2, 3 o 5 cuando alguien está en su habitación (excepto escritura o soplar una vela).</li><li>- No cazará con alguien en la misma habitación que el fantasma.</li><li><b>Comportamiento:</b></li><li>- Más eventos cuando la cordura promedio está baja (No hace eventos al 100% de cordura promedio).</li><li>- Es menos probable que aparezca como sombra en los eventos, pero es más probable que aparezca el evento de bola.</li><li>- El único fantasma que tiene la posibilidad de aparecer como una sombra si se invoca desde una caja de música, mano de mono o un círculo de invocación.</li></ul>'),
        ('Demonio', 70, '1.7', 'Un demonio es uno de los peores fantasmas con los que te puedes topar. Se dice que atacan sin razón alguna.\nFortaleza: Iniciará ataques más a menudo que otros fantasmas.\nDebilidad: Si te responde por la güija, perderás menos cordura.', '<ul><li><b>Información:</b></li><li>- Usar incienso cerca del fantasma evitará que cace durante 60s en vez de 90s.</li><li>- Tiempo entre cacerías de 20s (tiempo normal 25s)</li><li><b>Comportamiento:</b></li><li>- El crucifijo tiene un rango aumentado del 50% dependiendo del tier (T1: 4.5m. T2: 6m. T3: 7.5m).</li><li><b>Cordura de ataque:</b></li><li>- Puede cazar a cualquier nivel de cordura, caza normalmente a partir del 70%</li></ul>'),
        ('Yurei', 50, '1.7', 'Un yurei es un tipo de fantasma que ha vuelto al plano físico, normalmente para cobrarse una venganza o manifestar su odio.\nFortaleza: Se dice que tienen una gran influencia en la cordura de las personas.\nDebilidad: Utilizar incienso en su habitación lo atrapará ahí temporalmente, reduciendo la frecuencia con la que deambula.', '<ul><li><b>Información:</b></li><li>- Puede cerrar una puerta por completo quitando a los jugadores cercanos un 15% de cordura si la puerta está en su habitación.</li><li>- Solo este fantasma puede cerrar o interactuar con la puerta principal de la casa fuera de una cacería o evento.</li><li><b>Comportamiento:</b></li><li>- Usar incienso atrapará al fantasma en su habitación y evitará que merodee durante 60 segundos.</li></ul>'),
        ('Oni', 50, '1.7', 'Los oni comparten rasgos con los demonios y poseen una fuerza extrema. Algunos rumores apuntan a que se manifiestan más cuando están cerca de su presa.\nFortaleza: Son más activos cuando hay varias personas cerca y se les ha visto mover objetos a gran velocidad.\nDebilidad: Son muy activos, por lo que es más fácil encontrarlos.', '<ul><li><b>Información:</b></li><li>- Quita un 20% de cordura en los eventos, en vez de 10%.</li><li>- NO realiza eventos de orbes.</li><li>- Se le ve más durante las cacerías (Revisar pestaña \'Guías\').</li><li><b>Comportamiento:</b></li><li>- Más activo con varias personas.</li><li>- Es más probable que se vea el fantasma en los eventos en lugar de la sombra.</li></ul>'),
        ('Yokai', 80, '1.7', 'Los yokai son fantasmas comunes que se sienten atraídos por las voces humanas. Se les puede encontrar atormentando casas familiares.\nFortaleza: Hablar cerca de él lo enfadará, incrementando las probabilidades de ataque.\nDebilidad: Cuando está atacando solo puede oír voces en sus proximidades.', '<ul><li><b>Información:</b></li><li>- No puede detectar la voz o aparatos electrónicos a más de 2,5m durante la cacería.</li><li><b>Comportamiento:</b></li><li>- Más activo cuando se habla cerca del fantasma.</li><li><b>Cordura de caza:</b></li><li>- Puede iniciar cacerías a partir del 80% de cordura cuando se habla cerca de él, si no al 50%.</li></ul>'),
        ('Hantu', 50, '1.44 - 2.7', 'Un hantu es un tipo de fantasma raro que se puede encontrar en climas cálidos. Se les conoce por atacar a menudo cuando hay clima frío.\nFortaleza: Se desplaza más rápido si hay temperaturas bajas.\nDebilidad: Se mueve más despacio en zonas con temperaturas calientes.', '<ul><li><b>Información:</b></li><li>- Se le puede ver vaho al fantasma en cualquier habitación durante la cacería si los fusibles están apagados.</li><li>- No puede encender los fusibles.</li><li><b>Comportamiento:</b></li><li>- Alta probabilidad de que apague los fusibles.</li><li><b>Velocidad:</b></li><li>- Veloz en temperaturas heladas. NO acelera en línea de visión.</li><li><b>Evidencia:</b></li><li>- Temperaturas garantizadas en Pesadilla o Demencia.</li></ul>'),
        ('Goryo', 50, '1.7', 'Cuando un goryo pasa a través de un proyector DOTS, solo una cámara de video podrá verlo.\nFortaleza: Sólo se mostrará ante la cámara de video si no hay nadie cerca.\nDebilidad: Rara vez se les ve lejos del lugar donde murieron.', '<ul><li><b>Información:</b></li><li>- Sólo se le puede ver en el DOTs a través de una cámara de video y fuera de su habitación o desde el camión.</li><li><b>Comportamiento:</b></li><li>- No puede cambiar su habitación favorita.</li><li>- No sale de su habitación muy a menudo.</li><li><b>Evidencia:</b></li><li>- DOTs garantizados en Pesadilla o Demencia.</li></ul>'),
        ('Myling', 50, '1.7', 'Un myling es un fantasma muy activo y sonoro. Se rumorea que es silencioso cuando ataca a sus presas.\nFortaleza: Cuando ataca, suele ser sigiloso.\nDebilidad: Hacen ruido paranormal más frecuentemente.', '<ul><li><b>Información:</b></li><li>- No se le puede escuchar (pasos ni voz) a más de 12m durante las cacerías (de normal a 20m).</li><li><b>Comportamiento:</b></li><li>- Muchos sonidos paranormales a través del micrófono parabólico.</li></ul>'),
        ('Onryo', 60, '1.7', 'El onryo suele ser conocido como \"el espíritu furioso\". Roba las almas de los cuerpos de sus víctimas en búsqueda de venganza. Se conoce que este fantasma teme a cualquier tipo de fuego, y hará lo imposible para estar lejos de él.\nFortaleza: Apagar una llama puede provocar que el onryo ataque.\nDebilidad: Si se siente amenazado, atacará con menos frecuencia.', '<ul><li><b>Información:</b></li><li>- Cazará con cualquier cordura después de apagar cada tercera llama si ninguna otra llama o crucifijo lo impide.</li><li><b>Comportamiento:</b></li><li>- Las llamas actúan como crucifijos, apagará una llama si intenta cazar (a menos de 4 m).</li><li>- Más probable que apague llamas cuantos más jugadores muertos hay.</li><li><b>Cordura de ataque:</b></li><li>- Puede cazar a cualquier nivel de cordura usando su habilidad, de normal a partir del 60%.</li></ul>'),
        ('Gemelos', 50, '1.53 | 1.87', 'Hay reportes que indican que estos fantasmas imitan las acciones del otro. Alternan sus ataques para confundir a su presa.\nFortaleza: Cada uno de los gemelos puede enfadarse e iniciar un ataque sobre su presa.\nDebilidad: Suelen interactuar con el entorno al mismo tiempo.', '<ul><li><b>Información:</b></li><li>- A menudo realizan interacciones al mismo tiempo (en una ubicación real y en una ubicación falsa).</li><li><b>Comportamiento:</b></li><li>- Solo activa sensores de movimiento, pisa sal y da spirit box en su ubicación real.</li><li><b>Velocidad:</b></li><li>- 1.53m/s cuando caza desde la ubicación real, 1.87m/s cuando caza desde la ubicación falsa.</li></ul>'),
        ('Raiju', 65, '1.7 | 2.5', 'Un raiju es un demonio que se nutre de la corriente eléctrica. Normalmente es tranquilo, pero se puede descontrolar si absorbe demasiado poder.\nFortaleza: Obtiene su poder de los dispositivos eléctricos cercanos, haciendo que se mueva más rápido.\nDebilidad: Debido a que siempre interfiere con los aparatos electrónicos, es fácil de rastrear cuando ataca.', 'Información:\n- Durante una cacería los objetos electrónicos empiezan a parpadear a los 15m en vez de los 10m.&Cordura de ataque:\n- Puede atacar a partir de 65% de cordura cuando hay jugadores cerca con equipos electrónicos.&Velocidad:\n- 2.5m/s cerca de objetos electrónicos activos, 1.7m/s si no hay objetos electrónicos.'),
        ('Obake', 50, '1.7', 'Los obake son cambiaformas terroríficos, y por ello son capaces de adquirir muchas apariencias. Han sido vistos adoptando forma humanoide para atraer a su presa.\nFortaleza: Cuando interactúan con el entorno, rara vez dejarán rastro.\nDebilidad: A veces cambiarán de forma, revelando así pruebas indispensables.', '<ul><li><b>Información:</b></li><li>- Deja una huella especial de 6 dedos (Ver pestaña \'Guías\').</li><li>- Tiene un 6.6% de probabilidad de cambiar el modelo del fantasma cuando parpadea durante la cacería (garantizada 1 por cacería).</li><li>- Tiene un 25% de probabilidad de no dejar la evidencia de ultravioleta.</li><li>- Puede hacer que las huellas desaparezcan el doble de rápido cuando usa su habilidad.</li><li><b>Evidencia:</b></li><li>- Ultravioleta garantizada en Pesadilla y Demencia.</li></ul>'),
        ('Mímico', 50, '1.7', 'El mímico es un fantasma elusivo, misterioso e imitador que copia los rasgos y comportamientos de los demás, incluyendo otros tipos de fantasma.\nFortaleza: No estamos seguros de lo que es capaz. Ten cuidado.\nDebilidad: Muchos reportes indican orbes espectrales cerca de ellos.', '<ul><li><b>Información:</b></li><li>- Siempre muestra orbes espectrales como una prueba falsa (4 evidencias) incluso con 0 evidencias.</li><li>- Copia el comportamiento y las propiedades de otros fantasmas.</li><li>- Cambia el tipo de fantasma copiado cada 30s a 2m.</li><li><b>Cordura de ataque:</b></li><li>- Copia el comportamiento del fantasma actualmente imitado.</li><li><b>Velocidad:</b></li><li>- Copia la velocidad del fantasma actualmente imitado.</li></ul>'),
        ('Moroi', 50, '1.5 - 2.25 (3.71)', ' Los moroi emergen de sus tumbas para robar la energía de los vivos. Se dice que maldicen a sus víctimas, quienes sólo podrán liberarse de su maldición a través de antídotos o mudándose muy lejos.\nFortaleza: Cuanto más débil sea su víctima, más fuerte será el moroi.\nDebilidad: Los moroi padecen hiperosmia, lo cual los debilita durante un buen rato.', '<ul><li><b>Información:</b></li><li>- Pone una maldición al jugador cuando escucha al fantasma a través del micrófono parabólico o en la Spirit Box causando que la cordura se reduzca x2 veces más rápido.</li><li>- El incienso hace que el efecto de ceguera del fantasma se aumente un 50% (7.5s en lugar de 5s).</li><li><b>Velocidad:</b></li><li>- Muy rápido cuando el promedio de cordura es bajo, puede alcanzar una velocidad de 3.71 m/s cuando te tiene en la línea de visión.</li><li>- Reducirá su velocidad si durante la cacería se usa medicación para la cordura.</li><li><b>Evidencia:</b></li><li>- Spirit Box garantizada en Pesadilla o Demencia.</li></ul>'),
        ('Deogen', 40, '0.4 | 3.0', 'En ocasiones envueltos por una niebla eterna, los deogen llevan evadiendo a los cazadores de fantasmas durante años.\n Hay reportes que acusan a estos fantasmas de haber encontrado incluso a las presas más ocultas, justo antes de acecharles hasta la extenuación.\nFortaleza: Perciben a los vivos constantemente. Podrás huir, pero no podrás esconderte.\nDebilidad: Utilizan mucha energía para manifestarse, haciendo que se desplacen muy despacio al estar cerca de sus víctimas.', '<ul><li><b>Información:</b></li><li>- Respiración pesada a través de la Spirit Box cuando se usa a 1m del fantasma.</li><li>- No te puedes esconder del fantasma, tienes que loopearlo.</li><li><b>Velocidad:</b></li><li>- 3.0m/s cuando está lejos, 0.4m/s cuando está cerca del jugador.</li><li><b>Evidencia:</b></li><li>- Spirit Box garantizado en Pesadilla o Demencia.</li></ul>'),
        ('Thaye', 75, '1.0 - 2.75', 'Se dice que los thaye envejecen muy rápido, incluso en el más allá. Por lo que sabemos, parece que empeoran más rápido si hay vivos cerca de ellos.\nFortaleza: Conforme entres en la ubicación, se volverán activos, defensivos y ágiles.\nDebilidades: Se debilitan con el tiempo, tornándose más vulnerables, más lentos y menos agresivos.', '<ul><li><b>Comportamiento:</b></li><li>- Envejece cuando el jugador está en la habitación del fantasma o cerca del fantasma (cada 1-2 minutos).</li><li>- Más activo cuando es joven.</li><li>- Preguntar por su edad en la Ouija hará que envejezca.</li><li><b>Cordura de ataque:</b></li><li>- Puede cazar a partir de 75% cuando es joven, 15% cuando es viejo.</li><li><b>Velocidad:</b></li><li>- 2.75m/s cuando es joven, 1.0m/s cuando es viejo No aumenta su velocidad cuando está en línea de visión.</li></ul>');
    ";
    mysqli_query($conexion, $insertarFantasmas);

    //Insertar datos en tabla pruebas_fantasmas
    $insertarPruebasFantasmas = "INSERT INTO pruebas_fantasmas (prueba_id, fantasma_id) VALUES 
        (1,1),
        (4,1),
        (5,1),
        (1,2),
        (5,2),
        (6,2),
        (5,3),
        (7,3),
        (6,3),
        (5,4),
        (7,4),
        (4,4),
        (7,5),
        (6,5),
        (2,5),
        (1,6),
        (7,6),
        (3,6),
        (5,7),
        (2,7),
        (4,7),
        (2,8),
        (4,8),
        (3,8),
        (1,9),
        (4,9),
        (3,9),
        (7,10),
        (4,10),
        (3,10),
        (2,11),
        (3,11),
        (6,11),
        (1,12),
        (3,12),
        (6,12),
        (5,13),
        (2,13),
        (6,13),
        (7,14),
        (2,14),
        (3,14),
        (1,15),
        (7,15),
        (6,15),
        (1,16),
        (7,16),
        (4,16),
        (5,17),
        (2,17),
        (3,17),
        (1,18),
        (5,18),
        (3,18),
        (1,19),
        (2,19),
        (6,19),
        (1,20),
        (7,20),
        (2,20),
        (2,21),
        (5,21),
        (7,21),
        (3,21),
        (5,22),
        (4,22),
        (3,22),
        (5,23),
        (3,23),
        (6,23),
        (2,24),
        (4,24),
        (6,24);
    ";
    mysqli_query($conexion, $insertarPruebasFantasmas);

    //Insertar datos en tabla objetos_malditos
    $insertarObjetosMalditos = "INSERT INTO objetos_malditos (nombre, efecto, preguntas) VALUES 
        ('Pata de mono', 'Esta se caracteriza por tener la habilidad de conceder deseos.\n¿Cómo se utiliza?: dependiendo de la dificultad de la partida, tienes mas o menos deseos la cantidad de deseos por multiplicador es la siguiente:\n0x - 1.99x: 5 deseos   —   2x - 2.99x: 4 deseos   —   3x o más: 3 deseos\nFactores a tener en cuenta:\n1.- El listado de deseos se encuentra esparcido por el mapa de Sunny Meadows.\n2.- Puedes utilizar el chat en modo text para poder ver el listado.\n3.- Los deseos pueden ser algo bueno, algo neutro o algo malo.', 'Deseo ver al fantasma=El fantasma hace aparición, al que pide el deseo lo deja ciego (lo ve todo muy oscuro) en cacería, cuando acaba ve bien (la cacería es maldita). No quita cordura.\nDeseo actividad=Cierra la puerta de la calle durante 1 minuto y 40 segundos, rompe los plomos y no quita cordura.\nDeseo atrapar al fantasma=Cierra las puertas de donde se encuentre el fantasma y luego inicia ataque (duración 55segundos) la cacería no sería maldita, no quita cordura.\nDeseo tener cordura=Todos los jugadores se ponen con el 50% de cordura, ya tengan más o menos cordura. El fantasma cambia de habitación.\nDeseo irme=Este deseo se puede pedir en pleno ataque y la puerta de salida de la casa se abrirá y podrás salir sin problema, al que pide el deseo le da lentitud. No quita cordura.\nDeseo revivir a un amigo=50% de probabilidad de morir al pedir el deseo. No quita cordura.\nDeseo estar a salvo=Cualquier closet cerrado cercano, se despejara y podrás esconderte. No quita cordura\nDeseo saber más=Te quita una prueba, la cual el fantasma no te dará, pero el fantasma comenzará ataque cerca tuya y tu te quedarás ciego y sordo durante toda la partida. No quita cordura.\nDeseo cambiar el clima=Puedes cambiar el clima a soleado, lluvioso, con viento, nieve o despejado esto tiene una penalización de 25% de cordura a quien pide el deseo.\nDeseo lo que sea=Se escogerá un deseo al azar entre todos los que hay.'),
        ('Caja de música', 'Esta se caracteriza por una melodía que hace cantar al fantasma, haciendo así más fácil la localización de su habitación.\n¿Cómo se utiliza?: cuando la tenemos en la mano damos clic derecho y empieza a sonar la melodía. En ese mismo momento el fantasma se pondrá a cantar. Solo tiene 1 uso.\nFactores a tener en cuenta:\n1.- Los fantasmas se sienten atraído hacia la caja de música, por lo que si esta a menos de 5 metros se materializa y va hacia la caja, rompiéndola y provocando una cacería.\n2.- Cada segundo que suena la caja drena un 4% de cordura a todos los que estén en un radio de 3 metros circular a la caja.\n3.- Si tiras la caja al suelo cuando esta sonando se rompe y comienza una cacería.\n4.- La caja suena 28 segundos si tu cordura esta al 100%, si tu cordura baja a cero y quedan segundos se rompe y comienza cacería.\n5.- Si la cordura promedia no esta en el rango de ataque del fantasma una vez termine la melodía, NO comenzara la caza.\n6.- Es un objeto maldito muy útil tanto para saber la localización del fantasma como para hacer la foto al fantasma.', null),
        ('Espejo encantado', 'Este se caracteriza por por poder ver desde la visión del fantasma este donde esté.\n¿Cómo se utiliza?: cuando la tenemos en la mano damos clic derecho y empezaríamos a ver lo que ver el fantasma, para dejar de ver tendremos que dar clic derecho de nuevo.\nFactores a tener en cuenta:\n1.- Mirar por el espejo drenara un 20% de cordura de golpe.\n2.- Cada segundo que veamos por el espejo nos drenara un 10% de cordura aprox.\n3.- Si nos consume toda la cordura el espejo se romperá y comenzara caza.\n4.- Es muy útil para dar rápido con la habitación del fantasma.\n5.- También es muy útil para realizar la prueba de tener menos del 25% de cordura promedio.', null),
        ('Muñeco vudú', 'Este se caracteriza por poder hacer que el fantasma realice hasta 10 interacciones.\n¿Cómo se utiliza?: cuando la tenemos en la mano damos clic derecho y empezaríamos a pinchar agujas en la muñeca vudú.\nFactores a tener en cuenta:\n1.- Cada aguja nos baja un 10% la cordura.\n2.- Si pinchas en el corazón te quita un 20% y nos inicia caza.\n3.-Los pinchazos son aleatorios, no puedes controlar cual pinchas.\n4.- Si no tienes cordura o la pierdes toda con algún pinchazo se pincharan todas e iniciara caza.\n5.- Como dato curioso este objeto siempre estuvo, pero no tenia utilidad a parte de foto de interacción.', null),
        ('Cartas del tarot', 'Esta se caracteriza por ser 10 cartas diferentes cada una con sus habilidades. También en el juego salen 10 unidades de cartas, pero se puede repetir una misma carta varias veces.\n¿Cómo se utiliza?: cuando la tenemos en la mano damos clic derecho y empieza sacar cartas. Si esta el fantasma en ataque, todas las cartas saldrán con Joker y no tendrán efecto.\nFactores a tener en cuenta:\n1.- Alas de Resurrección: reviven a un compañero muerto. Si no hay nadie muerto se guarda y cuando muera alguien a los 5 segundos revive, aunque siga la caza del fantasma. Si hay varias personas muertas revive el primero que murió.\n2.- El Ahorcado: mata directamente a la persona que saco la carta.\n3.- El demonio: evento del fantasma ya sea presencial o con la nube que se acerca a un jugador y le sopla.\n4.- El Ermitaño: durante un breve periodo de tiempo, el fantasma no atacara.\n5.- El Sol: restaura el 100% de cordura de la persona que saque la carta.\n6.- La Luna: quita el 100% de cordura de la persona que saque la carta.\n7.- La Torre: provoca interacciones durante 20 segundos del fantasma. Puede tocarte puerta, interruptor, escribir en el libro, pasar por el d.o.t.s o tirar algún objeto.\n8.- Muerte: inmediatamente y sin tiempo de gracia (tiempo de gracia son los 3 segundos que el fantasma tiene al iniciar caza, camina sobre si mismo y no avanza hasta pasado esos segundos) inicia caza desde donde esté.\n9.- Ruleta de la fortuna en verde: recupera un 25% de cordura la persona que saco la carta.\n10.- Ruleta de la fortuna en roja: pierde un 25% de cordura la persona que saco la carta.', null),
        ('Círculo de invocación', 'Este se caracteriza por ser un circulo de invocación directo del fantasma.\n¿Cómo se utiliza?: tiene 5 velas en cada punta del pentagrama. Encendemos cada una de ellas y justo cuando encendamos la ultima, el fantasma se manifestara, estará 3 segundos quieto y después iniciara caza.\nFactores a tener en cuenta:\n1.- Cada vela que se encienda baja un 16% la cordura a la persona que encienda la vela y a quien este en un radio de 3 metros.\n2.- Se puede utilizar para bajar la cordura ya que si no enciendes todas las velas, se apagaran cuando pase de 2 minutos y 30 segundos a 5 minutos en un periodo random.\n3.- Es muy útil para poder realizar la foto del fantasma. En cuanto se encienda la última vela, puedes hacer una foto en esos 3 segundos de gracia.\n4.- Si no se tiene nada de cordura no se puede encender las velas, se apagarían al segundo. Si tienes menos del 16% pero no 0% y enciendes la ultima vela del circulo, el fantasma se mostrara y atacara sin tiempo de preparación como es habitual en el circulo.\n5.- También es muy útil si la posibilidad del fantasma es Ente, ya que desaparecerá  por la foto. O si es la silueta del fantasma en modo sombra, seria una Sombra.', null),
        ('Tablero de ouija', 'Este se caracteriza por ser una manera de comunicación directa con el fantasma.\n¿Cómo se utiliza?: clic izquierdo sobre ella y se baja el puntero de ouija, le realizas la pregunta y cuando termines tienes que decir adiós, el puntero desaparece y ahí termina su utilización.\nFactores a tener en cuenta:\n1.- Cada pregunta a la ouija baja cordura a quien le realiza la pregunta.\n2.- Si no tienes cordura, no puedes realizar preguntas. Si llegase a pasar, que realices una pregunta sin cordura, la ouija se romperá sin darte respuesta.\n3.- Es muy útil para saber la habitación donde esta el fantasma y para preguntar por el hueso.\n4.- También es muy útil sin el fantasma no te da interacciones para foto, ya que cada pregunta se puede realizar una foto de interacción 3 estrellas.\n5.- Al realizar preguntas puedes poner el aparato de EMF, si el fantasma tuviera la prueba de EMF5 te lo podría dar con las preguntas.', '¿Cuál es tu habitación favorita?=50% de cordura.\n¿Dónde estás?=50% de cordura.\n¿Dónde está el hueso?=50% de cordura.\n¿Dónde moriste?=50% de cordura.\n¿Te gustan las galletas?=20% de cordura.\nMARCO - Responde POLO=5% de cordura.\nTOC TOC=5% de cordura.\n¿Cuántos años tienes?=5% de cordura.\n¿Qué quieres?=5% de cordura.\n¿Estoy loco?=5% de cordura.\n¿Qué cordura tengo?=Responde NO 100%, MAYBE desde el 99% hasta el 10%, por debajo YES.\nESCONDITE=Comienza una cuenta atrás y cuando llega a 0 comienza un ataque y se rompe la ouija.');
    ";
    mysqli_query($conexion, $insertarObjetosMalditos);

    //Insertar datos en tabla equipamiento
    $insertarEquipamiento = "INSERT INTO equipamiento (nombre, tier, descripcion, nivel_desbloqueo, precio_mejora, coste, limite_mision, opcional, tipo) VALUES
        ('Proyector D.O.T.S.', 1, 'Un pequeño puntero láser que proyecta pequeños rayos de luz en el entorno. Se puede colocar.', 0, 0, 65, 2, 'N', 'electrico'),
        ('Proyector D.O.T.S.', 2, 'Este sensor de movimiento infrarrojo fue ampliablemente adaptado para proyectar luz. Es pequeño, compacto y se adhiere a la mayoría de superficies.', 29, 3000, 65, 2, 'N', 'electrico'),
        ('Proyector D.O.T.S.', 3, 'Un proyector motorizado con tres lentes que cubren un amplio rango lumínico. Se puede colocar en paredes y algunos techos.', 60, 3000, 65, 2, 'N', 'electrico'),
        ('Medidor EMF', 1, 'Un medidor EMF con varios modos para analizar las distintas interferencias del aire. Si la aguja empieza a moverse. Si el fantasma tuviera esta prueba, llegará la aguja al nivel 5.', 0, 0, 45, 2, 'N', 'electrico'),
        ('Medidor EMF', 2, 'El medidor K2 tiene más rango y 5 luces LED que muestran lecturas EMF, además de un módulo adicional con altavoz.', 20, 3000, 45, 2, 'N', 'electrico'),
        ('Medidor EMF', 3, 'Lector EMF con pantalla, muestra primero el EMF que emite el objeto, el RNA (la distancia donde está el objeto) y la DIR (unas flechas que indican en qué dirección está el objeto que tiene EMF).', 52, 4500, 45, 2, 'N', 'electrico'),
        ('Linterna', 1, 'Linterna con una pequeña luz.', 0, 0, 30, 4, 'N', 'electrico'),
        ('Linterna', 2, 'Emite un foco de luz más brillante.', 19, 3000, 30, 4, 'N', 'electrico'),
        ('Linterna', 3, 'Linterna con luz muy potente.', 35, 2500, 30, 4, 'N', 'electrico'),
        ('Libro de escritura fantasma', 1, 'Cuaderno de escritura pequeño, con poco alcance y será complicado que el fantasma dé la prueba. Si el fantasma no tuviese esta prueba lanzaría el libro por los aires, es muy útil para descartar todos los fantasmas sin escritura si lo llega a lanzar.', 0, 0, 40, 2, 'N', 'ninguno'),
        ('Libro de escritura fantasma', 2, 'Mejores páginas y bolígrafo, los fantasmas se fijan más haciendo que los tiempos sean algo inferiores para obtener la prueba. Si el fantasma no tuviese esta prueba lanzaría el libro por los aires, es muy útil para descartar todos los fantasmas sin escritura si lo llega a lanzar.', 23, 3000, 40, 2, 'N', 'ninguno'),
        ('Libro de escritura fantasma', 3, 'Grimorio de gran tamaño donde tiene un alcance mucho mayor y da con más facilidad la escritura. Si el fantasma no tuviese esta prueba lanzaría el libro por los aires, es muy útil para descartar todos los fantasmas sin escritura si lo llega a lanzar.', 63, 3000, 40, 2, 'N', 'ninguno'),
        ('Spirit Box', 1, 'Pequeña radio compacta y antigua. Tarda en dar resultados y su altavoz no tiene mucha calidad. Si el fantasma tuviera esta prueba, se pondrá en blanca la luz del fantasma.', 0, 0, 50, 2, 'N', 'electrico'),
        ('Spirit Box', 2, 'Altavoz de alta calidad y más eficiente al escanear entre distintas frecuencias logrando que las respuestas sean más fáciles de descifrar.', 27, 3000, 50, 2, 'N', 'electrico'),
        ('Spirit Box', 3, 'Altavoz de alta calidad y más eficiente al escanear entre distintas frecuencias logrando que las respuestas sean más fáciles de descifrar.', 54, 3000, 50, 2, 'N', 'electrico'),
        ('Termómetro', 1, 'Termómetro de pared que sirve para medir la temperatura de una habitación, tarda bastante tiempo en dar las temperaturas exactas. Si el fantasma tuviera esta prueba, verás el indicador debajo del cero.', 0, 0, 30, 2, 'N', 'ninguno'),
        ('Termómetro', 2, 'Termómetro digital mucho más rápido leyendo temperaturas.', 36, 3000, 30, 2, 'N', 'ninguno'),
        ('Termómetro', 3, 'Termómetro digital mucho más rápido leyendo temperaturas. Dejar pulsado el clic derecho para obtener lectura de temperatura.', 64, 3000, 30, 2, 'N', 'electrico'),
        ('Linterna ultravioleta', 1, 'Barra luminosa de duración 60 segundos (luz fuerte) pasado 10 segundos que se vaya su potencia, se agita (clic derecho) y se reactiva.', 0, 0, 20, 2, 'N', 'ninguno'),
        ('Linterna ultravioleta', 2, 'Emite un rato de luz de larga distancia pero estrecho siendo perfecta para buscar huellas dactilares y pisadas. Recarga dactilogramas ultravioletas más rápido que la barra luminosa.', 21, 3000, 20, 2, 'N', 'electrico'),
        ('Linterna ultravioleta', 3, 'Emite un rato de luz de larga distancia con mucha amplitud de luz siendo perfecta para buscar huellas dactilares y pisadas. Recarga dactilogramas ultravioletas más rápido que sus antecesoras.', 56, 2000, 20, 2, 'N', 'electrico'),
        ('Cámara de vídeo', 1, 'Cámara de video antigua pero se puede ver orbes sin problema. Interferencia altas en ataque. Se pueden visualizar orbes con ella.', 0, 0, 50, 4, 'N', 'electrico'),
        ('Cámara de vídeo', 2, 'Mejor calidad de imagen, mejor visión nocturna y más resistencia contra la interferencia paranormal. Se pueden visualizar orbes con ella.', 33, 3000, 50, 4, 'N', 'electrico'),
        ('Cámara de vídeo', 3, 'La mejor calidad de imagen, más amplia, mejor visión nocturna y más resistencia contra la interferencia paranormal. Se pueden visualizar orbes con ella.', 61, 3000, 50, 4, 'N', 'electrico'),
        ('Crucifijo', 1, 'Solo sirve para evitar 1 ataque y su alcance es bajo.', 8, 0, 30, 2, 'S', 'consumible'),
        ('Crucifijo', 2, 'Crucifijo de metal que puede bloquear hasta dos ataques, mayor rango de acción.', 37, 4000, 30, 2, 'S', 'consumible'),
        ('Crucifijo', 3, 'Crucifijo de metal que puede bloquear hasta dos ataques, o un solo ataque maldito. Mayor rango de acción que sus antecesores.', 90, 20000, 30, 2, 'S', 'consumible'),
        ('Lumbre', 1, 'Pequeña, con una duración de 3 minutos y reduce en un 33% la cordura que perdemos.', 12, 0, 15, 4, 'S', 'consumible'),
        ('Lumbre', 2, 'Candelabro con tres velas con una duración de 5 minutos y reduce en un 50% la cordura que perdemos. Cubre cordura incluso posicionándola cerca sin tener que tenerla en la mano.', 47, 3000, 15, 4, 'S', 'consumible'),
        ('Lumbre', 3, 'Farol de aceite con una duración de 10 minutos (se apagaría y se podría volver a encender) y reduce en un 66% la cordura que perdemos. Cubre cordura incluso posicionándola cerca sin tener que tenerla en la mano.', 79, 10000, 15, 4, 'S', 'consumible'),
        ('Equipamiento para la cabeza', 1, 'Cámara en la cabeza que se puede observar desde el camión para ver orbes.', 13, 0, 60, 4, 'S', 'electrico'),
        ('Equipamiento para la cabeza', 2, 'Equipamiento de cabeza que aporta una brillante luz para encenderlo dejar pulsado la letra T.', 49, 10000, 60, 4, 'S', 'electrico'),
        ('Equipamiento para la cabeza', 3, 'Cámara en la cabeza de alta resolución. Emite luz si se pulsa la letra T.', 88, 20000, 60, 4, 'S', 'electrico'),
        ('Bastón de luz', 1, 'Barra luminosa que se activa tras agitarla (clic derecho).', 10, 0, 20, 2, 'S', 'consumible'),
        ('Bastón de luz', 2, 'Barra luminosa de mayor duración (80 segundos luz fuerte) pasado 15 segundos que se vaya su potencia, se agita (clic derecho) y se reactiva.', 45, 1000, 20, 2, 'S', 'consumible'),
        ('Bastón de luz', 3, 'Barra luminosa de mayor duración (100 segundos luz fuerte) pasado 20 segundos que se vaya su potencia, se agita (clic derecho) y se reactiva.', 76, 10000, 20, 2, 'S', 'consumible'),
        ('Sal', 1, 'Bote de sal con un alcance pequeño y deja pocas partículas. Al pasar el fantasma por encima veremos la pisada.', 5, 0, 20, 2, 'S', 'consumible'),
        ('Sal', 2, 'Sal especial de uso doméstico con un alcance mayor.', 39, 4000, 20, 2, 'S', 'consumible'),
        ('Sal', 3, 'Sal especial de uso doméstico con un alcance mucho mayor, dejando más partículas.', 74, 8000, 20, 2, 'S', 'consumible'),
        ('Velas', 1, 'Velas sencillas, de corta duración. También sirve como mecha para prender el ritual (verifique primero el ritual a realizar).', 7, 0, 20, 4, 'S', 'consumible'),
        ('Velas', 2, 'Velas de larga duración. También sirve como mecha para prender el ritual (verifique primero el ritual a realizar).', 29, 2000, 20, 4, 'S', 'consumible'),
        ('Velas', 3, 'Velas especiales de muy larga duración.', 57, 10000, 20, 4, 'S', 'consumible');
    ";

    mysqli_query($conexion, $insertarEquipamiento);

    // Ruta de la imagen del mapa
    $TanglewoodDrive = "../img/Planos mapas/6_Tanglewood_Drive_-_Floorplan.webp";
    $RidgeviewCourt = "../img/Planos mapas/10_Ridgeview_Court_-_Floorplan.webp";
    $WillowStreet = "../img/Planos mapas/13_Willow_Street_-_Floorplan.webp";
    $EdgefieldRoad = "../img/Planos mapas/42_Edgefield_Road_-_Floorplan.webp";
    $BleasdaleFarmhouse = "../img/Planos mapas/Bleasdale_Farmhouse_-_Floorplan.webp";
    $CampWoodwind = "../img/Planos mapas/Woodwind.webp";
    $GraftonFarmhouse = "../img/Planos mapas/Grafton_Farmhouse_-_Floorplan.webp";
    $SunnyMeadowsMentalInstitutionRestricted = "../img/Planos mapas/Sunny_Meadows_Mental_Institution_-_Restricted_Map-Courtyard_Floorplan.webp";
    $MapleLodgeCampsite = "../img/Planos mapas/Maple_Lodge_Campsite_-_Floorplan.webp";
    $Prison = "../img/Planos mapas/Prison_-_Floorplan.webp";
    $BrownstoneHighSchool = "../img/Planos mapas/Brownstone_High_School_-_Floorplan.webp";
    $SunnyMeadowsMentalInstitution = "../img/Sunny_Meadows_Mental_Institution_-_Full_Map_Floorplan.webp";

    //Insertar datos en tabla mapas
    $insertarMapas = "INSERT INTO mapas (nombre, img, tamaño, plantas, habitaciones, salidas, grifos, camaras, escondites, nivel_desbloqueo) VALUES
        ('6 Tanglewood Drive', '$TanglewoodDrive', 'pequeño', 2, '10-1', 1, 3, 1, 6, 0),
        ('10 Ridgeview Court', '$RidgeviewCourt', 'pequeño', 2, '6-9-1', 1, 5, 1, 10, 2),
        ('13 Willow Street', '$WillowStreet', 'pequeño', 2, '7-3', 1, 2, 1, 8, 6),
        ('42 Edgefield Road', '$EdgefieldRoad', 'pequeño', 3, '7-8-1', 1, 4, 1, 9, 2),
        ('Bleasdale Farmhouse', '$BleasdaleFarmhouse', 'pequeño', 3, '1-7-8', 4, 4, 1, 7, 4),
        ('Camp Woodwind', '$CampWoodwind', 'pequeño', 1, '11', 1, 0, 1, 7, 13),
        ('Grafton Farmhouse', '$GraftonFarmhouse', 'pequeño', 2, '8-5', 2, 3, 1, 9, 4),
        ('Sunny Meadows Mental Institution (Restricted)', '$SunnyMeadowsMentalInstitutionRestricted', 'pequeño', 1, '17', 1, 0, 4, 6, 17),
        ('Maple Lodge Campsite', '$MapleLodgeCampsite', 'mediano', 1, '28', 1, 5, 2, 14, 13),
        ('Prison', '$Prison', 'mediano', 2, '12-19', 3, 16, 11, 4, 11),
        ('Brownstone High School', '$BrownstoneHighSchool', 'grande', 2, '34-30', 5, 8, 15, 0, 8),
        ('Sunny Meadows Mental Institution', '$SunnyMeadowsMentalInstitution', 'grande', 2, '44-22-3', 1, 22, 8, 28, 17);
    ";
    mysqli_query($conexion, $insertarMapas);

    $contraseña1 = password_hash('1', PASSWORD_DEFAULT);
    $contraseña2 = password_hash('2', PASSWORD_DEFAULT);
    //Insertar datos en tabla usuarios
    $insertarUsuarios = "INSERT INTO usuarios (nombre_usuario, correo, contrasena) VALUES
        ('1', '1@admin.com', '$contraseña1'),
        ('2', '2@admin.com', '$contraseña2');
    ";
    mysqli_query($conexion, $insertarUsuarios);

    $insertarVideos = "INSERT INTO videos (nombreVideo, idAutor, video) VALUES 
    ('Trailer de Xbox de phasmophobia', 1, '../video_area/videosMP4/video1.mp4'),
    ('Vas a flipar con este juegazo', 2, '../video_area/videosMP4/video2.mp4')
    ";
    mysqli_query($conexion, $insertarVideos);

    $insertarMeGusta = "INSERT INTO meGusta (idVideo, idUsuario) VALUES 
    (2, 1)
    ";
    mysqli_query($conexion, $insertarMeGusta);

    $insertarSuscripciones = "INSERT INTO suscripciones (idStreamer, idUsuario) VALUES 
    (2, 1)
    ";
    mysqli_query($conexion, $insertarSuscripciones);

    $insertarComentarios = "INSERT INTO comentarios (idVideo, idUsuario, comment) VALUES 
    (1, 2, 'Este video es el mejor que he visto!!!')
    ";
    mysqli_query($conexion, $insertarComentarios);
}
