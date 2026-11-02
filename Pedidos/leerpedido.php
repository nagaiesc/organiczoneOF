<?php

session_start();

$rol = $_SESSION['rol'] ?? '';

if ($rol === 'admin') {
    $volverInicio = '../vistaadmin.php';
} elseif ($rol === 'vendedor') {
    $volverInicio = '../Usuarios/vistavendedor.php';
} else {
    $volverInicio = '../paginaprincipal.php';
}

$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$bd = "organiczoneBD";

$conn = new mysqli(
    $servidor,
    $usuario,
    $contrasena,
    $bd
);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID de pedido no válido.");
}

$idPedido = (int) $_GET['id'];

$sqlPedido = "
    SELECT *
    FROM pedidos
    WHERE id = ?
";

$stmtPedido = $conn->prepare($sqlPedido);

if (!$stmtPedido) {
    die("Error al preparar la consulta del pedido.");
}

$stmtPedido->bind_param("i", $idPedido);
$stmtPedido->execute();

$resultadoPedido = $stmtPedido->get_result();

if ($resultadoPedido->num_rows === 0) {
    die("Pedido no encontrado.");
}

$pedido = $resultadoPedido->fetch_assoc();

$stmtPedido->close();

$sqlCarrito = "
    SELECT
        c.pedidos_id,
        c.productos_id,
        c.cantidad,
        c.costototal,
        p.nombre,
        p.precio,
        p.descripcion
    FROM carrito c
    INNER JOIN productos p
        ON c.productos_id = p.id
    WHERE c.pedidos_id = ?
";

$stmtCarrito = $conn->prepare($sqlCarrito);

if (!$stmtCarrito) {
    die("Error al preparar la consulta del carrito.");
}

$stmtCarrito->bind_param("i", $idPedido);
$stmtCarrito->execute();

$resultadoCarrito = $stmtCarrito->get_result();

function limpiar($dato)
{
    return htmlspecialchars(
        $dato ?? '',
        ENT_QUOTES,
        'UTF-8'
    );
}

$estado = strtolower(
    trim($pedido['estado'] ?? '')
);

$claseEstado = "estado-default";

if ($estado === "pendiente") {

    $claseEstado = "estado-pendiente";

} elseif (
    $estado === "procesando" ||
    $estado === "en proceso"
) {

    $claseEstado = "estado-proceso";

} elseif ($estado === "enviado") {

    $claseEstado = "estado-enviado";

} elseif ($estado === "entregado") {

    $claseEstado = "estado-entregado";

} elseif ($estado === "cancelado") {

    $claseEstado = "estado-cancelado";

}

$totalFactura = 0;

?>

<!DOCTYPE html>

<html lang="es">

<head>

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>
    Factura #<?= limpiar($pedido['id']) ?>
</title>


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


<style>

:root {
    --verde: #0BA84A;
    --verde-oscuro: #087A36;
    --verde-suave: #E5F7EA;

    --cafe: #2B140D;
    --cafe-2: #3A1E13;

    --crema: #FCD09F;
    --amarillo: #FFD57A;

    --fondo: #F5EEE3;

    --gris: #766E69;
    --linea: #E0D6C9;

    --rojo: #D62828;
}

* {
    box-sizing: border-box;
}

html,
body {
    margin: 0;
    padding: 0;
}

html {
    scroll-behavior: smooth;
}

body {
    min-height: 100vh;
    overflow-x: hidden;
    background:
        radial-gradient(
            circle at 4% 18%,
            rgba(11,168,74,.10),
            transparent 24%
        ),
        radial-gradient(
            circle at 96% 6%,
            rgba(252,208,159,.30),
            transparent 25%
        ),
        var(--fondo);
    color: var(--cafe);
    font-family: 'Nunito', Arial, sans-serif;
}


/* =====================================================
   BARRA SUPERIOR (verde, con el logo)
   ===================================================== */

.fa-topbar {
    position: relative;
    z-index: 50;
    width: min(1240px, 92%);
    min-height: 76px;
    margin: 20px auto 0;
    padding: 0 12px 0 28px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 14px;
    border-radius: 100px;
    background: var(--verde);
    box-shadow: 0 14px 34px rgba(11,168,74,.30);
}

.fa-logo {
    display: flex;
    align-items: center;
    text-decoration: none;
}

.fa-logo-img {
    display: block;
    height: 46px;
    width: auto;
}

/* Solo se ve si la imagen del logo no carga */
.fa-logo-texto {
    display: none;
    color: white;
    font-family: 'Fredoka', sans-serif;
    font-size: 26px;
    font-weight: 700;
    letter-spacing: .3px;
}

.fa-logo-texto span {
    color: var(--cafe);
}

.fa-topbar-botones {
    display: flex;
    align-items: center;
    gap: 10px;
}

.fa-btn-top {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 9px;
    padding: 14px 24px;
    border: 0;
    border-radius: 100px;
    background: var(--cafe);
    color: white;
    font-family: 'Nunito', sans-serif;
    font-size: 14px;
    font-weight: 900;
    text-decoration: none;
    cursor: pointer;
    transition:
        transform .25s ease,
        background .25s ease,
        color .25s ease,
        box-shadow .25s ease;
}

