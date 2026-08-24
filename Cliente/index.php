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


        <form id="formPedido">

            <div class="campo-modal">

                <label>
                    Nombre
                </label>

                <input
                    type="text"
                    name="nombre"
                    placeholder="Escribe tu nombre"
                    required
                >

            </div>


            <div class="dos-columnas">

                <div class="campo-modal">

                    <label>
                        Teléfono
                    </label>

                    <input
                        type="text"
                        name="telefono"
                        placeholder="Tu número de teléfono"
                        required
                    >

                </div>


                <div class="campo-modal">

                    <label>
                        Dirección
                    </label>

                    <input
                        type="text"
                        name="direccion"
                        placeholder="Tu dirección"
                        required
                    >

                </div>

            </div>


            <div class="campo-modal">

                <label>
                    Método de pago
                </label>

                <select
                    name="metodo"
                    required
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


<script src="js/cliente.js"></script>


<?php include("../footer.php"); ?>


</body>

</html>


<?php

$conexion->close();

?>