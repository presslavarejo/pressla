<style>
<?php
foreach($tipos as $tipo){
    if($tipo->layout != 1 && $tipo->layout != 13){
        echo ".categoria".$tipo->layout." {display:none;}";
    }
}
?>
.categoria1 {display:block;}
.readonly {
    background: #eee; /*Simular campo inativo - Sugestão @GabrielRodrigues*/
    pointer-events: none;
    touch-action: none;
}
.aba2,.aba3 {
    display:none;
}
td {
    border: 1px dashed #cecece;
    text-align:center;
}
td label {
    padding:10px;
    text-align:center;
}
.editor__editable,
/* Classic build. */
main .ck-editor[role='application'] .ck.ck-content,
/* Decoupled document build. */
.ck.editor__editable[role='textbox'],
.ck.ck-editor__editable[role='textbox'],
/* Inline & Balloon build. */
.ck.editor[role='textbox'] {
	width: 100%;
	background: #fff;
	font-size: 1em;
	line-height: 1.6em;
	min-height: 180px;
	padding: 1.5em 2em;
}
</style>
<script>
    function mudaCategorias(num){
        // num = num == 13 ? 1 : (num == 21 || num == 22 ? 11 : num);
        if(num != 26){
            num = num == 13 ? 1 : num;
            $('.categoria').hide();
            $('.categoria'+num).show();
            $(".categoria").removeAttr("selected");
            $(".categoria"+num+":first").attr("selected", "selected");
            selecionaCores();
            buscaIds();
            tamSelecionado();
            dados_faixa = {};
            dados_quadrante = {}
        } else {
            isAviso();
        }
    }
