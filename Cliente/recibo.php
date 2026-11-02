<?php
session_start();

$pedidoId = isset($_GET['id'])
    ? (int) $_GET['id']
    : (int) ($_SESSION['pedido_id'] ?? 0);

if ($pedidoId <= 0) {
    header('Location: index.php');
    exit();
}

$_SESSION['pedido_id'] = $pedidoId;

$conexion = new mysqli('localhost', 'root', '', 'organiczoneBD');

if ($conexion->connect_error) {
    die('Error de conexión.');
}

$conexion->set_charset('utf8mb4');

$stmtPedido = $conexion->prepare('SELECT id, nombre, fecha, estado, nombrevendedor, direccion, telefono, metodo FROM pedidos WHERE id = ? LIMIT 1');
$stmtPedido->bind_param('i', $pedidoId);
$stmtPedido->execute();
$pedido = $stmtPedido->get_result()->fetch_assoc();
$stmtPedido->close();

if (!$pedido) {
    header('Location: index.php');
    exit();
}

$stmtCarrito = $conexion->prepare('SELECT c.cantidad, c.costototal, p.nombre, p.precio FROM carrito c INNER JOIN productos p ON p.id = c.productos_id WHERE c.pedidos_id = ? ORDER BY p.nombre');
$stmtCarrito->bind_param('i', $pedidoId);
$stmtCarrito->execute();
$resultadoCarrito = $stmtCarrito->get_result();

$items = [];
$total = 0;

while ($fila = $resultadoCarrito->fetch_assoc()) {
    $fila['cantidad'] = (int) $fila['cantidad'];
    $fila['precio'] = (int) $fila['precio'];
    $fila['costototal'] = (int) $fila['costototal'];
    $total += $fila['costototal'];
    $items[] = $fila;
}

