<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <!-- IMPORTANTE: sin esta línea el celular NO aplica los @media -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>OrganicZone</title>
    <link rel="icon" type="image/x-icon" href="favicon.ico">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700;900&display=swap" rel="stylesheet">

<style>

*{
    box-sizing:border-box;
}

html{
    scroll-behavior:smooth;
    -webkit-text-size-adjust:100%;
}

body{
    margin:0;
    background:#eef0ed;
    font-family:'Fredoka', Arial, sans-serif;
    color:#2B140D;
    overflow-x:hidden;
}

.contenedor-nav{
    height:105px;
}

.about{
    width:100%;
    padding:45px 0 100px;
    position:relative;
    overflow:hidden;
}

.about::before{
    content:"";
    position:absolute;
    width:330px;
    height:330px;
    background:#FCD09F;
    border-radius:50%;
    left:-180px;
    top:100px;
    opacity:.45;
}

.about::after{
    content:"";
    position:absolute;
    width:250px;
    height:250px;
    background:#11b348;
    border-radius:50%;
    right:-130px;
    bottom:100px;
    opacity:.12;
}

.about-header{
    width:90%;
    max-width:1300px;
    margin:0 auto 80px;
    position:relative;
    z-index:2;
}

.etiqueta-about{
    display:inline-flex;
    align-items:center;
    gap:9px;
    padding:9px 18px;
    background:#2B140D;
    color:#FCD09F;
    border-radius:50px;
    font-size:13px;
    font-weight:700;
    letter-spacing:2px;
}

.etiqueta-about::before{
    content:"";
    width:8px;
    height:8px;
    background:#FCD09F;
    border-radius:50%;
}

.about h1{
    margin:20px 0 0;
    font-size:clamp(65px,10vw,145px);
    line-height:.85;
    font-weight:900;
    letter-spacing:-5px;
    color:#2B140D;
}

.about h1 span{
    color:#11b348;
}

.about-intro{
    max-width:620px;
    margin:25px 0 0;
    font-size:19px;
    line-height:1.6;
    color:#665852;
}

.contenedor-mision-vision{
    width:90%;
    max-width:1300px;
    margin:auto;
    display:flex;
    flex-direction:column;
    gap:45px;
    position:relative;
    z-index:2;
}

.bloque{
    position:relative;
    overflow:hidden;
    min-height:350px;
    padding:55px 65px;
}

.bloque-mision{
    width:78%;
    background:#11b348;
    color:white;
    border-radius:0 70px 70px 70px;
}

.bloque-vision{
    width:78%;
    margin-left:auto;
    background:#FCD09F;
    color:#2B140D;
    border-radius:70px 0 70px 70px;
}

.numero{
    position:absolute;
    right:35px;
    bottom:-35px;
    font-size:150px;
    line-height:1;
    font-weight:900;
    opacity:.12;
    pointer-events:none;
}

.bloque-mision .numero{
    color:#FCD09F;
}

.bloque-vision .numero{
    color:#2B140D;
}

.bloque-superior{
    display:flex;
    align-items:center;
    gap:18px;
    margin-bottom:25px;
}

.icono-plano{
    width:58px;
    height:58px;
    flex-shrink:0;
    border-radius:18px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:27px;
    font-weight:900;
}

.bloque-mision .icono-plano{
    background:#FCD09F;
    color:#2B140D;
}

.bloque-vision .icono-plano{
    background:#2B140D;
    color:#FCD09F;
}

.numero-seccion{
    font-size:13px;
    font-weight:700;
    letter-spacing:2px;
    opacity:.7;
}

.bloque h2{
    margin:0;
    font-size:clamp(45px,5vw,68px);
    line-height:1;
    font-weight:900;
    letter-spacing:-2px;
}

.bloque-mision h2{
    color:#FCD09F;
}

.bloque-vision h2{
    color:#2B140D;
}

.bloque p{
    position:relative;
    z-index:2;
    max-width:850px;
    margin:0;
    font-size:20px;
    line-height:1.7;
}

.bloque-mision p{
    color:#f7fff8;
}

.bloque-vision p{
    color:#4d3025;
}

.frase{
    width:90%;
    max-width:1300px;
    margin:80px auto 0;
    padding:30px 35px;
    background:#2B140D;
    color:#FCD09F;
    border-radius:25px;
    text-align:center;
    font-size:18px;
    font-weight:600;
    position:relative;
    z-index:2;
}

.frase span{
    color:white;
}


/* =========================================================
   TABLET / CELULAR GRANDE
   ========================================================= */

