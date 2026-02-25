<?php
include("Connections/conn_produtos.php");
include("helpfun.php");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Contato</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="CSS/pro_marca.css">
    <link rel="stylesheet" href="CSS/exclusivo.css">
</head>

<body>

<?php include("menu.php"); ?>

<div class="container my-5">
    <h1 class="text-center mb-4">Contato</h1>

    <div class="row g-4 justify-content-center">
      
        <div class="col-md-6">
            <div class="card p-4 h-100">
                <h5 class="mb-3">Fale Conosco</h5>

                <form id="formContato">
                    <div class="mb-3">
                        <label class="form-label">Nome</label>
                        <input type="text" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mensagem</label>
                        <textarea class="form-control" rows="4" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-dark w-100">
                        Enviar Mensagem
                    </button>
                </form>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card p-4 h-100">
                <h5 class="mb-3">Informações</h5>

                <p><strong>Email:</strong> vp_street@gmail.com</p>
                <p><strong>Atendimento:</strong> Seg a Sex</p>
                <p><strong>Horário:</strong> 09h às 18h</p>

                <hr>

                <p>
                    Se tiver qualquer dúvida sobre produtos, pedidos ou pagamentos,
                    entre em contato com a nossa equipe.
                </p>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalConfirmacao" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title text-success">Mensagem enviada!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">
                Sua mensagem foi enviada com sucesso.<br>
                Em breve nossa equipe entrará em contato.
            </div>

            <div class="modal-footer justify-content-center">
                <button class="btn btn-dark" data-bs-dismiss="modal">OK</button>
            </div>

        </div>
    </div>
</div>

<footer>
    <section class="py-5 bg-dark text-white">
        <div class="container text-center">
            <h3 class="fw-bold mb-4">NOSSOS BENEFÍCIOS</h3>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <h6 class="fw-bold">PAGUE PELO PIX</h6>
                    <p class="mb-0">Ganhe 10% OFF em</p>
                    <p>pagamentos via PIX</p>
                </div>

                <div class="col-md-4 mb-3">
                    <h6 class="fw-bold">FRETE GRÁTIS</h6>
                    <p class="mb-0">PARA PEDIDOS ACIMA</p>
                    <p>DE 1500,00R$</p>
                </div>

                <div class="col-md-4 mb-3">
                    <h6 class="fw-bold">CUPONS</h6>
                    <p class="mb-0">USE NOSSOS CUPONS PARA GARANTIR</p>
                    <p>DESCONTOS INCRÍVEIS</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-dark text-white">
        <div class="container text-center">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h6 class="fw-bold mb-3">Compra segura</h6>
                    <div class="d-flex flex-wrap justify-content-center gap-2">
                        <img src="imagens/rodapé/compra/escudo.webp">
                        <img src="imagens/rodapé/compra/escudo-2.webp">
                        <img src="imagens/rodapé/compra/selo.webp">
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <h6 class="fw-bold mb-3">Formas de Pagamento</h6>
                    <div class="d-flex flex-wrap justify-content-center gap-2">
                        <img src="imagens/rodapé/pagamento/elo.svg">
                        <img src="imagens/rodapé/pagamento/amex.svg">
                        <img src="imagens/rodapé/pagamento/pix.svg">
                        <img src="imagens/rodapé/pagamento/hyper.svg">
                        <img src="imagens/rodapé/pagamento/visa.svg">
                        <img src="imagens/rodapé/pagamento/master.svg">
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <h6>Fale com a gente (EMAIL)</h6>
                    vp_street@gmail.com
                </div>
            </div>
        </div>
    </section>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.getElementById("formContato").addEventListener("submit", function(e){
    e.preventDefault();
    new bootstrap.Modal(
        document.getElementById("modalConfirmacao")
    ).show();
    this.reset();
});
</script>

</body>
</html>
