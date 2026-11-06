<?php

session_start();

/* El menú público puede abrirse sin sesión; Oz Planning exige autenticación al pulsar su botón. */
$ozSesionActiva = !empty($_SESSION['rol']) && !empty($_SESSION['nombre']);

/* La conexión se conserva únicamente para leer el catálogo existente de productos.
   Los reportes NO crean tablas ni escriben en MySQL: se guardan en un TXT local. */
$conexion = new mysqli("localhost", "root", "", "organiczoneBD");
if ($conexion->connect_error) {
    die("No se pudo cargar el catálogo de Organic Zone. Comprueba que XAMPP y MySQL estén iniciados.");
}
$conexion->set_charset("utf8mb4");

/* Datos personales: se toman exclusivamente de la sesión autenticada.
   Para que CI y teléfono estén disponibles, el inicio de sesión debe guardarlos en $_SESSION. */
$ozUsuarioNombre = $ozSesionActiva ? trim((string)($_SESSION['nombre'] ?? $_SESSION['usuario'] ?? '')) : '';
$ozUsuarioRol = $ozSesionActiva ? trim((string)($_SESSION['rol'] ?? '')) : '';
$ozUsuarioCi = $ozSesionActiva ? trim((string)($_SESSION['CI'] ?? $_SESSION['ci'] ?? $_SESSION['carnet'] ?? $_SESSION['CI_usuario'] ?? '')) : '';
$ozUsuarioTelefono = $ozSesionActiva ? trim((string)($_SESSION['celular'] ?? $_SESSION['telefono'] ?? $_SESSION['telefono_usuario'] ?? $_SESSION['numero_telefono'] ?? '')) : '';

/* Si el login no guardó el teléfono en sesión, se recupera del perfil existente en usuarios. */
if ($ozSesionActiva && $ozUsuarioTelefono === '') {
    $ozBuscarUsuario = null;
    if ($ozUsuarioCi !== '') {
        $ozStmtUsuario = $conexion->prepare('SELECT celular FROM usuarios WHERE CI = ? LIMIT 1');
        if ($ozStmtUsuario) {
            $ozStmtUsuario->bind_param('s', $ozUsuarioCi);
            $ozStmtUsuario->execute();
            $ozBuscarUsuario = $ozStmtUsuario->get_result()->fetch_assoc();
            $ozStmtUsuario->close();
        }
    }
    if (!$ozBuscarUsuario && $ozUsuarioNombre !== '') {
        $ozStmtUsuario = $conexion->prepare('SELECT celular FROM usuarios WHERE nombre = ? LIMIT 1');
        if ($ozStmtUsuario) {
            $ozStmtUsuario->bind_param('s', $ozUsuarioNombre);
            $ozStmtUsuario->execute();
            $ozBuscarUsuario = $ozStmtUsuario->get_result()->fetch_assoc();
            $ozStmtUsuario->close();
        }
    }
    if (is_array($ozBuscarUsuario) && !empty($ozBuscarUsuario['celular'])) {
        $ozUsuarioTelefono = trim((string)$ozBuscarUsuario['celular']);
        $_SESSION['celular'] = $ozUsuarioTelefono;
    }
}

/* Archivo privado de reportes. El .htaccess impide que se descargue directamente desde el navegador. */
$ozDirectorioReportes = __DIR__ . DIRECTORY_SEPARATOR . 'datosOzPlanning';
if (!is_dir($ozDirectorioReportes) && !@mkdir($ozDirectorioReportes, 0750, true) && !is_dir($ozDirectorioReportes)) {
    die('No se pudo preparar el almacenamiento local de reportes. Revisa los permisos de la carpeta del proyecto.');
}
$ozArchivoReportes = $ozDirectorioReportes . DIRECTORY_SEPARATOR . 'oz_planning_reportes.txt';
$ozHtaccess = $ozDirectorioReportes . DIRECTORY_SEPARATOR . '.htaccess';
if (!file_exists($ozHtaccess)) {
    @file_put_contents($ozHtaccess, "Require all denied\n", LOCK_EX);
}

/* Endpoint: cada reporte se agrega como una línea JSON al archivo TXT, sin modificar la BD. */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ozp_action']) && $_POST['ozp_action'] === 'guardar_reporte') {
    header('Content-Type: application/json; charset=utf-8');
    if (empty($_SESSION['rol']) || empty($_SESSION['nombre'])) {
        http_response_code(401);
        echo json_encode(array('ok' => false, 'mensaje' => 'Tu sesión terminó. Inicia sesión para guardar el reporte.'), JSON_UNESCAPED_UNICODE);
        exit;
    }
    $ficha = trim((string)($_POST['ficha'] ?? ''));
    $perfil = trim((string)($_POST['perfil'] ?? ''));
    $preferencias = trim((string)($_POST['preferencias'] ?? ''));
    $restricciones = trim((string)($_POST['restricciones'] ?? ''));
    $producto = trim((string)($_POST['producto'] ?? ''));
    $modificaciones = trim((string)($_POST['modificaciones'] ?? ''));
    $fechaPlan = trim((string)($_POST['fecha_plan'] ?? ''));
    if ($ficha === '') {
        http_response_code(422);
        echo json_encode(array('ok' => false, 'mensaje' => 'No se encontró la ficha final. Genera la propuesta nuevamente.'), JSON_UNESCAPED_UNICODE);
        exit;
    }
    if ($fechaPlan !== '' && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $fechaPlan)) $fechaPlan = '';
    $codigo = 'OZ-' . date('Ymd-His') . '-' . strtoupper(bin2hex(random_bytes(2)));
    $registro = array(
        'codigo' => $codigo,
        'fecha_creacion' => date('Y-m-d H:i:s'),
        'usuario_ci' => $ozUsuarioCi,
        'nombre_usuario' => $ozUsuarioNombre,
        'telefono_usuario' => $ozUsuarioTelefono,
        'rol_usuario' => $ozUsuarioRol,
        'fecha_plan' => $fechaPlan,
        'perfil' => $perfil,
        'preferencias' => $preferencias,
        'restricciones' => $restricciones,
        'producto' => $producto,
        'modificaciones' => $modificaciones,
        'estado' => 'Nuevo',
        'ficha' => $ficha
    );
    $linea = json_encode($registro, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    $guardado = $linea !== false ? @file_put_contents($ozArchivoReportes, $linea . PHP_EOL, FILE_APPEND | LOCK_EX) : false;
    if ($guardado === false) {
        http_response_code(500);
        echo json_encode(array('ok' => false, 'mensaje' => 'No se pudo escribir el archivo TXT. Comprueba los permisos de la carpeta datosOzPlanning.'), JSON_UNESCAPED_UNICODE);
        exit;
    }
    echo json_encode(array('ok' => true, 'codigo' => $codigo, 'mensaje' => 'Reporte guardado en el archivo local de Organic Zone.'), JSON_UNESCAPED_UNICODE);
    exit;
}

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

/* Catálogo local de Oz Planning. Reutiliza los productos consultados arriba:
   no crea tablas, no guarda respuestas y no realiza consultas adicionales. */
