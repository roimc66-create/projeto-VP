<?php
// Incluir o arquivo de conexão
include("../Connections/conn_produtos.php");

// Definindo o USE do banco
mysqli_select_db($conn_produtos, $database_conn);

// Definindo dados para exclusão
$tabela_delete = "tbprodutos";
$id_tabela_del = "id_produto";
$id_filtro_del = $_GET['id_produto'];

// SQL para excluir o produto
$deleteSQL = "
    DELETE
    FROM    ".$tabela_delete."
    WHERE   ".$id_tabela_del." = ".$id_filtro_del.";
";

// Executa a exclusão
$resultado = $conn_produtos->query($deleteSQL);

// Página de destino
$destino = "produtos_lista.php";

// Redireciona após excluir
header("Location: $destino");
?>
