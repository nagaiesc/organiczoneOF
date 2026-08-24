<?php
session_start();

unset($_SESSION['pedido_id'], $_SESSION['pedido_confirmado']);

header('Location: index.php');
exit();
