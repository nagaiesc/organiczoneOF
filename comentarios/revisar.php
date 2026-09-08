<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Asuntos y comentarios</title>
    <style>
        body {
            margin: 0;
            padding: 40px;
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }
        .cajita {
            width: 700px;
            max-width: 90%;
            margin: auto;
        }
        .bloque {
            background-color: white;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        .asunto {
            font-size: 21px;
            font-weight: bold;
            color: #222;
            margin-bottom: 15px;
        }
        .comentario {
            font-size: 17px;
            color: #555;
            line-height: 1.5;
        }
        .etiqueta {
            color: #007bff;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="cajita">
<?php
$archivo = fopen("ejemplo.txt", "r");
$asunto = "";
$comentario = "";
while (($linea = fgets($archivo)) !== false) {
    $linea = trim($linea);
    if ($linea === "ASUNTO:") {
        $asunto = trim(fgets($archivo));
        if ($asunto === "") {
            continue;
        }
    }
    if ($linea === "COMENTARIO:") {
        $comentario = trim(fgets($archivo));
        if ($comentario === "") {
            continue;
        }
        echo '<div class="bloque">';

        echo '<div class="asunto">';
        echo '<span class="etiqueta">ASUNTO:</span> ';
        echo htmlspecialchars($asunto);
        echo '</div>';

        echo '<div class="comentario">';
        echo '<span class="etiqueta">COMENTARIO:</span> ';
        echo htmlspecialchars($comentario);
        echo '</div>';

        echo '</div>';
        $asunto = "";
        $comentario = "";
    }
}
fclose($archivo);
?>
</div>
</body>
</html>