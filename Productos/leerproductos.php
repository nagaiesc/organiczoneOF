<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Lista de Productos</title>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>

* {
    box-sizing: border-box;
}

html, body {
    min-height: 100%;
    margin: 0;
    padding: 0;
    background: #F5EEE3;
    font-family: 'Fredoka', Arial, sans-serif;
}

body {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 35px;
}

/* =========================
   CONTENEDOR PRINCIPAL
========================= */

.principal-grid {
    display: grid;
    grid-template-columns: 390px 1fr;
    width: 96vw;
    max-width: 1600px;
    min-height: 820px;

    background: white;
    box-shadow: 0px 10px 45px rgba(88, 88, 88, 0.15);

    border-radius: 18px;
    overflow: hidden;
}

/* =========================
   PANEL IZQUIERDO
========================= */

.section-negro {
    background: #2B140D;
    color: white;
    padding: 45px 40px;
}

.nav-inner {
    margin-bottom: 70px;
}

.nav-inner a {
    color: #e6e6e6;
    text-decoration: none;
    font-size: 15px;
    font-weight: 600;
    letter-spacing: 1px;

    transition: 0.3s;
}

.nav-inner a:hover {
    color: #97d395;
}

.contrato-titulo {
    font-size: 52px;
    line-height: 1.05;
    font-weight: 700;
    margin: 0 0 35px 0;
}

.desc {
    color: #c9c0bd;
    margin-top: 28px;
    font-size: 16px;
    line-height: 1.6;
}

/* =========================
   BOTÓN REGISTRAR
========================= */

#boton {
    display: inline-flex;
    align-items: center;
    justify-content: center;

    background: #F5EEE3;
    color: #2B140D;

    padding: 13px 22px;

    border-radius: 50px;

    font-size: 16px;
    font-weight: 700;

    text-decoration: none;

    box-shadow: 0 5px 15px rgba(0,0,0,0.15);

    transition: all 0.25s ease;
}

#boton:hover {
    background: #97d395;
    color: #1d2b1d;

    transform: translateY(-2px);

    box-shadow: 0 8px 20px rgba(0,0,0,0.22);
}

/* =========================
   PANEL DERECHO
========================= */

.section-blanco {
    background: #ffffff;
    padding: 45px;
    overflow-x: auto;
}

.section-clientes {
    border-bottom: 1px solid #eee;
    margin-bottom: 25px;
    padding-bottom: 18px;
}

.section-clientes h2 {
    margin: 0;
    color: #2B140D;
    font-size: 28px;
    font-weight: 700;
}

/* =========================
   TABLA
========================= */

table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    min-width: 900px;
}

thead th {
    background: #F5EEE3;
    color: #2B140D;

    padding: 15px 12px;

    text-align: left;

    font-size: 14px;
    font-weight: 700;

    border-bottom: 2px solid #2B140D;
}

thead th:first-child {
    border-radius: 10px 0 0 0;
}

thead th:last-child {
    border-radius: 0 10px 0 0;
}

tbody tr {
    transition: background 0.2s ease;
}

tbody tr:hover {
    background: #faf7f2;
}

tbody td {
    padding: 14px 12px;

    border-bottom: 1px solid #eeeeee;

    color: #3a302c;

    font-size: 14px;
    vertical-align: middle;
}

/* =========================
   IMAGEN
========================= */

tbody td img {
    display: block;

    width: 70px !important;
    height: 70px !important;

    object-fit: cover;

    border-radius: 12px;

    border: 1px solid #eee;

    box-shadow: 0 3px 10px rgba(0,0,0,0.08);
}

/* =========================
   ACCIONES
========================= */

.acciones {
    display: flex;
    align-items: center;
    gap: 7px;

    min-width: 270px;
}

/* Todos los botones */

.acciones a {
    display: inline-flex;
    align-items: center;
    justify-content: center;

    min-width: 78px;
    height: 34px;

    padding: 0 12px;

    border-radius: 9px;

    text-decoration: none;

    font-family: 'Fredoka', Arial, sans-serif;

    font-size: 13px;
    font-weight: 600;

    cursor: pointer;

    transition: all 0.2s ease;
}

/* Evitamos estilos del button antiguo */

.acciones button {
    display: none;
}

/* EDITAR */

.btn-editar {
    background: #F5EEE3;
    color: #2B140D;

    border: 1px solid #e2d7c8;
}

.btn-editar:hover {
    background: #2B140D;
    color: white;

    transform: translateY(-2px);
}

/* ELIMINAR */