$stmtCarrito->close();
$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprobante #<?= $pedidoId ?> | Organic Zone</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <style>

        :root {
            --verde: #12A33C;
            --verde-oscuro: #0A4A1B;
            --verde-claro: #EAF7EC;
            --cafe: #2B140D;
            --crema: #FCD09F;
            --fondo: #F5EEE3;
            --papel: #F8F4EC;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--fondo);
            font-family: 'Nunito', sans-serif;
            color: var(--cafe);
            padding: 35px 20px;
        }

        /* =====================================================
           TARJETA (plana, sin sombras ni bordes)
           ===================================================== */

        .comprobante {
            width: min(850px, 100%);
            margin: auto;
            background: white;
            border-radius: 42px;
            overflow: hidden;
        }

        /* =====================================================
           CABECERA
           ===================================================== */

        .cabecera {
            position: relative;
            overflow: hidden;
            background: var(--verde);
            color: white;
            padding: 42px 48px;
            display: flex;
            justify-content: space-between;
            gap: 20px;
            align-items: end;
        }

        /* Un solo círculo plano de adorno */
        .cabecera::before {
            content: "";
            position: absolute;
            width: 260px;
            height: 260px;
            right: -80px;
            top: -120px;
            border-radius: 50%;
            background: var(--crema);
            opacity: .25;
        }

        .marca,
        .numero {
            position: relative;
            z-index: 1;
        }

        /* My Oz: igual que el original */
        .marca {
            font-family: 'Fredoka', sans-serif;
            font-size: 78px;
            line-height: .75;
            font-weight: 700;
            min-width: 110px;
        }

        .marca span {
            display: block;
            font-size: 18px;
            color: var(--crema);
        }

        .numero {
            text-align: right;
            padding: 12px 24px;
            border-radius: 100px;
            background: var(--verde-oscuro);
        }

        .numero small {
            display: block;
            opacity: .8;
            font-size: 11px;
            font-weight: 900;
            letter-spacing: 2px;
        }

        .numero strong {
            font-family: 'Fredoka', sans-serif;
            font-size: 30px;
            line-height: 1.1;
        }

        /* =====================================================
           CONTENIDO
           ===================================================== */

        .contenido {
            padding: 38px 48px 42px;
        }

        .estado {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            padding: 10px 18px;
            border-radius: 100px;
            background: #fff1d9;
            color: #8b5b13;
            font-weight: 900;
            margin-bottom: 26px;
        }

        .estado::before {
            content: "";
            width: 9px;
            height: 9px;
            border-radius: 50%;
            background: #e0a02b;
        }

        /* ---------- Datos ---------- */

        .datos {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
            margin-bottom: 34px;
        }

        .dato {
            display: grid;
            grid-template-columns: auto 1fr;
            align-items: center;
            gap: 4px 14px;
            padding: 16px 20px 16px 16px;
            background: var(--papel);
            border-radius: 26px;
        }

        .ico {
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: var(--verde-claro);
            color: var(--verde);
        }

        .ico svg {
            width: 20px;
            height: 20px;
            fill: none;
            stroke: currentColor;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .dato-texto {
            min-width: 0;
        }

        .dato-texto span {
            display: block;
            margin-bottom: 2px;
            color: #858078;
            font-size: 11px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .dato-texto strong {
            display: block;
            font-size: 17px;
            overflow-wrap: anywhere;
        }

        .dato.ancho {
            grid-column: 1 / -1;
        }

        /* QR del comprobante (dentro de Método de pago) */
        .qr-comprobante {
            grid-column: 1 / -1;
            margin-top: 12px;
            text-align: center;
        }

        .codigo-qr {
            display: block;
            width: 150px;
            height: 150px;
            object-fit: contain;
            margin: 0 auto;
            padding: 10px;
            background: white;
            border-radius: 22px;
        }

        /* ---------- Tabla ---------- */

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 6px;
        }

        thead th {
            padding: 13px 16px;
            background: var(--cafe);
            color: var(--crema);
            font-size: 11px;
            font-weight: 900;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            text-align: left;
        }

        thead th:first-child {
            padding-left: 24px;
            border-radius: 100px 0 0 100px;
        }

        thead th:last-child {
            padding-right: 24px;
            border-radius: 0 100px 100px 0;
            text-align: right;
        }

        tbody td {
            padding: 15px 16px;
            background: var(--papel);
        }

        tbody td:first-child {
            padding-left: 24px;
            border-radius: 100px 0 0 100px;
            font-weight: 800;
        }

        tbody td:last-child {
            padding-right: 24px;
            border-radius: 0 100px 100px 0;
            text-align: right;
            font-weight: 900;
        }

        th:nth-child(2),
        td:nth-child(2) {
            text-align: center;
        }

        .cant {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 34px;
            height: 34px;
            padding: 0 10px;
            border-radius: 100px;
            background: var(--crema);
            color: var(--cafe);
            font-weight: 900;
        }

        /* ---------- QR de pago ---------- */

        .qr-pago {
            text-align: center;
            margin: 28px 0 26px;
            padding: 26px 25px;
            border-radius: 30px;
            background: var(--verde-claro);
        }

        .qr-pago p {
            margin: 0 0 16px;
            font-weight: 800;
            color: var(--cafe);
            font-size: 15px;
        }

        .qr-pago img {
            width: 170px;
            height: 170px;
            object-fit: contain;
            padding: 12px;
            background: white;
            border-radius: 24px;
        }

        /* ---------- Total ---------- */

        .total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            padding: 20px 36px;
            border-radius: 100px;
            background: var(--cafe);
            color: var(--crema);
        }

        .total span {
            font-size: 14px;
            font-weight: 900;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .total strong {
            font-family: 'Fredoka', sans-serif;
            font-size: 36px;
            line-height: 1;
            color: white;
        }

        /* ---------- Botones ---------- */

        .acciones {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        .acciones a {
            padding: 14px 26px;
            border-radius: 100px;
            text-decoration: none;
            font-weight: 900;
            transition: transform .2s ease;
        }

        .acciones a:hover {
            transform: translateY(-2px);
        }

        .verde {
            background: var(--verde);
            color: white;
        }

        .cafe {
            background: var(--cafe);
            color: white;
        }

        .gracias {
            margin: 28px 0 0;
            text-align: center;
            color: #858078;
            font-size: 13px;
            font-weight: 800;
        }

        /* =====================================================
           RESPONSIVE
           ===================================================== */

        @media (max-width: 600px) {

            .cabecera {
                padding: 30px 25px;
                flex-direction: column;
                align-items: start;
            }

            .contenido {
                padding: 28px 25px 32px;
            }

            .numero {
                text-align: left;
            }

            .datos {
                grid-template-columns: 1fr;
            }

            thead th,
            tbody td {
                padding: 12px 8px;
            }

            thead th:first-child,
            tbody td:first-child {
                padding-left: 16px;
            }

            thead th:last-child,
            tbody td:last-child {
                padding-right: 16px;
            }

            tbody td {
                font-size: 14px;
            }

            .total {
                padding: 18px 26px;
            }

            .total strong {
                font-size: 28px;
            }

        }

        @media print {

            body {
                background: white;
                padding: 0;
            }

            .acciones {
                display: none;
            }

        }

    </style>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/organiczoneOF/includes/oz-navegacion.php'; ?>
</head>

<body>

<div class="comprobante">

    <header class="cabecera">

        <div class="marca">
            <span>My</span>Oz
        </div>

        <div class="numero">
            <small>COMPROBANTE</small>
            <strong>#<?= $pedidoId ?></strong>
        </div>

    </header>

    <main class="contenido">

        <div class="estado">
            Estado: <?= htmlspecialchars($pedido['estado']) ?>
        </div>

        <section class="datos">

            <div class="dato">

                <span class="ico">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                </span>

                <div class="dato-texto">
                    <span>Cliente</span>

                    <strong>
                        <?= htmlspecialchars($pedido['nombre']) ?>
                    </strong>
                </div>

            </div>

            <div class="dato">

                <span class="ico">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <rect x="3" y="4" width="18" height="18" rx="2"/>
                        <path d="M16 2v4M8 2v4M3 10h18"/>
                    </svg>
                </span>

                <div class="dato-texto">
                    <span>Fecha</span>

                    <strong>
                        <?= htmlspecialchars($pedido['fecha']) ?>
                    </strong>
                </div>

            </div>

            <div class="dato">

                <span class="ico">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z"/>
                    </svg>
                </span>

                <div class="dato-texto">
                    <span>Teléfono</span>

                    <strong>
                        <?= htmlspecialchars($pedido['telefono']) ?>
                    </strong>
                </div>

            </div>

            <div class="dato">

                <span class="ico">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <rect x="1" y="4" width="22" height="16" rx="2"/>
                        <path d="M1 10h22"/>
                    </svg>
                </span>

                <div class="dato-texto">
                    <span>Método de pago</span>

                    <strong>
                        <?= htmlspecialchars($pedido['metodo']) ?>
                    </strong>
                </div>

                <!-- QR DEL COMPROBANTE: SE GENERA AUTOMÁTICAMENTE -->
                <div class="qr-comprobante">

                    <img
                        class="codigo-qr"
                        src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=<?= urlencode('http://localhost/organiczoneOF/comprobante.php?id=' . $pedidoId) ?>"
                        alt="Código QR del comprobante"
                    >

                </div>

            </div>

            <div class="dato ancho">

                <span class="ico">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                        <circle cx="12" cy="10" r="3"/>
                    </svg>
                </span>

                <div class="dato-texto">
                    <span>Dirección</span>

                    <strong>
                        <?= htmlspecialchars($pedido['direccion']) ?>
                    </strong>
                </div>

            </div>

        </section>

        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Total</th>
                </tr>
            </thead>

            <tbody>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td>
                        <?= htmlspecialchars($item['nombre']) ?>
                    </td>
                    <td>
                        <span class="cant"><?= $item['cantidad'] ?></span>
                    </td>
                    <td>
                        Bs. <?= number_format($item['precio'], 0, ',', '.') ?>
                    </td>
                    <td>
                        Bs. <?= number_format($item['costototal'], 0, ',', '.') ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>

        </table>

        <!-- QR DE PAGO: IMAGEN QUE TÚ TIENES GUARDADA -->
        <div class="qr-pago">
            <p>
                Escanea el código QR para realizar el pago
            </p>

            <img
                src="../Imagenes/QR.jpeg"
                alt="Código QR de pago"
            >
        </div>

        <div class="total">
            <span>Total</span>
            <strong>
                Bs. <?= number_format($total, 0, ',', '.') ?>
            </strong>
        </div>

        <div class="acciones">
            <a
                class="verde"
                href="consultar_pedido.php?id=<?= (int)$pedido['id'] ?>"
            >
                Consultar estado
            </a>

            <a
                class="cafe"
                href="nuevo_pedido.php"
            >
                Nueva compra
            </a>
        </div>

        <p class="gracias">¡Gracias por tu compra!</p>

    </main>

</div>
</body>
</html>