<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>
    Lista de Productos
</title>


<!-- SWEET ALERT -->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<!-- FUENTE FREDOKA -->

<link rel="preconnect" href="https://fonts.googleapis.com">

<link
    rel="preconnect"
    href="https://fonts.gstatic.com"
    crossorigin
>

<link
    href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&display=swap"
    rel="stylesheet"
>


<style>

/* =========================================
   ESTILOS GENERALES
========================================= */

* {
    box-sizing: border-box;
}

html,
body {

    min-height: 100%;

    margin: 0;

    padding: 0;

}

body {

    background: #ffffff;

    font-family: 'Fredoka', Arial, sans-serif;

    display: flex;

    justify-content: center;

    align-items: center;

    padding: 35px 20px;

    color: #2B140D;

}


/* =========================================
   CONTENEDOR PRINCIPAL
========================================= */

.principal-grid {

    display: grid;

    grid-template-columns: 390px 1fr;

    width: 96vw;

    max-width: 1600px;

    min-height: 820px;

    background: white;

    border-radius: 24px;

    overflow: hidden;

    box-shadow:
        0 15px 45px rgba(43, 20, 13, 0.14);

}


/* =========================================
   PANEL IZQUIERDO
========================================= */

.section-negro {

    background: #2B140D;

    color: white;

    padding: 45px 40px;

    display: flex;

    flex-direction: column;

}


/* =========================================
   NAVEGACIÓN
========================================= */

.nav-inner {

    margin-bottom: 70px;

}


.nav-inner a {

    display: inline-flex;

    align-items: center;

    text-decoration: none;

    color: white;

    background: rgba(255,255,255,0.10);

    padding: 10px 17px;

    border-radius: 30px;

    font-size: 15px;

    font-weight: 500;

    transition: 0.3s ease;

}


.nav-inner a:hover {

    background: #FCD09F;

    color: #2B140D;

    transform: translateY(-2px);

}


/* =========================================
   TITULO
========================================= */

.contrato-titulo {

    font-size: 52px;

    line-height: 1.05;

    font-weight: 700;

    margin: 0 0 35px 0;

    letter-spacing: -1px;

}


/* Línea verde */

.contrato-titulo::after {

    content: "";

    display: block;

    width: 65px;

    height: 6px;

    background: #0ba84a;

    border-radius: 10px;

    margin-top: 22px;

}


/* =========================================
   BOTÓN REGISTRAR
========================================= */

#boton {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    width: fit-content;

    background: #0ba84a;

    color: white;

    padding: 13px 22px;

    border-radius: 30px;

    font-size: 16px;

    font-weight: 600;

    text-decoration: none;

    box-shadow:
        0 6px 18px rgba(11,168,74,0.22);

    transition: 0.3s ease;

}


#boton:hover {

    background: #098d3e;

    transform: translateY(-2px);

    box-shadow:
        0 9px 22px rgba(11,168,74,0.30);

}


/* =========================================
   DESCRIPCIÓN
========================================= */

.desc {

    color: #d1c9c6;

    margin-top: 28px;

    font-size: 16px;

    line-height: 1.7;

    max-width: 280px;

}


/* =========================================
   PANEL DERECHO
========================================= */

.section-blanco {

    background: #ffffff;

    padding: 45px;

    overflow-x: auto;

}


/* =========================================
   TITULO TABLA
========================================= */

.section-clientes {

    border-bottom: 1px solid #eeeeee;

    margin-bottom: 28px;

    padding-bottom: 18px;

}


.section-clientes h2 {

    margin: 0;

    color: #2B140D;

    font-size: 28px;

    font-weight: 700;

}


/* =========================================
   TABLA
========================================= */

table {

    width: 100%;

    border-collapse: separate;

    border-spacing: 0;

    min-width: 900px;

}


/* ENCABEZADO */

thead th {

    background: #2B140D;

    color: white;

    padding: 15px 13px;

    text-align: left;

    font-size: 14px;

    font-weight: 600;

    border-bottom: 3px solid #0ba84a;

}


/* Bordes superiores */

thead th:first-child {

    border-radius: 12px 0 0 0;

}

thead th:last-child {

    border-radius: 0 12px 0 0;

}


/* FILAS */

tbody tr {

    transition: 0.2s ease;

}


tbody tr:hover {

    background: #f5faf7;

}


/* CELDAS */

tbody td {

    padding: 15px 13px;

    border-bottom: 1px solid #eeeeee;

    color: #3a302c;

    font-size: 14px;

    vertical-align: middle;

}


