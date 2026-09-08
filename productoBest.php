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
        INNER JOIN ventas ON carrito.pedidos_id = ventas.pedidos_id
        GROUP BY productos.id
        ORDER BY cantidad DESC";
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
        borderColor: 'rgb(75, 192, 192)',
        backgroundColor: 'rgb(75, 192, 192)',
        fill: false
    }]
};

const config = {
    type: 'line',
    data: data,
    options: {
        scales: {
            y: {
                beginAtZero: true
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