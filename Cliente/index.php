<?php
session_start();

$conexion = new mysqli('localhost', 'root', '', 'organiczoneBD');

if ($conexion->connect_error) {
    die('Error de conexión con la base de datos.');
}

$conexion->set_charset('utf8mb4');

if (isset($_GET['pedido'])) {
    $pedidoId = (int) $_GET['pedido'];

    if ($pedidoId > 0) {
        $_SESSION['pedido_id'] = $pedidoId;
    }
} else {
    $pedidoId = isset($_SESSION['pedido_id']) ? (int) $_SESSION['pedido_id'] : 0;
}

$pedidoEstado = '';
$pedidoConfirmado = !empty($_SESSION['pedido_confirmado']);

if ($pedidoId > 0) {
    $stmtPedido = $conexion->prepare(
        'SELECT id, estado, nombre, direccion, telefono, metodo
         FROM pedidos
         WHERE id = ?
         LIMIT 1'
    );

    $stmtPedido->bind_param('i', $pedidoId);
    $stmtPedido->execute();

    $resultadoPedido = $stmtPedido->get_result();
    $pedido = $resultadoPedido->fetch_assoc();

    $stmtPedido->close();

    if ($pedido) {
        $pedidoEstado = $pedido['estado'];

        if ($pedidoEstado !== 'Pendiente') {
            $pedidoConfirmado = true;
        }
    } else {
        unset(
            $_SESSION['pedido_id'],
            $_SESSION['pedido_confirmado']
        );

        $pedidoId = 0;
        $pedidoEstado = '';
        $pedidoConfirmado = false;
    }
}

$resultadoProductos = $conexion->query(
    'SELECT id, nombre, descripcion, precio, stock
     FROM productos
     ORDER BY id DESC'
);

function obtenerImagenProducto(int $id): string
{
    $extensiones = [
        'jpg',
        'jpeg',
        'png',
        'gif',
        'webp'
    ];

    foreach ($extensiones as $extension) {
        $rutaFisica = __DIR__ . '/../Imagenes/P-' . $id . '.' . $extension;

        if (file_exists($rutaFisica)) {
            return '../Imagenes/P-' . $id . '.' . $extension;
        }
    }

    return '../Imagenes/predeterminado.png';
}
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Organic Zone | Cliente</title>

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Nunito:wght@400;600;700;800&display=swap"
        rel="stylesheet"
    >

    <link rel="stylesheet" href="css/cliente.css">


