<?php
// Incluir o arquivo e fazer a conexão
include("Connections/conn_produtos.php");

// Selecionar os dados
$tabela_exclusivo        = "vw_tbprodutos";  
$campo_filtro_exclusivo  = "sneakers_produto";
$ordenar_por_exclusivo   = "resumo_produto ASC";
$filtro_select_exclusivo = "Sim"; 

$consulta_exclusivo = "
    SELECT *
    FROM ".$tabela_exclusivo."
    WHERE ".$campo_filtro_exclusivo."='".$filtro_select_exclusivo."'
    ORDER BY ".$ordenar_por_exclusivo.";
";

$lista_exclusivo = $conn_produtos->query($consulta_exclusivo);
$row_exclusivo   = $lista_exclusivo->fetch_assoc();
$totalRows      = $lista_exclusivo->num_rows;   
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exclusivos</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous"
    />

    <style>
        /* === AJUSTE DAS IMAGENS === */
        #Exclusivos .card {
            border: 1px solid #000;
        }

        #Exclusivos .card-img-top {
            height: 220px;
            object-fit: contain; /* mantém a imagem inteira */
            padding: 10px;
        }

        #Exclusivos .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        #Exclusivos .btn {
            margin-top: 10px;
        }
    </style>
</head>

<body>
<main>

<div class="container my-5 text-center" id="Exclusivos">
    <h2 class="fw-bold mb-4">EXCLUSIVOS</h2>

    <div class="row justify-content-center mt-4">
        <?php do { ?>
            <div class="col-12 col-md-4 mb-4">
                <div class="card h-100 p-3">
                    <img 
                        src="imagens/exclusivo/<?php echo $row_exclusivo['imagem_produto']; ?>" 
                        class="card-img-top img-fluid"
                        alt="<?php echo $row_exclusivo['nome_produto']; ?>"
                    >

                    <div class="card-body">
                        <div>
                            <h6 class="card-title mb-1">
                                <?= $row_exclusivo['nome_produto']; ?>
                            </h6>

                            <p class="card-text fw-bold">
                                <?= number_format($row_exclusivo['valor_produto'], 2, ',', '.'); ?>
                            </p>
                        </div>

                        <a href="#" class="btn btn-dark w-100">Comprar</a>
                    </div>
                </div>
            </div>
        <?php } while ($row_exclusivo = $lista_exclusivo->fetch_assoc()); ?>
    </div>

</div>

</main>

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
    integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
    crossorigin="anonymous"
></script>
</body>
</html>

<?php mysqli_free_result($lista_exclusivo); ?>
