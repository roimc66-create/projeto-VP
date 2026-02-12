<?php
include("../Connections/conn_produtos.php");

if ($_POST) {

    mysqli_select_db($conn_produtos, $database_conn);

    $tabela_insert = "tbusuarios";
    $campos_insert = "login_usuario, senha_usuario, nivel_usuario";

    $login_usuario = $_POST['login_usuario'];
    $senha_usuario = $_POST['senha_usuario'];
    $nivel_usuario = $_POST['nivel_usuario'];

    $valores_insert = "'$login_usuario', '$senha_usuario', '$nivel_usuario'";

    $insertSQL = "
        INSERT INTO $tabela_insert ($campos_insert)
        VALUES ($valores_insert)
    ";

    $resultado = $conn_produtos->query($insertSQL);

    header("Location: usuario_lista.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Inserir Usuário</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

   <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"/>

    <style>
        body {
            background: #ffffff;
            min-height: 100vh;
        }
        .card-custom {
            border-radius: 18px;
            padding: 30px;
            background: #fff;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            margin-top: 50px;
        }
    </style>
</head>

<body>

<?php include("menu.php"); ?>

<main class="container">

    <div class="row justify-content-center">
        <div class="col-12 col-sm-8 col-md-6 col-lg-4">

            <div class="card-custom">

                <div class="d-flex align-items-center mb-3">
                    <a href="usuario_lista.php" class="btn btn-warning me-3">
                        ←
                    </a>
                    <h4 class="mb-0 text-warning fw-bold">Inserir Usuário</h4>
                </div>

                <div class="alert alert-warning">

                    <form
                        action="usuario_insere.php"
                        method="post"
                        id="form_insere_usuario"
                        name="form_insere_usuario"
                    >

                        <!-- Login -->
                        <div class="mb-3">
                            <label for="login_usuario" class="form-label fw-semibold">
                                Login:
                            </label>

                            <input
                                type="text"
                                name="login_usuario"
                                id="login_usuario"
                                class="form-control"
                                maxlength="30"
                                required
                                placeholder="Digite o login"
                            >
                        </div>

                        <!-- Senha -->
                        <div class="mb-3">
                            <label for="senha_usuario" class="form-label fw-semibold">
                                Senha:
                            </label>

                            <input
                                type="password"
                                name="senha_usuario"
                                id="senha_usuario"
                                class="form-control"
                                maxlength="8"
                                required
                                placeholder="Digite a senha"
                            >
                        </div>

                        <!-- Nível -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Nível do usuário:
                            </label>

                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="radio"
                                    name="nivel_usuario"
                                    id="nivel_user"
                                    value="user"
                                    checked
                                >
                                <label class="form-check-label" for="nivel_user">
                                    User
                                </label>
                            </div>

                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="radio"
                                    name="nivel_usuario"
                                    id="nivel_admin"
                                    value="admin"
                                >
                                <label class="form-check-label" for="nivel_admin">
                                    Admin
                                </label>
                            </div>
                        </div>

                        <button
                            type="submit"
                            name="enviar"
                            class="btn btn-warning w-100 fw-semibold"
                        >
                            Cadastrar
                        </button>

                    </form>

                </div>

            </div>

        </div>
    </div>

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
