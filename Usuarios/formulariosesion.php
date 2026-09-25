<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Oz | Iniciar Sesión</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">

<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/localization/messages_es.min.js"></script>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

:root{
    --green:#12A33C;
    --green-dark:#064D22;
    --brown:#2B140D;
    --brown-soft:#3A1E13;
    --cream:#FCD09F;
    --cream-light:#FFF4E5;
    --bg:#F4F1EE;
    --input:#0D7C2F;
    --error:#D62828;
}

body{
    background:var(--bg);
    font-family:'Nunito',sans-serif;
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:100vh;
    overflow:hidden;
}

/* MY OZ ORIGINAL */

header{
    position:absolute;
    left:120px;
    top:30px;
    z-index:10;
}

.logo{
    font-family:'Fredoka',sans-serif;
    font-size:74px;
    font-weight:700;
    line-height:50px;
    color:#3A1E13;
}

.logo span{
    display:block;
    font-size:34px;
    margin-left:5px;
    margin-bottom:-10px;
}

/* CONTENEDOR */

main{
    width:1120px;
    height:700px;
    display:grid;
    grid-template-columns:46% 54%;
    border-radius:42px;
    overflow:hidden;
    background:#fff;
    position:relative;
    box-shadow:0 12px 30px rgba(43,20,13,.08);
}

/* LOGIN */

.login{
    background:var(--green);
    display:flex;
    justify-content:center;
    align-items:center;
    padding:60px 55px;
    position:relative;
    overflow:hidden;
}

.login::before{
    content:"";
    position:absolute;
    width:230px;
    height:230px;
    border-radius:50%;
    background:rgba(252,208,159,.13);
    top:-125px;
    left:-100px;
}

.login::after{
    content:"";
    position:absolute;
    width:190px;
    height:190px;
    border-radius:50%;
    background:rgba(255,255,255,.08);
    right:-90px;
    bottom:-85px;
}

.login article{
    width:78%;
    display:flex;
    flex-direction:column;
    justify-content:center;
    position:relative;
    z-index:2;
}

/* TITULO */

.titulo-login{
    margin-bottom:35px;
}

.login h2{
    font-family:'Fredoka',sans-serif;
    font-size:58px;
    font-weight:700;
    color:var(--cream);
    line-height:.9;
    letter-spacing:-1px;
}

.login h1{
    font-family:'Fredoka',sans-serif;
    font-size:88px;
    font-weight:700;
    color:#fff;
    line-height:.9;
    letter-spacing:-2px;
}

/* DETALLE */

.detalle-oz{
    width:65px;
    height:5px;
    border-radius:20px;
    background:var(--cream);
    margin-top:17px;
}

/* FORMULARIO */

form{
    display:flex;
    flex-direction:column;
}

label{
    display:block;
    font-size:18px;
    font-weight:800;
    color:white;
    margin-top:15px;
    margin-bottom:7px;
}

input[type=text]{
    width:100%;
    height:52px;
    border:none;
    outline:none;
    background:var(--input);
    border-radius:18px;
    padding:0 17px;
    font-size:17px;
    font-family:'Nunito',sans-serif;
    font-weight:600;
    color:white;
    margin-bottom:4px;
}

input[type=text]::placeholder{
    color:#D9E5D8;
}

input[type=text]:focus{
    box-shadow:0 0 0 3px rgba(252,208,159,.65);
}

input.error{
    border:2px solid #FFD6D6;
    background:#9B3030;
}

label.error{
    color:#FFE2E2;
    font-size:13px;
    margin-top:2px;
    margin-bottom:3px;
    font-weight:800;
}

/* ENTRAR */

.btn{
    width:100%;
    height:52px;
    margin-top:18px;
    border:none;
    border-radius:28px;
    background:var(--brown);
    color:white;
    font-family:'Nunito',sans-serif;
    font-size:20px;
    font-weight:800;
    cursor:pointer;
    transition:.2s ease;
}

.btn:hover{
    background:var(--brown-soft);
    transform:translateY(-1px);
}

/* SEPARADOR */

.separador-o{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:12px;
    color:var(--cream-light);
    font-size:15px;
    font-weight:800;
    margin:11px 0;
}

.separador-o::before,
.separador-o::after{
    content:"";
    height:2px;
    width:35px;
    border-radius:10px;
    background:rgba(255,255,255,.35);
}

