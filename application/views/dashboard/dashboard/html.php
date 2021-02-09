<div class='col offset-md-2'>
    <h1 class="header" style='padding:10px;'>Dashboard <small class="text-muted"><?php echo $usuarioadm ? "Métricas dos clientes" : "Veja suas métricas"; ?></small></h1>
    
    <?php
        if(isset($_GET['collection_id'])){
            header("Location: ".base_url('index.php/dashboard'));
		    exit;
        }
        $respostas = array(
            "approved" => "Seus novos créditos já foram adicionados à sua conta. Aproveite!",
            "in_process" =>	"Estamos processando o pagamento. Não se preocupe, em menos de 2 dias úteis seus créditos estarão na sua conta.",
            "rejected" => array(
                "cc_rejected_bad_filled_card_number" =>	"Revise o número do cartão.",
                "cc_rejected_bad_filled_date" => "Revise a data de vencimento.",
                "cc_rejected_bad_filled_other" => "Revise os dados.",
                "cc_rejected_bad_filled_security_code" => "Revise o código de segurança do cartão.",
                "cc_rejected_blacklist" => "Não pudemos processar seu pagamento.",
                "cc_rejected_call_for_authorize" => "Você deve autorizar ao payment_method_id o pagamento do valor ao Mercado Pago.",
                "cc_rejected_card_disabled" => "Ligue para o payment_method_id para ativar seu cartão. O telefone está no verso do seu cartão.",
                "cc_rejected_card_error" => "Não conseguimos processar seu pagamento.",
                "cc_rejected_duplicated_payment" => "Você já efetuou um pagamento com esse valor. Caso precise pagar novamente, utilize outro cartão ou outra forma de pagamento.",
                "cc_rejected_high_risk" => "Seu pagamento foi recusado. Escolha outra forma de pagamento. Recomendamos meios de pagamento em dinheiro.",
                "cc_rejected_insufficient_amount" => "O payment_method_id possui saldo insuficiente.",
                "cc_rejected_invalid_installments" => "O payment_method_id não processa pagamentos em installments parcelas.",
                "cc_rejected_max_attempts" => "Você atingiu o limite de tentativas permitido. Escolha outro cartão ou outra forma de pagamento.",
                "cc_rejected_other_reason" => "payment_method_id não processa o pagamento."
            ),
            "NAO FINALIZADO" => "Você não finalizou sua última compra."
        );
        if(isset($alertas)){
            foreach($alertas as $alerta){
    ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong><?php echo $alerta->ultima_atualizacao ? $alerta->ultima_atualizacao : $alerta->data_compra ?></strong> <?php echo $alerta->situacao == "rejected" ? $respostas["rejected"][$alerta->detalhe] : $respostas[$alerta->situacao]; ?>
            <button type="button" onclick="window.location.href='<?=base_url('index.php/dashboard/updateLido/'.$alerta->id)?>'" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php
            }
        }
    ?>
    <hr>

    <?php
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Content-Type");

        $postQuant = $this->input->post('quantidade');
        if(!$usuarioadm){

            if ($postQuant) {

                // SDK de Mercado Pago
                require __DIR__ .  '/../../../../vendor/autoload.php';

                // Configura credenciais
                MercadoPago\SDK::setAccessToken('TEST-5999412981018379-020306-27863709b5a3277790c87de708a52342-150651446');
                //MercadoPago\SDK::setAccessToken('TOKEN_DE_PRODUCAO');
                // Cria um objeto de preferência
                $preference = new MercadoPago\Preference();

                // Cria um item na preferência
                $item = new MercadoPago\Item();
                $item->id = "0001";
                $item->currency_id = "BRL";
                $item->title = 'Pressla - Cartaz Digital';
                $item->picture_url = base_url("assets/images/logo_icon.png");
                $item->description = "Créditos para geração de cartazes no sistema da Pressla";
                $item->category_id = "digital";
                $item->quantity = $postQuant;
                $item->unit_price = 1.00;

                $payer = new MercadoPago\Payer();
                $payer->email = $this->session->userdata('logado')['login'];
                //$payer->email = "michelrodrigonunesarruda@gmail.com";

                $preference->items = array($item);
                $preference->payer = $payer;
                $preference->external_reference = date("YmdHis")."pressla".$this->session->userdata('logado')['id'];
                $preference->back_urls = array(
                    "success" => base_url("index.php/dashboard"),
                    "failure" => base_url("index.php/dashboard"),
                    "pending" => base_url("index.php/dashboard")
                );
                $preference->save();

                $data = array(
                    'ref' => $preference->external_reference,
                    'id_cliente' => $this->session->userdata('logado')['id'],
                    'quantidade' => $postQuant,
                    'valor_a_pagar' => $postQuant*$item->unit_price,
                    'situacao' => 'NAO FINALIZADO',
                    'data_compra' => date("Y-m-d H:i:s")
                );
                $this->transacao_model->addTransacao($data);
            }
        }

        if(!is_array($metricas)){
            $metricas = array($metricas);
        }
        foreach($metricas as $metrica){
    ?>
    <div class='card mb-2'>
        <div class='row'>
            <div class='col text-center'>
                <?php if($usuarioadm){
                    echo "<a href='".base_url('index.php/clientes/gerenciar/'.$metrica->id)."'>";
                } ?>
                <h1 style='padding:10px;'><small class="text-muted"><?php echo $metrica->nome;?></small></h1>
                <?php if($usuarioadm){
                    echo "</a>";
                } ?>
            </div>
        </div>
        <div class='row'>
            <div class='col text-center'>
                Créditos Disponíveis
                <br>
                <h1><?php echo $metrica->impressoes;?></h1>
            </div>
            <div class='col mb-4 text-center'>
                Créditos Usados
                <br>
                <h1><?php echo $metrica->usadas;?></h1>
            </div>
            <?php
            if(!$usuarioadm){
            ?>
            <div class='col-sm mb-2 text-center'>
                <input type="button" value="Obter Mais Créditos" class="btn btn-primary" data-toggle="modal" data-target="#modalCreditosCenter">
                <br>
                <?php if($postQuant){ ?>
                    <div style="display:none"> 
                        <script
                            src="https://www.mercadopago.com.br/integrations/v1/web-payment-checkout.js"
                            data-preference-id="<?php echo $preference->id; ?>">
                        </script>
                    </div>
                
                    <script>
                        $(document).ready(function() {
                            $('.mercadopago-button').click();
                        });
                    </script>
                <?php } ?>
            </div>
            <?php
            }
            ?>
        </div>
    </div>
    <?php
        }
    ?>
