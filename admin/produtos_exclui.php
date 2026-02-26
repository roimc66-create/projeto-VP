<?php
ob_start();
include("../Connections/conn_produtos.php");

mysqli_select_db($conn_produtos, $database_conn);

$tabela_delete  = "tbprodutos";
$id_tabela_del  = "id_produto";
$id_filtro_del  = $_GET['id_produto'];

$deleteSQL = "
    DELETE
    FROM ".$tabela_delete."
    WHERE ".$id_tabela_del."=".$id_filtro_del.";
";

$conn_produtos->query($deleteSQL);

echo "<script>window.open('produtos_lista.php','_self')</script>";
exit;
?>
