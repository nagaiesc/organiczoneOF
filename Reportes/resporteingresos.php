<?php

session_start();

$rol = $_SESSION['rol'] ?? '';
$nombreVendedor = $_SESSION['nombre'] ?? '';

/* =====================================================
   CONEXIÓN
===================================================== */

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

    die("Error de conexión con la base de datos");

}


/* =====================================================
   FILTROS
===================================================== */

$anioActual = date("Y");

$anio = isset($_GET['anio']) ? (int) $_GET['anio'] : $anioActual;

$mes = isset($_GET['mes']) ? (int) $_GET['mes'] : 0;

if ($anio < 2000 || $anio > 2100) {

    $anio = $anioActual;

}

if ($mes < 0 || $mes > 12) {

    $mes = 0;

}


/* =====================================================
   FILTRO PARA ADMINISTRADOR O VENDEDOR
===================================================== */

$filtroVendedor = "";

if ($rol != "admin" && $nombreVendedor != "") {

    $nombreVendedorSeguro =
        $conexion->real_escape_string($nombreVendedor);

    $filtroVendedor =
        " AND p.nombrevendedor = '$nombreVendedorSeguro'";

}


/* =====================================================
   INGRESO TOTAL DEL AÑO
===================================================== */

$sqlAnual = "
    SELECT COALESCE(SUM(v.costototal), 0) AS total
    FROM ventas v
    INNER JOIN pedidos p
        ON v.pedidos_id = p.id
    WHERE YEAR(p.fecha) = $anio
    $filtroVendedor
";

$resultadoAnual = $conexion->query($sqlAnual);

$filaAnual = $resultadoAnual->fetch_assoc();

$totalAnual = $filaAnual['total'];


/* =====================================================
   INGRESO TOTAL DEL MES SELECCIONADO
===================================================== */

$totalMes = 0;

if ($mes > 0) {

    $sqlMes = "
        SELECT COALESCE(SUM(v.costototal), 0) AS total
        FROM ventas v
        INNER JOIN pedidos p
            ON v.pedidos_id = p.id
        WHERE YEAR(p.fecha) = $anio
        AND MONTH(p.fecha) = $mes
        $filtroVendedor
    ";

    $resultadoMes = $conexion->query($sqlMes);

    $filaMes = $resultadoMes->fetch_assoc();

    $totalMes = $filaMes['total'];

}


/* =====================================================
   INGRESOS POR MES
===================================================== */

$sqlMensual = "
    SELECT
        MONTH(p.fecha) AS mes,
        COALESCE(SUM(v.costototal), 0) AS total
    FROM ventas v
    INNER JOIN pedidos p
        ON v.pedidos_id = p.id
    WHERE YEAR(p.fecha) = $anio
    $filtroVendedor
    GROUP BY MONTH(p.fecha)
    ORDER BY MONTH(p.fecha)
";

$resultadoMensual = $conexion->query($sqlMensual);

$ingresosMensuales = array_fill(1, 12, 0);

while ($fila = $resultadoMensual->fetch_assoc()) {

    $ingresosMensuales[(int) $fila['mes']] =
        $fila['total'];

}


/* =====================================================
   INGRESOS POR AÑO
===================================================== */

$sqlAnios = "
    SELECT
        YEAR(p.fecha) AS anio,
        COALESCE(SUM(v.costototal), 0) AS total
    FROM ventas v
    INNER JOIN pedidos p
        ON v.pedidos_id = p.id
    WHERE p.fecha IS NOT NULL
    $filtroVendedor
    GROUP BY YEAR(p.fecha)
    ORDER BY YEAR(p.fecha) DESC
";

$resultadoAnios = $conexion->query($sqlAnios);

$ingresosAnuales = [];

while ($fila = $resultadoAnios->fetch_assoc()) {

    $ingresosAnuales[] = $fila;

}


/* =====================================================
   MESES
===================================================== */

$meses = [

    1 => "Enero",
    2 => "Febrero",
    3 => "Marzo",
    4 => "Abril",
    5 => "Mayo",
    6 => "Junio",
    7 => "Julio",
    8 => "Agosto",
    9 => "Septiembre",
    10 => "Octubre",
    11 => "Noviembre",
    12 => "Diciembre"

];

$nombreMesSeleccionado =
    $mes > 0 ? $meses[$mes] : "Todos los meses";

?>

<!DOCTYPE html>

<html lang="es">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Reporte de Ingresos - OrganicZone</title>

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
   BOTONES
===================================================== */

