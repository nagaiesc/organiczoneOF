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

/* Guardamos los productos en un arreglo (compatible con PHP antiguo) */
$productos = array();

while ($fila = $resultado->fetch_assoc()) {
    $productos[] = $fila;
}

$totalProductos = count($productos);


/* =========================================================
   INFORMACIÓN NUTRICIONAL POR PRODUCTO
   ---------------------------------------------------------
   "claves" son palabras que se buscan dentro del NOMBRE del
   producto (da igual mayúsculas o tildes). El primer grupo
   que coincida es el que se usa. Para cambiar a qué producto
   corresponde cada grupo, solo edita sus "claves" y los
   valores de abajo.

   OJO: los valores de papas y de Beyond son ESTIMACIONES de
   referencia. Cámbialos por los datos reales de tu cocina.
   ========================================================= */

$nutricion = array(

    array(
        'claves'        => array('doble', 'double'),
        'porcion'       => '1 unidad (aprox. 380 g)',
        'kcal'          => 730,
        'proteinas'     => 45,
        'carbohidratos' => 42,
        'azucares'      => 8,
        'grasas'        => 42,
        'saturadas'     => 17,
        'fibra'         => 3,
        'sodio'         => 1150
    ),

    array(
        'claves'        => array('vegana', 'vegano', 'vegetariana', 'veggie', 'lenteja', 'garbanzo', 'beyond'),
        'porcion'       => '1 unidad (aprox. 270 g)',
        'kcal'          => 420,
        'proteinas'     => 18,
        'carbohidratos' => 52,
        'azucares'      => 8,
        'grasas'        => 16,
        'saturadas'     => 3,
        'fibra'         => 9,
        'sodio'         => 640
    ),

    array(
        'claves'        => array('clasica', 'clasico', 'simple', 'hamburguesa', 'burger', 'burguer'),
        'porcion'       => '1 unidad (aprox. 260 g)',
        'kcal'          => 520,
        'proteinas'     => 30,
        'carbohidratos' => 40,
        'azucares'      => 7,
        'grasas'        => 26,
        'saturadas'     => 10,
        'fibra'         => 3,
        'sodio'         => 880
    ),

    array(
        'claves'        => array('fries', 'papas', 'papa'),
        'porcion'       => '1 porción (aprox. 150 g)',
        'kcal'          => 410,
        'proteinas'     => 5,
        'carbohidratos' => 48,
        'azucares'      => 1,
        'grasas'        => 22,
        'saturadas'     => 3,
        'fibra'         => 5,
        'sodio'         => 520
    )

);

/* Valor diario de referencia (dieta de 2.000 kcal) */
$valorDiario = array(
    'proteinas'     => 50,
    'carbohidratos' => 275,
    'grasas'        => 78,
    'saturadas'     => 20,
    'fibra'         => 28,
    'sodio'         => 2300
);

/* Filas de cada tabla: etiqueta, clave, unidad, ¿es subfila? */
$filasNutricion = array(
    array('Proteínas',              'proteinas',     'g',  false),
    array('Carbohidratos',          'carbohidratos', 'g',  false),
    array('De los cuales azúcares', 'azucares',      'g',  true),
    array('Grasas totales',         'grasas',        'g',  false),
    array('Saturadas',              'saturadas',     'g',  true),
    array('Fibra',                  'fibra',         'g',  false),
    array('Sodio',                  'sodio',         'mg', false)
);

/**
 * Escapa texto para mostrarlo seguro en HTML.
 *
 * @param string $texto
 * @return string
 */
function h($texto)
{
    return htmlspecialchars((string) $texto, ENT_QUOTES, 'UTF-8');
}

/**
 * Pasa a minúsculas y quita tildes para comparar nombres.
 *
 * @param string $texto
 * @return string
 */
function normalizarNombre($texto)
{
    $texto = strtr((string) $texto, array(
        'Á' => 'a', 'É' => 'e', 'Í' => 'i', 'Ó' => 'o', 'Ú' => 'u', 'Ñ' => 'n',
        'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u', 'ü' => 'u', 'ñ' => 'n'
    ));

    return strtolower(trim($texto));
}

/**
 * Busca el grupo nutricional que corresponde al nombre del producto.
 *
 * @param string $nombre
 * @param array  $nutricion
 * @return array|null
 */
function buscarNutricion($nombre, $nutricion)
{
    $nombre = normalizarNombre($nombre);

    foreach ($nutricion as $item) {

        foreach ($item['claves'] as $clave) {

            if (strpos($nombre, normalizarNombre($clave)) !== false) {
                return $item;
            }

        }

    }

    return null;
}

/**
 * Formatea un número (sin decimales si es entero).
 *
 * @param int|float $valor
 * @return string
 */
