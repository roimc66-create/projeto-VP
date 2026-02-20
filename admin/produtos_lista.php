<?php
include("protecao.php");
include("../Connections/conn_produtos.php");

// --- CONSULTA VIA VIEW (AJUSTADA) ---
$consulta = "
    SELECT DISTINCT
        id_produto,
        id_marca_produto,
        id_genero_produto,
        id_tipo_produto,
        nome_tipo,
        nome_marca,
        nome_genero,
        imagem_marca,
        nome_produto,
        resumo_produto,
        valor_produto,
        imagem_produto,
        promoção_produto,
        sneakers_produto
    FROM vw_tbprodutos
    ORDER BY id_produto ASC;
";

$lista = $conn_produtos->query($consulta);
if(!$lista){
    die("Erro na consulta: " . $conn_produtos->error);
}

$row        = $lista->fetch_assoc();
// Contar o total de linhas
$totalRows  = $lista->num_rows;
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Tênis</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>
        body { background:#fff; min-height:100vh; }
        .card-custom { border-radius:18px; padding:40px; background:#fff; box-shadow:0 10px 30px rgba(0,0,0,0.06); margin-top:40px; }
        .page-title { font-weight:700; font-size:32px; color:#1f2937; }
        .header-bar { height:4px; width:70px; background:#0d6efd; border-radius:10px; margin-bottom:20px; }
        thead { background:#0d6efd; color:white; }
        .table-hover tbody tr:hover { background:#eef5ff; }
        .badge-tipo { background:#0d6efd; padding:7px 13px; border-radius:6px; font-size:13px; font-weight:600; }
        .btn-custom { border-radius:10px; font-weight:600; }
    </style>
</head>

<body class="fundoBanner">

<?php include("menu.php"); ?>

<div class="container">
    <div class="card-custom">

        <div class="header-bar"></div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="page-title">Catálogo de Tênis</h2>

            <a href="produtos_insere.php" class="btn btn-success btn-lg btn-custom">
                ➕ Adicionar Novo
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tipo</th>
                        <th>Nome</th>
                        <th>Resumo</th>
                        <th>Valor</th>
                        <th>Gênero</th>
                        <th>Imagem</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>

                <tbody>
                <?php do { ?>
                    <tr>
                        <td><strong><?php echo $row['id_produto']; ?></strong></td>
                        <td><span class="badge badge-tipo"><?php echo $row['nome_tipo']; ?></span></td>
                        <td><?php echo $row['nome_produto']; ?></td>
                        <td><?php echo $row['resumo_produto']; ?></td>
                        <td class="text-success fw-bold">
                            R$ <?php echo number_format($row['valor_produto'],2,',','.'); ?>
                        </td>
                        <td><?php echo $row['nome_genero']; ?></td>
                        <td>
                            <img src="../imagens/exclusivo/<?php echo $row['imagem_produto']; ?>" width="100">
                        </td>
                        <td class="text-center">

                            <a href="produtos_atualiza.php?id_produto=<?php echo $row['id_produto']; ?>"
                            class="btn btn-warning btn-sm w-100 mb-2 btn-custom">
                                ✏ Editar
                            </a>

                            <button
                                data-id="<?php echo $row['id_produto']; ?>"
                                data-nome="<?php echo $row['nome_produto']; ?>"
                                class="btn btn-danger btn-sm w-100 btn-custom delete">
                                🗑 Excluir
                            </button>

                        </td>
                    </tr>
                <?php } while ($row = $lista->fetch_assoc()); ?>
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
                <p class="mb-2">Deseja mesmo EXCLUIR o item?</p>
                <h5 class="nome text-danger"></h5>
            </div>

            <div class="modal-footer justify-content-center">
                <a href="#" class="btn btn-danger delete-yes">Confirmar</a>
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>

        </div>
    </div>
</div>


<!-- JS BOOTSTRAP -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- SCRIPT EXCLUIR -->
<script>
document.addEventListener("DOMContentLoaded", function () {

    document.querySelectorAll(".delete").forEach(botao => {
        botao.addEventListener("click", function () {

            const nome = this.dataset.nome;
            const id   = this.dataset.id;

            document.querySelector(".nome").textContent = nome;
            document.querySelector(".delete-yes").href =
                "produtos_exclui.php?id_produto=" + id;

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