/* =========================================
   IMÁGENES
========================================= */

tbody td img {

    display: block;

    width: 72px !important;

    height: 72px !important;

    object-fit: cover;

    border-radius: 14px;

    border: 2px solid #eeeeee;

    box-shadow:
        0 4px 12px rgba(43,20,13,0.10);

    transition: 0.3s ease;

}


tbody tr:hover td img {

    border-color: #0ba84a;

    transform: scale(1.04);

}


/* =========================================
   ACCIONES
========================================= */

.acciones {

    display: flex;

    align-items: center;

    gap: 7px;

    min-width: 270px;

}


/* TODOS LOS BOTONES */

.acciones a {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    min-width: 78px;

    height: 36px;

    padding: 0 12px;

    border-radius: 20px;

    text-decoration: none;

    font-family: 'Fredoka', Arial, sans-serif;

    font-size: 13px;

    font-weight: 600;

    cursor: pointer;

    transition: 0.25s ease;

}


/* =========================================
   EDITAR
========================================= */

.btn-editar {

    background: #FCD09F;

    color: #2B140D;

    border: 1px solid #f2c38d;

}


.btn-editar:hover {

    background: #2B140D;

    color: white;

    transform: translateY(-2px);

    box-shadow:
        0 5px 12px rgba(43,20,13,0.20);

}


/* =========================================
   ELIMINAR
========================================= */

.btn-eliminar {

    background: #fff0ed;

    color: #963a2a;

    border: 1px solid #edcfc8;

}


.btn-eliminar:hover {

    background: #963a2a;

    color: white;

    transform: translateY(-2px);

    box-shadow:
        0 5px 12px rgba(150,58,42,0.20);

}


/* =========================================
   MOSTRAR
========================================= */

.btn-mostrar {

    background: #0ba84a;

    color: white;

    border: 1px solid #0ba84a;

}


.btn-mostrar:hover {

    background: #098d3e;

    color: white;

    transform: translateY(-2px);

    box-shadow:
        0 5px 12px rgba(11,168,74,0.25);

}


/* =========================================
   MENSAJE SIN PRODUCTOS
========================================= */

tbody td[colspan] {

    text-align: center;

    padding: 35px;

    color: #888;

    font-size: 15px;

}


/* =========================================
   STOCK BAJO
========================================= */

.stock-bajo {

    display: inline-block;

    background: #FCD09F;

    color: #8A4B08;

    padding: 7px 13px;

    border-radius: 20px;

    font-weight: 700;

}

.stock-sin {

    display: inline-block;

    background: #fff0ed;

    color: #963a2a;

    padding: 7px 13px;

    border-radius: 20px;

    font-weight: 700;

}

.stock-normal {

    display: inline-block;

    background: #eaf7ec;

    color: #0ba84a;

    padding: 7px 13px;

    border-radius: 20px;

    font-weight: 700;

}


/* =========================================
   SWEET ALERT STOCK BAJO
========================================= */

.popup-stock {

    border-radius: 20px !important;

    font-family: 'Fredoka', Arial, sans-serif !important;

}

/* =========================================
   SWEET ALERT
========================================= */

.popup-organic {

    border-radius: 20px !important;

    font-family: 'Fredoka', Arial, sans-serif !important;

}


/* =========================================
   RESPONSIVE
========================================= */

@media (max-width: 1000px) {

    body {

        padding: 20px;

        align-items: flex-start;

    }


    .principal-grid {

        grid-template-columns: 1fr;

        width: 96vw;

    }


    .section-negro {

        min-height: 400px;

        padding: 35px;

    }


    .nav-inner {

        margin-bottom: 40px;

    }


    .contrato-titulo {

        font-size: 44px;

    }


    .section-blanco {

        padding: 30px;

    }

}


@media (max-width: 600px) {

    .contrato-titulo {

        font-size: 38px;

    }


    .section-negro {

        padding: 30px;

    }


    .section-blanco {

        padding: 20px;

    }

}

</style>

</head>


<body>


