<?php

$nombreServidor = "localhost";
$nombreUsuario = "root";
$contraseñaBaseDeDatos = "";
$nombreBaseDeDatos = "organiczoneBD";

// CONEXIÓN
$conexion = new mysqli(
    $nombreServidor,
    $nombreUsuario,
    $contraseñaBaseDeDatos,
    $nombreBaseDeDatos
);

if ($conexion->connect_error) {
    die("Error en la conexión con la base de datos.");
}

$conexion->set_charset("utf8mb4");

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID de pedido no válido.");
}

$id = (int) $_GET['id'];

$sql = "SELECT * FROM pedidos WHERE id = ?";
$stmt = $conexion->prepare($sql);

if (!$stmt) {
    die("Error al preparar la consulta.");
}

$stmt->bind_param("i", $id);
$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    die("Pedido no encontrado.");
}

$fila = $resultado->fetch_assoc();

$stmt->close();
$conexion->close();

function limpiar($dato)
{
    return htmlspecialchars($dato ?? '', ENT_QUOTES, 'UTF-8');
}

$estado = strtolower(trim($fila['estado'] ?? ''));

$claseEstado = "estado-default";

if ($estado === "pendiente") {
    $claseEstado = "estado-pendiente";
} elseif ($estado === "procesando" || $estado === "en proceso") {
    $claseEstado = "estado-proceso";
} elseif ($estado === "enviado") {
    $claseEstado = "estado-enviado";
} elseif ($estado === "entregado") {
    $claseEstado = "estado-entregado";
} elseif ($estado === "cancelado") {
    $claseEstado = "estado-cancelado";
}

?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Factura #<?= limpiar($fila['id']) ?></title>

<style>

* {
    box-sizing: border-box;
}

html,
body {
    margin: 0;
    padding: 0;
    min-height: 100%;
}

body {
    font-family: Arial, Helvetica, sans-serif;
    background: #eef1f3;
    color: #222;
}

