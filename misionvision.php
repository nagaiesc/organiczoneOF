<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<head>
    <title>OrganicZone</title>
    <link rel="icon" type="image/x-icon" href="favicon.ico">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700;900&display=swap" rel="stylesheet">
</head>

<style>

*{
    box-sizing:border-box;
}

html{
    scroll-behavior:smooth;
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

@media(max-width:900px){

    .contenedor-nav{
        height:90px;
    }

    .about{
        padding-top:35px;
    }

    .about-header{
        margin-bottom:55px;
    }

    .about h1{
        font-size:75px;
        letter-spacing:-3px;
    }

    .about-intro{
        font-size:17px;
    }

    .bloque{
        width:92%;
        padding:40px;
        min-height:auto;
    }

    .bloque-vision{
        margin-left:8%;
    }

    .bloque h2{
        font-size:50px;
    }

    .bloque p{
        font-size:17px;
    }

}

@media(max-width:600px){

    .about{
        padding:25px 0 70px;
    }

    .about-header{
        width:88%;
    }

    .etiqueta-about{
        font-size:11px;
        letter-spacing:1.5px;
    }

    .about h1{
        font-size:57px;
        letter-spacing:-2px;
    }

    .about-intro{
        font-size:16px;
    }

    .contenedor-mision-vision{
        width:88%;
        gap:25px;
    }

    .bloque{
        width:100%;
        padding:30px 25px;
        border-radius:35px;
    }

    .bloque-vision{
        margin-left:0;
    }

    .bloque-superior{
        gap:13px;
        margin-bottom:20px;
    }

    .icono-plano{
        width:48px;
        height:48px;
        border-radius:15px;
        font-size:22px;
    }

    .bloque h2{
        font-size:42px;
    }

    .bloque p{
        font-size:16px;
        line-height:1.65;
    }

    .numero{
        font-size:100px;
        right:15px;
        bottom:-20px;
    }

    .frase{
        width:88%;
        margin-top:50px;
        padding:23px 20px;
        font-size:15px;
    }

}

</style>

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