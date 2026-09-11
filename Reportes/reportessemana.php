<?php 

// Consulta SQL simplificada
$sql = "SELECT WEEK(pedidos.fecha) AS semana, SUM(ventas.costototal) AS ventasSemana 
        FROM ventas 
        INNER JOIN pedidos ON ventas.pedidos_id = pedidos.id 
        GROUP BY WEEK(pedidos.fecha)";

$resultado = $conn->query($sql);

$semanas = [];
$ventasSemana = [];

if ($resultado && $resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        // Formateamos el texto directo en PHP para que se vea claro
        $semanas[] = "Semana " . $fila["semana"];
        $ventasSemana[] = $fila["ventasSemana"];
    }
}
?>

    <script>
        const semanas = <?php echo json_encode($semanas); ?>;
        const ventasSemana = <?php echo json_encode($ventasSemana); ?>;
    </script>

    <section class="grafico">
    <h2 class="titulo-grafico">Ingresos por semana</h2>
    <canvas id="graficoVentasSemana"></canvas>
</section>

    <script>
        const ctxSemanas = document.getElementById('graficoVentasSemana');
        new Chart(ctxSemanas, {
        type: 'doughnut',

        data: {
            labels: semanas,

            datasets: [{
                label: 'Ingresos en Bs.',
                data: ventasSemana,
                backgroundColor: [
                    '#0BA84A',
                    '#2B140D',
                    '#FCD09F',
                    '#087F3B',
                    '#82D19A'
                ],
                borderColor: '#FFFFFF',
                borderWidth: 2,
                hoverOffset: 6
            }]
        },

        options: {
            responsive: true,
            maintainAspectRatio: false,

            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        font: {
                            family: 'Fredoka',
                            size: 14
                        }
                    }
                }
            }
        }
    });
    </script>

    