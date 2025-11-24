<?php
// Incluir o arquivo e fazer a conexão
include("../Connections/conn_produtos.php");

// Selecionar os dados
$consulta   =   "
                SELECT  *
                FROM    vw_tbprodutos
                ORDER BY descri_produto ASC;
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
    <title>Modelo</title>
    <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"/>
</head>
<body>

<script           src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
           crossorigin="anonymous"
        ></script>
</body>
</html>