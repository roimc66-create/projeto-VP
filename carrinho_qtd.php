<?php
ob_start();
session_start();

$acao = isset($_GET['acao']) ? $_GET['acao'] : '';
$chave = isset($_GET['chave']) ? $_GET['chave'] : '';

if($chave && isset($_SESSION['carrinho'][$chave])){

    if($acao === 'mais'){
        $_SESSION['carrinho'][$chave]['qtd']++;
    }

    if($acao === 'menos'){
        $_SESSION['carrinho'][$chave]['qtd']--;
        if($_SESSION['carrinho'][$chave]['qtd'] <= 0){
            unset($_SESSION['carrinho'][$chave]);
        }
    }
}
echo "<script>window.open('carrinho.php','_self')</script>";
exit;
