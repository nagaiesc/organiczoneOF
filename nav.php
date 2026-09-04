<?php

/* Evita iniciar la sesión dos veces */
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

?>

<style>

/* BARRA PRINCIPAL */

#barra {
    background: rgba(18, 163, 60, 0.90);

    position: fixed;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);

    width: 92%;
    max-width: 1350px;
    min-height: 68px;

    border-radius: 50px;

    display: flex;
    justify-content: space-between;
    align-items: center;

    padding: 0 25px;
    box-sizing: border-box;

    z-index: 1000;

    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);

    font-family: 'Fredoka', sans-serif;

    transition: 0.5s ease;
}


/*CAMBIO AL HACER SCROLL */

#barra.desliza {
    background: rgba(43, 20, 13, 0.96);

    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
}


/* LOGO */

#orga {
    text-decoration: none;
    color: white;

    display: flex;
    align-items: center;

    margin-left: 5px;
}

#orga h1 {
    margin: 0;

    font-size: 27px;
    font-weight: 700;

    letter-spacing: 0.5px;
}


#links {
    display: flex;

    flex-direction: row;

    align-items: center;
    justify-content: center;

    gap: 12px;
}


/* Cada elemento del menú */

.item {
    position: relative;
}


/* Botones principales */

.item > a {
    display: flex;

    align-items: center;

    gap: 8px;

    text-decoration: none;

    color: white;

    padding: 11px 18px;

    border-radius: 30px;

    background: rgba(255, 255, 255, 0.13);

    font-size: 17px;
    font-weight: 500;

    transition: 0.3s ease;
}


/* Efecto al pasar el mouse */

.item > a:hover {
    background: rgba(252, 208, 159, 0.90);

    color: #2B140D;

    transform: translateY(-2px);
}


.flecha {
    font-size: 11px;

    transition: 0.3s ease;
}


/* Girar flecha */

.item:hover .flecha {
    transform: rotate(90deg);
}

.submenu {
    position: absolute;

    top: calc(100% + 10px);
    left: 0;

    min-width: 190px;

    background: rgba(18, 163, 60, 0.96);

    backdrop-filter: blur(15px);
    -webkit-backdrop-filter: blur(15px);

    border-radius: 18px;

    overflow: hidden;

    max-height: 0;

    opacity: 0;

    transform: translateY(-8px);

    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.18);

    transition:
        max-height 0.4s ease,
        opacity 0.3s ease,
        transform 0.3s ease;
}


/* Mostrar submenú */

.item:hover .submenu {
    max-height: 300px;

    opacity: 1;

    transform: translateY(0);
}


/* Links del submenú */

.submenu a {
    display: block;

    text-decoration: none;

    color: white;

    padding: 13px 17px;

    font-size: 16px;

    font-weight: 500;

    transition: 0.25s ease;
}


/* Hover del submenú */

.submenu a:hover {
    background: #FCD09F;

    color: #2B140D;

    padding-left: 22px;
}


.zona-sesion {
    display: flex;

    align-items: center;

    gap: 10px;
}


/* Botón de sesión */

.boton-sesion {
    display: flex;

    align-items: center;

    justify-content: center;

    text-decoration: none;

    padding: 11px 20px;

    border-radius: 30px;

    font-family: 'Fredoka', sans-serif;

    font-size: 16px;

    font-weight: 600;

    transition: 0.3s ease;
}


/* ==============================
   INICIAR SESIÓN
============================== */

.boton-iniciar {
    background: #FCD09F;

    color: #2B140D;
}


.boton-iniciar:hover {
    background: white;

    transform: translateY(-2px);

    box-shadow: 0 5px 15px rgba(252, 208, 159, 0.35);
}


/* ==============================
   CERRAR SESIÓN
============================== */

.boton-cerrar {
    background: #2B140D;

    color: white;
}


.boton-cerrar:hover {
    background: #b83232;

    transform: translateY(-2px);

    box-shadow: 0 5px 15px rgba(184, 50, 50, 0.35);
}


@media (max-width: 900px) {

    #barra {
        width: 95%;

        padding: 0 15px;
    }

    #orga h1 {
        font-size: 22px;
    }

    #links {
        gap: 5px;
    }

    .item > a {
        padding: 9px 12px;

        font-size: 14px;
    }

    .boton-sesion {
        padding: 9px 13px;

        font-size: 14px;
    }
}


@media (max-width: 700px) {

    #barra {
        min-height: 60px;
    }

    #orga {
        display: none;
    }

    #barra {
        justify-content: center;
    }

    #links {
        gap: 4px;
    }

    .item > a {
        padding: 8px 10px;

        font-size: 13px;
    }

    .zona-sesion {
        display: none;
    }
    function Producto{
        
    }
}

</style>


<!-- BARRA DE NAVEGACIÓN -->

<nav id="barra">


    <!--  LOGO -->

    <div>
<a href="Cliente/vistacliente.php" id="orga">
    <h1>OrganicZone</h1>
</a>

    </div>


    <!--MENÚ PRINCIPAL -->

    <section id="links">


        <!-- NOSOTROS -->

        <div class="item">

            <a href="#">

                Nosotros

                <span class="flecha">
                    ▶
                </span>

            </a>


            <div class="submenu">

                <a href="/organiczoneOF/misionvision.php">

                    Misión y Visión

                </a>

            </div>

        </div>


        <!--  ABOUT US -->

        <div class="item">

            <a href="#">

                About Us

                <span class="flecha">
                    ▶
                </span>

            </a>


            <div class="submenu">

                <a href="/organiczoneOF/contacto.php">

                    Contacto

                </a>

            </div>

        </div>


        <!--   MENÚ -->

        <div class="item">
            <a href="Hamburguesas.php">
                Menú
            </a>
        </div>

        <div class="item">
            <a href="/organiczoneOF/Cliente/index.php">
                Comprar
            </a>
        </div>

    </section>


    <!-- BOTONES DE SESIÓN -->

    <section class="zona-sesion">

        <?php

        /* Si existe el nombre, significa que inició sesión */

        if (isset($_SESSION['nombre'])) {

        ?>

            <!--USUARIO CON SESIÓN -->

            <a
                href="/organiczoneOF/Usuarios/cerrarse.php"
                class="boton-sesion boton-cerrar"
            >

                Cerrar sesión

            </a>


        <?php

        } else {

        ?>


            <!-- USUARIO SIN SESIÓN -->

            <a
                href="/organiczoneOF/Usuarios/formulariosesion.php"
                class="boton-sesion boton-iniciar"
            >

                Iniciar sesión

            </a>


        <?php

        }

        ?>

    </section>
    <section>
       <button onclick="Producto()">Producto mas vendido</button>
    </section>


</nav>


<!--EFECTO AL HACER SCROLL -->

<script>

window.addEventListener("scroll", function () {

    const barra = document.getElementById("barra");

    if (window.scrollY > 50) {

        barra.classList.add("desliza");

    } else {

        barra.classList.remove("desliza");

    }

});

</script>