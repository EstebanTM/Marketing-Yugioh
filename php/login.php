<?php
session_start();
require_once '../conexion/classConnectionMySQL.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $connection = new ConnectionMySQL();
    $connection->CreateConnection();
    $conn = $connection->GetConnection();

    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE Usuario = ? AND Contrasenia = ?");
    $stmt->bind_param("ss", $email, $password); // 'ss' indica que ambos parámetros son strings
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['ID'];
        $_SESSION['user_name'] = $user['Nombre'];
        header("Location: ../index.php"); // Cambia a la página a la que quieras redirigir después del login
        exit;
    } else {
        $error = "Correo electrónico o contraseña incorrectos.";
    }

    $connection->CloseConnection();
}
?>
