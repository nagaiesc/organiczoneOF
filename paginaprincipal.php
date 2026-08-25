<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Organic Zone | Sabor natural</title>

    <!-- TIPOGRAFÍAS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Nunito:wght@400;500;600;700;800&display=swap" rel="stylesheet">


    <style>

        /* =====================================================
           VARIABLES ORGANIC ZONE
        ===================================================== */

        :root{

            --verde:#12A33C;
            --verde-oscuro:#08752A;

            --cafe:#2B140D;
            --cafe-claro:#432318;

            --crema:#FCD09F;
            --fondo:#F5EEE3;
            --blanco:#FFFDF9;

            --gris:#756B66;

        }


        /* =====================================================
           RESET
        ===================================================== */

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }


        html{
            scroll-behavior:smooth;
        }


        body{

            background:var(--fondo);

            color:var(--cafe);

            font-family:'Nunito',sans-serif;

            overflow-x:hidden;

        }


        /* =====================================================
           NAVEGACIÓN
        ===================================================== */

        nav{
            position:relative;
            z-index:1000;
        }


        /* =====================================================
           HERO PRINCIPAL
        ===================================================== */

        .oz-hero{

            position:relative;

            min-height:720px;

            width:92%;

            max-width:1400px;

            margin:0 auto;

            padding:150px 7% 100px;

            display:flex;

            align-items:center;

            overflow:hidden;

            background:

                radial-gradient(
                    circle at 85% 20%,
                    rgba(252,208,159,.55),
                    transparent 25%
                ),

                linear-gradient(
                    135deg,
                    var(--verde),
                    #079334
                );

            border-radius:0 0 80px 80px;

        }


        /* =====================================================
           DECORACIONES DEL HERO
        ===================================================== */

        .oz-hero::before{

            content:"";

            position:absolute;

            width:520px;
            height:520px;

            right:-220px;
            top:-200px;

            border-radius:50%;

            background:rgba(252,208,159,.20);

        }


        .oz-hero::after{

            content:"";

            position:absolute;

            width:300px;
            height:300px;

            left:-150px;
            bottom:-160px;

            border-radius:50%;

            background:rgba(255,255,255,.10);

        }


        /* =====================================================
           TEXTO HERO
        ===================================================== */

        .oz-hero-contenido{

            position:relative;

            z-index:3;

            width:62%;

        }


        .oz-etiqueta{

            display:inline-flex;

            align-items:center;

            gap:9px;

            padding:9px 18px;

            margin-bottom:25px;

            border-radius:50px;

            background:var(--crema);

            color:var(--cafe);

            font-size:13px;

            font-weight:800;

            letter-spacing:2px;

        }


        .oz-etiqueta::before{

            content:"";

            width:8px;
            height:8px;

            border-radius:50%;

            background:var(--verde);

        }


        .oz-hero h1{

            font-family:'Fredoka',sans-serif;

            font-size:clamp(65px,8vw,120px);

            line-height:.82;

            letter-spacing:-5px;

            color:white;

            margin-bottom:35px;

        }


        .oz-hero h1 span{

            color:var(--crema);

        }


        .oz-hero-texto{

            max-width:600px;

            color:rgba(255,255,255,.90);

            font-size:19px;

            line-height:1.7;

            margin-bottom:35px;

        }


        /* =====================================================
           BOTONES HERO
        ===================================================== */

        .oz-botones{

            display:flex;

            align-items:center;

            gap:15px;

            flex-wrap:wrap;

        }


        .oz-btn{

            display:inline-flex;

            align-items:center;

            justify-content:center;

            min-height:52px;

            padding:0 25px;

            border-radius:50px;

            text-decoration:none;

            font-family:'Fredoka',sans-serif;

            font-size:17px;

            font-weight:600;

            transition:.3s ease;

        }


        .oz-btn-principal{

            background:var(--crema);

            color:var(--cafe);

        }


        .oz-btn-principal:hover{

            transform:translateY(-4px);

            background:white;

            box-shadow:0 12px 25px rgba(43,20,13,.20);

        }


        .oz-btn-secundario{

            border:2px solid rgba(255,255,255,.45);

            color:white;

        }


        .oz-btn-secundario:hover{

            background:white;

            color:var(--verde);

            transform:translateY(-4px);

        }


        /* =====================================================
           LETRAS OZ DECORATIVAS
        ===================================================== */

        .oz-hero-marca{

            position:absolute;

            right:5%;

            top:50%;

            transform:translateY(-50%);

            z-index:2;

            width:390px;

            height:390px;

            border-radius:50%;

            border:2px solid rgba(255,255,255,.25);

            display:flex;

            align-items:center;

            justify-content:center;

        }


        .oz-hero-marca::before{

            content:"";

            position:absolute;

            width:310px;

            height:310px;

            border-radius:50%;

            background:var(--cafe);

        }


        .oz-hero-marca::after{

            content:"OZ";

            position:absolute;

            font-family:'Fredoka',sans-serif;

            font-size:115px;

            font-weight:700;

            letter-spacing:-8px;

            color:var(--crema);

        }


        .oz-marca-texto{

            position:absolute;

            bottom:65px;

            font-family:'Fredoka',sans-serif;

            color:white;

            font-size:17px;

            letter-spacing:4px;

            z-index:4;

        }


        /* =====================================================
           FRASE FLOTANTE
        ===================================================== */

        .oz-frase{

            position:absolute;

            right:25px;

            top:85px;

            z-index:5;

            background:white;

            color:var(--cafe);

            padding:14px 20px;

            border-radius:20px;

            font-family:'Fredoka',sans-serif;

            font-weight:600;

            transform:rotate(6deg);

            box-shadow:0 15px 35px rgba(43,20,13,.15);

        }


        /* =====================================================
           SECCIÓN INTRO
        ===================================================== */

        .oz-intro{

            max-width:1250px;

            width:90%;

            margin:110px auto;

            display:grid;

            grid-template-columns:1fr 1fr;

            gap:80px;

            align-items:center;

        }


        .oz-intro-etiqueta{

            color:var(--verde);

            font-size:14px;

            font-weight:800;

            letter-spacing:3px;

            margin-bottom:15px;

        }


        .oz-intro h2{

            font-family:'Fredoka',sans-serif;

            font-size:clamp(45px,5vw,72px);

            line-height:.95;

            letter-spacing:-3px;

            margin-bottom:25px;

        }


        .oz-intro h2 span{

            color:var(--verde);

        }


        .oz-intro p{

            color:var(--gris);

            font-size:18px;

            line-height:1.8;

            max-width:580px;

        }


        /* =====================================================
           BLOQUE DE VALORES
        ===================================================== */

        .oz-valores{

            display:grid;

            grid-template-columns:1fr 1fr;

            gap:15px;

        }


        .oz-valor{

            min-height:190px;

            padding:28px;

            border-radius:30px;

            display:flex;

            flex-direction:column;

            justify-content:space-between;

            transition:.3s ease;

        }


        .oz-valor:hover{

            transform:translateY(-7px);

        }


        .oz-valor-numero{

            font-family:'Fredoka',sans-serif;

            font-size:45px;

            line-height:1;

        }


        .oz-valor h3{

            font-family:'Fredoka',sans-serif;

            font-size:23px;

            margin-bottom:7px;

        }


        .oz-valor p{

            font-size:14px;

            line-height:1.5;

        }


        .oz-valor-verde{

            background:var(--verde);

            color:white;

        }


        .oz-valor-crema{

            background:var(--crema);

            color:var(--cafe);

        }


        .oz-valor-cafe{

            background:var(--cafe);

            color:white;

        }


        .oz-valor-blanco{

            background:white;

            color:var(--cafe);

            box-shadow:0 12px 35px rgba(43,20,13,.08);

        }


        /* =====================================================
           SECCIÓN DIFERENCIA
        ===================================================== */

        .oz-diferencia{

            width:90%;

            max-width:1300px;

            margin:0 auto 110px;

            background:var(--cafe);

            color:white;

            border-radius:55px;

            padding:75px;

            position:relative;

            overflow:hidden;

        }


        .oz-diferencia::before{

            content:"";

            position:absolute;

            width:450px;

            height:450px;

            border-radius:50%;

            background:rgba(252,208,159,.08);

            right:-200px;

            top:-200px;

        }


        .oz-diferencia-contenido{

            position:relative;

            z-index:2;

            max-width:850px;

        }


        .oz-diferencia small{

            color:var(--crema);

            font-weight:800;

            letter-spacing:3px;

        }


        .oz-diferencia h2{

            font-family:'Fredoka',sans-serif;

            font-size:clamp(45px,6vw,75px);

            line-height:.95;

            letter-spacing:-3px;

            margin:20px 0 25px;

        }


        .oz-diferencia h2 span{

            color:var(--crema);

        }


        .oz-diferencia p{

            max-width:750px;

            color:#d8cbc4;

            font-size:18px;

            line-height:1.8;

        }


        /* =====================================================
           CARACTERÍSTICAS
        ===================================================== */

        .oz-caracteristicas{

            width:90%;

            max-width:1250px;

            margin:0 auto 110px;

        }


        .oz-titulo-seccion{

            text-align:center;

            margin-bottom:50px;

        }


        .oz-titulo-seccion small{

            color:var(--verde);

            font-weight:800;

            letter-spacing:3px;

        }


        .oz-titulo-seccion h2{

            font-family:'Fredoka',sans-serif;

            font-size:55px;

            letter-spacing:-2px;

            margin-top:10px;

        }


        .oz-grid-caracteristicas{

            display:grid;

            grid-template-columns:repeat(3,1fr);

            gap:20px;

        }


        .oz-feature{

            background:white;

            border-radius:35px;

            padding:35px;

            min-height:270px;

            box-shadow:0 12px 35px rgba(43,20,13,.07);

            transition:.3s ease;

        }


        .oz-feature:hover{

            transform:translateY(-8px);

        }


        .oz-feature-icon{

            width:58px;

            height:58px;

            border-radius:18px;

            display:flex;

            align-items:center;

            justify-content:center;

            background:var(--crema);

            color:var(--cafe);

            font-family:'Fredoka',sans-serif;

            font-size:22px;

            font-weight:700;

            margin-bottom:30px;

        }


        .oz-feature h3{

            font-family:'Fredoka',sans-serif;

            font-size:25px;

            margin-bottom:12px;

        }


        .oz-feature p{

            color:var(--gris);

            line-height:1.7;

            font-size:15px;

        }


        /* =====================================================
           CTA
        ===================================================== */

        .oz-cta{

            width:90%;

            max-width:1250px;

            margin:0 auto 110px;

            background:var(--verde);

            border-radius:55px;

            padding:70px;

            text-align:center;

            position:relative;

            overflow:hidden;

        }


        .oz-cta::before{

            content:"OZ";

            position:absolute;

            right:-25px;

            bottom:-90px;

            font-family:'Fredoka',sans-serif;

            font-size:300px;

            font-weight:700;

            color:rgba(255,255,255,.07);

            line-height:1;

        }


        .oz-cta h2{

            position:relative;

            z-index:2;

            font-family:'Fredoka',sans-serif;

            font-size:clamp(45px,6vw,75px);

            line-height:.95;

            color:white;

            margin-bottom:20px;

        }


        .oz-cta p{

            position:relative;

            z-index:2;

            max-width:650px;

            margin:0 auto 30px;

            color:rgba(255,255,255,.9);

            font-size:18px;

            line-height:1.7;

        }


        .oz-cta .oz-btn{

            position:relative;

            z-index:3;

        }


        /* =====================================================
           FOOTER
        ===================================================== */

        footer{

            width:100%;

        }


        /* =====================================================
           RESPONSIVE
        ===================================================== */

        @media(max-width:1000px){

            .oz-hero{

                min-height:680px;

            }


            .oz-hero-contenido{

                width:100%;

            }


            .oz-hero-marca{

                opacity:.25;

                right:-100px;

            }


            .oz-intro{

                grid-template-columns:1fr;

                gap:45px;

            }


            .oz-grid-caracteristicas{

                grid-template-columns:1fr 1fr;

            }

        }


        @media(max-width:700px){

            .oz-hero{

                width:100%;

                min-height:720px;

                padding:150px 25px 70px;

                border-radius:0 0 45px 45px;

            }


            .oz-hero h1{

                font-size:64px;

                letter-spacing:-3px;

            }


            .oz-hero-texto{

                font-size:16px;

            }


            .oz-hero-marca{

                width:260px;

                height:260px;

                right:-100px;

                top:58%;

            }


            .oz-hero-marca::before{

                width:205px;

                height:205px;

            }


            .oz-hero-marca::after{

                font-size:75px;

            }


            .oz-marca-texto{

                bottom:38px;

                font-size:11px;

            }


            .oz-frase{

                right:15px;

                top:100px;

                font-size:12px;

            }


            .oz-intro{

                width:90%;

                margin:75px auto;

            }


            .oz-intro h2{

                font-size:48px;

            }


            .oz-valores{

                grid-template-columns:1fr;

            }


            .oz-diferencia{

                width:92%;

                padding:45px 28px;

                border-radius:35px;

            }


            .oz-diferencia h2{

                font-size:48px;

            }


            .oz-grid-caracteristicas{

                grid-template-columns:1fr;

            }


            .oz-titulo-seccion h2{

                font-size:45px;

            }


            .oz-cta{

                width:92%;

                padding:50px 25px;

                border-radius:35px;

            }


            .oz-cta h2{

                font-size:48px;

            }

        }


        @media(max-width:450px){

            .oz-hero h1{

                font-size:55px;

            }


            .oz-btn{

                width:100%;

            }


            .oz-hero-marca{

                opacity:.18;

            }

        }

    </style>