.btn-eliminar {
    background: #f4e5e1;
    color: #8a3021;

    border: 1px solid #e6cbc5;
}

.btn-eliminar:hover {
    background: #8a3021;
    color: white;

    transform: translateY(-2px);
}

/* MOSTRAR */

.btn-mostrar {
    background: #97d395;
    color: #1d3b20;

    border: 1px solid #83c581;
}

.btn-mostrar:hover {
    background: #2B140D;
    color: white;

    transform: translateY(-2px);
}

/* =========================
   RESPONSIVE
========================= */

@media (max-width: 1000px) {

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
        padding: 30px;
    }
}

</style>
</head>

<body>

<section class="principal-grid">

    <!-- PANEL IZQUIERDO -->

    <section class="section-negro">

        <nav class="nav-inner">
            <a href="../maquetados/maquetadoAdmin.php">
                INICIO
            </a>
        </nav>

        <h1 class="contrato-titulo">
            LISTA DE<br>
            PRODUCTOS
        </h1>

        <a href="http://localhost/organiczoneOF/Productos/formularioproductos.php" id="boton">
            + Registrar Producto
        </a>

        <p class="desc">
            Visualiza los productos registrados
            en el sistema.<br><br>

            Administra precios, stock y costos
            de forma rápida.
        </p>

    </section>


    <!-- PANEL DERECHO -->

    <section class="section-blanco">

        <section class="section-clientes">

            <h2>
                Productos Registrados
            </h2>

        </section>


        <table>

            <thead>

                <tr>

                    <th>Imagen</th>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Costo</th>
                    <th>Stock</th>
                    <th>Acciones</th>

                </tr>

            </thead>


            <tbody>

            <?php

            $conexion = new mysqli(
                "localhost",
                "root",
                "",
                "organiczoneBD"
            );

            if ($conexion->connect_error) {

                echo "<tr>
                        <td colspan='8'>
                            Error en la conexión
                        </td>
                      </tr>";

            }


            $sql = "SELECT * FROM productos";

            $resultado = $conexion->query($sql);


            if ($resultado->num_rows > 0) {

                while($fila = $resultado->fetch_assoc()){

                    $id = $fila['id'];

                    $imagen = "../Imagenes/predeterminado.png";


                    $extensiones = [
                        "jpg",
                        "jpeg",
                        "png",
                        "gif",
                        "webp"
                    ];


                    foreach ($extensiones as $ext) {

                        $ruta = "../Imagenes/P-" . $id . "." . $ext;

                        if (file_exists($ruta)) {

                            $imagen = $ruta;

                            break;
                        }
                    }


                    echo "<tr>";


                    echo "<td>

                            <img
                                src='$imagen'
                                alt='Imagen del producto'
                            >

                          </td>";


                    echo "<td>
                            {$fila['id']}
                          </td>";


                    echo "<td>
                            {$fila['nombre']}
                          </td>";


                    echo "<td>
                            {$fila['descripcion']}
                          </td>";


                    echo "<td>
                            {$fila['precio']}
                          </td>";


                    echo "<td>
                            {$fila['costo']}
                          </td>";


                    echo "<td>
                            {$fila['stock']}
                          </td>";


                    echo "<td class='acciones'>

                            <a
                                href='editarproducto.php?id=$id'
                                class='btn-editar'
                            >
                                Editar
                            </a>


                            <a
                                href='#'
                                class='btn-eliminar'
                                onclick='confirmarEliminacion($id); return false;'
                            >
                                Eliminar
                            </a>


                            <a
                                href='leerproducto.php?id=$id'
                                class='btn-mostrar'
                            >
                                Mostrar
                            </a>

                          </td>";


                    echo "</tr>";

                }

            } else {

                echo "<tr>

                        <td colspan='8'>
                            No hay productos registrados
                        </td>

                      </tr>";

            }

            $conexion->close();

            ?>

            </tbody>

        </table>

    </section>

</section>


<script>

function confirmarEliminacion(id){

    Swal.fire({

        title: "¿Estás seguro?",

        text: "No podrás revertir esta acción",

        icon: "warning",

        showCancelButton: true,

        confirmButtonColor: "#97d395",

        cancelButtonColor: "#2B140D",

        confirmButtonText: "Sí, eliminar",

        cancelButtonText: "Cancelar",

        customClass: {

            popup: 'popup-organic'

        }

    }).then((result) => {

        if (result.isConfirmed) {

            window.location =
                "eliminarproducto.php?id=" + id;

        }

    });

}

</script>

</body>
</html>