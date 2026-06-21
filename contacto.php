<style>
body{
    background:#000;
}

.contacto{
    min-height:100vh;
    background:#000;
    color:white;
    position:relative;
    overflow:hidden;
}


.contacto::before{
    width:350px;
    height:350px;
    background:#4caf50;
    border-radius:50%;
    position:absolute;
    filter:blur(120px);
    opacity:.3;
}

.contacto::after{
    width:300px;
    height:300px;
    background:#4caf50;
    border-radius:50%;
    position:absolute;
    bottom:-120px;
    filter:blur(120px);
    opacity:.25;
}

.titulo{
    text-align:center;
    margin-bottom:80px;
}

.titulo h4{
    color:white;
    margin-bottom:20px;
    letter-spacing:2px;
}

.titulo h1{
    font-size:55px;
    margin-bottom:25px;
}

.titulo p{
    max-width:900px;
    margin:auto;
    line-height:1.7;
    font-size:18px;
}

.info{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
    gap:40px;
}

.carta{
    text-align:center;
    padding:40px 25px;
    border:1px solid rgba(255,255,255,.1);
    border-radius:20px;
    background:rgba(255,255,255,.03);
    backdrop-filter:blur(8px);
    transition:.4s;
}

.carta:hover{
    transform:translateY(10px);
    border-color:#4caf50;
    box-shadow:0 0 25px rgba(76,175,80,.5);
}

.carta span{
    font-size:45px;
    display:block;
    margin-bottom:25px;
}

.carta h2{
    font-size:38px;
    font-style:italic;
    margin-bottom:25px;
}

.carta p{
    line-height:1.7;
    font-size:18px;
}

.correo{
    color:#7CFC00;
    font-weight:bold;
}
</style>
<body>
    <section class="contacto">

    <div class="titulo">
        <h4>VISÍTANOS</h4>
        <h1>Encuéntranos en el<br> Colegio Pedro Poveda</h1>
        <p>
            Ven a visitarnos en Colegio Pedro Poveda Plazuela Tarija,
            Av. América, Cochabamba y disfruta de nuestras hamburguesas
            gourmet orgánicas en un ambiente acogedor.
        </p>
    </div>

    <div class="info">

        <div class="carta">
            <span>🌍</span>
            <h2>DIRECCIÓN</h2>
            <p>
                Colegio Pedro Poveda Plazuela Tarija,
                Av. América, Cochabamba Bolivia
            </p>
        </div>

        <div class="carta">
            <span>📞</span>
            <h2>CONTACTO</h2>
            <p>+591 70376053</p>
            <p>Llámanos para reservas o consultas.</p>
        </div>

        <div class="carta">
            <span>✉️</span>
            <h2>CORREO ELECTRÓNICO</h2>
            <p class="correo">organiczone@gmail.com</p>
            <p>Esperamos tener noticias tuyas.</p>
        </div>

    </div>

</section>