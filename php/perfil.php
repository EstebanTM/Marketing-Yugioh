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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	  <script src="https://kit.fontawesome.com/ff9db9c428.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/general.css">
    <link rel="stylesheet" href="../css/eventos.css">
    <link rel="icon" href="../recursos/logo.png" type="image/x-icon">
    <title>Perfil</title>
    
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

<div class="container-fluid d-flex justify-content-center">
<div class="tblInventario">
<?php
require("../conexion/classConnectionMySQL.php");
$Newconn = new ConnectionMySQL(); 
$Newconn->CreateConnection();

$user_id = $_SESSION['user_id'];

$stmt = $Newconn->GetConnection()->prepare("CALL MostrarEventosPorUsuario(?)");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '
        <div class="col-md-6 mb-3">
            <div class="card custom-card">
                <div class="row g-0">
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">' . $row['Nombre'] . '</h5>
                            <p class="card-text">' . $row['Descripcion'] . '</p>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>Ubicación:</strong> ' . $row['Ubicacion'] . '</li>
                                <li class="list-group-item"><strong>Capacidad:</strong> ' . $row['Capacidad'] . '</li>
                                <li class="list-group-item"><strong>Fecha:</strong> ' . $row['Fecha'] . '</li>
                                <li class="list-group-item"><strong>Precio:</strong> ' . $row['Precio'] . '</li>
                            </ul>
                            <a href="cancelar.php?evento_id=' . $row['ID'] . '" class="btn btn-warning">Cancelar registro</a>
                        </div>
                    </div>
                    <div class="col-md-4 align-items-center">
                        <img src="' . $row['ImagenURL'] . '" class="card-img" alt="Imagen del evento">
                    </div>
                </div>
            </div>
        </div>';
    }
    $Newconn->SetFreeResult($result);
} else {
    echo '
    <div class="col-md-6 mb-3">
        <div class="card">
            <div class="row g-0">
                <div class="col-md-12">
                    <div class="card-body">
                        <h5 class="card-title">Sin eventos registrados</h5>
                        <p class="card-text">No estás registrado en ningún evento.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>';
}

echo "
  </tbody>
</table>";

$Newconn->CloseConnection();
?>
</div>
</div>




    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>