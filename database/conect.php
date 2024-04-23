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
        velocidad INT,
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

    $insertarFantasmas = "INSERT INTO fantasmas (nombre, cordura, velocidad, extras) VALUES 
        ('Espíritu', 50, 2, 'Se ve más afectado por los inciensos, deteniendo sus cacerías durante 3 minutos tras su última cacería.'),
        ('Espectro', 60, 2, 'No dejara rastro de pisadas ni podrá pisar la sal. Este también posee la habilidad de teletransportarse a los jugadores y esto se podrá saber gracias al EMF el cual se encenderá de manera repentina.'),
        ('Ente', 30, 2, 'Si le hacemos foto durante una manifestación, el fantasma desaparecerá aunque el ruido de la manifestación continuará, además, al mirar el libro, la foto no estará distorsionada y no se verá al fantasma pese a que si lo marque. También, durante la cacería se mostrara con un parpadeo muy poco frecuente.'),
        ('Poltergeist', 40, 2, 'Puede lanzar varios objetos a la vez, es decir, si tiras varios objetos como platos o vasos juntos y el fantasma pasa por ahí, en caso de ser un poltergeist lanzará todos los objetos a la vez.'),
        ('Banshee', 40, 2, 'Marcara a un jugador siguiéndolo por toda el mapa sin importar donde este su habitación, esta cambiara de objetivo cuando el jugador marcado sale de la casa o muere. Además, tiene una baja posibilidad de hacer un grito único frente al micrófono parabólico.'),
        ('Jinn', 40, 3, 'No podrá apagar el cuadro de luces y a veces un EMF cercano al cuadro pitara sin que este sucediendo nada.'),
        ('Pesadilla', 40, 3, 'Será más peligroso si las luces están apagadas, permitiendo le atacar pese a una cordura alta. Este también posee la habilidad de apagarnos una luz justo tras encenderla y no puede encender luces.'),
        ('Revenant', 40, 3, 'Durante la cacería, se moverá muy despacio mientras no tenga a un jugador a la vista, de lo contrario, el reventant se moverá a gran velocidad.'),
        ('Sombra', 40, 3, 'Raramente realizan acciones paranormales con un jugador cerca, y cuanto más jugadores cercanos allá más difícil será que interactue con el entorno.'),
        ('Demonio', 40, 3, 'Puede atacar incluso con 100% de cordura, pero los crucifijos hacen que su radio de efecto no sean 3 metros sino 5 metros.'),
        ('Yurei', 40, 3, 'Reduce la cordura de los jugadores con mayor facilidad. Si una puerta se cierra del todo sin que haya habido una manifestación o caza también será un indicio de este fantasma, este evento reduce la cordura en un 25%'),
        ('Oni', 40, 3, 'Su forma de manifestarse siempre deberá ser física, es decir, no podrá suspirarte al odio. Además, este fantasma suele ser más activo y frecuente en las manifestaciones.'),
        ('Yokai', 40, 3, 'Durante las cacerías solo será capaz de escuchar a los jugadores cercanos a el. Hablar cerca de él le enfadará pudiendo provocar una cacería incluso con una cordura elevada.'),
        ('Hantu', 40, 3, 'Será más rápido en habitaciones frías, debido a esto apaga el cuadro de luces con mayor frecuencia para mantener la casa a baja temperatura. En dificultades en la que este esconda pruebas (como pesadilla o demencia) siempre deberá mostrar temperaturas heladas.'),
        ('Goryo', 40, 3, 'Suele mantenerse dentro de su habitación y solo se podrá verle la prueba de DOTS a través de una cámara. En las dificultades de pesadilla y demencia siempre deberá mostrar la prueba de DOTS.'),
        ('Myling', 40, 3, 'Tienden a hacer mucho ruido en el micrófono parabólico, pero durante una cacería será extremadamente sigiloso.'),
        ('Onryo', 40, 3, 'Apagará las velas encendidas por jugadores con mayor frecuencia pero al hacerlo, hay posibilidades de que este ataque incluso con un 100% de cordura.'),
        ('Gemelos', 40, 3, 'Son dos fantasmas con comportamientos difíciles, mientras uno interactua en una habitación el otro podría interactuar en otra diferente a la vez. Suelen interactuar con el entorno al mismo tiempo.
Durante las cacerías podrá atacar uno de los dos, uno de ellos se moverá ligeramente más lento que la media de fantasmas, mientras el otro se moverá ligeramente más rápido que la media.'),
        ('Raiju', 40, 3, 'Si hay objetos electrónicos cerca de él, atacará con mayor facilidad y se moverá más rápido durante las cacerías.'),
        ('Obake', 40, 3, 'Durante las cacerías cambiara de forma al menos una vez. Además, raramente dejaran una huella ultra violeta con 6 dedos en vez de 5 o dos huellas en los interruptores en vez de una. Este siempre revelara obligatoriamente su prueba de ultravioleta, esto no significa que la deje al primer intento sino que si en un modo donde oculte una o más pruebas no deja huellas no podrá ser este fantasma.'),
        ('Mímico', 40, 3, 'Puede actuar con la habilidad de cualquier otro fantasma del juego, además, presenta una cuarta prueba que no es propia de un mímico pero estará siempre presente, se trata de los orbes espectrales.'),
        ('Moroi', 40, 3, 'Este fantasma es capaz de maldecir a aquellos jugadores que le escuchen por la spirit box, haciendo que su cordura baje muy rápido por cada segundo dentro de la habitación del fantasma. Esta maldición puede ser eliminada tomando medicamentos para la cordura. Este siempre revelara obligatoriamente su prueba de spirit box, significando lo mismo que ocurría con el obake y la ultravioleta.'),
        ('Deogen', 40, 3, 'Estos fantasmas siempre sabrán donde estas por lo que no podrás esconderte, sin embargo son fantasmas muy lentos por lo que podrás huir de ellos fácilmente. Para reconocerlos fácilmente hay que fijarse en su velocidad, pues serán muy rápidos cuando estén lejos de ti pero muy lentos cuanto más cerca estén. Este siempre revelara obligatoriamente su prueba de spirit box.'),
        ('Thaye', 40, 3, 'Estos fantasmas son muy activos y agresivos durante el inicio de la partida tras entrar en su habitación, pero según la partida vaya avanzando se volverán más tranquilos.');
    ";
    mysqli_query($conexion, $insertarFantasmas);
}
// 
// 
//  En proceso 
// 
// 
// 
