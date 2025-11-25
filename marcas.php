<?php
// Incluir o arquivo e fazer a conexão
include("Connections/conn_produtos.php");

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
<section class="py-5 bg-white text-center">
  <div class="container " id="Marcas">
    <h2 class="fw-bold mb-4">NOSSAS MARCAS</h2>
    <div class="row justify-content-center">
        <?php do{ ?>
            
      <!-- Card 1 -->
      <div class="col-6 col-sm-6 col-md-4 col-lg-2 mb-4 d-none d-sm-block d-lg-block">
        <div class="card border-black p-3">
          <img src="imagens/tenis/<?php echo $row['imagem_marca'];?>" class="card-img-top" alt="<?php echo $row['nome_marca']; ?>">
        </div>
      </div>     
      <?php }while($row=$lista->fetch_assoc()); ?>  <!-- Fecha estrut. de repetição -->
      
     
      </div>      
    </div>
  </div>
</section>
<script           src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
           crossorigin="anonymous"
        ></script>
</body>
</html>
<?php mysqli_free_result($lista); ?>