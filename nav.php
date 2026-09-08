<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

?>

<style>

:root {
    --verde: #12A33C;
    --verde-oscuro: #0A4A1B;
    --verde-claro: #EAF7EC;
    --cafe: #2B140D;
    --crema: #FCD09F;
    --blanco: #FFFFFF;
}

#barra {
    width: min(1280px, 92%);
    height: 76px;

    position: fixed;
    top: 22px;
    left: 50%;
    transform: translateX(-50%);

    padding: 0 22px 0 28px;

    display: flex;
    align-items: center;

    gap: 25px;

    background: rgba(18, 163, 60, .94);

    border-radius: 50px;

    box-shadow: 0 10px 28px rgba(18, 163, 60, .20);

    z-index: 1000;

    font-family: 'Nunito', sans-serif;

    transition:
        background .4s ease,
        box-shadow .4s ease,
        transform .4s ease;
}

#barra.desliza {
    background: rgba(43, 20, 13, .97);

    box-shadow:
        0 10px 28px rgba(43, 20, 13, .28);
}

#barra > div {
    width: 70px;
    min-width: 70px;

    height: 70px;

    display: flex;
    align-items: center;
    justify-content: center;
}

#orga {
    width: 62px;
    height: 62px;

    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;

    text-decoration: none;

    color: var(--blanco);

    line-height: .72;

    transition: .3s ease;
}

#orga:hover {
    transform: scale(1.06);
}

#orga h1 {
    margin: 0;

    display: flex;
    flex-direction: column;
    align-items: center;

    font-family: 'Fredoka', sans-serif;

    font-size: 0;

    line-height: .72;
}

#orga h1::before {
    content: "My";

    color: var(--blanco);

    font-size: 22px;

    font-weight: 600;

    letter-spacing: 1px;

    margin-bottom: 6px;
}

#orga h1::after {
    content: "Oz";

    color: var(--crema);

    font-size: 31px;

    font-weight: 700;

    letter-spacing: -1px;
}

#links {
    flex: 1;

    height: 100%;

    display: flex;
    align-items: center;
    justify-content: center;

    gap: 8px;
}

.item {
    position: relative;

    display: flex;
    align-items: center;

    height: 100%;
}

.item > a {
    height: 46px;

    display: flex;
    align-items: center;
    justify-content: center;

    gap: 8px;

    padding: 0 20px;

    background: rgba(255, 255, 255, .13);

    color: var(--blanco);

    text-decoration: none;

    border-radius: 50px;

    font-family: 'Nunito', sans-serif;

    font-size: 16px;

    font-weight: 800;

    white-space: nowrap;

    transition: .3s ease;
}

.item > a:hover {
    background: var(--crema);

    color: var(--cafe);

    transform: translateY(-2px);
}

.flecha {
    font-size: 10px;

    transition: .3s ease;
}

.item:hover .flecha {
    transform: rotate(90deg);
}

.submenu {
    position: absolute;

    top: 67px;
    left: 0;

    min-width: 205px;

    padding: 7px;

    background: rgba(18, 163, 60, .98);

    border-radius: 20px;

    box-shadow:
        0 12px 30px rgba(43, 20, 13, .22);

    opacity: 0;

    visibility: hidden;

    transform: translateY(-10px);

    transition:
        opacity .25s ease,
        visibility .25s ease,
        transform .25s ease;
}

.item:hover .submenu {
    opacity: 1;

    visibility: visible;

    transform: translateY(0);
}

.submenu a {
    display: block;

    padding: 13px 16px;

    color: white;

    text-decoration: none;

    border-radius: 15px;

    font-family: 'Nunito', sans-serif;

    font-size: 15px;

    font-weight: 700;

    transition: .25s ease;
}

.submenu a:hover {
    background: var(--crema);

    color: var(--cafe);

    padding-left: 21px;
}

.zona-sesion {
    display: flex;
    align-items: center;

    min-width: max-content;
}

.boton-sesion {
    height: 46px;

    display: flex;
    align-items: center;
    justify-content: center;

    padding: 0 21px;

    border-radius: 50px;

    text-decoration: none;

    font-family: 'Nunito', sans-serif;

    font-size: 15px;

    font-weight: 800;

    white-space: nowrap;

    transition: .3s ease;
}

.boton-iniciar {
    background: var(--crema);

    color: var(--cafe);
}

.boton-iniciar:hover {
    background: white;

    color: var(--cafe);

    transform: translateY(-2px);

    box-shadow:
        0 7px 17px rgba(252, 208, 159, .35);
}

