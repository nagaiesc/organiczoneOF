
<?php

session_start();

$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$bd = "organiczoneBD";

$conn = new mysqli($servidor, $usuario, $contrasena, $bd);

if ($conn->connect_error) {
    die("Error de conexión");
}

$conn->set_charset("utf8mb4");

$anio = filter_input(INPUT_GET, 'anio', FILTER_VALIDATE_INT);

if ($anio === false || $anio === null || $anio < 2020 || $anio > 2100) {
    $anio = (int) date('Y');
}

$mesesNombres = [
    1 => 'Enero',
    2 => 'Febrero',
    3 => 'Marzo',
    4 => 'Abril',
    5 => 'Mayo',
    6 => 'Junio',
    7 => 'Julio',
    8 => 'Agosto',
    9 => 'Septiembre',
    10 => 'Octubre',
    11 => 'Noviembre',
    12 => 'Diciembre'
];

$meses = array_values($mesesNombres);
$ingresos = array_fill(0, 12, 0);

$fechaInicio = sprintf('%04d-01-01', $anio);
$fechaFin = sprintf('%04d-01-01', $anio + 1);

$sql = "
    SELECT
        MONTH(p.fecha) AS mes,
        COALESCE(SUM(v.costototal), 0) AS ingresos
    FROM ventas v
    INNER JOIN pedidos p ON v.pedidos_id = p.id
    WHERE p.fecha >= ?
      AND p.fecha < ?
    GROUP BY MONTH(p.fecha)
    ORDER BY mes
";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Error en el reporte mensual: " . htmlspecialchars($conn->error));
}

$stmt->bind_param("ss", $fechaInicio, $fechaFin);

if (!$stmt->execute()) {
    die("Error al consultar los ingresos mensuales");
}

$resultado = $stmt->get_result();

while ($fila = $resultado->fetch_assoc()) {
    $indice = (int) $fila['mes'] - 1;

    if ($indice >= 0 && $indice < 12) {
        $ingresos[$indice] = (float) $fila['ingresos'];
    }
}

$stmt->close();

$anios = [];
$totales = [];

$sqlAnual = "
    SELECT
        YEAR(p.fecha) AS anio,
        SUM(v.costototal) AS total
    FROM ventas v
    INNER JOIN pedidos p ON v.pedidos_id = p.id
    WHERE p.fecha IS NOT NULL
    GROUP BY YEAR(p.fecha)
    ORDER BY anio
";

$resultadoAnual = $conn->query($sqlAnual);

if (!$resultadoAnual) {
    die("Error en el reporte anual: " . htmlspecialchars($conn->error));
}

while ($fila = $resultadoAnual->fetch_assoc()) {
    $anios[] = (string) $fila['anio'];
    $totales[] = (float) $fila['total'];
}

