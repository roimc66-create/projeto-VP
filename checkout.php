<?php
ob_start();
session_start();
include("Connections/conn_produtos.php");

$id_produto_post = (int)($_POST['id_produto'] ?? 0);
$id_tamanho_post_raw = $_POST['id_tamanho'] ?? '';

if ($id_produto_post > 0 && $id_tamanho_post_raw !== '' && $id_tamanho_post_raw !== null) {

  // se vier número (id_tamanho), usa direto; se vier texto (G/GG/M/38), converte pelo numero_tamanho
  if (is_numeric($id_tamanho_post_raw)) {
    $id_tamanho_post = (int)$id_tamanho_post_raw;
  } else {
    $tamTxt = trim($id_tamanho_post_raw);
    $tamEsc = $conn_produtos->real_escape_string($tamTxt);

    $sqlTam = "
      SELECT id_tamanho
      FROM tbtamanhos
      WHERE numero_tamanho = '{$tamEsc}'
      LIMIT 1
    ";
    $resTam = $conn_produtos->query($sqlTam);
    if (!$resTam) die("Erro ao buscar tamanho: " . $conn_produtos->error);

    $rowTam = $resTam->fetch_assoc();
    if (!$rowTam) die("Tamanho inválido.");

    $id_tamanho_post = (int)$rowTam['id_tamanho'];
  }

  if ($id_tamanho_post > 0) {

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

    $_SESSION['carrinho'] = [];
    $key = $id_produto_post . "-" . $id_tamanho_post;
    $_SESSION['carrinho'][$key] = [
      'id_produto' => $id_produto_post,
      'id_tamanho' => $id_tamanho_post,
      'qtd' => 1
    ];
  }
}

$carrinho = $_SESSION['carrinho'] ?? [];
if (count($carrinho) == 0) {
  echo "<script>window.open('carrinho.php','_self')</script>";
  exit;
}

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

$map = [];
while ($r = $res->fetch_assoc()) {
  $k = $r['id_produto'] . "-" . $r['id_tamanho'];
  $map[$k] = $r;
}

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
    'tam'  => $p['numero_tamanho'], // <- SEM (int) pra não virar 0 em G/GG/M
    'qtd'  => $qtd,
    'preco'=> $preco,
    'subtotal' => $subtotal,
    'estoque' => $estoqueAtual,
    'img' => $img,
    'id_produto' => (int)$p['id_produto'],
    'id_tamanho' => (int)$p['id_tamanho'],
  ];
}

$maxParcelas = 12;
$semJurosAte = 3;
$jurosAoMes  = 0.02;

$descontoAvista = 0.05;
$descontoPix    = 0.10;

$pagamento = isset($_POST['pagamento']) ? strtolower(trim($_POST['pagamento'])) : 'cartao';
if (!in_array($pagamento, ['cartao', 'avista', 'pix'])) $pagamento = 'cartao';

$parcelasSelecionadas = isset($_POST['parcelas']) ? (int)$_POST['parcelas'] : 1;
if ($parcelasSelecionadas < 1) $parcelasSelecionadas = 1;
if ($parcelasSelecionadas > $maxParcelas) $parcelasSelecionadas = $maxParcelas;

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
  if ($parcelasSelecionadas <= $semJurosAte) {
    $fator = 1;
  } else {
    $meses = ($parcelasSelecionadas - 1);
    $fator = 1 + ($jurosAoMes * $meses);
  }
  $totalFinal = $total * $fator;
  $valorParcela = $totalFinal / $parcelasSelecionadas;
}

$fretePadrao = 40.00;
$freteGratisAcima = 1500.00;

$frete = ($totalFinal >= $freteGratisAcima) ? 0.00 : $fretePadrao;

$totalComFrete = $totalFinal + $frete;

