<?php

$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$bd = "organiczoneBD";

$conn = new mysqli($servidor, $usuario, $contrasena, $bd);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$idPedido = isset($_GET['pedidos_id']) ? $_GET['pedidos_id'] : 0;

$sql = "SELECT * FROM carrito WHERE pedidos_id='$idPedido'";
$resultado = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Carrito Pedido</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>

*{
    box-sizing:border-box;
}

body{
    background:#F5F8F2;
    margin:0;
    padding:40px 20px;
    font-family:'Fredoka',Arial,sans-serif;
    min-height:100vh;
    color:#2B140D;
}

.caja{
    background:#FFFFFF;
    width:94%;
    max-width:1250px;
    margin:auto;
    padding:42px;
    border-radius:32px;
    box-shadow:0 15px 45px rgba(43,20,13,.12);
    border:1px solid #E9EEE7;
}

.encabezado{
    display:flex;
    align-items:center;
    justify-content:space-between;
    margin-bottom:30px;
    gap:20px;
}

.marca{
    color:#0BA84A;
    font-size:18px;
    font-weight:700;
    letter-spacing:2px;
}

.pedido{
    background:#F1F8F2;
    color:#0BA84A;
    padding:9px 17px;
    border-radius:30px;
    font-size:14px;
    font-weight:600;
}

.titulo{
    font-size:38px;
    font-weight:700;
    color:#2B140D;
    margin:0 0 30px;
    line-height:1.1;
}

.titulo span{
    color:#0BA84A;
}

.tabla-contenedor{
    width:100%;
    overflow-x:auto;
    border-radius:18px;
    border:1px solid #E7E7E7;
}

table{
    width:100%;
    min-width:850px;
    border-collapse:separate;
    border-spacing:0;
}

thead th{
    background:#2B140D;
    color:#FFFFFF;
    padding:17px 15px;
    font-size:14px;
    font-weight:600;
    text-align:center;
    letter-spacing:.3px;
    border-bottom:4px solid #0BA84A;
}

thead th:first-child{
    border-radius:16px 0 0 0;
}

thead th:last-child{
    border-radius:0 16px 0 0;
}

tbody tr{
    background:#FFFFFF;
    transition:.25s ease;
}

tbody tr:nth-child(even){
    background:#FAFCF9;
}

tbody tr:hover{
    background:#EFF9F1;
    transform:scale(1.002);
}

td{
    padding:17px 14px;
    text-align:center;
    border-bottom:1px solid #E9E9E9;
    color:#453B37;
    font-size:14px;
    font-weight:500;
}

tbody tr:last-child td{
    border-bottom:none;
}

td:nth-child(1){
    color:#2B140D;
    font-weight:700;
}

td:nth-child(3),
td:nth-child(5){
    color:#0BA84A;
    font-weight:700;
}

td:nth-child(4){
    background:#F1F8F2;
    color:#2B140D;
    font-weight:700;
}

.accion{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-width:88px;
    padding:9px 15px;
    border-radius:12px;
    text-decoration:none;
    font-size:13px;
    font-weight:600;
    transition:.25s ease;
}

.editar{
    background:#F5EEDF;
    color:#2B140D;
}

.editar:hover{
    background:#2B140D;
    color:#FFFFFF;
    transform:translateY(-2px);
}

.eliminar{
    background:#FBEAEA;
    color:#B52A25;
}

.eliminar:hover{
    background:#D62828;
    color:#FFFFFF;
    transform:translateY(-2px);
}

.volver{
    display:flex;
    align-items:center;
    justify-content:center;
    width:160px;
    margin:30px auto 0;
    padding:12px 20px;
    text-align:center;
    text-decoration:none;
    background:#2B140D;
    color:#FFFFFF;
    border-radius:30px;
    font-size:14px;
    font-weight:600;
    transition:.25s ease;
}

.volver:hover{
    background:#0BA84A;
    transform:translateY(-2px);
}

@media(max-width:700px){

    body{
        padding:20px 10px;
    }

    .caja{
        width:100%;
        padding:25px 18px;
        border-radius:24px;
    }

    .encabezado{
        align-items:flex-start;
        flex-direction:column;
        gap:12px;
    }

    .titulo{
        font-size:30px;
    }

}

</style>

</head>

<body>

<div class="caja">

    <div class="encabezado">

        <div class="marca">
            ORGANIC ZONE
        </div>

        <div class="pedido">
            PEDIDO Nº <?= htmlspecialchars($idPedido) ?>
        </div>

    </div>

    <div class="titulo">
        Carrito del <span>Pedido</span>
    </div>

    <div class="tabla-contenedor">

        <table>

            <thead>

                <tr>
                    <th>ID Producto</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Costo Total</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>

            </thead>

            <tbody>

<?php

if ($resultado && $resultado->num_rows > 0) {

    while($fila = $resultado->fetch_assoc()){

        $idProducto = $fila['productos_id'];

        $sqlProducto = "SELECT * FROM productos WHERE id='$idProducto'";
        $resultadoProducto = $conn->query($sqlProducto);

        $producto = $resultadoProducto->fetch_assoc();

        echo "<tr>";

        echo "<td>".$producto['id']."</td>";

        echo "<td>".$producto['nombre']."</td>";

        echo "<td>Bs. ".$producto['precio']."</td>";

        echo "<td>".$fila['cantidad']."</td>";

        echo "<td>Bs. ".$fila['costototal']."</td>";

        echo "<td>
                <a class='accion editar' href='editarcarrito.php?pedidos_id=".$fila['pedidos_id']."&productos_id=".$fila['productos_id']."'>
                    Editar
                </a>
              </td>";

        echo "<td>
                <a class='accion eliminar' href='eliminarcarrito.php?pedidos_id=".$fila['pedidos_id']."&productos_id=".$fila['productos_id']."'>
                    Eliminar
                </a>
              </td>";

        echo "</tr>";

    }

} else {

    echo "
    <tr>
        <td colspan='7' style='padding:35px;color:#777;'>
            No hay productos registrados en este pedido.
        </td>
    </tr>";

}

?>

            </tbody>

        </table>

    </div>

    <a class="volver" href="leercarrito.php?pedidos_id=<?= htmlspecialchars($idPedido) ?>">
        ← Volver
    </a>

</div>

<?php

$conn->close();

?>

</body>

</html>
