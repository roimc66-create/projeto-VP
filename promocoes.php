<?php
// Incluir o arquivo e fazer a conexão
include("Connections/conn_produtos.php");
include("helpfun.php");
// Selecionar os dados
$tabela_promoçao        = "vw_tbprodutos";
$campo_filtro           = "promoção_produto";
$ordenar_por            = "resumo_produto ASC";
$filtro_select_promoçao = "Pro";


$consulta_promoçao = "
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
    FROM    {$tabela_promoçao}
    WHERE   {$campo_filtro} = '{$filtro_select_promoçao}'
    ORDER BY {$ordenar_por};
";


$lista_promoçao = $conn_produtos->query($consulta_promoçao);

if (!$lista_promoçao) {
  die("Erro na consulta: " . $conn_produtos->error);
}

$totalRows  = $lista_promoçao->num_rows;
$row_promoçao = ($totalRows > 0) ? $lista_promoçao->fetch_assoc() : null;


?>
<?php
include("dia_mes.php");
?>
<head>
<link rel="stylesheet" href="CSS/promo.css">
</head>

<body>
  <div class="snkr-container">
    <aside class="snkr-sidebar ">
      <h1><span>Calendário</span> SNEAKER</h1>
    </aside>

    <main class="snkr-main">

      <?php if ($totalRows > 0 && $row_promoçao): ?>

        <section class="snkr-featured d-none d-lg-block">
          <a class="snkr-link-overlay"
            href="produto_detalhe.php?id_produto=<?php echo $row_promoçao['id_produto']; ?>"
            aria-label="Ver <?php echo e($row_promoçao['nome_produto']); ?>"></a>

          <div class="snkr-date"><?php echo $dia; ?> | <?php echo $mes; ?></div>

          <img
            src="imagens/exclusivo/<?php echo e($row_promoçao['imagem_produto']); ?>"
            class="snkr-shoe"
            alt="<?php echo e($row_promoçao['nome_produto']); ?>">

          <h3><?php echo e($row_promoçao['nome_produto']); ?></h3>

          <p class="card-text fw-bold">
            R$ <?php echo dinheiro($row_promoçao['valor_produto']); ?>
          </p>
        </section>


        <section class="snkr-grid">
          <?php
          $contador = 0;
          while ($row_grid = $lista_promoçao->fetch_assoc()):
            if ($contador >= 4) {
              break;
            }
            $contador++;
          ?>
            <div class="snkr-item ">

              <a class="snkr-link-overlay"
                href="produto_detalhe.php?id_produto=<?php echo $row_grid['id_produto']; ?>"
                aria-label="Ver <?php echo e($row_grid['nome_produto']); ?>"></a>

              <div class="snkr-date small"><?php echo $dia; ?> | <?php echo $mes; ?></div>

              <img
                src="imagens/exclusivo/<?php echo e($row_grid['imagem_produto']); ?>"
                alt="<?php echo e($row_grid['nome_produto']); ?>">

              <h4><?php echo e($row_grid['nome_produto']); ?></h4>

              <p class="card-text fw-bold">R$ <?php echo dinheiro($row_grid['valor_produto']); ?></p>
              <br>



            </div>
          <?php endwhile; ?>
        </section>


      <?php else: ?>

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


  <?php
  if ($lista_promoçao) {
    mysqli_free_result($lista_promoçao);
  }
  ?>