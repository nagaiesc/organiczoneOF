<?php
session_start(); // Inicia la sesión

$conexion = mysqli_connect("localhost","root","","organiczoneBD");

$CI=$_POST['CI'];
$nombre=$_POST['nombre'];
/*$rol = $_POST['rol'];*/

$sql = "SELECT * FROM usuarios
        WHERE CI='$CI'
        AND nombre='$nombre'
        "; 

$resultado = mysqli_query($conexion,$sql);

if(mysqli_num_rows($resultado) > 0){

    $fila = mysqli_fetch_assoc($resultado);

    // Guardar datos en la sesión
    $_SESSION['CI'] = $fila['CI'];
    $_SESSION['nombre'] = $fila['nombre'];
    $_SESSION['rol']=$fila['rol'];
    $_SESSION['estado']=$fila['estado'];
 
    // Movido dentro del bloque de éxito para que evalúe correctamente y no pase de largo al else
    if($_SESSION['rol']=="vendedor"){

        header("Location:vistavendedor.php");
        exit();

    }

if($_SESSION['rol']=="admin"){


    header("Location:../maquetados/maquetadoAdmin.php");
    exit();
    }

}else{
    echo  "Usuario o contraseña incorrectos";
}
?>