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
    <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"/>
</head>
<body>
<div class="container-md bg-dark py-4" id="Promoçoes">
  <div class="d-flex">
    <div class="me-3 d-flex align-items-center">
      <div class=" fw-bold text-uppercase" 
           style="writing-mode: vertical-rl; transform: rotate(180deg); letter-spacing: 2px;">
       <h3 class="text-bg-dark">Promoções</h3> 
      </div>
    </div>

    <div class="w-100">
      <div class="row">    
        <div class="col-md-6 mb-3 d-none d-sm-block d-lg-block">
          <div class="card text-center ">
            <a   
           href="Produto_detalhe.php?id_produto=<?php echo $row_promoçao['id_produto']; ?>"  
        >
            <img src="imagens/Promoçoes/<?php echo $row_promoçao['imagem_produto']; ?>" class="card-img-top img-fluid" alt="Promoção grande" >
            <a
                         href="Produto_detalhe.php?id_produto=<?php echo $row_promoçao['id_produto']; ?>">                       
                    </a>   
            <h6 class="card-title mb-1"><?php echo $row_promoçao['nome_produto'];  ?></h6>
          <p class="card-text fw-bold"> <?php echo $row_promoçao['valor_produto'];  ?></p>  
                                              
          </div>
        </div>

        <?php $i = 1;      
        do{ $i++; ?>
        <!-- esquerda card imagens\Promoçoes\jordan-1-promoçao.webp-->
        <div class="col-6 col-md-3 mb-3 ">
          <div class="card text-center mb-3">
            <a   
           href="Produto_detalhe.php?id_produto=<?php echo $row_promoçao['id_produto']; ?>"  
        >
            <img src="imagens/Promoçoes/<?php echo $row_promoçao['imagem_produto']; ?>" class="card-img-top img-fluid" alt="Promoção 1">
            <a
                         href="Produto_detalhe.php?id_produto=<?php echo $row_promoçao['id_produto']; ?>">                       
                    </a>  
            <h6 class="card-title mb-1"><?php echo $row_promoçao['nome_produto']; ?></h6>
          <p class="card-text fw-bold">
<?php echo $row_promoçao['valor_produto'];  ?></p>
          </div>
          

        <?php }while($i <= 2 && $row_promoçao=$lista_promoçao->fetch_assoc()); ?>  <!-- Fecha estrut. de repetição -->
        <!-- direita card -->
         <?php $i = 1; 
         do{ $i++; ?>
        <div class="col-6 col-md-3 mb-3 " >
          <div class="card text-center mb-3">
            <a   
           href="Produto_detalhe.php?id_produto=<?php echo $row_promoçao['id_produto']; ?>"  
        >
            <img src="imagens/Promoçoes/<?php echo $row_promoçao['imagem_produto'];?>" class="card-img-top img-fluid" alt="Promoção 3">
             <a
                         href="Produto_detalhe.php?id_produto=<?php echo $row_promoçao['id_produto']; ?>">                       
                    </a>  
            <h6 class="card-title mb-1"><?php echo $row_promoçao['nome_produto'];  ?></h6>
          <p class="card-text fw-bold">
<?php echo number_format($row_promoçao['valor_produto'],2,',','.'); ?></p>
          </div>
          <?php }while($i <= 2 && $row_promoçao=$lista_promoçao->fetch_assoc()); ?>
          
      </div>
    </div>

  </div>
</div>

<script           src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
           crossorigin="anonymous"
        ></script>
</body>
</html>

<?php mysqli_free_result($lista); ?>