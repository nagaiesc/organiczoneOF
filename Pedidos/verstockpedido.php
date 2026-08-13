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

if ($conn->connect_error) {
    die("conexion fallida" . $conn->connect_error);
}

/* Buscar los productos del pedido */
$sqlCarrito = "SELECT productos_id, cantidad FROM carrito WHERE pedidos_id = '$pedidos_id'";
$resultadoCarrito = $conn->query($sqlCarrito);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock del Pedido - OrganicZone</title>

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

        /* TARJETA PRINCIPAL */
        .caja-formulario {
            background: #46b666;
            width: 100%;
            max-width: 850px;
            border-radius: 45px;
            padding: 40px;
            box-sizing: border-box;
            box-shadow: 0 10px 25px rgba(0,0,0,0.12);
        }

        /* TITULOS */
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

        /* TABLA */
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

        /* STOCK SUFICIENTE */
        .stock-ok {
            color: #16823b;
            font-weight: 700;
        }

        /* STOCK INSUFICIENTE */
        .stock-no {
            color: #d62828;
            font-weight: 700;
        }

        /* MENSAJE */
        .mensaje {
            background: #FCD09F;
            color: #2B140D;
            border-radius: 25px;
            padding: 18px;
            text-align: center;
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        /* BOTON */
        .boton-volver {
            display: block;
            width: fit-content;
            margin: auto;
            background: #2B140D;
            color: #ffffff;
            text-decoration: none;
            font-family: 'Fredoka', sans-serif;
            font-size: 18px;
            font-weight: 700;
            padding: 12px 35px;
            border-radius: 25px;
            transition: transform 0.2s ease, background-color 0.2s ease;
        }

        .boton-volver:hover {
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
            th, td {
                font-size: 14px;
                padding: 9px 5px;
            }
        }
    </style>
</head>
<body>

<article class="caja-formulario">

    <header class="caja-titulos">
        <h3 class="texto-saludo">Productos del pedido</h3>
        <h1 class="texto-rol">Ver Stock</h1>
    </header>

    <div class="caja-tabla">
        <table>
            <tr>
                <th>Producto</th>
                <th>Stock disponible</th>
                <th>Cantidad solicitada</th>
                <th>Estado</th>
            </tr>
            <?php
            $hayStock = true;

            if ($resultadoCarrito->num_rows > 0) {
                while ($producto = $resultadoCarrito->fetch_assoc()) {
                    $productos_id = $producto['productos_id'];
                    $cantidad = $producto['cantidad'];

                    /* Buscar el producto */
                    $sqlProducto = "SELECT nombre, stock FROM productos WHERE id = '$productos_id'";
                    $resultadoProducto = $conn->query($sqlProducto);
                    $datosProducto = $resultadoProducto->fetch_assoc();
                    $stock = $datosProducto['stock'];

                    /* Comprobar stock */
                    if ($stock >= $cantidad) {
                        $estadoStock = "✓ Suficiente";
                        $claseStock = "stock-ok";
                    } else {
                        $estadoStock = "✗ Insuficiente";
                        $claseStock = "stock-no";
                        $hayStock = false;
                    }
            ?>
            <tr>
                <td><?php echo $datosProducto['nombre']; ?></td>
                <td><?php echo $stock; ?></td>
                <td><?php echo $cantidad; ?></td>
                <td class="<?php echo $claseStock; ?>"><?php echo $estadoStock; ?></td>
            </tr>
            <?php
                }
            } else {
            ?>
            <tr>
                <td colspan="4">No hay productos registrados en este pedido.</td>
            </tr>
            <?php
            }
            ?>
        </table>
    </div>

    <?php
    if ($resultadoCarrito->num_rows > 0) {
        if ($hayStock) {
            echo "<div class='mensaje'>✓ Hay stock suficiente para aceptar este pedido.</div>";
        } else {
            echo "<div class='mensaje'>✗ No hay suficiente stock para aceptar este pedido.</div>";
        }
    }
    ?>

    <a href="leerpedidos.php" class="boton-volver">← Volver a pedidos</a>

</article>

</body>
</html>
<?php
$conn->close();
?>