<?php
session_start();
include("Connections/conn_produtos.php");

// Se já estiver logado, mostra opção de sair (igual login)
if(isset($_SESSION['login_usuario'])){
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Cadastro</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body{background:#f5f5f5;height:100vh;display:flex;align-items:center;justify-content:center;}
.box{background:white;padding:40px;border-radius:10px;box-shadow:0 0 20px rgba(0,0,0,0.1);width:350px;text-align:center;}
</style>
</head>
<body>
<div class="box">
  <h4>Você já está logado</h4>
  <p class="mb-3">Bem-vindo,<br><strong><?php echo $_SESSION['login_usuario']; ?></strong></p>

  <?php if($_SESSION['nivel_usuario'] == 'admin'){ ?>
    <a href="admin/index.php" class="btn btn-dark w-100 mb-2">Ir para o Admin</a>
  <?php } ?>

  <a href="logout.php" class="btn btn-outline-danger w-100">Sair da conta</a>
</div>
</body>
</html>
<?php
exit;
}

// Mensagens
$erro = "";
$sucesso = "";

// Quando enviar o formulário
if($_POST){

    $login = trim($_POST['login_usuario'] ?? '');
    $senha = trim($_POST['senha_usuario'] ?? '');
    $senha2 = trim($_POST['senha_confirmar'] ?? '');

    if($login == "" || $senha == "" || $senha2 == ""){
        $erro = "Preencha todos os campos.";
    }elseif($senha != $senha2){
        $erro = "As senhas não conferem.";
    }else{

        // Verifica se já existe login
        $check = $conn_produtos->query("
            SELECT id_usuario
            FROM tbusuarios
            WHERE login_usuario = '$login'
            LIMIT 1
        ");

        if($check && $check->num_rows > 0){
            $erro = "Esse login já existe. Tente outro.";
        }else{

            // Insere como USER (não deixa criar admin por aqui)
            $insert = $conn_produtos->query("
                INSERT INTO tbusuarios (login_usuario, senha_usuario, nivel_usuario)
                VALUES ('$login', '$senha', 'user')
            ");

            if($insert){
                // Opcional: já loga o usuário e manda pro site/home
                $novoId = $conn_produtos->insert_id;

                $_SESSION['id_usuario']    = $novoId;
                $_SESSION['login_usuario'] = $login;
                $_SESSION['nivel_usuario'] = 'user';

                header("Location: index.php"); // troque para a página que você quiser
                exit;

            }else{
                $erro = "Erro ao cadastrar: " . $conn_produtos->error;
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
body{
    background:#f5f5f5;
    height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
}

.login-box{
    background:white;
    padding:40px;
    border-radius:10px;
    box-shadow:0 0 20px rgba(0,0,0,0.1);
    width:350px;
}
</style>
</head>

<body>

<div class="login-box">

<h3 class="text-center mb-4">Criar conta</h3>

<?php if($erro != ""){ ?>
  <div class="alert alert-danger py-2"><?php echo $erro; ?></div>
<?php } ?>

<form action="cadastro.php" method="POST">

    <div class="mb-3">
        <label>Login</label>
        <input type="text" name="login_usuario" class="form-control" required>
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