function formatoNumero($valor)
{
    $decimales = ($valor == (int) $valor) ? 0 : 1;

    return number_format((float) $valor, $decimales, ',', '.');
}

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Menú | Organic Zone</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Nunito:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet"
    >

    <style>

        :root {
            --verde: #0BA84A;
            --verde-oscuro: #087A36;
            --verde-profundo: #064D22;
            --verde-suave: #E5F7EA;

            --cafe: #2B140D;
            --cafe-2: #3A1E13;

            --crema: #FCD09F;
            --amarillo: #FFD57A;

            --fondo: #F5EEE3;
            --blanco: #FFFFFF;

            --gris: #766E69;

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
            min-height: 100vh;
            overflow-x: hidden;
            background:#fff4e2;
            color: var(--cafe);
            font-family: 'Nunito', sans-serif;
        }

        body::before {
            content: "";
            position: fixed;
            width: 420px;
            height: 420px;
            left: -230px;
            bottom: -180px;
            border-radius: 50%;
            background: rgba(11,168,74,.07);
            pointer-events: none;
            z-index: -1;
        }

        body::after {
            content: "";
            position: fixed;
            width: 300px;
            height: 300px;
            right: -170px;
            top: 42%;
            border-radius: 50%;
            background: rgba(252,208,159,.15);
            pointer-events: none;
            z-index: -1;
        }

        nav {
            position: relative;
            z-index: 100;
        }

        .menu-productos {
            width: min(1480px, 94%);
            margin: auto;
            padding: 145px 0 100px;
        }

        /* =====================================================
           HERO
           ===================================================== */

        .hero-menu {
            position: relative;
            min-height: 500px;
            display: grid;
            grid-template-columns: 1.1fr .9fr;
            align-items: center;
            overflow: hidden;
            margin-bottom: 70px;
            padding: 65px 70px;
            border-radius: 55px;
            background:
                linear-gradient(
                    125deg,
                    #ffffff 0%,
                    #ffffff 53%,
                    #eff9f1 100%
                );
            box-shadow:
                0 25px 70px rgba(43,20,13,.11);
        }

        .hero-menu::before {
            content: "";
            position: absolute;
            width: 520px;
            height: 520px;
            right: -150px;
            top: -180px;
            border-radius: 50%;
            background: var(--crema);
            opacity: .30;
        }

        .hero-menu::after {
            content: "";
            position: absolute;
            width: 280px;
            height: 280px;
            right: 300px;
            bottom: -180px;
            border-radius: 50%;
            background: var(--verde);
            opacity: .08;
        }

        .hero-contenido {
            position: relative;
            z-index: 5;
        }

        .hero-tag {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 22px;
            padding: 10px 17px;
            border-radius: 100px;
            background: var(--cafe-2);
            color: var(--amarillo);
            font-size: 12px;
            font-weight: 900;
            letter-spacing: 1.5px;
        }

        .hero-tag span {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--amarillo);
            box-shadow: 0 0 0 5px rgba(11,168,74,.10);
        }

        .hero-titulo {
            margin: 0;
            max-width: 780px;
            font-family: 'Fredoka', sans-serif;
            font-size: clamp(70px, 9vw, 128px);
            line-height: .82;
            letter-spacing: -5px;
            font-weight: 700;
            color: var(--cafe);
        }

        .hero-titulo .verde {
            color: var(--verde);
        }

        .hero-subtitulo {
            max-width: 610px;
            margin: 30px 0 0;
            color: var(--gris);
            font-size: 18px;
            line-height: 1.65;
            font-weight: 700;
        }

        .hero-sello {
            position: absolute;
            z-index: 7;
            top: 50px;
            right: 55px;
            width: 125px;
            height: 125px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: var(--verde);
            color: white;
            transform: rotate(8deg);
            box-shadow:
                0 20px 35px rgba(11,168,74,.24);
        }

        .hero-sello strong {
            font-family: 'Fredoka', sans-serif;
            font-size: 32px;
            line-height: .9;
        }

        .hero-sello small {
            margin-top: 8px;
            font-size: 9px;
            font-weight: 900;
            letter-spacing: 1.5px;
        }

        .hero-decoracion {
            position: relative;
            z-index: 4;
            height: 100%;
            min-height: 360px;
        }

        .circulo-verde {
            position: absolute;
            width: 390px;
            height: 390px;
            right: 35px;
            top: 50%;
            transform: translateY(-50%);
            border-radius: 50%;
            background: var(--verde);
        }

        .circulo-crema {
            position: absolute;
            width: 245px;
            height: 245px;
            right: 5px;
            top: 25px;
            border-radius: 50%;
            background: var(--crema);
            opacity: .75;
        }

        .hero-burger {
            position: absolute;
            z-index: 6;
            width: 600px;
            right: -70px;
            top: 50%;
            transform: translateY(-50%) rotate(-6deg);
            filter: drop-shadow(0 26px 36px rgba(43, 20, 13, .32));
            transition: transform .4s ease, filter .4s ease;
        }

        .hero-menu:hover .hero-burger {
            transform: translateY(-55%) rotate(-3deg) scale(1.15);
            filter: drop-shadow(0 38px 48px rgba(43, 20, 13, .42));
        }

        .forma-hoja {
            position: absolute;
            width: 125px;
            height: 65px;
            border-radius: 100% 0 100% 0;
            background: var(--cafe);
            transform: rotate(-28deg);
            opacity: .95;
        }

        .hoja-1 {
            right: 345px;
            top: 35px;
        }

        .hoja-2 {
            right: 20px;
            bottom: 45px;
            transform: rotate(35deg);
            background: var(--verde-oscuro);
        }

        .mini-circulo {
            position: absolute;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: var(--amarillo);
        }

        .mini-1 {
            right: 405px;
            top: 105px;
        }

        .mini-2 {
            right: 80px;
            bottom: 30px;
        }

        .hero-burbuja {
            position: absolute;
            z-index: 8;
            right: 185px;
            bottom: 55px;
            padding: 14px 20px;
            border-radius: 18px;
            background: white;
            color: var(--cafe);
            font-family: 'Fredoka', sans-serif;
            font-size: 18px;
            transform: rotate(-5deg);
            box-shadow:
                0 15px 30px rgba(43,20,13,.12);
        }

        .hero-burbuja::after {
            content: "";
            position: absolute;
            right: 15px;
            bottom: -12px;
            width: 20px;
            height: 20px;
            background: white;
            clip-path: polygon(0 0,100% 0,100% 100%);
        }

        /* =====================================================
           LISTA DE PRODUCTOS
           ===================================================== */

        .seccion-productos {
            position: relative;
        }

        .encabezado-productos {
            display: flex;
            justify-content: space-between;
            align-items: end;
            gap: 25px;
            margin-bottom: 32px;
        }

        .encabezado-productos-texto small {
            display: block;
            margin-bottom: 7px;
            color: var(--verde);
            font-size: 11px;
            font-weight: 900;
            letter-spacing: 2px;
        }

        .encabezado-productos h2 {
            margin: 0;
            font-family: 'Fredoka', sans-serif;
            font-size: clamp(35px, 4vw, 55px);
            line-height: .95;
            color: var(--cafe);
        }

        .encabezado-productos p {
            margin: 10px 0 0;
            color: #817872;
            font-size: 15px;
            font-weight: 700;
        }

        .cantidad-productos {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            padding: 13px 19px;
            border-radius: 100px;
            background: var(--cafe);
            color: white;
            font-size: 12px;
            font-weight: 900;
            white-space: nowrap;
            box-shadow: 0 10px 25px rgba(43,20,13,.13);
        }

        .cantidad-productos::before {
            content: "";
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--verde);
        }

        /* align-items:start => cada tarjeta crece sola al desplegar */
        .productos {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            align-items: start;
            gap: 28px;
        }

        .carta {
            position: relative;
            overflow: hidden;
            background: white;
            border-radius: 38px;
            border: 1px solid rgba(43,20,13,.055);
            box-shadow:
                0 14px 38px rgba(43,20,13,.08);
            transition:
                transform .35s ease,
                box-shadow .35s ease;
        }

        .carta:hover {
            transform: translateY(-12px);
            box-shadow:
                0 28px 55px rgba(43,20,13,.15);
        }

        .imagen {
            position: relative;
            aspect-ratio: 1587 / 2245;
            overflow: hidden;
            background:
                radial-gradient(
                    circle at 50% 45%,
                    #ffffff 0%,
                    #edf7ef 60%,
                    #dcefe1 100%
                );
        }

        .imagen::before {
            content: "";
            position: absolute;
            z-index: 1;
            width: 250px;
            height: 250px;
            left: 50%;
            top: 50%;
            transform: translate(-50%,-50%);
            border-radius: 50%;
            background: rgba(11,168,74,.10);
        }

        .imagen::after {
            content: "";
            position: absolute;
            z-index: 2;
            inset: 0;
            background:
                linear-gradient(
                    to bottom,
                    transparent 70%,
                    rgba(43,20,13,.10)
                );
            pointer-events: none;
        }

        .imagen img {
            position: relative;
            z-index: 3;
            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;
            transition:
                transform .6s cubic-bezier(.2,.8,.2,1);
        }

        .carta:hover .imagen img {
            transform: scale(1.08);
        }

        .etiqueta-producto {
            position: absolute;
            z-index: 10;
            top: 18px;
            left: 18px;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 13px;
            border-radius: 100px;
            background: rgba(255,255,255,.94);
            color: var(--cafe);
            font-size: 10px;
            font-weight: 900;
            letter-spacing: .8px;
            box-shadow:
                0 8px 20px rgba(43,20,13,.10);
            backdrop-filter: blur(8px);
        }

        .etiqueta-producto::before {
            content: "";
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--verde);
        }

        .numero-producto {
            position: absolute;
            z-index: 8;
            right: 18px;
            top: 18px;
            width: 39px;
            height: 39px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: var(--cafe);
            color: white;
            font-family: 'Fredoka', sans-serif;
            font-size: 14px;
        }

        .informacion {
            position: relative;
            padding: 27px 27px 28px;
        }

        .informacion h2 {
            margin: 0;
            color: var(--cafe);
            font-family: 'Fredoka', sans-serif;
            font-size: 31px;
            line-height: 1;
            font-weight: 700;
        }

        .descripcion {
            margin: 13px 0 0;
            min-height: 52px;
            color: #7d746f;
            font-size: 14px;
            line-height: 1.55;
            font-weight: 700;
        }

        .parte-inferior {
            display: flex;
            flex-wrap: wrap;
            align-items: flex-end;
            justify-content: space-between;
            gap: 14px 15px;
            margin-top: 24px;
            padding-top: 18px;
            border-top: 1px dashed #e8e0d7;
        }

        .precio-contenedor {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .precio-label {
            color: #99908a;
            font-size: 11px;
            font-weight: 900;
            letter-spacing: 1.2px;
            text-transform: uppercase;
        }

        /* Precio al triple de tamaño (antes 34px) */
        .precio {
            color: var(--cafe);
            font-family: 'Fredoka', sans-serif;
            font-size: 102px;
            line-height: .85;
            letter-spacing: -3px;
            font-weight: 700;
        }

        .precio small {
            display: inline-block;
            vertical-align: top;
            margin: 8px 6px 0 0;
            color: var(--verde);
            font-family: 'Nunito', sans-serif;
            font-size: 39px;
            line-height: 1;
            letter-spacing: 0;
            font-weight: 900;
        }

        .disponible {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 13px;
            border-radius: 100px;
            background: var(--verde-suave);
            color: var(--verde-oscuro);
            font-size: 11px;
            font-weight: 900;
            white-space: nowrap;
        }

        .disponible::before {
            content: "";
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--verde);
            box-shadow: 0 0 0 4px rgba(11,168,74,.10);
        }

        .disponible.agotado {
            background: #fbe5e2;
            color: var(--rojo);
        }

        .disponible.agotado::before {
            background: var(--rojo);
            box-shadow: 0 0 0 4px rgba(214,40,40,.10);
        }

        /* =====================================================
           BOTÓN + PANEL NUTRICIONAL (dentro de cada tarjeta)
           Botón: amarillo con café  |  Panel: café con crema
           ===================================================== */

        .btn-nutri {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            margin: 22px 0 0;
            padding: 8px 8px 8px 24px;
            border: 0;
            border-radius: 100px;
            background: var(--amarillo);
            color: var(--cafe);
            font-family: 'Nunito', sans-serif;
            font-size: 14px;
            font-weight: 900;
            text-align: left;
            cursor: pointer;
            box-shadow: 0 10px 22px rgba(255,213,122,.55);
            transition:
                transform .25s ease,
                box-shadow .25s ease,
                background .25s ease;
        }

        .btn-nutri:hover {
            transform: translateY(-3px);
            background: #FFCB5C;
            box-shadow: 0 14px 28px rgba(255,203,92,.6);
        }

        .btn-nutri:focus {
            outline: 3px solid var(--cafe);
            outline-offset: 3px;
        }

        .btn-nutri-icono {
            flex: 0 0 auto;
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: var(--cafe);
            color: var(--amarillo);
        }

        .btn-nutri-icono svg {
            transition: transform .4s ease;
        }

        .btn-nutri.abierto .btn-nutri-icono svg {
            transform: rotate(180deg);
        }

        .nutri-desplegable {
            max-height: 0;
            overflow: hidden;
            transition: max-height .5s ease;
        }

        .nutri-contenido {
            position: relative;
            overflow: hidden;
            margin-top: 16px;
            padding: 26px 24px 22px;
            border-radius: 28px;
            background: var(--cafe);
            color: var(--crema);
        }

        .nutri-contenido::before {
            content: "";
            position: absolute;
            width: 190px;
            height: 190px;
            right: -70px;
            top: -90px;
            border-radius: 50%;
            background: var(--amarillo);
            opacity: .14;
            pointer-events: none;
        }

        .nutri-contenido > * {
            position: relative;
        }

        .nutri-etiqueta {
            display: block;
            color: var(--amarillo);
            font-size: 11px;
            font-weight: 900;
            letter-spacing: 2px;
        }

        .nutri-porcion {
            display: block;
            margin-top: 6px;
            color: var(--crema);
            opacity: .75;
            font-size: 13px;
            font-weight: 800;
        }

        .nutri-kcal {
            display: flex;
            align-items: baseline;
            gap: 10px;
            margin-top: 18px;
        }

        .nutri-kcal strong {
            color: var(--amarillo);
            font-family: 'Fredoka', sans-serif;
            font-size: 78px;
            line-height: .9;
            letter-spacing: -2px;
            font-weight: 700;
        }

        .nutri-kcal span {
            color: var(--crema);
            font-size: 19px;
            font-weight: 900;
        }

        .nutri-barra-titulo {
            display: block;
            margin-top: 20px;
            color: var(--crema);
            opacity: .7;
            font-size: 10px;
            font-weight: 900;
            letter-spacing: 1.3px;
            text-transform: uppercase;
        }

        .nutri-barra {
            display: flex;
            height: 14px;
            margin-top: 9px;
            overflow: hidden;
            border-radius: 100px;
            background: rgba(252,208,159,.18);
        }

        .nutri-barra span {
            display: block;
            height: 100%;
        }

        .seg-proteinas     { background: var(--verde); }
        .seg-carbohidratos { background: var(--amarillo); }
        .seg-grasas        { background: var(--crema); }

        .nutri-leyenda {
            display: flex;
            flex-wrap: wrap;
            gap: 6px 16px;
            margin: 12px 0 0;
            padding: 0;
            list-style: none;
            color: var(--crema);
            font-size: 12px;
            font-weight: 800;
        }

        .nutri-leyenda li {
            display: inline-flex;
            align-items: center;
            gap: 7px;
        }

        .nutri-leyenda li::before {
            content: "";
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }

        .nutri-leyenda .l-proteinas::before     { background: var(--verde); }
        .nutri-leyenda .l-carbohidratos::before { background: var(--amarillo); }
        .nutri-leyenda .l-grasas::before        { background: var(--crema); }

        .nutri-filas {
            margin: 22px 0 0;
            padding: 0;
            list-style: none;
        }

        .nutri-fila {
            display: grid;
            grid-template-columns: 1fr auto 54px;
            align-items: baseline;
            gap: 10px;
            padding: 11px 0;
            border-top: 1px dashed rgba(252,208,159,.30);
        }

        .nutri-fila.cabecera-filas {
            padding: 0 0 9px;
            border-top: 0;
            color: var(--crema);
            opacity: .7;
            font-size: 10px;
            font-weight: 900;
            letter-spacing: 1.2px;
            text-transform: uppercase;
        }

        .nutri-fila.cabecera-filas span:last-child {
            text-align: right;
        }

        .nutri-nombre {
            color: var(--crema);
            font-size: 15px;
            font-weight: 800;
        }

        .nutri-valor {
            color: var(--amarillo);
            font-family: 'Fredoka', sans-serif;
            font-size: 23px;
            line-height: 1;
            font-weight: 600;
        }

        .nutri-valor small {
            margin-left: 3px;
            color: var(--crema);
            font-family: 'Nunito', sans-serif;
            font-size: 13px;
            font-weight: 900;
        }

        .nutri-vd {
            justify-self: end;
            padding: 4px 9px;
            border-radius: 100px;
            background: var(--amarillo);
            color: var(--cafe);
            font-size: 11px;
            font-weight: 900;
        }

        .nutri-vd:empty {
            padding: 0;
            background: none;
        }

        .nutri-fila.sub {
            padding: 8px 0;
        }

        .nutri-fila.sub .nutri-nombre {
            padding-left: 18px;
            font-size: 13px;
            opacity: .8;
        }

        .nutri-fila.sub .nutri-valor {
            font-size: 18px;
        }

        .nutri-vacio {
            margin: 0;
            color: var(--crema);
            font-size: 14px;
            line-height: 1.55;
            font-weight: 700;
        }

        .nutri-nota {
            margin: 18px 0 0;
            color: var(--crema);
            opacity: .65;
            font-size: 11.5px;
            line-height: 1.5;
            font-weight: 700;
        }

        /* =====================================================
           FRANJA FINAL / SIN PRODUCTOS
           ===================================================== */

        .franja-final {
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 30px;
            margin-top: 75px;
            padding: 35px 45px;
            border-radius: 35px;
            background: var(--cafe);
            color: white;
        }

        .franja-final::before {
            content: "";
            position: absolute;
            width: 220px;
            height: 220px;
            right: -70px;
            top: -120px;
            border-radius: 50%;
            background: var(--verde);
            opacity: .8;
        }

        .franja-final::after {
            content: "";
            position: absolute;
            width: 100px;
            height: 100px;
            left: 45%;
            bottom: -70px;
            border-radius: 50%;
            background: var(--crema);
            opacity: .4;
        }

        .franja-final strong {
            position: relative;
            z-index: 2;
            font-family: 'Fredoka', sans-serif;
            font-size: clamp(26px, 3vw, 40px);
        }

        .franja-final span {
            position: relative;
            z-index: 2;
            color: var(--crema);
            font-size: 13px;
            font-weight: 900;
            letter-spacing: 1px;
        }

        .sin-productos {
            grid-column: 1 / -1;
            padding: 90px 30px;
            border-radius: 40px;
            background: white;
            text-align: center;
            box-shadow:
                0 18px 40px rgba(43,20,13,.08);
        }

        .sin-productos-icono {
            width: 85px;
            height: 85px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 22px;
            border-radius: 50%;
            background: var(--verde-suave);
            color: var(--verde);
            font-size: 38px;
        }

        .sin-productos h2 {
            margin: 0 0 10px;
            color: var(--cafe);
            font-family: 'Fredoka', sans-serif;
            font-size: 34px;
        }

        .sin-productos p {
            margin: 0;
            color: #777;
            font-size: 16px;
            font-weight: 700;
        }

        /* =====================================================
           RESPONSIVE
           ===================================================== */

        @media (max-width: 1100px) {

            .productos {
                grid-template-columns: repeat(2, minmax(0,1fr));
            }

            .precio {
                font-size: 96px;
            }

            .precio small {
                font-size: 36px;
            }

            /* ---- Hero: texto arriba, hamburguesa abajo y centrada ---- */

            .hero-menu {
                grid-template-columns: 1fr;
                min-height: 0;
                padding: 55px 50px 0;
            }

            .hero-contenido {
                max-width: 650px;
            }

            .hero-decoracion {
                height: auto;
                min-height: 320px;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 30px 0 44px;
            }

            .hero-burger {
                position: relative;
                flex: 0 0 auto;
                width: min(560px, 100%);
                height: auto;
                right: auto;
                top: auto;
                transform: rotate(-6deg);
            }

            .hero-menu:hover .hero-burger {
                transform: rotate(-3deg) scale(1.05);
            }

            .circulo-verde {
                width: min(380px, 70%);
                height: auto;
                aspect-ratio: 1;
                right: auto;
                left: 50%;
                top: 50%;
                transform: translate(-50%, -50%);
            }

            .circulo-crema {
                width: min(210px, 40%);
                height: auto;
                aspect-ratio: 1;
                right: auto;
                left: 58%;
                top: 14px;
            }

            .hoja-1 {
                right: auto;
                left: 10%;
                top: 30px;
            }

            .hoja-2 {
                right: 8%;
                top: 26px;
                bottom: auto;
            }

            .mini-1 {
                right: auto;
                left: 20%;
                top: 125px;
            }

            .mini-2 {
                right: 24%;
                bottom: 24px;
            }

            .hero-burbuja {
                right: auto;
                left: 6%;
                bottom: 40px;
            }

            .hero-sello {
                top: auto;
                right: 40px;
                bottom: 40px;
            }

        }

        @media (max-width: 800px) {

            .menu-productos {
                width: 92%;
                padding-top: 110px;
                padding-bottom: 65px;
            }

            .hero-menu {
                padding: 45px 32px 0;
                border-radius: 35px;
            }

            .hero-titulo {
                font-size: clamp(64px, 15vw, 90px);
                letter-spacing: -3px;
            }

            .hero-subtitulo {
                font-size: 16px;
                max-width: 520px;
            }

            .hero-decoracion {
                min-height: 300px;
                padding: 26px 0 40px;
            }

            .hero-burger {
                width: min(480px, 108%);
            }

            .circulo-verde {
                width: min(320px, 72%);
            }

            .hero-sello {
                width: 100px;
                height: 100px;
                right: 26px;
                bottom: 30px;
            }

            .hero-sello strong {
                font-size: 27px;
            }

            .hero-burbuja {
                bottom: 34px;
            }

            .encabezado-productos {
                align-items: flex-start;
                flex-direction: column;
            }

            .productos {
                grid-template-columns: 1fr 1fr;
                gap: 20px;
            }

            .informacion {
                padding: 22px;
            }

            .informacion h2 {
                font-size: 27px;
            }

            .precio {
                font-size: 66px;
                letter-spacing: -2px;
            }

            .precio small {
                margin-top: 5px;
                font-size: 24px;
            }

            .btn-nutri {
                font-size: 13px;
                padding-left: 20px;
            }

            .nutri-contenido {
                padding: 22px 18px 18px;
            }

            .nutri-kcal strong {
                font-size: 64px;
            }

        }

        @media (max-width: 560px) {

            .menu-productos {
                width: 91%;
                padding-top: 90px;
            }

            .hero-menu {
                padding: 36px 24px 0;
                border-radius: 30px;
            }

            .hero-tag {
                font-size: 10px;
            }

            .hero-titulo {
                font-size: 61px;
                line-height: .86;
                letter-spacing: -2px;
            }

            .hero-subtitulo {
                margin-top: 22px;
                font-size: 15px;
                line-height: 1.55;
            }

            .hero-decoracion {
                min-height: 270px;
                padding: 22px 0 36px;
            }

            .hero-burger {
                width: 112%;
            }

            .circulo-verde {
                width: min(250px, 80%);
            }

            .forma-hoja {
                width: 90px;
                height: 48px;
            }

            .mini-1 {
                top: 105px;
            }

            .hero-sello {
                width: 84px;
                height: 84px;
                right: 14px;
                bottom: 24px;
            }

            .hero-sello strong {
                font-size: 23px;
            }

            .hero-sello small {
                font-size: 7px;
            }

            .hero-burbuja {
                left: 4%;
                bottom: 28px;
                font-size: 15px;
            }

            .encabezado-productos h2 {
                font-size: 39px;
            }

            .productos {
                grid-template-columns: 1fr;
            }

            .informacion h2 {
                font-size: 30px;
            }

            .precio {
                font-size: 88px;
            }

            .precio small {
                margin-top: 7px;
                font-size: 32px;
            }

            .btn-nutri {
                font-size: 14px;
            }

            .franja-final {
                align-items: flex-start;
                flex-direction: column;
                padding: 30px;
                margin-top: 55px;
            }

        }

        @media (prefers-reduced-motion: reduce) {

            html {
                scroll-behavior: auto;
            }

            .nutri-desplegable,
            .btn-nutri,
            .btn-nutri-icono svg {
                transition: none;
            }

        }

    </style>