$ozPlanningCatalogo = array();
foreach ($productos as $productoOz) {
    $idOz = (int) $productoOz['id'];
    $imagenOz = "Imagenes/predeterminado.png";
    foreach (array("jpg", "jpeg", "png", "gif", "webp") as $extOz) {
        $rutaOz = "Imagenes/P-" . $idOz . "." . $extOz;
        if (file_exists($rutaOz)) {
            $imagenOz = $rutaOz;
            break;
        }
    }
    $infoOz = buscarNutricion($productoOz['nombre'], $nutricion);
    $ozPlanningCatalogo[] = array(
        'id' => $idOz,
        'nombre' => (string) $productoOz['nombre'],
        'descripcion' => (string) $productoOz['descripcion'],
        'precio' => (float) $productoOz['precio'],
        'imagen' => $imagenOz,
        'stock' => (int) $productoOz['stock'],
        'nutricionDisponible' => (bool) $infoOz,
        'kcal' => $infoOz ? (int) $infoOz['kcal'] : null,
        'proteinas' => $infoOz ? (float) $infoOz['proteinas'] : null,
        'fibra' => $infoOz ? (float) $infoOz['fibra'] : null,
        'azucares' => $infoOz ? (float) $infoOz['azucares'] : null
    );
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

    

        /* =====================================================
           OZ PLANNING · MÓDULO 2D INDEPENDIENTE
           Estilos encapsulados para no alterar el menú existente.
           ===================================================== */
        .ozp-acceso {
            position: relative;
            display: grid;
            grid-template-columns: minmax(0, 1.2fr) minmax(220px, .8fr);
            align-items: center;
            gap: 28px;
            margin: 0 0 76px;
            padding: clamp(28px, 5vw, 64px);
            overflow: hidden;
            border-radius: 34px;
            background: var(--cafe);
            color: #fff;
            isolation: isolate;
        }
        .ozp-acceso::before {
            content: "";
            position: absolute;
            z-index: -1;
            width: 340px;
            aspect-ratio: 1;
            right: -95px;
            top: -135px;
            border-radius: 50%;
            background: var(--verde);
        }
        .ozp-acceso::after {
            content: "";
            position: absolute;
            z-index: -1;
            width: 190px;
            aspect-ratio: 1;
            right: 90px;
            bottom: -125px;
            border-radius: 50%;
            background: var(--crema);
        }
        .ozp-eyebrow, .ozp-etiqueta {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            font-size: 11px;
            font-weight: 900;
            letter-spacing: 1.8px;
            text-transform: uppercase;
        }
        .ozp-eyebrow { color: var(--crema); }
        .ozp-punto { width: 9px; height: 9px; border-radius: 50%; background: var(--verde); }
        .ozp-acceso h2 {
            max-width: 720px;
            margin: 17px 0 14px;
            color: #fff;
            font-family: 'Fredoka', sans-serif;
            font-size: clamp(48px, 6.5vw, 86px);
            font-weight: 700;
            line-height: .9;
            letter-spacing: -2px;
        }
        .ozp-acceso h2 span { color: var(--crema); }
        .ozp-acceso p { max-width: 620px; margin: 0; color: #F4F1EE; font-size: 16px; line-height: 1.65; font-weight: 700; }
        .ozp-acceso-accion { display: flex; flex-direction: column; align-items: flex-start; gap: 13px; position: relative; z-index: 1; }
        .ozp-reportes-wrap { display:flex; align-items:center; justify-content:flex-start; width:100%; margin-top:2px; }
        .ozp-reportes-boton { display:inline-flex; align-items:center; justify-content:center; gap:9px; min-height:48px; padding:12px 21px; margin:0; border-radius:999px; background:#FFC982; color:#2B140D; font:900 14px 'Nunito',sans-serif; line-height:1.2; text-decoration:none; white-space:normal; text-align:center; border:0; box-sizing:border-box; }
        .ozp-reportes-boton:hover { background:#F4F1EE; color:#2B140D; transform:translateY(-1px); }
        .ozp-reportes-boton:focus-visible { outline:3px solid #0BA84A; outline-offset:3px; }
        .ozp-reportes-boton span { display:inline-grid; place-items:center; flex:0 0 25px; width:25px; height:25px; border-radius:50%; background:#2B140D; color:#FFC982; font-size:15px; }
        @media(max-width:560px) { .ozp-reportes-wrap { width:100%; } .ozp-reportes-boton { width:100%; } }
        .ozp-boton, .ozp-boton-secundario {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            gap: 11px;
            min-height: 52px;
            padding: 14px 22px;
            border: 0;
            border-radius: 15px;
            font: 800 15px 'Nunito', sans-serif;
            text-decoration: none;
            cursor: pointer;
            transition: transform .18s ease, background .18s ease;
        }
        .ozp-boton { background: var(--verde); color: #fff; }
        .ozp-boton:hover { background: #09883D; transform: translateY(-2px); }
        .ozp-boton-secundario { background: var(--crema); color: var(--cafe); }
        .ozp-boton-secundario:hover { background: #ffd9a5; transform: translateY(-2px); }
        .ozp-acceso-nota { color: #FCD09F; font-size: 12px; font-weight: 800; }
        .ozp-grafico { position: relative; width: min(100%, 270px); aspect-ratio: 1; margin: 0 auto; }
        .ozp-grafico-circulo { position: absolute; inset: 7%; border-radius: 50%; background: var(--crema); }
        .ozp-grafico-plato { position: absolute; inset: 18%; display: grid; place-items: center; border: 12px solid var(--cafe); border-radius: 50%; background: #fff; color: var(--cafe); }
        .ozp-grafico-plato svg { width: 62%; height: 62%; }
        .ozp-grafico-hoja { position: absolute; width: 27%; height: 14%; border-radius: 100% 0 100% 0; background: var(--verde); transform: rotate(-35deg); }
        .ozp-grafico-hoja.h1 { right: 2%; top: 15%; }
        .ozp-grafico-hoja.h2 { left: 0; bottom: 20%; transform: rotate(35deg); background: var(--cafe); }
        .ozp-modulo { display: none; margin: 0 0 76px; scroll-margin-top: 100px; }
        .ozp-modulo.ozp-visible { display: block; animation: ozp-aparecer .24s ease-out; }
        @keyframes ozp-aparecer { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }
        .ozp-cabecera { display: flex; align-items: flex-end; justify-content: space-between; gap: 20px; margin-bottom: 26px; }
        .ozp-cabecera h2 { margin: 7px 0 8px; color: var(--cafe); font: 700 clamp(42px, 6vw, 72px)/.94 'Fredoka', sans-serif; letter-spacing: -1.8px; }
        .ozp-cabecera h2 span { color: var(--verde); }
        .ozp-cabecera p { max-width: 670px; margin: 0; color: #766E69; font-size: 15px; font-weight: 700; line-height: 1.6; }
        .ozp-cerrar { flex: 0 0 auto; width: 46px; height: 46px; border: 0; border-radius: 14px; background: var(--crema); color: var(--cafe); font-size: 25px; font-weight: 900; cursor: pointer; }
        .ozp-layout { display: grid; grid-template-columns: minmax(0, 1fr) minmax(275px, .72fr); gap: 22px; align-items: start; }
        .ozp-panel { padding: clamp(20px, 3vw, 32px); border-radius: 26px; background: #fff; border: 2px solid var(--cafe); }
        .ozp-panel-titulo { display: flex; align-items: center; gap: 12px; margin: 0 0 21px; color: var(--cafe); font: 700 25px/1.1 'Fredoka', sans-serif; }
        .ozp-numero { display: grid; place-items: center; flex: 0 0 36px; width: 36px; height: 36px; border-radius: 50%; background: var(--verde); color: #fff; font: 700 19px 'Fredoka', sans-serif; }
        .ozp-campo { margin-bottom: 22px; }
        .ozp-campo:last-child { margin-bottom: 0; }
        .ozp-campo label, .ozp-label { display: block; margin-bottom: 8px; color: var(--cafe); font-size: 13px; font-weight: 900; }
        .ozp-campo select, .ozp-campo textarea, .ozp-campo input[type="text"] { display: block; width: 100%; min-height: 48px; padding: 12px 14px; border: 2px solid #E8DCCB; border-radius: 12px; background: #fff; color: var(--cafe); font: 700 14px 'Nunito', sans-serif; outline: none; }
        .ozp-campo select:focus, .ozp-campo textarea:focus, .ozp-campo input:focus { border-color: var(--verde); }
        .ozp-campo textarea { min-height: 94px; resize: vertical; }
        .ozp-ayuda { display: block; margin-top: 7px; color: #766E69; font-size: 12px; line-height: 1.5; }
        .ozp-opciones { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 9px; }
        .ozp-opcion { position: relative; }
        .ozp-opcion input { position: absolute; opacity: 0; pointer-events: none; }
        .ozp-opcion span { display: flex; align-items: center; gap: 8px; min-height: 44px; padding: 10px 12px; border: 2px solid #E8DCCB; border-radius: 12px; background: #fff; color: var(--cafe); font-size: 12px; font-weight: 800; cursor: pointer; transition: background .15s, border-color .15s; }
        .ozp-opcion span::before { content: "+"; display: grid; place-items: center; width: 21px; height: 21px; flex: 0 0 21px; border-radius: 6px; background: var(--crema); color: var(--cafe); font-size: 16px; }
        .ozp-opcion input:checked + span { border-color: var(--verde); background: #E5F7EA; }
        .ozp-opcion input:checked + span::before { content: "✓"; background: var(--verde); color: #fff; }
        .ozp-opcion input:focus-visible + span { outline: 3px solid var(--crema); outline-offset: 2px; }
        .ozp-acciones-form { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 25px; }
        .ozp-resultado { position: sticky; top: 24px; background: var(--crema); border-color: var(--cafe); }
        .ozp-resultado .ozp-panel-titulo { font-size: 29px; }
        .ozp-resultado-intro { margin: 0 0 18px; color: var(--cafe); font-size: 13px; font-weight: 700; line-height: 1.6; }
        .ozp-resultado-vacio { padding: 20px 0; color: #6E4B36; font-size: 14px; font-weight: 700; line-height: 1.6; }
        .ozp-resultado-lista { display: grid; gap: 12px; }
        .ozp-recomendacion { display: grid; grid-template-columns: 76px minmax(0,1fr); gap: 12px; padding: 11px; border-radius: 15px; background: #fff; }
        .ozp-recomendacion img { width: 76px; height: 92px; object-fit: cover; border-radius: 10px; background: #F4F1EE; }
        .ozp-recomendacion h4 { margin: 2px 0 5px; color: var(--cafe); font: 700 18px/1.1 'Fredoka', sans-serif; }
        .ozp-recomendacion p { margin: 0 0 7px; color: #766E69; font-size: 11px; line-height: 1.45; }
        .ozp-recomendacion strong { color: var(--verde); font-size: 12px; }
        .ozp-etiqueta { padding: 6px 8px; border-radius: 7px; background: var(--verde); color: #fff; font-size: 9px; letter-spacing: .8px; }
        .ozp-alerta { margin-top: 16px; padding: 13px 14px; border-left: 5px solid var(--cafe); border-radius: 8px; background: #fff; color: var(--cafe); font-size: 12px; font-weight: 700; line-height: 1.55; }
        .ozp-resumen { display: none; margin-top: 20px; padding: 22px; border-radius: 20px; background: var(--cafe); color: #fff; }
        .ozp-resumen.ozp-resumen-visible { display: block; }
        .ozp-resumen h3 { margin: 0 0 12px; color: var(--crema); font: 700 28px 'Fredoka', sans-serif; }
        .ozp-resumen p, .ozp-resumen li { color: #fff; font-size: 13px; line-height: 1.6; }
        .ozp-resumen ul { padding-left: 20px; }
        .ozp-sin-productos { padding: 15px; border-radius: 12px; background: #fff; color: var(--cafe); font-weight: 800; }
        .ozp-legal { margin: 18px 0 0; color: #766E69; font-size: 11px; line-height: 1.6; }
        @media (max-width: 900px) {
            .ozp-acceso { grid-template-columns: 1fr; }
            .ozp-grafico { position: absolute; width: 160px; right: 18px; bottom: 14px; opacity: .45; pointer-events: none; }
            .ozp-acceso-accion { align-items: flex-start; }
            .ozp-layout { grid-template-columns: 1fr; }
            .ozp-resultado { position: static; }
        }
        @media (max-width: 600px) {
            .ozp-acceso { margin-bottom: 52px; padding: 30px 22px; border-radius: 25px; }
            .ozp-acceso h2 { max-width: 100%; font-size: clamp(48px, 14vw, 68px); letter-spacing: -1.5px; }
            .ozp-acceso p { max-width: 100%; font-size: 14px; }
            .ozp-grafico { width: 105px; right: -4px; bottom: 5px; opacity: .23; }
            .ozp-cabecera { align-items: flex-start; }
            .ozp-cabecera h2 { font-size: 45px; }
            .ozp-cabecera p { font-size: 13px; }
            .ozp-panel { padding: 18px; border-radius: 20px; }
            .ozp-opciones { grid-template-columns: 1fr; }
            .ozp-acciones-form .ozp-boton, .ozp-acciones-form .ozp-boton-secundario { width: 100%; }
            .ozp-recomendacion { grid-template-columns: 64px minmax(0,1fr); }
            .ozp-recomendacion img { width: 64px; height: 82px; }
        }


        /* Oz Planning refresh: formas suaves, 2D y sin bordes visibles */
        .ozp-acceso { border-radius: 38px; background: #2B140D; box-shadow: none; }
        .ozp-boton, .ozp-boton-secundario { border-radius: 999px; min-height: 54px; padding: 15px 25px; font-weight: 900; }
        .ozp-boton:focus-visible, .ozp-boton-secundario:focus-visible, .ozp-cerrar:focus-visible { outline: 3px solid #FFC982; outline-offset: 3px; }
        .ozp-panel { border: 0; border-radius: 30px; background: #F4F1EE; box-shadow: none; }
        .ozp-resultado { background: #FFC982; }
        .ozp-panel-titulo { font-size: clamp(24px, 2.4vw, 32px); letter-spacing: -.5px; }
        .ozp-numero { width: 42px; height: 42px; flex-basis: 42px; border-radius: 15px; background: #0BA84A; }
        .ozp-campo select, .ozp-campo textarea, .ozp-campo input[type="text"] { border: 0; border-radius: 17px; background: #fff; min-height: 52px; padding: 14px 17px; box-shadow: none; }
        .ozp-campo select:focus, .ozp-campo textarea:focus, .ozp-campo input:focus { outline: 3px solid #0BA84A; outline-offset: 2px; }
        .ozp-opciones { gap: 10px; }
        .ozp-opcion span { border: 0; border-radius: 999px; background: #fff; min-height: 48px; padding: 11px 15px; font-size: 13px; }
        .ozp-opcion span::before { border-radius: 50%; width: 24px; height: 24px; flex-basis: 24px; }
        .ozp-opcion input:checked + span { background: #DDF3E3; box-shadow: inset 0 0 0 2px #0BA84A; }
        .ozp-recomendacion { border-radius: 22px; padding: 13px; background: #fff; }
        .ozp-recomendacion img { border-radius: 16px; }
        .ozp-etiqueta { border-radius: 999px; padding: 7px 11px; }
        .ozp-alerta { border: 0; border-radius: 16px; background: #fff; padding: 15px; }
        .ozp-sustituciones { display:grid; gap:10px; margin-top:15px; }
        .ozp-sustitucion { background:#fff; border-radius:19px; padding:15px 16px; color:#2B140D; }
        .ozp-sustitucion strong { display:block; color:#0BA84A; font:700 18px/1.2 'Fredoka',sans-serif; margin-bottom:5px; }
        .ozp-sustitucion p { margin:0; color:#65554B; font-size:12px; line-height:1.55; }
        .ozp-subtitulo-resultado { margin:22px 0 10px; color:#2B140D; font:700 25px/1.1 'Fredoka',sans-serif; }
        .ozp-opcion-nota { display:block; margin-top:6px; color:#6E4B36; font-size:11px; font-weight:800; }
        .ozp-perfil-extra { padding:17px; border-radius:22px; background:#E5F4E8; margin:0 0 22px; }
        .ozp-perfil-extra .ozp-label { font:700 21px/1.2 'Fredoka',sans-serif; font-size:21px; }
        .ozp-acceso-nota { letter-spacing:1px; }
        /* Controles Organic Zone: limpios, 2D y táctiles */
        .ozp-campo select { appearance:none; -webkit-appearance:none; cursor:pointer; padding-right:54px !important; color:#2B140D; font-family:'Nunito',sans-serif; font-size:15px; font-weight:800; background-color:#fff; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='22' height='22' viewBox='0 0 24 24' fill='none' stroke='%230BA84A' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 17px center; background-size:20px; transition:background-color .18s ease; }
        .ozp-campo select:hover { background-color:#F7FFF8; }
        .ozp-campo select option { background:#fff; color:#2B140D; font-weight:700; }
        .ozp-campo select:focus-visible { outline:3px solid #0BA84A; outline-offset:3px; }
        .ozp-agenda { display:flex; align-items:flex-start; gap:14px; padding:18px; margin:5px 0 22px; border-radius:24px; background:#E5F4E8; }
        .ozp-agenda-icono { display:grid; place-items:center; flex:0 0 44px; width:44px; height:44px; border-radius:15px; background:#0BA84A; color:#FFC982; font-size:25px; }
        .ozp-agenda-contenido { min-width:0; flex:1; }
        .ozp-agenda-contenido label { display:block; margin:1px 0 5px; color:#2B140D; font:700 21px/1.2 'Fredoka',sans-serif; }
        .ozp-agenda-contenido p { margin:0 0 12px; color:#65554B; font-size:12px; line-height:1.5; }
        .ozp-agenda input[type="date"] { width:100%; min-height:50px; padding:11px 14px; border:0; border-radius:15px; background:#fff; color:#2B140D; font:800 15px 'Nunito',sans-serif; color-scheme:light; }
        .ozp-agenda input[type="date"]:focus-visible { outline:3px solid #0BA84A; outline-offset:3px; }
        .ozp-confianza { display:inline-flex; align-items:center; gap:6px; margin-top:8px; padding:7px 10px; border-radius:999px; background:#DDF3E3; color:#12652F; font:900 11px 'Nunito',sans-serif; }
        .ozp-confianza-barra { height:7px; margin-top:7px; border-radius:999px; overflow:hidden; background:#E9E2D8; }
        .ozp-confianza-barra span { display:block; height:100%; border-radius:999px; background:#0BA84A; }
        .ozp-ideas-externas { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:10px; margin-top:12px; }
        .ozp-idea-externa { padding:17px; border-radius:20px; background:#F4F1EE; }
        .ozp-idea-externa strong { display:block; margin-bottom:6px; color:#2B140D; font:700 19px/1.15 'Fredoka',sans-serif; }
        .ozp-idea-externa p { margin:0; color:#65554B; font-size:12px; line-height:1.55; }
        .ozp-idea-externa .ozp-confianza { margin-bottom:8px; }
        @media(max-width:640px){ .ozp-ideas-externas{grid-template-columns:1fr}.ozp-agenda{padding:14px}.ozp-agenda-contenido label{font-size:19px} }

        /* OZ PLANNING — ampliación visual y controles estables */
        .ozp-acceso { gap:clamp(28px,5vw,76px) !important; padding:clamp(34px,5vw,76px) !important; }
        .ozp-acceso > div:first-child { max-width:760px; }
        .ozp-acceso h2 { font-size:clamp(48px,6vw,78px) !important; line-height:.98 !important; letter-spacing:-1.8px; }
        .ozp-acceso p { max-width:650px; font-size:clamp(17px,1.35vw,20px) !important; line-height:1.65 !important; }
        .ozp-eyebrow { font-size:12px !important; letter-spacing:1.8px; }
        .ozp-acceso-nota { font-size:11px !important; font-weight:900; }
        .ozp-grafico { isolation:isolate; min-height:340px; }
        .ozp-logo-orbita { position:absolute; inset:0; display:grid; place-items:center; }
        .ozp-logo-fondo { position:absolute; width:clamp(230px,25vw,330px); aspect-ratio:1; border-radius:50%; background:#FFC982; }
        .ozp-logo-imagen { position:relative; z-index:5; display:block; width:clamp(190px,22vw,285px); max-width:82%; height:auto; object-fit:contain; transition:none !important; transform:none !important; filter:none !important; }
        .ozp-orbita { position:absolute; z-index:2; display:block; border-radius:50%; pointer-events:none; transition:transform .5s cubic-bezier(.2,.8,.2,1); }
        .ozp-orbita-verde { width:clamp(270px,29vw,370px); aspect-ratio:1; border:18px solid #0BA84A; background:transparent; }
        .ozp-orbita-beige { width:clamp(300px,32vw,410px); aspect-ratio:1; border:3px solid #2B140D; background:transparent; }
        .ozp-acceso:hover .ozp-orbita-verde { transform:translate(10px,-9px) rotate(12deg) scale(1.035); }
        .ozp-acceso:hover .ozp-orbita-beige { transform:translate(-9px,8px) rotate(-10deg) scale(.98); }
        .ozp-particula { position:absolute; z-index:4; width:18px; height:18px; border-radius:50%; background:#0BA84A; transition:transform .45s ease; }
        .ozp-particula-1 { top:13%; left:19%; }
        .ozp-particula-2 { right:13%; top:24%; width:27px; height:27px; background:#2B140D; }
        .ozp-particula-3 { right:21%; bottom:10%; width:14px; height:14px; background:#FFC982; }
        .ozp-acceso:hover .ozp-particula-1 { transform:translate(-8px,-10px); }
        .ozp-acceso:hover .ozp-particula-2 { transform:translate(8px,-12px); }
        .ozp-acceso:hover .ozp-particula-3 { transform:translate(8px,7px); }
        .ozp-modulo { padding:clamp(22px,4vw,54px) !important; border-radius:36px !important; }
        .ozp-cabecera { margin-bottom:30px !important; align-items:flex-start !important; }
        .ozp-cabecera h2 { font-size:clamp(42px,5vw,66px) !important; line-height:.98 !important; letter-spacing:-1px; }
        .ozp-cabecera p { font-size:clamp(16px,1.2vw,18px) !important; line-height:1.65 !important; }
        .ozp-layout { gap:clamp(18px,2.5vw,30px) !important; }
        .ozp-panel { padding:clamp(22px,3vw,38px) !important; border:0 !important; border-radius:30px !important; background:#fff !important; }
        .ozp-panel-titulo { font-size:clamp(25px,2.2vw,31px) !important; margin-bottom:26px !important; }
        .ozp-campo { margin-bottom:27px !important; }
        .ozp-campo label, .ozp-label { font-size:clamp(15px,1.15vw,17px) !important; line-height:1.4; }
        .ozp-campo select, .ozp-campo textarea, .ozp-campo input[type="text"] {
            min-height:58px !important; padding:15px 52px 15px 18px !important; border:2px solid #0BA84A !important;
            border-radius:20px !important; background-color:#F8FFF9 !important; color:#2B140D !important;
            font:800 16px/1.35 'Nunito',sans-serif !important; box-shadow:none !important;
        }
        .ozp-campo select {
            appearance:none !important; -webkit-appearance:none !important; cursor:pointer;
            background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%230BA84A' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E") !important;
            background-repeat:no-repeat !important; background-position:right 18px center !important; background-size:20px !important;
        }
        .ozp-campo select:hover { background-color:#EAF8ED !important; }
        .ozp-campo select:focus-visible, .ozp-campo textarea:focus-visible, .ozp-campo input:focus-visible { outline:3px solid #FFC982 !important; outline-offset:3px; }
        .ozp-campo select option { padding:12px; color:#2B140D; background:#fff; font-weight:700; }
        .ozp-ayuda { font-size:14px !important; line-height:1.55 !important; }
        .ozp-opciones { gap:12px !important; }
        .ozp-opcion span { min-height:56px !important; display:flex; align-items:center; font-size:15px !important; line-height:1.3; padding:13px 16px !important; border-radius:18px !important; }
        .ozp-boton { min-height:56px; padding:15px 24px !important; border-radius:18px !important; font-size:16px !important; }
        .ozp-numero { width:42px !important; height:42px !important; flex-basis:42px !important; font-size:21px !important; }
        .ozp-resultados, #ozp-resultados { font-size:16px; line-height:1.6; }
        .ozp-confianza { font-size:12px !important; }
        @media (max-width:820px) {
            .ozp-acceso { grid-template-columns:1fr !important; }
            .ozp-grafico { min-height:300px; }
            .ozp-layout { grid-template-columns:minmax(0,1fr) !important; }
        }
        @media (max-width:560px) {
            .ozp-acceso { padding:27px 22px !important; border-radius:28px !important; }
            .ozp-grafico { min-height:250px; }
            .ozp-logo-fondo { width:205px; }
            .ozp-orbita-verde { width:235px; border-width:12px; }
            .ozp-orbita-beige { width:260px; }
            .ozp-logo-imagen { width:175px; }
            .ozp-cabecera h2 { font-size:42px !important; }
            .ozp-modulo { padding:18px !important; border-radius:26px !important; }
            .ozp-opciones { grid-template-columns:1fr !important; }
        }
        @media (prefers-reduced-motion: reduce) {
            .ozp-orbita, .ozp-particula, .ozp-logo-imagen { transition:none !important; }
        }

        /* Organic Zone · refinamiento limpio y ligero */
        .ozp-acceso {
            background: #2B140D !important;
            border-radius: 34px !important;
            box-shadow: none !important;
            gap: clamp(20px, 3vw, 44px) !important;
            padding: clamp(28px, 4vw, 54px) !important;
        }
        .ozp-acceso::before, .ozp-acceso::after { display: none !important; }
        .ozp-grafico { min-height: 0 !important; width: min(100%, 340px) !important; aspect-ratio: 1 !important; }
        .ozp-grafico-circulo { inset: 14% !important; background: #FFC982 !important; }
        .ozp-logo-fondo { width: 66% !important; background: #F4F1EE !important; }
        .ozp-logo-imagen { width: 58% !important; max-width: 58% !important; }
        .ozp-orbita { transition: transform .22s ease-out !important; }
        .ozp-orbita-verde { width: 82% !important; border: 10px solid #0BA84A !important; }
        .ozp-orbita-beige { width: 94% !important; border: 2px solid #FFC982 !important; }
        .ozp-acceso:hover .ozp-orbita-verde { transform: translate(3px,-3px) !important; }
        .ozp-acceso:hover .ozp-orbita-beige { transform: translate(-3px,3px) !important; }
        .ozp-grafico-hoja, .ozp-particula { display: none !important; }
        .ozp-modulo { animation: none !important; scroll-behavior: auto !important; }
        .ozp-layout { gap: 22px !important; }
        .ozp-panel { border: 0 !important; box-shadow: none !important; border-radius: 28px !important; }
        .ozp-resultado { position: static !important; background: #FFC982 !important; }
        .ozp-campo select, .ozp-campo textarea, .ozp-campo input[type="text"] {
            border: 0 !important; border-radius: 17px !important; background-color: #F4F1EE !important;
            min-height: 54px !important; padding: 14px 48px 14px 17px !important;
            color: #2B140D !important; box-shadow: none !important;
        }
        .ozp-campo textarea { padding: 15px 17px !important; min-height: 104px !important; }
        .ozp-campo select:focus-visible, .ozp-campo textarea:focus-visible, .ozp-campo input:focus-visible {
            outline: 3px solid #0BA84A !important; outline-offset: 2px !important;
        }
        .ozp-opcion span { border: 0 !important; border-radius: 17px !important; background: #F4F1EE !important; }
        .ozp-opcion input:checked + span { background: #DDF3E3 !important; box-shadow: inset 0 0 0 2px #0BA84A !important; }
        .ozp-perfil-extra { background: #F4F1EE !important; border-radius: 22px !important; }
        .ozp-boton, .ozp-boton-secundario { border-radius: 999px !important; box-shadow: none !important; }
        .ozp-producto-fecha { display: grid; grid-template-columns: minmax(0, 1fr) minmax(205px, .56fr); gap: 18px; align-items: stretch; margin: 0 0 24px; }
        .ozp-producto-col { min-width: 0; margin: 0 !important; }
        .ozp-agenda { display: flex !important; flex-direction: column; align-items: stretch; gap: 9px !important; min-width: 0; margin: 0 !important; padding: 17px !important; border-radius: 22px !important; background: #F4F1EE !important; }
        .ozp-agenda-cabecera { display: flex; align-items: center; justify-content: space-between; gap: 8px; }
        .ozp-agenda-kicker { color: #0BA84A; font-size: 10px; line-height: 1.3; font-weight: 900; letter-spacing: 1.1px; }
        .ozp-agenda-simbolo { display: grid; place-items: center; width: 34px; height: 34px; border-radius: 11px; background: #0BA84A; color: #FFC982; font-size: 21px; }
        .ozp-agenda > label { display: block; margin: 2px 0 0; color: #2B140D; font: 700 20px/1.15 'Fredoka',sans-serif; }
        .ozp-agenda small { color: #65554B; font: 700 11px/1.45 'Nunito',sans-serif; }
        .ozp-agenda input[type="date"] { width: 100%; min-width: 0; min-height: 50px; padding: 10px 11px; border: 0 !important; border-radius: 14px !important; background: #FFC982 !important; color: #2B140D !important; font: 800 14px 'Nunito',sans-serif; color-scheme: light; }
        .ozp-agenda input[type="date"]:focus-visible { outline: 3px solid #0BA84A; outline-offset: 2px; }
        .ozp-acciones-form { gap: 10px !important; }
        @media (max-width: 760px) {
            .ozp-producto-fecha { grid-template-columns: minmax(0,1fr); }
            .ozp-agenda { display: grid !important; grid-template-columns: minmax(0,1fr) auto; align-items: center; }
            .ozp-agenda-cabecera { grid-column: 1 / -1; }
            .ozp-agenda > label, .ozp-agenda small { grid-column: 1 / -1; }
        }
        @media (prefers-reduced-motion: reduce) {
            .ozp-orbita, .ozp-acceso:hover .ozp-orbita-verde, .ozp-acceso:hover .ozp-orbita-beige { transition: none !important; transform: none !important; }
        }
    

/* AJUSTE FINAL OZ PLANNING: selector y calendario propios, sin UI nativa visible */
.ozp-acceso::before,.ozp-acceso::after{display:none!important}
.ozp-acceso{grid-template-columns:minmax(0,1.25fr) minmax(260px,.75fr)!important;position:relative;overflow:hidden;background:#2B140D!important}
.ozp-grafico{min-height:320px!important;display:grid;place-items:center;isolation:isolate}
.ozp-grafico-circulo,.ozp-grafico-hoja,.ozp-particula{display:none!important}
.ozp-logo-orbita{position:absolute;inset:0;display:grid;place-items:center}
.ozp-logo-fondo{width:clamp(210px,22vw,280px)!important;background:#FFC982!important}
.ozp-logo-imagen{width:clamp(180px,19vw,245px)!important;max-width:80%;height:auto;z-index:5}
.ozp-orbita{border:0!important;transition:transform .35s ease!important}
.ozp-orbita-verde{width:76px!important;height:76px!important;aspect-ratio:1;top:7%!important;right:8%!important;left:auto!important;bottom:auto!important;background:#0BA84A!important;opacity:1}
.ozp-orbita-beige{width:54px!important;height:54px!important;aspect-ratio:1;left:7%!important;bottom:8%!important;top:auto!important;right:auto!important;background:#FFC982!important}
.ozp-acceso:hover .ozp-orbita-verde{transform:translate(5px,-5px)!important}
.ozp-acceso:hover .ozp-orbita-beige{transform:translate(-4px,5px)!important}
.ozp-modulo{animation:none!important}
.ozp-panel{border:0!important;box-shadow:none!important}
.ozp-panel-titulo{font-size:clamp(30px,2.7vw,37px)!important;line-height:1.12!important;margin-bottom:28px!important}
.ozp-numero{width:44px!important;height:44px!important;flex-basis:44px!important;border-radius:50%!important}
.ozp-campo label,.ozp-label{font-size:16px!important;line-height:1.45!important}
.ozp-campo select.ozp-select-original{position:absolute!important;width:1px!important;height:1px!important;padding:0!important;margin:-1px!important;overflow:hidden!important;clip:rect(0,0,0,0)!important;white-space:nowrap!important;border:0!important;opacity:0!important;pointer-events:none!important}
.ozp-select-custom{position:relative;width:100%;font-family:'Nunito',sans-serif;z-index:10}
.ozp-select-trigger{width:100%;min-height:58px;display:flex;align-items:center;justify-content:space-between;gap:14px;padding:15px 18px;border:0;border-radius:18px;background:#E5F4E8;color:#2B140D;text-align:left;font:800 16px/1.35 'Nunito',sans-serif;cursor:pointer}
.ozp-select-trigger:hover,.ozp-select-custom.esta-abierto .ozp-select-trigger{background:#D8F0DE}
.ozp-select-trigger:focus-visible{outline:3px solid #FFC982;outline-offset:3px}
.ozp-select-flecha{width:12px;height:12px;flex:0 0 12px;border-right:3px solid #0BA84A;border-bottom:3px solid #0BA84A;transform:rotate(45deg) translateY(-3px);transition:transform .18s ease}
.ozp-select-custom.esta-abierto .ozp-select-flecha{transform:rotate(225deg) translate(-2px,-1px)}
.ozp-select-lista{position:absolute;top:calc(100% + 8px);left:0;right:0;display:none;max-height:260px;overflow-y:auto;padding:7px;background:#FFF8EC;border-radius:18px;box-shadow:0 12px 28px rgba(43,20,13,.14);z-index:50}
.ozp-select-custom.esta-abierto .ozp-select-lista{display:grid;gap:3px}
.ozp-select-opcion{display:flex;align-items:center;width:100%;min-height:43px;padding:10px 13px;border:0;border-radius:12px;background:transparent;color:#2B140D;text-align:left;font:800 14px/1.35 'Nunito',sans-serif;cursor:pointer}
.ozp-select-opcion:hover,.ozp-select-opcion:focus-visible{outline:none;background:#E5F4E8}
.ozp-select-opcion[aria-selected="true"]{background:#0BA84A;color:#fff}
.ozp-producto-fecha{grid-template-columns:minmax(0,1fr) minmax(245px,.62fr)!important;align-items:start!important;gap:20px!important}
.ozp-agenda{display:block!important;min-width:0;padding:17px!important;margin:0 0 24px!important;border-radius:24px!important;background:#F4F1EE!important}
.ozp-agenda-cabecera{display:flex;align-items:center;justify-content:space-between;margin-bottom:12px}
.ozp-agenda-kicker{color:#0BA84A;font-size:11px;font-weight:900;letter-spacing:1.3px}
.ozp-agenda-simbolo{display:none!important}
.ozp-agenda-contenido label,.ozp-agenda>label{font:700 23px/1.15 'Fredoka',sans-serif!important;color:#2B140D!important;margin:0 0 10px!important;display:block}
.ozp-agenda>small{display:block;margin-top:10px;color:#6E4B36;font-size:12px;line-height:1.45}
.ozp-agenda input[type="date"].ozp-fecha-original{position:absolute!important;width:1px!important;height:1px!important;padding:0!important;margin:-1px!important;overflow:hidden!important;clip:rect(0,0,0,0)!important;opacity:0!important;pointer-events:none!important}
.ozp-calendario{padding:13px;border-radius:18px;background:#fff;color:#2B140D}
.ozp-cal-cabecera{display:flex;align-items:center;justify-content:space-between;gap:8px;margin-bottom:12px}
.ozp-cal-mes{font:700 19px/1.1 'Fredoka',sans-serif;color:#2B140D;text-transform:capitalize}
.ozp-cal-nav{display:grid;place-items:center;width:34px;height:34px;border:0;border-radius:50%;background:#E5F4E8;color:#2B140D;font-size:22px;font-weight:900;cursor:pointer}
.ozp-cal-nav:hover{background:#0BA84A;color:#fff}
.ozp-cal-dias,.ozp-cal-fechas{display:grid;grid-template-columns:repeat(7,minmax(0,1fr));gap:4px;text-align:center}
.ozp-cal-dias{margin-bottom:6px;color:#6E4B36;font-size:10px;font-weight:900}
.ozp-cal-dia{display:grid;place-items:center;min-width:0;aspect-ratio:1;border:0;border-radius:10px;background:transparent;color:#2B140D;font:800 12px 'Nunito',sans-serif;cursor:pointer}
.ozp-cal-dia:hover:not(:disabled){background:#E5F4E8}
.ozp-cal-dia.seleccionado{background:#0BA84A;color:#fff}
.ozp-cal-dia.hoy:not(.seleccionado){box-shadow:inset 0 0 0 2px #FFC982}
.ozp-cal-dia:disabled{color:#C8BEB2;cursor:not-allowed}
.ozp-cal-dia.vacio{pointer-events:none}
@media(max-width:820px){.ozp-acceso{grid-template-columns:1fr!important}.ozp-grafico{min-height:245px!important}.ozp-producto-fecha{grid-template-columns:1fr!important}.ozp-agenda{max-width:360px;width:100%;justify-self:start}}
@media(max-width:560px){.ozp-grafico{min-height:220px!important}.ozp-logo-fondo{width:190px!important}.ozp-logo-imagen{width:160px!important}.ozp-orbita-verde{width:56px!important;height:56px!important}.ozp-orbita-beige{width:42px!important;height:42px!important}.ozp-panel-titulo{font-size:28px!important}.ozp-select-trigger{font-size:15px}.ozp-agenda{max-width:none}}
@media(prefers-reduced-motion:reduce){.ozp-orbita,.ozp-select-flecha{transition:none!important}}


/* Ajuste de distribución y decoración solicitado: logo limpio, círculos en esquinas de la caja */
.ozp-acceso{position:relative!important;isolation:isolate;overflow:hidden!important}
.ozp-acceso::before,.ozp-acceso::after{content:""!important;display:block!important;position:absolute!important;z-index:0!important;border-radius:50%!important;pointer-events:none!important}
.ozp-acceso > *{position:relative!important;z-index:1!important}
.ozp-acceso::before{width:112px;height:112px;top:-48px;right:-42px;background:#0BA84A!important;opacity:1!important}
.ozp-acceso::after{width:76px;height:76px;bottom:-32px;right:clamp(220px,28%,380px);background:#FFC982!important;opacity:1!important}
.ozp-grafico{position:relative!important;z-index:1!important;overflow:visible!important}
.ozp-logo-orbita{position:relative!important;inset:auto!important;display:grid!important;place-items:center!important;width:100%!important;height:100%!important}
.ozp-logo-fondo,.ozp-orbita{display:none!important}
.ozp-logo-imagen{position:relative!important;display:block!important;width:clamp(190px,20vw,250px)!important;max-width:85%!important;height:auto!important;object-fit:contain!important;z-index:2!important;filter:none!important;transform:none!important}
.ozp-acceso:hover .ozp-logo-imagen{transform:none!important}
.ozp-producto-fecha{display:grid!important;grid-template-columns:minmax(0,1fr) minmax(245px,.62fr)!important;gap:20px!important;align-items:stretch!important}
.ozp-producto-col{display:flex!important;flex-direction:column!important;align-items:stretch!important;gap:8px!important;min-width:0!important}
.ozp-comentario-col{margin-top:12px!important}
.ozp-comentario-col textarea{width:100%!important;min-height:128px!important;resize:vertical!important;box-sizing:border-box!important}
.ozp-agenda{grid-column:2!important;grid-row:1!important;align-self:start!important;margin:0!important;min-width:0!important}
.ozp-agenda .ozp-calendario{margin-top:8px!important;background:#FFF8EC!important;border-radius:18px!important;padding:12px!important}
/* Titulares más protagonistas: aproximadamente el doble en escritorio */
.ozp-panel-titulo{font-size:clamp(48px,5.2vw,74px)!important;line-height:1.03!important;letter-spacing:-.7px!important;gap:16px!important;margin-bottom:32px!important;align-items:center!important;overflow-wrap:anywhere!important}
.ozp-numero{width:58px!important;height:58px!important;flex-basis:58px!important;min-width:58px!important;font-size:27px!important}
/* Círculos decorativos grandes en las esquinas del área del logo, sin invadir el centro */
.ozp-orbita-verde{width:clamp(112px,10vw,150px)!important;height:clamp(112px,10vw,150px)!important;top:3%!important;right:3%!important;left:auto!important;bottom:auto!important}
.ozp-orbita-beige{width:clamp(86px,7vw,112px)!important;height:clamp(86px,7vw,112px)!important;left:3%!important;bottom:3%!important;top:auto!important;right:auto!important}
/* Flechas del calendario: botones cuadrados reales, redondos y centrados */
.ozp-cal-cabecera{min-height:44px!important;gap:10px!important}
.ozp-cal-nav{display:flex!important;align-items:center!important;justify-content:center!important;flex:0 0 42px!important;width:42px!important;min-width:42px!important;height:42px!important;min-height:42px!important;aspect-ratio:1/1!important;padding:0!important;margin:0!important;border:0!important;border-radius:50%!important;line-height:1!important;font-family:Arial,sans-serif!important;font-size:28px!important;font-weight:700!important;transform:none!important;box-sizing:border-box!important;}
.ozp-cal-mes{flex:1;min-width:0;text-align:center;font-size:clamp(16px,1.5vw,20px)!important}
@media(max-width:820px){
 .ozp-panel-titulo{font-size:clamp(40px,6.2vw,54px)!important;line-height:1.06!important;gap:12px!important}
 .ozp-numero{width:48px!important;height:48px!important;flex-basis:48px!important;min-width:48px!important;font-size:23px!important}
 .ozp-orbita-verde{width:clamp(92px,20vw,125px)!important;height:clamp(92px,20vw,125px)!important;top:2%!important;right:2%!important}
 .ozp-orbita-beige{width:clamp(70px,15vw,94px)!important;height:clamp(70px,15vw,94px)!important;left:2%!important;bottom:2%!important}
}
@media(max-width:480px){
 .ozp-panel-titulo{font-size:38px!important;line-height:1.05!important;gap:10px!important;margin-bottom:24px!important}
 .ozp-numero{width:40px!important;height:40px!important;flex-basis:40px!important;min-width:40px!important;font-size:20px!important}
 .ozp-cal-nav{flex-basis:40px!important;width:40px!important;min-width:40px!important;height:40px!important;min-height:40px!important;font-size:26px!important}
}

@media(max-width:820px){
 .ozp-producto-fecha{grid-template-columns:minmax(0,1fr)!important}
 .ozp-agenda{grid-column:1!important;grid-row:auto!important;width:100%!important;max-width:none!important}
 .ozp-acceso::after{right:22px!important;bottom:-28px!important}
 .ozp-logo-imagen{width:clamp(170px,48vw,230px)!important}
}
@media(prefers-reduced-motion:reduce){.ozp-acceso::before,.ozp-acceso::after{transition:none!important}}


/* Alertas Organic Zone: mismo lenguaje visual del sistema de pedidos */
.oz-popup{width:min(430px,calc(100vw - 28px))!important;border-radius:30px!important;padding:32px 28px 27px!important;background:#FFFDF9!important;border:0!important;box-shadow:0 18px 48px rgba(43,20,13,.2)!important;font-family:'Fredoka',Arial,sans-serif!important}
.oz-title{color:#2B140D!important;font-family:'Fredoka',Arial,sans-serif!important;font-size:29px!important;font-weight:700!important}
.oz-text{color:#665752!important;font-family:'Fredoka',Arial,sans-serif!important;font-size:16px!important;line-height:1.55!important}
.oz-confirm,.oz-cancel,.oz-success{border:0!important;border-radius:999px!important;padding:12px 24px!important;margin:5px!important;font-family:'Fredoka',Arial,sans-serif!important;font-size:15px!important;font-weight:700!important;box-shadow:none!important;transition:background .18s ease,transform .18s ease!important;cursor:pointer!important}
.oz-confirm{background:#D62828!important;color:#fff!important}.oz-confirm:hover{background:#B71C1C!important;transform:translateY(-1px)!important}
.oz-cancel{background:#2B140D!important;color:#fff!important}.oz-cancel:hover{background:#0BA84A!important;transform:translateY(-1px)!important}
.oz-success{background:#0BA84A!important;color:#fff!important}.oz-success:hover{background:#087D38!important;transform:translateY(-1px)!important}
.swal2-icon{margin-top:0!important}.swal2-icon.swal2-warning{border-color:#FFC982!important;color:#2B140D!important}.swal2-icon.swal2-error{border-color:#D62828!important;color:#D62828!important}.swal2-icon.swal2-success{border-color:#0BA84A!important;color:#0BA84A!important}
@media(max-width:520px){.oz-popup{padding:26px 18px 22px!important;border-radius:24px!important}.oz-title{font-size:25px!important}.oz-text{font-size:14px!important}}

/* Ajuste final de tamaño, movimiento y responsive — Organic Zone */
.ozp-panel-titulo{
  font-size:clamp(52px,4.6vw,70px)!important;
  line-height:1.04!important;
  letter-spacing:-.7px!important;
  gap:15px!important;
  margin:0 0 32px!important;
  animation:ozpTituloEntrada .48s ease both;
}
.ozp-panel-titulo .ozp-numero{
  width:clamp(44px,4.2vw,58px)!important;
  height:clamp(44px,4.2vw,58px)!important;
  flex:0 0 clamp(44px,4.2vw,58px)!important;
  font-size:clamp(20px,2vw,27px)!important;
}
.ozp-acceso::before{
  width:clamp(175px,18vw,245px)!important;
  height:clamp(175px,18vw,245px)!important;
  top:-95px!important;right:-86px!important;
  animation:ozpRedondoEntrada .75s cubic-bezier(.2,.75,.25,1) both;
  transition:transform .35s ease!important;
}
.ozp-acceso::after{
  width:clamp(125px,13vw,175px)!important;
  height:clamp(125px,13vw,175px)!important;
  bottom:-78px!important;right:clamp(195px,26%,350px)!important;
  animation:ozpRedondoEntrada .85s .08s cubic-bezier(.2,.75,.25,1) both;
  transition:transform .35s ease!important;
}
.ozp-acceso:hover::before{transform:translate(-7px,8px)}
.ozp-acceso:hover::after{transform:translate(7px,-6px)}
.ozp-select-trigger{
  min-height:62px!important;padding:17px 20px!important;border-radius:19px!important;
  font-size:17px!important;transition:background-color .18s ease,transform .18s ease!important;
}
.ozp-select-trigger:hover{transform:translateY(-1px)}
.ozp-select-lista{animation:ozpListaEntrada .16s ease both;transform-origin:top center}
.ozp-select-opcion{min-height:46px!important;font-size:15px!important;transition:background-color .15s ease,color .15s ease,padding-left .15s ease!important}
.ozp-select-opcion:hover{padding-left:18px!important}
.ozp-cal-nav{
  width:44px!important;height:44px!important;min-width:44px!important;min-height:44px!important;
  aspect-ratio:1/1!important;flex:0 0 44px!important;display:flex!important;align-items:center!important;justify-content:center!important;
  padding:0!important;margin:0!important;line-height:1!important;font-family:Arial,sans-serif!important;
  font-size:30px!important;font-weight:500!important;border:0!important;border-radius:50%!important;
  transform:none!important;transition:background-color .18s ease,color .18s ease,transform .18s ease!important;
}
.ozp-cal-nav:hover{transform:scale(1.07)!important}
.ozp-cal-nav:active{transform:scale(.94)!important}
.ozp-cal-mes{font-size:21px!important;line-height:1.2!important;text-align:center}
.ozp-cal-dia{min-height:34px;transition:background-color .14s ease,color .14s ease,transform .14s ease!important}
.ozp-cal-dia:hover:not(:disabled){transform:scale(1.06)}
.ozp-boton,.ozp-boton-secundario{transition:transform .18s ease,background-color .18s ease,color .18s ease!important}
.ozp-boton:hover,.ozp-boton-secundario:hover{transform:translateY(-2px)}
.ozp-panel{animation:ozpPanelEntrada .42s ease both}
.ozp-resultado{animation-delay:.06s}
@keyframes ozpTituloEntrada{from{opacity:0;transform:translateY(8px)}to{opacity:1;transform:translateY(0)}}
@keyframes ozpRedondoEntrada{from{opacity:.45;scale:.78}to{opacity:1;scale:1}}
@keyframes ozpListaEntrada{from{opacity:0;transform:translateY(-5px) scale(.99)}to{opacity:1;transform:translateY(0) scale(1)}}
@keyframes ozpPanelEntrada{from{opacity:0;transform:translateY(8px)}to{opacity:1;transform:translateY(0)}}
@media(max-width:1100px){
 .ozp-panel-titulo{font-size:clamp(43px,5vw,58px)!important;line-height:1.06!important}
 .ozp-panel-titulo .ozp-numero{width:46px!important;height:46px!important;flex-basis:46px!important;font-size:21px!important}
 .ozp-acceso::before{width:175px!important;height:175px!important;top:-65px!important;right:-65px!important}
 .ozp-acceso::after{width:120px!important;height:120px!important;bottom:-55px!important;right:20%!important}
}
@media(max-width:820px){
 .ozp-panel-titulo{font-size:clamp(38px,6vw,50px)!important;margin-bottom:25px!important;letter-spacing:-.3px!important}
 .ozp-panel-titulo .ozp-numero{width:42px!important;height:42px!important;flex-basis:42px!important;font-size:19px!important}
 .ozp-producto-fecha{grid-template-columns:minmax(0,1fr) minmax(220px,.72fr)!important;gap:16px!important}
 .ozp-agenda{padding:14px!important}
 .ozp-cal-nav{width:42px!important;height:42px!important;min-width:42px!important;min-height:42px!important;flex-basis:42px!important;font-size:28px!important}
}
@media(max-width:600px){
 .ozp-panel-titulo{font-size:clamp(34px,8.4vw,43px)!important;line-height:1.08!important;gap:10px!important;margin-bottom:23px!important}
 .ozp-panel-titulo .ozp-numero{width:38px!important;height:38px!important;flex-basis:38px!important;font-size:17px!important}
 .ozp-acceso::before{width:132px!important;height:132px!important;top:-48px!important;right:-48px!important}
 .ozp-acceso::after{width:94px!important;height:94px!important;bottom:-42px!important;right:14%!important}
 .ozp-select-trigger{min-height:56px!important;padding:14px 16px!important;font-size:15px!important}
 .ozp-select-opcion{font-size:14px!important;min-height:44px!important}
 .ozp-producto-fecha{grid-template-columns:minmax(0,1fr)!important}
 .ozp-agenda{max-width:none!important;width:100%!important}
 .ozp-cal-nav{width:40px!important;height:40px!important;min-width:40px!important;min-height:40px!important;flex-basis:40px!important;font-size:27px!important}
 .ozp-cal-mes{font-size:19px!important}
 .ozp-cal-dias,.ozp-cal-fechas{gap:3px!important}
 .ozp-cal-dia{min-height:32px!important;font-size:12px!important;border-radius:9px!important}
}
@media(prefers-reduced-motion:reduce){
 .ozp-panel-titulo,.ozp-panel,.ozp-acceso::before,.ozp-acceso::after,.ozp-select-lista{animation:none!important;transition:none!important}
 .ozp-acceso:hover::before,.ozp-acceso:hover::after,.ozp-select-trigger:hover,.ozp-cal-nav:hover,.ozp-cal-dia:hover:not(:disabled),.ozp-boton:hover,.ozp-boton-secundario:hover{transform:none!important}
}


/* Ajuste final solicitado: títulos ordenados, decoración beige separada y proporciones estables */
.ozp-panel-titulo{
  display:flex!important;align-items:center!important;flex-wrap:nowrap!important;gap:12px!important;
  font-size:clamp(27px,2.35vw,34px)!important;line-height:1.16!important;letter-spacing:-.35px!important;
  margin:0 0 25px!important;overflow-wrap:normal!important;word-break:normal!important;
  animation:ozpTituloEntrada .32s ease both;
}
.ozp-panel-titulo .ozp-numero{
  display:inline-flex!important;align-items:center!important;justify-content:center!important;
  width:42px!important;height:42px!important;min-width:42px!important;flex:0 0 42px!important;
  font-size:20px!important;line-height:1!important;border-radius:14px!important;
}
.ozp-acceso::after{
  width:clamp(125px,13vw,175px)!important;height:clamp(125px,13vw,175px)!important;
  bottom:-105px!important;right:clamp(195px,26%,350px)!important;
}
@media(max-width:1100px){
 .ozp-panel-titulo{font-size:clamp(26px,3vw,32px)!important;line-height:1.16!important;gap:10px!important}
 .ozp-panel-titulo .ozp-numero{width:40px!important;height:40px!important;min-width:40px!important;flex-basis:40px!important;font-size:19px!important}
 .ozp-acceso::after{bottom:-86px!important;right:clamp(120px,20%,240px)!important}
}
@media(max-width:560px){
 .ozp-panel-titulo{font-size:25px!important;line-height:1.18!important;gap:9px!important;margin-bottom:22px!important;white-space:normal!important}
 .ozp-panel-titulo .ozp-numero{width:36px!important;height:36px!important;min-width:36px!important;flex-basis:36px!important;font-size:17px!important;border-radius:12px!important}
 .ozp-acceso::after{bottom:-70px!important;right:20px!important;width:105px!important;height:105px!important}
}
@media(prefers-reduced-motion:reduce){.ozp-panel-titulo{animation:none!important}}
</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/organiczoneOF/includes/oz-navegacion.php'; ?>

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




    <!-- OZ PLANNING: acceso y módulo interactivo independiente -->
    <section class="ozp-acceso" aria-labelledby="ozp-acceso-titulo">
        <div>
            <span class="ozp-eyebrow"><span class="ozp-punto"></span> MY OZ PRESENTA</span>
            <h2 id="ozp-acceso-titulo">Oz <span>Planning.</span></h2>
            <p>Tu comida, tus preferencias, tu manera. Personaliza una propuesta, explora opciones del menú y crea una ficha para que Organic Zone revise tu solicitud.</p>
            <div class="ozp-acceso-accion" style="margin-top:24px">
                <button type="button" class="ozp-boton" id="ozp-abrir">
                    Diseñar mi platillo
                </button>
                <span class="ozp-acceso-nota">PERSONALIZA · EXPLORA · PLANIFICA</span>
                <?php if (in_array(strtolower($ozUsuarioRol), array('admin', 'vendedor'), true)): ?>
                    <div class="ozp-reportes-wrap">
                        <a class="ozp-reportes-boton" href="reportesOzPlanning.php">Ver reportes recibidos</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="ozp-grafico" aria-hidden="true">
            <div class="ozp-grafico-circulo"></div>
            <div class="ozp-logo-orbita">
                <img class="ozp-logo-imagen" src="logoOz.png" alt="Logo de Organic Zone">
            </div>
            <span class="ozp-grafico-hoja h1"></span><span class="ozp-grafico-hoja h2"></span>
            <span class="ozp-particula ozp-particula-1"></span><span class="ozp-particula ozp-particula-2"></span>
            <span class="ozp-particula ozp-particula-3"></span>
        </div>
    </section>

    <section class="ozp-modulo" id="ozp-modulo" aria-labelledby="ozp-titulo" aria-hidden="true">
        <div class="ozp-cabecera">
            <div>
                <span class="ozp-eyebrow" style="color:var(--verde)"><span class="ozp-punto"></span> TU EXPERIENCIA MY OZ</span>
                <h2 id="ozp-titulo">Oz <span>Planning.</span></h2>
                <p>Diseña una propuesta a tu medida: combina preferencias, explora el menú actual y descubre ideas nuevas para que el equipo de OZ las evalúe. Tu perfil se actualiza al instante.</p>
            </div>
            <button type="button" class="ozp-cerrar" id="ozp-cerrar" aria-label="Cerrar Oz Planning">×</button>
        </div>

        <div class="ozp-layout">
            <form class="ozp-panel" id="ozp-formulario">
                <h3 class="ozp-panel-titulo"><span class="ozp-numero">1</span> Tu perfil de preferencias</h3>
                <div class="ozp-campo">
                    <label for="ozp-estilo">¿Qué tipo de alimentación prefieres?</label>
                    <select id="ozp-estilo" name="estilo">
                        <option value="sin-preferencia">No tengo una preferencia específica</option>
                        <option value="vegetariana">Vegetariana (requiere verificar receta)</option>
                        <option value="vegana">Vegana (requiere verificar receta)</option>
                        <option value="proteina">Busco opciones con más proteínas</option>
                        <option value="fibra">Busco opciones con fibra</option>
                    </select>
                    <small class="ozp-ayuda">Es una preferencia orientativa, no una evaluación médica.</small>
                </div>

                <div class="ozp-campo">
                    <span class="ozp-label">¿Qué ingredientes necesitas evitar o revisar?</span>
                    <div class="ozp-opciones">
                        <label class="ozp-opcion"><input type="checkbox" name="evitar" value="azucar"><span>Azúcar añadido</span></label>
                        <label class="ozp-opcion"><input type="checkbox" name="evitar" value="gluten"><span>Gluten</span></label>
                        <label class="ozp-opcion"><input type="checkbox" name="evitar" value="lacteos"><span>Lácteos</span></label>
                        <label class="ozp-opcion"><input type="checkbox" name="evitar" value="huevo"><span>Huevo</span></label>
                        <label class="ozp-opcion"><input type="checkbox" name="evitar" value="carne"><span>Carne</span></label>
                        <label class="ozp-opcion"><input type="checkbox" name="evitar" value="frutos-secos"><span>Frutos secos</span></label>
                        <label class="ozp-opcion"><input type="checkbox" name="evitar" value="soja"><span>Soja</span></label>
                        <label class="ozp-opcion"><input type="checkbox" name="evitar" value="picante"><span>Picante</span></label>
                    </div>
                    <small class="ozp-ayuda">Si se trata de una alergia o indicación médica, confirma siempre los ingredientes y la preparación con el emprendimiento.</small>
                </div>

                <div class="ozp-perfil-extra">
                    <span class="ozp-label">¿Qué te gustaría priorizar?</span>
                    <div class="ozp-opciones">
                        <label class="ozp-opcion"><input type="checkbox" name="perfilExtra" value="vegano"><span>100% vegetal / vegano</span></label>
                        <label class="ozp-opcion"><input type="checkbox" name="perfilExtra" value="menos-azucar"><span>Menos azúcar añadido</span></label>
                        <label class="ozp-opcion"><input type="checkbox" name="perfilExtra" value="menos-carbohidratos"><span>Menos carbohidratos</span></label>
                        <label class="ozp-opcion"><input type="checkbox" name="perfilExtra" value="sin-dulce"><span>Prefiero sabores no dulces</span></label>
                    </div>
                    <small class="ozp-ayuda">Estas preferencias generan ideas para solicitar al equipo de OZ; no certifican que una receta sea apta para una condición médica.</small>
                </div>

                <h3 class="ozp-panel-titulo"><span class="ozp-numero">2</span> Diseña tu propuesta</h3>
                <div class="ozp-producto-fecha">
                    <div class="ozp-campo ozp-producto-col">
                        <label for="ozp-producto">Elige un producto como punto de partida</label>
                        <select id="ozp-producto" name="producto">
                            <option value="">Recomiéndame opciones del menú</option>
                            <?php foreach ($productos as $productoOzSelect): ?>
                                <option value="<?php echo (int) $productoOzSelect['id']; ?>"><?php echo h($productoOzSelect['nombre']); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <small class="ozp-ayuda">También puedes empezar sin elegir un producto y descubrir ideas nuevas.</small>
                        <div class="ozp-campo ozp-comentario-col">
                            <label for="ozp-modificaciones">¿Qué te gustaría cambiar o comentar?</label>
                            <textarea id="ozp-modificaciones" name="modificaciones" maxlength="600" placeholder="Ej.: quisiera consultar si se puede servir sin una salsa o cambiar un ingrediente..."></textarea>
                            <small class="ozp-ayuda">Al crear la propuesta, el reporte se guardará para que administración y vendedores puedan revisarlo.</small>
                        </div>
                    </div>
                    <div class="ozp-agenda">
                        <div class="ozp-agenda-cabecera">
                            <span class="ozp-agenda-kicker">PLANIFICADOR OZ</span>
                            <span class="ozp-agenda-simbolo" aria-hidden="true">▦</span>
                        </div>
                        <label for="ozp-fecha">Elige una fecha</label>
                        <input type="date" id="ozp-fecha" name="fecha" aria-label="Fecha para planificar">
                        <small>Solo planificación; no es una reserva.</small>
                    </div>
                </div>
                <div class="ozp-campo">
                    <label for="ozp-objetivo">¿Qué te gustaría priorizar?</label>
                    <select id="ozp-objetivo" name="objetivo">
                        <option value="variedad">Variedad y preferencias personales</option>
                        <option value="energia">Información energética disponible</option>
                        <option value="proteina">Comparar proteína declarada</option>
                        <option value="fibra">Comparar fibra declarada</option>
                        <option value="sustituciones">Ideas de sustitución fuera del menú actual</option>
                    </select>
                    <small class="ozp-ayuda">Puedes solicitar cambios que el equipo de Organic Zone evaluará, aunque el ingrediente no figure en el menú actual.</small>
                </div>
                <div class="ozp-acciones-form">
                    <button type="submit" class="ozp-boton">Crear mi propuesta <span aria-hidden="true">→</span></button>
                    <button type="reset" class="ozp-boton-secundario" id="ozp-limpiar">Empezar de nuevo</button>
                </div>
                <p class="ozp-legal">Oz Planning utiliza reglas de coincidencia y la información disponible en el menú. No diagnostica, no prescribe dietas y no garantiza ausencia de alérgenos.</p>
            </form>

            <aside class="ozp-panel ozp-resultado" aria-live="polite" aria-atomic="true">
                <h3 class="ozp-panel-titulo">Tu <span style="color:var(--verde)">resultado.</span></h3>
                <p class="ozp-resultado-intro">Aquí aparecerán las opciones que coincidan con tus preferencias y una explicación de cómo se generó la propuesta.</p>
                <div id="ozp-resultados" class="ozp-resultado-vacio">Completa tus preferencias y pulsa «Crear mi propuesta» para comenzar.</div>
                <div id="ozp-resumen" class="ozp-resumen"></div>
                <div class="ozp-acciones-form" id="ozp-acciones-resultado" hidden>
                    <button type="button" class="ozp-boton" id="ozp-descargar">Descargar ficha</button>
                    <button type="button" class="ozp-boton-secundario" id="ozp-imprimir">Imprimir</button>
                </div>
            </aside>
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
    'use strict';
    var catalogo = <?php echo json_encode($ozPlanningCatalogo, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?> || [];
    var ozpSesionActiva = <?php echo $ozSesionActiva ? 'true' : 'false'; ?>;
    var ozpLoginUrl = 'Usuarios/formulariosesion.php';
    var ozpUsuario = <?php echo json_encode(array('ci' => ($ozUsuarioCi !== '' ? $ozUsuarioCi : 'No disponible'), 'nombre' => ($ozUsuarioNombre !== '' ? $ozUsuarioNombre : 'No disponible'), 'telefono' => ($ozUsuarioTelefono !== '' ? $ozUsuarioTelefono : 'No registrado')), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
    var modulo = document.getElementById('ozp-modulo');
    var acceso = document.querySelector('.ozp-acceso');
    var formulario = document.getElementById('ozp-formulario');
    var resultados = document.getElementById('ozp-resultados');
    var resumen = document.getElementById('ozp-resumen');
    var acciones = document.getElementById('ozp-acciones-resultado');
    var ultimaFicha = '';
    function escaparTextoHTML(valor) { var nodo = document.createElement('span'); nodo.textContent = String(valor == null ? '' : valor); return nodo.innerHTML; }
    var fechaPlan = document.getElementById('ozp-fecha');
    function establecerFechaMinima() {
        if (!fechaPlan) return;
        var hoy = new Date();
        var valor = hoy.getFullYear() + '-' + String(hoy.getMonth()+1).padStart(2,'0') + '-' + String(hoy.getDate()).padStart(2,'0');
        fechaPlan.min = valor;
        if (!fechaPlan.value || fechaPlan.value < valor) fechaPlan.value = valor;
    }
    establecerFechaMinima();
    var evitarPalabras = {
        'azucar': ['azucar','azúcar','jarabe','miel','caramelo','dulce','leche condensada'],
        'carbohidratos': ['pan','arroz','pasta','harina','papa','patata','tortilla','masa'],
        'gluten': ['gluten','trigo','harina de trigo','pan'],
        'lacteos': ['leche','queso','mantequilla','crema','yogur','lacteo','lácteo'],
        'huevo': ['huevo','mayonesa'],
        'carne': ['carne','res','pollo','cerdo','tocino','jamon','jamón','bacon'],
        'frutos-secos': ['mani','maní','almendra','nuez','nueces','avellana','frutos secos'],
        'soja': ['soja','soya'],
        'picante': ['picante','aji','ají','chile','jalapeño'],
        'vegano': ['carne','pollo','res','cerdo','tocino','jamon','jamón','bacon','leche','queso','mantequilla','crema','yogur','huevo','miel','mayonesa']
    };
    function normalizar(texto) {
        return String(texto || '').toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '');
    }
    function solicitarInicioSesionOzPlanning() {
        if (window.Swal && typeof window.Swal.fire === 'function') {
            window.Swal.fire({
                title: '¡Descubre Oz Planning!',
                text: 'Inicia sesión o regístrate para diseñar tu platillo personalizado. También puedes continuar explorando el menú.',
                icon: 'info',
                background: '#FFFDF9',
                showCancelButton: true,
                confirmButtonText: 'Iniciar sesión',
                cancelButtonText: 'Continuar navegando',
                reverseButtons: true,
                buttonsStyling: false,
                customClass: {
                    popup: 'oz-popup',
                    title: 'oz-title',
                    htmlContainer: 'oz-text',
                    confirmButton: 'oz-success',
                    cancelButton: 'oz-cancel'
                }
            }).then(function(resultado) {
                if (resultado.isConfirmed) {
                    window.location.href = ozpLoginUrl;
                }
            });
            return;
        }
        if (window.confirm('Para diseñar tu platillo debes iniciar sesión o registrarte.\n\nAceptar: iniciar sesión.\nCancelar: continuar navegando.')) {
            window.location.href = ozpLoginUrl;
        }
    }
    function abrirModulo() {
        if (!ozpSesionActiva) {
            solicitarInicioSesionOzPlanning();
            return;
        }
        modulo.classList.add('ozp-visible');
        modulo.setAttribute('aria-hidden', 'false');
        document.getElementById('ozp-titulo').setAttribute('tabindex', '-1');
        document.getElementById('ozp-titulo').focus({ preventScroll: true });
        modulo.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
    function cerrarModulo() {
        modulo.classList.remove('ozp-visible');
        modulo.setAttribute('aria-hidden', 'true');
        document.getElementById('ozp-abrir').focus({ preventScroll: true });
        acceso.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
    document.getElementById('ozp-abrir').addEventListener('click', abrirModulo);
    document.getElementById('ozp-cerrar').addEventListener('click', cerrarModulo);
    /* La página Hamburguesas.php sigue siendo pública. Solo al interactuar con la caja de Oz Planning se solicita sesión. */
    var ozpCajaAcceso = document.querySelector('.ozp-acceso');
    if (ozpCajaAcceso) {
        ozpCajaAcceso.addEventListener('click', function(evento) {
            if (ozpSesionActiva) return;
            if (evento.target.closest('#ozp-abrir')) return;
            if (evento.target.closest('a')) return;
            solicitarInicioSesionOzPlanning();
        });
    }

    function textoProducto(p) { return normalizar(p.nombre + ' ' + p.descripcion); }
    function conflicto(p, restricciones) {
        var texto = textoProducto(p);
        var coincidencias = [];
        restricciones.forEach(function (clave) {
            var palabras = evitarPalabras[clave] || [];
            if (palabras.some(function (palabra) { return texto.indexOf(normalizar(palabra)) !== -1; })) {
                coincidencias.push(clave.replace('-', ' '));
            }
        });
        return coincidencias;
    }
    function puntuacion(p, estilo, objetivo) {
        var texto = textoProducto(p), puntos = 0, razones = [];
        if (estilo === 'vegetariana' || estilo === 'vegana') {
            if (/vegetarian|vegetariana|vegetariano|vegana|vegano|veggie|lenteja|garbanzo|vegetal/.test(texto)) {
                puntos += 4; razones.push('El nombre o la descripción sugiere una opción vegetal; confirma la receta completa.');
            } else if (/pollo|res|carne|cerdo|tocino|jamon|jamón|bacon/.test(texto)) {
                puntos -= 5;
            }
        } else if (estilo === 'proteina') {
            if (p.nutricionDisponible && Number(p.proteinas) >= 15) { puntos += 3; razones.push('Tiene proteína declarada en la ficha nutricional disponible.'); }
            else if (/proteina|proteína|lenteja|garbanzo|pollo|carne/.test(texto)) { puntos += 1; razones.push('El nombre o la descripción contiene términos asociados a proteína; verifica la información del producto.'); }
        } else if (estilo === 'fibra') {
            if (p.nutricionDisponible && Number(p.fibra) >= 5) { puntos += 3; razones.push('Tiene fibra declarada en la ficha nutricional disponible.'); }
            else if (/integral|lenteja|garbanzo|vegetal|verdura/.test(texto)) { puntos += 1; razones.push('El nombre o la descripción sugiere ingredientes vegetales; revisa los datos nutricionales.'); }
        }
        if (objetivo === 'energia' && p.nutricionDisponible) { puntos += 1; razones.push('Hay información energética de referencia disponible.'); }
        if (objetivo === 'proteina' && p.nutricionDisponible && p.proteinas !== null) { puntos += 1; }
        if (objetivo === 'fibra' && p.nutricionDisponible && p.fibra !== null) { puntos += 1; }
        if (p.stock <= 0) { puntos -= 2; razones.push('Actualmente figura sin stock.'); }
        if (!razones.length) razones.push('Se incluye como opción del catálogo para revisar según tus preferencias.');
        return { puntos: puntos, razones: razones };
    }
    function escapar(texto) {
        return String(texto == null ? '' : texto).replace(/[&<>"']/g, function (c) {
            return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c];
        });
    }
    function obtenerSeleccionados() {
        return Array.prototype.slice.call(formulario.querySelectorAll('input[name="evitar"]:checked')).map(function (el) { return el.value; });
    }
    function nombreRestriccion(clave) {
        var labels = {'azucar':'azúcar añadido','gluten':'gluten','lacteos':'lácteos','huevo':'huevo','carne':'carne','frutos-secos':'frutos secos','soja':'soja','picante':'picante','carbohidratos':'fuentes de carbohidratos a revisar','vegano':'ingredientes de origen animal a revisar'};
        return labels[clave] || clave;
    }
    function obtenerIdeasSustitucion(perfiles) {
        var ideas = [];
        if (perfiles.indexOf('vegano') !== -1) {
            ideas.push({titulo:'Versión 100% vegetal', texto:'Solicitar una proteína vegetal (por ejemplo, lentejas, garbanzos o legumbres), retirar queso, huevo y salsas de origen animal, y confirmar todos los ingredientes.'});
            ideas.push({titulo:'Salsa vegetal', texto:'Consultar una salsa de vegetales, hierbas, limón o palta sin lácteos, huevo ni miel.'});
        }
        if (perfiles.indexOf('menos-azucar') !== -1 || perfiles.indexOf('sin-dulce') !== -1) {
            ideas.push({titulo:'Sabor sin dulzor añadido', texto:'Pedir que se omitan jarabes, miel y salsas dulces; valorar limón, hierbas, tomate natural o una salsa salada sin azúcar añadido confirmado.'});
        }
        if (perfiles.indexOf('menos-carbohidratos') !== -1) {
            ideas.push({titulo:'Alternativa al pan o la masa', texto:'Consultar si se puede servir el relleno sobre hojas de lechuga o verduras, o reducir la porción de pan/masa. La composición final debe confirmarse con el equipo.'});
            ideas.push({titulo:'Acompañamiento alternativo', texto:'Solicitar verduras frescas o cocidas en lugar de un acompañamiento basado principalmente en pan, arroz o papa, si está disponible.'});
        }
        if (!ideas.length) {
            ideas.push({titulo:'Personalización abierta', texto:'Escribe en tu solicitud qué ingrediente deseas cambiar y el equipo de Organic Zone podrá evaluar una alternativa fuera del menú publicado.'});
        }
        return ideas;
    }
    function porcentajeCompatibilidad(p, estilo, objetivo, restricciones, perfiles) {
        var texto = textoProducto(p), total = 2, logrados = p.stock > 0 ? 2 : 0;
        // Afinidad heurística explicable; no representa una probabilidad estadística.
        if (estilo === 'vegana' || perfiles.indexOf('vegano') !== -1) { total += 3; if (/vegano|vegana|100% vegetal/.test(texto)) logrados += 3; }
        else if (estilo === 'vegetariana') { total += 2; if (/vegetarian|vegetariana|vegetariano|vegana|vegano|veggie|lenteja|garbanzo|vegetal/.test(texto) && !/pollo|res|carne|cerdo|tocino|jamon|bacon/.test(texto)) logrados += 2; }
        if (estilo === 'proteina' || objetivo === 'proteina') { total += 2; if (p.nutricionDisponible && Number(p.proteinas) >= 15) logrados += 2; else if (/proteina|lenteja|garbanzo|pollo|carne/.test(texto)) logrados += 1; }
        if (estilo === 'fibra' || objetivo === 'fibra') { total += 2; if (p.nutricionDisponible && Number(p.fibra) >= 5) logrados += 2; else if (/integral|lenteja|garbanzo|vegetal|verdura/.test(texto)) logrados += 1; }
        if (perfiles.indexOf('menos-azucar') !== -1 || restricciones.indexOf('azucar') !== -1) { total += 2; if (p.nutricionDisponible && Number(p.azucares) <= 5) logrados += 2; else if (!/azucar|jarabe|miel|caramelo|dulce/.test(texto)) logrados += 1; }
        if (perfiles.indexOf('menos-carbohidratos') !== -1 || restricciones.indexOf('carbohidratos') !== -1) { total += 2; if (!/pan|arroz|pasta|harina|papa|patata|tortilla|masa/.test(texto)) logrados += 1; }
        total += restricciones.length;
        restricciones.forEach(function(k) { var words = evitarPalabras[k] || []; if (!words.some(function(w){ return texto.indexOf(normalizar(w)) !== -1; })) logrados += 1; });
        return Math.max(0, Math.min(99, Math.round(logrados / Math.max(1,total) * 100)));
    }
    function obtenerIdeasExternas(perfiles, restricciones, estilo) {
        var ideas = [
            {titulo:'Bowl vegetal de legumbres', texto:'Base de lentejas o garbanzos, verduras frescas, hierbas y limón; propuesta nueva fuera del menú actual. Confirmar disponibilidad, receta y costo.', claves:['vegano','vegetariana'], base:62},
            {titulo:'Wrap de lechuga crujiente', texto:'Hojas de lechuga en lugar de pan, con verduras y una proteína elegida; alternativa a evaluar para reducir carbohidratos.', claves:['menos-carbohidratos'], base:67},
            {titulo:'Salsa cítrica sin dulzor', texto:'Limón y hierbas en una salsa salada sin miel ni jarabes añadidos; verificar ingredientes y cantidades antes de ofrecerla.', claves:['menos-azucar','sin-dulce','azucar'], base:65},
            {titulo:'Hamburguesa de lentejas', texto:'Medallón de legumbres con aglutinante adecuado, verduras y salsa vegetal. No asumir que es libre de gluten sin revisar la receta.', claves:['vegano','vegetariana'], base:68},
            {titulo:'Acompañamiento de verduras', texto:'Verduras frescas o salteadas en lugar de papas, arroz o pan; el equipo debe confirmar preparación, costo y disponibilidad.', claves:['menos-carbohidratos'], base:66},
            {titulo:'Salsa de palta y hierbas', texto:'Palta, limón y hierbas como propuesta salada; comprobar alérgenos, conservación y costo.', claves:['vegano','sin-dulce','menos-azucar'], base:64}
        ];
        ideas.forEach(function(i){ var n=i.claves.filter(function(k){return perfiles.indexOf(k)!==-1 || restricciones.indexOf(k)!==-1 || estilo===k;}).length; i.compat=Math.min(96,Math.max(58,Math.round(i.base+n/Math.max(1,i.claves.length)*20))); });
        return ideas.sort(function(a,b){return b.compat-a.compat;}).slice(0,4);
    }
    function crearPropuesta(evento) {
        if (evento) evento.preventDefault();
        var estilo = document.getElementById('ozp-estilo').value;
        var objetivo = document.getElementById('ozp-objetivo').value;
        var productoElegido = document.getElementById('ozp-producto').value;
        var modificaciones = document.getElementById('ozp-modificaciones').value.trim();
        var restricciones = obtenerSeleccionados();
        var perfilesExtra = Array.prototype.slice.call(formulario.querySelectorAll('input[name="perfilExtra"]:checked')).map(function (el) { return el.value; });
        /* No generar resultados con el formulario vacío o solo con valores predeterminados. */
        var hayDatosReales = estilo !== 'sin-preferencia' || objetivo !== 'variedad' || productoElegido !== '' || modificaciones.length > 0 || restricciones.length > 0 || perfilesExtra.length > 0;
        if (!hayDatosReales) {
            var mensaje = 'Elige al menos una preferencia, un ingrediente que quieras revisar, un producto o escribe un comentario para crear una propuesta útil.';
            if (window.Swal && typeof window.Swal.fire === 'function') {
                window.Swal.fire({
                    title: '¡Completa tu idea primero!',
                    text: mensaje,
                    icon: 'warning',
                    iconColor: '#FFC982',
                    background: '#FFFDF9',
                    confirmButtonText: 'Volver al formulario',
                    buttonsStyling: false,
                    customClass: { popup: 'oz-popup', title: 'oz-title', htmlContainer: 'oz-text', confirmButton: 'oz-success' }
                });
            } else {
                window.alert(mensaje);
            }
            var primerCampo = document.getElementById('ozp-estilo');
            if (primerCampo) primerCampo.focus({ preventScroll: true });
            return;
        }
        if (perfilesExtra.indexOf('vegano') !== -1 && restricciones.indexOf('vegano') === -1) restricciones.push('vegano');
        if (perfilesExtra.indexOf('menos-azucar') !== -1 && restricciones.indexOf('azucar') === -1) restricciones.push('azucar');
        if (perfilesExtra.indexOf('menos-carbohidratos') !== -1 && restricciones.indexOf('carbohidratos') === -1) restricciones.push('carbohidratos');
        var ideasSustitucion = obtenerIdeasSustitucion(perfilesExtra);
        var evaluados = catalogo.filter(function (p) { return Number(p.stock) > 0; }).map(function (p) {
            var conflictos = conflicto(p, restricciones);
            var score = puntuacion(p, estilo, objetivo);
            var compatibilidad = porcentajeCompatibilidad(p, estilo, objetivo, restricciones, perfilesExtra);
            return { producto: p, conflictos: conflictos, score: score, compatibilidad: compatibilidad };
        }).filter(function (item) {
            if (item.conflictos.length !== 0) return false;
            if (perfilesExtra.indexOf('vegano') !== -1) {
                var declaracion = normalizar(item.producto.nombre + ' ' + item.producto.descripcion);
                return /vegano|vegana|100% vegetal/.test(declaracion);
            }
            return true;
        });
        if (productoElegido) {
            evaluados.sort(function (a,b) {
                if (String(a.producto.id) === String(productoElegido)) return -1;
                if (String(b.producto.id) === String(productoElegido)) return 1;
                return b.score.puntos - a.score.puntos;
            });
        } else {
            evaluados.sort(function (a,b) { return b.score.puntos - a.score.puntos; });
        }
        var encontrados = evaluados.slice(0, 3);
        var tituloEstilo = {'sin-preferencia':'preferencias generales','vegetariana':'preferencia vegetariana','vegana':'preferencia vegana (requiere confirmar receta)','proteina':'interés en proteína','fibra':'interés en fibra'}[estilo] || estilo;
        var restriccionesTexto = restricciones.length ? restricciones.map(nombreRestriccion).join(', ') : 'No indicadas';
        var objetivoTexto = {'variedad':'variedad y preferencias personales','energia':'información energética disponible','proteina':'comparación de proteína declarada','fibra':'comparación de fibra declarada'}[objetivo] || objetivo;
        var html = '';
        if (!catalogo.length) {
            html = '<div class="ozp-sin-productos">No hay productos disponibles en el catálogo para generar recomendaciones.</div>';
        } else if (!encontrados.length) {
            html = '<div class="ozp-sin-productos">No encontramos opciones disponibles sin coincidencias con las palabras de alerta seleccionadas. Prueba otros criterios o consulta directamente con Organic Zone.</div>';
        } else {
            html = '<div class="ozp-resultado-lista">';
            encontrados.forEach(function (item, i) {
                var p = item.producto;
                var razon = item.score.razones[0];
                html += '<article class="ozp-recomendacion">' +
                    '<img src="' + escapar(p.imagen) + '" alt="" loading="lazy">' +
                    '<div><span class="ozp-etiqueta">OPCIÓN ' + (i + 1) + '</span>' +
                    '<h4>' + escapar(p.nombre) + '</h4>' +
                    '<p>' + escapar(razon) + '</p>' +
                    '<span class="ozp-confianza">Coincidencia estimada: ' + item.compatibilidad + '%</span>' +
                    '<div class="ozp-confianza-barra" aria-label="Coincidencia estimada ' + item.compatibilidad + '%"><span style="width:' + item.compatibilidad + '%"></span></div>' +
                    '<strong>Bs. ' + Number(p.precio).toLocaleString('es-BO', {maximumFractionDigits:0}) + '</strong>' +
                    (p.nutricionDisponible ? '<p>Referencia: ' + Number(p.kcal) + ' kcal por porción (dato orientativo).</p>' : '<p>Sin datos nutricionales registrados para este producto.</p>') +
                    '</div></article>';
            });
            html += '</div>';
        }
        html += '<h3 class="ozp-subtitulo-resultado">Ideas para pedir a OZ</h3><div class="ozp-sustituciones">' + ideasSustitucion.map(function (idea) { return '<article class="ozp-sustitucion"><strong>' + escapar(idea.titulo) + '</strong><p>' + escapar(idea.texto) + '</p></article>'; }).join('') + '</div>';
        var ideasExternas = obtenerIdeasExternas(perfilesExtra, restricciones, estilo);
        html += '<h3 class="ozp-subtitulo-resultado">Explora ideas fuera del menú actual</h3><p class="ozp-ayuda">Estas son propuestas nuevas para evaluar, no productos que ya estén a la venta. El porcentaje representa afinidad estimada según tus elecciones, no una probabilidad real ni garantía de ingredientes.</p><div class="ozp-ideas-externas">' + ideasExternas.map(function(idea){ return '<article class="ozp-idea-externa"><span class="ozp-confianza">Afinidad estimada: '+idea.compat+'%</span><strong>'+escapar(idea.titulo)+'</strong><p>'+escapar(idea.texto)+'</p></article>'; }).join('') + '</div>';
        resultados.className = '';
        resultados.innerHTML = html;
        var seleccion = productoElegido ? catalogo.find(function (p) { return String(p.id) === String(productoElegido); }) : null;
        var seleccionTexto = seleccion ? seleccion.nombre : 'Recomendación abierta desde el catálogo';
        var fechaElegida = fechaPlan && fechaPlan.value ? fechaPlan.value : 'Sin fecha elegida';
        resumen.innerHTML = '<h3>Tu ficha OZ</h3>' +
            '<p><strong>CI:</strong> ' + escapar(ozpUsuario.ci) + '</p>' +
            '<p><strong>Usuario:</strong> ' + escapar(ozpUsuario.nombre) + '</p>' +
            '<p><strong>Teléfono:</strong> ' + escapar(ozpUsuario.telefono) + '</p>' +
            '<p><strong>Fecha de planificación:</strong> ' + escapar(fechaElegida) + ' (orientativa, no es reserva).</p>' +
            '<p><strong>Perfil:</strong> ' + escapar(tituloEstilo) + '</p>' +
            '<p><strong>Prioridad:</strong> ' + escapar(objetivoTexto) + '</p>' +
            '<p><strong>Preferencias adicionales:</strong> ' + escapar(perfilesExtra.length ? perfilesExtra.join(', ') : 'No indicadas') + '</p>' +
            '<h3>Ideas de sustitución</h3><ul>' + ideasSustitucion.map(function (idea) { return '<li><strong>' + escapar(idea.titulo) + ':</strong> ' + escapar(idea.texto) + '</li>'; }).join('') + '</ul>' +
            '<p><strong>Ingredientes a revisar:</strong> ' + escapar(restriccionesTexto) + '</p>' +
            '<p><strong>Producto de partida:</strong> ' + escapar(seleccionTexto) + '</p>' +
            '<p><strong>Solicitud:</strong> ' + escapar(modificaciones || 'Sin modificaciones adicionales indicadas.') + '</p>' +
            '<p>La propuesta se generó con reglas locales y el reporte se guarda en Organic Zone para revisión del equipo.</p>' +
            '<p>Antes de preparar o consumir el producto, confirma la receta, los ingredientes y la información nutricional con Organic Zone, especialmente ante alergias o condiciones médicas.</p>';
        resumen.classList.add('ozp-resumen-visible');
        acciones.hidden = true;
        ultimaFicha = 'OZ PLANNING — ORGANIC ZONE\nFICHA DE PERSONALIZACIÓN\n\n' +
            'Perfil: ' + tituloEstilo + '\nPrioridad: ' + objetivoTexto + '\nIngredientes a revisar: ' + restriccionesTexto +
            '\nProducto de partida: ' + seleccionTexto + '\nFecha de planificación: ' + fechaElegida + ' (no es reserva)\nSolicitud: ' + (modificaciones || 'Sin modificaciones adicionales indicadas.') +
            '\n\nOpciones sugeridas:\n' + (encontrados.length ? encontrados.map(function (item, i) { return (i+1)+'. '+item.producto.nombre+' — Bs. '+Number(item.producto.precio).toFixed(2)+'\n   '+item.score.razones.join(' '); }).join('\n') : 'No se encontraron opciones sin coincidencias de alerta.') +
            '\n\nIDEAS FUERA DEL MENÚ (para evaluar):\n' + obtenerIdeasExternas(perfilesExtra, restricciones, estilo).map(function(idea){return '- '+idea.titulo+' ('+idea.compat+'% de afinidad estimada): '+idea.texto;}).join('\n') +
            '\n\nDATOS DEL USUARIO\nCI: ' + ozpUsuario.ci + '\nNombre: ' + ozpUsuario.nombre + '\nTeléfono: ' + ozpUsuario.telefono + '\n\nNOTA: los porcentajes son afinidad heurística, no probabilidades estadísticas. Recomendación orientativa por reglas locales. No es una indicación médica ni garantiza ausencia de alérgenos. Confirmar ingredientes y preparación con el emprendimiento.';
        guardarReporteServidor();
        resumen.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
    async function guardarReporteServidor() {
        var datos = new FormData(formulario);
        var envio = new FormData();
        envio.append('ozp_action', 'guardar_reporte');
        envio.append('ficha', ultimaFicha);
        envio.append('perfil', datos.get('estilo') || '');
        envio.append('preferencias', datos.getAll('perfilExtra').join(', '));
        envio.append('restricciones', datos.getAll('evitar').join(', '));
        var selectorProducto = document.getElementById('ozp-producto');
        envio.append('producto', selectorProducto && selectorProducto.selectedIndex >= 0 ? selectorProducto.options[selectorProducto.selectedIndex].text : '');
        envio.append('modificaciones', document.getElementById('ozp-modificaciones').value.trim());
        envio.append('fecha_plan', fechaPlan && fechaPlan.value ? fechaPlan.value : '');
        resumen.insertAdjacentHTML('beforeend', '<p id="ozp-estado-guardado"><strong>Guardando el reporte para el equipo de OZ…</strong></p>');
        try {
            var respuesta = await fetch(window.location.href.split('#')[0], { method: 'POST', body: envio, credentials: 'same-origin' });
            var datosRespuesta = await respuesta.json();
            var estado = document.getElementById('ozp-estado-guardado');
            if (!respuesta.ok || !datosRespuesta.ok) throw new Error(datosRespuesta.mensaje || 'No se pudo guardar el reporte.');
            if (estado) estado.innerHTML = '<strong>Reporte guardado correctamente en el archivo TXT.</strong> El equipo autorizado puede consultarlo desde el panel. Código: ' + escaparTextoHTML(datosRespuesta.codigo) + '.';
            acciones.hidden = false;
            ultimaFicha += '\nCódigo de reporte: ' + datosRespuesta.codigo + '\nCI: ' + ozpUsuario.ci + '\nNombre: ' + ozpUsuario.nombre + '\nTeléfono: ' + ozpUsuario.telefono + '\nEstado: Nuevo — pendiente de revisión por Organic Zone.\n';
        } catch (error) {
            var estadoError = document.getElementById('ozp-estado-guardado');
            if (estadoError) estadoError.remove();
            if (window.Swal && typeof window.Swal.fire === 'function') {
                window.Swal.fire({ title: 'No se pudo enviar el reporte', text: error.message || 'Comprueba tu conexión e inténtalo otra vez.', icon: 'error', background: '#FFFDF9', confirmButtonText: 'Entendido', buttonsStyling: false, customClass: { popup: 'oz-popup', title: 'oz-title', htmlContainer: 'oz-text', confirmButton: 'oz-success' } });
            } else { window.alert(error.message || 'No se pudo guardar el reporte.'); }
            acciones.hidden = true;
        }
    }

    formulario.addEventListener('submit', crearPropuesta);
    formulario.addEventListener('reset', function () {
        window.setTimeout(function () {
            resultados.className = 'ozp-resultado-vacio';
            resultados.textContent = 'Completa tus preferencias y pulsa «Crear mi propuesta» para comenzar.';
            resumen.classList.remove('ozp-resumen-visible');
            resumen.innerHTML = '';
            acciones.hidden = true;
            ultimaFicha = '';
            establecerFechaMinima();
        }, 0);
    });
    function avisarFichaNoGenerada() {
        var mensaje = 'Completa el formulario y pulsa «Crear mi propuesta» antes de descargar o imprimir la ficha.';
        if (window.Swal && typeof window.Swal.fire === 'function') {
            window.Swal.fire({
                title: '¡Primero crea tu propuesta!',
                text: mensaje,
                icon: 'warning',
                iconColor: '#FFC982',
                background: '#FFFDF9',
                confirmButtonText: 'Volver al formulario',
                buttonsStyling: false,
                customClass: { popup: 'oz-popup', title: 'oz-title', htmlContainer: 'oz-text', confirmButton: 'oz-success' }
            });
        } else {
            window.alert(mensaje);
        }
        var primerCampo = document.getElementById('ozp-estilo');
        if (primerCampo) primerCampo.focus({ preventScroll: true });
    }

    document.getElementById('ozp-descargar').addEventListener('click', function () {
        if (!ultimaFicha) { avisarFichaNoGenerada(); return; }
        var blob = new Blob([ultimaFicha], { type: 'text/plain;charset=utf-8' });
        var url = URL.createObjectURL(blob);
        var enlace = document.createElement('a');
        enlace.href = url; enlace.download = 'Oz-Planning-ficha.txt';
        document.body.appendChild(enlace); enlace.click(); enlace.remove(); URL.revokeObjectURL(url);
    });
    document.getElementById('ozp-imprimir').addEventListener('click', function () {
        if (!ultimaFicha) { avisarFichaNoGenerada(); return; }
        var ventana = window.open('', '_blank', 'width=760,height=850');
        if (!ventana) { window.alert('Permite las ventanas emergentes para imprimir la ficha. También puedes descargarla.'); return; }
        ventana.document.open();
        ventana.document.write('<!doctype html><html lang="es"><head><meta charset="utf-8"><title>Ficha Oz Planning</title><style>body{font-family:Arial,sans-serif;color:#2B140D;max-width:760px;margin:40px auto;padding:0 24px;line-height:1.6}h1{font-size:30px}pre{white-space:pre-wrap;overflow-wrap:anywhere;font:15px/1.65 Arial,sans-serif}strong{color:#0BA84A}</style></head><body><h1>Oz Planning · Organic Zone</h1><pre id="ficha"></pre></body></html>');
        ventana.document.close();
        ventana.document.getElementById('ficha').textContent = ultimaFicha;
        ventana.focus(); ventana.print();
    });
})();
</script>

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


<script>
/* Selectores Organic Zone y calendario propio. Sin librerías externas. */
(function(){
 'use strict';
 function personalizarSelect(select){
   if(!select || select.dataset.ozpCustom==='1') return;
   select.dataset.ozpCustom='1'; select.classList.add('ozp-select-original');
   var wrap=document.createElement('div'); wrap.className='ozp-select-custom';
   var trigger=document.createElement('button'); trigger.type='button'; trigger.className='ozp-select-trigger'; trigger.setAttribute('aria-haspopup','listbox'); trigger.setAttribute('aria-expanded','false');
   var label=document.createElement('span'); label.className='ozp-select-valor';
   var arrow=document.createElement('span'); arrow.className='ozp-select-flecha'; arrow.setAttribute('aria-hidden','true'); trigger.append(label,arrow);
   var list=document.createElement('div'); list.className='ozp-select-lista'; list.setAttribute('role','listbox'); list.tabIndex=-1;
   select.parentNode.insertBefore(wrap,select); wrap.append(select,trigger,list);
   var opts=[];
   function sync(){var opt=select.options[select.selectedIndex];label.textContent=opt?opt.textContent:'Selecciona una opción';opts.forEach(function(b,i){b.setAttribute('aria-selected',String(select.options[i].selected));});}
   Array.prototype.forEach.call(select.options,function(opt,i){var b=document.createElement('button');b.type='button';b.className='ozp-select-opcion';b.setAttribute('role','option');b.textContent=opt.textContent;b.setAttribute('aria-selected',String(opt.selected));b.addEventListener('click',function(){select.selectedIndex=i;select.dispatchEvent(new Event('change',{bubbles:true}));sync();close();trigger.focus();});list.appendChild(b);opts.push(b);});
   function open(){document.querySelectorAll('.ozp-select-custom.esta-abierto').forEach(function(other){if(other!==wrap){other.classList.remove('esta-abierto');var t=other.querySelector('.ozp-select-trigger');if(t)t.setAttribute('aria-expanded','false');}});wrap.classList.add('esta-abierto');trigger.setAttribute('aria-expanded','true');var active=opts[Math.max(0,select.selectedIndex)];if(active)active.focus();}
   function close(){wrap.classList.remove('esta-abierto');trigger.setAttribute('aria-expanded','false');}
   trigger.addEventListener('click',function(){wrap.classList.contains('esta-abierto')?close():open();});
   trigger.addEventListener('keydown',function(e){if(['ArrowDown','ArrowUp','Enter',' '].indexOf(e.key)>=0){e.preventDefault();open();}});
   list.addEventListener('keydown',function(e){var i=opts.indexOf(document.activeElement);if(e.key==='Escape'){e.preventDefault();close();trigger.focus();}else if(e.key==='ArrowDown'){e.preventDefault();opts[Math.min(opts.length-1,i+1)].focus();}else if(e.key==='ArrowUp'){e.preventDefault();opts[Math.max(0,i-1)].focus();}else if(e.key==='Home'){e.preventDefault();opts[0].focus();}else if(e.key==='End'){e.preventDefault();opts[opts.length-1].focus();}else if(e.key==='Tab'){close();}});
   select.addEventListener('change',sync); sync();
   document.addEventListener('click',function(e){if(!wrap.contains(e.target))close();});
 }
 document.querySelectorAll('#ozp-formulario select').forEach(personalizarSelect);
 var input=document.getElementById('ozp-fecha'); if(!input)return;
 input.classList.add('ozp-fecha-original');
 var cal=document.createElement('div');cal.className='ozp-calendario';cal.setAttribute('aria-label','Calendario para elegir fecha');input.parentNode.insertBefore(cal,input);
 var now=new Date();now.setHours(0,0,0,0);var view=new Date(now.getFullYear(),now.getMonth(),1);
 function iso(d){return d.getFullYear()+'-'+String(d.getMonth()+1).padStart(2,'0')+'-'+String(d.getDate()).padStart(2,'0');}
 function render(){cal.innerHTML='';var head=document.createElement('div');head.className='ozp-cal-cabecera';var prev=document.createElement('button');prev.type='button';prev.className='ozp-cal-nav';prev.textContent='‹';prev.setAttribute('aria-label','Mes anterior');var month=document.createElement('strong');month.className='ozp-cal-mes';month.textContent=view.toLocaleDateString('es',{month:'long',year:'numeric'});var next=document.createElement('button');next.type='button';next.className='ozp-cal-nav';next.textContent='›';next.setAttribute('aria-label','Mes siguiente');prev.addEventListener('click',function(){view=new Date(view.getFullYear(),view.getMonth()-1,1);render();});next.addEventListener('click',function(){view=new Date(view.getFullYear(),view.getMonth()+1,1);render();});head.append(prev,month,next);cal.appendChild(head);
 var days=document.createElement('div');days.className='ozp-cal-dias';['L','M','X','J','V','S','D'].forEach(function(x){var e=document.createElement('span');e.textContent=x;days.appendChild(e);});cal.appendChild(days);
 var grid=document.createElement('div');grid.className='ozp-cal-fechas';var first=new Date(view.getFullYear(),view.getMonth(),1);var offset=(first.getDay()+6)%7;var count=new Date(view.getFullYear(),view.getMonth()+1,0).getDate();for(var z=0;z<offset;z++){var blank=document.createElement('span');blank.className='ozp-cal-dia vacio';grid.appendChild(blank);}for(var n=1;n<=count;n++){(function(day){var d=new Date(view.getFullYear(),view.getMonth(),day);d.setHours(0,0,0,0);var b=document.createElement('button');b.type='button';b.className='ozp-cal-dia';b.textContent=day;b.setAttribute('aria-label',d.toLocaleDateString('es',{day:'numeric',month:'long',year:'numeric'}));if(iso(d)===iso(now))b.classList.add('hoy');if(input.value===iso(d)){b.classList.add('seleccionado');b.setAttribute('aria-pressed','true');}if(d<now)b.disabled=true;b.addEventListener('click',function(){input.value=iso(d);input.dispatchEvent(new Event('change',{bubbles:true}));render();});grid.appendChild(b);})(n);}cal.appendChild(grid);
 }
 if(!input.value||input.value<iso(now))input.value=iso(now);view=new Date(input.value+'T12:00:00');view.setDate(1);render();input.addEventListener('change',function(){if(input.value){view=new Date(input.value+'T12:00:00');view.setDate(1);render();}});
})();
</script>

</body>

</html>

<?php

$conexion->close();

?>