.boton-cerrar {
    background: var(--cafe);

    color: white;
}

.boton-cerrar:hover {
    background: #b83232;

    color: white;

    transform: translateY(-2px);

    box-shadow:
        0 7px 17px rgba(184, 50, 50, .30);
}

.zonaProducto {
    display: flex;
    align-items: center;
    justify-content: center;

    min-width: max-content;
}

.botonProducto {
    height: 46px;

    display: flex;
    align-items: center;
    justify-content: center;

    padding: 0 21px;

    border: none;
    outline: none;

    border-radius: 50px;

    background: var(--crema);

    color: var(--cafe);

    font-family: 'Nunito', sans-serif;

    font-size: 15px;

    font-weight: 800;

    white-space: nowrap;

    cursor: pointer;

    transition: .3s ease;
}

.botonProducto:hover {
    background: white;

    transform: translateY(-2px);

    box-shadow:
        0 7px 17px rgba(252, 208, 159, .35);
}

.botonProducto:active {
    transform: scale(.97);
}

@media (max-width: 1200px) {

    #barra {
        width: 94%;

        gap: 15px;

        padding-left: 20px;
        padding-right: 18px;
    }

    #barra > div {
        width: 62px;
        min-width: 62px;
    }

    #orga h1::before {
        font-size: 19px;
    }

    #orga h1::after {
        font-size: 28px;
    }

    .item > a {
        padding: 0 15px;

        font-size: 15px;
    }

    .boton-sesion,
    .botonProducto {
        padding: 0 16px;

        font-size: 14px;
    }
}

@media (max-width: 1050px) {

    #barra {
        gap: 8px;

        padding-left: 15px;
        padding-right: 12px;
    }

    #links {
        gap: 3px;
    }

    .item > a {
        padding: 0 11px;

        font-size: 13px;
    }

    .boton-sesion,
    .botonProducto {
        padding: 0 12px;

        font-size: 13px;
    }
}

@media (max-width: 850px) {

    #barra {
        height: 70px;

        border-radius: 50px;
    }

    #barra > div {
        width: 55px;
        min-width: 55px;
    }

    #orga {
        width: 50px;
        height: 58px;
    }

    #orga h1::before {
        font-size: 16px;
    }

    #orga h1::after {
        font-size: 24px;
    }

    .item > a {
        height: 43px;

        padding: 0 9px;

        font-size: 12px;
    }

    .boton-sesion,
    .botonProducto {
        height: 43px;

        padding: 0 10px;

        font-size: 12px;
    }
}

@media (max-width: 700px) {

    #barra {
        width: 94%;

        height: 64px;

        padding: 0 10px;

        gap: 5px;
    }

    #barra > div {
        display: none;
    }

    #links {
        gap: 3px;
    }

    .item > a {
        height: 42px;

        padding: 0 10px;

        font-size: 12px;
    }

    .flecha {
        display: none;
    }

    .zona-sesion {
        display: none;
    }

    .botonProducto {
        height: 42px;

        padding: 0 11px;

        font-size: 11px;
    }
}

@media (max-width: 500px) {

    #barra {
        width: 94%;

        height: 60px;

        justify-content: center;

        border-radius: 50px;
    }

    #links {
        width: 100%;

        justify-content: center;
    }

    .item > a {
        height: 40px;

        padding: 0 8px;

        font-size: 10px;
    }

    .zonaProducto {
        display: none;
    }

    .submenu {
        top: 57px;

        min-width: 175px;
    }

    .submenu a {
        font-size: 13px;
    }
}

</style>

<nav id="barra">

    <div>

        <a href="Cliente/vistacliente.php" id="orga">

            <h1>OrganicZone</h1>

        </a>

    </div>

    <section id="links">

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

    <section class="zona-sesion">

        <?php if (isset($_SESSION['nombre'])): ?>

            <a
                href="/organiczoneOF/Usuarios/cerrarse.php"
                class="boton-sesion boton-cerrar"
            >
                Cerrar sesión
            </a>

        <?php else: ?>

            <a
                href="/organiczoneOF/Usuarios/formulariosesion.php"
                class="boton-sesion boton-iniciar"
            >
                Iniciar sesión
            </a>

        <?php endif; ?>

    </section>

    <section class="zonaProducto">

        <button
            class="botonProducto"
            onclick="window.location.href='productoBest.php'"
        >
            Producto más vendido
        </button>

    </section>

</nav>

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