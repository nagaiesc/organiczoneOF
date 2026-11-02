<?php
session_start();
require_once "../seguridad.php";

verificarAdminVendedor();

$rol = $_SESSION['rol'] ?? '';

if ($rol === 'admin') {
    $volverInicio = '../vistaadmin.php';
} elseif ($rol === 'vendedor') {
    $volverInicio = '../Usuarios/vistavendedor.php';
} else {
    $volverInicio = '../paginaprincipal.php';
}
?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>Lista de Productos</title>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

.principal-grid {
    display: grid;
    grid-template-columns: 390px 1fr;
    width: 96vw;
    max-width: 1600px;
    min-height: 820px;
    background: white;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 15px 45px rgba(43, 20, 13, 0.14);
}

.section-negro {
    background: #2B140D;
    color: white;
    padding: 45px 40px;
    display: flex;
    flex-direction: column;
}

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

.contrato-titulo {
    font-size: 52px;
    line-height: 1.05;
    font-weight: 700;
    margin: 0 0 35px 0;
    letter-spacing: -1px;
}

.contrato-titulo::after {
    content: "";
    display: block;
    width: 65px;
    height: 6px;
    background: #0ba84a;
    border-radius: 10px;
    margin-top: 22px;
}

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
    box-shadow: 0 6px 18px rgba(11,168,74,0.22);
    transition: 0.3s ease;
}

#boton:hover {
    background: #098d3e;
    transform: translateY(-2px);
    box-shadow: 0 9px 22px rgba(11,168,74,0.30);
}

.desc {
    color: #d1c9c6;
    margin-top: 28px;
    font-size: 16px;
    line-height: 1.7;
    max-width: 280px;
}

.section-blanco {
    background: #ffffff;
    padding: 45px;
    overflow-x: auto;
}

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

table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    min-width: 900px;
}

thead th {
    background: #2B140D;
    color: white;
    padding: 15px 13px;
    text-align: left;
    font-size: 14px;
    font-weight: 600;
    border-bottom: 3px solid #0ba84a;
}

thead th:first-child {
    border-radius: 12px 0 0 0;
}

thead th:last-child {
    border-radius: 0 12px 0 0;
}

tbody tr {
    transition: 0.2s ease;
}

tbody tr:hover {
    background: #f5faf7;
}

tbody td {
    padding: 15px 13px;
    border-bottom: 1px solid #eeeeee;
    color: #3a302c;
    font-size: 14px;
    vertical-align: middle;
}

tbody td img {
    display: block;
    width: 72px !important;
    height: 72px !important;
    object-fit: cover;
    border-radius: 14px;
    border: 2px solid #eeeeee;
    box-shadow: 0 4px 12px rgba(43,20,13,0.10);
    transition: 0.3s ease;
}

tbody tr:hover td img {
    border-color: #0ba84a;
    transform: scale(1.04);
}

th:last-child,
td.col-acciones {
    min-width: 300px;
}


/* =====================================================
   BOTONES DE ACCIONES
   Tres botones iguales, redondeados y alineados
   (mismos colores que la lista de usuarios y pedidos)
===================================================== */

.acciones {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 8px;
}

.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 36px;
    padding: 0 14px;
    border: 1.5px solid transparent;
    border-radius: 100px;
    font-family: 'Fredoka', Arial, sans-serif;
    font-size: 13px;
    font-weight: 600;
    line-height: 1;
    text-decoration: none;
    white-space: nowrap;
    cursor: pointer;
    transition:
        transform 0.2s ease,
        background 0.2s ease,
        color 0.2s ease,
        border-color 0.2s ease,
        box-shadow 0.2s ease;
}

.btn:hover {
    transform: translateY(-2px);
}

.btn:active {
    transform: scale(0.97);
}

/* Mostrar */
.btn-mostrar {
    background: #0ba84a;
    color: #ffffff;
}

.btn-mostrar:hover {
    background: #4a2115;
    box-shadow: 0 6px 14px rgba(43, 20, 13, 0.25);
}

/* Editar */
.btn-editar {
    background: #FCD09F;
    color: #2B140D;
}

.btn-editar:hover {
    background: #f5bd7e;
    box-shadow: 0 6px 14px rgba(252, 208, 159, 0.55);
}

/* Eliminar */
.btn-eliminar {
    background: #b3261e;
    color: #ffffff;
    border-color: #f1c7c1;
}

.btn-eliminar:hover {
    background: #D62828;
    border-color: #D62828;
    color: #ffffff;
    box-shadow: 0 6px 14px rgba(214, 40, 40, 0.30);
}