.boton {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    width: fit-content;

    margin-top: 25px;

    padding: 13px 23px;

    border-radius: 40px;

    background: #0ba84a;

    color: white;

    text-decoration: none;

    font-size: 17px;

    font-weight: 600;

    box-shadow:
        0 8px 20px rgba(11, 168, 74, 0.25);

    transition: 0.25s ease;

}

.boton:hover {

    background: #098d3e;

    transform: translateY(-3px);

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
   FILTROS
===================================================== */

.filtros {

    display: flex;

    flex-wrap: wrap;

    align-items: end;

    gap: 15px;

    margin-bottom: 28px;

    padding: 20px;

    background: #f8fbf9;

    border-radius: 18px;

    border: 1px solid #eeeeee;

}

.campo {

    display: flex;

    flex-direction: column;

    gap: 7px;

}

.campo label {

    color: #2B140D;

    font-size: 14px;

    font-weight: 600;

}

.campo select {

    padding: 11px 14px;

    min-width: 150px;

    border: 1px solid #dddddd;

    border-radius: 12px;

    background: white;

    color: #2B140D;

    font-family: 'Fredoka', Arial, sans-serif;

    font-size: 14px;

    outline: none;

}

.btn-filtrar {

    border: none;

    padding: 12px 20px;

    border-radius: 30px;

    background: #0ba84a;

    color: white;

    font-family: 'Fredoka', Arial, sans-serif;

    font-size: 15px;

    font-weight: 600;

    cursor: pointer;

    transition: 0.25s ease;

}

.btn-filtrar:hover {

    background: #098d3e;

    transform: translateY(-2px);

}


/* =====================================================
   TARJETAS
===================================================== */

.tarjetas {

    display: grid;

    grid-template-columns: repeat(2, 1fr);

    gap: 18px;

    margin-bottom: 30px;

}

.tarjeta {

    padding: 23px;

    border-radius: 20px;

    background: #f4ffef;

    border: 1px solid #e4f0df;

}

.tarjeta.verde {

    background: #0ba84a;

    color: white;

    border: none;

}

.tarjeta h3 {

    margin: 0 0 10px 0;

    font-size: 16px;

    font-weight: 600;

}

.tarjeta .monto {

    font-size: 32px;

    font-weight: 700;

}

.tarjeta p {

    margin: 8px 0 0 0;

    font-size: 13px;

    opacity: 0.8;

}


/* =====================================================
   TABLAS
===================================================== */

.tabla-contenedor {

    width: 100%;

    overflow-x: auto;

    border-radius: 15px;

    border: 1px solid #eee;

    margin-bottom: 30px;

}

table {

    width: 100%;

    border-collapse: collapse;

}

thead {

    background: #2B140D;

}

thead th {

    padding: 15px;

    color: white;

    text-align: left;

    font-size: 14px;

    font-weight: 600;

}

tbody td {

    padding: 14px 15px;

    border-bottom: 1px solid #eeeeee;

    color: #4b4b4b;

    font-size: 14px;

}

tbody tr:hover {

    background: #f8fbf9;

}

tbody tr:last-child td {

    border-bottom: none;

}

.monto-tabla {

    color: #0ba84a;

    font-weight: 700;

}

.mes-seleccionado {

    background: #f4ffef;

}

.sin-ingresos {

    color: #999999;

}


/* =====================================================
   RESPONSIVE
===================================================== */

@media (max-width: 1000px) {

    .principal-grid {

        grid-template-columns: 1fr;

    }

    .section-negro {

        padding: 40px 30px;

    }

    .contrato-titulo {

        margin-top: 0;

    }

}

@media (max-width: 650px) {

    body {

        padding: 15px;

    }

    .section-blanco {

        padding: 25px 18px;

    }

    .tarjetas {

        grid-template-columns: 1fr;

    }

    .filtros {

        align-items: stretch;

    }

    .campo select,
    .btn-filtrar {

        width: 100%;

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

            REPORTE<br>
            DE INGRESOS

        </h1>

        <p class="desc">

            Consulta los ingresos totales
            de OrganicZone por mes y por año,
            utilizando las ventas registradas
            en el sistema.

        </p>

        <a
            href="../Ventas/leerventas.php"
            class="boton"
        >

            Ver ventas

        </a>

    </section>


    <!-- =================================================
         PANEL DERECHO
    ================================================== -->

    <section class="section-blanco">

        <section class="section-clientes">

            <h2>

                Ingresos Totales

            </h2>

        </section>


        <!-- =================================================
             FILTROS
        ================================================== -->

        <form method="GET" class="filtros">

            <div class="campo">

                <label for="anio">

                    Año

                </label>

                <select name="anio" id="anio">

                    <?php

                    $anioInicio = $anioActual - 5;

                    $anioFin = $anioActual + 1;

                    for ($i = $anioFin; $i >= $anioInicio; $i--) {

                        $seleccionado =
                            ($i == $anio) ? "selected" : "";

                        echo "

                        <option
                            value='$i'
                            $seleccionado
                        >

                            $i

                        </option>

                        ";

                    }

                    ?>

                </select>

            </div>


            <div class="campo">

                <label for="mes">

                    Mes

                </label>

                <select name="mes" id="mes">

                    <option value="0">

                        Todos los meses

                    </option>

                    <?php

                    foreach ($meses as $numero => $nombre) {

                        $seleccionado =
                            ($numero == $mes) ? "selected" : "";

                        echo "

                        <option
                            value='$numero'
                            $seleccionado
                        >

                            $nombre

                        </option>

                        ";

                    }

                    ?>

                </select>

            </div>


            <button type="submit" class="btn-filtrar">

                Consultar reporte

            </button>

        </form>


        <!-- =================================================
             TARJETAS
        ================================================== -->

        <section class="tarjetas">

            <article class="tarjeta verde">

                <h3>

                    Ingresos del año <?= $anio ?>

                </h3>

                <div class="monto">

                    Bs. <?= number_format((float) $totalAnual, 0, ',', '.') ?>

                </div>

                <p>

                    Total acumulado del año seleccionado

                </p>

            </article>


            <article class="tarjeta">

                <h3>

                    <?= $mes > 0
                        ? "Ingresos de $nombreMesSeleccionado"
                        : "Periodo seleccionado"
                    ?>

                </h3>

                <div class="monto">

                    Bs. <?= number_format(
                        (float) ($mes > 0 ? $totalMes : $totalAnual),
                        0,
                        ',',
                        '.'
                    ) ?>

                </div>

                <p>

                    <?= $mes > 0
                        ? "Total de $nombreMesSeleccionado de $anio"
                        : "Selecciona un mes para consultar su ingreso"
                    ?>

                </p>

            </article>

        </section>


        <!-- =================================================
             REPORTE MENSUAL
        ================================================== -->

        <section class="section-clientes">

            <h2>

                Ingresos por mes - <?= $anio ?>

            </h2>

        </section>


        <div class="tabla-contenedor">

            <table>

                <thead>

                    <tr>

                        <th>Mes</th>

                        <th>Ingresos</th>

                    </tr>

                </thead>

                <tbody>

                    <?php

                    foreach ($meses as $numero => $nombre) {

                        $clase = "";

                        if ($mes == $numero) {

                            $clase = "class='mes-seleccionado'";

                        }

                        $total = $ingresosMensuales[$numero];

                        echo "

                        <tr $clase>

                            <td>

                                $nombre

                            </td>

                            <td class='monto-tabla'>

                                Bs. " .
                                number_format(
                                    (float) $total,
                                    0,
                                    ',',
                                    '.'
                                )
                                . "

                            </td>

                        </tr>

                        ";

                    }

                    ?>

                </tbody>

            </table>

        </div>


        <!-- =================================================
             REPORTE ANUAL
        ================================================== -->

        <section class="section-clientes">

            <h2>

                Ingresos por año

            </h2>

        </section>


        <div class="tabla-contenedor">

            <table>

                <thead>

                    <tr>

                        <th>Año</th>

                        <th>Ingresos totales</th>

                    </tr>

                </thead>

                <tbody>

                    <?php

                    if (count($ingresosAnuales) > 0) {

                        foreach ($ingresosAnuales as $fila) {

                            echo "

                            <tr>

                                <td>

                                    " . htmlspecialchars(
                                        $fila['anio']
                                    ) . "

                                </td>

                                <td class='monto-tabla'>

                                    Bs. " .
                                    number_format(
                                        (float) $fila['total'],
                                        0,
                                        ',',
                                        '.'
                                    )
                                    . "

                                </td>

                            </tr>

                            ";

                        }

                    } else {

                        echo "

                        <tr>

                            <td colspan='2' class='sin-ingresos'>

                                No hay ventas registradas todavía.

                            </td>

                        </tr>

                        ";

                    }

                    ?>

                </tbody>

            </table>

        </div>

    </section>

</section>

</body>

</html>
