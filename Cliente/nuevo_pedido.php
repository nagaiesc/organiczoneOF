<?php
session_start();

if (!isset($_SESSION['CI']) || ($_SESSION['rol'] ?? '') !== 'cliente') {
    header('Location: ../Usuarios/formulariosesion.php');
    exit();
}

unset($_SESSION['pedido_id'], $_SESSION['pedido_confirmado']);

header('Location: vistacliente.php');
exit();
