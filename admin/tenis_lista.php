<?php
// Incluir o arquivo e fazer a conexão
include("../Connections/conn_produtos.php");

// Selecionar os dados
$consulta   =   "
                SELECT  *
                FROM    vw_tbtenis
                ORDER BY resumo_tenis ASC;
                ";
// Fazer uma lista completa dos dados
$lista      =   $conn_produtos->query($consulta);
// Separar os dados em linhas (row)
$row        =   $lista->fetch_assoc();
// Contar o total de linhas
$totalRows  =   ($lista)->num_rows;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Tênis</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" 
          href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script 
      src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js">
    </script>
</head>

<body style="padding: 20px">

    <h2>Lista de Tênis</h2>
    <a href="tenis_insere.php" class="btn btn-success">ADICIONAR NOVO</a>
    <br><br>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tipo</th>
                <th>Nome</th>
                <th>Resumo</th>
                <th>Valor</th>
                <th>Imagem</th>
                <th>Ações</th>
            </tr>
        </thead>

        <tbody>
        <?php while($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id_tenis']; ?></td>

                <td><?php echo $row['nome_tipo']; ?></td>

                <td><?php echo $row['nome_tenis']; ?></td>

                <td><?php echo $row['resumo_tenis']; ?></td>

                <td><?php echo number_format($row['valor_tenis'], 2, ',', '.'); ?></td>

                <td>
                    <img src="../imagens/<?php echo $row['imagem_tenis']; ?>" 
                         width="100">
                </td>

                <td>
                    <a href="tenis_atualiza.php?id_tenis=<?php echo $row['id_tenis']; ?>"
                       class="btn btn-warning btn-xs btn-block">
                        ALTERAR
                    </a>

                    <button
                        data-id="<?php echo $row['id_tenis']; ?>"
                        data-nome="<?php echo $row['nome_tenis']; ?>"
                        class="btn btn-danger btn-xs btn-block delete">
                        EXCLUIR
                    </button>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>


    <!-- MODAL DE CONFIRMAÇÃO DE EXCLUSÃO
    <div id="modalDelete" class="modal fade">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">

                <div class="modal-header bg-danger">
                    <button class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Excluir Tênis</h4>
                </div>

                <div class="modal-body">
                    <p>Tem certeza que deseja excluir:</p>
                    <strong id="nomeTenis"></strong>
                </div>

                <div class="modal-footer">
                    <a id="btnConfirmDelete" 
                       class="btn btn-danger btn-block">
                        Excluir
                    </a>
                </div>

            </div>
        </div>
    </div> -->

    <!-- <script>
        // Ação do botão excluir
        $(".delete").on("click", function () {

            let id = $(this).data("id");
            let nome = $(this).data("nome");

            $("#nomeTenis").text(nome);
            $("#btnConfirmDelete").attr("href", "tenis_exclui.php?id_tenis=" + id);

            $("#modalDelete").modal("show");
        });
    </script> -->

</body>
</html>
