<?php $this->load->view("dashboard/criar/style"); ?>
<style>
    .card-plano {
        border-radius: 8px;
        background-color: #FFF;
        padding: 10px;
        border: 1px solid #cecece;
        box-shadow: 0px 0px 5px #cecece;
        width: 100%;
    }

    .aba-fila {
        padding: 10px;
        background-color: #cecece;
        width: 100%;
        cursor: pointer;
    }

    .aba-fila-ativa {
        background-color: white;
    }
</style>
<div class="col-2" id="comptela"></div>
<div class='col-sm pl-0 pr-md-2 pr-0 h-100' id="tela">
    <div class='card m-3'>
        <div class='row p-3'>
            <div class='col-sm-4 p-2'>
                <div class="row">
                    <div class="col">
                        Selecione uma Fila de Impressão
                        <br>
                        <select id="fila" class="form-control">
                            <option disabled selected value="">Selecione...</option>
                        </select>
                    </div>
                    <div class="col-auto">
                        <br>
                        <input type="button" value="IR" class="btn btn-primary">
                    </div>
                </div>
            </div>
            <div class='col-sm-2 p-2'>
                <br>
                <h1 class="text-center">OU</h1>
            </div>
            <div class='col-sm-6 p-2'>
                <div class="row">
                    <div class="col">
                        Adicione um arquivo .csv
                        <br>
                        <input type="file" id="arquivo" class="form-control" accept=".csv">
                    </div>
                    <div class="col-auto">
                        <br>
                        <input type="button" value="IR" class="btn btn-primary" onclick="lerArquivo()">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card m-3">
        <div class="row">
            <div class="col pt-2 pb-2 pr-4 text-right">
                <input type="button" value="GERAR PDF" class="btn btn-success">
            </div>
        </div>
        <div class="row no-gutters" id="dados">

        </div>
    </div>
</div>

<div style="display:none">
    <input type="hidden" id="preco">
    <input type="hidden" id="precoant">
    <input type="hidden" id="tamanho_fonte">
    <input type="hidden" id="unidade">
    <input type="hidden" id="rodape">
    <input type="hidden" id="produtol1">
    <input type="hidden" id="produtol2">
    <input type="hidden" id="produtol3">
    <input type="hidden" id="codigo">
    <input type="hidden" id="src_template">
    <input type="checkbox" name="quadrante" id="quadrante" value="1" checked>
    <input type="checkbox" name="incluirlogo" id="incluirlogo" value="1" checked>
    <input type="hidden" id="fonte">
    <input type="hidden" id="layout">
    <input type="hidden" id="cor_preco">
    <input type="hidden" id="cor_preco_anterior">
    <select name="tamanho" id="tamanho" class='form-control'>
        <option value="" id="" selected></option>
    </select>
    <input type="hidden" id="A3" value="2<|>297 x 420">

    <div id="container_cartaz"></div>
    <canvas id='cartaz' width='1122.66' height='1587.6'></canvas>
    <canvas id='cartaz_a2' width='1587.6' height='2245.32'></canvas>
</div>

