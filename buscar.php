<?php
include("Connections/conn_produtos.php");


// verifica busca
if (!isset($_GET['q']) || empty($_GET['q'])) {
    echo "Digite algo para buscar.";
    exit;
}

$busca = $_GET['q'];

// consulta geral
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
</head>

<body class="container mt-4">

<h4>Resultados para: <strong><?= htmlspecialchars($busca) ?></strong></h4>
<hr>

<?php if ($resultado->num_rows > 0) { ?>
    <div class="row">
        <?php while ($row = $resultado->fetch_assoc()) { ?>

            <?php
            // imagem segura
            $img = (!empty($row['imagem_produto']))
                ? "imagens/exclusivo/" . $row['imagem_produto']
                : "imagens/exclusivo/";
            ?>

            <div class="col-md-3 mb-4">
                <a href="produto_detalhe.php?id=<?= $row['id_produto'] ?>" 
                   class="text-decoration-none text-dark">

                    <div class="card h-100 shadow-sm">

                        <img src="<?= $img ?>"
                             class="card-img-top"
                             style="height:200px; object-fit:cover;">

                        <div class="card-body">
                            <h6 class="card-title mb-1">
                                <?= $row['nome_produto'] ?>
                            </h6>

                            <small class="text-muted">
                                <?= $row['nome_marca'] ?> • <?= $row['nome_tipo'] ?>
                            </small>

                            <p class="fw-bold mt-2 mb-0">
                                R$ <?= number_format($row['valor_produto'], 2, ',', '.') ?>
                            </p>
                        </div>

                    </div>
                </a>
            </div>

        <?php } ?>
    </div>
<?php } else { ?>
    <p>Nenhum resultado encontrado.</p>
<?php } ?>

</body>
</html>
