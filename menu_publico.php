<?php
include("Connections/conn_produtos.php");
include("helpfun.php");

/* TIPOS (Produtos) */
$sql_tipos = "
  SELECT id_tipo, nome_tipo
  FROM tbtipos
  ORDER BY nome_tipo ASC;
";
$lista_tipos = $conn_produtos->query($sql_tipos)
  or die("Erro tipos: ".$conn_produtos->error);


/* MARCAS */
$sql_marcas = "
  SELECT DISTINCT id_marca_produto, nome_marca
  FROM vw_tbprodutos
  ORDER BY nome_marca ASC;
";
$lista_marcas = $conn_produtos->query($sql_marcas) or die("Erro marcas: ".$conn_produtos->error);

/* GENEROS */
$sql_generos = "
  SELECT DISTINCT id_genero_produto, nome_genero
  FROM vw_tbprodutos
  ORDER BY nome_genero ASC;
";
$lista_generos = $conn_produtos->query($sql_generos) or die("Erro generos: ".$conn_produtos->error);
?>
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
              <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
              <link href="https://fonts.googleapis.com/css2?family=Potta+One&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="CSS/menu.css">
    <link rel="stylesheet" href="CSS/font-potta.css">

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
        @media (max-width: 991px) {
    .navbar-brand {
        position: static !important;
        transform: none !important;
    }
    #mainNav .navbar-toggler { 
  position: relative;
  z-index: 2000;
}
#mainNav .navbar-brand {
  z-index: 1;
}
    }

    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom" id="mainNav">
  <div class="container-fluid">
    <div class="" id="navMain">
     
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">

        <!-- MEGA MENU: TÊNIS -->
        <li class="nav-item dropdown dropdown-mega">
          <a class="nav-link fw-semibold navbar-brand text-dark fw-bold nav-center title-font"
   href="index.php"
   id="megaTenis"
   role="button"
   aria-expanded="false"><h3> 
   VP STREET
   </h3>
</a>

          <div class="dropdown-menu mega-menu p-4" aria-labelledby="megaTenis">
            <div class="row g-4">

              <div class="col-12 col-lg-3">
  <div class="mega-title subtitle-font" ><a class="mega-link" href="index_produtos.php">Produtos</a></div>

<a href="#" class="mega-vermais" data-toggle="mega-more">Ver mais...</a>

<div class="mega-more" style="display:none;">
  <?php while($tipo = $lista_tipos->fetch_assoc()){ ?>
    <a class="mega-link"
       href="produtos_por_tipo.php?id_tipo=<?php echo $tipo['id_tipo']; ?>">
       <?php echo $tipo['nome_tipo']; ?>
    </a>
  <?php } ?>
</div>



</div>


                      <div class="col-12 col-lg-3">
  <div class="mega-title subtitle-font">Marcas</div>

<a href="#" class="mega-vermais" data-toggle="mega-more">Ver mais...</a>

<div class="mega-more" style="display:none;">
  <?php while($marca = $lista_marcas->fetch_assoc()){ ?>
    <a href="produtos_por_marca.php?id_marca=<?php echo $marca['id_marca_produto']; ?>"
           class="mega-link">
      <?php echo $marca['nome_marca']; ?>
    </a>
  <?php } ?>
</div>

</div>
                  <div class="col-12 col-lg-3">
  <div class="mega-title subtitle-font">Gênero</div>

<a href="#" class="mega-vermais" data-toggle="mega-more">Ver mais...</a>

<div class="mega-more" style="display:none;">
  <?php while($gen = $lista_generos->fetch_assoc()){ ?>
    <a class="mega-link" href="produtos_por_genero.php?id_genero=<?php echo $gen['id_genero_produto']; ?>">
      <?php echo $gen['nome_genero']; ?>
    </a>
  <?php } ?>
</div>

</div>

              <div class="col-12 col-lg-3">
                <div class="mega-title subtitle-font">Tamanho do tênis</div>
                <div class="size-grid">
                  <a href="#" class="size">34</a><a href="#" class="size">35</a><a href="#" class="size">36</a>
                  <a href="#" class="size">37</a><a href="#" class="size">38</a><a href="#" class="size">39</a>
                  <a href="#" class="size">40</a><a href="#" class="size">41</a><a href="#" class="size">42</a>
                  <a href="#" class="size">43</a><a href="#" class="size">44</a><a href="#" class="size">45</a>
                </div>
              </div>
 <form class="d-flex" action="buscar.php" method="GET">
        <input class="form-control me-2" type="search" name="q" placeholder="Buscar...">
        <button class="btn btn-outline-dark" type="submit">Ok</button>
      </form>
            </div>
          </div>
        </li>

        
      </ul>

      

    </div>
  </div>
</nav>


<img src="imagens/Banners/Banner de tênis de corrida promoção inovador preto e rosa.png"
     class="img-fluid w-100"
     alt="Banner Puma">



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
<script>
  (function () {
    const item = document.querySelector('.dropdown-mega');
    const toggle = document.getElementById('megaTenis');
    const menu = item.querySelector('.mega-menu');

    let closeTimer = null;

    function openMenu() {
      clearTimeout(closeTimer);
      item.classList.add('show');
      menu.classList.add('show');
      toggle.setAttribute('aria-expanded', 'true');
    }

    function closeMenu() {
      item.classList.remove('show');
      menu.classList.remove('show');
      toggle.setAttribute('aria-expanded', 'false');
    }

    function scheduleClose() {
      clearTimeout(closeTimer);
      closeTimer = setTimeout(() => {
        if (window.innerWidth >= 992) closeMenu();
      }, 150);
    }

    // ✅ Desktop: abre ao passar o mouse, fecha com delay (sem piscar)
    toggle.addEventListener('mouseenter', () => {
      if (window.innerWidth >= 992) openMenu();
    });
    menu.addEventListener('mouseenter', () => {
      if (window.innerWidth >= 992) openMenu();
    });

    toggle.addEventListener('mouseleave', () => {
      if (window.innerWidth >= 992) scheduleClose();
    });
    menu.addEventListener('mouseleave', () => {
      if (window.innerWidth >= 992) scheduleClose();
    });

    // ✅ Mobile: clique abre/fecha
    toggle.addEventListener('click', (e) => {
      if (window.innerWidth >= 992) return; // desktop é hover
      e.preventDefault();
      const isOpen = item.classList.contains('show');
      isOpen ? closeMenu() : openMenu();
    });

    // Fecha clicando fora (desktop e mobile)
    document.addEventListener('click', (e) => {
      if (!item.contains(e.target)) closeMenu();
    });

    // Fecha no ESC
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') closeMenu();
    });

    window.addEventListener('resize', closeMenu);
  })();
</script>
<script>

document.addEventListener('click', function(e){
  const btn = e.target.closest('[data-toggle="mega-more"]');
  if(!btn) return;

  e.preventDefault();

  const col = btn.closest('.col-12, [class*="col-"]'); // pega a coluna atual
  const lista = col.querySelector('.mega-more');      // pega só a lista dessa coluna

  lista.style.display = 'block';
  btn.style.display = 'none'; // some o "Ver mais..."
});
</script>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
