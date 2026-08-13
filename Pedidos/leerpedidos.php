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

<title>Lista de Pedidos</title>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- FUENTE FREDOKA -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link
    href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&display=swap"
    rel="stylesheet"
>

<style>

/* =====================================================
   ESTILOS GENERALES
===================================================== */

* {
    box-sizing: border-box;
}

html,
body {

    min-height: 100%;
    margin: 0;
    padding: 0;

    background: #ffffff;

    font-family: 'Fredoka', Arial, sans-serif;

    color: #2B140D;
}

body {

    display: flex;

    justify-content: center;
    align-items: center;

    padding: 35px;
}


/* =====================================================
   CONTENEDOR PRINCIPAL
===================================================== */

.principal-grid {

    display: grid;

    grid-template-columns: 390px 1fr;

    width: 96vw;

    max-width: 1600px;

    min-height: 820px;

    background: white;

    border-radius: 18px;

    overflow: hidden;

    box-shadow:
        0 10px 45px rgba(43, 20, 13, 0.12);
}


/* =====================================================
   PANEL IZQUIERDO
===================================================== */

.section-negro {

    background: #2B140D;

    color: white;

    padding: 45px 40px;

}


/* =====================================================
   NAVEGACIÓN
===================================================== */

.nav-inner {

    margin-bottom: 70px;

}

.nav-inner a {

    color: #ffffff;

    text-decoration: none;

    font-size: 15px;

    font-weight: 600;

    letter-spacing: 1px;

    transition: 0.3s ease;

}

.nav-inner a:hover {

    color: #0ba84a;

}


/* =====================================================
   TÍTULO
===================================================== */

.contrato-titulo {

    font-size: 52px;

    line-height: 1.05;

    font-weight: 700;

    margin: 0 0 35px 0;

    color: white;

}


/* =====================================================
   DESCRIPCIÓN
===================================================== */

.desc {

    color: #d6ccc8;

    margin-top: 28px;

    font-size: 16px;

    line-height: 1.6;

}


/* =====================================================
   BOTÓN REGISTRAR PEDIDO
===================================================== */

#boton {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    background: #0ba84a;

    color: white;

    padding: 13px 22px;

    border-radius: 50px;

    font-size: 16px;

    font-weight: 700;

    text-decoration: none;

    box-shadow:
        0 5px 15px rgba(0, 0, 0, 0.18);

    transition: all 0.25s ease;

}

#boton:hover {

    background: #ffffff;

    color: #2B140D;

    transform: translateY(-2px);

    box-shadow:
        0 8px 20px rgba(0, 0, 0, 0.25);

}


/* =====================================================
   PANEL DERECHO
===================================================== */

.section-blanco {

    background: #ffffff;

    padding: 40px;

    overflow-x: auto;

}


/* =====================================================
   CABECERA
===================================================== */

.section-clientes {

    border-bottom: 1px solid #eeeeee;

    margin-bottom: 25px;

    padding-bottom: 18px;

}

.section-clientes h2 {

    margin: 0;

    color: #2B140D;

    font-size: 28px;

    font-weight: 700;

}


/* =====================================================
   TABLA
===================================================== */

table {

    width: 100%;

    border-collapse: separate;

    border-spacing: 0;

    min-width: 1050px;

}


/* =====================================================
   ENCABEZADOS
===================================================== */

thead th {

    background: #2B140D;

    color: white;

    padding: 15px 12px;

    text-align: left;

    font-size: 14px;

    font-weight: 700;

    border-bottom: 3px solid #0ba84a;

}

thead th:first-child {

    border-radius: 10px 0 0 0;

}

thead th:last-child {

    border-radius: 0 10px 0 0;

}


/* =====================================================
   FILAS
===================================================== */

tbody tr {

    transition: 0.2s ease;

}

tbody tr:hover {

    background: #f1fbf5;

}


/* =====================================================
   CELDAS
===================================================== */

tbody td {

    padding: 14px 12px;

    border-bottom: 1px solid #eeeeee;

    color: #3a302c;

    font-size: 14px;

    vertical-align: middle;

}


/* =====================================================
   ESTADO
===================================================== */

tbody td:nth-child(4) {

    font-weight: 600;

}


/* =====================================================
   ACCIONES
===================================================== */

.acciones {

    display: flex;

    flex-direction: column;

    gap: 6px;

    align-items: center;

    justify-content: center;

    min-width: 110px;

}

.acciones a {

    text-decoration: none;

    width: 100%;

    display: flex;

    justify-content: center;

}


/* =====================================================
   BOTONES
===================================================== */

