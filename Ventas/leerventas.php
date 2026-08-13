<?php

session_start();

$rol = $_SESSION['rol'] ?? '';
$nombreVendedor = $_SESSION['nombre'] ?? '';

?>
<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Lista de Ventas - OrganicZone</title>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- GOOGLE FONT -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link
    href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&display=swap"
    rel="stylesheet"
>

<style>

/* =====================================================
   CONFIGURACIÓN GENERAL
===================================================== */

* {
    box-sizing: border-box;
}

html,
body {

    margin: 0;
    padding: 0;

    min-height: 100%;

    font-family: 'Fredoka', Arial, sans-serif;

    background: #ffffff;

    color: #2B140D;
}

body {

    min-height: 100vh;

    display: flex;

    justify-content: center;

    align-items: center;

    padding: 30px;
}


/* =====================================================
   CONTENEDOR PRINCIPAL
===================================================== */

.principal-grid {

    display: grid;

    grid-template-columns: 390px 1fr;

    width: 96%;

    max-width: 1500px;

    min-height: 750px;

    background: white;

    border-radius: 25px;

    overflow: hidden;

    box-shadow:
        0 15px 45px rgba(43, 20, 13, 0.14);

}


/* =====================================================
   PANEL IZQUIERDO
===================================================== */

.section-negro {

    background: #2B140D;

    color: white;

    padding: 50px 42px;

    display: flex;

    flex-direction: column;

    justify-content: flex-start;
}


/* =====================================================
   TITULO
===================================================== */

.contrato-titulo {

    margin: 70px 0 0 0;

    font-size: 52px;

    line-height: 0.95;

    font-weight: 700;

    letter-spacing: -1px;

    color: white;

}


/* =====================================================
   DESCRIPCIÓN
===================================================== */

.desc {

    color: #e5dcd8;

    margin-top: 25px;

    font-size: 16px;

    line-height: 1.7;

    max-width: 280px;
}


/* =====================================================
   BOTÓN REGISTRAR VENTA
===================================================== */

#boton {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    width: fit-content;

    margin-top: 35px;

    padding: 13px 23px;

    border-radius: 40px;

    background: #0ba84a;

    color: white;

    text-decoration: none;

    font-size: 17px;

    font-weight: 600;

    box-shadow:
        0 8px 20px rgba(11, 168, 74, 0.25);

    transition:
        transform 0.25s ease,
        background 0.25s ease,
        box-shadow 0.25s ease;
}


#boton:hover {

    background: #098d3e;

    transform: translateY(-3px);

    box-shadow:
        0 12px 25px rgba(11, 168, 74, 0.35);
}


/* =====================================================
   PANEL DERECHO
===================================================== */

.section-blanco {

    background: #ffffff;

    padding: 50px;

    min-width: 0;

    overflow-x: auto;
}


/* =====================================================
   ENCABEZADO
===================================================== */

.section-clientes {

    border-bottom: 1px solid #eee;

    padding-bottom: 22px;

    margin-bottom: 28px;
}


.section-clientes h2 {

    margin: 0;

    color: #2B140D;

    font-size: 30px;

    font-weight: 700;
}


.section-clientes h2::after {

    content: "";

    display: block;

    width: 55px;

    height: 5px;

    background: #0ba84a;

    border-radius: 10px;

    margin-top: 10px;
}


/* =====================================================
   TABLA
===================================================== */

.tabla-contenedor {

    width: 100%;

    overflow-x: auto;

    border-radius: 15px;

    border: 1px solid #eee;
}


table {

    width: 100%;

    min-width: 750px;

    border-collapse: collapse;
}


/* CABECERA */

thead {

    background: #2B140D;
}


thead th {

    padding: 17px 15px;

    color: white;

    text-align: left;

    font-size: 14px;

    font-weight: 600;

    white-space: nowrap;
}


thead th:first-child {

    border-radius: 14px 0 0 0;
}


