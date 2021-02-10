<div class='col offset-md-2'>
    <div id="alerta-sucesso" class="alert alert-success hide" role="alert" style='display:none;'>
        Dados atualizados com sucesso!
    </div>
    <div id="alerta-erro" class="alert alert-danger hide" role="alert" style='display:none;'>
        Ocorreu um erro! Tente novamente.
    </div>

    <h1 class="header" style='padding:10px;'>Criação <small class="text-muted">Criação de Cartaz</small></h1>
    <hr>

    <div class='row'>
        <div class='col-sm mb-2'>
            <div class='card'>
                <div class='row'>
                    <div class='col'>
                        <h4 class="text-muted pl-3 pt-3">Dados do Produto</h4>
                        <hr class='m-3'>
                        <div class="row pl-2 pr-2">
                            <div class="col-sm-6">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Layout</span>
                                    </div>
                                    <select name="layout" id="layout" class='form-control' onchange="buscaIds()">
                                        <option value="1">Sem Imagem</option>
                                        <option value="2">Com Imagem</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row pl-2 pr-2">
                            <div class="col-sm">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Categoria</span>
                                    </div>
                                    <select name="tipo_template" id="tipo_template" class='form-control' onchange="buscaIds()">
                                        <?php
                                            foreach($templates as $template){
                                                echo "<option value='".$template->id."' id='".$template->id."'>";
                                                echo $template->tipo;
                                                echo "</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Template</span>
                                    </div>
                                    <select name="template" id="template" class='form-control' onchange="buscaTemplate()">
                                    </select>
                                    <input type='hidden' id='src_template' />
                                </div>
                            </div>
                        </div>
                        <div class="row pl-2 pr-2">
                            <div class="col-sm">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Tamanho</span>
                                    </div>
                                    <select name="tamanho" id="tamanho" class='form-control' onchange="tamSelecionado()">
                                        <?php
                                            foreach($tamanhos as $tamanho){
                                                echo "<option value='".$tamanho->fator."<|>".$tamanho->medidas."' id='".$tamanho->nome."'>";
                                                echo $tamanho->nome." | ".$tamanho->medidas;
                                                echo "</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Fonte</span>
                                    </div>
                                    <select name="fonte" id="fonte" class='form-control' onchange="isAviso()">
                                        <?php
                                            $path = 'assets/fonts/';
                                            $diretorio = dir($path);
                                        
                                            while($arquivo = $diretorio -> read()){
                                                if(strpos($arquivo, '.ttf')){
                                                    echo "<option value='".explode('.',$arquivo)[0]."'>";
                                                    echo explode('.',$arquivo)[0];
                                                    echo "</option>";
                                                }
                                            }
                                            $diretorio -> close();
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col">
                                <div class="form-check ml-2">
                                    <input type="checkbox" class="form-check-input" id="incluilogo" onchange="isAviso()" checked>
                                    <label class="form-check-label" for="incluilogo"> Incluir logo no cartaz</label>
                                </div>
                            </div>
                        </div>

                        <div class="row pl-2 pr-2" id='quadrantes' style='display:none;'>
                            <div class="col-auto">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Quadrante</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col d-flex align-items-center">
                                <label for="q1">
                                    <input type="radio" name="quadrante" value="1" id='q1' checked>
                                    &nbsp;1
                                </label>
                            </div>
                            <div class="col d-flex align-items-center">
                                <label for="q2">
                                    <input type="radio" name="quadrante" value="2" id='q2'>
                                    &nbsp;2
                                </label>
                            </div>
                            <div class="col d-flex align-items-center">
                                <label for="q3">
                                    <input type="radio" name="quadrante" value="3" id='q3'>
                                    &nbsp;3
                                </label>
                            </div>
                            <div class="col d-flex align-items-center">
                                <label for="q4">
                                    <input type="radio" name="quadrante" value="4" id='q4'>
                                    &nbsp;4
                                </label>
                            </div>
                        </div>

                        <div id='avisos' style='display:none;'>
                            <div class="row pl-2 pr-2">
                                <div class="col-sm">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="avisohorizontal">
                                        <label class="form-check-label" for="avisohorizontal">Imprimir em modo retrato</label>
                                    </div>
                                </div>
                                <div class="col-sm">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Tamanho</span>
                                        </div>
                                        <input type="number" class="form-control" id="size" min='1' max='4' step='1' value='1' class="form-control" onchange="criaAviso()">
                                    </div>
                                </div>
                            </div>
                            
                            <div id='linhas'>
                                <div class="row pl-2 pr-2">
                                    <div class="col-sm">
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Linha 1</span>
                                            </div>
                                            <input type="text" class="form-control textoaviso" id="linha1" class="form-control" onblur="criaAviso()" contenteditable="true" spellcheck="true">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row pl-2 pr-2 mb-2">
                                <div class="col-sm text-right">
                                    <input type="button" value="ADD LINHA" class="btn btn-dark col-auto" onclick="addLinha()">
                                </div>
                            </div>
                            
                            <div class="row pl-2 pr-2">
                                <div class="col-sm">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rodapé</span>
                                        </div>
                                        <input type="text" class="form-control" id="rodapeaviso" type="text" class="form-control" onblur="criaAviso()" contenteditable="true" spellcheck="true">
                                    </div>
                                </div>
                            </div>
                            <div class="row pl-2 pr-2 pt-3 pb-3">
                                <div class="col-sm">
                                    <input type="button" value="GERAR AVISO" class='btn btn-dark' onclick="gerarPDFaviso()">
                                    &nbsp;
                                    <input type="button" value="VER RESULTADO" class='btn btn-dark' onclick="criaAviso()">
                                </div>
                            </div>
                        </div>

                        <div id="todos">
                            <div class="form-check ml-2">
                                <input type="checkbox" class="form-check-input" id="horizontal">
                                <label class="form-check-label" for="horizontal">Pré-visualização em modo paisagem</label>
                            </div>

                            <div id="container_figuras" style="display:none;">
                                <div class="row pl-2 pr-2">
                                    <div class="col">
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Figura</span>
                                            </div>
                                            <input type="text" id="figura" class='form-control' placeholder="Faça uma busca pelo nome ou EAN do produto" onblur="escondeControle(this.value)" list="datafigura">
                                            <datalist id="datafigura">
                                                <?php
                                                    foreach($figuras as $figura){
                                                        echo "<option value='".$figura->nome."' onselect='isAviso()'/>";
                                                    }
                                                ?>
                                            </datalist>
                                        </div>
                                    </div>
                                    <div class="col-sm-2 text-center">
                                        <span class="btn btn-primary col" onclick="buscaImagens($('#figura').val())">
                                            <img src="<?= base_url("assets/images/pesquisa.png"); ?>" style="height:25px">
                                        </span>
                                    </div>
                                </div>

                                <div class="row pl-2 pr-2 pb-2">
                                    <input type="hidden" value="0" id="direita">
                                    <input type="hidden" value="0" id="cima">
                                    <input type="hidden" value="0" id="zoom">
                                    <div class="col m-0">
                                        <div id="controles" style="display:none;padding:10px;border:1px solid #eee;border-radius:6px;">
                                            <div class='row'>
                                                <div class="col-3 col-md-1 d-flex justify-content-center align-items-center">
                                                    <img src="<?php echo base_url("assets/images/left.png"); ?>" style="width:20px;cursor:pointer" onclick="passaImagem('back')">
                                                </div>
                                                <div class="col-6 col-md-4 d-flex justify-content-center align-items-center" style="height:200px;overflow:hidden;" id="col-img-figura">
                                                    <img src="" id="imagematual" class="w-100">
                                                </div>
                                                <div class="col-3 col-md-1 d-flex justify-content-center align-items-center">
                                                    <img src="<?php echo base_url("assets/images/right.png"); ?>" style="width:20px;cursor:pointer" onclick="passaImagem('next')">
                                                </div>
                                                <div class="col-sm d-flex justify-content-center align-items-center">
                                                    <div class="col text-center">
                                                        <img src="<?php echo base_url("assets/images/up.png"); ?>" style="width:25px;cursor:pointer" onclick="$('#cima').val(parseInt($('#cima').val())-1);isAviso();">
                                                        <br>
                                                        <img src="<?php echo base_url("assets/images/left.png"); ?>" style="height:25px;cursor:pointer" onclick="$('#direita').val(parseInt($('#direita').val())-1);isAviso();">
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <img src="<?php echo base_url("assets/images/right.png"); ?>" style="height:25px;cursor:pointer" onclick="$('#direita').val(parseInt($('#direita').val())+1);isAviso();">
                                                        <br>
                                                        <img src="<?php echo base_url("assets/images/downn.png"); ?>" style="width:25px;cursor:pointer" onclick="$('#cima').val(parseInt($('#cima').val())+1);isAviso();">
                                                        <br>
                                                        <br>
                                                        <img src="<?php echo base_url("assets/images/zoommenos.png"); ?>" style="height:40px;cursor:pointer" onclick="$('#zoom').val(parseInt($('#zoom').val())-1);isAviso();">
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <img src="<?php echo base_url("assets/images/zoommais.png"); ?>" style="height:40px;cursor:pointer" onclick="$('#zoom').val(parseInt($('#zoom').val())+1);isAviso();">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row pl-2 pr-2">
                                <div class="col-sm">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Linha 1</span>
                                        </div>
                                        <input type="text" class="form-control" id="produtol1" type="text" class="form-control" placeholder='Nome do Produto' onblur="criaCartaz()" contenteditable="true" spellcheck="true">
                                    </div>
                                </div>
                            </div>
                            <div class="row pl-2 pr-2">
                                <div class="col-sm">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Linha 2</span>
                                        </div>
                                        <input type="text" class="form-control" id="produtol2" type="text" class="form-control" placeholder='Marca do Produto' onblur="criaCartaz()" contenteditable="true" spellcheck="true">
                                    </div>
                                </div>
                            </div>
                            <div class="row pl-2 pr-2">
                                <div class="col-sm">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Linha 3</span>
                                        </div>
                                        <input type="text" class="form-control" id="produtol3" type="text" class="form-control" placeholder='Descrição Especial' onblur="criaCartaz()" contenteditable="true" spellcheck="true">
                                    </div>
                                </div>
                            </div>
                            <div class="row pl-2 pr-2">
                                <div class="col-sm">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Código do Produto</span>
                                        </div>
                                        <input type="text" class="form-control" id="codigo" type="text" class="form-control" onblur="criaCartaz()" contenteditable="true" spellcheck="true">
                                    </div>
                                </div>
                            </div>
                            <div class="row pl-2 pr-2">
                                <div class="col-sm">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Preço</span>
                                        </div>
                                        <input class="form-control" id="preco" type="text" class="form-control" placeholder='Ex.: 1,99' required oninput="" pattern="[0-9]*" onblur="criaCartaz()">
                                    </div>
                                </div>
                                <div class="col-sm">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Anterior</span>
                                        </div>
                                        <input class="form-control" id="precoant" type="text" class="form-control" placeholder='Ex.: 1,99' required oninput="" pattern="[0-9]*" onblur="criaCartaz()">
                                    </div>
                                </div>
                            </div>
                            <div class="row pl-2 pr-2">
                                <div class="col-sm">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Unidade</span>
                                        </div>
                                        <input type="text" class="form-control" id="unidade" type="text" class="form-control" placeholder='Ex.: KG' required onblur="criaCartaz()">
                                    </div>
                                </div>
                            </div>
                            <div class="row pl-2 pr-2">
                                <div class="col-sm">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rodapé</span>
                                        </div>
                                        <input type="text" class="form-control" id="rodape" type="text" class="form-control" placeholder='Mensagem de rodapé' value="Oferta válida enquanto durarem nossos estoques"  onblur="criaCartaz()" contenteditable="true" spellcheck="true">
                                    </div>
                                </div>
                            </div>
                            <div class="row pl-2 pr-2 pt-3 pb-3">
                                <div class="col-sm">
                                    <input type="button" value="GERAR CARTAZ" class='btn btn-dark' onclick="gerarPDF()" id='bt-pdf'>
                                    &nbsp;
                                    <input type="button" value="VER RESULTADO" class='btn btn-dark' onclick="criaCartaz()">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class='col-sm mb-2'>
            <div class='card' style="padding-bottom:20px;">
                <div class='row'>
                    <div class='col'>
                        <h4 class="text-muted pl-3 pt-3">Pré-visualização</h4>
                        <hr class='m-3'>
                        <div id="ver_img" class='pt-2 text-center w-100'>
                        </div>
                    </div>
                </div>
                <div id='loader-cartaz' class='loader' style='display:none;'>
                    <img src="<?php echo base_url('assets/images/loader.gif'); ?>">
                </div>
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

    <!-- TODOS OS CANVAS QUE SERVEM PARA A PRÉ VISUALIZAÇÃO APENAS -->
    <!-- <div id='container_cartaz_pre' style='display:none;'>
        <canvas id='cartaz_pre' width='396.9' height='559.44'></canvas>
    </div>
    <div id='container_cartaz_pre1' style='display:none;'></div>
    <div id='container_cartaz_pre2' style='display:none;'></div>
    <div id='container_cartaz_pre3' style='display:none;'></div>
    <div id='container_cartaz_pre4' style='display:none;'></div>

    <div id='container_avisoh_pre' style='display:none;'>
        <canvas id='avisoh_pre' width='559.44' height='396.9'></canvas>
    </div>
    <div id='container_avisoh_pre1' style='display:none;'></div>
    <div id='container_avisoh_pre2' style='display:none;'></div>
    <div id='container_avisoh_pre3' style='display:none;'></div>
    <div id='container_avisoh_pre4' style='display:none;'></div>

    <div id='container_avisor_pre' style='display:none;'>
        <canvas id='avisor_pre' width='396.9' height='559.44'></canvas>
    </div>
    <div id='container_avisor_pre1' style='display:none;'></div>
    <div id='container_avisor_pre2' style='display:none;'></div>
    <div id='container_avisor_pre3' style='display:none;'></div>
    <div id='container_avisor_pre4' style='display:none;'></div> -->
    
    <!-- TODOS OS CANVAS QUE SERVEM PARA GERAR O RESULTADO FINAL. ELES DEVEM SEMPRE POSSUIR O TAMANHO DO MAIOR TEMPLATE -->
    <div id='container_cartaz' style='display:none;'>
        <canvas id='cartaz' width='1122.66' height='1587.6'></canvas>
    </div>
    <div id='container_cartaz1' style='display:none;'></div>
    <div id='container_cartaz2' style='display:none;'></div>
    <div id='container_cartaz3' style='display:none;'></div>
    <div id='container_cartaz4' style='display:none;'></div>

    <div id='container_avisoh' style='display:none;'>
        <canvas id='avisoh' width='1587.6' height='1122.66'></canvas>
    </div>
    <div id='container_avisoh1' style='display:none;'></div>
    <div id='container_avisoh2' style='display:none;'></div>
    <div id='container_avisoh3' style='display:none;'></div>
    <div id='container_avisoh4' style='display:none;'></div>

    <div id='container_avisor' style='display:none;'>
        <canvas id='avisor' width='1122.66' height='1587.6'></canvas>
    </div>
    <div id='container_avisor1' style='display:none;'></div>
    <div id='container_avisor2' style='display:none;'></div>
    <div id='container_avisor3' style='display:none;'></div>
    <div id='container_avisor4' style='display:none;'></div>

    <div style='display:none;'>
        <canvas id='testecanvas' width='1' height='1'></canvas>
    </div>
    <div id="cont">
    </div>
</div>