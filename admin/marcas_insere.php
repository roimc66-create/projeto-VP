<?php
// Incluir o arquivo e fazer a conexão
include("../Connections/conn_produtos.php");

if($_POST){
    // Selecionar o banco de dados (USE)
    mysqli_select_db($conn_produtos,$database_conn);

    // Variáveis para acrescentar dados no banco
    $tabela_insert  =   "tbmarcas";
    $campos_insert  =   "
                            nome_marca,
                            imagem_marca                           
                        ";

    // Guardar o nome da imagem no banco e o arquivo no diretório
    if(isset($_POST['enviar'])){
        $nome_img   =   $_FILES['imagem_marca']['name'];
        $tmp_img    =   $_FILES['imagem_marca']['tmp_name'];
        $dir_img    =   "../imagens/exclusivo/".$nome_img;
        move_uploaded_file($tmp_img,$dir_img);
    };                    
    // Receber os dados do formulário
    // Organizar os campos na mesma ordem
    $nome_marca     =   $_POST['nome_marca'];
    $imagem_marca     =   $_FILES['imagem_marca']['name'];

    // Reunir os valores a serem inseridos
    $valores_insert =   "
                        '$nome_marca',
                        '$imagem_marca'
                        ";

    // Consulta SQL para inserção dos dados
    $insertSQL  =   "
                    INSERT INTO ".$tabela_insert."
                        (".$campos_insert.")
                    VALUES
                        (".$valores_insert.");
                    ";
    $resultado  =   $conn_produtos->query($insertSQL);

    // Após a ação a página será redirecionada
    $destino    =   "marcas_lista.php";
    if(mysqli_insert_id($conn_produtos)){
        header("Location: $destino");
    }else{
        header("Location: $destino");
    };
};
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
<main class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-offset-3 col-sm-6 col-md-offset-4 col-md-4" > <!-- abre dimensionamento -->
            <h2 class="breadcrumb text-warning">
                <a href="tipos_lista.php">
                    <button class="btn btn-warning">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                    </button>
                </a>
                Inserir Marca
            </h2>
            <div class="thumbnail">
                <div class="alert alert-warning">
                    <form 
                        action="marcas_insere.php"
                        enctype="multipart/form-data"
                        method="post"
                        id="form_insere_tipo"
                        name="form_insere_tipo"
                    >
                        <!-- text nome_marca -->
                        <label for="nome_marca">Rótulo:</label>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-apple"></span>
                            </span>
                            <input 
                                type="text" 
                                name="nome_marca" 
                                id="nome_marca"
                                class="form-control"
                                autofocus
                                maxlength="15"
                                required
                                placeholder="Digite o marca."
                            >
                        </div> <!-- fecha input-group -->
                        <!-- fecha text nome_marca -->
                        <br>
                         <!-- file imagem_marca -->
                        <label for="imagem_marca">Imagem:</label>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-picture"></span>
                            </span>
                            <!-- Exibir a imagem a ser inserida -->
                            <img 
                                src="" 
                                alt=""
                                name="imagem"
                                id="imagem"
                                class="img-responsive"
                                style="max-height: 150px;"
                            >
                            <input 
                                type="file" 
                                name="imagem_marca" 
                                id="imagem_marca"
                                class="form-control"
                                accept="image/*"
                            >
                        </div> <!-- fecha input-group -->
                        <!-- fecha file imagem_marca -->
                        <br>
                        <!-- btn enviar -->
                        <input 
                            type="submit" 
                            value="Cadastrar"
                            name="enviar"
                            id="enviar"
                            role="button"
                            class="btn btn-warning btn-block"
                        >
                    </form>
                </div> <!-- fecha alert alert-warning  -->
            </div> <!-- thumbnail -->
        </div> <!-- dimensionamento -->
    </div> <!-- fecha row -->
</main>

<script           src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
           crossorigin="anonymous"
        ></script>
</body>
</html>