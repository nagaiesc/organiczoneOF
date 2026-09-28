<?php

session_start();

if (!isset($_SESSION['rol']) || !isset($_SESSION['nombre'])) {
    header("Location: ../Usuarios/formulariosesion.php");
    exit;
}

$rol = $_SESSION['rol'];
$nombreVendedor = $_SESSION['nombre'];

if ($rol === 'admin') {
    $volverInicio = '../vistaadmin.php';
} elseif ($rol === 'vendedor') {
    $volverInicio = '../Usuarios/vistavendedor.php';
} else {
    $volverInicio = '../paginaprincipal.php';
}

$nombreServidor = "localhost";
$nombreUsuario = "root";
$contraseñaBaseDeDatos = "";
$nombreBaseDeDatos = "organiczoneBD";

$conexion = new mysqli(
    $nombreServidor,
    $nombreUsuario,
    $contraseñaBaseDeDatos,
    $nombreBaseDeDatos
);

if ($conexion->connect_error) {
    die("Error de conexión con la base de datos.");
}

$conexion->set_charset("utf8");

if (
    $rol === "vendedor" &&
    isset($_GET['rechazar']) &&
    is_numeric($_GET['rechazar'])
) {
    $idRechazar = intval($_GET['rechazar']);

    $sqlRechazar = "DELETE FROM pedidos
                    WHERE id = ?
                    AND nombrevendedor = ?
                    AND estado = 'Pendiente'";

    $stmtRechazar = $conexion->prepare($sqlRechazar);

    if ($stmtRechazar) {
        $stmtRechazar->bind_param("is", $idRechazar, $nombreVendedor);
        $stmtRechazar->execute();

        $eliminado = $stmtRechazar->affected_rows > 0;

        $stmtRechazar->close();

        header("Location: leerpedidos.php?rechazado=" . ($eliminado ? "1" : "0"));
        exit;
    }

    header("Location: leerpedidos.php?rechazado=0");
    exit;
}

?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Lista de Pedidos | Organic Zone</title>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<link rel="preconnect" href="https://fonts.googleapis.com">

<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

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

.principal-grid {
    display: grid;
    grid-template-columns: 390px 1fr;
    width: 96vw;
    max-width: 1600px;
    min-height: 820px;
    background: #ffffff;
    border-radius: 22px;
    overflow: hidden;
    box-shadow: 0 15px 45px rgba(43,20,13,.12);
}

.section-negro {
    background: #2B140D;
    color: #ffffff;
    padding: 45px 40px;
}

.nav-inner {
    margin-bottom: 70px;
}

.nav-inner a {
    color: #ffffff;
    text-decoration: none;
    font-size: 15px;
    font-weight: 600;
    letter-spacing: 1px;
    transition: .25s ease;
}

.nav-inner a:hover {
    color: #0BA84A;
}

.contrato-titulo {
    font-size: 52px;
    line-height: 1.05;
    font-weight: 700;
    margin: 0 0 35px;
    color: #ffffff;
}

.desc {
    color: #d6ccc8;
    margin-top: 28px;
    font-size: 16px;
    line-height: 1.6;
}

#boton {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: #0BA84A;
    color: #ffffff;
    padding: 13px 22px;
    border-radius: 50px;
    font-size: 16px;
    font-weight: 700;
    text-decoration: none;
    box-shadow: 0 5px 15px rgba(0,0,0,.18);
    transition: .25s ease;
}

#boton:hover {
    background: #FCD09F;
    color: #2B140D;
    transform: translateY(-2px);
}

.section-blanco {
    background: #ffffff;
    padding: 40px;
    overflow-x: hidden;
}

.section-clientes {
    border-bottom: 1px solid #eeeeee;
    margin-bottom: 25px;
    padding-bottom: 18px;
}

.section-clientes h2 {
    margin: 0;
    color: #2B140D;
    font-size: 28px;
    font-weight: 700;
}

