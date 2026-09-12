<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

/* =========================================================
   BOTÓN VOLVER SEGÚN EL ROL
   ========================================================= */

$rol = $_SESSION['rol'] ?? '';

$paginaActual = basename($_SERVER['PHP_SELF']);

$inicioRol = '';
$textoInicioRol = '';

if ($rol === 'admin' && $paginaActual !== 'vistaadmin.php') {

    $inicioRol = '/organiczoneOF/vistaadmin.php';
    $textoInicioRol = '← Volver a Admin';

}

if ($rol === 'vendedor' && $paginaActual !== 'vistavendedor.php') {

    $inicioRol = '/organiczoneOF/Usuarios/vistavendedor.php';
    $textoInicioRol = '← Volver a Vendedor';

}

?>

<style>

@import url('https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&display=swap');

:root {
    --verde: #12A33C;
    --verde-oscuro: #0A4A1B;
    --verde-claro: #EAF7EC;
    --cafe: #2B140D;
    --crema: #FCD09F;
    --blanco: #FFFFFF;
}

* {
    box-sizing: border-box;
}

#barra {
    width: min(1080px, 90%);
    height: 72px;
    position: fixed;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    padding: 0 14px 0 16px;
    display: flex;
    align-items: center;
    gap: 8px;
    background: rgba(18, 163, 60, 0.96);
    border-radius: 40px;
    box-shadow: 0 10px 28px rgba(18, 163, 60, 0.20);
    z-index: 1000;
    font-family: 'Fredoka', sans-serif;
}

#barra > div:first-child {
    width: 62px;
    min-width: 62px;
    height: 62px;
    display: flex;
    align-items: center;
    justify-content: center;
}

#orga {
    width: 62px;
    height: 62px;
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
    margin-top: 0.5px;
    content: "Oz";
    color: var(--crema);
    font-family: 'Fredoka', sans-serif;
    font-size: 32px;
    font-weight: 700;
    letter-spacing: -1px;
    line-height: 0.8;
}

#links {
    display: flex;
    align-items: center;
    gap: 4px;
    height: 100%;
    flex: 1;
}

.item {
    position: relative;
    height: 100%;
    display: flex;
    align-items: center;
}

.item > a {
    height: 42px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    padding: 0 13px;
    color: var(--blanco);
    text-decoration: none;
    border-radius: 22px;
    font-family: 'Fredoka', sans-serif;
    font-size: 15px;
    font-weight: 600;
    white-space: nowrap;
    transition: all 0.2s ease;
}

.item > a:hover {
    background: rgba(255, 255, 255, 0.16);
}

.flecha {
    font-size: 9px;
    transition: transform 0.2s ease;
}

.item:hover > a .flecha {
    transform: rotate(90deg);
}

.submenu {
    position: absolute;
    top: 57px;
    left: 50%;
    transform: translate(-50%, -8px);
    min-width: 190px;
    padding: 7px;
    display: flex;
    flex-direction: column;
    gap: 5px;
    background: var(--blanco);
    border: 2px solid rgba(252, 208, 159, 0.75);
    border-radius: 24px;
    box-shadow: 0 12px 30px rgba(43, 20, 13, 0.20);
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
    transition:
        opacity 0.22s ease,
        visibility 0.22s ease,
        transform 0.22s ease;
    z-index: 2000;
}

.item:hover .submenu,
.submenu:hover {
    opacity: 1;
    visibility: visible;
    pointer-events: auto;
    transform: translate(-50%, 0);
}

.submenu::after {
    content: "";
    position: absolute;
    top: -12px;
    left: 0;
    right: 0;
    height: 14px;
    background: transparent;
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
    border-radius: 18px;
    text-decoration: none;
    font-family: 'Fredoka', sans-serif;
    font-size: 14px;
    font-weight: 500;
    white-space: nowrap;
    transition: all 0.2s ease;
}

.submenu a:hover {
    color: var(--blanco);
    background: var(--verde);
    transform: scale(1.02);
}

.zona-sesion {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: auto;
}