$valorParcelaComFrete = ($parcelasSelecionadas > 0) ? ($totalComFrete / $parcelasSelecionadas) : $totalComFrete;
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
  <div class="mb-3">
    <a href="carrinho.php" class="btn btn-outline-dark d-inline-flex align-items-center">
      <i class="bi bi-arrow-left"></i>
      Voltar para o carrinho
    </a>
  </div>

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
              <div class="text-muted">Tamanho: <?php echo htmlspecialchars($item['tam']); ?> • Qtd: <?php echo $item['qtd']; ?></div>
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

            <input type="hidden" name="parcelas" value="<?php echo (int)$parcelasSelecionadas; ?>">
          </form>

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

                  $freteTmp = ($tFinal >= $freteGratisAcima) ? 0.00 : $fretePadrao;
                  $tComFreteTmp = $tFinal + $freteTmp;

                  $vParc  = $tComFreteTmp / $i;
                ?>
                  <option value="<?php echo $i; ?>" <?php echo $sel; ?>>
                    <?php echo $i; ?>x de R$ <?php echo number_format($vParc, 2, ',', '.'); ?> (<?php echo $labelJuros; ?>)
                  </option>
                <?php } ?>
              </select>
              <small class="text-muted d-block mt-2">
                (parcelas exibidas já com frete)
              </small>
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

          <div class="d-flex justify-content-between mt-2">
            <span>Frete</span>
            <strong>
              <?php if ($frete <= 0) { ?>
                Grátis
              <?php } else { ?>
                R$ <?php echo number_format($frete, 2, ',', '.'); ?>
              <?php } ?>
            </strong>
          </div>

          <hr>

          <div class="d-flex justify-content-between">
            <span>Total com frete</span>
            <strong>R$ <?php echo number_format($totalComFrete, 2, ',', '.'); ?></strong>
          </div>

          <div class="text-muted small">
            <?php if ($pagamento === 'cartao') { ?>
              <?php echo (int)$parcelasSelecionadas; ?>x de R$ <?php echo number_format($valorParcelaComFrete, 2, ',', '.'); ?>
            <?php } else { ?>
              À vista: R$ <?php echo number_format($totalComFrete, 2, ',', '.'); ?>
            <?php } ?>
          </div>

          <form class="mt-4 d-grid gap-2" action="checkout_finalizar.php" method="POST">
            <input type="hidden" name="pagamento" value="<?php echo htmlspecialchars($pagamento); ?>">
            <input type="hidden" name="parcelas" value="<?php echo (int)$parcelasSelecionadas; ?>">

            <input type="hidden" name="total_base" value="<?php echo number_format($total, 2, '.', ''); ?>">
            <input type="hidden" name="total_final" value="<?php echo number_format($totalFinal, 2, '.', ''); ?>">
            <input type="hidden" name="frete" value="<?php echo number_format($frete, 2, '.', ''); ?>">
            <input type="hidden" name="total_com_frete" value="<?php echo number_format($totalComFrete, 2, '.', ''); ?>">

            <div class="mt-2">
              <h6 class="fw-bold mb-2">Dados do cliente</h6>

              <label class="form-label">Nome completo</label>
              <input type="text" name="nome_completo" class="form-control" required>

              <label class="form-label mt-3">CPF</label>
              <input type="text" name="cpf" class="form-control" required maxlength="14"
                     placeholder="000.000.000-00">

              <h6 class="fw-bold mt-4 mb-2">Endereço de entrega</h6>

              <div class="row g-2">
                <div class="col-12 col-md-4">
                  <label class="form-label">CEP</label>
                  <input type="text" name="cep" class="form-control" required maxlength="9" placeholder="00000-000">
                </div>
                <div class="col-12 col-md-8">
                  <label class="form-label">Rua</label>
                  <input type="text" name="rua" class="form-control" required>
                </div>
                <div class="col-6 col-md-3">
                  <label class="form-label">Número</label>
                  <input type="text" name="numero" class="form-control" required>
                </div>
                <div class="col-6 col-md-4">
                  <label class="form-label">Bairro</label>
                  <input type="text" name="bairro" class="form-control" required>
                </div>
                <div class="col-12 col-md-5">
                  <label class="form-label">Cidade</label>
                  <input type="text" name="cidade" class="form-control" required>
                </div>
                <div class="col-12 col-md-3">
                  <label class="form-label">UF</label>
                  <input type="text" name="uf" class="form-control" required maxlength="2" placeholder="SP">
                </div>
                <div class="col-12 col-md-9">
                  <label class="form-label">Complemento (opcional)</label>
                  <input type="text" name="complemento" class="form-control">
                </div>
              </div>
            </div>

            <button class="btn btn-success mt-3" type="submit" <?php echo (count($errosEstoque) > 0 ? 'disabled' : ''); ?>>
              Confirmar compra
            </button>

            <a href="carrinho.php" class="btn btn-outline-dark">Voltar ao carrinho</a>
          </form>

          <small class="text-muted d-block mt-3">
            Cartão: até <?php echo (int)$semJurosAte; ?>x sem juros, depois <?php echo (int)($jurosAoMes*100); ?>% ao mês.
            <br>
            Frete: R$ <?php echo number_format($fretePadrao, 2, ',', '.'); ?> (grátis acima de R$ <?php echo number_format($freteGratisAcima, 2, ',', '.'); ?>).
          </small>
        </div>
      </div>
    </div>
  </div>

</div>
</body>
</html>