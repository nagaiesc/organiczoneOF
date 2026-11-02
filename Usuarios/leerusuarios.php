<?php
session_start();
require_once "../seguridad.php";

verificarAdmin();
?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Lista de Usuarios</title>

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
    max-width: 1600px;
    min-height: 820px;
    background: #ffffff;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 10px 45px rgba(43, 20, 13, 0.15);
}


/* =====================================================
   PANEL IZQUIERDO
===================================================== */

.section-negro {
    background: #2B140D;
    color: white;
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
    transition: 0.3s ease;
}

.nav-inner a:hover {
    color: #0ba84a;
}

.contrato-titulo {
    font-size: 52px;
    line-height: 1.05;
    font-weight: 700;
    margin: 0 0 35px 0;
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
    background: #0ba84a;
    color: white;
    padding: 13px 22px;
    border-radius: 50px;
    font-size: 16px;
    font-weight: 700;
    text-decoration: none;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.18);
    transition: all 0.25s ease;
}

#boton:hover {
    background: #ffffff;
    color: #2B140D;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
}


/* =====================================================
   PANEL DERECHO
===================================================== */

.section-blanco {
    background: #ffffff;
    padding: 40px;
    overflow-x: auto;
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


/* =====================================================
   TABLA
===================================================== */

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
    border-bottom: 3px solid #0ba84a;
    white-space: nowrap;
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
    background: #f1fbf5;
}

tbody td {
    padding: 14px 12px;
    border-bottom: 1px solid #eeeeee;
    color: #3a302c;
    font-size: 14px;
    vertical-align: middle;
}

tbody td:nth-child(6) {
    font-weight: 600;
}

th:last-child,
td.col-acciones {
    min-width: 340px;
}


/* =====================================================
   BOTONES DE ACCIONES
   Fila 1: Mostrar · Editar · Eliminar  (3 iguales)
   Fila 2: Rol · Bloqueo                (2 iguales)
===================================================== */

.acciones {
    display: grid;
    grid-template-columns: repeat(6, minmax(0, 1fr));
    gap: 8px;
}

.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
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

.btn svg {
    width: 14px;
    height: 14px;
    flex: 0 0 auto;
}

.btn:hover {
    transform: translateY(-2px);
}

.btn:active {
    transform: scale(0.97);
}

/* Fila 1: tres botones iguales */
.btn-basico {
    grid-column: span 2;
}

/* Fila 2: dos botones iguales (o uno completo si solo hay uno) */
.btn-ancho {
    grid-column: span 3;
}

.btn-ancho:nth-child(4):last-child {
    grid-column: span 6;
}

/* Mostrar */
.btn-mostrar {
    background:#0ba84a;
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
    background: #FBE5E2;
    color: #B3261E;
    border-color: #f1c7c1;
}

.btn-eliminar:hover {
    background: #D62828;
    border-color: #D62828;
    color: #ffffff;
    box-shadow: 0 6px 14px rgba(214, 40, 40, 0.30);
}

/* Hacer vendedor */
.btn-vendedor {
    background: #0ba84a;
    color: #ffffff;
}

.btn-vendedor:hover {
    background: #087c37;
    box-shadow: 0 6px 14px rgba(11, 168, 74, 0.30);
}

/* Hacer usuario */
.btn-usuario {
    background: #ffffff;
    color: #2B140D;
    border-color: #2B140D;
}

.btn-usuario:hover {
    background: #2B140D;
    color: #ffffff;
    box-shadow: 0 6px 14px rgba(43, 20, 13, 0.25);
}

/* Bloquear */
.btn-bloquear {
    background: #B3261E;
    color: #ffffff;
    border-color: #e6b9b3;
}

.btn-bloquear:hover {
    background: #B3261E;
    color: #ffffff;
    box-shadow: 0 6px 14px rgba(179, 38, 30, 0.28);
}

/* Desbloquear */
.btn-desbloquear {
    background: #E5F7EA;
    color: #087A36;
    border-color: #b9e3c6;
}

.btn-desbloquear:hover {
    background: #0ba84a;
    border-color: #0ba84a;
    color: #ffffff;
    box-shadow: 0 6px 14px rgba(11, 168, 74, 0.30);
}


/* =====================================================
   RESPONSIVE
===================================================== */

@media (max-width: 1100px) {

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

    .section-blanco {
        padding: 30px;
    }

    .nav-inner {
        margin-bottom: 40px;
    }

    .contrato-titulo {
        font-size: 44px;
    }

}

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

    .section-blanco {
        padding: 20px;
    }

    .contrato-titulo {
        font-size: 38px;
    }

}


