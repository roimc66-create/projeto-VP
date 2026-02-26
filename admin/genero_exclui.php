<?php
include("../Connections/conn_produtos.php");

mysqli_select_db($conn_produtos, $database_conn);

$tabela_delete  = "tbgeneros";
$id_tabela_del  = "id_genero";
$id_filtro_del  = $_GET['id_genero'];

$deleteSQL = "
    DELETE
    FROM ".$tabela_delete."
    WHERE ".$id_tabela_del."=".$id_filtro_del.";
";

$conn_produtos->query($deleteSQL);

    echo "<script>window.open('adm_options.php','_self')</script>";
exit;
?>
