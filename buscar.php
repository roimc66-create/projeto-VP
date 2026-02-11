<?php
include("Connections/conn_produtos.php");
include("helpfun.php");

if (!isset($_GET['q']) || empty($_GET['q'])) {
    echo "Digite algo para buscar.";
    exit;
}

$busca = $_GET['q'];

$sql = "
    SELECT *
    FROM vw_tbprodutos
    WHERE 
        nome_produto LIKE '%$busca%'
        OR nome_marca LIKE '%$busca%'
        OR nome_tipo LIKE '%$busca%'
";

$resultado = $conn_produtos->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Busca</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MESMOS CSS DO PRODUTOS -->
    <link rel="stylesheet" href="CSS/pro_marca.css">
    <link rel="stylesheet" href="CSS/exclusivo.css">
</head>

<body>
<?php include('menu.php') ?>

<h4 class="text-center my-4">
    Resultados para: <strong><?= e($busca) ?></strong>
</h4>

<div class="container my-4">
    <div class="row g-4">

        <?php if ($resultado->num_rows > 0) { ?>
            <?php while ($row = $resultado->fetch_assoc()) { ?>

                <div class="col-12 col-sm-6 col-lg-3" id="Exclusivos">
                    <a href="produto_detalhe.php?id_produto=<?= $row['id_produto'] ?>"
                       class="text-decoration-none text-dark">

                        <div class="product-card card h-100">
                            <img
                                src="imagens/exclusivo/<?= e($row['imagem_produto']) ?>"
                                class="product-img card-img-top img-fluid"
                                alt="<?= e($row['nome_produto']) ?>">

                            <div class="product-meta card-body">
                                <div class="product-brand">
                                    <?= e($row['nome_marca']) ?>
                                </div>

                                <p class="product-name">
                                    <?= e($row['nome_produto']) ?>
                                </p>

                                <p class="product-price">
                                    <?= dinheiro($row['valor_produto']) ?>
                                </p>

                                <a href="produto_detalhe.php?id_produto=<?= $row['id_produto'] ?>"
                                   class="btn btn-dark w-100">
                                    Comprar
                                </a>
                            </div>
                        </div>

                    </a>
                </div>

            <?php } ?>
        <?php } else { ?>
            <div class="col-12">
                <div class="alert alert-warning text-center">
                    Nenhum resultado encontrado.
                </div>
            </div>
        <?php } ?>

    </div>
</div>

</body>
</html>