/* =====================================================
   ALERTAS PERSONALIZADAS (SweetAlert2)
   Mismo estilo que la lista de pedidos
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

@media (max-width: 600px) {

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

</style>


<?php include $_SERVER['DOCUMENT_ROOT'] . '/organiczoneOF/includes/oz-navegacion.php'; ?>
</head>


<body>


<section class="principal-grid">


    <!-- =================================================
         PANEL IZQUIERDO
    ================================================== -->

    <section class="section-negro">

        <nav class="nav-inner">
            <a href="../vistaadmin.php">INICIO</a>
        </nav>

        <h1 class="contrato-titulo">
            LISTA DE<br>
            USUARIOS
        </h1>

        <a href="formularioregistro.php" id="boton">
            Registrar Usuario
        </a>

        <p class="desc">
            Visualiza todos los usuarios registrados
            en el sistema.<br><br>

            Administra información, estados
            y roles de manera rápida.
        </p>

    </section>



    <!-- =================================================
         PANEL DERECHO
    ================================================== -->

    <section class="section-blanco">

        <section class="section-clientes">
            <h2>Usuarios Registrados</h2>
        </section>

        <table>

            <thead>
                <tr>
                    <th>CI</th>
                    <th>Nombre</th>
                    <th>Celular</th>
                    <th>Dirección</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>

            <?php

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

                echo "
                <tr>
                    <td colspan='7'>
                        Hubo un error en la conexión
                    </td>
                </tr>";

            }

            $sql = "SELECT * FROM usuarios";

            $resultado = $conexion->query($sql);

            if ($resultado->num_rows > 0) {

                while ($fila = $resultado->fetch_assoc()) {

                    $CI = $fila['CI'];
                    $CIurl = urlencode($CI);
                    $CIattr = htmlspecialchars($CI, ENT_QUOTES, 'UTF-8');
                    $nombreAttr = htmlspecialchars($fila['nombre'], ENT_QUOTES, 'UTF-8');

                    echo "<tr>";
                    echo "<td>" . protegerTexto($fila['CI']) . "</td>";
                    echo "<td>" . protegerTexto($fila['nombre']) . "</td>";
                    echo "<td>" . protegerTexto($fila['celular']) . "</td>";
                    echo "<td>" . protegerTexto($fila['direccion']) . "</td>";
                    echo "<td>" . protegerTexto($fila['rol']) . "</td>";
                    echo "<td>" . protegerTexto($fila['estado']) . "</td>";

                    /*
                    ========================================
                    ACCIONES
                    ========================================
                    */

                    echo "<td class='col-acciones'>";
                    echo "<div class='acciones'>";

                    /* MOSTRAR */
                    echo "
                    <a href='leerusuario.php?CI=$CIurl' class='btn btn-basico btn-mostrar'>
                        Mostrar
                    </a>";

                    /* EDITAR */
                    echo "
                    <a href='editarusuario.php?CI=$CIurl' class='btn btn-basico btn-editar'>
                        Editar
                    </a>";

                    /* ELIMINAR */
                    echo "
                    <a href='#' class='btn btn-basico btn-eliminar'
                       data-ci='$CIattr' data-nombre='$nombreAttr'>
                        Eliminar
                    </a>";

                    /* CAMBIAR ROL */
                    if ($fila["rol"] == "usuario") {

                        echo "
                        <a href='../cambiar/cambiarVendedor.php?CI=$CIurl' class='btn btn-ancho btn-vendedor'>
                            Hacer Vendedor
                        </a>";

                    } elseif ($fila["rol"] == "vendedor") {

                        echo "
                        <a href='../cambiar/cambiarUsuario.php?CI=$CIurl' class='btn btn-ancho btn-usuario'>
                            Hacer Usuario
                        </a>";

                    }

                    /* BLOQUEAR / DESBLOQUEAR */
                    if ($fila["estado"] == "inactivo") {

                        echo "
                        <a href='../cambiar/desbloquear.php?CI=$CIurl' class='btn btn-ancho btn-desbloquear'>
                            Desbloquear
                        </a>";

                    } elseif ($fila["estado"] == "activo") {

                        echo "
                        <a href='../cambiar/bloquear.php?CI=$CIurl' class='btn btn-ancho btn-bloquear'>
                            Bloquear
                        </a>";

                    }

                    echo "</div>";
                    echo "</td>";
                    echo "</tr>";

                }

            } else {

                echo "
                <tr>
                    <td colspan='7'>
                        Sin usuarios para mostrar.
                    </td>
                </tr>";

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

function confirmarEliminacion(CI, nombre) {

    Swal.fire({

        title: "¿Eliminar usuario?",

        html: `
            <div style="
                font-family:'Fredoka', sans-serif;
                color:#665752;
                font-size:16px;
                line-height:1.5;
            ">
                El usuario
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

            window.location =
                "eliminarusuario.php?CI=" + encodeURIComponent(CI);

        }

    });

}

/* Botones "Eliminar" de la tabla */
document.addEventListener("click", function (e) {

    const boton = e.target.closest(".btn-eliminar");

    if (!boton) return;

    e.preventDefault();

    confirmarEliminacion(boton.dataset.ci, boton.dataset.nombre);

});

</script>


</body>

</html>