<?php
session_start();

if (!isset($_SESSION['CI']) || ($_SESSION['rol'] ?? '') !== 'cliente') {
    header('Location: ../Usuarios/formulariosesion.php');
    exit();
}

$pedidoId = (int) ($_SESSION['pedido_id'] ?? 0);

if ($pedidoId <= 0) {
    header('Location: vistacliente.php');
    exit();
}

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
    header('Location: vistacliente.php');
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
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root{--verde:#12A33C;--verde-oscuro:#0A4A1B;--cafe:#2B140D;--crema:#FCD09F;--fondo:#F5EEE3;}
        *{box-sizing:border-box}
        body{margin:0;background:var(--fondo);font-family:'Nunito',sans-serif;color:var(--cafe);padding:35px 20px}
        .comprobante{width:min(850px,100%);margin:auto;background:white;border-radius:42px;overflow:hidden;box-shadow:0 18px 45px rgba(43,20,13,.14)}
        .cabecera{background:var(--verde);color:white;padding:42px 48px;display:flex;justify-content:space-between;gap:20px;align-items:end}
        .marca{font-family:'Fredoka',sans-serif;font-size:48px;line-height:.8}.marca span{display:block;font-size:18px;color:var(--crema)}
        .numero{text-align:right}.numero small{display:block;opacity:.8}.numero strong{font-family:'Fredoka',sans-serif;font-size:32px}
        .contenido{padding:42px 48px}
        .estado{display:inline-block;padding:10px 15px;border-radius:30px;background:#fff1d9;color:#8b5b13;font-weight:900;margin-bottom:25px}
        .datos{display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:35px}
        .dato span{display:block;color:#858078;font-size:12px;font-weight:900;text-transform:uppercase;letter-spacing:1px}.dato strong{font-size:17px}
        table{width:100%;border-collapse:collapse}th{text-align:left;padding:12px 0;border-bottom:2px solid var(--cafe)}td{padding:15px 0;border-bottom:1px solid #eee8df}td:last-child,th:last-child{text-align:right}
        .total{display:flex;justify-content:flex-end;gap:30px;font-size:26px;font-weight:900;padding-top:22px}.total strong{color:var(--verde)}
        .acciones{display:flex;justify-content:center;gap:12px;margin-top:30px;flex-wrap:wrap}.acciones a{padding:13px 20px;border-radius:17px;text-decoration:none;font-weight:900}.verde{background:var(--verde);color:white}.cafe{background:var(--cafe);color:white}
        @media(max-width:600px){.cabecera,.contenido{padding:30px 25px}.cabecera{flex-direction:column;align-items:start}.numero{text-align:left}.datos{grid-template-columns:1fr}}
    </style>
</head>
<body>
<div class="comprobante">
    <header class="cabecera">
        <div class="marca"><span>My</span>Oz</div>
        <div class="numero"><small>COMPROBANTE</small><strong>#<?= $pedidoId ?></strong></div>
    </header>

    <main class="contenido">
        <div class="estado">Estado: <?= htmlspecialchars($pedido['estado']) ?></div>

        <section class="datos">
            <div class="dato"><span>Cliente</span><strong><?= htmlspecialchars($pedido['nombre']) ?></strong></div>
            <div class="dato"><span>Fecha</span><strong><?= htmlspecialchars($pedido['fecha']) ?></strong></div>
            <div class="dato"><span>Teléfono</span><strong><?= htmlspecialchars($pedido['telefono']) ?></strong></div>
            <div class="dato"><span>Método de pago</span><strong><?= htmlspecialchars($pedido['metodo']) ?></strong></div>
            <div class="dato" style="grid-column:1/-1"><span>Dirección</span><strong><?= htmlspecialchars($pedido['direccion']) ?></strong></div>
        </section>

        <table>
            <thead><tr><th>Producto</th><th>Cantidad</th><th>Precio</th><th>Total</th></tr></thead>
            <tbody>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['nombre']) ?></td>
                    <td><?= $item['cantidad'] ?></td>
                    <td>Bs. <?= number_format($item['precio'],0,',','.') ?></td>
                    <td>Bs. <?= number_format($item['costototal'],0,',','.') ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <div class="total"><span>Total</span><strong>Bs. <?= number_format($total,0,',','.') ?></strong></div>

        <div class="acciones">
            <a class="verde" href="consultar_pedido.php">Consultar estado</a>
            <a class="cafe" href="nuevo_pedido.php">Nueva compra</a>
        </div>
    </main>
</div>
</body>
</html>
