<?php
// Incluir o arquivo e fazer a conexão
include("../Connections/conn_produtos.php");

// Selecionar os dados
$consulta   =   "
                SELECT  *
                FROM    tbtenis
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Tênis</title>
    <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"/>
</head>
<body>
<!-- main>h1 -->
<main class="container">
    <h1 class="breadcrumb alert-danger ">Lista de Tênis</h1>
    <div class="btn btn-danger disabled">
        Total de tênis:
        <small class="badge"><?php echo $totalRows; ?></small>
    </div>
    <!-- table>thead>tr>th*8 -->
    <table class="table table-hover table-condensed tbopacidade" >
        <thead> <!-- Cabeçalho da tabela -->
            <tr> <!-- linha da tabela -->
                <th class="hidden">ID</th> <!-- célula de cabeçalho -->
                <th>TIPO</th>
                <!-- <th>DESTAQUE</th> -->
                <th>DESCRIÇÃO</th>
                <th>RESUMO</th>
                <th>VALOR</th>
                <th>IMAGEM</th>
                <th>
                    <a 
                        href="produtos_insere.php"
                        class="btn btn-block btn-primary btn-xs"
                    >
                        <span class="hidden-xs">ADICIONAR <br></span>
                        <span class="glyphicon glyphicon-plus"></span>
                    </a>
                </th>
            </tr>
        </thead>
        <!-- tbody>tr>td*8 -->
        <tbody>
            <!-- Abre a estrutura de repetição -->
            <?php do{ ?>
            <tr>
                <td class="hidden"><?php echo $row['id_produto']; ?></td>
                <td>
                    <span class="visible-xs"><?php echo $row['sigla_tipo']; ?></span>
                    <span class="hidden-xs"><?php echo $row['rotulo_tipo']; ?></span>
                </td>
                <td>
                    <?php
                        if($row['destaque_produto']=='Sim'){
                            echo('<span class="glyphicon glyphicon-heart text-danger"></span>');
                        } else if($row['destaque_produto']=='Não'){ 
                            echo('<span class="glyphicon glyphicon-ok text-info"></span>');
                        };
                    ?>
                    <?php echo $row['descri_produto']; ?>
                </td>
                <td><?php echo $row['resumo_produto']; ?></td>
                <td><?php echo number_format($row['valor_produto'],2,',','.'); ?></td>
                <!-- 
                        vírgula >> 0,00 >> separador de decimais;
                        ponto >> 1.000 >> separador de milhares;
                 -->
                <td>
                    <!-- 
                        Para exibir uma imagem insira em 'src'
                        o diretório que ela está armazenada e
                        a variável com seu nome.
                     -->
                    <img 
                        src="../imagens/<?php echo $row['imagem_produto']; ?>" 
                        alt="<?php echo $row['descri_produto']; ?>"
                        width="100px"
                    >
                </td>
                <td>
                    <a 
                        href="produtos_atualiza.php?id_produto=<?php echo $row['id_produto']; ?>"
                        target="_self"
                        class="btn btn-warning btn-xs btn-block"
                        role="button"
                    >
                        <span class="hidden-xs">ALTERAR<br></span>
                        <span class="glyphicon glyphicon-refresh"></span>
                    </a>
                    <button
                        data-id="<?php echo $row['id_produto']; ?>"
                        data-nome="<?php echo $row['descri_produto']; ?>"                        
                        class="btn btn-danger btn-xs btn-block delete"
                    >
                        <span class="hidden-xs">EXCLUIR<br></span>
                        <span class="glyphicon glyphicon-trash"></span>
                    </button>
                </td>
            </tr>
            <?php }while($row = $lista->fetch_assoc());  ?>
            <!-- Fechar a estrutura de repetição -->
        </tbody>
    </table>
</main>

<script           src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
           crossorigin="anonymous"
        ></script>
</body>
</html>