<?php include $_SERVER['DOCUMENT_ROOT'] . '/organiczoneOF/includes/oz-navegacion.php'; ?>

    <!-- =====================================================
         MEDIA CELULAR - BARRA CLIENTE
         Solo afecta pantallas de 980px o menos.
         Escritorio queda exactamente igual que antes.
         Medidas tomadas del nav principal (#barra).
         ===================================================== -->
    <style>

    @media (max-width: 980px) {

        html,
        body {
            max-width: 100%;
            overflow-x: hidden;
        }

        /* ---------- BARRA (2 filas dentro de una sola píldora) ---------- */

        .barra-cliente {
            position: relative !important;
            top: auto !important;
            left: auto !important;
            right: auto !important;
            transform: none !important;

            width: calc(100% - 16px) !important;
            max-width: none !important;
            min-height: 60px;

            margin: 76px auto 0 !important;
            padding: 6px 10px 4px !important;

            display: flex !important;
            flex-wrap: wrap !important;
            align-items: center !important;
            justify-content: flex-start !important;
            gap: 4px !important;

            background: rgba(18, 163, 60, 0.96) !important;
            border-radius: 30px !important;
            box-shadow: 0 10px 28px rgba(18, 163, 60, 0.20) !important;

            font-family: 'Fredoka', sans-serif;

            z-index: 900;
        }

        /* ---------- FILA 1: logo · hola nombre · carrito · salir ---------- */

        /* Logo apilado My / Oz (igual que el nav) */
        .barra-cliente .logo {
            order: 1;

            width: 50px;
            min-width: 50px;
            height: 50px;

            margin: 0 2px 0 0;
            padding: 0;

            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;

            font-size: 0;
            line-height: 0.75;
            white-space: nowrap;
            text-decoration: none;
        }

        .barra-cliente .logo span {
            display: block;
            margin: 0 0 1px;
            padding: 0;

            color: #FFFFFF;
            font-family: 'Fredoka', sans-serif;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .barra-cliente .logo::after {
            content: "Oz";
            color: #FCD09F;
            font-family: 'Fredoka', sans-serif;
            font-size: 26px;
            font-weight: 700;
            letter-spacing: -1px;
            line-height: 0.8;
            margin-top: 0.5px;
        }

        /* Los hijos de acciones-header pasan a ser parte de la fila */
        .barra-cliente .acciones-header {
            display: contents !important;
        }

        /* Mensaje "Hola, nombre" en dos líneas */
        .barra-cliente .usuario-mini {
            order: 2;

            flex: 1 1 0;
            min-width: 0;
            height: 40px;

            margin: 0;
            padding: 0 12px;

            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;

            overflow: hidden;

            color: #FFFFFF;
            background: rgba(255, 255, 255, 0.18);
            border-radius: 20px;

            font-family: 'Fredoka', sans-serif;
            line-height: 1.05;
            text-align: center;
        }

        .barra-cliente .usuario-mini span {
            font-size: 10.5px;
            font-weight: 500;
            opacity: 0.9;
        }

        .barra-cliente .usuario-mini strong {
            max-width: 100%;

            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;

            color: #FCD09F;
            font-size: 13.5px;
            font-weight: 700;
        }

        /* Carrito circular (igual que el botón de puntitos del nav) */
        .barra-cliente .boton-carrito {
            order: 3;
            position: relative;

            width: 40px;
            height: 40px;
            min-width: 40px;

            margin: 0;
            padding: 0;

            display: flex;
            align-items: center;
            justify-content: center;

            border: none;
            border-radius: 50%;

            color: #FFFFFF;
            background: rgba(255, 255, 255, 0.18);

            font-size: 15px;
            cursor: pointer;

            -webkit-tap-highlight-color: transparent;
        }

        .barra-cliente #contadorCarrito {
            position: absolute;
            top: -3px;
            right: -3px;

            min-width: 18px;
            height: 18px;
            padding: 0 4px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 9px;

            color: #2B140D;
            background: #FCD09F;

            font-family: 'Fredoka', sans-serif;
            font-size: 11px;
            font-weight: 700;
            line-height: 1;
        }

        /* Salir / Iniciar sesión (igual que .boton-sesion del nav) */
        .barra-cliente .boton-salir {
            order: 4;

            height: 40px;
            margin: 0;
            padding: 0 13px;

            display: flex;
            align-items: center;
            justify-content: center;

            flex-shrink: 0;

            color: #2B140D;
            background: #FCD09F;
            border: none;
            border-radius: 20px;
            text-decoration: none;

            font-family: 'Fredoka', sans-serif;
            font-size: 13px;
            font-weight: 600;
            white-space: nowrap;
        }

        /* ---------- FILA 2: Productos · Mis pedidos · Contacto ---------- */

        .barra-cliente .nav-cliente {
            order: 5;

            flex: 0 0 100%;
            width: 100%;

            margin: 2px 0 0;
            padding: 4px 0 0;

            display: flex;
            align-items: center;
            justify-content: space-evenly;
            gap: 0;

            border-top: 1px solid rgba(255, 255, 255, 0.25);
        }

        .barra-cliente .nav-cliente a {
            height: 36px;
            padding: 0 10px;

            display: flex;
            align-items: center;
            justify-content: center;

            color: #FFFFFF;
            border-radius: 18px;
            text-decoration: none;

            font-family: 'Fredoka', sans-serif;
            font-size: 14px;
            font-weight: 600;
            white-space: nowrap;
        }

        .barra-cliente .nav-cliente a:hover {
            background: rgba(255, 255, 255, 0.15);
        }
    }


    /* ---------- CELULARES ANGOSTOS (mismos cortes del nav) ---------- */

    @media (max-width: 400px) {

        .barra-cliente {
            width: calc(100% - 10px) !important;
            margin-top: 72px !important;
            padding: 5px 8px 3px !important;
            gap: 3px !important;
        }

        .barra-cliente .logo {
            width: 44px;
            min-width: 44px;
            height: 44px;
        }

        .barra-cliente .logo span {
            font-size: 11px;
        }

        .barra-cliente .logo::after {
            font-size: 23px;
        }

        .barra-cliente .usuario-mini {
            height: 36px;
            padding: 0 8px;
        }

        .barra-cliente .usuario-mini strong {
            font-size: 13px;
        }

        .barra-cliente .boton-carrito {
            width: 36px;
            height: 36px;
            min-width: 36px;
        }

        .barra-cliente .boton-salir {
            height: 36px;
            padding: 0 10px;
            font-size: 12px;
        }

        .barra-cliente .nav-cliente a {
            padding: 0 6px;
            font-size: 13px;
        }
    }

    @media (max-width: 360px) {

        .barra-cliente .logo {
            width: 40px;
            min-width: 40px;
            height: 40px;
        }

        .barra-cliente .logo::after {
            font-size: 21px;
        }

        .barra-cliente .boton-salir {
            padding: 0 8px;
            font-size: 11.5px;
        }

        .barra-cliente .nav-cliente a {
            padding: 0 4px;
            font-size: 12.5px;
        }
    }

    </style>

</head>

<body>

<header class="barra-cliente">

    <a class="logo" href="../paginaprincipal.php">
        <span>My</span> Oz
    </a>

    <nav class="nav-cliente">

        <a href="#productos">
            Productos
        </a>

        <a href="consultar_pedido.php">
            Mis pedidos
        </a>

        <a href="../contacto.php">
            Contacto
        </a>

    </nav>

    <div class="acciones-header">

        <div class="usuario-mini">

            <?php if (!empty($_SESSION['nombre'])): ?>

                <span>
                    Hola,
                </span>

                <strong>
                    <?= htmlspecialchars($_SESSION['nombre']) ?>
                </strong>

            <?php else: ?>

                <span>
                    Compra
                </span>

                <strong>
                    Sin registro
                </strong>

            <?php endif; ?>

        </div>

        <button
            type="button"
            class="boton-carrito"
            id="abrirCarrito"
            aria-label="Abrir carrito"
        >

            <i class="fa-solid fa-cart-shopping"></i>

            <span id="contadorCarrito">
                0
            </span>

        </button>

        <?php if (!empty($_SESSION['nombre'])): ?>

            <a
                class="boton-salir"
                href="../Usuarios/cerrarse.php"
            >
                Salir
            </a>

        <?php else: ?>

            <a
                class="boton-salir"
                href="../Usuarios/formulariosesion.php"
            >
                Iniciar sesión
            </a>

        <?php endif; ?>

    </div>

</header>

<main class="contenedor-principal">

    <section class="hero-cliente">

        <div class="hero-texto">

            <p class="etiqueta">
                ORGANIC ZONE
            </p>

            <h1>
                Disfruta algo
                <br>
                <span>delicioso.</span>
            </h1>

            <p class="hero-descripcion">
                Elige tus productos favoritos y arma tu pedido
                de forma rápida y sencilla.
            </p>

            <?php if ($pedidoId > 0): ?>

                <div class="pedido-activo">

                    <span>
                        Pedido activo
                    </span>

                    <strong>
                        #<?= $pedidoId ?>
                    </strong>

                    <small>
                        <?= htmlspecialchars($pedidoEstado) ?>
                    </small>

                </div>

            <?php else: ?>

                <button
                    type="button"
                    class="boton-principal"
                    id="abrirPedido"
                >
                    Generar pedido
                </button>

            <?php endif; ?>

        </div>

        <div class="hero-imagen">

            <img
                src="../chkioz.jpg"
                alt="Producto Organic Zone"
            >

        </div>

    </section>

    <section
        class="seccion-productos"
        id="productos"
    >

        <div class="titulo-seccion">

            <div>

                <p>
                    ELIGE TUS FAVORITOS
                </p>

                <h2>
                    Nuestros productos
                </h2>

            </div>

            <div
                class="estado-compra <?= $pedidoId > 0 ? 'activo' : '' ?>"
                id="estadoCompra"
            >

                <?php if ($pedidoId > 0): ?>

                    <span class="punto"></span>

                    Pedido #<?= $pedidoId ?>
                    listo para agregar productos

                <?php else: ?>

                    <span class="punto bloqueado"></span>

                    Genera un pedido para comprar

                <?php endif; ?>

            </div>

        </div>

        <div class="productos-grid">

            <?php if ($resultadoProductos && $resultadoProductos->num_rows > 0): ?>

                <?php while ($producto = $resultadoProductos->fetch_assoc()): ?>

                    <?php

                    $idProducto = (int) $producto['id'];

                    $stockProducto = (int) ($producto['stock'] ?? 0);

                    $sinStock = $stockProducto <= 0;

                    $imagen = obtenerImagenProducto($idProducto);

                    ?>

                    <article class="producto-card">

                        <div class="producto-imagen-wrap">

                            <img
                                src="<?= htmlspecialchars($imagen) ?>"
                                alt="<?= htmlspecialchars($producto['nombre']) ?>"
                            >

                            <?php if ($sinStock): ?>

                                <span class="etiqueta-stock sin-stock">
                                    Sin stock
                                </span>

                            <?php else: ?>

                                <span class="etiqueta-stock">
                                    Stock: <?= $stockProducto ?>
                                </span>

                            <?php endif; ?>

                        </div>

                        <div class="producto-info">

                            <h3>
                                <?= htmlspecialchars($producto['nombre']) ?>
                            </h3>

                            <p>
                                <?= htmlspecialchars($producto['descripcion']) ?>
                            </p>

                            <div class="producto-pie">

                                <strong>
                                    Bs.
                                    <?= number_format(
                                        (float) $producto['precio'],
                                        0,
                                        ',',
                                        '.'
                                    ) ?>
                                </strong>

                                <button
                                    type="button"
                                    class="boton-agregar"
                                    data-producto-id="<?= $idProducto ?>"
                                    <?= (
                                        $pedidoId <= 0 ||
                                        $pedidoConfirmado ||
                                        $sinStock
                                    ) ? 'disabled' : '' ?>
                                >
                                    Agregar
                                </button>

                            </div>

                        </div>

                    </article>

                <?php endwhile; ?>

            <?php else: ?>

                <div class="sin-productos">
                    No hay productos disponibles en este momento.
                </div>

            <?php endif; ?>

        </div>

    </section>

    <section class="seccion-informacion">

        <div class="info-card verde">

            <span>
                01
            </span>

            <h3>
                Genera tu pedido
            </h3>

            <p>
                Ingresa tus datos una sola vez para comenzar tu compra.
            </p>

        </div>

        <div class="info-card crema">

            <span>
                02
            </span>

            <h3>
                Agrega productos
            </h3>

            <p>
                El carrito se actualiza automáticamente sin recargar la página.
            </p>

        </div>

        <div class="info-card cafe">

            <span>
                03
            </span>

            <h3>
                Confirma y consulta
            </h3>

            <p>
                Recibe tu comprobante y revisa el estado de tu pedido.
            </p>

        </div>

    </section>

</main>

<div
    class="modal-overlay"
    id="modalPedido"
>

    <div class="modal-caja">

        <button
            type="button"
            class="modal-cerrar"
            data-cerrar-modal="modalPedido"
        >
            ×
        </button>

        <p class="modal-etiqueta">
            NUEVO PEDIDO
        </p>

        <h2>
            Comencemos tu compra
        </h2>

        <p class="modal-descripcion">
            Confirma tus datos y elige cómo realizarás el pago.
        </p>

        <form
            id="formPedido"
            method="POST"
            novalidate
        >

            <div class="campo-modal">

                <label for="nombre">
                    Nombre
                </label>

                <input
                    type="text"
                    id="nombre"
                    name="nombre"
                    placeholder="Escribe tu nombre"
                >

            </div>

            <div class="dos-columnas">

                <div class="campo-modal">

                    <label for="telefono">
                        Teléfono
                    </label>

                    <input
                        type="text"
                        id="telefono"
                        name="telefono"
                        placeholder="Tu número de teléfono"
                    >

                </div>

                <div class="campo-modal">

                    <label for="direccion">
                        Dirección
                    </label>

                    <input
                        type="text"
                        id="direccion"
                        name="direccion"
                        placeholder="Tu dirección"
                    >

                </div>

            </div>

            <div class="campo-modal">

                <label for="metodo">
                    Método de pago
                </label>

                <select
                    id="metodo"
                    name="metodo"
                >

                    <option value="">
                        Selecciona una opción
                    </option>

                    <option value="Efectivo">
                        Efectivo
                    </option>

                    <option value="QR">
                        QR
                    </option>

                    <option value="Tarjeta">
                        Tarjeta
                    </option>

                </select>

            </div>

            <button
                type="submit"
                class="boton-principal ancho-completo"
            >
                Crear pedido
            </button>

        </form>

        <p
            class="mensaje-form"
            id="mensajePedido"
        ></p>

    </div>

</div>

<div
    class="carrito-overlay"
    id="carritoOverlay"
></div>

<aside
    class="carrito-panel"
    id="carritoPanel"
>

    <div class="carrito-header">

        <div>

            <p>
                MI PEDIDO
            </p>

            <h2>
                Carrito
            </h2>

        </div>

        <button
            type="button"
            class="modal-cerrar"
            id="cerrarCarrito"
        >
            ×
        </button>

    </div>

    <div
        class="carrito-contenido"
        id="carritoContenido"
    >

        <div class="carrito-vacio">

            <span>
                🛒
            </span>

            <h3>
                Tu carrito está vacío
            </h3>

            <p>
                Agrega productos para verlos aquí.
            </p>

        </div>

    </div>

    <div class="carrito-footer">

        <div class="total-linea">

            <span>
                Total
            </span>

            <strong id="totalCarrito">
                Bs. 0
            </strong>

        </div>

        <button
            type="button"
            class="boton-principal ancho-completo"
            id="finalizarPedido"
            disabled
        >
            Finalizar pedido
        </button>

    </div>

</aside>

<script>

window.ORGANIC_ZONE = {
    pedidoId: <?= $pedidoId ?>,
    pedidoConfirmado: <?= $pedidoConfirmado ? 'true' : 'false' ?>
};

</script>

<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

<script>

$(document).ready(function () {

    $("#formPedido").validate({

        rules: {

            nombre: {
                required: true,
                minlength: 2,
                maxlength: 100
            },

            telefono: {
                required: true,
                digits: true,
                minlength: 7,
                maxlength: 15
            },

            direccion: {
                required: true,
                minlength: 5,
                maxlength: 200
            },

            metodo: {
                required: true
            }

        },

        messages: {

            nombre: {
                required: "Este campo no puede estar vacío",
                minlength: "El nombre debe tener al menos 2 caracteres",
                maxlength: "El nombre no puede superar los 100 caracteres"
            },

            telefono: {
                required: "Este campo no puede estar vacío",
                digits: "Solo se permiten números",
                minlength: "Ingresa un teléfono válido",
                maxlength: "El teléfono no puede superar los 15 números"
            },

            direccion: {
                required: "Este campo no puede estar vacío",
                minlength: "La dirección debe tener al menos 5 caracteres",
                maxlength: "La dirección no puede superar los 200 caracteres"
            },

            metodo: {
                required: "Selecciona un método de pago"
            }

        },

        errorElement: "span",

        errorClass: "error",

        errorPlacement: function (error, element) {

            error.insertAfter(element);

        },

        highlight: function (element) {

            $(element).addClass("input-error");

        },

        unhighlight: function (element) {

            $(element).removeClass("input-error");

        },

        invalidHandler: function (event, validator) {

            if (validator.numberOfInvalids() > 0) {

                $(validator.errorList[0].element).focus();

            }

        }

    });

});

</script>

<style>

.campo-modal .error {
    display: block;
    width: 100%;
    margin-top: 6px;
    color: #D62828;
    font-family: 'Nunito', sans-serif;
    font-size: 12px;
    font-weight: 700;
}

.campo-modal input.input-error,
.campo-modal select.input-error {
    border-color: #D62828;
    box-shadow: 0 0 0 3px rgba(214, 40, 40, 0.08);
}

.campo-modal input:not(.input-error):focus,
.campo-modal select:not(.input-error):focus {
    border-color: #0BA84A;
    box-shadow: 0 0 0 3px rgba(11, 168, 74, 0.10);
}

</style>

<script src="js/cliente.js"></script>

<?php include("../footer.php"); ?>

</body>
</html>

<?php

$conexion->close();

?>