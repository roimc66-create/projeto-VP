<?php
session_start();

$chave = isset($_GET['chave']) ? $_GET['chave'] : '';

if($chave && isset($_SESSION['carrinho'][$chave])){
    unset($_SESSION['carrinho'][$chave]);
}

header("Location: carrinho.php");
exit;