@media(max-width:900px){

    /* El nav en celular mide ~75px + su margen superior */
    .contenedor-nav{
        height:92px;
    }

    .about{
        padding:30px 0 80px;
    }

    .about::before{
        width:240px;
        height:240px;
        left:-140px;
        top:140px;
    }

    .about::after{
        width:190px;
        height:190px;
        right:-100px;
        bottom:120px;
    }

    .about-header{
        margin-bottom:55px;
    }

    .about h1{
        font-size:clamp(60px,12vw,90px);
        letter-spacing:-3px;
    }

    .about-intro{
        font-size:17px;
    }

    .contenedor-mision-vision{
        gap:30px;
    }

    /* Ambos bloques ocupan casi todo el ancho,
       Visión se desplaza un poco para mantener el efecto escalonado */
    .bloque{
        padding:40px;
        min-height:auto;
    }

    .bloque-mision,
    .bloque-vision{
        width:92%;
    }

    .bloque-mision{
        border-radius:0 55px 55px 55px;
    }

    .bloque-vision{
        margin-left:auto;
        border-radius:55px 0 55px 55px;
    }

    .bloque h2{
        font-size:50px;
    }

    .bloque p{
        font-size:17px;
    }

    .numero{
        font-size:120px;
    }

    .frase{
        margin-top:60px;
    }

}


/* =========================================================
   CELULAR
   ========================================================= */

@media(max-width:600px){

    .contenedor-nav{
        height:84px;
    }

    .about{
        padding:20px 0 60px;
    }

    .about::before{
        width:180px;
        height:180px;
        left:-100px;
        top:170px;
    }

    .about::after{
        width:150px;
        height:150px;
        right:-80px;
        bottom:150px;
    }

    .about-header{
        width:88%;
        margin-bottom:40px;
    }

    .etiqueta-about{
        padding:8px 15px;
        font-size:11px;
        letter-spacing:1.5px;
    }

    .about h1{
        margin-top:16px;
        font-size:clamp(46px,15vw,64px);
        letter-spacing:-2px;
        line-height:.9;
    }

    .about-intro{
        margin-top:18px;
        font-size:15.5px;
        line-height:1.55;
    }

    .contenedor-mision-vision{
        width:88%;
        gap:22px;
    }

    /* En celular los bloques ocupan todo el ancho,
       conservando la forma con esquina recta distinta en cada uno */
    .bloque-mision,
    .bloque-vision{
        width:100%;
        margin-left:0;
        padding:30px 24px 34px;
    }

    .bloque-mision{
        border-radius:0 38px 38px 38px;
    }

    .bloque-vision{
        border-radius:38px 0 38px 38px;
    }

    .bloque-superior{
        gap:13px;
        margin-bottom:18px;
    }

    .icono-plano{
        width:46px;
        height:46px;
        border-radius:14px;
        font-size:21px;
    }

    .numero-seccion{
        font-size:11px;
        letter-spacing:1.5px;
    }

    .bloque h2{
        font-size:40px;
        letter-spacing:-1px;
    }

    .bloque p{
        font-size:15.5px;
        line-height:1.65;
    }

    .numero{
        font-size:95px;
        right:14px;
        bottom:-16px;
    }

    .frase{
        width:88%;
        margin-top:40px;
        padding:22px 18px;
        border-radius:22px;
        font-size:15px;
        line-height:1.5;
    }

    /* La frase se divide en dos líneas limpias */
    .frase span{
        display:block;
        margin-top:4px;
        font-size:14px;
    }

}


/* =========================================================
   CELULARES MUY ANGOSTOS
   ========================================================= */

@media(max-width:380px){

    .about h1{
        font-size:46px;
    }

    .bloque-mision,
    .bloque-vision{
        padding:26px 20px 30px;
    }

    .bloque h2{
        font-size:36px;
    }

    .bloque p{
        font-size:15px;
    }

    .numero-seccion{
        font-size:10.5px;
    }

}

</style>

</head>

<body>

<section>

    <div class="contenedor-nav">

        <?php
        include("nav.php");
        ?>

    </div>

</section>

<section class="about">

    <div class="about-header">

        <span class="etiqueta-about">
            CONÓCENOS
        </span>

        <h1>
            About <span>Us</span>
        </h1>

        <p class="about-intro">
            Conoce el propósito que impulsa a Organic Zone y la visión
            que tenemos para transformar la manera en que disfrutamos
            una alimentación saludable.
        </p>

    </div>


    <div class="contenedor-mision-vision">


        <article class="bloque bloque-mision">

            <span class="numero">
                01
            </span>

            <div class="bloque-superior">

                <div class="icono-plano">
                    M
                </div>

                <span class="numero-seccion">
                    NUESTRO PROPÓSITO
                </span>

            </div>

            <h2>
                MISIÓN
            </h2>

            <p>
                Nuestra misión es transformar radicalmente la cultura alimentaria
                actual, integrando soluciones tecnológicas de vanguardia con una
                nutrición basada en plantas de alta calidad.
            </p>

        </article>


        <article class="bloque bloque-vision">

            <span class="numero">
                02
            </span>

            <div class="bloque-superior">

                <div class="icono-plano">
                    V
                </div>

                <span class="numero-seccion">
                    HACIA DÓNDE VAMOS
                </span>

            </div>

            <h2>
                VISIÓN
            </h2>

            <p>
                Posicionarnos como el referente nacional en soluciones de bienestar
                integral, expandiendo nuestra presencia y promoviendo una
                alimentación saludable para todos.
            </p>

        </article>

    </div>


    <div class="frase">

        ORGANIC ZONE

        <span>
            · Sabor natural · Vida saludable
        </span>

    </div>

</section>

<footer>

    <?php
    include("footer.php");
    ?>

</footer>

</body>
</html>