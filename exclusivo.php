<?php
include("Connections/conn_produtos.php");
include("helpfun.php");
$tabela_exclusivo        = "vw_tbprodutos";
$campo_filtro_exclusivo  = "sneakers_produto";
$ordenar_por_exclusivo   = "resumo_produto ASC";
$filtro_select_exclusivo = "Sne";


$consulta_exclusivo = "
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
    FROM    {$tabela_exclusivo}
    WHERE   {$campo_filtro_exclusivo} = '{$filtro_select_exclusivo}'
    ORDER BY {$ordenar_por_exclusivo};
";


$lista_exclusivo = $conn_produtos->query($consulta_exclusivo);

if (!$lista_exclusivo) {
    die("Erro na consulta: " . $conn_produtos->error);
}

$totalRows   = $lista_exclusivo->num_rows;
$row_exclusivo = ($totalRows > 0) ? $lista_exclusivo->fetch_assoc() : null;


?>

<head>
  <link rel="stylesheet" href="CSS/exclusivo.css">
</head>

<body>
<main>
  <div class="container my-5 text-center" id="Exclusivos">
    <h2 class="fw-bold mb-4">EXCLUSIVOS</h2>

    <div class="row justify-content-center mt-4">
      <?php if ($totalRows > 0 && $row_exclusivo): ?>

        <?php while ($row_exclusivo): ?>
          <div class="col-12 col-md-4 mb-4">
            <div class="card h-100 p-3">
              <img
                src="imagens/exclusivo/<?php echo e($row_exclusivo['imagem_produto']); ?>"
                class="card-img-top img-fluid"
                alt="<?php echo e($row_exclusivo['nome_produto']); ?>"
              >

              <div class="card-body">
                <div>
                  <h6 class="card-title mb-1"><?php echo e($row_exclusivo['nome_produto']); ?></h6>
                  <p class="card-text fw-bold">R$ <?php echo dinheiro($row_exclusivo['valor_produto']); ?></p>
                </div>
      
                <a href="produto_detalhe.php?id_produto=<?php echo (int)$row_promoçao['id_produto']; ?>" class="btn btn-dark w-100" role="button">Comprar</a>
              </div>
            </div>
          </div>

          <?php $row_exclusivo = $lista_exclusivo->fetch_assoc(); ?>
        <?php endwhile; ?>

      <?php else: ?>
        <div class="col-12 col-md-6">
          <div class="p-4 border rounded">
            Nenhum produto encontrado em <b>sneakers_produto</b> com valor <b><?php echo e($filtro_select_exclusivo); ?></b>.
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
</main>



<?php
mysqli_free_result($lista_exclusivo);
?>
