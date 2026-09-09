<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Organic Zone | Registrar Producto</title>

<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

<link rel="preconnect" href="https://fonts.googleapis.com">

<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">

<style>

:root {
    --verde: #0BA84A;
    --verde-oscuro: #087D38;
    --verde-claro: #EAF7EC;
    --cafe: #2B140D;
    --crema: #FCD09F;
    --crema-clara: #FFF8EF;
    --blanco: #FFFFFF;
    --rojo: #D62828;
    --gris: #756761;
}

* {
    box-sizing: border-box;
}

html,
body {
    margin: 0;
    padding: 0;
    min-height: 100%;
}

body {
    background: #F4F1EE;
    font-family: 'Nunito', sans-serif;
    color: var(--cafe);
}

.pagina {
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 125px 25px 45px;
}

.contenedor {
    width: min(1120px, 100%);
    background: var(--blanco);
    border-radius: 42px;
    overflow: hidden;
    box-shadow: 0 25px 65px rgba(43, 20, 13, .14);
    display: grid;
    grid-template-columns: 34% 66%;
}

.lateral {
    position: relative;
    background: var(--verde);
    padding: 45px 38px;
    min-height: 690px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    overflow: hidden;
}

.lateral::before {
    content: "";
    position: absolute;
    width: 310px;
    height: 310px;
    border-radius: 50%;
    background: rgba(255,255,255,.08);
    top: -135px;
    left: -120px;
}

.lateral::after {
    content: "";
    position: absolute;
    width: 370px;
    height: 370px;
    border-radius: 50%;
    background: rgba(43,20,13,.08);
    bottom: -210px;
    right: -180px;
}

.marca {
    position: relative;
    z-index: 2;
    width: 70px;
    height: 70px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    line-height: .7;
    text-decoration: none;
}

.marca .my {
    color: var(--blanco);
    font-family: 'Fredoka', sans-serif;
    font-size: 22px;
    font-weight: 600;
    letter-spacing: 1px;
    margin-bottom: 6px;
}

.marca .oz {
    color: var(--crema);
    font-family: 'Fredoka', sans-serif;
    font-size: 46px;
    font-weight: 700;
    letter-spacing: -1px;
}

.lateral-contenido {
    position: relative;
    z-index: 2;
    margin-top: -20px;
}

.etiqueta {
    display: inline-flex;
    padding: 8px 15px;
    margin: 0 0 20px;
    border-radius: 50px;
    background: var(--crema);
    color: var(--cafe);
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 1.5px;
}

.lateral h1 {
    margin: 0;
    color: var(--blanco);
    font-family: 'Fredoka', sans-serif;
    font-size: 50px;
    line-height: .98;
    font-weight: 700;
}

.lateral h1 span {
    color: var(--crema);
}

.lateral-texto {
    max-width: 270px;
    margin-top: 23px;
    color: rgba(255,255,255,.88);
    font-size: 15px;
    line-height: 1.65;
}
.formulario-area {
    padding: 50px 60px 48px;
}

.encabezado {
    margin-bottom: 30px;
}

.encabezado p {
    margin: 0 0 7px;
    color: var(--verde);
    font-size: 12px;
    font-weight: 800;
    letter-spacing: 2px;
}

.encabezado h2 {
    margin: 0;
    color: var(--cafe);
    font-family: 'Fredoka', sans-serif;
    font-size: 38px;
    font-weight: 700;
}

.encabezado span {
    display: block;
    margin-top: 5px;
    color: var(--gris);
    font-size: 14px;
    font-weight: 600;
}

.formulario {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 22px 25px;
}

.campo {
    display: flex;
    flex-direction: column;
}

.campo-completo {
    grid-column: 1 / -1;
}

.campo label {
    margin-bottom: 8px;
    color: var(--cafe);
    font-size: 14px;
    font-weight: 800;
}

.input-wrap {
    position: relative;
}

.icono {
    position: absolute;
    left: 17px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--verde);
    font-size: 14px;
    font-weight: 800;
    pointer-events: none;
}

input,
textarea {
    width: 100%;
    border: 2px solid transparent;
    outline: none;
    border-radius: 18px;
    background: var(--verde-claro);
    color: var(--cafe);
    font-family: 'Nunito', sans-serif;
    font-size: 14px;
    font-weight: 700;
    transition: .25s ease;
}

input {
    height: 53px;
    padding: 0 18px 0 45px;
}

textarea {
    min-height: 110px;
    resize: vertical;
    padding: 16px 18px;
}

