<?php
session_start();
session_unset(); // Elimina todas las variables de sesión
session_destroy(); // Destruye la sesión actual

// Redirige a la página de inicio o a donde prefieras después de cerrar sesión
header("Location: ../index.php");
exit;
?>