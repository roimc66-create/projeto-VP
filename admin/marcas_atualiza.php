<?php
include("../Connections/conn_produtos.php");

if (!isset($_GET['id_marca'])) {
    header("Location: marcas_lista.php");
    exit;
}

$id_marca = (int) $_GET['id_marca'];

$r = $conn_produtos->query(
    "SELECT * FROM tbmarcas WHERE id_marca = $id_marca"
);

if ($r->num_rows == 0) {
    header("Location: marcas_lista.php");
    exit;
}

$marca = $r->fetch_assoc();

if ($_POST) {

    $nome = $_POST['nome_marca'];

    if (!empty($_FILES['imagem_marca']['name'])) {

        $imagem = $_FILES['imagem_marca']['name'];
        move_uploaded_file(
            $_FILES['imagem_marca']['tmp_name'],
            "../imagens/tenis/" . $imagem
        );

        $conn_produtos->query(
            "UPDATE tbmarcas 
             SET nome_marca = '$nome',
                 imagem_marca = '$imagem'
             WHERE id_marca = $id_marca"
        );

    } else {

        $conn_produtos->query(
            "UPDATE tbmarcas 
             SET nome_marca = '$nome'
             WHERE id_marca = $id_marca"
        );
    }

    header("Location: marcas_lista.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Marca</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
    />

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
                    <a href="marcas_lista.php" class="btn btn-warning me-3">
                        ←
                    </a>
                    <h4 class="mb-0 text-warning fw-bold">Editar Marca</h4>
                </div>

                <div class="alert alert-warning">

                    <form method="post" enctype="multipart/form-data">

                        <!-- Nome -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Nome:
                            </label>

                            <input
                                type="text"
                                name="nome_marca"
                                value="<?= $marca['nome_marca']; ?>"
                                class="form-control"
                                required
                            >
                        </div>

                        <!-- Imagem atual -->
                        <div class="mb-3 text-center">
                            <label class="form-label fw-semibold d-block">
                                Imagem atual:
                            </label>

                            <img
                                src="../imagens/tenis/<?= $marca['imagem_marca']; ?>"
                                class="img-fluid rounded shadow"
                                style="max-width:120px;"
                            >
                        </div>

                        <!-- Nova imagem -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Nova imagem (opcional):
                            </label>

                            <input
                                type="file"
                                name="imagem_marca"
                                class="form-control"
                            >
                        </div>

                        <button
                            type="submit"
                            class="btn btn-warning w-100 fw-semibold"
                        >
                            💾 Salvar
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