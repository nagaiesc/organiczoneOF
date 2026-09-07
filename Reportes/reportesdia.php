<?php 
$servidor = "localhost";
$nombre = "root";
$contraseña = "";
$BDnombre = "organiczoneBD";

$conn = new mysqli($servidor, $nombre, $contraseña, $BDnombre);

  if($conn->connect_error) {
    die ("conexion fallida" . $conn->connect_error);
  }
  $id= $_SESSION["id"];
 //Paso 1 Consulta SQL
  $sql= "SELECT pedidos.fecha, SUM(ventas.costototal) AS ventas FROM ventas INNER JOIN pedidos ON ventas.pedidos_id = pedidos.id  GROUP BY pedidos.fecha";
  
  $resultado = $conn->query($sql);
  //Paso 2 Mover Datos al array
  while ($fila = $resultado->fetch_assoc()){
    $fecha[] = $fila["fecha"];
    $ventas[] = $fila["ventas"];
  }
  $resultado = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Reporte de Ingresos Totales por Día</h2>

    <script>
        const fechas = <?php echo json_encode($fecha); ?>;
        const ventas = <?php echo json_encode($ventas); ?>;
    </script>
    <div style="width: 500px; height: 300px;">
        <canvas id="graficoVentas"></canvas>
    </div>

    <script>
        const ctx = document.getElementById('graficoVentas');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: fechas,
                datasets: [{
                    label: 'Ingresos Totales ($)',
                    data: ventas
                }]
            }
        });
    </script>
</body>
</html>