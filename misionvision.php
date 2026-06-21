<style>

body{
    background:#eef0ed;
    font-family:Arial, sans-serif;
    min-height:100vh;
    overflow-x:hidden;
}

.about{
    width:100%;
}

h1{
    text-align:center;
    font-size:120px;
    color:#2b0a00;
    font-weight:900;
    margin-bottom:20px;
}

.mision{
    width:60%;
    background:#11b348;
    color:white;
    padding:25px 50px;
    border-radius:0 70px 70px 0;
    margin-bottom:40px;
}

.mision h2{
    font-size:55px;
    color:#ffd08a;
    margin-bottom:10px;
}

.mision p{
    font-size:18px;
    line-height:1.6;
}

.vision{
    width:60%;
    background:#e8b164;
    color:#1d2e1d;
    padding:25px 50px;
    border-radius:70px 0 0 70px;
    margin-left:auto;
}

.vision h2{
    font-size:55px;
    color:#2b0a00;
    margin-bottom:10px;
}

.vision p{
    font-size:18px;
    line-height:1.6;
}
</style>

<body>
<section>
<nav>
    <?php 
    include("nav.php");
    ?>
</nav>
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