thead th:last-child {

    border-radius: 0 14px 0 0;
}


/* CUERPO */

tbody td {

    padding: 16px 15px;

    border-bottom: 1px solid #eeeeee;

    color: #4b4b4b;

    font-size: 14px;

    vertical-align: middle;
}


tbody tr {

    transition: background 0.2s ease;
}


tbody tr:hover {

    background: #f8fbf9;
}


tbody tr:last-child td {

    border-bottom: none;
}


/* =====================================================
   ESTADO
===================================================== */

.estado {

    display: inline-block;

    padding: 6px 12px;

    border-radius: 30px;

    background: #e7f7ed;

    color: #0ba84a;

    font-size: 12px;

    font-weight: 600;

    white-space: nowrap;
}


/* =====================================================
   COSTO
===================================================== */

.costo {

    color: #0ba84a;

    font-weight: 700;

    white-space: nowrap;
}


/* =====================================================
   ACCIONES
===================================================== */

.acciones {

    display: flex;

    align-items: center;

    gap: 7px;

    white-space: nowrap;
}


.acciones a {

    text-decoration: none;
}


.acciones button {

    border: none;

    padding: 8px 12px;

    border-radius: 10px;

    cursor: pointer;

    font-family: 'Fredoka', Arial, sans-serif;

    font-size: 13px;

    font-weight: 600;

    transition:
        transform 0.2s ease,
        box-shadow 0.2s ease,
        background 0.2s ease;
}


/* EDITAR */

.btn-editar {

    background: #FCD09F;

    color: #2B140D;
}


.btn-editar:hover {

    background: #f7bd80;

    transform: translateY(-2px);
}


/* ELIMINAR */

.btn-eliminar {

    background: #2B140D;

    color: white;
}


.btn-eliminar:hover {

    background: #4a2115;

    transform: translateY(-2px);
}


/* MOSTRAR */

.btn-mostrar {

    background: #0ba84a;

    color: white;
}


.btn-mostrar:hover {

    background: #098d3e;

    transform: translateY(-2px);

    box-shadow:
        0 5px 12px rgba(11, 168, 74, 0.25);
}


/* =====================================================
   MENSAJES
===================================================== */

.mensaje {

    padding: 35px;

    text-align: center;

    color: #777;

    background: #fafafa;

    border-radius: 15px;

    margin-top: 20px;
}


/* =====================================================
   SCROLL
===================================================== */

::-webkit-scrollbar {

    width: 8px;

    height: 8px;
}


::-webkit-scrollbar-track {

    background: #f1f1f1;
}


::-webkit-scrollbar-thumb {

    background: #2B140D;

    border-radius: 10px;
}


::-webkit-scrollbar-thumb:hover {

    background: #0ba84a;
}


/* =====================================================
   RESPONSIVE
===================================================== */

@media (max-width: 1000px) {

    body {

        padding: 15px;

        align-items: flex-start;
    }


    .principal-grid {

        grid-template-columns: 1fr;

        width: 100%;

        margin-top: 15px;
    }


    .section-negro {

        padding: 40px;
    }


    .contrato-titulo {

        margin-top: 20px;

        font-size: 42px;
    }


    .desc {

        max-width: 500px;
    }


    .section-blanco {

        padding: 30px;
    }

}


@media (max-width: 600px) {

    body {

        padding: 0;
    }


    .principal-grid {

        width: 100%;

        min-height: 100vh;

        border-radius: 0;
    }


    .section-negro {

        padding: 35px 25px;
    }


    .contrato-titulo {

        font-size: 38px;
    }


    .section-blanco {

        padding: 25px 18px;
    }


    .section-clientes h2 {

        font-size: 25px;
    }


    #boton {

        font-size: 15px;

        padding: 12px 19px;
    }

}

</style>

</head>


<body>


