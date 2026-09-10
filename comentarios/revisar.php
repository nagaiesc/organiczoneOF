<?php
session_start();
?>

<!DOCTYPE html>

<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Comunidad OZ</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>

* {
    box-sizing: border-box;
}

html,
body {
    margin: 0;
    min-height: 100%;
}

body {
    padding: 55px 7%;
    background: #f4f1ee;
    font-family: 'Fredoka', sans-serif;
    color: #2B140D;
}

.contenedor {
    width: 100%;
    max-width: 1250px;
    margin: auto;
}

.encabezado {
    margin-bottom: 45px;
}

.mini-titulo {
    color: #12A33C;
    font-size: 14px;
    font-weight: 700;
    letter-spacing: 1.5px;
    margin-bottom: 8px;
}

h1 {
    margin: 0;
    color: #2B140D;
    font-size: 76px;
    line-height: .9;
    font-weight: 700;
}

h1 span {
    color: #12A33C;
}

.descripcion {
    max-width: 620px;
    margin-top: 18px;
    color: #725f58;
    font-size: 18px;
    line-height: 1.5;
}

.linea-decorativa {
    width: 75px;
    height: 7px;
    margin-top: 22px;
    background: #12A33C;
    border-radius: 20px;
}

.comentarios {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 25px;
}

.bloque {
    position: relative;
    overflow: hidden;
    background: #ffffff;
    padding: 30px;
    border-radius: 32px;
    border: 2px solid rgba(18, 163, 60, .10);
    box-shadow: 0 10px 30px rgba(43, 20, 13, .08);
    transition: .25s ease;
}

.bloque:hover {
    transform: translateY(-6px);
    box-shadow: 0 18px 38px rgba(43, 20, 13, .13);
}

.bloque::before {
    content: "";
    position: absolute;
    top: -45px;
    right: -45px;
    width: 125px;
    height: 125px;
    border-radius: 50%;
    background: rgba(18, 163, 60, .10);
}

.bloque::after {
    content: "";
    position: absolute;
    bottom: -35px;
    left: -35px;
    width: 95px;
    height: 95px;
    border-radius: 50%;
    background: rgba(252, 208, 159, .22);
}

.cabecera-comentario {
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    margin-bottom: 24px;
}

.usuario {
    display: flex;
    align-items: center;
    gap: 12px;
}

.avatar {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: #12A33C;
    color: #ffffff;
    font-size: 20px;
    font-weight: 700;
    box-shadow: 0 6px 15px rgba(18, 163, 60, .22);
}

.datos-usuario {
    min-width: 0;
}

