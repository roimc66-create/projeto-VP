<?php
// Incluir o arquivo e fazer a conexão
include("Connections/conn_produtos.php");

// Selecionar os dados
$tabela_promoçao        = "vw_tbprodutos";
$campo_filtro           = "promoção_produto";
$ordenar_por            = "resumo_produto ASC";
$filtro_select_promoçao = "Pro";

$consulta_promoçao = "
    SELECT *
    FROM {$tabela_promoçao}
    WHERE {$campo_filtro} = '{$filtro_select_promoçao}'
    ORDER BY {$ordenar_por};
";

$lista_promoçao = $conn_produtos->query($consulta_promoçao);

if (!$lista_promoçao) {
    die("Erro na consulta: " . $conn_produtos->error);
}

$totalRows  = $lista_promoçao->num_rows;
$row_promoçao = ($totalRows > 0) ? $lista_promoçao->fetch_assoc() : null;

function e($v) {
    return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
}

function dinheiro($v) {
    $num = is_numeric($v) ? (float)$v : 0;
    return number_format($num, 2, ',', '.');
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Modelo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
  <link rel="stylesheet" href="css/promo.css">
</head>

<body>
  <div class="snkr-container">
    <aside class="snkr-sidebar">
      <h1><span>Calendário</span> SNEAKER</h1>
    </aside>

    <main class="snkr-main">

      <?php if ($totalRows > 0 && $row_promoçao): ?>
        <!-- FEATURED (primeiro item da lista) -->
        <section class="snkr-featured">
          <div class="snkr-date">28 | NOV</div>
          <img
            src="imagens/exclusivo/<?php echo e($row_promoçao['imagem_produto']); ?>"
            class="snkr-shoe"
            alt="<?php echo e($row_promoçao['nome_produto']); ?>"
          >
          <h3><?php echo e($row_promoçao['nome_produto']); ?></h3>
          <button class="snkr-btn-price">
            R$ <?php echo dinheiro($row_promoçao['valor_produto']); ?>
          </button>
        </section>

        <!-- GRID (restante dos itens) -->
       <section class="snkr-grid">
  <?php
  $contador = 0;
  while ($row_grid = $lista_promoçao->fetch_assoc()):
      if ($contador >= 4) {
          break; // para depois de 4 itens
      }
      $contador++;
  ?>
    <div class="snkr-item">
      <div class="snkr-date small">29 | NOV</div>
      <img
        src="imagens/exclusivo/<?php echo e($row_grid['imagem_produto']); ?>"
        alt="<?php echo e($row_grid['nome_produto']); ?>"
      >
      <h4><?php echo e($row_grid['nome_produto']); ?></h4>
      <button class="snkr-btn-price">
        R$ <?php echo dinheiro($row_grid['valor_produto']); ?>
      </button>
    </div>
  <?php endwhile; ?>
</section>


      <?php else: ?>
        <!-- SEM RESULTADOS -->
        <section class="snkr-featured">
          <div class="snkr-date">-- | --</div>
          <div class="p-4 bg-dark text-white rounded">
            Nenhum produto encontrado para o filtro:
            <strong><?php echo e($filtro_select_promoçao); ?></strong>
          </div>
        </section>
      <?php endif; ?>

    </main>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
    integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
    crossorigin="anonymous"></script>
</body>
</html>

<?php
if ($lista_promoçao) {
    mysqli_free_result($lista_promoçao);
}
?>
