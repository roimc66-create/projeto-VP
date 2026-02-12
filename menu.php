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
        /* Mega dropdown ocupa a largura toda */
.dropdown-mega { position: static; }

.mega-menu{
  width: 100%;
  left: 0;
  right: 0;
  top: 100%;
  border: 0;
  border-top: 1px solid #eee;
  border-radius: 0;
  margin-top: 0;
}

/* Títulos e links */
.mega-title{
  font-weight: 700;
  font-size: 12px;
  letter-spacing: .04em;
  text-transform: uppercase;
  margin-bottom: 10px;
}

.mega-link{
  display: block;
  padding: 6px 0;
  text-decoration: none;
  color: #333;
}

.mega-link:hover{ text-decoration: underline; }

.mega-all{
  font-weight: 600;
  text-decoration: none;
}

/* Grid de tamanhos */
.size-grid{
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 8px;
}

.size{
  display: grid;
  place-items: center;
  border: 1px solid #eee;
  height: 38px;
  text-decoration: none;
  color: #111;
  font-weight: 600;
  font-size: 13px;
}

.size:hover{ border-color: #111; }
#mainNav{
  position: relative;
}

.nav-center{
  position: absolute;
  left: 50%;
  top: 50%;
  transform: translate(-50%, -50%);
}

#mainNav{
  min-height: 60px;   /* ajusta como quiser */
  display: flex;
  align-items: center;
}
@media (min-width: 992px){
  #mainNav{ position: relative; }

  #mainNav .nav-center{
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    white-space: nowrap;
  }
}

/* MOBILE: corrige o “erro” e centraliza normal */
@media (max-width: 991.98px){
  #mainNav .nav-center{
    position: static !important;
    left: auto !important;
    top: auto !important;
    transform: none !important;

    display: block;
    width: 100%;
    text-align: center;
    margin: 0;
    padding: 10px 0;
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
          <a class="nav-link fw-semibold navbar-brand text-dark fw-bold nav-center"
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
                <div class="mega-title">Produtos</div>
                <a class="mega-link" href="#">Tenis</a>
                <a class="mega-link" href="#">Camisa</a>
                <a class="mega-link" href="#">Chinelo</a>               
                
              </div>

              <div class="col-12 col-lg-3">
                <div class="mega-title">Marcas</div>
                <a class="mega-link" href="#">Nike</a>
                <a class="mega-link" href="#">Jordan</a>
                <a class="mega-link" href="#">Adidas</a>
                <a class="mega-link" href="#">New Balance</a>
                <a class="mega-link" href="#">Vans</a>
                
              </div>

              <div class="col-12 col-lg-3">
                <div class="mega-title">Infantil</div>
                <a class="mega-link" href="#">Nike</a>
                <a class="mega-link" href="#">Adidas</a>
                <a class="mega-link" href="#">Vans</a>
                <a class="mega-link" href="#">Converse</a>
                
              </div>

              <div class="col-12 col-lg-3">
                <div class="mega-title">Tamanho do tênis</div>
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


</body>
</html>
