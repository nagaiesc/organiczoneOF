<?php 
session_start();
$servidor = "localhost";
$nombre = "root";
$contraseña = "";
$BDnombre = "organiczoneBD";

$conn = new mysqli($servidor, $nombre, $contraseña, $BDnombre);

  if($conn->connect_error) {
    die ("conexion fallida" . $conn->connect_error);
  }
  $id= $_SESSION["CI"];
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h2>Reporte de Ingresos Totales por Día</h2>


    <div style="width: 500px; height: 300px;">
        <canvas id="graficoVentas"></canvas>
    </div>

    <script>
    const fecha = <?php echo json_encode($fecha); ?>;
    const ventas = <?php echo json_encode($ventas); ?>;

    const contexto = document.getElementById("graficoVentas");

        new Chart(contexto, {
            type: "bar", // Cambiado a barras para alinearlo con el de semana
            data: {
                labels: fecha,   // CORRECTO: Las fechas van en labels
                datasets: [{
                    label: "Ingresos Totales ($)",
                    data: ventas // CORRECTO: Los montos numéricos van en data
                }]
            },
            options: {
                responsive: true
            }
        });
    </script>
</body>
</html>