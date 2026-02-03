<?php
// Incluir o arquivo para fazer a conexão
include("Connections/conn_produtos.php");
include("helpfun.php");

// Consulta para trazer os dados e SE necessário filtrar
$tabela         = "vw_tbprodutos";
$campo_filtro   = "id_marca_produto";
$ordenar_por    = "resumo_produto ASC";

// pega o id_marca da URL e transforma em número
$filtro_select  = isset($_GET['id_marca']) ? (int)$_GET['id_marca'] : 0;

if ($filtro_select <= 0) {
    die("Marca inválida.");
}

$consulta = "
    SELECT  *
    FROM    ".$tabela."
    WHERE   ".$campo_filtro." = ".$filtro_select."
    ORDER BY ".$ordenar_por.";
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
    <?php include('menu.php')  ?>
    
    <a name="">&nbsp; </a>
         <!-- TÍTULO  -->
    <h1 class="brand-title">
        <?php   echo $row['nome_marca'];?>
        
    </h1>

    <!-- BARRA DE CONTROLES -->
    <div class="toolbar">
        <div class="left">
            <?php echo $totalRows; ?> produtos
        </div>

        <div class="right">
            <div>
                <strong>Visualizar</strong>
                <button type="button" title="Grade">...</button>
                <button type="button" title="Lista">....</button>
            </div>

            <div>
                <strong>Filtrar</strong>
                <button type="button" title="Filtrar">.....</button>
            </div>

            <div class="d-flex align-items-center gap-2">
                <strong>Ordenar por</strong>
                <!-- <select class="form-select form-select-sm" style="width:auto;">
                    <option selected>Mais recentes</option>
                    <option>Menor preço</option>
                    <option>Maior preço</option>
                    <option>A-Z</option>
                </select> -->
            </div>
        </div>
    </div>

    <!-- GRID DE PRODUTOS -->
    <div class="row g-3">
        <?php if($totalRows > 0){ ?>
            <?php do { ?>

                

                <div class="col-12 col-sm-6 col-lg-3" id="Exclusivos">
                    <a href="produto.php?id_produto=<?php echo $id_produto; ?>" class="text-decoration-none text-dark">
                        <div class="product-card card">
                            <img
                             src="imagens/exclusivo/<?php echo e($row['imagem_produto']); ?>"
                            class="product-img card-img-top img-fluid"
                             alt="<?php echo e($row['nome_produto']); ?>"
                              >

                            <div class="product-meta card-body">
                                <div class="product-brand card-text"><?php echo e($row['nome_marca']); ?></div>
                                <p class="product-name card-title"><?php echo e($row['nome_produto']); ?></p>

                                <p class="product-price">
                                    <?php echo dinheiro($row['valor_produto']); ?>
                                        </p>                                 
                                </p>
                                <a href="produto_detalhe.php?id_produto=<?php echo $row['id_produto']; ?>" class="btn btn-dark w-100" role="button">Comprar</a>
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


<script           src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
           crossorigin="anonymous"
        ></script>
</body>
</html>