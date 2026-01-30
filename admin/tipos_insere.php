<?php
include("../Connections/conn_produtos.php");

if ($_POST) {

    mysqli_select_db($conn_produtos, $database_conn);

    $tabela_insert = "tbtipos";
    $campos_insert = "nome_tipo";

    $nome_tipo = $_POST['nome_tipo'];

    $valores_insert = "'$nome_tipo'";

    $insertSQL = "
        INSERT INTO $tabela_insert ($campos_insert)
        VALUES ($valores_insert)
    ";

    $resultado = $conn_produtos->query($insertSQL);

    header("Location: tipos_lista.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Inserir Tipo</title>
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

<main class="container">

    <div class="row justify-content-center">
        <div class="col-12 col-sm-8 col-md-6 col-lg-4">

            <div class="card-custom">

                <div class="d-flex align-items-center mb-3">
                    <a href="tipos_lista.php" class="btn btn-warning me-3">
                        ←
                    </a>
                    <h4 class="mb-0 text-warning fw-bold">Inserir Nome</h4>
                </div>

                <div class="alert alert-warning">

                    <form
                        action="tipos_insere.php"
                        method="post"
                        id="form_insere_tipo"
                        name="form_insere_tipo"
                    >

                        <div class="mb-3">
                            <label for="nome_tipo" class="form-label fw-semibold">
                                Nome:
                            </label>

                            <div class="input-group">
                                <span class="input-group-text">Tipo</span>
                                <input
                                    type="text"
                                    name="nome_tipo"
                                    id="nome_tipo"
                                    class="form-control"
                                    maxlength="15"
                                    required
                                    autofocus
                                    placeholder="Digite o Nome do tipo"
                                >
                            </div>
                        </div>

                        <button
                            type="submit"
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

