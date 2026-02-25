<?php
session_start();
include("Connections/conn_produtos.php");

if($_POST){

    $login = $_POST['login_usuario'];
    $senha = $_POST['senha_usuario'];

    $consulta = "
        SELECT *
        FROM tbusuarios
        WHERE login_usuario = '$login'
        AND senha_usuario = '$senha'
    ";

    $resultado = $conn_produtos->query($consulta);

    if($resultado->num_rows > 0){

        $dados = $resultado->fetch_assoc();

        $_SESSION['id_usuario']    = $dados['id_usuario'];
        $_SESSION['login_usuario'] = $dados['login_usuario'];
        $_SESSION['nivel_usuario'] = $dados['nivel_usuario'];

        header("Location: index.php");
        exit;

    }else{

        header("Location: login.php?erro=1");
        exit;
    }
}
?>