</script>
<script src="<?= base_url("assets/ckeditor/build/ckeditor.js") ?>"></script>
<div class="col-2" id="comptela"></div>
<div class='col-sm pl-0 pr-md-2 pr-0 h-100' id="tela">
    <div id="alerta-sucesso" class="alert alert-success hide" role="alert" style='display:none;'>
        Dados atualizados com sucesso!
    </div>
    <div id="alerta-erro" class="alert alert-danger hide" role="alert" style='display:none;'>
        Ocorreu um erro! Tente novamente.
    </div>

    <div class='row no-gutters h-100'>
        <div class='col-sm bg-white h-100'>
            <div class="row">
                <div class="col-sm text-white">
                    <div class="row no-gutters m-0 p-0">
                        <div class="col p-3 text-center aba bg-white text-dark" id="aba1" onclick="mudaAba(1)">
                            <strong>LAYOUT</strong>
                        </div>
                        <div class="col p-3 text-center aba bg-dark" id="aba2" onclick="mudaAba(2)" style="border-bottom-left-radius:10px">
                            <strong>TEXTOS</strong>
                        </div>
                        <div class="col p-3 text-center aba bg-dark"  id="aba3" onclick="mudaAba(3)">
                            <strong>PREÇOS</strong>
                        </div>
                    </div>
                </div>
            </div>

            <div class='row pt-5 p-2'>
                <div class='col'>
                    <div class="row pl-2 pr-2 aba1">
                        <div class="col-sm">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Layout</span>
                                </div>
                                <select name="layout" id="layout" class='form-control' onchange="mudaCategorias(this.value)">
                                    <optgroup label="Layouts Verticais">
                                        <option value="1">Sem Imagem</option>
                                        <option value="13">Sem Imagem 2</option>
                                        <option value="2">Com Imagem</option>
                                        <option value="3">Cartão da Loja</option>
                                        <option value="4">Clube Fidelidade</option>
                                        <option value="15">2 Preços - Sem Imagem</option>
                                        <option value="7">Banner Bolsão A2</option>
                                        <option value="18">Banner A2</option>
                                        <option value="8">Atacado</option>
                                        <option value="9">Com Imagem 2</option>
                                        <option value="12">2 Preços - Sem Imagem 2</option>

                                        <option value="28">Vertical G1</option>
                                    </optgroup>
                                    <optgroup label="Layouts Horizontais">
                                        <option value="5">Layout Horizontal - Com imagem</option>
                                        <option value="6">Faixas para Gôndolas</option>
                                        <option value="6b">Faixas para Gôndolas 12x3</option>
                                        <option value="10">Atacado e Varejo - Sem imagem</option>
                                        <option value="11">Varejo - Sem imagem</option>
                                        <option value="14">Bolsão A1 - Com imagem</option>
                                        <option value="16">2 preços Horizontal sem imagem 8x20</option>
                                        <option value="17">1 preço Horizontal sem imagem 8x20</option>
                                        <option value="25">1 Preço horizontal - Sem imagem 42x30</option>
                                        <option value="21">Horizontal 17x12 sem imagem</option>
                                        <option value="22">Horizontal 17x12 com imagem</option>
                                        <option value="26">Horizontal 8x A3 - Apenas Texto</option>

                                        <option value="27">Horizontal P1</option>
                                    </optgroup>
                                    <?php
                                    if($this->clientes_model->getClientes($id)->tabloid == 1){
                                    ?>
                                    <optgroup label="Tabloides">
                                        <!-- <option value="18">Tabloide 6 Produtos</option> -->
                                        <option value="23">Horizontal 17x12 Tabloide</option>
                                        <option value="19">Tabloide 11 Produtos</option>
                                        <option value="20">Tabloide 12 Produtos</option>
                                    </optgroup>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm" id="container_categoria">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Categoria</span>
                                </div>
                                <select name="tipo_template" id="tipo_template" class='form-control' onchange="buscaIds()">
                                    <?php
                                        foreach($templates as $template){
                                            echo "<option value='".$template->id."' id='".$template->id."' class='";
                                            foreach($tipos as $tipo){
                                                $arids = explode(", ",$tipo->tipos_ids);
                                                if(in_array($template->id, $arids)){
                                                    echo "categoria".$tipo->layout." ";
                                                }
                                            }
                                            echo "categoria'>";
                                            echo $template->tipo;
                                            echo "</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row pl-2 pr-2 aba1">
                        <div class="col-sm" id="container_template">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Template</span>
                                </div>
                                <select name="template" id="template" class='form-control' onchange="buscaTemplate()">
                                </select>
                                <input type='hidden' id='src_template' />
                            </div>
                        </div>
                        <div class="col-sm" id="tamanho_comum">
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
                        <div class="col-sm" id="tamanho_maior" style="display:none;">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Tamanho</span>
                                </div>
                                <select name="tamanho2" id="tamanho2" class='form-control'>
                                    <option selected value="A1">A1 4 x A3</option>
                                    <option value="A1U">A1 (Página Única)</option>
                                    <option value="A3">A3 (Página Única)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="aba2">
                        <div class="row pl-2 pr-2">
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
                                                // if(strpos($arquivo, '.ttf')){
                                                //     echo "<option value='".explode('.',$arquivo)[0]."'>";
                                                //     echo explode('.',$arquivo)[0];
                                                //     echo "</option>";
                                                // }
                                                if($arquivo != "." && $arquivo != ".."){
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
                            <div class="col-sm" id="container_tam_fonte">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Tam. Fonte (%)</span>
                                    </div>
                                    <input type="number" id="tamanho_fonte" class="form-control" value="100" min="1" step="5" onchange="isAviso()">
                                </div>
                            </div>
                            <div class="col-sm" id="container_tam_fonte_aviso">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Tamanho</span>
                                    </div>
                                    <input type="number" class="form-control" id="size" min='1' max='4' step='1' value='1' class="form-control" onchange="criaAviso()">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row aba1">
                        <div class="col" id="container_incluirlogo">
                            <div class="form-check ml-2">
                                <input type="checkbox" class="form-check-input" id="incluilogo" onchange="isAviso()" checked>
                                <label class="form-check-label" for="incluilogo"> Incluir logo no cartaz</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="aba1">
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
                                    <input type="radio" name="quadrante" value="1" id='q1' onclick="isAvisoDois()" checked>
                                    &nbsp;1
                                </label>
                            </div>
                            <div class="col d-flex align-items-center">
                                <label for="q2">
                                    <input type="radio" name="quadrante" value="2" id='q2' onclick="isAvisoDois()">
                                    &nbsp;2
                                </label>
                            </div>
                            <div class="col d-flex align-items-center">
                                <label for="q3">
                                    <input type="radio" name="quadrante" value="3" id='q3' onclick="isAvisoDois()">
                                    &nbsp;3
                                </label>
                            </div>
                            <div class="col d-flex align-items-center">
                                <label for="q4">
                                    <input type="radio" name="quadrante" value="4" id='q4' onclick="isAvisoDois()">
                                    &nbsp;4
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="aba1">
                        <div id='faixas' style='display:none;'>
                            <div class="row pl-2 pr-2">
                                <div class="col-auto">
                                    <strong>Faixas</strong>
                                </div>
                            </div>
                            
                            <div class="row pl-2 pr-2">
                                <div class="col">
                                    <hr>
                                </div>
                            </div>
                            
                            <div class="row pl-2 pr-2">
                                <div class="col d-flex align-items-center">
                                    <label for="f1">
                                        <input type="radio" name="faixa" value="1" id='f1' onchange="isAvisoDois()" checked>
                                        &nbsp;Faixa 1
                                    </label>
                                </div>
                                <div class="col d-flex align-items-center">
                                    <label for="f2">
                                        <input type="radio" name="faixa" value="2" id='f2' onchange="isAvisoDois()">
                                        &nbsp;Faixa 2
                                    </label>
                                </div>
                                <div class="col d-flex align-items-center">
                                    <label for="f3">
                                        <input type="radio" name="faixa" value="3" id='f3' onchange="isAvisoDois()">
                                        &nbsp;Faixa 3
                                    </label>
                                </div>
                                <div class="col d-flex align-items-center">
                                    <label for="f4">
                                        <input type="radio" name="faixa" value="4" id='f4' onchange="isAvisoDois()">
                                        &nbsp;Faixa 4
                                    </label>
                                </div>
                                <div class="col d-flex align-items-center">
                                    <label for="f5">
                                        <input type="radio" name="faixa" value="5" id='f5' onchange="isAvisoDois()">
                                        &nbsp;Faixa 5
                                    </label>
                                </div>
                            </div>

                            <div class="row pl-2 pr-2">
                                <div class="col d-flex align-items-center">
                                    <label for="f6">
                                        <input type="radio" name="faixa" value="6" id='f6' onchange="isAvisoDois()">
                                        &nbsp;Faixa 6
                                    </label>
                                </div>
                                <div class="col d-flex align-items-center">
                                    <label for="f7">
                                        <input type="radio" name="faixa" value="7" id='f7' onchange="isAvisoDois()">
                                        &nbsp;Faixa 7
                                    </label>
                                </div>
                                <div class="col d-flex align-items-center">
                                    <label for="f8">
                                        <input type="radio" name="faixa" value="8" id='f8' onchange="isAvisoDois()">
                                        &nbsp;Faixa 8
                                    </label>
                                </div>
                                <div class="col d-flex align-items-center">
                                    <label for="f9">
                                        <input type="radio" name="faixa" value="9" id='f9' onchange="isAvisoDois()">
                                        &nbsp;Faixa 9
                                    </label>
                                </div>
                                <div class="col d-flex align-items-center">
                                    <label for="f10">
                                        <input type="radio" name="faixa" value="10" id='f10' onchange="isAvisoDois()">
                                        &nbsp;Faixa 10
                                    </label>
                                </div>
                            </div>
                            
                            <div class="row pl-2 pr-2">
                                <div class="col">
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id='avisos' style='display:none;'>
                        <div class="row pl-2 pr-2 aba1">
                            <div class="col-sm">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="avisohorizontal">
                                    <label class="form-check-label" for="avisohorizontal">Imprimir em modo retrato</label>
                                </div>
                            </div>
                        </div>
                        
                        <div id='linhas' class="aba2">
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

                        <div class="row pl-2 pr-2 mb-2 aba2">
                            <div class="col-sm text-right">
                                <input type="button" value="ADD LINHA" class="btn btn-dark col-auto" onclick="addLinha()">
                            </div>
                        </div>
                        
                        <div class="row pl-2 pr-2 aba2">
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
                            </div>
                        </div>
                    </div>

                    <div id="todos">
                        <div class="aba1">
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
                                                        echo "<option value='".$figura->nome."' onselect='isAviso()'>".$figura->ean."</option>";
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
                        </div>

                        <style>
                            ul.auto-list{
                                background-color:#fff;
                                position:fixed;
                                z-index:1001;
                                box-shadow: 0px 0px 6px #cecece;
                                display:none;
                            }
                            ul.auto-list li{
                                padding:5px;
                                cursor: pointer;
                            }
                            ul.auto-list li:hover{
                                background-color:#eee;
                            }
                        </style>

                        <div class="aba2">
                            <div class="row pl-2 pr-2 mb-2">
                                <div class="col-sm">
                                    <!-- <div id="editor"></div> -->
                                    <textarea id="editor" cols="30" rows="3" placeholder="Descrição do Produto"></textarea>
                                    <div id="container_maisinfo" style="display:none">
                                        <div class="row mt-2">
                                            <div class="col-sm">
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Informação Adicional</span>
                                                    </div>
                                                    <input type="text" class="form-control" id="informacao-adicional" type="text" class="form-control" onblur="criaCartaz()" placeholder="Ex.: Contém Glúten">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm">
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Abastecimento</span>
                                                    </div>
                                                    <input type="date" class="form-control" id="abastecimento" type="text" class="form-control" onblur="criaCartaz()">
                                                </div>
                                            </div>
                                            <div class="col-sm">
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Vencimento</span>
                                                    </div>
                                                    <input type="date" class="form-control" id="vencimento" type="text" class="form-control" onblur="criaCartaz()">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="col-sm-5 auto-list" id="auto-list">
                                        <li class="lista"></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row pl-2 pr-2 mt-4 mb-4" id="container_incluir_produto" style="display:none">
                                <div class="col align-middle">
                                    <span style="cursor:pointer" onclick="addProduto()"><i class="fa fa-question-circle text-primary" aria-hidden="true"></i> Deseja acrescentar este produto à sua lista de produtos?</span>
                                </div>
                            </div>
                        
                            <div class="row pl-2 pr-2" id="container_codigo">
                                <div class="col-sm">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="label_codigo">Código do Produto</span>
                                        </div>
                                        <input type="text" class="form-control" id="codigo" type="text" class="form-control" onblur="criaCartaz()" contenteditable="true" spellcheck="true">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="aba3">
                            <div class="row pl-2 pr-2">
                                <div class="col">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text preco">Preço</span>
                                        </div>
                                        <input class="form-control" id="preco" type="text" class="form-control" placeholder='Ex.: 1,99' required oninput="" pattern="[0-9]*" onblur="salvaAutomatico();criaCartaz()">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Cor</span>
                                        </div>
                                        <input type="color" id="cor_preco" name="ArcoIris" list="arcoIris" value="#FFFFFF" class="form-control p-0" style="height:38px" onchange="criaCartaz()">
                                        <datalist id="arcoIris">
                                            <option value="#FFFFFF">Branco</option>
                                            <option value="#000000">Preto</option>
                                            <option value="#FF0000">Vermelho</option>
                                        </datalist>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="aba3">
                            <div class="row pl-2 pr-2 container_acimade">
                                <div class="col-sm">
                                    <div class="input-group mb-2">
                                        <!-- <div class="input-group-prepend">
                                            <span class="input-group-text">Acima de</span>
                                        </div> -->
                                        <input type="text" class="form-control" id="acimade" type="text" class="form-control" value="Ex.: X unidades" onblur="criaCartaz()">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="aba3">
                            <div class="row pl-2 pr-2" id="container_preco_anterior">
                                <div class="col">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text ant">Anterior</span>
                                        </div>
                                        <input class="form-control" id="precoant" type="text" class="form-control" placeholder='Ex.: 1,99' required oninput="" pattern="[0-9]*" onblur="salvaAutomatico();criaCartaz()">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Cor</span>
                                        </div>
                                        <input type="color" id="cor_preco_anterior" name="ArcoIris" list="arcoIris" value="#FFFFFF" class="form-control p-0" style="height:38px" onchange="criaCartaz()">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="aba3">
                            <div class="row pl-2 pr-2 container_acimade" id="container_acimade_varejo">
                                <div class="col-sm">
                                    <div class="input-group mb-2">
                                        <!-- <div class="input-group-prepend">
                                            <span class="input-group-text">Acima de</span>
                                        </div> -->
                                        <input type="text" class="form-control" id="acimadevarejo" type="text" class="form-control" value="Ex.: Unidade" onblur="criaCartaz()">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="aba3">
                            <div class="row pl-2 pr-2" id="container_unidade">
                                <div class="col-sm">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Unidade</span>
                                        </div>
                                        <input type="text" class="form-control" id="unidade" type="text" class="form-control" placeholder='Ex.: KG' required onblur="criaCartaz()">
                                    </div>
                                </div>
                            </div>
                            <div class="row pl-2 pr-2" id="container_texto_livre">
                                <div class="col-sm">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Detalhes</span>
                                        </div>
                                        <input type="text" class="form-control" id="detalhe" type="text" class="form-control" placeholder='Texto livre' required onblur="criaCartaz()">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row pl-2 pr-2 aba2">
                            <div class="col-sm" id="container_rodape">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="texto_rodape">Rodapé</span>
                                    </div>
                                    <input type="text" class="form-control" id="rodape" type="text" class="form-control" value="Oferta válida enquanto durarem nossos estoques"  onblur="criaCartaz()" contenteditable="true" spellcheck="true">
                                </div>
                            </div>
                        </div>

                        <div class="row pl-2 pr-2" id='container_tabela_18' style="display:none">
                            <div class="col-3 text-center">
                                <input type="hidden" id="width_18" value="2">
                                <input type="hidden" id="height_18" value="4">
                                Grade
                                <br>
                                <table style="width:100%">
                                    <tr>
                                        <td colspan=2> <label></label><br> </td>
                                    </tr>
                                    <tr>
                                        <!-- NO VALUE = PÁGINA/LINHA/COLUNA/TIPO(nORMAL,hORIZONTAL,vERTICAL) -->
                                        <td><label><input type="radio" name="cel_tab_18" value="110n" id="110" checked></label></td>
                                        <td><label><input type="radio" name="cel_tab_18" value="111n" id="111"></label></td>
                                    </tr>
                                    <tr>
                                        <td><label><input type="radio" name="cel_tab_18" value="120n" id="120"></label></td>
                                        <td><label><input type="radio" name="cel_tab_18" value="121n" id="121"></label></td>
                                    </tr>
                                    <tr>
                                        <td><label><input type="radio" name="cel_tab_18" value="130n" id="130"></label></td>
                                        <td><label><input type="radio" name="cel_tab_18" value="131n" id="131"></label></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="row pl-2 pr-2" id='container_tabela_19' style="display:none">
                            <div class="col-3 text-center">
                                <input type="hidden" id="width_19" value="3">
                                <input type="hidden" id="height_19" value="5">
                                Grade
                                <br>
                                <table style="width:100%">
                                    <tr>
                                        <td colspan=3> <label></label><br> </td>
                                    </tr>
                                    <tr>
                                        <td><label><input type="radio" name="cel_tab_19" value="110n" id="110" checked></label></td>
                                        <td><label><input type="radio" name="cel_tab_19" value="111n" id="111"></label></td>
                                        <td><label><input type="radio" name="cel_tab_19" value="112n" id="112"></label></td>
                                    </tr>
                                    <tr>
                                        <td><label><input type="radio" name="cel_tab_19" value="120n" id="120"></label></td>
                                        <td><label><input type="radio" name="cel_tab_19" value="121n" id="121"></label></td>
                                        <td><label><input type="radio" name="cel_tab_19" value="122n" id="122"></label></td>
                                    </tr>
                                    <tr>
                                        <td colspan=2><label><input type="radio" name="cel_tab_19" value="130h" id="130"></label></td>
                                        <td><label><input type="radio" name="cel_tab_19" value="132n" id="132"></label></td>
                                    </tr>
                                    <tr>
                                        <td><label><input type="radio" name="cel_tab_19" value="140n" id="140"></label></td>
                                        <td><label><input type="radio" name="cel_tab_19" value="141n" id="141"></label></td>
                                        <td><label><input type="radio" name="cel_tab_19" value="142n" id="142"></label></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="row pl-2 pr-2" id='container_tabela_20' style="display:none">
                            <div class="col-3 text-center">
                                <input type="hidden" id="width_20" value="3">
                                <input type="hidden" id="height_20" value="5">
                                Grade
                                <br>
                                <table style="width:100%">
                                    <tr>
                                        <td colspan=3> <label></label><br> </td>
                                    </tr>
                                    <tr>
                                        <td><label><input type="radio" name="cel_tab_20" value="110n" id="110" checked></label></td>
                                        <td><label><input type="radio" name="cel_tab_20" value="111n" id="111"></label></td>
                                        <td><label><input type="radio" name="cel_tab_20" value="112n" id="112"></label></td>
                                    </tr>
                                    <tr>
                                        <td><label><input type="radio" name="cel_tab_20" value="120n" id="120"></label></td>
                                        <td><label><input type="radio" name="cel_tab_20" value="121n" id="121"></label></td>
                                        <td><label><input type="radio" name="cel_tab_20" value="122n" id="122"></label></td>
                                    </tr>
                                    <tr>
                                        <td><label><input type="radio" name="cel_tab_20" value="130n" id="130"></label></td>
                                        <td><label><input type="radio" name="cel_tab_20" value="131n" id="131"></label></td>
                                        <td><label><input type="radio" name="cel_tab_20" value="132n" id="132"></label></td>
                                    </tr>
                                    <tr>
                                        <td><label><input type="radio" name="cel_tab_20" value="140n" id="140"></label></td>
                                        <td><label><input type="radio" name="cel_tab_20" value="141n" id="141"></label></td>
                                        <td><label><input type="radio" name="cel_tab_20" value="142n" id="142"></label></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row pl-2 pr-2" id='container_tabela_23' style="display:none">
                            <div class="col-3 text-center">
                                <input type="hidden" id="width_23" value="3">
                                <input type="hidden" id="height_23" value="3">
                                Grade
                                <br>
                                <table style="width:100%">
                                    <tr>
                                        <td colspan=3> <label></label><br> </td>
                                    </tr>
                                    <tr>
                                        <td><label><input type="radio" name="cel_tab_23" value="110n" id="110" checked></label></td>
                                        <td><label><input type="radio" name="cel_tab_23" value="111n" id="111"></label></td>
                                        <td><label><input type="radio" name="cel_tab_23" value="112n" id="112"></label></td>
                                    </tr>
                                    <tr>
                                        <td><label><input type="radio" name="cel_tab_23" value="120n" id="120"></label></td>
                                        <td><label><input type="radio" name="cel_tab_23" value="121n" id="121"></label></td>
                                        <td><label><input type="radio" name="cel_tab_23" value="122n" id="122"></label></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="row pl-2 pr-2 pt-3 pb-3">
                            <div class="col-sm">
                                <input type="button" value="GERAR CARTAZ" class='btn btn-dark' onclick="gerarPDF()" id='bt-pdf'>
                                <input type="button" value="BAIXAR IMAGEM" class='btn' onclick="baixarImagem()">
                                <?php if($cliente->token && $cliente->sessao){ ?>
                                <button type="button" class="btn btn-success d-inline-flex align-items-center" onclick="buscaContatos()">
                                <svg xmlns="http://www.w3.org/2000/svg" height="1.2em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:#ffffff}</style><path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/></svg>
                                &nbsp;Enviar Cartaz
                                </button>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class='col-sm mb-2 h-100' style="background-color:#eeeeee;">
            <div class='h-100'>
                <div class='row'>
                    <div class='col'>
                        <h5 class="text-muted pl-3 pt-3">Visualização</h5>
                    </div>
                    <div class="col pt-3">
                        <div class="form-check ml-2 check_verpaisagem text-right" style="z-index:997">
                            <input type="checkbox" class="form-check-input" id="horizontal">
                            <label class="form-check-label" for="horizontal">Ver em modo paisagem</label>
                        </div>
                    </div>
                </div>
                <hr class='m-2'>
                <div class="row">
                    <div class="col">
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

    <!-- MODAL ADICIONAR PRODUTO -->
    <div class="modal fade" id="modalProduto" tabindex="-1" role="dialog" aria-labelledby="modalProdutoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalProdutoLabel">Adicionar Produto</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="modal-produto" method="post">
                        <div class="form-row">
                            <div class="col-sm">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Descrição</span>
                                    </div>
                                    <input type="text" class="form-control" id="modal_descricao" name="modal_descricao" type="text" class="form-control" value="" required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">NCM</span>
                                    </div>
                                    <input type="text" class="form-control" id="modal_ncm" name="modal_ncm" type="text" class="form-control" value="">
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-sm-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">SKU</span>
                                    </div>
                                    <input type="text" class="form-control" id="modal_sku" name="modal_sku" type="text" class="form-control" value="">
                                </div>
                            </div>

                            <div class="col-sm">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Preço</span>
                                    </div>
                                    <input type="text" class="form-control money" id="modal_preco" name="modal_preco" type="text" class="form-control" value="" pattern="[0-9]*" required>
                                </div>
                            </div>

                            <div class="col-sm">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Preço Promocional</span>
                                    </div>
                                    <input type="text" class="form-control money" id="modal_preco_promocional" name="modal_preco_promocional" type="text" class="form-control" value="" pattern="[0-9]*">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Fechar</button>
                    <button class="btn btn-success" type="button" onclick="$('#modal-produto').submit()">Salvar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL CONTATOS -->
    <div class="modal fade" id="modalContatos" tabindex="-1" role="dialog" aria-labelledby="modalContatosLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="modalContatosLabel">Envio de Cartaz via Whatsapp</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-end mb-3">
                        <div class="col-auto">Mín.:</div>
                        <div class="col-2"> <input type="number" class="w-100" name="min-leads" id="min-leads" value="2"> </div>
                        <div class="col-auto">Máx.:</div>
                        <div class="col-2"> <input type="number" class="w-100" name="max-leads" id="max-leads" value="31"> </div>
                    </div>
                    <div>
                        <textarea class="form-control" id="mensagem" cols="30" rows="4" placeholder="(opcional) Digite aqui a mensagem que deseja enviar junto com a imagem"></textarea>
                    </div>
                    <div class="mt-3" id="texto-contatos" style="height:300px;overflow-y:auto"></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <button class="btn btn-success" type="button" onclick="fazEnvio()">Enviar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL INTEGRAÇÃO -->
    <div class="modal fade" id="modalIntegracao" tabindex="-1" role="dialog" aria-labelledby="modalIntegracaoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalIntegracaoLabel">Faça sua integração</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <button class="btn btn-success" type="button" onclick="">Enviar</button>
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

    <!-- TODOS OS CANVAS QUE SERVEM PARA GERAR O RESULTADO FINAL. ELES DEVEM SEMPRE POSSUIR O TAMANHO DO MAIOR TEMPLATE -->
    <div id='container_cartaz' style='display:none;'>
        <canvas id='cartaz' width='1122.66' height='1587.6'></canvas>
        <!-- <canvas id='cartaz' width='2245.32' height='3178.98'></canvas> -->
    </div>
    <div id='container_cartaz_a2' style='display:none;'>
        <canvas id='cartaz_a2' width='1587.6' height='2245.32'></canvas>
    </div>
    <div id='container_hidden' style='display:none;'>
        
    </div>
    
    <div id='container_cartaz1' style='display:none;'></div>
    <div id='container_cartaz2' style='display:none;'></div>
    <div id='container_cartaz3' style='display:none;'></div>
    <div id='container_cartaz4' style='display:none;'></div>
    <div id='container_cartaz5' style='display:none;'></div>
    <div id='container_cartaz6' style='display:none;'></div>
    <div id='container_cartaz7' style='display:none;'></div>
    <div id='container_cartaz8' style='display:none;'></div>
    <div id='container_cartaz9' style='display:none;'></div>
    <div id='container_cartaz10' style='display:none;'></div>

    <div id='container_avisoh' style='display:none;'>
        <canvas id='avisoh' width='1587.6' height='1122.66'></canvas>
        <!-- <canvas id='avisoh' width='3178.98' height='2245.32'></canvas> -->
    </div>
    <div id='container_avisoh1' style='display:none;'></div>
    <div id='container_avisoh2' style='display:none;'></div>
    <div id='container_avisoh3' style='display:none;'></div>
    <div id='container_avisoh4' style='display:none;'></div>

    <div id='container_avisor' style='display:none;'>
        <canvas id='avisor' width='1122.66' height='1587.6'></canvas>
        <!-- <canvas id='avisor' width='2245.32' height='3178.98'></canvas> -->
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

<div id="loader-contatos" class="position-fixed h-100 w-100 top-0 left-0" style="background-color:rgba(0,0,0,.8);z-index:1002;display:none">
    <div class="h-100 w-100 d-flex align-items-center justify-content-center">
        <div class="text-center">
            <img src="<?= base_url("assets/images/loader.gif") ?>" alt="Loader" style="width:150px">

            <br><br>

            <div class="text-center text-white" id="msg-loader-contatos"></div>
        </div>
    </div>
</div>

<script>
    function fazEnvio(){
        // var contatos = []

        // $("[name=checkcontato]:checked").each((index, item) => {
        //     contatos.push("55"+item.value);
        // });
        var listas = []

        $("[name=checkcontato]:checked").each((index, item) => {
            listas.push(item.value);
        });

        if(listas.length > 0){
            $("#modalContatos").modal("hide");
            $("#msg-loader-contatos").html(`Disparando mensagem. <span style="cursor:pointer" onclick="$('#loader-contatos').hide()">Clique aqui</span> para continuar o envio em segundo plano, mas você não pode sair desta tela.`);
            $("#loader-contatos").show();
            $.ajax({
                url: '<?= base_url("index.php/integracao/enviarCartaz") ?>',
                type: 'POST',
                data: {
                    mensagem: $('#mensagem').val(),
                    telefones: listas,
                    imagem: $("#imgfinal").prop("src"),
                    min: $('#min-leads').val(),
                    max: $('#max-leads').val()
                },
                success: function(response) {
                    json = JSON.parse(response)
                    $("#loader-contatos").hide();
                    if(json.status){
                        alert("Solicitações enviadas com sucesso.");    
                    } else {
                        alert("Algo deu errado. Tente novamente mais tarde.");
                    }
                },
                error: function(error) {
                    alert("Erro ao tentar solicitar envio");
                    $("#loader-contatos").hide();
                }
            });

        }
    }

    function verificaStatus(){
        $("#msg-loader-contatos").html("Estamos verificando seus dados de integração");
        $("#loader-contatos").show();
        $.get("<?= base_url("index.php/integracao/verDadosIntegracao") ?>", function(json){
            if(json){
                json = JSON.parse(json);
                if(json.status){
                    $("#msg-loader-contatos").html("Estamos buscando seus contatos");
                    buscaContatos();
                } else {
                    $("#texto-contatos").html(json.msg);    
                    $("#loader-contatos").hide();
                    $("#modalContatos").modal("show");
                }
            } else {
                $("#texto-contatos").html("Não foi possível verificar os dados de sua integração com whatsapp");
                $("#loader-contatos").hide();
                $("#modalContatos").modal("show");
            }
        });
    }

    function buscaContatos(){
        $.get("<?= base_url("index.php/meuscontatos/buscaGruposContatos") ?>", function(json){
            if(json){
                json = JSON.parse(json);

                var tabela = `
                    <table>
                        <thead>
                            <th class="text-center" style="width:30px"><input type="checkbox" checked onchange="$('[name=checkcontato]').prop('checked', this.checked)"></th>
                            <th>Marque aqui para selecionar todas as listas de contato</th>
                        </thead>
                        <body>
                `;

                json.forEach((item) => {
                    tabela += `<tr>
                    <td><input type="checkbox" name="checkcontato" value="${item.grupo}" checked></td>
                    <td class="text-left pl-3">${item.grupo}</td>
                    </tr>`;
                });

                tabela += `
                        </body>
                    </table>
                `;

                $("#texto-contatos").html(tabela);
            } else {
                $("#texto-contatos").html("Você não tem contatos cadastrados. <a href='<?= base_url("meuscontatos") ?>'>Clique aqui</a> para começar a cadastrar");
            }

            $("#loader-contatos").hide();
            $("#modalContatos").modal("show");
        });
    }
</script>

<script>
    var id_produto_alteracao = false;

    $("#modal-produto").on("submit", function(e){
        e.preventDefault();
        if(!$("#modal_descricao").val()){
            alert("A descrição não pode ser vazia.");
            return;
        }
        if(!$("#modal_preco").val()){
            alert("O preço não pode ser vazio.");
            return;
        }

        var datastring = $(this).serialize();

        $.ajax({
            type: "POST",
            url: "<?= base_url("index.php/dashboard/cadprod") ?>",
            data: datastring,
            dataType: "json",
            success: function(data) {
                todosprodutos.push({"id":data.id,"descricao":data.descricao,"preco":data.preco,"preco_promocional":data.preco_promocional});
                
                escolheAuto(data.id, data.descricao+' <|> '+data.preco+' <|> '+data.preco_promocional);

                $('#modalProduto').modal('hide');
                $("#container_incluir_produto").hide();
            },
            error: function(error) {
                alert('Desculpe. Alguma coisa não executou como o esperado. Tente novamente mais tarde!');
                $('#modalProduto').modal('hide');
            }
        });
    });

    function salvaAutomatico(){
        if(!id_produto_alteracao){
            return;
        }

        var datastring = {
            id_produto: id_produto_alteracao,
            linha1: descproduto[0][0],
            linha2: descproduto[1][0],
            linha3: descproduto[2][0],
            preco: $("#precoant").val(),
            preco_promocional: $("#preco").val()
        }

        $.ajax({
            type: "POST",
            url: "<?= base_url("index.php/dashboard/salvaAlteracao") ?>",
            data: datastring,
            dataType: "json",
            success: function(html) {
                console.log(html.status);

                if(html.status == "erro"){
                    console.log(html.msg);
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    }

    function criaDesc(array){
        var saida = "";
        array.forEach((item, i) => {
            if(i != 0){
                saida += " ";
            }
            saida += item[0];
        });
        return saida;
    }

    function addProduto(){
        $("#modal_descricao").val(criaDesc(extraiNomeCor(Editor_master.getData())));
        $("#modal_preco").val($("#precoant").val());
        $("#modal_preco_promocional").val($("#preco").val());

        $('#modalProduto').modal('show');
    }

    function mudaAba(num){
        $('.aba').removeClass('bg-white');
        $('.aba').removeClass('text-dark');
        $('.aba').addClass('bg-dark');
        $('.aba').addClass('text-white');
        
        $('#aba'+num).addClass('bg-white');
        $('#aba'+num).addClass('text-dark');
        
        $('.aba1').hide();
        $('.aba2').hide();
        $('.aba3').hide();
        $('.aba'+num).show();

        $('.aba').css('border-radius','0px');

        if(num == 1){
            $('#aba2').css('border-bottom-left-radius','10px');
        } else if(num == 2){
            $('#aba1').css('border-bottom-right-radius','10px');
            $('#aba3').css('border-bottom-left-radius','10px');
        } else {
            $('#aba2').css('border-bottom-right-radius','10px');
        }
    }
</script>
<script>
    var todosprodutos = <?= $produtos ? (is_array($produtos) ? json_encode($produtos) : $produtos) : "[]" ?>;
    var descproduto = [["Produto", "#000000"],["", "#000000"],["", "#000000"]];
    var Editor_master = null;

    function filtrarLista(nome){
        if(nome){
            const result = todosprodutos.filter(function(item){
                return item.descricao.toUpperCase().normalize("NFD").replace(/[\u0300-\u036f]/g, '').indexOf(nome.toUpperCase().normalize("NFD").replace(/[\u0300-\u036f]/g, '')) != -1;
            });

            $("#auto-list").html('');

            if(result.length > 0){
                $("#container_incluir_produto").hide();
                result.forEach((item) => {
                    $("#auto-list").append(
                        `<li onclick="escolheAuto(
                            '${item.id}', 
                            '${item.descricao} <|> ${item.preco} <|> ${item.preco_promocional}', 
                            ['${item.linha1 ? item.linha1 : false}', '${item.linha2 ? ""+item.linha2 : false}', '${item.linha3 ? ""+item.linha3 : false}']
                        )">
                            ${item.descricao+' - de '+item.preco+(item.preco_promocional && parseFloat(item.preco_promocional) != 0 && item.preco != item.preco_promocional ? ' por '+item.preco_promocional : "")}
                        </li>`
                    );
                });
                if(Editor_master.editing.view.document.isFocused){
                    $("#auto-list").show();
                }
            } else {
                $("#auto-list").hide();

                <?php
                if(!$cliente->planilha){
                ?>
                if(extraiNomeCor(Editor_master.getData())[0][0] != "Produto"){
                    $("#container_incluir_produto").show('fast');
                }
                <?php
                }
                ?>
            }
        } else {
            $("#container_incluir_produto").hide();
        }
    }

    function separaTexto(texto){
        texto = texto.split(" ");

        var linha1 = texto[0];
        var linha2 = "";
        var linha3 = "";

        var contador = 1;

        if(linha1.length <= 11){
        
            while (linha1.length <= 11 && contador < texto.length){

                if((linha1+" "+texto[contador]).length > 11){
                    break;
                } else {
                    linha1 = linha1+" "+texto[contador];
                }

                contador++;
            
            }

        }

        while (linha2.length <= 12 && contador < texto.length){

            if(linha2 == ""){
                linha2 = linha2+" "+texto[contador];
            } else {
                if((linha2+" "+texto[contador]).length > 12){
                    break;
                } else {
                    linha2 = linha2+" "+texto[contador];
                }
            }

            contador++;

        }

        while (contador < texto.length){

            linha3 = linha3+" "+texto[contador];

            contador++;

        }

        return [linha1, linha2, linha3];
    }

    function escolheAuto(id, desc, sep_linhas=false){
        id_produto_alteracao = id;
        var descricoes = desc.split(" <|> ");
        var linhas = separaTexto(descricoes[0]);
Editor_master
        if(sep_linhas && sep_linhas.length == 3 && (sep_linhas[0] != "false" || sep_linhas[1] != "false" || sep_linhas[2] != "false")){
            console.log(sep_linhas);
            
            Editor_master.setData('<p>'+(sep_linhas[0] != "false" ? sep_linhas[0] : "")+'</p><p>'+(sep_linhas[1] != "false" ? sep_linhas[1] : "")+'</p><p>'+(sep_linhas[2] != "false" ? sep_linhas[2] : "")+'</p>');
        
        } else {

            if(linhas[0] && linhas[1] && linhas[2]){
                Editor_master.setData('<p>'+linhas[0]+'</p><p>'+linhas[1]+'</p><p>'+linhas[2]+'</p>');
            } else if(linhas[0] && linhas[1]){
                Editor_master.setData('<p>'+linhas[0]+'</p><p>'+linhas[1]+'</p>');
            } else if(linhas[0]){
                Editor_master.setData('<p>'+linhas[0]+'</p>');
            }

        }

        if(parseFloat(descricoes[1]) == 0){
            $("#preco").val(descricoes[2].replace(".",","));
            $("#precoant").val("");    
        } else if(parseFloat(descricoes[2]) == 0){
            $("#preco").val(descricoes[1].replace(".",","));    
            $("#precoant").val("");    
        } else if(parseFloat(descricoes[1]) == parseFloat(descricoes[2])){
            $("#preco").val(descricoes[1].replace(".",","));    
            $("#precoant").val("");    
        } else {
            $("#preco").val(descricoes[2].replace(".",","));
            $("#precoant").val(descricoes[1].replace(".",","));
        }
        
        $("#auto-list").hide();
        descproduto = extraiNomeCor(Editor_master.getData());
        setTimeout(() => {
            criaCartaz();
        }, 10);
    }

    ClassicEditor.create( document.querySelector( '#editor' ))
    .then(editor => {
        Editor_master = editor;
        editor.editing.view.document.on('keyup', ( ) => {
            if((editor.getData().match(/<p>/g) || []).length > 3){
                $(".ck-toolbar__items")[0].children[0].click();
            }
            var saida = extraiNomeCor(editor.getData());
            filtrarLista(saida.length > 0 ? saida[0][0].replace("&nbsp;"," ") : false);
            // extraiNomeCor(editor.getData());
        });

        editor.editing.view.document.on('blur', ( ) => {
            descproduto = extraiNomeCor(editor.getData());
            setTimeout(() => {
                $("#auto-list").hide();
                salvaAutomatico();
                criaCartaz();
            }, 150);
        });
    })
    .catch( error => {
        console.error( error );
    } );

    function extraiNomeCor(texto){
        texto = texto.split("</p>");

        if(texto.length == 1 && texto[0] == ""){
            return [["Produto", "#000000"],["", "#000000"],["", "#000000"]];
        }
        var saida = []

        texto.forEach((item) => {
            item = item.replace("<p>","");
            item = item.replace("<p data-placeholder=\"Descrição do Produto\">","");

            if(item.indexOf("<span") != -1){
                var cor = item.split(";\">");
                
                item = [cor[1].replace("</span>", ""), "#000000"]

                cor = cor[0].replace("<span style=\"color:", "");

                item[1] = cor;

            } else {
                item = [item.replace("<p>",""), "#000000"]
            }

            saida.push(item);
        });

        saida.pop();

        while(saida.length < 3){
            saida.push(["", "#000000"]);
        }

        return saida;
    }
</script>
