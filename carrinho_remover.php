<?php
ob_start();
session_start();

$chave = isset($_GET['chave']) ? $_GET['chave'] : '';

if($chave && isset($_SESSION['carrinho'][$chave])){
    unset($_SESSION['carrinho'][$chave]);
}
echo "<script>window.open('carrinho.php','_self')</script>";
exit;
?>