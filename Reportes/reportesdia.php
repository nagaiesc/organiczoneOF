<?php 
 //Paso 1 Consulta SQL
  $sql= "SELECT pedidos.fecha, SUM(ventas.costototal) AS ventas FROM ventas INNER JOIN pedidos ON ventas.pedidos_id = pedidos.id  GROUP BY pedidos.fecha";
  
  $resultado = $conn->query($sql);

  $fecha = [];
  $ventas = [];
  //Paso 2 Mover Datos al array
  while ($fila = $resultado->fetch_assoc()){
    $fecha[] = $fila["fecha"];
    $ventas[] = $fila["ventas"];
  }
  

?>


<!-- Estructura visual para el panel -->
<section class="grafico">
    <h2 class="titulo-grafico">Ingresos por día</h2>
    <canvas id="graficoDias"></canvas>
</section>

<script>
const dias = <?php echo json_encode($dias); ?>;
const ingresosDias = <?php echo json_encode($ingresosDias); ?>;

const ctxDias = document.getElementById('graficoDias');
new Chart(ctxDias, {
    type: 'bar',
    data: {
        labels: dias,
        datasets: [{
            label: 'Ingresos en Bs.',
            data: ingresosDias
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});
</script>