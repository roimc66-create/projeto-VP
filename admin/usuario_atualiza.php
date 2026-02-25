<?php
include("protecao.php");
include("../Connections/conn_produtos.php");

if (!isset($_GET['id_usuario'])) {
    header("Location: usuario_lista.php");
    exit;
}

$id_usuario = (int) $_GET['id_usuario'];

$stmtBusca = $conn_produtos->prepare(
    "SELECT * FROM tbusuarios WHERE id_usuario = ?"
);
$stmtBusca->bind_param("i", $id_usuario);
$stmtBusca->execute();
$resultado = $stmtBusca->get_result();

if (!$resultado || $resultado->num_rows === 0) {
    header("Location: usuario_lista.php?erro=notfound");
    exit;
}

$usuario = $resultado->fetch_assoc();
$erroMsg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $login     = trim($_POST['login_usuario']);
    $email     = trim($_POST['email_usuario']);
    $nivelNovo = $_POST['nivel_usuario'];
    $senha     = trim($_POST['senha_usuario']);

    if ($login === "" || $email === "") {
        $erroMsg = "Login e email são obrigatórios.";
    }

    if ($erroMsg === "" && $usuario['nivel_usuario'] === 'admin' && $nivelNovo !== 'admin') {

        $rAdmins = $conn_produtos->query(
            "SELECT COUNT(*) AS total_admin 
             FROM tbusuarios 
             WHERE nivel_usuario = 'admin'"
        );

        $totalAdmin = (int) $rAdmins->fetch_assoc()['total_admin'];

        if ($totalAdmin <= 1) {
            $erroMsg = "Você não pode alterar o ÚLTIMO admin para user.";
        }
    }

    if ($erroMsg === "") {

        $stmtDup = $conn_produtos->prepare(
            "SELECT id_usuario 
             FROM tbusuarios 
             WHERE (login_usuario = ? OR email_usuario = ?)
             AND id_usuario != ?"
        );

        $stmtDup->bind_param("ssi", $login, $email, $id_usuario);
        $stmtDup->execute();
        $stmtDup->store_result();

        if ($stmtDup->num_rows > 0) {
            $erroMsg = "Login ou email já está sendo usado por outro usuário.";
        }

        $stmtDup->close();
    }

    if ($erroMsg === "") {

        if ($senha !== "") {

            $stmtUpdate = $conn_produtos->prepare(
                "UPDATE tbusuarios 
                 SET login_usuario = ?, 
                     email_usuario = ?, 
                     senha_usuario = ?, 
                     nivel_usuario = ?
                 WHERE id_usuario = ?"
            );

            $stmtUpdate->bind_param(
                "ssssi",
                $login,
                $email,
                $senha,
                $nivelNovo,
                $id_usuario
            );

        } else {

            $stmtUpdate = $conn_produtos->prepare(
                "UPDATE tbusuarios 
                 SET login_usuario = ?, 
                     email_usuario = ?, 
                     nivel_usuario = ?
                 WHERE id_usuario = ?"
            );

            $stmtUpdate->bind_param(
                "sssi",
                $login,
                $email,
                $nivelNovo,
                $id_usuario
            );
        }

        $stmtUpdate->execute();
        $stmtUpdate->close();

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
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

<?php include("../menu.php"); ?>

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

                <form method="post">

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Login:</label>
                        <input type="text"
                               name="login_usuario"
                               class="form-control"
                               maxlength="30"
                               required
                               value="<?= htmlspecialchars($usuario['login_usuario']); ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email:</label>
                        <input type="email"
                               name="email_usuario"
                               class="form-control"
                               maxlength="150"
                               required
                               value="<?= htmlspecialchars($usuario['email_usuario']); ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nova senha (opcional):</label>
                        <input type="password"
                               name="senha_usuario"
                               class="form-control"
                               maxlength="60"
                               placeholder="Deixe em branco para não alterar">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nível do usuário:</label>

                        <div class="form-check">
                            <input class="form-check-input"
                                   type="radio"
                                   name="nivel_usuario"
                                   value="user"
                                   <?= $usuario['nivel_usuario'] == 'user' ? 'checked' : '' ?>>
                            <label class="form-check-label">User</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input"
                                   type="radio"
                                   name="nivel_usuario"
                                   value="admin"
                                   <?= $usuario['nivel_usuario'] == 'admin' ? 'checked' : '' ?>>
                            <label class="form-check-label">Admin</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-warning w-100 fw-semibold">
                        Salvar
                    </button>

                </form>

            </div>

        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>