.boton-sesion  {
    height: 42px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0 14px;
    border-radius: 22px;
    text-decoration: none;
    font-family: 'Fredoka', sans-serif;
    font-size: 14px;
    font-weight: 600;
    white-space: nowrap;
    transition: all 0.2s ease;
}

.boton-iniciar {
    color: var(--cafe);
    background: var(--crema);
}

.boton-iniciar:hover {
    background: var(--blanco);
    transform: translateY(-1px);
}

.boton-cerrar {
    color: var(--cafe);
    background: var(--crema);
}

.boton-cerrar:hover {
    background: var(--blanco);
    transform: translateY(-1px);
}

.zonaProducto {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: auto;
}

.botonProducto
{
    height: 42px;
    padding: 0 14px;
    border: none;
    border-radius: 22px;
    color: var(--blanco);
    background: var(--cafe);
    font-family: 'Fredoka', sans-serif;
    font-size: 14px;
    font-weight: 500;
    white-space: nowrap;
    cursor: pointer;
}

.botonProducto:hover{
    background: #432116;
    transform: translateY(-1px);
}


/* =========================================================
   ÚNICAMENTE AGREGADO:
   BOTÓN VOLVER A ADMIN / VENDEDOR
   ========================================================= */

.boton-inicio-rol {
    height: 42px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0 14px;
    border-radius: 22px;
    color: var(--crema);
    background: var(--cafe);
    text-decoration: none;
    font-family: 'Fredoka', sans-serif;
    font-size: 14px;
    font-weight: 600;
    white-space: nowrap;
    transition: all 0.2s ease;
}

.boton-inicio-rol:hover {
    background: #432116;
    color: var(--blanco);
    transform: translateY(-1px);
}


/* =========================================================
   LO DEMÁS SE QUEDA IGUAL
   ========================================================= */

@media (max-width: 950px) {

    #barra {
        width: 94%;
        gap: 5px;
        padding: 0 10px;
    }

    #links {
        gap: 2px;
    }

    .item > a {
        padding: 0 9px;
        font-size: 14px;
    }

    .boton-sesion,
    .botonProducto{
        padding: 0 10px;
        font-size: 13px;
    }

}

@media (max-width: 760px) {

    #barra {
        height: auto;
        min-height: 68px;
        padding: 8px 10px;
        border-radius: 30px;
        flex-wrap: wrap;
    }

    #barra > div:first-child {
        height: 52px;
        width: 55px;
        min-width: 55px;
    }

    #orga {
        width: 55px;
        height: 52px;
    }

    #orga h1::before {
        font-size: 12px;
    }

    #orga h1::after {
        font-size: 27px;
    }

    #links {
        height: 52px;
        overflow-x: auto;
    }

    .item > a {
        height: 38px;
        font-size: 13px;
        padding: 0 9px;
    }

    .boton-sesion,
    .botonProducto {
        height: 38px;
        font-size: 12px;
        padding: 0 9px;
    }

    .submenu {
        top: 49px;
    }

}

</style>

<nav id="barra">

<div>

    <a href="/organiczoneOF/paginaprincipal.php" id="orga">

        <h1>OrganicZone</h1>

    </a>

</div>

<section id="links">

    <div class="item">

        <a href="#">

            Nosotros

            <span class="flecha">▶</span>

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

            <span class="flecha">▶</span>

        </a>

        <div class="submenu">

            <a href="/organiczoneOF/contacto.php">
                Contacto
            </a>

        </div>

    </div>

    <div class="item">

        <a href="/organiczoneOF/Hamburguesas.php">
            Menú
        </a>

    </div>

    <div class="item">

        <a href="/organiczoneOF/Cliente/index.php">
            Comprar
        </a>

    </div>

</section>


<!-- =====================================================
     SESIÓN
     ===================================================== -->

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


<section class="zonaProducto">

    <button
        class="botonProducto"
        onclick="window.location.href='/organiczoneOF/productoBest.php'"
    >
        Producto más vendido
    </button>

</section class="zonaUsuario">

<button 
class="botonUsuario"
onclick="window.location.href='/organiczoneOF/usuarioBest.php'">
Mejor cliente
</button>

<section>

</section>

</nav>