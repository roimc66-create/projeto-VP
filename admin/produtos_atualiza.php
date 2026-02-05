<?php
include("../Connections/conn_produtos.php");

/* ===== PEGA O ID ===== */
if (!isset($_GET['id_produto'])) {
    header("Location: produtos_lista.php");
    exit;
}

$id_produto = $_GET['id_produto'];

/* ===== BUSCA PRODUTO ===== */
$sqlProduto = "SELECT * FROM tbprodutos WHERE id_produto = $id_produto";
$resultProduto = $conn_produtos->query($sqlProduto);
$produto = $resultProduto->fetch_assoc();

/* ===== SELECTS ===== */
$marcas  = $conn_produtos->query("SELECT id_marca, nome_marca FROM tbmarcas ORDER BY nome_marca");
$generos = $conn_produtos->query("SELECT id_genero, nome_genero FROM tbgeneros ORDER BY nome_genero");
$tipos   = $conn_produtos->query("SELECT id_tipo, nome_tipo FROM tbtipos ORDER BY nome_tipo");

/* ===== UPDATE ===== */
if ($_POST) {

    $nome_produto   = $_POST['nome_produto'];
    $resumo_produto = $_POST['resumo_produto'];
    $valor_produto  = $_POST['valor_produto'];

    $id_marca_produto  = $_POST['id_marca_produto'];
    $id_genero_produto = $_POST['id_genero_produto'];
    $id_tipo_produto   = $_POST['id_tipo_produto'];

    if (!empty($_FILES['imagem_produto']['name'])) {

        $imagem = $_FILES['imagem_produto']['name'];
        move_uploaded_file(
            $_FILES['imagem_produto']['tmp_name'],
            "../imagens/exclusivo/" . $imagem
        );

        $sqlUpdate = "
            UPDATE tbprodutos SET
                id_marca_produto  = '$id_marca_produto',
                id_genero_produto = '$id_genero_produto',
                id_tipo_produto   = '$id_tipo_produto',
                nome_produto      = '$nome_produto',
                resumo_produto    = '$resumo_produto',
                valor_produto     = '$valor_produto',
                imagem_produto    = '$imagem'
            WHERE id_produto = $id_produto
        ";

    } else {

        $sqlUpdate = "
            UPDATE tbprodutos SET
                id_marca_produto  = '$id_marca_produto',
                id_genero_produto = '$id_genero_produto',
                id_tipo_produto   = '$id_tipo_produto',
                nome_produto      = '$nome_produto',
                resumo_produto    = '$resumo_produto',
                valor_produto     = '$valor_produto'
            WHERE id_produto = $id_produto
        ";
    }

    $conn_produtos->query($sqlUpdate);
    header("Location: produtos_lista.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Produto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<?php include("menu.php"); ?>

<div class="container mt-5">
    <div class="card p-4 shadow">
        <h3 class="text-warning fw-bold mb-4">✏ Editar Produto</h3>

        <form method="post" enctype="multipart/form-data">

            <label>Nome</label>
            <input type="text" name="nome_produto" class="form-control mb-3"
                   value="<?= $produto['nome_produto']; ?>" required>

            <label>Resumo</label>
            <textarea name="resumo_produto" class="form-control mb-3" required><?= $produto['resumo_produto']; ?></textarea>

            <label>Valor</label>
            <input type="number" step="0.01" name="valor_produto"
                   value="<?= $produto['valor_produto']; ?>" class="form-control mb-3">

            <label>Marca</label>
            <select name="id_marca_produto" class="form-select mb-3">
                <?php while($m = $marcas->fetch_assoc()) { ?>
                    <option value="<?= $m['id_marca']; ?>"
                        <?= $m['id_marca'] == $produto['id_marca_produto'] ? 'selected' : '' ?>>
                        <?= $m['nome_marca']; ?>
                    </option>
                <?php } ?>
            </select>

            <label>Imagem (opcional)</label><br>
            <img src="../imagens/exclusivo/<?= $produto['imagem_produto']; ?>" width="120" class="mb-2 rounded">
            <input type="file" name="imagem_produto" class="form-control mb-3">

            <button class="btn btn-warning w-100 fw-bold">
                💾 Salvar Alterações
            </button>

        </form>
    </div>
</div>

</body>
</html>
