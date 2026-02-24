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
    <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        nav.navbar {
            position: fixed !important;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 9999;
            transition: background-color 0.3s ease;
            padding: 12px 20px !important;
        }

        .navbar-transparent {
            background-color: transparent !important;
        }

        .navbar-solid {
            background-color: white !important;
            box-shadow: 0px 2px 10px rgba(0,0,0,0.1);
        }

        body {
            padding-top: 75px !important;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light navbar-transparent" id="mainNav">
    <div class="container-fluid">
        
        <a class="navbar-brand text-dark fw-bold" href="../index.php">VP STREET</a>

        <!-- Botão da tela de mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <!-- Espaçoamento -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0"></ul>

            <!-- Ícone ADM -->
            <a class="nav-link text-dark fw-bold fs-2" href="../admin/adm_options.php"title="Painel Administrativo">
                <i class="bi bi-house-gear-fill"></i>
            </a>

        </div>
    </div>
</nav>

<script>
    // Navbar sólida
    document.addEventListener("DOMContentLoaded", () => {
        const navbar = document.getElementById("mainNav");

        // Quando a página não tem banner, isso ativa a navbar sólida e deixa certinho
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