.topbar {
    width: 100%;
    background: #111;
    color: white;
    padding: 18px 5%;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.logo {
    font-size: 22px;
    font-weight: 800;
    letter-spacing: 1px;
}

.logo span {
    color: #8bc34a;
}

.topbar-buttons {
    display: flex;
    gap: 10px;
}

.top-btn {
    text-decoration: none;
    color: white;
    border: 1px solid #555;
    padding: 9px 16px;
    border-radius: 6px;
    font-size: 14px;
    cursor: pointer;
    background: transparent;
    transition: 0.2s;
}

.top-btn:hover {
    background: #333;
}

.top-btn.green {
    background: #7cb342;
    border-color: #7cb342;
}

.top-btn.green:hover {
    background: #689f38;
}

.contenedor {
    width: 92%;
    max-width: 1050px;
    margin: 40px auto;
}

.factura {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 10px 35px rgba(0, 0, 0, 0.10);
}

.factura-header {
    padding: 40px;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    border-bottom: 1px solid #e8e8e8;
}

.empresa h1 {
    margin: 0;
    font-size: 30px;
    color: #111;
}

.empresa h1 span {
    color: #7cb342;
}

.empresa p {
    margin: 8px 0 0;
    color: #777;
    font-size: 14px;
}

.factura-titulo {
    text-align: right;
}

.factura-titulo h2 {
    margin: 0;
    font-size: 30px;
    color: #222;
}

.numero {
    margin-top: 8px;
    color: #777;
    font-size: 14px;
}

.info {
    padding: 30px 40px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
    border-bottom: 1px solid #eee;
}

.info-box h3 {
    margin: 0 0 15px;
    font-size: 13px;
    color: #888;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.info-box p {
    margin: 6px 0;
    font-size: 15px;
    color: #333;
}

.info-box strong {
    color: #111;
}

.estado-contenedor {
    padding: 25px 40px;
    background: #fafafa;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.estado-label {
    font-size: 14px;
    color: #777;
}

.estado {
    padding: 8px 16px;
    border-radius: 30px;
    font-size: 13px;
    font-weight: bold;
    text-transform: uppercase;
}

.estado-pendiente {
    background: #fff3cd;
    color: #856404;
}

.estado-proceso {
    background: #cfe2ff;
    color: #084298;
}

.estado-enviado {
    background: #d1ecf1;
    color: #0c5460;
}

.estado-entregado {
    background: #d1e7dd;
    color: #0f5132;
}

.estado-cancelado {
    background: #f8d7da;
    color: #842029;
}

.estado-default {
    background: #e9ecef;
    color: #495057;
}

.tabla-contenedor {
    padding: 30px 40px;
}

.tabla {
    width: 100%;
    border-collapse: collapse;
}

.tabla th {
    background: #111;
    color: white;
    padding: 14px;
    text-align: left;
    font-size: 13px;
}

.tabla td {
    padding: 18px 14px;
    border-bottom: 1px solid #eee;
    font-size: 14px;
}

.tabla tr:last-child td {
    border-bottom: none;
}

.col-id {
    width: 100px;
    color: #777;
}

.resumen {
    display: flex;
    justify-content: flex-end;
    padding: 10px 40px 35px;
}

.resumen-box {
    width: 320px;
}

.total-linea {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    color: #555;
}

.total-final {
    border-top: 2px solid #111;
    margin-top: 8px;
    padding-top: 18px;
    display: flex;
    justify-content: space-between;
    font-size: 22px;
    font-weight: bold;
    color: #111;
}

.direccion {
    margin: 0 40px 35px;
    padding: 20px;
    background: #f6f7f8;
    border-left: 4px solid #7cb342;
    border-radius: 5px;
}

.direccion h3 {
    margin: 0 0 8px;
    font-size: 13px;
    text-transform: uppercase;
    color: #777;
}

.direccion p {
    margin: 0;
    color: #333;
}

.factura-footer {
    padding: 25px 40px;
    background: #111;
    color: #aaa;
    text-align: center;
    font-size: 13px;
}

.factura-footer strong {
    color: white;
}
.acciones {
    margin-top: 25px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.btn {
    display: inline-block;
    padding: 12px 20px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 14px;
    font-weight: bold;
    cursor: pointer;
    border: none;
    transition: 0.2s;
}

.btn-volver {
    background: #555;
    color: white;
}

.btn-volver:hover {
    background: #333;
}

.btn-imprimir {
    background: #111;
    color: white;
}

.btn-imprimir:hover {
    background: #333;
}

.botones-derecha {
    display: flex;
    gap: 10px;
}

@media (max-width: 700px) {

    .topbar {
        flex-direction: column;
        gap: 15px;
        text-align: center;
    }

    .contenedor {
        width: 95%;
        margin: 20px auto;
    }

    .factura-header {
        padding: 25px;
        flex-direction: column;
        gap: 25px;
    }

    .factura-titulo {
        text-align: left;
    }

    .info {
        grid-template-columns: 1fr;
        gap: 25px;
        padding: 25px;
    }

    .tabla-contenedor {
        padding: 20px;
        overflow-x: auto;
    }

    .estado-contenedor {
        padding: 20px;
    }

    .resumen {
        padding: 10px 20px 25px;
    }

    .direccion {
        margin: 0 20px 25px;
    }

    .factura-footer {
        padding: 20px;
    }

    .acciones {
        flex-direction: column;
        gap: 12px;
        align-items: stretch;
    }

    .botones-derecha {
        flex-direction: column;
    }

    .btn {
        text-align: center;
        width: 100%;
    }

}

@media print {

    body {
        background: white;
    }

    .topbar,
    .acciones {
        display: none;
    }

    .contenedor {
        width: 100%;
        max-width: none;
        margin: 0;
    }

    .factura {
        box-shadow: none;
        border-radius: 0;
    }

    .factura-footer {
        background: white;
        color: #555;
        border-top: 1px solid #ddd;
    }

    .factura-footer strong {
        color: #111;
    }

}

</style>

</head>

<body>
<header class="topbar">
    <div class="logo">
        ORGANIC<span>ZONE</span>
    </div>
    <div class="topbar-buttons">

        <a href="leerpedidos.php" class="top-btn">
            ← Pedidos
        </a>

        <button onclick="window.print()" class="top-btn green">
            🖨 Imprimir factura
        </button>

    </div>

</header>

<main class="contenedor">


    <div class="factura">


        <!-- CABECERA -->

        <section class="factura-header">

            <div class="empresa">

                <h1>
                    ORGANIC<span>ZONE</span>
                </h1>

                <p>
                    Productos naturales y orgánicos
                </p>

            </div>


            <div class="factura-titulo">

                <h2>
                    FACTURA
                </h2>

                <div class="numero">
                    N.º #<?= limpiar($fila['id']) ?>
                </div>

            </div>

        </section>
        <section class="info">


            <div class="info-box">

                <h3>
                    Información del cliente
                </h3>

                <p>
                    <strong>
                        <?= limpiar($fila['nombre']) ?>
                    </strong>
                </p>

                <p>
                    📞 <?= limpiar($fila['telefono']) ?>
                </p>

                <p>
                    📍 <?= limpiar($fila['direccion']) ?>
                </p>

            </div>


            <div class="info-box">

                <h3>
                    Información del pedido
                </h3>

                <p>
                    <strong>
                        Pedido #<?= limpiar($fila['id']) ?>
                    </strong>
                </p>

                <p>
                    📅 <?= limpiar($fila['fecha']) ?>
                </p>

                <p>
                    Vendedor:
                    <strong>
                        <?= limpiar($fila['nombrevendedor']) ?>
                    </strong>
                </p>

            </div>


        </section>
        <section class="estado-contenedor">

            <span class="estado-label">
                Estado actual del pedido
            </span>

            <span class="estado <?= $claseEstado ?>">
                <?= limpiar($fila['estado']) ?>
            </span>

        </section>
        <section class="tabla-contenedor">

            <table class="tabla">

                <thead>

                    <tr>

                        <th>
                            ID
                        </th>

                        <th>
                            Descripción
                        </th>

                        <th>
                            Cliente
                        </th>

                        <th>
                            Estado
                        </th>

                    </tr>

                </thead>

                <tbody>

                    <tr>

                        <td class="col-id">
                            #<?= limpiar($fila['id']) ?>
                        </td>

                        <td>
                            Pedido de productos OrganicZone
                        </td>

                        <td>
                            <?= limpiar($fila['nombre']) ?>
                        </td>

                        <td>
                            <?= limpiar($fila['estado']) ?>
                        </td>

                    </tr>

                </tbody>

            </table>

        </section>
        <section class="resumen">

            <div class="resumen-box">

                <div class="total-linea">

                    <span>
                        Pedido
                    </span>

                    <span>
                        #<?= limpiar($fila['id']) ?>
                    </span>

                </div>


                <div class="total-linea">

                    <span>
                        Estado
                    </span>

                    <span>
                        <?= limpiar($fila['estado']) ?>
                    </span>

                </div>


                <div class="total-final">

                    <span>
                        TOTAL
                    </span>

                    <span>
                        Ver pedido
                    </span>

                </div>

            </div>

        </section>
        <section class="direccion">

            <h3>
                Dirección de entrega
            </h3>

            <p>
                <?= limpiar($fila['direccion']) ?>
            </p>

        </section>
        <footer class="factura-footer">

            <strong>
                Gracias por comprar en OrganicZone
            </strong>

            <br>

            Esta factura corresponde al pedido
            #<?= limpiar($fila['id']) ?>.

        </footer>


    </div>
    <div class="acciones">

        <a href="leercarrito.php" class="btn btn-volver">
            ← Volver a pedidos
        </a>


        <div class="botones-derecha">
            <button
                onclick="window.print()"
                class="btn btn-imprimir"
            >
                🖨 Imprimir
            </button>

        </div>

    </div>


</main>


</body>

</html>
