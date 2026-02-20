<?php
 include("protecao.php");
include("../Connections/conn_produtos.php");

$mensagem = "";

/* ===== CADASTRAR ===== */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['numero_tamanho']) && $_POST['numero_tamanho'] !== "") {

        $numero_tamanho = (int) $_POST['numero_tamanho'];

        if ($numero_tamanho <= 0) {
            $mensagem = "<div class='alert alert-warning'>⚠️ Informe um tamanho válido.</div>";
        } else {

            // verifica duplicado
            $stmt = $conn_produtos->prepare("
                SELECT id_tamanho
                FROM tbtamanhos
                WHERE numero_tamanho = ?
            ");
            $stmt->bind_param("i", $numero_tamanho);
            $stmt->execute();
            $rs_verifica = $stmt->get_result();

            if ($rs_verifica->num_rows > 0) {
                $mensagem = "<div class='alert alert-warning'>⚠️ Esse tamanho já existe.</div>";
            } else {

                $stmt = $conn_produtos->prepare("
                    INSERT INTO tbtamanhos (numero_tamanho)
                    VALUES (?)
                ");
                $stmt->bind_param("i", $numero_tamanho);

                if ($stmt->execute()) {
                    header("Location: tamanhos_lista.php");
                    exit;
                } else {
                    $mensagem = "<div class='alert alert-danger'>Erro: {$conn_produtos->error}</div>";
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Inserir Tamanho</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet">

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
                    <a href="tamanhos_lista.php" class="btn btn-warning me-3">←</a>
                    <h4 class="mb-0 text-warning fw-bold">Inserir Tamanho</h4>
                </div>

                <?php echo $mensagem; ?>

                <div class="alert alert-warning">

                    <form method="POST">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Número do Tamanho:
                            </label>

                            <input
                                type="number"
                                name="numero_tamanho"
                                class="form-control"
                                placeholder="Ex: 34, 35, 36..."
                                required>
                        </div>

                        <button
                            type="submit"
                            class="btn btn-warning w-100 fw-semibold">
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