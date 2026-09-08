<?php

session_start();

$conexion = new mysqli(
    "localhost",
    "root",
    "",
    "organiczoneBD"
);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$conexion->set_charset("utf8mb4");

$sql = "SELECT * FROM productos ORDER BY id DESC";

$resultado = $conexion->query($sql);

if (!$resultado) {
    die("Error al consultar productos: " . $conexion->error);
}

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Menú | Organic Zone</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Nunito:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet"
    >

    <style>

        :root {
            --verde: #0BA84A;
            --verde-claro: #DDF3E4;
            --verde-oscuro: #087A36;
            --cafe: #2B140D;
            --cafe-claro: #583226;
            --crema: #FCD09F;
            --fondo: #F5EEE3;
            --blanco: #FFFFFF;
            --gris: #777777;
            --rojo: #D62828;
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            background:
                radial-gradient(
                    circle at 8% 12%,
                    rgba(11, 168, 74, 0.08),
                    transparent 25%
                ),
                radial-gradient(
                    circle at 92% 30%,
                    rgba(252, 208, 159, 0.22),
                    transparent 28%
                ),
                var(--fondo);
            color: var(--cafe);
            font-family: 'Nunito', sans-serif;
            min-height: 100vh;
        }

        nav {
            position: relative;
            z-index: 20;
        }

        .menu-productos {
            width: min(1400px, 92%);
            margin: auto;
            padding: 135px 0 90px;
        }

        .cabecera-menu {
            position: relative;
            display: grid;
            grid-template-columns: 1fr auto;
            align-items: end;
            gap: 30px;
            margin-bottom: 55px;
            padding: 55px 60px;
            border-radius: 42px;
            overflow: hidden;
            background:
                linear-gradient(
                    135deg,
                    #ffffff 0%,
                    #ffffff 58%,
                    #edf8ef 100%
                );
            box-shadow:
                0 20px 50px rgba(43, 20, 13, 0.10);
        }

        .cabecera-menu::before {
            content: "";
            position: absolute;
            width: 280px;
            height: 280px;
            right: -90px;
            top: -110px;
            border-radius: 50%;
            background: var(--crema);
            opacity: 0.38;
        }

        .cabecera-menu::after {
            content: "";
            position: absolute;
            width: 180px;
            height: 180px;
            right: 130px;
            bottom: -110px;
            border-radius: 50%;
            background: var(--verde);
            opacity: 0.10;
        }

        .cabecera-texto {
            position: relative;
            z-index: 2;
        }

        .mini-titulo {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            margin: 0 0 12px;
            color: var(--verde);
            font-size: 13px;
            font-weight: 900;
            letter-spacing: 2px;
        }

        .mini-titulo::before {
            content: "";
            width: 28px;
            height: 3px;
            border-radius: 10px;
            background: var(--verde);
        }

        .titulo-menu {
            margin: 0;
            font-family: 'Fredoka', sans-serif;
            font-size: clamp(60px, 8vw, 105px);
            line-height: 0.85;
            font-weight: 700;
            letter-spacing: -3px;
            color: var(--cafe);
        }

        .titulo-menu span {
            color: var(--verde);
        }

        .descripcion-menu {
            max-width: 560px;
            margin: 24px 0 0;
            color: var(--gris);
            font-size: 18px;
            line-height: 1.6;
            font-weight: 600;
        }

        .sello-menu {
            position: relative;
            z-index: 3;
            display: flex;
            width: 135px;
            height: 135px;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            border-radius: 50%;
            background: var(--verde);
            color: white;
            text-align: center;
            transform: rotate(7deg);
            box-shadow:
                0 14px 25px rgba(11, 168, 74, 0.22);
        }

        .sello-menu strong {
            font-family: 'Fredoka', sans-serif;
            font-size: 32px;
            line-height: 1;
        }

        .sello-menu small {
            margin-top: 6px;
            font-size: 11px;
            font-weight: 900;
            letter-spacing: 1px;
        }

        .barra-productos {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 25px;
        }

        .barra-productos h2 {
            margin: 0;
            font-family: 'Fredoka', sans-serif;
            font-size: 34px;
            color: var(--cafe);
        }

        .barra-productos p {
            margin: 5px 0 0;
            color: #8b817b;
            font-size: 14px;
            font-weight: 700;
        }

        .cantidad-productos {
            padding: 11px 18px;
            border-radius: 30px;
            background: var(--verde-claro);
            color: var(--verde-oscuro);
            font-size: 13px;
            font-weight: 900;
        }

        .productos {
            display: grid;
            grid-template-columns: repeat(
                auto-fit,
                minmax(280px, 1fr)
            );
            gap: 30px;
        }

        .carta {
            position: relative;
            background: var(--blanco);
            border-radius: 32px;
            overflow: hidden;
            border: 1px solid rgba(43, 20, 13, 0.04);
            box-shadow:
                0 12px 30px rgba(43, 20, 13, 0.08);
            transition:
                transform 0.3s ease,
                box-shadow 0.3s ease;
        }

        .carta:hover {
            transform: translateY(-9px);
            box-shadow:
                0 22px 45px rgba(43, 20, 13, 0.14);
        }

        .imagen {
            position: relative;
            width: 100%;
            height: 310px;
            overflow: hidden;
            background: var(--verde-claro);
        }

        .imagen::after {
            content: "";
            position: absolute;
            inset: 0;
            background:
                linear-gradient(
                    to top,
                    rgba(43, 20, 13, 0.14),
                    transparent 35%
                );
            pointer-events: none;
        }

        .imagen img {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .carta:hover .imagen img {
            transform: scale(1.07);
        }

        .etiqueta-producto {
            position: absolute;
            z-index: 3;
            top: 18px;
            left: 18px;
            padding: 8px 13px;
            border-radius: 30px;
            background: rgba(255, 255, 255, 0.93);
            color: var(--cafe);
            font-size: 11px;
            font-weight: 900;
            box-shadow:
                0 5px 15px rgba(43, 20, 13, 0.10);
        }

        .informacion {
            padding: 24px 24px 25px;
        }

        .informacion h2 {
            margin: 0;
            color: var(--cafe);
            font-family: 'Fredoka', sans-serif;
            font-size: 29px;
            line-height: 1.1;
            font-weight: 700;
        }

        .descripcion {
            margin: 11px 0 0;
            min-height: 52px;
            color: #7b7470;
            font-size: 15px;
            line-height: 1.55;
            font-weight: 600;
        }

        .parte-inferior {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            margin-top: 22px;
            padding-top: 18px;
            border-top: 1px solid #eee8e0;
        }

        .precio {
            color: var(--cafe);
            font-family: 'Fredoka', sans-serif;
            font-size: 27px;
            font-weight: 700;
            white-space: nowrap;
        }

        .precio small {
            color: var(--verde);
            font-family: 'Nunito', sans-serif;
            font-size: 12px;
            font-weight: 900;
        }

        .disponible {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 8px 12px;
            border-radius: 30px;
            background: var(--verde-claro);
            color: var(--verde-oscuro);
            font-size: 12px;
            font-weight: 900;
            white-space: nowrap;
        }

        .disponible::before {
            content: "";
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--verde);
        }

        .disponible.agotado {
            background: #fbe4e1;
            color: var(--rojo);
        }

        .disponible.agotado::before {
            background: var(--rojo);
        }

        .sin-productos {
            grid-column: 1 / -1;
            padding: 75px 30px;
            background: white;
            border-radius: 35px;
            text-align: center;
            box-shadow:
                0 12px 30px rgba(43, 20, 13, 0.08);
        }

        .sin-productos-icono {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 75px;
            height: 75px;
            margin: 0 auto 20px;
            border-radius: 50%;
            background: var(--verde-claro);
            color: var(--verde);
            font-size: 32px;
        }

        .sin-productos h2 {
            margin: 0 0 10px;
            color: var(--cafe);
            font-family: 'Fredoka', sans-serif;
            font-size: 32px;
        }

        .sin-productos p {
            margin: 0;
            color: #777;
            font-size: 17px;
            font-weight: 600;
        }

        .frase-final {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            margin-top: 55px;
            color: var(--cafe);
            font-family: 'Fredoka', sans-serif;
            font-size: 22px;
            text-align: center;
        }

        .frase-final::before,
        .frase-final::after {
            content: "";
            width: 50px;
            height: 2px;
            border-radius: 10px;
            background: var(--crema);
        }

        @media (max-width: 800px) {

            .menu-productos {
                width: 92%;
                padding-top: 110px;
                padding-bottom: 60px;
            }

            .cabecera-menu {
                grid-template-columns: 1fr;
                padding: 40px 30px;
                border-radius: 32px;
            }

            .sello-menu {
                width: 105px;
                height: 105px;
                margin-top: 5px;
            }

            .sello-menu strong {
                font-size: 27px;
            }

            .titulo-menu {
                font-size: 65px;
            }

            .descripcion-menu {
                font-size: 16px;
            }

            .barra-productos {
                align-items: flex-start;
                flex-direction: column;
            }

            .barra-productos h2 {
                font-size: 30px;
            }

            .productos {
                grid-template-columns: repeat(
                    auto-fit,
                    minmax(250px, 1fr)
                );
                gap: 22px;
            }

        }

        @media (max-width: 520px) {

            body {
                overflow-x: hidden;
            }

            .menu-productos {
                padding-top: 90px;
            }

            .cabecera-menu {
                padding: 35px 23px;
            }

            .titulo-menu {
                font-size: 57px;
                letter-spacing: -2px;
            }

            .descripcion-menu {
                margin-top: 18px;
            }

            .sello-menu {
                width: 90px;
                height: 90px;
            }

            .sello-menu strong {
                font-size: 23px;
            }

            .sello-menu small {
                font-size: 9px;
            }

            .productos {
                grid-template-columns: 1fr;
            }

            .imagen {
                height: 290px;
            }

            .informacion {
                padding: 22px;
            }

            .parte-inferior {
                align-items: flex-start;
                flex-direction: column;
            }

            .disponible {
                align-self: flex-start;
            }

            .frase-final {
                font-size: 18px;
            }

        }

    </style>

