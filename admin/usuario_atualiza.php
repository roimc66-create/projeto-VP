<?php
include("../Connections/conn_produtos.php");

if (!isset($_GET['id_usuario'])) {
    header("Location: usuario_lista.php");
    exit;
}

$id_usuario = (int) $_GET['id_usuario'];

$r = $conn_produtos->query(
    "SELECT * FROM tbusuarios WHERE id_usuario = $id_usuario"
);

if ($r->num_rows == 0) {
    header("Location: usuario_lista.php");
    exit;
}

$usuario = $r->fetch_assoc();

if ($_POST) {

    $login = $_POST['login_usuario'];
    $nivel = $_POST['nivel_usuario'];

    // se senha foi preenchida, atualiza
    if (!empty($_POST['senha_usuario'])) {

        $senha = $_POST['senha_usuario'];

        $conn_produtos->query(
            "UPDATE tbusuarios 
             SET login_usuario = '$login',
                 senha_usuario = '$senha',
                 nivel_usuario = '$nivel'
             WHERE id_usuario = $id_usuario"
        );

    } else {

        $conn_produtos->query(
            "UPDATE tbusuarios 
             SET login_usuario = '$login',
                 nivel_usuario = '$nivel'
             WHERE id_usuario = $id_usuario"
        );
    }

    header("Location: usuario_lista.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuário</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<?php include("menu.php"); ?>

<div class="container mt-5">
    <div class="card p-4 shadow" style="max-width:420px;margin:auto">

        <div class="d-flex align-items-center mb-3">
            <a href="usuario_lista.php" class="btn btn-warning me-3">←</a>
            <h4 class="mb-0 text-warning fw-bold">Editar Usuário</h4>
        </div>

        <form method="post">

            <label class="fw-semibold">Login</label>
            <input
                type="text"
                name="login_usuario"
                value="<?= $usuario['login_usuario']; ?>"
                class="form-control mb-3"
                required
            >

            <label class="fw-semibold">Nova Senha (opcional)</label>
            <input
                type="password"
                name="senha_usuario"
                class="form-control mb-3"
                placeholder="Deixe em branco para não alterar"
            >

            <label class="fw-semibold">Nível</label>
            <select name="nivel_usuario" class="form-select mb-4">
                <option value="admin" <?= $usuario['nivel_usuario']=='admin'?'selected':'' ?>>
                    Admin
                </option>
                <option value="usuario" <?= $usuario['nivel_usuario']=='usuario'?'selected':'' ?>>
                    Usuário
                </option>
            </select>

            <button class="btn btn-warning w-100 fw-semibold">
                💾 Salvar
            </button>

        </form>

    </div>
</div>

</body>
</html>
