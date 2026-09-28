<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$rol = $_SESSION['rol'] ?? '';

$paginaActual = basename($_SERVER['PHP_SELF']);

$inicioRol = '';
$textoInicioRol = '';

if ($rol === 'admin' && $paginaActual !== 'vistaadmin.php') {
    $inicioRol = '/organiczoneOF/vistaadmin.php';
    $textoInicioRol = 'Volver a Admin';
}

if ($rol === 'vendedor' && $paginaActual !== 'vistavendedor.php') {
    $inicioRol = '/organiczoneOF/Usuarios/vistavendedor.php';
    $textoInicioRol = 'Volver a Vendedor';
}

?>

<style>

@import url('https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&display=swap');

:root {
    --verde: #12A33C;
    --verde-oscuro: #0A4A1B;
    --verde-claro: #EAF7EC;
    --cafe: #2B140D;
    --cafe-hover: #432116;
    --crema: #FCD09F;
    --blanco: #FFFFFF;
}

* {
    box-sizing: border-box;
}


/* =========================================================
   NAV PRINCIPAL
   ========================================================= */

#barra {
    width: min(1250px, 94%);
    min-height: 72px;

    position: fixed;
    top: 20px;
    left: 50%;

    transform: translateX(-50%);

    padding: 0 18px;

    display: flex;
    align-items: center;

    gap: 12px;

    background: rgba(18, 163, 60, 0.96);

    border-radius: 40px;

    box-shadow: 0 10px 28px rgba(18, 163, 60, 0.20);

    z-index: 1000;

    font-family: 'Fredoka', sans-serif;
}


/* =========================================================
   LOGO
   ========================================================= */

#barra > div:first-child {
    width: 65px;
    min-width: 65px;
    height: 65px;

    display: flex;
    align-items: center;
    justify-content: center;

    margin-right: 5px;
}

#orga {
    width: 65px;
    height: 65px;

    display: flex;
    align-items: center;
    justify-content: center;

    text-decoration: none;
}

#orga h1 {
    margin: 0;
    padding: 0;

    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;

    font-family: 'Fredoka', sans-serif;
    font-size: 0;
    line-height: 0.75;
    white-space: nowrap;
}

#orga h1::before {
    content: "My";
    color: var(--blanco);
    font-family: 'Fredoka', sans-serif;
    font-size: 15px;
    font-weight: 600;
    letter-spacing: 0.5px;
    margin-bottom: 1px;
}

#orga h1::after {
    content: "Oz";
    color: var(--crema);
    font-family: 'Fredoka', sans-serif;
    font-size: 32px;
    font-weight: 700;
    letter-spacing: -1px;
    line-height: 0.8;
    margin-top: 0.5px;
}


/* =========================================================
   LINKS PRINCIPALES
   ========================================================= */

#links {
    display: flex;
    align-items: center;
    gap: 6px;
    height: 100%;
    flex: 1;
    min-width: 0;
}

.item {
    position: relative;
    height: 100%;
    display: flex;
    align-items: center;
    padding-bottom: 4px;
}

.item > a {
    height: 44px;

    display: flex;
    align-items: center;
    justify-content: center;

    padding: 0 15px;

    color: var(--blanco);
    text-decoration: none;

    border-radius: 22px;

    font-family: 'Fredoka', sans-serif;
    font-size: 15px;
    font-weight: 600;
    white-space: nowrap;

    transition: background 0.2s ease, transform 0.2s ease;
}

.item > a:hover {
    background: rgba(255, 255, 255, 0.15);
}


/* =========================================================
   SUBMENÚ
   ========================================================= */

.submenu {
    position: absolute;

    top: 54px;
    left: 50%;

    transform: translateX(-50%);

    min-width: 190px;
    padding: 9px;

    display: flex;
    flex-direction: column;
    gap: 5px;

    background: var(--blanco);
    border: 2px solid rgba(252, 208, 159, 0.75);
    border-radius: 22px;

    opacity: 0;
    visibility: hidden;
    pointer-events: none;

    transition: opacity 0.18s ease, visibility 0.18s ease;

    z-index: 2000;
}

/* Puente invisible entre botón y submenú */
.submenu::before {
    content: "";
    position: absolute;
    top: -14px;
    left: 0;
    width: 100%;
    height: 16px;
    background: transparent;
}

/* Mantener submenú abierto */
.item:hover .submenu,
.item:focus-within .submenu,
.submenu:hover {
    opacity: 1;
    visibility: visible;
    pointer-events: auto;
    transform: translateX(-50%);
}

.submenu a {
    width: 100%;
    min-height: 42px;

    display: flex;
    align-items: center;
    justify-content: center;

    padding: 9px 14px;

    color: var(--cafe);
    background: transparent;
    border-radius: 16px;
    text-decoration: none;

    font-family: 'Fredoka', sans-serif;
    font-size: 14px;
    font-weight: 500;
    white-space: nowrap;

    transition: background 0.2s ease, color 0.2s ease;
}

.submenu a:hover {
    color: var(--blanco);
    background: var(--verde);
}


/* =========================================================
   ZONA DE SESIÓN
   ========================================================= */

