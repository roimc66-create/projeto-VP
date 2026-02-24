<?php
include("Connections/conn_produtos.php");
include("helpfun.php");

if (!isset($_GET['q']) || trim($_GET['q']) === '') {
    echo "Digite algo para buscar.";
    exit;
}

$busca = trim($_GET['q']);
$busca_esc = $conn_produtos->real_escape_string($busca);

/* Se digitou número, usamos como tamanho também */
$busca_numero = (int)$busca;

/* CONSULTA (1 produto por tênis + filtro por tamanho) */
$sql = "
    SELECT DISTINCT
        p.id_produto,
        p.id_marca_produto,
        p.id_genero_produto,
        p.id_tipo_produto,
        p.nome_tipo,
        p.nome_marca,
        p.nome_genero,
        p.imagem_marca,
        p.nome_produto,
        p.resumo_produto,
        p.valor_produto,
        p.imagem_produto,
        p.promoção_produto,
        p.sneakers_produto
    FROM vw_tbprodutos p
    WHERE
        p.nome_produto LIKE '%{$busca_esc}%'
        OR p.nome_marca LIKE '%{$busca_esc}%'
        OR p.nome_tipo  LIKE '%{$busca_esc}%'
        OR (
            {$busca_numero} > 0
            AND EXISTS (
                SELECT 1
                FROM tbproduto_tamanho pt
                JOIN tbtamanhos ta ON ta.id_tamanho = pt.id_tamanho
                WHERE pt.id_produto = p.id_produto
                  AND ta.numero_tamanho = {$busca_numero}
                  AND pt.estoque > 0
            )
        )
";

$resultado = $conn_produtos->query($sql);

if(!$resultado){
    die('Erro na busca: '.$conn_produtos->error);
}
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

<div class="container my-4"> <!-- container  -->
    <div class="row g-4"> <!-- row  -->

        <?php if ($resultado->num_rows > 0) { ?>
            <?php while ($row = $resultado->fetch_assoc()) { ?>

                <div class="col-12 col-sm-6 col-lg-3" id="Exclusivos"> <!-- colunas  -->
                    <a href="produto_detalhe.php?id_produto=<?= $row['id_produto'] ?>"
                       class="text-decoration-none text-dark">

                        <div class="product-card card h-100"> <!-- card  -->
                            <img
                                src="imagens/exclusivo/<?= e($row['imagem_produto']) ?>"
                                class="product-img card-img-top img-fluid"
                                alt="<?= e($row['nome_produto']) ?>">

                            <div class="product-meta card-body"> <!-- corpo do card  -->
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
                            </div> <!-- fecha corpo do card  -->
                        </div> <!-- fecha card  -->

                    </a>
                </div> <!-- fecha colunas  -->

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