</head>

<body>

<nav>

    <?php include("nav.php"); ?>

</nav>

<main class="menu-productos">

    <section class="hero-menu">

        <div class="hero-contenido">

            <div class="hero-tag">
                <span></span>
                SABOR REAL · INGREDIENTES REALES
            </div>

            <h1 class="hero-titulo">
                Come<br>
                <span class="verde">bien.</span>
                <br>
                Siéntete<br>
                mejor.
            </h1>

            <p class="hero-subtitulo">
                Descubre el menú de Organic Zone: productos preparados
                para disfrutar sabores increíbles, ingredientes seleccionados
                y una experiencia diferente.
            </p>

        </div>

        <div class="hero-decoracion">

            <div class="circulo-verde"></div>
            <div class="circulo-crema"></div>

            <div class="forma-hoja hoja-1"></div>
            <div class="forma-hoja hoja-2"></div>

            <div class="mini-circulo mini-1"></div>
            <div class="mini-circulo mini-2"></div>

            <img
                class="hero-burger"
                src="ozburger.png"
                alt="Hamburguesa Organic Zone"
                onerror="this.style.display='none';"
            >

            <div class="hero-burbuja">
                yummy!
            </div>

        </div>

        <div class="hero-sello">

            <strong>100%</strong>

            <small>
                ORGANIC
            </small>

        </div>

    </section>


    <section class="seccion-productos">

        <div class="encabezado-productos">

            <div class="encabezado-productos-texto">

                <small>
                    ORGANIC ZONE / MENÚ
                </small>

                <h2>
                    Elige tu favorito.
                </h2>

                <p>
                    Explora nuestros productos y encuentra algo delicioso.
                </p>

            </div>

            <?php if ($totalProductos > 0): ?>

                <span class="cantidad-productos">

                    <?php echo $totalProductos; ?>

                    productos

                </span>

            <?php endif; ?>

        </div>


        <div class="productos">

            <?php if ($totalProductos > 0): ?>

                <?php foreach ($productos as $indice => $producto): ?>

                    <?php

                    $numero = $indice + 1;

                    $id = (int) $producto['id'];

                    $imagen = "Imagenes/predeterminado.png";

                    $extensiones = array(
                        "jpg",
                        "jpeg",
                        "png",
                        "gif",
                        "webp"
                    );

                    foreach ($extensiones as $extension) {

                        $ruta = "Imagenes/P-" . $id . "." . $extension;

                        if (file_exists($ruta)) {

                            $imagen = $ruta;

                            break;

                        }

                    }

                    $hayStock = ((int) $producto['stock'] > 0);

                    /* Información nutricional de este producto */
                    $info = buscarNutricion($producto['nombre'], $nutricion);

                    /* Valores iniciales (evita el aviso "undefined variable") */
                    $pctProteinas     = 0;
                    $pctCarbohidratos = 0;
                    $pctGrasas        = 0;

                    if ($info) {

                        $kcalProteinas     = $info['proteinas'] * 4;
                        $kcalCarbohidratos = $info['carbohidratos'] * 4;
                        $kcalGrasas        = $info['grasas'] * 9;

                        $kcalTotal = $kcalProteinas + $kcalCarbohidratos + $kcalGrasas;

                        if ($kcalTotal < 1) {
                            $kcalTotal = 1;
                        }

                        $pctProteinas     = (int) round($kcalProteinas * 100 / $kcalTotal);
                        $pctCarbohidratos = (int) round($kcalCarbohidratos * 100 / $kcalTotal);
                        $pctGrasas        = 100 - $pctProteinas - $pctCarbohidratos;

                    }

                    ?>

                    <article class="carta">

                        <div class="imagen">

                            <span class="etiqueta-producto">
                                ORGANIC ZONE
                            </span>

                            <span class="numero-producto">
                                <?php echo str_pad($numero, 2, '0', STR_PAD_LEFT); ?>
                            </span>

                            <img
                                src="<?php echo h($imagen); ?>"
                                alt="<?php echo h($producto['nombre']); ?>"
                            >

                        </div>


                        <div class="informacion">

                            <h2>
                                <?php echo h($producto['nombre']); ?>
                            </h2>

                            <p class="descripcion">
                                <?php echo h($producto['descripcion']); ?>
                            </p>


                            <div class="parte-inferior">

                                <div class="precio-contenedor">

                                    <span class="precio-label">
                                        Precio
                                    </span>

                                    <span class="precio">

                                        <small>Bs.</small><?php echo number_format((float) $producto['precio'], 0, ',', '.'); ?>

                                    </span>

                                </div>


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


                            <!-- ===== Botón + información nutricional ===== -->

                            <button
                                type="button"
                                class="btn-nutri"
                                aria-expanded="false"
                                aria-controls="nutri-<?php echo $id; ?>"
                            >

                                <span class="btn-nutri-texto">Ver información nutricional</span>

                                <span class="btn-nutri-icono">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                         stroke="currentColor" stroke-width="3.2"
                                         stroke-linecap="round" stroke-linejoin="round"
                                         aria-hidden="true">
                                        <path d="M6 9l6 6 6-6"/>
                                    </svg>
                                </span>

                            </button>


                            <div class="nutri-desplegable" id="nutri-<?php echo $id; ?>" aria-hidden="true">

                                <div class="nutri-contenido">

                                    <?php if ($info): ?>

                                        <span class="nutri-etiqueta">INFORMACIÓN NUTRICIONAL</span>

                                        <span class="nutri-porcion">
                                            Porción: <?php echo h($info['porcion']); ?>
                                        </span>

                                        <div class="nutri-kcal">
                                            <strong><?php echo formatoNumero($info['kcal']); ?></strong>
                                            <span>kcal</span>
                                        </div>

                                        <span class="nutri-barra-titulo">
                                            De dónde vienen las calorías
                                        </span>

                                        <div class="nutri-barra">
                                            <span class="seg-proteinas"     style="width: <?php echo $pctProteinas; ?>%"></span>
                                            <span class="seg-carbohidratos" style="width: <?php echo $pctCarbohidratos; ?>%"></span>
                                            <span class="seg-grasas"        style="width: <?php echo $pctGrasas; ?>%"></span>
                                        </div>

                                        <ul class="nutri-leyenda">
                                            <li class="l-proteinas">Proteínas <?php echo $pctProteinas; ?>%</li>
                                            <li class="l-carbohidratos">Carbohidratos <?php echo $pctCarbohidratos; ?>%</li>
                                            <li class="l-grasas">Grasas <?php echo $pctGrasas; ?>%</li>
                                        </ul>

                                        <ul class="nutri-filas">

                                            <li class="nutri-fila cabecera-filas">
                                                <span>Por porción</span>
                                                <span></span>
                                                <span>% VD</span>
                                            </li>

                                            <?php foreach ($filasNutricion as $filaN): ?>

                                                <?php

                                                list($etiqueta, $clave, $unidad, $esSubfila) = $filaN;

                                                $valor = $info[$clave];

                                                $porcentajeVD = '';

                                                if (isset($valorDiario[$clave])) {
                                                    $porcentajeVD = round($valor * 100 / $valorDiario[$clave]) . '%';
                                                }

                                                ?>

                                                <li class="nutri-fila<?php echo $esSubfila ? ' sub' : ''; ?>">

                                                    <span class="nutri-nombre"><?php echo h($etiqueta); ?></span>

                                                    <span class="nutri-valor"><?php echo formatoNumero($valor); ?><small><?php echo $unidad; ?></small></span>

                                                    <span class="nutri-vd"><?php echo $porcentajeVD; ?></span>

                                                </li>

                                            <?php endforeach; ?>

                                        </ul>

                                        <p class="nutri-nota">
                                            Valores de referencia por porción; pueden variar según la preparación.
                                            % VD: porcentaje del valor diario en una dieta de 2.000 kcal.
                                        </p>

                                    <?php else: ?>

                                        <span class="nutri-etiqueta">INFORMACIÓN NUTRICIONAL</span>

                                        <p class="nutri-vacio" style="margin-top: 12px;">
                                            La información nutricional de este producto
                                            estará disponible muy pronto.
                                        </p>

                                    <?php endif; ?>

                                </div>

                            </div>

                        </div>

                    </article>

                <?php endforeach; ?>

            <?php else: ?>

                <div class="sin-productos">

                    <div class="sin-productos-icono">
                        ☘
                    </div>

                    <h2>
                        Todavía no hay productos
                    </h2>

                    <p>
                        Estamos preparando algo delicioso para ti.
                    </p>

                </div>

            <?php endif; ?>

        </div>


        <?php if ($totalProductos > 0): ?>

            <div class="franja-final">

                <strong>
                    Fresco. Natural. Delicioso.
                </strong>

                <span>
                    HECHO PARA DISFRUTAR
                </span>

            </div>

        <?php endif; ?>

    </section>