</div>
<!-- Modal -->
<div class="modal fade" id="modalCreditosCenter" tabindex="-1" role="dialog" aria-labelledby="modalCreditosCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalCreditosLongTitle">Selecione a quantidade e a forma</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container">
            <form action="" method='post' id="form-quantidade">
                <div class="row">
                    <div class="col text-right text-secondary" style="cursor:pointer" onclick="$('#quantidade').val() > 1 ? $('#quantidade').val(parseInt($('#quantidade').val()) - 1) : false"> <h1>-</h1> </div>
                    <div class="col-3 col-md-2 text-center"><input type="text" name="quantidade" id="quantidade" class="form-control text-center bg-white" value="1" readonly></div>
                    <div class="col text-left text-secondary" style="cursor:pointer" onclick="$('#quantidade').val(parseInt($('#quantidade').val()) + 1)"> <h1>+</h1> </div>
                </div>
            </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="$('#form-quantidade').submit()">Via Mercado Pago</button>
        <button type="button" class="btn btn-success" onclick="window.open('https:\/\/api.whatsapp.com/send?phone=55<?=$whatsapp?>&text=Ol%C3%A1%2C%20gostaria%20de%20incluir%20'+ $('#quantidade').val() +'%20cr%C3%A9ditos%20%C3%A0%20minha%20conta%20do%20sistema%20de%20cartazes%20da%20Pressla!')">Via Whatsapp</button>
      </div>
    </div>
  </div>
</div>