.fa-btn-top:hover {
    transform: translateY(-2px);
    background: var(--crema);
    color: var(--cafe);
}

/* Botón de imprimir: más grande */
.fa-btn-top.imprimir {
    gap: 12px;
    padding: 19px 36px;
    background: var(--crema);
    color: var(--cafe);
    font-size: 18px;
    box-shadow: 0 10px 24px rgba(43,20,13,.20);
}

.fa-btn-top.imprimir:hover {
    background: white;
    color: var(--cafe);
    box-shadow: 0 14px 30px rgba(43,20,13,.26);
}

.fa-btn-top.imprimir svg {
    width: 22px;
    height: 22px;
}

.fa-btn-top svg,
.fa-btn svg {
    flex: 0 0 auto;
}


/* =====================================================
   CONTENEDOR
   ===================================================== */

.fa-contenedor {
    width: min(1240px, 92%);
    margin: 34px auto 70px;
}


/* =====================================================
   CABECERA DE LA FACTURA (título grande)
   ===================================================== */

.fa-hero {
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 30px;
    padding: 58px 64px 54px;
    border-radius: 55px;
    background:
        linear-gradient(
            125deg,
            #ffffff 0%,
            #ffffff 55%,
            #eff9f1 100%
        );
    box-shadow: 0 25px 70px rgba(43,20,13,.10);
}

.fa-hero::before {
    content: "";
    position: absolute;
    width: 500px;
    height: 500px;
    right: -150px;
    top: -210px;
    border-radius: 50%;
    background: var(--crema);
    opacity: .30;
}

.fa-hero::after {
    content: "";
    position: absolute;
    width: 270px;
    height: 270px;
    left: -90px;
    bottom: -170px;
    border-radius: 50%;
    background: var(--verde);
    opacity: .08;
}

.fa-hero-texto,
.fa-sello {
    position: relative;
    z-index: 2;
}

.fa-etiqueta {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 10px 17px;
    border-radius: 100px;
    background: var(--verde-suave);
    color: var(--verde-oscuro);
    font-size: 12px;
    font-weight: 900;
    letter-spacing: 1.5px;
}

.fa-etiqueta::before {
    content: "";
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: var(--verde);
    box-shadow: 0 0 0 5px rgba(11,168,74,.10);
}

.fa-titulo {
    margin: 24px 0 0;
    font-family: 'Fredoka', sans-serif;
    font-size: clamp(68px, 12vw, 150px);
    line-height: .85;
    letter-spacing: -5px;
    font-weight: 700;
    color: var(--cafe);
}

.fa-titulo span {
    color: var(--verde);
}

.fa-subtitulo {
    margin: 22px 0 0;
    color: var(--gris);
    font-size: 18px;
    font-weight: 700;
}

.fa-meta {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 12px 16px;
    margin-top: 30px;
}

.fa-meta-label {
    color: #99908a;
    font-size: 11px;
    font-weight: 900;
    letter-spacing: 1.3px;
    text-transform: uppercase;
}

.fa-sello {
    flex: 0 0 auto;
    width: 200px;
    height: 200px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: var(--verde);
    color: white;
    transform: rotate(8deg);
    box-shadow: 0 24px 40px rgba(11,168,74,.26);
    text-align: center;
}

.fa-sello small {
    font-size: 12px;
    font-weight: 900;
    letter-spacing: 3px;
}

.fa-sello strong {
    margin-top: 4px;
    font-family: 'Fredoka', sans-serif;
    font-size: 68px;
    line-height: .95;
    letter-spacing: -2px;
}


/* ----- Estado del pedido ----- */

.fa-estado {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 11px 20px;
    border-radius: 100px;
    font-size: 13px;
    font-weight: 900;
    letter-spacing: 1px;
    text-transform: uppercase;
}

.fa-estado::before {
    content: "";
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: currentColor;
}

.estado-pendiente {
    background: var(--amarillo);
    color: #6B4A00;
}

.estado-proceso {
    background: var(--crema);
    color: var(--cafe);
}

.estado-enviado {
    background: var(--cafe);
    color: var(--crema);
}

.estado-entregado {
    background: var(--verde-suave);
    color: var(--verde-oscuro);
}

.estado-cancelado {
    background: #FBE5E2;
    color: var(--rojo);
}

.estado-default {
    background: #EEE7DC;
    color: var(--gris);
}


/* =====================================================
   CAJAS DE INFORMACIÓN
   ===================================================== */

.fa-info {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 24px;
    margin-top: 24px;
}

.fa-caja {
    position: relative;
    overflow: hidden;
    padding: 34px 34px 32px;
    border-radius: 38px;
    background: white;
    border: 1px solid rgba(43,20,13,.055);
    box-shadow: 0 14px 38px rgba(43,20,13,.08);
}

.fa-caja-etiqueta {
    display: block;
    color: var(--verde);
    font-size: 11px;
    font-weight: 900;
    letter-spacing: 2px;
    text-transform: uppercase;
}

