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


/* =========================================================
   INFORMACIÓN NUTRICIONAL POR PRODUCTO
   ---------------------------------------------------------
   "claves" son palabras que se buscan dentro del NOMBRE del
   producto (da igual mayúsculas o tildes). El primer grupo
   que coincida es el que se usa.

   OJO: los valores de papas y de Beyond son ESTIMACIONES de
   referencia. Cámbialos por los datos reales de tu cocina.
   ========================================================= */

$nutricion = [

    [
        'claves'        => ['doble', 'double'],
        'porcion'       => '1 unidad (aprox. 380 g)',
        'kcal'          => 730,
        'proteinas'     => 45,
        'carbohidratos' => 42,
        'azucares'      => 8,
        'grasas'        => 42,
        'saturadas'     => 17,
        'fibra'         => 3,
        'sodio'         => 1150
    ],

    [
        'claves'        => ['vegana', 'vegano', 'vegetariana', 'veggie', 'lenteja', 'garbanzo', 'beyond'],
        'porcion'       => '1 unidad (aprox. 270 g)',
        'kcal'          => 420,
        'proteinas'     => 18,
        'carbohidratos' => 52,
        'azucares'      => 8,
        'grasas'        => 16,
        'saturadas'     => 3,
        'fibra'         => 9,
        'sodio'         => 640
    ],

    [
        'claves'        => ['clasica', 'clasico', 'simple', 'hamburguesa', 'burger', 'burguer'],
        'porcion'       => '1 unidad (aprox. 260 g)',
        'kcal'          => 520,
        'proteinas'     => 30,
        'carbohidratos' => 40,
        'azucares'      => 7,
        'grasas'        => 26,
        'saturadas'     => 10,
        'fibra'         => 3,
        'sodio'         => 880
    ],

    [
        'claves'        => ['fries', 'papas', 'papa'],
        'porcion'       => '1 porción (aprox. 150 g)',
        'kcal'          => 410,
        'proteinas'     => 5,
        'carbohidratos' => 48,
        'azucares'      => 1,
        'grasas'        => 22,
        'saturadas'     => 3,
        'fibra'         => 5,
        'sodio'         => 520
    ]

];

/* Valor diario de referencia (dieta de 2.000 kcal) */
$valorDiario = [
    'proteinas'     => 50,
    'carbohidratos' => 275,
    'grasas'        => 78,
    'saturadas'     => 20,
    'fibra'         => 28,
    'sodio'         => 2300
];

/* Filas de cada tabla: etiqueta, clave, unidad, ¿es subfila? */
$filasNutricion = [
    ['Proteínas',              'proteinas',     'g',  false],
    ['Carbohidratos',          'carbohidratos', 'g',  false],
    ['De los cuales azúcares', 'azucares',      'g',  true],
    ['Grasas totales',         'grasas',        'g',  false],
    ['Saturadas',              'saturadas',     'g',  true],
    ['Fibra',                  'fibra',         'g',  false],
    ['Sodio',                  'sodio',         'mg', false]
];

/**
 * Escapa texto para mostrarlo seguro en HTML.
 *
 * @param string $texto
 * @return string
 */
function h($texto)
{
    return htmlspecialchars((string) $texto, ENT_QUOTES, 'UTF-8');
}

/**
 * Pasa a minúsculas y quita tildes para comparar nombres.
 *
 * @param string $texto
 * @return string
 */
function normalizarNombre($texto)
{
    $texto = strtr((string) $texto, [
        'Á' => 'a', 'É' => 'e', 'Í' => 'i', 'Ó' => 'o', 'Ú' => 'u', 'Ñ' => 'n',
        'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u', 'ü' => 'u', 'ñ' => 'n'
    ]);

    return strtolower(trim($texto));
}

/**
 * Busca el grupo nutricional que corresponde al nombre del producto.
 *
 * @param string $nombre
 * @param array  $nutricion
 * @return array|null
 */
function buscarNutricion($nombre, $nutricion)
{
    $nombre = normalizarNombre($nombre);

    foreach ($nutricion as $item) {

        foreach ($item['claves'] as $clave) {

            if (strpos($nombre, normalizarNombre($clave)) !== false) {
                return $item;
            }

        }

    }

    return null;
}

/**
 * Formatea un número (sin decimales si es entero).
 *
 * @param int|float $valor
 * @return string
 */
