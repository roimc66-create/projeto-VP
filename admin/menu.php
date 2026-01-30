<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modelo</title>

   <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"/>

    <style>
        /* --- CORREÇÃO DEFINITIVA --- */

        /* Navbar padrão fixa no topo */
        nav.navbar {
            position: fixed !important;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 9999;
            transition: background-color 0.3s ease;
            padding: 12px 20px !important;
        }

        /* Transparente APENAS quando sobre a imagem */
        .navbar-transparent {
            background-color: transparent !important;
        }

        /* Navbar sólida para páginas normais */
        .navbar-solid {
            background-color: white !important;
            box-shadow: 0px 2px 10px rgba(0,0,0,0.1);
        }

        /* Garante que o conteúdo abaixo não seja invadido */
        body {
            padding-top: 75px !important;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light navbar-transparent" id="mainNav">
    <div class="container-fluid">
        
        <!-- LOGO / NOME DO SITE -->
        <a class="navbar-brand text-dark fw-bold" href="index.php">VP STREET</a>

        <!-- Botão mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>


        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <!-- LINKS PRINCIPAIS -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <li class="nav-item">
                    <a class="nav-link text-dark fw-bold" href=".php">Marcas</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-dark" href=".php">Promoções</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-dark" href=".php">Produtos</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-dark" href="contato.php">Contato</a>
                </li>

            </ul>

            <!-- BARRA DE PESQUISA -->
            <form class="d-flex" action="buscar.php" method="GET">
                <input class="form-control me-2" type="search" name="q" placeholder="Buscar...">
                <button class="btn btn-outline-dark" type="submit">Ok</button>
            </form>

        </div>
    </div>
</nav>

<script>
    // Torna a navbar sólida automaticamente quando não há imagem de fundo
    document.addEventListener("DOMContentLoaded", () => {
        const navbar = document.getElementById("mainNav");

        // SE a página NÃO tiver banner, ativa navbar sólida
        const hasBanner = document.querySelector(".banner-principal");

        if (!hasBanner) {
            navbar.classList.remove("navbar-transparent");
            navbar.classList.add("navbar-solid");
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
