<?php

$conexion = new mysqli("localhost", "root", "", "organiczoneBD");

if ($conexion->connect_error) {
    die("Error en la conexión");
}

$id = $_GET['id'];

$sql = "SELECT * FROM pedidos WHERE id = $id";
$resultado = $conexion->query($sql);

if ($resultado->num_rows == 0) {
    die("Pedido no encontrado");
}

$fila = $resultado->fetch_assoc();

$nombre = $fila['nombre'];
$fecha = $fila['fecha'];
$estado = $fila['estado'];
$nombrevendedor = $fila['nombrevendedor'];
$direccion = $fila['direccion'];
$telefono = $fila['telefono'];

?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Editar Pedido</title>

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

    min-height: 100%;

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

    color: white;

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

    font-size: 52px;

    line-height: 1.05;

    font-weight: 700;

    margin: 0 0 35px 0;

    color: #ffffff;

}


/* =====================================================
   DESCRIPCIÓN
===================================================== */

.desc {

    color: #d6ccc8;

    margin-top: 28px;

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

    font-size: 30px;

    font-weight: 700;

}


/* =====================================================
   FORMULARIO
===================================================== */

.forma {

    width: 100%;

}

.forma label {

    display: block;

    color: #2B140D;

    font-size: 15px;

    font-weight: 600;

    margin-bottom: 6px;

}


/* =====================================================
   INPUTS
===================================================== */

.forma input {

    width: 100%;

    border: none;

    border-bottom: 1px solid #d6d0cc;

    margin-bottom: 24px;

    padding: 10px 3px;

    font-family: 'Fredoka', Arial, sans-serif;

    font-size: 16px;

    color: #2B140D;

    background: transparent;

    outline: none;

    transition: 0.25s ease;

}

.forma input:focus {

    border-bottom: 2px solid #0ba84a;

}


/* =====================================================
   FILAS
===================================================== */

.forma .fil {

    display: flex;

    gap: 25px;

}

.forma .fil > div {

    width: 100%;

}


/* =====================================================
   BOTÓN
===================================================== */

.forma button {

    width: 100%;

    background: #0ba84a;

    color: #ffffff;

    border: none;

    border-radius: 12px;

    padding: 14px;

    margin-top: 10px;

    font-family: 'Fredoka', Arial, sans-serif;

    font-size: 16px;

    font-weight: 700;

    cursor: pointer;

    transition: all 0.25s ease;

}

.forma button:hover {

    background: #2B140D;

    transform: translateY(-2px);

    box-shadow:
        0 6px 15px rgba(43, 20, 13, 0.20);

}


/* =====================================================
   CAMPOS DE SOLO LECTURA
===================================================== */

.forma input[readonly] {

    color: #6d625e;

    cursor: not-allowed;

}


/* =====================================================
   RESPONSIVE
===================================================== */

@media (max-width: 1000px) {

    body {

        align-items: flex-start;

        padding: 20px;

    }

    .principal-grid {

        grid-template-columns: 1fr;

        width: 100%;

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


/* =====================================================
   MÓVIL
===================================================== */

@media (max-width: 600px) {

    body {

        padding: 10px;

    }

    .principal-grid {

        border-radius: 12px;

    }

    .section-negro {

        padding: 30px;

    }

    .contrato-titulo {

        font-size: 38px;

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

            <a href="leerproductos.php">

                VOLVER

            </a>

        </nav>


        <h1 class="contrato-titulo">

            EDITAR<br>
            PEDIDO

        </h1>


        <p class="desc">

            Modifica los datos del pedido seleccionado.<br>
            Mantén actualizada la información del pedido.

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
            action="registroeditarpedido.php"
            method="post"
        >


            <!-- ID -->

            <input
                type="hidden"
                name="id"
                value="<?= $id ?>"
                readonly
            >


            <!-- NOMBRE -->

            <label>

                Nombre

            </label>

            <input
                type="text"
                name="nombre"
                value="<?= htmlspecialchars($nombre) ?>"
                required
            >



            <!-- FECHA -->

            <div class="fil">

                <div>

                    <label>

                        Fecha

                    </label>

                    <input
                        type="date"
                        name="fecha"
                        value="<?= $fecha ?>"
                        required
                    >

                </div>



                <!-- ESTADO -->

                <div>

                    <label>

                        Estado

                    </label>

                    <select
                        name="estado"
                        required
                        style="
                            width:100%;
                            border:none;
                            border-bottom:1px solid #d6d0cc;
                            margin-bottom:24px;
                            padding:10px 3px;
                            font-family:'Fredoka',Arial,sans-serif;
                            font-size:16px;
                            color:#2B140D;
                            background:transparent;
                            outline:none;
                        "
                    >

                        <option
                            value="Pendiente"
                            <?= ($estado == "Pendiente") ? "selected" : "" ?>
                        >
                            Pendiente
                        </option>

                        <option
                            value="En proceso"
                            <?= ($estado == "En proceso") ? "selected" : "" ?>
                        >
                            En proceso
                        </option>

                        <option
                            value="Completado"
                            <?= ($estado == "Completado") ? "selected" : "" ?>
                        >
                            Completado
                        </option>

                        <option
                            value="Rechazado"
                            <?= ($estado == "Rechazado") ? "selected" : "" ?>
                        >
                            Rechazado
                        </option>

                    </select>

                </div>

            </div>



            <!-- VENDEDOR -->

            <div class="fil">

                <div>

                    <label>

                        Nombre vendedor

                    </label>

                    <input
                        type="text"
                        name="nombrevendedor"
                        value="<?= htmlspecialchars($nombrevendedor) ?>"
                        required
                    >

                </div>



                <!-- DIRECCIÓN -->

                <div>

                    <label>

                        Dirección

                    </label>

                    <input
                        type="text"
                        name="direccion"
                        value="<?= htmlspecialchars($direccion) ?>"
                        required
                    >

                </div>

            </div>



            <!-- TELÉFONO -->

            <label>

                Teléfono

            </label>

            <input
                type="number"
                name="telefono"
                value="<?= htmlspecialchars($telefono) ?>"
                required
            >



            <!-- BOTÓN -->

            <button type="submit">

                Guardar Cambios

            </button>


        </form>


    </section>


</section>


</body>

</html>