<?php 
 //Paso 1 Consulta SQL
  $sql= "SELECT pedidos.fecha, SUM(ventas.costototal) AS ventasDia FROM ventas INNER JOIN pedidos ON ventas.pedidos_id = pedidos.id  GROUP BY pedidos.fecha";
  
  $resultado = $conn->query($sql);

  $fecha = [];
  $ventasDia = [];
  //Paso 2 Mover Datos al array
  while ($fila = $resultado->fetch_assoc()){
    $fecha[] = $fila["fecha"];
    $ventasDia[] = $fila["ventasDia"];
  }
  

?>


<!-- Estructura visual para el panel -->
<section class="grafico">
    <h2 class="titulo-grafico">Ingresos por día</h2>
    <canvas id="graficoDias"></canvas>
</section>

<script>
const fecha = <?php echo json_encode($fecha); ?>;
const ventasDia = <?php echo json_encode($ventasDia); ?>;

const ctxDias = document.getElementById('graficoDias');
new Chart(ctxDias, {
    type: 'bar',
    data: {
        labels: fecha,
        datasets: [{
            label: 'Ingresos en Bs.',
            data: ventasDia,
            backgroundColor: '#0BA84A', // Color principal (#0BA84A)
            borderColor: '#087F3B',          // Borde (#087F3B)
            borderWidth: 1,                    // Grosor del borde en px
            borderRadius: 8,                   // Bordes redondeados en las barras
            hoverBackgroundColor: '#087F3B'   // Color al pasar el cursor sobre la barra
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});
</script>