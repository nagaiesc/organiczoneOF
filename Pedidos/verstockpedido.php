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
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        :root {
            --verde: #0BA84A;
            --verde-oscuro: #087A36;
            --verde-profundo: #064D22;
            --verde-suave: #E5F7EA;

            --cafe: #2B140D;
            --cafe-2: #3A1E13;

            --crema: #FCD09F;

            --fondo: #F5EEE3;
            --blanco: #FFFFFF;

            --gris: #766E69;
            --rojo: #D62828;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: var(--fondo);
            margin: 0;
            font-family: 'Nunito', sans-serif;
            color: var(--cafe);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 30px;
        }

        /* TARJETA PRINCIPAL (base café) */
        .caja-formulario {
            position: relative;
            overflow: hidden;
            width: 100%;
            max-width: 900px;
            padding: 48px 44px;
            background: var(--cafe);
            border-radius: 42px;
            box-shadow: 0 28px 65px rgba(43, 20, 13, .24);
        }

        .caja-formulario::before {
            content: "";
            position: absolute;
            z-index: 1;
            width: 300px;
            height: 300px;
            right: -110px;
            top: -110px;
            border-radius: 50%;
            background: var(--verde);
            opacity: .85;
        }

        .caja-formulario::after {
            content: "";
            position: absolute;
            z-index: 1;
            width: 190px;
            height: 190px;
            left: -70px;
            bottom: -70px;
            border-radius: 50%;
            background: var(--crema);
            opacity: .16;
        }

        .caja-formulario > * {
            position: relative;
            z-index: 2;
        }

        /* TITULOS */
        .caja-titulos {
            margin-bottom: 32px;
        }

        .texto-saludo {
            display: block;
            margin: 0 0 8px;
            color: var(--crema);
            font-family: 'Nunito', sans-serif;
            font-size: 11px;
            font-weight: 900;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .texto-rol {
            margin: 0;
            font-family: 'Fredoka', sans-serif;
            font-size: 42px;
            color: var(--blanco);
            font-weight: 700;
            line-height: 1;
            letter-spacing: -1px;
        }

        /* TABLA */
        .caja-tabla {
            margin-bottom: 26px;
            padding: 12px 26px 10px;
            background: rgba(255, 255, 255, .06);
            border: 1px solid rgba(252, 208, 159, .16);
            border-radius: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            padding: 12px 10px;
            color: var(--crema);
            font-family: 'Fredoka', sans-serif;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .6px;
            text-align: center;
            text-transform: uppercase;
        }

        td {
            padding: 16px 10px;
            border-top: 1px dashed rgba(252, 208, 159, .22);
            color: var(--blanco);
            font-family: 'Nunito', sans-serif;
            font-size: 15px;
            font-weight: 800;
            text-align: center;
        }

        th:first-child,
        td:first-child {
            text-align: left;
        }

        th:last-child,
        td:last-child {
            text-align: right;
        }

        .celda-vacia {
            padding: 22px 10px;
            color: rgba(255, 255, 255, .7);
            font-size: 14px;
            font-weight: 700;
            text-align: center !important;
        }

        /* Número en forma de pastilla */
        .pastilla-numero {
            display: inline-block;
            min-width: 46px;
            padding: 6px 14px;
            border-radius: 100px;
            background: rgba(252, 208, 159, .16);
            color: var(--crema);
            font-size: 13px;
            font-weight: 900;
        }

        /* STOCK SUFICIENTE */
        .stock-ok,
        .stock-no {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 100px;
            font-size: 12px;
            font-weight: 900;
            white-space: nowrap;
        }

        .stock-ok {
            background: var(--verde);
            color: var(--blanco);
        }

        /* STOCK INSUFICIENTE */
        .stock-no {
            background: #FBE5E2;
            color: var(--rojo);
        }

        /* MENSAJE */
        .mensaje {
            margin-bottom: 22px;
            padding: 18px 22px;
            border-radius: 22px;
            text-align: center;
            font-family: 'Fredoka', sans-serif;
            font-size: 19px;
            font-weight: 600;
        }

        .mensaje.ok {
            background: var(--verde);
            color: var(--blanco);
        }

        .mensaje.no {
            background: var(--crema);
            color: var(--cafe);
        }

        /* BOTON */
        .boton-volver {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: fit-content;
            margin: 0 auto;
            padding: 14px 38px;
            background: var(--crema);
            color: var(--cafe);
            text-decoration: none;
            font-family: 'Fredoka', sans-serif;
            font-size: 18px;
            font-weight: 600;
            border-radius: 16px;
            transition: .25s ease;
        }

        .boton-volver:hover {
            background: var(--blanco);
            transform: translateY(-2px);
            box-shadow: 0 10px 24px rgba(0, 0, 0, .28);
        }

        .boton-volver:active {
            transform: scale(.98);
        }

        @media (max-width: 760px) {

            body {
                padding: 15px;
            }

            .caja-formulario {
                max-width: 520px;
                padding: 34px 24px;
                border-radius: 32px;
            }

            .texto-rol {
                font-size: 34px;
            }

            .caja-tabla {
                padding: 8px 18px;
                border-radius: 24px;
            }

            /* Cada producto pasa a ser una ficha vertical */
            table,
            tbody,
            tr,
            td {
                display: block;
                width: 100%;
            }

            tr:first-child:has(th) {
                display: none;
            }

            tr {
                padding: 12px 0;
                border-top: 1px dashed rgba(252, 208, 159, .22);
            }

            tr:first-of-type,
            tr:nth-child(2) {
                border-top: 0;
            }

            td {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 12px;
                padding: 6px 0;
                border: 0;
                text-align: right;
            }

            td[data-label]::before {
                content: attr(data-label);
                color: var(--crema);
                font-family: 'Fredoka', sans-serif;
                font-size: 11px;
                font-weight: 600;
                letter-spacing: .6px;
                text-transform: uppercase;
            }

            td:first-child {
                text-align: left;
            }

            .celda-vacia {
                display: block;
                text-align: center !important;
            }

            .mensaje {
                font-size: 16px;
            }
        }
    </style>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/organiczoneOF/includes/oz-navegacion.php'; ?>
</head>
<body>

<article class="caja-formulario">

    <header class="caja-titulos">
        <span class="texto-saludo">Productos del pedido</span>
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
                        $estadoStock = "SI Suficiente";
                        $claseStock = "stock-ok";
                    } else {
                        $estadoStock = "NO Insuficiente";
                        $claseStock = "stock-no";
                        $hayStock = false;
                    }
            ?>
            <tr>
                <td data-label="Producto"><?php echo $datosProducto['nombre']; ?></td>
                <td data-label="Stock disponible"><span class="pastilla-numero"><?php echo $stock; ?></span></td>
                <td data-label="Cantidad solicitada"><span class="pastilla-numero"><?php echo $cantidad; ?></span></td>
                <td data-label="Estado"><span class="<?php echo $claseStock; ?>"><?php echo $estadoStock; ?></span></td>
            </tr>
            <?php
                }
            } else {
            ?>
            <tr>
                <td colspan="4" class="celda-vacia">No hay productos registrados en este pedido.</td>
            </tr>
            <?php
            }
            ?>
        </table>
    </div>

    <?php
    if ($resultadoCarrito->num_rows > 0) {
        if ($hayStock) {
            echo "<div class='mensaje ok'>SI Hay stock suficiente para aceptar este pedido.</div>";
        } else {
            echo "<div class='mensaje no'>NO Hay suficiente stock para aceptar este pedido.</div>";
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