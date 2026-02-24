<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Compra finalizada</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

  <?php include('menu.php'); ?>

  <div class="container py-5">
    <div class="alert alert-success">
      <h4 class="mb-2">Compra finalizada ✅</h4>
      <p class="mb-0">Seu pedido foi processado, obrigado por comprar conosco.</p>
    </div>

    <a href="index.php" class="btn btn-dark">Voltar para a loja</a>
  </div>
  <?php include('index_tenis.php'); ?>
</body>

</html>