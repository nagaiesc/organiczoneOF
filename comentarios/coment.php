<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    $asu=$_POST["asu"];
    $come=$_POST["come"];
    $archivo=fopen("ejemplo.txt","a");
    fwrite($archivo, "ASUNTO:" .PHP_EOL);
    fwrite($archivo,"$asu" .PHP_EOL);
    fwrite($archivo, "COMENTARIO:" .PHP_EOL);
    fwrite($archivo, $come.PHP_EOL);
    echo "<a href='revisar.php'>ir a comentarios</a>"
    ?>
</body>
</html> 