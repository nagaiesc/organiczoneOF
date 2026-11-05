<?php
session_start();

if (empty($_SESSION['rol']) || empty($_SESSION['nombre'])) {
    header('Location: Usuarios/formulariosesion.php');
    exit;
}

$rol = strtolower(trim((string) $_SESSION['rol']));
if (!in_array($rol, array('admin', 'vendedor'), true)) {
    http_response_code(403);
    echo 'No tienes permiso para consultar los reportes de Oz Planning.';
    exit;
}

$archivo = __DIR__ . DIRECTORY_SEPARATOR . 'datosOzPlanning' . DIRECTORY_SEPARATOR . 'oz_planning_reportes.txt';
function oz_e($valor) { return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8'); }
function oz_valor($reporte, $campo, $alternativo = 'No indicado') {
    if (!isset($reporte[$campo]) || trim((string) $reporte[$campo]) === '') return $alternativo;
    return (string) $reporte[$campo];
}

$q = trim((string) ($_GET['q'] ?? ''));
$todos = array();
$avisoArchivo = '';
if (is_file($archivo) && is_readable($archivo)) {
    $fp = @fopen($archivo, 'rb');
    if ($fp) {
        if (flock($fp, LOCK_SH)) {
            while (($linea = fgets($fp)) !== false) {
                $registro = json_decode(trim($linea), true);
                if (is_array($registro) && isset($registro['codigo'])) $todos[] = $registro;
            }
            flock($fp, LOCK_UN);
        } else {
            $avisoArchivo = 'No se pudo bloquear el archivo para leerlo. Vuelve a cargar esta página.';
        }
        fclose($fp);
    } else {
        $avisoArchivo = 'No se pudo abrir el archivo de reportes. Comprueba los permisos de la carpeta datosOzPlanning.';
    }
} else {
    $avisoArchivo = 'Todavía no se ha creado el archivo de reportes. Aparecerá automáticamente cuando se guarde la primera solicitud desde Oz Planning.';
}

/* Completa teléfonos ausentes de reportes anteriores consultando el perfil en usuarios.
   No sobrescribe los datos que ya están guardados en el archivo TXT. */
$ozUsuariosPorCi = array();
$ozUsuariosPorNombre = array();
$ozDb = @new mysqli('localhost', 'root', '', 'organiczoneBD');
if (!$ozDb->connect_error) {
    $ozDb->set_charset('utf8mb4');
    $ozResUsuarios = @$ozDb->query('SELECT CI, nombre, celular FROM usuarios');
    if ($ozResUsuarios) {
        while ($ozU = $ozResUsuarios->fetch_assoc()) {
            $ozCiClave = trim((string)($ozU['CI'] ?? ''));
            $ozNombreClave = mb_strtolower(trim((string)($ozU['nombre'] ?? '')), 'UTF-8');
            $ozCelular = trim((string)($ozU['celular'] ?? ''));
            if ($ozCelular !== '') {
                if ($ozCiClave !== '') $ozUsuariosPorCi[$ozCiClave] = $ozCelular;
                if ($ozNombreClave !== '') $ozUsuariosPorNombre[$ozNombreClave] = $ozCelular;
            }
        }
        $ozResUsuarios->free();
    }
    $ozDb->close();
}
foreach ($todos as &$ozRegistro) {
    if (trim((string)($ozRegistro['telefono_usuario'] ?? '')) === '') {
        $ozCiRegistro = trim((string)($ozRegistro['usuario_ci'] ?? ''));
        $ozNombreRegistro = mb_strtolower(trim((string)($ozRegistro['nombre_usuario'] ?? '')), 'UTF-8');
        if ($ozCiRegistro !== '' && isset($ozUsuariosPorCi[$ozCiRegistro])) {
            $ozRegistro['telefono_usuario'] = $ozUsuariosPorCi[$ozCiRegistro];
        } elseif ($ozNombreRegistro !== '' && isset($ozUsuariosPorNombre[$ozNombreRegistro])) {
            $ozRegistro['telefono_usuario'] = $ozUsuariosPorNombre[$ozNombreRegistro];
        }
    }
}
unset($ozRegistro);

$reportes = array();
foreach ($todos as $registro) {
    $busqueda = implode(' ', array(
        (string) ($registro['codigo'] ?? ''),
        (string) ($registro['usuario_ci'] ?? ''),
        (string) ($registro['nombre_usuario'] ?? ''),
        (string) ($registro['telefono_usuario'] ?? ''),
        (string) ($registro['producto'] ?? ''),
        (string) ($registro['perfil'] ?? '')
    ));
    if ($q === '' || stripos($busqueda, $q) !== false) $reportes[] = $registro;
}
$reportes = array_reverse($reportes);

// Exporta únicamente los resultados que coinciden con la búsqueda actual.
if (isset($_GET['exportar']) && $_GET['exportar'] === 'csv') {
    header('Content-Type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename="oz_planning_reportes_' . date('Y-m-d') . '.csv"');
    echo "\xEF\xBB\xBF";
    $salida = fopen('php://output', 'w');
    fputcsv($salida, array('Código', 'Fecha de recepción', 'Estado', 'Nombre', 'CI', 'Teléfono', 'Perfil', 'Preferencias', 'Restricciones', 'Producto', 'Modificaciones', 'Fecha solicitada', 'Ficha completa'), ';');
    foreach ($reportes as $r) {
        fputcsv($salida, array(
            $r['codigo'] ?? '', $r['fecha_creacion'] ?? '', $r['estado'] ?? 'Nuevo',
            $r['nombre_usuario'] ?? '', $r['usuario_ci'] ?? '', $r['telefono_usuario'] ?? '',
            $r['perfil'] ?? '', $r['preferencias'] ?? '', $r['restricciones'] ?? '',
            $r['producto'] ?? '', $r['modificaciones'] ?? '', $r['fecha_plan'] ?? '', $r['ficha'] ?? ''
        ), ';');
    }
    fclose($salida);
    exit;
}

$nuevos = 0;
foreach ($todos as $registro) if (strtolower((string) ($registro['estado'] ?? 'nuevo')) === 'nuevo') $nuevos++;
$exportUrl = 'reportesOzPlanning.php?'. http_build_query(array_filter(array('q' => $q, 'exportar' => 'csv'), static function ($v) { return $v !== ''; }));
?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Reportes Oz Planning | Organic Zone</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">
<style>
:root{--verde:#0ba84a;--verde-oscuro:#087b37;--cafe:#2b140d;--beige:#ffc982;--crema:#f7f3ed;--blanco:#fffdf9;--linea:#eadfD2;--texto-suave:#79675d}
*{box-sizing:border-box}html{scroll-behavior:smooth}body{margin:0;background:var(--crema);color:var(--cafe);font:600 15px/1.55 'Nunito',Arial,sans-serif}
a{color:inherit}.topbar{background:var(--cafe);color:var(--blanco);padding:26px max(4vw,20px) 30px;border-radius:0 0 34px 34px}.topbar-inner{width:min(1440px,100%);margin:auto;display:flex;align-items:center;justify-content:space-between;gap:22px;flex-wrap:wrap}.brand{display:flex;align-items:center;gap:15px}.brand-mark{width:48px;height:48px;display:grid;place-items:center;flex:0 0 48px;border-radius:16px;background:var(--verde);color:#fff;font-size:25px;font-weight:900}.brand h1{font:700 clamp(27px,3vw,40px)/1.05 'Fredoka',sans-serif;margin:0;letter-spacing:-.5px}.brand p{margin:6px 0 0;color:var(--beige);font-weight:800;font-size:13px}.session{display:flex;align-items:center;gap:9px;background:#3a2118;padding:10px 15px;border-radius:999px;font-size:13px}.session-dot{width:8px;height:8px;background:var(--verde);border-radius:50%}.wrap{width:min(1440px,92%);margin:32px auto 60px}.intro{display:flex;align-items:flex-end;justify-content:space-between;gap:22px;flex-wrap:wrap;margin-bottom:22px}.eyebrow{color:var(--verde-oscuro);font-size:11px;font-weight:900;letter-spacing:1.5px;text-transform:uppercase}.intro h2{font:700 clamp(27px,3vw,37px)/1.1 'Fredoka',sans-serif;margin:7px 0 7px;letter-spacing:-.4px}.intro p{margin:0;color:var(--texto-suave);max-width:760px}.toolbar{display:flex;align-items:center;gap:9px;flex-wrap:wrap}.search{display:flex;gap:8px;flex-wrap:wrap}.search input{width:min(350px,70vw);min-height:48px;border:2px solid transparent;border-radius:15px;background:var(--blanco);padding:12px 15px;color:var(--cafe);font:800 14px 'Nunito',sans-serif;outline:none}.search input:focus{border-color:var(--verde)}.btn{min-height:46px;display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:11px 17px;border:0;border-radius:999px;background:var(--verde);color:white;text-decoration:none;font:900 13px 'Nunito',sans-serif;cursor:pointer;white-space:nowrap;transition:background .15s ease,transform .15s ease}.btn:hover{background:var(--verde-oscuro);transform:translateY(-1px)}.btn-beige{background:var(--beige);color:var(--cafe)}.btn-beige:hover{background:#f5b965;color:var(--cafe)}.btn-brown{background:var(--cafe);color:var(--blanco)}.btn-brown:hover{background:#432318}.stats{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:14px;margin:24px 0}.stat{min-width:0;padding:20px 22px;background:var(--blanco);border-radius:22px}.stat-label{display:block;color:var(--texto-suave);font-size:12px;font-weight:900}.stat-value{display:block;margin-top:3px;font:700 clamp(26px,3vw,34px)/1.15 'Fredoka',sans-serif}.stat-foot{display:block;margin-top:5px;color:var(--texto-suave);font-size:12px}.panel{overflow:hidden;background:var(--blanco);border-radius:25px}.panel-head{display:flex;align-items:center;justify-content:space-between;gap:15px;flex-wrap:wrap;padding:20px 22px;border-bottom:1px solid #eee4d8}.panel-head h3{font:600 22px 'Fredoka',sans-serif;margin:0}.count{display:inline-flex;align-items:center;justify-content:center;min-width:32px;height:30px;padding:0 10px;border-radius:999px;background:#e4f5e9;color:#126b34;font-size:12px;font-weight:900}.table-scroll{overflow:auto;width:100%}table{width:100%;border-collapse:separate;border-spacing:0;min-width:980px}thead th{padding:13px 15px;text-align:left;background:#fbf5eb;color:#705344;font-size:10px;font-weight:900;letter-spacing:.8px;text-transform:uppercase;white-space:nowrap}tbody td{padding:16px 15px;vertical-align:top;border-bottom:1px solid #f0e7dc;font-size:13px}tbody tr:last-child td{border-bottom:0}tbody tr:hover td{background:#f8fff8}.code{font-weight:900;overflow-wrap:anywhere}.date{display:block;margin:4px 0 8px;color:var(--texto-suave);font-size:11px}.pill{display:inline-flex;align-items:center;border-radius:999px;padding:4px 9px;background:#e4f5e9;color:#126b34;font-size:10px;font-weight:900}.client-name{font-weight:900}.subline{display:block;margin-top:4px;color:var(--texto-suave);font-size:11px}.detail{min-width:155px}.detail summary{display:inline-flex;align-items:center;gap:7px;cursor:pointer;color:var(--verde-oscuro);font-weight:900}.detail summary:hover{text-decoration:underline}.detail pre{width:min(440px,75vw);max-height:350px;overflow:auto;white-space:pre-wrap;overflow-wrap:anywhere;margin:10px 0 0;padding:14px;border-radius:14px;background:var(--crema);color:var(--cafe);font:12px/1.6 'Nunito',sans-serif}.empty{padding:44px 24px;text-align:center}.empty-mark{width:54px;height:54px;display:grid;place-items:center;margin:0 auto 12px;border-radius:18px;background:#e4f5e9;color:var(--verde-oscuro);font-size:25px}.empty h3{font:600 24px 'Fredoka',sans-serif;margin:0 0 5px}.empty p{max-width:590px;margin:0 auto;color:var(--texto-suave)}.notice{margin:0 0 18px;padding:14px 17px;border-radius:16px;background:#fff0d9;color:#704315;font-size:13px}.bottom-actions{display:flex;justify-content:space-between;align-items:center;gap:14px;flex-wrap:wrap;margin-top:20px}.bottom-actions p{margin:0;color:var(--texto-suave);font-size:12px}.bottom-buttons{display:flex;gap:9px;flex-wrap:wrap}@media(max-width:780px){.wrap{width:94%;margin-top:24px}.stats{grid-template-columns:1fr 1fr}.stat:last-child{grid-column:1/-1}.intro{align-items:stretch}.toolbar,.search{width:100%}.search input{width:100%;flex:1}.search .btn{flex:1}.topbar{border-radius:0 0 26px 26px}.panel-head{padding:17px}}@media(max-width:480px){.brand-mark{width:42px;height:42px;flex-basis:42px}.session{width:100%;justify-content:center}.stats{gap:9px}.stat{padding:15px}.stat-value{font-size:27px}.stat:last-child{grid-column:1/-1}.bottom-buttons,.bottom-buttons .btn{width:100%}.bottom-buttons{display:grid;grid-template-columns:1fr}}
@media print{body{background:#fff}.topbar{background:#fff;color:#000;padding:10px 0;border-radius:0}.brand p,.session,.toolbar,.bottom-actions,.detail summary{display:none!important}.wrap{width:100%;margin:15px 0}.panel,.stat{border:1px solid #ddd;break-inside:avoid}.stats{grid-template-columns:repeat(3,1fr)}.table-scroll{overflow:visible}table{min-width:0;font-size:10px}thead th,tbody td{padding:6px;font-size:9px}.detail pre{display:block;width:auto;max-height:none}.panel-head{padding:10px}}

/* REDISEÑO OZ: minimalista, plano, geométrico y sin bordes visibles */
:root{--verde:#0ba84a;--verde-oscuro:#087b37;--cafe:#2b140d;--beige:#ffc982;--crema:#f7f3ed;--blanco:#fffdf9;--linea:transparent;--texto-suave:#75645a}
body{background:#f7f3ed;color:#2b140d;font-family:'Nunito',Arial,sans-serif}
.topbar{background:transparent;color:#2b140d;padding:34px 0 8px;border-radius:0}
.topbar-inner{width:min(1380px,90%);align-items:flex-start}
.brand{align-items:flex-start;gap:17px}
.brand-mark{width:54px;height:54px;flex-basis:54px;border-radius:18px;background:#0ba84a;color:#fff;font:700 23px 'Fredoka',sans-serif}
.brand h1{font:700 clamp(36px,5.2vw,62px)/.98 'Fredoka',sans-serif;letter-spacing:-1.4px;color:#2b140d}
.brand p{margin:9px 0 0;color:#0ba84a;font:800 13px 'Nunito',sans-serif;letter-spacing:.2px}
.session{background:#e5f4e8;color:#2b140d;padding:10px 15px;font:800 12px 'Nunito',sans-serif}
.session-dot{background:#0ba84a}
.wrap{width:min(1380px,90%);margin:32px auto 70px}
.intro{display:block;margin-bottom:30px}
.eyebrow{color:#0ba84a;font:900 11px 'Nunito',sans-serif;letter-spacing:1.8px}
.intro h2{font:700 clamp(42px,6.2vw,70px)/.98 'Fredoka',sans-serif;letter-spacing:-1.7px;margin:10px 0 12px;color:#2b140d;text-align:left}
.intro p{max-width:800px;color:#75645a;font:700 15px/1.65 'Nunito',sans-serif}
.toolbar{margin-top:22px}
.search{width:100%;max-width:800px;gap:10px}
.search input{flex:1;width:auto;min-width:180px;min-height:54px;border:0!important;border-radius:17px;background:#fffdf9;padding:14px 18px;box-shadow:none;font:800 14px 'Nunito',sans-serif}
.search input:focus{outline:3px solid #d8efde;outline-offset:1px}
.btn{min-height:50px;padding:13px 21px;border:0;border-radius:999px;font:900 13px 'Nunito',sans-serif;box-shadow:none;transform:none}
.btn:hover{transform:none;background:#087b37}
.btn-beige{background:#ffc982;color:#2b140d}.btn-beige:hover{background:#f3b866;color:#2b140d}
.btn-brown{background:#2b140d;color:#fffdf9}.btn-brown:hover{background:#432318}
.stats{grid-template-columns:repeat(3,minmax(0,1fr));gap:16px;margin:30px 0}
.stat{padding:25px 27px;background:#fffdf9;border:0;border-radius:25px;box-shadow:none}
.stat-label{color:#75645a;font:900 12px 'Nunito',sans-serif}
.stat-value{font:700 clamp(34px,4vw,46px)/1.05 'Fredoka',sans-serif;color:#2b140d;margin-top:9px}
.stat-foot{font:700 12px/1.5 'Nunito',sans-serif;color:#75645a}
.panel{background:#fffdf9;border:0;border-radius:28px;box-shadow:none;overflow:hidden}
.panel-head{padding:25px 27px 18px;border:0;display:flex;align-items:center;justify-content:space-between}
.panel-head h3{font:700 29px/1.1 'Fredoka',sans-serif;color:#2b140d}
.count{background:#e5f4e8;color:#087b37;border-radius:999px;font:900 12px 'Nunito',sans-serif}
table{min-width:980px;border-spacing:0 5px;border-collapse:separate}
thead th{background:#f4f1ee;color:#75645a;padding:14px 16px;border:0;font:900 10px 'Nunito',sans-serif;letter-spacing:1px}
thead th:first-child{border-radius:13px 0 0 13px}thead th:last-child{border-radius:0 13px 13px 0}
tbody td{padding:17px 16px;border:0!important;background:#fffdf9;font:700 13px/1.55 'Nunito',sans-serif}
tbody tr:hover td{background:#f1f8f0}
.code{font:900 13px 'Nunito',sans-serif;color:#087b37}.date{color:#75645a}.pill{background:#e5f4e8;color:#087b37;padding:5px 10px;font:900 10px 'Nunito',sans-serif}
.client-name{font:900 14px 'Nunito',sans-serif}.subline{font:700 11px/1.55 'Nunito',sans-serif;color:#75645a}
.detail summary{color:#087b37;font:900 12px 'Nunito',sans-serif;text-decoration:none}.detail summary:hover{text-decoration:none;color:#0ba84a}
.detail pre{background:#f4f1ee;border:0;border-radius:17px;padding:16px;font:700 12px/1.65 'Nunito',sans-serif}
.empty{padding:58px 24px}.empty-mark{background:#e5f4e8;border-radius:18px;color:#087b37}.empty h3{font:700 29px 'Fredoka',sans-serif}.empty p{font:700 14px/1.7 'Nunito',sans-serif;color:#75645a}
.notice{background:#fff0d9;border:0;border-radius:18px;padding:16px 19px;font:800 13px 'Nunito',sans-serif}
.bottom-actions{margin-top:22px}.bottom-actions p{font:700 12px 'Nunito',sans-serif;color:#75645a}.bottom-actions code{background:#eee8df;padding:4px 7px;border-radius:7px;overflow-wrap:anywhere}
@media(max-width:780px){.topbar{padding-top:24px}.topbar-inner{width:92%}.wrap{width:92%;margin-top:24px}.intro h2{font-size:clamp(40px,10vw,56px)}.stats{grid-template-columns:1fr 1fr}.stat:last-child{grid-column:1/-1}.search{max-width:none}.panel-head{padding:21px 18px}.stat{padding:20px}}
@media(max-width:480px){.brand{gap:11px}.brand-mark{width:43px;height:43px;flex-basis:43px;border-radius:14px;font-size:20px}.brand h1{font-size:34px}.brand p{font-size:11px}.session{width:100%;justify-content:center}.stats{gap:10px}.stat{padding:16px;border-radius:19px}.stat-value{font-size:32px}.search{display:grid;grid-template-columns:1fr 1fr}.search input{grid-column:1/-1;width:100%}.search .btn{width:100%;padding:12px 10px}.bottom-buttons,.bottom-buttons .btn{width:100%}.bottom-buttons{display:grid;grid-template-columns:1fr}.panel{border-radius:22px}}
@media print{.topbar{background:#fff;padding:10px 0}.brand h1{font-size:32px}.wrap{width:100%;margin:15px 0}.panel,.stat{border:0;box-shadow:none}.topbar,.panel,.stat{border-radius:0}.stats{grid-template-columns:repeat(3,1fr)}thead th,tbody td{padding:6px;font-size:9px}.detail pre{display:block;width:auto;max-height:none}}


/* AJUSTE OZ — fondo beige dominante y jerarquía cromática verde/café/beige */
:root{--verde:#0ba84a;--verde-oscuro:#087b37;--cafe:#2b140d;--beige:#fcd09f;--crema:#fcd09f;--blanco:#ffe4bd;--texto-suave:#634435}
body{background:#fcd09f;color:#2b140d}
.topbar{padding:25px 0 8px;background:transparent}
.topbar-inner{width:min(1380px,90%);align-items:center;justify-content:space-between}
.brand{align-items:center;gap:0}
.brand-mark{width:58px;height:58px;flex-basis:58px;background:#0ba84a;color:#fcd09f;border-radius:20px;font-size:27px}
.session{margin-left:auto;min-height:64px;gap:13px;padding:15px 25px;background:#2b140d;color:#fcd09f;border-radius:20px;font:900 clamp(17px,2.1vw,23px)/1.2 'Fredoka',sans-serif;letter-spacing:.1px}
.session-dot{width:12px;height:12px;flex:0 0 12px;background:#0ba84a;box-shadow:0 0 0 5px rgba(11,168,74,.18)}
.wrap{margin-top:26px}
.intro{padding:28px 31px;background:#ffe4bd;border-radius:28px;margin-bottom:22px;gap:24px}
.eyebrow{display:inline-flex;align-items:center;padding:8px 13px;border-radius:999px;background:#0ba84a;color:#fff5e8;letter-spacing:1.5px}
.intro h2{margin-top:15px;color:#2b140d}
.intro p{color:#634435}
.toolbar{margin-top:20px}
.search input{background:#fcd09f;color:#2b140d;box-shadow:inset 0 0 0 2px rgba(43,20,13,.06)}
.search input::placeholder{color:#77523c}
.stats{gap:17px;margin:22px 0}
.stat{min-height:166px;padding:25px 27px;border-radius:25px;background:#0ba84a;color:#fff5e8;position:relative;overflow:hidden}
.stat:nth-child(2){background:#2b140d;color:#fcd09f}
.stat:nth-child(3){background:#fcd09f;color:#2b140d;box-shadow:inset 0 0 0 2px rgba(43,20,13,.08)}
.stat-label{color:inherit;opacity:.88;font-size:13px}
.stat-value{color:inherit;font-size:clamp(38px,4.3vw,52px);margin-top:12px}
.stat-foot{color:inherit;opacity:.82;font-size:12px}
.panel{background:#ffe4bd;border-radius:28px;overflow:hidden}
.panel-head{padding:25px 28px 20px;background:#2b140d;color:#fcd09f;border:0}
.panel-head h3{font-size:30px;color:#fcd09f}
.count{background:#0ba84a;color:#fff5e8;min-height:34px;padding:0 13px}
.table-scroll{padding:12px 13px 15px}
table{border-spacing:0 7px;min-width:980px}
thead th{background:#0ba84a;color:#fff5e8;padding:16px 15px;font-size:10px}
thead th:first-child{border-radius:14px 0 0 14px}thead th:last-child{border-radius:0 14px 14px 0}
tbody td{background:#fcd09f!important;color:#2b140d;padding:18px 15px;vertical-align:middle}
tbody tr:nth-child(even) td{background:#ffe9c9!important}
tbody tr:hover td{background:#d8f0dc!important}
tbody tr td:first-child{border-radius:14px 0 0 14px}tbody tr td:last-child{border-radius:0 14px 14px 0}
.code{color:#087b37;font-size:14px}.date{color:#634435}
.pill{background:#2b140d;color:#fcd09f;padding:6px 11px}
.client-name{font-size:14px}.subline{color:#634435}
.detail summary{background:#0ba84a;color:#fff5e8;padding:9px 12px;border-radius:999px;text-decoration:none}
.detail summary:hover{background:#087b37;color:#fff5e8}
.detail pre{background:#2b140d;color:#fcd09f}
.empty{padding:56px 24px}.empty-mark{background:#0ba84a;color:#fff5e8}.empty h3{color:#2b140d}
.notice{background:#2b140d;color:#fcd09f;border-radius:18px}
.bottom-actions{padding:19px 22px;background:#ffe4bd;border-radius:22px}
.bottom-actions p{color:#634435}.bottom-actions code{background:#fcd09f;color:#2b140d}
.btn{background:#0ba84a;color:#fff5e8}.btn:hover{background:#087b37}
.btn-beige{background:#fcd09f;color:#2b140d}.btn-beige:hover{background:#f5bd78;color:#2b140d}
.btn-brown{background:#2b140d;color:#fcd09f}.btn-brown:hover{background:#432318;color:#fcd09f}
@media(max-width:780px){.topbar{padding-top:18px}.intro{padding:23px 20px}.stats{gap:11px}.stat{min-height:145px;padding:19px}.panel-head{padding:21px}.table-scroll{padding:8px}.bottom-actions{padding:17px}}
@media(max-width:480px){.brand-mark{width:46px;height:46px;flex-basis:46px}.session{min-height:58px;padding:13px 15px;font-size:18px;border-radius:17px}.intro{border-radius:22px}.stats{grid-template-columns:1fr}.stat:last-child{grid-column:auto}.stat{min-height:125px}.panel-head h3{font-size:25px}.bottom-actions{border-radius:18px}}
@media print{body{background:#fff}.topbar{background:#fff}.session{background:#fff;color:#000}.intro,.stat,.panel,.bottom-actions{background:#fff!important;color:#000!important}.stat-label,.stat-value,.stat-foot,.panel-head h3{color:#000!important}.panel-head{background:#eee!important}.table-scroll{padding:0}thead th{background:#eee!important;color:#000!important}tbody td{background:#fff!important;color:#000!important}}


/* OZ FINAL — crema #FFF4E2 dominante, tres colores principales y jerarquía limpia */
:root{--oz-fondo:#fff4e2;--oz-beige:#ffc982;--oz-verde:#0ba84a;--oz-cafe:#2b140d;--crema:#fff4e2;--blanco:#ffe8c5;--verde:#0ba84a;--verde-oscuro:#087b37;--beige:#ffc982;--cafe:#2b140d;--texto-suave:#654532}
html,body{background:#fff4e2!important;color:#2b140d}
.topbar{padding:26px 0 12px;background:transparent!important}
.topbar-inner{width:min(1380px,92%);align-items:center;gap:20px}
.brand-mark{width:64px;height:64px;flex-basis:64px;border-radius:22px;background:#0ba84a;color:#fff4e2;font:700 28px/1 'Fredoka',sans-serif}
.session{margin-left:auto;min-height:70px;max-width:100%;padding:17px 25px;gap:14px;border-radius:22px;background:#2b140d!important;color:#fff4e2!important;font:700 clamp(19px,2.25vw,27px)/1.2 'Fredoka',sans-serif;letter-spacing:.1px;box-shadow:none}
.session-dot{width:13px;height:13px;flex:0 0 13px;background:#0ba84a;box-shadow:0 0 0 6px rgba(11,168,74,.18)}
.wrap{width:min(1380px,92%);margin:24px auto 64px}
.intro{padding:28px 30px;background:#ffc982;border-radius:28px;margin-bottom:22px;gap:22px;align-items:center}
.eyebrow{display:inline-flex;padding:8px 13px;border-radius:999px;background:#0ba84a;color:#fff4e2;letter-spacing:1.2px}
.intro h2{font:700 clamp(36px,4.5vw,54px)/1.02 'Fredoka',sans-serif;margin:12px 0 9px;color:#2b140d;letter-spacing:-.7px}
.intro p{color:#654532;font:700 14px/1.6 'Nunito',sans-serif}
.toolbar{margin-top:18px}.search{max-width:850px;gap:10px}
.search input{min-height:56px;background:#fff4e2!important;color:#2b140d;box-shadow:none!important;border:0!important;border-radius:17px;padding:14px 18px;font:800 14px 'Nunito',sans-serif}
.search input::placeholder{color:#76543b}.search input:focus{outline:3px solid rgba(11,168,74,.3);outline-offset:2px}
.btn{min-height:50px;border-radius:16px;padding:13px 20px;background:#0ba84a;color:#fff4e2;font:900 13px 'Nunito',sans-serif;box-shadow:none!important;transform:none!important}
.btn:hover{background:#087b37}.btn-beige{background:#ffc982;color:#2b140d}.btn-beige:hover{background:#f2b968;color:#2b140d}.btn-brown{background:#2b140d;color:#fff4e2}.btn-brown:hover{background:#432318}
.stats{gap:16px;margin:22px 0 25px}
.stat{min-height:164px;padding:24px 26px;border-radius:25px;background:#0ba84a!important;color:#fff4e2;box-shadow:none!important}
.stat:nth-child(2){background:#2b140d!important;color:#ffc982}
.stat:nth-child(3){background:#ffc982!important;color:#2b140d}
.stat-label,.stat-foot{color:inherit;opacity:.9;font-weight:800}.stat-label{font-size:13px}.stat-value{color:inherit;font:700 clamp(36px,4.2vw,49px)/1.05 'Fredoka',sans-serif;margin:11px 0 7px}.stat-foot{font-size:12px;line-height:1.45}
.panel{background:#ffc982!important;border-radius:28px;box-shadow:none!important;overflow:hidden}
.panel-head{padding:24px 28px;background:#2b140d!important;border:0!important;color:#ffc982}
.panel-head h3{font:700 clamp(25px,3vw,32px)/1.1 'Fredoka',sans-serif;color:#ffc982;margin:0}
.count{min-height:36px;padding:0 14px;border-radius:999px;background:#0ba84a!important;color:#fff4e2!important;font:900 12px 'Nunito',sans-serif}
.table-scroll{padding:12px 14px 16px}
table{min-width:980px;border-spacing:0 7px;border-collapse:separate}
thead th{padding:15px 15px;background:#0ba84a!important;color:#fff4e2!important;border:0;font:900 10px 'Nunito',sans-serif;letter-spacing:.8px}
thead th:first-child{border-radius:14px 0 0 14px}thead th:last-child{border-radius:0 14px 14px 0}
tbody td{padding:17px 15px;vertical-align:middle;background:#fff4e2!important;color:#2b140d;border:0!important;font-size:13px}
tbody tr:nth-child(even) td{background:#ffe8c5!important}tbody tr:hover td{background:#dff1df!important}
tbody tr td:first-child{border-radius:13px 0 0 13px}tbody tr td:last-child{border-radius:0 13px 13px 0}
.code{color:#087b37;font-size:14px}.date,.subline{color:#654532}.pill{background:#2b140d;color:#ffc982;padding:6px 11px;font-size:10px}.client-name{font-size:14px}
.detail summary{padding:10px 14px;border-radius:14px;background:#0ba84a;color:#fff4e2;text-decoration:none;font-weight:900}.detail summary:hover{background:#087b37}.detail pre{background:#2b140d;color:#ffc982;border-radius:16px}
.empty{padding:52px 24px}.empty-mark{background:#0ba84a;color:#fff4e2;border-radius:18px}.empty h3{font:700 26px 'Fredoka',sans-serif}.empty p{color:#654532}
.notice{background:#2b140d;color:#ffc982;border-radius:18px}.bottom-actions{padding:19px 22px;background:#ffc982;border-radius:22px;margin-top:20px}.bottom-actions p{color:#654532}.bottom-actions code{background:#fff4e2;color:#2b140d;border-radius:8px;padding:4px 7px}
@media(max-width:780px){.topbar{padding-top:18px}.topbar-inner,.wrap{width:94%}.session{min-height:62px;padding:14px 18px;font-size:20px}.intro{padding:23px 20px}.stats{gap:11px}.stat{min-height:145px;padding:19px}.panel-head{padding:21px}.table-scroll{padding:8px}.bottom-actions{padding:17px}}
@media(max-width:480px){.brand-mark{width:48px;height:48px;flex-basis:48px;border-radius:16px;font-size:22px}.session{width:100%;justify-content:center;border-radius:17px;font-size:19px}.intro{border-radius:22px;padding:20px 16px}.stats{grid-template-columns:1fr}.stat:last-child{grid-column:auto}.stat{min-height:125px;border-radius:20px}.panel{border-radius:22px}.panel-head h3{font-size:25px}.search{display:grid;grid-template-columns:1fr 1fr}.search input{grid-column:1/-1;width:100%}.search .btn{width:100%;padding:12px 10px}.bottom-buttons,.bottom-buttons .btn{width:100%}.bottom-buttons{display:grid;grid-template-columns:1fr}}
@media print{body{background:#fff!important}.session{background:#fff!important;color:#000!important;box-shadow:none}.intro,.stat,.panel,.bottom-actions{print-color-adjust:exact;-webkit-print-color-adjust:exact}.table-scroll{padding:0}}


/* Ajuste final de identidad visual Organic Zone: minimalista, geométrica y plana */
.topbar{background:transparent!important;color:var(--cafe)!important;padding:42px 0 8px!important;border-radius:0!important}
.topbar-inner{width:min(1380px,92%)!important;align-items:center!important;gap:28px!important}
.brand{display:block!important;min-width:0!important}
.brand h1{margin:0!important;font:700 clamp(46px,7vw,82px)/.98 'Fredoka',sans-serif!important;letter-spacing:-2.8px!important;color:#2B140D!important}
.brand h1 span{color:#0BA84A!important}
.brand p{margin:13px 0 0!important;color:#6f594b!important;font:900 11px/1.4 'Nunito',sans-serif!important;letter-spacing:2px!important}
.session{display:flex!important;align-items:center!important;gap:13px!important;background:#fff!important;color:#2B140D!important;border-radius:22px!important;padding:15px 19px!important;min-width:235px!important;box-shadow:none!important}
.session-dot{width:11px!important;height:11px!important;flex:0 0 11px!important;background:#0BA84A!important}
.session-info{display:grid;gap:2px;min-width:0}
.session-label{font:900 10px/1.2 'Nunito',sans-serif;color:#78675c;text-transform:uppercase;letter-spacing:1.1px}
.session-name{font:900 17px/1.25 'Nunito',sans-serif;color:#2B140D;overflow-wrap:anywhere}
.session-role{display:inline-flex;width:max-content;max-width:100%;margin-top:5px;padding:5px 10px;border-radius:999px;background:#e5f6e9;color:#087b36;font:900 11px/1.2 'Nunito',sans-serif;text-transform:capitalize}
.wrap{width:min(1380px,92%)!important;margin:30px auto 60px!important}
.intro{align-items:center!important;background:#fff!important;border-radius:25px!important;padding:23px 25px!important;margin-bottom:23px!important;gap:20px!important}
.intro-copy{flex:1;min-width:220px}
.intro-copy p{margin:0!important;max-width:620px;color:#715f54!important;font:700 15px/1.65 'Nunito',sans-serif!important}
.toolbar{flex:0 1 auto}
.search input{border:0!important;background:#F7F3ED!important;border-radius:15px!important;min-height:49px!important}
.search input:focus{outline:2px solid #0BA84A!important;outline-offset:2px!important}
.btn{box-shadow:none!important;transform:none!important;transition:background .15s ease!important}
.btn:hover{transform:none!important}
.stats{gap:16px!important;margin:24px 0!important}
.stat{background:#fff!important;border-radius:23px!important;padding:22px 24px!important;box-shadow:none!important}
.stat-label{color:#77655a!important;font-size:12px!important}
.stat-value{color:#2B140D!important;font-size:clamp(31px,3.6vw,43px)!important}
.stat-foot{color:#8b796e!important}
.panel{background:#fff!important;border-radius:25px!important;box-shadow:none!important}
.panel-head{border:0!important;padding:23px 25px 15px!important}
.panel-head h3{font:700 24px/1.2 'Fredoka',sans-serif!important;color:#2B140D!important}
.table-scroll{padding:8px 18px 18px!important}
thead th{background:#F7F3ED!important;color:#725748!important;border:0!important}
tbody td{border-bottom:1px solid #f4eee7!important}
tbody tr:hover td{background:#f8fff8!important}
@media(max-width:780px){.topbar{padding-top:28px!important}.topbar-inner{align-items:flex-start!important}.session{min-width:0!important}.brand h1{letter-spacing:-1.7px!important}.intro{padding:21px!important}.toolbar{width:100%}.search{width:100%}}
@media(max-width:560px){.topbar-inner,.wrap{width:92%!important}.topbar-inner{display:grid!important;grid-template-columns:1fr!important}.brand h1{font-size:clamp(43px,12vw,60px)!important}.brand p{font-size:10px!important;letter-spacing:1.5px!important}.session{width:100%!important;justify-content:flex-start!important;padding:14px 16px!important}.session-name{font-size:16px!important}.intro{display:grid!important;grid-template-columns:1fr!important;padding:18px!important;border-radius:20px!important}.stats{grid-template-columns:1fr!important}.stat:last-child{grid-column:auto!important}.stat{min-height:0!important}.panel{border-radius:20px!important}.panel-head{padding:20px 18px 12px!important}.table-scroll{padding:6px 8px 12px!important}}
@media print{.brand h1{font-size:34px!important}.session{box-shadow:none!important}.topbar{padding:10px 0!important}.intro{padding:10px!important}}
/* Paleta final Organic Zone: plana, limpia y coordinada. Se conserva el fondo y el título. */
:root{--oz-fondo:#FFF4E2;--oz-verde:#0BA84A;--oz-cafe:#2B140D;--oz-beige:#FFC982;--oz-superficie:#FFFAF2;--oz-verde-suave:#E7F4E8;--oz-texto-suave:#715F54}
html,body{background:#FFF4E2!important;color:#2B140D!important}
/* Cabecera y título: conservar sus colores actuales */
.brand h1{color:#2B140D!important}
.brand h1 span{color:#0BA84A!important}
/* Tarjeta de sesión */
.session{background:#FFFAF2!important;color:#2B140D!important;border-radius:20px!important}
.session-label{color:#715F54!important}
.session-name{color:#2B140D!important}
.session-role{background:#E7F4E8!important;color:#087B36!important}
/* Introducción y buscador */
.intro{background:#FFFAF2!important;color:#2B140D!important}
.intro-copy p{color:#715F54!important}
.search input{background:#FFFFFF!important;color:#2B140D!important;border:0!important}
.search input::placeholder{color:#806D60!important}
/* Tres tarjetas de resumen con la misma base clara; el color se usa en los números */
.stats .stat,.stats .stat:nth-child(2),.stats .stat:nth-child(3){background:#FFFAF2!important;color:#2B140D!important;border-radius:22px!important;box-shadow:none!important}
.stats .stat-label{color:#715F54!important}
.stats .stat-value{color:#0BA84A!important}
.stats .stat:nth-child(2) .stat-value{color:#2B140D!important}
.stats .stat:nth-child(3) .stat-value{color:#0BA84A!important}
.stats .stat-foot{color:#806D60!important;opacity:1!important}
/* Panel y tabla */
.panel{background:#FFFAF2!important;border-radius:24px!important;box-shadow:none!important}
.panel-head{background:#FFFAF2!important;color:#2B140D!important}
.panel-head h3{color:#2B140D!important}
.count{background:#E7F4E8!important;color:#087B36!important}
thead th{background:#E7F4E8!important;color:#315B3B!important}
tbody td,tbody tr:nth-child(even) td{background:#FFFAF2!important;color:#2B140D!important;border:0!important}
tbody tr:hover td{background:#F0F7ED!important}
.code{color:#087B36!important}
.date,.subline{color:#806D60!important}
.pill{background:#E7F4E8!important;color:#087B36!important}
.detail summary{background:#0BA84A!important;color:#FFFFFF!important}
.detail pre{background:#F7F3ED!important;color:#2B140D!important;border-radius:14px!important}
/* Acciones */
.btn{background:#0BA84A!important;color:#FFFFFF!important;border:0!important}
.btn:hover{background:#087B36!important}
.btn-beige{background:#FFC982!important;color:#2B140D!important}
.btn-beige:hover{background:#F2B968!important;color:#2B140D!important}
.btn-brown{background:#2B140D!important;color:#FFF4E2!important}
.btn-brown:hover{background:#432318!important}
.notice{background:#E7F4E8!important;color:#2B140D!important}
.empty-mark{background:#E7F4E8!important;color:#087B36!important}
.empty p,.bottom-actions p{color:#715F54!important}
.bottom-actions{background:#FFFAF2!important;border-radius:22px!important}
.bottom-actions code{background:#F7F3ED!important;color:#2B140D!important}
@media(max-width:560px){.stats .stat,.stats .stat:nth-child(2),.stats .stat:nth-child(3){min-height:0!important}}
@media print{html,body{background:#FFFFFF!important}.stats .stat,.panel,.intro,.bottom-actions{print-color-adjust:exact;-webkit-print-color-adjust:exact}}


/* CONTRASTE OZ: un toque de verde y una tarjeta café, sin alterar fondo ni título */
.stats .stat:first-child{
  background:#E7F4E8!important;
  color:#2B140D!important;
}
.stats .stat:first-child .stat-value{color:#087B36!important}
.stats .stat:first-child .stat-label,
.stats .stat:first-child .stat-foot{color:#315B3B!important;opacity:1!important}
.stats .stat:nth-child(2){
  background:#2B140D!important;
  color:#FFF4E2!important;
}
.stats .stat:nth-child(2) .stat-label,
.stats .stat:nth-child(2) .stat-foot{color:#FFF4E2!important;opacity:1!important}
.stats .stat:nth-child(2) .stat-value{color:#FFC982!important}
.stats .stat:nth-child(3){
  background:#FFFAF2!important;
  color:#2B140D!important;
}
.stats .stat:nth-child(3) .stat-value{color:#0BA84A!important}
.intro{background:#E7F4E8!important}
.intro-copy p{color:#315B3B!important}
.panel-head{background:#E7F4E8!important;color:#2B140D!important}
.panel-head h3{color:#2B140D!important}
.count{background:#2B140D!important;color:#FFC982!important}
thead th{background:#0BA84A!important;color:#FFFFFF!important}
.pill{background:#FFF0D7!important;color:#2B140D!important}
@media(max-width:560px){.stats .stat:nth-child(2){background:#2B140D!important;color:#FFF4E2!important}}


/* Ajuste final OZ: verde de marca real, café profundo y beige; 2D limpio */
:root{--oz-verde:#0BA84A;--oz-cafe:#2B140D;--oz-beige:#FFC982;--oz-fondo:#FFF4E2;--oz-crema:#FFFAF2}
/* Intro crema para no competir con el título; acento verde de marca */
.intro{background:#FFFAF2!important;color:#2B140D!important;position:relative!important;border:0!important;padding:14px 18px!important;border-radius:18px!important;margin-bottom:18px!important}
.intro-copy p{color:#2B140D!important}
/* Cifras grandes y fáciles de leer */
.stats{gap:18px!important}
.stats .stat{min-height:174px!important;padding:27px 26px!important;border-radius:22px!important;box-shadow:none!important;display:flex!important;flex-direction:column!important;justify-content:center!important;gap:9px!important}
.stats .stat-label{font-size:14px!important;font-weight:800!important;letter-spacing:.2px!important}
.stats .stat-value{display:block!important;font-size:clamp(48px,5vw,66px)!important;line-height:1!important;font-weight:900!important;letter-spacing:-2px!important;margin:4px 0!important;font-variant-numeric:tabular-nums!important}
.stats .stat-foot{font-size:12px!important;line-height:1.45!important}
/* Tarjeta 1: verde sólido oficial, texto blanco */
.stats .stat:first-child{background:#0BA84A!important;color:#FFFFFF!important}
.stats .stat:first-child .stat-label,.stats .stat:first-child .stat-foot{color:#FFFFFF!important;opacity:1!important}
.stats .stat:first-child .stat-value{color:#FFFFFF!important}
/* Tarjeta 2: café oscuro con número beige */
.stats .stat:nth-child(2){background:#2B140D!important;color:#FFF4E2!important}
.stats .stat:nth-child(2) .stat-label,.stats .stat:nth-child(2) .stat-foot{color:#FFF4E2!important;opacity:1!important}
.stats .stat:nth-child(2) .stat-value{color:#FFC982!important}
/* Tarjeta 3: beige con texto café y cifra verde oficial */
.stats .stat:nth-child(3){background:#FFC982!important;color:#2B140D!important}
.stats .stat:nth-child(3) .stat-label,.stats .stat:nth-child(3) .stat-foot{color:#2B140D!important;opacity:1!important}
.stats .stat:nth-child(3) .stat-value{color:#0BA84A!important}
/* Encabezado del panel crema con contador café/beige */
.panel{background:#FFFAF2!important;border-radius:24px!important;box-shadow:none!important}
.panel-head{background:#FFFAF2!important;border-bottom:3px solid #0BA84A!important}
.panel-head h3{color:#2B140D!important}
.count{background:#2B140D!important;color:#FFC982!important;font-weight:800!important;padding:9px 14px!important;border-radius:999px!important}
/* Verde de marca real en encabezado de tabla; filas neutras */
thead th{background:#0BA84A!important;color:#FFFFFF!important}
tbody td,tbody tr:nth-child(even) td{background:#FFFAF2!important;color:#2B140D!important}
tbody tr:hover td{background:#FFF0D7!important}
.code{color:#0BA84A!important;font-weight:900!important}
.pill{background:#FFC982!important;color:#2B140D!important;font-weight:800!important}
.detail summary{background:#0BA84A!important;color:#FFFFFF!important}
/* Botones mantienen los tres colores de marca sin sombras */
.btn{background:#0BA84A!important;color:#FFFFFF!important;border:0!important;box-shadow:none!important}
.btn-beige{background:#FFC982!important;color:#2B140D!important}
.btn-brown{background:#2B140D!important;color:#FFF4E2!important}
.notice{background:#0BA84A!important;color:#FFFFFF!important}
.empty-mark{background:#FFC982!important;color:#2B140D!important}
@media(max-width:560px){.stats .stat{min-height:145px!important;padding:22px!important}.stats .stat-value{font-size:52px!important}.stats{gap:12px!important}}
@media print{.stats .stat,.intro,.panel-head,thead th,.count{print-color-adjust:exact;-webkit-print-color-adjust:exact}}

/* Ajustes solicitados: búsqueda compacta sin borde verde y encabezado Código y fecha en café */
.search{width:auto!important;max-width:fit-content!important;gap:8px!important;flex-wrap:nowrap!important}
.search input{flex:0 1 350px!important;width:350px!important;max-width:calc(100vw - 190px)!important;min-width:0!important;min-height:49px!important;border:0!important;outline:none!important;box-shadow:none!important;background:#FFFAF2!important;border-radius:15px!important;padding:13px 16px!important}
.search input:focus{outline:none!important;border:0!important;box-shadow:none!important}
thead th:first-child{background:#2B140D!important;color:#FFC982!important}
@media(max-width:780px){.search{width:100%!important;max-width:100%!important;flex-wrap:wrap!important}.search input{flex:1 1 220px!important;width:auto!important;max-width:100%!important}}
@media(max-width:480px){.search{display:grid!important;grid-template-columns:1fr 1fr!important}.search input{grid-column:1/-1!important;width:100%!important;max-width:100%!important}}


/* Ajustes finales solicitados: intro compacto, ficha café y animaciones 2D */
.intro{display:flex!important;align-items:center!important;justify-content:flex-start!important;gap:22px!important;width:fit-content!important;max-width:100%!important;padding:13px 18px!important;margin-bottom:18px!important;background:#FFFAF2!important;border:0!important;border-radius:18px!important}
.intro-copy{flex:0 1 auto!important;min-width:0!important;max-width:340px!important}
.intro-copy h2{font:700 clamp(27px,3vw,34px)/1 'Fredoka',sans-serif!important;color:#2B140D!important;margin:0 0 5px!important;letter-spacing:-.4px!important}
.intro-copy p{max-width:340px!important;margin:0!important;color:#2B140D!important;font:700 13px/1.4 'Nunito',sans-serif!important}
.intro .toolbar{flex:0 0 auto!important;width:auto!important}
.intro .search{max-width:100%!important}
/* Ficha completa: texto legible en café oscuro */
.detail summary{color:#2B140D!important;background:#FFC982!important;border-radius:999px!important;padding:9px 12px!important;text-decoration:none!important;transition:background .2s ease,transform .2s ease!important}
.detail summary:hover{background:#f5b965!important;transform:translateY(-2px)!important}
.detail pre,.detail pre *{color:#2B140D!important}
.detail pre{background:#FFF4E2!important;border:1px solid #FFC982!important}
/* Animación de las tarjetas inspirada en la sección Contacto de Organic Zone */
.stats .stat{
  transition:transform .3s ease!important;
}
@media (hover: hover){
  .stats .stat:hover{
    transform:translateY(-8px)!important;
  }
}
.stats .stat:active{
  transform:translateY(-2px)!important;
  transition-duration:.12s!important;
}
.detail summary{transition:background .2s ease,transform .2s ease!important}
@media(max-width:780px){.intro{width:100%!important;align-items:flex-start!important;flex-direction:column!important;gap:12px!important}.intro-copy{max-width:100%!important}.intro-copy p{max-width:100%!important}.intro .toolbar,.intro .search{width:100%!important}.intro .search input{width:auto!important;max-width:100%!important}}
@media(max-width:480px){.intro{padding:14px!important}.intro-copy h2{font-size:30px!important}.stats .stat:hover{transform:translateY(-2px)!important}}
@media(prefers-reduced-motion:reduce){.stats .stat,.detail summary{transition:none!important}.stats .stat:hover,.stats .stat:active,.detail summary:hover{transform:none!important}}

</style>
</head>
<body>
<header class="topbar"><div class="topbar-inner"><div class="brand"><h1>Solicitudes <span>de clientes</span></h1><p>OZ PLANNING · PANEL DE GESTIÓN</p></div><div class="session"><span class="session-dot" aria-hidden="true"></span><div class="session-info"><span class="session-label">Sesión activa</span><strong class="session-name"><?= oz_e($_SESSION['nombre']) ?></strong><span class="session-role"><?= $rol === 'admin' ? 'Administrador' : 'Vendedor' ?></span></div></div></div></header>
<main class="wrap">
  <section class="intro"><div class="intro-copy"><h2>Consulta</h2><p>Organiza y revisa las propuestas guardadas en Oz Planning.</p></div><div class="toolbar"><form class="search" method="get" action="reportesOzPlanning.php"><input type="search" name="q" value="<?= oz_e($q) ?>" placeholder="Buscar un reporte…" aria-label="Buscar reportes"><button class="btn" type="submit">⌕ Buscar</button><?php if ($q !== ''): ?><a class="btn btn-beige" href="reportesOzPlanning.php">Limpiar</a><?php endif; ?></form></div></section>
  <?php if ($avisoArchivo !== ''): ?><div class="notice"><?= oz_e($avisoArchivo) ?></div><?php endif; ?>
  <section class="stats" aria-label="Resumen de reportes"><div class="stat"><span class="stat-label">Reportes guardados</span><strong class="stat-value"><?= count($todos) ?></strong><span class="stat-foot">Total registrado en el archivo local</span></div><div class="stat"><span class="stat-label">Resultados visibles</span><strong class="stat-value"><?= count($reportes) ?></strong><span class="stat-foot"><?= $q !== '' ? 'Coincidencias de tu búsqueda' : 'Solicitudes mostradas' ?></span></div><div class="stat"><span class="stat-label">Pendientes de revisar</span><strong class="stat-value"><?= $nuevos ?></strong><span class="stat-foot">Reportes con estado «Nuevo»</span></div></section>
  <section class="panel"><div class="panel-head"><h3>Reportes recibidos</h3><span class="count"><?= count($reportes) ?> <?= count($reportes) === 1 ? 'reporte' : 'reportes' ?></span></div>
  <?php if (!$reportes): ?><div class="empty"><div class="empty-mark" aria-hidden="true">⌕</div><h3><?= $q !== '' ? 'No encontramos coincidencias' : 'Aún no hay reportes' ?></h3><p><?= $q !== '' ? 'Prueba con otro código, CI, nombre, teléfono o producto. También puedes limpiar la búsqueda para ver todas las solicitudes.' : 'Cuando una persona autenticada genere y guarde su propuesta desde Oz Planning, aparecerá aquí automáticamente.' ?></p></div>
  <?php else: ?><div class="table-scroll"><table><thead><tr><th>Código y fecha</th><th>Cliente</th><th>Contacto</th><th>Preferencias</th><th>Producto / solicitud</th><th>Ficha completa</th></tr></thead><tbody>
  <?php foreach ($reportes as $r): ?><tr><td><span class="code"><?= oz_e(oz_valor($r, 'codigo', 'Sin código')) ?></span><span class="date"><?= oz_e(oz_valor($r, 'fecha_creacion', 'Fecha no disponible')) ?></span><span class="pill"><?= oz_e(oz_valor($r, 'estado', 'Nuevo')) ?></span></td><td><span class="client-name"><?= oz_e(oz_valor($r, 'nombre_usuario', 'Nombre no disponible')) ?></span><span class="subline">CI: <?= oz_e(oz_valor($r, 'usuario_ci', 'No disponible')) ?></span></td><td><?= oz_e(oz_valor($r, 'telefono_usuario', 'No registrado')) ?></td><td><strong><?= oz_e(oz_valor($r, 'perfil', 'Sin perfil')) ?></strong><span class="subline">Preferencias: <?= oz_e(oz_valor($r, 'preferencias', 'No indicadas')) ?></span><span class="subline">Restricciones: <?= oz_e(oz_valor($r, 'restricciones', 'No indicadas')) ?></span></td><td><strong><?= oz_e(oz_valor($r, 'producto', 'Sin producto de partida')) ?></strong><span class="subline"><?= oz_e(oz_valor($r, 'modificaciones', 'Sin modificaciones adicionales')) ?></span><span class="subline">Fecha solicitada: <?= oz_e(oz_valor($r, 'fecha_plan', 'No elegida')) ?></span></td><td class="detail"><details><summary>Ver ficha completa <span aria-hidden="true">＋</span></summary><pre><?= oz_e(oz_valor($r, 'ficha', 'La ficha no está disponible.')) ?></pre></details></td></tr><?php endforeach; ?>
  </tbody></table></div><?php endif; ?></section>
  <div class="bottom-actions"><div class="bottom-buttons"><a class="btn btn-beige" href="<?= oz_e($exportUrl) ?>">↓ Exportar CSV</a><button class="btn btn-brown" type="button" onclick="window.print()">Imprimir panel</button><a class="btn" href="Hamburguesas.php">Volver al menú</a></div></div>
</main>
</body>
</html>
