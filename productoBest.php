<?php
$servidor = "localhost";
$nombre = "root";
$contraseña = "";
$BDnombre = "organiczoneBD";
$conn = new mysqli($servidor, $nombre, $contraseña, $BDnombre);
if ($conn->connect_error) {
    die("Conexion fallida");
}
$sql = "SELECT productos.nombre, SUM(carrito.cantidad) AS cantidad
        FROM carrito
        INNER JOIN productos ON carrito.productos_id = productos.id
        GROUP BY productos.id, productos.nombre
        ORDER BY cantidad DESC";

$resultado = $conn->query($sql);

if (!$resultado) {
    die("Error en la consulta: " . $conn->error);
}

$resultado = $conn->query($sql);
$productos = [];
$cantidades = [];
while ($fila = $resultado->fetch_assoc()) {
    $productos[] = $fila['nombre'];
    $cantidades[] = $fila['cantidad'];
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Productos más vendidos</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<h1>Productos más vendidos</h1>
<canvas id="grafico"></canvas>
 <script>
        const data = {
            labels: <?php echo json_encode($productos); ?>,
            datasets: [{
                label: 'Productos vendidos',
                data: <?php echo json_encode($cantidades); ?>,
backgroundColor: [
    'rgba(255, 99, 132, 0.7)',
    'rgba(54, 162, 235, 0.7)',
    'rgba(255, 206, 86, 0.7)',
    'rgba(75, 192, 192, 0.7)',
    'rgba(153, 102, 255, 0.7)',
    'rgba(255, 159, 64, 0.7)',
    'rgba(46, 204, 113, 0.7)',
    'rgba(231, 76, 60, 0.7)',
    'rgba(52, 73, 94, 0.7)',
    'rgba(241, 196, 15, 0.7)'
],
borderColor: [
    'rgb(255, 99, 132)',
    'rgb(54, 162, 235)',
    'rgb(255, 206, 86)',
    'rgb(75, 192, 192)',
    'rgb(153, 102, 255)',
    'rgb(255, 159, 64)',
    'rgb(46, 204, 113)',
    'rgb(231, 76, 60)',
    'rgb(52, 73, 94)',
    'rgb(241, 196, 15)'
],
borderWidth: 2
            }]
        };

        const config = {
            type: 'bar',
            data: data,
            options: {
                indexAxis: 'y',

                elements: {
                    bar: {
                        borderWidth: 2
                    }
                },
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right'
                    },
                    title: {
                        display: true,
                        text: 'Productos más bestia '
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,

                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        };
        new Chart(
            document.getElementById('grafico'),
            config
        );
    </script>
</body>
</html>
<?php
$conn->close();
?>