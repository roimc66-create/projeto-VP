<?php
ob_start();
include("../Connections/conn_produtos.php");

mysqli_select_db($conn_produtos, $database_conn);

$tabela_delete  = "tbmarcas";
$id_tabela_del  = "id_marca";
$id_filtro_del  = $_GET['id_marca'];

$deleteSQL = "
    DELETE
    FROM ".$tabela_delete."
    WHERE ".$id_tabela_del."=".$id_filtro_del.";
";

$conn_produtos->query($deleteSQL);

echo "<script>window.open('marcas_lista.php','_self')</script>";
exit;
?>
