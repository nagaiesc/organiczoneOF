<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Panel de Control - Admin</title>


    <!-- FUENTE FREDOKA -->

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect"
          href="https://fonts.gstatic.com"
          crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&display=swap"
          rel="stylesheet">


    <style>

        /* =====================================================
           CONFIGURACIÓN GENERAL
           ===================================================== */

        * {
            box-sizing: border-box;
        }


        body {

            margin: 0;

            min-height: 100vh;

            background: #F5EEE3;

            font-family: 'Fredoka', sans-serif;

            color: #2B140D;

            display: flex;

            justify-content: center;

            align-items: center;

            padding: 80px 30px 40px;

        }


        /* =====================================================
           PANEL PRINCIPAL
           ===================================================== */

        .panel {

            width: 100%;

            max-width: 1250px;

            display: grid;

            grid-template-columns: 1fr 1fr 1.5fr;

            grid-template-rows: 235px 370px 235px;

            gap: 25px;

            margin: auto;

        }


        /* =====================================================
           CAJAS GENERALES
           ===================================================== */

        .tarjeta {

            border-radius: 35px;

            overflow: hidden;

            transition: transform 0.2s ease,
                        box-shadow 0.2s ease;

        }


        .tarjeta:hover {

            transform: translateY(-4px);

            box-shadow: 0 10px 25px rgba(43, 20, 13, 0.12);

        }


        /* =====================================================
           HISTORIAL DE USUARIOS
           ===================================================== */

        .historial {

            background: #2B140D;

            padding: 25px;

            display: flex;

            flex-direction: column;

            justify-content: space-between;

        }


        .botones-historial {

            display: flex;

            flex-direction: column;

            align-items: flex-end;

            gap: 12px;

        }


        .boton-amarillo {

            background: #FCD09F;

            color: #2B140D;

            border: none;

            border-radius: 30px;

            padding: 12px 30px;

            font-family: 'Fredoka', sans-serif;

            font-size: 19px;

            font-weight: 600;

            cursor: pointer;

            text-decoration: none;

            display: inline-block;

            transition: transform 0.2s ease,
                        background 0.2s ease;

        }


        .boton-amarillo:hover {

            transform: scale(1.05);

            background: #FFDDB2;

        }


        .titulo-historial {

            margin: 0;

            color: white;

            font-size: 48px;

            line-height: 0.9;

            font-weight: 700;

        }


        .titulo-historial span {

            display: block;

            color: #FCD09F;

            font-size: 25px;

            margin-top: 8px;

        }


        /* =====================================================
           IMAGEN HAMBURGUESA
           ===================================================== */

        .imagen-hamburguesa {

            background: #08A84B;

            display: flex;

            align-items: center;

            justify-content: center;

        }


        .imagen-hamburguesa img {

            width: 100%;

            height: 100%;

            object-fit: cover;

            display: block;

        }


        /* =====================================================
           SALUDO
           ===================================================== */

        .saludo {

            display: flex;

            flex-direction: column;

            justify-content: center;

            align-items: center;

            text-align: center;

            padding: 20px;

        }


        .saludo-verde {

            margin: 0;

            color: #08A84B;

            font-size: 62px;

            font-weight: 700;

            line-height: 0.9;

        }


        .saludo-admin {

            margin: 8px 0 0 0;

            color: #2B140D;

            font-size: 78px;

            font-weight: 700;

            line-height: 0.95;

            word-break: break-word;

        }


        /* =====================================================
           PEDIDOS
           ===================================================== */

        .pedidos {

            background: #08A84B;

            padding: 30px;

            display: flex;

            flex-direction: column;

            justify-content: space-between;

            position: relative;

        }


        .pedidos::before {

            content: "";

            position: absolute;

            width: 190px;

            height: 280px;

            background: #2B140D;

            left: -85px;

            top: 35px;

            border-radius: 0 150px 150px 0;

        }


        .botones-pedidos {

            position: relative;

            z-index: 2;

            display: flex;

            flex-direction: column;

            align-items: flex-end;

            gap: 12px;

        }


        .boton-verde {

            background: #087F3B;

            color: white;

            border: none;

            border-radius: 30px;

            padding: 12px 32px;

            font-family: 'Fredoka', sans-serif;

            font-size: 19px;

            font-weight: 600;

            cursor: pointer;

            text-decoration: none;

            display: inline-block;

            transition: transform 0.2s ease,
                        background 0.2s ease;

        }


        .boton-verde:hover {

            transform: scale(1.05);

            background: #096D34;

        }


        .texto-pedidos {

            position: relative;

            z-index: 2;

        }


        .texto-pequeno {

            margin: 0;

            color: #FCD09F;

            font-size: 25px;

            font-weight: 600;

        }


        .titulo-pedidos {

            margin: 0;

            color: white;

            font-size: 52px;

            font-weight: 700;

            line-height: 0.9;

        }


        /* =====================================================
           PRODUCTOS
           ===================================================== */

        .productos {

            background: #FCD09F;

            padding: 30px;

            display: flex;

            flex-direction: column;

            justify-content: space-between;

            position: relative;

        }


        .productos::before {

            content: "";

            position: absolute;

            width: 175px;

            height: 220px;

            background: #833518;

            left: 65px;

            top: -25px;

            border-radius: 0 0 90px 90px;

        }


        .botones-productos {

            position: relative;

            z-index: 2;

            display: flex;

            flex-direction: column;

            align-items: flex-end;

            gap: 12px;

        }


        .boton-marron {

            background: #2B140D;

            color: white;

            border: none;

            border-radius: 30px;

            padding: 12px 32px;

            font-family: 'Fredoka', sans-serif;

            font-size: 19px;

            font-weight: 600;

            cursor: pointer;

            text-decoration: none;

            display: inline-block;

            transition: transform 0.2s ease,
                        background 0.2s ease;

        }


        .boton-marron:hover {

            transform: scale(1.05);

            background: #432117;

        }


        .texto-productos {

            position: relative;

            z-index: 2;

        }


        .texto-productos .texto-pequeno {

            color: #833518;

        }


        .titulo-productos {

            margin: 0;

            color: #2B140D;

            font-size: 52px;

            font-weight: 700;

            line-height: 0.9;

        }


        /* =====================================================
           VENTAS (NUEVO MÓDULO)
           ===================================================== */

        .ventas {

            grid-column: 1 / -1;

            background: #2B140D;

            padding: 30px 40px;

            display: flex;

            align-items: center;

            justify-content: space-between;

            position: relative;

        }


        .texto-ventas {

            position: relative;

            z-index: 2;

        }


        .texto-ventas .texto-pequeno {

            color: #FCD09F;

        }


        .titulo-ventas {

            margin: 0;

            color: white;

            font-size: 52px;

            font-weight: 700;

            line-height: 0.9;

        }


        .botones-ventas {

            position: relative;

            z-index: 2;

        }


        /* =====================================================
           IMAGEN DEL CHICO
           ===================================================== */

        .imagen-chico {

            background: #08A84B;

            display: flex;

            align-items: center;

            justify-content: center;

        }


        .imagen-chico img {

            width: 100%;

            height: 100%;

            object-fit: cover;

            display: block;

        }


        /* =====================================================
           RESPONSIVE
           ===================================================== */

        @media (max-width: 1000px) {

            body {

                align-items: flex-start;

                padding-top: 100px;

            }


            .panel {

                grid-template-columns: 1fr 1fr;

                grid-template-rows: auto;

                max-width: 800px;

            }


            .saludo {

                grid-column: 1 / -1;

                min-height: 220px;

            }


            .imagen-chico {

                min-height: 350px;

            }


            .imagen-hamburguesa {

                min-height: 250px;

            }

        }


        @media (max-width: 650px) {

            body {

                padding: 90px 15px 30px;

            }


            .panel {

                grid-template-columns: 1fr;

                gap: 18px;

            }


            .tarjeta {

                min-height: 300px;

            }


            .ventas {

                flex-direction: column;

                justify-content: space-between;

                align-items: flex-start;

            }


            .botones-ventas {

                align-self: flex-end;

            }


            .saludo {

                min-height: 200px;

            }


            .saludo-verde {

                font-size: 50px;

            }


            .saludo-admin {

                font-size: 60px;

            }


            .titulo-historial {

                font-size: 42px;

            }


            .titulo-pedidos,

            .titulo-productos,

            .titulo-ventas {

                font-size: 45px;

            }


            .boton-amarillo,

            .boton-verde,

            .boton-marron {

                padding: 11px 25px;

                font-size: 17px;

            }

        }

    </style>