$totalAnio = array_sum($ingresos);

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Reporte de Ingresos | Organic Zone</title>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>

        * {
            box-sizing: border-box;
        }

        :root {
            --verde: #0BA84A;
            --verde-oscuro: #087F3B;
            --cafe: #2B140D;
            --crema: #FCD09F;
            --fondo: #F4F1EE;
            --borde: #E8EEE9;
        }

        body {
            margin: 0;
            padding: 24px;
            min-height: 100vh;
            background: var(--fondo);
            font-family: 'Fredoka', sans-serif;
            color: var(--cafe);
        }

        .principal {
            width: 100%;
            max-width: 1100px;
            margin: 35px auto;
            padding: 36px;
            background: #FFFFFF;
            border-radius: 28px;
        }

        h1 {
            margin: 0;
            font-size: 38px;
            line-height: 1.2;
        }

        h1::after {
            content: "";
            display: block;
            width: 58px;
            height: 5px;
            margin-top: 12px;
            background: var(--verde);
            border-radius: 10px;
        }

        .filtro {
            display: flex;
            align-items: end;
            flex-wrap: wrap;
            gap: 14px;
            margin: 28px 0;
        }

        .filtro label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .filtro input {
            width: 180px;
            min-height: 45px;
            padding: 10px 14px;
            border: 1px solid #DDE5DE;
            border-radius: 15px;
            font-family: 'Fredoka', sans-serif;
            font-size: 16px;
            outline: none;
        }

        .filtro input:focus {
            border-color: var(--verde);
        }

        .boton {
            min-height: 45px;
            padding: 11px 24px;
            border: 0;
            border-radius: 15px;
            background: var(--verde);
            color: #FFFFFF;
            font-family: 'Fredoka', sans-serif;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
        }

        .boton:hover {
            background: var(--verde-oscuro);
        }

        .tarjeta {
            margin-bottom: 28px;
            padding: 25px;
            background: var(--cafe);
            color: var(--crema);
            border-radius: 22px;
        }

        .tarjeta p {
            margin: 0;
            color: #FFFFFF;
            font-size: 17px;
            line-height: 1.5;
        }

        .tarjeta h2 {
            margin: 8px 0 0;
            color: var(--crema);
            font-size: 38px;
            overflow-wrap: anywhere;
        }

        .grafico {
            width: 100%;
            min-width: 0;
            height: 390px;
            margin-bottom: 26px;
            padding: 24px;
            background: #FFFFFF;
            border: 1px solid var(--borde);
            border-radius: 21px;
        }

        .titulo-grafico {
            margin: 0 0 18px;
            font-size: 23px;
            line-height: 1.3;
        }

        .grafico-contenido {
            position: relative;
            width: 100%;
            height: 300px;
            min-width: 0;
        }

        .grafico-contenido canvas {
            display: block;
        }

        .volver {
            display: inline-block;
            margin-top: 4px;
            padding: 8px 0;
            color: var(--verde-oscuro);
            font-weight: 600;
            text-decoration: none;
        }

        .volver:hover {
            color: var(--cafe);
        }

        @media (max-width: 700px) {

            body {
                padding: 12px;
            }

            .principal {
                margin: 16px auto;
                padding: 22px 15px;
                border-radius: 22px;
            }

            h1 {
                font-size: 30px;
            }

            .filtro {
                display: flex;
                flex-direction: column;
                align-items: stretch;
                gap: 12px;
                margin: 24px 0;
            }

            .filtro > div,
            .filtro input,
            .boton {
                width: 100%;
            }

            .tarjeta {
                padding: 22px 18px;
                border-radius: 19px;
            }

            .tarjeta p {
                font-size: 15px;
            }

            .tarjeta h2 {
                font-size: 31px;
            }

            .grafico {
                height: 335px;
                margin-bottom: 20px;
                padding: 18px 10px 12px;
                border-radius: 18px;
            }

            .titulo-grafico {
                padding: 0 4px;
                font-size: 20px;
            }

            .grafico-contenido {
                height: 265px;
            }

            .volver {
                font-size: 14px;
                line-height: 1.6;
            }

        }

        @media (max-width: 380px) {

            .principal {
                padding: 19px 11px;
            }

            h1 {
                font-size: 27px;
            }

            .grafico {
                padding-right: 7px;
                padding-left: 7px;
            }

            .grafico-contenido {
                height: 245px;
            }

        }

    </style>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/organiczoneOF/includes/oz-navegacion.php'; ?>

</head>

