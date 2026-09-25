<?php

function verificarLogin(){

    if(
        !isset($_SESSION['CI']) ||
        !isset($_SESSION['rol']) ||
        !isset($_SESSION['segundoPaso']) ||
        $_SESSION['segundoPaso'] !== true
    ){

        header("Location: /organiczoneOF/Usuarios/formulariosesion.php");
        exit();

    }

}

function verificarAdmin(){

    verificarLogin();

    if($_SESSION['rol'] !== 'admin'){

        header("Location: /organiczoneOF/paginaprincipal.php");
        exit();

    }

}

function verificarVendedor(){

    verificarLogin();

    if($_SESSION['rol'] !== 'vendedor'){

        header("Location: /organiczoneOF/paginaprincipal.php");
        exit();

    }

}

function verificarAdminVendedor(){

    verificarLogin();

    if(
        $_SESSION['rol'] !== 'admin' &&
        $_SESSION['rol'] !== 'vendedor'
    ){

        header("Location: /organiczoneOF/paginaprincipal.php");
        exit();

    }

}

function protegerTexto($texto){

    return htmlspecialchars(
        $texto,
        ENT_QUOTES,
        'UTF-8'
    );

}

?>