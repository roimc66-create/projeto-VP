<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SESSION['nivel_usuario'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}
?>