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
:root{
    --oz-verde:#12A33C;
    --oz-verde-oscuro:#064D22;
    --oz-cafe:#2B140D;
    --oz-fondo:#F7F3ED;
    --oz-crema:#FCD09F;
    --oz-blanco:#FFFFFF;
    --oz-borde:#E6DED4;
    --oz-error:#C62828;
}

*{
    box-sizing:border-box;
}

html{
    min-height:100%;
}

body{
    min-height:100vh;
    margin:0;
    padding:120px 22px 45px;
    display:flex;
    align-items:center;
    justify-content:center;
    background:var(--oz-fondo);
    color:var(--oz-cafe);
    font-family:'Nunito',sans-serif;
}

.caja{
    width:100%;
    max-width:440px;
    padding:38px;
    background:var(--oz-blanco);
    border:1px solid var(--oz-borde);
    border-radius:30px;
    text-align:center;
}

.etiqueta{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    margin-bottom:17px;
    padding:7px 14px;
    border-radius:30px;
    background:#EAF8E9;
    color:var(--oz-verde-oscuro);
    font-family:'Fredoka',sans-serif;
    font-size:12px;
    font-weight:600;
    letter-spacing:1px;
}

h1{
    margin:0 0 12px;
    color:var(--oz-cafe);
    font-family:'Fredoka',sans-serif;
    font-size:32px;
    font-weight:600;
    line-height:1.2;
}

h1 span{
    color:var(--oz-verde);
}

.descripcion{
    max-width:320px;
    margin:0 auto 26px;
    color:#6F6259;
    font-size:15px;
    font-weight:700;
    line-height:1.65;
}

form{
    width:100%;
    margin:0;
}

input{
    display:block;
    width:100%;
    height:54px;
    margin:0 0 14px;
    padding:0 17px;
    border:1.5px solid var(--oz-borde);
    border-radius:15px;
    outline:none;
    background:#FAF8F5;
    color:var(--oz-cafe);
    font-family:'Nunito',sans-serif;
    font-size:15px;
    font-weight:700;
    transition:border-color .2s,background-color .2s;
}

input::placeholder{
    color:#91847A;
    opacity:1;
}

input:focus{
    border-color:var(--oz-verde);
    background:var(--oz-blanco);
}

button{
    display:block;
    width:100%;
    min-height:53px;
    padding:13px 20px;
    border:2px solid var(--oz-cafe);
    border-radius:15px;
    background:var(--oz-cafe);
    color:var(--oz-crema);
    font-family:'Fredoka',sans-serif;
    font-size:18px;
    font-weight:500;
    cursor:pointer;
    transition:background-color .2s,border-color .2s,color .2s;
}

button:hover{
    border-color:var(--oz-verde);
    background:var(--oz-verde);
    color:var(--oz-blanco);
}

button:focus-visible{
    outline:3px solid var(--oz-verde);
    outline-offset:3px;
}

.error{
    margin:17px 0 0;
    padding:12px 15px;
    border:1px solid #E9B9B4;
    border-radius:13px;
    background:#FFF4F2;
    color:var(--oz-error);
    font-size:14px;
    font-weight:800;
    line-height:1.5;
}

@media(max-width:600px){
    body{
        padding:105px 17px 30px;
    }

    .caja{
        max-width:400px;
        padding:31px 23px;
        border-radius:25px;
    }

    h1{
        font-size:29px;
    }

    .descripcion{
        font-size:14px;
    }

    input{
        height:52px;
    }

    button{
        min-height:51px;
    }
}

@media(prefers-reduced-motion:reduce){
    input,
    button{
        transition:none;
    }
}
</style>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/organiczoneOF/includes/oz-navegacion.php'; ?>

</head>

<body>

<section class="caja">

    <div class="etiqueta">ORGANIC ZONE</div>

    <h1>Segunda <span>verificación</span></h1>

    <p class="descripcion">
        Por seguridad, debes ingresar la contraseña de acceso de tu rol.
    </p>

    <form action="verificarsegundo.php" method="POST">
        <input
            type="password"
            name="segundaclave"
            placeholder="Contraseña"
            aria-label="Contraseña de verificación"
            autocomplete="current-password"
            required
        >

        <button type="submit">Continuar</button>
    </form>

    <?php
    if(isset($_GET['error'])){
        echo '<p class="error" role="alert">Contraseña incorrecta</p>';
    }
    ?>

</section>

</body>
</html>
