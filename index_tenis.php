<?php
include("Connections/conn_produtos.php");
include("helpfun.php");

$id_atual = isset($_GET['id_produto']) ? (int)$_GET['id_produto'] : 0;

/* ===============================
   BUSCAR 6 PRODUTOS ALEATÓRIOS
   (exceto o atual)
================================= */

$consulta = "
    SELECT DISTINCT
        id_produto,
        nome_produto,
        valor_produto,
        imagem_produto,
        nome_marca
    FROM vw_tbprodutos
    WHERE id_produto <> $id_atual
    ORDER BY RAND()
    LIMIT 6
";

$lista = $conn_produtos->query($consulta);

if(!$lista){
    die('Erro na consulta: ' . $conn_produtos->error);
}

$totalRows  = $lista->num_rows;
?>
<link rel="stylesheet" href="CSS/exclusivo.css">
<link rel="stylesheet" href="CSS/produtos_detalhe.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<div class="divider-full"></div>

<div class="container my-4">

  <div class="d-flex align-items-center justify-content-between my-4">
    <button id="btnPrev" class="nav-arrow" type="button" aria-label="Anterior">
      <i class="bi bi-chevron-left"></i>
    </button>

    <h1 class="text-center m-0 flex-grow-1">Você também pode gostar</h1>

    <button id="btnNext" class="nav-arrow" type="button" aria-label="Próximo">
      <i class="bi bi-chevron-right"></i>
    </button>
  </div>

<div class="carousel-wrap">
  <div class="carousel-viewport" id="carouselViewport">
    <div class="row flex-nowrap m-0" id="vitrineProdutos">

      <?php if($totalRows > 0){ ?>
        <?php while($row = $lista->fetch_assoc()){ ?>

          <div class="col-12 col-sm-6 col-lg-3 product-item">
            <a href="produto_detalhe.php?id_produto=<?php echo $row['id_produto']; ?>"
               class="text-decoration-none text-dark">

              <div class="product-card card h-100">

                <img
                  src="imagens/exclusivo/<?php echo e($row['imagem_produto']); ?>"
                  class="product-img img-fluid"
                  alt="<?php echo e($row['nome_produto']); ?>">

                <div class="product-meta card-body">
                  <div class="product-brand">
                    <?php echo e($row['nome_marca']); ?>
                  </div>

                  <p class="product-name">
                    <?php echo e($row['nome_produto']); ?>
                  </p>

                  <p class="product-price">
                    <?php echo dinheiro($row['valor_produto']); ?>
                  </p>

                  <span class="btn btn-dark w-100">Comprar</span>
                </div>

              </div>
            </a>
          </div>

        <?php } ?>
      <?php } else { ?>
        <div class="col-12">
          <div class="alert alert-warning text-center">
            Nenhum produto encontrado.
          </div>
        </div>
      <?php } ?>

    </div>
  </div>
</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", () => {
  const viewport = document.getElementById("carouselViewport");
  const row = document.getElementById("vitrineProdutos");
  const items = Array.from(row.querySelectorAll(".product-item"));

  const btnPrev = document.getElementById("btnPrev");
  const btnNext = document.getElementById("btnNext");

  function gapPx(){
    const styles = window.getComputedStyle(row);
    const gap = parseFloat(styles.gap || "0");
    return isNaN(gap) ? 0 : gap;
  }

  function step(){
    if(!items.length) return 0;
    return items[0].getBoundingClientRect().width + gapPx();
  }

  function updateButtons(){
    const maxScroll = viewport.scrollWidth - viewport.clientWidth;
    btnPrev.disabled = viewport.scrollLeft <= 1;
    btnNext.disabled = viewport.scrollLeft >= (maxScroll - 1);
  }

  btnNext.addEventListener("click", () => {
    viewport.scrollBy({ left: step(), behavior: "smooth" });
  });

  btnPrev.addEventListener("click", () => {
    viewport.scrollBy({ left: -step(), behavior: "smooth" });
  });

  viewport.addEventListener("scroll", updateButtons);
  window.addEventListener("resize", updateButtons);

  updateButtons();
});
</script>




