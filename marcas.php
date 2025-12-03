<?php
// Incluir o arquivo e fazer a conexão
include("Connections/conn_produtos.php");

// Selecionar os dados
$consulta   =   "
                SELECT  *
                FROM    tbmarcas
                ORDER BY imagem_marca ASC;
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
<body class="">
<section class="py-5 bg-white text-center">
  <div class="container " id="Marcas">
    <h2 class="fw-bold mb-4">NOSSAS MARCAS</h2>
    <div id="carouselMarcas" class="carousel slide" data-bs-ride="false">
  <div class="carousel-inner">
    <?php
    $contador = 0;
    $active = "active";

    mysqli_data_seek($lista, 0);

    while ($row = $lista->fetch_assoc()) {

       
        if ($contador % 6 == 0) {
            echo '<div class="carousel-item ' . $active . '">';
            echo '<div class="row justify-content-center">';
            $active = ""; 
        }
    ?>

        <!-- CARD individual -->
        <div class="col-6 col-sm-4 col-md-2 mb-4">
          <div class="card border-black p-3 h-100">
            <img src="imagens/tenis/<?php echo $row['imagem_marca']; ?>"
                 class="card-img-top img-logo"
                 alt="<?php echo $row['nome_marca']; ?>">
          </div>
        </div>

    <?php
        $contador++;

        // fecha a row e o slide quando completar 6 imagens
        if ($contador % 6 == 0) {
            echo '</div></div>';
        }
    }
    // Se terminar com menos de 6 e o slide não foi fechado → fecha agora
    if ($contador % 6 != 0) {
        echo '</div></div>';
    }
    ?>

  </div>

  <!-- SETAS DE NAVEGAÇÃO -->
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselMarcas" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>

  <button class="carousel-control-next" type="button" data-bs-target="#carouselMarcas" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>
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