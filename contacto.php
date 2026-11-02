<?php

// Iniciar sesión antes de enviar cualquier contenido al navegador
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Contacto - Organic Zone</title>

    <style>

        @import url('https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&display=swap');


        /* =====================================================
           PALETA DE COLORES
           (cambia aquí y se actualiza toda la página)
        ===================================================== */

        :root {
            --oz-cafe: #2e140d;
            --oz-verde: #12A33C;
            --oz-ambar: #ffc982;
            --oz-crema: #fff4e2;
        }


        /* =====================================================
           CONFIGURACIÓN GENERAL
        ===================================================== */

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--oz-crema);
            font-family: 'Fredoka', Arial, sans-serif;
            color: var(--oz-cafe);
        }


        /* =====================================================
           SECCIÓN PRINCIPAL
        ===================================================== */

        .contacto {
            position: relative;
            min-height: 100vh;
            padding: 140px 5% 110px;
            overflow: hidden;
        }


        /* =====================================================
           DECORACIÓN DE FONDO
        ===================================================== */

        .contacto::before {
            content: "";
            position: absolute;
            width: min(620px, 80vw);
            aspect-ratio: 1;
            border-radius: 50%;
            background: var(--oz-verde);
            right: -260px;
            top: -260px;
        }

        .contacto::after {
            content: "";
            position: absolute;
            width: 340px;
            height: 340px;
            border-radius: 50%;
            background: var(--oz-cafe);
            opacity: .08;
            left: -170px;
            bottom: -190px;
        }

        .contenedor {
            position: relative;
            z-index: 2;
            max-width: 1320px;
            margin: 0 auto;
        }


        /* =====================================================
           ENCABEZADO (alineado a la izquierda)
        ===================================================== */

        .titulo {
            margin: 0 0 70px;
            text-align: left;
        }

        .titulo .etiqueta {
            display: inline-block;
            margin: 0 0 26px;
            padding: 9px 20px;
            background: var(--oz-cafe);
            color: var(--oz-ambar);
            border-radius: 50px;
            font-size: 15px;
            font-weight: 600;
            letter-spacing: .02em;
            
        }

        .titulo h1 {
            margin: 0;
            font-size: clamp(40px, 11vw, 150px);
            line-height: .95;
            font-weight: 700;
            letter-spacing: -.04em;
            color: var(--oz-cafe);
        }

        .titulo .intro {
            max-width: 620px;
            margin: 34px 0 0;
            font-size: clamp(17px, 1.6vw, 21px);
            line-height: 1.65;
            color: rgba(46, 20, 13, .82);
        }


        /* =====================================================
           CAJAS EN LÍNEA RECTA
        ===================================================== */

        .info {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 20px;
            align-items: stretch;
        }

        .carta {
            display: flex;
            flex-direction: column;
            min-height: 440px;
            padding: clamp(26px, 2.6vw, 40px);
            border-radius: 32px;
            transition: transform .3s ease;
        }

        @media (hover: hover) {
            .carta:hover {
                transform: translateY(-8px);
            }
        }


        /* ---------- Ícono ---------- */

        .carta .icono {
            display: grid;
            place-items: center;
            width: 58px;
            height: 58px;
            margin-bottom: 34px;
            border-radius: 50%;
        }

        .carta .icono svg {
            width: 28px;
            height: 28px;
            fill: none;
            stroke: currentColor;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }


        /* ---------- Títulos de las cajas (grandes) ---------- */

        .carta h2 {
            margin: 0 0 22px;
            font-size: clamp(32px, 3.3vw, 46px);
            line-height: 1.02;
            font-weight: 700;
            letter-spacing: -.02em;
            overflow-wrap: anywhere;
        }


        /* ---------- Textos ---------- */

        .carta .dato {
            margin: 0 0 14px;
            font-size: clamp(18px, 1.5vw, 21px);
            line-height: 1.45;
            font-weight: 600;
            overflow-wrap: anywhere;
        }

        .carta .dato-telefono {
            font-size: clamp(26px, 2.6vw, 36px);
            font-weight: 700;
            line-height: 1.1;
            letter-spacing: -.01em;
        }

        .carta .detalle {
            margin: 0 0 32px;
            font-size: 17px;
            line-height: 1.65;
        }


        /* ---------- Botón de cada caja ---------- */

        .carta .boton {
            margin-top: auto;
            align-self: flex-start;
            display: inline-block;
            padding: 14px 26px;
            border-radius: 50px;
            font-family: inherit;
            font-size: 17px;
            font-weight: 600;
            text-decoration: none;
            transition: transform .2s ease;
        }

        .carta .boton:hover {
            transform: translateY(-2px);
        }

        .carta .boton:focus-visible {
            outline: 3px solid var(--oz-cafe);
            outline-offset: 3px;
        }


        /* =====================================================
           VARIANTES DE COLOR
        ===================================================== */

        /* Caja 1: café */
        .carta-cafe {
            background: var(--oz-cafe);
            color: var(--oz-crema);
        }

        .carta-cafe h2 {
            color: var(--oz-crema);
        }

        .carta-cafe .icono {
            background: var(--oz-crema);
            color: var(--oz-cafe);
        }

        .carta-cafe .detalle {
            color: rgba(255, 244, 226, .78);
        }

        .carta-cafe .boton {
            background: var(--oz-crema);
            color: var(--oz-cafe);
        }

        .carta-cafe .boton:focus-visible {
            outline-color: var(--oz-ambar);
        }


        /* Caja 2: verde */
        .carta-verde {
            background: var(--oz-verde);
            color: var(--oz-crema);
        }

        .carta-verde .icono {
            background: var(--oz-crema);
            color: var(--oz-verde);
        }

        .carta-verde .boton {
            background: var(--oz-crema);
            color: var(--oz-verde);
        }


        /* Caja 3: crema */
        .carta-crema {
            background: var(--oz-ambar);
            color: var(--oz-cafe);
        }

        .carta-crema .icono {
            background: var(--oz-cafe);
            color: var(--oz-crema);
        }

        .carta-crema .detalle {
            color: rgba(46, 20, 13, .78);
        }

        .carta-crema .boton {
            background: var(--oz-cafe);
            color: var(--oz-crema);
        }


        /* =====================================================
           RESPONSIVE - TABLET (cajas una debajo de otra)
        ===================================================== */

        @media (max-width: 1040px) {

            .contacto {
                padding: 120px 5% 80px;
            }

            .info {
                grid-template-columns: 1fr;
            }

            .carta {
                min-height: auto;
            }

            .carta .detalle {
                max-width: 560px;
            }

        }


        /* =====================================================
           RESPONSIVE - CELULAR
        ===================================================== */

        @media (max-width: 650px) {

            .contacto {
                padding: 110px 20px 70px;
            }

            .contacto::before {
                width: 240px;
                right: -80px;
                top: -80px;
            }

            .titulo {
                margin-bottom: 48px;
            }

            .carta {
                padding: 28px;
                border-radius: 28px;
            }

            .carta .icono {
                margin-bottom: 26px;
            }

        }


        /* =====================================================
           ACCESIBILIDAD: menos movimiento
        ===================================================== */

        @media (prefers-reduced-motion: reduce) {

            .carta,
            .carta .boton {
                transition: none;
            }

            .carta:hover,
            .carta .boton:hover {
                transform: none;
            }

        }

    </style>