.nombre-usuario {
    color: #2B140D;
    font-size: 17px;
    font-weight: 600;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.tipo-usuario {
    margin-top: 2px;
    color: #8b7770;
    font-size: 12px;
    font-weight: 600;
}

.etiqueta-asunto {
    position: relative;
    z-index: 1;
    display: inline-block;
    margin-bottom: 11px;
    padding: 7px 13px;
    border-radius: 18px;
    background: #FCD09F;
    color: #2B140D;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .5px;
}

.asunto {
    position: relative;
    z-index: 1;
    margin-bottom: 19px;
    color: #2B140D;
    font-size: 25px;
    line-height: 1.2;
    font-weight: 700;
}

.separador {
    position: relative;
    z-index: 1;
    width: 100%;
    height: 1px;
    margin-bottom: 18px;
    background: #eee7e3;
}

.comentario {
    position: relative;
    z-index: 1;
    color: #594a44;
    font-size: 17px;
    line-height: 1.6;
}

.comilla {
    position: absolute;
    right: 22px;
    bottom: -8px;
    color: rgba(18, 163, 60, .10);
    font-size: 100px;
    font-weight: 700;
    line-height: 1;
}

.vacio {
    grid-column: 1 / -1;
    padding: 70px 30px;
    text-align: center;
    background: #ffffff;
    border-radius: 32px;
    box-shadow: 0 10px 30px rgba(43, 20, 13, .08);
}

.vacio-icono {
    width: 75px;
    height: 75px;
    margin: 0 auto 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: #12A33C;
    color: #ffffff;
    font-size: 25px;
    font-weight: 700;
}

.vacio h2 {
    margin: 0 0 8px;
    color: #2B140D;
    font-size: 28px;
}

.vacio p {
    margin: 0;
    color: #806f68;
    font-size: 16px;
}

@media (max-width: 850px) {

    body {
        padding: 40px 5%;
    }

    .comentarios {
        grid-template-columns: 1fr;
    }

    h1 {
        font-size: 58px;
    }
}

@media (max-width: 520px) {

    body {
        padding: 30px 20px;
    }

    .encabezado {
        margin-bottom: 30px;
    }

    h1 {
        font-size: 48px;
    }

    .descripcion {
        font-size: 16px;
    }

    .bloque {
        padding: 22px;
        border-radius: 25px;
    }

    .asunto {
        font-size: 22px;
    }
}

</style>

</head>

<body>

<div class="contenedor">

<header class="encabezado">

<div class="mini-titulo">
MY OZ · COMUNIDAD
</div>

<h1>
Comunidad <span>OZ</span>
</h1>

<div class="descripcion">
Un espacio para compartir ideas, opiniones y experiencias dentro de nuestra comunidad Organic Zone.
</div>

<div class="linea-decorativa"></div>

</header>

<section class="comentarios">

<?php

$archivo = "ejemplo.txt";
$hayComentarios = false;

if (file_exists($archivo)) {

    $contenido = file(
        $archivo,
        FILE_IGNORE_NEW_LINES
    );

    $usuario = "Usuario de Organic Zone";
    $asunto = "";
    $comentario = "";

    $cantidad = count($contenido);

    for ($i = 0; $i < $cantidad; $i++) {

        $linea = trim($contenido[$i]);

        if ($linea === "USUARIO:") {

            if ($i + 1 < $cantidad) {
                $usuario = trim($contenido[++$i]);
            }

            continue;
        }

        if ($linea === "ASUNTO:") {

            if ($i + 1 < $cantidad) {
                $asunto = trim($contenido[++$i]);
            }

            continue;
        }

        if ($linea === "COMENTARIO:") {

            if ($i + 1 < $cantidad) {
                $comentario = trim($contenido[++$i]);
            }

            if ($comentario !== "") {

                $hayComentarios = true;

                if ($usuario === "") {
                    $usuario = "Usuario de Organic Zone";
                }

                if ($asunto === "") {
                    $asunto = "Comentario de la comunidad";
                }

                $inicial = strtoupper(
                    mb_substr($usuario, 0, 1, "UTF-8")
                );

                echo '<article class="bloque">';

                echo '<div class="cabecera-comentario">';

                echo '<div class="usuario">';

                echo '<div class="avatar">';
                echo htmlspecialchars($inicial);
                echo '</div>';

                echo '<div class="datos-usuario">';

                echo '<div class="nombre-usuario">';
                echo htmlspecialchars($usuario);
                echo '</div>';

                echo '<div class="tipo-usuario">';
                echo 'Miembro de Comunidad OZ';
                echo '</div>';

                echo '</div>';

                echo '</div>';

                echo '</div>';

                echo '<div class="etiqueta-asunto">';
                echo 'ASUNTO';
                echo '</div>';

                echo '<div class="asunto">';
                echo htmlspecialchars($asunto);
                echo '</div>';

                echo '<div class="separador"></div>';

                echo '<div class="comentario">';
                echo htmlspecialchars($comentario);
                echo '</div>';

                echo '<div class="comilla">“</div>';

                echo '</article>';

                $usuario = "Usuario de Organic Zone";
                $asunto = "";
                $comentario = "";
            }
        }
    }

} else {

    $hayComentarios = false;

}

if (!$hayComentarios) {

    echo '
    <div class="vacio">

        <div class="vacio-icono">
            OZ
        </div>

        <h2>
            Aún no hay comentarios
        </h2>

        <p>
            Cuando nuestra comunidad comparta algo,
            aparecerá aquí.
        </p>

    </div>';

}

?>

</section>

</div>

</body>

</html>
