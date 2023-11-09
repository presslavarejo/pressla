<style>
    .card-plano {
        border-radius: 8px;
        background-color: #FFF;
        padding: 10px;
        border: 1px solid #cecece;
        box-shadow: 0px 0px 5px #cecece;
        width: 100%;
    }
</style>
<div class="col-sm-2" id="comptela"></div>
<div class='col-sm' id="tela">
    <!-- <h1 class="header" style='padding:10px;'>Dashboard <small class="text-muted"><?php echo $usuarioadm ? "Métricas dos clientes" : "Veja suas métricas"; ?></small></h1> -->
    
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
    <!-- <hr> -->
    <br>
    <?php
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Content-Type");

        $postQuant = $this->input->post('quantidade');
        if(!$usuarioadm){

            if ($postQuant) {

                // SDK de Mercado Pago
                require __DIR__ .  '/../../../../vendor/autoload.php';

                // Configura credenciais
                //MercadoPago\SDK::setAccessToken('TEST-5999412981018379-020306-27863709b5a3277790c87de708a52342-150651446');
                MercadoPago\SDK::setAccessToken('APP_USR-1016177777202866-021116-2746f1b35693a5b0e02114878bd5c601-713127743');
                // Cria um objeto de preferência
                $preference = new MercadoPago\Preference();

                // Cria um item na preferência
                $item = new MercadoPago\Item();
                $item2 = new MercadoPago\Item();
                $item->id = "0001";
                $item->currency_id = "BRL";
                $item->title = 'Pressla - Cartaz Digital';
                $item->picture_url = base_url("assets/images/logo_icon.png");
                $item->description = "Créditos para geração de cartazes no sistema da Pressla";
                $item->category_id = "digital";
                $item->quantity = $this->input->post('parte1') ? $this->input->post('parte1') : $postQuant;
                $item->unit_price = $this->input->post('corretor_preco') ? ($this->input->post('corretor_preco') * 2.00) : 2.00;

                if($this->input->post('personalizado')){
                    $item2->id = "0002";
                    $item2->currency_id = "BRL";
                    $item2->title = 'Pressla - Cartaz Digital';
                    $item2->picture_url = base_url("assets/images/logo_icon.png");
                    $item2->description = "Créditos PROMOCIONAIS para geração de cartazes no sistema da Pressla";
                    $item2->category_id = "digital";
                    $item2->quantity = $this->input->post('parte2') ? $this->input->post('parte2') : $postQuant;
                    $item2->unit_price = $this->input->post('personalizado');
                }

                $payer = new MercadoPago\Payer();
                $payer->email = $this->session->userdata('logado')['login'];

                if($this->input->post('personalizado')){
                    $preference->items = array($item, $item2);
                } else {
                    $preference->items = array($item);
                }

                // echo var_dump($preference->items);
                // return;
                $preference->statement_descriptor = $this->input->post('pacote') ? $this->input->post('pacote') : "CREDITOSPRESSLA";
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
                    'valor_a_pagar' => $this->input->post('parte2') ? (($item->quantity*$item->unit_price) + ($item2->quantity*$item2->unit_price)) : ($item->quantity*$item->unit_price),
                    'situacao' => 'NAO FINALIZADO',
                    'data_compra' => date("Y-m-d H:i:s")
                );
                $this->transacao_model->addTransacao($data);
            }
        }
    ?>
    <div class="row justify-content-center mb-3">
        <div class="col-md-3 mb-2">
            <div class="card">
                <div class="row px-3 py-2">
                    <div class="col text-secondary">Cartazes Gerados Hoje</div>
                </div>
                <div class="row px-3 py-0">
                    <div class="col text-dark">
                        <h1 class="text-center" style="font-size:90pt"><?= $historico_dia ? $historico_dia->quantidade : 0 ?></h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="card">
                <div class="row px-3 py-2">
                    <div class="col text-secondary">Cartazes Gerados no Mês</div>
                </div>
                <div class="row px-3 py-0">
                    <div class="col text-dark">
                        <h1 class="text-center" style="font-size:90pt"><?= $historico_mes ? $historico_mes->quantidade : 0 ?></h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row pr-4">
        <div class='col'>
            <h5 class="text-muted pl-3 pt-3">Layouts Verticais</h5>
        </div>
        <?php
            if(!$usuarioadm){
        ?>
        <div class='col mb-2 text-right'>
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
    <hr>
    <!-- ACESSO RÁPIDO AOS LAYOUTS -->
    <!--  -->
    <div class="row justify-content-center">
        <div class="col-auto p-0 m-4 text-center" onclick="window.location.href='<?=base_url('index.php/dashboard/criar/1')?>'">
            <img src="<?=base_url("assets/images/acessorapido/semimagem.jpeg")?>" width="175px" style="box-shadow: 5px 5px 5px #999;margin-bottom:10px;cursor:pointer;">
            <br>
            <span class="ttacesso"><strong>Sem Imagem</strong></span>
        </div>
        <div class="col-auto p-0 m-4 text-center" onclick="window.location.href='<?=base_url('index.php/dashboard/criar/13')?>'">
            <img src="<?=base_url("assets/images/acessorapido/semimagem2.jpg")?>" width="175px" style="box-shadow: 5px 5px 5px #999;margin-bottom:10px;cursor:pointer;">
            <br>
            <span class="ttacesso"><strong>Sem Imagem 2</strong></span>
        </div>
        <div class="col-auto p-0 m-4 text-center" onclick="window.location.href='<?=base_url('index.php/dashboard/criar/2')?>'">
            <img src="<?=base_url("assets/images/acessorapido/comimagem.jpeg")?>" width="175px" style="box-shadow: 5px 5px 5px #999;margin-bottom:10px;cursor:pointer;">
            <br>
            <span class="ttacesso"><strong>Com Imagem</strong></span>
        </div>
        <div class="col-auto p-0 m-4 text-center" onclick="window.location.href='<?=base_url('index.php/dashboard/criar/3')?>'">
            <img src="<?=base_url("assets/images/acessorapido/cartaodaloja.jpeg")?>" width="175px" style="box-shadow: 5px 5px 5px #999;margin-bottom:10px;cursor:pointer;">
            <br>
            <span class="ttacesso"><strong>Cartão da Loja</strong></span>
        </div>
        <div class="col-auto p-0 m-4 text-center" onclick="window.location.href='<?=base_url('index.php/dashboard/criar/15')?>'">
            <img src="<?=base_url("assets/images/acessorapido/fidelidadesemimagem.jpg")?>" width="175px" style="box-shadow: 5px 5px 5px #999;margin-bottom:10px;cursor:pointer;">
            <br>
            <span class="ttacesso"><strong>2 Preços - Sem Imagem</strong></span>
        </div>
        <div class="col-auto p-0 m-4 text-center" onclick="window.location.href='<?=base_url('index.php/dashboard/criar/7')?>'">
            <img src="<?=base_url("assets/images/acessorapido/BANNER BOLSAO VERTICAL A2.jpeg")?>" width="175px" style="box-shadow: 5px 5px 5px #999;margin-bottom:10px;cursor:pointer;">
            <br>
            <span class="ttacesso"><strong>Bolsão Vertical A2</strong></span>
        </div>
        <div class="col-auto p-0 m-4 text-center" onclick="window.location.href='<?=base_url('index.php/dashboard/criar/8')?>'">
            <img src="<?=base_url("assets/images/acessorapido/vertatacvarejo.jpeg")?>" width="175px" style="box-shadow: 5px 5px 5px #999;margin-bottom:10px;cursor:pointer;">
            <br>
            <span class="ttacesso"><strong>2 preços - Com imagem</strong></span>
        </div>
        <div class="col-auto p-0 m-4 text-center" onclick="window.location.href='<?=base_url('index.php/dashboard/criar/9')?>'">
            <img src="<?=base_url("assets/images/acessorapido/varejovertical.jpeg")?>" width="175px" style="box-shadow: 5px 5px 5px #999;margin-bottom:10px;cursor:pointer;">
            <br>
            <span class="ttacesso"><strong>Com Imagem 2</strong></span>
        </div>
        <div class="col-auto p-0 m-4 text-center" onclick="window.location.href='<?=base_url('index.php/dashboard/criar/12')?>'">
            <img src="<?=base_url("assets/images/acessorapido/atacadoevarejovert.jpeg")?>" width="175px" style="box-shadow: 5px 5px 5px #999;margin-bottom:10px;cursor:pointer;">
            <br>
            <span class="ttacesso"><strong>2 Preços - Sem Imagem 2</strong></span>
        </div>
    </div>
    <div class="row pr-4 mt-3">
        <div class='col'>
            <h5 class="text-muted pl-3 pt-3">Layouts Horizontais</h5>
        </div>
    </div>
    <hr>
    <div class="row justify-content-center">
        <div class="col-auto p-0 m-4 text-center" onclick="window.location.href='<?=base_url('index.php/dashboard/criar/5')?>'">
            <img src="<?=base_url("assets/images/acessorapido/horzatacvarejo.jpeg")?>" width="315px" style="box-shadow: 5px 5px 5px #999;margin-bottom:10px;cursor:pointer;">
            <br>
            <span class="ttacesso"><strong>Horizontal Atacado e Varejo</strong></span>
        </div>
        <div class="col-auto p-0 m-4 text-center" onclick="window.location.href='<?=base_url('index.php/dashboard/criar/10')?>'">
            <img src="<?=base_url("assets/images/acessorapido/atacvarejosemimg.jpeg")?>" width="315px" style="box-shadow: 5px 5px 5px #999;margin-bottom:10px;cursor:pointer;">
            <br>
            <span class="ttacesso"><strong>Horizontal Atacado e Varejo - Sem Imagem</strong></span>
        </div>
        <div class="col-auto p-0 m-4 text-center" onclick="window.location.href='<?=base_url('index.php/dashboard/criar/11')?>'">
            <img src="<?=base_url("assets/images/acessorapido/varejohorz.jpeg")?>" width="315px" style="box-shadow: 5px 5px 5px #999;margin-bottom:10px;cursor:pointer;">
            <br>
            <span class="ttacesso"><strong>Horizontal Varejo - Sem Imagem</strong></span>
        </div>    
        <div class="col-auto p-0 m-4 text-center" onclick="window.location.href='<?=base_url('index.php/dashboard/criar/14')?>'">
            <img src="<?=base_url("assets/images/acessorapido/bolsaoa1.jpg")?>" width="315px" style="box-shadow: 5px 5px 5px #999;margin-bottom:10px;cursor:pointer;">
            <br>
            <span class="ttacesso"><strong>Horizontal Bolsão A1 - Com Imagem</strong></span>
        </div>    
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modalCreditosCenter" tabindex="-1" role="dialog" aria-labelledby="modalCreditosCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document" style="min-width: 600px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalCreditosLongTitle">Selecione a quantidade</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container">
            <!-- <form action="" method='post' id="form-quantidade">
                <div class="row">
                    <div class="col text-right text-secondary" style="cursor:pointer" onclick="$('#quantidade').val() > 1 ? $('#quantidade').val(parseInt($('#quantidade').val()) - 1) : false"> <h1>-</h1> </div>
                    <div class="col-3 col-md-2 text-center"><input type="text" name="quantidade" id="quantidade" class="form-control text-center bg-white" value="1" readonly></div>
                    <div class="col text-left text-secondary" style="cursor:pointer" onclick="$('#quantidade').val(parseInt($('#quantidade').val()) + 1)"> <h1>+</h1> </div>
                </div>
            </form> -->
            <div class="row">
                <div class="col-4">
                    <div class="card-plano text-center">
                        <span class="text-muted">PACOTE 200</span>
                        <h1 class="text-center mt-3 mb-3">R$ 149,00</h1>
                        <hr>
                        Você economiza R$ 251,00
                        <hr>
                        <form action="" class="text-center" method='post'>
                            <input type="hidden" name="quantidade" value="200">
                            <input type="hidden" name="corretor_preco" value="0.5">
                            <input type="hidden" name="parte1" value="100">
                            <input type="hidden" name="parte2" value="100">
                            <input type="hidden" name="personalizado" value="0.49">
                            <input type="hidden" name="pacote" value="PKT200PRESSLA">
                            <button type="submit" class="btn btn-primary">COMPRAR</button>
                        </form>                
                    </div>
                </div>

                <div class="col-4">
                    <div class="card-plano text-center">
                        <span class="text-muted">PACOTE 400</span>
                        <h1 class="text-center mt-3 mb-3">R$ 198,00</h1>
                        <hr>
                        Você economiza R$ 402,00
                        <hr>
                        <form action="" class="text-center" method='post'>
                            <input type="hidden" name="quantidade" value="300">
                            <input type="hidden" name="corretor_preco" value="0.25">
                            <input type="hidden" name="parte1" value="200">
                            <input type="hidden" name="parte2" value="100">
                            <input type="hidden" name="personalizado" value="0.98">
                            <input type="hidden" name="pacote" value="PKT300PRESSLA">
                            <button type="submit" class="btn btn-primary">COMPRAR</button>
                        </form>                
                    </div>
                </div>

                <div class="col-4">
                    <div class="card-plano text-center">
                        <span class="text-muted">PACOTE 400</span>
                        <h1 class="text-center mt-3 mb-3">R$ 249,00</h1>
                        <hr>
                        Você economiza R$ 551,00
                        <hr>
                        <form action="" class="text-center" method='post'>
                            <input type="hidden" name="quantidade" value="400">
                            <input type="hidden" name="corretor_preco" value="0.2">
                            <input type="hidden" name="parte1" value="300">
                            <input type="hidden" name="parte2" value="100">
                            <input type="hidden" name="personalizado" value="1.29">
                            <input type="hidden" name="pacote" value="PKT400PRESSLA">
                            <button type="submit" class="btn btn-primary">COMPRAR</button>
                        </form>                
                    </div>
                </div>
            </div>
            
            <h2 class="text-center text-muted mt-3 mb-3">OU</h2>
            
            <div class="row">
                <div class="col text-muted mb-4">
                    CRÉDITO AVULSO
                </div>
            </div>
            <form action="" method='post' id="form-quantidade">
                <div class="row">
                    <div class="col-1 text-right text-secondary" style="cursor:pointer" onclick="numeroTotal('menos')"> <h1>-</h1> </div>
                    <div class="col-3 col-md-2 text-center"><input type="text" name="quantidade" id="quantidade" class="form-control text-center bg-white" value="1" readonly></div>
                    <div class="col-1 text-left text-secondary" style="cursor:pointer" onclick="numeroTotal('mais')"> <h1>+</h1> </div>
                    <div class="col text-center border-left border-right">
                        <span class="small text-muted">TOTAL: </span><span id="total_pagar" style="font-size:2em"> R$ 2,00</span>
                    </div>
                    <div class="col-auto text-right">
                        <button type="submit" class="btn btn-primary">COMPRAR</button>
                    </div>
                </div>
                <div class="row">
                    
                </div>
            </form>
        </div>
      </div>
      <!-- <div class="modal-footer"> -->
        <!-- <button type="button" class="btn btn-primary" onclick="$('#form-quantidade').submit()">Via Mercado Pago</button> -->
        <!-- <button type="button" class="btn btn-success" onclick="window.open('https:\/\/api.whatsapp.com/send?phone=55<?=$whatsapp?>&text=Ol%C3%A1%2C%20gostaria%20de%20incluir%20'+ $('#quantidade').val() +'%20cr%C3%A9ditos%20%C3%A0%20minha%20conta%20do%20sistema%20de%20cartazes%20da%20Pressla!')">Via Whatsapp</button> -->
      <!-- </div> -->
    </div>
  </div>
</div>

<script>
    function numeroTotal(tipo){
        if(tipo == "menos"){
            $('#quantidade').val() > 1 ? $('#quantidade').val(parseInt($('#quantidade').val()) - 1) : false;
        } else {
            $('#quantidade').val(parseInt($('#quantidade').val()) + 1);
        }
        var valor = (parseFloat($('#quantidade').val()) * 2.00).toFixed(2);
        $("#total_pagar").html((" R$ "+valor).replace(".",","));
    }
</script>

<?php
if(!$usuarioadm && (!isset($cliente->cnpj) || (isset($cliente->cnpj) && $cliente->cnpj == ""))){
?>
<!-- Modal COMPLETAR CADASTRO -->
<div class="modal fade" id="modalCompletar" tabindex="-1" role="dialog" aria-labelledby="modalCompletarTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalCompletarLongTitle">Seja Muito Bem Vindo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container">
            <div class="row">
                <div class="col">
                    Você tem um crédito para testar nossa aplicação. Complete seu cadastro para reverter seu saldo em 10 créditos mensais gratuitamente!
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick='$("#modalCompletar").modal("hide")'>Lembre-me quando voltar</button>
        <button type="button" class="btn btn-success" onclick="window.location.href = '<?=base_url('index.php/dadoscliente/gerenciar/')?>'">Completar Cadastro</button>
      </div>
    </div>
  </div>
</div>

<script>
    $(document).ready(function(){
        $("#modalCompletar").modal("show");
    });
</script>
<?php
}
?>