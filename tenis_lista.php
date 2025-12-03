<?php
include("Connections/conn_produtos.php");

$sql = "SELECT t.*, tp.nome_tipo
        FROM tbprodutos AS t
        INNER JOIN tbtipos AS tp
        ON t.id_tipo_produto = tp.id_tipo
        ORDER BY t.id_produto ASC";

$result = $conn_produtos->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Tênis</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f3f4f6;
            min-height: 100vh;
        }
        /* CARD PRINCIPAL */
        .card-custom {
            border-radius: 18px;
            padding: 40px;
            background: #ffffff;
            box-shadow: 0 10px 30px rgba(0,0,0,0.06);
            margin-top: 40px;
        }
        /* TÍTULO */
        .page-title {
            font-weight: 700;
            font-size: 32px;
            color: #1f2937;
        }

        .header-bar {
            height: 4px;
            width: 70px;
            background: #0d6efd;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        /* TABELA */
        table {
            border-radius: 10px;
            overflow: hidden;
        }

        thead {
            background: #0d6efd;
            color: white;
        }

        .table-hover tbody tr:hover {
            background: #eef5ff;
            transition: all 0.2s ease;
        }

        /* IMAGENS */
        .table img {
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0,0,0,0.15);
            transition: 0.2s;
        }

        .table img:hover {
            transform: scale(1.08);
        }

        /* TIPO */
        .badge-tipo {
            background: #0d6efd !important;
            padding: 7px 13px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
        }

        /* BOTÕES */
        .btn-custom {
            border-radius: 10px;
            font-weight: 600;
        }

        .btn-warning {
            background: #fbbf24 !important;
            border: none;
            color: #000;
        }

        .btn-warning:hover {
            background: #f59e0b !important;
        }

        .btn-danger {
            background: #ef4444 !important;
            border: none;
        }

        .btn-danger:hover {
            background: #dc2626 !important;
        }

        .btn-success {
            background: #10b981 !important;
            border: none;
        }

        .btn-success:hover {
            background: #059669 !important;
        }
    </style>
</head>

<body
{
    margin-top: 90px !important; 
}
>

      
<?php include("menu.php"); ?>

<div class="container">

    <div class="card-custom">

        <div class="header-bar"></div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="page-title">Catálogo de Tênis</h2>

            <a href="produto_insere.php" class="btn btn-success btn-lg btn-custom shadow-sm">
                ➕ Adicionar Novo
            </a>
        </div>

        <div class="table-responsive mt-4">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tipo</th>
                        <th>Nome</th>
                        <th>Resumo</th>
                        <th>Valor</th>
                        <th>Imagem</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>

                <tbody>
                <?php while($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><strong><?php echo $row['id_produto']; ?></strong></td>

                        <td><span class="badge badge-tipo"><?php echo $row['nome_tipo']; ?></span></td>

                        <td><?php echo $row['nome_produto']; ?></td>

                        <td><?php echo $row['resumo_produto']; ?></td>

                        <td>
                            <span class="fw-bold text-success">
                                R$ <?php echo number_format($row['valor_produto'], 2, ',', '.'); ?>
                            </span>
                        </td>

                        <td>
                            <img src="../imagens/<?php echo $row['imagem_produto']; ?>" width="90">
                        </td>

                        <td class="text-center">

                            <a href="produto_atualiza.php?id_produto=<?php echo $row['id_produto']; ?>"
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
                <?php } ?>
                </tbody>
            </table>
        </div>

    </div>

</div>

</body>
</html>
