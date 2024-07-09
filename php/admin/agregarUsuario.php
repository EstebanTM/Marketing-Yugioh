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
  $usuario = $_POST['eventUser'];
  $contrasenia = $_POST['eventPswd'];
  $tipo = $_POST['eventTipe'];

  $query = "INSERT INTO usuarios (Nombre, Usuario, Contrasenia, Tipo) 
            VALUES ('$nombre', '$usuario', '$contrasenia', '$Tipo')";
  $result = $Newconn->ExecuteQuery($query);

  if ($result) {
    header('Location: usuariosADM.php');
    exit();
  } else {
    echo "Error al agregar el evento.";
  }
}
?>