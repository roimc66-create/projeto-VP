<?php
include("protecao.php");
include("../Connections/conn_produtos.php");

if ($_POST) {

    mysqli_select_db($conn_produtos, $database_conn);

    $tabela_insert = "tbgeneros";
    $campos_insert = "nome_genero";

    $nome_genero = $_POST['nome_genero'];

    $valores_insert = "'$nome_genero'";

    $insertSQL = "
        INSERT INTO $tabela_insert ($campos_insert)
        VALUES ($valores_insert)
    ";

    $resultado = $conn_produtos->query($insertSQL);

    header("Location: genero_lista.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Inserir Gênero</title>
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
    </style>
</head>

<body>

<?php include("menu.php"); ?>

<main class="container">

    <div class="row justify-content-center">
        <div class="col-12 col-sm-8 col-md-6 col-lg-4">

            <div class="card-custom">

                <div class="d-flex align-items-center mb-3">
                    <a href="genero_lista.php" class="btn btn-warning me-3">
                        ←
                    </a>
                    <h4 class="mb-0 text-warning fw-bold">Inserir Gênero</h4>
                </div>

                <div class="alert alert-warning">

                    <form
                        action="genero_insere.php"
                        method="post"
                        id="form_insere_genero"
                        name="form_insere_genero"
                    >

                        <div class="mb-3">
                            <label for="nome_genero" class="form-label fw-semibold">
                                Rótulo:
                            </label>

                            <input
                                type="text"
                                name="nome_genero"
                                id="nome_genero"
                                class="form-control"
                                maxlength="15"
                                required
                                autofocus
                                placeholder="Digite o gênero"
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
</body>
</html>
