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
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Organic Zone</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link
    href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&display=swap"
    rel="stylesheet"
>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/organiczoneOF/includes/oz-navegacion.php'; ?>

<style>

.swal2-container{
    padding: 18px !important;
}

.oz-alert-popup{

    width: 500px !important;

    max-width: calc(100vw - 30px) !important;

    padding: 0 !important;

    margin: 0 !important;

    background: transparent !important;

    border: none !important;

    outline: none !important;

    box-shadow: none !important;

    overflow: visible !important;

    font-family: 'Fredoka', sans-serif !important;
}

.oz-alert-box{

    position: relative;

    width: 100%;

    min-height: 610px;

    box-sizing: border-box;

    background: #0BA84A;

    border-radius: 28px;

    display: flex;

    flex-direction: column;

    align-items: center;

    overflow: hidden;

}

/* =========================================================
   DETALLES CIRCULARES
   TODOS ESTÁN COMPLETAMENTE DENTRO DE LA CAJA
   ========================================================= */

.oz-circle{

    position: absolute;

    border-radius: 50%;

    pointer-events: none;

    z-index: 1;

}

/* CREMA GRANDE SUPERIOR */

.oz-circle-1{

    width: 142px;
    height: 142px;

    background: #FCD09F;

    top: 25px;
    right: 25px;

}

/* VERDE OSCURO GRANDE */

.oz-circle-2{

    width: 108px;
    height: 108px;

    background: #078F40;

    top: 178px;
    right: 28px;

}

/* VERDE CLARO */

.oz-circle-3{

    width: 68px;
    height: 68px;

    background: #38C96C;

    top: 315px;
    right: 42px;

}

/* CREMA INFERIOR */

.oz-circle-4{

    width: 112px;
    height: 112px;

    background: #FCD09F;

    bottom: 27px;
    left: 28px;

}

/* VERDE CLARO INFERIOR */

.oz-circle-5{

    width: 65px;
    height: 65px;

    background: #38C96C;

    bottom: 145px;
    left: 45px;

}

/* VERDE OSCURO PEQUEÑO */

.oz-circle-6{

    width: 48px;
    height: 48px;

    background: #078F40;

    top: 135px;
    left: 38px;

}

/* CREMA PEQUEÑO */

.oz-circle-7{

    width: 42px;
    height: 42px;

    background: #FCD09F;

    top: 285px;
    left: 48px;

}

/* VERDE CLARO PEQUEÑO */

.oz-circle-8{

    width: 34px;
    height: 34px;

    background: #62D98A;

    top: 95px;
    left: 105px;

}

/* CREMA PEQUEÑO DERECHO */

.oz-circle-9{

    width: 38px;
    height: 38px;

    background: #FCD09F;

    top: 355px;
    right: 105px;

}

/* VERDE OSCURO PEQUEÑO DERECHO */

.oz-circle-10{

    width: 30px;
    height: 30px;

    background: #078F40;

    bottom: 92px;
    right: 105px;

}

/* VERDE CLARO CENTRAL LATERAL */

.oz-circle-11{

    width: 27px;
    height: 27px;

    background: #62D98A;

    top: 235px;
    left: 78px;

}

/* CREMA CENTRAL PEQUEÑO */

.oz-circle-12{

    width: 25px;
    height: 25px;

    background: #FCD09F;

    bottom: 175px;
    right: 55px;

}

/* =========================================================
   MARCA
   ========================================================= */

.oz-alert-brand{

    position: relative;

    z-index: 5;

    width: 100%;

    padding: 25px 28px 0;

    box-sizing: border-box;

    display: flex;

    align-items: center;

}

.oz-alert-brand-left{

    display: flex;

    align-items: center;

    gap: 10px;

}

.oz-alert-brand-mark{

    width: 42px;
    height: 42px;

    background: #F7F3ED;

    color: #2B140D;

    border-radius: 12px;

    display: flex;

    align-items: center;
    justify-content: center;

    font-family: 'Fredoka', sans-serif;

    font-size: 17px;

    font-weight: 700;

}

.oz-alert-brand-name{

    color: #FFFFFF;

    font-size: 18px;

    font-weight: 600;

}

/* =========================================================
   PERRITO
   ========================================================= */

.oz-alert-dog-area{

    position: relative;

    z-index: 4;

    width: 100%;

    height: 280px;

    display: flex;

    align-items: flex-end;

    justify-content: center;

}

.oz-alert-dog{

    width: 255px;

    height: 255px;

    object-fit: contain;

    display: block;

}

/* =========================================================
   TARJETA DE INFORMACIÓN
   ========================================================= */

.oz-alert-content{

    position: relative;

    z-index: 6;

    width: calc(100% - 56px);

    margin: 0 28px 28px;

    padding: 27px 28px 26px;

    box-sizing: border-box;

    background: #F7F3ED;

    border-radius: 27px;

    text-align: center;

}

.oz-alert-tag{

    display: inline-flex;

    align-items: center;

    justify-content: center;

    padding: 7px 15px;

    margin-bottom: 12px;

    background: #E5F7E9;

    color: #078F40;

    border-radius: 20px;

    font-size: 12px;

    font-weight: 600;

    letter-spacing: .3px;

}

.oz-alert-title{

    margin: 0;

    color: #2B140D;

    font-family: 'Fredoka', sans-serif;

    font-size: 39px;

    line-height: 1.05;

    font-weight: 700;

}

.oz-alert-message{

    max-width: 330px;

    margin: 11px auto 22px;

    color: #56382D;

    font-family: 'Fredoka', sans-serif;

    font-size: 17px;

    line-height: 1.4;

    font-weight: 400;

}

