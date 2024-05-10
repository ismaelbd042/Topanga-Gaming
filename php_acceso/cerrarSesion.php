<?php
session_start();

// Eliminar todas las variables de sesión
session_unset();

// Destruir la sesión
session_destroy();

header("Location: ../Index/index.php");
exit();
