<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Lista de Usuarios</title>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

    max-width: 1600px;

    min-height: 820px;

    background: #ffffff;

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
   BOTÓN REGISTRAR USUARIO
===================================================== */

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

    box-shadow:
        0 5px 15px rgba(0, 0, 0, 0.18);

    transition: all 0.25s ease;
}


#boton:hover {

    background: #ffffff;

    color: #2B140D;

    transform: translateY(-2px);

    box-shadow:
        0 8px 20px rgba(0, 0, 0, 0.25);
}


/* =====================================================
   PANEL DERECHO
===================================================== */

.section-blanco {

    background: #ffffff;

    padding: 40px;

    overflow-x: auto;
}


/* =====================================================
   CABECERA
===================================================== */

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


/* =====================================================
   ENCABEZADOS
===================================================== */

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


/* Primera esquina */

thead th:first-child {

    border-radius: 10px 0 0 0;
}


/* Última esquina */

thead th:last-child {

    border-radius: 0 10px 0 0;
}


/* =====================================================
   CUERPO DE TABLA
===================================================== */

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


/* =====================================================
   COLUMNA ACCIONES
===================================================== */

th:last-child {

    min-width: 360px;
}


td.acciones {

    min-width: 360px;

    display: flex;

    flex-wrap: wrap;

    align-items: center;

    gap: 7px;
}


/* =====================================================
   ENLACES
===================================================== */

.acciones a {

    text-decoration: none;

    display: inline-flex;
}


/* =====================================================
   BOTONES
===================================================== */

.acciones button {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    min-height: 34px;

    padding: 8px 12px;

    border: none;

    border-radius: 9px;

    cursor: pointer;

    font-family: 'Fredoka', Arial, sans-serif;

    font-size: 13px;

    font-weight: 600;

    white-space: nowrap;

    transition: all 0.2s ease;
}


/* =====================================================
   EFECTO GENERAL
===================================================== */

.acciones button:hover {

    transform: translateY(-2px);
}


/* =====================================================
   EDITAR
===================================================== */

.acciones a[href*="editarusuario"] button {

    background: #F5EEE3;

    color: #2B140D;

    border: 1px solid #e2d7c8;
}


.acciones a[href*="editarusuario"] button:hover {

    background: #2B140D;

    color: #ffffff;
}


/* =====================================================
   ELIMINAR
===================================================== */

.acciones a[href="#"] button {

    background: #f4e5e1;

    color: #8a3021;

    border: 1px solid #e6cbc5;
}


.acciones a[href="#"] button:hover {

    background: #8a3021;

    color: #ffffff;

    box-shadow:
        0 5px 12px rgba(138, 48, 33, 0.25);
}


/* =====================================================
   MOSTRAR
===================================================== */

.acciones a[href*="leerusuario"] button {

    background: #0ba84a;

    color: #ffffff;
}


.acciones a[href*="leerusuario"] button:hover {

    background: #2B140D;

    color: #ffffff;
}


/* =====================================================
   HACER VENDEDOR
===================================================== */

.acciones a[href*="cambiarVendedor"] button {

    background: #0ba84a;

    color: #ffffff;
}


.acciones a[href*="cambiarVendedor"] button:hover {

    background: #087c37;

    color: #ffffff;

    box-shadow:
        0 5px 12px rgba(11, 168, 74, 0.25);
}


/* =====================================================
   HACER USUARIO
===================================================== */

.acciones a[href*="cambiarUsuario"] button {

    background: #2B140D;

    color: #ffffff;
}


.acciones a[href*="cambiarUsuario"] button:hover {

    background: #4a2115;

    color: #ffffff;

    box-shadow:
        0 5px 12px rgba(43, 20, 13, 0.25);
}


/* =====================================================
   BLOQUEAR
===================================================== */

.acciones a[href*="bloquear"] button {

    background: #f4e5e1;

    color: #8a3021;

    border: 1px solid #e6cbc5;
}


.acciones a[href*="bloquear"] button:hover {

    background: #8a3021;

    color: #ffffff;

    transform: translateY(-2px);

    box-shadow:
        0 5px 12px rgba(138, 48, 33, 0.25);
}


/* =====================================================
   DESBLOQUEAR
===================================================== */

.acciones a[href*="desbloquear"] button {

    background: #0ba84a;

    color: #ffffff;
}


.acciones a[href*="desbloquear"] button:hover {

    background: #087c37;

    transform: translateY(-2px);

    box-shadow:
        0 5px 12px rgba(11, 168, 74, 0.25);
}


/* =====================================================
   CELDA ESTADO
===================================================== */

tbody td:nth-child(6) {

    font-weight: 600;
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

</style>

</head>


<body>


<section class="principal-grid">


    <!-- =================================================
         PANEL IZQUIERDO
    ================================================== -->

    <section class="section-negro">


        <nav class="nav-inner">

            <a href="../vistaadmin.php">

                INICIO

            </a>

        </nav>


        <h1 class="contrato-titulo">

            LISTA DE<br>
            USUARIOS

        </h1>


        <a
            href="formularioregistro.php"
            id="boton"
        >

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


            <h2>

                Usuarios Registrados

            </h2>


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


                while($fila = $resultado->fetch_assoc()) {


                    $CI = $fila['CI'];


                    echo "<tr>";


                    echo "<td>"
                        . $fila['CI'] .
                        "</td>";


                    echo "<td>"
                        . $fila['nombre'] .
                        "</td>";


                    echo "<td>"
                        . $fila['celular'] .
                        "</td>";


                    echo "<td>"
                        . $fila['direccion'] .
                        "</td>";


                    echo "<td>"
                        . $fila['rol'] .
                        "</td>";


                    echo "<td>"
                        . $fila['estado'] .
                        "</td>";


                    /*
                    ========================================
                    ACCIONES
                    ========================================
                    */

                    echo "<td class='acciones'>";


                    /* EDITAR */

                    echo "

                    <a href='editarusuario.php?CI=$CI'>

                        <button>

                            Editar

                        </button>

                    </a>

                    ";


                    /* ELIMINAR */

                    echo "

                    <a
                        href='#'
                        onclick='confirmarEliminacion($CI)'
                    >

                        <button>

                            Eliminar

                        </button>

                    </a>

                    ";


                    /* MOSTRAR */

                    echo "

                    <a href='leerusuario.php?CI=$CI'>

                        <button>

                            Mostrar

                        </button>

                    </a>

                    ";


                    /*
                    ========================================
                    CAMBIAR ROL
                    ========================================
                    */

                    if ($fila["rol"] == "usuario") {


                        echo "

                        <a
                            href='../cambiar/cambiarVendedor.php?CI=$CI'
                        >

                            <button>

                                Hacer Vendedor

                            </button>

                        </a>

                        ";


                    } elseif ($fila["rol"] == "vendedor") {


                        echo "

                        <a
                            href='../cambiar/cambiarUsuario.php?CI=$CI'
                        >

                            <button>

                                Hacer Usuario

                            </button>

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

                        <a
                            href='../cambiar/desbloquear.php?CI=$CI'
                        >

                            <button>

                                Desbloquear

                            </button>

                        </a>

                        ";


                    } elseif ($fila["estado"] == "activo") {


                        echo "

                        <a
                            href='../cambiar/bloquear.php?CI=$CI'
                        >

                            <button>

                                Bloquear

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



<script>


function confirmarEliminacion(CI) {


    Swal.fire({

        title: "¿Estás seguro?",

        text: "No podrás revertir esta acción",

        icon: "warning",

        showCancelButton: true,

        confirmButtonColor: "#0ba84a",

        cancelButtonColor: "#2B140D",

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