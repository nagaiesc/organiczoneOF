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

$anio = $_GET['anio'] ?? date('Y');

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

$meses = [];
$ingresos = [];

$sql = "
    SELECT 
        MONTH(p.fecha) AS mes,
        SUM(v.costototal) AS ingresos
    FROM ventas v
    INNER JOIN pedidos p ON v.pedidos_id = p.id
    WHERE YEAR(p.fecha) = '$anio'
    GROUP BY MONTH(p.fecha)
    ORDER BY mes
";

$resultado = $conn->query($sql);

while ($fila = $resultado->fetch_assoc()) {
    $meses[] = $mesesNombres[$fila['mes']];
    $ingresos[] = (float) $fila['ingresos'];
}

$anios = [];
$totales = [];

$sqlAnual = "
    SELECT 
        YEAR(p.fecha) AS anio,
        SUM(v.costototal) AS total
    FROM ventas v
    INNER JOIN pedidos p ON v.pedidos_id = p.id
    GROUP BY YEAR(p.fecha)
    ORDER BY anio
";

$resultadoAnual = $conn->query($sqlAnual);

while ($fila = $resultadoAnual->fetch_assoc()) {
    $anios[] = $fila['anio'];
    $totales[] = (float) $fila['total'];
}

$totalAnio = 0;

