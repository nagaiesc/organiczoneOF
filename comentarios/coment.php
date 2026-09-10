<?php
session_start();

$asu = isset($_POST["asu"]) ? trim($_POST["asu"]) : "";
$come = isset($_POST["come"]) ? trim($_POST["come"]) : "";

$usuario = "Usuario de Organic Zone";

if (isset($_SESSION["nombre"]) && trim($_SESSION["nombre"]) !== "") {
    $usuario = trim($_SESSION["nombre"]);
}

$archivo = fopen("ejemplo.txt", "a");

fwrite($archivo, "USUARIO:" . PHP_EOL);
fwrite($archivo, $usuario . PHP_EOL);
fwrite($archivo, "ASUNTO:" . PHP_EOL);
fwrite($archivo, $asu . PHP_EOL);
fwrite($archivo, "COMENTARIO:" . PHP_EOL);
fwrite($archivo, $come . PHP_EOL);

fclose($archivo);

header("Location: revisar.php");
exit;
?>
