<?php

$conexion = new mysqli(
    "localhost",
    "root",
    "",
    "organiczoneBD"
);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$sql = "SELECT * FROM productos ORDER BY id DESC";

$resultado = $conexion->query($sql);

?>
<!DOCTYPE html>

<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Menú - Organic Zone</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect"
          href="https://fonts.gstatic.com"
          crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&display=swap"
          rel="stylesheet">


    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background-color: #F5EEE3;
            font-family: 'Fredoka', sans-serif;
            color: #2B140D;
        }

        .menu-productos {
            width: 90%;
            max-width: 1400px;
            margin: auto;
            padding-top: 150px;
            padding-bottom: 80px;
        }

        .titulo-menu {
            text-align: center;
            margin-bottom: 50px;
        }

        .titulo-menu h1 {
            margin: 0;
            font-size: clamp(55px, 8vw, 90px);
            font-weight: 700;
            color: #0c8d2f;
        }


        .titulo-menu p {
            margin-top: 10px;
            font-size: 20px;
            color: #6d6d6d;

        }

        .productos {
            display: grid;
            grid-template-columns:
            repeat(auto-fit, minmax(250px, 1fr));
            gap: 35px;

        }


        .carta {
            background-color: white;
            border-radius: 30px;
            overflow: hidden;
            box-shadow:0 10px 30px rgba(43, 20, 13, 0.12);
            transition:
            transform 0.3s ease,
            box-shadow 0.3s ease;
        }

        .carta:hover {
            transform: translateY(-8px);
            box-shadow:0 18px 35px rgba(43, 20, 13, 0.18);
        }

        .imagen {
            width: 100%;
            height: 300px;
            background-color: #e9f4e6;
            overflow: hidden;
        }

        .imagen img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.4s ease;
        }

        .carta:hover .imagen img {
            transform: scale(1.05);
        }

        .informacion {
            padding: 22px;
        }

        .informacion h2 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
            color: #2B140D;
        }

        .descripcion {
            margin-top: 10px;
            min-height: 50px;
            color: #777;
            line-height: 1.5;
            font-size: 16px;
        }

        .parte-inferior {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-top: 20px;

        }

        .precio {
            font-size: 25px;
            font-weight: 700;
            color: #0c8d2f;
        }

        .disponible {
            font-size: 14px;
            color: #777;
        }

        .sin-productos {
            grid-column: 1 / -1;
            background-color: white;
            border-radius: 30px;
            padding: 60px 30px;
            text-align: center;
            box-shadow:0 10px 30px rgba(43, 20, 13, 0.10);
        }

        .sin-productos h2 {
            margin: 0 0 10px;
            color: #2B140D;
            font-size: 30px;

        }

        .sin-productos p {
            margin: 0;
            color: #777;
            font-size: 18px;

        }

        @media (max-width: 700px) {

            .menu-productos {
                width: 92%;
                padding-top: 120px;
                padding-bottom: 50px;
            }


            .productos {
                grid-template-columns: 1fr;
            }


            .titulo-menu h1 {
                font-size: 55px;
            }
            .imagen {
                height: 280px;
            }
        }
    </style>
</head>


<body>
    <nav>
        <?php
        include("nav.php");
        ?>
    </nav>

    <section class="menu-productos">
        <div class="titulo-menu">
            <h1>Menú</h1>
            <p>
                Descubre todos nuestros productos
            </p>
        </div>


        <div class="productos">
            <?php
            if ($resultado && $resultado->num_rows > 0) {
                while ($producto = $resultado->fetch_assoc()) {
                    $id = $producto['id'];
                    $imagen =
                    "Imagenes/predeterminado.png";
                    $extensiones = ["jpg", "jpeg", "png","gif","webp"];

                    foreach ($extensiones as $extension) {
                        $ruta =
                        "Imagenes/P-" .
                        $id .
                        "." .
                        $extension;

                        if (file_exists($ruta)) {
                            $imagen = $ruta;
                            break;
                        }
                    }
            ?>

                    <article class="carta">
                        <div class="imagen">
                            <img
                                src="<?= htmlspecialchars($imagen) ?>"
                                alt="<?= htmlspecialchars($producto['nombre']) ?>"
                            >
                        </div>

                        <div class="informacion">
                            <h2>

                                <?= htmlspecialchars(
                                    $producto['nombre']
                                ) ?>
                            </h2>

                            <p class="descripcion">
                                <?= htmlspecialchars(
                                    $producto['descripcion']
                                ) ?>
                            </p>

                            <div class="parte-inferior">

                                <span class="precio">
                                    <?= htmlspecialchars(
                                        $producto['precio']
                                    ) ?>
                                    Bs
                                </span>
                                <span class="disponible">
                                 <?php
                                    if ($producto['stock'] > 0) {
                                        echo "Disponible";
                                    } else {
                                        echo "Agotado";
                                    }
                                    ?>
                                </span>
                            </div>
                        </div>
                    </article>
            <?php
                }
            } else {
            ?>
                <div class="sin-productos">
                    <h2>
                        No hay productos disponibles
                    </h2>
                    <p>
                        Pronto tendremos nuevos productos para ti.
                    </p>
                </div>
            <?php
            }
            ?>
        </div>

    </section>

    <footer>
        <?php
        include("footer.php");
        ?>
    </footer>
</body>
</html>
<?php
$conexion->close();

?>