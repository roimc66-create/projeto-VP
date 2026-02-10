<?php
include("../Connections/conn_produtos.php");

if($_POST){
    // Selecionar o banco de dados (USE)
    mysqli_select_db($conn_produtos,$database_conn);

    // Variáveis para acrescentar dados no banco
    $tabela_insert  =   "tbprodutos";
    $campos_insert  =   "
                           id_marca_produto,
                           id_genero_produto,
                           id_tipo_produto,
                           nome_produto,
                           resumo_produto,
                           valor_produto,
                           imagem_produto,
                           promoção_produto,
                           sneakers_produto
                        ";

    // Guardar o nome da imagem no banco e o arquivo no diretório
    if (isset($_POST['enviar']) && isset($_FILES['imagem_produto'])) {
        $nome_img = $_FILES['imagem_produto']['name'];
        $tmp_img  = $_FILES['imagem_produto']['tmp_name'];

        if(!empty($nome_img)){
            $dir_img  = "../imagens/exclusivo/" . $nome_img;
            move_uploaded_file($tmp_img, $dir_img);
        }
    };

    // Receber os dados do formulário
    $id_marca_produto    = $_POST['id_marca_produto'];
    $id_genero_produto   = $_POST['id_genero_produto'];
    $id_tipo_produto     = $_POST['id_tipo_produto'];
    $nome_produto        = $_POST['nome_produto'];
    $resumo_produto      = $_POST['resumo_produto'];
    $valor_produto       = $_POST['valor_produto'];
    $promoção_produto    = $_POST['promoção_produto'];
    $sneakers_produto    = $_POST['sneakers_produto'];
    $imagem_produto      = $_FILES['imagem_produto']['name'];

    // Reunir os valores a serem inseridos
    $valores_insert = "
                        '$id_marca_produto',
                        '$id_genero_produto',
                        '$id_tipo_produto',
                        '$nome_produto',
                        '$resumo_produto',
                        '$valor_produto',
                        '$imagem_produto',
                        '$promoção_produto',
                        '$sneakers_produto'
                    ";

    // Consulta SQL para inserção dos dados
    $insertSQL  =   "
                    INSERT INTO ".$tabela_insert."
                        (".$campos_insert.")
                    VALUES
                        (".$valores_insert.");
                    ";

    $resultado  =   $conn_produtos->query($insertSQL);

    // Após a ação a página será redirecionada
    $destino    =   "produtos_lista.php";
    header("Location: $destino");
    exit;
};

// Selecionar o banco de dados (USE)
mysqli_select_db($conn_produtos,$database_conn);

/* ====== SELECT TIPOS ====== */
$tabela_tipos      = "tbtipos";
$ordenar_tipos     = "nome_tipo ASC";
$consulta_tipos    = "
                    SELECT *
                    FROM ".$tabela_tipos."
                    ORDER BY ".$ordenar_tipos.";
                    ";
$lista_tipos       = $conn_produtos->query($consulta_tipos);
$row_tipos         = $lista_tipos->fetch_assoc();
$totalRows_tipos   = $lista_tipos->num_rows;

/* ====== SELECT MARCAS ====== */
$tabela_marcas      = "tbmarcas";
$ordenar_marcas     = "nome_marca ASC";
$consulta_marcas    = "
                    SELECT *
                    FROM ".$tabela_marcas."
                    ORDER BY ".$ordenar_marcas.";
                    ";
$lista_marcas       = $conn_produtos->query($consulta_marcas);
$row_marcas         = $lista_marcas->fetch_assoc();
$totalRows_marcas   = $lista_marcas->num_rows;

/* ====== SELECT GENEROS ====== */
$tabela_generos      = "tbgeneros";
$ordenar_generos     = "nome_genero ASC";
$consulta_generos    = "
                    SELECT *
                    FROM ".$tabela_generos."
                    ORDER BY ".$ordenar_generos.";
                    ";
