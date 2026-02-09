<?php
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

header("Location: marcas_lista.php");
exit;
?>
