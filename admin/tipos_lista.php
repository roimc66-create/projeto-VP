<?php
include("../Connections/conn_produtos.php");

// --- CONSULTA VIA VIEW ---
$consulta = "
            SELECT *
            FROM tbtipos
            ORDER BY id_tipo ASC;
            ";

$lista = $conn_produtos->query($consulta);
$row        =   $lista->fetch_assoc();
// Contar o total de linhas
$totalRows  =   ($lista)->num_rows;
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>tipo-Lista</title>
    <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"/>
            <style>
        body { background:rgb(255, 255, 255); min-height: 100vh; }
        .card-custom { border-radius: 18px; padding: 40px; background: #fff; box-shadow: 0 10px 30px rgba(0,0,0,0.06); margin-top: 40px; }
        .page-title { font-weight: 700; font-size: 32px; color: #1f2937; }
        .header-bar { height: 4px; width: 70px; background: #0d6efd; border-radius: 10px; margin-bottom: 20px; }
        thead { background: #0d6efd; color: white; }
        .table-hover tbody tr:hover { background: #eef5ff; }
        .table img { border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.15); transition: 0.2s; }
        .table img:hover { transform: scale(1.08); }
        .badge-tipo { background: #0d6efd !important; padding: 7px 13px; border-radius: 6px; font-size: 13px; font-weight: 600; }
        .btn-custom { border-radius: 10px; font-weight: 600; }
    </style>
</head>
<body>
        <div class="container">

    <div class="card-custom">

        <div class="header-bar"></div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="page-title">Catálogo de Tipos</h2>

            <a href="tipos_insere.php" class="btn btn-success btn-lg btn-custom shadow-sm">
                ➕ Adicionar Novo
            </a>
        </div>

        <div class="table-responsive mt-4">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>ID</th>                        
                        <th>Nome</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>

                <tbody>
                <?php while($row = $lista->fetch_assoc()) { ?>
                    <tr>
                        <td><strong><?php echo $row['id_tipo']; ?></strong></td>

                        <td><?php echo $row['nome_tipo']; ?></td>

                        <td class="text-center">

                            <a href="tipos_atualiza.php?id_tipo=<?php echo $row['id_tipo']; ?>"
                            class="btn btn-warning btn-sm w-100 mb-2 btn-custom">
                                ✏ Editar
                            </a>
                          
                            <button
                                data-id="<?php echo $row['id_tipo']; ?>"
                                data-nome="<?php echo $row['nome_tipo']; ?>"
                                class="btn btn-danger btn-sm w-100 btn-custom btn-block delete">
                                <span class="hidden-xs">EXCLUIR<br></span>
                        <span class="glyphicon glyphicon-trash"></span>
                            </button>
                            
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>

    </div>

</div>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                >
                    &times;
                </button>
                <h4 class="modal-title text-danger">ATENÇÃO!</h4>
            </div> <!-- fecha modal-header -->
            <div class="modal-body">
                Deseja mesmo EXCLUIR o item?
                <h4><span class="nome text-danger"></span></h4>
            </div> <!-- fecha modal-body -->
            <div class="modal-footer">
                <a 
                    href="#" 
                    type="button" 
                    class="btn btn-danger delete-yes"
                >
                    Confirmar
                </a>
                <button class="btn btn-success" data-dismiss="modal">
                    Cancelar
                </button>
            </div> <!-- fecha modal-footer -->
        </div> <!-- fecha modal-content -->
    </div> <!-- fecha modal-dialog -->
</div> <!-- fecha modal -->

<script           src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
           crossorigin="anonymous"
        ></script>
        <!-- Script para o Modal -->
<script type="text/javascript">
    $('.delete').on('click',function(){
        var nome    =   $(this).data('nome');
        // buscar o valor do atributo data-nome
        var id      =   $(this).data('id');
        // buscar o valor do atributo data-id
        $('span.nome').text(nome);
        // Inserir o nome do item na pergunta de confirmação
        $('a.delete-yes').attr('href','tipos_exclui.php?id_tipo='+id);
        // mudar dinamicamente o id do link no botão confirmar
        $('#myModal').modal('show'); // abre modal
    });
</script>
</body>
</html>