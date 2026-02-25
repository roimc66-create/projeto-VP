<?php

include("session.php");

if (!isset($_SESSION['login_usuario'])) {
    header("Location: login.php");
    exit;
}

include("Connections/conn_produtos.php");

$carrinho = $_SESSION['carrinho'] ?? [];
$keys = array_keys($carrinho);

$itens = [];
$total = 0;

if (count($keys) > 0) {

    $produtosIds = [];
    $tamanhosIds = [];

    foreach ($carrinho as $item) {
        $produtosIds[]  = (int)$item['id_produto'];
        $tamanhosIds[]  = (int)$item['id_tamanho'];
    }

    $produtosIds  = array_values(array_unique($produtosIds));
    $tamanhosIds  = array_values(array_unique($tamanhosIds));

    $produtosIn  = implode(",", $produtosIds);
    $tamanhosIn  = implode(",", $tamanhosIds);

    $sql = "
        SELECT 
            p.id_produto,
            p.nome_produto,
            p.valor_produto,
            p.imagem_produto,
            ta.id_tamanho,
            ta.numero_tamanho
        FROM tbprodutos p
        JOIN tbproduto_tamanho pt ON pt.id_produto = p.id_produto
        JOIN tbtamanhos ta ON ta.id_tamanho = pt.id_tamanho
        WHERE p.id_produto IN ($produtosIn)
          AND ta.id_tamanho IN ($tamanhosIn)
    ";

    $res = $conn_produtos->query($sql);
    if (!$res) {
        die("Erro carrinho: " . $conn_produtos->error);
    }

    $map = [];
    while ($r = $res->fetch_assoc()) {
        $k = $r['id_produto'] . "-" . $r['id_tamanho'];
        $map[$k] = $r;
    }

    foreach ($carrinho as $k => $item) {

        if (!isset($map[$k])) continue;

        $p = $map[$k];
        $qtd = (int)$item['qtd'];
        $preco = (float)$p['valor_produto'];
        $subtotal = $preco * $qtd;
        $total += $subtotal;

        $foto = $p['imagem_produto'];

        if ($foto && strpos($foto, "/") === false) {
            $img = "imagens/exclusivo/" . $foto;
        } else {
            $img = $foto;
        }

        if (!$img) $img = "imagens/sem-foto.png";

        $itens[] = [
            "chave"      => $k,
            "id_produto" => (int)$p['id_produto'],
            "nome"       => $p['nome_produto'],
            "preco"      => $preco,
            "qtd"        => $qtd,
            "subtotal"   => $subtotal,
            "img"        => $img,

            /* 🔥 AQUI A CORREÇÃO */
            "tamanho"    => $p['numero_tamanho'] // ← SEM (int)
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Carrinho</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<?php include("menu.php") ?>

<div class="container py-5">

<div class="mb-3">
<a href="#"
onclick="
if (document.referrer && !document.referrer.includes('checkout.php')) {
history.back();
} else {
window.location.href='index.php';
}
return false;
"
class="btn btn-outline-dark">
Voltar
</a>
</div>

<h1 class="mb-4">Seu carrinho</h1>

<?php if (count($itens) == 0) { ?>

<div class="alert alert-warning">
Seu carrinho está vazio.
</div>

<a href="index.php" class="btn btn-dark">
Voltar para a loja
</a>

<?php } else { ?>

<div class="row g-4">

<div class="col-lg-8">

<?php foreach ($itens as $item) { ?>

<div class="card mb-3">
<div class="card-body d-flex gap-3 align-items-center">

<img src="<?php echo $item['img']; ?>"
style="width:90px;height:90px;object-fit:cover;border-radius:8px;">

<div class="flex-grow-1">

<div class="fw-bold">
<?php echo htmlspecialchars($item['nome']); ?>
</div>

<div class="text-muted">
Tamanho: <?php echo htmlspecialchars($item['tamanho']); ?>
</div>

<div class="mt-1">
R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?>
</div>

</div>

<div class="text-center">

<div class="d-flex align-items-center gap-2 justify-content-center">

<a class="btn btn-outline-secondary btn-sm"
href="carrinho_qtd.php?acao=menos&chave=<?php echo urlencode($item['chave']); ?>">
-
</a>

<span class="fw-bold"><?php echo $item['qtd']; ?></span>

<a class="btn btn-outline-secondary btn-sm"
href="carrinho_qtd.php?acao=mais&chave=<?php echo urlencode($item['chave']); ?>">
+
</a>

</div>

<a class="btn btn-link text-danger p-0 mt-2"
href="carrinho_remover.php?chave=<?php echo urlencode($item['chave']); ?>">
Remover
</a>

</div>

<div class="text-end" style="min-width:140px;">
<div class="text-muted">Subtotal</div>
<div class="fw-bold">
R$ <?php echo number_format($item['subtotal'], 2, ',', '.'); ?>
</div>
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
<span>Total</span>
<strong>
R$ <?php echo number_format($total, 2, ',', '.'); ?>
</strong>
</div>

<div class="d-grid gap-2 mt-4">
<a href="checkout.php" class="btn btn-danger">
Finalizar compra
</a>

<a href="index.php" class="btn btn-outline-dark">
Continuar comprando
</a>
</div>

</div>
</div>

</div>

</div>

<?php } ?>

</div>
</body>
</html>