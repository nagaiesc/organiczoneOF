<?php

$nombreServidor = "localhost";
$nombreUsuario = "root";
$contraseñaBaseDeDatos = "";
$nombreBaseDeDatos = "organiczoneBD";

$conn = new mysqli(
    $nombreServidor,
    $nombreUsuario,
    $contraseñaBaseDeDatos,
    $nombreBaseDeDatos
);

if ($conn->connect_error) {
    die("Hubo un error en la conexion");
}

$CI = $_GET['CI'];

$sql = "SELECT * FROM usuarios WHERE CI = $CI";
$resultado = $conn->query($sql);

if ($resultado->num_rows > 0) {

    $fila = $resultado->fetch_assoc();

    $nombre = $fila['nombre'];
    $direccion = $fila['direccion'];
    $celular = $fila['celular'];
    $rol = $fila['rol'];
    $estado = $fila['estado'];
}

?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Editar Usuario</title>

<!-- FUENTE FREDOKA -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link
    href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&display=swap"
    rel="stylesheet"
>

<style>

/* =====================================================
   ESTILOS GENERALES
===================================================== */

* {
    box-sizing: border-box;
}

html,
body {

    height: 100%;

    margin: 0;

    padding: 0;

    background: #ffffff;

    font-family: 'Fredoka', Arial, sans-serif;

    color: #2B140D;

}

body {

    display: flex;

    justify-content: center;

    align-items: center;

    padding: 35px;

}


/* =====================================================
   CONTENEDOR PRINCIPAL
===================================================== */

.principal-grid {

    display: grid;

    grid-template-columns: 390px 1fr;

    width: 96vw;

    max-width: 1400px;

    min-height: 700px;

    background: #ffffff;

    border-radius: 18px;

    overflow: hidden;

    box-shadow:
        0 10px 45px rgba(43, 20, 13, 0.12);

}


/* =====================================================
   PANEL IZQUIERDO
===================================================== */

.section-negro {

    background: #2B140D;

    color: #ffffff;

    padding: 45px 40px;

}


/* =====================================================
   NAVEGACIÓN
===================================================== */

.nav-inner {

    margin-bottom: 70px;

}

.nav-inner a {

    color: #ffffff;

    text-decoration: none;

    font-size: 15px;

    font-weight: 600;

    letter-spacing: 1px;

    transition: 0.3s ease;

}

.nav-inner a:hover {

    color: #0ba84a;

}


/* =====================================================
   TÍTULO
===================================================== */

.contrato-titulo {

    font-size: 50px;

    line-height: 1.05;

    font-weight: 700;

    margin: 0 0 30px 0;

    color: #ffffff;

}


/* =====================================================
   DESCRIPCIÓN
===================================================== */

.desc {

    color: #d6ccc8;

    margin-top: 25px;

    font-size: 16px;

    line-height: 1.6;

}


/* =====================================================
   PANEL DERECHO
===================================================== */

.section-blanco {

    background: #ffffff;

    padding: 50px;

}


/* =====================================================
   TÍTULO DEL FORMULARIO
===================================================== */

.section-blanco h2 {

    margin: 0 0 35px 0;

    color: #2B140D;

    font-size: 28px;

    font-weight: 700;

}


/* =====================================================
   FORMULARIO
===================================================== */

.forma {

    width: 100%;

}


/* =====================================================
   LABELS
===================================================== */

.forma label {

    display: block;

    font-size: 14px;

    font-weight: 600;

    color: #4a3a34;

    margin-bottom: 8px;

}


/* =====================================================
   INPUTS Y SELECT
===================================================== */

.forma input,
.forma select {

    width: 100%;

    border: 2px solid #eee5df;

    border-radius: 12px;

    margin-bottom: 22px;

    padding: 13px 15px;

    font-family: 'Fredoka', Arial, sans-serif;

    font-size: 15px;

    color: #2B140D;

    background: #f8f5f2;

    outline: none;

    transition: 0.3s ease;

}


/* =====================================================
   FOCUS
===================================================== */

.forma input:focus,
.forma select:focus {

    border-color: #0ba84a;

    background: #ffffff;

    box-shadow:
        0 0 0 3px rgba(11, 168, 74, 0.12);

}


