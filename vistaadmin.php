<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&display=swap"
          rel="stylesheet">


    <style>

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

            padding: 30px 20px;
        }

        .panel {
            width: 100%;
            max-width: 1100px;

            display: grid;

            grid-template-columns: 1fr 1fr 1.5fr;

            grid-template-rows: 200px 330px;

            gap: 20px;

            margin: auto;
        }


        .tarjeta {
            border-radius: 30px;
            overflow: hidden;

            transition: transform 0.2s ease;
        }

        .tarjeta:hover {
            transform: translateY(-3px);
        }


        .historial {
            background: #2B140D;

            padding: 18px 20px;

            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }


        .botones-historial {
            display: flex;
            flex-direction: column;

            align-items: flex-end;

            gap: 8px;
        }


        .boton-amarillo {
            background: #FCD09F;

            color: #2B140D;

            border: none;

            border-radius: 25px;

            padding: 8px 20px;

            font-family: 'Fredoka', sans-serif;

            font-size: 17px;
            font-weight: 600;

            cursor: pointer;
        }


        .boton-amarillo:hover {
            transform: scale(1.04);
        }


        .titulo-historial {
            margin: 0;

            color: white;

            font-size: 40px;

            line-height: 0.9;

            font-weight: 700;
        }


        .titulo-historial span {
            display: block;

            color: #FCD09F;

            font-size: 21px;

            margin-top: 5px;
        }



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
        }


        .saludo {
            display: flex;

            flex-direction: column;

            justify-content: center;

            align-items: center;

            text-align: center;

            padding: 10px;
        }


        .saludo-verde {
            margin: 0;

            color: #08A84B;

            font-size: 55px;

            font-weight: 700;

            line-height: 0.9;
        }


        .saludo-admin {
            margin: 0;

            color: #2B140D;

            font-size: 70px;

            font-weight: 700;

            line-height: 0.9;

            word-break: break-word;
        }


        /* =========================
           PEDIDOS
        ========================= */

        .pedidos {
            background: #08A84B;

            padding: 25px;

            display: flex;

            flex-direction: column;

            justify-content: space-between;

            position: relative;

            text-decoration: none;
        }


        .pedidos::before {
            content: "";

            position: absolute;

            width: 170px;
            height: 250px;

            background: #2B140D;

            left: -75px;
            top: 30px;

            border-radius: 0 140px 140px 0;
        }


        .botones-pedidos {
            position: relative;

            z-index: 2;

            display: flex;

            flex-direction: column;

            align-items: flex-end;

            gap: 8px;
        }


        .boton-verde {
            background: #087F3B;

            color: white;

            border: none;

            border-radius: 25px;

            padding: 8px 20px;

            font-family: 'Fredoka', sans-serif;

            font-size: 17px;

            font-weight: 600;

            cursor: pointer;
        }


        .texto-pedidos {
            position: relative;

            z-index: 2;
        }


        .texto-pequeno {
            margin: 0;

            color: #FCD09F;

            font-size: 22px;

            font-weight: 600;
        }


        .titulo-pedidos {
            margin: 0;

            color: white;

            font-size: 45px;

            font-weight: 700;

            line-height: 0.9;
        }


        /*  PRODUCTOS */

        .productos {
            background: #FCD09F;

            padding: 25px;

            display: flex;

            flex-direction: column;

            justify-content: space-between;

            position: relative;

            text-decoration: none;
        }


        .productos::before {
            content: "";

            position: absolute;

            width: 150px;
            height: 190px;

            background: #833518;

            left: 55px;
            top: -20px;

            border-radius: 0 0 80px 80px;
        }


        .botones-productos {
            position: relative;

            z-index: 2;

            display: flex;

            flex-direction: column;

            align-items: flex-end;

            gap: 8px;
        }


        .boton-marron {
            background: #2B140D;

            color: white;

            border: none;

            border-radius: 25px;

            padding: 8px 20px;

            font-family: 'Fredoka', sans-serif;

            font-size: 17px;

            font-weight: 600;

            cursor: pointer;
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

            font-size: 45px;

            font-weight: 700;

            line-height: 0.9;
        }


        /* =========================
           IMAGEN DEL CHICO
        ========================= */

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
        }


        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 900px) {

            body {
                align-items: flex-start;
            }

            .panel {
                grid-template-columns: 1fr 1fr;

                grid-template-rows: auto;

                margin-top: 20px;
            }

            .saludo {
                grid-column: 1 / -1;

                min-height: 180px;
            }

            .imagen-chico {
                min-height: 300px;
            }

        }


        @media (max-width: 600px) {

            body {
                padding: 20px 15px;
            }

            .panel {
                grid-template-columns: 1fr;

                gap: 15px;
            }

            .tarjeta {
                min-height: 250px;
            }

            .saludo {
                min-height: 170px;
            }

            .saludo-verde {
                font-size: 45px;
            }

            .saludo-admin {
                font-size: 55px;
            }

            .imagen-chico {
                min-height: 280px;
            }

        }

    </style>

</head>


<body>
    
    <?php include("nav.php"); ?>

    <main class="panel">


        <!-- HISTORIAL DE USUARIOS -->

        <section class="tarjeta historial">

            <div class="botones-historial">

                <button class="boton-amarillo">
                    Consultar
                </button>

                <button class="boton-amarillo">
                    Mostrar
                </button>

            </div>


            <h2 class="titulo-historial">

                Historial

                <span>
                    De usuarios
                </span>

            </h2>

        </section>

        <section class="tarjeta imagen-hamburguesa">

            <div>
                  <img src="burger2d.jpeg"
                     alt="Hamburguesa Organic Zone">
              

            </div>

        </section>
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

        <a href="Pedidos/formulariopedidos.php"
           class="tarjeta pedidos">


            <div class="botones-pedidos">

                <button type="button" class="boton-verde">
                    Mostrar
                </button>


            </div>


            <div class="texto-pedidos">

                <p class="texto-pequeno">
                    Gestionar
                </p>

                <h2 class="titulo-pedidos">
                    Pedidos
                </h2>

            </div>


        </a>


        <a href="Productos/formularioproductos.php"
           class="tarjeta productos">


            <div class="botones-productos">

                <button type="button" class="boton-marron">
                    Registrar
                </button>

                <button type="button" class="boton-marron">
                    Mostrar
                </button>

            </div>


            <div class="texto-productos">

                <p class="texto-pequeno">
                    Gestionar
                </p>

                <h2 class="titulo-productos">
                    Productos
                </h2>

            </div>


        </a>


        <section class="tarjeta imagen-chico">


            <div>
              <img src="chicoburger.jpeg"
            </div>

        </section>


    </main>


</body>

</html>