.fa-caja-titulo {
    margin: 12px 0 0;
    font-family: 'Fredoka', sans-serif;
    font-size: clamp(30px, 3vw, 42px);
    line-height: 1;
    font-weight: 700;
    color: var(--cafe);
    overflow-wrap: anywhere;
}

.fa-dato {
    margin-top: 20px;
    padding-top: 16px;
    border-top: 1px dashed var(--linea);
}

.fa-dato span {
    display: block;
    color: #99908a;
    font-size: 10px;
    font-weight: 900;
    letter-spacing: 1.3px;
    text-transform: uppercase;
}

.fa-dato strong {
    display: block;
    margin-top: 5px;
    color: var(--cafe);
    font-size: 17px;
    font-weight: 800;
}

.fa-caja-crema {
    background: var(--crema);
    border-color: transparent;
}

.fa-caja-crema::after {
    content: "";
    position: absolute;
    width: 170px;
    height: 170px;
    right: -60px;
    bottom: -80px;
    border-radius: 50%;
    background: white;
    opacity: .28;
}

.fa-caja-crema .fa-caja-etiqueta {
    color: var(--cafe);
}

.fa-caja-crema .fa-caja-titulo,
.fa-caja-crema .fa-caja-etiqueta {
    position: relative;
    z-index: 2;
}


/* =====================================================
   DETALLE DEL PEDIDO
   ===================================================== */

.fa-detalle {
    margin-top: 24px;
    padding: 46px 46px 30px;
    border-radius: 45px;
    background: white;
    box-shadow: 0 25px 70px rgba(43,20,13,.10);
}

.fa-encabezado {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 25px;
    margin-bottom: 30px;
}

.fa-encabezado small {
    display: block;
    margin-bottom: 8px;
    color: var(--verde);
    font-size: 11px;
    font-weight: 900;
    letter-spacing: 2px;
}

.fa-encabezado h2 {
    margin: 0;
    font-family: 'Fredoka', sans-serif;
    font-size: clamp(38px, 5vw, 64px);
    line-height: .95;
    font-weight: 700;
    color: var(--cafe);
}

.fa-contador {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    padding: 13px 19px;
    border-radius: 100px;
    background: var(--cafe);
    color: white;
    font-size: 12px;
    font-weight: 900;
    white-space: nowrap;
}

.fa-contador::before {
    content: "";
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: var(--verde);
}

.fa-tabla {
    width: 100%;
    border-collapse: collapse;
}

.fa-tabla th {
    padding: 0 14px 16px;
    text-align: left;
    color: #99908a;
    font-size: 11px;
    font-weight: 900;
    letter-spacing: 1.4px;
    text-transform: uppercase;
}

.fa-tabla td {
    padding: 24px 14px;
    border-top: 1px dashed var(--linea);
    vertical-align: middle;
    color: var(--gris);
    font-size: 17px;
    font-weight: 800;
}

.fa-tabla .c {
    text-align: center;
}

.fa-tabla .d {
    text-align: right;
}

.fa-prod-nombre {
    color: var(--cafe);
    font-family: 'Fredoka', sans-serif;
    font-size: 28px;
    line-height: 1.05;
    font-weight: 600;
}

.fa-prod-desc {
    margin-top: 7px;
    max-width: 420px;
    color: #99908a;
    font-size: 13px;
    line-height: 1.5;
    font-weight: 700;
}

.fa-cant {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 62px;
    padding: 9px 16px;
    border-radius: 100px;
    background: var(--verde-suave);
    color: var(--verde-oscuro);
    font-family: 'Fredoka', sans-serif;
    font-size: 20px;
    font-weight: 600;
}

.fa-bs {
    margin-right: 4px;
    color: var(--verde);
    font-size: .62em;
    font-weight: 900;
}

.fa-precio {
    color: var(--cafe);
    font-family: 'Fredoka', sans-serif;
    font-size: 22px;
    font-weight: 500;
}

.fa-subtotal {
    color: var(--cafe);
    font-family: 'Fredoka', sans-serif;
    font-size: 30px;
    font-weight: 700;
}

.fa-vacio {
    padding: 60px 20px 50px;
    border-top: 1px dashed var(--linea);
    text-align: center;
    color: var(--gris);
    font-size: 17px;
    font-weight: 800;
}


/* =====================================================
   PAGO: QR + TOTAL
   ===================================================== */

.fa-pago {
    display: grid;
    grid-template-columns: .8fr 1.2fr;
    gap: 24px;
    margin-top: 24px;
}

.fa-qr {
    padding: 38px 34px 34px;
    border-radius: 40px;
    background: white;
    border: 1px solid rgba(43,20,13,.055);
    box-shadow: 0 14px 38px rgba(43,20,13,.08);
    text-align: center;
}

.fa-qr h3 {
    margin: 0 0 22px;
    font-family: 'Fredoka', sans-serif;
    font-size: 30px;
    line-height: 1.05;
    font-weight: 700;
    color: var(--cafe);
}

