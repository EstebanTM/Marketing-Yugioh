<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventos</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
	<script src="https://kit.fontawesome.com/ff9db9c428.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="../css/general.css">
	<link rel="stylesheet" href="../css/eventos.css">
</head>
<body>
<header class="header">
  <a href="#" class="titulo">Eventos</a>
    <nav class="navbar">
      <a href="perfil.php">Perfil</a>
      <a href="../index.html">Inicio</a>
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
      <th scope='col'></th>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>