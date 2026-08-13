<?php

$conexion = new mysqli("localhost", "root", "", "organiczoneBD");

if ($conexion->connect_error) {
    die("Error en la conexión");
}

$id = $_GET['id'];

$sql = "SELECT * FROM ventas WHERE id = $id";
$resultado = $conexion->query($sql);

$fila = $resultado->fetch_assoc();

$estado = $fila['estado'];
$metodo = $fila['metodo'];

?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Editar Venta</title>

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

    background: #F5EEE3;

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

    max-width: 1200px;

    min-height: 700px;

    background: white;

    border-radius: 18px;

    overflow: hidden;

    box-shadow:
        0 10px 45px rgba(43, 20, 13, 0.15);
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

    color: white;
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

    font-size: 28px;

    font-weight: 700;

    padding-bottom: 18px;

    border-bottom: 1px solid #eeeeee;
}


/* =====================================================
   FORMULARIO
===================================================== */

.forma {

    width: 100%;
}


/* =====================================================
   FILAS
===================================================== */

.forma .fil {

    display: grid;

    grid-template-columns: 1fr 1fr;

    gap: 22px;

    width: 100%;

    margin-bottom: 25px;
}


/* =====================================================
   CONTENEDOR DE CADA CAMPO
===================================================== */

.forma .fil > div {

    display: flex;

    flex-direction: column;

    gap: 8px;
}


/* =====================================================
   ETIQUETAS
===================================================== */

.forma label {

    font-family: 'Fredoka', sans-serif;

    font-size: 15px;

    font-weight: 600;

    color: #333;
}


/* =====================================================
   INPUTS
===================================================== */

.forma input {

    width: 100%;

    padding: 13px 15px;

    border: 2px solid #dce8d8;

    border-radius: 12px;

    background-color: #ffffff;

    font-family: 'Fredoka', sans-serif;

    font-size: 15px;

    color: #333;

    outline: none;

    transition: 0.3s;
}


.forma input:focus {

    border-color: #0ba84a;

    box-shadow:
        0 0 0 3px rgba(11, 168, 74, 0.12);
}


/* =====================================================
   INPUTS SOLO LECTURA
===================================================== */

.forma input[readonly] {

    background: #f7f4ef;

    color: #777;

    cursor: not-allowed;

    border-color: #e5ded5;
}


/* =====================================================
   SELECT
===================================================== */

.forma select {

    width: 100%;

    padding: 13px 15px;

    border: 2px solid #dce8d8;

    border-radius: 12px;

    background-color: #ffffff;

    color: #333;

    font-family: 'Fredoka', sans-serif;

    font-size: 15px;

    outline: none;

    cursor: pointer;

    transition: 0.3s;
}


.forma select:focus {

    border-color: #0ba84a;

    box-shadow:
        0 0 0 3px rgba(11, 168, 74, 0.12);
}


/* =====================================================
   BOTÓN GUARDAR
===================================================== */

.forma button {

    display: block;

    width: 100%;

    padding: 15px;

    margin-top: 10px;

    border: none;

    border-radius: 14px;

    background-color: #0ba84a;

    color: white;

    font-family: 'Fredoka', sans-serif;

    font-size: 16px;

    font-weight: 700;

    cursor: pointer;

    transition: all 0.3s ease;

    box-shadow:
        0 5px 15px rgba(11, 168, 74, 0.20);
}


.forma button:hover {

    background-color: #2B140D;

    transform: translateY(-2px);

    box-shadow:
        0 8px 20px rgba(43, 20, 13, 0.22);
}


/* =====================================================
   RESPONSIVE
===================================================== */

@media (max-width: 900px) {

    body {

        padding: 20px;
    }

    .principal-grid {

        grid-template-columns: 1fr;

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

        width: 100%;

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

        grid-template-columns: 1fr;

        gap: 18px;
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

            <a href="leerventas.php">

                VOLVER

            </a>

        </nav>


        <h1 class="contrato-titulo">

            EDITAR<br>
            VENTA

        </h1>


        <p class="desc">

            Modifica los datos de la venta seleccionada.<br><br>

            Mantén actualizado el método de pago
            y el estado de la venta.

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
            action="editarventa.php"
            method="post"
        >


            <input
                type="hidden"
                name="id"
                value="<?= $id ?>"
                readonly
            >


            <div class="fil">


                <!-- ESTADO -->

                <div>

                    <label>
                        Estado
                    </label>

                    <select
                        name="estado"
                        required
                    >

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

                    </select>

                </div>


                <!-- MÉTODO -->

                <div>

                    <label>
                        Método
                    </label>

                    <select
                        name="metodo"
                        required
                    >

                        <option
                            value="QR"
                            <?= ($metodo == "QR") ? "selected" : "" ?>
                        >
                            QR
                        </option>


                        <option
                            value="Efectivo"
                            <?= ($metodo == "Efectivo") ? "selected" : "" ?>
                        >
                            Efectivo
                        </option>

                    </select>

                </div>


                <!-- COSTO -->

                <div>

                    <label>
                        Costo Total
                    </label>

                    <input
                        type="number"
                        value="<?= $fila['costototal'] ?>"
                        readonly
                    >

                </div>


                <!-- PEDIDO -->

                <div>

                    <label>
                        ID del Pedido
                    </label>

                    <input
                        type="number"
                        value="<?= $fila['pedidos_id'] ?>"
                        readonly
                    >

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