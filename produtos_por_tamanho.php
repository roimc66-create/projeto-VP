<?php
include("Connections/conn_produtos.php");
include("helpfun.php");

$tamanho_select = isset($_GET['tamanho']) ? (int)$_GET['tamanho'] : 0;

if ($tamanho_select <= 0) {
    die("Tamanho inválido.");
}

$ordenar = $_GET['ordenar'] ?? 'az';

switch ($ordenar) {
    case 'menor_preco':
        $ordenar_por = "p.valor_produto ASC";
        break;

    case 'maior_preco':
        $ordenar_por = "p.valor_produto DESC";
        break;

    case 'recentes':

        $ordenar_por = "p.id_produto DESC";
        break;

    case 'az':
    default:
        $ordenar_por = "p.nome_produto ASC";
        break;
}

$consulta = "
    SELECT DISTINCT
        p.id_produto,
        p.id_marca_produto,
        p.id_genero_produto,
        p.id_tipo_produto,
        p.nome_produto,
        p.resumo_produto,
        p.valor_produto,
        p.imagem_produto,
        p.promoção_produto,
        p.sneakers_produto,
        m.nome_marca,
        g.nome_genero,
        t.nome_tipo
    FROM tbprodutos p
    JOIN tbproduto_tamanho pt ON pt.id_produto = p.id_produto
    JOIN tbtamanhos ta ON ta.id_tamanho = pt.id_tamanho
    JOIN tbmarcas m ON m.id_marca = p.id_marca_produto
    JOIN tbgeneros g ON g.id_genero = p.id_genero_produto
    JOIN tbtipos t ON t.id_tipo = p.id_tipo_produto
    WHERE ta.numero_tamanho = {$tamanho_select}
      AND pt.estoque > 0
    ORDER BY {$ordenar_por}
";

$lista = $conn_produtos->query($consulta);
if(!$lista){
    die("Erro na consulta: " . $conn_produtos->error);
}

$row       = $lista->fetch_assoc();
$totalRows = $lista->num_rows;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tamanho <?php echo (int)$tamanho_select; ?></title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
<link rel="stylesheet" href="CSS/pro_marca.css">
<link rel="stylesheet" href="CSS/exclusivo.css">
</head>

<body>

<?php include('menu.php') ?>

<h1 class="text-center brand-title my-4">
    Tamanho <?php echo (int)$tamanho_select; ?>
</h1>

<div class="container mb-3">
  <div class="toolbar">
    <div class="toolbar-left">
      <strong><?php echo (int)$totalRows; ?></strong> produtos
    </div>

    <div class="toolbar-right">
      <form method="get" class="tool-group m-0">

        <input type="hidden" name="tamanho" value="<?php echo (int)$tamanho_select; ?>">

        <span class="tool-label">Ordenar por</span>

        <select class="tool-select" name="ordenar" onchange="this.form.submit()">
          <option value="recentes"    <?php echo ($ordenar==='recentes') ? 'selected' : ''; ?>>Mais recentes</option>
          <option value="menor_preco" <?php echo ($ordenar==='menor_preco') ? 'selected' : ''; ?>>Menor preço</option>
          <option value="maior_preco" <?php echo ($ordenar==='maior_preco') ? 'selected' : ''; ?>>Maior preço</option>
          <option value="az"          <?php echo ($ordenar==='az') ? 'selected' : ''; ?>>A-Z</option>
        </select>

        <noscript>
          <button class="btn btn-sm btn-dark ms-2" type="submit">OK</button>
        </noscript>
      </form>
    </div>
  </div>
</div>

<div class="container my-4">
  <div class="row g-3">

  <?php if($totalRows > 0){ ?>
    <?php do { ?>

      <div class="col-12 col-sm-6 col-lg-3" id="Exclusivos">
        <a href="produto_detalhe.php?id_produto=<?php echo (int)$row['id_produto']; ?>"
           class="text-decoration-none text-dark">

          <div class="product-card card">
            <img
              src="imagens/exclusivo/<?php echo e($row['imagem_produto']); ?>"
              class="product-img card-img-top img-fluid"
              alt="<?php echo e($row['nome_produto']); ?>"
            >

            <div class="product-meta card-body">
              <div class="product-brand card-text">
                <?php echo e($row['nome_marca']); ?>
              </div>

              <p class="product-name card-title">
                <?php echo e($row['nome_produto']); ?>
              </p>

              <p class="product-price">
                <?php echo dinheiro($row['valor_produto']); ?>
              </p>

              <span class="btn btn-dark w-100">Comprar</span>
            </div>
          </div>

        </a>
      </div>

    <?php } while($row = $lista->fetch_assoc()); ?>

  <?php } else { ?>

    <div class="col-12">
      <div class="alert alert-warning">
        Nenhum produto encontrado para o tamanho <?php echo (int)$tamanho_select; ?>.
      </div>
    </div>

  <?php } ?>

  </div>
</div>

<?php include('rodapé.php') ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
</body>
</html>