<section class="principal-grid">


    <!-- =====================================
         PANEL IZQUIERDO
    ====================================== -->

    <section class="section-negro">


        <nav class="nav-inner">

            <a href="../Usuarios/vistavendedor.php">

                ← Inicio

            </a>

        </nav>


        <h1 class="contrato-titulo">

            LISTA DE<br>

            PRODUCTOS

        </h1>


        <a
            href="http://localhost/organiczoneOF/Productos/formularioproductos.php"
            id="boton"
        >

            + Registrar Producto

        </a>


        <p class="desc">

            Visualiza los productos registrados
            en el sistema.
            <br><br>
            Administra precios, stock y costos
            de forma rápida.
        </p>
    </section>

    <section class="section-blanco">
        <section class="section-clientes">
            <h2>
                Productos Registrados
            </h2>
        </section>


        <table>
            <thead>
                <tr>
                    <th>
                        Imagen
                    </th>
                    <th>
                        ID
                    </th>
                    <th>
                        Nombre
                    </th>
                    <th>
                        Descripción
                    </th>
                    <th>
                        Precio
                    </th>
                    <th>
                        Costo
                    </th>
                    <th>
                        Stock
                    </th>
                    <th>
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody>


            <?php
            $conexion = new mysqli("localhost","root","","organiczoneBD");

            if ($conexion->connect_error) {
                echo "<tr> <td colspan='8'>Error en la conexión </td> </tr> ";
            }

            $stockBajo = 5;
            $sql = "SELECT * FROM productos";

            $resultado = $conexion->query($sql);
            if ($resultado && $resultado->num_rows > 0) {
                while($fila = $resultado->fetch_assoc()){
                    $id = $fila['id'];

                    $imagen =
                        "../Imagenes/predeterminado.png";
                    $extensiones = [
                        "jpg",
                        "jpeg",
                        "png",
                        "gif",
                        "webp"
                    ];
                    foreach ($extensiones as $ext) {
                        $ruta =
                            "../Imagenes/P-" .
                            $id .
                            "." .
                            $ext;
                        if (file_exists($ruta)) {
                            $imagen = $ruta;
                            break;
                        }

                    }

                    echo "<tr>";

                    echo "<td><img src='" .htmlspecialchars($imagen) ."'alt='Imagen del producto' > </td>";


                    echo "<td>{$fila['id']}</td> ";
                    echo "<td> {$fila['nombre']}</td>";
                    echo "<td> {$fila['descripcion']}</td> ";
                    echo "<td><strong style='color:#0ba84a;'>Bs. {$fila['precio']}</strong></td> ";
                    echo " <td> Bs. {$fila['costo']} </td> ";

                    $stock = (int) $fila['stock'];
                    if ($stock <= 0) {
                        $claseStock = "stock-sin";
                        $textoStock = "Sin stock";
                    } elseif ($stock <= $stockBajo) {
                        $claseStock = "stock-bajo";
                        $textoStock = "Stock: " . $stock;
                    } else {
                        $claseStock = "stock-normal";
                        $textoStock = "Stock: " . $stock;
                    }

                    echo "
                        <td>
                            <span class='$claseStock'>
                                $textoStock
                            </span>
                        </td>
                    ";
                    echo "
                        <td class='acciones'>
                            <a href='editarproducto.php?id=$id' class='btn-editar'> Editar </a>
                            <a href='#' class='btn-eliminar' onclick='confirmarEliminacion($id); return false;'>Eliminar</a>
                            <ahref='leerproducto.php?id=$id'class='btn-mostrar'>Mostrar</ahref=>
                        </td>
                    ";
                    echo "</tr>";
                }
            } else {
                echo "
                    <tr>
                        <td colspan='8'>
                            No hay productos registrados
                        </td>
                    </tr>
                ";
            }
            $conexion->close();
            ?>
            </tbody>
        </table>
    </section>
</section>
<script>

<?php

$productosBajoStock = [];
$resultadoStock = $conexion->query(
    "SELECT nombre, stock FROM productos WHERE stock <= $stockBajo ORDER BY stock ASC"
);

if ($resultadoStock && $resultadoStock->num_rows > 0) {
    while ($productoStock = $resultadoStock->fetch_assoc()) {
        $productosBajoStock[] =
            $productoStock['nombre'] . " (" . $productoStock['stock'] . " unidades)";
    }
}

?>
<?php if (count($productosBajoStock) > 0): ?>

Swal.fire({
    title: "Productos con bajo stock",
    html: "Estos productos necesitan reposición:<br><br><strong><?= htmlspecialchars(implode('<br>', $productosBajoStock)) ?></strong>",
    icon: "warning",
    confirmButtonColor: "#0ba84a",
    confirmButtonText: "Entendido",
    customClass: {
        popup: "popup-stock"
    }
});

<?php endif; ?>

function confirmarEliminacion(id) {
    Swal.fire({

        title: "¿Estás seguro?",
        text: "No podrás revertir esta acción",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#0ba84a",
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