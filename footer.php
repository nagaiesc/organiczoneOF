
<style>
@import url('https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&display=swap');

.oz-footer {
    position: relative;
    width: 100%;
    margin-top: 70px;
    padding: 85px 7% 30px;
    background: #2B140D;
    color: #F4F1EE;
    font-family: 'Fredoka', Arial, sans-serif;
    overflow: hidden;
    border-radius: 100px 45px 0 0;
    box-sizing: border-box;
}

.oz-footer *,
.oz-footer *::before,
.oz-footer *::after {
    box-sizing: border-box;
}

.oz-footer::before,
.oz-footer::after {
    content: "";
    position: absolute;
    border-radius: 50%;
    pointer-events: none;
}

.oz-footer::before {
    width: 350px;
    height: 350px;
    right: -220px;
    top: -245px;
    border: 45px solid #472518;
}

.oz-footer::after {
    width: 240px;
    height: 240px;
    left: -175px;
    bottom: -185px;
    border: 32px solid #472518;
}

.oz-footer-contenedor {
    position: relative;
    z-index: 2;
    max-width: 1350px;
    margin: auto;
}

.oz-footer-top {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    gap: 50px;
    margin-bottom: 55px;
}

.oz-footer-etiqueta {
    display: inline-block;
    padding: 9px 18px;
    margin-bottom: 18px;
    border-radius: 50px;
    background: #FCD09F;
    color: #2B140D;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 2px;
}

.oz-footer-titulo {
    margin: 0;
    color: #F4F1EE;
    font-size: clamp(48px, 6vw, 82px);
    line-height: .98;
    font-weight: 700;
    letter-spacing: -3px;
}

.oz-footer-titulo span {
    color: #FCD09F;
}

.oz-footer-descripcion {
    max-width: 470px;
    margin: 0;
    color: #D5C3B9;
    font-size: 17px;
    line-height: 1.7;
}

.oz-footer-info {
    display: grid;
    grid-template-columns: 1.2fr .9fr .9fr;
    gap: 18px;
}

.oz-footer-card {
    position: relative;
    min-width: 0;
    min-height: 280px;
    padding: 32px;
    background: #30160F;
    border: 1px solid #492719;
    border-radius: 25px;
    overflow: hidden;
    transition: background .2s ease, border-color .2s ease;
}

.oz-footer-card:hover {
    background: #3A1C12;
    border-color: #67402B;
}

.oz-footer-card:first-child {
    background: #35190F;
    border-color: #56301D;
}

.oz-footer-card:first-child:hover {
    background: #402013;
}

.oz-footer-card::after {
    position: absolute;
    right: 12px;
    bottom: -28px;
    font-size: 115px;
    line-height: 1;
    font-weight: 700;
    color: #492719;
    pointer-events: none;
}

.oz-footer-card:nth-child(1)::after {
    content: "01";
}

.oz-footer-card:nth-child(2)::after {
    content: "02";
}

.oz-footer-card:nth-child(3)::after {
    content: "03";
}

/* ICONOS 2D */

.oz-footer-icon {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 58px;
    height: 58px;
    margin-bottom: 24px;
    background: #FCD09F;
    border-radius: 17px;
    color: #2B140D;
}

/* Ubicación */
.oz-icon-ubicacion::before {
    content: "";
    position: absolute;
    top: 14px;
    left: 19px;
    width: 20px;
    height: 20px;
    border: 4px solid #2B140D;
    border-radius: 50% 50% 50% 0;
    transform: rotate(-45deg);
}

.oz-icon-ubicacion::after {
    content: "";
    position: absolute;
    top: 21px;
    left: 26px;
    width: 6px;
    height: 6px;
    background: #2B140D;
    border-radius: 50%;
}

/* Teléfono */
.oz-icon-telefono::before {
    content: "";
    position: absolute;
    top: 13px;
    left: 19px;
    width: 20px;
    height: 32px;
    border: 3px solid #2B140D;
    border-radius: 5px;
}

.oz-icon-telefono::after {
    content: "";
    position: absolute;
    bottom: 18px;
    left: 27px;
    width: 5px;
    height: 3px;
    background: #2B140D;
    border-radius: 3px;
}

/* Correo */
.oz-icon-correo::before {
    content: "";
    position: absolute;
    top: 19px;
    left: 12px;
    width: 34px;
    height: 23px;
    border: 3px solid #2B140D;
    border-radius: 5px;
}

.oz-icon-correo::after {
    content: "";
    position: absolute;
    top: 15px;
    left: 19px;
    width: 20px;
    height: 20px;
    border-right: 3px solid #2B140D;
    border-bottom: 3px solid #2B140D;
    transform: rotate(45deg) scale(.72);
    border-radius: 2px;
}

.oz-footer-card h3 {
    position: relative;
    z-index: 2;
    margin: 0 0 14px;
    color: #F4F1EE;
    font-size: 27px;
    font-weight: 700;
}

.oz-footer-card p {
    position: relative;
    z-index: 2;
    margin: 0;
    color: #D5C3B9;
    font-size: 16px;
    line-height: 1.7;
}

.oz-footer-card:first-child p {
    color: #E8D8CD;
}

.oz-footer-telefono {
    display: block;
    margin: 0 0 10px !important;
    color: #FCD09F !important;
    font-size: 27px !important;
    font-weight: 700;
}