.acciones button {

    width: 100%;

    border: none;

    padding: 8px 13px;

    border-radius: 9px;

    cursor: pointer;

    font-family: 'Fredoka', Arial, sans-serif;

    font-size: 13px;

    font-weight: 600;

    transition: all 0.2s ease;

}


/* =====================================================
   BOTÓN EDITAR
===================================================== */

.acciones a:nth-child(1) button {

    background: #f5eee3;

    color: #2B140D;

}

.acciones a:nth-child(1) button:hover {

    background: #2B140D;

    color: white;

    transform: translateY(-2px);

}


/* =====================================================
   BOTÓN STOCK
===================================================== */

.acciones a:nth-child(2) button {

    background: #0ba84a;

    color: white;

}

.acciones a:nth-child(2) button:hover {

    background: #2B140D;

    color: white;

    transform: translateY(-2px);

}


/* =====================================================
   BOTÓN ELIMINAR
===================================================== */

.acciones a:nth-child(3) button {

    background: #f4e5e1;

    color: #8a3021;

}

.acciones a:nth-child(3) button:hover {

    background: #8a3021;

    color: white;

    transform: translateY(-2px);

}


/* =====================================================
   BOTÓN MOSTRAR
===================================================== */

.acciones a:nth-child(4) button {

    background: #0ba84a;

    color: white;

}

.acciones a:nth-child(4) button:hover {

    background: #2B140D;

    color: white;

    transform: translateY(-2px);

}


/* =====================================================
   RESPONSIVE
===================================================== */

@media (max-width: 1000px) {

    body {

        padding: 20px;

    }

    .principal-grid {

        grid-template-columns: 1fr;

    }

    .section-negro {

        padding: 35px;

    }

    .nav-inner {

        margin-bottom: 40px;

    }

    .contrato-titulo {

        font-size: 42px;

    }

    .section-blanco {

        padding: 30px;

    }

}


/* =====================================================
   MÓVIL
===================================================== */

@media (max-width: 600px) {

    body {

        padding: 10px;

    }

    .principal-grid {

        width: 100%;

        border-radius: 12px;

    }

    .section-negro {

        padding: 30px;

    }

    .contrato-titulo {

        font-size: 38px;

    }

    .section-blanco {

        padding: 20px;

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


        <nav class="nav-inner">

            <a href="../Usuarios/vistavendedor.php">

                INICIO

            </a>

        </nav>


        <h1 class="contrato-titulo">

            LISTA DE<br>
            PEDIDOS

        </h1>


        <a
            href="formulariopedidos.php"
            id="boton"
        >

            Registrar Pedido

        </a>


        <p class="desc">

            Visualiza todos los pedidos
            registrados en el sistema.<br><br>

            Administra información, estados
            y roles de manera rápida.

        </p>


    </section>



    <!-- =================================================
         PANEL DERECHO
    ================================================== -->

    <section class="section-blanco">


        <section class="section-clientes">

            <h2>

                Pedidos Registrados

            </h2>

        </section>


        <!-- =================================================
             ÚNICA TABLA
        ================================================== -->

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

                    <th style="text-align: center;">

                        Acciones

                    </th>

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

                    <td colspan='8'>

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


                    /* =================================================
                       ADMIN
                    ================================================== */

                    if ($rol == "admin") {


                        echo "

                        <a href='editarpedido.php?id=$id'>

                            <button>

                                Editar

                            </button>

                        </a>";


                        echo "

                        <a href='verstockpedido.php?pedido=$id'>

                            <button>

                                Stock

                            </button>

                        </a>";


                        echo "

                        <a
                            href='#'
                            onclick='confirmarEliminacion($id)'
                        >

                            <button>

                                Eliminar

                            </button>

                        </a>";

                    }


                    /* =================================================
                       MOSTRAR
                    ================================================== */

                    echo "

                    <a href='leerpedido.php?id=$id'>

                        <button>

                            Mostrar

                        </button>

                    </a>";


                    /* =================================================
                       VENDEDOR
                    ================================================== */

                    if(
                        $rol == "vendedor"
                        &&
                        $estado == "Pendiente"
                    ){


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


                    /* =================================================
                       VENTA
                    ================================================== */

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



<script>

function confirmarEliminacion(id){

    Swal.fire({

        title: "¿Estás seguro?",

        text: "No podrás revertir esta acción",

        icon: "warning",

        showCancelButton: true,

        confirmButtonColor: "#0ba84a",

        cancelButtonColor: "#2B140D",

        confirmButtonText: "Sí, eliminar",

        cancelButtonText: "Cancelar"

    }).then((result) => {

        if (result.isConfirmed) {

            window.location =
                "eliminarpedido.php?id=" + id;

        }

    });

}

</script>


</body>

</html>