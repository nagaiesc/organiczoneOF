<?php

    session_start();

    if(!isset($_SESSION['CI']) || !isset($_SESSION['rol'])){
        header("Location: formulariosesion.php");
        exit();
    }

    $clave = $_POST['segundaclave'] ?? '';

    $claveAdmin = '$2y$12$.OvqhRgy51cRcFOTl0CM/OmQFXkrQNM8Bjn10bc2MP02ISzYWazeS';
    $claveVendedor = '$2y$12$nJUNP6XrIjqZ27pZ3xRdhej1OzRtfqBrwtWWmt0Wc5zgGu1zXTk0G';

    $correcta = false;

    if($_SESSION['rol'] === 'admin'){
        if(password_verify($clave,$claveAdmin)){
            $correcta = true;
        }
    }

    if($_SESSION['rol'] === 'vendedor'){
        if(password_verify($clave,$claveVendedor)){
            $correcta = true;
        }
    }

    if(!$correcta){
        header("Location: segundopaso.php?error=1");
        exit();
    }

    session_regenerate_id(true);

    $_SESSION['segundoPaso'] = true;

    if($_SESSION['rol'] === 'admin'){
        header("Location: ../vistaadmin.php");
        exit();
    }

    if($_SESSION['rol'] === 'vendedor'){
        header("Location: vistavendedor.php");
        exit();
    }

    header("Location: formulariosesion.php");
    exit();
?>