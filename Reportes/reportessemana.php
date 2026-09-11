<?php 

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

    <script>
        const semanas = <?php echo json_encode($semanas); ?>;
        const ventas = <?php echo json_encode($ventas); ?>;
    </script>

    <section class="grafico">
    <h2 class="titulo-grafico">Ingresos por semana</h2>
    <canvas id="graficoVentasSemana"></canvas>
</section>

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