.fa-qr-marco {
    display: inline-block;
    padding: 14px;
    border-radius: 28px;
    background: var(--fondo);
    border: 2px dashed var(--crema);
}

.fa-qr-marco img {
    width: 190px;
    height: 190px;
    display: block;
    object-fit: contain;
    border-radius: 14px;
    background: white;
}

.fa-total {
    position: relative;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 42px 46px 40px;
    border-radius: 40px;
    background: var(--cafe);
    color: white;
}

.fa-total::before {
    content: "";
    position: absolute;
    width: 240px;
    height: 240px;
    right: -80px;
    top: -130px;
    border-radius: 50%;
    background: var(--verde);
    opacity: .85;
}

.fa-total::after {
    content: "";
    position: absolute;
    width: 110px;
    height: 110px;
    left: 42%;
    bottom: -70px;
    border-radius: 50%;
    background: var(--crema);
    opacity: .35;
}

.fa-total > * {
    position: relative;
    z-index: 2;
}

.fa-total-linea {
    display: flex;
    justify-content: space-between;
    padding: 12px 0;
    border-bottom: 1px dashed rgba(252,208,159,.30);
    color: var(--crema);
    font-size: 15px;
    font-weight: 800;
}

.fa-total-linea strong {
    color: white;
}

.fa-total-etiqueta {
    display: block;
    margin-top: 34px;
    color: var(--crema);
    font-size: 12px;
    font-weight: 900;
    letter-spacing: 2px;
}

.fa-total-monto {
    display: block;
    margin-top: 6px;
    color: var(--crema);
    font-family: 'Fredoka', sans-serif;
    font-size: clamp(58px, 8vw, 108px);
    line-height: .9;
    letter-spacing: -3px;
    font-weight: 700;
}

.fa-total-monto small {
    margin-right: 8px;
    color: var(--verde);
    font-family: 'Nunito', sans-serif;
    font-size: .36em;
    letter-spacing: 0;
    font-weight: 900;
    vertical-align: top;
    display: inline-block;
    margin-top: .18em;
}


/* =====================================================
   PIE
   ===================================================== */

.fa-footer {
    position: relative;
    overflow: hidden;
    margin-top: 24px;
    padding: 54px 56px;
    border-radius: 45px;
    background: var(--cafe);
    color: var(--crema);
}

.fa-footer::before {
    content: "";
    position: absolute;
    width: 300px;
    height: 300px;
    right: -100px;
    top: -170px;
    border-radius: 50%;
    background: var(--verde);
    opacity: .85;
}

.fa-footer > * {
    position: relative;
    z-index: 2;
}

.fa-footer h2 {
    margin: 0;
    max-width: 760px;
    font-family: 'Fredoka', sans-serif;
    font-size: clamp(34px, 5vw, 62px);
    line-height: .98;
    font-weight: 700;
    color: white;
}

.fa-footer h2 span {
    color: var(--crema);
}

.fa-footer p {
    margin: 18px 0 0;
    max-width: 520px;
    font-size: 15px;
    line-height: 1.6;
    font-weight: 700;
}

.fa-footer-lugar {
    display: inline-block;
    margin-top: 26px;
    padding: 10px 18px;
    border-radius: 100px;
    background: rgba(252,208,159,.16);
    color: var(--crema);
    font-size: 12px;
    font-weight: 900;
    letter-spacing: 1.2px;
}


/* =====================================================
   ACCIONES
   ===================================================== */

.fa-acciones {
    margin-top: 30px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 14px;
}

.fa-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 16px 30px;
    border: 0;
    border-radius: 100px;
    font-family: 'Nunito', sans-serif;
    font-size: 15px;
    font-weight: 900;
    text-decoration: none;
    cursor: pointer;
    transition:
        transform .25s ease,
        background .25s ease,
        box-shadow .25s ease;
}

.fa-btn-volver {
    background: var(--cafe);
    color: white;
    box-shadow: 0 10px 25px rgba(43,20,13,.15);
}

.fa-btn-volver:hover {
    transform: translateY(-3px);
    background: var(--cafe-2);
}

.fa-btn-imprimir {
    gap: 14px;
    padding: 23px 50px;
    background: var(--verde);
    color: white;
    font-size: 19px;
    box-shadow: 0 12px 28px rgba(11,168,74,.30);
}

.fa-btn-imprimir svg {
    width: 24px;
    height: 24px;
}

.fa-btn-imprimir:hover {
    transform: translateY(-3px);
    background: var(--verde-oscuro);
}


/* =====================================================
   RESPONSIVE
   ===================================================== */

@media (max-width: 1000px) {

    .fa-hero {
        padding: 48px 42px;
    }

    .fa-sello {
        width: 150px;
        height: 150px;
    }

    .fa-sello strong {
        font-size: 52px;
    }

    .fa-info {
        grid-template-columns: 1fr 1fr;
    }

    .fa-caja-crema {
        grid-column: 1 / -1;
    }

    .fa-pago {
        grid-template-columns: 1fr;
    }

    .fa-detalle {
        padding: 38px 30px 24px;
    }

}

