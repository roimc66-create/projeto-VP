<?php
session_start();

// Se não estiver logado
if(!isset($_SESSION['login_usuario'])){
    header("Location: ../login.php");
    exit;
}

// Se não for admin
if($_SESSION['nivel_usuario'] != 'admin'){
    echo "<h2>Acesso negado.</h2>";
    exit;
}
?>