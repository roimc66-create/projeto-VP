<?php
include("../Connections/conn_produtos.php");

mysqli_select_db($conn_produtos, $database_conn);

$tabela_delete  = "tbusuarios";
$id_tabela_del  = "id_usuario";
$id_filtro_del  = $_GET['id_usuario'];

$deleteSQL = "
    DELETE
    FROM ".$tabela_delete."
    WHERE ".$id_tabela_del."=".$id_filtro_del.";
";

$conn_produtos->query($deleteSQL);

header("Location: usuario_lista.php");
exit;
?>
