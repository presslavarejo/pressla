<?php
echo "Página Não Encontrada";
return;
?>
<div class="col-2" id="comptela"></div>
<div class='col' id="tela">
    <div class="row p-0 m-0">
        <div class="col-8">
        <h1 class="header" style='padding:10px;'>Integração <small class="text-muted">Integre ao Whatsapp</small></h1>
        </div>
        <?php
        if($this->login_model->checkAdmin(true)){
        ?>
        <div class="col-4 text-right pt-3">
            <a class="btn btn-primary text-white" href="<?= base_url("index.php/integracaoconf") ?>">CONFIGURAÇÕES</a>
        </div>
        <?php
        }
        ?>
    </div>
    
    <hr>

    <div class="card p-2">
        <?php
        if(strstr($qrcode, "<img")){
        ?>
        <div class="row align-items-center">
            <div class="col-6 text-center" id="container-qrcode">
                <?= $qrcode ?>
            </div>
            <div class="col-6 text-justify">
                <div class="row mt-3 justify-content-center">
                    <div class="col-md-4">
                        <img src="<?= base_url("assets/images/passo1.jpeg") ?>" alt="Passo 1" class="w-100">
                    </div>
                    <div class="col-md-4">
                        <img src="<?= base_url("assets/images/passo2.jpeg") ?>" alt="Passo 2" class="w-100">
                    </div>
                    <div class="col-md-4">
                        <img src="<?= base_url("assets/images/passo3.jpeg") ?>" alt="Passo 3" class="w-100">
                    </div>
                </div>
            </div>
        </div>
        <?php
        } else {
        ?>
        <div class="row align-items-center">
            <div class="col-12 text-center">
                Seu whatsapp já está sendo acessado. Volte para o módulo de criação e comece a enviar cartazes pelo Whatsapp
            </div>
        </div>
        <?php
        }
        ?>

        <div class="row justify-content-center mt-5">
            <div class="col-10 text-center">
                Cliente Pressla já tem sessão criada automaticamente e a sua se chama "<?= $sessao ?>". Siga as instruções para ler o QrCode e comece a enviar cartazes em massa via Whatsapp direto do módulo Gerar Cartaz. Se precisar de ajuda, entre em contato conosco.
            </div>
        </div>
    </div>
</div>

<script>
    function atualizaQrCode(){
        setTimeout(() => {
            $.get("<?= base_url("index.php/integracao/echoQrCode/").str_rot13($sessao) ?>", function(image){
                $("#container-qrcode").html(image);
                atualizaQrCode();
                console.log(image);
            });
        }, 5000);
    }

    window.addEventListener("load", function(){
        atualizaQrCode();
    });
</script>