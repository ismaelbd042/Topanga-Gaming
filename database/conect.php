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
        extras TEXT
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
        precio_desbloqueo INT,
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
        habitaciones INT,
        salidas INT,
        grifos INT,
        camaras INT,
        escondites INT
        )";
    mysqli_query($conexion, $sqlMapas);
}

function insertarDatos($conexion)
{
    // Insertar datos de ejemplo
    $insertarPruebas = "INSERT INTO pruebas (nombre, extra) VALUES 
        ('Medidor EMF 5', 'Nivel máximo de lecturas de EMF'),
        ('Orbes Espectrales', 'Apariciones visuales de orbes'),
        ('Temperaturas Heladas', 'Temperaturas muy bajas cerca'),
        ('Escritura Fantasmal', 'Escritura en el libro de actividad'),
        ('Spirit Box', 'Respuestas a preguntas a través del dispositivo de caja de voz (Spirit Box)'),
        ('Proyector D.O.T.S.', 'Silueta del fantasma vista a través del proyector'),
        ('Ultravioleta', 'Impresiones de las manos visibles en superficies');
    ";
    mysqli_query($conexion, $insertarPruebas);
    // cordura, velocidad y extra estan sacados de 'https://tybayn.github.io/phasmo-cheat-sheet-es/'
    // y la descripción es la que pone en el libro del juego
    $insertarFantasmas = "INSERT INTO fantasmas (nombre, cordura, velocidad, descripcion, extra) VALUES 
        ('Espíritu', 50, '1.7', 'Los espíritus son fantasmas muy comunes. Son muy poderosos, pero pasivos: solo atacan cuando es necesario. Defienden el lugar donde murieron hasta la saciedad, matando a cualquiera que se quede más tiempo de lo necesario.\nDebilidad:Utilizar incienso cerca de ellos los parará temporalmente.', 'Información:\n- Usando incienso cerca del fantasma evitará que cace en 180s(3m) en vez de 90s de normal(1,5m).'),
        ('Espectro', 50, '1.7', 'Un espectro es un tipo de fantasma de los más peligrosos que puedes hallar. También es el único tipo de fantasma que puede volar y en ocasiones atravesar paredes.\nFortaleza: Casi nunca tocan el suelo, por lo que no dejan pisadas.\nDebilidad: Al entrar en contacto con la sal, les produce una reacción tóxica.', 'Información:\n- El fantasma nunca pisara la sal sin importar su tier.|- No se ralentizará por la sal de tier 3 durante una cacería.&Comportamiento:\n- Se puede hacer tp a un jugador aleatorio dejando como resultado EMF 2 o EMF 5.'),
        ('Ente', 50, '1.7', 'Un ente es un fantasma que puede poseer a los vivos, induciendo el miedo a quienes le rodean. Son comúnmente invocados a través de la güija.\nFortaleza: Mirarlo directamente descenderá tu cordura considerablemente rápido.\nDebilidad: Al sacarle una foto, desaparecerá temporalmente.', 'Información:\n- No se les ve en las fotografías.|- Al tomarle foto durante un evento o aparición en DOTs hará que el fantasma desaparezca al instante.|- Su parpadeo es más lento durante las cacerías (Comprobar la pestaña 'Guías').&Comportamiento:\n- Puede seguir a un jugador random dejando como resultado EMF 2.'),
        ('Poltergeist', 50, '1.7', 'Uno de los fantasmas más famosos: el poltergeist. Conocido por manipular objetos a su alrededor para propagar el miedo en sus victimas.\nFortaleza: Puede lanzar múltiples objetos a la vez.\nDebilidad: Su poder no sirve de nada si no tiene objetos que lanzar.', 'Información:\n- Puede lanzar múltiples objetos a la vez reduciendo la cordura del jugador un 2% por cada objeto lanzado.|- Lanza o interactúa con los objetos cada 0.5s durante la cacería.&Comportamiento:\n- Mayor probabilidad de que lance o interactúe con objetos.|- Puede lanzar los objetos velozmente y más lejos que otros fantasmas.'),
        ('Banshee', 50, '1.7', 'Una banshee es una cazadora nata y atacará a cualquier cosa. Se la conoce por aislar a su presa antes de asestar el golpe fatal.\nFortaleza: Solo se fijará en una persona simultáneamente.\nDebilidad: Temen el crucifijo y serán menos agresivas cerca de uno.', 'Información:\n- Grita a través la parabólica.&Comportamiento:\n- Sólo irá tras una persona durante la cacería (a no ser que el objetivo esté fuera).|- Se mueve hacia su objetivo, dejando un EMF 2.|- Intentará moverse hacia su objetivo mientras esté en estado DOTs.|- Prefiere los eventos de cántico.&Cordura de ataque:\n- Atacará cuando la cordura de su objetivo esté en 50% o por debajo, lo que significa que puede cazar con un 87% de cordura promedio.'),
        ('Jinn', 50, '1.7 | 2.5', 'Un jinn es un fantasma territorial que atacará cuando se sienta amenazado. También se le conoce por desplazarse significativamente rápido.\nFortalezas: Un jinn acelerará su velocidad si su víctima está lejos de él.\nDebilidades: Apagar el cuadro eléctrico de la ubicación evitará que el jinn pueda usar sus habilidades.', 'Información:\n- Su habilidad reducirá la cordura de los jugadores cercanos en un 25%, dando lugar a un EMF 2 o 5 en la caja de fusibles (cuando está encendido).&Comportamiento:\n- No puede apagar la caja de fusibles.&Velocidad:\n- 2.5m/s cuando los fusibles están encendidos y el jugador se encuentra a más de 3m, 1.7m/s cuando está a menos de 3m.'),
        ('Pesadilla', 60, '1.7', 'Una pesadilla es la fuente de tus peores sueños, haciéndola así muy poderosa en la oscuridad.\nFortalezas: Una pesadilla podrá atacar muy frecuentemente si está todo a oscuras.\nDebilidades: Encender las luces cerca de una pesadilla reducirá sus posibilidades de atacar.', 'Información:\n- Habilidad de apagar inmediatamente el interruptor que encendió el jugador (Se puede probar solamente 1 vez cada 10s).|- No puede encender luces (teclados y televisiones sí).&Comportamiento:\n- Es más probable que se apaguen y se rompan las luces.|- Es más probable que deambule por una habitación donde las luces están apagadas.&Cordura de ataque:\n- 60% cuando las luces de su habitación están apagadas, 40% cuando están encendidas.'),
        ('Revenant', 50, '1.0 | 3.0', 'Un revenant es un fantasma violento que atacará indiscriminadamente. Su velocidad puede ser engañosa, ya que son lentos mientras están inactivos, sin embargo, tan pronto como cazan, pueden moverse increíblemente rápido.\nFortaleza : Viajará a una velocidad significativamente rápida cuando ataque a su presa.\nDebilidad : Esconderse de él hará que se mueva muy lentamente.', 'Velocidad:\n- 3.0m/s inmediatamente que detecta al jugador (equipamiento, voz, o línea de visión) hasta que el fantasma haya llegado a la última ubicación conocida del jugador, donde se reducirá gradualmente a 1 m/s.'),
        ('Sombra', 35, '1.7', 'Una sombra es conocida por ser muy tímida. Existe evidencia que confirma que una sombra detendrá su actividad paranormal si hay varias personas cerca.\nFortaleza: Son difíciles de encontrar.\nDebilidad: Este fantasma no atacará sí hay varias personas cerca.', 'Información:\n- Sus interacciones no darán como resultado EMF 2, 3 o 5 cuando alguien está en su habitación (excepto escritura o soplar una vela).|- No cazará con alguien en la misma habitación que el fantasma.&Comportamiento:\n- Más eventos cuando la cordura promedio está baja (No hace eventos al 100% de cordura promedio).|- Es menos probable que aparezca como sombra en los eventos, pero es más probable que aparezca el evento de bola.|- El único fantasma que tiene la posibilidad de aparecer como una sombra si se invoca desde una caja de música, mano de mono o un círculo de invocación.'),
        ('Demonio', 70, '1.7', 'Un demonio es uno de los peores fantasmas con los que te puedes topar. Se dice que atacan sin razón alguna.\nFortaleza: Iniciará ataques más a menudo que otros fantasmas.\nDebilidad: Si te responde por la güija, perderás menos cordura.', 'Información:\n- Usar incienso cerca del fantasma evitará que cace durante 60s en vez de 90s.|- Tiempo entre cacerías de 20s (tiempo normal 25s)&Comportamiento:\n- El crucifijo tiene un rango aumentado del 50% dependiendo del tier (T1: 4.5m. T2: 6m. T3: 7.5m).&Cordura de ataque:\n- Puede cazar a cualquier nivel de cordura, caza normalmente a partir del 70%'),
        ('Yurei', 50, '1.7', 'Un yurei es un tipo de fantasma que ha vuelto al plano físico, normalmente para cobrarse una venganza o manifestar su odio.\nFortaleza: Se dice que tienen una gran influencia en la cordura de las personas.\nDebilidad: Utilizar incienso en su habitación lo atrapará ahí temporalmente, reduciendo la frecuencia con la que deambula.', 'Información:\n- Puede cerrar una puerta por completo quitando a los jugadores cercanos un 15% de cordura si la puerta está en su habitación.|- Solo este fantasma puede cerrar o interactuar con la puerta principal de la casa fuera de una cacería o evento.&Comportamiento:\n- Usar incienso atrapará al fantasma en su habitación y evitará que merodee durante 60 segundos.'),
        ('Oni', 50, '1.7', 'Los oni comparten rasgos con los demonios y poseen una fuerza extrema. Algunos rumores apuntan a que se manifiestan más cuando están cerca de su presa.\nFortaleza: Son más activos cuando hay varias personas cerca y se les ha visto mover objetos a gran velocidad.\nDebilidad: Son muy activos, por lo que es más fácil encontrarlos.', 'Información:\n- Quita un 20% de cordura en los eventos, en vez de 10%.|- NO realiza eventos de orbes.|- Se le ve más durante las cacerías (Revisar pestaña 'Guías').&Comportamiento:\n- Más activo con varias personas.|- Es más probable que se vea el fantasma en los eventos en lugar de la sombra.'),
        ('Yokai', 80, '1.7', 'Los yokai son fantasmas comunes que se sienten atraídos por las voces humanas. Se les puede encontrar atormentando casas familiares.\nFortaleza: Hablar cerca de él lo enfadará, incrementando las probabilidades de ataque.\nDebilidad: Cuando está atacando solo puede oír voces en sus proximidades.', 'Información:\n- No puede detectar la voz o aparatos electrónicos a más de 2,5m durante la cacería.&Comportamiento:\n- Más activo cuando se habla cerca del fantasma.&Cordura de caza:\n- Puede iniciar cacerías a partir del 80% de cordura cuando se habla cerca de él, si no al 50%.'),
        ('Hantu', 50, '1.44 - 2.7', 'Un hantu es un tipo de fantasma raro que se puede encontrar en climas cálidos. Se les conoce por atacar a menudo cuando hay clima frío.\nFortaleza: Se desplaza más rápido si hay temperaturas bajas.\nDebilidad: Se mueve más despacio en zonas con temperaturas calientes.', 'Información:\n- Se le puede ver vaho al fantasma en cualquier habitación durante la cacería si los fusibles están apagados.|- No puede encender los fusibles.&Comportamiento:\n- Alta probabilidad de que apague los fusibles.&Velocidad:\n- Veloz en temperaturas heladas. NO acelera en línea de visión.&Evidencia:\n- Temperaturas garantizadas en Pesadilla o Demencia.'),
        ('Goryo', 50, '1.7', 'Cuando un goryo pasa a través de un proyector DOTS, solo una cámara de video podrá verlo.\nFortaleza: Sólo se mostrará ante la cámara de video si no hay nadie cerca.\nDebilidad: Rara vez se les ve lejos del lugar donde murieron.', 'Información:\n- Sólo se le puede ver en el DOTs a través de una cámara de video y fuera de su habitación o desde el camión.&Comportamiento:\n- No puede cambiar su habitación favorita.|- No sale de su habitación muy a menudo.&Evidencia:\n- DOTs garantizados en Pesadilla o Demencia.'),
        ('Myling', 50, '1.7', 'Un myling es un fantasma muy activo y sonoro. Se rumorea que es silencioso cuando ataca a sus presas.\nFortaleza: Cuando ataca, suele ser sigiloso.\nDebilidad: Hacen ruido paranormal más frecuentemente.', 'Información:\n- No se le puede escuchar (pasos ni voz) a más de 12m durante las cacerías (de normal a 20m).&Comportamiento:\n- Muchos sonidos paranormales a través del micrófono parabólico.'),
        ('Onryo', 60, '1.7', 'El onryo suele ser conocido como \"el espíritu furioso\". Roba las almas de los cuerpos de sus víctimas en búsqueda de venganza. Se conoce que este fantasma teme a cualquier tipo de fuego, y hará lo imposible para estar lejos de él.\nFortaleza: Apagar una llama puede provocar que el onryo ataque.\nDebilidad: Si se siente amenazado, atacará con menos frecuencia.', 'Información:\n- Cazará con cualquier cordura después de apagar cada tercera llama si ninguna otra llama o crucifijo lo impide.&Comportamiento:\n- Las llamas actúan como crucifijos, apagará una llama si intenta cazar (a menos de 4 m).|- Más probable que apague llamas cuantos más jugadores muertos hay.&Cordura de ataque:\n- Puede cazar a cualquier nivel de cordura usando su habilidad, de normal a partir del 60%.'),
        ('Gemelos', 50, '1.53 | 1.87', 'Hay reportes que indican que estos fantasmas imitan las acciones del otro. Alternan sus ataques para confundir a su presa.\nFortaleza: Cada uno de los gemelos puede enfadarse e iniciar un ataque sobre su presa.\nDebilidad: Suelen interactuar con el entorno al mismo tiempo.', 'Información:\n- A menudo realizan interacciones al mismo tiempo (en una ubicación real y en una ubicación falsa).&Comportamiento:\n- Solo activa sensores de movimiento, pisa sal y da spirit box en su ubicación real.&Velocidad:\n- 1.53m/s cuando caza desde la ubicación real, 1.87m/s cuando caza desde la ubicación falsa.'),
        ('Raiju', 65, '1.7 | 2.5', 'Un raiju es un demonio que se nutre de la corriente eléctrica. Normalmente es tranquilo, pero se puede descontrolar si absorbe demasiado poder.\nFortaleza: Obtiene su poder de los dispositivos eléctricos cercanos, haciendo que se mueva más rápido.\nDebilidad: Debido a que siempre interfiere con los aparatos electrónicos, es fácil de rastrear cuando ataca.', 'Información:\n- Durante una cacería los objetos electrónicos empiezan a parpadear a los 15m en vez de los 10m.&Cordura de ataque:\n- Puede atacar a partir de 65% de cordura cuando hay jugadores cerca con equipos electrónicos.&Velocidad:\n- 2.5m/s cerca de objetos electrónicos activos, 1.7m/s si no hay objetos electrónicos.'),
        ('Obake', 50, '1.7', 'Los obake son cambiaformas terroríficos, y por ello son capaces de adquirir muchas apariencias. Han sido vistos adoptando forma humanoide para atraer a su presa.\nFortaleza: Cuando interactúan con el entorno, rara vez dejarán rastro.\nDebilidad: A veces cambiarán de forma, revelando así pruebas indispensables.', 'Información:\n- Deja una huella especial de 6 dedos (Ver pestaña 'Guías').|- Tiene un 6.6% de probabilidad de cambiar el modelo del fantasma cuando parpadea durante la cacería (garantizada 1 por cacería).|- Tiene un 25% de probabilidad de no dejar la evidencia de ultravioleta.|- Puede hacer que las huellas desaparezcan el doble de rápido cuando usa su habilidad.&Evidencia:\n- Ultravioleta garantizada en Pesadilla y Demencia.'),
        ('Mímico', 50, '1.7', 'El mímico es un fantasma elusivo, misterioso e imitador que copia los rasgos y comportamientos de los demás, incluyendo otros tipos de fantasma.\nFortaleza: No estamos seguros de lo que es capaz. Ten cuidado.\nDebilidad: Muchos reportes indican orbes espectrales cerca de ellos.', 'Información:\n- Siempre muestra orbes espectrales como una prueba falsa (4 evidencias) incluso con 0 evidencias.|- Copia el comportamiento y las propiedades de otros fantasmas.|- Cambia el tipo de fantasma copiado cada 30s a 2m.&Cordura de ataque:\n- Copia el comportamiento del fantasma actualmente imitado.&Velocidad:\n- Copia la velocidad del fantasma actualmente imitado.'),
        ('Moroi', 50, '1.5 - 2.25 (3.71)', ' Los moroi emergen de sus tumbas para robar la energía de los vivos. Se dice que maldicen a sus víctimas, quienes sólo podrán liberarse de su maldición a través de antídotos o mudándose muy lejos.\nFortaleza: Cuanto más débil sea su víctima, más fuerte será el moroi.\nDebilidad: Los moroi padecen hiperosmia, lo cual los debilita durante un buen rato.', 'Información:\n- Pone una maldición al jugador cuando escucha al fantasma a través del micrófono parabólico o en la Spirit Box causando que la cordura se reduzca x2 veces más rápido.|- El incienso hace que el efecto de ceguera del fantasma se aumente un 50% (7.5s en lugar de 5s).&Velocidad:\n- Muy rápido cuando el promedio de cordura es bajo, puede alcanzar una velocidad de 3.71 m/s cuando te tiene en la línea de visión.|- Reducirá su velocidad si durante la cacería se usa medicación para la cordura.&Evidencia:\n- Spirit Box garantizada en Pesadilla o Demencia.'),
        ('Deogen', 40, '0.4 | 3.0', 'En ocasiones envueltos por una niebla eterna, los deogen llevan evadiendo a los cazadores de fantasmas durante años.\n Hay reportes que acusan a estos fantasmas de haber encontrado incluso a las presas más ocultas, justo antes de acecharles hasta la extenuación.\nFortaleza: Perciben a los vivos constantemente. Podrás huir, pero no podrás esconderte.\nDebilidad: Utilizan mucha energía para manifestarse, haciendo que se desplacen muy despacio al estar cerca de sus víctimas.', 'Información:\n- Respiración pesada a través de la Spirit Box cuando se usa a 1m del fantasma.|- No te puedes esconder del fantasma, tienes que loopearlo.&Velocidad:\n- 3.0m/s cuando está lejos, 0.4m/s cuando está cerca del jugador.&Evidencia:\n- Spirit Box garantizado en Pesadilla o Demencia.'),
        ('Thaye', 75, '1.0 - 2.75', 'Se dice que los thaye envejecen muy rápido, incluso en el más allá. Por lo que sabemos, parece que empeoran más rápido si hay vivos cerca de ellos.\nFortaleza: Conforme entres en la ubicación, se volverán activos, defensivos y ágiles.\nDebilidades: Se debilitan con el tiempo, tornándose más vulnerables, más lentos y menos agresivos.', 'Comportamiento:\n- Envejece cuando el jugador está en la habitación del fantasma o cerca del fantasma (cada 1-2 minutos).|- Más activo cuando es joven.|- Preguntar por su edad en la Ouija hará que envejezca.&Cordura de ataque:\n- Puede cazar a partir de 75% cuando es joven, 15% cuando es viejo.&Velocidad:\n- 2.75m/s cuando es joven, 1.0m/s cuando es viejo No aumenta su velocidad cuando está en línea de visión.');
    ";
    mysqli_query($conexion, $insertarFantasmas);
}
// 
// 
//  En proceso 
// 
// 
// 
