<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuarios</title>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-page: #f4ffef;
            --canva-green: #0ba84a;
            --text-brown: #2e140d;
            --input-bg: #f4ffef;
            --accent-orange: #ffc982;
            --dark-green-btn: #064d22;
        }

        body, html {
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
            padding: 50px 20px 20px 80px;
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
            margin: -10px 0 0 0;
            line-height: 0.85;
        }

        .main-wrapper {
            display: flex;
            justify-content: center;
            align-items: flex-end;
            flex-grow: 1;
            width: 100%;
            margin-top: 20px;
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
            box-shadow: 0 -5px 25px rgba(0,0,0,0.05);
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
            border: none;
            border-radius: 35px;
            padding: 16px 25px;
            font-family: 'Fredoka', sans-serif;
            font-size: 18px;
            font-weight: 500;
            outline: none;
            width: 100%;
            box-sizing: border-box;
            color: var(--text-brown);
        }

        .input-orange {
            background-color: var(--accent-orange);
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
            transition: 0.2s;
            position: relative;
        }

        .option-box input[type="radio"] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        .opt-admin {
            background-color: var(--dark-green-btn);
        }

        .opt-vendedor {
            background-color: var(--accent-orange);
            color: var(--text-brown);
        }

        .opt-activo {
            background-color: var(--dark-green-btn);
        }

        .opt-inactivo {
            background-color: var(--bg-page);
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
            transition: 0.3s;
        }

        .btn-submit:hover {
            transform: scale(1.05);
            background-color: #1a0b07;
        }

        label.error {
            color: var(--accent-orange);
            font-size: 14px;
            margin-top: 5px;
            font-weight: 400;
        }

        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(46, 20, 13, 0.45);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            padding: 20px;
            box-sizing: border-box;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal-organic {
            width: 100%;
            max-width: 420px;
            background-color: var(--bg-page);
            border-radius: 40px;
            padding: 35px;
            box-sizing: border-box;
            text-align: center;
            box-shadow: 0 15px 45px rgba(46, 20, 13, 0.25);
            transform: scale(0.9);
            opacity: 0;
            transition: 0.25s ease;
        }

        .modal-overlay.active .modal-organic {
            transform: scale(1);
            opacity: 1;
        }

        .modal-check {
            width: 68px;
            height: 68px;
            margin: 0 auto 18px;
            border-radius: 50%;
            background-color: var(--canva-green);
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 38px;
            font-weight: 700;
        }

        .modal-organic h2 {
            color: var(--text-brown);
            font-size: 30px;
            font-weight: 700;
            margin: 0 0 10px;
        }

        .modal-organic p {
            color: var(--text-brown);
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
            transition: 0.25s;
        }

        .modal-button:hover {
            background-color: var(--dark-green-btn);
            transform: scale(1.04);
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

                    <button type="button" class="option-box opt-vendedor"
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

        submitHandler: function(form) {

            $("#modalRegistro").addClass("active");

            $("#cerrarModal").off("click").on("click", function() {

                $("#modalRegistro").removeClass("active");

                setTimeout(function() {

                    window.location.href = "formulariosesion.php";

                }, 200);

            });

        }

    });

    $(".options-container input[type='radio']").on("change", function() {

        $(this)
            .closest(".options-container")
            .find(".option-box")
            .blur();

    });

    $("#modalRegistro").on("click", function(e) {

        if (e.target === this) {

            $("#modalRegistro").removeClass("active");

        }

    });

</script>

</body>
</html>