tbody td[colspan] {
    text-align: center;
    padding: 35px;
    color: #888;
    font-size: 15px;
}

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


/* =====================================================
   ALERTAS PERSONALIZADAS (SweetAlert2)
   Mismo estilo que la lista de pedidos y usuarios
===================================================== */

.oz-popup {
    width: 430px !important;
    border-radius: 32px !important;
    padding: 35px 32px 30px !important;
    background: #FFFDF9 !important;
    border: 3px solid #FCD09F !important;
    box-shadow: 0 20px 60px rgba(43,20,13,.25) !important;
    font-family: 'Fredoka', Arial, sans-serif !important;
}

.oz-title {
    color: #2B140D !important;
    font-family: 'Fredoka', Arial, sans-serif !important;
    font-size: 29px !important;
    font-weight: 700 !important;
}

.oz-text {
    color: #665752 !important;
    font-family: 'Fredoka', Arial, sans-serif !important;
    font-size: 16px !important;
}

.oz-confirm {
    background: #D62828 !important;
    color: #ffffff !important;
    border: none !important;
    border-radius: 50px !important;
    padding: 12px 23px !important;
    margin: 5px !important;
    font-family: 'Fredoka', Arial, sans-serif !important;
    font-size: 14px !important;
    font-weight: 600 !important;
    cursor: pointer !important;
    box-shadow: none !important;
    transition: .25s ease !important;
}

.oz-confirm:hover {
    background: #B71C1C !important;
    transform: translateY(-2px) !important;
}

.oz-cancel {
    background: #2B140D !important;
    color: #ffffff !important;
    border: none !important;
    border-radius: 50px !important;
    padding: 12px 23px !important;
    margin: 5px !important;
    font-family: 'Fredoka', Arial, sans-serif !important;
    font-size: 14px !important;
    font-weight: 600 !important;
    cursor: pointer !important;
    box-shadow: none !important;
    transition: .25s ease !important;
}

.oz-cancel:hover {
    background: #0BA84A !important;
    transform: translateY(-2px) !important;
}

.oz-success {
    background: #0BA84A !important;
    color: #ffffff !important;
    border: none !important;
    border-radius: 50px !important;
    padding: 12px 28px !important;
    font-family: 'Fredoka', Arial, sans-serif !important;
    font-size: 14px !important;
    font-weight: 600 !important;
    cursor: pointer !important;
    box-shadow: none !important;
    transition: .25s ease !important;
}

.oz-success:hover {
    background: #087D38 !important;
    transform: translateY(-2px) !important;
}

.swal2-icon {
    margin-top: 0 !important;
}

.swal2-icon.swal2-warning {
    border-color: #D62828 !important;
    color: #D62828 !important;
}

.swal2-icon.swal2-success {
    border-color: #0BA84A !important;
    color: #0BA84A !important;
}


/* =====================================================
   RESPONSIVE
===================================================== */

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

    .oz-popup {
        width: calc(100% - 18px) !important;
        max-width: 380px !important;
        border-radius: 25px !important;
        padding: 25px 18px 22px !important;
    }

    .oz-title {
        font-size: 23px !important;
    }

    .oz-text {
        font-size: 14px !important;
    }

    .oz-confirm,
    .oz-cancel,
    .oz-success {
        padding: 10px 17px !important;
        font-size: 13px !important;
    }
}

@media (max-width: 400px) {

    .oz-popup {
        padding: 22px 15px 20px !important;
    }

    .oz-title {
        font-size: 21px !important;
    }

    .oz-text {
        font-size: 13px !important;
    }
}

</style>


<?php include $_SERVER['DOCUMENT_ROOT'] . '/organiczoneOF/includes/oz-navegacion.php'; ?>
</head>

<body>

<section class="principal-grid">

<section class="section-negro">

<nav class="nav-inner">

<a href="<?php echo $volverInicio; ?>">
← Inicio
</a>

</nav>

<h1 class="contrato-titulo">
LISTA DE<br>
PRODUCTOS
</h1>

<a
    href="formularioproductos.php"
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

    die("Error de conexión con la base de datos.");

}

$conexion->set_charset("utf8mb4");

$stockBajo = 5;

$sql = "SELECT * FROM productos ORDER BY id DESC";

$resultado = $conexion->query($sql);

$productosBajoStock = [];

