<!DOCTYPE html>

<html lang="es">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0"

>

<title>Organic Zone | Comentarios</title>

<link rel="preconnect" href="https://fonts.googleapis.com">

<link
    rel="preconnect"
    href="https://fonts.gstatic.com"
    crossorigin
>

<link
    href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Nunito:wght@400;500;600;700;800&display=swap"
    rel="stylesheet"
>

<style>

:root {
    --verde: #0BA84A;
    --verde-oscuro: #087F38;
    --verde-claro: #EAF7EC;
    --cafe: #2B140D;
    --crema: #FCD09F;
    --blanco: #FFFFFF;
    --gris: #6F625D;
}

* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

html,
body {
    min-height: 100%;
}

body {
    min-height: 100vh;
    background: var(--verde-claro);
    font-family: 'Nunito', Arial, sans-serif;
    color: var(--cafe);
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 35px 20px;
    position: relative;
    overflow-x: hidden;
}

body::before {
    content: "";
    position: fixed;
    width: 420px;
    height: 420px;
    background: var(--verde);
    border-radius: 50%;
    top: -250px;
    left: -180px;
    opacity: .12;
}

body::after {
    content: "";
    position: fixed;
    width: 480px;
    height: 480px;
    background: var(--crema);
    border-radius: 50%;
    bottom: -300px;
    right: -220px;
    opacity: .45;
}

.formulario-contenedor {
    width: 100%;
    max-width: 1050px;
    min-height: 610px;
    background: var(--blanco);
    border-radius: 45px;
    overflow: hidden;
    display: grid;
    grid-template-columns: 40% 60%;
    position: relative;
    z-index: 2;
    box-shadow: 0 20px 55px rgba(43, 20, 13, .16);
}

.panel-lateral {
    background: var(--cafe);
    color: white;
    padding: 50px 42px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    position: relative;
    overflow: hidden;
}

.panel-lateral::before {
    content: "";
    position: absolute;
    width: 260px;
    height: 260px;
    border-radius: 50%;
    background: var(--verde);
    opacity: .16;
    top: -120px;
    right: -100px;
}

.panel-lateral::after {
    content: "";
    position: absolute;
    width: 190px;
    height: 190px;
    border-radius: 50%;
    background: var(--crema);
    opacity: .10;
    bottom: -80px;
    left: -70px;
}

.marca {
    position: relative;
    z-index: 2;
    
    font-family: 'Fredoka', sans-serif;
    line-height: .7;
    margin-bottom: 35px;
}

.marca .my {
    display: block;
    color: white;
    font-size: 27px;
    font-weight: 600;
    letter-spacing: 1px;
    margin-bottom: 5px;
}

.marca .oz {
    display: block;
    color: var(--crema);
    font-size: 52px;
    font-weight: 700;
    letter-spacing: -2px;
}

.panel-contenido {
    position: relative;
    z-index: 2;
}

.etiqueta {
    color: var(--crema);
    font-family: 'Fredoka', sans-serif;
    font-size: 13px;
    font-weight: 700;
    letter-spacing: 2px;
    margin-bottom: 15px;
}

.panel-lateral h1 {
    font-family: 'Fredoka', sans-serif;
    font-size: 45px;
    line-height: .98;
    font-weight: 700;
    margin-bottom: 22px;
}

.panel-lateral h1 span {
    color: var(--verde);
}

.panel-lateral p {
    color: #d9d0cc;
    font-size: 15px;
    line-height: 1.7;
    max-width: 290px;
}

.decoracion {
    position: relative;
    z-index: 2;
    display: flex;
    gap: 8px;
    align-items: center;
}

.decoracion span {
    display: block;
    width: 38px;
    height: 8px;
    border-radius: 50px;
    background: var(--verde);
}

.decoracion span:nth-child(2) {
    width: 18px;
    background: var(--crema);
}

