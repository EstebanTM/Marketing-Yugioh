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
$id = $_POST['id'];
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$ubicacion = $_POST['ubicacion'];
$capacidad = $_POST['capacidad'];
$fecha = $_POST['fecha'];
$precio = $_POST['precio'];
$imagenUrl = $_POST['imagenUrl'];
// Creamos una nueva instancia
$NewConn = new ConnectionMySQL();
// Creamos una nueva conexion
$NewConn->CreateConnection();
///Realiza la insecion de datos a la base de datos
echo $query="UPDATE eventos 
                SET Nombre = '$nombre', 
                    Descripcion = '$descripcion', 
                    Ubicacion = '$ubicacion', 
                    Capacidad = '$capacidad', 
                    Fecha = '$fecha',  
                    Precio = '$precio', 
                    ImagenUrl = '$imagenUrl'
                    WHERE ID = $id";
$result=$NewConn->ExecuteQuery($query);
    if($result){
        $RowCount =  $NewConn->GetCountAffectedRows();
        if($RowCount > 0){
            echo "Query ejecutado exitosamente<br/>";
			header("Location: eventosADM.php");
			header('Location: eventosADM.php');
        }
    }else{
        echo "<h3>Error al ejecutar la consulta</h3>";
    }
?>