<?php
$compat = explode(', ',$template->ids_tipos);
$id_exclusivo = explode(',',$template->id_exclusivo);
?>
<div class="col-2" id="comptela"></div>
<div class='col' id="tela">
    <div id="alerta-sucesso" class="alert alert-success hide" role="alert" style='display:none;'>
        Dados atualizados com sucesso!
    </div>
    <div id="alerta-erro" class="alert alert-danger hide" role="alert" style='display:none;'>
        Ocorreu um erro! Tente novamente.
    </div>

    <h1 class="header" style='padding:10px;'><a  href="<?=base_url('index.php/templates/');?>">Templates </a> <small class="text-muted">Gerenciamento de Template</small></h1>
    <hr>
    
    <div class='row'>
        <div class='col'>
            <div class='card p-4'>
                <form id="frm-template" action="<?=base_url('index.php/templates/update/'.$template->id)?>" method='post' enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="col-sm">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Nome</span>
                                </div>
                                <input type="text" class="form-control" id="nome" name="nome" type="text" class="form-control" value="<?=$template->nome?>" placeholder="Ex.: Varejão" required>
                            </div>
                        </div>
                        <div class="col-sm col-12">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Imagem</span>
                                </div>
                                <label class='form-control' for='src' id="label-img" style="cursor:pointer;"><?=$template->src?></label>
                                <input type="file" id="src" name="src" style="display:none;" oninput="$('#label-img').html($('#src').val().split('\\').pop())" accept="image/png, image/jpeg, image/jpg"/>
                            </div>
                        </div>
                    </div>

                    <script>
                        function irAoCliente(elemento){
                            $(".coisas").removeClass("border-bottom");
                            var div = $('[name *= "'+elemento.value.toUpperCase()+'" ]:first');
                            
                            if(div && div.offset()){
                                div.addClass("border-bottom");
                                div.addClass("border-primary");
                                
                                $('#clientes-scroll').animate({
                                        scrollTop: 0
                                }, 0);
                                $('#clientes-scroll').animate({
                                    scrollTop: div.offset().top - 300
                                }, 'fast');
                            }
                        }
                    </script>

                    <div class="row mt-3">
                        <div class="col-sm-6">
                            <span class='text-muted'>Selecione uma categoria</span>
                            <br><br>
                            <div class="row">
                            <?php
                                foreach($tipos as $tipo){
                            ?>
                            <div class="col-6">
                                <label class='btn p-0 m-0'><input type='checkbox' value='<?= $tipo->id ?>' name='tipos' id='tipo<?= $tipo->id ?>' onchange='constuirIdsTipos()' <?= (in_array($tipo->id, $compat) ? "checked" : "") ?>> <?= $tipo->tipo ?></label>
                            </div>
                            <?php
                                }
                            ?>
                            </div>
                            <input type="hidden" name="ids_tipos" id="ids_tipos" value="<?=$template->ids_tipos?>">
                        </div>

                        <div class="col-sm-6">
                            <span class='text-muted'>O template é exclusivo a algum dos clientes?</span>
                            <br><br>
                            <div class="border p-2">
                                <div class="row">
                                    <div class="col">
                                        <input type="text" class="form-control" placeholder="Digite o nome do cliente para ajudar a encontrá-lo..." onkeyup="irAoCliente(this)">
                                    </div>
                                </div>
                                <div class="row pl-3 pr-3 pt-3">
                                    <div class="w-100" style="overflow-y:auto; overflow-x:hidden; max-height: 350px" id="clientes-scroll">
                                        <div class="row">
                                            <div class="col-12 coisas" name="TODOS OS ASSINANTES">
                                                <label> <input type="checkbox" name="id_exclusivo[]" value="0" <?= in_array(0, $id_exclusivo) ? "checked" : "" ?>> Todos os Assinantes</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 coisas" name="ASSINANTES PREMIUM">
                                                <label> <input type="checkbox" name="id_exclusivo[]" value="1" <?= in_array(1, $id_exclusivo) ? "checked" : "" ?>> Assinantes PREMIUM</label>
                                            </div>
                                        </div>
                                        <?php
                                            foreach($clientes as $cliente){
                                        ?>
                                        <div class="row">
                                            <div class="col-12 coisas" name="<?= strtoupper($cliente->nome) ?>">
                                                <label> <input type="checkbox" name="id_exclusivo[]" value="<?= $cliente->id ?>" <?= in_array($cliente->id, $id_exclusivo) ? "checked" : "" ?>> <?= $cliente->nome ?></label>
                                            </div>
                                        </div>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <br><br>

                    <div class="col-sm-12">
                        <span class='text-muted'>Para qual layout será selecionado o template?</span>
                        <br><br>
                        <div class="row">
                            <div class="col-sm-4">
                                <label class="form-check-label"><input type="radio" name="layout" id="layout1" value='1' class="form-check-input" <?php echo ($template->layout == 1 ? "checked" : ""); ?>> Sem Imagem</label>
                            </div>
                            <div class="col-sm-4">
                                <label class="form-check-label"><input type="radio" name="layout" id="layout2" value='2' class="form-check-input" <?php echo ($template->layout == 2 ? "checked" : ""); ?>> Com Imagem</label>
                            </div>
                            <div class="col-sm-4">
                                <label class="form-check-label"><input type="radio" name="layout" id="layout3" value='3' class="form-check-input" <?php echo ($template->layout == 3 ? "checked" : ""); ?>> Cartão da Loja</label>
                            </div>
                            <div class="col-sm-4">
                                <label class="form-check-label"><input type="radio" name="layout" id="layout4" value='4' class="form-check-input" <?php echo ($template->layout == 4 ? "checked" : ""); ?>> Clube Fidelidade</label>
                            </div>
                            <div class="col-sm-4">
                                <label class="form-check-label"><input type="radio" name="layout" id="layout5" value='5' class="form-check-input" <?php echo ($template->layout == 5 ? "checked" : ""); ?>> Layout Horizontal</label>
                            </div>
                            <div class="col-sm-4">
                                <label class="form-check-label"><input type="radio" name="layout" id="layout6" value='6' class="form-check-input" <?php echo ($template->layout == 6 ? "checked" : ""); ?>> Faixas para Gôndolas</label>
                            </div>
                            <div class="col-sm-4">
                                <label class="form-check-label"><input type="radio" name="layout" id="layout6b" value='6b' class="form-check-input" <?php echo ($template->layout == '6b' ? "checked" : ""); ?>> Faixas para Gôndolas 12x3</label>
                            </div>
                            <div class="col-sm-4">
                                <label class="form-check-label"><input type="radio" name="layout" id="layout7" value='7' class="form-check-input" <?php echo ($template->layout == 7 ? "checked" : ""); ?>> Banner Bolsão A2 Vertical</label>
                            </div>
                            <div class="col-sm-4">
                                <label class="form-check-label"><input type="radio" name="layout" id="layout18" value='18' class="form-check-input" <?php echo ($template->layout == 18 ? "checked" : ""); ?>> Banner A2 Vertical</label>
                            </div>
                            <div class="col-sm-4">
                                <label class="form-check-label"><input type="radio" name="layout" id="layout8" value='8' class="form-check-input" <?php echo ($template->layout == 8 ? "checked" : ""); ?>> Atacado</label>
                            </div>
                            <div class="col-sm-4">
                                <label class="form-check-label"><input type="radio" name="layout" id="layout9" value='9' class="form-check-input" <?php echo ($template->layout == 9 ? "checked" : ""); ?>> Com Imagem 2</label>
                            </div>
                            <div class="col-sm-4">
                                <label class="form-check-label"><input type="radio" name="layout" id="layout28" value='28' class="form-check-input" <?php echo ($template->layout == 28 ? "checked" : ""); ?>> Vertical G1</label>
                            </div>
                            <div class="col-sm-4">
                                <label class="form-check-label"><input type="radio" name="layout" id="layout10" value='10' class="form-check-input" <?php echo ($template->layout == 10 ? "checked" : ""); ?>> Atacado e Varejo - Horizontal</label>
                            </div>
                            <div class="col-sm-4">
                                <label class="form-check-label"><input type="radio" name="layout" id="layout11" value='11' class="form-check-input" <?php echo ($template->layout == 11 ? "checked" : ""); ?>> Varejo - Horizontal</label>
                            </div>
                            <div class="col-sm-4">
                                <label class="form-check-label"><input type="radio" name="layout" id="layout12" value='12' class="form-check-input" <?php echo ($template->layout == 12 ? "checked" : ""); ?>> 2 Preços - Sem Imagem 2</label>
                            </div>
                            <!-- O 13 NÃO PRECISA, POIS PEGA OS TEMPLATES DO 1 -->
                            <div class="col-sm-4">
                                <label class="form-check-label"><input type="radio" name="layout" id="layout14" value='14' class="form-check-input" <?php echo ($template->layout == 14 ? "checked" : ""); ?>> Bolsão A3x4 - Horizontal</label>
                            </div>
                            <div class="col-sm-4">
                                <label class="form-check-label"><input type="radio" name="layout" id="layout15" value='15' class="form-check-input" <?php echo ($template->layout == 15 ? "checked" : ""); ?>> 2 Preços - Sem Imagem</label>
                            </div>
                            <div class="col-sm-4">
                                <label class="form-check-label"><input type="radio" name="layout" id="layout16" value='16' class="form-check-input" <?php echo ($template->layout == 16 ? "checked" : ""); ?>> 2 preços Horizontal sem imagem 8x20</label>
                            </div>
                            <div class="col-sm-4">
                                <label class="form-check-label"><input type="radio" name="layout" id="layout17" value='17' class="form-check-input" <?php echo ($template->layout == 17 ? "checked" : ""); ?>> 1 preço Horizontal sem imagem 8x20</label>
                            </div>
                            <div class="col-sm-4">
                                <label class="form-check-label"><input type="radio" name="layout" id="layout25" value='25' class="form-check-input" <?php echo ($template->layout == 25 ? "checked" : ""); ?>> 1 Preço horizontal - Sem imagem 42x30</label>
                            </div>
                            <div class="col-sm-4">
                                <label class="form-check-label"><input type="radio" name="layout" id="layout21" value='21' class="form-check-input" <?php echo ($template->layout == 21 ? "checked" : ""); ?>> Horizontal 17x12 sem imagem</label>
                            </div>
                            <div class="col-sm-4">
                                <label class="form-check-label"><input type="radio" name="layout" id="layout22" value='22' class="form-check-input" <?php echo ($template->layout == 22 ? "checked" : ""); ?>> Horizontal 17x12 com imagem</label>
                            </div>
                            <div class="col-sm-4">
                                <label class="form-check-label"><input type="radio" name="layout" id="layout27" value='27' class="form-check-input" <?php echo ($template->layout == 27 ? "checked" : ""); ?>> Horizontal P1</label>
                            </div>
                            <div class="col-sm-4">
                                <label class="form-check-label"><input type="radio" name="layout" id="layout23" value='23' class="form-check-input" <?php echo ($template->layout == 23 ? "checked" : ""); ?>> Horizontal 17x12 Tabloide</label>
                            </div>
                            <!-- <div class="col-sm-4">
                                <label class="form-check-label"><input type="radio" name="layout" id="layout18" value='18' class="form-check-input" <?php echo ($template->layout == 18 ? "checked" : ""); ?>> Tabloide 6 Produtos</label>
                            </div> -->
                            <div class="col-sm-4">
                                <label class="form-check-label"><input type="radio" name="layout" id="layout19" value='19' class="form-check-input" <?php echo ($template->layout == 19 ? "checked" : ""); ?>> Tabloide 11 Produtos</label>
                            </div>
                            <div class="col-sm-4">
                                <label class="form-check-label"><input type="radio" name="layout" id="layout20" value='20' class="form-check-input" <?php echo ($template->layout == 20 ? "checked" : ""); ?>> Tabloide 12 Produtos</label>
                            </div>
                        </div>
                    </div>

                    <br><br>

                    <div class="form-group text-right">
                        <button id="enviar" type="submit" class="btn btn-primary col-2 pull-right mb-0 mt-2">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalAviso" tabindex="-1" role="dialog" aria-labelledby="modalAvisoLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAvisoLabel">Atenção!</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" id="texto-aviso"></div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
</div>