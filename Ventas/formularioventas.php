<?php
$pedidos_id = $_GET['pedido'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Venta</title>
</head>
<body>

    <h2>Registrar Venta</h2>

    <form action="ventas.php" method="POST">

        <input type="hidden" name="pedidos_id" value="<?php echo $pedidos_id; ?>">

        <label>Método de Pago</label>
        <select name="metodo" required>
            <option value="">Seleccione</option>
            <option value="Efectivo">Efectivo</option>
            <option value="QR">QR</option>
            <option value="Transferencia">Transferencia</option>
        </select>

        <br><br>

        <button type="submit">Registrar Venta</button>

    </form>

</body>
</html>