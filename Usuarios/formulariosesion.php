<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--fuentes de canva y fonts hay que desacargar"-->
<title>My Oz | Iniciar Sesión</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">

<style>
form{
    display:flex;
    flex-direction:column;
}
/*reset*/
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

/*my oz log*/

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
/*caja padre*/

main{

width:1120px;

height:740px;

display:grid;

grid-template-columns:44% 56%;

border-radius:34px;

overflow:hidden;

background:white;

box-shadow:

0 18px 40px rgba(0,0,0,.12);

}

/*panel izuqiero verde*/

.login{

background:#12A33C;

display:flex;

justify-content:center;

align-items:center;

padding:70px 55px;

}

/*contenido log*/
.login article{

    width:72%;
    display:flex;
    flex-direction:column;
    justify-content:center;
}

/*titulos*/

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

/*inputs con animaciones algunos no dan*/

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

/*roles admin y vendedor*/

h3{


    color:white;
    margin:20px 0 8px 0;

}

.roles{
   
    display:flex;
    justify-content:space-between;
    align-items:center;

    gap:12px;
    margin-bottom:18px;
}

.roles label{
    cursor:pointer;
}

.roles input{
    display:none;
}

.admin span,
.vendedor span{
    display:inline-block;
    padding:12px 24px;
    border-radius:15px;
    font-weight:bold;
    transition:.3s;
}

.admin span{
    background:#3A1E13;
    color:#FFD57A;
}

.vendedor span{
    background:#FFD68A;
    color:#3A1E13;
}

.roles label:hover span{
    transform:translateY(-2px);
}

/*boton de entrar*/

.btn{


    width:100%;
    height:45px;

    margin-top:18px;

    border:none;
    border-radius:14px;

    background:#3A1E13;
    color:white;

    font-size:22px;
    font-weight:700;

    cursor:pointer;

}

.btn:hover{
    background:#2b140d;
    transform:scale(1.02);
}

/*ft hamburguesa*/

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

/*media */

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

<!--panel izquierdo login posisiones-->

<section class="login">

<article>

<h2>Iniciar</h2>

<h1>Sesión</h1>

<form action="login.php" method="POST">

    <label>Nombre:</label>
    <input type="text" name="nombre" required>

    <label>Carnet de Identidad:</label>
    <input type="text" name="CI" required>

    <h3>Rol:</h3>

    <section class="roles">

    <label class="admin">
        <input type="radio" name="rol" value="admin" required>
        <span>Admin</span>
    </label>

    <label class="vendedor">
        <input type="radio" name="rol" value="vendedor">
        <span>Vendedor</span>
    </label>

</section>

    <button class="btn" type="submit">
        Entrar
    </button>

</form>

</article>

</section>


<!-- panel derecho ft burger -->

<section class="foto">

<img
src="hamburgee.png"
alt="Hamburguesa Organic Zone">

</section>

</main>

</body>

</html>