<body>

    <article class="principal">

        <h1>Reporte de Ingresos</h1>

        <form class="filtro" method="GET">

            <div>
                <label for="anio">Año</label>

                <input
                    type="number"
                    id="anio"
                    name="anio"
                    value="<?php echo htmlspecialchars((string) $anio, ENT_QUOTES, 'UTF-8'); ?>"
                    min="2020"
                    max="2100"
                    required
                >
            </div>

            <button class="boton" type="submit">
                Consultar
            </button>

        </form>

        <section class="tarjeta">

            <p>
                Ingresos totales del año <?php echo htmlspecialchars((string) $anio, ENT_QUOTES, 'UTF-8'); ?>
            </p>

            <h2>
                Bs. <?php echo number_format($totalAnio, 2, ',', '.'); ?>
            </h2>

        </section>

        <?php include 'reportesdia.php'; ?>

        <?php include 'reportessemana.php'; ?>

        <section class="grafico">

            <h2 class="titulo-grafico">
                Ingresos por mes
            </h2>

            <div class="grafico-contenido">
                <canvas id="graficoMeses"></canvas>
            </div>

        </section>

        <section class="grafico">

            <h2 class="titulo-grafico">
                Ingresos por año
            </h2>

            <div class="grafico-contenido">
                <canvas id="graficoAnios"></canvas>
            </div>

        </section>

        <a class="volver" href="../vistaadmin.php">
            ← Volver al panel del administrador
        </a>

    </article>

    <script>

        const meses = <?php echo json_encode($meses, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
        const ingresos = <?php echo json_encode($ingresos, JSON_NUMERIC_CHECK); ?>;

        const anios = <?php echo json_encode($anios, JSON_NUMERIC_CHECK); ?>;
        const totales = <?php echo json_encode($totales, JSON_NUMERIC_CHECK); ?>;

        const verdeOrganicZone = '#0BA84A';
        const verdeOscuro = '#087F3B';
        const cafeOrganicZone = '#2B140D';

        Chart.defaults.font.family = 'Fredoka';
        Chart.defaults.color = '#78685F';

        const formatoBolivianos = (valor) => {
            return 'Bs. ' + Number(valor).toLocaleString('es-BO', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        };

        const opcionesBase = {
            responsive: true,
            maintainAspectRatio: false,
            resizeDelay: 100,

            plugins: {
                legend: {
                    display: true,
                    labels: {
                        usePointStyle: true,
                        padding: 14,
                        font: {
                            family: 'Fredoka',
                            size: 12
                        }
                    }
                },

                tooltip: {
                    backgroundColor: cafeOrganicZone,
                    titleFont: {
                        family: 'Fredoka'
                    },
                    bodyFont: {
                        family: 'Fredoka'
                    },
                    padding: 12,
                    cornerRadius: 10,
                    callbacks: {
                        label: function(context) {
                            return 'Ingresos: ' + formatoBolivianos(context.parsed.y);
                        }
                    }
                }
            },

            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            family: 'Fredoka',
                            size: 11
                        },
                        maxRotation: 45,
                        minRotation: 0
                    },
                    border: {
                        display: false
                    }
                },

                y: {
                    beginAtZero: true,
                    ticks: {
                        font: {
                            family: 'Fredoka',
                            size: 11
                        },
                        callback: function(valor) {
                            return 'Bs. ' + Number(valor).toLocaleString('es-BO');
                        }
                    },
                    border: {
                        display: false
                    },
                    grid: {
                        color: 'rgba(43, 20, 13, 0.07)'
                    }
                }
            }
        };

        const ctxMeses = document.getElementById('graficoMeses');

        new Chart(ctxMeses, {
            type: 'line',

            data: {
                labels: meses,

                datasets: [{
                    label: 'Ingresos en Bs.',
                    data: ingresos,
                    borderColor: verdeOrganicZone,
                    backgroundColor: 'rgba(11, 168, 74, 0.10)',
                    fill: true,
                    borderWidth: 3,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    pointBackgroundColor: verdeOrganicZone,
                    pointBorderColor: '#FFFFFF',
                    pointBorderWidth: 2,
                    tension: 0.3,
                    spanGaps: true
                }]
            },

            options: {
                ...opcionesBase,

                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });

        const ctxAnios = document.getElementById('graficoAnios');

        new Chart(ctxAnios, {
            type: 'bar',

            data: {
                labels: anios,

                datasets: [{
                    label: 'Ingresos en Bs.',
                    data: totales,
                    backgroundColor: verdeOrganicZone,
                    borderColor: verdeOscuro,
                    borderWidth: 1,
                    borderRadius: 7,
                    hoverBackgroundColor: verdeOscuro,
                    maxBarThickness: 48
                }]
            },

            options: {
                ...opcionesBase,

                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });

    </script>

</body>

</html>
