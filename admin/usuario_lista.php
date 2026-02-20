<?php
 include("protecao.php");
include("../Connections/conn_produtos.php");

$sql = "
    SELECT *
    FROM tbusuarios
    ORDER BY id_usuario ASC
";

$lista = $conn_produtos->query($sql);
$row = $lista->fetch_assoc();
$totalRows = $lista->num_rows;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Usuários</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <style>
        body { background: #ffffff; min-height: 100vh; }

        .card-custom {
            margin-top: 40px;
            padding: 40px;
            border-radius: 18px;
            background: #fff;
            box-shadow: 0 10px 30px rgba(0,0,0,0.06);
        }

        .page-title {
            font-size: 32px;
            font-weight: 700;
            color: #1f2937;
        }

        .header-bar {
            width: 70px;
            height: 4px;
            background: #0d6efd;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        thead { background: #0d6efd; color: #fff; }

        .table-hover tbody tr:hover { background: #eef5ff; }

        .btn-custom {
            border-radius: 10px;
            font-weight: 600;
        }
    </style>
</head>

<!-- MODAL EXCLUIR (IGUAL AO DE PRODUTOS) -->
<div class="modal fade" id="myModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title text-danger">ATENÇÃO!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">
                Deseja mesmo EXCLUIR o usuário?
                <h5 class="nome text-danger mt-2"></h5>
            </div>

            <div class="modal-footer justify-content-center">
                <a href="#" class="btn btn-danger delete-yes">Confirmar</a>
                <button class="btn btn-success" data-bs-dismiss="modal">Cancelar</button>
            </div>

        </div>
    </div>
</div>

<body class="fundoBanner">

<?php include("menu.php"); ?>

<div class="container">

    <div class="card-custom">

        <div class="header-bar"></div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="page-title">Catálogo de Usuários</h2>

            <a href="usuario_insere.php" class="btn btn-success btn-lg btn-custom shadow-sm">
                ➕ Adicionar Novo
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Login</th>
                        <th>Nível</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>

                <tbody>
                <?php do { ?>
                    <tr>
                        <td><strong><?php echo $row['id_usuario']; ?></strong></td>

                        <td><?php echo $row['login_usuario']; ?></td>

                        <td><?php echo $row['nivel_usuario']; ?></td>

                        <td class="text-center">
                            <a
                                href="usuario_atualiza.php?id_usuario=<?php echo $row['id_usuario']; ?>"
                                class="btn btn-warning btn-sm w-100 mb-2 btn-custom">
                                ✏ Editar
                            </a>

                            <button
                                class="btn btn-danger btn-sm w-100 btn-custom delete"
                                data-id="<?php echo $row['id_usuario']; ?>"
                                data-nome="<?php echo $row['login_usuario']; ?>">
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.querySelectorAll('.delete').forEach(botao => {
    botao.addEventListener('click', function () {

        const nome = this.dataset.nome;
        const id   = this.dataset.id;

        document.querySelector('.nome').textContent = nome;
        document.querySelector('.delete-yes')
            .setAttribute('href', 'usuarios_exclui.php?id_usuario=' + id);

        const modal = new bootstrap.Modal(
            document.getElementById('myModal')
        );
        modal.show();
    });
});
</script>

</body>
</html>

<?php mysqli_free_result($lista); ?>