input:hover,
textarea:hover {
    background: #E3F5E7;
}

input:focus,
textarea:focus {
    background: var(--blanco);
    border-color: var(--verde);
    box-shadow: 0 0 0 4px rgba(11,168,74,.10);
}

input.input-error,
textarea.input-error {
    border-color: var(--rojo);
    background: #FFF5F4;
}

.imagen-area {
    grid-column: 1 / -1;
}

.imagen-box {
    min-height: 125px;
    border: 2px dashed #B9DCC3;
    border-radius: 22px;
    background: var(--verde-claro);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 18px;
    cursor: pointer;
    transition: .25s ease;
}

.imagen-box:hover {
    border-color: var(--verde);
    background: #E3F5E7;
    transform: translateY(-2px);
}

.imagen-contenido {
    display: flex;
    align-items: center;
    gap: 16px;
}

.imagen-icono {
    width: 55px;
    height: 55px;
    border-radius: 18px;
    background: var(--crema);
    color: var(--cafe);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
}

.imagen-texto strong {
    display: block;
    color: var(--cafe);
    font-family: 'Fredoka', sans-serif;
    font-size: 16px;
    margin-bottom: 3px;
}

.imagen-texto span {
    color: var(--gris);
    font-size: 12px;
    font-weight: 600;
}

#imagen {
    display: none;
}

.preview {
    display: none;
    margin-top: 12px;
    padding: 10px;
    background: var(--crema-clara);
    border-radius: 18px;
}

.preview img {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 15px;
    display: block;
}

.acciones {
    grid-column: 1 / -1;
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 12px;
    margin-top: 5px;
}

.btn-cancelar {
    height: 53px;
    padding: 0 25px;
    border-radius: 50px;
    border: 2px solid #E7DED9;
    background: var(--blanco);
    color: var(--cafe);
    font-family: 'Fredoka', sans-serif;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: .25s ease;
}

.btn-cancelar:hover {
    background: var(--crema-clara);
    border-color: var(--crema);
    transform: translateY(-2px);
}

.btn-submit {
    height: 53px;
    padding: 0 32px;
    border: none;
    border-radius: 50px;
    background: var(--cafe);
    color: var(--blanco);
    font-family: 'Fredoka', sans-serif;
    font-size: 17px;
    font-weight: 600;
    cursor: pointer;
    transition: .3s ease;
    box-shadow: 0 8px 20px rgba(43,20,13,.14);
}

.btn-submit:hover {
    background: var(--verde);
    transform: translateY(-3px);
    box-shadow: 0 12px 25px rgba(11,168,74,.23);
}

.btn-submit:active {
    transform: scale(.97);
}

label.error {
    margin-top: 6px;
    color: var(--rojo);
    font-family: 'Nunito', sans-serif;
    font-size: 12px;
    font-weight: 700;
}

.mensaje-imagen {
    margin-top: 7px;
    color: var(--gris);
    font-size: 11px;
    font-weight: 600;
}

@media (max-width: 950px) {

    .contenedor {
        grid-template-columns: 1fr;
    }

    .lateral {
        min-height: 360px;
    }

    .formulario-area {
        padding: 40px 35px;
    }

}

@media (max-width: 650px) {

    .pagina {
        padding: 100px 12px 30px;
    }

    .contenedor {
        border-radius: 28px;
    }

    .lateral {
        min-height: 320px;
        padding: 30px;
    }

    .lateral h1 {
        font-size: 40px;
    }

    .formulario-area {
        padding: 30px 22px;
    }

    .formulario {
        grid-template-columns: 1fr;
    }

    .campo-completo,
    .imagen-area,
    .acciones {
        grid-column: 1;
    }

    .acciones {
        flex-direction: column-reverse;
    }

    .btn-submit,
    .btn-cancelar {
        width: 100%;
    }

}

</style>

</head>

<body>

<div class="pagina">

<div class="contenedor">

<section class="lateral">

<a class="marca" href="../index.php">

<span class="my">My</span>

<span class="oz">Oz</span>

</a>

<div class="lateral-contenido">

<p class="etiqueta">
ORGANIC ZONE
</p>

<h1>
Nuevo
<br>
<span>producto.</span>
</h1>

<p class="lateral-texto">
Agrega un nuevo producto a nuestro catálogo y haz que forme parte de la experiencia Organic Zone.
</p>

</div>

<div>
</div>


</section>

<section class="formulario-area">