<?php include $_SERVER['DOCUMENT_ROOT'] . '/organiczoneOF/includes/oz-navegacion.php'; ?>
</head>


<body>


    <!-- =====================================================
         BARRA DE NAVEGACIÓN
    ===================================================== -->

    <nav>

        <?php

        include("nav.php");

        ?>

    </nav>


    <!-- =====================================================
         SECCIÓN CONTACTO
    ===================================================== -->

    <section class="contacto">

        <div class="contenedor">


            <!-- ENCABEZADO -->

            <div class="titulo">

                <span class="etiqueta">VISÍTANOS</span>

                <h1>
                    Ven a conocer<br>
                    Organic Zone
                </h1>

                <p class="intro">
                    Estamos listos para recibirte. Encuentra nuestra ubicación,
                    contáctanos o escríbenos para conocer más sobre nuestras
                    hamburguesas gourmet elaboradas con ingredientes orgánicos.
                </p>

            </div>


            <!-- =================================================
                 INFORMACIÓN (3 cajas en línea)
            ================================================= -->

            <div class="info">


                <!-- DIRECCIÓN -->

                <div class="carta carta-cafe">

                    <span class="icono" aria-hidden="true">
                        <svg viewBox="0 0 24 24">
                            <path d="M12 21s-7-6.2-7-11a7 7 0 0 1 14 0c0 4.8-7 11-7 11z"></path>
                            <circle cx="12" cy="10" r="2.5"></circle>
                        </svg>
                    </span>

                    <h2>Encuéntranos</h2>

                    <p class="dato">
                        Colegio Pedro Poveda,
                        Plazuela Tarija,
                        Av. América,
                        Cochabamba, Bolivia.
                    </p>

                    <p class="detalle">
                        Un espacio pensado para disfrutar
                        de una experiencia diferente,
                        saludable y deliciosa.
                    </p>

                    <a class="boton"
                       href="https://www.google.com/maps/search/?api=1&query=Colegio+Pedro+Poveda+Cochabamba"
                       target="_blank" rel="noopener">
                        Ver en el mapa
                    </a>

                </div>


                <!-- TELÉFONO -->

                <div class="carta carta-verde">

                    <span class="icono" aria-hidden="true">
                        <svg viewBox="0 0 24 24">
                            <path d="M5 4h4l2 5-2.5 1.5a11 11 0 0 0 5 5L15 13l5 2v4a2 2 0 0 1-2 2A16 16 0 0 1 3 6a2 2 0 0 1 2-2z"></path>
                        </svg>
                    </span>

                    <h2>Hablemos</h2>

                    <p class="dato dato-telefono">
                        +591 70376053
                    </p>

                    <p class="detalle">
                        Llámanos para realizar consultas,
                        conocer nuestros productos
                        o coordinar una reserva.
                    </p>

                    <a class="boton" href="tel:+59170376053">
                        Llamar ahora
                    </a>

                </div>


                <!-- CORREO -->

                <div class="carta carta-crema">

                    <span class="icono" aria-hidden="true">
                        <svg viewBox="0 0 24 24">
                            <rect x="3" y="5" width="18" height="14" rx="2"></rect>
                            <path d="m3 7 9 6 9-6"></path>
                        </svg>
                    </span>

                    <h2>Escríbenos</h2>

                    <p class="dato">
                        organiczone@gmail.com
                    </p>

                    <p class="detalle">
                        También puedes comunicarte
                        con nosotros por correo.
                        Estaremos encantados de atenderte.
                    </p>

                    <a class="boton" href="mailto:organiczone@gmail.com">
                        Enviar un correo
                    </a>

                </div>


            </div>

        </div>

    </section>


</body>

<?php include("footer.php"); ?>
</html>