foreach ($ingresos as $ingreso) {
    $totalAnio += $ingreso;
}

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Reporte de Ingresos</title>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 30px;
            min-height: 100vh;
            background: #EAF7EC;
            font-family: 'Fredoka', sans-serif;
            color: #2B140D;
        }

        .principal {
            width: 95%;
            max-width: 1100px;
            margin: 40px auto;
            padding: 40px;
            background: #FFFFFF;
            border-radius: 30px;
            box-shadow: 0 10px 30px rgba(43, 20, 13, 0.12);
        }

        h1 {
            margin: 0;
            color: #2B140D;
            font-size: 42px;
        }

        h1::after {
            content: "";
            display: block;
            width: 60px;
            height: 5px;
            margin-top: 10px;
            background: #0BA84A;
            border-radius: 10px;
        }

        .filtro {
            display: flex;
            align-items: end;
            gap: 15px;
            margin: 30px 0;
            flex-wrap: wrap;
        }

        .filtro label {
            display: block;
            margin-bottom: 7px;
            font-weight: 600;
        }

        .filtro input {
            padding: 11px 15px;
            border: 1px solid #DDE5DE;
            border-radius: 20px;
            font-family: 'Fredoka', sans-serif;
            font-size: 16px;
            outline: none;
        }

        .filtro input:focus {
            border-color: #0BA84A;
            box-shadow: 0 0 0 3px rgba(11, 168, 74, 0.12);
        }

        .boton {
            padding: 12px 25px;
            border: 0;
            border-radius: 25px;
            background: #0BA84A;
            color: #FFFFFF;
            font-family: 'Fredoka', sans-serif;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s ease;
        }

        .boton:hover {
            background: #087F3B;
            transform: translateY(-1px);
        }

        .tarjeta {
            margin-bottom: 30px;
            padding: 25px;
            background: #2B140D;
            color: #FCD09F;
            border-radius: 25px;
        }

        .tarjeta p {
            margin: 0;
            color: #FFFFFF;
            font-size: 18px;
        }

        .tarjeta h2 {
            margin: 5px 0 0;
            font-size: 42px;
        }

        .grafico {
            height: 400px;
            margin-bottom: 30px;
            padding: 25px;
            background: #FFFFFF;
            border: 1px solid #E8EEE9;
            border-radius: 20px;
        }

        .titulo-grafico {
            margin: 0 0 20px;
            color: #2B140D;
            font-size: 24px;
            font-weight: 700;
        }

        .volver {
            display: inline-block;
            margin-top: 5px;
            color: #0BA84A;
            font-weight: 600;
            text-decoration: none;
            transition: 0.2s ease;
        }

        .volver:hover {
            color: #087F3B;
            transform: translateX(-2px);
        }

        @media (max-width: 700px) {

            body {
                padding: 15px;
            }

            .principal {
                width: 100%;
                margin: 20px auto;
                padding: 25px;
            }

            h1 {
                font-size: 34px;
            }

            .grafico {
                height: 350px;
                padding: 15px;
            }

            .tarjeta h2 {
                font-size: 34px;
            }

        }

    </style>

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
                    value="<?php echo htmlspecialchars($anio); ?>"
                    min="2020"
                    max="2100"
                >

            </div>

            <button class="boton" type="submit">
                Consultar
            </button>

        </form>

        <section class="tarjeta">

            <p>
                Ingresos totales del año <?php echo htmlspecialchars($anio); ?>
            </p>

            <h2>
                Bs. <?php echo number_format($totalAnio, 2); ?>
            </h2>

        </section>
         
        <?php include 'reportesdia.php'; ?>

        <?php include 'reportessemana.php'; ?>

        <section class="grafico">

            <h2 class="titulo-grafico">
                Ingresos por mes
            </h2>

            <canvas id="graficoMeses"></canvas>

        </section>

        <section class="grafico">

            <h2 class="titulo-grafico">
                Ingresos por año
            </h2>

            <canvas id="graficoAnios"></canvas>

        </section>

        <a class="volver" href="../vistaadmin.php">
            ← Volver al panel del administrador
        </a>

    </article>

    <script>

        const meses = <?php echo json_encode($meses); ?>;
        const ingresos = <?php echo json_encode($ingresos); ?>;

        const anios = <?php echo json_encode($anios); ?>;
        const totales = <?php echo json_encode($totales); ?>;

        const verdeOrganicZone = '#0BA84A';
        const verdeOscuro = '#087F3B';

        const ctxMeses = document.getElementById('graficoMeses');

        new Chart(ctxMeses, {
            type: 'bar',

            data: {
                labels: meses,

                datasets: [
                    {
                        label: 'Ingresos en Bs.',
                        data: ingresos,
                        backgroundColor: verdeOrganicZone,
                        borderColor: verdeOscuro,
                        borderWidth: 1,
                        borderRadius: 8,
                        hoverBackgroundColor: verdeOscuro
                    }
                ]
            },

            options: {
                responsive: true,
                maintainAspectRatio: false,

                plugins: {
                    legend: {
                        labels: {
                            font: {
                                family: 'Fredoka',
                                size: 14
                            }
                        }
                    }
                },

                scales: {
                    x: {
                        ticks: {
                            font: {
                                family: 'Fredoka'
                            }
                        },

                        grid: {
                            display: false
                        }
                    },

                    y: {
                        beginAtZero: true,

                        ticks: {
                            font: {
                                family: 'Fredoka'
                            }
                        }
                    }
                }
            }
        });

        const ctxAnios = document.getElementById('graficoAnios');

        new Chart(ctxAnios, {
            type: 'bar',

            data: {
                labels: anios,

                datasets: [
                    {
                        label: 'Ingresos en Bs.',
                        data: totales,
                        backgroundColor: verdeOrganicZone,
                        borderColor: verdeOscuro,
                        borderWidth: 1,
                        borderRadius: 8,
                        hoverBackgroundColor: verdeOscuro
                    }
                ]
            },

            options: {
                responsive: true,
                maintainAspectRatio: false,

                plugins: {
                    legend: {
                        labels: {
                            font: {
                                family: 'Fredoka',
                                size: 14
                            }
                        }
                    }
                },

                scales: {
                    x: {
                        ticks: {
                            font: {
                                family: 'Fredoka'
                            }
                        },

                        grid: {
                            display: false
                        }
                    },

                    y: {
                        beginAtZero: true,

                        ticks: {
                            font: {
                                family: 'Fredoka'
                            }
                        }
                    }
                }
            }
        });

    </script>

</body>

</html>

