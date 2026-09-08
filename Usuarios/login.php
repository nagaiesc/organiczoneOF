<?php
session_start();

$conexion = mysqli_connect("localhost", "root", "", "organiczoneBD");

if (!$conexion) {
    die("Error en la conexión con la base de datos.");
}

$CI = trim($_POST['CI'] ?? '');
$nombre = trim($_POST['nombre'] ?? '');

if ($CI === '' || $nombre === '') {
    die("Debes completar todos los campos.");
}

$stmt = mysqli_prepare(
    $conexion,
    "SELECT * FROM usuarios WHERE CI = ? AND nombre = ? LIMIT 1"
);

mysqli_stmt_bind_param($stmt, "ss", $CI, $nombre);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($resultado) > 0) {

    $fila = mysqli_fetch_assoc($resultado);

    $_SESSION['CI'] = $fila['CI'];
    $_SESSION['nombre'] = $fila['nombre'];
    $_SESSION['rol'] = $fila['rol'];
    $_SESSION['estado'] = $fila['estado'];

    mysqli_stmt_close($stmt);
    mysqli_close($conexion);

    if ($_SESSION['estado'] === "inactivo") {
        header("Location: ../cambiar/verUsuario.php");
        exit();
    }

    if ($_SESSION['rol'] === "vendedor") {
        header("Location: vistavendedor.php");
        exit();
    }

    if ($_SESSION['rol'] === "admin") {
        header("Location: ../vistaadmin.php");
        exit();
    }

    if ($_SESSION['rol'] === "cliente") {
        unset($_SESSION['pedido_id'], $_SESSION['pedido_confirmado']);
        header("Location: ../Cliente/index.php");
        exit();
    }

    echo "Rol de usuario no reconocido.";
    exit();

} else {

    mysqli_stmt_close($stmt);
    mysqli_close($conexion);
    ?>

    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Organic Zone</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <style>
            :root {
                --verde: #12A33C;
                --verde-oscuro: #0A4A1B;
                --crema: #FCD09F;
                --cafe: #2B140D;
                --blanco: #FFFFFF;
            }

            body {
                margin: 0;
                min-height: 100vh;
                background: #F5EEE3;
                font-family: 'Nunito', sans-serif;
            }

            .swal2-popup {
                width: 390px !important;
                padding: 28px 25px 25px !important;
                border-radius: 30px !important;
                background: var(--blanco) !important;
                box-shadow: 0 20px 60px rgba(43, 20, 13, 0.22) !important;
                font-family: 'Nunito', sans-serif !important;
            }

            .swal2-image {
                width: 145px !important;
                height: 145px !important;
                object-fit: contain !important;
                margin: 5px auto 10px !important;
            }

            .swal2-title {
                margin: 5px 0 8px !important;
                color: var(--cafe) !important;
                font-family: 'Fredoka', sans-serif !important;
                font-size: 27px !important;
                font-weight: 700 !important;
            }

            .swal2-html-container {
                margin: 0 15px 20px !important;
                color: #6f756f !important;
                font-family: 'Nunito', sans-serif !important;
                font-size: 17px !important;
                font-weight: 700 !important;
                line-height: 1.4 !important;
            }

            .swal2-confirm {
                min-width: 145px !important;
                height: 48px !important;
                padding: 0 25px !important;
                border: none !important;
                border-radius: 50px !important;
                background: var(--verde) !important;
                color: white !important;
                font-family: 'Nunito', sans-serif !important;
                font-size: 16px !important;
                font-weight: 800 !important;
                box-shadow: 0 8px 18px rgba(18, 163, 60, 0.25) !important;
                transition: 0.3s ease !important;
            }

            .swal2-confirm:hover {
                background: var(--verde-oscuro) !important;
                transform: translateY(-2px) !important;
            }

            .swal2-icon {
                display: none !important;
            }
        </style>
    </head>

    <body>

        <script>
            Swal.fire({
                imageUrl: 'perritoOZ.png',
                imageAlt: 'Perrito Organic Zone',
                title: '¡Ups!',
                html: 'Usuario o contraseña incorrectos',
                confirmButtonText: 'Intentar de nuevo',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: true
            }).then(() => {
                window.location.href = 'formulariosesion.php';
            });
        </script>

    </body>
    </html>

    <?php
}
?>