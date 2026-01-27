<?php
// Incluir o arquivo e fazer a conexão
include("Connections/conn_produtos.php");

// Selecionar os dados
$tabela_promoçao        =   "vw_tbprodutos";  
$campo_filtro           =   "promoção_produto";
$ordenar_por            =   "resumo_produto ASC";
$filtro_select_promoçao =   "Sim"; 
$consulta_promoçao      =   "
                   SELECT *
                   FROM ".$tabela_promoçao."
                   WHERE  ".$campo_filtro."='".$filtro_select_promoçao."'
                   ORDER BY ".$ordenar_por.";
                   ";
$lista_promoçao      =   $conn_produtos->query($consulta_promoçao);
$row_promoçao        =   $lista_promoçao->fetch_assoc();
$totalRows  =   ($lista_promoçao)->num_rows;   
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

      <section class="snkr-featured">
        <div class="snkr-date">28 | NOV</div>     
        <img src="imagens/exclusivo/<?php echo $row_promoçao['imagem_produto']; ?>"  class="snkr-shoe">
        <h3>
          <?= $row_promoçao['nome_produto']; ?>
        </h3>
        <button class="snkr-btn-price">
    <?= number_format($row_promoçao['valor_produto'], 2, ',', '.'); ?>
</button>

      </section>

      <section class="snkr-grid">        
        <div class="snkr-item">
          <div class="snkr-date small">29 | NOV</div>
          <img src="imagens/exclusivo/<?php echo $row_promoçao['imagem_produto']; ?>">
          <h4><?= $row_promoçao['nome_produto']; ?></h4>
          <button class="snkr-btn-price">
    <?= number_format($row_promoçao['valor_produto'], 2, ',', '.'); ?>
</button>
        </div>

      </section>
      

    </main>

  </div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
    integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
    crossorigin="anonymous"></script>
</body>

</html>

<?php mysqli_free_result($lista_promoçao); ?>