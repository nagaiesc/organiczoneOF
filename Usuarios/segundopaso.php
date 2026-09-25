<?php
session_start();

if(!isset($_SESSION['CI']) || !isset($_SESSION['rol'])){
    header("Location: formulariosesion.php");
    exit();
}

if($_SESSION['rol'] !== 'admin' && $_SESSION['rol'] !== 'vendedor'){
    header("Location: ../Cliente/index.php");
    exit();
}

if(isset($_SESSION['segundoPaso']) && $_SESSION['segundoPaso'] === true){
    if($_SESSION['rol'] === 'admin'){
        header("Location: ../vistaadmin.php");
    }else{
        header("Location: vistavendedor.php");
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Seguridad | Organic Zone</title>

<style>
    body{
        margin:0;
        min-height:100vh;
        display:flex;
        justify-content:center;
        align-items:center;
        background:#F5EEE3;
        font-family:Arial,sans-serif;
    }

    .caja{
        width:400px;
        padding:40px;
        background:white;
        border-radius:30px;
        text-align:center;
        box-shadow:0 10px 30px rgba(0,0,0,.15);
    }

    h1{
        color:#12A33C;
    }

    p{
        color:#555;
    }

    input{
        width:100%;
        padding:15px;
        box-sizing:border-box;
        border:2px solid #12A33C;
        border-radius:12px;
        margin:15px 0;
        font-size:16px;
    }

    button{
        width:100%;
        padding:15px;
        border:0;
        border-radius:12px;
        background:#2B140D;
        color:white;
        font-size:17px;
        cursor:pointer;
    }

    button:hover{
        background:#12A33C;
    }

    .error{
        color:#c62828;
        font-weight:bold;
    }
</style>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/organiczoneOF/includes/oz-navegacion.php'; ?>
</head>

<body>

    <section class="caja">

        <h1>Segunda verificación</h1>
        <p>Por seguridad, debes ingresar la contraseña de acceso de tu rol</p>
        <form action="verificarsegundo.php" method="POST">
            <input type="password" name="segundaclave" placeholder="Contraseña" required>
            <button type="submit">Continuar</button>
        </form>

        <?php
        if(isset($_GET['error'])){
            echo '<p class="error">Contraseña incorrecta</p>';
        }
        ?>

    </section>

</body>
</html>