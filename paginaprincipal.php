<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organic Zone | Sabor natural</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Nunito:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >
    <style>
        :root{
            --verde:#0BA84A;
            --verde-oscuro:#087A35;
            --verde-suave:#DFF4E7;
            --cafe:#29140D;
            --cafe-suave:#543328;
            --crema:#FCD09F;
            --crema-clara:#FFF1DF;
            --fondo:#F7F3ED;
            --blanco:#FFFFFF;
            --gris:#706963;
            --gris-claro:#E9E3DC;
        }
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
        a{
            text-decoration:none;
        }
        nav{
            position:relative;
            z-index:1000;
        }
        .oz-hero{
            width:94%;
            max-width:1450px;
            min-height:690px;
            margin:0 auto;
            position:relative;
            display:grid;
            grid-template-columns:1.05fr .95fr;
            align-items:center;
            gap:40px;
            padding:95px 7% 80px;
            overflow:hidden;
            background:var(--verde);
            border-radius:0 0 65px 65px;
        }
        .oz-hero::before{
            content:"";
            position:absolute;
            width:500px;
            height:500px;
            border-radius:50%;
            right:-240px;
            top:-230px;
            background:rgba(255,255,255,.08);
        }
        .oz-hero::after{
            content:"";
            position:absolute;
            width:220px;
            height:220px;
            border-radius:50%;
            left:-120px;
            bottom:-120px;
            background:rgba(252,208,159,.14);
        }
        .oz-hero-contenido{
            position:relative;
            z-index:3;
            max-width:680px;
        }
        .oz-etiqueta{
            display:inline-flex;
            align-items:center;
            gap:9px;
            padding:9px 17px;
            margin-bottom:25px;
            background:var(--crema);
            color:var(--cafe);
            border-radius:50px;
            font-size:12px;
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
            font-size:clamp(65px,7.5vw,112px);
            font-weight:700;
            line-height:.86;
            letter-spacing:-5px;
            color:white;
            margin-bottom:30px;
        }
        .oz-hero h1 span{
            color:var(--crema);
        }
        .oz-hero-texto{
            max-width:600px;
            color:rgba(255,255,255,.92);
            font-size:18px;
            line-height:1.75;
            margin-bottom:32px;
        }
        .oz-botones{
            display:flex;
            gap:12px;
            flex-wrap:wrap;
        }
        .oz-btn{
            min-height:52px;
            padding:0 25px;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            border-radius:16px;
            font-family:'Fredoka',sans-serif;
            font-size:16px;
            font-weight:600;
            transition:.25s ease;
        }
        .oz-btn-principal{
            background:var(--crema);
            color:var(--cafe);
        }
        .oz-btn-principal:hover{
            background:white;
            transform:translateY(-3px);
        }
        .oz-btn-secundario{
            border:2px solid rgba(255,255,255,.55);
            color:white;
        }
        .oz-btn-secundario:hover{
            background:white;
            color:var(--verde);
            transform:translateY(-3px);
        }
        .oz-hero-imagen{
            position:relative;
            z-index:3;
            width:100%;
            max-width:520px;
            aspect-ratio:1 / 1;
            margin-left:auto;
            border:3px dashed rgba(255,255,255,.70);
            border-radius:42px;
            display:flex;
            align-items:center;
            justify-content:center;
            background:rgba(255,255,255,.07);
        }
        .oz-hero-imagen span{
            color:rgba(255,255,255,.80);
            font-family:'Fredoka',sans-serif;
            font-size:18px;
            letter-spacing:1px;
            text-align:center;
        }
        .oz-hero-imagen img{
            width:100%;
            height:100%;
            object-fit:contain;
            border-radius:40px;
            display:block;
        }
        .oz-filosofia{
            width:90%;
            max-width:1250px;
            margin:110px auto;
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:70px;
            align-items:center;
        }
        .oz-mini-titulo{
            color:var(--verde);
            font-size:13px;
            font-weight:800;
            letter-spacing:3px;
            margin-bottom:15px;
        }
        .oz-filosofia h2{
            font-family:'Fredoka',sans-serif;
            font-size:clamp(48px,5vw,72px);
            line-height:.94;
            letter-spacing:-3px;
            margin-bottom:25px;
        }
        .oz-filosofia h2 span{
            color:var(--verde);
        }
        .oz-filosofia-texto{
            max-width:600px;
            color:var(--gris);
            font-size:17px;
            line-height:1.8;
        }
        .oz-valores{
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:14px;
        }
        .oz-valor{
            min-height:190px;
            padding:27px;
            border-radius:28px;
            display:flex;
            flex-direction:column;
            justify-content:space-between;
            transition:.25s ease;
        }
        .oz-valor:hover{
            transform:translateY(-6px);
        }
        .oz-valor-numero{
            font-family:'Fredoka',sans-serif;
            font-size:38px;
        }
        .oz-valor h3{
            font-family:'Fredoka',sans-serif;
            font-size:23px;
            margin-bottom:7px;
        }
        .oz-valor p{
            font-size:14px;
            line-height:1.55;
        }
        .valor-verde{
            background:var(--verde);
            color:white;
        }
        .valor-crema{
            background:var(--crema);
            color:var(--cafe);
        }
        .valor-cafe{
            background:var(--cafe);
            color:white;
        }
        .valor-blanco{
            background:white;
            color:var(--cafe);
            border:1px solid var(--gris-claro);
        }
        .oz-manifiesto{
            width:90%;
            max-width:1300px;
            margin:0 auto 110px;
            padding:75px;
            background:var(--cafe);
            border-radius:50px;
            position:relative;
            overflow:hidden;
        }
        .oz-manifiesto::after{
            content:"";
            position:absolute;
            width:300px;
            height:300px;
            border-radius:50%;
            right:-130px;
            bottom:-150px;
            background:rgba(252,208,159,.08);
        }
        .oz-manifiesto-contenido{
            position:relative;
            z-index:2;
            max-width:850px;
        }
        .oz-manifiesto small{
            color:var(--crema);
            font-weight:800;
            letter-spacing:3px;
        }
        .oz-manifiesto h2{
            color:white;
            font-family:'Fredoka',sans-serif;
            font-size:clamp(45px,6vw,75px);
            line-height:.95;
            letter-spacing:-3px;
            margin:20px 0 25px;
        }
        .oz-manifiesto h2 span{
            color:var(--crema);
        }
        .oz-manifiesto p{
            max-width:750px;
            color:#D9CCC5;
            font-size:17px;
            line-height:1.8;
        }
        .oz-diferente{
            width:90%;
            max-width:1250px;
            margin:0 auto 110px;
        }
        .oz-titulo{
            text-align:center;
            margin-bottom:50px;
        }
        .oz-titulo small{
            color:var(--verde);
            font-size:13px;
            font-weight:800;
            letter-spacing:3px;
        }
        .oz-titulo h2{
            font-family:'Fredoka',sans-serif;
            font-size:clamp(45px,5vw,62px);
            letter-spacing:-2px;
            margin-top:10px;
        }
        .oz-grid{
            display:grid;
            grid-template-columns:repeat(3,1fr);
            gap:18px;
        }
        .oz-card{
            min-height:290px;
            padding:35px;
            background:white;
            border:1px solid var(--gris-claro);
            border-radius:32px;
            transition:.25s ease;
        }
        .oz-card:hover{
            transform:translateY(-8px);
            border-color:var(--verde);
        }
        .oz-card-numero{
            width:55px;
            height:55px;
            display:flex;
            align-items:center;
            justify-content:center;
            border-radius:16px;
            background:var(--verde-suave);
            color:var(--verde-oscuro);
            font-family:'Fredoka',sans-serif;
            font-weight:700;
            font-size:19px;
            margin-bottom:30px;
        }
        .oz-card h3{
            font-family:'Fredoka',sans-serif;
            font-size:25px;
            margin-bottom:12px;
        }
        .oz-card p{
            color:var(--gris);
            font-size:15px;
            line-height:1.7;
        }
        .oz-cta{
            width:90%;
            max-width:1250px;
            margin:0 auto 110px;
            padding:70px 40px;
            background:var(--verde);
            border-radius:50px;
            text-align:center;
            position:relative;
            overflow:hidden;
        }
        .oz-cta::before{
            content:"";
            position:absolute;
            width:260px;
            height:260px;
            border-radius:50%;
            left:-130px;
            top:-130px;
            background:rgba(255,255,255,.08);
        }
        .oz-cta h2{
            position:relative;
            z-index:2;
            color:white;
            font-family:'Fredoka',sans-serif;
            font-size:clamp(45px,6vw,72px);
            line-height:.95;
            margin-bottom:20px;
        }
        .oz-cta p{
            position:relative;
            z-index:2;
            max-width:650px;
            margin:0 auto 30px;
            color:rgba(255,255,255,.9);
            font-size:17px;
            line-height:1.7;
        }
        .oz-cta .oz-btn{
            position:relative;
            z-index:3;
        }
        footer{
            width:100%;
        }
        @media(max-width:1000px){
            .oz-hero{
                grid-template-columns:1fr;
                padding:110px 7% 70px;
            }
            .oz-hero-contenido{
                max-width:700px;
            }
            .oz-hero-imagen{
                width:80%;
                max-width:430px;
                margin:0 auto;
            }
            .oz-filosofia{
                grid-template-columns:1fr;
                gap:45px;
            }
            .oz-grid{
                grid-template-columns:1fr 1fr;
            }
        }
        @media(max-width:700px){
            .oz-hero{
                width:100%;
                min-height:auto;
                border-radius:0 0 40px 40px;
                padding:100px 25px 50px;
                gap:45px;
            }
            .oz-hero h1{
                font-size:58px;
                letter-spacing:-3px;
            }
            .oz-hero-texto{
                font-size:16px;
            }
            .oz-hero-imagen{
                width:100%;
                max-width:none;
                aspect-ratio:1 / .9;
                border-radius:30px;
            }
            .oz-sello{
                right:18px;
                top:46%;
                font-size:12px;
            }
            .oz-filosofia{
                width:90%;
                margin:75px auto;
            }
            .oz-filosofia h2{
                font-size:48px;
            }
            .oz-valores{
                grid-template-columns:1fr;
            }
            .oz-manifiesto{
                width:92%;
                padding:45px 28px;
                border-radius:35px;
            }
            .oz-manifiesto h2{
                font-size:47px;
            }
            .oz-grid{
                grid-template-columns:1fr;
            }
            .oz-cinta{
                margin-bottom:75px;
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
                font-size:51px;
            }
            .oz-botones{
                flex-direction:column;
                width:100%;
            }
            .oz-btn{
                width:100%;
            }
        }
    </style>
