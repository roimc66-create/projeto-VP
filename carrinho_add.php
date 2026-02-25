<?php
session_start();
include("Connections/conn_produtos.php");

$id_produto = isset($_POST['id_produto']) ? (int)$_POST['id_produto'] : 0;
$id_tamanho = $_POST['id_tamanho'] ?? '';

if ($id_produto <= 0) {
  die("Produto inválido.");
}

if ($id_tamanho === '' || $id_tamanho === null) {
  die("Selecione um tamanho.");
}

if (!isset($_SESSION['carrinho'])) {
  $_SESSION['carrinho'] = [];
}

/* se vier número (id_tamanho), usa direto */
if (is_numeric($id_tamanho)) {

  $id_tamanho = (int)$id_tamanho;

  $sql = "
    SELECT estoque
    FROM tbproduto_tamanho
    WHERE id_produto = {$id_produto}
      AND id_tamanho = {$id_tamanho}
    LIMIT 1
  ";

  $res = $conn_produtos->query($sql) or die("Erro: ".$conn_produtos->error);
  $row = $res->fetch_assoc();

  if (!$row || (int)$row['estoque'] <= 0) {
    die("Tamanho esgotado.");
  }

  $chave = $id_produto . "-" . $id_tamanho;

  if (isset($_SESSION['carrinho'][$chave])) {
    $_SESSION['carrinho'][$chave]['qtd']++;
  } else {
    $_SESSION['carrinho'][$chave] = [
      'id_produto' => $id_produto,
      'id_tamanho' => $id_tamanho,
      'qtd' => 1
    ];
  }

  header("Location: carrinho.php");
  exit;
}

/* se vier texto (P/M/G/GG ou "38"), converte para id_tamanho pela tabela tbtamanhos.numero_tamanho */
$tamanho_txt = trim($id_tamanho);
$tamanho_esc = $conn_produtos->real_escape_string($tamanho_txt);

$sql = "
  SELECT pt.estoque, pt.id_tamanho
  FROM tbproduto_tamanho pt
  INNER JOIN tbtamanhos t
    ON t.id_tamanho = pt.id_tamanho
  WHERE pt.id_produto = {$id_produto}
    AND t.numero_tamanho = '{$tamanho_esc}'
  LIMIT 1
";

$res = $conn_produtos->query($sql) or die("Erro: ".$conn_produtos->error);
$row = $res->fetch_assoc();

if (!$row || (int)$row['estoque'] <= 0) {
  die("Tamanho esgotado.");
}

$id_tamanho_real = (int)$row['id_tamanho'];

$chave = $id_produto . "-" . $id_tamanho_real;

if (isset($_SESSION['carrinho'][$chave])) {
  $_SESSION['carrinho'][$chave]['qtd']++;
} else {
  $_SESSION['carrinho'][$chave] = [
    'id_produto' => $id_produto,
    'id_tamanho' => $id_tamanho_real,
    'qtd' => 1
  ];
}

header("Location: carrinho.php");
exit;
?>