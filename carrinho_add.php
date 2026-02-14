<?php
session_start();

include("Connections/conn_produtos.php");

// ================= VALIDAR =================
$id_produto = isset($_POST['id_produto'])
  ? (int)$_POST['id_produto'] : 0;

$id_tamanho = isset($_POST['id_tamanho'])
  ? (int)$_POST['id_tamanho'] : 0;

if($id_produto <= 0){
  die("Produto inválido.");
}

if($id_tamanho <= 0){
  die("Selecione um tamanho.");
}

// ================= VER ESTOQUE =================
$sql = "
  SELECT estoque
  FROM tbproduto_tamanho
  WHERE id_produto = $id_produto
  AND id_tamanho = $id_tamanho
";

$res = $conn_produtos->query($sql);
$row = $res->fetch_assoc();

if(!$row || $row['estoque'] <= 0){
  die("Tamanho esgotado.");
}

// ================= CRIAR CARRINHO =================
if(!isset($_SESSION['carrinho'])){
  $_SESSION['carrinho'] = [];
}

$chave = $id_produto . "-" . $id_tamanho;

if(isset($_SESSION['carrinho'][$chave])){
  $_SESSION['carrinho'][$chave]['qtd']++;
}else{
  $_SESSION['carrinho'][$chave] = [
    'id_produto' => $id_produto,
    'id_tamanho' => $id_tamanho,
    'qtd' => 1
  ];
}

// ================= REDIRECIONAR =================
header("Location: carrinho.php");
exit;
