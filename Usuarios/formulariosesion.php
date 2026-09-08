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
form{
    display:flex;
    flex-direction:column;
}

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    background:#F4F1EE;
    font-family:'Nunito',sans-serif;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
    overflow:hidden;
}

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

main{
    width:1120px;
    height:740px;
    display:grid;
    grid-template-columns:44% 56%;
    border-radius:34px;
    overflow:hidden;
    background:white;
    box-shadow:0 18px 40px rgba(0,0,0,.12);
}

.login{
    background:#12A33C;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:70px 55px;
}

.login article{
    width:72%;
    display:flex;
    flex-direction:column;
    justify-content:center;
}

.login h2{
    font-family:'Fredoka',sans-serif;
    font-size:64px;
    font-weight:700;
    color:#FFD470;
    line-height:48px;
    letter-spacing:-1px;
}

.login h1{
    font-family:'Fredoka',sans-serif;
    font-size:92px;
    font-weight:700;
    color:#ffffff;
    line-height:78px;
    letter-spacing:-2px;
    margin-bottom:38px;
}

label{
    display:block;
    font-size:20px;
    font-weight:700;
    color:white;
    margin-top:16px;
    margin-bottom:8px;
}

input[type=text]{
    width:100%;
    height:52px;
    border:none;
    outline:none;
    background:#0D7C2F;
    border-radius:16px;
    padding:0 18px;
    font-size:18px;
    font-family:'Nunito',sans-serif;
    color:white;
    margin-bottom:6px;
}

input[type=text]::placeholder{
    color:#D9E5D8;
}

input[type=text]:focus{
    box-shadow:0 0 0 3px rgba(255,255,255,.25);
}

input.error{
    border:2px solid #FFD6D6;
    background:#9B3030;
}

label.error{
    color:#FFE2E2;
    font-size:14px;
    margin-top:2px;
    margin-bottom:4px;
    font-weight:700;
}

.btn{
    width:100%;
    height:45px;
    margin-top:18px;
    border:none;
    border-radius:14px;
    background:#3A1E13;
    color:white;
    font-family:'Nunito',sans-serif;
    font-size:22px;
    font-weight:700;
    cursor:pointer;
    transition:all .2s;
}

.btn:hover{
    background:#2b140d;
    transform:scale(1.02);
}

.separador-o{
    text-align:center;
    color:white;
    font-size:18px;
    font-weight:700;
    margin:10px 0;
}

.boton-registro{
    width:100%;
    height:45px;
    border:none;
    border-radius:14px;
    background:#3A1E13;
    color:white;
    font-family:'Nunito',sans-serif;
    font-size:22px;
    font-weight:700;
    cursor:pointer;
    transition:all .2s;
}

.boton-registro:hover{
    background:#2b140d;
    transform:scale(1.02);
}

.foto{
    background:#ECE9E4;
    overflow:hidden;
}

.foto img{
    width:100%;
    height:100%;
    object-fit:cover;
    object-position:center center;
    display:block;
}

@media(max-width:1000px){
    main{
        width:95%;
        height:auto;
        grid-template-columns:1fr;
    }

    .foto{
        height:420px;
    }

    header{
        left:30px;
        top:20px;
    }
}
</style>
</head>

<body>

<header>
    <section class="logo">
        <span>My</span>
        Oz
    </section>
</header>

<main>

    <section class="login">
        <article>

            <h2>Iniciar</h2>
            <h1>Sesión</h1>

            <form id="formLogin" action="login.php" method="POST" novalidate>

                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre">

                <label for="CI">Carnet de Identidad:</label>
                <input type="text" id="CI" name="CI">

                <button class="btn" type="submit">
                    Entrar
                </button>

                <p class="separador-o">o</p>

                <button class="boton-registro" type="button" onclick="window.location.href='formularioregistro.php'">
                    Registrarse
                </button>

            </form>

        </article>
    </section>

    <section class="foto">
        <img src="hamburgee.png" alt="Hamburguesa Organic Zone">
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