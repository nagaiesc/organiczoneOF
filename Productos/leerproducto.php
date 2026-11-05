<?php
session_start();
require_once "../seguridad.php";
verificarAdminVendedor();

$conexion = new mysqli("localhost", "root", "", "organiczoneBD");

if ($conexion->connect_error) {
    die("Error en la conexión");
}

if (!isset($_GET['id'])) {
    die("ID no recibido");
}

$id = intval($_GET['id']);

$stmt = $conexion->prepare("SELECT * FROM productos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();
} else {
    die("Producto no encontrado");
}

/* Buscar la imagen actual del producto */
$nombreArchivo = "P-" . $fila['id'];
$directorio = "../Imagenes/";
$extensiones = ["jpg", "jpeg", "png", "gif", "webp"];
$archivoEncontrado = null;

foreach ($extensiones as $ext) {
    $ruta = $directorio . $nombreArchivo . "." . $ext;
    if (file_exists($ruta)) {
        $archivoEncontrado = $ruta;
        break;
    }
}

/* ?v= evita que el navegador muestre la imagen vieja desde caché */
$srcImagen = $archivoEncontrado
    ? $archivoEncontrado . "?v=" . filemtime($archivoEncontrado)
    : "../Imagenes/sinimagen.png";
?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Detalle Producto</title>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Fredoka -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&display=swap" rel="stylesheet">


<style>

/* ========================= BASE ========================= */

* { box-sizing: border-box; }

html, body {
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


/* ========================= CONTENEDOR ========================= */

.principal-grid {
    display: grid;
    grid-template-columns: 390px 1fr;
    width: 96vw;
    max-width: 1300px;
    min-height: 650px;
    background: white;
    box-shadow: 0px 10px 45px rgba(88, 88, 88, 0.15);
    border-radius: 18px;
    overflow: hidden;
}


/* ========================= PANEL IZQUIERDO ========================= */

.section-negro {
    background: #2B140D;
    color: #fff;
    padding: 45px 40px;
}

.nav-inner { margin-bottom: 70px; }

.nav-inner a {
    color: #e6e6e6;
    text-decoration: none;
    font-size: 15px;
    font-weight: 600;
    letter-spacing: 1px;
    transition: 0.3s;
}

.nav-inner a:hover { color: #97d395; }

.contrato-titulo {
    font-size: 52px;
    line-height: 1.05;
    font-weight: 700;
    margin: 0 0 35px 0;
}

.desc {
    color: #c9c0bd;
    margin-top: 25px;
    font-size: 16px;
    line-height: 1.6;
}


/* ========================= PANEL DERECHO ========================= */

.section-blanco {
    background: #ffffff;
    padding: 45px;
    overflow-y: auto;
}

.grid-derecha {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 45px;
    align-items: start;
}


/* ========================= INFORMACIÓN ========================= */

.card { width: 100%; }

.card::before {
    content: "Información del producto";
    display: block;
    color: #2B140D;
    font-size: 25px;
    font-weight: 700;
    margin-bottom: 28px;
}

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


/* ========================= BOTÓN VOLVER ========================= */

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
    box-shadow: 0 6px 15px rgba(43, 20, 13, 0.18);
}


/* ========================= CAJA DE IMAGEN ========================= */

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


/* ========================= IMAGEN ACTUAL ========================= */

.preview { margin-top: 18px; }

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
    box-shadow: 0 8px 25px rgba(43, 20, 13, 0.12);
    background: white;
}


/* ========================= INPUT ARCHIVO ========================= */

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