.table-contenedor {
    width: 100%;
    overflow: visible;
}

table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    min-width: 1050px;
}

thead th {
    background: #2B140D;
    color: #ffffff;
    padding: 15px 12px;
    text-align: left;
    font-size: 14px;
    font-weight: 700;
    border-bottom: 4px solid #0BA84A;
}

thead th:first-child {
    border-radius: 12px 0 0 0;
}

thead th:last-child {
    border-radius: 0 12px 0 0;
}

tbody tr {
    transition: .2s ease;
}

tbody tr:hover {
    background: #F1FBF5;
}

tbody td {
    padding: 14px 12px;
    border-bottom: 1px solid #eeeeee;
    color: #3a302c;
    font-size: 14px;
    vertical-align: middle;
}

tbody td:nth-child(4) {
    font-weight: 600;
}

.acciones {
    display: flex;
    flex-direction: column;
    gap: 7px;
    align-items: center;
    justify-content: center;
    min-width: 120px;
}

.acciones a {
    width: 100%;
    display: flex;
    justify-content: center;
    text-decoration: none;
}

.acciones button {
    width: 100%;
    border: none;
    padding: 9px 13px;
    border-radius: 50px;
    cursor: pointer;
    font-family: 'Fredoka', Arial, sans-serif;
    font-size: 13px;
    font-weight: 600;
    transition: .25s ease;
}

.boton-stock button {
    background: #0BA84A !important;
    color: #ffffff !important;
    border: 1px solid #0BA84A !important;
}

.boton-stock button:hover {
    background: #2B140D !important;
    color: #ffffff !important;
    border-color: #2B140D !important;
    transform: translateY(-2px);
}

.boton-aceptar button {
    background: #F5F5F5 !important;
    color: #2B140D !important;
    border: 1px solid #E2E2E2 !important;
}

.boton-aceptar button:hover {
    background: #0BA84A !important;
    color: #ffffff !important;
    border-color: #0BA84A !important;
    transform: translateY(-2px);
}

.boton-rechazar button {
    background: #FFF0EE !important;
    color: #D62828 !important;
    border: 1px solid #F2C8C4 !important;
}

.boton-rechazar button:hover {
    background: #D62828 !important;
    color: #ffffff !important;
    border-color: #D62828 !important;
    transform: translateY(-2px);
}

.boton-mostrar button {
    background: #FCD09F !important;
    color: #2B140D !important;
    border: 1px solid #FCD09F !important;
}

.boton-mostrar button:hover {
    background: #2B140D !important;
    color: #ffffff !important;
    border-color: #2B140D !important;
    transform: translateY(-2px);
}

.boton-venta button {
    background: #0BA84A !important;
    color: #ffffff !important;
    border: 1px solid #0BA84A !important;
}

.boton-venta button:hover {
    background: #2B140D !important;
    color: #ffffff !important;
    border-color: #2B140D !important;
    transform: translateY(-2px);
}

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

@media (max-width: 1100px) {

    body {
        padding: 24px;
        align-items: flex-start;
    }

    .principal-grid {
        grid-template-columns: 330px 1fr;
        width: 100%;
        min-height: auto;
    }

    .section-negro {
        padding: 38px 30px;
    }

    .nav-inner {
        margin-bottom: 55px;
    }

    .contrato-titulo {
        font-size: 44px;
    }

    .desc {
        font-size: 15px;
    }

    .section-blanco {
        padding: 30px;
    }

    table {
        min-width: 950px;
    }
}

