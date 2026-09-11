<?php
$servidor = "localhost";
$nombre = "root";
$contraseña = "";
$BDnombre = "organiczoneBD";
$conn = new mysqli($servidor, $nombre, $contraseña, $BDnombre);

if ($conn->connect_error) {
    die("Conexión fallida");
}
$conn->set_charset("utf8mb4");
$sql = "SELECT 
            usuario.nombre,
            COUNT(pedidos.id) AS cantidad_pedidos
        FROM pedidos
        INNER JOIN usuario
            ON pedidos.usuario_id = usuario.id
        GROUP BY usuario.id, usuario.nombre
        ORDER BY cantidad_pedidos DESC";

$resultado = $conn->query($sql);

if (!$resultado) {
    die("Error en la consulta: " . $conn->error);
}

$clientes = [];
$cantidades = [];

while ($fila = $resultado->fetch_assoc()) {

    $clientes[] = $fila['nombre'];
    $cantidades[] = (int)$fila['cantidad_pedidos'];

}


$totalPedidos = array_sum($cantidades);

$totalClientes = count($clientes);

$clienteTop = $totalClientes > 0
    ? $clientes[0]
    : "Sin datos";

$cantidadTop = $totalClientes > 0
    ? $cantidades[0]
    : 0;

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
    Organic Zone | Clientes más frecuentes
</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link
    rel="preconnect"
    href="https://fonts.googleapis.com"
>

<link
    rel="preconnect"
    href="https://fonts.gstatic.com"
    crossorigin
>

<link
    href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Nunito:wght@400;600;700;800&display=swap"
    rel="stylesheet"
>


<style>

:root {

    --verde: #0BA84A;

    --verde-oscuro: #087A37;

    --verde-suave: #EAF7EC;

    --cafe: #2B140D;

    --cafe-suave: #5A382D;

    --crema: #FCD09F;

    --crema-suave: #FFF5E8;

    --blanco: #FFFFFF;

    --gris: #77716D;

    --borde: #EEE7E2;

}

* {

    box-sizing: border-box;

}


html {

    scroll-behavior: smooth;

}


body {

    margin: 0;

    min-height: 100vh;

    background:

        radial-gradient(
            circle at 10% 10%,
            rgba(11,168,74,.08),
            transparent 30%
        ),

        #F8FBF8;

    color: var(--cafe);

    font-family: 'Nunito', sans-serif;

}

.contenedor {

    width: min(1250px, 92%);

    margin: 0 auto;

    padding: 35px 0 50px;

}

.header {

    display: flex;

    align-items: center;

    justify-content: space-between;

    margin-bottom: 45px;

}

.logo {

    text-decoration: none;

    display: flex;

    flex-direction: column;

    align-items: flex-start;

    line-height: .72;

    transition: .3s ease;

}


.logo:hover {

    transform: translateY(-2px);

}


.logo .my {

    color: var(--cafe);

    font-family: 'Fredoka', sans-serif;

    font-size: 24px;

    font-weight: 800;

    margin-left: 9px;

    letter-spacing: .5px;

}


.logo .oz {

    margin-top: 1px;

    color: var(--verde);

    font-family: 'Fredoka', sans-serif;

    font-size: 59px;

    font-weight: 700;

    letter-spacing: -3px;

}

.boton-volver {

    display: inline-flex;

    align-items: center;

    gap: 9px;

    padding: 12px 21px;

    border-radius: 50px;

    background: var(--cafe);

    color: white;

    text-decoration: none;

    font-family: 'Fredoka', sans-serif;

    font-size: 15px;

    font-weight: 600;

    transition: .3s ease;

    box-shadow:
        0 7px 18px rgba(43,20,13,.13);

}


.boton-volver:hover {

    background: var(--verde);

    transform: translateY(-2px);

    box-shadow:
        0 9px 22px rgba(11,168,74,.20);

}

.encabezado {

    margin-bottom: 30px;

}


.etiqueta {

    display: inline-flex;

    align-items: center;

    gap: 8px;

    margin: 0 0 12px;

    color: var(--verde);

    font-family: 'Fredoka', sans-serif;

    font-size: 14px;

    font-weight: 700;

    letter-spacing: 1.5px;

}


.etiqueta::before {

    content: "";

    width: 28px;

    height: 4px;

    background: var(--verde);

    border-radius: 10px;

}


.titulo {

    margin: 0;

    font-family: 'Fredoka', sans-serif;

    font-size: clamp(38px, 5vw, 62px);

    line-height: .98;

    font-weight: 700;

    letter-spacing: -1.5px;

}


.titulo span {

    color: var(--verde);

}


.descripcion {

    max-width: 650px;

    margin: 18px 0 0;

    color: var(--gris);

    font-size: 16px;

    line-height: 1.6;

}

