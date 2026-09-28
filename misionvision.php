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
 
<?php include $_SERVER['DOCUMENT_ROOT'] . '/organiczoneOF/includes/oz-navegacion.php'; ?> 
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
    flex-shrink:0; 
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
        padding:35px 0 80px; 
    } 
 
    .about-header{ 
        width:88%; 
        margin-bottom:55px; 
    } 
 
    .about h1{ 
        font-size:clamp(62px,11vw,90px); 
        letter-spacing:-3px; 
    } 
 
    .about-intro{ 
        max-width:600px; 
        font-size:17px; 
        line-height:1.55; 
    } 
 
    .contenedor-mision-vision{ 
        width:88%; 
        gap:30px; 
    } 
 
    .bloque{ 
        width:100%; 
        padding:40px 38px; 
        min-height:320px; 
    } 
 
    .bloque-mision{ 
        border-radius:0 50px 50px 50px; 
    } 
 
    .bloque-vision{ 
        margin-left:0; 
        border-radius:50px 0 50px 50px; 
    } 
 
    .bloque-superior{ 
        margin-bottom:22px; 
    } 
 
    .bloque h2{ 
        font-size:50px; 
    } 
 
    .bloque p{ 
        font-size:17px; 
        line-height:1.6; 
    } 
 
    .numero{ 
        font-size:125px; 
        right:25px; 
        bottom:-28px; 
    } 
 
    .frase{ 
        width:88%; 
        margin-top:60px; 
    } 
 
} 
 
@media(max-width:600px){ 
 
    .contenedor-nav{ 
        height:90px; 
    } 
 
    .about{ 
        padding:25px 0 60px; 
    } 
 
    .about::before{ 
        width:220px; 
        height:220px; 
        left:-145px; 
        top:120px; 
    } 
 
    .about::after{ 
        width:180px; 
        height:180px; 
        right:-105px; 
        bottom:80px; 
    } 
 
    .about-header{ 
        width:88%; 
        margin-bottom:40px; 
    } 
 
    .etiqueta-about{ 
        gap:7px; 
        padding:8px 14px; 
        font-size:10px; 
        letter-spacing:1.2px; 
    } 
 
    .etiqueta-about::before{ 
        width:7px; 
        height:7px; 
    } 
 
    .about h1{ 
        margin-top:17px; 
        font-size:58px; 
        line-height:.88; 
        letter-spacing:-2.5px; 
    } 
 
    .about-intro{ 
        margin-top:20px; 
        font-size:15.5px; 
        line-height:1.55; 
    } 
 
    .contenedor-mision-vision{ 
        width:88%; 
        gap:22px; 
    } 
 
    .bloque{ 
        width:100%; 
        min-height:0; 
        padding:27px 23px 30px; 
        border-radius:30px; 
    } 
 
    .bloque-mision{ 
        border-radius:0 35px 35px 35px; 
    } 
 
    .bloque-vision{ 
        margin-left:0; 
        border-radius:35px 0 35px 35px; 
    } 
 
    .bloque-superior{ 
        width:100%; 
        gap:11px; 
        margin-bottom:17px; 
    } 
 
    .icono-plano{ 
        width:44px; 
        height:44px; 
        border-radius:13px; 
        font-size:20px; 
    } 
 
    .numero-seccion{ 
        font-size:10px; 
        line-height:1.2; 
        letter-spacing:1.3px; 
    } 
 
    .bloque h2{ 
        font-size:39px; 
        letter-spacing:-1.5px; 
        margin-bottom:14px; 
    } 
 
    .bloque p{ 
        font-size:15px; 
        line-height:1.6; 
        max-width:none; 
    } 
 
    .numero{ 
        font-size:85px; 
        right:10px; 
        bottom:-18px; 
    } 
 
    .frase{ 
        width:88%; 
        margin-top:38px; 
        padding:20px 16px; 
        border-radius:20px; 
        font-size:13px; 
        line-height:1.5; 
    } 
 
    .frase span{ 
        display:block; 
        margin-top:2px; 
    } 
 
} 
 
@media(max-width:380px){ 
 
    .about-header{ 
        width:90%; 
    } 
 
    .about h1{ 
        font-size:51px; 
    } 
 
    .about-intro{ 
        font-size:14px; 
    } 
 
    .contenedor-mision-vision{ 
        width:90%; 
    } 
 
    .bloque{ 
        padding:24px 19px 27px; 
    } 
 
    .bloque-superior{ 
        gap:9px; 
    } 
 
    .icono-plano{ 
        width:40px; 
        height:40px; 
        border-radius:12px; 
        font-size:18px; 
    } 
 
    .numero-seccion{ 
        font-size:9px; 
        letter-spacing:1px; 
    } 
 
    .bloque h2{ 
        font-size:35px; 
    } 
 
    .bloque p{ 
        font-size:14px; 
    } 
 
    .frase{ 
        width:90%; 
        font-size:12px; 
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