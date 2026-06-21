<style>
body{
    background:#f2f2f2;
    min-height:100vh;
    box-sizing:border-box;
    font-family:Arial, sans-serif;
}
.menu{
    padding:40px;
}

.menu h1{
    font-size:80px;
    color:#0c8d2f;
    margin-bottom:30px;
    font-weight:bold;
}

.productos{
    display:flex;
    justify-content:center;
    gap:25px;
    flex-wrap:wrap;
}

.carta{
    width:220px;
}

.imagen{
    height:270px;
    background:#0c8d2f;
    border-radius:15px;
}


.carta h2{
    margin-top:15px;
    color:white;
    font-size:32px;
    font-weight:bold;
}

.precio{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-top:15px;
}

.precio span{
    font-size:30px;
    font-weight:bold;
    color:#0c8d2f;
}

.precio button{
    background:#0c8d2f;
    color:white;
    border:none;
    padding:8px 18px;
    border-radius:20px;
    cursor:pointer;
    font-weight:bold;
}

button:hover{
    opacity:.8;
}
</style>
<body>
<nav>
    <?php 
    include("nav.php");
    ?>
</nav>

<section class="menu">
    <h1>Menú</h1>

    <div class="productos">

        <div class="carta">
            <div class="imagen"></div>
            <h2>Beyond Burger</h2>
            <div class="precio">
                <span>21 Bs</span>
                <button>Agregar</button>
            </div>
        </div>

        <div class="carta">
            <div class="imagen"></div>
            <h2>Beef Burger</h2>
            <div class="precio">
                <span>27 Bs</span>
                <button>Agregar</button>
            </div>
        </div>

        <div class="carta">
            <div class="imagen"></div>
            <h2>Smoked Fries</h2>
            <div class="precio">
                <span>7 Bs</span>
                <button>Agregar</button>
            </div>
        </div>

        <div class="carta">
            <div class="imagen"></div>
            <h2>Zone Shake</h2>
            <div class="precio">
                <span>12 Bs</span>
                <button>Agregar</button>
            </div>
        </div>

    </div>
</section>
<footer>
    <?php 
    include("footer.php");
    ?>
</footer>