</main>

<?php include("footer.php"); ?>

<script>

    (function () {

        var botones = document.querySelectorAll('.btn-nutri');

        function alternar(boton) {

            var panel = document.getElementById(boton.getAttribute('aria-controls'));
            var texto = boton.querySelector('.btn-nutri-texto');
            var abierto = boton.getAttribute('aria-expanded') === 'true';

            if (abierto) {

                boton.setAttribute('aria-expanded', 'false');
                boton.classList.remove('abierto');
                panel.setAttribute('aria-hidden', 'true');
                panel.style.maxHeight = '0px';
                texto.textContent = 'Ver información nutricional';

            } else {

                boton.setAttribute('aria-expanded', 'true');
                boton.classList.add('abierto');
                panel.setAttribute('aria-hidden', 'false');
                panel.style.maxHeight = panel.scrollHeight + 'px';
                texto.textContent = 'Ocultar información nutricional';

                // Si el panel queda cortado abajo, lo acerca a la vista
                setTimeout(function () {

                    var caja = panel.getBoundingClientRect();

                    if (caja.bottom > window.innerHeight) {
                        window.scrollBy(0, caja.bottom - window.innerHeight + 24);
                    }

                }, 520);

            }

        }

        for (var i = 0; i < botones.length; i++) {

            botones[i].addEventListener('click', function () {
                alternar(this);
            });

        }

        // Si cambia el ancho de la pantalla, recalcula la altura de los paneles abiertos
        window.addEventListener('resize', function () {

            var abiertos = document.querySelectorAll('.btn-nutri.abierto');

            for (var j = 0; j < abiertos.length; j++) {

                var panel = document.getElementById(abiertos[j].getAttribute('aria-controls'));
                panel.style.maxHeight = panel.scrollHeight + 'px';

            }

        });

    })();

</script>

</body>

</html>

<?php

$conexion->close();

?>