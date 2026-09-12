<?php
session_start();

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
    die("Conexión fallida: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

$sqlCarrito = "SELECT productos_id, cantidad FROM carrito WHERE pedidos_id = ?";
$stmtCarrito = $conn->prepare($sqlCarrito);
$stmtCarrito->bind_param("i", $pedidos_id);
$stmtCarrito->execute();
$resultadoCarrito = $stmtCarrito->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Registrar Venta - OrganicZone</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">

<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/localization/messages_es.min.js"></script>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    background: #F5EEE3;
    margin: 0;
    font-family: 'Nunito', sans-serif;
    color: #2B140D;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 30px;
}

.caja-formulario {
    background: #12A33C;
    width: 100%;
    max-width: 760px;
    border-radius: 38px;
    padding: 38px;
    box-shadow: 0 18px 45px rgba(43, 20, 13, .15);
}

.caja-titulos {
    text-align: center;
    margin-bottom: 25px;
}

.texto-saludo {
    font-family: 'Fredoka', sans-serif;
    font-size: 30px;
    color: #FCD09F;
    margin: 0;
    font-weight: 600;
}

.texto-rol {
    font-family: 'Fredoka', sans-serif;
    font-size: 54px;
    color: #FFFFFF;
    margin: 0;
    font-weight: 700;
    line-height: 1;
}

.caja-tabla {
    background: #0A4A1B;
    border-radius: 27px;
    padding: 18px;
    margin-bottom: 25px;
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 8px;
}

th {
    color: #FCD09F;
    font-family: 'Fredoka', sans-serif;
    font-size: 17px;
    font-weight: 600;
    padding: 10px 12px;
    text-align: center;
}

td {
    background: #FFFFFF;
    color: #2B140D;
    font-family: 'Nunito', sans-serif;
    font-size: 16px;
    font-weight: 700;
    padding: 13px 12px;
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

.caja-pago {
    background: #FCD09F;
    border-radius: 27px;
    padding: 24px 28px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 15px;
}

.grupo-campo {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 15px;
}

.grupo-campo label {
    font-family: 'Fredoka', sans-serif;
    font-size: 21px;
    font-weight: 600;
    color: #2B140D;
}

select {
    height: 48px;
    min-width: 220px;
    padding: 0 18px;
    font-family: 'Nunito', sans-serif;
    font-size: 16px;
    font-weight: 700;
    color: #2B140D;
    background: #FFFFFF;
    border: 3px solid transparent;
    border-radius: 50px;
    outline: none;
    cursor: pointer;
    transition: .3s ease;
}

select:focus {
    border-color: #12A33C;
}

select.error {
    border-color: #B83232;
}

label.error {
    color: #B83232 !important;
    font-family: 'Nunito', sans-serif !important;
    font-size: 14px !important;
    font-weight: 800 !important;
}

.boton-registrar {
    min-width: 220px;
    height: 50px;
    background: #2B140D;
    color: #FFFFFF;
    font-family: 'Fredoka', sans-serif;
    font-size: 20px;
    font-weight: 600;
    padding: 0 35px;
    border-radius: 50px;
    border: none;
    cursor: pointer;
    transition: .3s ease;
}

.boton-registrar:hover {
    background: #0A4A1B;
    transform: translateY(-2px);
    box-shadow: 0 8px 18px rgba(43, 20, 13, .20);
}

.boton-registrar:active {
    transform: scale(.98);
}

@media (max-width: 650px) {
    body {
        padding: 15px;
    }

    .caja-formulario {
        padding: 25px 18px;
        border-radius: 30px;
    }

    .texto-saludo {
        font-size: 25px;
    }

    .texto-rol {
        font-size: 42px;
    }

    .caja-tabla {
        padding: 12px;
    }

    th {
        font-size: 14px;
    }

    td {
        font-size: 14px;
        padding: 11px 8px;
    }

    .caja-pago {
        padding: 22px 15px;
    }

    .grupo-campo {
        flex-direction: column;
        gap: 8px;
    }

    .grupo-campo label {
        font-size: 19px;
    }

    select {
        width: 100%;
        min-width: 0;
    }

    .boton-registrar {
        width: 100%;
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

                $sqlProducto = "SELECT nombre, stock FROM productos WHERE id = ?";
                $stmtProducto = $conn->prepare($sqlProducto);
                $stmtProducto->bind_param("i", $productos_id);
                $stmtProducto->execute();

                $resultadoProducto = $stmtProducto->get_result();
                $datosProducto = $resultadoProducto->fetch_assoc();
            ?>

            <tr>
                <td>
                    <?php echo htmlspecialchars($datosProducto['nombre']); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($datosProducto['stock']); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($cantidad); ?>
                </td>
            </tr>

            <?php
                $stmtProducto->close();
            }
            ?>

        </table>

    </div>

    <form action="ventas.php" method="POST" class="caja-pago" id="formVenta" novalidate>

        <input type="hidden" name="pedidos_id" value="<?php echo htmlspecialchars($pedidos_id); ?>" >

        <div class="grupo-campo">

            <label for="metodo">Método de Pago:</label>

            <select name="metodo" id="metodo" >
                <option value="Efectivo">Efectivo</option>
                <option value="QR">QR</option>
                <option value="Transferencia">Transferencia</option>
            </select>

        </div>

        <button type="submit" class="boton-registrar">
            Registrar Venta
        </button>

    </form>

    <a href="../Pedidos/leerpedidos.php" class="boton-volver">
        ← Volver a pedidos
    </a>

</article>

<script>
$(document).ready(function() {

    $("#formVenta").validate({

        rules: {
            metodo: {
                required: true
            }
        },

        messages: {
            metodo: {
                required: "Selecciona un método de pago"
            }
        },

        errorElement: "label",

        errorPlacement: function(error, element) {
            error.insertAfter(element);
        },

        highlight: function(element) {
            $(element).addClass("error");
        },

        unhighlight: function(element) {
            $(element).removeClass("error");
        },

        submitHandler: function(form) {
            form.submit();
        }

    });

});
</script>

</body>
</html>

<?php
$stmtCarrito->close();
$conn->close();
?>