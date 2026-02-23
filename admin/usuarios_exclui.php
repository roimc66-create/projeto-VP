<?php
include("protecao.php");
include("../Connections/conn_produtos.php");

// ID alvo
$idDel = isset($_GET['id_usuario']) ? (int)$_GET['id_usuario'] : 0;
if ($idDel <= 0) {
    header("Location: usuario_lista.php?erro=notfound");
    exit;
}

// ID logado (ajuste se sua sessão usar outro nome)
$idLogado = isset($_SESSION['id_usuario']) ? (int)$_SESSION['id_usuario'] : 0;

// 1) Bloquear auto-exclusão
if ($idLogado > 0 && $idDel === $idLogado) {
    header("Location: usuario_lista.php?erro=self");
    exit;
}

// 2) Bloquear excluir o último usuário
$rTotal = $conn_produtos->query("SELECT COUNT(*) AS total FROM tbusuarios");
$total = (int)$rTotal->fetch_assoc()['total'];
if ($total <= 1) {
    header("Location: usuario_lista.php?erro=last");
    exit;
}

// 3) (Recomendado) Bloquear excluir o último ADMIN
$rNivel = $conn_produtos->query("SELECT nivel_usuario FROM tbusuarios WHERE id_usuario = $idDel");
if ($rNivel->num_rows == 0) {
    header("Location: usuario_lista.php?erro=notfound");
    exit;
}
$nivelDel = $rNivel->fetch_assoc()['nivel_usuario'];

if ($nivelDel === 'admin') {
    $rAdmins = $conn_produtos->query("SELECT COUNT(*) AS total_admin FROM tbusuarios WHERE nivel_usuario = 'admin'");
    $totalAdmin = (int)$rAdmins->fetch_assoc()['total_admin'];

    if ($totalAdmin <= 1) {
        header("Location: usuario_lista.php?erro=lastadmin");
        exit;
    }
}

// 4) Deletar (mais seguro: prepared)
$stmt = $conn_produtos->prepare("DELETE FROM tbusuarios WHERE id_usuario = ?");
$stmt->bind_param("i", $idDel);
$stmt->execute();

if ($stmt->affected_rows <= 0) {
    $stmt->close();
    header("Location: usuario_lista.php?erro=notfound");
    exit;
}

$stmt->close();
header("Location: usuario_lista.php");
exit;
?>