input[type="file"]::file-selector-button:hover { background: #4a2519; }


/* ========================= BOTÓN ACTUALIZAR ========================= */

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

.upload-box .btn:disabled {
    opacity: .6;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}


/* ========================= ALERTAS (SweetAlert2) ========================= */

.oz-popup {
    width: 430px !important;
    border-radius: 32px !important;
    padding: 35px 32px 30px !important;
    background: #FFFDF9 !important;
    border: 3px solid #FCD09F !important;
    box-shadow: 0 20px 60px rgba(43,20,13,.25) !important;
    font-family: 'Fredoka', Arial, sans-serif !important;
}

.oz-title {
    color: #2B140D !important;
    font-family: 'Fredoka', Arial, sans-serif !important;
    font-size: 29px !important;
    font-weight: 700 !important;
}

.oz-text {
    color: #665752 !important;
    font-family: 'Fredoka', Arial, sans-serif !important;
    font-size: 16px !important;
}

.oz-confirm {
    background: #D62828 !important;
    color: #ffffff !important;
    border: none !important;
    border-radius: 50px !important;
    padding: 12px 28px !important;
    margin: 5px !important;
    font-family: 'Fredoka', Arial, sans-serif !important;
    font-size: 14px !important;
    font-weight: 600 !important;
    cursor: pointer !important;
    box-shadow: none !important;
    transition: .25s ease !important;
}

.oz-confirm:hover {
    background: #B71C1C !important;
    transform: translateY(-2px) !important;
}

.oz-success {
    background: #0BA84A !important;
    color: #ffffff !important;
    border: none !important;
    border-radius: 50px !important;
    padding: 12px 28px !important;
    font-family: 'Fredoka', Arial, sans-serif !important;
    font-size: 14px !important;
    font-weight: 600 !important;
    cursor: pointer !important;
    box-shadow: none !important;
    transition: .25s ease !important;
}

.oz-success:hover {
    background: #087D38 !important;
    transform: translateY(-2px) !important;
}

.swal2-icon { margin-top: 0 !important; }

.oz-dato {
    display: inline-block;
    margin-top: 4px;
    padding: 5px 15px;
    border-radius: 100px;
    background: #F5EEE3;
    color: #2B140D;
    font-weight: 700;
}


/* ========================= RESPONSIVE ========================= */

@media (max-width: 950px) {
    body { padding: 20px; }
    .principal-grid { grid-template-columns: 1fr; }
    .section-negro { padding: 35px; }
    .nav-inner { margin-bottom: 40px; }
    .contrato-titulo { font-size: 42px; }
    .section-blanco { padding: 30px; }
    .grid-derecha { grid-template-columns: 1fr; gap: 30px; }
}

@media (max-width: 500px) {
    .contrato-titulo { font-size: 36px; }
    .upload-box { padding: 20px; }
    .preview img { max-width: 100%; max-height: 250px; }

    .oz-popup {
        width: calc(100% - 18px) !important;
        max-width: 380px !important;
        border-radius: 25px !important;
        padding: 25px 18px 22px !important;
    }

    .oz-title { font-size: 23px !important; }
    .oz-text { font-size: 14px !important; }

    .oz-confirm, .oz-success {
        padding: 10px 22px !important;
        font-size: 13px !important;
    }
}

</style>


<?php include $_SERVER['DOCUMENT_ROOT'] . '/organiczoneOF/includes/oz-navegacion.php'; ?>
</head>


<body>

<section class="principal-grid">

    <!-- PANEL IZQUIERDO -->

    <section class="section-negro">

        <nav class="nav-inner">
            <a href="leerproductos.php">← VOLVER</a>
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


    <!-- PANEL DERECHO -->

    <section class="section-blanco">

        <div class="grid-derecha">

            <!-- INFORMACIÓN -->

            <div class="card">

                <div class="campo">
                    <span>ID</span>
                    <strong><?= htmlspecialchars($fila['id']) ?></strong>
                </div>

                <div class="campo">
                    <span>Nombre</span>
                    <strong><?= htmlspecialchars($fila['nombre']) ?></strong>
                </div>

                <div class="campo">
                    <span>Descripción</span>
                    <strong><?= htmlspecialchars($fila['descripcion']) ?></strong>
                </div>

                <div class="campo">
                    <span>Precio</span>
                    <strong><?= htmlspecialchars($fila['precio']) ?></strong>
                </div>

                <div class="campo">
                    <span>Costo</span>
                    <strong><?= htmlspecialchars($fila['costo']) ?></strong>
                </div>

                <div class="campo">
                    <span>Stock</span>
                    <strong><?= htmlspecialchars($fila['stock']) ?></strong>
                </div>

                <a class="btn" href="leerproductos.php">← Volver a productos</a>

            </div>


            <!-- IMAGEN -->

            <div class="upload-box">

                <h3>Imagen del producto</h3>

                <!-- IMAGEN ACTUAL -->

                <div class="preview">

                    <p>Imagen actual</p>

                    <img
                        id="imgActual"
                        src="<?= htmlspecialchars($srcImagen) ?>"
                        alt="Imagen del producto"
                    >

                </div>


                <!-- FORMULARIO -->

                <form
                    id="formImagen"
                    action="subirimagen.php"
                    method="post"
                    enctype="multipart/form-data"
                    novalidate
                >

                    <input type="hidden" name="id" value="<?= htmlspecialchars($fila['id']) ?>">

                    <input
                        id="inputImagen"
                        type="file"
                        name="imagen"
                        accept="image/*"
                        onchange="previewImage(event)"
                    >

                    <button class="btn" type="submit">
                        Actualizar imagen
                    </button>

                </form>


                <!-- PREVISUALIZACIÓN -->

                <div class="preview" id="previewContainer" style="display:none;">

                    <p>Previsualización</p>

                    <img id="preview" src="" alt="Previsualización">

                </div>

            </div>

        </div>

    </section>

</section>


<script>

/* Tamaño máximo permitido: 2 MB */
const TAMANO_MAXIMO = 2 * 1024 * 1024;


/* =========================
   ALERTAS
========================= */

function alertaImagenGrande(bytes) {

    const mb = (bytes / (1024 * 1024)).toFixed(2);

    Swal.fire({

        title: "La imagen es muy pesada",

        html: `
            <div style="font-family:'Fredoka', sans-serif; color:#665752; font-size:16px; line-height:1.5;">
                El archivo que elegiste pesa
                <strong style="color:#2B140D;">${mb} MB</strong>.
                <br><br>
                El tamaño máximo permitido es
                <br>
                <span class="oz-dato">2 MB</span>
                <br><br>
                <span style="color:#D62828; font-size:14px; font-weight:600;">
                    Elige una imagen más liviana.
                </span>
            </div>
        `,

        icon: "error",
        iconColor: "#D62828",
        background: "#FFFDF9",
        confirmButtonText: "Entendido",
        buttonsStyling: false,

        customClass: {
            popup: "oz-popup",
            title: "oz-title",
            htmlContainer: "oz-text",
            confirmButton: "oz-confirm"
        }

    });

}


function alertaSinImagen() {

    Swal.fire({

        title: "Ninguna imagen seleccionada",

        html: `
            <div style="font-family:'Fredoka', sans-serif; color:#665752; font-size:16px; line-height:1.5;">
                Selecciona una imagen
                antes de actualizar
                la foto del producto.
            </div>
        `,

        icon: "info",
        iconColor: "#2B140D",
        background: "#FFFDF9",
        confirmButtonText: "Entendido",
        buttonsStyling: false,

        customClass: {
            popup: "oz-popup",
            title: "oz-title",
            htmlContainer: "oz-text",
            confirmButton: "oz-success"
        }

    });

}


function alertaExito() {

    Swal.fire({

        title: "¡Imagen actualizada!",

        html: `
            <div style="font-family:'Fredoka', sans-serif; color:#665752; font-size:16px; line-height:1.5;">
                La foto del producto se
                guardó correctamente.
            </div>
        `,

        icon: "success",
        iconColor: "#0BA84A",
        background: "#FFFDF9",
        confirmButtonText: "Aceptar",
        buttonsStyling: false,

        customClass: {
            popup: "oz-popup",
            title: "oz-title",
            htmlContainer: "oz-text",
            confirmButton: "oz-success"
        }

    });

}


function alertaError(mensaje) {

    Swal.fire({

        title: "No se pudo actualizar",

        text: mensaje,

        icon: "error",
        iconColor: "#D62828",
        background: "#FFFDF9",
        confirmButtonText: "Entendido",
        buttonsStyling: false,

        customClass: {
            popup: "oz-popup",
            title: "oz-title",
            htmlContainer: "oz-text",
            confirmButton: "oz-confirm"
        }

    });

}


/* =========================
   PREVISUALIZACIÓN
========================= */

function previewImage(event) {

    const input = event.target;
    const archivo = input.files[0];
    const container = document.getElementById('previewContainer');

    if (!archivo) {
        container.style.display = 'none';
        return;
    }

    /* Más de 2 MB: se avisa y se limpia la selección */

    if (archivo.size > TAMANO_MAXIMO) {
        alertaImagenGrande(archivo.size);
        input.value = "";
        container.style.display = 'none';
        return;
    }

    const reader = new FileReader();

    reader.onload = function () {
        document.getElementById('preview').src = reader.result;
        container.style.display = 'block';
    };

    reader.readAsDataURL(archivo);

}


/* =========================
   VALIDAR Y ENVIAR
========================= */

document
    .getElementById('formImagen')
    .addEventListener('submit', async function (e) {

        e.preventDefault();

        const input = document.getElementById('inputImagen');
        const archivo = input.files[0];
        const boton = this.querySelector('button[type="submit"]');
        const container = document.getElementById('previewContainer');

        /* Ninguna imagen seleccionada */

        if (!archivo) {
            alertaSinImagen();
            return;
        }

        /* Revisar tamaño */

        if (archivo.size > TAMANO_MAXIMO) {
            alertaImagenGrande(archivo.size);
            input.value = "";
            container.style.display = 'none';
            return;
        }

        boton.disabled = true;
        boton.textContent = "Subiendo...";

        try {

            const resp = await fetch('subirimagen.php', {
                method: 'POST',
                body: new FormData(this)
            });

            const data = await resp.json();

            if (data.ok) {

                /* Muestra la nueva imagen sin usar la caché */
                document.getElementById('imgActual').src =
                    data.ruta + '?v=' + Date.now();

                input.value = "";
                container.style.display = 'none';

                alertaExito();

            } else {

                alertaError(data.mensaje);

            }

        } catch (err) {

            alertaError("No se pudo conectar con el servidor o la sesión expiró.");

        } finally {

            boton.disabled = false;
            boton.textContent = "Actualizar imagen";

        }

    });

</script>

</body>

</html>