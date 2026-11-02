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



$sqlCarrito = "SELECT productos_id FROM carrito WHERE pedidos_id = '$pedidos_id'";
$resultadoCarrito = $conn->query($sqlCarrito);
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

.caja-formulario {
    width: 100%;
    max-width: 900px;
    display: grid;
    grid-template-columns: 1.15fr .85fr;
    background: var(--blanco);
    border-radius: 42px;
    overflow: hidden;
    box-shadow: 0 28px 65px rgba(43, 20, 13, .14);
}

.panel-pedido {
    padding: 48px 44px;
}

.texto-saludo {
    display: block;
    margin: 0 0 8px;
    color: var(--verde);
    font-family: 'Nunito', sans-serif;
    font-size: 11px;
    font-weight: 900;
    letter-spacing: 2px;
    text-transform: uppercase;
}

.texto-rol {
    margin: 0 0 32px;
    font-family: 'Fredoka', sans-serif;
    font-size: 42px;
    color: var(--cafe);
    font-weight: 700;
    line-height: 1;
    letter-spacing: -1px;
}

.lista-pedido {
    display: flex;
    flex-direction: column;
}

.fila-pedido-encabezado {
    display: flex;
    justify-content: space-between;
    padding: 0 2px 12px;
    color: var(--verde-oscuro);
    font-family: 'Fredoka', sans-serif;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: .6px;
    text-transform: uppercase;
}

.fila-pedido {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
    padding: 15px 2px;
    border-bottom: 1px dashed rgba(43, 20, 13, .15);
}

.fila-pedido:last-child {
    border-bottom: none;
}

.fila-pedido-nombre {
    font-family: 'Nunito', sans-serif;
    font-size: 15px;
    font-weight: 800;
    color: var(--cafe);
}

.fila-pedido-stock {
    flex-shrink: 0;
    padding: 6px 14px;
    border-radius: 100px;
    background: var(--verde-suave);
    color: var(--verde-oscuro);
    font-family: 'Nunito', sans-serif;
    font-size: 12px;
    font-weight: 900;
    white-space: nowrap;
}

.fila-pedido-vacio {
    padding: 18px 2px;
    color: var(--gris);
    font-family: 'Nunito', sans-serif;
    font-size: 14px;
    font-weight: 700;
}

.panel-pago {
    position: relative;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    justify-content: center;
    gap: 24px;
    padding: 48px 40px;
    background: var(--verde);
}

.panel-pago::before {
    content: "";
    position: absolute;
    z-index: 1;
    width: 260px;
    height: 260px;
    right: -95px;
    top: -95px;
    border-radius: 50%;
    background: var(--verde-profundo);
    opacity: .55;
}

.panel-pago::after {
    content: "";
    position: absolute;
    z-index: 1;
    width: 170px;
    height: 170px;
    left: -65px;
    bottom: -65px;
    border-radius: 50%;
    background: var(--crema);
    opacity: .16;
}

.panel-pago-etiqueta {
    position: relative;
    z-index: 2;
    display: block;
    color: var(--crema);
    font-family: 'Nunito', sans-serif;
    font-size: 11px;
    font-weight: 900;
    letter-spacing: 2px;
    text-transform: uppercase;
}

.panel-pago h2 {
    position: relative;
    z-index: 2;
    margin: 6px 0 0;
    color: var(--blanco);
    font-family: 'Fredoka', sans-serif;
    font-size: 27px;
    font-weight: 700;
    line-height: 1.05;
}

form.panel-pago-form {
    position: relative;
    z-index: 2;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.grupo-campo {
    display: flex;
    flex-direction: column;
    gap: 9px;
}

.grupo-campo label {
    font-family: 'Nunito', sans-serif;
    font-size: 13px;
    font-weight: 800;
    color: var(--crema);
}

select {
    width: 100%;
    height: 50px;
    padding: 0 18px;
    font-family: 'Nunito', sans-serif;
    font-size: 15px;
    font-weight: 700;
    color: var(--cafe);
    background: var(--blanco);
    border: 3px solid transparent;
    border-radius: 16px;
    outline: none;
    cursor: pointer;
    transition: .3s ease;
}

select:focus {
    border-color: var(--crema);
}

select.error {
    border-color: var(--cafe);
}

label.error {
    color: var(--cafe-2) !important;
    font-family: 'Nunito', sans-serif !important;
    font-size: 13px !important;
    font-weight: 800 !important;
}

.boton-registrar {
    width: 100%;
    height: 52px;
    margin-top: 6px;
    background: var(--crema);
    color: var(--cafe);
    font-family: 'Fredoka', sans-serif;
    font-size: 18px;
    font-weight: 600;
    border: none;
    border-radius: 16px;
    cursor: pointer;
    transition: .25s ease;
}

.boton-registrar:hover {
    background: var(--blanco);
    transform: translateY(-2px);
    box-shadow: 0 10px 24px rgba(43, 20, 13, .22);
}

.boton-registrar:active {
    transform: scale(.98);
}

.boton-volver {
    position: relative;
    z-index: 2;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    margin-top: 2px;
    color: rgba(255, 255, 255, .78);
    font-family: 'Nunito', sans-serif;
    font-size: 12px;
    font-weight: 800;
    text-decoration: none;
    transition: color .2s ease;
}

.boton-volver:hover {
    color: var(--crema);
}

@media (max-width: 760px) {

    body {
        padding: 15px;
    }

    .caja-formulario {
        grid-template-columns: 1fr;
        max-width: 460px;
        border-radius: 32px;
    }

    .panel-pedido,
    .panel-pago {
        padding: 34px 26px;
    }

    .texto-rol {
        font-size: 34px;
        margin-bottom: 24px;
    }

    .fila-pedido-nombre {
        font-size: 14px;
    }

    .panel-pago h2 {
        font-size: 23px;
    }

}
</style>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/organiczoneOF/includes/oz-navegacion.php'; ?>
</head>

<body>

<article class="caja-formulario">

    <div class="panel-pedido">

        <span class="texto-saludo">Productos del pedido</span>
        <h1 class="texto-rol">Registrar Venta</h1>

        <div class="lista-pedido">

            <div class="fila-pedido-encabezado">
                <span>Producto</span>
                <span>Stock disponible</span>
            </div>

            <?php

            if ($resultadoCarrito->num_rows > 0) {
                while ($producto = $resultadoCarrito->fetch_assoc()) {
                    $productos_id = $producto['productos_id'];


                    $sqlProducto = "SELECT nombre, stock FROM productos WHERE id = '$productos_id'";
                    $resultadoProducto = $conn->query($sqlProducto);
                    $datosProducto = $resultadoProducto->fetch_assoc();
                    $stock = $datosProducto['stock'];

            ?>
            <div class="fila-pedido">
                <span class="fila-pedido-nombre"><?php echo $datosProducto['nombre']; ?></span>
                <span class="fila-pedido-stock"><?php echo $stock; ?></span>
            </div>
            <?php
                }
            } else {
            ?>
            <p class="fila-pedido-vacio">No hay productos registrados en este pedido.</p>
            <?php
            }
            ?>

        </div>

    </div>

    <div class="panel-pago">

        <div>
            <span class="panel-pago-etiqueta">Confirmar venta</span>
            <h2>Elige el método de pago</h2>
        </div>

        <form action="ventas.php" method="POST" class="panel-pago-form" id="formVenta" novalidate>

            <input type="hidden" name="pedidos_id" value="<?php echo htmlspecialchars($pedidos_id); ?>" >

            <div class="grupo-campo">

                <label for="metodo">Método de Pago</label>

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

    </div>

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
$conn->close();
?>