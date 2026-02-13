<?php
include("../Connections/conn_produtos.php");

if (!isset($_GET['id_marca'])) {
    header("Location: marcas_lista.php");
    exit;
}

$id_marca = (int) $_GET['id_marca'];

$r = $conn_produtos->query(
    "SELECT * FROM tbmarcas WHERE id_marca = $id_marca"
);

if ($r->num_rows == 0) {
    header("Location: marcas_lista.php");
    exit;
}

$marca = $r->fetch_assoc();

if ($_POST) {

    $nome = $_POST['nome_marca'];

    if (!empty($_FILES['imagem_marca']['name'])) {

        $imagem = $_FILES['imagem_marca']['name'];
        move_uploaded_file(
            $_FILES['imagem_marca']['tmp_name'],
            "../imagens/tenis/" . $imagem
        );

        $conn_produtos->query(
            "UPDATE tbmarcas 
             SET nome_marca = '$nome',
                 imagem_marca = '$imagem'
             WHERE id_marca = $id_marca"
        );

    } else {

        $conn_produtos->query(
            "UPDATE tbmarcas 
             SET nome_marca = '$nome'
             WHERE id_marca = $id_marca"
        );
    }

    header("Location: marcas_lista.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Marca</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<?php include("menu.php"); ?>

<div class="container mt-5">
    <div class="card p-4 shadow" style="max-width:420px;margin:auto">

        <div class="d-flex align-items-center mb-3">
            <a href="marcas_lista.php" class="btn btn-warning me-3">←</a>
            <h4 class="mb-0 text-warning fw-bold">Editar Marca</h4>
        </div>

        <form method="post" enctype="multipart/form-data">

            <label class="fw-semibold">Nome</label>
            <input type="text"
                   name="nome_marca"
                   value="<?= $marca['nome_marca']; ?>"
                   class="form-control mb-3"
                   required>

            <label class="fw-semibold">Imagem Atual</label><br>
            <img
                src="../imagens/tenis/<?= $marca['imagem_marca']; ?>"
                width="120"
                class="mb-3 rounded shadow"
            >

            <input type="file"
                   name="imagem_marca"
                   class="form-control mb-3">

            <button class="btn btn-warning w-100 fw-semibold">
                💾 Salvar
            </button>

        </form>

    </div>
</div>

</body>
</html>
