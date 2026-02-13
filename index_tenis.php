<?php
include("Connections/conn_produtos.php");
include("helpfun.php");

// --- CONSULTA VIA VIEW ---
$consulta = "
    SELECT *
    FROM vw_tbprodutos
    WHERE id_tipo_produto = 1
    ORDER BY id_produto ASC;
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
    <title>Tênis</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="CSS/pro_marca.css">
    <link rel="stylesheet" href="CSS/exclusivo.css">
</head>

<body>
<?php include('menu.php') ?>

<!-- TÍTULO -->


<!-- BARRA DE CONTROLES -->

    <div class="toolbar">
       
    </div>

<h1 class="text-center  my-4">Outras opções</h1>
<!-- GRID DE PRODUTOS -->

    <div class="row g-4">

        <?php if($totalRows > 0){ ?>
            <?php do { ?>

                <div class="col-12 col-sm-6 col-lg-3" id="Exclusivos">
                    <a href="produto_detalhe.php?id_produto=<?php echo $row['id_produto']; ?>"
                       class="text-decoration-none text-dark">

                        <div class="product-card card h-100">
                            <img
                                src="imagens/exclusivo/<?php echo e($row['imagem_produto']); ?>"
                                class="product-img card-img-top img-fluid"
                                alt="<?php echo e($row['nome_produto']); ?>">

                            <div class="product-meta card-body">
                                <div class="product-brand">
                                    <?php echo e($row['nome_marca']); ?>
                                </div>

                                <p class="product-name">
                                    <?php echo e($row['nome_produto']); ?>
                                </p>

                                <p class="product-price">
                                    <?php echo dinheiro($row['valor_produto']); ?>
                                </p>

                                <a href="produto_detalhe.php?id_produto=<?php echo $row['id_produto']; ?>"
                                   class="btn btn-dark w-100">
                                    Comprar
                                </a>
                            </div>
                        </div>
                    </a>
                </div>

            <?php } while($row = $lista->fetch_assoc()); ?>
        <?php } else { ?>
            <div class="col-12">
                <div class="alert alert-warning text-center">
                    Nenhum produto encontrado.
                </div>
            </div>
        <?php } ?>

    </div>

    <br><br>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
