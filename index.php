<?php require_once('session.php'); ?>
<!doctype html>
<html lang="pt-br">
<head>
    <title>VP Street</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet">
</head>

<body>

    <?php include('menu_publico.php'); ?>

    <div class="my-4">
        <?php include('marcas.php'); ?>
    </div>

    <div class="my-4">
        <?php include('promocoes.php'); ?>
    </div>

    <div class="my-4">
        <?php include('exclusivo.php'); ?>
    </div>

    <?php include('rodapé.php'); ?>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js">
    </script>

</body>
</html>