.resumen {

    display: grid;

    grid-template-columns: repeat(3, 1fr);

    gap: 18px;

    margin-bottom: 25px;

}


.tarjeta {

    position: relative;

    overflow: hidden;

    min-height: 145px;

    padding: 24px;

    border-radius: 28px;

    border: 1px solid var(--borde);

    background: var(--blanco);

    box-shadow:
        0 10px 30px rgba(43,20,13,.07);

    transition: .3s ease;

}


.tarjeta:hover {

    transform: translateY(-4px);

    box-shadow:
        0 15px 35px rgba(43,20,13,.11);

}


.tarjeta::after {

    content: "";

    position: absolute;

    width: 90px;

    height: 90px;

    right: -25px;

    bottom: -35px;

    border-radius: 50%;

    background:
        rgba(11,168,74,.08);

}


.tarjeta.verde {

    background: var(--verde);

    border-color: var(--verde);

    color: white;

}


.tarjeta.verde::after {

    background:
        rgba(255,255,255,.12);

}


.tarjeta.crema {

    background: var(--crema-suave);

    border-color: #F2DFC6;

}


.tarjeta.cafe {

    background: var(--cafe);

    border-color: var(--cafe);

    color: white;

}


.tarjeta.cafe::after {

    background:
        rgba(252,208,159,.10);

}

.tarjeta-label {

    position: relative;

    z-index: 2;

    margin: 0 0 8px;

    font-size: 13px;

    font-weight: 800;

    opacity: .78;

    text-transform: uppercase;

    letter-spacing: .7px;

}


.tarjeta-valor {

    position: relative;

    z-index: 2;

    margin: 0;

    font-family: 'Fredoka', sans-serif;

    font-size: 31px;

    font-weight: 700;

    line-height: 1.1;

}


.tarjeta-extra {

    position: relative;

    z-index: 2;

    margin: 7px 0 0;

    font-size: 13px;

    opacity: .75;

}

.grafico-contenedor {

    background: var(--blanco);

    border: 1px solid var(--borde);

    border-radius: 32px;

    padding: 30px;

    box-shadow:
        0 12px 35px rgba(43,20,13,.08);

}


.grafico-header {

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 20px;

    margin-bottom: 25px;

}


.grafico-titulo {

    margin: 0;

    font-family: 'Fredoka', sans-serif;

    font-size: 27px;

    font-weight: 700;

}


.grafico-subtitulo {

    margin: 5px 0 0;

    color: var(--gris);

    font-size: 14px;

}

.indicador {

    flex-shrink: 0;

    display: flex;

    align-items: center;

    gap: 9px;

    padding: 10px 15px;

    border-radius: 50px;

    background: var(--verde-suave);

    color: var(--verde-oscuro);

    font-family: 'Fredoka', sans-serif;

    font-size: 13px;

    font-weight: 600;

}


.indicador-punto {

    width: 8px;

    height: 8px;

    border-radius: 50%;

    background: var(--verde);

    box-shadow:
        0 0 0 4px rgba(11,168,74,.12);

}

.canvas-wrapper {

    position: relative;

    width: 100%;

    height: 520px;

}


/* =========================================================
   SIN DATOS
========================================================= */

.sin-datos {

    min-height: 400px;

    display: flex;

    align-items: center;

    justify-content: center;

    text-align: center;

    border-radius: 24px;

    background: var(--verde-suave);

    color: var(--cafe-suave);

    font-family: 'Fredoka', sans-serif;

    font-size: 20px;

    padding: 30px;

}


/* =========================================================
   DECORACIÓN FINAL
========================================================= */

.footer-decorativo {

    display: flex;

    justify-content: center;

    margin-top: 30px;

}


.footer-decorativo span {

    width: 55px;

    height: 5px;

    border-radius: 10px;

    background: var(--crema);

}


/* =========================================================
   TABLET
========================================================= */

@media (max-width: 850px) {

    .resumen {

        grid-template-columns: 1fr;

    }


    .header {

        margin-bottom: 35px;

    }


    .grafico-header {

        align-items: flex-start;

        flex-direction: column;

    }


    .canvas-wrapper {

        height: 480px;

    }

}


/* =========================================================
   CELULAR
========================================================= */

@media (max-width: 600px) {

    .contenedor {

        width: 94%;

        padding-top: 25px;

    }


    .header {

        margin-bottom: 30px;

    }


    .logo .oz {

        font-size: 36px;

    }


    .logo .my {

        font-size: 20px;

    }


    .boton-volver {

        padding: 10px 15px;

        font-size: 13px;

    }


    .titulo {

        font-size: 42px;

    }


    .grafico-contenedor {

        padding: 20px;

        border-radius: 24px;

    }


    .canvas-wrapper {

        height: 430px;

    }

}

</style>

</head>


<body>


<div class="contenedor">


<!-- =====================================================
     HEADER
===================================================== -->

