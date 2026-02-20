<?php
session_start();

// SE JÁ ESTIVER LOGADO
if(isset($_SESSION['login_usuario'])){
?>
    
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Já logado</title>

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
    text-align:center;
}
</style>
</head>

<body>

<div class="login-box">

<h4>Você já está logado</h4>

<p class="mb-3">
Bem-vindo,<br>
<strong><?php echo $_SESSION['login_usuario']; ?></strong>
</p>

<!-- BOTÃO SÓ PRA ADMIN -->
<?php if($_SESSION['nivel_usuario'] == 'admin'){ ?>

<a href="admin/index.php" class="btn btn-dark w-100 mb-2">
Ir para o Admin
</a>

<?php } ?>

<a href="logout.php" class="btn btn-outline-danger w-100">
Sair da conta
</a>

</div>

</body>
</html>

<?php
exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Login</title>

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

<h3 class="text-center mb-4">Login</h3>

<?php if(isset($_GET['erro'])){ ?>
    <div class="alert alert-danger text-center py-2" style="font-size:14px;">
        Login ou senha inválidos
    </div>
<?php } ?>

<form action="login_valida.php" method="POST">
    <div class="mb-3">
        <label>Login</label>
        <input type="text" name="login_usuario" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Senha</label>
        <input type="password" name="senha_usuario" class="form-control" required>
    </div>

    <button class="btn btn-dark w-100">Entrar</button>

    <!-- CADASTRO -->
    <div class="text-center mt-3">

        <small class="text-muted">
            Não tem login?
        </small><br>

        <a href="cadastro.php" class="fw-bold text-dark text-decoration-none">
            Cadastre-se agora
        </a>

    </div>

</form>

</div>

</body>
</html>