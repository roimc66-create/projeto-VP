<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modelo</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
    />

    <style>
        nav.navbar {
            position: fixed !important;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 9999;
            padding: 12px 20px !important;
            background-color: white !important;
            box-shadow: 0px 2px 10px rgba(0,0,0,0.1);
        }

        body {
            margin: 0;
            padding: 0;
        }

        main {
            padding-top: 75px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light" id="mainNav">
    <div class="container-fluid">
        
        <!-- LOGO DO SITE -->
        <a class="navbar-brand text-dark fw-bold" href="index.php">VP STREET</a>

        <!-- BOTÃO CELULAR-->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- MENU -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <li class="nav-item">
                    <a class="nav-link text-dark" href="index_tenis.php">Tenis</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-dark" href="promocoes.php">Promoções</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-dark" href="produtos.php">Produtos</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-dark" href="contato.php">Contato</a>
                </li>

            </ul>

            <!-- CAIXA DE PESQUISA -->
            <form class="d-flex" action="buscar.php" method="GET">
                <input class="form-control me-2" type="search" name="q" placeholder="Buscar...">
                <button class="btn btn-outline-dark" type="submit">Ok</button>
            </form>

        </div>
    </div>
</nav>

<img src="imagens/Banners/Banner de tênis de corrida promoção inovador preto e rosa.png"
     class="img-fluid w-100"
     alt="Banner Puma">





<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
