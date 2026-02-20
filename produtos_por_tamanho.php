<?php
include("Connections/conn_produtos.php");
include("helpfun.php");

/* PEGA O TAMANHO DA URL */
$tamanho_select = isset($_GET['tamanho']) ? (int)$_GET['tamanho'] : 0;

if ($tamanho_select <= 0) {
    die("Tamanho inválido.");
}

/* CONSULTA — PRODUTOS POR TAMANHO */
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
    ORDER BY p.nome_produto ASC
";

$lista = $conn_produtos->query($consulta);
if(!$lista){
    die("Erro na consulta: " . $conn_produtos->error);
}

$row        = $lista->fetch_assoc();
$totalRows  = $lista->num_rows;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tamanho <?php echo $tamanho_select; ?></title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
<link rel="stylesheet" href="CSS/pro_marca.css">
<link rel="stylesheet" href="CSS/exclusivo.css">
</head>

<body>

<?php include('menu.php') ?>

<!-- TÍTULO -->
<h1 class="text-center brand-title my-4">
    Tamanho <?php echo $tamanho_select; ?>
</h1>

<!-- BARRA -->
<div class="container mb-3">
  <div class="toolbar">
    <div class="left">
      <?php echo $totalRows; ?> produtos
    </div>
  </div>
</div>

<!-- GRID -->
<div class="container my-4">
  <div class="row g-3">

<?php if($totalRows > 0){ ?>
<?php do { ?>

<div class="col-12 col-sm-6 col-lg-3" id="Exclusivos">

  <a href="produto_detalhe.php?id_produto=<?php echo $row['id_produto']; ?>"
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

        <a href="produto_detalhe.php?id_produto=<?php echo $row['id_produto']; ?>"
           class="btn btn-dark w-100">
           Comprar
        </a>

      </div>
    </div>

  </a>

</div>

<?php } while($row = $lista->fetch_assoc()); ?>

<?php } else { ?>

<div class="col-12">
  <div class="alert alert-warning">
    Nenhum produto encontrado para o tamanho <?php echo $tamanho_select; ?>.
  </div>
</div>

<?php } ?>

  </div>
</div>

<?php include('rodapé.php') ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
</body>
</html>