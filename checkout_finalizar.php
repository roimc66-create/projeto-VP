<?php
ob_start();
session_start();
include("Connections/conn_produtos.php");

$carrinho = $_SESSION['carrinho'] ?? [];
if(count($carrinho) == 0){
  echo "<script>window.open('carrinho.php','_self')</script>";
  exit;
}

mysqli_begin_transaction($conn_produtos);

try {
  foreach($carrinho as $item){
    $id_produto = (int)$item['id_produto'];
    $id_tamanho = (int)$item['id_tamanho'];
    $qtd = (int)$item['qtd'];

    $sql = "
      UPDATE tbproduto_tamanho
      SET estoque = estoque - $qtd
      WHERE id_produto = $id_produto
        AND id_tamanho = $id_tamanho
        AND estoque >= $qtd
    ";

    $ok = $conn_produtos->query($sql);
    if(!$ok) throw new Exception("Erro ao atualizar estoque.");

    if($conn_produtos->affected_rows === 0){
      throw new Exception("Sem estoque suficiente para algum item do carrinho.");
    }
  }

  mysqli_commit($conn_produtos);

  unset($_SESSION['carrinho']);

  echo "<script>window.open('checkout_sucesso.php','_self')</script>";
  exit;

} catch (Exception $e) {
  mysqli_rollback($conn_produtos);

  die("Falha no checkout: " . $e->getMessage() . " <a href='carrinho.php'>Voltar</a>");
}