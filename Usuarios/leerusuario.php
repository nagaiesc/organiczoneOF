<?php

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
    die("Hubo un error en la conexion");
}

if (!isset($_GET['CI'])) {
    die("CI no recibido");
}

$CI = intval($_GET['CI']);

$sql = "SELECT * FROM usuarios WHERE CI = $CI";

$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {

    $fila = $resultado->fetch_assoc();

} else {

    die("Cliente no encontrado");

}

?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Detalle Usuario</title>

<!-- FUENTE FREDOKA -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link
    href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&display=swap"
    rel="stylesheet"
>

<style>

/* =====================================================
   ESTILOS GENERALES
===================================================== */

* {
    box-sizing: border-box;
}

html,
body {

    height: 100%;
    margin: 0;
    padding: 0;

    background: #ffffff;

    font-family: 'Fredoka', Arial, sans-serif;

    color: #2B140D;
}

body {

    display: flex;

    justify-content: center;

    align-items: center;

    padding: 35px;
}


/* =====================================================
   CONTENEDOR PRINCIPAL
===================================================== */

.principal-grid {

    display: grid;

    grid-template-columns: 390px 1fr;

    width: 96vw;

    max-width: 1200px;

    min-height: 600px;

    background: #ffffff;

    border-radius: 18px;

    overflow: hidden;

    box-shadow:
        0 10px 45px rgba(43, 20, 13, 0.12);
}


/* =====================================================
   PANEL IZQUIERDO
===================================================== */

.section-negro {

    background: #2B140D;

    color: #ffffff;

    padding: 45px 40px;

}


/* =====================================================
   NAVEGACIÓN
===================================================== */

.nav-inner {

    margin-bottom: 70px;

}

.nav-inner a {

    color: #ffffff;

    text-decoration: none;

    font-size: 15px;

    font-weight: 600;

    letter-spacing: 1px;

    transition: 0.3s ease;

}

.nav-inner a:hover {

    color: #0ba84a;

}


/* =====================================================
   TÍTULO
===================================================== */

.contrato-titulo {

    font-size: 50px;

    line-height: 1.05;

    font-weight: 700;

    margin: 0 0 30px 0;

    color: #ffffff;

}


/* =====================================================
   DESCRIPCIÓN
===================================================== */

.desc {

    color: #d6ccc8;

    margin-top: 25px;

    font-size: 16px;

    line-height: 1.6;

}


/* =====================================================
   PANEL DERECHO
===================================================== */

.section-blanco {

    background: #ffffff;

    padding: 50px;

}


/* =====================================================
   CARD
===================================================== */

.card {

    width: 100%;

    max-width: 600px;

}


/* =====================================================
   CAMPOS
===================================================== */

.campo {

    margin-bottom: 25px;

    padding: 17px 20px;

    background: #f8f5f2;

    border: 2px solid #eee5df;

    border-radius: 14px;

    transition: 0.25s ease;

}

.campo:hover {

    border-color: #0ba84a;

    background: #f7fcf8;

    transform: translateX(3px);

}


/* ETIQUETA */

.campo span {

    display: block;

    font-size: 13px;

    color: #7b6d67;

    margin-bottom: 6px;

    font-weight: 500;

    letter-spacing: 0.3px;

}


/* VALOR */

.campo strong {

    display: block;

    font-size: 19px;

    color: #2B140D;

    font-weight: 600;

    word-break: break-word;

}


/* =====================================================
   ESTADO
===================================================== */

.campo:nth-child(6) strong {

    color: #0ba84a;

}


/* =====================================================
   BOTÓN VOLVER
===================================================== */

.btn {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    margin-top: 15px;

    background: #0ba84a;

    color: #ffffff;

    padding: 13px 22px;

    border-radius: 50px;

    text-decoration: none;

    font-size: 15px;

    font-weight: 700;

    border: none;

    cursor: pointer;

    transition: 0.3s ease;

}

.btn:hover {

    background: #2B140D;

    transform: translateY(-2px);

}


/* =====================================================
   RESPONSIVE
===================================================== */

@media (max-width: 900px) {

    body {

        align-items: flex-start;

        padding: 20px;

    }

    .principal-grid {

        grid-template-columns: 1fr;

        width: 100%;

        min-height: auto;

    }

    .section-negro {

        padding: 35px;

    }

    .nav-inner {

        margin-bottom: 40px;

    }

    .contrato-titulo {

        font-size: 42px;

    }

    .section-blanco {

        padding: 35px;

    }

}


@media (max-width: 600px) {

    body {

        padding: 10px;

    }

    .principal-grid {

        border-radius: 14px;

    }

    .section-negro {

        padding: 30px;

    }

    .contrato-titulo {

        font-size: 36px;

    }

    .section-blanco {

        padding: 25px;

    }

    .campo strong {

        font-size: 17px;

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


        <nav class="nav-inner">

            <a href="leerusuarios.php">

                VOLVER

            </a>

        </nav>


        <h1 class="contrato-titulo">

            DETALLE<br>
            USUARIO

        </h1>


        <p class="desc">

            Visualiza la información completa
            del usuario seleccionado.

        </p>


    </section>



    <!-- =================================================
         PANEL DERECHO
    ================================================== -->

    <section class="section-blanco">


        <div class="card">


            <div class="campo">

                <span>CI</span>

                <strong>
                    <?= $fila['CI'] ?>
                </strong>

            </div>


            <div class="campo">

                <span>Nombre</span>

                <strong>
                    <?= $fila['nombre'] ?>
                </strong>

            </div>


            <div class="campo">

                <span>Dirección</span>

                <strong>
                    <?= $fila['direccion'] ?>
                </strong>

            </div>


            <div class="campo">

                <span>Celular</span>

                <strong>
                    <?= $fila['celular'] ?>
                </strong>

            </div>


            <div class="campo">

                <span>Rol</span>

                <strong>
                    <?= $fila['rol'] ?>
                </strong>

            </div>


            <div class="campo">

                <span>Estado</span>

                <strong>
                    <?= $fila['estado'] ?>
                </strong>

            </div>


        </div>


    </section>


</section>


</body>

</html>