.oz-footer-correo {
    display: inline-block;
    max-width: 100%;
    padding: 9px 13px;
    background: #422417;
    border: 1px solid #593322;
    border-radius: 10px;
    color: #FCD09F !important;
    font-weight: 600;
    font-size: 15px !important;
    overflow-wrap: anywhere;
}

.oz-footer-bottom {
    position: relative;
    z-index: 2;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 30px;
    margin-top: 55px;
    padding-top: 25px;
    border-top: 1px solid #492719;
}

/* LOGO Y MARCA */

.oz-footer-logo {
    display: flex;
    align-items: center;
    gap: 15px;
    min-width: 0;
}

.oz-footer-logo-imagen {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    width: 68px;
    height: 68px;
}

.oz-footer-logo-imagen img {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.oz-footer-logo-marca {
    color: #F4F1EE;
    font-size: 30px;
    font-weight: 700;
    letter-spacing: -1px;
    white-space: nowrap;
}

.oz-footer-logo-marca span {
    color: #FCD09F;
}

.oz-footer-logo-linea {
    width: 2px;
    height: 35px;
    flex-shrink: 0;
    background: #68432F;
}

.oz-footer-logo-texto {
    color: #C2ACA0;
    font-size: 13px;
    line-height: 1.6;
}

.oz-footer-copy {
    color: #B59B8D;
    font-size: 13px;
    line-height: 1.8;
    text-align: right;
}

.oz-footer-copy strong {
    color: #FCD09F;
}

/* TABLET */

@media (max-width: 1050px) {
    .oz-footer-info {
        grid-template-columns: 1fr 1fr;
    }

    .oz-footer-card:first-child {
        grid-column: span 2;
    }

    .oz-footer-top {
        gap: 30px;
    }
}

/* CELULARES */

@media (max-width: 800px) {
    .oz-footer {
        padding: 65px 5% 28px;
        border-radius: 45px 45px 0 0;
    }

    .oz-footer-top {
        flex-direction: column;
        align-items: flex-start;
        gap: 25px;
        margin-bottom: 35px;
    }

    .oz-footer-titulo {
        font-size: clamp(43px, 9vw, 58px);
        letter-spacing: -2px;
    }

    .oz-footer-descripcion {
        font-size: 16px;
    }

    .oz-footer-info {
        grid-template-columns: 1fr;
        gap: 14px;
    }

    .oz-footer-card,
    .oz-footer-card:first-child {
        grid-column: auto;
        min-height: 230px;
        padding: 27px;
    }

    .oz-footer-bottom {
        flex-direction: column;
        align-items: flex-start;
        gap: 25px;
        margin-top: 35px;
    }

    .oz-footer-copy {
        text-align: left;
    }
}

@media (max-width: 500px) {
    .oz-footer {
        padding: 55px 20px 24px;
        border-radius: 32px 32px 0 0;
    }

    .oz-footer-titulo {
        font-size: 43px;
        letter-spacing: -1.5px;
    }

    .oz-footer-etiqueta {
        font-size: 11px;
    }

    .oz-footer-descripcion {
        font-size: 15px;
    }

    .oz-footer-card,
    .oz-footer-card:first-child {
        min-height: 220px;
        padding: 24px;
        border-radius: 21px;
    }

    .oz-footer-card h3 {
        font-size: 24px;
    }

    .oz-footer-card p {
        font-size: 15px;
    }

    .oz-footer-telefono {
        font-size: 23px !important;
    }

    .oz-footer-logo {
        display: grid;
        grid-template-columns: 58px minmax(0, 1fr);
        gap: 8px 12px;
        width: 100%;
    }

    .oz-footer-logo-imagen {
        width: 58px;
        height: 58px;
        grid-row: span 2;
    }

    .oz-footer-logo-marca {
        align-self: end;
        font-size: 27px;
    }

    .oz-footer-logo-linea {
        display: none;
    }

    .oz-footer-logo-texto {
        align-self: start;
        font-size: 12px;
    }

    .oz-footer-copy {
        font-size: 12px;
    }
}
</style>

<footer class="oz-footer">
    <div class="oz-footer-contenedor">

        <div class="oz-footer-top">
            <div>
                <span class="oz-footer-etiqueta">VISÍTANOS</span>

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

                <h3>Encuéntranos</h3>

                <p>
                    Colegio Pedro Poveda,
                    Plazuela Tarija,
                    Av. América,
                    Cochabamba, Bolivia.
                </p>
            </article>

            <article class="oz-footer-card">
                <div class="oz-footer-icon oz-icon-telefono"></div>

                <h3>Hablemos</h3>

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

                <h3>Escríbenos</h3>

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

                <div class="oz-footer-logo-imagen">
                    <img src="logoOz.png" alt="Logo de Organic Zone">
                </div>

                <div class="oz-footer-logo-marca">
                    Organic<span>Zone</span>
                </div>

                <div class="oz-footer-logo-linea"></div>

                <div class="oz-footer-logo-texto">
                    Sabor natural · Vida saludable
                </div>

            </div>

            <div class="oz-footer-copy">
                © 2026 Organic Zone · Cochabamba, Bolivia<br>
                Hecho con <strong>ingredientes orgánicos</strong>
            </div>

        </div>

    </div>
</footer>
