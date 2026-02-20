<?php
 include("protecao.php");
include("../Connections/conn_produtos.php");

/* ===== VALIDA ID ===== */
if (!isset($_GET['id_tamanho'])) {
    header("Location: tamanhos_lista.php");
    exit;
}

$id_tamanho = (int) $_GET['id_tamanho'];
$mensagem = "";

/* ===== ATUALIZAR ===== */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['numero_tamanho']) && $_POST['numero_tamanho'] !== "") {

        $numero_tamanho = (int) $_POST['numero_tamanho'];

        if ($numero_tamanho <= 0) {
            $mensagem = "<div class='alert alert-warning'>⚠️ Informe um tamanho válido.</div>";
        } else {

            $stmt = $conn_produtos->prepare("
                UPDATE tbtamanhos
                SET numero_tamanho = ?
                WHERE id_tamanho = ?
            ");
            $stmt->bind_param("ii", $numero_tamanho, $id_tamanho);

            if ($stmt->execute()) {
                header("Location: tamanhos_lista.php");
                exit;
            } else {
                $mensagem = "<div class='alert alert-danger'>Erro: {$conn_produtos->error}</div>";
            }
        }
    }
}

/* ===== BUSCAR DADOS ===== */
$stmt = $conn_produtos->prepare("
    SELECT *
    FROM tbtamanhos
    WHERE id_tamanho = ?
");
$stmt->bind_param("i", $id_tamanho);
$stmt->execute();
$dados = $stmt->get_result();
$row = $dados->fetch_assoc();

if (!$row) {
    header("Location: tamanhos_lista.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Editar Tamanho</title>

<link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
    rel="stylesheet">

<style>
body { background:#ffffff; min-height:100vh; }
.card-custom {
    border-radius:18px;
    padding:30px;
    background:#fff;
    box-shadow:0 10px 30px rgba(0,0,0,0.08);
    margin-top:50px;
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
                    <h4 class="mb-0 text-warning fw-bold">Editar Tamanho</h4>
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
                                value="<?php echo $row['numero_tamanho']; ?>"
                                required>
                        </div>

                        <button
                            type="submit"
                            class="btn btn-warning w-100 fw-semibold">
                            Salvar Alterações
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