.zona-sesion {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    flex-shrink: 0;
    padding-left: 10px;
    padding-right: 2px;
}

.boton-inicio-rol {
    height: 44px;

    display: flex;
    align-items: center;
    justify-content: center;

    padding: 0 18px;

    border-radius: 22px;

    color: var(--crema);
    background: var(--cafe);

    text-decoration: none;

    font-family: 'Fredoka', sans-serif;
    font-size: 14px;
    font-weight: 600;
    white-space: nowrap;

    transition: background 0.2s ease, color 0.2s ease, transform 0.2s ease;
}

.boton-inicio-rol:hover {
    background: var(--cafe-hover);
    color: var(--blanco);
    transform: translateY(-1px);
}

.boton-sesion {
    height: 44px;

    display: flex;
    align-items: center;
    justify-content: center;

    padding: 0 17px;

    border-radius: 22px;
    text-decoration: none;

    font-family: 'Fredoka', sans-serif;
    font-size: 14px;
    font-weight: 600;
    white-space: nowrap;

    transition: background 0.2s ease, transform 0.2s ease;
}

.boton-iniciar,
.boton-cerrar {
    color: var(--cafe);
    background: var(--crema);
}

.boton-iniciar:hover,
.boton-cerrar:hover {
    background: var(--blanco);
    transform: translateY(-1px);
}


/* =========================================================
   PRODUCTO MÁS VENDIDO / MEJOR CLIENTE
   ========================================================= */

.zonaProducto {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    margin-left: 4px;
}

.botonProducto,
.botonUsuario {
    height: 44px;

    display: flex;
    align-items: center;
    justify-content: center;

    padding: 0 16px;

    border: none;
    border-radius: 22px;

    color: var(--blanco);
    background: var(--cafe);

    font-family: 'Fredoka', sans-serif;
    font-size: 14px;
    font-weight: 600;
    white-space: nowrap;

    cursor: pointer;
    text-decoration: none;

    transition: background 0.2s ease, transform 0.2s ease;
}

.botonProducto:hover,
.botonUsuario:hover {
    background: var(--cafe-hover);
    transform: translateY(-1px);
}

.botonUsuario {
    flex-shrink: 0;
    margin-left: 1px;
}


/* =========================================================
   TABLET
   ========================================================= */

@media (max-width: 1150px) {

    #barra {
        width: 96%;
        gap: 7px;
        padding: 0 12px;
    }

    #barra > div:first-child {
        width: 58px;
        min-width: 58px;
    }

    #orga {
        width: 58px;
    }

    #links {
        gap: 2px;
    }

    .item > a {
        padding: 0 10px;
        font-size: 14px;
    }

    .zona-sesion {
        gap: 7px;
        padding-left: 4px;
    }

    .boton-sesion,
    .boton-inicio-rol,
    .botonProducto,
    .botonUsuario {
        padding: 0 11px;
        font-size: 13px;
    }
}


/* =========================================================
   CONTENEDOR DEL MENÚ DESPLEGABLE (3 PUNTITOS)
   En escritorio no afecta el diseño (display: contents)
   ========================================================= */

#menu-extra {
    display: contents;
}

#btn-mas {
    display: none;
}


/* =========================================================
   CELULAR / PANTALLAS PEQUEÑAS
   Una sola fila: Logo | Nosotros | About Us | Menú | Comprar | ⋮
   Los 3 puntitos despliegan: sesión, producto más vendido y mejor cliente
   ========================================================= */

@media (max-width: 900px) {

    #barra {
        width: calc(100% - 16px);
        top: 8px;

        min-height: 60px;

        padding: 0 10px;
        gap: 4px;

        border-radius: 30px;

        flex-wrap: nowrap;
    }

    /* Logo */
    #barra > div:first-child {
        width: 50px;
        min-width: 50px;
        height: 52px;
        margin-right: 0;
    }

    #orga {
        width: 50px;
        height: 52px;
    }

    #orga h1::before {
        font-size: 12px;
    }

    #orga h1::after {
        font-size: 26px;
    }

    /* Links dentro del nav, en una sola fila */
    #links {
        flex: 1;
        min-width: 0;

        height: auto;

        justify-content: space-evenly;
        gap: 0;
    }

    .item {
        height: auto;
        padding-bottom: 0;
    }

    .item > a {
        height: 36px;
        padding: 0 8px;
        font-size: 13px;
    }

    /* Submenús se abren debajo del botón */
    .submenu {
        top: 46px;
        left: 0;
        transform: none;
        min-width: 165px;
    }

    .item:hover .submenu,
    .item:focus-within .submenu,
    .submenu:hover {
        transform: none;
    }

    .submenu a {
        min-height: 40px;
        font-size: 13px;
    }

    /* Botón de 3 puntitos */
    #btn-mas {
        width: 38px;
        min-width: 38px;
        height: 38px;

        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;

        gap: 4px;

        padding: 0;

        border: none;
        border-radius: 50%;

        background: var(--cafe);

        cursor: pointer;

        flex-shrink: 0;

        transition: background 0.2s ease;
    }

    #btn-mas:hover,
    #btn-mas[aria-expanded="true"] {
        background: var(--cafe-hover);
    }

    #btn-mas span {
        width: 4px;
        height: 4px;

        border-radius: 50%;

        background: var(--crema);
    }

    /* Panel desplegable */
    #menu-extra {
        position: absolute;

        top: calc(100% + 8px);
        right: 0;

        width: min(260px, 100%);

        padding: 10px;

        display: flex;
        flex-direction: column;

        gap: 8px;

        background: var(--blanco);

        border: 2px solid rgba(252, 208, 159, 0.75);
        border-radius: 22px;

        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.18);

        opacity: 0;
        visibility: hidden;
        pointer-events: none;

        transform: translateY(-6px);

        transition:
            opacity 0.2s ease,
            visibility 0.2s ease,
            transform 0.2s ease;

        z-index: 2000;
    }

    #menu-extra.abierto {
        opacity: 1;
        visibility: visible;
        pointer-events: auto;

        transform: translateY(0);
    }

    #menu-extra .zona-sesion,
    #menu-extra .zonaProducto {
        width: 100%;

        flex-direction: column;
        align-items: stretch;

        gap: 8px;

        padding: 0;
        margin: 0;
    }

    #menu-extra .boton-sesion,
    #menu-extra .boton-inicio-rol,
    #menu-extra .botonProducto,
    #menu-extra .botonUsuario {
        width: 100%;
        height: 42px;

        margin: 0;
        padding: 0 14px;

        font-size: 14px;
    }
}


