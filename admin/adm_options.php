<?php include("protecao.php"); ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Administrativo</title>

    <!-- Bootstrap todo -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- Link dos ícones no bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
        rel="stylesheet">
</head>

<body>

<?php include("menu.php"); ?>

<div class="container mt-5">

    <h2 class="mb-4 text-center">Área Administrativa</h2>

    <div class="row g-4 justify-content-center">

        <!-- USUÁRIOS -->
        <div class="col-sm-12 col-md-6">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <i class="bi bi-people-fill fs-1 text-secondary"></i>
                    <h5 class="card-title mt-2">USUÁRIOS</h5>

                    <div class="d-grid gap-2 mt-3">
                        <a href="usuario_lista.php" class="btn btn-secondary">Listar</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- TIPOS -->
        <div class="col-sm-12 col-md-6">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <i class="bi bi-tags-fill fs-1 text-secondary"></i>
                    <h5 class="card-title mt-2">TIPOS</h5>

                    <div class="d-grid gap-2 mt-3">
                        <a href="tipos_lista.php" class="btn btn-secondary">Listar</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- PRODUTOS -->
        <div class="col-sm-12 col-md-6">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <i class="bi bi-box-seam-fill fs-1 text-secondary"></i>
                    <h5 class="card-title mt-2">PRODUTOS</h5>

                    <div class="d-grid gap-2 mt-3">
                        <a href="produtos_lista.php" class="btn btn-secondary">Listar</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- MARCAS -->
        <div class="col-sm-12 col-md-6">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <i class="bi bi-award-fill fs-1 text-secondary"></i>
                    <h5 class="card-title mt-2">MARCAS</h5>

                    <div class="d-grid gap-2 mt-3">
                        <a href="marcas_lista.php" class="btn btn-secondary">Listar</a>

                    </div>
                </div>
            </div>
        </div>

        <!-- TAMANHOS -->
        <div class="col-sm-12 col-md-6">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <i class="bi bi-rulers fs-1 text-secondary"></i>
                    <h5 class="card-title mt-2">TAMANHOS</h5>

                    <div class="d-grid gap-2 mt-3">
                        <a href="tamanhos_lista.php" class="btn btn-secondary">Listar</a>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
