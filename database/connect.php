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
        ('Espíritu', 50, '1.7', 'Los espíritus son fantasmas muy comunes. Son muy poderosos, pero pasivos: solo atacan cuando es necesario. Defienden el lugar donde murieron hasta la saciedad, matando a cualquiera que se quede más tiempo de lo necesario.\nDebilidad:Utilizar incienso cerca de ellos los parará temporalmente.', 'Información:\n- Usando incienso cerca del fantasma evitará que cace en 180s(3m) en vez de 90s de normal(1,5m).'),
        ('Espectro', 50, '1.7', 'Un espectro es un tipo de fantasma de los más peligrosos que puedes hallar. También es el único tipo de fantasma que puede volar y en ocasiones atravesar paredes.\nFortaleza: Casi nunca tocan el suelo, por lo que no dejan pisadas.\nDebilidad: Al entrar en contacto con la sal, les produce una reacción tóxica.', 'Información:\n- El fantasma nunca pisara la sal sin importar su tier.|- No se ralentizará por la sal de tier 3 durante una cacería.&Comportamiento:\n- Se puede hacer tp a un jugador aleatorio dejando como resultado EMF 2 o EMF 5.'),
        ('Ente', 50, '1.7', 'Un ente es un fantasma que puede poseer a los vivos, induciendo el miedo a quienes le rodean. Son comúnmente invocados a través de la güija.\nFortaleza: Mirarlo directamente descenderá tu cordura considerablemente rápido.\nDebilidad: Al sacarle una foto, desaparecerá temporalmente.', 'Información:\n- No se les ve en las fotografías.|- Al tomarle foto durante un evento o aparición en DOTs hará que el fantasma desaparezca al instante.|- Su parpadeo es más lento durante las cacerías (Comprobar la pestaña \'Guías\').&Comportamiento:\n- Puede seguir a un jugador random dejando como resultado EMF 2.'),
        ('Poltergeist', 50, '1.7', 'Uno de los fantasmas más famosos: el poltergeist. Conocido por manipular objetos a su alrededor para propagar el miedo en sus victimas.\nFortaleza: Puede lanzar múltiples objetos a la vez.\nDebilidad: Su poder no sirve de nada si no tiene objetos que lanzar.', 'Información:\n- Puede lanzar múltiples objetos a la vez reduciendo la cordura del jugador un 2% por cada objeto lanzado.|- Lanza o interactúa con los objetos cada 0.5s durante la cacería.&Comportamiento:\n- Mayor probabilidad de que lance o interactúe con objetos.|- Puede lanzar los objetos velozmente y más lejos que otros fantasmas.'),
        ('Banshee', 50, '1.7', 'Una banshee es una cazadora nata y atacará a cualquier cosa. Se la conoce por aislar a su presa antes de asestar el golpe fatal.\nFortaleza: Solo se fijará en una persona simultáneamente.\nDebilidad: Temen el crucifijo y serán menos agresivas cerca de uno.', 'Información:\n- Grita a través la parabólica.&Comportamiento:\n- Sólo irá tras una persona durante la cacería (a no ser que el objetivo esté fuera).|- Se mueve hacia su objetivo, dejando un EMF 2.|- Intentará moverse hacia su objetivo mientras esté en estado DOTs.|- Prefiere los eventos de cántico.&Cordura de ataque:\n- Atacará cuando la cordura de su objetivo esté en 50% o por debajo, lo que significa que puede cazar con un 87% de cordura promedio.'),
        ('Jinn', 50, '1.7 | 2.5', 'Un jinn es un fantasma territorial que atacará cuando se sienta amenazado. También se le conoce por desplazarse significativamente rápido.\nFortalezas: Un jinn acelerará su velocidad si su víctima está lejos de él.\nDebilidades: Apagar el cuadro eléctrico de la ubicación evitará que el jinn pueda usar sus habilidades.', 'Información:\n- Su habilidad reducirá la cordura de los jugadores cercanos en un 25%, dando lugar a un EMF 2 o 5 en la caja de fusibles (cuando está encendido).&Comportamiento:\n- No puede apagar la caja de fusibles.&Velocidad:\n- 2.5m/s cuando los fusibles están encendidos y el jugador se encuentra a más de 3m, 1.7m/s cuando está a menos de 3m.'),
        ('Pesadilla', 60, '1.7', 'Una pesadilla es la fuente de tus peores sueños, haciéndola así muy poderosa en la oscuridad.\nFortalezas: Una pesadilla podrá atacar muy frecuentemente si está todo a oscuras.\nDebilidades: Encender las luces cerca de una pesadilla reducirá sus posibilidades de atacar.', 'Información:\n- Habilidad de apagar inmediatamente el interruptor que encendió el jugador (Se puede probar solamente 1 vez cada 10s).|- No puede encender luces (teclados y televisiones sí).&Comportamiento:\n- Es más probable que se apaguen y se rompan las luces.|- Es más probable que deambule por una habitación donde las luces están apagadas.&Cordura de ataque:\n- 60% cuando las luces de su habitación están apagadas, 40% cuando están encendidas.'),
        ('Revenant', 50, '1.0 | 3.0', 'Un revenant es un fantasma violento que atacará indiscriminadamente. Su velocidad puede ser engañosa, ya que son lentos mientras están inactivos, sin embargo, tan pronto como cazan, pueden moverse increíblemente rápido.\nFortaleza : Viajará a una velocidad significativamente rápida cuando ataque a su presa.\nDebilidad : Esconderse de él hará que se mueva muy lentamente.', 'Velocidad:\n- 3.0m/s inmediatamente que detecta al jugador (equipamiento, voz, o línea de visión) hasta que el fantasma haya llegado a la última ubicación conocida del jugador, donde se reducirá gradualmente a 1 m/s.'),
        ('Sombra', 35, '1.7', 'Una sombra es conocida por ser muy tímida. Existe evidencia que confirma que una sombra detendrá su actividad paranormal si hay varias personas cerca.\nFortaleza: Son difíciles de encontrar.\nDebilidad: Este fantasma no atacará sí hay varias personas cerca.', 'Información:\n- Sus interacciones no darán como resultado EMF 2, 3 o 5 cuando alguien está en su habitación (excepto escritura o soplar una vela).|- No cazará con alguien en la misma habitación que el fantasma.&Comportamiento:\n- Más eventos cuando la cordura promedio está baja (No hace eventos al 100% de cordura promedio).|- Es menos probable que aparezca como sombra en los eventos, pero es más probable que aparezca el evento de bola.|- El único fantasma que tiene la posibilidad de aparecer como una sombra si se invoca desde una caja de música, mano de mono o un círculo de invocación.'),
        ('Demonio', 70, '1.7', 'Un demonio es uno de los peores fantasmas con los que te puedes topar. Se dice que atacan sin razón alguna.\nFortaleza: Iniciará ataques más a menudo que otros fantasmas.\nDebilidad: Si te responde por la güija, perderás menos cordura.', 'Información:\n- Usar incienso cerca del fantasma evitará que cace durante 60s en vez de 90s.|- Tiempo entre cacerías de 20s (tiempo normal 25s)&Comportamiento:\n- El crucifijo tiene un rango aumentado del 50% dependiendo del tier (T1: 4.5m. T2: 6m. T3: 7.5m).&Cordura de ataque:\n- Puede cazar a cualquier nivel de cordura, caza normalmente a partir del 70%'),
        ('Yurei', 50, '1.7', 'Un yurei es un tipo de fantasma que ha vuelto al plano físico, normalmente para cobrarse una venganza o manifestar su odio.\nFortaleza: Se dice que tienen una gran influencia en la cordura de las personas.\nDebilidad: Utilizar incienso en su habitación lo atrapará ahí temporalmente, reduciendo la frecuencia con la que deambula.', 'Información:\n- Puede cerrar una puerta por completo quitando a los jugadores cercanos un 15% de cordura si la puerta está en su habitación.|- Solo este fantasma puede cerrar o interactuar con la puerta principal de la casa fuera de una cacería o evento.&Comportamiento:\n- Usar incienso atrapará al fantasma en su habitación y evitará que merodee durante 60 segundos.'),
        ('Oni', 50, '1.7', 'Los oni comparten rasgos con los demonios y poseen una fuerza extrema. Algunos rumores apuntan a que se manifiestan más cuando están cerca de su presa.\nFortaleza: Son más activos cuando hay varias personas cerca y se les ha visto mover objetos a gran velocidad.\nDebilidad: Son muy activos, por lo que es más fácil encontrarlos.', 'Información:\n- Quita un 20% de cordura en los eventos, en vez de 10%.|- NO realiza eventos de orbes.|- Se le ve más durante las cacerías (Revisar pestaña \'Guías\').&Comportamiento:\n- Más activo con varias personas.|- Es más probable que se vea el fantasma en los eventos en lugar de la sombra.'),
        ('Yokai', 80, '1.7', 'Los yokai son fantasmas comunes que se sienten atraídos por las voces humanas. Se les puede encontrar atormentando casas familiares.\nFortaleza: Hablar cerca de él lo enfadará, incrementando las probabilidades de ataque.\nDebilidad: Cuando está atacando solo puede oír voces en sus proximidades.', 'Información:\n- No puede detectar la voz o aparatos electrónicos a más de 2,5m durante la cacería.&Comportamiento:\n- Más activo cuando se habla cerca del fantasma.&Cordura de caza:\n- Puede iniciar cacerías a partir del 80% de cordura cuando se habla cerca de él, si no al 50%.'),
        ('Hantu', 50, '1.44 - 2.7', 'Un hantu es un tipo de fantasma raro que se puede encontrar en climas cálidos. Se les conoce por atacar a menudo cuando hay clima frío.\nFortaleza: Se desplaza más rápido si hay temperaturas bajas.\nDebilidad: Se mueve más despacio en zonas con temperaturas calientes.', 'Información:\n- Se le puede ver vaho al fantasma en cualquier habitación durante la cacería si los fusibles están apagados.|- No puede encender los fusibles.&Comportamiento:\n- Alta probabilidad de que apague los fusibles.&Velocidad:\n- Veloz en temperaturas heladas. NO acelera en línea de visión.&Evidencia:\n- Temperaturas garantizadas en Pesadilla o Demencia.'),
        ('Goryo', 50, '1.7', 'Cuando un goryo pasa a través de un proyector DOTS, solo una cámara de video podrá verlo.\nFortaleza: Sólo se mostrará ante la cámara de video si no hay nadie cerca.\nDebilidad: Rara vez se les ve lejos del lugar donde murieron.', 'Información:\n- Sólo se le puede ver en el DOTs a través de una cámara de video y fuera de su habitación o desde el camión.&Comportamiento:\n- No puede cambiar su habitación favorita.|- No sale de su habitación muy a menudo.&Evidencia:\n- DOTs garantizados en Pesadilla o Demencia.'),
        ('Myling', 50, '1.7', 'Un myling es un fantasma muy activo y sonoro. Se rumorea que es silencioso cuando ataca a sus presas.\nFortaleza: Cuando ataca, suele ser sigiloso.\nDebilidad: Hacen ruido paranormal más frecuentemente.', 'Información:\n- No se le puede escuchar (pasos ni voz) a más de 12m durante las cacerías (de normal a 20m).&Comportamiento:\n- Muchos sonidos paranormales a través del micrófono parabólico.'),
        ('Onryo', 60, '1.7', 'El onryo suele ser conocido como \"el espíritu furioso\". Roba las almas de los cuerpos de sus víctimas en búsqueda de venganza. Se conoce que este fantasma teme a cualquier tipo de fuego, y hará lo imposible para estar lejos de él.\nFortaleza: Apagar una llama puede provocar que el onryo ataque.\nDebilidad: Si se siente amenazado, atacará con menos frecuencia.', 'Información:\n- Cazará con cualquier cordura después de apagar cada tercera llama si ninguna otra llama o crucifijo lo impide.&Comportamiento:\n- Las llamas actúan como crucifijos, apagará una llama si intenta cazar (a menos de 4 m).|- Más probable que apague llamas cuantos más jugadores muertos hay.&Cordura de ataque:\n- Puede cazar a cualquier nivel de cordura usando su habilidad, de normal a partir del 60%.'),
        ('Gemelos', 50, '1.53 | 1.87', 'Hay reportes que indican que estos fantasmas imitan las acciones del otro. Alternan sus ataques para confundir a su presa.\nFortaleza: Cada uno de los gemelos puede enfadarse e iniciar un ataque sobre su presa.\nDebilidad: Suelen interactuar con el entorno al mismo tiempo.', 'Información:\n- A menudo realizan interacciones al mismo tiempo (en una ubicación real y en una ubicación falsa).&Comportamiento:\n- Solo activa sensores de movimiento, pisa sal y da spirit box en su ubicación real.&Velocidad:\n- 1.53m/s cuando caza desde la ubicación real, 1.87m/s cuando caza desde la ubicación falsa.'),
        ('Raiju', 65, '1.7 | 2.5', 'Un raiju es un demonio que se nutre de la corriente eléctrica. Normalmente es tranquilo, pero se puede descontrolar si absorbe demasiado poder.\nFortaleza: Obtiene su poder de los dispositivos eléctricos cercanos, haciendo que se mueva más rápido.\nDebilidad: Debido a que siempre interfiere con los aparatos electrónicos, es fácil de rastrear cuando ataca.', 'Información:\n- Durante una cacería los objetos electrónicos empiezan a parpadear a los 15m en vez de los 10m.&Cordura de ataque:\n- Puede atacar a partir de 65% de cordura cuando hay jugadores cerca con equipos electrónicos.&Velocidad:\n- 2.5m/s cerca de objetos electrónicos activos, 1.7m/s si no hay objetos electrónicos.'),
        ('Obake', 50, '1.7', 'Los obake son cambiaformas terroríficos, y por ello son capaces de adquirir muchas apariencias. Han sido vistos adoptando forma humanoide para atraer a su presa.\nFortaleza: Cuando interactúan con el entorno, rara vez dejarán rastro.\nDebilidad: A veces cambiarán de forma, revelando así pruebas indispensables.', 'Información:\n- Deja una huella especial de 6 dedos (Ver pestaña \'Guías\').|- Tiene un 6.6% de probabilidad de cambiar el modelo del fantasma cuando parpadea durante la cacería (garantizada 1 por cacería).|- Tiene un 25% de probabilidad de no dejar la evidencia de ultravioleta.|- Puede hacer que las huellas desaparezcan el doble de rápido cuando usa su habilidad.&Evidencia:\n- Ultravioleta garantizada en Pesadilla y Demencia.'),
        ('Mímico', 50, '1.7', 'El mímico es un fantasma elusivo, misterioso e imitador que copia los rasgos y comportamientos de los demás, incluyendo otros tipos de fantasma.\nFortaleza: No estamos seguros de lo que es capaz. Ten cuidado.\nDebilidad: Muchos reportes indican orbes espectrales cerca de ellos.', 'Información:\n- Siempre muestra orbes espectrales como una prueba falsa (4 evidencias) incluso con 0 evidencias.|- Copia el comportamiento y las propiedades de otros fantasmas.|- Cambia el tipo de fantasma copiado cada 30s a 2m.&Cordura de ataque:\n- Copia el comportamiento del fantasma actualmente imitado.&Velocidad:\n- Copia la velocidad del fantasma actualmente imitado.'),
        ('Moroi', 50, '1.5 - 2.25 (3.71)', ' Los moroi emergen de sus tumbas para robar la energía de los vivos. Se dice que maldicen a sus víctimas, quienes sólo podrán liberarse de su maldición a través de antídotos o mudándose muy lejos.\nFortaleza: Cuanto más débil sea su víctima, más fuerte será el moroi.\nDebilidad: Los moroi padecen hiperosmia, lo cual los debilita durante un buen rato.', 'Información:\n- Pone una maldición al jugador cuando escucha al fantasma a través del micrófono parabólico o en la Spirit Box causando que la cordura se reduzca x2 veces más rápido.|- El incienso hace que el efecto de ceguera del fantasma se aumente un 50% (7.5s en lugar de 5s).&Velocidad:\n- Muy rápido cuando el promedio de cordura es bajo, puede alcanzar una velocidad de 3.71 m/s cuando te tiene en la línea de visión.|- Reducirá su velocidad si durante la cacería se usa medicación para la cordura.&Evidencia:\n- Spirit Box garantizada en Pesadilla o Demencia.'),
        ('Deogen', 40, '0.4 | 3.0', 'En ocasiones envueltos por una niebla eterna, los deogen llevan evadiendo a los cazadores de fantasmas durante años.\n Hay reportes que acusan a estos fantasmas de haber encontrado incluso a las presas más ocultas, justo antes de acecharles hasta la extenuación.\nFortaleza: Perciben a los vivos constantemente. Podrás huir, pero no podrás esconderte.\nDebilidad: Utilizan mucha energía para manifestarse, haciendo que se desplacen muy despacio al estar cerca de sus víctimas.', 'Información:\n- Respiración pesada a través de la Spirit Box cuando se usa a 1m del fantasma.|- No te puedes esconder del fantasma, tienes que loopearlo.&Velocidad:\n- 3.0m/s cuando está lejos, 0.4m/s cuando está cerca del jugador.&Evidencia:\n- Spirit Box garantizado en Pesadilla o Demencia.'),
        ('Thaye', 75, '1.0 - 2.75', 'Se dice que los thaye envejecen muy rápido, incluso en el más allá. Por lo que sabemos, parece que empeoran más rápido si hay vivos cerca de ellos.\nFortaleza: Conforme entres en la ubicación, se volverán activos, defensivos y ágiles.\nDebilidades: Se debilitan con el tiempo, tornándose más vulnerables, más lentos y menos agresivos.', 'Comportamiento:\n- Envejece cuando el jugador está en la habitación del fantasma o cerca del fantasma (cada 1-2 minutos).|- Más activo cuando es joven.|- Preguntar por su edad en la Ouija hará que envejezca.&Cordura de ataque:\n- Puede cazar a partir de 75% cuando es joven, 15% cuando es viejo.&Velocidad:\n- 2.75m/s cuando es joven, 1.0m/s cuando es viejo No aumenta su velocidad cuando está en línea de visión.');
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
        (3,24),
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
        ('Proyector D.O.T.S.', 1, 'UN PEQUEÑO PUNTERO LÁSER QUE PROYECTA PEQUEÑOS RAYOS DE LUZ EN EL ENTORNO. SE PUEDE COLOCAR.', 0, 0, 65, 2, 'N', 'electrico'),
        ('Proyector D.O.T.S.', 2, 'ESTE SENSOR DE MOVIMIENTO INFRARROJO FUE AMPLIABLEMENTE ADAPTADO PARA PROYECTAR LUZ. ES PEQUEÑO, COMPACTO Y SE ADHIERE A LA MAYORÍA DE SUPERFICIES.', 29, 3000, 65, 2, 'N', 'electrico'),
        ('Proyector D.O.T.S.', 3, 'UN PROYECTOR MOTORIZADO CON TRES LENTES QUE CUBREN UN AMPLIO RANGO LUMÍNICO. SE PUEDE COLOCAR EN PAREDES Y ALGUNOS TECHOS.', 60, 3000, 65, 2, 'N', 'electrico'),
        ('Medidor EMF', 1, 'UN MEDIDOR EMF CON VARIOS MODOS PARA ANALIZAR LAS DISTINTAS INTERFERENCIAS DEL AIRE. SI LA AGUJA EMPIEZA A MOVERSE. SI EL FANTASMA TUVIERA ESTA PRUEBA, LLEGARA LA AGUJA AL NIVEL 5.', 0, 0, 45, 2, 'N', 'electrico'),
        ('Medidor EMF', 2, 'EL MEDIDOR K2 TIENE MAS RANGO Y 5 LUCES LED QUE MUESTRAN LECTURAS EMF, ADEMÁS DE UN MODULO ADICIONAL CON ALTAVOZ.', 20, 3000, 45, 2, 'N', 'electrico'),
        ('Medidor EMF', 3, 'LECTOR EMF CON PANTALLA, MUESTRA PRIMERO EL EMF QUE EMITE EL OBJETO, EL RNA(LA DISTANCIA DONDE ESTA EL OBJETO) Y LA DIR(UNAS FLECHAS QUE INDICAN EN QUE DIRECCIÓN ESTA EL OBJETO QUE TIENE EMF).', 52, 4500, 45, 2, 'N', 'electrico'),
        ('Linterna', 1, 'LINTERNA CON UNA PEQUEÑA LUZ.', 0, 0, 30, 4, 'N', 'electrico'),
        ('Linterna', 2, 'EMITE UN FOCO DE LUZ MÁS BRILLANTE.', 19, 3000, 30, 4, 'N', 'electrico'),
        ('Linterna', 3, 'LINTERNA CON LUZ MUY POTENTE.', 35, 2500, 30, 4, 'N', 'electrico'),
        ('Libro de escritura fantasma', 1, 'CUADERNO DE ESCRITURA PEQUEÑO, CON POCO ALCANCE Y SERÁ COMPLICADO QUE EL FANTASMA DE LA PRUEBA. SI EL FANTASMA NO TUVIESE ESTA PRUEBA LANZARIA EL LIBRO POR LOS AIRES, ES MUY ÚTIL PARA DESCARTAR TODOS LOS FANTASMAS SIN ESCRITURA SI LO LLEGA A LAZAR.', 0, 0, 40, 2, 'N', 'ninguno'),
        ('Libro de escritura fantasma', 2, 'MEJORES PÁGINAS Y BOLÍGRAFO, LOS FANTASMAS SE FIJAN MÁS HACIENDO QUE LOS TIEMPOS SEAN ALGO INFERIORES PARA OBTENER LA PRUEBA. SI EL FANTASMA NO TUVIESE ESTA PRUEBA LANZARIA EL LIBRO POR LOS AIRES, ES MUY ÚTIL PARA DESCARTAR TODOS LOS FANTASMAS SIN ESCRITURA SI LO LLEGA A LAZAR.', 23, 3000, 40, 2, 'N', 'ninguno'),
        ('Libro de escritura fantasma', 3, 'GRIMORIO DE GRAN TAMAÑO DONDE TIENE UN ALCANCE MUCHO MAYOR Y DA CON MAS FACILIDAD LA ESCRITURA. SI EL FANTASMA NO TUVIESE ESTA PRUEBA LANZARIA EL LIBRO POR LOS AIRES, ES MUY ÚTIL PARA DESCARTAR TODOS LOS FANTASMAS SIN ESCRITURA SI LO LLEGA A LAZAR.', 63, 3000, 40, 2, 'N', 'ninguno'),
        ('Spirit Box', 1, 'PEQUEÑA RADIO COMPACTA Y ANTIGUA. TARDA EN DAR RESULTADOS Y SU ALTAVOZ NO TIENE MUCHA CALIDAD. SI EL FANTASMA TUVIERA ESTA PRUEBA, SE PONDRÁ EN BLANCA LA LUZ DEL FANTASMA.', 0, 0, 50, 2, 'N', 'electrico'),
        ('Spirit Box', 2, 'ALTAVOZ DE ALTA CALIDAD Y MÁS EFICIENTE AL ESCANEAR ENTRE DISTINTAS FRECUENCIAS LOGRANDO QUE LAS RESPUESTAS SEAN MÁS FÁCILES DE DESCIFRAR.', 27, 3000, 50, 2, 'N', 'electrico'),
        ('Spirit Box', 3, 'ALTAVOZ DE ALTA CALIDAD Y MÁS EFICIENTE AL ESCANEAR ENTRE DISTINTAS FRECUENCIAS LOGRANDO QUE LAS RESPUESTAS SEAN MÁS FÁCILES DE DESCIFRAR.', 54, 3000, 50, 2, 'N', 'electrico'),
        ('Termómetro', 1, 'TERMÓMETRO DE PARED QUE SIRVE PARA MEDIR LA TEMPERATURA DE UNA HABITACIÓN, TARDA BASTANTE TIEMPO EN DAR LAS TEMPERATURAS EXACTAS. SI EL FANTASMA TUVIERA ESTA PRUEBA, VERAS EL INDICADOR DEBAJO DEL CERO.', 0, 0, 30, 2, 'N', 'ninguno'),
        ('Termómetro', 2, 'TERMÓMETRO DIGITAL MUCHO MÁS RÁPIDO LEYENDO TEMPERATURAS.', 36, 3000, 30, 2, 'N', 'ninguno'),
        ('Termómetro', 3, 'TERMÓMETRO DIGITAL MUCHO MÁS RÁPIDO LEYENDO TEMPERATURAS. DEJAR PULSADO EL CLIC DERECHO PARA OBTENER LECTURA DE TEMPERATURA.', 64, 3000, 30, 2, 'N', 'electrico'),
        ('Linterna ultravioleta', 1, 'BARRA LUMINOSA DE DURACIÓN 60 SEGUNDOS (LUZ FUERTE) PASADO 10 SEGUNDOS QUE SE VAYA SU POTENCIA, SE AGITA (CLIC DERECHO) Y SE REACTIVA.', 0, 0, 20, 2, 'N', 'ninguno'),
        ('Linterna ultravioleta', 2, 'EMITE UN RATO DE LUZ DE LARGA DISTANCIA PERO ESTRECHO SIENDO PERFECTA PARA BUSCAR HUELLAS DACTILARES Y PISADAS. RECARGA DACTILOGRAMAS ULTRAVIOLETAS MÁS RÁPIDO QUE LA BARRA LUMINOSA.', 21, 3000, 20, 2, 'N', 'electrico'),
        ('Linterna ultravioleta', 3, 'EMITE UN RATO DE LUZ DE LARGA DISTANCIA CON MUCHA AMPLITUD DE LUZ SIENDO PERFECTA PARA BUSCAR HUELLAS DACTILARES Y PISADAS. RECARGA DACTILOGRAMAS ULTRAVIOLETAS MÁS RÁPIDO QUE SUS ANTECESORAS.', 56, 2000, 20, 2, 'N', 'electrico'),
        ('Cámara de vídeo', 1, 'CÁMARA DE VIDEO ANTIGUA PERO SE PUEDE VER ORBES SIN PROBLEMA. INTERFERENCIA ALTAS EN ATAQUE. SE PUEDEN VISUALIZAR ORBES CON ELLA.', 0, 0, 50, 4, 'N', 'electrico'),
        ('Cámara de vídeo', 2, 'MEJOR CALIDAD DE IMAGEN, MEJOR VISIÓN NOCTURNA Y MAS RESISTENCIA CONTRA LA INTERFERENCIA PARANORMAL. SE PUEDEN VISUALIZAR ORBES CON ELLA.', 33, 3000, 50, 4, 'N', 'electrico'),
        ('Cámara de vídeo', 3, 'LA MEJOR CALIDAD DE IMAGEN, MAS AMPLIA, MEJOR VISIÓN NOCTURNA Y MAS RESISTENCIA CONTRA LA INTERFERENCIA PARANORMAL. SE PUEDEN VISUALIZAR ORBES CON ELLA.', 61, 3000, 50, 4, 'N', 'electrico'),
        ('Crucifijo', 1, 'SOLO SIRVE PARA EVITAR 1 ATAQUE Y SU ALCANCE ES BAJO.', 8, 0, 30, 2, 'S', 'consumible'),
        ('Crucifijo', 2, 'CRUCIFIJO DE METAL QUE PUEDE BLOQUEAR HASTA DOS ATAQUES, MAYOR RANGO DE ACCIÓN.', 37, 4000, 30, 2, 'S', 'consumible'),
        ('Crucifijo', 3, 'CRUCIFIJO DE METAL QUE PUEDE BLOQUEAR HASTA DOS ATAQUES, O UN SOLO ATAQUE MALDITO. MAYOR RANGO DE ACCIÓN QUE SUS ANTECESORES.', 90, 20000, 30, 2, 'S', 'consumible'),
        ('Lumbre', 1, 'PEQUEÑA, CON UNA DURACIÓN DE 3 MINUTOS Y REDUCE EN UN 33% LA CORDURA QUE PERDEMOS.', 12, 0, 15, 4, 'S', 'consumible'),
        ('Lumbre', 2, 'CANDELABRO CON TRES VELAS CON UNA DURACIÓN DE 5 MINUTOS Y REDUCE EN UN 50% LA CORDURA QUE PERDEMOS. CUBRE CORDURA INCLUSO POSICIONANDOLA CERCA SIN TENER QUE TENERLA EN LA MANO.', 47, 3000, 15, 4, 'S', 'consumible'),
        ('Lumbre', 3, 'FAROL DE ACEITE CON UNA DURACIÓN DE 10 MINUTOS(SE APAGARÍA Y SE PODRIA VOLVER A ENCEDER) Y REDUCE EN UN 66% LA CORDURA QUE PERDEMOS. CUBRE CORDURA INCLUSO POSICIONANDOLA CERCA SIN TENER QUE TENERLA EN LA MANO.', 79, 10000, 15, 4, 'S', 'consumible'),
        ('Equipamiento para la cabeza', 1, 'CÁMARA EN LA CABEZA QUE SE PUEDE OBSERVAR DESDE EL CAMIÓN PARA VER ORBES.', 13, 0, 60, 4, 'S', 'electrico'),
        ('Equipamiento para la cabeza', 2, 'EQUIPAMIENTO DE CABEZA QUE APORTA UNA BRILLANTE LUZ PARA ENCENDERLO DEJAR PULSADO LA LETRA T.', 49, 10000, 60, 4, 'S', 'electrico'),
        ('Equipamiento para la cabeza', 3, 'LUZ INFLAROJA QUE PERMITE VER PERFECTAMENTE EN LA OSCURIDAD PARA ENCENDERLO DEJAR PULSADO LA LETRA T.', 82, 10000, 60, 4, 'S', 'electrico'),
        ('Encendedor', 1, 'CAJA DE 10 CERILLAS QUE CADA UNA TIENE UNA DURACIÓN DE 10 SEGUNDOS.', 12, 0, 10, 4, 'S', 'consumible'),
        ('Encendedor', 2, 'MECHERO DE GAS CON UNA DURACIÓN DE 5 MINUTOS.', 41, 500, 10, 4, 'S', 'consumible'),
        ('Encendedor', 3, 'MECHERO DE GAS CON UNA DURACIÓN DE 10 MINUTOS (SE APAGA A LOS 10 MINUTOS Y DEJARA DE SER ÚTIL).', 57, 750, 10, 4, 'S', 'ninguno'),
        ('Incienso', 1, 'INCIENSO CON EL QUE SE PUEDE HACER DESORIENTAR AL FANTASMAS 5 SEGUNDOS EN UN RADIO DE 3 METROS.', 14, 0, 15, 4, 'S', 'consumible'),
        ('Incienso', 2, 'ESTA VERSIÓN AUMENTA EL RANGO Y LA DURACIÓN DE LA CREMACIÓN. ADEMÁS DURANTE EL ATAQUE RALENTIZA AL FANTASMA DURANTE 5 SEGUNDOS.', 42, 3500, 15, 4, 'S', 'consumible'),
        ('Incienso', 3, 'ESTA VERSIÓN AUMENTA EL RANGO Y LA DURACIÓN DE LA CREMACIÓN. ADEMÁS DURANTE EL ATAQUE PARA EN EL SITIO AL FANTASMA DURANTE 5 SEGUNDOS (EL FANTASMA SIGUE TENIENDO VISION DE TI, AUMENTARA SU VELOCIDAD Y PODRA VER A DONDE FUISTE A ESCONDER).', 85, 15000, 15, 4, 'S', 'ninguno'),
        ('Sensor de movimiento', 1, 'SENSOR QUE EMITE LUZ AL PASAR EL FANTASMA. SE ADHIERE A PAREDES O SUELO.', 5, 0, 100, 4, 'S', 'electrico'),
        ('Sensor de movimiento', 2, 'ESTA VERSIÓN ES CONFIGURABLE PARA DETECTAR AL FANTASMA EN FORMA LINEAL O CÓNICA.', 45, 2500, 100, 4, 'S', 'electrico'),
        ('Sensor de movimiento', 3, 'ESTA VERSIÓN ES SEMIESFERICA Y TIENE VISION 360º. SOLO DETECTA AL FANTASMA, TIENE UN SONIDO CARACTERISTICO DE DECTECCION Y UNA LUZ BLANCA INDICANDO LA DIRECCION DE DONDE SE MOVIO EL FANTASMA.', 74, 8000, 100, 4, 'S', 'electrico'),
        ('Micrófono parabólico', 1, 'PARA ESCUCHAR SONIDOS LEJANOS, SE ENSORDECE TODO LO DEMÁS PARA ESCUCHAR MEJOR AL FANTASMA.', 7, 0, 50, 2, 'S', 'electrico'),
        ('Micrófono parabólico', 2, 'AUMENTA EL RANGO DE DETECCIÓN E INCLUYE UNA PANTALLA PARA TENER LECTURAS VISUALES DE CUÁN FUERTES SON LOS SONIDOS. ALCANCE 30 METROS.', 31, 3000, 50, 2, 'S', 'electrico'),
        ('Micrófono parabólico', 3, 'AUMENTA EL RANGO DE DETECCIÓN E INCLUYE UNA PANTALLA PARA TENER LECTURAS VISUALES DE CUÁN FUERTES SON LOS SONIDOS Y POR DONDE SE MUEVE EXACTAMENTE. COMO CURIOSIDAD SI LO DEJAS EN EL SUELO ENFOCANDO LA HABITAICIÓN ES POSIBLE QUE TE DE SOLO EL SENSOR DE SONIDO COMO PRUEBA SECUNDARIA. ALCANCE 30 METROS.', 72, 5000, 50, 2, 'S', 'electrico'),
        ('Cámara de fotos', 1, 'CÁMARA POLAROID TARDA MUCHO MAS EN SACAR FOTOS DE SEGUIDO Y NO ES ELECTRÓNICA.', 3, 0, 40, 3, 'S', 'ninguno'),
        ('Cámara de fotos', 2, 'REDUCE EL TIEMPO ENTRE CAPTURAS E INCLUYE UNA PANTALLA PARA VISUALIZAR. LA PANTALLA SUFRIRÁ INTERFERENCIA DURANTE ATAQUES O APARICIONES.', 25, 3000, 40, 3, 'S', 'electrico'),
        ('Cámara de fotos', 3, 'EL TIEMPO ENTRE CAPTURAS ES MÍNIMO E INCLUYE UNA PANTALLA PARA VISUALIZAR. LA PANTALLA SUFRIRÁ INTERFERENCIA DURANTE ATAQUES O APARICIONES.', 70, 5000, 40, 3, 'S', 'electrico'),
        ('Sal', 1, 'SAL QUE SE PUEDE UTILIZAR FUERA DE ATAQUE PARA QUE PISE EL FANTASMA Y PUEDA DEJAR LA EVIDENCIA ULTRAVIOLETA (TIENE 2 USOS).', 9, 0, 15, 3, 'S', 'consumible'),
        ('Sal', 2, 'ESTA VERSIÓN CONTIENE MÁS SAL Y SE PUEDE ESPARCIR EN LARGAS LÍNEAS DE SAL PARA BLOQUEAR PASILLOS MÁS ANCHOS (TIENE 3 USOS). EL FANTASMA LA PISA EN ATAQUE Y FUERA DE ATAQUE.', 43, 2500, 15, 3, 'S', 'consumible'),
        ('Sal', 3, 'ESTA VERSIÓN CONTIENE MÁS SAL Y SE PUEDE ESPARCIR EN LARGAS LÍNEAS DE SAL PARA BLOQUEAR PASILLOS MÁS ANCHOS. (TIENE 3 USOS) COMO CURIOSIDAD PUEDES PONER TODOS MONTONES JUNTOS, EL FANTASMA AL PISAR UNA LAS PISA TODAS Y PODRIAS HACER 9 FOTOS DE 3 ESTRELLAS EN POCO TIEMPO. SI EL FANTAMA LA PISA FUERA DE ATAQUE, LE HARIA VOLVER DE DONDE VINO. SI LA PISA EN CACERIA SE RALENTIZA 2 SEGUNDOS.', 68, 5000, 15, 3, 'S', 'consumible'),
        ('Medicación para la cordura', 1, 'BOTELLA CON ACEITE DE SERPIENTE QUE RESTAURA LA CORDURA LENTAMENTE.', 16, 0, 20, 4, 'S', 'consumible'),
        ('Medicación para la cordura', 2, 'PERMITE RECUPERAR LA CORDURA MÁS RÁPIDO.', 39, 2000, 20, 4, 'S', 'consumible'),
        ('Medicación para la cordura', 3, 'PERMITE RECUPERAR LA CORDURA MÁS RÁPIDO Y DURANTE 10 SEGUNDOS NO SE TE AGOTA EL SPRINT. SI NO TIENES SPRINT NO TE LO DARIA, TENDRIAS QUE TENERLO SIN GASTAR PARA QUE SEA ILIMITADO 10 SEGUNDOS.', 77, 5000, 20, 4, 'S', 'consumible'),
        ('Sensor de sonido', 1, 'SENSOR DE SONIDO QUE PUEDES ESCUCHAR DESDE EL CAMIÓN.', 11, 0, 80, 4, 'S', 'electrico'),
        ('Sensor de sonido', 2, 'ESTÁ VERSIÓN DEL SENSOR PUEDE ADAPTARSE A TRES TIPOS DE TAMAÑO (5, 10 Y 15 METROS). SE PUEDE ACTIVAR O DESACTIVAR DESDE LA PANTALLA DEL CAMIÓN.', 32, 3000, 80, 4, 'S', 'electrico'),
        ('Sensor de sonido', 3, 'ESTÁ VERSIÓN DEL SENSOR PUEDE ADAPTARSE A TRES TIPOS DE TAMAÑO (5, 10 Y 15 METROS). SE PUEDE ACTIVAR O DESACTIVAR DESDE LA PANTALLA DEL CAMIÓN.', 58, 1500, 80, 4, 'S', 'electrico'),
        ('Trípode', 1, 'PARA COLOCAL UNA CÁMARA DE VIDEO A EL Y QUE SE PUEDA VER MEJOR LA ZONA. LOS FANTASMA PUEDEN INTERACTUAR CON EL Y TUMBARLO.', 10, 0, 25, 4, 'S', 'ninguno'),
        ('Trípode', 2, 'ESTA VERSIÓN INCLUYE UN MOTOR ROTACIONAL LO QUE PERMITE AJUSTA LA VISIÓN DESDE LA PANTALLA QUE HAY EN EL CAMIÓN.', 34, 5000, 25, 4, 'S', 'ninguno'),
        ('Trípode', 3, 'ESTA VERSIÓN INCLUYE UN MOTOR ROTACIONAL LO QUE PERMITE AJUSTA LA VISIÓN DESDE LA PANTALLA QUE HAY EN EL CAMIÓN. TIENE MENOS POSIBILIDAD EL FANTASMA DE MOVERLO.', 62, 3000, 25, 4, 'S', 'ninguno');
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
    //Insertar datos en tabla usuarios
    $insertarUsuarios = "INSERT INTO usuarios (nombre_usuario, correo, contrasena) VALUES
        ('1', '1@admin.com', '$contraseña1');
    ";
    mysqli_query($conexion, $insertarUsuarios);
}
