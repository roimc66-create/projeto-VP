<?php
session_start();
include("Connections/conn_produtos.php");

$carrinho = $_SESSION['carrinho'] ?? [];
if(count($carrinho) == 0){
  header("Location: carrinho.php");
  exit;
}

mysqli_begin_transaction($conn_produtos);

try {
  foreach($carrinho as $item){
    $id_produto = (int)$item['id_produto'];
    $id_tamanho = (int)$item['id_tamanho'];
    $qtd = (int)$item['qtd'];

    // baixa estoque somente se tiver quantidade suficiente
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

  // limpar carrinho
  unset($_SESSION['carrinho']);

  header("Location: checkout_sucesso.php");
  exit;

} catch (Exception $e) {
  mysqli_rollback($conn_produtos);
  // você pode melhorar isso exibindo mensagem bonita
  die("Falha no checkout: " . $e->getMessage() . " <a href='carrinho.php'>Voltar</a>");
}