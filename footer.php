<style>

@import url('https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&display=swap');

.oz-footer{
    position:relative;
    width:100%;
    margin-top:70px;
    padding:85px 7% 30px;
    background:#2B140D;
    color:#F4F1EE;
    font-family:'Fredoka',Arial,sans-serif;
    overflow:hidden;
    border-radius:150px 60px 0 0;
}

.oz-footer::before{
    content:"";
    position:absolute;
    width:400px;
    height:400px;
    right:-220px;
    top:-260px;
    border-radius:50%;
    background:rgba(252,208,159,0.90);
    opacity:.08;
}

.oz-footer::after{
    content:"";
    position:absolute;
    width:280px;
    height:280px;
    left:-190px;
    bottom:-220px;
    border-radius:50%;
    background:rgba(252,208,159,0.90);
    opacity:.06;
}

.oz-footer-contenedor{
    position:relative;
    z-index:2;
    max-width:1350px;
    margin:auto;
}

.oz-footer-top{
    display:flex;
    justify-content:space-between;
    align-items:flex-end;
    gap:60px;
    margin-bottom:55px;
}

.oz-footer-etiqueta{
    display:inline-block;
    padding:9px 18px;
    margin-bottom:18px;
    border-radius:50px;
    background:rgba(252,208,159,0.90);
    color:#2B140D;
    font-size:12px;
    font-weight:700;
    letter-spacing:2px;
}

.oz-footer-titulo{
    margin:0;
    color:#F4F1EE;
    font-size:clamp(48px,6vw,82px);
    line-height:.95;
    font-weight:700;
    letter-spacing:-3px;
}

.oz-footer-titulo span{
    color:rgba(252,208,159,0.90);
}

.oz-footer-descripcion{
    max-width:470px;
    margin:0;
    color:#cbbdb7;
    font-size:17px;
    line-height:1.7;
}

.oz-footer-info{
    display:grid;
    grid-template-columns:1.2fr .9fr .9fr;
    gap:18px;
}

.oz-footer-card{
    position:relative;
    min-height:280px;
    padding:32px;
    background:#351B12;
    border-radius:28px;
    overflow:hidden;
    transition:background .25s ease;
}

.oz-footer-card:hover{
    background:#432318;
}

.oz-footer-card:first-child{
    background:#432318;
}

.oz-footer-card:first-child:hover{
    background:#4D291C;
}

.oz-footer-card::after{
    position:absolute;
    right:-5px;
    bottom:-45px;
    font-size:140px;
    line-height:1;
    font-weight:700;
    color:rgba(252,208,159,0.05);
    pointer-events:none;
}

.oz-footer-card:nth-child(1)::after{
    content:"01";
}

.oz-footer-card:nth-child(2)::after{
    content:"02";
}

.oz-footer-card:nth-child(3)::after{
    content:"03";
}

.oz-footer-icon{
    position:relative;
    width:58px;
    height:58px;
    margin-bottom:24px;
    background:rgba(252,208,159,0.90);
    border-radius:18px;
}

.oz-icon-ubicacion::before{
    content:"";
    position:absolute;
    width:18px;
    height:23px;
    left:20px;
    top:15px;
    background:#2B140D;
    border-radius:50% 50% 50% 0;
    transform:rotate(-45deg);
}

.oz-icon-ubicacion::after{
    content:"";
    position:absolute;
    width:7px;
    height:7px;
    left:25px;
    top:20px;
    background:rgba(252,208,159,0.90);
    border-radius:50%;
}

.oz-icon-telefono::before{
    content:"";
    position:absolute;
    width:22px;
    height:29px;
    left:18px;
    top:14px;
    background:#2B140D;
    border-radius:6px 6px 8px 8px;
}

.oz-icon-telefono::after{
    content:"";
    position:absolute;
    width:8px;
    height:3px;
    left:25px;
    bottom:19px;
    background:rgba(252,208,159,0.90);
    border-radius:5px;
}

.oz-icon-correo::before{
    content:"";
    position:absolute;
    width:32px;
    height:23px;
    left:13px;
    top:18px;
    background:#2B140D;
    border-radius:5px;
}

.oz-icon-correo::after{
    content:"";
    position:absolute;
    width:18px;
    height:18px;
    left:20px;
    top:13px;
    border-left:4px solid rgba(252,208,159,0.90);
    border-bottom:4px solid rgba(252,208,159,0.90);
    transform:rotate(-45deg);
}

.oz-footer-card h3{
    position:relative;
    z-index:2;
    margin:0 0 14px;
    color:#F4F1EE;
    font-size:27px;
    font-weight:700;
}

.oz-footer-card p{
    position:relative;
    z-index:2;
    margin:0;
    color:#cbbdb7;
    font-size:16px;
    line-height:1.7;
}

.oz-footer-card:first-child p{
    color:#eadfd9;
}

.oz-footer-telefono{
    display:block;
    margin:0 0 10px!important;
    color:rgba(252,208,159,0.90)!important;
    font-size:27px!important;
    font-weight:700;
}

