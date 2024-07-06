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
    <title>Eventos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<script src="https://kit.fontawesome.com/ff9db9c428.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="../css/general.css">
	<link rel="stylesheet" href="../css/eventos.css">
</head>
<body>
<!-- Header -->
<header class="header">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="../recursos/Yu-Gi-Oh!.png" alt="" class="logo">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
                    <ul class="navbar-nav mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="../index.php">Inicio</a>
                        </li>
                        <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="../php/eventos.php">Eventos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="../php/perfil.php">Perfil</a>
                        </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="../gameplay.php">Como jugar YuGiOh!</a>
                        </li>
                    </ul>
                </div>
                <div class="ms-auto">
                    <?php if (!isset($_SESSION['user_id'])): ?>
                    <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#loginModal">Iniciar Sesión</a>
                    <?php else: ?>
                    <a href="logout.php" class="nav-link">Cerrar Sesión</a>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </header>

<div class="container-fluid row">
<div class="tblInventario p-4">
<?php
require("../conexion/classConnectionMySQL.php");
$Newconn = new ConnectionMySQL(); 
$Newconn->CreateConnection();

echo "
<table class='table'>
  <thead class='tblHead bg-info'>
    <tr>
      <th scope='col'>Nombre</th>
      <th scope='col'>Descripción</th>
      <th scope='col'>Ubicación</th>
      <th scope='col'>Capacidad</th>
      <th scope='col'>Fecha</th>
      <th scope='col'>Precio</th>
      <th scope='col'></th>
    </tr>
  </thead>
  <tbody>";

$query = "SELECT 
          eventos.ID,
          eventos.Nombre,
          eventos.Descripcion,
          eventos.Ubicacion,
          eventos.Capacidad,
          eventos.Fecha,
          eventos.Precio
          from eventos";

$result = $Newconn->ExecuteQuery($query);
if ($result) {
    while ($row = $Newconn->GetRows($result)) {
      //<th scope='row'>" . $row[0] . "</th> --- linea para la columna de id
        echo "<tr>
                <td>" . $row[1] . "</td>
                <td>" . $row[2] . "</td>
                <td>" . $row[3] . "</td>
                <td>" . $row[4] . "</td>
                <td>" . $row[5] . "</td>
                <td>" . $row[6] . "</td>
                <td>
					        <a class='btn btn-small btn-warning' href='editar.php?id=$row[0]'><i class='fa-solid fa-pen-to-square'></i></a>
					        <a class='btn btn-small btn-danger' href='eliminar.php?id=$row[0]'><i class='fa-solid fa-trash'></i></a>
				        </td>
              </tr>";
    }
    $Newconn->SetFreeResult($result);
} else {
    echo "<tr><td colspan='5'><h1>Error al conectar a los eventos</h1></td></tr>";
}

echo "
  </tbody>
</table>";
?>

</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>