.formulario {
    padding: 55px 60px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.encabezado-formulario {
    margin-bottom: 30px;
}

.encabezado-formulario .mini-titulo {
    color: var(--verde);
    font-family: 'Fredoka', sans-serif;
    font-size: 13px;
    font-weight: 700;
    letter-spacing: 2px;
    margin-bottom: 7px;
}

.encabezado-formulario h2 {
    color: var(--cafe);
    font-family: 'Fredoka', sans-serif;
    font-size: 34px;
    font-weight: 700;
    margin-bottom: 8px;
}

.encabezado-formulario p {
    color: var(--gris);
    font-size: 14px;
    line-height: 1.5;
}

.campo {
    display: flex;
    flex-direction: column;
    margin-bottom: 21px;
}

.campo label {
    color: var(--cafe);
    font-family: 'Fredoka', sans-serif;
    font-size: 15px;
    font-weight: 600;
    margin-bottom: 9px;
}

.campo label::after {
    content: " ✦";
    color: var(--verde);
    font-size: 11px;
}

input[type="text"],
textarea {
    width: 100%;
    border: 2px solid #E8E1DC;
    border-radius: 18px;
    background: #FAFDFC;
    color: var(--cafe);
    font-family: 'Nunito', sans-serif;
    font-size: 15px;
    outline: none;
    transition: .25s ease;
}

input[type="text"] {
    height: 52px;
    padding: 0 18px;
}

textarea {
    min-height: 145px;
    padding: 15px 18px;
    resize: vertical;
    line-height: 1.5;
}

input[type="text"]::placeholder,
textarea::placeholder {
    color: #A59B96;
}

input[type="text"]:focus,
textarea:focus {
    border-color: var(--verde);
    background: white;
    box-shadow: 0 0 0 4px rgba(11,168,74,.10);
}

.botones {
    display: flex;
    gap: 12px;
    margin-top: 4px;
}

input[type="submit"],
input[type="reset"] {
    height: 50px;
    border-radius: 50px;
    font-family: 'Fredoka', sans-serif;
    font-size: 15px;
    font-weight: 700;
    cursor: pointer;
    transition: .25s ease;
}

input[type="submit"] {
    flex: 1;
    border: none;
    background: var(--verde);
    color: white;
    box-shadow: 0 7px 18px rgba(11,168,74,.22);
}

input[type="submit"]:hover {
    background: var(--cafe);
    transform: translateY(-2px);
    box-shadow: 0 9px 20px rgba(43,20,13,.20);
}

input[type="reset"] {
    width: 125px;
    border: 2px solid #E6DDD7;
    background: white;
    color: var(--cafe);
}

input[type="reset"]:hover {
    background: var(--crema);
    border-color: var(--crema);
    transform: translateY(-2px);
}

.regresar {
    position: fixed;
    top: 24px;
    left: 25px;
    z-index: 10;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 11px 19px;
    border-radius: 50px;
    background: var(--cafe);
    color: white;
    text-decoration: none;
    font-family: 'Fredoka', sans-serif;
    font-size: 14px;
    font-weight: 600;
    box-shadow: 0 7px 18px rgba(43,20,13,.16);
    transition: .25s ease;
}

.regresar:hover {
    background: var(--verde);
    transform: translateY(-2px);
}

@media (max-width: 850px) {

    body {
        padding: 80px 18px 25px;
    }

    .formulario-contenedor {
        grid-template-columns: 1fr;
        max-width: 620px;
    }

    .panel-lateral {
        min-height: 330px;
        padding: 35px;
    }

    .panel-lateral h1 {
        font-size: 38px;
    }

    .formulario {
        padding: 40px 35px;
    }

}

@media (max-width: 500px) {

    .regresar {
        top: 15px;
        left: 15px;
        font-size: 13px;
        padding: 9px 15px;
    }

    .panel-lateral {
        padding: 30px 25px;
    }

    .formulario {
        padding: 32px 25px;
    }

    .panel-lateral h1 {
        font-size: 34px;
    }

    .encabezado-formulario h2 {
        font-size: 29px;
    }

    .botones {
        flex-direction: column;
    }

    input[type="reset"] {
        width: 100%;
    }

}

</style>

</head>

<body>

<a
href="../paginaprincipal.php"
class="regresar"

>


← Volver


</a>

<section class="formulario-contenedor">

<section class="panel-lateral">

    <div>

        <div class="marca">
            <span class="my">My</span>
            <span class="oz">Oz</span>
        </div>

        <div class="panel-contenido">

            <p class="etiqueta">
                ORGANIC ZONE
            </p>

            <h1>
                Tu opinión
                <br>
                <span>nos importa.</span>
            </h1>

            <p>
                Queremos conocer tu experiencia.
                Déjanos tus comentarios y ayúdanos
                a seguir mejorando nuestros productos
                y servicios.
            </p>

        </div>

    </div>

    <div class="decoracion">
        <span></span>
        <span></span>
    </div>

</section>

<section class="formulario">

    <div class="encabezado-formulario">

        <p class="mini-titulo">
            CUÉNTANOS
        </p>

        <h2>
            Déjanos un comentario
        </h2>

        <p>
            Completa los siguientes campos y envíanos tu opinión.
        </p>

    </div>

    <form
        action="coment.php"
        method="POST"
    >

        <div class="campo">

            <label for="asu">
                ASUNTO
            </label>

            <input
                type="text"
                id="asu"
                name="asu"
                placeholder="¿Sobre qué quieres comentarnos?"
            >

        </div>

        <div class="campo">

            <label for="come">
                COMENTARIO
            </label>

            <textarea
                id="come"
                name="come"
                placeholder="Escribe aquí tu comentario..."
            ></textarea>

        </div>

        <div class="botones">

            <input
                type="submit"
                value="Enviar comentario"
            >

            <input
                type="reset"
                value="Borrar"
            >

        </div>

    </form>

</section>

</section>

</body>

</html>
