<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Lista de Usuarios</title>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Fuente Fredoka -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>

/* ============================= */
/* ESTILOS GENERALES */
/* ============================= */

html, body {
    height: 100%;
    margin: 0;
    padding: 0;
    background: #969696;
    font-family: 'Fredoka', sans-serif;
}

body {
    display: flex;
    justify-content: center;
    align-items: center;
}

/* ============================= */
/* CAJA PRINCIPAL */
/* ============================= */

.principal-grid {
    display: grid;
    grid-template-columns: 440px 1fr;
    width: 96vw;
    max-width: 1600px;
    min-height: 820px;

    box-shadow: 0px 6px 40px rgba(88, 88, 88, 0.16);

    border-radius: 10px;
    overflow: hidden;
}

/* ============================= */
/* PANEL IZQUIERDO */
/* ============================= */

.section-negro {
    background: #000;
    color: #fff;
    padding: 40px;
}

.nav-inner a {
    color: #e0e0e0;
    text-decoration: none;
    font-weight: 600;
    font-size: 17px;
}

.nav-inner a:hover {
    color: #0ba84a;
}

.contrato-titulo {
    font-size: 2.6em;
    font-weight: 700;
    margin-top: 40px;
    line-height: 1.1;
}

.desc {
    color: #bababa;
    margin-top: 20px;
    line-height: 1.6;
    font-size: 17px;
}

/* ============================= */
/* BOTON REGISTRAR */
/* ============================= */

#boton {
    display: flex;
    align-items: center;
    justify-content: center;

    gap: 8px;

    background-color: #ffffff;
    color: #000;

    padding: 13px 25px;

    border-radius: 50px;

    font-size: 18px;
    font-weight: 600;

    text-decoration: none;

    width: fit-content;

    margin-top: 25px;

    transition: 0.3s ease;
}

#boton:hover {
    background: #0ba84a;
    color: white;
    transform: translateY(-3px);
}

/* ============================= */
/* PANEL DERECHO */
/* ============================= */

.section-blanco {
    background: #fff;
    padding: 40px;

    overflow-x: auto;
}

.section-clientes {
    border-bottom: 1px solid #eee;
    margin-bottom: 20px;
}

.section-clientes h2 {
    font-size: 30px;
    margin-top: 0;
    margin-bottom: 25px;
    font-weight: 700;
}

/* ============================= */
/* TABLA */
/* ============================= */

table {
    width: 100%;
    border-collapse: collapse;
    min-width: 950px;
}

thead th {
    border-bottom: 3px solid #000;

    padding: 14px 12px;

    text-align: left;

    font-weight: 700;

    font-size: 16px;

    white-space: nowrap;
}

tbody td {
    border-bottom: 1px solid #ddd;

    padding: 14px 12px;

    font-size: 15px;

    vertical-align: middle;
}

tbody tr {
    transition: 0.2s ease;
}

tbody tr:hover {
    background: #f5f5f5;
}

/* ============================= */
/* COLUMNA ACCIONES */
/* ============================= */

th:last-child {
    min-width: 330px;
}

td.acciones {
    min-width: 330px;

    display: flex;

    flex-wrap: wrap;

    align-items: center;

    gap: 8px;
}

/* ============================= */
/* BOTONES DE ACCIONES */
/* ============================= */

.acciones a {
    text-decoration: none;
    display: inline-block;
}

.acciones button {
    background: #000;

    color: #fff;

    border: none;

    padding: 9px 14px;

    cursor: pointer;

    font-family: 'Fredoka', sans-serif;

    font-size: 14px;

    font-weight: 600;

    border-radius: 8px;

    white-space: nowrap;

    transition:
        background-color 0.25s ease,
        color 0.25s ease,
        transform 0.2s ease,
        box-shadow 0.25s ease;
}

/* Efecto general */

.acciones button:hover {
    background: #222;
    transform: translateY(-2px);
}

/* ============================= */
/* BOTON HACER VENDEDOR */
/* ============================= */

.acciones a[href*="cambiarVendedor"] button {
    background: #0ba84a;
}

.acciones a[href*="cambiarVendedor"] button:hover {
    background: #087c37;
    transform: translateY(-2px);
    box-shadow: 0 5px 12px rgba(11, 168, 74, 0.3);
}

/* ============================= */
/* BOTON HACER USUARIO */
/* ============================= */

.acciones a[href*="cambiarUsuario"] button {
    background: #2b140d;
}

.acciones a[href*="cambiarUsuario"] button:hover {
    background: #4a2115;
    transform: translateY(-2px);
    box-shadow: 0 5px 12px rgba(43, 20, 13, 0.3);
}

/* ============================= */
/* BOTON BLOQUEAR */
/* ============================= */

.acciones a[href*="bloquear"] button {
    background: #000;
}

/* Al pasar el mouse se vuelve rojo */

.acciones a[href*="bloquear"] button:hover {
    background: #d62828;

    color: #fff;

    transform: scale(1.05);

    box-shadow:
        0 0 0 3px rgba(214, 40, 40, 0.15),
        0 6px 15px rgba(214, 40, 40, 0.35);
}

/* ============================= */
/* BOTON DESBLOQUEAR */
/* ============================= */

.acciones a[href*="desbloquear"] button {
    background: #0ba84a;
}

.acciones a[href*="desbloquear"] button:hover {
    background: #087c37;

    transform: scale(1.05);

    box-shadow: 0 6px 15px rgba(11, 168, 74, 0.3);
}

