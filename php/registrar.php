<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    // Redirigir al index.php si no hay sesión
    header('Location: ../index.php');
    exit();
}

//if (!isset($_GET['evento_id'])) {
    // Redirigir si no hay evento_id
    //header('Location: eventos.php');
    //exit();
//}

require("../conexion/classConnectionMySQL.php");

$evento_id = $_GET['evento_id'];
$user_id = $_SESSION['user_id'];

$Newconn = new ConnectionMySQL(); 
$Newconn->CreateConnection();

try {
    $query = "CALL RegistrarUsuarioEnEvento(?, ?)";
    $stmt = $Newconn->GetConnection()->prepare($query);
    $stmt->bind_param("ii", $user_id, $evento_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION['success'] = "Te has registrado en el evento exitosamente.";
    } else {
        $_SESSION['error'] = "No se pudo completar el registro. Puede que el evento esté lleno.";
    }
} catch (Exception $e) {
    $_SESSION['error'] = "Ocurrió un error: " . $e->getMessage();
}

$stmt->close();
$Newconn->CloseConnection();

header('Location: eventos.php');
exit();
?>

