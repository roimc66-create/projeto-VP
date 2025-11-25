<?php
// Incluir o arquivo e fazer a conexão
include("../Connections/conn_produtos.php");

// Selecionar os dados
$consulta   =   "
                SELECT  *
                FROM    vw_tbtenis
                ORDER BY resumo_tenis ASC;
                ";
// Fazer uma lista completa dos dados
$lista      =   $conn_produtos->query($consulta);
// Separar os dados em linhas (row)
$row        =   $lista->fetch_assoc();
// Contar o total de linhas
$totalRows  =   ($lista)->num_rows;
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
            <img src="imagens/Promoçoes/puma-promoçao.webp" class="card-img-top img-fluid" alt="Promoção grande">
            <h6 class="card-title mb-1">PUMA INHALE X A$AP ROCKY</h6>
          <p class="card-text fw-bold">
R$ 1.000,99</p>
          </div>
        </div>
        <!-- esquerda card -->
        <div class="col-6 col-md-3 mb-3 ">
          <div class="card text-center mb-3">
            <img src="imagens/Promoçoes/jordan-1-promoçao.webp" class="card-img-top img-fluid" alt="Promoção 1">
            <h6 class="card-title mb-1"> AIR JORDAN 1 OG</h6>
          <p class="card-text fw-bold">
R$ 1.299,00</p>
          </div>
          <div class="card  text-center">
            <img src="imagens/Promoçoes/puma-2-promoçao.webp" class="card-img-top img-fluid" alt="Promoção 2">
            <h6 class="card-title mb-1">PUMA MOSTRO </h6>
          <p class="card-text fw-bold">
R$ 1.199,99</p>
          </div>
        </div>
        <!-- direita card -->
        <div class="col-6 col-md-3 mb-3 " >
          <div class="card text-center mb-3">
            <img src="imagens/Promoçoes/puma-lafrancé-promoçao.webp" class="card-img-top img-fluid" alt="Promoção 3">
            <h6 class="card-title mb-1">PUMA LAFRANCÉ</h6>
          <p class="card-text fw-bold">
R$ 2.099,99</p>
          </div>
          <div class="card  text-center ">
            <img src="imagens/Promoçoes/air-jordan-promoçao.webp" class="card-img-top img-fluid" alt="Promoção 4">
            <h6 class="card-title mb-1">AIR JORDAN 5  </h6>
          <p class="card-text fw-bold">
R$ 1.399,99</p>
          </div>
        </div>

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