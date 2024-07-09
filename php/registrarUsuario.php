<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once '../conexion/classConnectionMySQL.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    $nombre = $_POST['nombre']; // Asumiendo que también se pide el nombre del usuario en el formulario de registro

    // Validación básica
    if (empty($email) || empty($password) || empty($confirmPassword) || empty($nombre)) {
        $_SESSION['error'] = "Todos los campos son obligatorios.";
        header("Location: ../index.php");
        exit;
    } elseif ($password !== $confirmPassword) {
        $_SESSION['error'] = "Las contraseñas no coinciden.";
        header("Location: ../index.php");
        exit;
    } else {
        // Crear una nueva conexión a la base de datos
        $connection = new ConnectionMySQL();
        $connection->CreateConnection();
        $conn = $connection->GetConnection();

        // Verificar si el usuario ya existe
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE Usuario = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "El correo electrónico ya está registrado.";
            header("Location: ../index.php?error=" . urlencode($error));
            //$_SESSION['error'] = "El correo electrónico ya está registrado.";
            //header("Location: ../index.php");
            exit;
        } else {
            // Insertar el nuevo usuario
            $tipo=0;
            $stmt = $conn->prepare("INSERT INTO usuarios (Nombre, Usuario, Contrasenia, Tipo) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sssi", $nombre, $email, $password, $tipo);

            if ($stmt->execute()) {
                $_SESSION['user_id'] = $conn->insert_id;
                $_SESSION['user_name'] = $nombre;
                $_SESSION['user_type'] = $tipo;
                $_SESSION['success'] = "Usuario registrado exitosamente. Redirigiendo...";
                header("Location: ../index.php"); // Cambia a la página a la que quieras redirigir después del registro
                exit;
            } else {
                $_SESSION['error'] = "Error al registrar el usuario. Inténtalo de nuevo.";
                header("Location: ../index.php");
                exit;
            }
        }

        // Cerrar la conexión a la base de datos
        $connection->CloseConnection();
    }
}
?>