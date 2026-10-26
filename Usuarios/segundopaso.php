<?php
session_start();

if(!isset($_SESSION['CI']) || !isset($_SESSION['rol'])){
    header("Location: formulariosesion.php");
    exit();
}

if($_SESSION['rol'] !== 'admin' && $_SESSION['rol'] !== 'vendedor'){
    header("Location: ../Cliente/index.php");
    exit();
}

if(isset($_SESSION['segundoPaso']) && $_SESSION['segundoPaso'] === true){
    if($_SESSION['rol'] === 'admin'){
        header("Location: ../vistaadmin.php");
    }else{
        header("Location: vistavendedor.php");
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Seguridad | Organic Zone</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Nunito:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

:root{
    --verde:#0BA84A;
    --cafe:#3A1E13;
    --crema:#FCD09F;
    --fondo:#F4F1EE;
    --blanco:#FFFFFF;
    --borde:#DED8D3;
    --gris:#8B817B;
    --rojo:#D62828;
}

body{
    min-height:100vh;
    padding:35px 25px;
    display:flex;
    align-items:center;
    justify-content:center;
    background:var(--fondo);
    color:var(--cafe);
    font-family:'Nunito',sans-serif;
}

.contenedor{
    width:100%;
    max-width:850px;
    display:grid;
    grid-template-columns:36% 64%;
    overflow:hidden;
    border-radius:32px;
    background:var(--blanco);
    box-shadow:0 14px 38px rgba(58,30,19,.10);
}

.lateral{
    min-width:0;
    min-height:490px;
    padding:38px 30px;
    display:flex;
    flex-direction:column;
    justify-content:space-between;
    gap:24px;
    position:relative;
    overflow:hidden;
    background:var(--crema);
}

.lateral::before{
    content:"";
    position:absolute;
    width:190px;
    height:190px;
    top:-105px;
    right:-95px;
    border-radius:50%;
    background:var(--verde);
}

.lateral::after{
    content:"";
    position:absolute;
    width:145px;
    height:145px;
    bottom:-80px;
    left:-65px;
    border-radius:50%;
    background:var(--cafe);
}

.lateral-contenido{
    position:relative;
    z-index:1;
}

.lateral-contenido h2{
    margin-bottom:17px;
    color:var(--cafe);
    font-family:'Fredoka',sans-serif;
    font-size:36px;
    font-weight:700;
    line-height:1.08;
}

.lateral-contenido h2 span{
    color:var(--verde);
}

.lateral-contenido p{
    max-width:235px;
    color:var(--cafe);
    font-size:14px;
    font-weight:700;
    line-height:1.7;
}

.mascota-lateral{
    position:relative;
    z-index:1;
    display:flex;
    align-items:center;
    justify-content:center;
    flex:1;
    min-height:190px;
    width:100%;
}

.mascota-lateral img{
    display:block;
    width:min(100%, 250px);
    max-height:245px;
    object-fit:contain;
    object-position:center;
}

.decoracion{
    position:relative;
    z-index:1;
    color:var(--cafe);
    font-size:10px;
    font-weight:800;
    letter-spacing:1.3px;
    line-height:1.7;
}

.formulario{
    min-width:0;
    padding:52px 48px 35px;
    background:var(--blanco);
}

.encabezado{
    margin-bottom:30px;
}

.etiqueta{
    margin-bottom:9px;
    color:var(--verde);
    font-size:12px;
    font-weight:800;
    letter-spacing:2px;
    text-transform:uppercase;
}

.titulo{
    color:var(--cafe);
    font-family:'Fredoka',sans-serif;
    font-size:38px;
    font-weight:700;
    line-height:1.1;
}

.subtitulo{
    margin-top:11px;
    color:var(--gris);
    font-size:14px;
    line-height:1.6;
}

.campo{
    margin-bottom:21px;
}

.campo label{
    display:block;
    margin-bottom:8px;
    color:var(--cafe);
    font-size:13px;
    font-weight:800;
}

.campo input{
    display:block;
    width:100%;
    height:49px;
    padding:0 15px;
    border:1.5px solid var(--borde);
    border-radius:12px;
    outline:none;
    background:#FAF8F6;
    color:var(--cafe);
    font-family:'Nunito',sans-serif;
    font-size:14px;
    transition:border-color .2s,background-color .2s,box-shadow .2s;
}

.campo input::placeholder{
    color:#A8A09A;
    opacity:1;
}

.campo input:focus{
    border-color:var(--verde);
    background:var(--blanco);
    box-shadow:0 0 0 3px rgba(11,168,74,.10);
}

.boton{
    display:block;
    width:100%;
    min-height:51px;
    margin-top:3px;
    padding:13px 18px;
    border:0;
    border-radius:13px;
    background:var(--cafe);
    color:var(--blanco);
    font-family:'Nunito',sans-serif;
    font-size:15px;
    font-weight:800;
    cursor:pointer;
    transition:background-color .2s,color .2s;
}

.boton:hover{
    background:var(--verde);
    color:var(--blanco);
}

.boton:focus-visible{
    outline:3px solid rgba(11,168,74,.35);
    outline-offset:3px;
}

.alerta-error{
    margin-top:17px;
    padding:12px 14px;
    border:1px solid #F0C8C3;
    border-radius:12px;
    background:#FFF3F1;
    color:var(--rojo);
    font-size:13px;
    font-weight:800;
    line-height:1.5;
}

.pie{
    margin-top:23px;
    color:#918983;
    font-size:11px;
    line-height:1.6;
    text-align:center;
}

@media(max-width:800px){

    body{
        padding:90px 22px 30px;
    }

    .contenedor{
        width:100%;
        max-width:520px;
        grid-template-columns:1fr;
        border-radius:28px;
    }

    .lateral{
        min-height:0;
        padding:30px 30px 25px;
        gap:24px;
    }

    .lateral::before{
        width:150px;
        height:150px;
        top:-90px;
        right:-65px;
    }

    .lateral::after{
        width:105px;
        height:105px;
        bottom:-65px;
        left:-45px;
    }

    .lateral-contenido h2{
        margin-bottom:12px;
        font-size:32px;
        line-height:1.12;
    }

    .lateral-contenido p{
        max-width:340px;
        font-size:14px;
        line-height:1.65;
    }

    .mascota-lateral{
        min-height:170px;
    }

    .mascota-lateral img{
        width:min(100%, 210px);
        max-height:190px;
    }

    .decoracion{
        font-size:10px;
        letter-spacing:1.2px;
    }

    .formulario{
        padding:36px 34px 30px;
    }

    .encabezado{
        margin-bottom:27px;
    }

    .etiqueta{
        margin-bottom:10px;
    }

    .titulo{
        font-size:35px;
        line-height:1.15;
    }

    .subtitulo{
        margin-top:11px;
        font-size:14px;
        line-height:1.65;
    }

    .campo{
        margin-bottom:20px;
    }

    .campo label{
        margin-bottom:8px;
    }

    .campo input{
        height:50px;
    }

    .boton{
        min-height:52px;
        margin-top:4px;
    }

    .pie{
        margin-top:22px;
    }
}

@media(max-width:520px){

    body{
        padding:82px 16px 24px;
    }

    .contenedor{
        max-width:400px;
        border-radius:25px;
    }

    .lateral{
        padding:26px 24px 23px;
        gap:20px;
    }

    .lateral::before{
        width:120px;
        height:120px;
        top:-72px;
        right:-55px;
    }

    .lateral::after{
        width:85px;
        height:85px;
        bottom:-52px;
        left:-38px;
    }

    .lateral-contenido h2{
        max-width:270px;
        margin-bottom:10px;
        font-size:29px;
        line-height:1.15;
    }

    .lateral-contenido p{
        max-width:290px;
        font-size:13px;
        line-height:1.65;
    }

    .mascota-lateral{
        min-height:145px;
    }

    .mascota-lateral img{
        width:min(100%, 175px);
        max-height:160px;
    }

    .decoracion{
        font-size:9px;
        letter-spacing:1px;
    }

    .formulario{
        padding:30px 24px 26px;
    }

    .encabezado{
        margin-bottom:25px;
    }

    .etiqueta{
        font-size:11px;
        letter-spacing:1.7px;
    }

    .titulo{
        max-width:300px;
        font-size:30px;
        line-height:1.2;
        overflow-wrap:normal;
    }

    .subtitulo{
        max-width:300px;
        font-size:13px;
        line-height:1.65;
    }

    .campo{
        margin-bottom:18px;
    }

    .campo label{
        font-size:13px;
    }

    .campo input{
        height:49px;
        padding:0 14px;
        font-size:14px;
    }

    .boton{
        min-height:51px;
        border-radius:12px;
        font-size:15px;
    }

    .alerta-error{
        margin-top:16px;
        padding:12px;
        font-size:13px;
        line-height:1.55;
    }

    .pie{
        margin-top:20px;
        font-size:10px;
    }
}

@media(max-width:360px){

    body{
        padding:76px 11px 18px;
    }

    .contenedor{
        border-radius:21px;
    }

    .lateral{
        padding:23px 20px 21px;
        gap:17px;
    }

    .lateral-contenido h2{
        font-size:27px;
    }

    .lateral-contenido p{
        font-size:12px;
    }

    .decoracion{
        font-size:8px;
        letter-spacing:.7px;
    }

    .formulario{
        padding:27px 20px 23px;
    }

    .titulo{
        font-size:27px;
    }

    .subtitulo{
        font-size:12px;
    }

    .campo label{
        font-size:12px;
    }

    .campo input{
        height:47px;
        font-size:13px;
    }
}

@media(prefers-reduced-motion:reduce){

    .campo input,
    .boton{
        transition:none;
    }
}
</style>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/organiczoneOF/includes/oz-navegacion.php'; ?>

</head>

<body>

<main class="contenedor">

    <section class="lateral">

        <div class="lateral-contenido">

            <h2>
                Tu seguridad,
                <br>
                <span>primero.</span>
            </h2>

            <p>
                Verifica tu identidad para continuar con el acceso a Organic Zone.
            </p>

        </div>

       
    <div class="mascota-lateral">
              <img src="../beyondjr.png">
        </div>

    </section>

    <section class="formulario">

        <header class="encabezado">

            <div class="etiqueta">
                Organic Zone
            </div>

            <h1 class="titulo">
                Segunda verificación
            </h1>

            <p class="subtitulo">
                Por seguridad, debes ingresar la contraseña de acceso de tu rol.
            </p>

        </header>

        <form action="verificarsegundo.php" method="POST">

            <div class="campo">

                <label for="segundaclave">
                    Contraseña
                </label>

                <input
                    type="password"
                    id="segundaclave"
                    name="segundaclave"
                    placeholder="Ingresa tu contraseña"
                    autocomplete="current-password"
                    required
                >

            </div>

            <button type="submit" class="boton">
                Continuar
            </button>

        </form>

        <?php
        if(isset($_GET['error'])){
            echo '<p class="alerta-error" role="alert">Contraseña incorrecta</p>';
        }
        ?>

        <div class="pie">
            Organic Zone · Cochabamba, Bolivia
        </div>

    </section>

</main>

</body>
</html>