</head>


<body>


    <!-- =====================================================
         NAVEGACIÓN EXISTENTE
    ===================================================== -->

    <nav>

        <?php include("nav.php"); ?>

    </nav>



    <!-- =====================================================
         HERO
    ===================================================== -->

    <header class="oz-hero">


        <div class="oz-hero-contenido">

            <span class="oz-etiqueta">
                SABOR NATURAL
            </span>


            <h1>

                Come bien.<br>

                Vive <span>mejor.</span>

            </h1>


            <p class="oz-hero-texto">

                En Organic Zone transformamos ingredientes
                frescos y orgánicos en una experiencia llena
                de sabor. Alimentación consciente, hamburguesas
                increíbles y una forma diferente de disfrutar.

            </p>


            <div class="oz-botones">

                <a
                    href="Cliente/vistacliente.php"
                    class="oz-btn oz-btn-principal"
                >

                    Ver nuestro menú

                </a>


                <a
                    href="#nosotros"
                    class="oz-btn oz-btn-secundario"
                >

                    Conoce Organic Zone

                </a>

            </div>

        </div>


        <!-- CÍRCULO OZ -->

        <div class="oz-hero-marca">

            <span class="oz-marca-texto">
                ORGANIC ZONE
            </span>

        </div>


        <div class="oz-frase">

            100% sabor 🌱

        </div>


    </header>



    <!-- =====================================================
         INTRODUCCIÓN
    ===================================================== -->

    <section
        class="oz-intro"
        id="nosotros"
    >


        <div>

            <p class="oz-intro-etiqueta">
                NUESTRA FILOSOFÍA
            </p>


            <h2>

                Lo natural<br>

                sabe <span>mejor.</span>

            </h2>


            <p>

                Organic Zone nace con una idea sencilla:
                crear comida deliciosa utilizando ingredientes
                de calidad y una propuesta más consciente.

                <br><br>

                Queremos que cada visita sea mucho más que
                una comida. Queremos crear una experiencia
                que puedas disfrutar, compartir y recordar.

            </p>

        </div>



        <div class="oz-valores">


            <article class="oz-valor oz-valor-verde">

                <span class="oz-valor-numero">
                    01
                </span>

                <div>

                    <h3>
                        Natural
                    </h3>

                    <p>
                        Ingredientes seleccionados
                        para una alimentación más consciente.
                    </p>

                </div>

            </article>



            <article class="oz-valor oz-valor-crema">

                <span class="oz-valor-numero">
                    02
                </span>

                <div>

                    <h3>
                        Fresco
                    </h3>

                    <p>
                        Productos pensados para
                        conservar su sabor y calidad.
                    </p>

                </div>

            </article>



            <article class="oz-valor oz-valor-cafe">

                <span class="oz-valor-numero">
                    03
                </span>

                <div>

                    <h3>
                        Delicioso
                    </h3>

                    <p>
                        Porque comer saludable
                        también puede ser increíble.
                    </p>

                </div>

            </article>



            <article class="oz-valor oz-valor-blanco">

                <span class="oz-valor-numero">
                    04
                </span>

                <div>

                    <h3>
                        Consciente
                    </h3>

                    <p>
                        Una propuesta que busca
                        cuidar el producto y nuestro entorno.
                    </p>

                </div>

            </article>


        </div>


    </section>



    <!-- =====================================================
         DIFERENCIA
    ===================================================== -->

    <section class="oz-diferencia">


        <div class="oz-diferencia-contenido">

            <small>
                LA DIFERENCIA ORGANIC ZONE
            </small>


            <h2>

                No se trata solo<br>

                de una <span>hamburguesa.</span>

            </h2>


            <p>

                Se trata de saber qué estás comiendo,
                disfrutar cada ingrediente y descubrir
                que una propuesta saludable no tiene
                por qué ser aburrida.

                En Organic Zone combinamos sabor,
                creatividad y una filosofía más natural
                para crear algo diferente.

            </p>

        </div>


    </section>



    <!-- =====================================================
         CARACTERÍSTICAS
    ===================================================== -->

    <section class="oz-caracteristicas">


        <div class="oz-titulo-seccion">

            <small>
                ¿POR QUÉ ORGANIC ZONE?
            </small>

            <h2>
                Hecho diferente.
            </h2>

        </div>



        <div class="oz-grid-caracteristicas">


            <article class="oz-feature">

                <div class="oz-feature-icon">
                    01
                </div>

                <h3>
                    Ingredientes
                </h3>

                <p>

                    Seleccionamos ingredientes
                    buscando equilibrio entre
                    sabor, calidad y frescura.

                </p>

            </article>



            <article class="oz-feature">

                <div class="oz-feature-icon">
                    02
                </div>

                <h3>
                    Sabor
                </h3>

                <p>

                    Creamos combinaciones pensadas
                    para que cada bocado tenga
                    personalidad propia.

                </p>

            </article>



            <article class="oz-feature">

                <div class="oz-feature-icon">
                    03
                </div>

                <h3>
                    Experiencia
                </h3>

                <p>

                    Desde nuestro concepto hasta
                    nuestra atención, todo forma
                    parte de Organic Zone.

                </p>

            </article>


        </div>


    </section>



    <!-- =====================================================
         CTA
    ===================================================== -->

    <section class="oz-cta">


        <h2>

            ¿Listo para<br>

            probar algo diferente?

        </h2>


        <p>

            Descubre nuestro menú y encuentra
            tu próximo favorito de Organic Zone.

        </p>


        <a
            href="Cliente/vistacliente.php"
            class="oz-btn oz-btn-principal"
        >

            Explorar menú

        </a>


    </section>



    <!-- =====================================================
         FOOTER EXISTENTE
    ===================================================== -->

    <footer>

        <?php include("footer.php"); ?>

    </footer>


</body>

</html>