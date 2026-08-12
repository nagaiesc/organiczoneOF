<?php

session_start();
if (!isset($_SESSION['rol']) || !isset($_SESSION['nombre'])) {

    header("Location: ../Pedidos/leerpedido.php");
    exit;

}

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

<!-- Fuente Fredoka -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>

/* === ESTILOS GENERALES === */

html, body {
    height: 100%;
    margin: 0;
    padding: 0;
    background: #969696;
    font-family: 'Fredoka', Arial, sans-serif;
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
    font-family: 'Fredoka', Arial, sans-serif;
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
    font-family: 'Fredoka', Arial, sans-serif;
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

        <nav class="nav-inner">

            <a href="../maquetados/maquetadoAdmin.php">
                INICIO
            </a>

        </nav>


        <h1 class="contrato-titulo">
            LISTA DE PEDIDOS
        </h1>


        <a href="formulariopedidos.php" id="boton">
            Registrar Pedido
        </a>


        <p class="desc">
            Visualiza todos los pedidps registrados en el sistema.<br>
            Administra información, estados y roles de manera rápida.
        </p>

    </section>



    <!-- PANEL DERECHO -->

    <section class="section-blanco">

        <section class="section-clientes">

            <h2>
                Pedidos Registrados
            </h2>


            <table>

                <thead>

                    <tr>

                        <th>ID</th>

                        <th>Nombre</th>

                        <th>Fecha</th>

                        <th>Estado</th>

                        <th>Nombre vendedor</th>

                        <th>Dirección</th>

                        <th>Teléfono</th>

                    </tr>

                </thead>


                <tbody>

                <?php

                $nombreServidor = "localhost";
                $nombreUsuario = "root";
                $contraseñaBaseDeDatos = "";
                $nombreBaseDeDatos = "organiczoneBD";


                $conexion = new mysqli(
                    $nombreServidor,
                    $nombreUsuario,
                    $contraseñaBaseDeDatos,
                    $nombreBaseDeDatos
                );


                if ($conexion->connect_error) {

                    echo "
                    <tr>
                        <td colspan='7'>
                            Hubo un error en la conexión
                        </td>
                    </tr>";

                }


                if ($rol == "admin") {

                    $sql = "SELECT * FROM pedidos";

                } else {

                    $sql = "SELECT * FROM pedidos
                            WHERE nombrevendedor = '$nombreVendedor'";

                }


                $resultado = $conexion->query($sql);


                if ($resultado->num_rows > 0) {

                    while($fila = $resultado->fetch_assoc()){

                        $id = $fila['id'];

                        $estado = $fila['estado'];


                        echo "<tr>";


                        echo "<td>"
                            . $fila['id'] .
                            "</td>";


                        echo "<td>"
                            . $fila['nombre'] .
                            "</td>";


                        echo "<td>"
                            . $fila['fecha'] .
                            "</td>";


                        echo "<td>"
                            . $fila['estado'] .
                            "</td>";


                        echo "<td>"
                            . $fila['nombrevendedor'] .
                            "</td>";


                        echo "<td>"
                            . $fila['direccion'] .
                            "</td>";


                        echo "<td>"
                            . $fila['telefono'] .
                            "</td>";


                        echo "<td class='acciones'>";


                        if ($rol == "admin") {

                            echo "
                            <a href='editarpedido.php?id=$id'>
                                <button>
                                    Editar
                                </button>
                            </a>";


                            echo "
                            <a href='#' onclick='confirmarEliminacion($id)'>
                                <button>
                                    Eliminar
                                </button>
                            </a>";

                        }


                        echo "
                        <a href='leerpedido.php?id=$id'>
                            <button>
                                Mostrar
                            </button>
                        </a>";


                        if($rol == "vendedor" && $estado == "Pendiente"){

                            echo "
                            <a href='aceptarpedido.php?id=$id'>
                                <button>
                                    Aceptar
                                </button>
                            </a>";


                            echo "
                            <a href='rechazarpedido.php?id=$id'>
                                <button>
                                    Rechazar
                                </button>
                            </a>";

                        }


                        if($estado == "En proceso"){

                            echo "
                            <a href='../Ventas/formularioventas.php?pedido=$id'>
                                <button>
                                    Venta
                                </button>
                            </a>";

                        }


                        echo "</td>";

                        echo "</tr>";

                    }

                } else {

                    echo "
                    <tr>
                        <td colspan='8'>
                            Sin pedidos para mostrar.
                        </td>
                    </tr>";

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

            /* Redirecciona al archivo de eliminación */

            window.location = "eliminarpedido.php?id=" + id;

        }

    });

}

</script>

</body>
</html>