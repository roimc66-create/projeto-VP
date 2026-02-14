<?php
// Incluir o arquivo para fazer a conexão
include("Connections/conn_produtos.php");
include("helpfun.php");

// --- CONSULTA VIA VIEW ---
$consulta = "
    SELECT DISTINCT id_produto,
           nome_produto,
           valor_produto,
           imagem_produto,
           nome_marca,
           imagem_marca,
           nome_tipo,
           nome_genero,
           promoção_produto,
           sneakers_produto
    FROM vw_tbprodutos
    ORDER BY id_produto ASC
";



$lista = $conn_produtos->query($consulta);
if(!$lista){
    die("Erro na consulta: " . $conn_produtos->error);
}

$row        = $lista->fetch_assoc();
$totalRows  = $lista->num_rows;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marca</title>
    <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"/>
            <link rel="stylesheet" href="CSS/pro_marca.css">
            <link rel="stylesheet" href="CSS/exclusivo.css">
</head>
<body>
    <?php include('menu.php') ?>

    <h1 class="text-center brand-title my-4 ">Produtos</h1>

    <!-- BARRA DE CONTROLES -->
    <div class="container mb-3">
        <div class="toolbar d-flex justify-content-between align-items-center">
            <div class="left">
                <?php echo $totalRows; ?> Produtos
            </div>

            <div class="right d-flex gap-4">
                <div>
                    <strong>Visualizar</strong>
                    <button type="button">...</button>
                    <button type="button">...</button>
                </div>

                <div>
                    <strong>Filtrar</strong>
                    <button type="button">...</button>
                </div>
            </div>
        </div>
    </div>

    <!-- GRID DE PRODUTOS -->
    <div class="container my-4">
        <div class="row g-4">
            <?php if($totalRows > 0){ ?>
                <?php do { ?>
                    <div class="col-12 col-sm-6 col-lg-3" id="Exclusivos">
                        <a href="produto_detalhe.php?id_produto=<?php echo $row['id_produto']; ?>" class="text-decoration-none text-dark">
                            <div class="product-card card h-100">
                                <img
                                    src="imagens/exclusivo/<?php echo e($row['imagem_produto']); ?>"
                                    class="card-img-top img-fluid"
                                    alt="<?php echo e($row['nome_produto']); ?>"
                                >

                                <div class="card-body">
                                    <div class="product-brand"><?php echo e($row['nome_marca']); ?></div>
                                    <p class="card-title fw-bold"><?php echo e($row['nome_produto']); ?></p>

                                    <p class="product-price">
                                        <?php echo dinheiro($row['valor_produto']); ?>
                                    </p>

                                    <a href="produto_detalhe.php?id_produto=<?php echo $row['id_produto']; ?>" class="btn btn-dark w-100">
                                        Comprar
                                    </a>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php } while($row = $lista->fetch_assoc()); ?>
            <?php } else { ?>
                <div class="col-12">
                    <div class="alert alert-warning">
                        Nenhum produto encontrado.
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <?php include('rodapé.php') ?>
<script           src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
           crossorigin="anonymous"
        ></script>
</body>
</html>