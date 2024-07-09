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
$usuario = $_POST['usuario'];
$password = $_POST['password'];
$tipo = $_POST['tipo'];
// Creamos una nueva instancia
$NewConn = new ConnectionMySQL();
// Creamos una nueva conexion
$NewConn->CreateConnection();
///Realiza la insecion de datos a la base de datos
echo $query="UPDATE usuarios 
                SET Nombre = '$nombre', 
                    Usuario = '$usuario', 
                    Contrasenia = '$password', 
                    Tipo = '$tipo'
                    WHERE ID = $id";
$result=$NewConn->ExecuteQuery($query);
    if($result){
        $RowCount =  $NewConn->GetCountAffectedRows();
        if($RowCount > 0){
            echo "Query ejecutado exitosamente<br/>";
			header("Location: usuariosADM.php");
			header('Location: usuariosADM.php');
        }
    }else{
        echo "<h3>Error al ejecutar la consulta</h3>";
    }
?>