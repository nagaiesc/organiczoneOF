<?php
$conexion = new mysqli("localhost", "root", "", "organiczoneBD");

if ($conexion->connect_error) {
    die("Error en la conexión");
}

if (!isset($_GET['id'])) {
    die("ID no recibido");
}

$id = intval($_GET['id']);

$sql = "SELECT * FROM productos WHERE id = $id";
$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {

    $fila = $resultado->fetch_assoc();

} else {

    die("Producto no encontrado");

}
?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Detalle Producto</title>

<!-- Fredoka -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&display=swap" rel="stylesheet">


<style>

/* =========================
   BASE
========================= */

* {
    box-sizing: border-box;
}

html,
body {

    min-height: 100%;

    margin: 0;
    padding: 0;

    background: #F5EEE3;

    font-family: 'Fredoka', Arial, sans-serif;
}

body {

    display: flex;

    justify-content: center;
    align-items: center;

    padding: 35px;
}


/* =========================
   CONTENEDOR
========================= */

.principal-grid {

    display: grid;

    grid-template-columns: 390px 1fr;

    width: 96vw;

    max-width: 1300px;

    min-height: 650px;

    background: white;

    box-shadow:
        0px 10px 45px rgba(88, 88, 88, 0.15);

    border-radius: 18px;

    overflow: hidden;
}


/* =========================
   PANEL IZQUIERDO
========================= */

.section-negro {

    background: #2B140D;

    color: #fff;

    padding: 45px 40px;
}


/* NAVEGACIÓN */

.nav-inner {

    margin-bottom: 70px;
}

.nav-inner a {

    color: #e6e6e6;

    text-decoration: none;

    font-size: 15px;

    font-weight: 600;

    letter-spacing: 1px;

    transition: 0.3s;
}

.nav-inner a:hover {

    color: #97d395;
}


/* TÍTULO */

.contrato-titulo {

    font-size: 52px;

    line-height: 1.05;

    font-weight: 700;

    margin: 0 0 35px 0;
}


/* DESCRIPCIÓN */

.desc {

    color: #c9c0bd;

    margin-top: 25px;

    font-size: 16px;

    line-height: 1.6;
}


/* =========================
   PANEL DERECHO
========================= */

.section-blanco {

    background: #ffffff;

    padding: 45px;

    overflow-y: auto;
}


/* =========================
   GRID
========================= */

.grid-derecha {

    display: grid;

    grid-template-columns: 1fr 1fr;

    gap: 45px;

    align-items: start;
}


/* =========================
   INFORMACIÓN
========================= */

.card {

    width: 100%;
}


/* TÍTULO DE INFORMACIÓN */

.card::before {

    content: "Información del producto";

    display: block;

    color: #2B140D;

    font-size: 25px;

    font-weight: 700;

    margin-bottom: 28px;
}


/* CAMPOS */

.campo {

    margin-bottom: 20px;

    padding-bottom: 15px;

    border-bottom: 1px solid #eeeeee;
}


.campo span {

    display: block;

    font-size: 13px;

    color: #8a817d;

    margin-bottom: 5px;

    font-weight: 500;
}


.campo strong {

    display: block;

    color: #2B140D;

    font-size: 18px;

    font-weight: 600;

    word-break: break-word;
}


/* =========================
   BOTÓN VOLVER
========================= */

.btn {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    min-height: 40px;

    margin-top: 10px;

    padding: 10px 20px;

    background: #2B140D;

    color: #fff;

    border-radius: 10px;

    text-decoration: none;

    font-family: 'Fredoka', Arial, sans-serif;

    font-size: 14px;

    font-weight: 600;

    border: none;

    cursor: pointer;

    transition: all 0.25s ease;
}


.btn:hover {

    background: #4a2519;

    transform: translateY(-2px);

    box-shadow:
        0 6px 15px rgba(43, 20, 13, 0.18);
}


/* =========================
   CAJA DE IMAGEN
========================= */

.upload-box {

    background: #faf7f2;

    border: 2px dashed #d8cec2;

    padding: 28px;

    text-align: center;

    border-radius: 16px;

    min-height: 480px;
}


.upload-box h3 {

    margin-top: 0;

    margin-bottom: 22px;

    color: #2B140D;

    font-size: 22px;

    font-weight: 700;
}


/* =========================
   IMAGEN ACTUAL
========================= */

.preview {

    margin-top: 18px;
}


.preview p {

    margin: 0 0 12px 0;

    font-size: 13px;

    color: #8a817d;

    font-weight: 500;
}


.preview img {

    display: block;

    margin: auto;

    max-width: 300px;

    max-height: 300px;

    width: auto;

    height: auto;

    object-fit: cover;

    border-radius: 14px;

    box-shadow:
        0 8px 25px rgba(43, 20, 13, 0.12);

    background: white;
}


/* =========================
   INPUT ARCHIVO
========================= */

input[type="file"] {

    width: 100%;

    margin-top: 20px;

    padding: 10px;

    background: white;

    border: 1px solid #ddd2c5;

    border-radius: 9px;

    font-family: 'Fredoka', Arial, sans-serif;

    font-size: 13px;

    color: #4b403a;

    cursor: pointer;
}


input[type="file"]::file-selector-button {

    background: #2B140D;

    color: white;

    border: none;

    padding: 8px 14px;

    border-radius: 7px;

    font-family: 'Fredoka', Arial, sans-serif;

    font-weight: 600;

    cursor: pointer;

    margin-right: 10px;
}


