<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuarios | Organic Zone</title>

    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>

        :root {
            --bg: #F4F1EE;
            --green: #0BA84A;
            --green-dark: #064D22;
            --brown: #2B140D;
            --cream: #FCD09F;
            --input: #F4FFEF;
            --error: #D62828;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            min-height: 100%;
            font-family: 'Fredoka', sans-serif;
            background: var(--bg);
            color: var(--brown);
        }

        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        /* =========================================
           HEADER
           ========================================= */

        header {
            width: min(1040px, 92%);
            margin: 0 auto;
            padding: 34px 28px 20px;
            position: relative;
        }

        .title-area {
            position: relative;
            display: inline-block;
        }

        .titu-registro {
            margin: 0;
            color: var(--brown);
            font-size: 43px;
            font-weight: 700;
            line-height: .95;
            letter-spacing: -1px;
        }

        .titu-usuarios {
            margin: 3px 0 0;
            color: var(--green);
            font-size: 105px;
            font-weight: 700;
            line-height: .78;
            letter-spacing: -4px;
        }

        .title-accent {
            width: 67px;
            height: 7px;
            margin: 17px 0 0 7px;
            background: var(--cream);
            border-radius: 20px;
        }

        /* =========================================
           MY OZ
           ========================================= */

        .my-oz {
            position: absolute;
            top: 31px;
            right: 35px;
            width: 76px;
            text-align: left;
            line-height: .75;
            z-index: 5;
        }

        .my-oz .my {
            display: block;
            color: var(--cream);
            font-size: 20px;
            font-weight: 600;
            letter-spacing: -.5px;
            margin: 0;
        }

        .my-oz .oz {
            display: block;
            color: var(--brown);
            font-size: 52px;
            font-weight: 700;
            letter-spacing: -3px;
            margin: 0;
        }

        .my-oz::after {
            content: "";
            display: block;
            width: 27px;
            height: 4px;
            margin: 8px 0 0;
            border-radius: 10px;
            background: var(--green);
        }

        /* =========================================
           FORMULARIO
           ========================================= */

        .main-wrapper {
            width: 100%;
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: flex-end;
            margin-top: 12px;
        }

        main {
            position: relative;
            width: min(920px, 90%);
            min-height: 515px;
            background: var(--green);
            border-radius: 70px 70px 0 0;
            padding: 48px 76px 43px;
            overflow: hidden;
        }

        /* Forma orgánica integrada */

        .organic-shape {
            position: absolute;
            right: -35px;
            top: -75px;
            width: 205px;
            height: 205px;
            border-radius: 50%;
            background: rgba(252,208,159,.13);
        }

        .organic-line {
            position: absolute;
            left: 32px;
            bottom: 65px;
            width: 48px;
            height: 7px;
            border-radius: 20px;
            background: var(--cream);
            opacity: .65;
            transform: rotate(-25deg);
        }

        .form-top {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-bottom: 31px;
        }

        .form-title h2 {
            margin: 0;
            color: white;
            font-size: 31px;
            font-weight: 700;
            line-height: 1;
        }

        .form-title p {
            margin: 8px 0 0;
            color: rgba(255,255,255,.82);
            font-size: 15px;
            font-weight: 400;
        }

        .form-mark {
            width: 43px;
            height: 43px;
            border: 3px solid var(--cream);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-right: 3px;
            margin-bottom: 2px;
        }

        .form-mark::before {
            content: "";
            width: 15px;
            height: 15px;
            border-radius: 50%;
            background: var(--cream);
        }

        form {
            position: relative;
            z-index: 3;
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 1fr;
            column-gap: 38px;
            row-gap: 25px;
        }

        article {
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        label {
            color: white;
            font-size: 18px;
            font-weight: 600;
            line-height: 1.1;
            margin: 0 0 8px 8px;
        }

        input {
            width: 100%;
            height: 57px;
            border: 3px solid transparent;
            border-radius: 30px;
            outline: none;
            padding: 0 22px;
            background: var(--input);
            color: var(--brown);
            font-family: 'Fredoka', sans-serif;
            font-size: 17px;
            font-weight: 500;
            transition: .22s ease;
        }

        input:hover {
            background: #FFFFFF;
        }

        input:focus {
            background: #FFFFFF;
            border-color: var(--cream);
            box-shadow: 0 0 0 4px rgba(252,208,159,.20);
        }

        .input-orange {
            background: var(--cream);
        }

        .input-orange:hover,
        .input-orange:focus {
            background: #FFDAA9;
        }

        /* =========================================
           BOTÓN
           ========================================= */

        .footer-form {
            grid-column: 1 / -1;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            padding-top: 10px;
        }

        .btn-submit {
            height: 61px;
            min-width: 215px;
            padding: 0 42px;
            border: none;
            border-radius: 34px;
            background: var(--brown);
            color: white;
            font-family: 'Fredoka', sans-serif;
            font-size: 24px;
            font-weight: 700;
            cursor: pointer;
            transition: .25s ease;
        }

        .btn-submit:hover {
            background: var(--green-dark);
            transform: translateY(-2px);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .btn-submit:disabled {
            opacity: .65;
            cursor: wait;
            transform: none;
        }

        /* =========================================
           VALIDACIÓN
           ========================================= */

        label.error {
            color: var(--cream);
            font-size: 13px;
            font-weight: 500;
            line-height: 1.2;
            margin: 6px 0 0 8px;
        }

        input.input-error {
            border-color: var(--error);
            box-shadow: 0 0 0 4px rgba(214,40,40,.14);
        }

        /* =========================================
           MODAL
           ========================================= */

        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(43,20,13,.55);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            padding: 20px;
            backdrop-filter: blur(5px);
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal-organic {
            width: 100%;
            max-width: 430px;
            background: var(--bg);
            border-radius: 42px;
            padding: 38px;
            text-align: center;
            box-shadow: 0 20px 60px rgba(43,20,13,.30);
            transform: scale(.75);
            opacity: 0;
        }

        .modal-overlay.active .modal-organic {
            animation: modalEntrada .4s ease forwards;
        }

        @keyframes modalEntrada {

            0% {
                transform: scale(.75);
                opacity: 0;
            }

            70% {
                transform: scale(1.04);
                opacity: 1;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .modal-check {
            width: 70px;
            height: 70px;
            margin: 0 auto 18px;
            border-radius: 50%;
            background: var(--green);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 38px;
            font-weight: 700;
        }

        .modal-organic h2 {
            margin: 0 0 10px;
            color: var(--brown);
            font-size: 30px;
            font-weight: 700;
        }

        .modal-organic p {
            margin: 0 0 25px;
            color: #5E4B44;
            font-size: 18px;
            line-height: 1.4;
        }

        .modal-organic strong {
            color: var(--green);
        }

        .modal-button {
            background: var(--brown);
            color: white;
            border: none;
            border-radius: 35px;
            padding: 13px 40px;
            font-family: 'Fredoka', sans-serif;
            font-size: 18px;
            font-weight: 700;
            cursor: pointer;
            transition: .25s;
        }

        .modal-button:hover {
            background: var(--green);
            transform: scale(1.05);
        }

        /* =========================================
           SWEET ALERT
           ========================================= */

        .popup-organic,
        .popup-error {
            border-radius: 38px !important;
            font-family: 'Fredoka', sans-serif !important;
            padding: 30px !important;
            box-shadow: 0 20px 60px rgba(43,20,13,.30) !important;
        }

        .popup-organic .swal2-title,
        .popup-error .swal2-title {
            color: var(--brown) !important;
            font-family: 'Fredoka', sans-serif !important;
            font-size: 29px !important;
            font-weight: 700 !important;
        }

        .popup-organic .swal2-html-container,
        .popup-error .swal2-html-container {
            color: #66544D !important;
            font-family: 'Fredoka', sans-serif !important;
            font-size: 17px !important;
            line-height: 1.4 !important;
        }

        .popup-organic .swal2-confirm {
            background: var(--green) !important;
            border-radius: 30px !important;
            font-family: 'Fredoka', sans-serif !important;
            font-weight: 700 !important;
            padding: 12px 30px !important;
        }

        .popup-organic .swal2-confirm:hover {
            background: var(--green-dark) !important;
        }

        .popup-error .swal2-confirm {
            background: var(--error) !important;
            border-radius: 30px !important;
            font-family: 'Fredoka', sans-serif !important;
            font-weight: 700 !important;
            padding: 12px 30px !important;
        }

        .popup-error .swal2-confirm:hover {
            background: #A91F1F !important;
        }

        /* =========================================
           RESPONSIVE
           ========================================= */

        @media (max-width: 900px) {

            header {
                width: 94%;
                padding: 30px 10px 17px;
            }

            .titu-registro {
                font-size: 36px;
            }

            .titu-usuarios {
                font-size: 80px;
            }

            .my-oz {
                right: 12px;
                top: 27px;
            }

            .my-oz .my {
                font-size: 18px;
            }

            .my-oz .oz {
                font-size: 45px;
            }

            main {
                width: 94%;
                padding: 44px 42px 39px;
                border-radius: 54px 54px 0 0;
            }

            form {
                grid-template-columns: 1fr;
                row-gap: 23px;
            }

            .footer-form {
                grid-column: 1;
                justify-content: center;
            }

            .btn-submit {
                width: 100%;
            }

        }

        @media (max-width: 520px) {

            header {
                padding: 25px 8px 12px;
            }

            .titu-registro {
                font-size: 28px;
            }

            .titu-usuarios {
                font-size: 60px;
                letter-spacing: -2px;
            }

            .title-accent {
                width: 48px;
                height: 5px;
                margin-top: 13px;
            }

            .my-oz {
                right: 7px;
                top: 22px;
                width: 60px;
            }

            .my-oz .my {
                font-size: 16px;
            }

            .my-oz .oz {
                font-size: 35px;
            }

            .my-oz::after {
                width: 21px;
                height: 3px;
                margin-top: 6px;
            }

            main {
                width: 96%;
                padding: 35px 23px 30px;
                border-radius: 38px 38px 0 0;
            }

            .form-top {
                margin-bottom: 27px;
            }

            .form-title h2 {
                font-size: 27px;
            }

            .form-title p {
                font-size: 14px;
            }

            .form-mark {
                width: 36px;
                height: 36px;
            }

            .form-mark::before {
                width: 11px;
                height: 11px;
            }

            label {
                font-size: 17px;
            }

            input {
                height: 54px;
            }

            .btn-submit {
                height: 58px;
                font-size: 21px;
            }

        }

    </style>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/organiczoneOF/includes/oz-navegacion.php'; ?>

</head>

<body>

<header>

    <div class="title-area">

        <p class="titu-registro">
            Registro de
        </p>

        <h1 class="titu-usuarios">
            Usuarios
        </h1>

        <div class="title-accent"></div>

    </div>

    <div class="my-oz">
        <span class="my">My</span>
        <span class="oz">Oz</span>
    </div>

</header>

<div class="main-wrapper">

    <main>

        <div class="organic-shape"></div>
        <div class="organic-line"></div>

        <div class="form-top">

            <div class="form-title">

                <h2>Crear usuario</h2>

                <p>
                    Completa tus datos para formar parte de Organic Zone.
                </p>

            </div>

            <div class="form-mark"></div>

        </div>

        <form id="usuariosForm" action="usuarios.php" method="POST">

            <article>

                <label for="nombre">
                    Nombre
                </label>

                <input
                    type="text"
                    name="nombre"
                    id="nombre"
                >

            </article>

            <article>

                <label for="CI">
                    Carnet de Identidad
                </label>

                <input
                    type="number"
                    name="CI"
                    id="CI"
                >

            </article>

            <article>

                <label for="direccion">
                    Dirección
                </label>

                <input
                    type="text"
                    name="direccion"
                    id="direccion"
                >

            </article>

            <article>

                <label for="celular">
                    Celular
                </label>

                <input
                    type="number"
                    name="celular"
                    id="celular"
                    class="input-orange"
                >

            </article>

            <section class="footer-form">

                <button
                    type="submit"
                    class="btn-submit"
                >
                    Registrarse
                </button>

            </section>

        </form>

    </main>

</div>

<section class="modal-overlay" id="modalRegistro">

    <section class="modal-organic">

        <div class="modal-check">
            ✓
        </div>

        <h2>
            ¡Registro exitoso!
        </h2>

        <p>
            El usuario ha sido registrado correctamente en
            <strong>Organic Zone</strong>.
        </p>

        <button
            type="button"
            class="modal-button"
            id="cerrarModal"
        >
            Aceptar
        </button>

    </section>

</section>

<script>

$("#usuariosForm").validate({

    rules: {

        CI: {
            required: true
        },

        nombre: {
            required: true
        },

        direccion: {
            required: true
        },

        celular: {
            required: true
        }

    },

    messages: {

        CI: {
            required: "Este campo no puede estar vacío"
        },

        nombre: {
            required: "Este campo no puede estar vacío"
        },

        direccion: {
            required: "Este campo no puede estar vacío"
        },

        celular: {
            required: "Este campo no puede estar vacío"
        }

    },

    errorElement: "label",

    errorClass: "error",

    highlight: function(element) {

        $(element).addClass("input-error");

    },

    unhighlight: function(element) {

        $(element).removeClass("input-error");

    },

    submitHandler: function(form) {

        $(".btn-submit").prop("disabled", true);

        $.ajax({

            url: "usuarios.php",

            type: "POST",

            data: $(form).serialize(),

            dataType: "json",

            success: function(respuesta) {

                $(".btn-submit").prop("disabled", false);

                if (respuesta.estado === "exito") {

                    $("#modalRegistro").addClass("active");

                }

                else if (respuesta.estado === "duplicado") {

                    Swal.fire({

                        icon: "warning",

                        title: "CI ya registrado",

                        html: "El Carnet de Identidad <strong>ya está registrado</strong> en Organic Zone.",

                        confirmButtonText: "Entendido",

                        confirmButtonColor: "#0BA84A",

                        customClass: {
                            popup: "popup-error"
                        }

                    }).then(function() {

                        $("#CI").val("").focus();

                    });

                }

                else {

                    Swal.fire({

                        icon: "error",

                        title: "No se pudo registrar",

                        html: respuesta.mensaje || "Ocurrió un error al intentar registrar el usuario.",

                        confirmButtonText: "Entendido",

                        confirmButtonColor: "#D62828",

                        customClass: {
                            popup: "popup-error"
                        }

                    });

                }

            },

            error: function(xhr) {

                $(".btn-submit").prop("disabled", false);

                Swal.fire({

                    icon: "error",

                    title: "Ocurrió un error",

                    html: "Ocurrió un error al intentar registrar el usuario.",

                    confirmButtonText: "Entendido",

                    confirmButtonColor: "#D62828",

                    customClass: {
                        popup: "popup-error"
                    }

                });

                console.log(xhr.responseText);

            }

        });

        return false;

    }

});

$("#cerrarModal").on("click", function() {

    $("#modalRegistro").removeClass("active");

    setTimeout(function() {

        window.location.href = "formulariosesion.php";

    }, 250);

});

$("#modalRegistro").on("click", function(e) {

    if (e.target === this) {

        $("#modalRegistro").removeClass("active");

    }

});

</script>

</body>
</html>
