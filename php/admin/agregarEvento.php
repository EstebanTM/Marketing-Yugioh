<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 1) {
  header('Location: ../../index.php');
  exit();
}

require("../../conexion/classConnectionMySQL.php");
$Newconn = new ConnectionMySQL(); 
$Newconn->CreateConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nombre = $_POST['eventName'];
  $descripcion = $_POST['eventDescription'];
  $ubicacion = $_POST['eventLocation'];
  $capacidad = $_POST['eventCapacity'];
  $fecha = $_POST['eventDate'];
  $precio = $_POST['eventPrice'];
  $imagenURL = $_POST['eventImage'];

  $query = "INSERT INTO eventos (Nombre, Descripcion, Ubicacion, Capacidad, Fecha, Precio, ImagenURL) 
            VALUES ('$nombre', '$descripcion', '$ubicacion', '$capacidad', '$fecha', '$precio', '$imagenURL')";
  $result = $Newconn->ExecuteQuery($query);

  if ($result) {
    header('Location: eventosADM.php');
    exit();
  } else {
    echo "Error al agregar el evento.";
  }
}
?>
