<?php
session_start();
include("Connections/conn_produtos.php");

/*
  CHECKOUT.PHP (aceita 2 fluxos)
  1) Carrinho normal: $_SESSION['carrinho']
  2) Comprar agora: POST id_produto + id_tamanho (cria carrinho temporário com qtd=1)
*/

// ===================== 1) TRATAR "COMPRAR AGORA" =====================
$id_produto_post = (int)($_POST['id_produto'] ?? 0);
$id_tamanho_post = (int)($_POST['id_tamanho'] ?? 0);

if ($id_produto_post > 0 && $id_tamanho_post > 0) {
  // valida se esse tamanho pertence ao produto e existe no estoque (>=1)
  $sqlValida = "
    SELECT pt.estoque
    FROM tbproduto_tamanho pt
    WHERE pt.id_produto = {$id_produto_post}
      AND pt.id_tamanho = {$id_tamanho_post}
    LIMIT 1
  ";
  $resValida = $conn_produtos->query($sqlValida);
  if (!$resValida) {
    die("Erro ao validar comprar agora: " . $conn_produtos->error);
  }
  if ($resValida->num_rows == 0) {
    die("Produto/tamanho inválido.");
  }
  $v = $resValida->fetch_assoc();
  if ((int)$v['estoque'] <= 0) {
    die("Sem estoque para esse tamanho.");
  }

  // cria/atualiza carrinho com apenas esse item (qtd 1)
  $_SESSION['carrinho'] = [];
  $key = $id_produto_post . "-" . $id_tamanho_post;
  $_SESSION['carrinho'][$key] = [
    'id_produto' => $id_produto_post,
    'id_tamanho' => $id_tamanho_post,
    'qtd' => 1
  ];
}

// ===================== 2) CARRINHO =====================
$carrinho = $_SESSION['carrinho'] ?? [];
if (count($carrinho) == 0) {
  header("Location: carrinho.php");
  exit;
}

// montar mapa de produtos/tamanhos pra buscar no banco
$produtosIds = [];
$tamanhosIds = [];
foreach ($carrinho as $item) {
  $produtosIds[] = (int)$item['id_produto'];
  $tamanhosIds[] = (int)$item['id_tamanho'];
}
$produtosIds = array_values(array_unique($produtosIds));
$tamanhosIds = array_values(array_unique($tamanhosIds));

$produtosIn = implode(",", $produtosIds);
$tamanhosIn = implode(",", $tamanhosIds);

// buscar dados e estoque atual
$sql = "
  SELECT
    p.id_produto,
    p.nome_produto,
    p.valor_produto,
    p.imagem_produto,
    ta.id_tamanho,
    ta.numero_tamanho,
    pt.estoque
  FROM tbprodutos p
  JOIN tbproduto_tamanho pt ON pt.id_produto = p.id_produto
  JOIN tbtamanhos ta ON ta.id_tamanho = pt.id_tamanho
  WHERE p.id_produto IN ($produtosIn)
    AND ta.id_tamanho IN ($tamanhosIn)
";

$res = $conn_produtos->query($sql);
if (!$res) die("Erro checkout: " . $conn_produtos->error);

// indexar por chave "produto-tamanho"
$map = [];
while ($r = $res->fetch_assoc()) {
  $k = $r['id_produto'] . "-" . $r['id_tamanho'];
  $map[$k] = $r;
}

// montar itens
$itens = [];
$total = 0;
$errosEstoque = [];

foreach ($carrinho as $k => $item) {
  if (!isset($map[$k])) continue;

  $p = $map[$k];
  $qtd = (int)$item['qtd'];
  if ($qtd < 1) $qtd = 1;

  $preco = (float)$p['valor_produto'];
  $subtotal = $preco * $qtd;
  $total += $subtotal;

  $estoqueAtual = (int)$p['estoque'];
  if ($qtd > $estoqueAtual) {
    $errosEstoque[] = $p['nome_produto'] . " (tam " . $p['numero_tamanho'] . ")";
  }

  // imagem
  $foto = $p['imagem_produto'];
  if ($foto && strpos($foto, "/") === false) {
    $img = "imagens/exclusivo/" . $foto;
  } else {
    $img = $foto;
  }
  if (!$img) $img = "imagens/sem-foto.png";

  $itens[] = [
    'chave' => $k,
    'nome' => $p['nome_produto'],
    'tam'  => (int)$p['numero_tamanho'],
    'qtd'  => $qtd,
    'preco'=> $preco,
    'subtotal' => $subtotal,
    'estoque' => $estoqueAtual,
    'img' => $img,
    'id_produto' => (int)$p['id_produto'],
    'id_tamanho' => (int)$p['id_tamanho'],
  ];
}