</head>

<body>

<nav>

    <?php include("nav.php"); ?>

</nav>

<section class="menu-productos">

    <header class="cabecera-menu">

        <div class="cabecera-texto">

            <p class="mini-titulo">
                ORGANIC ZONE
            </p>

            <h1 class="titulo-menu">
                Nuestro<br>
                <span>Menú.</span>
            </h1>

            <p class="descripcion-menu">
                Sabores naturales, ingredientes seleccionados
                y productos preparados para disfrutar algo
                realmente delicioso.
            </p>

        </div>

        <div class="sello-menu">

            <strong>100%</strong>

            <small>
                NATURAL
            </small>

        </div>

    </header>

    <div class="barra-productos">

        <div>

            <h2>
                Elige tus favoritos
            </h2>

            <p>
                Descubre todo lo que tenemos preparado para ti.
            </p>

        </div>

        <?php if ($resultado->num_rows > 0): ?>

            <span class="cantidad-productos">

                <?= $resultado->num_rows ?>

                productos

            </span>

        <?php endif; ?>

    </div>

    <div class="productos">

        <?php if ($resultado->num_rows > 0): ?>

            <?php while ($producto = $resultado->fetch_assoc()): ?>

                <?php

                $id = (int) $producto['id'];

                $imagen = "Imagenes/predeterminado.png";

                $extensiones = [
                    "jpg",
                    "jpeg",
                    "png",
                    "gif",
                    "webp"
                ];

                foreach ($extensiones as $extension) {

                    $ruta = "Imagenes/P-" . $id . "." . $extension;

                    if (file_exists($ruta)) {

                        $imagen = $ruta;

                        break;

                    }

                }

                $hayStock = (int) $producto['stock'] > 0;

                ?>

                <article class="carta">

                    <div class="imagen">

                        <span class="etiqueta-producto">
                            ORGANIC ZONE
                        </span>

                        <img
                            src="<?= htmlspecialchars($imagen) ?>"
                            alt="<?= htmlspecialchars($producto['nombre']) ?>"
                        >

                    </div>

                    <div class="informacion">

                        <h2>
                            <?= htmlspecialchars($producto['nombre']) ?>
                        </h2>

                        <p class="descripcion">
                            <?= htmlspecialchars($producto['descripcion']) ?>
                        </p>

                        <div class="parte-inferior">

                            <span class="precio">

                                <small>Bs.</small>

                                <?= number_format(
                                    (float) $producto['precio'],
                                    0,
                                    ',',
                                    '.'
                                ) ?>

                            </span>

                            <?php if ($hayStock): ?>

                                <span class="disponible">
                                    Disponible
                                </span>

                            <?php else: ?>

                                <span class="disponible agotado">
                                    Agotado
                                </span>

                            <?php endif; ?>

                        </div>

                    </div>

                </article>

            <?php endwhile; ?>

        <?php else: ?>

            <div class="sin-productos">

                <div class="sin-productos-icono">
                    ☘
                </div>

                <h2>
                    No hay productos disponibles
                </h2>

                <p>
                    Pronto tendremos nuevos productos para ti.
                </p>

            </div>

        <?php endif; ?>

    </div>

    <?php if ($resultado->num_rows > 0): ?>

        <div class="frase-final">
            Fresco · Natural · Delicioso
        </div>

    <?php endif; ?>

</section>

<?php include("footer.php"); ?>

</body>

</html>

<?php

$conexion->close();

?>