</head>
<body>
    <nav>
        <?php include("nav.php"); ?>
    </nav>
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
                En <strong>Organic Zone</strong> creemos que comer
                bien no significa renunciar al sabor.
                Creamos una propuesta diferente con ingredientes
                seleccionados, combinaciones únicas y una experiencia
                pensada para disfrutar.
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
                    Conoce nuestra filosofía
                </a>
            </div>
        </div>
        <div class="oz-hero-imagen">
            <span>
                FT OZ
            </span>
        </div>
    </header>
    <section
        class="oz-filosofia"
        id="nosotros"
    >
        <div>
            <p class="oz-mini-titulo">
                NUESTRA FILOSOFÍA
            </p>
            <h2>
                Lo natural<br>
                sabe <span>mejor.</span>
            </h2>
            <p class="oz-filosofia-texto">
                Organic Zone nace para demostrar que una propuesta
                diferente también puede ser deliciosa.
                <br><br>
                Buscamos combinar sabor, calidad y una forma más
                consciente de disfrutar la comida. Cada detalle
                está pensado para que nuestra marca tenga una
                personalidad propia.
            </p>
        </div>
        <div class="oz-valores">
            <article class="oz-valor valor-verde">
                <span class="oz-valor-numero">
                    01
                </span>
                <div>
                    <h3>
                        Natural
                    </h3>
                    <p>
                        Ingredientes seleccionados
                        pensando en calidad y sabor.
                    </p>
                </div>
            </article>
            <article class="oz-valor valor-crema">
                <span class="oz-valor-numero">
                    02
                </span>
                <div>
                    <h3>
                        Fresco
                    </h3>
                    <p>
                        Productos preparados para
                        disfrutar su mejor sabor.
                    </p>
                </div>
            </article>
            <article class="oz-valor valor-cafe">
                <span class="oz-valor-numero">
                    03
                </span>
                <div>
                    <h3>
                        Delicioso
                    </h3>
                    <p>
                        Porque una alimentación consciente
                        también puede ser increíble.
                    </p>
                </div>
            </article>
            <article class="oz-valor valor-blanco">
                <span class="oz-valor-numero">
                    04
                </span>
                <div>
                    <h3>
                        Consciente
                    </h3>
                    <p>
                        Una propuesta que busca cuidar
                        cada detalle.
                    </p>
                </div>
            </article>
        </div>
    </section>
    <section class="oz-manifiesto">
        <div class="oz-manifiesto-contenido">
            <small>
                LA ESENCIA DE ORGANIC ZONE
            </small>
            <h2>
                No queremos hacer<br>
                lo de siempre.<br>
                Queremos hacerlo <span>mejor.</span>
            </h2>
            <p>
                Organic Zone combina una identidad fresca,
                ingredientes seleccionados y una experiencia
                diferente.
                <br><br>
                Porque nuestra comida no solo tiene que verse bien.
                Tiene que sentirse bien y, sobre todo, saber increíble.
            </p>
        </div>
    </section>
    <section class="oz-diferente">
        <div class="oz-titulo">
            <small>
                ¿POR QUÉ ORGANIC ZONE?
            </small>
            <h2>
                Hecho diferente.
            </h2>
        </div>
        <div class="oz-grid">
            <article class="oz-card">
                <div class="oz-card-numero">
                    01
                </div>
                <h3>
                    Ingredientes
                </h3>
                <p>
                    Seleccionamos nuestros ingredientes
                    buscando un equilibrio entre frescura,
                    calidad y sabor.
                </p>
            </article>
            <article class="oz-card">
                <div class="oz-card-numero">
                    02
                </div>
                <h3>
                    Sabor
                </h3>
                <p>
                    Creamos combinaciones con personalidad
                    para que cada bocado tenga algo especial.
                </p>
            </article>
            <article class="oz-card">
                <div class="oz-card-numero">
                    03
                </div>
                <h3>
                    Experiencia
                </h3>
                <p>
                    Organic Zone es más que comida:
                    es una identidad, una actitud y una
                    manera diferente de disfrutar.
                </p>
            </article>
        </div>
    </section>
    <section class="oz-cta">
        <h2>
            ESCRIBE TUS COMENTARIOS<br>
            !AYUDANOS A MEJORAR¡
        </h2>
        <p>
         Tus comentarios nos valen verga JAJSJSA
        </p>
        <a href="Cliente/vistacliente.php"
            class="oz-btn oz-btn-principal">
            Explorar comentarios
        </a>
    </section>
    <footer>
        <?php include("footer.php"); ?>
    </footer>
</body>
</html>