@media (max-width: 700px) {

    .fa-topbar {
        width: 95%;
        min-height: 66px;
        padding: 0 8px 0 18px;
    }

    .fa-logo-img {
        height: 36px;
    }

    .fa-btn-top {
        padding: 11px 15px;
        font-size: 13px;
    }

    .fa-btn-top.imprimir {
        padding: 14px 20px;
        font-size: 15px;
    }

    .fa-btn-top.imprimir svg {
        width: 18px;
        height: 18px;
    }

    .fa-contenedor {
        width: 92%;
        margin-top: 24px;
    }

    .fa-hero {
        display: block;
        padding: 38px 26px 36px;
        border-radius: 35px;
    }

    .fa-sello {
        position: absolute;
        top: 22px;
        right: 22px;
        width: 100px;
        height: 100px;
    }

    .fa-sello small {
        font-size: 9px;
        letter-spacing: 2px;
    }

    .fa-sello strong {
        font-size: 34px;
    }

    .fa-titulo {
        margin-top: 70px;
        font-size: clamp(56px, 18vw, 92px);
        letter-spacing: -3px;
    }

    .fa-subtitulo {
        font-size: 16px;
    }

    .fa-info {
        grid-template-columns: 1fr;
    }

    .fa-caja {
        padding: 28px 26px;
        border-radius: 32px;
    }

    .fa-detalle {
        padding: 32px 22px 14px;
        border-radius: 35px;
    }

    .fa-encabezado {
        flex-direction: column;
        align-items: flex-start;
    }

    /* La tabla se convierte en tarjetas apiladas */

    .fa-tabla thead {
        display: none;
    }

    .fa-tabla,
    .fa-tabla tbody,
    .fa-tabla tr,
    .fa-tabla td {
        display: block;
        width: 100%;
    }

    .fa-tabla tr {
        padding: 20px 0;
        border-top: 1px dashed var(--linea);
    }

    .fa-tabla td {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 7px 0;
        border: 0;
    }

    .fa-tabla td::before {
        content: attr(data-label);
        color: #99908a;
        font-size: 11px;
        font-weight: 900;
        letter-spacing: 1.2px;
        text-transform: uppercase;
    }

    .fa-tabla td.fa-prod {
        display: block;
        padding-bottom: 12px;
    }

    .fa-tabla td.fa-prod::before {
        content: none;
    }

    .fa-qr {
        padding: 32px 22px;
        border-radius: 32px;
    }

    .fa-total {
        padding: 34px 26px 30px;
        border-radius: 32px;
    }

    .fa-footer {
        padding: 42px 28px;
        border-radius: 35px;
    }

    .fa-acciones {
        flex-direction: column;
        align-items: stretch;
    }

}


@media (max-width: 480px) {

    .fa-topbar {
        justify-content: center;
        padding: 0 8px;
    }

    .fa-logo {
        display: none;
    }

}


/* =====================================================
   IMPRESIÓN: FACTURA LARGA Y ANGOSTA (tipo ticket / hoja larga)
   Borde exterior > cajas con título > borde exterior
   Solo afecta al imprimir. La pantalla no cambia.
   ===================================================== */

/* Sin márgenes de página: el borde de la factura marca el límite.
   Si tu impresora lo necesita, descomenta y ajusta el tamaño del papel:
   @page { size: 80mm 400mm; margin: 0; }  */
@page {
    margin: 0;
}

