<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Organic Zone</title>
    <link rel="stylesheet" href="style.css">
</head>
<style>
body{
    background:#f2f2f2;
    min-height:100vh;
    padding:40px;
    margin:0;
    box-sizing:border-box;
    font-family:Arial, sans-serif;
}

.menu h1{
    color:#0c8d2f;
    font-size:70px;
    margin-bottom:30px;
    font-weight:bold;
}

.productos{
    display:flex;
    gap:25px;
    flex-wrap:wrap;
}

.card{
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

.carta{
    position:relative;
}

.carta h2{
    position:absolute;
    top:20px;
    left:20px;
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

button{
    background:#0c8d2f;
    color:white;
    border:none;
    padding:8px 18px;
    border-radius:20px;
    cursor:pointer;
    font-weight:bold;
}

button:hover{
    opacity:.9;
}
</style>
<body>


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

</body>
</html>