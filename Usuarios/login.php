<?php
session_start(); // Inicia la sesión

$conexion = mysqli_connect("localhost","root","","organiczoneBD");

$CI=$_POST['CI'];
$nombre=$_POST['nombre'];
$rol = $_POST['rol'];
$estado = $_POST['estado'];

$sql = "SELECT * FROM usuarios
        WHERE CI='$CI'
        AND nombre='$nombre'
        AND rol='$rol'
        AND estado='$estado'"; 

$resultado = mysqli_query($conexion,$sql);

if(mysqli_num_rows($resultado) > 0){

    $fila = mysqli_fetch_assoc($resultado);

    // Guardar datos en la sesión
    $_SESSION['CI'] = $fila['CI'];
    $_SESSION['nombre'] = $fila['nombre'];
    $_SESSION['rol']=$fila['rol'];
    $_SESSION['estado']=$fila['estado'];
}if($_SESSION['rol']==¨Administrador¨){



    header("Location: ../maquetados/maquetadoAdmin.php");

}
if($_SESSION['rol']==¨Vendedor¨){



    header("Location: ../maquetados/maquetadovendedor.php");

}else{
    echo "Usuario o contraseña incorrectos";
   
}

?>
