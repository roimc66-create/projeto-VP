<?php
ob_start();
include("../Connections/conn_produtos.php");

/* Validar ID*/
if (!isset($_GET['id_produto'])) {
    header("Location: produtos_lista.php");
    exit;
}

$id_produto = (int) $_GET['id_produto'];

/* Acha o Produto */
$sqlProduto = "SELECT * FROM tbprodutos WHERE id_produto = $id_produto";
$result = $conn_produtos->query($sqlProduto);

if ($result->num_rows == 0) {
    echo "<script>window.open('produtos_lista.php','_self')</script>";  
    exit;
}

$produto = $result->fetch_assoc();

/* Buscar */
$lista_marcas   = $conn_produtos->query("SELECT * FROM tbmarcas ORDER BY nome_marca ASC");
$lista_generos  = $conn_produtos->query("SELECT * FROM tbgeneros ORDER BY nome_genero ASC");
$lista_tipos    = $conn_produtos->query("SELECT * FROM tbtipos ORDER BY nome_tipo ASC");
$lista_tamanhos = $conn_produtos->query("SELECT * FROM tbtamanhos ORDER BY numero_tamanho ASC");

/* Tamanho que é do produto */
$tamanhos_prod = [];
$resTam = $conn_produtos->query("
    SELECT id_tamanho, estoque
    FROM tbproduto_tamanho
    WHERE id_produto = $id_produto
");

while ($t = $resTam->fetch_assoc()) {
    $tamanhos_prod[$t['id_tamanho']] = $t['estoque'];
}

/* Atualizar */
if (isset($_POST['salvar'])) {

    $nome   = $_POST['nome_produto'] ?? '';
    $resumo = $_POST['resumo_produto'] ?? '';
    $valor  = $_POST['valor_produto'] ?? 0;
    $marca  = $_POST['id_marca_produto'] ?? 0;
    $genero = $_POST['id_genero_produto'] ?? 0;
    $tipo   = $_POST['id_tipo_produto'] ?? 0;

    // novos (promo e sneakers)
    $promo  = $_POST['promoção_produto'] ?? 'Não';
    $sneak  = $_POST['sneakers_produto'] ?? 'Not';

    /* Imagem */
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
                id_genero_produto = '$genero',
                id_tipo_produto = '$tipo',
                promoção_produto = '$promo',
                sneakers_produto = '$sneak',
                imagem_produto = '$imagem'
            WHERE id_produto = $id_produto
        ";

    } else {

        $sqlUpdate = "
            UPDATE tbprodutos SET
                nome_produto = '$nome',
                resumo_produto = '$resumo',
                valor_produto = '$valor',
                id_marca_produto = '$marca',
                id_genero_produto = '$genero',
                id_tipo_produto = '$tipo',
                promoção_produto = '$promo',
                sneakers_produto = '$sneak'
            WHERE id_produto = $id_produto
        ";
    }

    $conn_produtos->query($sqlUpdate);

    /* Atualizar os tamanhos */
    $conn_produtos->query("DELETE FROM tbproduto_tamanho WHERE id_produto = $id_produto");

    if (isset($_POST['tamanhos'])) {
        foreach ($_POST['tamanhos'] as $id_tamanho) {

            $estoque = $_POST['estoque'][$id_tamanho] ?? 0;

            $conn_produtos->query("
                INSERT INTO tbproduto_tamanho
                (id_produto, id_tamanho, estoque)
                VALUES
                ('$id_produto', '$id_tamanho', '$estoque')
            ");
        }
    }

    header("Location: produtos_lista.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Editar Produto</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body { background: #ffffff; min-height: 100vh; }
.card-custom {
    border-radius: 18px;
    padding: 30px;
    background: #fff;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    margin-top: 50px;
}
.preview-img {
    max-height: 140px;
    border-radius: 10px;
    margin-bottom: 10px;
}
</style>
</head>

<body>

<?php include("menu.php"); ?>

<main class="container">

<div class="row justify-content-center">
<div class="col-12 col-md-10 col-lg-8">

<div class="card-custom">

<div class="d-flex align-items-center mb-3">
    <a href="produtos_lista.php" class="btn btn-warning me-3">←</a>
    <h4 class="mb-0 text-warning fw-bold">Editar Produto</h4>
</div>

<div class="alert alert-warning">

<form method="POST" enctype="multipart/form-data">

<div class="mb-3">
<label class="form-label fw-semibold">Nome do Produto</label>
<input type="text" name="nome_produto"
       value="<?= $produto['nome_produto']; ?>"
       class="form-control" required>
</div>

<div class="mb-3">
<label class="form-label fw-semibold">Resumo</label>
<textarea name="resumo_produto"
          class="form-control"
          rows="3"
          required><?= $produto['resumo_produto']; ?></textarea>
</div>

<div class="mb-3">
<label class="form-label fw-semibold">Valor</label>
<input type="number" step="0.01"
       name="valor_produto"
       value="<?= $produto['valor_produto']; ?>"
       class="form-control" required>
</div>

<div class="row">

  <div class="col-md-4 mb-3">
    <label class="form-label fw-semibold">Marca</label>
    <select name="id_marca_produto" class="form-select" required>
      <?php while($m = $lista_marcas->fetch_assoc()){ ?>
      <option value="<?= $m['id_marca']; ?>"
        <?= ($m['id_marca'] == $produto['id_marca_produto']) ? 'selected' : '' ?>>
        <?= $m['nome_marca']; ?>
      </option>
      <?php } ?>
    </select>
  </div>

  <div class="col-md-4 mb-3">
    <label class="form-label fw-semibold">Gênero</label>
    <select name="id_genero_produto" class="form-select" required>
      <?php while($g = $lista_generos->fetch_assoc()){ ?>
      <option value="<?= $g['id_genero']; ?>"
        <?= ($g['id_genero'] == $produto['id_genero_produto']) ? 'selected' : '' ?>>
        <?= $g['nome_genero']; ?>
      </option>
      <?php } ?>
    </select>
  </div>

  <div class="col-md-4 mb-3">
    <label class="form-label fw-semibold">Tipo</label>
    <select name="id_tipo_produto" class="form-select" required>
      <?php while($t = $lista_tipos->fetch_assoc()){ ?>
      <option value="<?= $t['id_tipo']; ?>"
        <?= ($t['id_tipo'] == $produto['id_tipo_produto']) ? 'selected' : '' ?>>
        <?= $t['nome_tipo']; ?>
      </option>
      <?php } ?>
    </select>
  </div>

</div>

<!-- ✅ PROMO + SNEAKERS (faltava aqui) -->
<div class="row">

  <div class="col-md-6 mb-3">
    <label class="form-label fw-semibold">Promoção</label>
    <select name="promoção_produto" class="form-select">
      <option value="Pro" <?= ($produto['promoção_produto'] == 'Pro') ? 'selected' : '' ?>>Pro</option>
      <option value="Não" <?= ($produto['promoção_produto'] == 'Não') ? 'selected' : '' ?>>Não</option>
    </select>
  </div>

  <div class="col-md-6 mb-3">
    <label class="form-label fw-semibold">Sneakers</label>
    <select name="sneakers_produto" class="form-select">
      <option value="Sne" <?= ($produto['sneakers_produto'] == 'Sne') ? 'selected' : '' ?>>Sne</option>
      <option value="Not" <?= ($produto['sneakers_produto'] == 'Not') ? 'selected' : '' ?>>Not</option>
    </select>
  </div>

</div>

<div class="mb-3">
<label class="form-label fw-semibold">Tamanhos disponíveis</label>
<div class="row">

<?php while($tam = $lista_tamanhos->fetch_assoc()){
    $checked = isset($tamanhos_prod[$tam['id_tamanho']]);
    $estoque_val = $checked ? $tamanhos_prod[$tam['id_tamanho']] : 0;
?>
<div class="col-md-4 mb-2">
<div class="border rounded p-2">

<div class="form-check">
<input class="form-check-input chk-tamanho"
       type="checkbox"
       name="tamanhos[]"
       value="<?= $tam['id_tamanho']; ?>"
       <?= $checked ? 'checked' : ''; ?>>
<label class="form-check-label fw-bold">
Tam <?= $tam['numero_tamanho']; ?>
</label>
</div>

<input type="number"
       name="estoque[<?= $tam['id_tamanho']; ?>]"
       class="form-control form-control-sm mt-2 estoque-input"
       value="<?= $estoque_val; ?>"
       <?= $checked ? '' : 'disabled'; ?>
       min="0">

</div>
</div>
<?php } ?>

</div>
</div>

<div class="mb-3">
<label class="form-label fw-semibold">Imagem Atual</label><br>
<img src="../imagens/exclusivo/<?= $produto['imagem_produto']; ?>"
     class="preview-img img-fluid">
<input type="file" name="imagem_produto" class="form-control mt-2" accept="image/*">
</div>

<button type="submit" name="salvar"
        class="btn btn-warning w-100 fw-semibold">
Salvar Alterações
</button>

</form>

</div>
</div>
</div>
</div>

</main>

<script>
document.querySelectorAll('.chk-tamanho').forEach(function(chk){
    chk.addEventListener('change', function(){
        const box = this.closest('.border');
        const input = box.querySelector('.estoque-input');
        if(this.checked){
            input.disabled = false;
            input.focus();
        }else{
            input.disabled = true;
            input.value = 0;
        }
    });
});
</script>

</body>
</html>