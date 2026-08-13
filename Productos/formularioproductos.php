<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Registro de Productos</title>


<!-- =========================
     FUENTE FREDOKA
========================= -->

<link rel="preconnect" href="https://fonts.googleapis.com">

<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link
    href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&display=swap"
    rel="stylesheet"
>


<!-- =========================
     JQUERY
========================= -->

<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>


<style>

/* ==================================================
   ESTILOS GENERALES
================================================== */

* {
    box-sizing: border-box;
}

html,
body {

    margin: 0;
    padding: 0;

    min-height: 100vh;

    background: #ffffff;

    font-family: 'Fredoka', sans-serif;

    color: #2B140D;
}


/* ==================================================
   CUERPO
================================================== */

body {

    display: flex;

    justify-content: center;

    align-items: center;

    padding: 40px 20px;

}


/* ==================================================
   CONTENEDOR PRINCIPAL
================================================== */

.cajp {

    width: 100%;

    max-width: 760px;

    background: #ffffff;

    border-radius: 28px;

    padding: 45px 55px;

    box-shadow:
        0 12px 40px rgba(43, 20, 13, 0.12);

    border: 1px solid #eeeeee;

}


/* ==================================================
   ENCABEZADO
================================================== */

.nav {

    display: flex;

    justify-content: center;

    align-items: center;

    margin-bottom: 12px;

    color: #0ba84a;

    font-size: 18px;

    font-weight: 700;

    letter-spacing: 2px;

    text-transform: uppercase;

}


/* ==================================================
   TÍTULO
================================================== */

.titu {

    font-size: 48px;

    line-height: 1.1;

    font-weight: 700;

    text-align: center;

    color: #2B140D;

    margin-bottom: 40px;

}


/* ==================================================
   FORMULARIO
================================================== */

.forma {

    width: 100%;

}


/* ==================================================
   FILAS
================================================== */

.fil {

    display: grid;

    grid-template-columns: 1fr 1fr;

    gap: 24px;

    width: 100%;

    margin-bottom: 28px;

}


/* ==================================================
   CAMPOS
================================================== */

.fil > div {

    display: flex;

    flex-direction: column;

    gap: 8px;

}


/* ==================================================
   LABEL
================================================== */

.fil label {

    font-family: 'Fredoka', sans-serif;

    font-size: 15px;

    font-weight: 600;

    color: #2B140D;

}


/* ==================================================
   INPUTS
================================================== */

.fil input {

    width: 100%;

    padding: 13px 15px;

    border: 2px solid #eadfd5;

    border-radius: 12px;

    background: #ffffff;

    color: #2B140D;

    font-family: 'Fredoka', sans-serif;

    font-size: 15px;

    outline: none;

    transition: all 0.3s ease;

}


/* ==================================================
   INPUT FOCUS
================================================== */

.fil input:focus {

    border-color: #0ba84a;

    box-shadow:
        0 0 0 3px rgba(11, 168, 74, 0.12);

    background: #ffffff;

}


/* ==================================================
   INPUT ARCHIVO
================================================== */

.fil input[type="file"] {

    padding: 10px;

    cursor: pointer;

    background: #faf8f5;

}


/* ==================================================
   HOVER ARCHIVO
================================================== */

.fil input[type="file"]:hover {

    border-color: #0ba84a;

    background: #f5faf6;

}


/* ==================================================
   BOTÓN GUARDAR
================================================== */

button[type="submit"] {

    display: block;

    width: 100%;

    padding: 15px;

    border: none;

    border-radius: 14px;

    background: #0ba84a;

    color: #ffffff;

    font-family: 'Fredoka', sans-serif;

    font-size: 17px;

    font-weight: 700;

    cursor: pointer;

    transition: all 0.3s ease;

}


/* ==================================================
   HOVER BOTÓN
================================================== */

button[type="submit"]:hover {

    background: #098f3f;

    transform: translateY(-2px);

    box-shadow:
        0 7px 18px rgba(11, 168, 74, 0.25);

}


/* ==================================================
   BOTÓN VOLVER
================================================== */

