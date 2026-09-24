<?php

session_start();

$conexion = mysqli_connect("localhost","root","","organiczoneBD");

if(!$conexion){
    die("Error en la conexión con la base de datos.");
}

$CI = trim($_POST['CI'] ?? '');
$nombre = trim($_POST['nombre'] ?? '');

if($CI === '' || $nombre === ''){
    die("Debes completar todos los campos.");
}

$stmt = mysqli_prepare(
    $conexion,
    "SELECT * FROM usuarios WHERE CI = ? AND nombre = ? LIMIT 1"
);

mysqli_stmt_bind_param($stmt,"ss",$CI,$nombre);
mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);

if(mysqli_num_rows($resultado) > 0){

    $fila = mysqli_fetch_assoc($resultado);

    $_SESSION['CI'] = $fila['CI'];
    $_SESSION['nombre'] = $fila['nombre'];
    $_SESSION['rol'] = $fila['rol'];
    $_SESSION['estado'] = $fila['estado'];

    $_SESSION['segundoPaso'] = false;

    mysqli_stmt_close($stmt);
    mysqli_close($conexion);

    if($_SESSION['estado'] === "inactivo"){
        header("Location: ../cambiar/verUsuario.php");
        exit();
    }

    if($_SESSION['rol'] === "vendedor" || $_SESSION['rol'] === "admin"){
        header("Location: segundopaso.php");
        exit();
    }

    if($_SESSION['rol'] === "cliente"){
    unset($_SESSION['pedido_id'],$_SESSION['pedido_confirmado']);
    header("Location: ../paginaprincipal.php");
    exit();
}

    echo "Rol de usuario no reconocido.";
    exit();

}else{

    mysqli_stmt_close($stmt);
    mysqli_close($conexion);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Organic Zone</title>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

    <body>

    <script>
    Swal.fire({
        icon:'error',
        title:'¡Ups!',
        text:'Usuario o contraseña incorrectos',
        confirmButtonText:'Intentar de nuevo'
    }).then(()=>{
        window.location.href='formulariosesion.php';
    });
    </script>

    </body>
</html>

<?php
}
?>