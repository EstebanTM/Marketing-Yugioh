<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 1) {
  // Redirigir al index.php si no hay sesión
  header('Location: ../../index.php');
  exit();
}
?>

<?php
require ("../../conexion/classConnectionMySQL.php");
//////////
echo $id= $_GET['id'];
// Creamos una nueva instancia
$NewConn = new ConnectionMySQL();
// Creamos una nueva conexion
$NewConn->CreateConnection();
///Consulta a la base de datos
$query = "DELETE FROM eventos WHERE ID = $id";
$result = $NewConn -> ExecuteQuery($query);
if ($result){
	$RowCount = $NewConn -> GetCountAffectedRows();
	if($RowCount > 0){
		echo "Registro eliminado correctamente";
		header("Location: eventosADM.php");
		header('Location: eventosADM.php');		
	}
}
else {
	echo "<h1>No se pudo eliminar el registro</h1>";
}
?>