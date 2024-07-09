<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 1) {
  // Redirigir al index.php si no hay sesión
  header('Location: ../../index.php');
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario</title>
	<link rel="stylesheet" href="../../css/bootstrap.min.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<script src="https://kit.fontawesome.com/ff9db9c428.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../css/eventos.css">
	<link rel="stylesheet" href="../../css/general.css">
    <link rel="stylesheet" href="../../css/eventosADM.css">
</head>
<body>

<!-- Header -->
<header class="header">
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="../../recursos/Yu-Gi-Oh!.png" alt="" class="logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="../../index.php">Inicio</a>
                    </li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="../eventos.php">Eventos</a>
                        </li>
                        <?php if ($_SESSION['user_type'] == 1): ?>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="eventosADM.php">Editar Eventos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="usuariosADM.php">Editar Usuarios</a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="../perfil.php">Perfil</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="../../gameplay.php">Como jugar YuGiOh!</a>
                            </li>
                        <?php endif; ?>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="../../gameplay.php">Como jugar YuGiOh!</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="ms-auto">
                <?php if (!isset($_SESSION['user_id'])): ?>
                    <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#loginModal">Iniciar Sesión</a>
                <?php else: ?>
                    <a href="../logout.php" class="nav-link">Cerrar Sesión</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
</header>



<div class="container-fluid d-flex justify-content-center">
<div class="tblInventario w-75">

<div class="event-container d-flex align-items-center justify-content-between p-3 rounded">
  <h3>Tabla con todos los eventos disponibles</h3>
  <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addEventModal">Agregar evento</button>
</div>

<?php
require("../../conexion/classConnectionMySQL.php");
$Newconn = new ConnectionMySQL(); 
$Newconn->CreateConnection();

echo "
<table class='table'>
  <thead class='tblHead'>
    <tr>
      <th scope='col'>ID</th>
      <th scope='col'>Nombre</th>
      <th scope='col'>Descripcion</th>
      <th scope='col'>Ubicacion</th>
      <th scope='col'>Capacidad</th>
      <th scope='col'>Fecha</th>
      <th scope='col'>Precio</th>
      <th scope='col'>Imagen</th>
      <th scope='col'></th>
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
          eventos.Precio,
          eventos.ImagenURL
          from eventos";
$result = $Newconn->ExecuteQuery($query);
if ($result) {
    while ($row = $Newconn->GetRows($result)) {
        echo "<tr>
                <th scope='row'>" . $row[0] . "</th>
                <td>" . $row[1] . "</td>
                <td>" . $row[2] . "</td>
                <td>" . $row[3] . "</td>
                <td>" . $row[4] . "</td>
                <td>" . $row[5] . "</td>
                <td>" . $row[6] . "</td>
                <td>" . $row[7] . "</td>
                <td>" . $row[8] . "</td>
                <td>
					<a class='btn btn-small btn-warning me-3 mb-3' href='editarEvento.php?id=" . urlencode($row[0]) . "'><i class='fa-solid fa-pen-to-square'></i></a>
					<a class='btn btn-small btn-danger' href='eliminarEvento.php?id=" . urlencode($row[0]) . "'><i class='fa-solid fa-trash'></i></a>
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


<!-- Modal para agregar eventos -->
<div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="addEventModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addEventModalLabel">Agregar Evento</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="agregarEvento.php" method="POST" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="eventName" class="form-label">Nombre del Evento</label>
            <input type="text" class="form-control" id="eventName" name="eventName" required>
          </div>
          <div class="mb-3">
            <label for="eventDescription" class="form-label">Descripción</label>
            <textarea class="form-control" id="eventDescription" name="eventDescription" rows="3" required></textarea>
          </div>
          <div class="mb-3">
            <label for="eventLocation" class="form-label">Ubicación</label>
            <input type="text" class="form-control" id="eventLocation" name="eventLocation" required>
          </div>
          <div class="mb-3">
            <label for="eventCapacity" class="form-label">Capacidad</label>
            <input type="number" class="form-control" id="eventCapacity" name="eventCapacity" required>
          </div>
          <div class="mb-3">
            <label for="eventDate" class="form-label">Fecha</label>
            <input type="date" class="form-control" id="eventDate" name="eventDate" required>
          </div>
          <div class="mb-3">
            <label for="eventPrice" class="form-label">Precio</label>
            <input type="number" class="form-control" id="eventPrice" name="eventPrice" required>
          </div>
          <div class="mb-3">
            <label for="eventImage" class="form-label">URL de la Imagen</label>
            <input type="url" class="form-control" id="eventImage" name="eventImage" required>
          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-primary">Agregar Evento</button>
          </div>
          
        </form>
      </div>
    </div>
  </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>