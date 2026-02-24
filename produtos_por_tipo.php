<?php
// Incluir o arquivo para fazer a conexão
include("Connections/conn_produtos.php");
include("helpfun.php");

// Consulta para trazer os dados e SE necessário filtrar
$tabela       = "vw_tbprodutos";
$campo_filtro = "id_tipo_produto";

// pega o id_tipo da URL e transforma em número
$filtro_select = isset($_GET['id_tipo']) ? (int)$_GET['id_tipo'] : 0;

if ($filtro_select <= 0) {
    die("tipo inválida.");
}

/* ===================== ORDENAR (via GET) ===================== */
$ordenar = $_GET['ordenar'] ?? 'recentes';

// whitelist (seguro)
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
        // se tiver campo de data, troque por ele (ex: data_produto DESC)
        $ordenar_por = "id_produto DESC";
        break;
}

/* ===================== CONSULTA ===================== */
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
    FROM ".$tabela."
    WHERE ".$campo_filtro." = ".$filtro_select."
    ORDER BY ".$ordenar_por.";
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
    <title>tipo</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous"
    />
    <link rel="stylesheet" href="CSS/pro_marca.css">
    <link rel="stylesheet" href="CSS/exclusivo.css">
</head>

<body>
<?php include('menu.php') ?>

<a name="">&nbsp; </a>

<!-- TÍTULO -->
<h1 class="text-center brand-title my-4">
    <?php echo e($row['nome_tipo']); ?>
</h1>

<!-- BARRA DE CONTROLES -->
<div class="container mb-3">
  <div class="toolbar">
    <div class="toolbar-left">
      <strong><?php echo (int)$totalRows; ?></strong> produtos
    </div>

    <div class="toolbar-right">
      <form method="get" class="tool-group m-0">
        <!-- mantém o id_tipo ao ordenar -->
        <input type="hidden" name="id_tipo" value="<?php echo (int)$filtro_select; ?>">

        <span class="tool-label">Ordenar por</span>

        <select class="tool-select" name="ordenar" onchange="this.form.submit()">
          <option value="recentes"     <?php echo ($ordenar==='recentes') ? 'selected' : ''; ?>>Mais recentes</option>
          <option value="menor_preco"  <?php echo ($ordenar==='menor_preco') ? 'selected' : ''; ?>>Menor preço</option>
          <option value="maior_preco"  <?php echo ($ordenar==='maior_preco') ? 'selected' : ''; ?>>Maior preço</option>
          <option value="az"           <?php echo ($ordenar==='az') ? 'selected' : ''; ?>>A-Z</option>
        </select>

        <noscript>
          <button class="btn btn-sm btn-dark ms-2" type="submit">OK</button>
        </noscript>
      </form>
    </div>
  </div>
</div>

<!-- GRID DE PRODUTOS -->
<div class="container my-4">
  <div class="row g-3">
    <?php if($totalRows > 0){ ?>
      <?php do { ?>
        <div class="col-12 col-sm-6 col-lg-3" id="Exclusivos">
          <!-- CORRIGIDO: usar id do row -->
          <a href="produto_detalhe.php?id_produto=<?php echo (int)$row['id_produto']; ?>" class="text-decoration-none text-dark">
            <div class="product-card card">
              <img
                src="imagens/exclusivo/<?php echo e($row['imagem_produto']); ?>"
                class="product-img card-img-top img-fluid"
                alt="<?php echo e($row['nome_produto']); ?>"
              >

              <div class="product-meta card-body">
                <div class="product-name card-text"><?php echo e($row['nome_tipo']); ?></div>
                <p class="product-name card-title"><?php echo e($row['nome_produto']); ?></p>

                <p class="product-price">
                  R$ <?php echo dinheiro($row['valor_produto']); ?>
                </p>

                <a href="produto_detalhe.php?id_produto=<?php echo (int)$row['id_produto']; ?>"
                   class="btn btn-dark w-100" role="button">
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
          Nenhum produto encontrado para esta tipo.
        </div>
      </div>
    <?php } ?>
  </div>
</div>

<?php include('rodapé.php') ?>

<script
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
  integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
  crossorigin="anonymous"
></script>

</body>
</html>