if ($resultado && $resultado->num_rows > 0) {

    while ($fila = $resultado->fetch_assoc()) {

        $id = (int)$fila['id'];

        $nombre = protegerTexto($fila['nombre']);
        $descripcion = protegerTexto($fila['descripcion']);
        $precio = protegerTexto($fila['precio']);
        $costo = protegerTexto($fila['costo']);

        $nombreAttr = htmlspecialchars($fila['nombre'], ENT_QUOTES, 'UTF-8');

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

        $stock = (int)$fila['stock'];

        if ($stock <= 0) {

            $claseStock = "stock-sin";
            $textoStock = "Sin stock";

        } elseif ($stock <= $stockBajo) {

            $claseStock = "stock-bajo";
            $textoStock = "Stock: " . $stock;

            $productosBajoStock[] =
                $nombre . " (" . $stock . " unidades)";

        } else {

            $claseStock = "stock-normal";
            $textoStock = "Stock: " . $stock;

        }

        echo "<tr>";

        echo "
            <td>
                <img
                    src='" . htmlspecialchars($imagen, ENT_QUOTES, 'UTF-8') . "'
                    alt='Imagen del producto'
                >
            </td>
        ";

        echo "<td>$id</td>";

        echo "<td>$nombre</td>";

        echo "<td>$descripcion</td>";

        echo "
            <td>
                <strong style='color:#0ba84a;'>
                    Bs. $precio
                </strong>
            </td>
        ";

        echo "<td>Bs. $costo</td>";

        echo "
            <td>
                <span class='$claseStock'>
                    $textoStock
                </span>
            </td>
        ";

        echo "
            <td class='col-acciones'>

                <div class='acciones'>

                    <a
                        href='leerproducto.php?id=$id'
                        class='btn btn-mostrar'
                    >
                        Mostrar
                    </a>

                    <a
                        href='editarproducto.php?id=$id'
                        class='btn btn-editar'
                    >
                        Editar
                    </a>

                    <a
                        href='#'
                        class='btn btn-eliminar'
                        data-id='$id'
                        data-nombre='$nombreAttr'
                    >
                        Eliminar
                    </a>

                </div>

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

?>

</tbody>

</table>

</section>

</section>

<script>

/* Evita que el nombre rompa el HTML de la alerta */
function escaparHtml(texto) {
    const div = document.createElement("div");
    div.textContent = texto;
    return div.innerHTML;
}

<?php if (count($productosBajoStock) > 0): ?>

const productosBajoStock = <?= json_encode(
    implode('<br>', $productosBajoStock),
    JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT
) ?>;

Swal.fire({

    title: "Productos con bajo stock",

    html: `
        <div style="
            font-family:'Fredoka', sans-serif;
            color:#665752;
            font-size:16px;
            line-height:1.5;
        ">
            Estos productos necesitan reposición:
            <br><br>
            <strong style="color:#2B140D;">
                ${productosBajoStock}
            </strong>
        </div>
    `,

    icon: "warning",

    iconColor: "#D62828",

    background: "#FFFDF9",

    confirmButtonText: "Entendido",

    buttonsStyling: false,

    customClass: {
        popup: "oz-popup",
        title: "oz-title",
        htmlContainer: "oz-text",
        confirmButton: "oz-success"
    }

});

<?php endif; ?>

function confirmarEliminacion(id, nombre) {

    Swal.fire({

        title: "¿Eliminar producto?",

        html: `
            <div style="
                font-family:'Fredoka', sans-serif;
                color:#665752;
                font-size:16px;
                line-height:1.5;
            ">
                El producto
                <strong style="color:#2B140D;">${escaparHtml(nombre)}</strong>
                será eliminado
                permanentemente.
                <br><br>
                <span style="
                    color:#D62828;
                    font-size:14px;
                    font-weight:600;
                ">
                    Esta acción no se puede deshacer.
                </span>
            </div>
        `,

        icon: "warning",

        iconColor: "#D62828",

        background: "#FFFDF9",

        showCancelButton: true,

        confirmButtonText: "Eliminar",

        cancelButtonText: "Cancelar",

        buttonsStyling: false,

        customClass: {
            popup: "oz-popup",
            title: "oz-title",
            htmlContainer: "oz-text",
            confirmButton: "oz-confirm",
            cancelButton: "oz-cancel"
        }

    }).then((result) => {

        if (result.isConfirmed) {

            window.location.href =
                "eliminarproducto.php?id=" + encodeURIComponent(id);

        }

    });

}

/* Botones "Eliminar" de la tabla */
document.addEventListener("click", function (e) {

    const boton = e.target.closest(".btn-eliminar");

    if (!boton) return;

    e.preventDefault();

    confirmarEliminacion(boton.dataset.id, boton.dataset.nombre);

});

</script>

</body>

</html>