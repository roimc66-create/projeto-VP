<?php

include("../Connections/conn_produtos.php");

if (!isset($_GET['id_tamanho'])) {
    header("Location: tamanhos_lista.php");
    exit;
}

$id_tamanho = intval($_GET['id_tamanho']);

/* ===== REMOVE DA TABELA RELACIONADA ===== */
$sql_rel = "DELETE FROM tbproduto_tamanho WHERE id_tamanho = ?";
$stmt_rel = $conn_produtos->prepare($sql_rel);
$stmt_rel->bind_param("i", $id_tamanho);
$stmt_rel->execute();

/* ===== REMOVE O TAMANHO ===== */
$sql = "DELETE FROM tbtamanhos WHERE id_tamanho = ?";
$stmt = $conn_produtos->prepare($sql);
$stmt->bind_param("i", $id_tamanho);

if ($stmt->execute()) {
    header("Location: tamanhos_lista.php?excluido=1");
} else {
    echo "Erro ao excluir.";
}

exit;
?>