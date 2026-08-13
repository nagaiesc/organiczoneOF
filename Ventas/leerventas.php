<?php
session_start();

$rol = $_SESSION['rol'];
$nombreVendedor = $_SESSION['nombre'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Lista de Usuarios</title>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
/* === ESTILOS GENERALES === */
html, body {
    height: 100%;
    margin: 0;
    padding: 0;
    background: #969696;
    font-family: 'Inter', Arial, sans-serif;
}

body {
    display: flex;
    justify-content: center;
    align-items: center;
}

.principal-grid {
    display: grid;
    grid-template-columns: 440px 1fr;
    width: 96vw;
    max-width: 1600px;
    min-height: 820px;
    box-shadow: 0px 6px 40px rgba(88, 88, 88, 0.16);
    border-radius: 10px;
    overflow: hidden;
}

/* PANEL IZQUIERDO */
.section-negro {
    background: #000;
    color: #fff;
    padding: 40px;
}

.nav-inner a {
    color: #e0e0e0;
    text-decoration: none;
    font-weight: 600;
}

.contrato-titulo {
    font-size: 2.6em;
    font-weight: 900;
    margin-top: 40px;
}

.desc {
    color: #bababa;
    margin-top: 20px;
    line-height: 1.6;
}

/* PANEL DERECHO */
.section-blanco {
    background: #fff;
    padding: 40px;
}

.section-clientes {
    border-bottom: 1px solid #eee;
    margin-bottom: 20px;
}

/* TABLA */
table {
    width: 100%;
    border-collapse: collapse;
}

thead th {
    border-bottom: 3px solid #000;
    padding: 12px;
    text-align: left;
    font-weight: 900;
}

tbody td {
    border-bottom: 1px solid #ddd;
    padding: 12px;
}

tbody tr:hover {
    background: #f5f5f5;
}

/* BOTONES */
.acciones button {
    background: #000;
    color: #fff;
    border: none;
    padding: 6px 12px;
    margin-right: 5px;
    cursor: pointer;
    font-weight: 600;
    border-radius: 5px;
    transition: 0.3s ease;
}

.acciones button:hover {
    background: #222;
    transform: scale(1.05);
}

.acciones a {
    text-decoration: none;
}

#boton {
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    gap: 8px;
    background-color: rgb(255, 255, 255);
    color: black;
    padding: 10px 20px;
    border-radius: 50px;
    font-size: 18px;
    font-weight: bold;
    text-decoration: none;
    width: fit-content;
    margin-top: 20px;
}

#boton:hover {
    background: #eaeaea;
}
</style>
</head>

<body>

<section class="principal-grid">

    <!-- PANEL IZQUIERDO -->
    <section class="section-negro">

        <h1 class="contrato-titulo">LISTA DE VENTAS</h1>

        <a href="formularioventas.php" id="boton">Registrar Venta</a>

        <p class="desc">
            Visualiza todos las ventas registradas en el sistema.<br>
            Administra información, estados y roles de manera rápida.
        </p>
    </section>

    <!-- PANEL DERECHO -->
    <section class="section-blanco">

        <section class="section-clientes">
            <h2>Ventas Registradas</h2>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Vendedor</th>
                        <th>Estado</th>
                        <th>Método</th>
                        <th>Costo Total</th>
                        <th>ID Pedido</th>
                    </tr>
                </thead>

                <tbody>
                <?php
                $nombreServidor = "localhost";
                $nombreUsuario = "root";
                $contraseñaBaseDeDatos = "";
                $nombreBaseDeDatos = "organiczoneBD";

                $conexion = new mysqli($nombreServidor, $nombreUsuario, $contraseñaBaseDeDatos, $nombreBaseDeDatos);

                if ($conexion->connect_error) {
                    echo "<tr><td colspan='7'>Hubo un error en la conexión</td></tr>";
                }

                if ($rol == "admin") {

    $sql = "SELECT * FROM ventas";
    $resultado = $conexion->query($sql);

    if ($resultado->num_rows > 0) {

        while($fila = $resultado->fetch_assoc()){

            $id = $fila['id'];
            $pedidos_id = $fila['pedidos_id'];

            // Buscar el vendedor del pedido
            $sqlPedido = "SELECT nombrevendedor 
                          FROM pedidos 
                          WHERE id = '$pedidos_id'";

            $resultadoPedido = $conexion->query($sqlPedido);
            $pedido = $resultadoPedido->fetch_assoc();

            $nombrevendedor = $pedido['nombrevendedor'];

            echo "<tr>";
            echo "<td>" . $fila['id'] . "</td>";
            echo "<td>" . $nombrevendedor . "</td>";
            echo "<td>" . $fila['estado'] . "</td>";
            echo "<td>" . $fila['metodo'] . "</td>";
            echo "<td>" . $fila['costototal'] . "</td>";
            echo "<td>" . $fila['pedidos_id'] . "</td>";

            echo "<td class='acciones'>";
            echo "<a href='registroeditarventa.php?id=$id'><button>Editar</button></a>";
            echo "<a href='#' onclick='confirmarEliminacion($id)'><button>Eliminar</button></a>";
            echo "<a href='leerventa.php?id=$id'><button>Mostrar</button></a>";
            echo "</td>";

            echo "</tr>";
        }

    } else {

        echo "<tr><td colspan='7'>Sin ventas para mostrar.</td></tr>";

    }

    } else {
    // Buscar los pedidos del vendedor
    $sqlPedidos = "SELECT id 
                   FROM pedidos 
                   WHERE nombrevendedor = '$nombreVendedor'";

    $resultadoPedidos = $conexion->query($sqlPedidos);

    if ($resultadoPedidos->num_rows > 0) {

        while($pedido = $resultadoPedidos->fetch_assoc()){

            $pedidos_id = $pedido['id'];

            // Buscar las ventas de ese pedido
            $sqlVentas = "SELECT * 
                          FROM ventas 
                          WHERE pedidos_id = '$pedidos_id'";

            $resultadoVentas = $conexion->query($sqlVentas);

            while($fila = $resultadoVentas->fetch_assoc()){

                $id = $fila['id'];

                echo "<tr>";
                echo "<td>" . $fila['id'] . "</td>";
                echo "<td>" . $nombreVendedor . "</td>";
                echo "<td>" . $fila['estado'] . "</td>";
                echo "<td>" . $fila['metodo'] . "</td>";
                echo "<td>" . $fila['costototal'] . "</td>";
                echo "<td>" . $fila['pedidos_id'] . "</td>";

                echo "<td class='acciones'>";
                echo "<a href='leerventa.php?id=$id'><button>Mostrar</button></a>";
                echo "</td>";

                echo "</tr>";
            }
        }

    } else {

        echo "<tr><td colspan='7'>No tienes pedidos registrados.</td></tr>";

    }
}
                ?>
                </tbody>
            </table>

        </section>

    </section>

</section>
<script>

function confirmarEliminacion(id){

    Swal.fire({
        title: "¿Estás seguro?",
        text: "No podrás revertir esta acción",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar"
    }).then((result) => {

        if (result.isConfirmed) {
            /*Redirecciona de navegador a la página verdadera*/
            window.location = "eliminarventa.php?id=" + id;

        }

    });
}
</script>
</body>
</html>
```