.oz-alert-button{

    width: 100%;

    max-width: 270px;

    height: 52px;

    padding: 0 25px;

    border: none !important;

    outline: none !important;

    border-radius: 17px;

    background: #0BA84A;

    color: #FFFFFF;

    font-family: 'Fredoka', sans-serif;

    font-size: 17px;

    font-weight: 600;

    cursor: pointer;

    box-shadow: none !important;

    appearance: none;

    -webkit-appearance: none;

    transition:
        background .15s ease,
        transform .15s ease;

}

.oz-alert-button:hover{

    background: #078F40;

    transform: translateY(-2px);

}

.oz-alert-button:focus{

    outline: none !important;

    border: none !important;

    box-shadow: none !important;

}

.oz-alert-button:active{

    transform: scale(.98);

}

.oz-alert-footer{

    margin-top: 14px;

    color: #8A7065;

    font-family: 'Fredoka', sans-serif;

    font-size: 11px;

}

/* =========================================================
   RESPONSIVE
   ========================================================= */

@media(max-width:520px){

    .swal2-container{

        padding: 12px !important;

    }

    .oz-alert-popup{

        width: calc(100vw - 24px) !important;

    }

    .oz-alert-box{

        min-height: 560px;

        border-radius: 24px;

    }

    .oz-circle-1{

        width: 105px;
        height: 105px;

        top: 20px;
        right: 20px;

    }

    .oz-circle-2{

        width: 80px;
        height: 80px;

        top: 160px;
        right: 22px;

    }

    .oz-circle-3{

        width: 52px;
        height: 52px;

        top: 275px;
        right: 30px;

    }

    .oz-circle-4{

        width: 82px;
        height: 82px;

        bottom: 22px;
        left: 22px;

    }

    .oz-circle-5{

        width: 50px;
        height: 50px;

        bottom: 125px;
        left: 32px;

    }

    .oz-circle-6{

        width: 38px;
        height: 38px;

        top: 120px;
        left: 25px;

    }

    .oz-circle-7{

        width: 32px;
        height: 32px;

        top: 255px;
        left: 30px;

    }

    .oz-circle-8{

        width: 27px;
        height: 27px;

        top: 78px;
        left: 78px;

    }

    .oz-circle-9{

        width: 29px;
        height: 29px;

        top: 310px;
        right: 78px;

    }

    .oz-circle-10{

        width: 24px;
        height: 24px;

        bottom: 75px;
        right: 75px;

    }

    .oz-circle-11{

        width: 21px;
        height: 21px;

        top: 205px;
        left: 60px;

    }

    .oz-circle-12{

        width: 19px;
        height: 19px;

        bottom: 145px;
        right: 38px;

    }

    .oz-alert-brand{

        padding: 19px 20px 0;

    }

    .oz-alert-brand-mark{

        width: 37px;
        height: 37px;

        border-radius: 11px;

        font-size: 15px;

    }

    .oz-alert-brand-name{

        font-size: 16px;

    }

    .oz-alert-dog-area{

        height: 235px;

    }

    .oz-alert-dog{

        width: 215px;
        height: 215px;

    }

    .oz-alert-content{

        width: calc(100% - 36px);

        margin: 0 18px 18px;

        padding: 23px 18px 22px;

        border-radius: 23px;

    }

    .oz-alert-title{

        font-size: 32px;

    }

    .oz-alert-message{

        font-size: 16px;

        max-width: 280px;

        margin-bottom: 20px;

    }

    .oz-alert-button{

        max-width: 100%;

        height: 50px;

        font-size: 16px;

        border-radius: 16px;

    }

}

</style>

</head>

<body>

<script>

Swal.fire({

    html: `

        <div class="oz-alert-box">

            <div class="oz-circle oz-circle-1"></div>
            <div class="oz-circle oz-circle-2"></div>
            <div class="oz-circle oz-circle-3"></div>
            <div class="oz-circle oz-circle-4"></div>
            <div class="oz-circle oz-circle-5"></div>
            <div class="oz-circle oz-circle-6"></div>
            <div class="oz-circle oz-circle-7"></div>
            <div class="oz-circle oz-circle-8"></div>
            <div class="oz-circle oz-circle-9"></div>
            <div class="oz-circle oz-circle-10"></div>
            <div class="oz-circle oz-circle-11"></div>
            <div class="oz-circle oz-circle-12"></div>

            <div class="oz-alert-brand">

                <div class="oz-alert-brand-left">

                    <div class="oz-alert-brand-mark">
                        OZ
                    </div>

                    <div class="oz-alert-brand-name">
                        Organic Zone
                    </div>

                </div>

            </div>

            <div class="oz-alert-dog-area">

                <img
                    src="perritoOZ.png"
                    class="oz-alert-dog"
                    alt="Perrito Organic Zone"
                >

            </div>

            <div class="oz-alert-content">

                <div class="oz-alert-tag">
                    ACCESO NO VÁLIDO
                </div>

                <h2 class="oz-alert-title">
                    ¡Ups!
                </h2>

                <p class="oz-alert-message">
                    El usuario o la contraseña no son correctos.
                    Revisa tus datos e inténtalo nuevamente.
                </p>

                <button
                    type="button"
                    class="oz-alert-button"
                    id="oz-alert-retry"
                >
                    Intentar de nuevo
                </button>

                <div class="oz-alert-footer">
                    Sabor natural · Organic Zone
                </div>

            </div>

        </div>

    `,

    customClass: {
        popup: 'oz-alert-popup'
    },

    showConfirmButton: false,

    allowOutsideClick: false,

    allowEscapeKey: false,

    backdrop: 'rgba(43,20,13,0.50)',

    didOpen: () => {

        const boton = document.getElementById('oz-alert-retry');

        boton.addEventListener('click', () => {

            window.location.href = 'formulariosesion.php';

        });

    }

});

</script>

</body>

</html>

<?php
}
?>