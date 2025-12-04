<?php
include("Connections/conn_produtos.php");

$consulta = "
    SELECT *
    FROM tbmarcas
    ORDER BY imagem_marca ASC;
";

$lista = $conn_produtos->query($consulta);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marcas</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Área geral */
        section#Marcas {
            padding-top: 60px;
        }

        /* Linha do título + setas */
        .marcas-header {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 25px;
            margin-bottom: 40px;
        }

        .marcas-header h2 {
            font-size: 2.3rem;
            font-weight: 800;
            margin: 0;
        }

        /* Botões laterais alinhados com o título */
        .arrow-btn {
            background: #00000010;
            border-radius: 50%;
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.3s;
            border: none;
        }
        .arrow-btn:hover {
            background: #00000025;
        }

        .arrow-btn span {
            filter: invert(1);
        }

        /* Cards */
        .card {
            border-radius: 15px;
            transition: transform .3s, box-shadow .3s;
        }
        .card img {
            height: 100px;
            object-fit: contain;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0px 8px 25px #00000025;
        }

        /* Colunas centralizadas */
        .carousel-item .row {
            justify-content: center;
        }
    </style>
</head>

<body>

<section class="bg-white text-center" id="Marcas">
    <div class="container">

        <!-- TÍTULO + SETAS -->
        <div class="marcas-header">

            <button class="arrow-btn" type="button" data-bs-target="#carouselMarcas" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>

            <h2>NOSSAS MARCAS</h2>

            <button class="arrow-btn" type="button" data-bs-target="#carouselMarcas" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>

        <!-- CARROSSEL -->
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
                        <div class="card border p-3">
                            <img src="imagens/tenis/<?php echo $row['imagem_marca']; ?>"
                                 class="img-fluid"
                                 alt="<?php echo $row['nome_marca']; ?>">
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
</body>
</html>

<?php mysqli_free_result($lista); ?>
