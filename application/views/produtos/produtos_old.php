<div class="col-2" id="comptela"></div>
<div class='col' id="tela">
    <h1 class="header" style='padding:10px;'>Produtos <small class="text-muted">Gerenciamento de produtos</small> <a href="<?php echo base_url('index.php/produtos/cadastro'); ?>" class="btn btn-success btn-sm text-white"> + </a> </h1>
    <hr>
    <form method="post" class="row" enctype="multipart/form-data">
        <div class="col-sm text-center mt-2 mb-2">
            Cadastre também produtos em massa. <a href="#" onclick="$('#baixamodelo').modal('show')">Clique aqui</a> para baixar o arquivo modelo.
        </div>
        <div class="col-sm-4 mt-2 mb-2">
            <input type="file" name="arquivoxml" class="form-control" accept=".xml , .csv" required>
        </div>
        <div class="col-sm-1 mt-2 mb-2">
            <input type="submit" value="OK" class="btn btn-success col">
        </div>
        <div class="col-sm-4 border-left mt-2 mb-2 text-center">
            <input type="button" class="btn btn-success" value="CONTINUAR COM OS SELECIONADOS" onclick="continuarSelecionados()">
        </div>
    </form>
    <hr>
    <style>
        td {
            padding: 5px;
        }
    </style>
    <?php $this->load->view("dashboard/criar/style"); ?>
    <script>
        function toggleCheck(elemento){
            $(".check-produto").prop("checked", elemento.checked);
        }
    </script>
    <div class="card p-2">
        <div class="row">
            <div class="col-12">
                <table class="table-striped" id="tabela-produtos">
                    <thead class="thead-dark">
                        <tr>
                            <?php if(count($produtos) > 0) {?>        
                            <th style="padding:5px"><input type="checkbox" onclick="toggleCheck(this)"></th>
                            <th>Descricao</th>
                            <th>NCM</th>
                            <th>SKU</th>
                            <th>Preco</th>
                            <th>Preco Promocional</th>
                            <th></th>
                            <?php } else {echo "Não há produtos cadastrados.";}?>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($produtos as $produto) {?>
                        <tr>
                            <td><input type="checkbox" class="check-produto" name="produtos[]" value="<?=$produto->id."<|>".$produto->descricao."<|>".$produto->ncm."<|>".$produto->sku."<|>".$produto->preco."<|>".$produto->preco_promocional?>"></td>
                            <td><?=$produto->descricao?></td>
                            <td><?=$produto->ncm?></td>
                            <td><?=$produto->sku?></td>
                            <td><?=$produto->preco?></td>
                            <td><?=$produto->preco_promocional?></td>
                            <td class='text-right text-white'>
                                <a role="button" href="<?=base_url('index.php/produtos/cadastro/'.$produto->id)?>" class="m-1 btn btn-primary">Alterar</a>
                                <a role="button" class="m-1 btn btn-danger" onClick="deletarproduto('<?=$produto->id?>')" >Excluir</a>
                            </td>
                        </tr>
                    <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="baixamodelo" tabindex="-1" role="dialog" aria-labelledby="baixamodeloLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="baixamodeloLabel">Selecione o formato do arquivo</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <a class="btn btn-primary col m-2 text-white" href="<?= base_url('assets/produtos.xml') ?>" download onclick="$('#baixamodelo').modal('hide')">Formato XML</a>
                    <a class="btn btn-primary col m-2 text-white" href="<?= base_url('assets/produtos.csv') ?>" download onclick="$('#baixamodelo').modal('hide')">Formato CSV</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deletarproduto" tabindex="-1" role="dialog" aria-labelledby="deletarprodutoLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deletarprodutoLabel">Atenção!</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    Deseja realmente excluir este produto?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="confirmar-exclusao" type="button">Excluir</button>
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CÓDIGOS PARA A IMPRESSÃO EM MASSA -->
<div class="modal fade" id="modalLayout" tabindex="-1" role="dialog" aria-labelledby="modalLayoutLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLayoutLabel">Selecione os detalhes dos cartazes</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6">
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
                                        <option value="8">Atacado</option>
                                        <option value="9">Com Imagem 2</option>
                                        <option value="12">2 Preços - Sem Imagem 2</option>
                                    </optgroup>
                                    <optgroup label="Layouts Horizontais">
                                        <option value="5">Layout Horizontal - Com imagem</option>
                                        <option value="6">Faixas para Gôndolas</option>
                                        <option value="10">Atacado e Varejo - Sem imagem</option>
                                        <option value="11">Varejo - Sem imagem</option>
                                        <option value="14">Bolsão A1 - Com imagem</option>
                                        <option value="16">2 preços Horizontal sem imagem 8x20</option>
                                        <option value="17">1 preço Horizontal sem imagem 8x20</option>
                                        <option value="25">1 Preço horizontal - Sem imagem 42x30</option>
                                        <option value="21">Horizontal 17x12 sem imagem</option>
                                        <option value="22">Horizontal 17x12 com imagem</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Categoria</span>
                                </div>
                                <select name="tipo_template" id="tipo_template" class='form-control' onchange="buscaIds()">
                                    <?php
                                    foreach ($templates as $template) {
                                        echo "<option value='" . $template->id . "' id='" . $template->id . "' class='";
                                        foreach ($tipos as $tipo) {
                                            $arids = explode(", ", $tipo->tipos_ids);
                                            if (in_array($template->id, $arids)) {
                                                echo "categoria" . $tipo->layout . " ";
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

                    <div class="row">
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
                        <div class="col-sm" id="tamanho_comum">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Tamanho</span>
                                </div>
                                <select name="tamanho" id="tamanho" class='form-control'>
                                    <?php
                                    foreach ($tamanhos as $tamanho) {
                                        echo "<option value='" . $tamanho->fator . "<|>" . $tamanho->medidas . "' id='" . $tamanho->nome . "'>";
                                        echo $tamanho->nome . " | " . $tamanho->medidas;
                                        echo "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Fonte</span>
                                </div>
                                <select name="fonte" id="fonte" class='form-control'>
                                    <?php
                                    $path = 'assets/fonts/';
                                    $diretorio = dir($path);

                                    while ($arquivo = $diretorio->read()) {
                                        if ($arquivo != "." && $arquivo != "..") {
                                            echo "<option value='" . explode('.', $arquivo)[0] . "'>";
                                            echo explode('.', $arquivo)[0];
                                            echo "</option>";
                                        }
                                    }
                                    $diretorio->close();
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Cor Preço</span>
                                </div>
                                <input type="color" id="cor_preco" name="ArcoIris" list="arcoIris" value="#FF0000" class="form-control" style="height:38px" onchange="criaCartazFila()">
                                <datalist id="arcoIris">
                                    <option value="#FFFFFF">Branco</option>
                                    <option value="#000000">Preto</option>
                                    <option value="#FF0000">Vermelho</option>
                                </datalist>
                            </div>
                        </div>
                    </div>

                    <!-- MOSTRAR RESULTADO -->
                    <div class="row mt-2 mb-2">
                        <div class="col text-center align-middle">
                            <img src="<?= base_url("assets/images/left.png") ?>" id="img_left" width="50px" style="cursor:pointer" onclick="mudaimg(-1)">
                            <img src="" id="img_result" width="250px">
                            <img src="<?= base_url("assets/images/right.png") ?>" id="img_right" width="50px" style="cursor:pointer" onclick="mudaimg(1)">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col pt-2 pb-2 pr-4 text-right">
                        <input type="button" value="GERAR CARTAZ" class='btn btn-primary' onclick="$('#modalLayout').modal('hide');gerarPDFFila();" id='bt-pdf'>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div style="display:none">
    <input type="hidden" id="tamanho_fonte" value="100">
    <input type="checkbox" name="quadrante" id="quadrante" value="1" checked>
    <input type="checkbox" name="incluirlogo" id="incluirlogo" value="1" checked>
    <input type="hidden" id="A3" value="2<|>297 x 420">
    <input type="hidden" id="id_cartaz">
    <div id="container_cartaz"></div>
    <canvas id='cartaz' width='1122.66' height='1587.6'></canvas>
    <canvas id='cartaz_a2' width='1587.6' height='2245.32'></canvas>
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

<script>
    var dadosdafila = [];
    var vetor = [];
    var imgatual = 0;

    window.onload = function () {
        // buscaIds();
    }

    function mudaimg(num){
        if(imgatual + num >= 0 && imgatual + num < vetor.length){
            imgatual = imgatual + num;
            $("#img_result").attr("src", document.getElementById('cartaz'+vetor[imgatual]).toDataURL());
        }
    }

    function mostrarPrototipos(){
        var elementos = $("input[name=produtos\\[\\]]:checked");

        $.each(elementos, function(){            
            vetor.push($(this).val().split("<|>")[0]);
        });

        $("#img_result").attr("src", document.getElementById('cartaz'+vetor[0]).toDataURL());

        imgatual = 0;
        
        $("#modalLayout").modal("show");
    }

    function continuarSelecionados(){
        if($("input[name=produtos\\[\\]]:checked").length == 0){
            alert("Selecione pelo menos 1 produto");
        } else {
            criaCartazFila();
        }
    }

    function mudaCategorias(num) {
        // num = num == 13 ? 1 : (num == 21 || num == 22 ? 11 : num);
        num = num == 13 ? 1 : num;
        $('.categoria').hide();
        $('.categoria' + num).show();
        $(".categoria").removeAttr("selected");
        $(".categoria" + num + ":first").attr("selected", "selected");
        selecionaCores();
        // buscaIds();
        tamSelecionado();
        dados_faixa = {};
        dados_quadrante = {}
    }
</script>

<?php $this->load->view("dashboard/criar/script"); ?>

<script>
    function atualizaLista() {
        id_cartaz = $('.id_cartaz').length;
        for (var i = 0; i < id_cartaz+1; i++) {
            mudaAba(i);
            mudaAba(0);
        }
    }
</script>

<script>
    var objeto = {}

    // SCRIPTS FALTOSOS
    function carregarContextoCanvas(idCanvas) {
        var elemento = document.getElementById(idCanvas);
        if (elemento && elemento.getContext) {
            var contexto = elemento.getContext('2d');
            if (contexto) {
                return contexto;
            }
        }
        return false;
    }

    function isPrimeiro() {
        return false;
    }

    function liberaCampos() {
        //pass
    }

    function visuPaisagem() {
        // if($('#horizontal').prop('checked')){
        //     $('#imgfinal').css('transform','rotate(-90deg)');
        //     $('#imgfinal').css('box-shadow','-5px 5px 10px #444');
        // }
        // pass
    }

    dados_quadrante = []

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
</script>