.volver {

    display: flex;

    justify-content: center;

    margin-top: 15px;

}


.volver a {

    text-decoration: none;

    color: #2B140D;

    background: #FCD09F;

    padding: 11px 22px;

    border-radius: 30px;

    font-size: 15px;

    font-weight: 600;

    transition: all 0.3s ease;

}


.volver a:hover {

    background: #2B140D;

    color: #ffffff;

    transform: translateY(-2px);

}


/* ==================================================
   PIE
================================================== */

.pie {

    text-align: center;

    margin-top: 30px;

    padding-top: 20px;

    border-top: 1px solid #eeeeee;

    font-size: 13px;

    color: #8b817d;

}


/* ==================================================
   MENSAJES DE VALIDACIÓN
================================================== */

label.error {

    color: #b83232 !important;

    font-size: 12px !important;

    font-weight: 500 !important;

    margin-top: -3px;

}


/* ==================================================
   RESPONSIVE
================================================== */

@media (max-width: 650px) {

    body {

        padding: 20px 12px;

        align-items: flex-start;

    }


    .cajp {

        margin-top: 20px;

        padding: 35px 25px;

        border-radius: 22px;

    }


    .titu {

        font-size: 35px;

        margin-bottom: 30px;

    }


    .fil {

        grid-template-columns: 1fr;

        gap: 20px;

        margin-bottom: 22px;

    }


    .nav {

        font-size: 16px;

    }

}

</style>

</head>


<body>


<!-- ==================================================
     CONTENEDOR
================================================== -->

<div class="cajp">


    <!-- MARCA -->

    <div class="nav">

        ORGANIC ZONE

    </div>


    <!-- TÍTULO -->

    <div class="titu">

        Registro de Producto

    </div>


    <!-- ==================================================
         FORMULARIO
    ================================================== -->

    <form
        action="productos.php"
        method="post"
        enctype="multipart/form-data"
    >

        <div class="fil">


            <!-- NOMBRE -->

            <div>

                <label>
                    Nombre
                </label>

                <input
                    type="text"
                    name="nombre"
                >

            </div>


            <!-- DESCRIPCIÓN -->

            <div>

                <label>
                    Descripción
                </label>

                <input
                    type="text"
                    name="descripcion"
                >

            </div>


            <!-- PRECIO -->

            <div>

                <label>
                    Precio
                </label>

                <input
                    type="number"
                    name="precio"
                    step="0.01"
                >

            </div>


            <!-- COSTO -->

            <div>

                <label>
                    Costo
                </label>

                <input
                    type="number"
                    name="costo"
                    step="0.01"
                >

            </div>


            <!-- STOCK -->

            <div>

                <label>
                    Stock
                </label>

                <input
                    type="number"
                    name="stock"
                >

            </div>


            <!-- IMAGEN -->

            <div>

                <label>
                    Imagen del producto
                </label>

                <input
                    type="file"
                    name="imagen"
                    accept="image/jpeg,image/png,image/gif,image/webp"
                >

            </div>


        </div>


        <!-- BOTÓN -->

        <button type="submit">

            Guardar Producto

        </button>


    </form>


    <!-- ==================================================
         VOLVER
    ================================================== -->

    <div class="volver">

        <a href="leerproductos.php">

            ← Volver a productos

        </a>

    </div>


    <!-- PIE -->

    <div class="pie">

        Organic Zone - Cochabamba, Bolivia 2026

    </div>


</div>


<!-- ==================================================
     VALIDACIÓN
================================================== -->

<script>

$("form").validate({

    rules: {

        nombre: {

            required: true

        },

        descripcion: {

            required: true

        },

        precio: {

            required: true

        },

        costo: {

            required: true

        },

        stock: {

            required: true

        }

    },


    messages: {

        nombre: {

            required: "Este campo no puede ir vacío"

        },

        descripcion: {

            required: "Este campo debe llenarse"

        },

        precio: {

            required: "Este campo no puede ir vacío"

        },

        costo: {

            required: "Este campo no puede ir vacío"

        },

        stock: {

            required: "Este campo no puede ir vacío"

        }

    }

});

</script>


</body>

</html>