.oz-footer-correo{
    display:inline-block;
    padding:9px 13px;
    background:rgba(252,208,159,0.08);
    border-radius:12px;
    color:rgba(252,208,159,0.90)!important;
    font-weight:600;
    font-size:15px!important;
    word-break:break-word;
}

.oz-footer-bottom{
    position:relative;
    z-index:2;
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:30px;
    margin-top:55px;
    padding-top:25px;
    border-top:1px solid rgba(252,208,159,0.12);
}

.oz-footer-logo{
    display:flex;
    align-items:center;
    gap:15px;
}

.oz-footer-logo-marca{
    color:#F4F1EE;
    font-size:30px;
    font-weight:700;
    letter-spacing:-1px;
}

.oz-footer-logo-marca span{
    color:rgba(252,208,159,0.90);
}

.oz-footer-logo-linea{
    width:2px;
    height:28px;
    background:rgba(252,208,159,0.30);
}

.oz-footer-logo-texto{
    color:#8f807a;
    font-size:13px;
}

.oz-footer-copy{
    color:#8f807a;
    font-size:13px;
    line-height:1.7;
    text-align:right;
}

.oz-footer-copy strong{
    color:rgba(252,208,159,0.90);
}

@media(max-width:1050px){

    .oz-footer-info{
        grid-template-columns:1fr 1fr;
    }

    .oz-footer-card:first-child{
        grid-column:span 2;
    }

}

@media(max-width:800px){

    .oz-footer{
        padding:70px 5% 28px;
        border-radius:45px 45px 0 0;
    }

    .oz-footer-top{
        flex-direction:column;
        align-items:flex-start;
        gap:30px;
    }

    .oz-footer-titulo{
        font-size:55px;
    }

    .oz-footer-info{
        grid-template-columns:1fr;
    }

    .oz-footer-card:first-child{
        grid-column:auto;
    }

    .oz-footer-bottom{
        flex-direction:column;
        align-items:flex-start;
    }

    .oz-footer-copy{
        text-align:left;
    }

}

@media(max-width:500px){

    .oz-footer{
        padding:60px 20px 25px;
        border-radius:35px 35px 0 0;
    }

    .oz-footer-titulo{
        font-size:45px;
        letter-spacing:-2px;
    }

    .oz-footer-descripcion{
        font-size:15px;
    }

    .oz-footer-card{
        min-height:260px;
        padding:27px;
        border-radius:24px;
    }

    .oz-footer-card h3{
        font-size:24px;
    }

    .oz-footer-telefono{
        font-size:24px!important;
    }

    .oz-footer-logo{
        flex-wrap:wrap;
    }

    .oz-footer-logo-linea{
        display:none;
    }

}

</style>

<footer class="oz-footer">
    

    <div class="oz-footer-contenedor">

        <div class="oz-footer-top">

            <div>

                <span class="oz-footer-etiqueta">
                    VISÍTANOS
                </span>

                <h2 class="oz-footer-titulo">
                    Ven a conocer<br>
                    <span>Organic Zone</span>
                </h2>

            </div>

            <p class="oz-footer-descripcion">

                Un espacio pensado para disfrutar de una
                experiencia diferente, saludable y deliciosa.
                Ven a visitarnos y descubre nuestras
                hamburguesas gourmet orgánicas en un
                ambiente acogedor.

            </p>

        </div>

        <div class="oz-footer-info">

            <article class="oz-footer-card">

                <div class="oz-footer-icon oz-icon-ubicacion"></div>

                <h3>
                    Encuéntranos
                </h3>

                <p>
                    Colegio Pedro Poveda,
                    Plazuela Tarija,
                    Av. América,
                    Cochabamba, Bolivia.
                </p>

            </article>

            <article class="oz-footer-card">

                <div class="oz-footer-icon oz-icon-telefono"></div>

                <h3>
                    Hablemos
                </h3>

                <p class="oz-footer-telefono">
                    +591 70376053
                </p>

                <p>
                    Llámanos para reservas,
                    consultas o para conocer
                    nuestros productos.
                </p>

            </article>

            <article class="oz-footer-card">

                <div class="oz-footer-icon oz-icon-correo"></div>

                <h3>
                    Escríbenos
                </h3>

                <p class="oz-footer-correo">
                    organiczone@gmail.com
                </p>

                <p style="margin-top:15px;">
                    Esperamos tener noticias tuyas.
                </p>

            </article>

        </div>

        <div class="oz-footer-bottom">

            <div class="oz-footer-logo">

                <div class="oz-footer-logo-marca">
                    Organic<span>Zone</span>
                </div>

                <div class="oz-footer-logo-linea"></div>

                <div class="oz-footer-logo-texto">
                    Sabor natural · Vida saludable
                </div>

            </div>

            <div class="oz-footer-copy">

                © 2026 Organic Zone · Cochabamba, Bolivia

                <br>

                Hecho con
                <strong>ingredientes orgánicos</strong>

            </div>

        </div>

    </div>

</footer>