$lista_generos       = $conn_produtos->query($consulta_generos);
$row_generos         = $lista_generos->fetch_assoc();
$totalRows_generos   = $lista_generos->num_rows;
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Inserir Produto</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { background: #ffffff; min-height: 100vh; }
        .card-custom {
            border-radius: 18px;
            padding: 30px;
            background: #fff;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            margin-top: 50px;
        }
        .preview-img {
            max-height: 140px;
            border-radius: 10px;
            margin-bottom: 10px;
            display: none;
        }
    </style>
</head>

<body>

<?php include("menu.php"); ?>

<main class="container">

<div class="row justify-content-center">
<div class="col-12 col-md-10 col-lg-8">

<div class="card-custom">

<div class="d-flex align-items-center mb-3">
    <a href="produtos_lista.php" class="btn btn-warning me-3">←</a>
    <h4 class="mb-0 text-warning fw-bold">Inserir Produto</h4>
</div>

<div class="alert alert-warning">

<form action="" method="post" enctype="multipart/form-data">


<!-- Nome -->
<div class="mb-3">
    <label class="form-label fw-semibold">Nome do Produto</label>
    <input type="text" name="nome_produto" class="form-control" required>
</div>

<!-- Resumo -->
<div class="mb-3">
    <label class="form-label fw-semibold">Resumo</label>
    <textarea name="resumo_produto" class="form-control" rows="3" required></textarea>
</div>

<!-- Valor -->
<div class="mb-3">
    <label class="form-label fw-semibold">Valor</label>
    <input type="number" step="0.01" name="valor_produto" class="form-control" required>
</div>

<!-- Marca / Gênero / Tipo -->
<div class="row">

<div class="col-md-4 mb-3">
    <label class="form-label fw-semibold">Marca</label>
    <select name="id_marca_produto" class="form-select" required>
        <option value="">Selecione</option>

        <?php if($totalRows_marcas > 0){ ?>
            <?php do { ?>
                <option value="<?php echo $row_marcas['id_marca']; ?>">
                    <?php echo $row_marcas['nome_marca']; ?>
                </option>
            <?php } while($row_marcas = $lista_marcas->fetch_assoc()); ?>
        <?php } ?>

    </select>
</div>


<div class="col-md-4 mb-3">
    <label class="form-label fw-semibold">Gênero</label>
    <select name="id_genero_produto" class="form-select" required>
        <option value="">Selecione</option>

        <?php if($totalRows_generos > 0){ ?>
            <?php do { ?>
                <option value="<?php echo $row_generos['id_genero']; ?>">
                    <?php echo $row_generos['nome_genero']; ?>
                </option>
            <?php } while($row_generos = $lista_generos->fetch_assoc()); ?>
        <?php } ?>

    </select>
</div>


<div class="col-md-4 mb-3">
    <label class="form-label fw-semibold">Tipo</label>
    <select name="id_tipo_produto" class="form-select" required>
        <option value="">Selecione</option>

        <?php if($totalRows_tipos > 0){ ?>
            <?php do { ?>
                <option value="<?php echo $row_tipos['id_tipo']; ?>">
                    <?php echo $row_tipos['nome_tipo']; ?>
                </option>
            <?php } while($row_tipos = $lista_tipos->fetch_assoc()); ?>
        <?php } ?>

    </select>
</div>


</div>

<!-- Promo / Sneakers -->
<div class="row">

<div class="col-md-6 mb-3">
    <label class="form-label fw-semibold">Promoção</label>
    <select name="promoção_produto" class="form-select">
        <option value="Pro">Pro</option>
        <option value="Não">Não</option>
    </select>
</div>

<div class="col-md-6 mb-3">
    <label class="form-label fw-semibold">Sneakers</label>
    <select name="sneakers_produto" class="form-select">
        <option value="Sne">Sne</option>
        <option value="Not">Not</option>
    </select>
</div>

</div>

<!-- Imagem -->
<div class="mb-3">
    <label class="form-label fw-semibold">Imagem</label>

    <img id="preview" class="preview-img img-fluid">

    <input
        type="file"
        name="imagem_produto"
        id="imagem_produto"
        class="form-control"
        accept="image/*"
        required
    >
</div>

<button type="submit" name="enviar" class="btn btn-warning w-100 fw-semibold">
    Cadastrar Produto
</button>

</form>

</div>
</div>
</div>
</div>

</main>

<script>
document.getElementById('imagem_produto').addEventListener('change', function (e) {
    const preview = document.getElementById('preview');
    const file = e.target.files[0];

    if (file) {
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
    }
});
</script>

</body>
</html>
