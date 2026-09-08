<?php

$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$bd = "organiczoneBD";

$conn = new mysqli($servidor, $usuario, $contrasena, $bd);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

$idPedido = isset($_GET['pedidos_id']) ? (int)$_GET['pedidos_id'] : 0;

$sql = "SELECT * FROM productos";
$resultado = $conn->query($sql);

$sqlTotal = "SELECT SUM(costototal) AS total FROM carrito WHERE pedidos_id = ?";
$stmtTotal = $conn->prepare($sqlTotal);
$stmtTotal->bind_param("i", $idPedido);
$stmtTotal->execute();
$resultadoTotal = $stmtTotal->get_result();
$res = $resultadoTotal->fetch_assoc();

$total = $res['total'] ?? 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organic Zone | Carrito de Pedido</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Nunito:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --verde: #12A33C;
            --verde-oscuro: #0A4A1B;
            --verde-fuerte: #0D7C2F;
            --crema: #FCD09F;
            --cafe: #2B140D;
            --fondo: #F5EEE3;
            --blanco: #FFFFFF;
            --gris: #68716A;
            --gris-claro: #E9F0E8;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background:
                radial-gradient(circle at top left, rgba(18, 163, 60, .12), transparent 28%),
                radial-gradient(circle at bottom right, rgba(252, 208, 159, .35), transparent 30%),
                var(--fondo);
            font-family: 'Nunito', Arial, sans-serif;
            color: var(--cafe);
            padding: 30px 20px 60px;
        }

        .caja {
            width: min(1250px, 96%);
            margin: 0 auto;
            background: var(--blanco);
            border-radius: 42px;
            overflow: hidden;
            box-shadow: 0 18px 55px rgba(43, 20, 13, .13);
            border: 1px solid rgba(18, 163, 60, .08);
        }

        .encabezado {
            background: var(--verde);
            padding: 35px 45px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 25px;
        }

        .marca {
            display: flex;
            flex-direction: column;
            line-height: .82;
            font-family: 'Fredoka', sans-serif;
            font-weight: 700;
        }

        .marca .my {
            color: var(--crema);
            font-size: 25px;
        }

        .marca .oz {
            color: var(--blanco);
            font-size: 43px;
        }

        .pedido {
            background: rgba(255, 255, 255, .16);
            color: white;
            padding: 13px 22px;
            border-radius: 25px;
            font-size: 15px;
            font-weight: 800;
        }

        .contenido {
            padding: 42px 45px 45px;
        }

        .titulo {
            text-align: center;
            font-family: 'Fredoka', sans-serif;
            font-size: 42px;
            font-weight: 700;
            color: var(--cafe);
            margin: 0 0 10px;
        }

        .subtitulo {
            text-align: center;
            color: var(--gris);
            font-size: 16px;
            margin: 0 0 35px;
        }

        .tabla-contenedor {
            width: 100%;
            overflow-x: auto;
            border-radius: 25px;
            border: 1px solid #E4EBE3;
        }

        table {
            width: 100%;
            min-width: 850px;
            border-collapse: separate;
            border-spacing: 0;
        }

        th {
            background: var(--verde-oscuro);
            color: white;
            padding: 18px 14px;
            font-family: 'Fredoka', sans-serif;
            font-size: 16px;
            font-weight: 600;
            text-align: center;
        }

        th:first-child {
            border-radius: 24px 0 0 0;
        }

        th:last-child {
            border-radius: 0 24px 0 0;
        }

        td {
            padding: 18px 14px;
            text-align: center;
            border-bottom: 1px solid #E7ECE7;
            background: #FBFDFB;
            font-size: 15px;
            vertical-align: middle;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .producto-id {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--crema);
            color: var(--cafe);
            font-family: 'Fredoka', sans-serif;
            font-weight: 700;
        }

        .producto-nombre {
            color: var(--cafe);
            font-family: 'Fredoka', sans-serif;
            font-size: 18px;
            font-weight: 600;
        }

        .precio {
            color: var(--verde-fuerte);
            font-size: 17px;
            font-weight: 800;
        }

        .descripcion {
            max-width: 280px;
            margin: auto;
            color: var(--gris);
            line-height: 1.4;
        }

        .cantidad {
            width: 72px;
            height: 44px;
            border: 2px solid #DCE6DC;
            border-radius: 14px;
            outline: none;
            text-align: center;
            font-family: 'Nunito', sans-serif;
            font-size: 16px;
            font-weight: 700;
            color: var(--cafe);
            background: white;
            transition: .2s;
        }

        .cantidad:focus {
            border-color: var(--verde);
            box-shadow: 0 0 0 4px rgba(18, 163, 60, .10);
        }

        .boton-agregar {
            background: var(--verde);
            color: white;
            border: none;
            border-radius: 18px;
            padding: 12px 20px;
            font-family: 'Nunito', sans-serif;
            font-size: 15px;
            font-weight: 800;
            cursor: pointer;
            transition: .2s;
            box-shadow: 0 7px 16px rgba(18, 163, 60, .18);
        }

        .boton-agregar:hover {
            background: var(--verde-fuerte);
            transform: translateY(-2px);
        }

        .total-contenedor {
            display: flex;
            justify-content: flex-end;
            margin-top: 30px;
        }

        .total {
            min-width: 280px;
            background: var(--crema);
            border-radius: 25px;
            padding: 20px 28px;
            text-align: right;
            box-shadow: 0 8px 20px rgba(43, 20, 13, .08);
        }

        .total-label {
            display: block;
            color: var(--cafe);
            font-family: 'Fredoka', sans-serif;
            font-size: 17px;
            margin-bottom: 4px;
        }

        .total-precio {
            color: var(--verde-fuerte);
            font-family: 'Fredoka', sans-serif;
            font-size: 31px;
            font-weight: 700;
        }

        .botones {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            gap: 14px;
            margin-top: 35px;
        }

        .botones a {
            text-decoration: none;
            padding: 14px 25px;
            border-radius: 25px;
            font-weight: 800;
            font-size: 15px;
            transition: .2s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .boton-ver {
            background: var(--verde);
            color: white;
            box-shadow: 0 8px 18px rgba(18, 163, 60, .18);
        }

        .boton-ver:hover {
            background: var(--verde-fuerte);
            transform: translateY(-2px);
        }

        .boton-finalizar {
            background: var(--cafe);
            color: white;
            box-shadow: 0 8px 18px rgba(43, 20, 13, .15);
        }

        .boton-finalizar:hover {
            background: #442117;
            transform: translateY(-2px);
        }

        .boton-cerrar {
            background: #F1E9E5;
            color: var(--cafe);
        }

        .boton-cerrar:hover {
            background: #E5D7D1;
            transform: translateY(-2px);
        }

        .pie {
            background: var(--cafe);
            color: #D8CCC6;
            text-align: center;
            padding: 25px;
            font-size: 14px;
        }

        .pie strong {
            color: var(--crema);
            font-family: 'Fredoka', sans-serif;
        }

        @media (max-width: 700px) {
            body {
                padding: 15px 10px 35px;
            }

            .caja {
                width: 100%;
                border-radius: 28px;
            }

            .encabezado {
                padding: 25px;
            }

            .marca .oz {
                font-size: 34px;
            }

            .marca .my {
                font-size: 20px;
            }

            .pedido {
                font-size: 13px;
                padding: 10px 14px;
            }

            .contenido {
                padding: 30px 20px;
            }

            .titulo {
                font-size: 32px;
            }

            .subtitulo {
                font-size: 14px;
            }

            .total-contenedor {
                justify-content: stretch;
            }

            .total {
                width: 100%;
                min-width: 0;
            }

            .botones {
                flex-direction: column;
            }

            .botones a {
                width: 100%;
            }
        }
    </style>
</head>

<body>

<div class="caja">

    <header class="encabezado">
        <div class="marca">
            <span class="my">My</span>
            <span class="oz">Oz</span>
        </div>

        <div class="pedido">
            Pedido #<?= htmlspecialchars($idPedido) ?>
        </div>
    </header>

    <main class="contenido">

        <h1 class="titulo">Carrito de Pedido</h1>

        <p class="subtitulo">
            Selecciona los productos que deseas agregar a tu pedido
        </p>

        <div class="tabla-contenedor">

            <table>

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Agregar</th>
                    </tr>
                </thead>

                <tbody>

                <?php while ($fila = $resultado->fetch_assoc()): ?>

                    <tr>

                        <td>
                            <span class="producto-id">
                                <?= htmlspecialchars($fila['id']) ?>
                            </span>
                        </td>

                        <td>
                            <span class="producto-nombre">
                                <?= htmlspecialchars($fila['nombre']) ?>
                            </span>
                        </td>

                        <td>
                            <span class="precio">
                                Bs. <?= number_format((float)$fila['precio'], 2) ?>
                            </span>
                        </td>

                        <td>
                            <div class="descripcion">
                                <?= htmlspecialchars($fila['descripcion']) ?>
                            </div>
                        </td>

                        <td>
                            <form action="crearcarrito.php" method="POST">
                                <input
                                    type="hidden"
                                    name="productos_id"
                                    value="<?= htmlspecialchars($fila['id']) ?>"
                                >

                                <input
                                    type="hidden"
                                    name="pedidos_id"
                                    value="<?= htmlspecialchars($idPedido) ?>"
                                >

                                <input
                                    type="hidden"
                                    name="precio"
                                    value="<?= htmlspecialchars($fila['precio']) ?>"
                                >

                                <input
                                    class="cantidad"
                                    type="number"
                                    name="cantidad"
                                    value="1"
                                    min="1"
                                >
                        </td>

                        <td>
                                <input
                                    class="boton-agregar"
                                    type="submit"
                                    value="Agregar"
                                >
                            </form>
                        </td>

                    </tr>

                <?php endwhile; ?>

                </tbody>

            </table>

        </div>

        <div class="total-contenedor">

            <div class="total">
                <span class="total-label">Total del pedido</span>

                <span class="total-precio">
                    Bs. <?= number_format((float)$total, 2) ?>
                </span>
            </div>

        </div>

        <div class="botones">

            <a
                class="boton-ver"
                href="mostrarcarrito.php?pedidos_id=<?= htmlspecialchars($idPedido) ?>"
            >
                Ver carrito
            </a>

            <a
                class="boton-finalizar"
                href="../Pedidos/leerpedido.php?id=<?= htmlspecialchars($idPedido) ?>"
            >
                Finalizar compra
            </a>

            <a
                class="boton-cerrar"
                href="../Usuarios/cerrarse.php"
            >
                Cerrar sesión
            </a>

        </div>

    </main>

    <footer class="pie">
        <strong>Organic Zone</strong> · Cochabamba, Bolivia · 2026
    </footer>

</div>

</body>
</html>

<?php
$stmtTotal->close();
$conn->close();
?>