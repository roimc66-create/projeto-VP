<?php
ob_start();
include("protecao.php");
include("../Connections/conn_produtos.php");

$idDel = isset($_GET['id_usuario']) ? (int)$_GET['id_usuario'] : 0;
if ($idDel <= 0) {
    echo "<script>window.open('usuario_lista.php','_self')</script>";
    exit;
}

$idLogado = isset($_SESSION['id_usuario']) ? (int)$_SESSION['id_usuario'] : 0;

// Bloquear se excluir
if ($idLogado > 0 && $idDel === $idLogado) {
    echo "<script>window.open('usuario_lista.php','_self')</script>";
    exit;
}

// Bloquear excluir o último usuário que restou
$rTotal = $conn_produtos->query("SELECT COUNT(*) AS total FROM tbusuarios");
$total = (int)$rTotal->fetch_assoc()['total'];
if ($total <= 1) {
    echo "<script>window.open('usuario_lista.php','_self')</script>";
    exit;
}

// Bloquear excluir o último ADMIN
$rNivel = $conn_produtos->query("SELECT nivel_usuario FROM tbusuarios WHERE id_usuario = $idDel");
if ($rNivel->num_rows == 0) {
    echo "<script>window.open('usuario_lista.php','_self')</script>";
    exit;
}
$nivelDel = $rNivel->fetch_assoc()['nivel_usuario'];

if ($nivelDel === 'admin') {
    $rAdmins = $conn_produtos->query("SELECT COUNT(*) AS total_admin FROM tbusuarios WHERE nivel_usuario = 'admin'");
    $totalAdmin = (int)$rAdmins->fetch_assoc()['total_admin'];

    if ($totalAdmin <= 1) {
        echo "<script>window.open('usuario_lista.php?erro=lastadmin','_self')</script>";
        exit;
    }
}

$stmt = $conn_produtos->prepare("DELETE FROM tbusuarios WHERE id_usuario = ?");
$stmt->bind_param("i", $idDel);
$stmt->execute();

if ($stmt->affected_rows <= 0) {
    $stmt->close();
    echo "<script>window.open('usuario_lista.php','_self')</script>";
    exit;
}

$stmt->close();
echo "<script>window.open('usuario_lista.php','_self')</script>";
exit;
?>