@media (max-width: 850px) {

    body {
        padding: 18px;
    }

    .principal-grid {
        grid-template-columns: 1fr;
        border-radius: 20px;
    }

    .section-negro {
        padding: 36px 32px;
        border-radius: 20px 20px 0 0;
    }

    .nav-inner {
        margin-bottom: 38px;
    }

    .contrato-titulo {
        font-size: 42px;
        margin-bottom: 26px;
    }

    .desc {
        max-width: 620px;
    }

    #boton {
        margin-top: 2px;
    }

    .section-blanco {
        padding: 28px;
        border-radius: 0 0 20px 20px;
    }

    .section-clientes {
        margin-bottom: 22px;
    }

    .section-clientes h2 {
        font-size: 26px;
    }

    table {
        min-width: 0;
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    thead {
        display: none;
    }

    tbody {
        display: block;
        width: 100%;
    }

    tbody tr {
        display: block;
        width: 100%;
        margin-bottom: 18px;
        padding: 18px;
        background: #ffffff;
        border: 1px solid #E9E3DF;
        border-radius: 18px;
        box-shadow: 0 5px 18px rgba(43,20,13,.06);
    }

    tbody tr:hover {
        background: #ffffff;
    }

    tbody td {
        display: grid;
        grid-template-columns: 125px 1fr;
        gap: 12px;
        width: 100%;
        min-height: 36px;
        padding: 8px 0;
        border-bottom: 1px solid #F0ECE9;
        font-size: 13px;
        white-space: normal;
        overflow-wrap: anywhere;
    }

    tbody td:last-child {
        border-bottom: none;
    }

    tbody td::before {
        color: #2B140D;
        font-size: 12px;
        font-weight: 700;
    }

    tbody td:nth-child(1)::before {
        content: "ID";
    }

    tbody td:nth-child(2)::before {
        content: "Nombre";
    }

    tbody td:nth-child(3)::before {
        content: "Fecha";
    }

    tbody td:nth-child(4)::before {
        content: "Estado";
    }

    tbody td:nth-child(5)::before {
        content: "Vendedor";
    }

    tbody td:nth-child(6)::before {
        content: "Dirección";
    }

    tbody td:nth-child(7)::before {
        content: "Teléfono";
    }

    tbody td:nth-child(8) {
        display: block;
        padding-top: 15px;
        margin-top: 6px;
    }

    tbody td:nth-child(8)::before {
        display: block;
        margin-bottom: 10px;
    }

    .acciones {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 7px;
        width: 100%;
        min-width: 0;
    }

    .acciones a {
        width: 100%;
    }

    .acciones button {
        width: 100%;
        min-height: 36px;
        padding: 8px 9px;
        font-size: 12px;
    }
}

@media (max-width: 600px) {

    body {
        display: block;
        padding: 9px;
    }

    .principal-grid {
        width: 100%;
        border-radius: 18px;
    }

    .section-negro {
        padding: 27px 21px 29px;
        border-radius: 18px 18px 0 0;
    }

    .nav-inner {
        margin-bottom: 30px;
    }

    .nav-inner a {
        font-size: 13px;
        letter-spacing: .6px;
    }

    .contrato-titulo {
        font-size: 33px;
        line-height: 1.02;
        margin-bottom: 21px;
    }

    .desc {
        margin-top: 19px;
        font-size: 13px;
        line-height: 1.55;
    }

    #boton {
        width: 100%;
        min-height: 45px;
        padding: 11px 17px;
        font-size: 14px;
    }

    .section-blanco {
        padding: 20px 12px 23px;
        border-radius: 0 0 18px 18px;
    }

    .section-clientes {
        margin-bottom: 17px;
        padding-bottom: 13px;
    }

    .section-clientes h2 {
        font-size: 21px;
    }

    tbody tr {
        margin-bottom: 15px;
        padding: 15px;
        border-radius: 16px;
    }

    tbody td {
        grid-template-columns: 92px minmax(0, 1fr);
        gap: 9px;
        min-height: 34px;
        padding: 7px 0;
        font-size: 12px;
        line-height: 1.35;
    }

    tbody td::before {
        font-size: 11px;
    }

    tbody td:nth-child(8) {
        padding-top: 14px;
    }

    .acciones {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 6px;
    }

    .acciones button {
        min-height: 35px;
        padding: 7px 6px;
        font-size: 11px;
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

    body {
        padding: 6px;
    }

    .principal-grid {
        border-radius: 15px;
    }

    .section-negro {
        padding: 23px 17px 25px;
        border-radius: 15px 15px 0 0;
    }

    .nav-inner {
        margin-bottom: 27px;
    }

    .nav-inner a {
        font-size: 12px;
    }

    .contrato-titulo {
        font-size: 29px;
        margin-bottom: 18px;
    }

    .desc {
        font-size: 12px;
        line-height: 1.5;
    }

    #boton {
        min-height: 43px;
        font-size: 13px;
        padding: 10px 14px;
    }

    .section-blanco {
        padding: 17px 9px 20px;
        border-radius: 0 0 15px 15px;
    }

    .section-clientes h2 {
        font-size: 19px;
    }

    tbody tr {
        padding: 13px;
        border-radius: 15px;
        margin-bottom: 13px;
    }

    tbody td {
        grid-template-columns: 82px minmax(0, 1fr);
        gap: 7px;
        padding: 6px 0;
        font-size: 11px;
    }

    tbody td::before {
        font-size: 10px;
    }

    .acciones {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 5px;
    }

    .acciones button {
        min-height: 33px;
        padding: 6px 4px;
        font-size: 10px;
    }

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
← INICIO
</a>

