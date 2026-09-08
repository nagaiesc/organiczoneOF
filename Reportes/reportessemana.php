<?php 
session_start();

$servidor = "localhost";
$nombre = "root";
$contraseña = "";
$BDnombre = "organiczoneBD";

$conn = new mysqli($servidor, $nombre, $contraseña, $BDnombre);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$id = $_SESSION["CI"];

// Consulta SQL simplificada
$sql = "SELECT WEEK(pedidos.fecha) AS semana, SUM(ventas.costototal) AS ventas 
        FROM ventas 
        INNER JOIN pedidos ON ventas.pedidos_id = pedidos.id 
        GROUP BY WEEK(pedidos.fecha)";

$resultado = $conn->query($sql);

$semanas = [];
$ventas = [];

if ($resultado && $resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        // Formateamos el texto directo en PHP para que se vea claro
        $semanas[] = "Semana " . $fila["semana"];
        $ventas[] = $fila["ventas"];
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Ingresos por Semana</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h2>Reporte de Ingresos Totales por Semana</h2>

    <script>
        const semanas = <?php echo json_encode($semanas); ?>;
        const ventas = <?php echo json_encode($ventas); ?>;
    </script>

    <div style="width: 500px; height: 300px;">
        <canvas id="graficoVentasSemana"></canvas>
    </div>

    <script>
        const ctx = document.getElementById('graficoVentasSemana');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: semanas,
                datasets: [{
                    label: 'Ingresos Totales ($)',
                    data: ventas
                }]
            }
        });
    </script>
</body>
</html>