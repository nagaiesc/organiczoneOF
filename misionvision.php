<head>
    <title>OrganicZone</title>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700;900&display=swap" rel="stylesheet">
</head>
<style>

body{
    background:#eef0ed;
    font-family:'Fredoka', Arial, sans-serif;
    min-height:100vh;
    margin:0;
    overflow-x:hidden;
}

.contenedor-nav{
    height:100px;
}

.about{
    width:100%;
}

.about h1{
    text-align:center;
    font-size:120px;
    color:#2b0a00;
    font-family:'Fredoka', Arial, sans-serif;
    font-weight:900;
    margin:20px 0 50px;
}

.mision{
    width:60%;
    background:#11b348;
    color:white;
    padding:35px 50px;
    border-radius:0 70px 70px 0;
    margin-bottom:50px;
    box-sizing:border-box;
}

.mision h2{
    font-size:55px;
    color:#ffd08a;
    font-family:'Fredoka', Arial, sans-serif;
    margin:0 0 10px;
}

.mision p{
    font-size:18px;
    font-family:'Fredoka', Arial, sans-serif;
    line-height:1.6;
}

.vision{
    width:60%;
    background:#e8b164;
    color:#1d2e1d;
    padding:35px 50px;
    border-radius:70px 0 0 70px;
    margin-left:auto;
    box-sizing:border-box;
}

.vision h2{
    font-size:55px;
    color:#2b0a00;
    font-family:'Fredoka', Arial, sans-serif;
    margin:0 0 10px;
}

.vision p{
    font-size:18px;
    font-family:'Fredoka', Arial, sans-serif;
    line-height:1.6;
}

@media(max-width:900px){

    .about h1{
        font-size:70px;
    }

    .mision,.vision{
        width:90%;
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

    <h1>About Us</h1>

    <div class="mision">

        <h2>MISIÓN</h2>

        <p>
            Nuestra misión es transformar radicalmente la cultura alimentaria 
            actual, integrando soluciones tecnológicas de vanguardia con una 
            nutrición basada en plantas de alta calidad.
        </p>

    </div>

    <div class="vision">

        <h2>VISIÓN</h2>

        <p>
            Posicionarnos como el referente nacional en soluciones de bienestar 
            integral, expandiendo nuestra presencia y promoviendo una 
            alimentación saludable para todos.
        </p>

    </div>

</section>

<footer>

<?php  
include("footer.php");
?>

</footer>