</nav>

<h1 class="contrato-titulo">
LISTA DE<br>
PEDIDOS
</h1>

<?php if ($rol === 'admin'): ?>

<a href="formulariopedidos.php" id="boton">
Registrar Pedido
</a>

<?php endif; ?>

<p class="desc">
Visualiza todos los pedidos
registrados en el sistema.<br><br>

Administra información, estados
y roles de manera rápida.
</p>

</section>

<section class="section-blanco">

<section class="section-clientes">

<h2>
Pedidos Registrados
</h2>

</section>

<div class="table-contenedor">

<table>

<thead>

<tr>

<th>ID</th>
<th>Nombre</th>
<th>Fecha</th>
<th>Estado</th>
<th>Nombre vendedor</th>
<th>Dirección</th>
<th>Teléfono</th>
<th style="text-align:center;">
Acciones
</th>

</tr>

</thead>

<tbody>

<?php

if ($rol == "admin") {

    $sql = "SELECT * FROM pedidos";

    $resultado = $conexion->query($sql);

} else {

    $sql = "SELECT * FROM pedidos
            WHERE nombrevendedor = ?";

    $stmt = $conexion->prepare($sql);

    $stmt->bind_param("s", $nombreVendedor);

    $stmt->execute();

    $resultado = $stmt->get_result();
}

if ($resultado && $resultado->num_rows > 0) {

    while ($fila = $resultado->fetch_assoc()) {

        $id = $fila['id'];

        $estado = $fila['estado'];

        echo "<tr>";

        echo "<td>" .
            htmlspecialchars($fila['id']) .
            "</td>";

        echo "<td>" .
            htmlspecialchars($fila['nombre']) .
            "</td>";

        echo "<td>" .
            htmlspecialchars($fila['fecha']) .
            "</td>";

        echo "<td>" .
            htmlspecialchars($fila['estado']) .
            "</td>";

        echo "<td>" .
            htmlspecialchars($fila['nombrevendedor']) .
            "</td>";

        echo "<td>" .
            htmlspecialchars($fila['direccion']) .
            "</td>";

        echo "<td>" .
            htmlspecialchars($fila['telefono']) .
            "</td>";

        echo "<td class='acciones'>";

        if ($rol == "admin") {

            echo "
            <a href='editarpedido.php?id=$id'>
                <button type='button'>
                    Editar
                </button>
            </a>
            ";

            echo "
            <a href='verstockpedido.php?pedido=$id'>
                <button type='button'>
                    Stock
                </button>
            </a>
            ";

            echo "
            <a href='#'
               onclick='confirmarEliminacion($id); return false;'>
                <button type='button'>
                    Eliminar
                </button>
            </a>
            ";
        }

        echo "
        <a href='leerpedido.php?id=$id'
           class='boton-mostrar'>
            <button type='button'>
                Mostrar
            </button>
        </a>
        ";

        if (
            $rol == "vendedor" &&
            $estado == "Pendiente"
        ) {

            echo "
            <a href='verstockpedido.php?pedido=$id'
               class='boton-stock'>
                <button type='button'>
                    Stock
                </button>
            </a>
            ";

            echo "
            <a href='aceptarpedido.php?id=$id'
               class='boton-aceptar'>
                <button type='button'>
                    Aceptar
                </button>
            </a>
            ";

            echo "
            <a href='#'
               class='boton-rechazar'
               onclick='confirmarRechazo($id); return false;'>
                <button type='button'>
                    Rechazar
                </button>
            </a>
            ";
        }

        if ($estado == "En proceso") {

            echo "
            <a href='../Ventas/formularioventas.php?pedido=$id'
               class='boton-venta'>
                <button type='button'>
                    Venta
                </button>
            </a>
            ";
        }

        echo "</td>";

        echo "</tr>";
    }

} else {

    echo "
    <tr>
        <td colspan='8'
            style='text-align:center;padding:35px;color:#777;'>
            Sin pedidos para mostrar.
        </td>
    </tr>
    ";
}