function formatoNumero($valor)
{
    $decimales = ($valor == (int) $valor) ? 0 : 1;

    return number_format((float) $valor, $decimales, ',', '.');
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
        href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Nunito:wght@400;600;700;800;900&display=swap"
        rel="stylesheet"
    >

    <link rel="stylesheet" href="css/cliente.css?v=<?= (int) @filemtime(__DIR__ . '/css/cliente.css') ?>">

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

        <div class="productos">

            <?php if ($resultadoProductos && $resultadoProductos->num_rows > 0): ?>

                <?php $numero = 0; ?>

                <?php while ($producto = $resultadoProductos->fetch_assoc()): ?>

                    <?php

                    $numero++;

                    $idProducto = (int) $producto['id'];

                    $stockProducto = (int) ($producto['stock'] ?? 0);

                    $sinStock = $stockProducto <= 0;

                    $imagen = obtenerImagenProducto($idProducto);

                    /* Información nutricional de este producto */
                    $info = buscarNutricion($producto['nombre'], $nutricion);

                    /* Valores iniciales (evita el aviso "undefined variable") */
                    $pctProteinas     = 0;
                    $pctCarbohidratos = 0;
                    $pctGrasas        = 0;

                    if ($info) {

                        $kcalProteinas     = $info['proteinas'] * 4;
                        $kcalCarbohidratos = $info['carbohidratos'] * 4;
                        $kcalGrasas        = $info['grasas'] * 9;

                        $kcalTotal = $kcalProteinas + $kcalCarbohidratos + $kcalGrasas;

                        if ($kcalTotal < 1) {
                            $kcalTotal = 1;
                        }

                        $pctProteinas     = (int) round($kcalProteinas * 100 / $kcalTotal);
                        $pctCarbohidratos = (int) round($kcalCarbohidratos * 100 / $kcalTotal);
                        $pctGrasas        = 100 - $pctProteinas - $pctCarbohidratos;

                    }

                    ?>

                    <article class="carta producto-card">

                        <div class="imagen">

                            <span class="etiqueta-producto">
                                ORGANIC ZONE
                            </span>

                            <span class="numero-producto">
                                <?= str_pad((string) $numero, 2, '0', STR_PAD_LEFT) ?>
                            </span>

                            <img
                                src="<?= h($imagen) ?>"
                                alt="<?= h($producto['nombre']) ?>"
                            >

                        </div>


                        <div class="informacion">

                            <h3>
                                <?= h($producto['nombre']) ?>
                            </h3>

                            <p class="descripcion">
                                <?= h($producto['descripcion']) ?>
                            </p>


                            <div class="parte-inferior">

                                <div class="precio-contenedor">

                                    <span class="precio-label">
                                        Precio
                                    </span>

                                    <span class="precio">

                                        <small>Bs.</small><?= number_format((float) $producto['precio'], 0, ',', '.') ?>

                                    </span>

                                </div>


                                <?php if (!$sinStock): ?>

                                    <span class="disponible">
                                        Disponible
                                    </span>

                                <?php else: ?>

                                    <span class="disponible agotado sin-stock">
                                        Agotado
                                    </span>

                                <?php endif; ?>

                            </div>


                            <!-- ===== Botón agregar al carrito ===== -->

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


                            <!-- ===== Botón + información nutricional ===== -->

                            <button
                                type="button"
                                class="btn-nutri"
                                aria-expanded="false"
                                aria-controls="nutri-<?= $idProducto ?>"
                            >

                                <span class="btn-nutri-texto">Ver información nutricional</span>

                                <span class="btn-nutri-icono">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                         stroke="currentColor" stroke-width="3.2"
                                         stroke-linecap="round" stroke-linejoin="round"
                                         aria-hidden="true">
                                        <path d="M6 9l6 6 6-6"/>
                                    </svg>
                                </span>

                            </button>


                            <div class="nutri-desplegable" id="nutri-<?= $idProducto ?>" aria-hidden="true">

                                <div class="nutri-contenido">

                                    <?php if ($info): ?>

                                        <span class="nutri-etiqueta">INFORMACIÓN NUTRICIONAL</span>

                                        <span class="nutri-porcion">
                                            Porción: <?= h($info['porcion']) ?>
                                        </span>

                                        <div class="nutri-kcal">
                                            <strong><?= formatoNumero($info['kcal']) ?></strong>
                                            <span>kcal</span>
                                        </div>

                                        <span class="nutri-barra-titulo">
                                            De dónde vienen las calorías
                                        </span>

                                        <div class="nutri-barra">
                                            <span class="seg-proteinas"     style="width: <?= $pctProteinas ?>%"></span>
                                            <span class="seg-carbohidratos" style="width: <?= $pctCarbohidratos ?>%"></span>
                                            <span class="seg-grasas"        style="width: <?= $pctGrasas ?>%"></span>
                                        </div>

                                        <ul class="nutri-leyenda">
                                            <li class="l-proteinas">Proteínas <?= $pctProteinas ?>%</li>
                                            <li class="l-carbohidratos">Carbohidratos <?= $pctCarbohidratos ?>%</li>
                                            <li class="l-grasas">Grasas <?= $pctGrasas ?>%</li>
                                        </ul>

                                        <ul class="nutri-filas">

                                            <li class="nutri-fila cabecera-filas">
                                                <span>Por porción</span>
                                                <span></span>
                                                <span>% VD</span>
                                            </li>

                                            <?php foreach ($filasNutricion as $filaN): ?>

                                                <?php

                                                list($etiqueta, $clave, $unidad, $esSubfila) = $filaN;

                                                $valor = $info[$clave];

                                                $porcentajeVD = '';

                                                if (isset($valorDiario[$clave])) {
                                                    $porcentajeVD = round($valor * 100 / $valorDiario[$clave]) . '%';
                                                }

                                                ?>

                                                <li class="nutri-fila<?= $esSubfila ? ' sub' : '' ?>">

                                                    <span class="nutri-nombre"><?= h($etiqueta) ?></span>

                                                    <span class="nutri-valor"><?= formatoNumero($valor) ?><small><?= $unidad ?></small></span>

                                                    <span class="nutri-vd"><?= $porcentajeVD ?></span>

                                                </li>

                                            <?php endforeach; ?>

                                        </ul>

                                        <p class="nutri-nota">
                                            Valores de referencia por porción; pueden variar según la preparación.
                                            % VD: porcentaje del valor diario en una dieta de 2.000 kcal.
                                        </p>

                                    <?php else: ?>

                                        <span class="nutri-etiqueta">INFORMACIÓN NUTRICIONAL</span>

                                        <p class="nutri-vacio" style="margin-top: 12px;">
                                            La información nutricional de este producto
                                            estará disponible muy pronto.
                                        </p>

                                    <?php endif; ?>

                                </div>

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

<!-- Desplegable de información nutricional -->
<script>

(function () {

    var botones = document.querySelectorAll('.btn-nutri');

    function alternar(boton) {

        var panel = document.getElementById(boton.getAttribute('aria-controls'));
        var texto = boton.querySelector('.btn-nutri-texto');
        var abierto = boton.getAttribute('aria-expanded') === 'true';

        if (abierto) {

            boton.setAttribute('aria-expanded', 'false');
            boton.classList.remove('abierto');
            panel.setAttribute('aria-hidden', 'true');
            panel.style.maxHeight = '0px';
            texto.textContent = 'Ver información nutricional';

        } else {

            boton.setAttribute('aria-expanded', 'true');
            boton.classList.add('abierto');
            panel.setAttribute('aria-hidden', 'false');
            panel.style.maxHeight = panel.scrollHeight + 'px';
            texto.textContent = 'Ocultar información nutricional';

            // Si el panel queda cortado abajo, lo acerca a la vista
            setTimeout(function () {

                var caja = panel.getBoundingClientRect();

                if (caja.bottom > window.innerHeight) {
                    window.scrollBy(0, caja.bottom - window.innerHeight + 24);
                }

            }, 520);

        }

    }

    for (var i = 0; i < botones.length; i++) {

        botones[i].addEventListener('click', function () {
            alternar(this);
        });

    }

    // Si cambia el ancho de la pantalla, recalcula la altura de los paneles abiertos
    window.addEventListener('resize', function () {

        var abiertos = document.querySelectorAll('.btn-nutri.abierto');

        for (var j = 0; j < abiertos.length; j++) {

            var panel = document.getElementById(abiertos[j].getAttribute('aria-controls'));
            panel.style.maxHeight = panel.scrollHeight + 'px';

        }

    });

})();

</script>

<script src="js/cliente.js"></script>

<?php include("../footer.php"); ?>

</body>
</html>

<?php

$conexion->close();

?>