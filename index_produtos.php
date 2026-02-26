<?php

include("Connections/conn_produtos.php");
include("helpfun.php");

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

    case 'recentes':
    default:

        $ordenar_por = "id_produto DESC";
        break;
}

$consulta = "
    SELECT DISTINCT 
           id_produto,
           nome_produto,
           valor_produto,
           imagem_produto,
           nome_marca,
           imagem_marca,
           nome_tipo,
           nome_genero,
           promoção_produto,
           sneakers_produto
    FROM vw_tbprodutos
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
<title>Produtos</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
<link rel="stylesheet" href="CSS/pro_marca.css">
<link rel="stylesheet" href="CSS/exclusivo.css">
</head>

<body>

<?php include('menu.php') ?>

<h1 class="text-center brand-title my-4">Produtos</h1>

<div class="container mb-3">
  <div class="toolbar">
    <div class="toolbar-left">
      <strong><?php echo (int)$totalRows; ?></strong> Produtos
    </div>

    <div class="toolbar-right">
      <form method="get" class="tool-group m-0">

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
  <div class="row g-4">

    <?php if($totalRows > 0){ ?>
      <?php do { ?>

        <div class="col-12 col-sm-6 col-lg-3" id="Exclusivos">
          <a href="produto_detalhe.php?id_produto=<?php echo (int)$row['id_produto']; ?>"
             class="text-decoration-none text-dark">

            <div class="product-card card h-100">

              <img
                src="imagens/exclusivo/<?php echo e($row['imagem_produto']); ?>"
                class="card-img-top img-fluid"
                alt="<?php echo e($row['nome_produto']); ?>"
              >

              <div class="card-body">
                <div class="product-brand">
                  <?php echo e($row['nome_marca']); ?>
                </div>

                <p class="card-title fw-bold">
                  <?php echo e($row['nome_produto']); ?>
                </p>

                <p class="product-price">
                  <?php echo dinheiro($row['valor_produto']); ?>
                </p>

                <span class="btn btn-dark w-100">
                  Comprar
                </span>
              </div>

            </div>
          </a>
        </div>

      <?php } while($row = $lista->fetch_assoc()); ?>

    <?php } else { ?>

      <div class="col-12">
        <div class="alert alert-warning">
          Nenhum produto encontrado.
        </div>
      </div>

    <?php } ?>

  </div>
</div>

<?php include('rodapé.php') ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
</body>
</html>