</head>


<body>


    <?php include("nav.php"); ?>


    <main class="panel">


        <!-- =================================================
             HISTORIAL DE USUARIOS
             ================================================= -->

        <section class="tarjeta historial">

            <div class="botones-historial">

                <!-- SOLO ESTE BOTÓN REDIRECCIONA -->

                <a href="Usuarios/leerusuarios.php"
                   class="boton-amarillo">

                    Mostrar

                </a>

            </div>


            <h2 class="titulo-historial">

                Historial

                <span>
                    De usuarios
                </span>

            </h2>

        </section>


        <!-- =================================================
             IMAGEN HAMBURGUESA
             ================================================= -->

        <section class="tarjeta imagen-hamburguesa">

            <img src="burger2d.jpeg"
                 alt="Hamburguesa Organic Zone">

        </section>


        <!-- =================================================
             SALUDO DEL ADMIN
             ================================================= -->

        <section class="saludo">

            <h2 class="saludo-verde">
                Hola!
            </h2>


            <h1 class="saludo-admin">

                <?php

                    echo $_SESSION['nombre'];

                ?>

            </h1>

        </section>


        <!-- =================================================
             GESTIONAR PEDIDOS
             ================================================= -->

        <section class="tarjeta pedidos">


            <div class="botones-pedidos">

                <!-- SOLO EL BOTÓN REDIRECCIONA -->

                <a href="Pedidos/leerpedidos.php"
                   class="boton-verde">

                    Mostrar

                </a>

            </div>


            <div class="texto-pedidos">

                <p class="texto-pequeno">

                    Gestionar

                </p>


                <h2 class="titulo-pedidos">

                    Pedidos

                </h2>

            </div>


        </section>


        <!-- =================================================
             GESTIONAR PRODUCTOS
             ================================================= -->

        <section class="tarjeta productos">


            <div class="botones-productos">


                <!-- REGISTRAR PRODUCTO -->

                <a href="Productos/formularioproductos.php"
                   class="boton-marron">

                    Registrar

                </a>


                <!-- MOSTRAR PRODUCTOS -->

                <a href="Productos/leerproductos.php"
                   class="boton-marron">

                    Mostrar

                </a>


            </div>


            <div class="texto-productos">

                <p class="texto-pequeno">

                    Gestionar

                </p>


                <h2 class="titulo-productos">

                    Productos

                </h2>

            </div>


        </section>


        <!-- =================================================
             IMAGEN DEL CHICO
             ================================================= -->

        <section class="tarjeta imagen-chico">

            <img src="chicoburger.jpeg"
                 alt="Organic Zone">

        </section>


        <!-- =================================================
             GESTIONAR VENTAS
             ================================================= -->

        <section class="tarjeta ventas">

            <div class="texto-ventas">

                <p class="texto-pequeno">

                    Gestionar

                </p>

                <h2 class="titulo-ventas">

                    Ventas

                </h2>

            </div>

            <div class="botones-ventas">

                <a href="Ventas/leerventas.php"
                   class="boton-amarillo">

                    Mostrar

                </a>

            </div>

        </section>


    </main>


</body>

</html>