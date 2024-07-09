<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 1) {
    // Redirigir al index.php si no hay sesión
    header('Location: ../../index.php');
    exit();
}

require("../../conexion/classConnectionMySQL.php");

// Creamos una nueva instancia y conexión
$NewConn = new ConnectionMySQL();
$NewConn->CreateConnection();

$query = "CALL ObtenerParticipantesPorEvento()";
$result = $NewConn->ExecuteQuery($query);

$eventos = [];
$labels = [];
$disponibilidad = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $eventos[$row["EventoID"]]["Nombre"] = $row["EventoNombre"];
        $eventos[$row["EventoID"]]["LugaresDisponibles"] = $row["LugaresDisponibles"];
        $eventos[$row["EventoID"]]["Participantes"][] = $row["UsuarioNombre"];
    }

    foreach ($eventos as $eventoID => $evento) {
        $labels[] = $evento["Nombre"];
        $disponibilidad[] = $evento["LugaresDisponibles"];
    }
}
$NewConn->CloseConnection();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Participantes por Evento</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Reporte de Participantes por Evento</h1>
    
    <canvas id="availabilityChart"></canvas>
    <script>
        var labels = <?php echo json_encode($labels); ?>;
        var disponibilidad = <?php echo json_encode($disponibilidad); ?>;

        var ctx = document.getElementById('availabilityChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Lugares Disponibles',
                    data: disponibilidad,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    <?php foreach ($eventos as $eventoID => $evento): ?>
        <h2><?php echo $evento["Nombre"]; ?></h2>
        <p>Lugares Disponibles: <?php echo $evento["LugaresDisponibles"]; ?></p>
        <table>
            <tr>
                <th>Participante</th>
            </tr>
            <?php if (!empty($evento["Participantes"])): ?>
                <?php foreach ($evento["Participantes"] as $participante): ?>
                    <tr>
                        <td><?php echo $participante; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td>No hay participantes registrados</td>
                </tr>
            <?php endif; ?>
        </table>
    <?php endforeach; ?>
</body>
</html>