<section class="principal-grid">


    <!-- =================================================
         PANEL IZQUIERDO
    ================================================== -->

    <section class="section-negro">


        <h1 class="contrato-titulo">

            LISTA<br>
            DE VENTAS

        </h1>


        <a
            href="formularioventas.php"
            id="boton"
        >

            + Registrar Venta

        </a>


        <p class="desc">

            Visualiza todas las ventas
            registradas en el sistema.

            <br><br>

            Administra estados,
            métodos de pago y
            costos de manera rápida.

        </p>


    </section>



    <!-- =================================================
         PANEL DERECHO
    ================================================== -->

    <section class="section-blanco">


        <section class="section-clientes">


            <h2>

                Ventas Registradas

            </h2>


        </section>



        <div class="tabla-contenedor">


            <table>


                <thead>

                    <tr>

                        <th>ID</th>

                        <th>Vendedor</th>

                        <th>Estado</th>

                        <th>Método</th>

                        <th>Costo Total</th>

                        <th>ID Pedido</th>

                        <th>Acciones</th>

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
                        <td colspan='7' class='mensaje'>
                            Error en la conexión con la base de datos.
                        </td>
                    </tr>
                    ";

                } else {


                    /*
                    ==================================================
                    ADMINISTRADOR
                    ==================================================
                    */

                    if ($rol == "admin") {


                        $sql = "SELECT * FROM ventas";

                        $resultado = $conexion->query($sql);


                        if ($resultado && $resultado->num_rows > 0) {


                            while ($fila = $resultado->fetch_assoc()) {


                                $id = $fila['id'];

                                $pedidos_id = $fila['pedidos_id'];


                                /*
                                Buscar vendedor del pedido
                                */

                                $sqlPedido = "
                                    SELECT nombrevendedor
                                    FROM pedidos
                                    WHERE id = '$pedidos_id'
                                ";


                                $resultadoPedido =
                                    $conexion->query($sqlPedido);


                                $nombrevendedor = "Sin vendedor";


                                if (
                                    $resultadoPedido &&
                                    $resultadoPedido->num_rows > 0
                                ) {

                                    $pedido =
                                        $resultadoPedido->fetch_assoc();

                                    $nombrevendedor =
                                        $pedido['nombrevendedor'];

                                }


                                echo "<tr>";


                                echo "
                                <td>
                                    {$fila['id']}
                                </td>
                                ";


                                echo "
                                <td>
                                    " . htmlspecialchars($nombrevendedor) . "
                                </td>
                                ";


                                echo "
                                <td>
                                    <span class='estado'>
                                        " . htmlspecialchars($fila['estado']) . "
                                    </span>
                                </td>
                                ";


                                echo "
                                <td>
                                    " . htmlspecialchars($fila['metodo']) . "
                                </td>
                                ";


                                echo "
                                <td>
                                    <span class='costo'>
                                        Bs. " . htmlspecialchars($fila['costototal']) . "
                                    </span>
                                </td>
                                ";


                                echo "
                                <td>
                                    #{$fila['pedidos_id']}
                                </td>
                                ";


                                echo "
                                <td class='acciones'>

                                    <a href='registroeditarventa.php?id=$id'>

                                        <button
                                            type='button'
                                            class='btn-editar'
                                        >
                                            Editar
                                        </button>

                                    </a>


                                    <a
                                        href='#'
                                        onclick='confirmarEliminacion($id); return false;'
                                    >

                                        <button
                                            type='button'
                                            class='btn-eliminar'
                                        >
                                            Eliminar
                                        </button>

                                    </a>


                                    <a href='leerventa.php?id=$id'>

                                        <button
                                            type='button'
                                            class='btn-mostrar'
                                        >
                                            Mostrar
                                        </button>

                                    </a>

                                </td>
                                ";


                                echo "</tr>";

                            }


                        } else {


                            echo "
                            <tr>

                                <td
                                    colspan='7'
                                    class='mensaje'
                                >

                                    No hay ventas registradas.

                                </td>

                            </tr>
                            ";

                        }


                    }


                    /*
                    ==================================================
                    VENDEDORES
                    ==================================================
                    */

                    else {


                        $sqlPedidos = "
                            SELECT id
                            FROM pedidos
                            WHERE nombrevendedor = '$nombreVendedor'
                        ";


                        $resultadoPedidos =
                            $conexion->query($sqlPedidos);


                        if (
                            $resultadoPedidos &&
                            $resultadoPedidos->num_rows > 0
                        ) {


                            $hayVentas = false;


                            while (
                                $pedido =
                                $resultadoPedidos->fetch_assoc()
                            ) {


                                $pedidos_id =
                                    $pedido['id'];


                                $sqlVentas = "
                                    SELECT *
                                    FROM ventas
                                    WHERE pedidos_id = '$pedidos_id'
                                ";


                                $resultadoVentas =
                                    $conexion->query($sqlVentas);


                                if (
                                    $resultadoVentas &&
                                    $resultadoVentas->num_rows > 0
                                ) {


                                    $hayVentas = true;


                                    while (
                                        $fila =
                                        $resultadoVentas->fetch_assoc()
                                    ) {


                                        $id =
                                            $fila['id'];


                                        echo "<tr>";


                                        echo "
                                        <td>
                                            {$fila['id']}
                                        </td>
                                        ";


                                        echo "
                                        <td>
                                            " .
                                            htmlspecialchars(
                                                $nombreVendedor
                                            )
                                            .
                                            "
                                        </td>
                                        ";


                                        echo "
                                        <td>

                                            <span class='estado'>

                                                " .
                                                htmlspecialchars(
                                                    $fila['estado']
                                                )
                                                .

                                                "

                                            </span>

                                        </td>
                                        ";


                                        echo "
                                        <td>
                                            " .
                                            htmlspecialchars(
                                                $fila['metodo']
                                            )
                                            .
                                            "
                                        </td>
                                        ";


                                        echo "
                                        <td>

                                            <span class='costo'>

                                                Bs. " .
                                                htmlspecialchars(
                                                    $fila['costototal']
                                                )
                                                .

                                                "

                                            </span>

                                        </td>
                                        ";


                                        echo "
                                        <td>
                                            #{$fila['pedidos_id']}
                                        </td>
                                        ";


                                        echo "
                                        <td class='acciones'>

                                            <a
                                                href='leerventa.php?id=$id'
                                            >

                                                <button
                                                    type='button'
                                                    class='btn-mostrar'
                                                >
                                                    Mostrar
                                                </button>

                                            </a>

                                        </td>
                                        ";


                                        echo "</tr>";

                                    }

                                }

                            }


                            if (!$hayVentas) {

                                echo "
                                <tr>

                                    <td
                                        colspan='7'
                                        class='mensaje'
                                    >

                                        No tienes ventas registradas.

                                    </td>

                                </tr>
                                ";

                            }


                        } else {


                            echo "
                            <tr>

                                <td
                                    colspan='7'
                                    class='mensaje'
                                >

                                    No tienes pedidos registrados.

                                </td>

                            </tr>
                            ";

                        }

                    }

                }


                ?>


                </tbody>


            </table>


        </div>


    </section>


</section>



<script>


/* =====================================================
   CONFIRMAR ELIMINACIÓN
===================================================== */

function confirmarEliminacion(id) {


    Swal.fire({

        title: "¿Eliminar venta?",

        text: "No podrás revertir esta acción.",

        icon: "warning",

        showCancelButton: true,

        confirmButtonColor: "#0ba84a",

        cancelButtonColor: "#2B140D",

        confirmButtonText: "Sí, eliminar",

        cancelButtonText: "Cancelar",

        background: "#ffffff",

        color: "#2B140D",

        customClass: {

            popup: "organic-alert"

        }

    }).then((result) => {


        if (result.isConfirmed) {


            window.location =
                "eliminarventa.php?id=" + id;


        }

    });


}


</script>


</body>

</html>