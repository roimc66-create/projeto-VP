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

$totalRows = $lista->num_rows;
if ($totalRows == 0) {
    die("Produto não encontrado.");
}

$row = $lista->fetch_assoc();
// ===================== TAMANHOS DO PRODUTO =====================
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


//  montar caminho da imagem 
$fotoBanco = $row['imagem_produto']; 

// se no banco vier só o nome do arquivo
if ($fotoBanco && strpos($fotoBanco, "/") === false) {
    $srcImg = "imagens/exclusivo/" . $fotoBanco;
} else {
    $srcImg = $fotoBanco; 
}


if (!$srcImg) {
    $srcImg = "imagens/sem-foto.png";
}

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
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"/>
            <link rel="stylesheet" href="CSS/produto.css">


</head>
<body>
    <?php include('menu.php')  ?>
    <a name="">&nbsp; </a>
<section class="produto-wrap">
  <div class="container-fluid px-4">
    <div class="row g-4">

      <div class="col-lg-8">
        <div class="produto-galeria">
          <!-- imagem principal -->
          <div class="produto-main">
            <img
  id="imgPrincipal"
  src="<?php echo $srcImg; ?>"
  alt="<?php echo htmlspecialchars($row['nome_produto'] ?? 'Produto'); ?>"
/>
          </div>         
        </div>
      </div>

      <!-- DIREITA: BOX DE COMPRA -->
      <div class="col-lg-4">
        <aside class="produto-box">

          <h1 class="produto-titulo"><?php echo $row['nome_produto']; ?></h1>
          <div class="produto-preco">
            <div class="preco-linha">
               <div class="preco-atual"><?php echo $row['valor_produto']; ?> <!--<small>no pix à vista</small>  --></div>
              <div class="preco-de"><?php echo $row['valor_produto']; ?></div>
              <!-- <span class="badge-desconto">5%Off</span> -->
            </div>
            <div class="preco-parcela">ou R$ 999,99 10x de R$ 99,99 sem juros</div>
          </div>

          <div class="produto-info">
            <div class="info-item">
              <span class="info-dot">✓</span>
              <div>
                Use o cupom de primeira compra no site:<br>
                <b>PRIMEIRACOMPRA</b>
              </div>
            </div>
            
          </div>

          <div class="mt-4">
            <div class="sec-title"></div>
            <div class="opcoes">
              <div class="opcao-card">
                 <img
  id="imgPrincipal"
  src="<?php echo $srcImg; ?>"
  alt="<?php echo htmlspecialchars($row['nome_produto'] ?? 'Produto'); ?>"
/>
              </div>
              
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
        class="tam"
        type="button"
        data-tamanho="<?php echo $num; ?>"
        data-id-tamanho="<?php echo (int)$t['id_tamanho']; ?>"
        <?php echo $disabled; ?>
        title="<?php echo ($estoque <= 0) ? 'Esgotado' : 'Disponível'; ?>"
      >
        <?php echo $num; ?>
      </button>
    <?php } ?>

  <?php } else { ?>
    <small class="text-muted">Sem tamanhos cadastrados para este produto.</small>
  <?php } ?>
</div>
<input type="hidden" id="tamanhoSelecionado" name="tamanhoSelecionado" value="">
<input type="hidden" id="idTamanhoSelecionado" name="idTamanhoSelecionado" value="">


          <div class="mt-4 d-grid gap-2">            
            <form action="carrinho_add.php" method="POST">

  <input type="hidden" name="id_produto" value="<?php echo $id; ?>">
  <input type="hidden" name="id_tamanho" id="idTamanhoSelecionadoForm">

  <div class="mt-4 d-grid gap-2">
    <button class="btn btn-comprar btn-danger" type="button">
      COMPRAR AGORA
    </button>

    <button class="btn btn-carrinho border" type="submit">
      ADICIONAR AO CARRINHO
    </button>
  </div>

</form>

          </div>
          
          <!-- DESCRIÇÃO DO PRODUTO (embaixo dos botões) -->
<div class="produto-desc">
  <h3 class="desc-title">Características</h3>
  <p class="desc-text">
    <?php echo $row['resumo_produto'] ?? 'Escreva aqui as características do produto.'; ?>
  </p>

  

  <div class="desc-selo">
    <div class="selo-icon">
      <img src="imagens/tenis/<?php echo $row['imagem_marca']; ?>"
                                 class="img-fluid"
                                 alt="<?php echo $row['nome_marca']; ?>
                                 ">
    </div>

    <div class="selo-text">
      <strong>Produto original <?php echo $row['nome_marca']; ?></strong><br>
      <span>Vendido por VP STREET</span>
    </div>
  </div>
</div>


          <!-- <div class="mt-4">
            <div class="cep-top">
              <div class="sec-title mb-0">Insira seu CEP</div>
              <a class="cep-link" href="#">NÃO SEI MEU CEP</a>
            </div>

            <div class="cep-row">
              <input class="cep-input" placeholder="00000-000" />
              <button class="cep-btn" type="button">CALCULAR</button>
            </div>
          </div> -->


        </aside>
      </div>

    </div>
  </div>
</section>

<?php include('index_tenis.php')  ?>
<?php include('rodapé.php')  ?>
<script           src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
           crossorigin="anonymous"
        ></script>

</body>

<script>
  document.querySelectorAll('.tamanhos .tam').forEach(btn => {
    btn.addEventListener('click', () => {
      if (btn.disabled) return;

      document.querySelectorAll('.tamanhos .tam')
        .forEach(b => b.classList.remove('ativo'));

      btn.classList.add('ativo');

      document.getElementById('tamanhoSelecionado').value =
        btn.dataset.tamanho;

      document.getElementById('idTamanhoSelecionado').value =
        btn.dataset.idTamanho;

      // envia pro form
      document.getElementById('idTamanhoSelecionadoForm').value =
        btn.dataset.idTamanho;
    });
  });
</script>


</html>
<?php mysqli_free_result($lista);
if(isset($lista_tamanhos)) mysqli_free_result($lista_tamanhos);
 ?>