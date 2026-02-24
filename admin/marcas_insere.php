<?php
include("../Connections/conn_produtos.php");

if ($_POST) {

    mysqli_select_db($conn_produtos, $database_conn);

    $tabela_insert = "tbmarcas";
    $campos_insert = "nome_marca, imagem_marca";

    if (isset($_POST['enviar'])) {
        $nome_img = $_FILES['imagem_marca']['name'];
        $tmp_img  = $_FILES['imagem_marca']['tmp_name'];
        $dir_img  = "../imagens/exclusivo/" . $nome_img;
        move_uploaded_file($tmp_img, $dir_img);
    }

    $nome_marca   = $_POST['nome_marca'];
    $imagem_marca = $_FILES['imagem_marca']['name'];

    $valores_insert = "'$nome_marca', '$imagem_marca'";

    $insertSQL = "
        INSERT INTO $tabela_insert ($campos_insert)
        VALUES ($valores_insert)
    ";

    $resultado = $conn_produtos->query($insertSQL);

    header("Location: marcas_lista.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Inserir Marca</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
<link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"/>
    <style>
        body {
            background: #ffffff;
            min-height: 100vh;
        }
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
        <div class="col-12 col-sm-8 col-md-6 col-lg-4">

            <div class="card-custom">

                <div class="d-flex align-items-center mb-3">
                    <a href="marcas_lista.php" class="btn btn-warning me-3">
                        ←
                    </a>
                    <h4 class="mb-0 text-warning fw-bold">Inserir Marca</h4>
                </div>

                <div class="alert alert-warning">

                    <form
                        action="marcas_insere.php"
                        method="post"
                        enctype="multipart/form-data"
                        id="form_insere_marca"
                        name="form_insere_marca"
                    >

                        <div class="mb-3">
                            <label for="nome_marca" class="form-label fw-semibold">
                                Rótulo:
                            </label>

                            <input
                                type="text"
                                name="nome_marca"
                                id="nome_marca"
                                class="form-control"
                                maxlength="15"
                                required
                                autofocus
                                placeholder="Digite a marca"
                            >
                        </div>

                        <div class="mb-3">
                            <label for="imagem_marca" class="form-label fw-semibold">
                                Imagem:
                            </label>

                            <img id="preview" class="preview-img img-fluid">

                            <input
                                type="file"
                                name="imagem_marca"
                                id="imagem_marca"
                                class="form-control"
                                accept="image/*"
                                required
                            >
                        </div>

                        <button
                            type="submit"
                            name="enviar"
                            class="btn btn-warning w-100 fw-semibold"
                        >
                            Cadastrar
                        </button>

                    </form>

                </div>

            </div>

        </div>
    </div>

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.getElementById('imagem_marca').addEventListener('change', function (e) {
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