<script>
    var objeto = {}

    function mudaAba(num, massa = false, quantidade = 0, i = 0) {
        $(".aba-fila").removeClass("aba-fila-ativa");
        $("#aba-fila-" + num).addClass("aba-fila-ativa");

        $.get('<?php echo base_url('index.php/dashboard/buscaTemplate/') ?>' + document.getElementById("template" + num).value, function(html) {
            $('#A3').val().split('<|>');
            $("#layout").val(document.getElementById("layout" + num).value);
            $("#src_template").val(html);
            $('#tamanho').children(":selected").attr('id', 'A4');
            $("#fonte").val(document.getElementById("fonte" + num).value);
            $("#tamanho_fonte").val(document.getElementById("tamanho_fonte" + num).value);

            $("#produtol1").val(document.getElementById("linha1" + num).value);
            $("#produtol2").val(document.getElementById("linha2" + num).value);
            $("#produtol3").val(document.getElementById("linha3" + num).value);
            $("#codigo").val(document.getElementById("codigo" + num).value);
            $("#rodape").val(document.getElementById("rodape" + num).value);

            $("#preco").val(document.getElementById("preco" + num).value);
            $("#cor_preco").val(document.getElementById("cor_preco" + num).value);
            $("#precoant").val(document.getElementById("preco_anterior" + num).value);
            $("#cor_preco_anterior").val(document.getElementById("cor_preco_anterior" + num).value);
            $("#unidade").val(document.getElementById("unidade" + num).value);
            
            $("#visual").val(document.getElementById("visual" + num).value);

            criaCartaz(num);
        });
    }

    function lerArquivo() {
        $(document).ready(function() {
            $.ajax({
                type: "GET",
                url: URL.createObjectURL(document.getElementById("arquivo").files[0]),
                dataType: "text",
                success: function(data) {
                    processaArquivo(data.split("\n"));
                }
            });
        });
    }

    function processaArquivo(data) {
        var keys = data.shift().split(";");
        data.pop();
        if (keys[keys.length] == "fim_texto") {
            keys.pop();
        }

        keys.forEach((key) => {
            objeto[key] = []
        });

        data.forEach((item) => {
            item = item.split(";");

            item.forEach((coluna, index) => {
                objeto[keys[index]].push(coluna);
            });
        });

        objeto.layout.forEach((item, index) => {
            $("#dados").append(
                '<div class="col-sm-6">\
                <div class="aba-fila' + (index == 0 ? " aba-fila-ativa" : "") + '" id="aba-fila-' + (index) + '" onclick="mudaAba(' + (index) + ')">\
                <div class="form-row" id="header-aba-fila-' + index + '">\
                <div class="form-group col-12">\
                <h6>Cartaz ' + (index+1) + '</h6>\
                </div>\
                </div>\
                <div class="form-row" id="pre-aba-fila-' + index + '">\
                    <div class="form-group col-12">\
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal' + (index) + '">\
                    Editar cartaz\
                    </button>\
                    <div class="modal fade" id="exampleModal' + (index) + '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">\
                    <div class="modal-dialog" role="document">\
                        <div class="modal-content">\
                        <div class="modal-header">\
                            <h5 class="modal-title" id="exampleModalLabel">Editar cartaz</h5>\
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">\
                            <span aria-hidden="true">&times;</span>\
                            </button>\
                        </div>\
                        <div class="modal-body">\
                        <div class="form-row" id="lay-aba-fila-' + index + '" style="display:none;">\
                    <div class="form-group col-md-4">\
                    <label for="layout">Layout</label>\
                    <select name="layout" id="layout' + (index) + '" class="form-control" onchange="mudaAba(' + (index) + ');">\
                    <option value="' + objeto.layout[index] + '" selected hidden>Sem Imagem</option>\
                                    <optgroup label="Layouts Verticais">\
                                        <option value="1">Sem Imagem</option>\
                                        <option value="13">Sem Imagem 2</option>\
                                        <option value="2">Com Imagem</option>\
                                        <option value="3">Cartão da Loja</option>\
                                        <option value="4">Clube Fidelidade</option>\
                                        <option value="15">2 Preços - Sem Imagem</option>\
                                        <option value="7">Banner Bolsão A2</option>\
                                        <option value="8">Atacado</option>\
                                        <option value="9">Com Imagem 2</option>\
                                        <option value="12">2 Preços - Sem Imagem 2</option>\
                                    </optgroup>\
                                    <optgroup label="Layouts Horizontais">\
                                        <option value="5">Layout Horizontal - Com imagem</option>\
                                        <option value="6">Faixas para Gôndolas</option>\
                                        <option value="10">Atacado e Varejo - Sem imagem</option>\
                                        <option value="11">Varejo - Sem imagem</option>\
                                        <option value="14">Bolsão A1 - Com imagem</option>\
                                        <option value="16">2 preços Horizontal sem imagem 8x20</option>\
                                        <option value="17">1 preço Horizontal sem imagem 8x20</option>\
                                        <option value="25">1 Preço horizontal - Sem imagem 42x30</option>\
                                        <option value="21">Horizontal 17x12 sem imagem</option>\
                                        <option value="22">Horizontal 17x12 com imagem</option>\
                                    </optgroup>\
                                    <?php if ($this->clientes_model->getClientes($id)->tabloid == 1) { ?>\
                                    <optgroup label="Tabloides">\
                                        <!-- <option value="18">Tabloide 6 Produtos</option> -->\
                                        <option value="23">Horizontal 17x12 Tabloide</option>\
                                        <option value="19">Tabloide 11 Produtos</option>\
                                        <option value="20">Tabloide 12 Produtos</option>\
                                    </optgroup>\
                                    <?php } ?>\
                                </select>\
                            </div>\
                    <div class="form-group col-md-8">\
                    <label for="template">Template</label>\
                    <input type="text" class="form-control" id="template' + (index) + '" value="' + objeto.template[index] + '" onblur="mudaAba(' + (index) + ');">\
                    </div>\
                    <div class="form-group col-md-2">\
                    <label for="tamanho">Tamanho</label>\
                    <input type="text" class="form-control" id="tamanho' + (index) + '" value="' + objeto.tamanho[index] + '" onblur="mudaAba(' + (index) + ');">\
                    </div>\
                    <div class="form-group col-md-7">\
                    <label for="fonte">Fonte</label>\
                    <select name="fonte" id="fonte' + (index) + '" class="form-control" onchange="mudaAba(' + (index) + ');">\
                    <option value="' + objeto.fonte[index] + '" selected hidden>' + objeto.fonte[index] + '</option>\
                                    </select>\
                    </div>\
                    <div class="form-group col-md-3">\
                    <label for="tamanho_fonte">Tam. Fonte</label>\
                    <input type="text" class="form-control" id="tamanho_fonte' + (index) + '" value="' + objeto.fonte_tamanho[index] + '" onblur="mudaAba(' + (index) + ');">\
                    </div>\
                </div>\
                <div class="form-row" id="desc-aba-fila-' + index + '">\
                    <div class="form-group col-4">\
                    <label for="linha1">Produto</label>\
                    <input type="text" class="form-control" id="linha1' + (index) + '" value="' + objeto.linha1[index] + '" onblur="mudaAba(' + (index) + ');">\
                    </div>\
                    <div class="form-group col-4">\
                    <label for="linha2">&nbsp;</label>\
                    <input type="text" class="form-control" id="linha2' + (index) + '" value="' + objeto.linha2[index] + '" onblur="mudaAba(' + (index) + ');">\
                    </div>\
                    <div class="form-group col-4">\
                    <label for="linha3">&nbsp;</label>\
                    <input type="text" class="form-control" id="linha3' + (index) + '" value="' + objeto.linha3[index] + '" onblur="mudaAba(' + (index) + ');">\
                    </div>\
                    <div class="form-group col-12" style="display:none;">\
                    <label for="rodape">Rodapé</label>\
                    <input type="text" class="form-control" id="rodape' + (index) + '" value="' + objeto.rodape[index] + '" onblur="mudaAba(' + (index) + ');">\
                    </div>\
                </div>\
                        <div class="form-row">\
                        <div class="form-group col-md-4">\
                    <label for="codigo">Código</label>\
                    <input type="text" class="form-control" id="codigo' + (index) + '" value="' + objeto.codigo[index] + '" onblur="mudaAba(' + (index) + ');">\
                    </div>\
                    <div class="form-group col-md-3">\
                    <label for="preco_anterior">Preço anterior</label>\
                    <input type="text" class="form-control" id="preco_anterior' + (index) + '" value="' + objeto.preco_anterior[index] + '" onblur="mudaAba(' + (index) + ');">\
                    </div>\
                    <div class="form-group col-md-3">\
                    <label for="preco">Preço</label>\
                    <input type="text" class="form-control" id="preco' + (index) + '" value="' + objeto.preco[index] + '" onblur="mudaAba(' + (index) + ');">\
                    </div>\
                    <div class="form-group col-md-2">\
                    <label for="unidade">Unidade</label>\
                    <input type="text" class="form-control" id="unidade' + (index) + '" value="' + objeto.unidade[index] + '" onblur="mudaAba(' + (index) + ');">\
                    </div>\
                    <div class="form-group col-12">\
                    <div class="form-check form-check-inline">\
                    <input class="form-check-input" type="checkbox" id="manter' + (index) + '" value="1" checked>\
                    <label class="form-check-label" for="incluir-list">Manter na fila</label>\
                    </div>\
                    </div>\
                    </div>\
                        </div>\
                        <div class="modal-footer">\
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Salvar e fechar</button>\
                        </div>\
                        </div>\
                    </div>\
                    </div>\
                    </div>\
                    <div class="form-group col-md-6" style="display:none;">\
                    <label for="cor_preco">Cor Preço</label>\
                    <input type="text" class="form-control" id="cor_preco' + (index) + '" value="' + objeto.cor_preco[index] + '" onblur="mudaAba(' + (index) + ');">\
                    </div>\
                    <div class="form-group col-md-6" style="display:none;">\
                    <label for="cor_preco_anterior">Cor Preço anterior</label>\
                    <input type="text" class="form-control" id="cor_preco_anterior' + (index) + '" value="' + objeto.cor_preco_anterior[index] + '" onblur="mudaAba(' + (index) + ');">\
                    </div>\
                </div>\
                </div>\
                </div>\
                <div class="col-sm-6" id="visual' + (index) + '">\
                <div id="ver_img" class="pt-2 text-center w-50">\
                </div>\
            </div>'
            );
        });
        mudaAba(0);
    }

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
</script>

<?php $this->load->view("dashboard/criar/criarcartaz"); ?>
<?php $this->load->view("dashboard/criar/continuarcartaz"); ?>
<?php $this->load->view("dashboard/criar/layout1"); ?>
<?php $this->load->view("dashboard/criar/layout2"); ?>
<?php $this->load->view("dashboard/criar/layout3"); ?>
<?php $this->load->view("dashboard/criar/layout4"); ?>
<?php $this->load->view("dashboard/criar/layout5"); ?>
<?php $this->load->view("dashboard/criar/layout6"); ?>
<?php $this->load->view("dashboard/criar/layout7"); ?>
<?php $this->load->view("dashboard/criar/layout8"); ?>
<?php $this->load->view("dashboard/criar/layout9"); ?>
<?php $this->load->view("dashboard/criar/layout10"); ?>
<?php $this->load->view("dashboard/criar/layout11"); ?>
<?php $this->load->view("dashboard/criar/layout12"); ?>
<?php $this->load->view("dashboard/criar/layout13"); ?>
<?php $this->load->view("dashboard/criar/layout14"); ?>