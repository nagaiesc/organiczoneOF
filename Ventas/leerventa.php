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
    die("Hubo un error en la conexión");
} 
 
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID de venta no válido");
}

$id = intval($_GET['id']); 
 
$sql = "SELECT * FROM ventas WHERE id = $id"; 
 
$resultado = $conexion->query($sql); 
 
// Comprobar que existe la venta
if (!$resultado || $resultado->num_rows == 0) {  
    die("La venta no existe");  
}  

$fila = $resultado->fetch_assoc();  

?> 
 
<!DOCTYPE html> 
<html lang="es"> 

<head>

<meta charset="UTF-8"> 

<meta 
    name="viewport" 
    content="width=device-width, initial-scale=1.0"
> 

<title>
    Detalle Venta
</title>

<!-- FUENTE FREDOKA -->

<link rel="preconnect" href="https://fonts.googleapis.com">

<link 
    rel="preconnect" 
    href="https://fonts.gstatic.com" 
    crossorigin
>

<link 
    href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&display=swap" 
    rel="stylesheet"
>


<style>

/* =========================================
   ESTILOS GENERALES
========================================= */

* {
    box-sizing: border-box;
}

html,
body {

    width: 100%;
    min-height: 100%;

    margin: 0;
    padding: 0;

}

body {

    background: #ffffff;

    font-family: 'Fredoka', Arial, sans-serif;

    display: flex;

    justify-content: center;

    align-items: center;

    padding: 40px 20px;

    color: #2B140D;

}


/* =========================================
   CONTENEDOR PRINCIPAL
========================================= */

.principal-grid {

    display: grid;

    grid-template-columns: 400px 1fr;

    width: 96vw;

    max-width: 1150px;

    min-height: 650px;

    background: white;

    border-radius: 24px;

    overflow: hidden;

    box-shadow:
        0 15px 45px rgba(43, 20, 13, 0.14);

}


/* =========================================
   PANEL IZQUIERDO
========================================= */

.section-negro {

    background: #2B140D;

    color: white;

    padding: 45px;

    display: flex;

    flex-direction: column;

}


/* VOLVER */

.nav-inner {

    margin-bottom: 20px;

}

.nav-inner a {

    display: inline-flex;

    align-items: center;

    text-decoration: none;

    color: white;

    background: rgba(255,255,255,0.10);

    padding: 10px 17px;

    border-radius: 30px;

    font-size: 15px;

    font-weight: 500;

    transition: 0.3s ease;

}

.nav-inner a:hover {

    background: #FCD09F;

    color: #2B140D;

    transform: translateY(-2px);

}


/* TITULO */

.contrato-titulo {

    font-size: 3em;

    line-height: 1.05;

    font-weight: 700;

    margin-top: 70px;

    margin-bottom: 0;

    letter-spacing: -1px;

}


/* LINEA VERDE */

.contrato-titulo::after {

    content: "";

    display: block;

    width: 65px;

    height: 6px;

    background: #0ba84a;

    border-radius: 10px;

    margin-top: 22px;

}


/* DESCRIPCIÓN */

.desc {

    color: #d1c9c6;

    margin-top: 25px;

    line-height: 1.7;

    font-size: 16px;

    max-width: 280px;

}


/* =========================================
   PANEL DERECHO
========================================= */

.section-blanco {

    background: #ffffff;

    padding: 55px;

}


/* =========================================
   ENCABEZADO
========================================= */

.section-blanco::before {

    content: "Información de la venta";

    display: block;

    font-size: 25px;

    font-weight: 700;

    color: #2B140D;

    margin-bottom: 30px;

}


/* =========================================
   TARJETA
========================================= */

.card {

    width: 100%;

    display: grid;

    grid-template-columns: 1fr 1fr;

    gap: 18px;

}


/* =========================================
   CAMPOS
========================================= */

.campo {

    background: #fafafa;

    border: 1px solid #eeeeee;

    border-radius: 15px;

    padding: 20px;

    min-height: 90px;

    display: flex;

    flex-direction: column;

    justify-content: center;

    transition: 0.3s ease;

}


/* HOVER */

.campo:hover {

    border-color: #0ba84a;

    transform: translateY(-3px);

    box-shadow:
        0 8px 20px rgba(11, 168, 74, 0.10);

}


/* ETIQUETA */

.campo span {

    display: block;

    font-size: 13px;

    color: #8a8a8a;

    margin-bottom: 8px;

    text-transform: uppercase;

    letter-spacing: 0.8px;

    font-weight: 500;

}


/* VALOR */

.campo strong {

    font-size: 20px;

    color: #2B140D;

    font-weight: 600;

    word-break: break-word;

}