/* ============================= */
/* EDITAR */
/* ============================= */

.acciones a[href*="editarusuario"] button {
    background: #000;
}

.acciones a[href*="editarusuario"] button:hover {
    background: #333;
}

/* ============================= */
/* ELIMINAR */
/* ============================= */

.acciones a[href="#"] button {
    background: #000;
}

.acciones a[href="#"] button:hover {
    background: #d62828;
}

/* ============================= */
/* MOSTRAR */
/* ============================= */

.acciones a[href*="leerusuario"] button {
    background: #555;
}

.acciones a[href*="leerusuario"] button:hover {
    background: #333;
}

/* ============================= */
/* RESPONSIVE */
/* ============================= */

@media (max-width: 1100px) {

    body {
        align-items: flex-start;
        padding: 20px;
        box-sizing: border-box;
    }

    .principal-grid {
        grid-template-columns: 1fr;
        width: 100%;
        min-height: auto;
    }

    .section-negro {
        padding: 30px;
    }

    .section-blanco {
        padding: 30px;
    }

}

</style>
</head>

<body>

<section class="principal-grid">

    <!-- ============================= -->
    <!-- PANEL IZQUIERDO -->
    <!-- ============================= -->

    <section class="section-negro">

        <nav class="nav-inner">
            <a href="../maquetados/maquetadoAdmin.php">
                INICIO
            </a>
        </nav>

        <h1 class="contrato-titulo">
            LISTA DE USUARIOS
        </h1>

        <a href="formularioregistro.php" id="boton">
            Registrar Usuario
        </a>

        <p class="desc">
            Visualiza todos los usuarios registrados en el sistema.<br>
            Administra información, estados y roles de manera rápida.
        </p>

    </section>


    <!-- ============================= -->
    <!-- PANEL DERECHO -->
    <!-- ============================= -->

    <section class="section-blanco">

        <section class="section-clientes">

            <h2>
                Usuarios Registrados
            </h2>

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

                    echo "<tr>
                            <td colspan='7'>
                                Hubo un error en la conexión
                            </td>
                          </tr>";

                }


                $sql = "SELECT * FROM usuarios";

                $resultado = $conexion->query($sql);


                if ($resultado->num_rows > 0) {

                    while($fila = $resultado->fetch_assoc()) {

                        $CI = $fila['CI'];

                        echo "<tr>";

                        echo "<td>" . $fila['CI'] . "</td>";

                        echo "<td>" . $fila['nombre'] . "</td>";

                        echo "<td>" . $fila['celular'] . "</td>";

                        echo "<td>" . $fila['direccion'] . "</td>";

                        echo "<td>" . $fila['rol'] . "</td>";

                        echo "<td>" . $fila['estado'] . "</td>";


                        /*
                        ========================================
                        ACCIONES
                        ========================================
                        */

                        echo "<td class='acciones'>";


                        /* EDITAR */

                        echo "
                        <a href='editarusuario.php?CI=$CI'>
                            <button>Editar</button>
                        </a>
                        ";


                        /* ELIMINAR */

                        echo "
                        <a href='#' onclick='confirmarEliminacion($CI)'>
                            <button>Eliminar</button>
                        </a>
                        ";


                        /* MOSTRAR */

                        echo "
                        <a href='leerusuario.php?CI=$CI'>
                            <button>Mostrar</button>
                        </a>
                        ";


                        /*
                        ========================================
                        CAMBIAR ROL
                        ========================================
                        */

                        if ($fila["rol"] == "usuario") {

                            echo "
                            <a href='../cambiar/cambiarVendedor.php?CI=$CI'>
                                <button>Hacer Vendedor</button>
                            </a>
                            ";

                        } elseif ($fila["rol"] == "vendedor") {

                            echo "
                            <a href='../cambiar/cambiarUsuario.php?CI=$CI'>
                                <button>Hacer Usuario</button>
                            </a>
                            ";

                        }


                        /*
                        ========================================
                        BLOQUEAR / DESBLOQUEAR
                        ========================================
                        */

                        if ($fila["estado"] == "inactivo") {

                            echo "
                            <a href='../cambiar/desbloquear.php?CI=$CI'>
                                <button>Desbloquear</button>
                            </a>
                            ";

                        } elseif ($fila["estado"] == "activo") {

                            echo "
                            <a href='../cambiar/bloquear.php?CI=$CI'>
                                <button>Bloquear</button>
                            </a>
                            ";

                        }


                        echo "</td>";

                        echo "</tr>";

                    }

                } else {

                    echo "
                    <tr>
                        <td colspan='7'>
                            Sin usuarios para mostrar.
                        </td>
                    </tr>
                    ";

                }

                ?>

                </tbody>

            </table>

        </section>

    </section>

</section>


<script>

function confirmarEliminacion(CI) {

    Swal.fire({

        title: "¿Estás seguro?",

        text: "No podrás revertir esta acción",

        icon: "warning",

        showCancelButton: true,

        confirmButtonColor: "#3085d6",

        cancelButtonColor: "#d33",

        confirmButtonText: "Sí, eliminar",

        cancelButtonText: "Cancelar"

    }).then((result) => {

        if (result.isConfirmed) {

            window.location =
                "eliminarusuario.php?CI=" + CI;

        }

    });

}

</script>

</body>
</html>
