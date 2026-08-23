<?php
session_start();

if (!isset($_SESSION['CI']) || ($_SESSION['rol'] ?? '') !== 'cliente') {
    header('Location: ../Usuarios/formulariosesion.php');
    exit();
}

$pedidoId = (int) ($_SESSION['pedido_id'] ?? 0);
$pedido = null;

if ($pedidoId > 0) {
    $conexion = new mysqli('localhost', 'root', '', 'organiczoneBD');

    if (!$conexion->connect_error) {
        $stmt = $conexion->prepare('SELECT id, fecha, estado, nombrevendedor, metodo FROM pedidos WHERE id = ? LIMIT 1');
        $stmt->bind_param('i', $pedidoId);
        $stmt->execute();
        $pedido = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $conexion->close();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estado del pedido | Organic Zone</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root{--verde:#12A33C;--verde-oscuro:#0A4A1B;--cafe:#2B140D;--crema:#FCD09F;--fondo:#F5EEE3}
        *{box-sizing:border-box}body{margin:0;background:var(--fondo);font-family:'Nunito',sans-serif;color:var(--cafe);min-height:100vh;display:flex;align-items:center;justify-content:center;padding:25px}
        .caja{width:min(700px,100%);background:white;border-radius:42px;padding:45px;box-shadow:0 18px 45px rgba(43,20,13,.14);text-align:center}
        .marca{font-family: 'Fredoka', sans-serif;font-size: 84px;line-height: .75; font-weight: 700; min-width: 110px;;color:var(--verde);line-height:.75}.marca span{display:block;font-size:17px;color:var(--cafe)}
        h1{font-family:'Fredoka',sans-serif;font-size:50px;margin:35px 0 10px}.sub{color:#777;margin-bottom:35px}
        .numero{font-size:20px;font-weight:900}.numero strong{color:var(--verde)}
        .estado{margin:25px auto;padding:18px;border-radius:25px;background:#fff3dc;color:#8a5b18;font-family:'Fredoka',sans-serif;font-size:30px;width:fit-content;min-width:220px}
        .estado.en-proceso{background:#e1f5e5;color:var(--verde-oscuro)}.estado.rechazado{background:#fbe2df;color:#a62c20}
        .datos{display:grid;grid-template-columns:1fr 1fr;gap:15px;text-align:left;margin:30px 0}.dato{padding:16px;border-radius:18px;background:#f7f5f0}.dato span{display:block;color:#888;font-size:12px;font-weight:900}.dato strong{font-size:16px}
        .acciones{display:flex;justify-content:center;gap:12px;flex-wrap:wrap}.acciones a{padding:13px 20px;border-radius:17px;text-decoration:none;font-weight:900}.verde{background:var(--verde);color:white}.cafe{background:var(--cafe);color:white}
        @media(max-width:600px){.caja{padding:30px 20px}.datos{grid-template-columns:1fr}h1{font-size:40px}}
    </style>
</head>
<body>
<div class="caja">
    <div class="marca"><span>My</span>Oz</div>

    <?php if ($pedido): ?>
        <h1>Estado de tu pedido</h1>
        <p class="sub">Aquí puedes revisar cómo avanza tu compra.</p>
        <div class="numero">Pedido <strong>#<?= (int)$pedido['id'] ?></strong></div>

        <?php
            $claseEstado = '';
            if ($pedido['estado'] === 'En proceso') $claseEstado = 'en-proceso';
            if ($pedido['estado'] === 'Rechazado') $claseEstado = 'rechazado';
        ?>
        <div class="estado <?= $claseEstado ?>">
            <?= htmlspecialchars($pedido['estado']) ?>
        </div>

        <section class="datos">
            <div class="dato"><span>Fecha</span><strong><?= htmlspecialchars($pedido['fecha']) ?></strong></div>
            <div class="dato"><span>Método de pago</span><strong><?= htmlspecialchars($pedido['metodo']) ?></strong></div>
            <div class="dato"><span>Vendedor</span><strong><?= htmlspecialchars($pedido['nombrevendedor'] ?: 'Aún no asignado') ?></strong></div>
        </section>

        <div class="acciones">
            <a class="verde" href="recibo.php">Ver comprobante</a>
            <a class="cafe" href="vistacliente.php">Volver a productos</a>
        </div>
    <?php else: ?>
        <h1>Aún no tienes un pedido activo</h1>
        <p class="sub">Genera un pedido desde la vista de cliente para comenzar.</p>
        <div class="acciones"><a class="verde" href="vistacliente.php">Ir a productos</a></div>
    <?php endif; ?>
</div>
</body>
</html>
