<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  // Redirigir al index.php si no hay sesión
  header('Location: ../index.php');
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>