/* =========================================================
   CELULARES MUY ANGOSTOS
   ========================================================= */

@media (max-width: 380px) {

    #barra {
        width: calc(100% - 10px);
        top: 5px;
        padding: 0 7px;
    }

    #barra > div:first-child,
    #orga {
        width: 44px;
        min-width: 44px;
    }

    #orga h1::after {
        font-size: 23px;
    }

    .item > a {
        padding: 0 5px;
        font-size: 12px;
    }

    #btn-mas {
        width: 34px;
        min-width: 34px;
        height: 34px;
    }
}

</style>


<nav id="barra">


    <!-- LOGO -->

    <div>

        <a
            href="/organiczoneOF/paginaprincipal.php"
            id="orga"
        >

            <h1>OrganicZone</h1>

        </a>

    </div>


    <!-- LINKS -->

    <section id="links">


        <!-- NOSOTROS -->

        <div class="item">

            <a href="#">

                Nosotros

            </a>

            <div class="submenu">

                <a href="/organiczoneOF/misionvision.php">

                    Misión y Visión

                </a>

            </div>

        </div>


        <!-- ABOUT US -->

        <div class="item">

            <a href="#">

                About Us

            </a>

            <div class="submenu">

                <a href="/organiczoneOF/contacto.php">

                    Contacto

                </a>

            </div>

        </div>


        <!-- MENÚ -->

        <div class="item">

            <a href="/organiczoneOF/Hamburguesas.php">

                Menú

            </a>

        </div>


        <!-- COMPRAR -->

        <div class="item">

            <a href="/organiczoneOF/Cliente/index.php">

                Comprar

            </a>

        </div>


    </section>


    <!-- BOTÓN 3 PUNTITOS (solo celular) -->

    <button
        type="button"
        id="btn-mas"
        aria-label="Más opciones"
        aria-expanded="false"
        aria-controls="menu-extra"
    >
        <span></span>
        <span></span>
        <span></span>
    </button>


    <!-- MENÚ DESPLEGABLE: sesión, producto más vendido y mejor cliente -->

    <div id="menu-extra">


    <!-- SESIÓN -->

    <section class="zona-sesion">


        <?php if ($inicioRol !== ''): ?>

            <a
                href="<?php echo $inicioRol; ?>"
                class="boton-inicio-rol"
            >

                <?php echo $textoInicioRol; ?>

            </a>

        <?php endif; ?>


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


    <!-- PRODUCTO MÁS VENDIDO -->

    <section class="zonaProducto">

        <button
            class="botonProducto"
            onclick="window.location.href='/organiczoneOF/productoBest.php'"
        >

            Producto más vendido

        </button>

    </section>


    <!-- MEJOR CLIENTE -->

    <button
        class="botonUsuario"
        onclick="window.location.href='/organiczoneOF/usuarioBest.php'"
    >

        Mejor cliente

    </button>


    </div>


</nav>


<script>
(function () {
    var btn  = document.getElementById('btn-mas');
    var menu = document.getElementById('menu-extra');

    if (!btn || !menu) return;

    function cerrar() {
        menu.classList.remove('abierto');
        btn.setAttribute('aria-expanded', 'false');
    }

    btn.addEventListener('click', function (e) {
        e.stopPropagation();
        var abierto = menu.classList.toggle('abierto');
        btn.setAttribute('aria-expanded', abierto ? 'true' : 'false');
    });

    document.addEventListener('click', function (e) {
        if (!menu.contains(e.target) && e.target !== btn) cerrar();
    });

    window.addEventListener('resize', function () {
        if (window.innerWidth > 900) cerrar();
    });
})();
</script>