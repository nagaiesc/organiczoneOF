<?php

session_start();

$nombrevendedor = $_SESSION['nombre'] ?? '';

?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Registro de Pedido | Organic Zone</title>

<link rel="preconnect" href="https://fonts.googleapis.com">

<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Nunito:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

<style>

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    background: #F4F1EE;
    font-family: 'Nunito', sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    padding: 30px;
    color: #3A1E13;
}

.contenedor {
    width: 100%;
    max-width: 920px;
    background: #FFFFFF;
    border-radius: 35px;
    overflow: hidden;
    display: grid;
    grid-template-columns: 34% 66%;
    box-shadow: 0 18px 50px rgba(58, 30, 19, 0.15);
}

.lateral {
    background: #FCD09F;
    min-height: 650px;
    padding: 45px 35px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    position: relative;
    overflow: hidden;
}

.lateral::before {
    content: "";
    width: 230px;
    height: 230px;
    background: #0BA84A;
    border-radius: 50%;
    position: absolute;
    top: -125px;
    left: -105px;
}

.lateral::after {
    content: "";
    width: 190px;
    height: 190px;
    background: #3A1E13;
    border-radius: 50%;
    position: absolute;
    bottom: -100px;
    right: -90px;
}

.logo {
    font-family: 'Fredoka', sans-serif;
    font-size: 74px;
    font-weight: 700;
    line-height: 50px;
    color: #3A1E13;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    position: relative;
    z-index: 2;
}

.logo .my {
    font-size: 42px;
    line-height: 35px;
}

.logo .oz {
    font-size: 74px;
    line-height: 55px;
}

.lateral-contenido {
    position: relative;
    z-index: 2;
}

.lateral-contenido h2 {
    font-family: 'Fredoka', sans-serif;
    font-size: 38px;
    line-height: 1.05;
    font-weight: 700;
    color: #3A1E13;
    margin-bottom: 18px;
}

.lateral-contenido h2 span {
    color: #0BA84A;
}

.lateral-contenido p {
    font-size: 15px;
    line-height: 1.6;
    color: #3A1E13;
    max-width: 220px;
}

.decoracion {
    position: relative;
    z-index: 2;
    font-size: 12px;
    font-weight: 800;
    letter-spacing: 1.5px;
    color: #3A1E13;
}

.formulario {
    padding: 48px 55px;
    background: #FFFFFF;
}

.encabezado {
    margin-bottom: 30px;
}

.etiqueta {
    color: #0BA84A;
    font-size: 12px;
    font-weight: 800;
    letter-spacing: 2px;
    text-transform: uppercase;
    margin-bottom: 8px;
}

.titulo {
    font-family: 'Fredoka', sans-serif;
    font-size: 42px;
    line-height: 1;
    font-weight: 700;
    color: #3A1E13;
    text-align: left;
}

.subtitulo {
    margin-top: 10px;
    color: #8B817B;
    font-size: 14px;
}

.forma {
    width: 100%;
}

.campo {
    margin-bottom: 20px;
}

.campo label {
    display: block;
    font-size: 13px;
    font-weight: 800;
    color: #3A1E13;
    margin-bottom: 7px;
}

.campo input {
    width: 100%;
    height: 48px;
    border: 1.5px solid #DED8D3;
    border-radius: 12px;
    padding: 0 15px;
    outline: none;
    background: #FAF8F6;
    color: #3A1E13;
    font-family: 'Nunito', sans-serif;
    font-size: 14px;
    transition: all 0.25s ease;
}

.campo input::placeholder {
    color: #A8A09A;
}

.campo input:focus {
    background: #FFFFFF;
    border-color: #0BA84A;
    box-shadow: 0 0 0 3px rgba(11, 168, 74, 0.10);
}

.fila {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 18px;
}

.vendedor input {
    background: #F1ECE7;
    color: #746A64;
    cursor: not-allowed;
}

.boton-volver-form {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 12px;
    padding: 10px 18px;
    border-radius: 20px;
    background: #2B140D;
    color: #FCD09F;
    text-decoration: none;
    font-weight: 700;
}

.boton-volver-form:hover { opacity: .9; }

.boton {
    width: 100%;
    height: 52px;
    margin-top: 5px;
    border: none;
    border-radius: 13px;
    background: #3A1E13;
    color: #FFFFFF;
    font-family: 'Nunito', sans-serif;
    font-size: 15px;
    font-weight: 800;
    cursor: pointer;
    transition: all 0.25s ease;
}

.boton:hover {
    background: #0BA84A;
    transform: translateY(-2px);
    box-shadow: 0 10px 22px rgba(11, 168, 74, 0.20);
}

.error {
    display: block;
    color: #D62828;
    font-size: 11px;
    font-weight: 700;
    margin-top: 5px;
}

input.error {
    border-color: #D62828;
}

input.error:focus {
    border-color: #D62828;
    box-shadow: 0 0 0 3px rgba(214, 40, 40, 0.08);
}

