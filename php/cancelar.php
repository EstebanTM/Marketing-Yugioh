<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['user_id'])) {
    // Redirigir al index.php si no hay sesión
    header('Location: ../index.php');
    exit();
}

if (!isset($_GET['evento_id'])) {
    // Redirigir a la página de eventos si no se proporciona un evento_id
    header('Location: perfil.php');
    exit();
}

require("../conexion/classConnectionMySQL.php");
$Newconn = new ConnectionMySQL(); 
$Newconn->CreateConnection();

$usuario_id = $_SESSION['user_id'];
$evento_id = $_GET['evento_id'];

// Llamar al procedimiento almacenado para cancelar el registro
$query = "CALL CancelarRegistroEnEvento(?, ?)";
$stmt = $Newconn->GetConnection()->prepare($query);
$stmt->bind_param("ii", $user_id, $evento_id);
$stmt->execute();

if ($stmt->execute()) {
    // Redirigir a la página de eventos con un mensaje de éxito
    header('Location: perfil.php?mensaje=cancelado');
} else {
    // Redirigir a la página de eventos con un mensaje de error
    header('Location: perfil.php?mensaje=error');
}

$stmt->close();
$Newconn->CloseConnection();
?>
