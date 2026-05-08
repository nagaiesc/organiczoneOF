<?php
$conexion = new mysqli("localhost", "root", "", "productosOZ");

if ($conexion->connect_error) {
    die("Error en la conexión");
}

$id = intval($_GET['id']);

$sql = "SELECT * FROM productos WHERE id = $id";
$resultado = $conexion->query($sql);

$fila = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Detalle Producto</title>

<style>
html, body {
    height: 100%;
    margin: 0;
    background: #969696;
    font-family: 'Inter', Arial, sans-serif;
}

body {
    display: flex;
    justify-content: center;
    align-items: center;
}

.principal-grid {
    display: grid;
    grid-template-columns: 440px 1fr;
    width: 96vw;
    max-width: 1300px;
    min-height: 600px;
    box-shadow: 0px 6px 40px rgba(88, 88, 88, 0.16);
    border-radius: 10px;
    overflow: hidden;
}

/* IZQUIERDA */
.section-negro {
    background: #000;
    color: #fff;
    padding: 40px;
}

.nav-inner a {
    color: #e0e0e0;
    text-decoration: none;
}

.contrato-titulo {
    font-size: 2.3em;
    font-weight: 900;
    margin-top: 40px;
}

.desc {
    color: #bababa;
    margin-top: 20px;
}

/* DERECHA */
.section-blanco {
    background: #fff;
    padding: 40px;
}

/* GRID INTERNO */
.grid-derecha {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
}

/* CARD */
.card {
    max-width: 100%;
}

.campo {
    margin-bottom: 20px;
}

.campo span {
    display: block;
    font-size: 13px;
    color: #777;
}

.campo strong {
    font-size: 18px;
}

/* UPLOAD */
.upload-box {
    border: 2px dashed #ccc;
    padding: 20px;
    text-align: center;
    border-radius: 10px;
}

.upload-box input {
    margin-top: 10px;
}

.preview {
    margin-top: 20px;
}

.preview img {
    max-width: 100%;
    border-radius: 8px;
}

/* BOTÓN */
.btn {
    display: inline-block;
    margin-top: 20px;
    background: #000;
    color: #fff;
    padding: 8px 16px;
    text-decoration: none;
    font-weight: 600;
}

.btn:hover {
    background: #222;
}
</style>
</head>

<body>

<section class="principal-grid">

    <!-- IZQUIERDA -->
    <section class="section-negro">
        <nav class="nav-inner">
            <a href="leerproductos.php">VOLVER</a>
        </nav>

        <h1 class="contrato-titulo">DETALLE PRODUCTO</h1>

        <p class="desc">
            Visualiza y gestiona el producto seleccionado.
        </p>
    </section>

    <!-- DERECHA -->
    <section class="section-blanco">

        <div class="grid-derecha">

            <!-- DETALLE -->
            <div class="card">

                <div class="campo">
                    <span>ID</span>
                    <strong><?= $fila['id'] ?></strong>
                </div>

                <div class="campo">
                    <span>Nombre</span>
                    <strong><?= $fila['nombreproducto'] ?></strong>
                </div>

                <div class="campo">
                    <span>Precio</span>
                    <strong><?= $fila['precioventa'] ?></strong>
                </div>

                <div class="campo">
                    <span>Cantidad</span>
                    <strong><?= $fila['cantidad'] ?></strong>
                </div>

                <div class="campo">
                    <span>Costo</span>
                    <strong><?= $fila['costo'] ?></strong>
                </div>

                <a class="btn" href="leerproductos.php">Volver</a>

            </div>

            <!-- SUBIDA -->
            <div class="upload-box">

            <h3>Imagen del producto</h3>

            <!-- IMAGEN ACTUAL -->
             <?php  
                //nombre del posible archivo
                $nombreArchivo="P-".$id;
                $directorio = "../Imagenes/";
                //lista de todas las extenciones posibles
                $extensiones = ["pdf", "jpg", "jpeg", "png", "gif", "webp"];
                //bandera para verificar todo tipo de archivo
                $archivoEncontrado = null;
                //verificar si el archivo se creo en alguna extension conocida
                foreach ($extensiones as $ext) {
                    //nombre del archivo con cada extension
                    $ruta = $directorio . $nombreArchivo . "." . $ext;
                    //verifica
                    if (file_exists($ruta)) {
                        $archivoEncontrado = $ruta;
                        // detenemos la búsqueda en cuanto lo encuentra
                        break;
                    }
                }
                
            ?>
            <?php if ($archivoEncontrado) {?>
                <div class="preview">
                    <p style="font-size:13px; color:#777;">Imagen actual</p>
                    <img src="<?= $archivoEncontrado ?>" alt="Imagen actual">
                </div>
            <?php } else { ?>
                <p style="font-size:13px; color:#999;">Sin imagen cargada</p>
            <?php } ?>

            <!-- SUBIDA -->
            <form action="subirimagen.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $id ?>">

                <input type="file" name="imagen" accept="image/*" onchange="previewImage(event)">
                
                <button class="btn" type="submit">Actualizar imagen</button>
            </form>

            <!-- PREVIEW NUEVO -->
            <div class="preview">
                <p style="font-size:13px; color:#777;">Previsualización</p>
                <img id="preview" src="" alt="">
            </div>

</div>

        </div>

    </section>

</section>

<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function(){
        const img = document.getElementById('preview');
        img.src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>

</body>
</html>