<header class="encabezado">

<p>
CATÁLOGO ORGANIC ZONE
</p>

<h2>
Registrar producto
</h2>

<span>
Completa la información del nuevo producto.
</span>

</header>

<form
class="formulario"
id="productoForm"
method="POST"
action="productos.php"
enctype="multipart/form-data"
>

<article class="campo">

<label for="nombre">
Nombre del producto
</label>

<div class="input-wrap">

<span class="icono">
●
</span>

<input
type="text"
name="nombre"
id="nombre"
placeholder="Ej. Hamburguesa de lentejas"
>

</div>

</article>

<article class="campo">

<label for="precio">
Precio
</label>

<div class="input-wrap">

<span class="icono">
Bs
</span>

<input
type="number"
name="precio"
id="precio"
step="0.01"
placeholder="Ej. 25"
>

</div>

</article>

<article class="campo campo-completo">

<label for="descripcion">
Descripción
</label>

<textarea
name="descripcion"
id="descripcion"
placeholder="Describe brevemente el producto..."
></textarea>

</article>

<article class="campo">

<label for="stock">
Stock disponible
</label>

<div class="input-wrap">

<span class="icono">
#
</span>

<input
type="number"
name="stock"
id="stock"
placeholder="Ej. 20"
min="0"
>

</div>

</article>

<article class="campo">

<label for="categoria">
Categoría
</label>

<div class="input-wrap">

<span class="icono">
●
</span>

<input
type="text"
name="categoria"
id="categoria"
placeholder="Ej. Hamburguesas"
>

</div>

</article>

<article class="imagen-area">

<label>
Imagen del producto
</label>

<label
class="imagen-box"
for="imagen"
>

<div class="imagen-contenido">

<div class="imagen-icono">
+
</div>

<div class="imagen-texto">

<strong>
Agregar imagen
</strong>

<span>
Opcional · JPG, PNG o WEBP
</span>

</div>

</div>

</label>

<input
type="file"
name="imagen"
id="imagen"
accept=".jpg,.jpeg,.png,.webp"
>

<div
class="preview"
id="preview"
>

<img
id="previewImagen"
src=""
alt="Vista previa"
>

</div>

<p class="mensaje-imagen">
Puedes registrar el producto aunque no subas una imagen.
</p>

</article>

<section class="acciones">

<a
href="javascript:history.back()"
class="btn-cancelar"
>
Cancelar
</a>

<button
type="submit"
class="btn-submit"
>
Registrar producto
</button>

</section>

</form>

</section>

</div>

</div>

<script>

$(document).ready(function() {

    $("#productoForm").validate({

        rules: {

            nombre: {
                required: true,
                minlength: 2
            },

            precio: {
                required: true,
                number: true,
                min: 0
            },

            descripcion: {
                required: true,
                minlength: 5
            },

            stock: {
                required: true,
                digits: true,
                min: 0
            },

            categoria: {
                required: true,
                minlength: 2
            }

        },

        messages: {

            nombre: {
                required: "Ingresa el nombre del producto",
                minlength: "Ingresa un nombre válido"
            },

            precio: {
                required: "Ingresa el precio",
                number: "Ingresa un precio válido",
                min: "El precio no puede ser negativo"
            },

            descripcion: {
                required: "Ingresa una descripción",
                minlength: "La descripción es demasiado corta"
            },

            stock: {
                required: "Ingresa el stock",
                digits: "Solo se permiten números",
                min: "El stock no puede ser negativo"
            },

            categoria: {
                required: "Ingresa la categoría",
                minlength: "Ingresa una categoría válida"
            }

        },

        errorElement: "label",

        errorClass: "error",

        errorPlacement: function(error, element) {

            if (element.parent(".input-wrap").length) {

                error.insertAfter(element.parent(".input-wrap"));

            } else {

                error.insertAfter(element);

            }

        },

        highlight: function(element) {

            $(element).addClass("input-error");

        },

        unhighlight: function(element) {

            $(element).removeClass("input-error");

        }

    });

    $("#imagen").on("change", function() {

        const archivo = this.files[0];

        if (!archivo) {

            $("#preview").hide();

            $("#previewImagen").attr("src", "");

            return;

        }

        const lector = new FileReader();

        lector.onload = function(e) {

            $("#previewImagen").attr("src", e.target.result);

            $("#preview").fadeIn(250);

        };

        lector.readAsDataURL(archivo);

    });

});

</script>

</body>

</html>
```

