<?php
include("../Connections/conn_produtos.php");

if (!isset($_GET['id_tipo'])) {
    header("Location: tipos_lista.php");
    exit;
}

$id_tipo = (int) $_GET['id_tipo'];

$r = $conn_produtos->query(
    "SELECT * FROM tbtipos WHERE id_tipo = $id_tipo"
);
$tipo = $r->fetch_assoc();

if ($_POST) {

    $nome = $_POST['nome_tipo'];

    $conn_produtos->query(
        "UPDATE tbtipos SET nome_tipo = '$nome' WHERE id_tipo = $id_tipo"
    );

    header("Location: tipos_lista.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Tipo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { background:#fff; min-height:100vh; }
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
                    <a href="tipos_lista.php" class="btn btn-warning me-3">←</a>
                    <h4 class="mb-0 text-warning fw-bold">Editar Tipo</h4>
                </div>

                <div class="alert alert-warning">

                    <form method="post">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nome:</label>

                            <div class="input-group">
                                <span class="input-group-text">Tipo</span>
                                <input
                                    type="text"
                                    name="nome_tipo"
                                    class="form-control"
                                    value="<?= $tipo['nome_tipo']; ?>"
                                    required
                                >
                            </div>
                        </div>

                        <button class="btn btn-warning w-100 fw-semibold">
                            Salvar
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
