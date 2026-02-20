<?php
include("Connections/conn_produtos.php");

$tabela       = "vw_tbprodutos";
$campo_filtro = "id_produto";
$ordenar_por  = "resumo_produto ASC";

$id = isset($_GET['id_produto']) ? (int)$_GET['id_produto'] : 0;
if ($id <= 0) {
    die("ID do produto inválido ou não informado.");
}

$consulta = "
    SELECT *
    FROM {$tabela}
    WHERE {$campo_filtro} = {$id}
    ORDER BY {$ordenar_por}
    LIMIT 1
";
$lista = $conn_produtos->query($consulta);

if (!$lista) {
    die("Erro na consulta: " . $conn_produtos->error);
}

if ($lista->num_rows == 0) {
    die("Produto não encontrado.");
}

$row = $lista->fetch_assoc();

// ===================== TAMANHOS =====================
$sql_tamanhos = "
    SELECT ta.id_tamanho, ta.numero_tamanho, pt.estoque
    FROM tbproduto_tamanho pt
    JOIN tbtamanhos ta ON ta.id_tamanho = pt.id_tamanho
    WHERE pt.id_produto = {$id}
    ORDER BY ta.numero_tamanho
";

$lista_tamanhos = $conn_produtos->query($sql_tamanhos);
if(!$lista_tamanhos){
    die("Erro na consulta tamanhos: " . $conn_produtos->error);
}

// imagem
$fotoBanco = $row['imagem_produto'];
if ($fotoBanco && strpos($fotoBanco, "/") === false) {
    $srcImg = "imagens/exclusivo/" . $fotoBanco;
} else {
    $srcImg = $fotoBanco;
}
if (!$srcImg) $srcImg = "imagens/sem-foto.png";

$valorOriginal = (float)$row['valor_produto'];
$valorComAumento = $valorOriginal * 1.10;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Modelo</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="CSS/produto.css">
</head>

<body>
<?php include('menu.php') ?>

<section class="produto-wrap">
<div class="container-fluid px-4">
<div class="row g-4">

<!-- IMAGEM -->
<div class="col-lg-8">
<div class="produto-galeria">
<div class="produto-main">
<img id="imgPrincipal"
     src="<?php echo $srcImg; ?>"
     alt="<?php echo htmlspecialchars($row['nome_produto'] ?? 'Produto'); ?>">
</div>
</div>
</div>

<!-- BOX COMPRA -->
<div class="col-lg-4">
<aside class="produto-box">

<h1 class="produto-titulo"><?php echo $row['nome_produto']; ?></h1>

<div class="produto-preco">
<div class="preco-linha">
<div class="preco-atual">R$<?php echo $row['valor_produto']; ?></div>
<div class="preco-de">R$ <?php echo number_format($valorComAumento, 2, ',', '.'); ?></div>
</div>
<div class="preco-parcela">
Cartão: até 3x sem juros, a vista 5% e no pix 10%
</div>
</div>

<div class="sec-title">Tamanho</div>

<div class="tamanhos">
<?php if($lista_tamanhos->num_rows > 0){ ?>
<?php while($t = $lista_tamanhos->fetch_assoc()){
$num = (int)$t['numero_tamanho'];
$estoque = (int)$t['estoque'];
$disabled = ($estoque <= 0) ? 'disabled' : '';
?>
<button
class="tam btn"
type="button"
data-id-tamanho="<?php echo (int)$t['id_tamanho']; ?>"
<?php echo $disabled; ?>>
<?php echo $num; ?>
</button>
<?php } ?>
<?php } else { ?>
<small class="text-muted">Sem tamanhos cadastrados.</small>
<?php } ?>
</div>

<!-- BOTÕES -->
<div class="mt-4 d-grid gap-2">

<form id="formCompraAgora" action="checkout.php" method="POST" class="m-0">
<input type="hidden" name="id_produto" value="<?php echo $id; ?>">
<input type="hidden" name="id_tamanho" id="idTamanhoCompraAgora">
<button class="btn btn-danger w-100" type="submit">
COMPRAR AGORA
</button>
</form>

<form id="formCarrinho" action="carrinho_add.php" method="POST" class="m-0">
<input type="hidden" name="id_produto" value="<?php echo $id; ?>">
<input type="hidden" name="id_tamanho" id="idTamanhoCarrinho">
<button class="btn border w-100" type="submit">
ADICIONAR AO CARRINHO
</button>
</form>

<small id="msgTamanho" class="text-danger text-center" style="display:none;">
Selecione um tamanho para continuar.
</small>

</div>

<!-- DESCRIÇÃO -->
<div class="produto-desc">
<h3 class="desc-title">Características</h3>
<p class="desc-text">
<?php echo $row['resumo_produto'] ?? 'Descrição do produto.'; ?>
</p>
</div>

</aside>
</div>

</div>
</div>
</section>

<?php include('index_tenis.php') ?>
<?php include('rodapé.php') ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const wrap = document.querySelector('.tamanhos');
  const msg = document.getElementById('msgTamanho');

  const inputCompraAgora = document.getElementById('idTamanhoCompraAgora');
  const inputCarrinho = document.getElementById('idTamanhoCarrinho');

  const formCompraAgora = document.getElementById('formCompraAgora');
  const formCarrinho = document.getElementById('formCarrinho');

  if (!wrap) return;

  function tamanhoSelecionado() {
    return inputCompraAgora.value !== "";
  }

  wrap.addEventListener('click', (e) => {
    const btn = e.target.closest('.tam');
    if (!btn || btn.disabled) return;

    wrap.querySelectorAll('.tam').forEach(b => b.classList.remove('ativo'));
    btn.classList.add('ativo');

    const idTam = btn.dataset.idTamanho;

    inputCompraAgora.value = idTam;
    inputCarrinho.value = idTam;

    msg.style.display = 'none';
  });

  formCompraAgora.addEventListener('submit', (e) => {
    if (!tamanhoSelecionado()) {
      e.preventDefault();
      msg.style.display = 'block';
    }
  });

  formCarrinho.addEventListener('submit', (e) => {
    if (!tamanhoSelecionado()) {
      e.preventDefault();
      msg.style.display = 'block';
    }
  });
});
</script>

</body>
</html>

<?php
mysqli_free_result($lista);
if(isset($lista_tamanhos)) mysqli_free_result($lista_tamanhos);
?>