<style>

@import url('https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&display=swap');


/* =====================================================
   CONTACTO - ORGANIC ZONE
===================================================== */

*{
    box-sizing:border-box;
}

body{
    margin:0;
    background:#F4F1EE;
    font-family:'Fredoka', Arial, sans-serif;
    color:#2B140D;
}


/* =====================================================
   SECCIÓN PRINCIPAL
===================================================== */

.contacto{

    min-height:100vh;

    background:#F4F1EE;

    padding:110px 7% 100px;

    position:relative;

    overflow:hidden;
}


/* DECORACIÓN DE FONDO */

.contacto::before{

    content:"";

    position:absolute;

    width:420px;
    height:420px;

    background:#0ba84a;

    border-radius:50%;

    right:-180px;
    top:-150px;

    opacity:.12;
}


.contacto::after{

    content:"";

    position:absolute;

    width:300px;
    height:300px;

    background:#2B140D;

    border-radius:50%;

    left:-150px;
    bottom:-150px;

    opacity:.08;
}


/* =====================================================
   ENCABEZADO
===================================================== */

.titulo{

    position:relative;

    z-index:2;

    max-width:1050px;

    margin:0 auto 75px;

    text-align:center;
}


.titulo h4{

    display:inline-block;

    margin:0 0 18px;

    padding:8px 18px;

    background:#0ba84a;

    color:white;

    border-radius:50px;

    font-size:13px;

    font-weight:600;

    letter-spacing:2px;

}


.titulo h1{

    margin:0;

    color:#2B140D;

    font-size:clamp(45px,6vw,82px);

    line-height:.98;

    font-weight:700;

    letter-spacing:-2px;

}


.titulo h1::first-line{
    color:#2B140D;
}


.titulo p{

    max-width:750px;

    margin:30px auto 0;

    color:#6d5d57;

    font-size:18px;

    line-height:1.7;

}


/* =====================================================
   CONTENEDOR DE INFORMACIÓN
===================================================== */

.info{

    position:relative;

    z-index:2;

    max-width:1200px;

    margin:auto;

    display:grid;

    grid-template-columns:1.2fr .8fr .8fr;

    gap:18px;

}


/* =====================================================
   TARJETAS
===================================================== */

.carta{

    position:relative;

    min-height:390px;

    padding:38px;

    border-radius:30px;

    background:#ffffff;

    border:1px solid rgba(43,20,13,.08);

    box-shadow:0 15px 45px rgba(43,20,13,.08);

    overflow:hidden;

    transition:.35s ease;

}


.carta:hover{

    transform:translateY(-10px);

    box-shadow:0 25px 55px rgba(43,20,13,.14);

}


/* =====================================================
   TARJETA DIRECCIÓN
===================================================== */

.carta:first-child{

    background:#2B140D;

    color:white;

    min-height:430px;

}


.carta:first-child::after{

    content:"01";

    position:absolute;

    right:-20px;

    bottom:-50px;

    font-size:180px;

    font-weight:700;

    color:rgba(255,255,255,.04);

}


.carta:first-child h2{

    color:white;

}


.carta:first-child p{

    color:#ded3cf;

}


/* =====================================================
   NUMERACIÓN
===================================================== */

.carta::before{

    content:"";

    display:block;

    width:42px;

    height:6px;

    border-radius:20px;

    background:#0ba84a;

    margin-bottom:35px;

}


.carta:nth-child(2)::after{

    content:"02";

    position:absolute;

    right:20px;

    bottom:-30px;

    font-size:120px;

    font-weight:700;

    color:rgba(43,20,13,.04);

}


.carta:nth-child(3)::after{

    content:"03";

    position:absolute;

    right:20px;

    bottom:-30px;

    font-size:120px;

    font-weight:700;

    color:rgba(43,20,13,.04);

}


/* =====================================================
   TÍTULOS
===================================================== */

.carta h2{

    position:relative;

    z-index:2;

    margin:0 0 25px;

    color:#2B140D;

    font-size:31px;

    font-weight:700;

    line-height:1.05;

}


/* =====================================================
   TEXTO
===================================================== */

.carta p{

    position:relative;

    z-index:2;

    margin:0 0 16px;

    color:#6d5d57;

    font-size:17px;

    line-height:1.7;

}


/* =====================================================
   CONTACTO
===================================================== */

.carta:nth-child(2){

    background:#ffffff;

}


.carta:nth-child(2) p:first-of-type{

    color:#0ba84a;

    font-size:29px;

    font-weight:700;

}


/* =====================================================
   CORREO
===================================================== */

.carta:nth-child(3){

    background:#E9F5EC;

}


.correo{

    display:inline-block;

    color:#2B140D;

    background:white;

    padding:10px 15px;

    border-radius:12px;

    font-size:16px !important;

    font-weight:600;

    word-break:break-word;

}


/* =====================================================
   EFECTO DECORATIVO
===================================================== */

.carta:nth-child(2)::before{

    background:#2B140D;

}


.carta:nth-child(3)::before{

    background:#0ba84a;

}


/* =====================================================
   RESPONSIVE
===================================================== */

@media(max-width:1000px){

    .contacto{

        padding:90px 5% 70px;

    }

    .info{

        grid-template-columns:1fr 1fr;

    }

    .carta:first-child{

        grid-column:span 2;

    }

}


@media(max-width:650px){

    .contacto{

        padding:70px 20px;

    }

    .titulo{

        margin-bottom:50px;

    }

    .titulo h1{

        font-size:48px;

    }

    .titulo p{

        font-size:16px;

    }

    .info{

        grid-template-columns:1fr;

    }

    .carta:first-child{

        grid-column:auto;

    }

    .carta{

        min-height:320px;

    }

}

</style>


<body>

<nav>
    <?php
    include("nav.php");
    ?>
</nav>


<section class="contacto">


    <!-- ================================================
         ENCABEZADO
    ================================================= -->

    <div class="titulo">

        <h4>VISÍTANOS</h4>

        <h1>
            Ven a conocer<br>
            Organic Zone
        </h1>

        <p>
            Estamos listos para recibirte. Encuentra nuestra ubicación,
            contáctanos o escríbenos para conocer más sobre nuestras
            hamburguesas gourmet elaboradas con ingredientes orgánicos.
        </p>

    </div>


    <!-- ================================================
         INFORMACIÓN
    ================================================= -->

    <div class="info">


        <!-- DIRECCIÓN -->

        <div class="carta">

            <h2>
                Encuéntranos
            </h2>

            <p>
                Colegio Pedro Poveda,
                Plazuela Tarija,
                Av. América,
                Cochabamba, Bolivia.
            </p>

            <p>
                Un espacio pensado para disfrutar
                de una experiencia diferente,
                saludable y deliciosa.
            </p>

        </div>


        <!-- CONTACTO -->

        <div class="carta">

            <h2>
                Hablemos
            </h2>

            <p>
                +591 70376053
            </p>

            <p>
                Llámanos para realizar consultas,
                conocer nuestros productos
                o coordinar una reserva.
            </p>

        </div>


        <!-- CORREO -->

        <div class="carta">

            <h2>
                Escríbenos
            </h2>

            <p class="correo">
                organiczone@gmail.com
            </p>

            <p>
                También puedes comunicarte
                con nosotros por correo.
                Estaremos encantados de atenderte.
            </p>

        </div>


    </div>

</section>