/* =====================================================
   FILAS
===================================================== */

.forma .fil {

    display: flex;

    gap: 20px;

    width: 100%;

}

.forma .fil div {

    width: 100%;

}


/* =====================================================
   BOTÓN GUARDAR CAMBIOS
===================================================== */

.forma button {

    width: 100%;

    background: #0ba84a;

    color: #ffffff;

    border: none;

    padding: 14px;

    font-family: 'Fredoka', Arial, sans-serif;

    font-size: 16px;

    font-weight: 700;

    cursor: pointer;

    border-radius: 14px;

    transition: 0.3s ease;

    margin-top: 5px;

}


/* HOVER */

.forma button:hover {

    background: #2B140D;

    transform: translateY(-2px);

    box-shadow:
        0 7px 18px rgba(43, 20, 13, 0.18);

}


/* =====================================================
   RESPONSIVE
===================================================== */

@media (max-width: 900px) {

    body {

        align-items: flex-start;

        padding: 20px;

    }

    .principal-grid {

        grid-template-columns: 1fr;

        width: 100%;

        min-height: auto;

    }

    .section-negro {

        padding: 35px;

    }

    .nav-inner {

        margin-bottom: 40px;

    }

    .contrato-titulo {

        font-size: 42px;

    }

    .section-blanco {

        padding: 35px;

    }

}


@media (max-width: 600px) {

    body {

        padding: 10px;

    }

    .principal-grid {

        border-radius: 14px;

    }

    .section-negro {

        padding: 30px;

    }

    .contrato-titulo {

        font-size: 36px;

    }

    .section-blanco {

        padding: 25px;

    }

    .forma .fil {

        flex-direction: column;

        gap: 0;

    }

}

</style>

</head>


<body>


<section class="principal-grid">


    <!-- =================================================
         PANEL IZQUIERDO
    ================================================== -->

    <section class="section-negro">


        <nav class="nav-inner">

            <a href="leerusuarios.php">

                VOLVER

            </a>

        </nav>


        <h1 class="contrato-titulo">

            EDITAR<br>
            USUARIO

        </h1>


        <p class="desc">

            Modifica los datos del usuario seleccionado.<br>

            Mantén actualizada la información del sistema.

        </p>


    </section>



    <!-- =================================================
         PANEL DERECHO
    ================================================== -->

    <section class="section-blanco">


        <h2>

            Formulario de Edición

        </h2>


        <form
            class="forma"
            action="registroeditarusuario.php"
            method="post"
        >


            <input
                type="hidden"
                name="CI"
                value="<?= $CI ?>"
            >


            <label>

                Nombre del usuario

            </label>

            <input
                type="text"
                name="nombre"
                value="<?= $nombre ?>"
                required
            >



            <div class="fil">


                <div>

                    <label>

                        Dirección

                    </label>

                    <input
                        type="text"
                        name="direccion"
                        value="<?= $direccion ?>"
                        required
                    >

                </div>


                <div>

                    <label>

                        Celular

                    </label>

                    <input
                        type="text"
                        name="celular"
                        value="<?= $celular ?>"
                        required
                    >

                </div>


            </div>



            <div class="fil">


                <div>

                    <label>

                        Rol

                    </label>


                    <select
                        name="rol"
                        required
                    >

                        <option
                            value="admin"
                            <?= $rol == 'admin' ? 'selected' : '' ?>
                        >
                            Admin
                        </option>


                        <option
                            value="usuario"
                            <?= $rol == 'vendedor' ? 'selected' : '' ?>
                        >
                            Vendedor
                        </option>

                    </select>

                </div>



                <div>

                    <label>

                        Estado

                    </label>


                    <select
                        name="estado"
                        required
                    >

                        <option
                            value="activo"
                            <?= $estado == 'activo' ? 'selected' : '' ?>
                        >
                            Activo
                        </option>


                        <option
                            value="inactivo"
                            <?= $estado == 'inactivo' ? 'selected' : '' ?>
                        >
                            Inactivo
                        </option>

                    </select>

                </div>


            </div>


            <button type="submit">

                Guardar Cambios

            </button>


        </form>


    </section>


</section>


</body>

</html>