input[type="file"]::file-selector-button:hover {

    background: #4a2519;
}


/* =========================
   BOTÓN ACTUALIZAR
========================= */

.upload-box .btn {

    margin-top: 15px;

    width: 100%;

    background: #97d395;

    color: #1d3b20;
}


.upload-box .btn:hover {

    background: #2B140D;

    color: white;
}


/* =========================
   RESPONSIVE
========================= */

@media (max-width: 950px) {

    body {

        padding: 20px;
    }

    .principal-grid {

        grid-template-columns: 1fr;

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

        padding: 30px;
    }

    .grid-derecha {

        grid-template-columns: 1fr;

        gap: 30px;
    }

}


@media (max-width: 500px) {

    .contrato-titulo {

        font-size: 36px;
    }

    .upload-box {

        padding: 20px;
    }

    .preview img {

        max-width: 100%;

        max-height: 250px;
    }

}

</style>

</head>


<body>


<section class="principal-grid">


    <!-- =========================
         PANEL IZQUIERDO
    ========================== -->

    <section class="section-negro">

        <nav class="nav-inner">

            <a href="leerproductos.php">
                ← VOLVER
            </a>

        </nav>


        <h1 class="contrato-titulo">

            DETALLE<br>
            PRODUCTO

        </h1>


        <p class="desc">

            Visualiza la información del producto
            seleccionado y administra su imagen
            de manera rápida y sencilla.

        </p>

    </section>



    <!-- =========================
         PANEL DERECHO
    ========================== -->

    <section class="section-blanco">


        <div class="grid-derecha">


            <!-- =========================
                 INFORMACIÓN
            ========================== -->

            <div class="card">


                <div class="campo">

                    <span>ID</span>

                    <strong>
                        <?= htmlspecialchars($fila['id']) ?>
                    </strong>

                </div>



                <div class="campo">

                    <span>Nombre</span>

                    <strong>
                        <?= htmlspecialchars($fila['nombre']) ?>
                    </strong>

                </div>



                <div class="campo">

                    <span>Descripción</span>

                    <strong>
                        <?= htmlspecialchars($fila['descripcion']) ?>
                    </strong>

                </div>



                <div class="campo">

                    <span>Precio</span>

                    <strong>
                        <?= htmlspecialchars($fila['precio']) ?>
                    </strong>

                </div>



                <div class="campo">

                    <span>Costo</span>

                    <strong>
                        <?= htmlspecialchars($fila['costo']) ?>
                    </strong>

                </div>



                <div class="campo">

                    <span>Stock</span>

                    <strong>
                        <?= htmlspecialchars($fila['stock']) ?>
                    </strong>

                </div>



                <a
                    class="btn"
                    href="leerproductos.php"
                >
                    ← Volver a productos
                </a>


            </div>



            <!-- =========================
                 IMAGEN
            ========================== -->

            <div class="upload-box">


                <h3>
                    Imagen del producto
                </h3>


                <?php

                $nombreArchivo = "P-" . $fila['id'];

                $directorio = "../Imagenes/";

                $extensiones = [
                    "jpg",
                    "jpeg",
                    "png",
                    "gif",
                    "webp"
                ];

                $archivoEncontrado = null;


                foreach ($extensiones as $ext) {

                    $ruta =
                        $directorio .
                        $nombreArchivo .
                        "." .
                        $ext;


                    if (file_exists($ruta)) {

                        $archivoEncontrado = $ruta;

                        break;
                    }

                }

                ?>


                <!-- IMAGEN ACTUAL -->

                <div class="preview">

                    <p>
                        Imagen actual
                    </p>


                    <?php

                    if ($archivoEncontrado) {

                    ?>

                        <img
                            src="<?= htmlspecialchars($archivoEncontrado) ?>"
                            alt="Imagen del producto"
                        >

                    <?php

                    } else {

                    ?>

                        <img
                            src="../Imagenes/sinimagen.png"
                            alt="Sin imagen"
                        >

                    <?php

                    }

                    ?>

                </div>



                <!-- FORMULARIO -->

                <form
                    action="subirimagen.php"
                    method="post"
                    enctype="multipart/form-data"
                >


                    <input
                        type="hidden"
                        name="id"
                        value="<?= htmlspecialchars($fila['id']) ?>"
                    >


                    <input
                        type="file"
                        name="imagen"
                        accept="image/*"
                        onchange="previewImage(event)"
                    >


                    <button
                        class="btn"
                        type="submit"
                    >
                        Actualizar imagen
                    </button>


                </form>



                <!-- PREVISUALIZACIÓN -->

                <div
                    class="preview"
                    id="previewContainer"
                    style="display:none;"
                >

                    <p>
                        Previsualización
                    </p>


                    <img
                        id="preview"
                        src=""
                        alt="Previsualización"
                    >

                </div>


            </div>


        </div>


    </section>


</section>



<script>

function previewImage(event) {

    const archivo = event.target.files[0];

    if (!archivo) {

        return;

    }


    const reader = new FileReader();


    reader.onload = function() {

        const img =
            document.getElementById('preview');

        const container =
            document.getElementById('previewContainer');


        img.src = reader.result;

        container.style.display = 'block';

    };


    reader.readAsDataURL(archivo);

}

</script>


</body>

</html>