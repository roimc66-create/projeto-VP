<?php
include("../Connections/conn_produtos.php");

/* ====== CONSULTAS PARA OS SELECTS ====== */
$marcas  = $conn_produtos->query("SELECT id_marca, nome_marca FROM tbmarcas ORDER BY nome_marca ASC");
$generos = $conn_produtos->query("SELECT id_genero, nome_genero FROM tbgeneros ORDER BY nome_genero ASC");
$tipos   = $conn_produtos->query("SELECT id_tipo, nome_tipo FROM tbtipos ORDER BY nome_tipo ASC");

/* ====== INSERT ====== */
if ($_POST) {

    if (isset($_POST['enviar'])) {
        $nome_img = $_FILES['imagem_produto']['name'];
        $tmp_img  = $_FILES['imagem_produto']['tmp_name'];
        $dir_img  = "../imagens/exclusivo/" . $nome_img;
        move_uploaded_file($tmp_img, $dir_img);
    }

    $nome_produto     = $_POST['nome_produto'];
    $resumo_produto   = $_POST['resumo_produto'];
    $valor_produto    = $_POST['valor_produto'];
    $imagem_produto   = $_FILES['imagem_produto']['name'];
    $promocao_produto = $_POST['promocao_produto'];
    $sneakers_produto = $_POST['sneakers_produto'];

    $id_marca_produto  = $_POST['id_marca_produto'];
    $id_genero_produto = $_POST['id_genero_produto'];
    $id_tipo_produto   = $_POST['id_tipo_produto'];

    $insertSQL = "
        INSERT INTO tbprodutos (
            id_marca_produto,
            id_genero_produto,
            id_tipo_produto,
            nome_produto,
            resumo_produto,
            valor_produto,
            imagem_produto,
            promoção_produto,
            sneakers_produto
        ) VALUES (
            '$id_marca_produto',
            '$id_genero_produto',
            '$id_tipo_produto',
            '$nome_produto',
            '$resumo_produto',
            '$valor_produto',
            '$imagem_produto',
            '$promocao_produto',
            '$sneakers_produto'
        )
    ";

    $conn_produtos->query($insertSQL);

    header("Location: produtos_lista.php");
    exit;
}
?>