/* REGISTRARSE */

.boton-registro{
    width:100%;
    height:52px;
    border:none;
    border-radius:28px;
    background:var(--cream);
    color:var(--brown);
    font-family:'Nunito',sans-serif;
    font-size:20px;
    font-weight:800;
    cursor:pointer;
    transition:.2s ease;
}

.boton-registro:hover{
    background:#FFD9A9;
    color:var(--brown);
    transform:translateY(-1px);
}

/* IMAGEN */

.foto{
    background:var(--cream);
    overflow:hidden;
    position:relative;
}

.foto::before{
    content:"";
    position:absolute;
    width:280px;
    height:280px;
    border-radius:50%;
    background:rgba(255,255,255,.30);
    top:-135px;
    right:-100px;
    z-index:1;
}

.foto::after{
    content:"";
    position:absolute;
    width:210px;
    height:210px;
    border-radius:50%;
    background:rgba(18,163,60,.12);
    bottom:-110px;
    left:-90px;
    z-index:1;
}

.foto img{
    width:100%;
    height:100%;
    object-fit:cover;
    object-position:center center;
    display:block;
    position:relative;
    z-index:2;
}

/* RESPONSIVE */

@media(max-width:1000px){

    body{
        overflow:auto;
        padding:30px 0;
    }

    header{
        position:relative;
        left:auto;
        top:auto;
        width:95%;
        margin-bottom:25px;
    }

    .logo{
        font-size:65px;
    }

    main{
        width:92%;
        height:auto;
        min-height:700px;
        grid-template-columns:1fr;
    }

    .login{
        min-height:600px;
    }

    .foto{
        height:420px;
    }
}

@media(max-width:600px){

    body{
        padding:20px 0;
    }

    header{
        width:90%;
    }

    .logo{
        font-size:58px;
        line-height:42px;
    }

    .logo span{
        font-size:28px;
    }

    main{
        width:92%;
        border-radius:30px;
    }

    .login{
        padding:50px 25px;
    }

    .login article{
        width:90%;
    }

    .login h2{
        font-size:47px;
    }

    .login h1{
        font-size:70px;
    }

    .foto{
        height:320px;
    }
}

</style>
</head>

<body>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/organiczoneOF/includes/oz-navegacion.php'; ?>

<header>
    <section class="logo">
        <span>My</span>
        Oz
    </section>
</header>

<main>

    <section class="login">

        <article>

            <div class="titulo-login">

                <h2>Iniciar</h2>
                <h1>Sesión</h1>

                <div class="detalle-oz"></div>

            </div>

            <form id="formLogin" action="login.php" method="POST" novalidate>

                <label for="nombre">Nombre:</label>

                <input
                    type="text"
                    id="nombre"
                    name="nombre"
                    autocomplete="name"
                >

                <label for="CI">Carnet de Identidad:</label>

                <input
                    type="text"
                    id="CI"
                    name="CI"
                    autocomplete="off"
                >

                <button class="btn" type="submit">
                    Entrar
                </button>

                <p class="separador-o">o</p>

                <button
                    class="boton-registro"
                    type="button"
                    onclick="window.location.href='formularioregistro.php'"
                >
                    Registrarse
                </button>

            </form>

        </article>

    </section>

    <section class="foto">

        <img
            src="hamburgee.png"
            alt="Hamburguesa Organic Zone"
        >

    </section>

</main>

<script>

$(document).ready(function(){

    $("#formLogin").validate({

        rules:{
            nombre:{
                required:true,
                minlength:2
            },

            CI:{
                required:true,
                minlength:5,
                maxlength:20
            }
        },

        messages:{
            nombre:{
                required:"Ingresa tu nombre",
                minlength:"El nombre debe tener al menos 2 caracteres"
            },

            CI:{
                required:"Ingresa tu Carnet de Identidad",
                minlength:"El CI debe tener al menos 5 caracteres",
                maxlength:"El CI no puede superar los 20 caracteres"
            }
        },

        errorElement:"label",

        errorPlacement:function(error,element){
            error.insertAfter(element);
        },

        highlight:function(element){
            $(element).addClass("error");
        },

        unhighlight:function(element){
            $(element).removeClass("error");
        },

        submitHandler:function(form){
            form.submit();
        }

    });

});

</script>

</body>
</html>
