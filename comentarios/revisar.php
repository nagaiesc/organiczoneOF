<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    $a=fopen("ejemplo.txt","r");
    while(!feof($a)){
        $leer=fgets($a);
        $ver=nl2br($leer);
        echo $ver;
    }
    ?>
</body>
</html>