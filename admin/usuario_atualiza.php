<?php
include("../Connections/conn_produtos.php");

/* ===== VALIDAR ID ===== */
if (!isset($_GET['id_usuario'])) {
    header("Location: usuario_lista.php");
    exit;
}

$id_usuario = (int) $_GET['id_usuario'];

/* ===== BUSCAR usuario ===== */
$sqlProduto = "SELECT * FROM tbusuarios WHERE id_usuario = $id_usuario";
$result = $conn_produtos->query($sqlUsuario);

if ($result->num_rows == 0) {
    header("Location: usuario_lista.php");
    exit;
}

$usuario = $result->fetch_assoc();

/* ===== BUSCAR MARCAS ===== */
$marcas = $conn_produtos->query("
    SELECT id_usuario, login_usuario 
    FROM tbusuarios
    ORDER BY login_usuario
");

/* ===== UPDATE ===== */
if (isset($_POST['salvar'])) {

    $login   = $_POST['login_usuario'];
    $resumo = $_POST['resumo_produto'];
    $valor  = $_POST['valor_produto'];
    $marca  = $_POST['id_marca_produto'];

    // SE TROCOU A IMAGEM
    if (!empty($_FILES['imagem_produto']['name'])) {

        $imagem = $_FILES['imagem_produto']['name'];
        move_uploaded_file(
            $_FILES['imagem_produto']['tmp_name'],
            "../imagens/exclusivo/" . $imagem
        );

        $sqlUpdate = "
            UPDATE tbprodutos SET
                nome_produto = '$nome',
                resumo_produto = '$resumo',
                valor_produto = '$valor',
                id_marca_produto = '$marca',
                imagem_produto = '$imagem'
            WHERE id_produto = $id_produto
        ";

    } else {

        $sqlUpdate = "
            UPDATE tbprodutos SET
                nome_produto = '$nome',
                resumo_produto = '$resumo',
                valor_produto = '$valor',
                id_marca_produto = '$marca'
            WHERE id_produto = $id_produto
        ";
    }

    if ($conn_produtos->query($sqlUpdate)) {
        header("Location: produtos_lista.php");
        exit;
    } else {
        echo "ERRO AO SALVAR: " . $conn_produtos->error;
    }
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

        <form method="POST" enctype="multipart/form-data">

            <label class="fw-bold">Nome</label>
            <input type="text" name="nome_produto"
                   value="<?= $produto['nome_produto']; ?>"
                   class="form-control mb-3" required>

            <label class="fw-bold">Resumo</label>
            <textarea name="resumo_produto"
                      class="form-control mb-3"
                      required><?= $produto['resumo_produto']; ?></textarea>

            <label class="fw-bold">Valor</label>
            <input type="number" step="0.01"
                   name="valor_produto"
                   value="<?= $produto['valor_produto']; ?>"
                   class="form-control mb-3" required>

            <label class="fw-bold">Marca</label>
            <select name="id_marca_produto" class="form-select mb-3">
                <?php while ($m = $marcas->fetch_assoc()) { ?>
                    <option value="<?= $m['id_marca']; ?>"
                        <?= $m['login_'] == $produto['id_marca_produto'] ? 'selected' : '' ?>>
                        <?= $m['nome_marca']; ?>
                    </option>
                <?php } ?>
            </select>

            <label class="fw-bold">Imagem Atual</label><br>
            <img src="../imagens/exclusivo/<?= $produto['imagem_produto']; ?>"
                 width="120" class="mb-3 rounded shadow">

            <input type="file" name="imagem_produto" class="form-control mb-4">

            <button type="submit" name="salvar"
                    class="btn btn-warning w-100 fw-bold">
                💾 Salvar Alterações
            </button>

        </form>

    </div>
</div>

</body>
</html>
