<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<<<<<<< HEAD
=======

>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<<<<<<< HEAD
=======

    <title>Organic Zone | Sabor natural</title>

    <!-- TIPOGRAFÍAS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Nunito:wght@400;500;600;700;800&display=swap" rel="stylesheet">
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

    <title>Organic Zone | Sabor natural</title>

    <!-- TIPOGRAFÍAS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Nunito:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <style>

<<<<<<< HEAD

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


        /* =========================================================
           RESET
        ========================================================= */
=======
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
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

<<<<<<< HEAD
=======

>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128
        html{
            scroll-behavior:smooth;
        }

<<<<<<< HEAD
        body{
            background:var(--fondo);
            color:var(--cafe);
            font-family:'Nunito',sans-serif;
            overflow-x:hidden;
        }

        a{
            text-decoration:none;
        }


        /* =========================================================
           NAV
        ========================================================= */

        nav{
            position:relative;
            z-index:1000;
        }


        /* =========================================================
           HERO
        ========================================================= */

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
=======

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
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

        }


<<<<<<< HEAD
        /* Formas 2D */

        .oz-hero::before{
=======
        .oz-hero::after{
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

            content:"";

            position:absolute;

<<<<<<< HEAD
            width:500px;
            height:500px;

            border-radius:50%;

            right:-240px;
            top:-230px;

            background:rgba(255,255,255,.08);
=======
            width:300px;
            height:300px;

            left:-150px;
            bottom:-160px;

            border-radius:50%;

            background:rgba(255,255,255,.10);
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

        }


<<<<<<< HEAD
        .oz-hero::after{

            content:"";

            position:absolute;

            width:220px;
            height:220px;

            border-radius:50%;

            left:-120px;
            bottom:-120px;

            background:rgba(252,208,159,.14);
=======
        /* =====================================================
           TEXTO HERO
        ===================================================== */

        .oz-hero-contenido{

            position:relative;

            z-index:3;

            width:62%;
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

        }


<<<<<<< HEAD
        /* =========================================================
           CONTENIDO HERO
        ========================================================= */

        .oz-hero-contenido{

            position:relative;
            z-index:3;

            max-width:680px;
=======
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
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

        }


<<<<<<< HEAD
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
=======
        .oz-etiqueta::before{

            content:"";

            width:8px;
            height:8px;

            border-radius:50%;

            background:var(--verde);
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

        }


<<<<<<< HEAD
        .oz-etiqueta::before{

            content:"";

            width:8px;
            height:8px;

            border-radius:50%;

            background:var(--verde);
=======
        .oz-hero h1{

            font-family:'Fredoka',sans-serif;

            font-size:clamp(65px,8vw,120px);

            line-height:.82;

            letter-spacing:-5px;

            color:white;

            margin-bottom:35px;
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

        }


<<<<<<< HEAD
        .oz-hero h1{

            font-family:'Fredoka',sans-serif;

            font-size:clamp(65px,7.5vw,112px);

            font-weight:700;

            line-height:.86;

            letter-spacing:-5px;

            color:white;

            margin-bottom:30px;
=======
        .oz-hero h1 span{

            color:var(--crema);
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

        }


<<<<<<< HEAD
        .oz-hero h1 span{

            color:var(--crema);
=======
        .oz-hero-texto{

            max-width:600px;

            color:rgba(255,255,255,.90);

            font-size:19px;

            line-height:1.7;

            margin-bottom:35px;
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

        }


<<<<<<< HEAD
        .oz-hero-texto{

            max-width:600px;

            color:rgba(255,255,255,.92);

            font-size:18px;

            line-height:1.75;

            margin-bottom:32px;

        }


        /* =========================================================
           BOTONES
        ========================================================= */
=======
        /* =====================================================
           BOTONES HERO
        ===================================================== */
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

        .oz-botones{

            display:flex;

<<<<<<< HEAD
            gap:12px;
=======
            align-items:center;

            gap:15px;
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

            flex-wrap:wrap;

        }


        .oz-btn{

<<<<<<< HEAD
            min-height:52px;

            padding:0 25px;

=======
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128
            display:inline-flex;

            align-items:center;

            justify-content:center;

<<<<<<< HEAD
            border-radius:16px;

            font-family:'Fredoka',sans-serif;

            font-size:16px;

            font-weight:600;

            transition:.25s ease;
=======
            min-height:52px;

            padding:0 25px;

            border-radius:50px;

            text-decoration:none;

            font-family:'Fredoka',sans-serif;

            font-size:17px;

            font-weight:600;

            transition:.3s ease;
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

        }


        .oz-btn-principal{

            background:var(--crema);

            color:var(--cafe);

        }


        .oz-btn-principal:hover{

<<<<<<< HEAD
            background:white;

            transform:translateY(-3px);
=======
            transform:translateY(-4px);

            background:white;

            box-shadow:0 12px 25px rgba(43,20,13,.20);
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

        }


        .oz-btn-secundario{

<<<<<<< HEAD
            border:2px solid rgba(255,255,255,.55);
=======
            border:2px solid rgba(255,255,255,.45);
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

            color:white;

        }


        .oz-btn-secundario:hover{

            background:white;

            color:var(--verde);

<<<<<<< HEAD
            transform:translateY(-3px);
=======
            transform:translateY(-4px);
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

        }


<<<<<<< HEAD
        /* =========================================================
           CAJA PARA IMAGEN DEL HERO
        ========================================================= */

        .oz-hero-imagen{

            position:relative;

            z-index:3;

            width:100%;

            max-width:520px;

            aspect-ratio:1 / 1;

            margin-left:auto;

            border:3px dashed rgba(255,255,255,.70);

            border-radius:42px;
=======
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
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

            display:flex;

            align-items:center;

            justify-content:center;

<<<<<<< HEAD
            background:rgba(255,255,255,.07);
=======
        }


        .oz-hero-marca::before{

            content:"";

            position:absolute;

            width:310px;

            height:310px;

            border-radius:50%;

            background:var(--cafe);
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

        }


<<<<<<< HEAD
        /*
           AQUÍ COLOCARÁS LA IMAGEN

           Ejemplo:

           <img src="mi-imagen.png">

        */

        .oz-hero-imagen span{

            color:rgba(255,255,255,.80);

            font-family:'Fredoka',sans-serif;

            font-size:18px;

            letter-spacing:1px;

            text-align:center;
=======
        .oz-hero-marca::after{

            content:"OZ";

            position:absolute;

            font-family:'Fredoka',sans-serif;

            font-size:115px;

            font-weight:700;

            letter-spacing:-8px;

            color:var(--crema);
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

        }


<<<<<<< HEAD
        /* Cuando pongas la imagen */

        .oz-hero-imagen img{

            width:100%;

            height:100%;

            object-fit:contain;

            border-radius:40px;

            display:block;
=======
        .oz-marca-texto{

            position:absolute;

            bottom:65px;

            font-family:'Fredoka',sans-serif;

            color:white;

            font-size:17px;

            letter-spacing:4px;

            z-index:4;
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

        }


<<<<<<< HEAD
        
        


        /* =========================================================
           SECCIÓN FILOSOFÍA
        ========================================================= */

        .oz-filosofia{

            width:90%;

            max-width:1250px;

=======
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

>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128
            margin:110px auto;

            display:grid;

            grid-template-columns:1fr 1fr;

<<<<<<< HEAD
            gap:70px;
=======
            gap:80px;
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

            align-items:center;

        }


<<<<<<< HEAD
        .oz-mini-titulo{

            color:var(--verde);

            font-size:13px;
=======
        .oz-intro-etiqueta{

            color:var(--verde);

            font-size:14px;
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

            font-weight:800;

            letter-spacing:3px;

            margin-bottom:15px;

        }


<<<<<<< HEAD
        .oz-filosofia h2{

            font-family:'Fredoka',sans-serif;

            font-size:clamp(48px,5vw,72px);

            line-height:.94;
=======
        .oz-intro h2{

            font-family:'Fredoka',sans-serif;

            font-size:clamp(45px,5vw,72px);

            line-height:.95;
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

            letter-spacing:-3px;

            margin-bottom:25px;

        }


<<<<<<< HEAD
        .oz-filosofia h2 span{
=======
        .oz-intro h2 span{
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

            color:var(--verde);

        }


<<<<<<< HEAD
        .oz-filosofia-texto{

            max-width:600px;

            color:var(--gris);

            font-size:17px;

            line-height:1.8;

        }


        /* =========================================================
           TARJETAS DE VALORES
        ========================================================= */
=======
        .oz-intro p{

            color:var(--gris);

            font-size:18px;

            line-height:1.8;

            max-width:580px;

        }


        /* =====================================================
           BLOQUE DE VALORES
        ===================================================== */
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

        .oz-valores{

            display:grid;

            grid-template-columns:1fr 1fr;

<<<<<<< HEAD
            gap:14px;
=======
            gap:15px;
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

        }


        .oz-valor{

            min-height:190px;

<<<<<<< HEAD
            padding:27px;

            border-radius:28px;
=======
            padding:28px;

            border-radius:30px;
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

            display:flex;

            flex-direction:column;

            justify-content:space-between;

<<<<<<< HEAD
            transition:.25s ease;
=======
            transition:.3s ease;
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

        }


        .oz-valor:hover{

<<<<<<< HEAD
            transform:translateY(-6px);
=======
            transform:translateY(-7px);
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

        }


        .oz-valor-numero{

            font-family:'Fredoka',sans-serif;

<<<<<<< HEAD
            font-size:38px;
=======
            font-size:45px;

            line-height:1;
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

        }


        .oz-valor h3{

            font-family:'Fredoka',sans-serif;

            font-size:23px;

            margin-bottom:7px;

        }


        .oz-valor p{

            font-size:14px;

<<<<<<< HEAD
            line-height:1.55;
=======
            line-height:1.5;
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

        }


<<<<<<< HEAD
        .valor-verde{
=======
        .oz-valor-verde{
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

            background:var(--verde);

            color:white;

        }


<<<<<<< HEAD
        .valor-crema{
=======
        .oz-valor-crema{
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

            background:var(--crema);

            color:var(--cafe);

        }


<<<<<<< HEAD
        .valor-cafe{
=======
        .oz-valor-cafe{
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

            background:var(--cafe);

            color:white;

        }


<<<<<<< HEAD
        .valor-blanco{
=======
        .oz-valor-blanco{
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

            background:white;

            color:var(--cafe);

<<<<<<< HEAD
            border:1px solid var(--gris-claro);
=======
            box-shadow:0 12px 35px rgba(43,20,13,.08);
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

        }


<<<<<<< HEAD
        /* =========================================================
           FRASE CENTRAL
        ========================================================= */

        .oz-manifiesto{
=======
        /* =====================================================
           SECCIÓN DIFERENCIA
        ===================================================== */

        .oz-diferencia{
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

            width:90%;

            max-width:1300px;

            margin:0 auto 110px;

<<<<<<< HEAD
            padding:75px;

            background:var(--cafe);

            border-radius:50px;
=======
            background:var(--cafe);

            color:white;

            border-radius:55px;

            padding:75px;
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

            position:relative;

            overflow:hidden;

        }


<<<<<<< HEAD
        .oz-manifiesto::after{
=======
        .oz-diferencia::before{
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

            content:"";

            position:absolute;

<<<<<<< HEAD
            width:300px;

            height:300px;

            border-radius:50%;

            right:-130px;

            bottom:-150px;

            background:rgba(252,208,159,.08);

        }


        .oz-manifiesto-contenido{
=======
            width:450px;

            height:450px;

            border-radius:50%;

            background:rgba(252,208,159,.08);

            right:-200px;

            top:-200px;

        }


        .oz-diferencia-contenido{
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

            position:relative;

            z-index:2;

            max-width:850px;

        }


<<<<<<< HEAD
        .oz-manifiesto small{
=======
        .oz-diferencia small{
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

            color:var(--crema);

            font-weight:800;

            letter-spacing:3px;

        }


<<<<<<< HEAD
        .oz-manifiesto h2{

            color:white;
=======
        .oz-diferencia h2{
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

            font-family:'Fredoka',sans-serif;

            font-size:clamp(45px,6vw,75px);

            line-height:.95;

            letter-spacing:-3px;

            margin:20px 0 25px;

        }


<<<<<<< HEAD
        .oz-manifiesto h2 span{
=======
        .oz-diferencia h2 span{
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

            color:var(--crema);

        }


<<<<<<< HEAD
        .oz-manifiesto p{

            max-width:750px;

            color:#D9CCC5;

            font-size:17px;
=======
        .oz-diferencia p{

            max-width:750px;

            color:#d8cbc4;

            font-size:18px;
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

            line-height:1.8;

        }


<<<<<<< HEAD
        /* =========================================================
           SECCIÓN "HECHO DIFERENTE"
        ========================================================= */

        .oz-diferente{
=======
        /* =====================================================
           CARACTERÍSTICAS
        ===================================================== */

        .oz-caracteristicas{
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

            width:90%;

            max-width:1250px;

            margin:0 auto 110px;

        }


<<<<<<< HEAD
        .oz-titulo{
=======
        .oz-titulo-seccion{
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

            text-align:center;

            margin-bottom:50px;

        }


<<<<<<< HEAD
        .oz-titulo small{

            color:var(--verde);

            font-size:13px;

=======
        .oz-titulo-seccion small{

            color:var(--verde);

>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128
            font-weight:800;

            letter-spacing:3px;

        }


<<<<<<< HEAD
        .oz-titulo h2{

            font-family:'Fredoka',sans-serif;

            font-size:clamp(45px,5vw,62px);
=======
        .oz-titulo-seccion h2{

            font-family:'Fredoka',sans-serif;

            font-size:55px;
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

            letter-spacing:-2px;

            margin-top:10px;

        }


<<<<<<< HEAD
        .oz-grid{
=======
        .oz-grid-caracteristicas{
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

            display:grid;

            grid-template-columns:repeat(3,1fr);

<<<<<<< HEAD
            gap:18px;
=======
            gap:20px;
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

        }


<<<<<<< HEAD
        .oz-card{

            min-height:290px;

            padding:35px;

            background:white;

            border:1px solid var(--gris-claro);

            border-radius:32px;

            transition:.25s ease;
=======
        .oz-feature{

            background:white;

            border-radius:35px;

            padding:35px;

            min-height:270px;

            box-shadow:0 12px 35px rgba(43,20,13,.07);

            transition:.3s ease;
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

        }


<<<<<<< HEAD
        .oz-card:hover{

            transform:translateY(-8px);

            border-color:var(--verde);

        }


        .oz-card-numero{

            width:55px;

            height:55px;
=======
        .oz-feature:hover{

            transform:translateY(-8px);

        }


        .oz-feature-icon{

            width:58px;

            height:58px;

            border-radius:18px;
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

            display:flex;

            align-items:center;

            justify-content:center;

<<<<<<< HEAD
            border-radius:16px;

            background:var(--verde-suave);

            color:var(--verde-oscuro);

            font-family:'Fredoka',sans-serif;

            font-weight:700;

            font-size:19px;
=======
            background:var(--crema);

            color:var(--cafe);

            font-family:'Fredoka',sans-serif;

            font-size:22px;

            font-weight:700;
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

            margin-bottom:30px;

        }


<<<<<<< HEAD
        .oz-card h3{
=======
        .oz-feature h3{
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

            font-family:'Fredoka',sans-serif;

            font-size:25px;

            margin-bottom:12px;

        }


<<<<<<< HEAD
        .oz-card p{

            color:var(--gris);

            font-size:15px;

            line-height:1.7;

        }

        /* =========================================================
           CTA
        ========================================================= */
=======
        .oz-feature p{

            color:var(--gris);

            line-height:1.7;

            font-size:15px;

        }


        /* =====================================================
           CTA
        ===================================================== */
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

        .oz-cta{

            width:90%;

            max-width:1250px;

            margin:0 auto 110px;

<<<<<<< HEAD
            padding:70px 40px;

            background:var(--verde);

            border-radius:50px;
=======
            background:var(--verde);

            border-radius:55px;

            padding:70px;
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

            text-align:center;

            position:relative;

            overflow:hidden;

        }


        .oz-cta::before{

<<<<<<< HEAD
            content:"";

            position:absolute;

            width:260px;

            height:260px;

            border-radius:50%;

            left:-130px;

            top:-130px;

            background:rgba(255,255,255,.08);
=======
            content:"OZ";

            position:absolute;

            right:-25px;

            bottom:-90px;

            font-family:'Fredoka',sans-serif;

            font-size:300px;

            font-weight:700;

            color:rgba(255,255,255,.07);

            line-height:1;
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

        }


        .oz-cta h2{

            position:relative;

            z-index:2;

<<<<<<< HEAD
            color:white;

            font-family:'Fredoka',sans-serif;

            font-size:clamp(45px,6vw,72px);

            line-height:.95;

=======
            font-family:'Fredoka',sans-serif;

            font-size:clamp(45px,6vw,75px);

            line-height:.95;

            color:white;

>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128
            margin-bottom:20px;

        }


        .oz-cta p{

            position:relative;

            z-index:2;

            max-width:650px;

            margin:0 auto 30px;

            color:rgba(255,255,255,.9);

<<<<<<< HEAD
            font-size:17px;
=======
            font-size:18px;
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

            line-height:1.7;

        }


        .oz-cta .oz-btn{

            position:relative;

            z-index:3;

        }


<<<<<<< HEAD
        /* =========================================================
           FOOTER
        ========================================================= */
=======
        /* =====================================================
           FOOTER
        ===================================================== */
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

        footer{

            width:100%;

        }


<<<<<<< HEAD
        /* =========================================================
           RESPONSIVE
        ========================================================= */
=======
        /* =====================================================
           RESPONSIVE
        ===================================================== */
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

        @media(max-width:1000px){

            .oz-hero{

<<<<<<< HEAD
                grid-template-columns:1fr;

                padding:110px 7% 70px;
=======
                min-height:680px;
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

            }


            .oz-hero-contenido{

<<<<<<< HEAD
                max-width:700px;
=======
                width:100%;
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

            }


<<<<<<< HEAD
            .oz-hero-imagen{

                width:80%;

                max-width:430px;

                margin:0 auto;
=======
            .oz-hero-marca{

                opacity:.25;

                right:-100px;
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

            }


<<<<<<< HEAD
            .oz-filosofia{
=======
            .oz-intro{
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

                grid-template-columns:1fr;

                gap:45px;

            }


<<<<<<< HEAD
            .oz-grid{
=======
            .oz-grid-caracteristicas{
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

                grid-template-columns:1fr 1fr;

            }

        }


        @media(max-width:700px){

            .oz-hero{

                width:100%;

<<<<<<< HEAD
                min-height:auto;

                border-radius:0 0 40px 40px;

                padding:100px 25px 50px;

                gap:45px;
=======
                min-height:720px;

                padding:150px 25px 70px;

                border-radius:0 0 45px 45px;
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

            }


            .oz-hero h1{

<<<<<<< HEAD
                font-size:58px;
=======
                font-size:64px;
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

                letter-spacing:-3px;

            }


            .oz-hero-texto{

                font-size:16px;

            }


<<<<<<< HEAD
            .oz-hero-imagen{

                width:100%;

                max-width:none;

                aspect-ratio:1 / .9;

                border-radius:30px;
=======
            .oz-hero-marca{

                width:260px;

                height:260px;

                right:-100px;

                top:58%;
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

            }


<<<<<<< HEAD
            .oz-sello{

                right:18px;

                top:46%;
=======
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
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

                font-size:12px;

            }


<<<<<<< HEAD
            .oz-filosofia{
=======
            .oz-intro{
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

                width:90%;

                margin:75px auto;

            }


<<<<<<< HEAD
            .oz-filosofia h2{
=======
            .oz-intro h2{
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

                font-size:48px;

            }


            .oz-valores{

                grid-template-columns:1fr;

            }


<<<<<<< HEAD
            .oz-manifiesto{
=======
            .oz-diferencia{
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

                width:92%;

                padding:45px 28px;

                border-radius:35px;

            }


<<<<<<< HEAD
            .oz-manifiesto h2{

                font-size:47px;
=======
            .oz-diferencia h2{

                font-size:48px;
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

            }


<<<<<<< HEAD
            .oz-grid{
=======
            .oz-grid-caracteristicas{
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

                grid-template-columns:1fr;

            }


<<<<<<< HEAD
            .oz-cinta{

                margin-bottom:75px;
=======
            .oz-titulo-seccion h2{

                font-size:45px;
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

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

<<<<<<< HEAD
                font-size:51px;

            }


            .oz-botones{

                flex-direction:column;

                width:100%;
=======
                font-size:55px;
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

            }


            .oz-btn{

                width:100%;

            }

<<<<<<< HEAD
=======

            .oz-hero-marca{

                opacity:.18;

            }

>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128
        }

    </style>

</head>


<body>


    <!-- =====================================================
<<<<<<< HEAD
         NAVEGACIÓN
=======
         NAVEGACIÓN EXISTENTE
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128
    ===================================================== -->

    <nav>

        <?php include("nav.php"); ?>

    </nav>



    <!-- =====================================================
<<<<<<< HEAD
         HERO PRINCIPAL
=======
         HERO
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128
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

<<<<<<< HEAD
                En <strong>Organic Zone</strong> creemos que comer
                bien no significa renunciar al sabor.

                Creamos una propuesta diferente con ingredientes
                seleccionados, combinaciones únicas y una experiencia
                pensada para disfrutar.
=======
                En Organic Zone transformamos ingredientes
                frescos y orgánicos en una experiencia llena
                de sabor. Alimentación consciente, hamburguesas
                increíbles y una forma diferente de disfrutar.
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

            </p>


            <div class="oz-botones">

                <a
                    href="Cliente/vistacliente.php"
                    class="oz-btn oz-btn-principal"
                >
<<<<<<< HEAD
                    Ver nuestro menú
=======

                    Ver nuestro menú

>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128
                </a>


                <a
                    href="#nosotros"
                    class="oz-btn oz-btn-secundario"
                >
<<<<<<< HEAD
                    Conoce nuestra filosofía
=======

                    Conoce Organic Zone

>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128
                </a>

            </div>

        </div>


<<<<<<< HEAD
        <!-- =================================================
             CAJA PARA TU IMAGEN
             NO HAY DIBUJO OZ
        ================================================== -->

        <div class="oz-hero-imagen">

            <span>
                FT OZ
            </span>

        </div>
=======
        <!-- CÍRCULO OZ -->

        <div class="oz-hero-marca">

            <span class="oz-marca-texto">
                ORGANIC ZONE
            </span>

        </div>


        <div class="oz-frase">

            100% sabor 🌱

        </div>


>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128
    </header>



    <!-- =====================================================
<<<<<<< HEAD
         FILOSOFÍA
    ===================================================== -->

    <section
        class="oz-filosofia"
=======
         INTRODUCCIÓN
    ===================================================== -->

    <section
        class="oz-intro"
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128
        id="nosotros"
    >


        <div>

<<<<<<< HEAD
            <p class="oz-mini-titulo">
=======
            <p class="oz-intro-etiqueta">
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128
                NUESTRA FILOSOFÍA
            </p>


            <h2>

                Lo natural<br>
<<<<<<< HEAD
=======

>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128
                sabe <span>mejor.</span>

            </h2>


<<<<<<< HEAD
            <p class="oz-filosofia-texto">

                Organic Zone nace para demostrar que una propuesta
                diferente también puede ser deliciosa.

                <br><br>

                Buscamos combinar sabor, calidad y una forma más
                consciente de disfrutar la comida. Cada detalle
                está pensado para que nuestra marca tenga una
                personalidad propia.
=======
            <p>

                Organic Zone nace con una idea sencilla:
                crear comida deliciosa utilizando ingredientes
                de calidad y una propuesta más consciente.

                <br><br>

                Queremos que cada visita sea mucho más que
                una comida. Queremos crear una experiencia
                que puedas disfrutar, compartir y recordar.
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

            </p>

        </div>



        <div class="oz-valores">


<<<<<<< HEAD
            <article class="oz-valor valor-verde">
=======
            <article class="oz-valor oz-valor-verde">
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

                <span class="oz-valor-numero">
                    01
                </span>

                <div>

                    <h3>
                        Natural
                    </h3>

                    <p>
                        Ingredientes seleccionados
<<<<<<< HEAD
                        pensando en calidad y sabor.
=======
                        para una alimentación más consciente.
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128
                    </p>

                </div>

            </article>



<<<<<<< HEAD
            <article class="oz-valor valor-crema">
=======
            <article class="oz-valor oz-valor-crema">
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

                <span class="oz-valor-numero">
                    02
                </span>

                <div>

                    <h3>
                        Fresco
                    </h3>

                    <p>
<<<<<<< HEAD
                        Productos preparados para
                        disfrutar su mejor sabor.
=======
                        Productos pensados para
                        conservar su sabor y calidad.
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128
                    </p>

                </div>

            </article>



<<<<<<< HEAD
            <article class="oz-valor valor-cafe">
=======
            <article class="oz-valor oz-valor-cafe">
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

                <span class="oz-valor-numero">
                    03
                </span>

                <div>

                    <h3>
                        Delicioso
                    </h3>

                    <p>
<<<<<<< HEAD
                        Porque una alimentación consciente
=======
                        Porque comer saludable
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128
                        también puede ser increíble.
                    </p>

                </div>

            </article>



<<<<<<< HEAD
            <article class="oz-valor valor-blanco">
=======
            <article class="oz-valor oz-valor-blanco">
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

                <span class="oz-valor-numero">
                    04
                </span>

                <div>

                    <h3>
                        Consciente
                    </h3>

                    <p>
<<<<<<< HEAD
                        Una propuesta que busca cuidar
                        cada detalle.
=======
                        Una propuesta que busca
                        cuidar el producto y nuestro entorno.
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128
                    </p>

                </div>

            </article>


        </div>


    </section>



    <!-- =====================================================
<<<<<<< HEAD
         MANIFIESTO
    ===================================================== -->

    <section class="oz-manifiesto">


        <div class="oz-manifiesto-contenido">

            <small>
                LA ESENCIA DE ORGANIC ZONE
=======
         DIFERENCIA
    ===================================================== -->

    <section class="oz-diferencia">


        <div class="oz-diferencia-contenido">

            <small>
                LA DIFERENCIA ORGANIC ZONE
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128
            </small>


            <h2>

<<<<<<< HEAD
                No queremos hacer<br>

                lo de siempre.<br>

                Queremos hacerlo <span>mejor.</span>
=======
                No se trata solo<br>

                de una <span>hamburguesa.</span>
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

            </h2>


            <p>

<<<<<<< HEAD
                Organic Zone combina una identidad fresca,
                ingredientes seleccionados y una experiencia
                diferente.

                <br><br>

                Porque nuestra comida no solo tiene que verse bien.
                Tiene que sentirse bien y, sobre todo, saber increíble.
=======
                Se trata de saber qué estás comiendo,
                disfrutar cada ingrediente y descubrir
                que una propuesta saludable no tiene
                por qué ser aburrida.

                En Organic Zone combinamos sabor,
                creatividad y una filosofía más natural
                para crear algo diferente.
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

            </p>

        </div>


    </section>



    <!-- =====================================================
         CARACTERÍSTICAS
    ===================================================== -->

<<<<<<< HEAD
    <section class="oz-diferente">


        <div class="oz-titulo">
=======
    <section class="oz-caracteristicas">


        <div class="oz-titulo-seccion">
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

            <small>
                ¿POR QUÉ ORGANIC ZONE?
            </small>

            <h2>
                Hecho diferente.
            </h2>

        </div>



<<<<<<< HEAD
        <div class="oz-grid">


            <article class="oz-card">

                <div class="oz-card-numero">
=======
        <div class="oz-grid-caracteristicas">


            <article class="oz-feature">

                <div class="oz-feature-icon">
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128
                    01
                </div>

                <h3>
                    Ingredientes
                </h3>

                <p>

<<<<<<< HEAD
                    Seleccionamos nuestros ingredientes
                    buscando un equilibrio entre frescura,
                    calidad y sabor.
=======
                    Seleccionamos ingredientes
                    buscando equilibrio entre
                    sabor, calidad y frescura.
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

                </p>

            </article>



<<<<<<< HEAD
            <article class="oz-card">

                <div class="oz-card-numero">
=======
            <article class="oz-feature">

                <div class="oz-feature-icon">
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128
                    02
                </div>

                <h3>
                    Sabor
                </h3>

                <p>

<<<<<<< HEAD
                    Creamos combinaciones con personalidad
                    para que cada bocado tenga algo especial.
=======
                    Creamos combinaciones pensadas
                    para que cada bocado tenga
                    personalidad propia.
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

                </p>

            </article>



<<<<<<< HEAD
            <article class="oz-card">

                <div class="oz-card-numero">
=======
            <article class="oz-feature">

                <div class="oz-feature-icon">
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128
                    03
                </div>

                <h3>
                    Experiencia
                </h3>

                <p>

<<<<<<< HEAD
                    Organic Zone es más que comida:
                    es una identidad, una actitud y una
                    manera diferente de disfrutar.
=======
                    Desde nuestro concepto hasta
                    nuestra atención, todo forma
                    parte de Organic Zone.
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

                </p>

            </article>


        </div>


    </section>
<<<<<<< HEAD
=======



>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128
    <!-- =====================================================
         CTA
    ===================================================== -->

    <section class="oz-cta">


        <h2>

<<<<<<< HEAD
            Tu próximo<br>
            favorito está aquí.
=======
            ¿Listo para<br>

            probar algo diferente?
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

        </h2>


        <p>

<<<<<<< HEAD
            Descubre el menú de Organic Zone
            y encuentra algo que te sorprenda.
=======
            Descubre nuestro menú y encuentra
            tu próximo favorito de Organic Zone.
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128

        </p>


        <a
            href="Cliente/vistacliente.php"
            class="oz-btn oz-btn-principal"
        >

            Explorar menú

        </a>


    </section>



    <!-- =====================================================
<<<<<<< HEAD
         FOOTER
=======
         FOOTER EXISTENTE
>>>>>>> 6adca3b873662fd66309645c11b6ee6329425128
    ===================================================== -->

    <footer>

        <?php include("footer.php"); ?>

    </footer>


</body>

</html>