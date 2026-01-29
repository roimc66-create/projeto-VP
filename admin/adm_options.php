<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Administrativo</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-4">

    <h2 class="mb-4">Área Administrativa</h2>

    <div class="row g-3">

        <!-- ===== BLOCO PADRÃO (COPIE E COLE) ===== -->
        <div class="col-sm-6 col-md-4">
            <div class="card h-100">
                <div class="card-body text-center">

                    <h5 class="card-title">PRODUTOS</h5>

                    <div class="d-grid gap-2 mt-3">
                        <a href="produtos_lista.php" class="btn btn-outline-primary">
                            Listar
                        </a>

                        <a href="produtos_insere.php" class="btn btn-primary">
                            Inserir
                        </a>
                    </div>

                </div>
            </div>
        </div>
        <!-- ===== FIM DO BLOCO ===== -->

        <!-- EXEMPLO DE OUTRO MÓDULO -->
        <div class="col-sm-6 col-md-4">
            <div class="card h-100">
                <div class="card-body text-center">

                    <h5 class="card-title">USUÁRIOS</h5>

                    <div class="d-grid gap-2 mt-3">
                        <a href="usuarios_lista.php" class="btn btn-outline-secondary">
                            Listar
                        </a>

                        <a href="usuarios_insere.php" class="btn btn-secondary">
                            Inserir
                        </a>
                    </div>

                </div>
            </div>
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
