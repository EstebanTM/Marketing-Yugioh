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
    <link rel="stylesheet" href="../../css/editarEvento.css">
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
    <div class="formEditar w-75 rounded">
    <form class="frmEdit w-50 mx-auto" method="POST" action="updateEvento.php">
        <h3 class="text-center alert alert-secondary lblTop">Editar evento</h3>
        <?php
	        require ("../../conexion/classConnectionMySQL.php");

			// Creamos una nueva instancia
			$NewConn = new ConnectionMySQL();
			// Creamos una nueva conexion
			$NewConn->CreateConnection();
			/////////
			$id= $_GET['id'];
			
			///Consulta a la base de datos
			$query = "Select * from eventos WHERE ID = $id";
			$result = $NewConn -> ExecuteQuery($query);
            while($datos=$result->fetch_object()){?>
                <div class="mb-3">
                    <label for="id" class="form-label">ID</label>
                    <input type="text" class="form-control" id="id" name="id" value="<?= $datos->ID ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="name" name="nombre" value="<?= $datos->Nombre ?>">
                </div>
                <div class="mb-3">
                    <label for="locat" class="form-label">Descripcion</label>
                    <input type="text" class="form-control" id="descripcion" name="descripcion" value="<?= $datos->Descripcion ?>">
                </div>
                <div class="mb-3">
                    <label for="locat" class="form-label">Ubicacion</label>
                    <input type="text" class="form-control" id="ubicacion" name="ubicacion" value="<?= $datos->Ubicacion ?>">
                </div>
                <div class="mb-3">
                    <label for="locat" class="form-label">Capacidad</label>
                    <input type="number" class="form-control" id="capacidad" name="capacidad" value="<?= $datos->Capacidad ?>">
                </div>
                <div class="mb-3">
                    <label for="locat" class="form-label">Fecha del evento</label>
                    <input type="date" class="form-control" id="fecha" name="fecha" value="<?= $datos->Fecha ?>">
                </div>
                <div class="mb-3">
                    <label for="locat" class="form-label">Precio</label>
                    <input type="number" class="form-control" id="precio" name="precio" value="<?= $datos->Precio ?>">
                </div>
                <div class="mb-3">
                    <label for="locat" class="form-label">Url de la imagen</label>
                    <input type="text" class="form-control" id="imagenUrl" name="imagenUrl" value="<?= $datos->ImagenURL ?>">
                </div>
            <?php }
            ?>
            <div class="btnAcept text-center">
                <button type="submit" class="btn btn-warning">Editar</button>
            </div>
    </form>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>