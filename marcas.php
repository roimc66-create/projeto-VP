<?php
include("Connections/conn_produtos.php");

$consulta = "
    SELECT *
    FROM tbmarcas
    ORDER BY imagem_marca ASC;
";

$lista = $conn_produtos->query($consulta);
?>


    <link rel="stylesheet" href="CSS/style.css">

    


<body>

<section class="bg-white text-center" id="Marcas">
    <div class="container">

        <div class="marcas-header">

            <button class="marc-arrow-btn" type="button" data-bs-target="#carouselMarcas" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>

            <h2>NOSSAS MARCAS</h2>

            <button class="marc-arrow-btn" type="button" data-bs-target="#carouselMarcas" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>

        <div id="carouselMarcas" class="carousel slide" data-bs-ride="false">
            <div class="carousel-inner">

                <?php
                $contador = 0;
                $active = "active";

                mysqli_data_seek($lista, 0);

                while ($row = $lista->fetch_assoc()) {

                    if ($contador % 6 == 0) {
                        echo '<div class="carousel-item ' . $active . '">';
                        echo '<div class="row">';
                        $active = "";
                    }
                ?>

                    <div class="col-6 col-sm-4 col-md-2 mb-4">
    <div class="marc-card border p-3 position-relative">
        <img src="imagens/tenis/<?php echo $row['imagem_marca']; ?>"
             class="img-fluid"
             alt="<?php echo $row['nome_marca']; ?>">

        <a href="produtos_por_marca.php?id_marca=<?php echo $row['id_marca']; ?>"
           class="stretched-link"></a>
    </div>
</div>

                <?php
                    $contador++;
                    if ($contador % 6 == 0) {
                        echo '</div></div>';
                    }
                }

                if ($contador % 6 != 0) {
                    echo '</div></div>';
                }
                ?>
            </div>
        </div>

    </div>
</section>



<?php mysqli_free_result($lista); ?>