.pie {
    text-align: center;
    margin-top: 22px;
    color: #918983;
    font-size: 11px;
}

@media (max-width: 800px) {

    body {
        padding: 20px;
    }

    .contenedor {
        grid-template-columns: 1fr;
    }

    .lateral {
        min-height: 280px;
        padding: 30px;
    }

    .lateral-contenido {
        margin-top: 35px;
    }

    .lateral-contenido h2 {
        font-size: 32px;
    }

    .formulario {
        padding: 35px 30px;
    }

}

@media (max-width: 520px) {

    body {
        padding: 10px;
    }

    .contenedor {
        border-radius: 25px;
    }

    .lateral {
        min-height: 250px;
    }

    .logo {
        font-size: 60px;
    }

    .logo .my {
        font-size: 35px;
        line-height: 30px;
    }

    .logo .oz {
        font-size: 60px;
        line-height: 45px;
    }

    .formulario {
        padding: 30px 22px;
    }

    .titulo {
        font-size: 34px;
    }

    .fila {
        grid-template-columns: 1fr;
        gap: 0;
    }

}

</style>

</head>

<body>

<main class="contenedor">

    <section class="lateral">

        <div class="logo">

            <span class="my">
                My
            </span>

            <span class="oz">
                OZ
            </span>

        </div>

        <div class="lateral-contenido">

            <h2>
                Un pedido
                <br>
                <span>natural.</span>
            </h2>

            <p>
                Registra los datos del cliente
                para comenzar a preparar su pedido
                de Organic Zone.
            </p>

        </div>

        <div class="decoracion">
            FRESCO · NATURAL · DELICIOSO
        </div>

    </section>

    <section class="formulario">

        <header class="encabezado">

            <div class="etiqueta">
                Organic Zone
            </div>

            <h1 class="titulo">
                Registro de Pedido
            </h1>

            <p class="subtitulo">
                Completa los datos para registrar un nuevo pedido.
            </p>

        </header>

        <form
            class="forma"
            id="pedidosForm"
            action="pedidos.php"
            method="POST"
        >

            <div class="campo">

                <label for="nombre">
                    Nombre del cliente
                </label>

                <input
                    type="text"
                    id="nombre"
                    name="nombre"
                    placeholder="Escribe el nombre del cliente"
                >

            </div>

            <div class="fila">

                <div class="campo">

                    <label for="fecha">
                        Fecha
                    </label>

                    <input
                        type="date"
                        id="fecha"
                        name="fecha"
                        value="<?php echo date('Y-m-d'); ?>"
                    >

                </div>

                <div class="campo">

                    <label for="telefono">
                        Teléfono
                    </label>

                    <input
                        type="tel"
                        id="telefono"
                        name="telefono"
                        placeholder="Ej. 76543210"
                    >

                </div>

            </div>

            <div class="campo">

                <label for="direccion">
                    Dirección
                </label>

                <input
                    type="text"
                    id="direccion"
                    name="direccion"
                    placeholder="Ingresa la dirección del cliente"
                >

            </div>

            <div class="campo vendedor">

                <label for="nombrevendedor">
                    Nombre del vendedor
                </label>

                <input
                    type="text"
                    id="nombrevendedor"
                    name="nombrevendedor"
                    value="<?php echo htmlspecialchars($nombrevendedor); ?>"
                    readonly
                >

            </div>

            <a href="leerpedidos.php" class="boton-volver-form">
                ← Volver a pedidos
            </a>

            <button
                type="submit"
                class="boton"
            >
                Enviar Pedido
            </button>

        </form>

        <div class="pie">
            Organic Zone · Cochabamba, Bolivia · 2026
        </div>

    </section>

</main>

<script>

$(document).ready(function() {

    $("#pedidosForm").validate({

        rules: {

            nombre: {
                required: true,
                minlength: 2
            },

            fecha: {
                required: true
            },

            direccion: {
                required: true,
                minlength: 5
            },

            telefono: {
                required: true,
                digits: true,
                minlength: 7,
                maxlength: 15
            },

            nombrevendedor: {
                required: true
            }

        },

        messages: {

            nombre: {
                required: "Este campo no puede estar vacío",
                minlength: "Ingresa un nombre válido"
            },

            fecha: {
                required: "Selecciona una fecha"
            },

            direccion: {
                required: "Este campo no puede estar vacío",
                minlength: "Ingresa una dirección válida"
            },

            telefono: {
                required: "Este campo no puede estar vacío",
                digits: "Solo se permiten números",
                minlength: "Ingresa un teléfono válido",
                maxlength: "El teléfono es demasiado largo"
            },

            nombrevendedor: {
                required: "No se encontró el vendedor"
            }

        },

        errorElement: "span",

        errorClass: "error",

        errorPlacement: function(error, element) {
            error.insertAfter(element);
        }

    });

});

</script>

</body>

</html>
```