<header class="header">


<a
    href="Cliente/vistacliente.php"
    class="logo"
    aria-label="Ir a My Oz"
>

    <span class="my">
        My
    </span>

    <span class="oz">
        Oz
    </span>

</a>


<a
    href="paginaprincipal.php"
    class="boton-volver"
>

    Volver

</a>


</header>

<section class="encabezado">


<p class="etiqueta">

    ORGANIC ZONE

</p>


<h1 class="titulo">

    Clientes más
    <span>frecuentes.</span>

</h1>


<p class="descripcion">

    Descubre cuáles son los clientes que más pedidos
    han realizado. La información se organiza
    automáticamente según la cantidad de pedidos
    registrados.

</p>


</section>

<section class="resumen">


<!-- CLIENTE TOP -->

<article class="tarjeta verde">


<p class="tarjeta-label">

    Cliente destacado

</p>


<h2 class="tarjeta-valor">

    <?= htmlspecialchars($clienteTop) ?>

</h2>


<p class="tarjeta-extra">

    <?= $cantidadTop ?>

    <?= $cantidadTop == 1 ? 'pedido realizado' : 'pedidos realizados' ?>

</p>


</article>




<article class="tarjeta crema">


<p class="tarjeta-label">

    Pedidos realizados

</p>


<h2 class="tarjeta-valor">

    <?= $totalPedidos ?>

</h2>


<p class="tarjeta-extra">

    Cantidad total de pedidos

</p>


</article>


<article class="tarjeta cafe">


<p class="tarjeta-label">

    Clientes analizados

</p>


<h2 class="tarjeta-valor">

    <?= $totalClientes ?>

</h2>


<p class="tarjeta-extra">

    Clientes con pedidos registrados

</p>


</article>


</section>

<section class="grafico-contenedor">


<div class="grafico-header">


<div>


<h2 class="grafico-titulo">

    Ranking de clientes

</h2>


<p class="grafico-subtitulo">

    Ordenados de mayor a menor cantidad de pedidos

</p>


</div>



<div class="indicador">


<span class="indicador-punto"></span>

Pedidos registrados


</div>


</div>



<?php if ($totalClientes > 0): ?>


<div class="canvas-wrapper">

    <canvas id="grafico"></canvas>

</div>


<?php else: ?>


<div class="sin-datos">

    No existen pedidos registrados
    para mostrar en el gráfico.

</div>


<?php endif; ?>


</section>

<div class="footer-decorativo">

    <span></span>

</div>


</div>



<?php if ($totalClientes > 0): ?>


<script>


const clientes = <?= json_encode(
    $clientes,
    JSON_UNESCAPED_UNICODE |
    JSON_UNESCAPED_SLASHES
) ?>;


const cantidades = <?= json_encode(
    $cantidades
) ?>;


const ctx = document.getElementById('grafico');


new Chart(ctx, {

    type: 'bar',


    data: {

        labels: clientes,


        datasets: [{

            label: 'Pedidos realizados',

            data: cantidades,


            backgroundColor:
                'rgba(11, 168, 74, 0.78)',


            borderColor:
                '#0BA84A',


            borderWidth: 2,


            borderRadius: 12,


            borderSkipped: false,


            barThickness: 28,


            hoverBackgroundColor:
                '#087A37',


            hoverBorderColor:
                '#087A37'

        }]

    },


    options: {


        indexAxis: 'y',


        responsive: true,


        maintainAspectRatio: false,


        animation: {

            duration: 900,

            easing: 'easeOutQuart'

        },



        interaction: {

            intersect: false,

            mode: 'index'

        },


        plugins: {

            legend: {

                display: false

            },


            tooltip: {

                backgroundColor:
                    '#2B140D',


                titleFont: {

                    family: 'Fredoka',

                    size: 14

                },


                bodyFont: {

                    family: 'Nunito',

                    size: 13

                },


                padding: 13,


                cornerRadius: 12,


                displayColors: false,


                callbacks: {

                    label: function(context) {

                        const cantidad =
                            context.parsed.x;

                        return cantidad +
                            (
                                cantidad === 1
                                ? ' pedido realizado'
                                : ' pedidos realizados'
                            );

                    }

                }

            }

        },

        scales: {

            x: {

                beginAtZero: true,


                ticks: {

                    precision: 0,


                    color:
                        '#77716D',


                    font: {

                        family: 'Nunito',

                        size: 12

                    }

                },


                grid: {

                    color:
                        'rgba(43,20,13,.07)'

                }

            },


            y: {

                ticks: {

                    color:
                        '#2B140D',


                    font: {

                        family: 'Fredoka',

                        size: 13,

                        weight: '600'

                    }

                },


                grid: {

                    display: false

                }

            }

        }

    }

});

</script>

<?php endif; ?>
<?php
$conn->close();
?>
</body>

</html>
