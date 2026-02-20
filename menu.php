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
$lista_marcas = $conn_produtos->query($sql_marcas)
  or die("Erro marcas: ".$conn_produtos->error);

/* GENEROS */
$sql_generos = "
  SELECT DISTINCT id_genero_produto, nome_genero
  FROM vw_tbprodutos
  ORDER BY nome_genero ASC;
";
$lista_generos = $conn_produtos->query($sql_generos)
  or die("Erro generos: ".$conn_produtos->error);

/* TAMANHOS (menu) */
$sql_tamanhos_menu = "
  SELECT DISTINCT ta.numero_tamanho
  FROM tbproduto_tamanho pt
  JOIN tbtamanhos ta ON ta.id_tamanho = pt.id_tamanho
  WHERE pt.estoque > 0
  ORDER BY ta.numero_tamanho ASC;
";
$lista_tamanhos_menu = $conn_produtos->query($sql_tamanhos_menu)
  or die("Erro tamanhos menu: ".$conn_produtos->error);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Modelo</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Potta+One&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="CSS/menu.css">
  <link rel="stylesheet" href="CSS/font-potta.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom" id="mainNav">
  <div class="container-fluid">
    <div id="navMain">

      <ul class="navbar-nav me-auto mb-2 mb-lg-0">

        <!-- MEGA MENU: TÊNIS -->
        <li class="nav-item dropdown dropdown-mega">
          <a class="nav-link fw-semibold navbar-brand text-dark fw-bold nav-center title-font"
             href="index.php"
             id="megaTenis"
             role="button"
             aria-expanded="false">
            <h3>VP STREET</h3>
          </a>

          <div class="dropdown-menu mega-menu p-4" aria-labelledby="megaTenis">
            <div class="row g-4">

              <!-- PRODUTOS (TIPOS) -->
              <div class="col-12 col-lg-3">
                <div class="mega-title"><a class="mega-link" href="index_produtos.php">Produtos</a></div>

                <a href="#" class="mega-vermais" data-toggle="mega-more">Ver mais...</a>

                <div class="mega-more" style="display:none;">
                  <?php while($tipo = $lista_tipos->fetch_assoc()){ ?>
                    <a class="mega-link" href="produtos_por_tipo.php?id_tipo=<?php echo $tipo['id_tipo']; ?>">
                      <?php echo $tipo['nome_tipo']; ?>
                    </a>
                  <?php } ?>
                </div>
              </div>

              <!-- MARCAS -->
              <div class="col-12 col-lg-3">
                <div class="mega-title">Marcas</div>

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

              <!-- GÊNERO -->
              <div class="col-12 col-lg-3">
                <div class="mega-title">Gênero</div>

                <a href="#" class="mega-vermais" data-toggle="mega-more">Ver mais...</a>

                <div class="mega-more" style="display:none;">
                  <?php while($gen = $lista_generos->fetch_assoc()){ ?>
                    <a class="mega-link"
                       href="produtos_por_genero.php?id_genero=<?php echo $gen['id_genero_produto']; ?>">
                      <?php echo $gen['nome_genero']; ?>
                    </a>
                  <?php } ?>
                </div>
              </div>

              <!-- TAMANHOS -->
              <div class="col-12 col-lg-3">
                <div class="mega-title">Tamanho do tênis</div>

                <div class="size-grid">
                  <?php while($tam = $lista_tamanhos_menu->fetch_assoc()){ ?>
                    <a href="produtos_por_tamanho.php?tamanho=<?php echo $tam['numero_tamanho']; ?>"
                       class="size">
                      <?php echo $tam['numero_tamanho']; ?>
                    </a>
                  <?php } ?>
                </div>
              </div>

              <!-- BUSCA -->
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

<script>
  // Torna a navbar sólida automaticamente quando não há imagem de fundo
  document.addEventListener("DOMContentLoaded", () => {
    const navbar = document.getElementById("mainNav");
    const hasBanner = document.querySelector(".banner-principal");

    if (!hasBanner) {
      navbar.classList.remove("navbar-transparent");
      navbar.classList.add("navbar-solid");
    }
  });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

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

    // Desktop: hover
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

    // Mobile: click
    toggle.addEventListener('click', (e) => {
      if (window.innerWidth >= 992) return;
      e.preventDefault();
      const isOpen = item.classList.contains('show');
      isOpen ? closeMenu() : openMenu();
    });

    document.addEventListener('click', (e) => {
      if (!item.contains(e.target)) closeMenu();
    });

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

    const col = btn.closest('.col-12, [class*="col-"]');
    const lista = col.querySelector('.mega-more');

    lista.style.display = 'block';
    btn.style.display = 'none';
  });
</script>

</body>
</html>