/* ID */

.campo:first-child strong {

    color: #0ba84a;

}


/* COSTO TOTAL */

.campo:nth-child(4) strong {

    color: #0ba84a;

    font-size: 24px;

}


/* =========================================
   BOTÓN
========================================= */

.btn {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    margin-top: 25px;

    background: #0ba84a;

    color: white;

    padding: 13px 24px;

    border-radius: 30px;

    text-decoration: none;

    font-size: 16px;

    font-weight: 600;

    border: none;

    cursor: pointer;

    transition: 0.3s ease;

    box-shadow:
        0 6px 18px rgba(11, 168, 74, 0.20);

}


.btn:hover {

    background: #098d3e;

    transform: translateY(-2px);

    box-shadow:
        0 9px 22px rgba(11, 168, 74, 0.28);

}


/* =========================================
   INFORMACIÓN DEL VENDEDOR
========================================= */

.campo:last-child {

    grid-column: span 2;

    background:
        linear-gradient(
            135deg,
            #f7fbf8,
            #ffffff
        );

    border-color: #dcefe3;

}


/* =========================================
   RESPONSIVE
========================================= */

@media (max-width: 850px) {

    body {

        align-items: flex-start;

        padding-top: 20px;

    }

    .principal-grid {

        grid-template-columns: 1fr;

        width: 95vw;

    }

    .section-negro {

        min-height: 350px;

        padding: 35px;

    }

    .contrato-titulo {

        margin-top: 45px;

        font-size: 2.5em;

    }

    .section-blanco {

        padding: 35px;

    }

}


@media (max-width: 600px) {

    .card {

        grid-template-columns: 1fr;

    }

    .campo:last-child {

        grid-column: span 1;

    }

    .contrato-titulo {

        font-size: 2.2em;

    }

    .section-blanco {

        padding: 25px;

    }

    .section-negro {

        padding: 30px;

    }

}

</style>

</head>


<body>


<section class="principal-grid">


    <!-- =====================================
         PANEL IZQUIERDO
    ====================================== -->

    <section class="section-negro">


        <nav class="nav-inner">

            <a href="leerventas.php">

                ← Volver

            </a>

        </nav>


        <h1 class="contrato-titulo">

            DETALLE<br>

            VENTA

        </h1>


        <p class="desc">

            Visualiza toda la información

            correspondiente a la venta

            seleccionada.

        </p>


    </section>


    <!-- =====================================
         PANEL DERECHO
    ====================================== -->

    <section class="section-blanco">


        <div class="card">


            <!-- ID -->

            <div class="campo">

                <span>
                    ID de venta
                </span>

                <strong>

                    #<?= htmlspecialchars($fila['id']) ?>

                </strong>

            </div>


            <!-- ESTADO -->

            <div class="campo">

                <span>
                    Estado
                </span>

                <strong>

                    <?= htmlspecialchars($fila['estado']) ?>

                </strong>

            </div>


            <!-- MÉTODO -->

            <div class="campo">

                <span>
                    Método de pago
                </span>

                <strong>

                    <?= htmlspecialchars($fila['metodo']) ?>

                </strong>

            </div>


            <!-- COSTO -->

            <div class="campo">

                <span>
                    Costo total
                </span>

                <strong>

                    Bs.
                    <?= htmlspecialchars($fila['costototal']) ?>

                </strong>

            </div>


            <!-- PEDIDO -->

            <div class="campo">

                <span>
                    ID Pedido
                </span>

                <strong>

                    #<?= htmlspecialchars($fila['pedidos_id']) ?>

                </strong>

            </div>


            <!-- VENDEDOR -->

            <div class="campo">

                <span>
                    Vendedor
                </span>


                <?php  

                $pedidos_id = $fila['pedidos_id'];  

                $sqlPedido = "
                    SELECT nombrevendedor 
                    FROM pedidos 
                    WHERE id = '$pedidos_id'
                ";  

                $resultadoPedido =
                    $conexion->query($sqlPedido);  

                if (
                    $resultadoPedido &&
                    $resultadoPedido->num_rows > 0
                ) {  

                    $pedido =
                        $resultadoPedido->fetch_assoc();  

                ?>

                    <strong>

                        <?= htmlspecialchars(
                            $pedido['nombrevendedor']
                        ) ?>

                    </strong>

                <?php

                } else {

                ?>

                    <strong>

                        No disponible

                    </strong>

                <?php

                }

                ?>

            </div>


        </div>


        <!-- BOTÓN -->

        <a
            href="leerventas.php"
            class="btn"
        >

            ← Volver a ventas

        </a>


    </section>


</section>


</body>

</html>