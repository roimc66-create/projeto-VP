<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Administrativo</title>

   <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"/>
</head>

<body>

<?php include("menu.php"); ?>

<div class="container mt-5">

    <!-- TÍTULO-->
    <h2 class="mb-4 text-center">Área Administrativa</h2>

    <!-- CARDS -->
    <div class="row g-4 justify-content-center">

    <!-- USUÁRIOS -->
    <div class="col-sm-12 col-md-6">
        <div class="card h-100">
            <div class="card-body text-center">
                <h5 class="card-title">USUÁRIOS</h5>
                <div class="d-grid gap-2 mt-3">
                    <a href="usuario_lista.php" class="btn btn-outline-secondary">Listar</a>
                    <a href="usuario_insere.php" class="btn btn-secondary">Inserir</a>
                </div>
            </div>
        </div>
    </div>

    <!-- TIPOS -->
    <div class="col-sm-12 col-md-6">
        <div class="card h-100">
            <div class="card-body text-center">
                <h5 class="card-title">TIPOS</h5>
                <div class="d-grid gap-2 mt-3">
                    <a href="tipos_lista.php" class="btn btn-outline-secondary">Listar</a>
                    <a href="tipos_insere.php" class="btn btn-secondary">Inserir</a>
                </div>
            </div>
        </div>
    </div>

    <!-- PRODUTOS -->
    <div class="col-sm-12 col-md-6">
        <div class="card h-100">
            <div class="card-body text-center">
                <h5 class="card-title">PRODUTOS</h5>
                <div class="d-grid gap-2 mt-3">
                    <a href="tenis_lista.php" class="btn btn-outline-secondary">Listar</a>
                    <a href="tenis_insere.php" class="btn btn-secondary">Inserir</a>
                </div>
            </div>
        </div>
    </div>

    <!-- MARCAS -->
    <div class="col-sm-12 col-md-6">
        <div class="card h-100">
            <div class="card-body text-center">
                <h5 class="card-title">MARCAS</h5>
                <div class="d-grid gap-2 mt-3">
                    <a href="marcas_lista.php" class="btn btn-outline-secondary">Listar</a>
                    <a href="marcas_insere.php" class="btn btn-secondary">Inserir</a>
                </div>
            </div>
        </div>
    </div>

</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