@media print {

    /* ANCHO DE LA FACTURA: cámbialo aquí
       80mm de papel -> 76mm | 58mm de papel -> 54mm | 110mm -> 106mm */
    :root {
        --ancho-factura: 76mm;
    }

    * {
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    html,
    body {
        width: auto;
        height: auto;
        min-height: 0;
        margin: 0;
        overflow: visible;
        background: white;
    }

    /* Fuera barras y botones (también la barra del sitio) */
    nav,
    [class*="barra"],
    [class*="navegacion"],
    .fa-topbar,
    .fa-acciones {
        display: none !important;
    }

    /* ----- BORDE EXTERIOR DE LA FACTURA ----- */

    .fa-contenedor {
        width: var(--ancho-factura);
        max-width: 100%;
        margin: 2mm auto;
        padding: 3mm;
        border: 2px solid var(--cafe);
        border-radius: 10px;
        background: white;
        color: var(--cafe);
    }

    /* Sin círculos decorativos ni sombras */
    .fa-hero::before,
    .fa-hero::after,
    .fa-caja-crema::after,
    .fa-total::before,
    .fa-total::after,
    .fa-footer::before {
        display: none;
    }

    /* ----- CAJAS: todas iguales, una debajo de otra ----- */

    .fa-hero,
    .fa-caja,
    .fa-detalle,
    .fa-qr,
    .fa-total,
    .fa-footer {
        background: white;
        color: var(--cafe);
        border: 1px solid #8a8079;
        border-radius: 8px;
        box-shadow: none;
        page-break-inside: avoid;
        break-inside: avoid;
    }

    /* ----- 1. TÍTULO ----- */

    .fa-hero {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0;
        padding: 10px 8px 12px;
        text-align: center;
    }

    .fa-hero-texto {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .fa-etiqueta {
        padding: 3px 10px;
        font-size: 9px;
        letter-spacing: 1.4px;
    }

    .fa-titulo {
        margin: 6px 0 0;
        font-size: 44px;
        line-height: .9;
        letter-spacing: -2px;
    }

    .fa-subtitulo {
        display: block;
        margin: 6px 0 0;
        font-size: 10px;
    }

    .fa-meta {
        flex-direction: column;
        align-items: center;
        gap: 5px;
        margin-top: 8px;
    }

    .fa-meta-label {
        font-size: 8px;
    }

    .fa-estado {
        padding: 4px 12px;
        font-size: 10px;
        border: 1px solid currentColor;
    }

    /* El sello del número pasa a ser una etiqueta horizontal */
    .fa-sello {
        position: static;
        flex-direction: row;
        gap: 6px;
        width: auto;
        height: auto;
        margin-top: 10px;
        padding: 3px 16px;
        border: 1.5px solid var(--cafe);
        border-radius: 100px;
        background: white;
        color: var(--cafe);
        transform: none;
        box-shadow: none;
    }

    .fa-sello small {
        font-size: 11px;
        letter-spacing: 1px;
    }

    .fa-sello strong {
        margin: 0;
        font-size: 22px;
        letter-spacing: 0;
    }

    /* ----- 2. CAJAS DE INFORMACIÓN ----- */

    .fa-info {
        display: flex;
        flex-direction: column;
        gap: 8px;
        margin-top: 8px;
    }

    .fa-caja,
    .fa-caja-crema {
        grid-column: auto;
        padding: 8px 12px 10px;
    }

    .fa-caja-crema {
        background: #FFF3E2;
        border-color: #cdb58f;
    }

    .fa-caja-etiqueta {
        padding-bottom: 5px;
        border-bottom: 1px solid #8a8079;
        font-size: 8px;
        letter-spacing: 1.4px;
    }

    .fa-caja-titulo {
        margin-top: 7px;
        font-size: 18px;
        line-height: 1.1;
    }

    .fa-dato {
        display: flex;
        align-items: baseline;
        justify-content: space-between;
        gap: 8px;
        margin-top: 6px;
        padding-top: 6px;
    }

    .fa-dato span {
        font-size: 8px;
    }

    .fa-dato strong {
        margin-top: 0;
        font-size: 12px;
        text-align: right;
    }

    /* ----- 3. DETALLE DEL PEDIDO ----- */

    .fa-detalle {
        margin-top: 8px;
        padding: 8px 12px 4px;
        page-break-inside: auto;
        break-inside: auto;
    }

    .fa-encabezado {
        flex-direction: column;
        align-items: center;
        gap: 6px;
        margin-bottom: 4px;
        padding-bottom: 8px;
        border-bottom: 1px solid #8a8079;
        text-align: center;
    }

    .fa-encabezado small {
        margin-bottom: 3px;
        font-size: 8px;
    }

    .fa-encabezado h2 {
        font-size: 22px;
    }

    .fa-contador {
        padding: 4px 10px;
        border: 1px solid #8a8079;
        background: white;
        color: var(--cafe);
        font-size: 9px;
    }

    /* Cada producto es una mini-ficha: nombre arriba, 3 datos abajo */

    .fa-tabla,
    .fa-tabla tbody {
        display: block;
        width: 100%;
    }

    .fa-tabla thead {
        display: none;
    }

    .fa-tabla tr {
        display: grid;
        grid-template-columns: .8fr 1.1fr 1.1fr;
        gap: 4px 6px;
        padding: 8px 0;
        border: 0;
        border-top: 1px dashed #8a8079;
        page-break-inside: avoid;
        break-inside: avoid;
    }

    .fa-tabla tbody tr:first-child {
        border-top: 0;
    }

    .fa-tabla td,
    .fa-tabla td.fa-prod {
        display: flex;
        flex-direction: column;
        width: auto;
        padding: 0;
        border: 0;
        font-size: 11px;
    }

    .fa-tabla td.fa-prod {
        display: block;
        grid-column: 1 / -1;
    }

    .fa-tabla td.c {
        align-items: flex-start;
        text-align: left;
    }

    .fa-tabla td.d {
        align-items: flex-end;
        text-align: right;
    }

    .fa-tabla td::before {
        content: attr(data-label);
        margin-bottom: 2px;
        color: #8a8079;
        font-size: 7px;
        font-weight: 900;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .fa-tabla td.fa-prod::before {
        content: none;
    }

    .fa-prod-nombre {
        font-size: 15px;
    }

    .fa-prod-desc {
        max-width: none;
        margin-top: 2px;
        font-size: 8px;
        line-height: 1.3;
    }

    .fa-cant {
        min-width: 0;
        padding: 2px 8px;
        font-size: 12px;
    }

    .fa-precio {
        font-size: 12px;
    }

    .fa-subtotal {
        font-size: 15px;
    }

    .fa-vacio {
        padding: 14px 0;
        font-size: 11px;
    }

    /* ----- 4. PAGO: QR arriba, total abajo ----- */

    .fa-pago {
        display: flex;
        flex-direction: column;
        gap: 8px;
        margin-top: 8px;
    }

    .fa-qr {
        padding: 8px 12px 10px;
        text-align: center;
    }

    .fa-qr h3 {
        margin: 0 0 8px;
        padding-bottom: 6px;
        border-bottom: 1px solid #8a8079;
        font-size: 13px;
    }

    .fa-qr-marco {
        padding: 5px;
        border-radius: 10px;
        background: white;
        border: 1px dashed #8a8079;
    }

    .fa-qr-marco img {
        width: 130px;
        height: 130px;
    }

    .fa-total {
        display: block;
        padding: 8px 12px 10px;
        border: 1.5px solid var(--cafe);
    }

    .fa-total-linea {
        padding: 4px 0;
        border-bottom: 1px dashed #8a8079;
        color: var(--gris);
        font-size: 10px;
    }

    .fa-total-linea strong {
        color: var(--cafe);
    }

    .fa-total-etiqueta {
        margin-top: 8px;
        color: var(--gris);
        font-size: 9px;
        text-align: center;
    }

    .fa-total-monto {
        margin-top: 2px;
        color: var(--cafe);
        font-size: 40px;
        letter-spacing: -1px;
        text-align: center;
    }

    .fa-total-monto small {
        margin-right: 4px;
        color: var(--verde);
    }

    /* ----- 5. PIE ----- */

    .fa-footer {
        margin-top: 8px;
        padding: 10px 12px;
        text-align: center;
    }

    .fa-footer h2,
    .fa-footer h2 span {
        max-width: none;
        font-size: 16px;
        line-height: 1.1;
        color: var(--cafe);
    }

    .fa-footer h2 span {
        color: var(--verde);
    }

    .fa-footer p {
        max-width: none;
        margin: 6px 0 0;
        font-size: 9px;
        color: var(--gris);
    }

    .fa-footer-lugar {
        margin-top: 8px;
        padding: 0;
        background: none;
        color: var(--gris);
        font-size: 8px;
    }

}

</style>


<?php include $_SERVER['DOCUMENT_ROOT'] . '/organiczoneOF/includes/oz-navegacion.php'; ?>
</head>


<body>

<header class="fa-topbar">

    <a
        href="<?php echo $volverInicio; ?>"
        class="fa-logo"
    >

        <img
            class="fa-logo-img"
            src="../logoOz.png"
            alt="Organic Zone"
        >

    </a>

    <div class="fa-topbar-botones">

        <!-- VOLVER A PEDIDOS -->

        <a
            href="leerpedidos.php"
            class="fa-btn-top"
        >

            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="3"
                 stroke-linecap="round" stroke-linejoin="round"
                 aria-hidden="true">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>

            Pedidos

        </a>

        <!-- IMPRIMIR -->

        <button
            type="button"
            onclick="window.print()"
            class="fa-btn-top imprimir"
        >

            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2.6"
                 stroke-linecap="round" stroke-linejoin="round"
                 aria-hidden="true">
                <path d="M6 9V3h12v6"/>
                <rect x="3" y="9" width="18" height="9" rx="2"/>
                <path d="M7 14h10v7H7z"/>
            </svg>

            Imprimir factura

        </button>

    </div>

</header>


<main class="fa-contenedor">


    <!-- ================= CABECERA ================= -->

    <section class="fa-hero">

        <div class="fa-hero-texto">

            <span class="fa-etiqueta">
                ORGANICZONE
            </span>

            <h1 class="fa-titulo">
                Factura<span>.</span>
            </h1>

            <p class="fa-subtitulo">
                Productos naturales y orgánicos
            </p>

            <div class="fa-meta">

                <span class="fa-meta-label">
                    Estado actual del pedido
                </span>

                <span class="fa-estado <?= $claseEstado ?>">
                    <?= limpiar($pedido['estado']) ?>
                </span>

            </div>

        </div>

        <div class="fa-sello">

            <small>Nº</small>

            <strong><?= limpiar($pedido['id']) ?></strong>

        </div>

    </section>


    <!-- ================= INFORMACIÓN ================= -->

    <section class="fa-info">

        <article class="fa-caja">

            <span class="fa-caja-etiqueta">
                Información del cliente
            </span>

            <h2 class="fa-caja-titulo">
                <?= limpiar($pedido['nombre']) ?>
            </h2>

            <div class="fa-dato">

                <span>Teléfono</span>

                <strong>
                    <?= limpiar($pedido['telefono']) ?>
                </strong>

            </div>

        </article>


        <article class="fa-caja">

            <span class="fa-caja-etiqueta">
                Información del pedido
            </span>

            <h2 class="fa-caja-titulo">
                #<?= limpiar($pedido['id']) ?>
            </h2>

            <div class="fa-dato">

                <span>Fecha</span>

                <strong>
                    <?= limpiar($pedido['fecha']) ?>
                </strong>

            </div>

            <div class="fa-dato">

                <span>Vendedor</span>

                <strong>
                    <?= limpiar($pedido['nombrevendedor']) ?>
                </strong>

            </div>

        </article>


        <article class="fa-caja fa-caja-crema">

            <span class="fa-caja-etiqueta">
                Dirección de entrega
            </span>

            <h2 class="fa-caja-titulo">
                <?= limpiar($pedido['direccion']) ?>
            </h2>

        </article>

    </section>


    <!-- ================= DETALLE ================= -->

    <section class="fa-detalle">

        <div class="fa-encabezado">

            <div>

                <small>
                    ORGANICZONE / DETALLE
                </small>

                <h2>
                    Detalle del pedido
                </h2>

            </div>

            <span class="fa-contador">
                <?= $resultadoCarrito->num_rows ?>
                productos
            </span>

        </div>


        <?php if (
            $resultadoCarrito->num_rows > 0
        ): ?>

        <table class="fa-tabla">

            <thead>

                <tr>

                    <th>
                        Producto
                    </th>

                    <th class="c">
                        Cantidad
                    </th>

                    <th class="d">
                        Precio
                    </th>

                    <th class="d">
                        Subtotal
                    </th>

                </tr>

            </thead>

            <tbody>

            <?php while (
                $producto =
                $resultadoCarrito->fetch_assoc()
            ): ?>

                <?php

                $cantidad =
                    (int)
                    $producto['cantidad'];


                $precio =
                    (float)
                    $producto['precio'];


                $subtotal =
                    (float)
                    $producto['costototal'];


                $totalFactura +=
                    $subtotal;

                ?>

                <tr>

                    <td class="fa-prod">

                        <div class="fa-prod-nombre">

                            <?= limpiar(
                                $producto['nombre']
                            ) ?>

                        </div>

                        <?php if (
                            !empty(
                                $producto['descripcion']
                            )
                        ): ?>

                            <div class="fa-prod-desc">

                                <?= limpiar(
                                    $producto['descripcion']
                                ) ?>

                            </div>

                        <?php endif; ?>

                    </td>

                    <td class="c" data-label="Cantidad">

                        <span class="fa-cant">
                            × <?= $cantidad ?>
                        </span>

                    </td>

                    <td class="d" data-label="Precio">

                        <span class="fa-precio">

                            <span class="fa-bs">Bs.</span><?= number_format(
                                $precio,
                                2
                            ) ?>

                        </span>

                    </td>

                    <td class="d" data-label="Subtotal">

                        <strong class="fa-subtotal">

                            <span class="fa-bs">Bs.</span><?= number_format(
                                $subtotal,
                                2
                            ) ?>

                        </strong>

                    </td>

                </tr>

            <?php endwhile; ?>

            </tbody>

        </table>

        <?php else: ?>

            <div class="fa-vacio">

                Este pedido todavía no tiene productos.

            </div>

        <?php endif; ?>

    </section>


    <!-- ================= PAGO ================= -->

    <section class="fa-pago">

        <div class="fa-qr">

            <h3>
                Escanea para realizar el pago
            </h3>

            <div class="fa-qr-marco">

                <img
                    src="../Imagenes/QR.jpeg"
                    alt="QR de pago"
                >

            </div>

        </div>


        <div class="fa-total">

            <div>

                <div class="fa-total-linea">

                    <span>Pedido</span>

                    <strong>
                        #<?= limpiar($pedido['id']) ?>
                    </strong>

                </div>

                <div class="fa-total-linea">

                    <span>Productos</span>

                    <strong>
                        <?= $resultadoCarrito->num_rows ?>
                    </strong>

                </div>

            </div>

            <div>

                <span class="fa-total-etiqueta">
                    TOTAL
                </span>

                <span class="fa-total-monto">

                    <small>Bs.</small><?= number_format(
                        $totalFactura,
                        2
                    ) ?>

                </span>

            </div>

        </div>

    </section>


    <!-- ================= PIE ================= -->

    <footer class="fa-footer">

        <h2>
            Gracias por comprar en <span>OrganicZone</span>
        </h2>

        <p>
            Productos naturales, orgánicos
            y preparados con dedicación.
        </p>

        <span class="fa-footer-lugar">
            COCHABAMBA, BOLIVIA · 2026
        </span>

    </footer>


    <!-- ================= ACCIONES ================= -->

    <div class="fa-acciones">

        <a
            href="leerpedidos.php"
            class="fa-btn fa-btn-volver"
        >

            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="3"
                 stroke-linecap="round" stroke-linejoin="round"
                 aria-hidden="true">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>

            Volver a pedidos

        </a>

        <button
            type="button"
            onclick="window.print()"
            class="fa-btn fa-btn-imprimir"
        >

            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2.6"
                 stroke-linecap="round" stroke-linejoin="round"
                 aria-hidden="true">
                <path d="M6 9V3h12v6"/>
                <rect x="3" y="9" width="18" height="9" rx="2"/>
                <path d="M7 14h10v7H7z"/>
            </svg>

            Imprimir factura

        </button>

    </div>


</main>

</body>

</html>


<?php

$stmtCarrito->close();

$conn->close();

?>