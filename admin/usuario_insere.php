<?php
include("protecao.php");
include("../Connections/conn_produtos.php");

$erroMsg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $login_usuario = trim($_POST['login_usuario']);
    $email_usuario = trim($_POST['email_usuario']);
    $senha_usuario = trim($_POST['senha_usuario']);
    $nivel_usuario = $_POST['nivel_usuario'];

    if ($login_usuario === "" || $email_usuario === "" || $senha_usuario === "") {
        $erroMsg = "Preencha todos os campos.";
    } else {

        $stmt = $conn_produtos->prepare(
            "SELECT id_usuario FROM tbusuarios WHERE login_usuario = ? OR email_usuario = ?"
        );
        $stmt->bind_param("ss", $login_usuario, $email_usuario);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $erroMsg = "Login ou email já cadastrado.";
        } else {

            $stmtInsert = $conn_produtos->prepare(
                "INSERT INTO tbusuarios 
                (login_usuario, email_usuario, senha_usuario, nivel_usuario)
                VALUES (?, ?, ?, ?)"
            );

            $stmtInsert->bind_param(
                "ssss",
                $login_usuario,
                $email_usuario,
                $senha_usuario,
                $nivel_usuario
            );

            if ($stmtInsert->execute()) {
                header("Location: usuario_lista.php");
                exit;
            } else {
                $erroMsg = "Erro ao cadastrar usuário.";
            }

            $stmtInsert->close();
        }

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Inserir Usuário</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

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
                    <a href="usuario_lista.php" class="btn btn-warning me-3">←</a>
                    <h4 class="mb-0 text-warning fw-bold">Inserir Usuário</h4>
                </div>

                <?php if (!empty($erroMsg)): ?>
                    <div class="alert alert-danger py-2">
                        <?= htmlspecialchars($erroMsg) ?>
                    </div>
                <?php endif; ?>

                <form method="post">

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Login:</label>
                        <input type="text"
                               name="login_usuario"
                               class="form-control"
                               maxlength="30"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email:</label>
                        <input type="email"
                               name="email_usuario"
                               class="form-control"
                               maxlength="150"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Senha:</label>
                        <input type="password"
                               name="senha_usuario"
                               class="form-control"
                               maxlength="60"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nível do usuário:</label>

                        <div class="form-check">
                            <input class="form-check-input"
                                   type="radio"
                                   name="nivel_usuario"
                                   value="user"
                                   checked>
                            <label class="form-check-label">User</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input"
                                   type="radio"
                                   name="nivel_usuario"
                                   value="admin">
                            <label class="form-check-label">Admin</label>
                        </div>
                    </div>

                    <button type="submit"
                            class="btn btn-warning w-100 fw-semibold">
                        Cadastrar
                    </button>

                </form>

            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>