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
        // Cada inicio de sesión de cliente comienza sin un pedido activo anterior.
        unset($_SESSION['pedido_id'], $_SESSION['pedido_confirmado']);
        header("Location: ../Cliente/index.php");
        exit();
    }

    echo "Rol de usuario no reconocido.";
    exit();

} else {
    mysqli_stmt_close($stmt);
    mysqli_close($conexion);
    echo "Usuario o contraseña incorrectos";
}
?>
