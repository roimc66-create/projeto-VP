<?php
session_start();
include("Connections/conn_produtos.php");

if (isset($_SESSION['login_usuario'])) {
?>
    <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <title>Cadastro</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body {
                background: #f5f5f5;
                height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .box {
                background: white;
                padding: 40px;
                border-radius: 10px;
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
                width: 350px;
                text-align: center;
            }
        </style>
    </head>

    <body>
        <div class="box">
            <h4>Você já está logado</h4>

            <p class="mb-3">
                Bem-vindo,<br>
                <strong><?php echo $_SESSION['login_usuario']; ?></strong><br>
                <small class="text-muted"><?php echo $_SESSION['email_usuario'] ?? ''; ?></small>
            </p>

            <?php if ($_SESSION['nivel_usuario'] == 'admin') { ?>
                <a href="admin/index.php" class="btn btn-dark w-100 mb-2">Ir para o Admin</a>
            <?php } ?>

            <a href="logout.php" class="btn btn-outline-danger w-100">Sair da conta</a>
        </div>
    </body>

    </html>
<?php
    exit;
}


$erro = "";
$sucesso = "";


if ($_POST) {

    $login  = trim($_POST['login_usuario'] ?? '');
    $email  = trim($_POST['email_usuario'] ?? '');
    $senha  = trim($_POST['senha_usuario'] ?? '');
    $senha2 = trim($_POST['senha_confirmar'] ?? '');

    if ($login == "" || $email == "" || $senha == "" || $senha2 == "") {
        $erro = "Preencha todos os campos.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = "Digite um e-mail válido.";
    } elseif ($senha != $senha2) {
        $erro = "As senhas não conferem.";
    } else {

        // Verifica login existente
        $check = $conn_produtos->query("
            SELECT id_usuario
            FROM tbusuarios
            WHERE login_usuario = '$login'
            LIMIT 1
        ");

        if ($check && $check->num_rows > 0) {
            $erro = "Esse login já existe.";
        } else {

            // Verifica email existente
            $checkEmail = $conn_produtos->query("
                SELECT id_usuario
                FROM tbusuarios
                WHERE email_usuario = '$email'
                LIMIT 1
            ");

            if ($checkEmail && $checkEmail->num_rows > 0) {
                $erro = "Esse e-mail já está cadastrado.";
            } else {

             
                $insert = $conn_produtos->query("
                    INSERT INTO tbusuarios
                    (login_usuario, email_usuario, senha_usuario, nivel_usuario)
                    VALUES
                    ('$login', '$email', '$senha', 'user')
                ");

                if ($insert) {

                    $novoId = $conn_produtos->insert_id;

                    $_SESSION['id_usuario']     = $novoId;
                    $_SESSION['login_usuario'] = $login;
                    $_SESSION['email_usuario'] = $email;
                    $_SESSION['nivel_usuario'] = 'user';

                    header("Location: index.php");
                    exit;
                } else {
                    $erro = "Erro ao cadastrar: " . $conn_produtos->error;
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Cadastro</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f5f5;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-box {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            width: 350px;
        }
    </style>
</head>

<body>

    <div class="login-box">

        <h3 class="text-center mb-4">Criar conta</h3>

        <?php if ($erro != "") { ?>
            <div class="alert alert-danger py-2"><?php echo $erro; ?></div>
        <?php } ?>

        <form action="cadastro.php" method="POST">

        
            <div class="mb-3">
                <label>Login</label>
                <input type="text" name="login_usuario" class="form-control" required>
            </div>

        
            <div class="mb-3">
                <label>E-mail</label>
                <input type="email" name="email_usuario" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Senha</label>
                <input type="password" name="senha_usuario" class="form-control" required>
            </div>

 
            <div class="mb-3">
                <label>Confirmar senha</label>
                <input type="password" name="senha_confirmar" class="form-control" required>
            </div>

            <button class="btn btn-dark w-100">Cadastrar</button>

            <div class="text-center mt-3">
                <small class="text-muted">Já tem login?</small><br>
                <a href="login.php" class="fw-bold text-dark text-decoration-none">Entrar agora</a>
            </div>

        </form>

    </div> 

</body>

</html>