<?php
 include("protecao.php");
include("../Connections/conn_produtos.php");

$consulta = "
    SELECT *
    FROM tbtamanhos
    ORDER BY id_tamanho ASC
";

$lista = $conn_produtos->query($consulta);
if(!$lista){
    die("Erro na consulta: " . $conn_produtos->error);
}

$row       = $lista->fetch_assoc();
$totalRows = $lista->num_rows;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Lista de Tamanhos</title>

<link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
    rel="stylesheet"
>

<style>
body { background:#fff; min-height:100vh; }
.card-custom {
    border-radius:18px;
    padding:40px;
    background:#fff;
    box-shadow:0 10px 30px rgba(0,0,0,0.06);
    margin-top:40px;
}
.page-title { font-weight:700; font-size:32px; color:#1f2937; }
.header-bar {
    height:4px;
    width:70px;
    background:#0d6efd;
    border-radius:10px;
    margin-bottom:20px;
}
thead { background:#0d6efd; color:white; }
.table-hover tbody tr:hover { background:#eef5ff; }
.btn-custom { border-radius:10px; font-weight:600; }
</style>
</head>

<body>

<?php include("menu.php"); ?>

<div class="container">
    <div class="card-custom">

        <div class="header-bar"></div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="page-title">Lista de Tamanhos</h2>

            <a href="tamanhos_insere.php"
               class="btn btn-success btn-lg btn-custom">
               ➕ Adicionar Novo
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tamanho</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>

                <tbody>
                <?php if($totalRows > 0) { do { ?>
                    <tr>
                        <td><strong><?php echo $row['id_tamanho']; ?></strong></td>
                        <td class="fw-semibold">
                            <?php echo $row['numero_tamanho']; ?>
                        </td>
                        <td class="text-center">

                            <a href="editar_tamanho.php?id_tamanho=<?php echo $row['id_tamanho']; ?>"
                               class="btn btn-warning btn-sm w-100 mb-2 btn-custom">
                                ✏ Editar
                            </a>

                            <button
                                data-id="<?php echo $row['id_tamanho']; ?>"
                                data-nome="<?php echo $row['numero_tamanho']; ?>"
                                class="btn btn-danger btn-sm w-100 btn-custom delete">
                                🗑 Excluir
                            </button>

                        </td>
                    </tr>
                <?php } while ($row = $lista->fetch_assoc()); } ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<!-- MODAL EXCLUIR -->
<div class="modal fade" id="myModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title text-danger">ATENÇÃO!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">
                <p class="mb-2">Deseja mesmo EXCLUIR o tamanho?</p>
                <h5 class="nome text-danger"></h5>
            </div>

            <div class="modal-footer justify-content-center">
                <a href="#" class="btn btn-danger delete-yes">Confirmar</a>
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    document.querySelectorAll(".delete").forEach(botao => {
        botao.addEventListener("click", function () {

            const nome = this.dataset.nome;
            const id   = this.dataset.id;

            document.querySelector(".nome").textContent = nome;
            document.querySelector(".delete-yes").href =
                "excluir_tamanho.php?id_tamanho=" + id;

            new bootstrap.Modal(
                document.getElementById("myModal")
            ).show();
        });
    });

});
</script>

</body>
</html>

<?php mysqli_free_result($lista); ?>