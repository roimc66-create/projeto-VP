<?php
include("Connections/conn_produtos.php");
include("helpfun.php");

$tabela       = "vw_tbprodutos";
$campo_filtro = "id_tipo_produto";

$filtro_select = isset($_GET['id_tipo']) ? (int)$_GET['id_tipo'] : 0;

if ($filtro_select <= 0) {
    die("Tipo inválido.");
}

$ordenar = $_GET['ordenar'] ?? 'recentes';

switch ($ordenar) {
    case 'menor_preco':
        $ordenar_por = "valor_produto ASC";
        break;
    case 'maior_preco':
        $ordenar_por = "valor_produto DESC";
        break;
    case 'az':
        $ordenar_por = "nome_produto ASC";
        break;
    default:
        $ordenar_por = "id_produto DESC";
        break;
}

$consulta = "
    SELECT DISTINCT
        id_produto,
        id_marca_produto,
        id_genero_produto,
        id_tipo_produto,
        nome_tipo,
        nome_marca,
        nome_genero,
        imagem_marca,
        nome_produto,
        resumo_produto,
        valor_produto,
        imagem_produto,
        promoção_produto,
        sneakers_produto
    FROM $tabela
    WHERE $campo_filtro = $filtro_select
    ORDER BY $ordenar_por
";

$lista = $conn_produtos->query($consulta);

if(!$lista){
    die("Erro na consulta: " . $conn_produtos->error);
}

$totalRows = $lista->num_rows;
$row = ($totalRows > 0) ? $lista->fetch_assoc() : null;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tipo</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="CSS/pro_marca.css">
<link rel="stylesheet" href="CSS/exclusivo.css">
</head>

<body>

<?php include('menu.php') ?>

<h1 class="text-center brand-title my-4">
    <?php echo ($row) ? e($row['nome_tipo']) : "Tipo"; ?>
</h1>

<div class="container mb-3">
  <div class="toolbar d-flex justify-content-between align-items-center">

    <div>
      <strong><?php echo $totalRows; ?></strong> produtos
    </div>

    <form method="get" class="d-flex align-items-center gap-2 m-0">
      <input type="hidden" name="id_tipo" value="<?php echo $filtro_select; ?>">

      <span>Ordenar por</span>

      <select name="ordenar" class="form-select form-select-sm" onchange="this.form.submit()">
        <option value="recentes"     <?php echo ($ordenar==='recentes') ? 'selected' : ''; ?>>Mais recentes</option>
        <option value="menor_preco"  <?php echo ($ordenar==='menor_preco') ? 'selected' : ''; ?>>Menor preço</option>
        <option value="maior_preco"  <?php echo ($ordenar==='maior_preco') ? 'selected' : ''; ?>>Maior preço</option>
        <option value="az"           <?php echo ($ordenar==='az') ? 'selected' : ''; ?>>A-Z</option>
      </select>
    </form>

  </div>
</div>

<div class="container my-4">
  <div class="row g-3">

    <?php if($totalRows > 0){ ?>
      <?php do { ?>

        <div class="col-12 col-sm-6 col-lg-3">
          <div class="card h-100">

            <img src="imagens/exclusivo/<?php echo e($row['imagem_produto']); ?>"
                 class="card-img-top img-fluid"
                 alt="<?php echo e($row['nome_produto']); ?>">

            <div class="card-body d-flex flex-column">

              <small class="text-muted"><?php echo e($row['nome_tipo']); ?></small>

              <h6 class="mt-1"><?php echo e($row['nome_produto']); ?></h6>

              <p class="fw-bold mb-3">
                <?php echo dinheiro($row['valor_produto']); ?>
              </p>

              <a href="produto_detalhe.php?id_produto=<?php echo $row['id_produto']; ?>"
                 class="btn btn-dark mt-auto w-100">
                 Comprar
              </a>

            </div>

          </div>
        </div>

      <?php } while($row = $lista->fetch_assoc()); ?>
    <?php } else { ?>

      <div class="col-12">
        <div class="alert alert-warning text-center">
          Nenhum produto encontrado para este tipo.
        </div>
      </div>

    <?php } ?>

  </div>
</div>

<?php include('rodapé.php') ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>

</body>
</html>