<?php
include("protecao.php");
include("../Connections/conn_produtos.php");

if (!isset($_GET['id_usuario'])) {
    header("Location: usuario_lista.php");
    exit;
}

$id_usuario = (int) $_GET['id_usuario'];

// busca usuário
$r = $conn_produtos->query(
    "SELECT * FROM tbusuarios WHERE id_usuario = $id_usuario"
);

if (!$r || $r->num_rows == 0) {
    header("Location: usuario_lista.php?erro=notfound");
    exit;
}

$usuario = $r->fetch_assoc();

$erroMsg = "";

if ($_POST) {

    $login = $_POST['login_usuario'];
    $nivelNovo = $_POST['nivel_usuario'];

    // Nao deixar remover o último admin 
    if ($usuario['nivel_usuario'] === 'admin' && $nivelNovo !== 'admin') {

        $rAdmins = $conn_produtos->query(
            "SELECT COUNT(*) AS total_admin FROM tbusuarios WHERE nivel_usuario = 'admin'"
        );
        $totalAdmin = (int) $rAdmins->fetch_assoc()['total_admin'];

        // se esse usuário é admin e só existe 1 admin, não pode trocar ele para user
        if ($totalAdmin <= 1) {
            $erroMsg = "Você não pode alterar o nível do ÚLTIMO admin para user.";
        }
    }

    if ($erroMsg === "") {

        $loginEsc = $conn_produtos->real_escape_string($login);
        $nivelEsc = $conn_produtos->real_escape_string($nivelNovo);

        if (!empty($_POST['senha_usuario'])) {
            $senha = $_POST['senha_usuario'];
            $senhaEsc = $conn_produtos->real_escape_string($senha);

            $conn_produtos->query(
                "UPDATE tbusuarios 
                 SET login_usuario = '$loginEsc',
                     senha_usuario = '$senhaEsc',
                     nivel_usuario = '$nivelEsc'
                 WHERE id_usuario = $id_usuario"
            );
        } else {
            $conn_produtos->query(
                "UPDATE tbusuarios 
                 SET login_usuario = '$loginEsc',
                     nivel_usuario = '$nivelEsc'
                 WHERE id_usuario = $id_usuario"
            );
        }

        header("Location: usuario_lista.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuário</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
    />

    <style>
        body { background: #ffffff; min-height: 100vh; }
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
                    <h4 class="mb-0 text-warning fw-bold">Editar Usuário</h4>
                </div>

                <?php if (!empty($erroMsg)): ?>
                    <div class="alert alert-danger py-2">
                        <?= htmlspecialchars($erroMsg) ?>
                    </div>
                <?php endif; ?>

                <div class="alert alert-warning">
                    <form method="post">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Login:</label>
                            <input
                                type="text"
                                name="login_usuario"
                                class="form-control"
                                maxlength="30"
                                required
                                value="<?= htmlspecialchars($usuario['login_usuario']); ?>"
                            >
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nova senha (opcional):</label>
                            <input
                                type="password"
                                name="senha_usuario"
                                class="form-control"
                                maxlength="8"
                                placeholder="Deixe em branco para não alterar"
                            >
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nível do usuário:</label>

                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="radio"
                                    name="nivel_usuario"
                                    value="user"
                                    <?= $usuario['nivel_usuario']=='user'?'checked':'' ?>
                                >
                                <label class="form-check-label">User</label>
                            </div>

                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="radio"
                                    name="nivel_usuario"
                                    value="admin"
                                    <?= $usuario['nivel_usuario']=='admin'?'checked':'' ?>
                                >
                                <label class="form-check-label">Admin</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-warning w-100 fw-semibold">
                            💾 Salvar
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