if (isset($stmt) && $stmt) {
    $stmt->close();
}

?>

</tbody>

</table>

</div>

</section>

</section>

<script>

function confirmarEliminacion(id) {

    Swal.fire({

        title: "¿Eliminar pedido?",

        html: `
            <div style="
                font-family:'Fredoka', sans-serif;
                color:#665752;
                font-size:16px;
                line-height:1.5;
            ">
                El pedido será eliminado
                permanentemente.
                <br>
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

            window.location =
                "eliminarpedido.php?id=" + id;

        }

    });

}

function confirmarRechazo(id) {

    Swal.fire({

        title: "¿Rechazar pedido?",

        html: `
            <div style="
                font-family:'Fredoka', sans-serif;
                color:#665752;
                font-size:16px;
                line-height:1.5;
            ">
                El pedido será eliminado
                de la base de datos.
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

        confirmButtonText: "Sí, rechazar",

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

            window.location =
                "leerpedidos.php?rechazar=" + id;

        }

    });

}

<?php if (isset($_GET['rechazado']) && $_GET['rechazado'] == '1'): ?>

Swal.fire({

    title: "¡Pedido rechazado!",

    html: `
        <div style="
            font-family:'Fredoka', sans-serif;
            color:#665752;
            font-size:16px;
        ">
            El pedido fue eliminado
            correctamente.
        </div>
    `,

    icon: "success",

    iconColor: "#0BA84A",

    background: "#FFFDF9",

    confirmButtonText: "Aceptar",

    buttonsStyling: false,

    customClass: {
        popup: "oz-popup",
        title: "oz-title",
        htmlContainer: "oz-text",
        confirmButton: "oz-success"
    }

}).then(() => {

    window.history.replaceState(
        {},
        document.title,
        "leerpedidos.php"
    );

});

<?php endif; ?>

<?php if (isset($_GET['rechazado']) && $_GET['rechazado'] == '0'): ?>

Swal.fire({

    title: "No se pudo rechazar",

    html: `
        <div style="
            font-family:'Fredoka', sans-serif;
            color:#665752;
            font-size:16px;
        ">
            El pedido no pudo ser eliminado.
        </div>
    `,

    icon: "error",

    iconColor: "#D62828",

    background: "#FFFDF9",

    confirmButtonText: "Aceptar",

    buttonsStyling: false,

    customClass: {
        popup: "oz-popup",
        title: "oz-title",
        htmlContainer: "oz-text",
        confirmButton: "oz-confirm"
    }

});

<?php endif; ?>

</script>

</body>

</html>

<?php

$conexion->close();

?>