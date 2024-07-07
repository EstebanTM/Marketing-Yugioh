<?php
// Configuración de la conexión
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "yugioh";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// ID del usuario y evento
$usuario_id = 1;
$evento_id = 3;

// Llamar al procedimiento almacenado
$sql = "CALL RegistrarUsuarioEnEvento(?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $usuario_id, $evento_id);

if ($stmt->execute()) {
    echo "Usuario registrado en el evento exitosamente.";
} else {
    echo "Error: " . $stmt->error;
}

// Cerrar conexión
$stmt->close();
$conn->close();
?>
