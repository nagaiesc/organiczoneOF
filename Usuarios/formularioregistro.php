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

        /* Contenedor de titulos */
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

        /* Contenedor  */
        .main-wrapper {
            display: flex;
            justify-content: center;
            align-items: flex-end;
            flex-grow: 1;
            width: 100%;
            margin-top: 20px;
        }

        /* Caja Principal*/
        main {
            background-color: var(--canva-green);
            width: 85%;
            max-width: 950px;
            border-radius: 80px 80px 0 0;
            padding: 60px 80px 40px 80px; /* Padding */
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

        /* Grupos de opciones */
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
        }

        .opt-admin { background-color: var(--dark-green-btn); }
        .opt-vendedor { background-color: var(--accent-orange); color: var(--text-brown); }
        .opt-activo { background-color: var(--dark-green-btn); }
        .opt-inactivo { background-color: var(--bg-page); color: var(--canva-green); }

        .option-box.active {
            box-shadow: 0 0 0 4px white;
        }

        /* Botón Registrarse */
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

        /* Errores */
        label.error {
            color: var(--accent-orange);
            font-size: 14px;
            margin-top: 5px;
            font-weight: 400;
        }

        @media (max-width: 900px) {
            header { padding-left: 30px; }
            .titu-usuarios { font-size: 80px; }
            main { width: 95%; padding: 40px 30px; border-radius: 40px 40px 0 0; }
            form { grid-template-columns: 1fr; gap: 20px; }
            .footer-form { grid-column: 1; }
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
                        <input type="hidden" name="rol"  value="admin">
                        <button type="button" class="option-box opt-admin active" >Admin</button>
                        <button type="button" class="option-box opt-vendedor" >Vendedor</button>
                    </section>
                </article>

                <article>
                    <label for="direccion">Dirección</label>
                    <input type="text" name="direccion" >
                </article>

                <article>
                    <label>Estado</label>
                    <section class="options-container">
                        <input type="hidden" name="estado" value="activo">
                        <button type="button" class="option-box opt-activo active">Activo</button>
                        <button type="button" class="option-box opt-inactivo" >Inactivo</button>
                    </section>
                </article>

                <section class="footer-form">
                    <button type="submit" class="btn-submit">Registrarse</button>
                </section>

            </form>
        </main>
    </div>

    <script>
    $("form").validate({
        rules:{
            CI:{
                required:true
            },
            nombre:{
                required:true
            },
            direccion:{
                required:true
            },
            celular:{
                required:true
            },
            rol:{
                required:true
            },
            estado:{
                required:true
            }

        },
        messages:{
            CI:{
                required:"este campo no puede estar vacio"
            },
            nombre:{
                required:"este campo no puede estar vacio"
            },
            direccion:{
                required:"este campo no puede estar vacio"
            },
            celular:{
                required:"este campo no puede estar vacio"
            },
            rol:{
                required:"este campo no puede estar vacio"
            },
            estado:{
                required:"este campo no puede estar vacio"
            }
        }
    })
</script>


</body>
</html>