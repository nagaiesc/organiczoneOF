<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    .refrescos{
    padding:40px;
}

.refrescos h1{
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
    width:100%;
    height:280px;
    background:#0c8d2f;
    border-radius:15px;
}

.carta h2{
    margin-top:15px;
    font-size:35px;
    color:#0c8d2f;
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

.precio button:hover{
    opacity:.8;
}
</style>
<body>
    <nav>
         <?php 
        include("nav.php");
        ?>
    </nav>

    <section class="refrescos">

    <h1>Refrescos</h1>

    <div class="productos">

        <div class="carta">
            <div class="imagen"></div>
            <h2>Limonada</h2>

            <div class="precio">
                <span>8 Bs</span>
                <button>Agregar</button>
            </div>
        </div>

        <div class="carta">
            <div class="imagen"></div>
            <h2>Jugo</h2>

            <div class="precio">
                <span>10 Bs</span>
                <button>Agregar</button>
            </div>
        </div>

        <div class="carta">
            <div class="imagen"></div>
            <h2>Té Frío</h2>

            <div class="precio">
                <span>9 Bs</span>
                <button>Agregar</button>
            </div>
        </div>

        <div class="carta">
            <div class="imagen"></div>
            <h2>Batido Verde</h2>

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
</body>
</html>