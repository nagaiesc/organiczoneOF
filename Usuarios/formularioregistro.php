<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuarios</title>

    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-page: #F4F1EE;
            --canva-green: #0BA84A;
            --text-brown: #2B140D;
            --input-bg: #F4FFEF;
            --accent-cream: #FCD09F;
            --dark-green: #064D22;
            --soft-green: #EAF7EC;
            --error-red: #D62828;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            font-family: 'Fredoka', sans-serif;
            background-color: var(--bg-page);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        header {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 32px 20px 5px 80px;
            box-sizing: border-box;
        }

        .titu-registro {
            color: var(--text-brown);
            font-size: 48px;
            font-weight: 700;
            margin: 0;
            line-height: 1;
        }

        .titu-usuarios {
            color: var(--canva-green);
            font-size: 120px;
            font-weight: 700;
            margin: -7px 0 0 0;
            line-height: 0.85;
        }

        .main-wrapper {
            display: flex;
            justify-content: center;
            align-items: flex-end;
            flex-grow: 1;
            width: 100%;
            margin-top: 8px;
        }

        main {
            background-color: var(--canva-green);
            width: 85%;
            max-width: 950px;
            border-radius: 80px 80px 0 0;
            padding: 60px 80px 40px 80px;
            box-sizing: border-box;
            min-height: 500px;
            display: flex;
            flex-direction: column;
            box-shadow: 0 -5px 25px rgba(43,20,13,0.08);
        }

        form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px 60px;
            width: 100%;
        }

        article {
            display: flex;
            flex-direction: column;
        }

        label {
            color: white;
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        input {
            background-color: var(--input-bg);
            border: 3px solid transparent;
            border-radius: 35px;
            padding: 16px 25px;
            font-family: 'Fredoka', sans-serif;
            font-size: 18px;
            font-weight: 500;
            outline: none;
            width: 100%;
            box-sizing: border-box;
            color: var(--text-brown);
            transition: .25s ease;
        }

        input:focus {
            border-color: var(--accent-cream);
            box-shadow: 0 0 0 4px rgba(252,208,159,.20);
        }

        .input-orange {
            background-color: var(--accent-cream);
        }

        .options-container {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .option-box {
            border: none;
            border-radius: 25px;
            padding: 10px 25px;
            font-family: 'Fredoka', sans-serif;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            color: white;
            transition: .2s;
            position: relative;
        }

        .option-box input[type="radio"] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        .opt-admin {
            background-color: var(--dark-green);
        }

        .opt-vendedor {
            background-color: var(--accent-cream);
            color: var(--text-brown);
        }

        .opt-cliente {
            background-color: var(--input-bg);
            color: var(--canva-green);
        }

        .option-box:has(input[type="radio"]:checked) {
            box-shadow: 0 0 0 4px white;
        }

        .footer-form {
            grid-column: 2;
            display: flex;
            justify-content: center;
            align-items: center;
            padding-top: 20px;
        }

        .btn-submit {
            background-color: var(--text-brown);
            color: white;
            border: none;
            border-radius: 45px;
            padding: 18px 60px;
            font-family: 'Fredoka', sans-serif;
            font-size: 30px;
            font-weight: 700;
            cursor: pointer;
            transition: .3s;
        }

        .btn-submit:hover {
            transform: scale(1.05);
            background-color: var(--dark-green);
        }

        .btn-submit:disabled {
            opacity: .7;
            cursor: wait;
            transform: none;
        }

        label.error {
            color: var(--accent-cream);
            font-size: 14px;
            margin-top: 5px;
            font-weight: 400;
        }

        input.input-error {
            border-color: var(--error-red);
            box-shadow: 0 0 0 4px rgba(214,40,40,.15);
        }

        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(43,20,13,.55);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            padding: 20px;
            box-sizing: border-box;
            backdrop-filter: blur(5px);
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal-organic {
            width: 100%;
            max-width: 430px;
            background-color: var(--bg-page);
            border-radius: 42px;
            padding: 38px;
            box-sizing: border-box;
            text-align: center;
            box-shadow: 0 20px 60px rgba(43,20,13,.30);
            transform: scale(.75);
            opacity: 0;
            transition: .3s ease;
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
            background-color: var(--canva-green);
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 38px;
            font-weight: 700;
            box-shadow: 0 8px 20px rgba(11,168,74,.25);
            animation: checkEntrada .5s ease .15s both;
        }

        @keyframes checkEntrada {
            0% {
                transform: scale(0) rotate(-30deg);
            }

            70% {
                transform: scale(1.15) rotate(5deg);
            }

            100% {
                transform: scale(1) rotate(0);
            }
        }

        .modal-organic h2 {
            color: var(--text-brown);
            font-size: 30px;
            font-weight: 700;
            margin: 0 0 10px;
        }

        .modal-organic p {
            color: #5E4B44;
            font-size: 18px;
            font-weight: 400;
            line-height: 1.4;
            margin: 0 0 25px;
        }

        .modal-organic strong {
            color: var(--canva-green);
            font-weight: 700;
        }

        .modal-button {
            background-color: var(--text-brown);
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
            background-color: var(--canva-green);
            transform: scale(1.05);
        }

        .popup-organic,
        .popup-error {
            border-radius: 38px !important;
            font-family: 'Fredoka', sans-serif !important;
            padding: 30px !important;
            box-shadow: 0 20px 60px rgba(43,20,13,.30) !important;
        }

        .popup-organic .swal2-title,
        .popup-error .swal2-title {
            color: var(--text-brown) !important;
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
            background: var(--canva-green) !important;
            border-radius: 30px !important;
            font-family: 'Fredoka', sans-serif !important;
            font-weight: 700 !important;
            padding: 12px 30px !important;
            box-shadow: 0 7px 18px rgba(11,168,74,.22) !important;
            transition: .2s !important;
        }

        .popup-organic .swal2-confirm:hover {
            background: var(--dark-green) !important;
            transform: scale(1.04);
        }

        .popup-error .swal2-confirm {
            background: var(--error-red) !important;
            border-radius: 30px !important;
            font-family: 'Fredoka', sans-serif !important;
            font-weight: 700 !important;
            padding: 12px 30px !important;
            transition: .2s !important;
        }

        .popup-error .swal2-confirm:hover {
            background: #A91F1F !important;
            transform: scale(1.04);
        }

        .swal2-icon {
            font-family: 'Fredoka', sans-serif !important;
        }

        @media (max-width: 900px) {
            header {
                padding-left: 30px;
            }

            .titu-usuarios {
                font-size: 80px;
            }

            main {
                width: 95%;
                padding: 40px 30px;
                border-radius: 40px 40px 0 0;
            }

            form {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .footer-form {
                grid-column: 1;
            }
        }
    </style>
</head>

<body>

<header>
    <p class="titu-registro">Registro de</p>
    <h1 class="titu-usuarios">Usuarios</h1>
</header>

<div class="main-wrapper">
    <main>

        <form id="usuariosForm" action="usuarios.php" method="POST">

            <article>
                <label for="CI">Carnet de Identidad:</label>
                <input type="number" name="CI" id="CI">
            </article>

            <article>
                <label for="celular">Celular</label>
                <input type="number" name="celular" id="celular" class="input-orange">
            </article>

            <article>
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre">
            </article>

            <article>
                <label>Rol</label>

                <section class="options-container">

                    <button type="button" class="option-box opt-admin"
                        onclick="$(this).find('input').prop('checked', true).trigger('change')">
                        <input type="radio" name="rol" value="admin" checked>
                        Admin
                    </button>

                    <button type="button" class="option-box opt-vendedor"
                        onclick="$(this).find('input').prop('checked', true).trigger('change')">
                        <input type="radio" name="rol" value="vendedor">
                        Vendedor
                    </button>

                    <button type="button" class="option-box opt-cliente"
                        onclick="$(this).find('input').prop('checked', true).trigger('change')">
                        <input type="radio" name="rol" value="cliente">
                        Cliente
                    </button>

                </section>
            </article>

            <article>
                <label for="direccion">Dirección</label>
                <input type="text" name="direccion" id="direccion">
            </article>

            <section class="footer-form">
                <button type="submit" class="btn-submit">
                    Registrarse
                </button>
            </section>

        </form>

    </main>
</div>

<section class="modal-overlay" id="modalRegistro">

    <section class="modal-organic">

        <div class="modal-check">✓</div>

        <h2>¡Registro exitoso!</h2>

        <p>
            El usuario ha sido registrado correctamente en
            <strong>Organic Zone</strong>.
        </p>

        <button type="button" class="modal-button" id="cerrarModal">
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

                } else if (respuesta.estado === "duplicado") {

                    Swal.fire({
                        icon: "warning",
                        title: "CI ya registrado",
                        html: "El Carnet de Identidad <strong>ya está registrado</strong> en Organic Zone.",
                        confirmButtonText: "Entendido",
                        confirmButtonColor: "#0BA84A",
                        customClass: {
                            popup: "popup-error"
                        },
                        showClass: {
                            popup: "animate__animated animate__zoomIn"
                        },
                        hideClass: {
                            popup: "animate__animated animate__zoomOut"
                        }
                    }).then(function() {
                        $("#CI").val("").focus();
                    });

                } else {

                    Swal.fire({
                        icon: "error",
                        title: "No se pudo registrar",
                        html: respuesta.mensaje || "Ocurrió un error al intentar registrar el usuario.",
                        confirmButtonText: "Entendido",
                        confirmButtonColor: "#D62828",
                        customClass: {
                            popup: "popup-error"
                        },
                        showClass: {
                            popup: "animate__animated animate__zoomIn"
                        },
                        hideClass: {
                            popup: "animate__animated animate__zoomOut"
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
                    },
                    showClass: {
                        popup: "animate__animated animate__zoomIn"
                    },
                    hideClass: {
                        popup: "animate__animated animate__zoomOut"
                    }
                });

                console.log(xhr.responseText);
            }
        });

        return false;
    }
});

$(".options-container input[type='radio']").on("change", function() {

    $(this)
        .closest(".options-container")
        .find(".option-box")
        .blur();

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
