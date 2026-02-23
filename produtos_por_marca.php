<?php
// Incluir o arquivo para fazer a conexão
include("Connections/conn_produtos.php");
include("helpfun.php");

// Consulta
$tabela         = "vw_tbprodutos";
$campo_filtro   = "id_marca_produto";
$ordenar_por    = "resumo_produto ASC";

// pega o id_marca da URL
$filtro_select  = isset($_GET['id_marca']) ? (int)$_GET['id_marca'] : 0;

if ($filtro_select <= 0) {
    die("Marca inválida.");
}

$consulta = "
    SELECT DISTINCT
        id_produto,
        id_marca_produto,
        id_genero_produto,
        id_tipo_produto,
        nome_tipo,
        nome_marca,
        nome_genero,
        imagem_marca,
        nome_produto,
        resumo_produto,
        valor_produto,
        imagem_produto,
        promoção_produto,
        sneakers_produto
    FROM ".$tabela."
    WHERE ".$campo_filtro." = ".$filtro_select."
    ORDER BY ".$ordenar_por.";
";

$lista = $conn_produtos->query($consulta);
if(!$lista){
    die("Erro na consulta: " . $conn_produtos->error);
}

$totalRows = $lista->num_rows;
$row = ($totalRows > 0) ? $lista->fetch_assoc() : null;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Marca</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="CSS/pro_marca.css">
<link rel="stylesheet" href="CSS/exclusivo.css">
</head>

<body>
<?php include('menu.php') ?>

<!-- TÍTULO -->
<h1 class="text-center brand-title my-4">
    <?php echo ($row) ? e($row['nome_marca']) : 'Marca'; ?>
</h1>

<!-- BARRA -->
<div class="container mb-3">
    <div class="toolbar">
        <div class="left">
            <?php echo $totalRows; ?> produtos
        </div>
    </div>
</div>

<!-- GRID -->
<div class="container my-4">
    <div class="row g-4">

<?php if($totalRows > 0){ ?>

<?php do { ?>
    <div class="col-12 col-sm-6 col-lg-3" id="Exclusivos">
        <a href="produto_detalhe.php?id_produto=<?php echo (int)$row['id_produto']; ?>" class="text-decoration-none text-dark">

            <div class="product-card card">
                <img
                    src="imagens/exclusivo/<?php echo e($row['imagem_produto']); ?>"
                    class="product-img card-img-top img-fluid"
                    alt="<?php echo e($row['nome_produto']); ?>"
                >

                <div class="product-meta card-body">
                    <div class="product-brand card-text">
                        <?php echo e($row['nome_marca']); ?>
                    </div>

                    <p class="product-name card-title">
                        <?php echo e($row['nome_produto']); ?>
                    </p>

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
            Nenhum produto encontrado para esta marca.
        </div>
    </div>

<?php } ?>

    </div>
</div>

<?php include('rodapé.php') ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
</body>
</html>