/* ===================== REGRAS: PAGAMENTO / DESCONTOS / PARCELAS ===================== */
$maxParcelas = 12;
$semJurosAte = 3;         // até 3x sem juros
$jurosAoMes  = 0.02;      // 2% ao mês a partir da 4ª parcela

$descontoAvista = 0.05;   // 5% OFF
$descontoPix    = 0.10;   // 10% OFF

// forma de pagamento selecionada
// opcoes: cartao | avista | pix
$pagamento = isset($_POST['pagamento']) ? strtolower(trim($_POST['pagamento'])) : 'cartao';
if (!in_array($pagamento, ['cartao', 'avista', 'pix'])) $pagamento = 'cartao';

// parcela selecionada
$parcelasSelecionadas = isset($_POST['parcelas']) ? (int)$_POST['parcelas'] : 1;
if ($parcelasSelecionadas < 1) $parcelasSelecionadas = 1;
if ($parcelasSelecionadas > $maxParcelas) $parcelasSelecionadas = $maxParcelas;

// calcula total final conforme pagamento
$totalFinal = $total;
$valorParcela = $total;

if ($pagamento === 'avista') {
  $totalFinal = $total * (1 - $descontoAvista);
  $parcelasSelecionadas = 1;
  $valorParcela = $totalFinal;

} elseif ($pagamento === 'pix') {
  $totalFinal = $total * (1 - $descontoPix);
  $parcelasSelecionadas = 1;
  $valorParcela = $totalFinal;

} else {
  // cartao parcelado
  if ($parcelasSelecionadas <= $semJurosAte) {
    $fator = 1;
  } else {
    $meses = ($parcelasSelecionadas - 1);
    $fator = 1 + ($jurosAoMes * $meses);
  }
  $totalFinal = $total * $fator;
  $valorParcela = $totalFinal / $parcelasSelecionadas;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include('menu.php'); ?>

<div class="container py-5">
  <h1 class="mb-4">Checkout</h1>

  <?php if (count($errosEstoque) > 0) { ?>
    <div class="alert alert-danger">
      <b>Sem estoque suficiente para:</b><br>
      <?php foreach ($errosEstoque as $e) { echo "• " . htmlspecialchars($e) . "<br>"; } ?>
      <div class="mt-2">
        <a href="carrinho.php" class="btn btn-dark btn-sm">Voltar ao carrinho</a>
      </div>
    </div>
  <?php } ?>

  <div class="row g-4">
    <div class="col-lg-8">
      <?php foreach ($itens as $item) { ?>
        <div class="card mb-3">
          <div class="card-body d-flex gap-3 align-items-center">
            <img src="<?php echo $item['img']; ?>" style="width:90px;height:90px;object-fit:cover;border-radius:8px;">
            <div class="flex-grow-1">
              <div class="fw-bold"><?php echo htmlspecialchars($item['nome']); ?></div>
              <div class="text-muted">Tamanho: <?php echo $item['tam']; ?> • Qtd: <?php echo $item['qtd']; ?></div>
              <div>R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?></div>
            </div>
            <div class="text-end" style="min-width:140px;">
              <div class="text-muted">Subtotal</div>
              <div class="fw-bold">R$ <?php echo number_format($item['subtotal'], 2, ',', '.'); ?></div>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>

    <div class="col-lg-4">
      <div class="card">
        <div class="card-body">
          <h5 class="mb-3">Resumo</h5>

          <div class="d-flex justify-content-between">
            <span>Total base</span>
            <strong>R$ <?php echo number_format($total, 2, ',', '.'); ?></strong>
          </div>

          <!-- ===================== FORMA DE PAGAMENTO ===================== -->
          <form class="mt-3" method="POST" action="checkout.php" id="formPagamento">
            <label class="form-label fw-bold">Forma de pagamento</label>

            <div class="d-grid gap-2">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="pagamento" id="pgCartao" value="cartao"
                       <?php echo ($pagamento === 'cartao') ? 'checked' : ''; ?>
                       onchange="this.form.submit()">
                <label class="form-check-label" for="pgCartao">
                  Cartão (parcelado)
                </label>
              </div>

              <div class="form-check">
                <input class="form-check-input" type="radio" name="pagamento" id="pgAvista" value="avista"
                       <?php echo ($pagamento === 'avista') ? 'checked' : ''; ?>
                       onchange="this.form.submit()">
                <label class="form-check-label" for="pgAvista">
                  À vista (5% OFF)
                </label>
              </div>

              <div class="form-check">
                <input class="form-check-input" type="radio" name="pagamento" id="pgPix" value="pix"
                       <?php echo ($pagamento === 'pix') ? 'checked' : ''; ?>
                       onchange="this.form.submit()">
                <label class="form-check-label" for="pgPix">
                  Pix (10% OFF)
                </label>
              </div>
            </div>

            <!-- manter parcelas no post ao trocar pagamento -->
            <input type="hidden" name="parcelas" value="<?php echo $parcelasSelecionadas; ?>">
          </form>

          <!-- ===================== PARCELAS (só aparece no cartão) ===================== -->
          <?php if ($pagamento === 'cartao') { ?>
            <form class="mt-3" method="POST" action="checkout.php">
              <input type="hidden" name="pagamento" value="cartao">
              <label class="form-label fw-bold">Parcelamento</label>
              <select name="parcelas" class="form-select" onchange="this.form.submit()"
                      <?php echo (count($errosEstoque) > 0 ? 'disabled' : ''); ?>>
                <?php for ($i=1; $i<=$maxParcelas; $i++) {
                  $sel = ($i == $parcelasSelecionadas) ? 'selected' : '';

                  if ($i <= $semJurosAte) {
                    $f = 1;
                    $labelJuros = "sem juros";
                  } else {
                    $m = ($i - 1);
                    $f = 1 + ($jurosAoMes * $m);
                    $labelJuros = "com juros";
                  }

                  $tFinal = $total * $f;
                  $vParc  = $tFinal / $i;
                ?>
                  <option value="<?php echo $i; ?>" <?php echo $sel; ?>>
                    <?php echo $i; ?>x de R$ <?php echo number_format($vParc, 2, ',', '.'); ?> (<?php echo $labelJuros; ?>)
                  </option>
                <?php } ?>
              </select>
            </form>
          <?php } else { ?>
            <div class="alert alert-success mt-3 mb-0">
              <?php if ($pagamento === 'avista') { ?>
                Pagamento à vista: <b>5% de desconto</b> aplicado.
              <?php } else { ?>
                Pagamento no Pix: <b>10% de desconto</b> aplicado.
              <?php } ?>
            </div>
          <?php } ?>

          <hr>

          <div class="d-flex justify-content-between">
            <span>Total final</span>
            <strong>R$ <?php echo number_format($totalFinal, 2, ',', '.'); ?></strong>
          </div>

          <div class="text-muted small">
            <?php if ($pagamento === 'cartao') { ?>
              <?php echo $parcelasSelecionadas; ?>x de R$ <?php echo number_format($valorParcela, 2, ',', '.'); ?>
            <?php } else { ?>
              À vista: R$ <?php echo number_format($totalFinal, 2, ',', '.'); ?>
            <?php } ?>
          </div>

          <!-- ===================== FINALIZAR ===================== -->
          <form class="mt-4 d-grid gap-2" action="checkout_finalizar.php" method="POST">
            <input type="hidden" name="pagamento" value="<?php echo htmlspecialchars($pagamento); ?>">
            <input type="hidden" name="parcelas" value="<?php echo (int)$parcelasSelecionadas; ?>">
            <input type="hidden" name="total_final" value="<?php echo number_format($totalFinal, 2, '.', ''); ?>">

            <button class="btn btn-success" type="submit" <?php echo (count($errosEstoque) > 0 ? 'disabled' : ''); ?>>
              Confirmar compra
            </button>
            <a href="carrinho.php" class="btn btn-outline-dark">Voltar ao carrinho</a>
          </form>

          <small class="text-muted d-block mt-3">
            Cartão: até <?php echo $semJurosAte; ?>x sem juros, depois <?php echo (int)($jurosAoMes*100); ?>% ao mês.
          </small>
        </div>
      </div>
    </div>
  </div>

</div>
</body>
</html>