<?php
if (isset($_GET['pedido'])) {
    $pedidos_id = $_GET['pedido'];
} else {
    die("No se recibió el pedido.");
}

$servidor = "localhost";
$nombre = "root";
$contraseña = "";
$BDnombre = "organiczoneBD";

$conn = new mysqli($servidor, $nombre, $contraseña, $BDnombre);

if($conn->connect_error) {
    die ("conexion fallida" . $conn->connect_error);
}

// Buscamos los productos del pedido para luego mostrar el stock
$sqlCarrito = "SELECT productos_id, cantidad FROM carrito WHERE pedidos_id = '$pedidos_id'";
$resultadoCarrito = $conn->query($sqlCarrito);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Registrar Venta - OrganicZone</title>
<!-- Tipografía Fredoka de Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
body {
    background: #EAF7EC;
    margin: 0;
    font-family: 'Fredoka', sans-serif;
    color: #111;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px;
    box-sizing: border-box;
}

/* Tarjeta principal estilo vistavendedor */
.caja-formulario {
    background: #46b666;
    width: 100%;
    max-width: 700px;
    border-radius: 45px;
    padding: 40px;
    box-sizing: border-box;
    box-shadow: 0 10px 25px rgba(0,0,0,0.12);
}

.caja-titulos {
    text-align: center;
    margin-bottom: 25px;
}

.texto-saludo {
    font-size: 32px;
    color: #EAF7EC;
    margin: 0;
    font-weight: 600;
}

.texto-rol {
    font-size: 52px;
    color: #2B140D;
    margin: -5px 0 0 0;
    font-weight: 700;
    line-height: 1;
}

/* Contenedor de la Tabla */
.caja-tabla {
    background: #0A4A1B;
    border-radius: 30px;
    padding: 20px;
    margin-bottom: 25px;
    overflow: hidden;
}

table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 8px;
}

th {
    color: #FCD09F;
    font-size: 18px;
    font-weight: 700;
    padding: 10px 15px;
    text-align: center;
}

td {
    background: #ffffff;
    color: #2B140D;
    font-size: 16px;
    font-weight: 600;
    padding: 12px 15px;
    text-align: center;
}

td:first-child {
    border-top-left-radius: 15px;
    border-bottom-left-radius: 15px;
}

td:last-child {
    border-top-right-radius: 15px;
    border-bottom-right-radius: 15px;
}

/* Sección del Pago */
.caja-pago {
    background: #FCD09F;
    border-radius: 30px;
    padding: 25px 30px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 15px;
}

.grupo-campo {
    display: flex;
    align-items: center;
    gap: 15px;
}

label {
    font-size: 22px;
    font-weight: 700;
    color: #2B140D;
}

select {
    font-family: 'Fredoka', sans-serif;
    font-size: 16px;
    font-weight: 600;
    color: #2B140D;
    background: #EAF7EC;
    border: none;
    padding: 10px 20px;
    border-radius: 20px;
    outline: none;
    cursor: pointer;
}

/* Botón principal estilo vistavendedor */
.boton-registrar {
    background: #2B140D;
    color: #ffffff;
    font-family: 'Fredoka', sans-serif;
    font-size: 20px;
    font-weight: 700;
    padding: 12px 40px;
    border-radius: 25px;
    border: none;
    cursor: pointer;
    transition: transform 0.2s ease, background-color 0.2s ease;
}

.boton-registrar:hover {
    transform: translateY(-2px);
    background: #1a0b08;
}

@media (max-width: 600px) {
    .caja-formulario {
        padding: 25px;
        border-radius: 30px;
    }
    .texto-rol {
        font-size: 40px;
    }
    .grupo-campo {
        flex-direction: column;
    }
}
</style>
</head>
<body>

<article class="caja-formulario">

    <header class="caja-titulos">
        <h3 class="texto-saludo">Productos del pedido</h3>
        <h1 class="texto-rol">Registrar Venta</h1>
    </header>

    <div class="caja-tabla">
        <table> 
            <tr> 
                <th>Producto</th> 
                <th>Stock disponible</th> 
                <th>Cantidad solicitada</th> 
            </tr>

            <?php 
            while ($producto = $resultadoCarrito->fetch_assoc()) { 
                $productos_id = $producto['productos_id']; 
                $cantidad = $producto['cantidad'];

                // Buscar el producto
                $sqlProducto = "SELECT nombre, stock FROM productos WHERE id = '$productos_id'";
                $resultadoProducto = $conn->query($sqlProducto); 
                $datosProducto = $resultadoProducto->fetch_assoc();
            ?>

            <tr> 
                <td><?php echo $datosProducto['nombre']; ?></td> 
                <td><?php echo $datosProducto['stock']; ?></td> 
                <td><?php echo $cantidad; ?></td> 
            </tr>

            <?php 
            } 
            ?> 
        </table> 
    </div>

    <form action="ventas.php" method="POST" class="caja-pago">

        <input type="hidden" name="pedidos_id" value="<?php echo $pedidos_id; ?>">

        <div class="grupo-campo">
            <label>Método de Pago:</label>
            <select name="metodo" required>
                <option value="">Seleccione</option>
                <option value="Efectivo">Efectivo</option>
                <option value="QR">QR</option>
                <option value="Transferencia">Transferencia</option>
            </select>
        </div>

        <button type="submit" class="boton-registrar">Registrar Venta</button>

    </form>

</article>

</body>
</html>

<?php 
    $conn->close(); 
?>