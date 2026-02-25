<?php
include("protecao.php");
include("../Connections/conn_produtos.php");

if (!isset($_GET['id_tipo'])) {
    header("Location: tipos_lista.php");
    exit;
}

$id_tipo = (int) $_GET['id_tipo'];

$r = $conn_produtos->query(
    "SELECT * FROM tbtipos WHERE id_tipo = $id_tipo"
);

if (!$r || $r->num_rows == 0) {
    header("Location: tipos_lista.php");
    exit;
}

$tipo = $r->fetch_assoc();
$erroMsg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = trim($_POST['nome_tipo']);
    $nome = strtoupper($nome);
    $nomeEsc = $conn_produtos->real_escape_string($nome);

    if ($nome === "") {

        $erroMsg = "O nome é obrigatório.";

    } else {

        $sqlDup = "
            SELECT id_tipo 
            FROM tbtipos 
            WHERE UPPER(nome_tipo) = '$nomeEsc'
            AND id_tipo != $id_tipo
        ";

        $verifica = $conn_produtos->query($sqlDup);

        if ($verifica && $verifica->num_rows > 0) {

            $erroMsg = "Esse tipo já existe.";

        } else {

            $update = "
                UPDATE tbtipos
                SET nome_tipo = '$nomeEsc'
                WHERE id_tipo = $id_tipo
            ";

            if (!$conn_produtos->query($update)) {
                $erroMsg = "Erro ao atualizar.";
            } else {
                header("Location: tipos_lista.php");
                exit;
            }
        }
    }
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
